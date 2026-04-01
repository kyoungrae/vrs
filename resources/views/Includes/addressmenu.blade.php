<div class="az-content-body-right">
    <label id="moreHistory" class="az-content-label tx-base mg-b-15">주소ийн лавлахууд</label>
    <div class="az-media-list-activity mg-b-20 moreHistory">
        @if(\App\Http\Controllers\BaseController::hasMenuShow("/reference/address", 1, \App\Http\Controllers\BaseController::enc(session()->get("auth")->userpositionid)))
            <div class="media">
                <div class="media-icon bg-success"><i class="typcn typcn-news"></i></div>
                <a href="/reference/address">
                    <div class="media-body">
                        <h6>Улсын лавлах</h6>
                        <span>Бүртгэлтэй улсын лавлах</span>
                    </div>
                </a>
            </div>
        @endif
        @if(\App\Http\Controllers\BaseController::hasMenuShow("/reference/address/province", 1, \App\Http\Controllers\BaseController::enc(session()->get("auth")->userpositionid)))
            <div class="media">
                <div class="media-icon bg-warning"><i class="typcn typcn-news"></i></div>
                <a href="/reference/address/province">
                    <div class="media-body">
                        <h6>Хот/аймгийн лавлах</h6>
                        <span>Бүртгэлтэй хот/аймгийн лавлах</span>
                    </div>
                </a>
            </div>
        @endif
        @if(\App\Http\Controllers\BaseController::hasMenuShow("/reference/address/destrict", 1, \App\Http\Controllers\BaseController::enc(session()->get("auth")->userpositionid)))
            <div class="media">
                <div class="media-icon bg-primary"><i class="typcn typcn-news"></i></div>
                <a href="/reference/address/destrict">
                    <div class="media-body">
                        <h6>Дүүрэг/сумын лавлах</h6>
                        <span>Бүртгэлтэй дүүрэг/сумын лавлах</span>
                    </div>
                </a>
            </div>
        @endif
        @if(\App\Http\Controllers\BaseController::hasMenuShow("/reference/address/commission", 1, \App\Http\Controllers\BaseController::enc(session()->get("auth")->userpositionid)))
            <div class="media">
                <div class="media-icon bg-purple"><i class="typcn typcn-news"></i></div>
                <a href="/reference/address/commission">
                    <div class="media-body">
                        <h6>Баг/хорооны лавлах</h6>
                        <span>Бүртгэлтэй баг/хорооны лавлах</span>
                    </div>
                </a>
            </div>
        @endif
        @if(\App\Http\Controllers\BaseController::hasMenuShow("/reference/address/town", 1, \App\Http\Controllers\BaseController::enc(session()->get("auth")->userpositionid)))
            <div class="media">
                <div class="media-icon bg-danger"><i class="typcn typcn-news"></i></div>
                <a href="/reference/address/town">
                    <div class="media-body">
                        <h6>Хорооллын лавлах</h6>
                        <span>Бүртгэлтэй хорооллын лавлах</span>
                    </div>
                </a>
            </div>
        @endif
    </div>
</div>