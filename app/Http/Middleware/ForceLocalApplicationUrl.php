<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;

/**
 * APP_URL 로 고정하면 내부(192.168.x.x)·외부(공인 IP) 중 한쪽만 쓸 때 asset()/url() 이
 * 접속 불가인 호스트로 나가 CSS·이미지가 깨진다. 웹 요청마다 현재 요청의 루트로 맞춘다.
 * (CLI·큐는 AppServiceProvider 에서 APP_URL 을 강제하지 않으므로 config app.url 사용.)
 *
 * 서브경로 배포(/vrs)인데 프록시가 Laravel 에는 베이스 경로를 안 넘기면 request->root() 에
 * /vrs 가 없어 asset() 이 /img/... 로 나간다. APP_URL 의 path(예: /vrs)를 이 경우에만 덧붙인다.
 * 포트가 항상 80으로만 잡히면 nginx 등에서 Host 또는 X-Forwarded-Port 를 넘기고 TrustProxies 를 맞출 것.
 */
class ForceLocalApplicationUrl
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Prefer proxy-forwarded origin when available (keeps public port like :2000).
        $scheme = $request->getScheme();
        $xfProto = $request->headers->get('x-forwarded-proto');
        if (is_string($xfProto) && trim($xfProto) !== '') {
            $scheme = trim(explode(',', $xfProto)[0]);
        }

        $host = $request->getHttpHost();
        $xfHost = $request->headers->get('x-forwarded-host');
        if (is_string($xfHost) && trim($xfHost) !== '') {
            $host = trim(explode(',', $xfHost)[0]);
        } else {
            $xfPort = $request->headers->get('x-forwarded-port');
            if (is_string($xfPort) && trim($xfPort) !== '') {
                $port = (int) trim(explode(',', $xfPort)[0]);
                if ($port > 0 && strpos($host, ':') === false && ! in_array($port, [80, 443], true)) {
                    $host .= ':'.$port;
                }
            }
        }

        $root = rtrim($scheme.'://'.$host.$request->getBaseUrl(), '/');

        // Subpath deployment (/vrs) fallback when proxy/rewrite doesn't expose base URL to PHP.
        $appUrl = (string) config('app.url', '');
        $appHost = parse_url($appUrl, PHP_URL_HOST);
        $appPort = parse_url($appUrl, PHP_URL_PORT);
        $appPath = parse_url($appUrl, PHP_URL_PATH);

        // If proxy strips port from Host, recover it from APP_URL for that same host.
        if (is_string($appHost) && $appHost !== '' && is_int($appPort)) {
            $rootHost = parse_url($root, PHP_URL_HOST);
            $rootPort = parse_url($root, PHP_URL_PORT);
            if ($rootHost === $appHost && ($rootPort === null || in_array($rootPort, [80, 443], true))) {
                $root = preg_replace('/^(https?:\/\/[^\/:]+)(?=\/|$)/', '$1:'.$appPort, $root);
            }
        }

        if (is_string($appPath)) {
            $appPath = trim($appPath, '/');
            if ($appPath !== '') {
                $suffix = '/'.$appPath;
                if (! Str::endsWith($root, $suffix)) {
                    $root .= $suffix;
                }
            }
        }

        \URL::forceRootUrl($root);

        return $next($request);
    }
}
