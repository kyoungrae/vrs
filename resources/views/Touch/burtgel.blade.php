<!DOCTYPE html>
<html lang="en">
<head>
    @include('Includes.head')
    <link href="{{ asset('css/vrstouch.css') }}" rel="stylesheet">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script> 
    <style>
        .az-content-dashboard-ten .card{margin:0!important}.ordered_number{pointer-events:none;color:#42ff14;border:1px solid #42ff14}.ordered_pending{pointer-events:none;color:#ffdf00;border:1px solid #ffb900}.given_number{pointer-events:none;color:#ff0002;border:1px solid #ff0002}.alert-outline-success{border-color:#0062cb;color:#0062cb;font-size:18px}@media only screen and (max-width: 1100px){.modal-dialog{max-width:95%!important;width:95%!important}.form-control{padding:0;font-size:18px!important}}@media only screen and (max-width: 700px){.modal-dialog{max-width:95%!important;width:95%!important}.form-control{padding:0;font-size:12px!important}.headerIcon{margin-top:2px;font-size:10px!important}}@media only screen and (max-width: 450px){.modal-dialog{max-width:95%!important;width:95%!important}.form-control{padding:0;width:200%;font-size:15px!important}.headerIcon{margin-top:8px;font-size:5px!important}}@media only screen and (max-width: 350px){.headerIcon{display:none}}
    </style>
</head>
<body class="az-body flexcroll" oncontextmenu="return false;">
<div class="az-iconbar az-iconbar-primary">
    <a href="/dashboard" class="az-iconbar-logo"><img src="{{ asset('img/logo.png') }}" width="45px" /></a>
</div>
<div class="az-iconbar-aside az-iconbar-aside-primary">
</div>
<div class="az-content az-content-dashboard-ten">
    <div class="az-content-body">
        <div class="az-content-body-left">

            <form id="seriesForm" action="" method="POST">
                {{ csrf_field() }}
                <div class="row row-sm">
                    <div class="col-lg-4 col-md-12 col-sm-12">
                        <div class="card-header tx-bold bd-0 tx-white bg-primary" style=" background: #0062cb !important; ">
                            검색
                        </div>

                        <div class="card card-body card-dashboard-twentyfive">

                            <div class="row flexcroll" style=" max-height: 550px; overflow-x: hidden; overflow-y: scroll; ">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="row">

                                        <div class="col" style=" padding: 0; ">
                                            <select name="d1" id="select-reg-2" class="form-control form-control select2-no-search" required style=" font-size: 25px; height: 50px !important; ">
                                                <option value="0" @if(isset($d1) && $d1=="0") {{"selected"}} @endif>0</option>
                                                <option value="1" @if(isset($d1) && $d1=="1") {{"selected"}} @endif>1</option>
                                                <option value="2" @if(isset($d1) && $d1=="2") {{"selected"}} @endif>2</option>
                                                <option value="3" @if(isset($d1) && $d1=="3") {{"selected"}} @endif>3</option>
                                                <option value="4" @if(isset($d1) && $d1=="4") {{"selected"}} @endif>4</option>
                                                <option value="5" @if(isset($d1) && $d1=="5") {{"selected"}} @endif>5</option>
                                                <option value="6" @if(isset($d1) && $d1=="6") {{"selected"}} @endif>6</option>
                                                <option value="7" @if(isset($d1) && $d1=="7") {{"selected"}} @endif>7</option>
                                                <option value="8" @if(isset($d1) && $d1=="8") {{"selected"}} @endif>8</option>
                                                <option value="9" @if(isset($d1) && $d1=="9") {{"selected"}} @endif>9</option>
                                            </select>
                                        </div>
                                        <div class="col" style=" padding: 0; ">
                                            <select name="d2" id="select-reg-2" class="form-control form-control select2-no-search" required style=" font-size: 25px; height: 50px !important; ">
                                                <option value="0" @if(isset($d2) && $d2=="0") {{"selected"}} @endif>0</option>
                                                <option value="1" @if(isset($d2) && $d2=="1") {{"selected"}} @endif>1</option>
                                                <option value="2" @if(isset($d2) && $d2=="2") {{"selected"}} @endif>2</option>
                                                <option value="3" @if(isset($d2) && $d2=="3") {{"selected"}} @endif>3</option>
                                                <option value="4" @if(isset($d2) && $d2=="4") {{"selected"}} @endif>4</option>
                                                <option value="5" @if(isset($d2) && $d2=="5") {{"selected"}} @endif>5</option>
                                                <option value="6" @if(isset($d2) && $d2=="6") {{"selected"}} @endif>6</option>
                                                <option value="7" @if(isset($d2) && $d2=="7") {{"selected"}} @endif>7</option>
                                                <option value="8" @if(isset($d2) && $d2=="8") {{"selected"}} @endif>8</option>
                                                <option value="9" @if(isset($d2) && $d2=="9") {{"selected"}} @endif>9</option>
                                            </select>
                                        </div>
                                        <div class="col" style=" padding: 0; ">
                                            <select name="d3" id="select-reg-2" class="form-control form-control select2-no-search" required style=" font-size: 25px; height: 50px !important; ">
                                                <option value="0" @if(isset($d3) && $d3=="0") {{"selected"}} @endif>0</option>
                                                <option value="1" @if(isset($d3) && $d3=="1") {{"selected"}} @endif>1</option>
                                                <option value="2" @if(isset($d3) && $d3=="2") {{"selected"}} @endif>2</option>
                                                <option value="3" @if(isset($d3) && $d3=="3") {{"selected"}} @endif>3</option>
                                                <option value="4" @if(isset($d3) && $d3=="4") {{"selected"}} @endif>4</option>
                                                <option value="5" @if(isset($d3) && $d3=="5") {{"selected"}} @endif>5</option>
                                                <option value="6" @if(isset($d3) && $d3=="6") {{"selected"}} @endif>6</option>
                                                <option value="7" @if(isset($d3) && $d3=="7") {{"selected"}} @endif>7</option>
                                                <option value="8" @if(isset($d3) && $d3=="8") {{"selected"}} @endif>8</option>
                                                <option value="9" @if(isset($d3) && $d3=="9") {{"selected"}} @endif>9</option>
                                            </select>
                                        </div>
                                        <div class="col" style=" padding: 0; ">
                                            <select name="d4" id="select-reg-2" class="form-control form-control select2-no-search" required style=" font-size: 25px; height: 50px !important; ">
                                                <option value="0" @if(isset($d4) && $d4=="0") {{"selected"}} @endif>0</option>
                                                <option value="1" @if(isset($d4) && $d4=="1") {{"selected"}} @endif>1</option>
                                                <option value="2" @if(isset($d4) && $d4=="2") {{"selected"}} @endif>2</option>
                                                <option value="3" @if(isset($d4) && $d4=="3") {{"selected"}} @endif>3</option>
                                                <option value="4" @if(isset($d4) && $d4=="4") {{"selected"}} @endif>4</option>
                                                <option value="5" @if(isset($d4) && $d4=="5") {{"selected"}} @endif>5</option>
                                                <option value="6" @if(isset($d4) && $d4=="6") {{"selected"}} @endif>6</option>
                                                <option value="7" @if(isset($d4) && $d4=="7") {{"selected"}} @endif>7</option>
                                                <option value="8" @if(isset($d4) && $d4=="8") {{"selected"}} @endif>8</option>
                                                <option value="9" @if(isset($d4) && $d4=="9") {{"selected"}} @endif>9</option>
                                            </select>
                                        </div>
                                        <div class="col" style="padding: 0;">
                                            <button class="btn btn-outline-primary btn-block active" type="submit" style=" height: 50px;font-size: 25px;"><i class="ion-ios-search"></i></button>
                                        </div>
                                        <div class="col" style="padding: 0;">
                                            <a href="https://vrs.transdep.mn/burtgel/key"><button class="btn btn-outline-primary btn-block active" type="button" style="height: 50px;font-size: 25px;background-color: #445c70 !important;border: 1px solid #445c70 !important;"><i class="ion-ios-refresh"></i></button></a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="card-header tx-bold bd-0 tx-white bg-primary" style=" background: #0062cb !important; ">
                            시리즈
                        </div>
                        <div class="card card-body card-dashboard-twentyfive">
                            <div class="row flexcroll" id="seriesListDiv" style=" max-height: 550px; overflow-x: hidden; overflow-y: scroll; ">
                                <div class="col-lg-6 col-md-6 col-sm-12 series-list-top">
                                    <button class="btn btn-outline-primary btn-block @if(isset($seriesId) && $tmp_series_id==22) {{"active"}} @endif" onclick="javascript:getNumbers('{{ \App\Http\Controllers\BaseController::seriesIdEnc(22) }}');">울란바토르</button>
                                </div>
                                @if(isset($province))
                                    @foreach($province as $row)
                                        <div class="col-lg-6 col-md-6 col-sm-12 series-list-top">
                                            <button class="btn btn-outline-primary btn-block @if(isset($seriesId) && $tmp_series_id==$row->id) {{"active"}}  @endif" onclick="javascript:getNumbers('{{ \App\Http\Controllers\BaseController::seriesIdEnc($row->id) }}');">{{$row->name}}</button>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-12 col-sm-12">
                        <div class="card-header tx-bold bd-0 tx-white bg-primary" style=" background: #0062cb !important; ">
                            <span>가능한 번호</span>
                            <span class="headerIcon" style=" float: right; margin-left:10px; color:#ff0002;"><i class="icon ion-ios-radio-button-on"> 부여됨</i></span>
                            <span class="headerIcon" style=" float: right; margin-left:10px; color:#42ff14;"><i class="icon ion-ios-radio-button-on"> 주문됨</i></span>
                            <span class="headerIcon" style=" float: right; margin-left:10px; color:#ffdf00;"><i class="icon ion-ios-radio-button-on"> 대기 중</i></span>
                            <span class="headerIcon" style=" float: right; margin-left:10px; color:#fff;"><i class="icon ion-ios-radio-button-on"> 여유</i></span>
                        </div>
                        <div class="card card-body card-dashboard-twentyfive mg-b-20" style="width:100%;">
                            @if(!isset($seriesId) && isset($d1))
                                <div class="alert alert-outline-warning" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    <h3>주(도시)를 선택하세요!</h3>
                                </div>
                            @endif
                            <div class="row flexcroll" style="max-height: 608px; overflow-x: hidden; overflow-y: scroll; ">
                                <div class="col">
                                    <label class="az-content-label tx-base">월요일</label>
                                    <hr class="mg-y-5 line" >
                                    @if(isset($numbers))
                                        @foreach($numbers as $key => $row)
                                            @if(($row->weekend==1))
                                                <button type="button" class="btnNumber btn btn-outline-primary btn-block {{ $row->class }}" value="{{ $row->row_id }}">{{$row->name}}</button>
                                            @endif
                                        @endforeach
                                    @endif
                                </div>

                                <div class="col">
                                    <label class="az-content-label tx-base">화요일</label>
                                    <hr class="mg-y-5 line" >
                                    @if(isset($numbers))
                                        @foreach($numbers as $key => $row)
                                            @if(($row->weekend==2))
                                                <button type="button" class="btnNumber btn btn-outline-primary btn-block {{ $row->class }}" value="{{ $row->row_id }}">{{$row->name}}</button>
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                                <div class="col">
                                    <label class="az-content-label tx-base">수요일</label>
                                    <hr class="mg-y-5 line" >
                                    @if(isset($numbers))
                                        @foreach($numbers as $key => $row)
                                            @if($row->weekend==3)
                                                <button type="button" class="btnNumber btn btn-outline-primary btn-block {{ $row->class }}" value="{{ $row->row_id }}">{{$row->name}}</button>
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                                <div class="col">
                                    <label class="az-content-label tx-base">목요일</label>
                                    <hr class="mg-y-5 line" >
                                    @if(isset($numbers))
                                        @foreach($numbers as $key => $row)
                                            @if($row->weekend==4)
                                                <button type="button" class="btnNumber btn btn-outline-primary btn-block {{ $row->class }}" value="{{ $row->row_id }}">{{$row->name}}</button>
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                                <div class="col">
                                    <label class="az-content-label tx-base">금요일</label>
                                    <hr class="mg-y-5 line" >
                                    @if(isset($numbers))
                                        @foreach($numbers as $key => $row)
                                            @if($row->weekend==5)
                                                <button type="button" class="btnNumber btn btn-outline-primary btn-block {{ $row->class }}" value="{{ $row->row_id }}">{{$row->name}}</button>
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="series" name="series" value="@if(isset($seriesId)) {{$seriesId}} @endif">
                    </div>
                </div>
            </form>
        </div>
    </div>
    @include('Includes.footer')
</div>

<div id="orderModal" class="modal">
    <form action="" method="POST" accept-charset="UTF-8">
        {{ csrf_field() }}
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document" style=" max-width: 65%; ">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" style=" width: 100%; ">번호 주문 창</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" class="form-control" id="seriesNumberId" name="seriesNumberId">
                        <input type="hidden" class="form-control" id="seriesName" name="seriesName">
                        <input type="hidden" id="seriesModal" name="seriesModal" value="@if(isset($seriesId)) {{$seriesId}} @endif">
                        <div class="col-lg-12">
                            <center><h4><span style="color: #f61717;display: block;">Регистрийн болон арлын дугаар буруу оруулсан тохиолдолд 번호판 олгохгүй болохыг анхаарна уу!</span></h4></center>
                            <div class="row" style="margin-top: 15px;margin-bottom:15px;">
                                <div class="col-lg-1 mg-t-20 mg-lg-t-0">
                                </div>
                                <div class="col-lg-3 mg-t-20 mg-lg-t-0">
                                    <label class="rdiobox">
                                        <input id="person" name="registeroption" type="radio" checked value="person">
                                        <span>비율 хүн</span>
                                    </label>
                                </div><!-- col-3 -->
                                <div class="col-lg-3 mg-t-20 mg-lg-t-0">
                                    <label class="rdiobox">
                                        <input id="company" name="registeroption" type="radio" value="company">
                                        <span>기관</span>
                                    </label>
                                </div><!-- col-3 -->
                                <div class="col-lg-4 mg-t-20 mg-lg-t-0">
                                    <label class="rdiobox">
                                        <input id="foreign" name="registeroption" type="radio" value="foreign">
                                        <span>Гадаадын иргэн /Foreign citizen/</span>
                                    </label>
                                </div><!-- col-3 -->
                            </div>

                            <div class="row row-xs align-items-center mg-b-5" style=" margin-bottom: 15px !important; ">
                                <div class="col-lg-4 col-md-12 col-sm-12">
                                    <label class="form-label mg-b-0">주문 번호판</label>
                                </div>
                                <div class="col-lg-8 col-md-12 col-sm-12">
                                    <button id="orderNumberLbl" type="button" class="btn btn-primary btn-block" style=" background: #0062cb !important; "></button>
                                </div>
                            </div>
                            <div class="row row-xs align-items-center mg-b-5">
                                <div class="col-lg-4 col-md-12 col-sm-12">
                                    <label class="form-label mg-b-0 required-input">등록번호</label>
                                </div>
                                <div class="col-lg-8 col-md-12 col-sm-12">
                                    <div class="row">
                                        <div class="col-3 person" style="width: 100%;">
                                            <div class="row">
                                                <div class="col-6 person" style=" padding-right: 1px; padding-top: 1px; padding-bottom: 1px; ">
                                                    <select name="first" id="select-reg-1" class="form-control form-control select2-no-search person" required style=" font-size: 25px; height: 50px !important; ">
                                                        <option value="У">У</option>
                                                        <option value="А">А</option>
                                                        <option value="Б">Б</option>
                                                        <option value="В">В</option>
                                                        <option value="Г">Г</option>
                                                        <option value="Д">Д</option>
                                                        <option value="Е">Е</option>
                                                        <option value="Ё">Ё</option>
                                                        <option value="Ж">Ж</option>
                                                        <option value="З">З</option>
                                                        <option value="И">И</option>
                                                        <option value="Й">Й</option>
                                                        <option value="К">К</option>
                                                        <option value="Л">Л</option>
                                                        <option value="М">М</option>
                                                        <option value="Н">Н</option>
                                                        <option value="О">О</option>
                                                        <option value="Ө">Ө</option>
                                                        <option value="П">П</option>
                                                        <option value="Р">Р</option>
                                                        <option value="С">С</option>
                                                        <option value="Т">Т</option>
                                                        <option value="Ү">Ү</option>
                                                        <option value="Ф">Ф</option>
                                                        <option value="Х">Х</option>
                                                        <option value="Ч">Ч</option>
                                                        <option value="Ц">Ц</option>
                                                        <option value="Ш">Ш</option>
                                                        <option value="Щ">Щ</option>
                                                        <option value="Ъ">Ъ</option>
                                                        <option value="Ы">Ы</option>
                                                        <option value="Ь">Ь</option>
                                                        <option value="Э">Э</option>
                                                        <option value="Ю">Ю</option>
                                                        <option value="Я">Я</option>
                                                    </select>
                                                </div>
                                                <div class="col-6 person"  style=" padding-right: 1px; padding-top: 1px; padding-bottom: 1px; ">
                                                    <select name="second" id="select-reg-2" class="form-control form-control select2-no-search person" required style=" font-size: 25px; height: 50px !important; ">
                                                        <option value="А">А</option>
                                                        <option value="Б">Б</option>
                                                        <option value="В">В</option>
                                                        <option value="Г">Г</option>
                                                        <option value="Д">Д</option>
                                                        <option value="Е">Е</option>
                                                        <option value="Ё">Ё</option>
                                                        <option value="Ж">Ж</option>
                                                        <option value="З">З</option>
                                                        <option value="И">И</option>
                                                        <option value="Й">Й</option>
                                                        <option value="К">К</option>
                                                        <option value="Л">Л</option>
                                                        <option value="М">М</option>
                                                        <option value="Н">Н</option>
                                                        <option value="О">О</option>
                                                        <option value="Ө">Ө</option>
                                                        <option value="П">П</option>
                                                        <option value="Р">Р</option>
                                                        <option value="С">С</option>
                                                        <option value="Т">Т</option>
                                                        <option value="У">У</option>
                                                        <option value="Ү">Ү</option>
                                                        <option value="Ф">Ф</option>
                                                        <option value="Х">Х</option>
                                                        <option value="Ч">Ч</option>
                                                        <option value="Ц">Ц</option>
                                                        <option value="Ш">Ш</option>
                                                        <option value="Щ">Щ</option>
                                                        <option value="Ъ">Ъ</option>
                                                        <option value="Ы">Ы</option>
                                                        <option value="Ь">Ь</option>
                                                        <option value="Э">Э</option>
                                                        <option value="Ю">Ю</option>
                                                        <option value="Я">Я</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-9 company" style="width: 100%;">
                                            <div class="row" style=" margin-right: 0px; ">
                                                <div class="col" style=" padding-right: 1px; padding-top: 1px; padding-bottom: 1px; ">
                                                    <select name="r1" id="select-reg-2" class="form-control form-control select2-no-search" required style=" font-size: 25px; height: 50px !important; ">
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                        <option value="6">6</option>
                                                        <option value="7">7</option>
                                                        <option value="8">8</option>
                                                        <option value="9">9</option>
                                                    </select>
                                                </div>
                                                <div class="col" style=" padding: 1px; ">
                                                    <select name="r2" id="select-reg-2" class="form-control form-control select2-no-search" required style=" font-size: 25px; height: 50px !important; ">
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                        <option value="6">6</option>
                                                        <option value="7">7</option>
                                                        <option value="8">8</option>
                                                        <option value="9">9</option>
                                                    </select>
                                                </div>
                                                <div class="col" style=" padding: 1px; ">
                                                    <select name="r3" id="select-reg-2" class="form-control form-control select2-no-search" required style=" font-size: 25px; height: 50px !important; ">
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                        <option value="6">6</option>
                                                        <option value="7">7</option>
                                                        <option value="8">8</option>
                                                        <option value="9">9</option>
                                                    </select>
                                                </div>
                                                <div class="col" style=" padding: 1px; ">
                                                    <select name="r4" id="select-reg-2" class="form-control form-control select2-no-search" required style=" font-size: 25px; height: 50px !important; ">
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                        <option value="6">6</option>
                                                        <option value="7">7</option>
                                                        <option value="8">8</option>
                                                        <option value="9">9</option>
                                                    </select>
                                                </div>
                                                <div class="col" style=" padding: 1px; ">
                                                    <select name="r5" id="select-reg-2" class="form-control form-control select2-no-search" required style=" font-size: 25px; height: 50px !important; ">
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                        <option value="6">6</option>
                                                        <option value="7">7</option>
                                                        <option value="8">8</option>
                                                        <option value="9">9</option>
                                                    </select>
                                                </div>
                                                <div class="col" style=" padding: 1px; ">
                                                    <select name="r6" id="select-reg-2" class="form-control form-control select2-no-search" required style=" font-size: 25px; height: 50px !important; ">
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                        <option value="6">6</option>
                                                        <option value="7">7</option>
                                                        <option value="8">8</option>
                                                        <option value="9">9</option>
                                                    </select>
                                                </div>
                                                <div class="col" style=" padding: 1px; ">
                                                    <select name="r7" id="select-reg-2" class="form-control form-control select2-no-search" required style=" font-size: 25px; height: 50px !important; ">
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                        <option value="6">6</option>
                                                        <option value="7">7</option>
                                                        <option value="8">8</option>
                                                        <option value="9">9</option>
                                                    </select>
                                                </div>
                                                <div class="col" style=" padding: 1px; ">
                                                    <select name="r8" id="select-reg-2" class="form-control form-control select2-no-search person" required style=" font-size: 25px; height: 50px !important; ">
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                        <option value="6">6</option>
                                                        <option value="7">7</option>
                                                        <option value="8">8</option>
                                                        <option value="9">9</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 foreign">
                                            <div class="row">
                                                <div class="col-12">
                                                    <input class="form-control foreign" name="foreign" autocomplete="off" style="display:none;font-size: 25px; height: 50px !important; " value=""/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br/>
                            </div>

                            <div class="row row-xs align-items-center mg-b-5">
                                <div class="col-lg-4 col-md-12 col-sm-12">
                                    <label class="form-label required-input">차체번호ын сүүлийн 5 орон</label>
                                </div>
                                <div class="col-lg-8" style="width: 100%;">
                                    <div class="row" style=" margin-left: 0px;  margin-right: 0px; ">
                                        <div class="col" style=" padding: 4px 4px 4px 0px; ">
                                            <select name="a1" id="select-reg-2" class="form-control form-control select2-no-search" required style=" font-size: 25px; height: 50px !important; ">
                                                <option value="0">0</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="A">A</option>
                                                <option value="B">B</option>
                                                <option value="C">C</option>
                                                <option value="D">D</option>
                                                <option value="E">E</option>
                                                <option value="F">F</option>
                                                <option value="G">G</option>
                                                <option value="H">H</option>
                                                <option value="I">I</option>
                                                <option value="J">J</option>
                                                <option value="K">K</option>
                                                <option value="L">L</option>
                                                <option value="M">M</option>
                                                <option value="N">N</option>
                                                <option value="O">O</option>
                                                <option value="P">P</option>
                                                <option value="Q">Q</option>
                                                <option value="R">R</option>
                                                <option value="S">S</option>
                                                <option value="T">T</option>
                                                <option value="U">U</option>
                                                <option value="V">V</option>
                                                <option value="W">W</option>
                                                <option value="X">X</option>
                                                <option value="Y">Y</option>
                                                <option value="Z">Z</option>
                                            </select>
                                        </div>
                                        <div class="col" style=" padding: 4px; ">
                                            <select name="a2" id="select-reg-2" class="form-control form-control select2-no-search" required style=" font-size: 25px; height: 50px !important; ">
                                                <option value="0">0</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="A">A</option>
                                                <option value="B">B</option>
                                                <option value="C">C</option>
                                                <option value="D">D</option>
                                                <option value="E">E</option>
                                                <option value="F">F</option>
                                                <option value="G">G</option>
                                                <option value="H">H</option>
                                                <option value="I">I</option>
                                                <option value="J">J</option>
                                                <option value="K">K</option>
                                                <option value="L">L</option>
                                                <option value="M">M</option>
                                                <option value="N">N</option>
                                                <option value="O">O</option>
                                                <option value="P">P</option>
                                                <option value="Q">Q</option>
                                                <option value="R">R</option>
                                                <option value="S">S</option>
                                                <option value="T">T</option>
                                                <option value="U">U</option>
                                                <option value="V">V</option>
                                                <option value="W">W</option>
                                                <option value="X">X</option>
                                                <option value="Y">Y</option>
                                                <option value="Z">Z</option>
                                            </select>
                                        </div>
                                        <div class="col" style="padding: 4px;">
                                            <select name="a3" id="select-reg-2" class="form-control form-control select2-no-search" required style=" font-size: 25px; height: 50px !important; ">
                                                <option value="0">0</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="A">A</option>
                                                <option value="B">B</option>
                                                <option value="C">C</option>
                                                <option value="D">D</option>
                                                <option value="E">E</option>
                                                <option value="F">F</option>
                                                <option value="G">G</option>
                                                <option value="H">H</option>
                                                <option value="I">I</option>
                                                <option value="J">J</option>
                                                <option value="K">K</option>
                                                <option value="L">L</option>
                                                <option value="M">M</option>
                                                <option value="N">N</option>
                                                <option value="O">O</option>
                                                <option value="P">P</option>
                                                <option value="Q">Q</option>
                                                <option value="R">R</option>
                                                <option value="S">S</option>
                                                <option value="T">T</option>
                                                <option value="U">U</option>
                                                <option value="V">V</option>
                                                <option value="W">W</option>
                                                <option value="X">X</option>
                                                <option value="Y">Y</option>
                                                <option value="Z">Z</option>
                                            </select>
                                        </div>
                                        <div class="col" style="padding: 4px;">
                                            <select name="a4" id="select-reg-2" class="form-control form-control select2-no-search" required style=" font-size: 25px; height: 50px !important; ">
                                                <option value="0">0</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="A">A</option>
                                                <option value="B">B</option>
                                                <option value="C">C</option>
                                                <option value="D">D</option>
                                                <option value="E">E</option>
                                                <option value="F">F</option>
                                                <option value="G">G</option>
                                                <option value="H">H</option>
                                                <option value="I">I</option>
                                                <option value="J">J</option>
                                                <option value="K">K</option>
                                                <option value="L">L</option>
                                                <option value="M">M</option>
                                                <option value="N">N</option>
                                                <option value="O">O</option>
                                                <option value="P">P</option>
                                                <option value="Q">Q</option>
                                                <option value="R">R</option>
                                                <option value="S">S</option>
                                                <option value="T">T</option>
                                                <option value="U">U</option>
                                                <option value="V">V</option>
                                                <option value="W">W</option>
                                                <option value="X">X</option>
                                                <option value="Y">Y</option>
                                                <option value="Z">Z</option>
                                            </select>
                                        </div>
                                        <div class="col" style="padding: 4px 0px 4px 4px;">
                                            <select name="a5" id="select-reg-2" class="form-control form-control select2-no-search" required style=" font-size: 25px; height: 50px !important; ">
                                                <option value="0">0</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="A">A</option>
                                                <option value="B">B</option>
                                                <option value="C">C</option>
                                                <option value="D">D</option>
                                                <option value="E">E</option>
                                                <option value="F">F</option>
                                                <option value="G">G</option>
                                                <option value="H">H</option>
                                                <option value="I">I</option>
                                                <option value="J">J</option>
                                                <option value="K">K</option>
                                                <option value="L">L</option>
                                                <option value="M">M</option>
                                                <option value="N">N</option>
                                                <option value="O">O</option>
                                                <option value="P">P</option>
                                                <option value="Q">Q</option>
                                                <option value="R">R</option>
                                                <option value="S">S</option>
                                                <option value="T">T</option>
                                                <option value="U">U</option>
                                                <option value="V">V</option>
                                                <option value="W">W</option>
                                                <option value="X">X</option>
                                                <option value="Y">Y</option>
                                                <option value="Z">Z</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-xs align-items-center mg-b-5">
                                <div class="col-lg-4 col-md-12 col-sm-12">
                                    <label class="form-label required-input">Баталгаажуулах код</label>
                                </div>
                                <div class="col-lg-8 col-md-12 col-sm-12">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-12 col-sm-12">
                                            <label class="form-label" style="height: 50px !important;"> {{ captcha_img('math') }}</label>
                                        </div>
                                        <div class="col-lg-4 col-md-12 col-sm-12">
                                            <input id="valid" type="text" class="form-control keyboard" placeholder="검정иуг бич" required autocomplete="off" style=" font-size: 25px; height: 50px !important; " name="captcha">
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-2">
                                            <select id="calRow"  onchange="concat(this.value, '')" class="form-control form-control select2-no-search" style=" font-size: 25px; height: 50px !important; ">
                                                <option value="0">0</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-2 col-md-12 col-sm-12">
                                            <button type="button" onclick="concat(0, 'clear')" class="btn btn-primary btn-block btnnopadding" style=" font-size: 25px; height: 50px !important; "><i class="fas fa-backspace"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" style="justify-content: center">
                        <button type="submit" class="btn btn-primary col-md-4" style="font-size: 24px; min-width: 80px !important;;background: #0062cb !important; ">주문</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<div id="document" class="modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title" id="titileDiv"></h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="info_body" style="text-align: center">
            </div>
            <div class="modal-footer" style="text-align: center;">
                <button type="button" class="btn btn-primary" data-dismiss="modal">닫기</button>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('lib/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('lib/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('lib/jQuery-Mask-Plugin-master/src/jquery.mask.js') }}"></script>
