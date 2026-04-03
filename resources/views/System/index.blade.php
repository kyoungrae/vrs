<!DOCTYPE html>
<html lang="en">
<head>
    @include('Includes.head-login')
    <style>
        .az-body
        {
            background: #e9ecef;
        }
        .az-card-signin
        {
            background: #fff;
            min-height: 500px;
            height: auto !important;
            max-height: none !important;
            border: 1px solid #fef100;
            border-radius: 8px;
            padding: 20px 40px 24px 40px;
            overflow: visible;
        }
        .dev-local-login-wrap {
            position: relative;
            z-index: 50;
            margin-top: 12px;
        }
        .dev-local-login-wrap a,
        .dev-local-login-wrap button {
            pointer-events: auto;
            cursor: pointer;
        }
        .login-title
        {
            margin-bottom: 20px;
        }
        .logo
        {
            width:120px;
            padding: 0px;
            margin: 0px;
        }
        .form-control
        {
            height: 38px !important;
        }
    </style>
</head>
<body class="az-body" style="overflow-x: hidden; overflow-y: auto;">
<div class="az-signin-wrapper">
    <div class="az-card-signin">
        <center><img src="{{ asset('img/logo.png') }}" class="logo" alt="" /></center>
        <div class="az-signin-header" style="padding-top: 0px">
            <center class="login-title">
                <h4>자동차 운송 통합 시스템</h4>
            </center>
            @if(ISSET($message) || session()->has("message"))
                @include("System.message")
            @endif
            <form method="POST" action="{{ route("login") }}">
                {{ csrf_field() }}
                <div class="form-group">
                    <label>아이디</label>
                    <input type="text" class="form-control" name="username" required placeholder="아이디를 입력하세요">
                </div>
                <div class="form-group">
                    <label>비밀번호</label>
                    <input type="password" class="form-control" name="password" required placeholder="비밀번호를 입력하세요">
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <label>{{ captcha_img('flat') }}</label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="captcha" class="form-control" autocomplete="off" required placeholder="보안 코드를 입력하세요">
                        </div>
                    </div>
                </div>
                <button class="btn btn-az-primary btn-block" style="margin-top: 0 !important;">로그인</button>
            </form>
            @if (\App\Http\Controllers\BaseController::isDevBypassLogin())
                <div class="form-group dev-local-login-wrap">
                    <button type="button" class="btn btn-outline-secondary btn-block btn-sm"
                        onclick="window.location.href='{{ url('/dev/local-login') }}'">
                        로컬 개발: 계정 없이 진입 (DEV_BYPASS_LOGIN)
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>
</body>
</html>
