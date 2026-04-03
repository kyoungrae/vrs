<?php

namespace App\Http\Middleware;

use Closure;

/**
 * 로컬에서 APP_URL 과 실제 브라우저 주소(localhost vs 127.0.0.1, 포트)가 다르면
 * asset()/url() 이 다른 호스트·포트로 나가 CSS·이미지가 로드되지 않는다.
 * 웹 요청마다 현재 요청의 루트(URL)로 맞춘다.
 */
class ForceLocalApplicationUrl
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (config('app.env') === 'local') {
            \URL::forceRootUrl($request->root());
        }

        return $next($request);
    }
}
