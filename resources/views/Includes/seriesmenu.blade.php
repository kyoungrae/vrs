<div class="az-content-body-right">
    <label id="moreHistory" class="az-content-label tx-base mg-b-15">번호판 시리즈 작업</label>
    <div class="az-media-list-activity mg-b-20 moreHistory">
        @if(\App\Http\Controllers\BaseController::hasMenuShow("/reference/series", 1, \App\Http\Controllers\BaseController::enc(session()->get("auth")->userpositionid)))
            <div class="media">
                <div class="media-icon bg-success"><i class="typcn typcn-arrow-back"></i></div>
                <a href="{{ url('/reference/series') }}">
                    <div class="media-body">
                        <h6>시리즈 정보</h6>
                        <span>시리즈 목록 관리를 수행합니다.</span>
                    </div>
                </a>
            </div>
        @endif
        @if(\App\Http\Controllers\BaseController::hasMenuShow("/series/create", 1, \App\Http\Controllers\BaseController::enc(session()->get("auth")->userpositionid)))
            <div class="media">
                <div class="media-icon bg-primary"><i class="typcn typcn-news"></i></div>
                <a href="{{ url('/series/create') }}">
                    <div class="media-body">
                        <h6>시리즈 생성</h6>
                        <span>새로운 번호판 시리즈를 생성합니다.</span>
                    </div>
                </a>
            </div>
        @endif
        @if(\App\Http\Controllers\BaseController::hasMenuShow("/series/open", 1, \App\Http\Controllers\BaseController::enc(session()->get("auth")->userpositionid)))
            <div class="media">
                <div class="media-icon bg-warning"><i class="typcn typcn-document-add"></i></div>
                <a href="{{ url('/series/open') }}">
                    <div class="media-body">
                        <h6>주문에 시리즈 추가</h6>
                        <span>주문 창에 시리즈를 표시합니다.</span>
                    </div>
                </a>
            </div>
        @endif
        @if(\App\Http\Controllers\BaseController::hasMenuShow("/series/open/list", 1, \App\Http\Controllers\BaseController::enc(session()->get("auth")->userpositionid)))
            <div class="media">
                <div class="media-icon bg-warning"><i class="typcn typcn-th-list-outline"></i></div>
                <a href="{{ url('/series/open/list') }}">
                    <div class="media-body">
                        <h6>주문 포함 시리즈 목록</h6>
                        {{--<span>Нээгдсэн серийн жагсаалттай а년лах</span>--}}
                    </div>
                </a>
            </div>
        @endif
        @if(\App\Http\Controllers\BaseController::hasMenuShow("/series/send", 1, \App\Http\Controllers\BaseController::enc(session()->get("auth")->userpositionid)))
            <div class="media">
                <div class="media-icon bg-purple"><i class="typcn typcn-upload"></i></div>
                <a href="{{ url('/series/send') }}">
                    <div class="media-body">
                        <h6>시리즈 전송</h6>
                        <span>시리즈를 전송하고 할당합니다.</span>
                    </div>
                </a>
            </div>
        @endif
        @if(\App\Http\Controllers\BaseController::hasMenuShow("/series/sent", 1, \App\Http\Controllers\BaseController::enc(session()->get("auth")->userpositionid)))
            <div class="media">
                <div class="media-icon bg-danger"><i class="typcn typcn-document-text"></i></div>
                <a href="{{ url('/series/sent') }}">
                    <div class="media-body">
                        <h6>전송된 시리즈</h6>
                        <span>이미 전송된 시리즈 목록입니다.</span>
                    </div>
                </a>
            </div>
        @endif
        @if(\App\Http\Controllers\BaseController::hasMenuShow("/series/search", 1, \App\Http\Controllers\BaseController::enc(session()->get("auth")->userpositionid)))
            <div class="media">
                <div class="media-icon bg-dark"><i class="typcn typcn-filter"></i></div>
                <a href="{{ url('/series/search') }}">
                    <div class="media-body">
                        <h6>시리즈 검색</h6>
                        <span>시리즈 통합 검색을 수행합니다.</span>
                    </div>
                </a>
            </div>
        @endif
    </div>
</div>