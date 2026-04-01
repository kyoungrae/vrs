@php
    $auth = session()->get("auth");
    $authId = null;
    $authPositionId = null;
    if (is_object($auth)) {
        $authId = $auth->id ?? $auth->Id ?? $auth->ID ?? null;
        $authPositionId = $auth->userpositionid ?? $auth->UserPositionId ?? $auth->USERPOSITIONID ?? null;
    }
@endphp

@if(\App\Http\Controllers\BaseController::checkChangePassword($authId) < 30)
    <a href="/dashboard" class="az-iconbar-logo"><img src="{{ asset('img/logo.png') }}" width="45px" /></a>
    <nav class="nav">
        @if(\App\Http\Controllers\BaseController::hasMenuShow("main_user", 1, \App\Http\Controllers\BaseController::enc($authPositionId)))
            <a href="#asideUser" class="nav-link <?php $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']; $activeMenu=""; if (strpos($url,"user") != false) { echo $activeMenu="active"; } ?>"><i class="typcn typcn-user"></i></a>
        @endif
        @if(\App\Http\Controllers\BaseController::hasMenuShow("main_vehicle", 1, \App\Http\Controllers\BaseController::enc($authPositionId)))
            <a href="#asideVehicle" class="nav-link <?php $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']; $activeMenu=""; if (strpos($url,"vehicle") != false) { echo $activeMenu="active"; } ?>"><i class="ion-ios-car"></i></a>
        @endif
        @if(\App\Http\Controllers\BaseController::hasMenuShow("main_search", 1, \App\Http\Controllers\BaseController::enc($authPositionId)))
            <a href="#asideFilter" class="nav-link <?php $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']; $activeMenu=""; if (strpos($url,"search") != false) { echo $activeMenu="active"; } ?>"><i class="typcn typcn-filter"></i></a>
        @endif
        @if(\App\Http\Controllers\BaseController::hasMenuShow("main_reference", 1, \App\Http\Controllers\BaseController::enc($authPositionId)))
            <a href="#asideReference" class="nav-link <?php $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']; $activeMenu=""; if (strpos($url,"reference/") != false || strpos($url,"series/") != false) { echo $activeMenu="active"; } ?>"><i class="typcn typcn-th-large-outline"></i></a>
        @endif

        <a href="#asideReports" class="nav-link <?php $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']; $activeMenu=""; if (strpos($url,"report") != false) { echo $activeMenu="active"; } ?>"><i class="typcn typcn-chart-area-outline"></i></a>

        @if(\App\Http\Controllers\BaseController::hasMenuShow("main_system", 1, \App\Http\Controllers\BaseController::enc($authPositionId)))
            <a href="#asideSettings" class="nav-link <?php $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']; $activeMenu=""; if (strpos($url,"settings") != false) { echo $activeMenu="active"; } ?>"><i class="typcn typcn-cog-outline"></i></a>
        @endif

        @if(\App\Http\Controllers\BaseController::hasMenuShow("/mehanizm/search", 1, \App\Http\Controllers\BaseController::enc($authPositionId)))
            <a title="기타 차량 번호 검색" href="/mehanizm/search" onclick="location.href='/mehanizm/search';" style="color: rgba(255, 255, 255, 0.5) !important;margin-top: 10px;border-radius: 3px; transition: all 0.2s ease-in-out; position: relative; padding: 0;width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; line-height: 1; font-size: 30px;" class="<?php $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']; $activeMenu=""; if (strpos($url,"search") != false) { echo $activeMenu="active"; } ?>"><i class="la la-search"></i></a>
        @endif

        @if(\App\Http\Controllers\BaseController::hasMenuShow("/reference/orderednumbers", 1, \App\Http\Controllers\BaseController::enc($authPositionId)))
            <a title="예약 번호 검색" href="/reference/orderednumbers" onclick="location.href='/reference/orderednumbers';" style="color: rgba(255, 255, 255, 0.5) !important;margin-top: 10px;border-radius: 3px; transition: all 0.2s ease-in-out; position: relative; padding: 0;width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; line-height: 1; font-size: 30px;" class="<?php $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']; $activeMenu=""; if (strpos($url,"orderednumbers") != false) { echo $activeMenu="active"; } ?>"><i class="la la-filter"></i></a>
        @endif

        @if(\App\Http\Controllers\BaseController::hasMenuShow("/plate/print", 1, \App\Http\Controllers\BaseController::enc($authPositionId)))
            <a title="번호판 인쇄" href="/plate/print" onclick="location.href='/plate/print';" style="color: rgba(255, 255, 255, 0.5) !important;margin-top: 10px;border-radius: 3px; transition: all 0.2s ease-in-out; position: relative; padding: 0;width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; line-height: 1; font-size: 30px;" class="<?php $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']; $activeMenu=""; if (strpos($url,"print") != false) { echo $activeMenu="active"; } ?>"><i class="la la-print"></i></a>
        @endif
    </nav>
@endif