<div class="az-content-body-right">
    <label id="moreHistory" class="az-content-label tx-base mg-b-15">주소 정보</label>
    <div class="az-media-list-activity mg-b-20 moreHistory">
        @if(\App\Http\Controllers\BaseController::hasMenuShow("/reference/address", 1, \App\Http\Controllers\BaseController::enc(session()->get("auth")->userpositionid)))
            <div class="media">
                <div class="media-icon bg-success"><i class="typcn typcn-news"></i></div>
                <a href="{{ url('/reference/address') }}">
                    <div class="media-body">
                        <h6>국가 정보</h6>
                        <span>등록된 국가 정보</span>
                    </div>
                </a>
            </div>
        @endif
        @if(\App\Http\Controllers\BaseController::hasMenuShow("/reference/address/province", 1, \App\Http\Controllers\BaseController::enc(session()->get("auth")->userpositionid)))
            <div class="media">
                <div class="media-icon bg-warning"><i class="typcn typcn-news"></i></div>
                <a href="{{ url('/reference/address/province') }}">
                    <div class="media-body">
                        <h6>도시/아이막 정보</h6>
                        <span>등록된 도시/아이막 정보</span>
                    </div>
                </a>
            </div>
        @endif
        @if(\App\Http\Controllers\BaseController::hasMenuShow("/reference/address/destrict", 1, \App\Http\Controllers\BaseController::enc(session()->get("auth")->userpositionid)))
            <div class="media">
                <div class="media-icon bg-primary"><i class="typcn typcn-news"></i></div>
                <a href="{{ url('/reference/address/destrict') }}">
                    <div class="media-body">
                        <h6>구/솜 정보</h6>
                        <span>등록된 구/솜 정보</span>
                    </div>
                </a>
            </div>
        @endif
        @if(\App\Http\Controllers\BaseController::hasMenuShow("/reference/address/commission", 1, \App\Http\Controllers\BaseController::enc(session()->get("auth")->userpositionid)))
            <div class="media">
                <div class="media-icon bg-purple"><i class="typcn typcn-news"></i></div>
                <a href="{{ url('/reference/address/commission') }}">
                    <div class="media-body">
                        <h6>박/허로 정보</h6>
                        <span>등록된 박/허로 정보</span>
                    </div>
                </a>
            </div>
        @endif
        @if(\App\Http\Controllers\BaseController::hasMenuShow("/reference/address/town", 1, \App\Http\Controllers\BaseController::enc(session()->get("auth")->userpositionid)))
            <div class="media">
                <div class="media-icon bg-danger"><i class="typcn typcn-news"></i></div>
                <a href="{{ url('/reference/address/town') }}">
                    <div class="media-body">
                        <h6>구역 정보</h6>
                        <span>등록된 구역 정보</span>
                    </div>
                </a>
            </div>
        @endif
    </div>
</div>