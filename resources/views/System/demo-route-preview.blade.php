@extends('System.layout-demo-menu')

@section('demo_content')
@php
    $routeLabel = '페이지';
    $path = ltrim(($requestedPath ?? '/'), '/');
    $map = [
        'vehicle' => '차량 정보',
        'search' => '차량 검색',
        'user' => '사용자 등록',
        'userlist' => '사용자 목록',
        'reference/service' => '서비스 기준정보',
        'reference/position' => '직책 기준정보',
        'reference/address' => '주소 기준정보',
        'report/total' => '전체 차량 리포트',
        'settings/department' => '부서 설정',
        'settings/archive' => '아카이브 지점 설정',
        'plate/print' => '번호판 인쇄',
        'mehanizm' => '기타 차량 번호 검색',
    ];
    foreach ($map as $key => $label) {
        if (strpos($path, $key) === 0) {
            $routeLabel = $label;
            break;
        }
    }
@endphp
<div class="demo-wrap-shell">
    <h1 class="demo-title">{{ $routeLabel }} (데모 모드)</h1>
    <p class="demo-muted">Oracle 없이 메뉴·화면 구조만 확인하는 모드입니다. 실제 데이터 화면은 DB 연결 후 <code>?demo=off</code>로 열 수 있습니다.</p>

    <div class="demo-box">
        <div><strong>요청 경로:</strong> {{ $requestedPath ?? '/' }}</div>
        <div><strong>요청 메서드:</strong> {{ $requestedMethod ?? 'GET' }}</div>
        <div><strong>요청 URL:</strong> {{ $requestedUrl ?? url('/') }}</div>
    </div>

    <div class="demo-actions" style="margin-top: 16px;">
        <a class="btn btn-az-primary" href="/dashboard">대시보드</a>
        <a class="btn btn-outline-secondary" href="{{ ($requestedUrl ?? url('/')) . (strpos(($requestedUrl ?? ''), '?') !== false ? '&' : '?') . 'demo=off' }}">
            실제 페이지 열기 (demo=off)
        </a>
        <a class="btn btn-outline-danger" href="/logout">로그아웃</a>
    </div>
</div>
@endsection
