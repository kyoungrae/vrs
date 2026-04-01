<div class="az-content-body-right">
    <label id="moreHistory" class="az-content-label tx-base mg-b-15">Серийн үйлдлүүд</label>
    <div class="az-media-list-activity mg-b-20 moreHistory">
        @if(\App\Http\Controllers\BaseController::hasMenuShow("/reference/series", 1, \App\Http\Controllers\BaseController::enc(session()->get("auth")->userpositionid)))
            <div class="media">
                <div class="media-icon bg-success"><i class="typcn typcn-arrow-back"></i></div>
                <a href="/reference/series">
                    <div class="media-body">
                        <h6>Серийн лавлах</h6>
                        <span>Серийн лавлах жагсаалт</span>
                    </div>
                </a>
            </div>
        @endif
        @if(\App\Http\Controllers\BaseController::hasMenuShow("/series/create", 1, \App\Http\Controllers\BaseController::enc(session()->get("auth")->userpositionid)))
            <div class="media">
                <div class="media-icon bg-primary"><i class="typcn typcn-news"></i></div>
                <a href="/series/create">
                    <div class="media-body">
                        <h6>Сери үүсгэх</h6>
                        <span>신규эр сери үүсгэх</span>
                    </div>
                </a>
            </div>
        @endif
        @if(\App\Http\Controllers\BaseController::hasMenuShow("/series/open", 1, \App\Http\Controllers\BaseController::enc(session()->get("auth")->userpositionid)))
            <div class="media">
                <div class="media-icon bg-warning"><i class="typcn typcn-document-add"></i></div>
                <a href="/series/open">
                    <div class="media-body">
                        <h6>Сери захиалга руу оруулах</h6>
                        <span>Захиалгын цонхонд харагдах</span>
                    </div>
                </a>
            </div>
        @endif
        @if(\App\Http\Controllers\BaseController::hasMenuShow("/series/open/list", 1, \App\Http\Controllers\BaseController::enc(session()->get("auth")->userpositionid)))
            <div class="media">
                <div class="media-icon bg-warning"><i class="typcn typcn-th-list-outline"></i></div>
                <a href="/series/open/list">
                    <div class="media-body">
                        <h6>Захиалга руу орсон серийн жагсаалт</h6>
                        {{--<span>Нээгдсэн серийн жагсаалттай а년лах</span>--}}
                    </div>
                </a>
            </div>
        @endif
        @if(\App\Http\Controllers\BaseController::hasMenuShow("/series/send", 1, \App\Http\Controllers\BaseController::enc(session()->get("auth")->userpositionid)))
            <div class="media">
                <div class="media-icon bg-purple"><i class="typcn typcn-upload"></i></div>
                <a href="/series/send">
                    <div class="media-body">
                        <h6>Сери илгээх</h6>
                        <span>Сери илгээх, хуваарилах</span>
                    </div>
                </a>
            </div>
        @endif
        @if(\App\Http\Controllers\BaseController::hasMenuShow("/series/sent", 1, \App\Http\Controllers\BaseController::enc(session()->get("auth")->userpositionid)))
            <div class="media">
                <div class="media-icon bg-danger"><i class="typcn typcn-document-text"></i></div>
                <a href="/series/sent">
                    <div class="media-body">
                        <h6>Илгээсэн серүүд</h6>
                        <span>합계 илгээсэн серүүд</span>
                    </div>
                </a>
            </div>
        @endif
        @if(\App\Http\Controllers\BaseController::hasMenuShow("/series/search", 1, \App\Http\Controllers\BaseController::enc(session()->get("auth")->userpositionid)))
            <div class="media">
                <div class="media-icon bg-dark"><i class="typcn typcn-filter"></i></div>
                <a href="/series/search">
                    <div class="media-body">
                        <h6>Серийн хайлт</h6>
                        <span>Серийн хайлт хийх</span>
                    </div>
                </a>
            </div>
        @endif
    </div>
</div>