<script src="{{ asset('js/vrs.js') }}"></script>
<script src="{{ asset('js/avtoteever.js') }}"></script>
<script>function getNumbers(n){$("#series").val(n),$("#seriesForm").submit()}function concat(n,e){"clear"==e?$("#valid").val(""):$("#valid").val($("#valid").val()+n);$("#calRow").val("");}$(document).ready(function(){"use strict";$(".btnNumber").click(function(){var n=$(this).val(),e=$(this).text();$("#orderModal").modal(),$("#seriesNumberId").val(n),$("#orderNumberLbl").text(e)}),$("#company").click(function(){$(".company").fadeIn(),$(".person").css("display","none"),$(".foreign").css("display","none")}),$("#person").click(function(){$(".person").fadeIn(),$(".company").css("display","block"),$(".foreign").css("display","none")}),$("#foreign").click(function(){$(".foreign").fadeIn(),$(".person").css("display","none"),$(".company").css("display","none")})});</script>
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-144549056-1"></script>
<script>window.dataLayer = window.dataLayer || []; function gtag() {dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'UA-144549056-1'); @if(ISSET($message)) var type = "{{ $message['type'] }}"; var color = ""; var title = ""; if (type == "info") {color = "red"; title = "Захиалга ам년тгүй боллоо!";} else if (type == "warning") {color = "red";title = "Захиалгын мэдээлэл ам년тгүй боллоо!";} else if (type == "success") { color = "green"; title = "Таны захиалга ам년ттай хийгдлээ!"; }$("#titileDiv").text(title);$("#info_body").html('<div style="font-size:24px;color:' + color + '">{!! $message['message'] !!}</div>'); $("#document").modal("show");@endif</script>
</body>
</html>