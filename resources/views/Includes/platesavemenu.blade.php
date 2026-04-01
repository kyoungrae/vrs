<div class="az-content-body-right">
    <label id="moreHistory" class="az-content-label tx-base mg-b-15">Дугаар хадгалах үйлчигээ</label>
    <div class="az-media-list-activity mg-b-20 moreHistory">
        @if(\App\Http\Controllers\BaseController::hasMenuShow("/plateSave", 1, \App\Http\Controllers\BaseController::enc(session()->get("auth")->userpositionid)))
            <div class="media">
                <div class="media-icon bg-purple"><i class=" typcn typcn-news"></i></div>
                <a href="/plateSave">
                    <div class="media-body">
                        <h6>Хадгалсан дугаар</h6>
                        <span>Хадгалсан дугаарын жагсаалт</span>
                    </div>
                </a>
            </div>
        @endif 
        @if(\App\Http\Controllers\BaseController::hasMenuShow("/plateSave/indexSavePlateStore", 1, \App\Http\Controllers\BaseController::enc(session()->get("auth")->userpositionid)))
            <div class="media">
                <div class="media-icon bg-success"><i class=" typcn typcn-download"></i></div>
                <a href="/plateSave/indexSavePlateStore">
                    <div class="media-body">
                        <h6>번호판 хадгалах</h6>
                        <span>번호판 хадгалах үйлчигээ</span>
                    </div>
                </a>
            </div>
        @endif
        @if(\App\Http\Controllers\BaseController::hasMenuShow("/plateSave/edit", 1, \App\Http\Controllers\BaseController::enc(session()->get("auth")->userpositionid)))
            <div class="media">
                <div class="media-icon bg-success"><i class=" typcn typcn-calendar"></i></div>
                <a href="/plateSave/edit">
                    <div class="media-body">
                        <h6>Хадгалсан дугаар  сунгах</h6>
                        <span>Хадгалсан дугаар сунгах үйлчигээ</span>
                    </div>
                </a>
            </div>
        @endif
        {{-- @if(\App\Http\Controllers\BaseController::hasMenuShow("/series/create", 1, \App\Http\Controllers\BaseController::enc(session()->get("auth")->userpositionid)))
            <div class="media">
                <div class="media-icon bg-primary"><i class="typcn typcn-news"></i></div>
                <a href="/series/create">
                    <div class="media-body">
                        <h6>Дугаар захиалга</h6>
                        <span>Дугаар захиалгын дугаар хадгалах</span>
                    </div>
                </a>
            </div>
        @endif
        @if(\App\Http\Controllers\BaseController::hasMenuShow("/series/open", 1, \App\Http\Controllers\BaseController::enc(session()->get("auth")->userpositionid)))
            <div class="media">
                <div class="media-icon bg-warning"><i class="typcn typcn-document-add"></i></div>
                <a href="/series/open">
                    <div class="media-body">
                        <h6>Үйлчигээ авсан</h6>
                        <span>Дугаар солих болон 말소 хийлгэсэн дугаар хадгалах</span>
                    </div>
                </a>
            </div>
        @endif --}}
      
        @if(\App\Http\Controllers\BaseController::hasMenuShow("/plateSave/plateNumberSaveOrder", 1, \App\Http\Controllers\BaseController::enc(session()->get("auth")->userpositionid)))
            <div class="media">
                <div class="media-icon bg-purple"><i class="typcn typcn-upload"></i></div>
                <a href="/plateSave/plateNumberSaveOrder">
                    <div class="media-body">
                        <h6>Хадгалсан дугаар захиалах</h6>
                        <span>Хадгалсан дугаар захиалах үйлчилгээ</span>
                    </div>
                </a>
            </div>
        @endif
        @if(\App\Http\Controllers\BaseController::hasMenuShow("/plateSave/plateNumberOrderList", 1, \App\Http\Controllers\BaseController::enc(session()->get("auth")->userpositionid)))
            <div class="media">
                <div class="media-icon bg-success"><i class="typcn typcn-news"></i></div>
                <a href="/plateSave/plateNumberOrderList">
                    <div class="media-body">
                        <h6>주문된 번호 목록</h6>
                        <span>주문된 번호 목록</span>
                    </div>
                </a>
            </div>
        @endif
        @if(\App\Http\Controllers\BaseController::hasMenuShow("/plateSavePay", 1, \App\Http\Controllers\BaseController::enc(session()->get("auth")->userpositionid)))
            <div class="media">
                <div class="media-icon bg-purple"><i class="typcn typcn-news"></i></div>
                <a href="/plateSavePay">
                    <div class="media-body">
                        <h6>Дугаарын төлбөр шалгах</h6>
                        <span>Дугаарын төлбөр жагсаалт</span>
                    </div>
                </a>
            </div>
        @endif
   
    
    </div>
</div>