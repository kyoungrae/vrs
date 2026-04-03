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
    <div class="az-iconbar-body">
        @if(\App\Http\Controllers\BaseController::hasMenuShow("main_user", 1, \App\Http\Controllers\BaseController::enc($authPositionId)))
            <div id="asideUser" class="az-iconbar-pane">
                <h6 class="az-iconbar-title">사용자</h6>
                <small class="az-iconbar-text">시스템 로그인 권한이 있는 사용자를 관리하는 메뉴입니다.</small>
                <nav class="nav">
                    @if(\App\Http\Controllers\BaseController::hasMenuShow("/user", 1, \App\Http\Controllers\BaseController::enc($authPositionId)))
                        <a href="{{ url('/user') }}" class="nav-link">사용자 등록</a>
                    @endif
                    @if(\App\Http\Controllers\BaseController::hasMenuShow("/userlist", 1, \App\Http\Controllers\BaseController::enc($authPositionId)))
                        <a href="{{ url('/userlist') }}" class="nav-link">사용자 목록</a>
                    @endif
                </nav>
            </div>
        @endif
        @if(\App\Http\Controllers\BaseController::hasMenuShow("main_vehicle", 1, \App\Http\Controllers\BaseController::enc($authPositionId)))
            <div id="asideVehicle" class="az-iconbar-pane">
                <h6 class="az-iconbar-title">차량</h6>
                <small class="az-iconbar-text">차량 등록, 소유자, 아카이브, 제한 정보 등을 관리하는 메뉴입니다.</small>
                <nav class="nav">
                    @if(\App\Http\Controllers\BaseController::hasMenuShow("/vehicle", 1, \App\Http\Controllers\BaseController::enc($authPositionId)))
                        <a href="{{ url('/vehicle') }}" class="nav-link">차량 정보</a>
                    @endif
                </nav>
            </div>
        @endif
        @if(\App\Http\Controllers\BaseController::hasMenuShow("main_search", 1, \App\Http\Controllers\BaseController::enc($authPositionId)))
            <div id="asideFilter" class="az-iconbar-pane">
                <h6 class="az-iconbar-title">검색</h6>
                <small class="az-iconbar-text">차량 등록, 소유자 상세, 아카이브를 검색하는 메뉴입니다.</small>
                <nav class="nav">
                    @if(\App\Http\Controllers\BaseController::hasMenuShow("/search", 1, \App\Http\Controllers\BaseController::enc($authPositionId)))
                        <a href="{{ url('/search') }}" class="nav-link">차량 검색</a>
                    @endif
                </nav>
            </div>
        @endif
        @if(\App\Http\Controllers\BaseController::hasMenuShow("main_reference", 1, \App\Http\Controllers\BaseController::enc($authPositionId)))
            <div id="asideReference" class="az-iconbar-pane">
                <h6 class="az-iconbar-title">기준정보</h6>
                <small class="az-iconbar-text">주소, 시리얼, 서비스 기준정보를 관리하는 메뉴입니다.</small>
                <nav class="nav">
                    @if(\App\Http\Controllers\BaseController::hasMenuShow("/reference/service", 1, \App\Http\Controllers\BaseController::enc($authPositionId)))
                        <a href="{{ url('/reference/service') }}" class="nav-link">서비스</a>
                    @endif
                    @if(\App\Http\Controllers\BaseController::hasMenuShow("/reference/position", 1, \App\Http\Controllers\BaseController::enc($authPositionId)))
                        <a href="{{ url('/reference/position') }}" class="nav-link">직책</a>
                    @endif
                    @if(\App\Http\Controllers\BaseController::hasMenuShow("main_address", 1, \App\Http\Controllers\BaseController::enc($authPositionId)))
                        <a href="{{ url('/reference/address') }}" class="nav-link">주소 기준정보</a>
                    @endif
                    @if(\App\Http\Controllers\BaseController::hasMenuShow("/reference/factorycountry", 1, \App\Http\Controllers\BaseController::enc($authPositionId)))
                        <a href="{{ url('/reference/factorycountry') }}" class="nav-link">제조국</a>
                    @endif
                    @if(\App\Http\Controllers\BaseController::hasMenuShow("/reference/org", 1, \App\Http\Controllers\BaseController::enc($authPositionId)))
                        <a href="{{ url('/reference/org') }}" class="nav-link">조회 기관</a>
                    @endif
                    @if(\App\Http\Controllers\BaseController::hasMenuShow("/reference/owner", 1, \App\Http\Controllers\BaseController::enc($authPositionId)))
                        <a href="{{ url('/reference/owner') }}" class="nav-link">소유자 기준정보</a>
                    @endif
                    @if(\App\Http\Controllers\BaseController::hasMenuShow("main_series", 1, \App\Http\Controllers\BaseController::enc($authPositionId)))
                        <a href="{{ url('/reference/series') }}" class="nav-link">시리얼 기준정보</a>
                    @endif 
                    @if(\App\Http\Controllers\BaseController::hasMenuShow("main_series", 1, \App\Http\Controllers\BaseController::enc($authPositionId)))
                    <a href="{{ url('/audit') }}" class="nav-link">감사 로그</a>
                @endif 
                    @if(\App\Http\Controllers\BaseController::hasMenuShow("main_series", 1, \App\Http\Controllers\BaseController::enc($authPositionId)))
                    <a href="{{ url('/auction') }}" class="nav-link">경매</a>
                @endif 
                    @if(\App\Http\Controllers\BaseController::hasMenuShow("/payment", 1, \App\Http\Controllers\BaseController::enc($authPositionId)))
                    <a href="{{ url('/payment') }}" class="nav-link">결제 확인</a>
                @endif 
                    @if(\App\Http\Controllers\BaseController::hasMenuShow("/plateSave", 1, \App\Http\Controllers\BaseController::enc($authPositionId)))
                    <a href="{{ url('/plateSave') }}" class="nav-link">번호 보관</a>
                @endif 
                    @if(\App\Http\Controllers\BaseController::hasMenuShow("/recovery/vehiclePlateRecovery", 1, \App\Http\Controllers\BaseController::enc($authPositionId)))
                    <a href="{{ url('/recovery/vehiclePlateRecovery') }}" class="nav-link">말소 번호 예약</a>
                @endif 
                </nav>
            </div> 
        @endif
        @if(\App\Http\Controllers\BaseController::hasMenuShow("main_system", 1, \App\Http\Controllers\BaseController::enc($authPositionId)))
            <div id="asideSettings" class="az-iconbar-pane">
                <h6 class="az-iconbar-title">시스템 설정</h6>
                <small class="az-iconbar-text">시스템 운영 설정을 관리하는 메뉴입니다.</small>
                <nav class="nav">
                    @if(\App\Http\Controllers\BaseController::hasMenuShow("/settings/department", 1, \App\Http\Controllers\BaseController::enc($authPositionId)))
                        <a href="{{ url('/settings/department') }}" class="nav-link">부서</a>
                    @endif
                    @if(\App\Http\Controllers\BaseController::hasMenuShow("/settings/archive", 1, \App\Http\Controllers\BaseController::enc($authPositionId)))
                        <a href="{{ url('/settings/archive') }}" class="nav-link">아카이브 지점</a>
                    @endif
                </nav>
            </div>
        @endif
        @if(\App\Http\Controllers\BaseController::hasMenuShow("main_report", 1, \App\Http\Controllers\BaseController::enc($authPositionId)))
            <div id="asideReports" class="az-iconbar-pane">
                <h6 class="az-iconbar-title">리포트</h6>
                <small class="az-iconbar-text">리포트 및 통계</small>
                <nav class="nav">
                    @if(\App\Http\Controllers\BaseController::hasMenuShow("/report/vehicle/total", 1, \App\Http\Controllers\BaseController::enc($authPositionId)))
                        <a href="{{ url('/report/total') }}" class="nav-link">전체 차량</a>
                    @endif
                    @if(\App\Http\Controllers\BaseController::hasMenuShow("/report/vehicle/archive", 1, \App\Http\Controllers\BaseController::enc($authPositionId)))
                        <a href="{{ url('/report/archive') }}" class="nav-link">아카이브 요약</a>
                    @endif
                    @if(\App\Http\Controllers\BaseController::hasMenuShow("/report/daily/transfer", 1, \App\Http\Controllers\BaseController::enc($authPositionId)))
                        <a href="{{ url('/report/daily/transfer') }}" class="nav-link">이전 상세 리포트</a>
                    @endif
                    @if(\App\Http\Controllers\BaseController::hasMenuShow("/report/daily/import", 1, \App\Http\Controllers\BaseController::enc($authPositionId)))
                        <a href="{{ url('/report/daily/import') }}" class="nav-link">수입 상세 리포트</a>
                    @endif
                    @if(\App\Http\Controllers\BaseController::hasMenuShow("/report/daily/users", 1, \App\Http\Controllers\BaseController::enc($authPositionId)))
                        <a href="{{ url('/report/daily/users') }}" class="nav-link">담당자 리포트</a>
                    @endif
                    @if(\App\Http\Controllers\BaseController::hasMenuShow("/report/ePay/users", 1, \App\Http\Controllers\BaseController::enc($authPositionId)))
                        <a href="{{ url('/report/ePay/users') }}" class="nav-link">담당자 결제 리포트</a>
                    @endif
                    {{--@if(\App\Http\Controllers\BaseController::hasMenuShow("/report/daily/newplate", 1, \App\Http\Controllers\BaseController::enc($authPositionId)))--}}
                    {{--<a href="{{ url('/report/daily/newplate') }}" class="nav-link">신규 번호판 발급 리포트</a>--}}
                    {{--@endif--}}
                    @if(\App\Http\Controllers\BaseController::hasMenuShow("/report/daily/users/info", 1, \App\Http\Controllers\BaseController::enc($authPositionId)))
                        <a href="{{ url('/report/daily/users/info') }}" class="nav-link">담당자 상세 리포트</a>
                    @endif
                    @if(\App\Http\Controllers\BaseController::hasMenuShow("/report/daily/vehicleref", 1, \App\Http\Controllers\BaseController::enc($authPositionId)))
                        <a href="{{ url('/report/daily/vehicleref') }}" class="nav-link">차량 조회(소유자 기준)</a>
                    @endif
                    @if(\App\Http\Controllers\BaseController::hasMenuShow("/report/daily/vehicleref2", 1, \App\Http\Controllers\BaseController::enc($authPositionId)))
                        <a href="{{ url('/report/daily/vehicleref2') }}" class="nav-link">차량 조회(점유자 기준)</a>
                    @endif
                    @if(\App\Http\Controllers\BaseController::hasMenuShow("/report/daily/vehiclerefold", 1, \App\Http\Controllers\BaseController::enc($authPositionId)))
                        <a href="{{ url('/report/daily/vehiclerefold') }}" class="nav-link">차량 조회(이전 소유자 기준)</a>
                    @endif
                    @if(\App\Http\Controllers\BaseController::hasMenuShow("/report/all/users", 1, \App\Http\Controllers\BaseController::enc($authPositionId)))
                        <a href="{{ url('/report/all/users') }}" class="nav-link">전체 담당자 리포트</a>
                    @endif
                    @if(\App\Http\Controllers\BaseController::hasMenuShow("/report/aging", 1, \App\Http\Controllers\BaseController::enc($authPositionId)))
                        <a href="{{ url('/report/aging') }}" class="nav-link">연식 리포트</a>
                    @endif
                    @if(\App\Http\Controllers\BaseController::hasMenuShow("/report/total/province", 1, \App\Http\Controllers\BaseController::enc($authPositionId)))
                        <a href="{{ url('/report/total/province') }}" class="nav-link">전체 차량 통계</a>
                    @endif
                    @if(\App\Http\Controllers\BaseController::hasMenuShow("/report/user/certificate", 1, \App\Http\Controllers\BaseController::enc($authPositionId)))
                        <a href="{{ url('/report/user/certificate') }}" class="nav-link">증명서 리포트</a>
                    @endif
                    @if(\App\Http\Controllers\BaseController::hasMenuShow("/report/vehicle/remove", 1, \App\Http\Controllers\BaseController::enc($authPositionId)))
                        <a href="{{ url('/report/vehicle/remove') }}" class="nav-link">말소 차량 리포트</a>
                    @endif
                    @if(\App\Http\Controllers\BaseController::hasMenuShow("/report/daily/department", 1, \App\Http\Controllers\BaseController::enc($authPositionId)))
                        <a href="{{ url('/report/daily/department') }}" class="nav-link">지점 리포트</a>
                    @endif
                    @if($authPositionId == 1 || $authPositionId == 103)
                        <a href="{{ url('/report/position/log') }}" class="nav-link">직책 권한 로그</a>
                    @endif
                    @if(\App\Http\Controllers\BaseController::hasMenuShow("/report/reportFactory", 1, \App\Http\Controllers\BaseController::enc($authPositionId)))
                        <a href="{{ url('/report/reportFactory') }}" class="nav-link">번호판 공장 리포트</a>
                    @endif
                    @if(\App\Http\Controllers\BaseController::hasMenuShow("/report/reportFactoryPlate", 1, \App\Http\Controllers\BaseController::enc($authPositionId)))
                        <a href="{{ url('/report/reportFactoryPlate') }}" class="nav-link">번호판 인쇄 리포트</a>
                    @endif
                    @if(\App\Http\Controllers\BaseController::hasMenuShow("/report/reportFactoryColor", 1, \App\Http\Controllers\BaseController::enc($authPositionId)))
                        <a href="{{ url('/report/reportFactoryColor') }}" class="nav-link">번호판 색상 리포트</a>
                    @endif
                    {{-- @if(\App\Http\Controllers\BaseController::hasMenuShow("/report/plateSaveReport", 1, \App\Http\Controllers\BaseController::enc($authPositionId))) --}}
                        <a href="{{ url('/report/plateSaveReport') }}" class="nav-link">번호 보관 리포트</a>
                    {{-- @endif --}}
                </nav>
            </div>
        @endif
    </div>
@endif 