<!DOCTYPE html>
<html lang="en">
<head>
    @include('Includes.head')
    <link href="{{ asset('css/vrstouch.css') }}" rel="stylesheet">
    <style>
        .az-content-dashboard-ten .card {
            margin: 0px !important;
        }
        .ordered_number{
            pointer-events: none;
            color: #42ff14;
            border: 1px solid #42ff14;
        }
        .ordered_pending{
            pointer-events: none;
            color: #ffdf00;
            border: 1px solid #ffb900;
        }
        .given_number{
            pointer-events: none;
            color: #ff0002;
            border: 1px solid #ff0002;
        }
        .alert-outline-success
        {
            border-color: #0062cb;
            color: #0062cb;
            font-size: 18px;
        }

        @media only screen and (max-width: 1100px) {
            .modal-dialog
            {
                max-width:95% !important;
                width: 95% !important;
            }
            .form-control
            {
                padding: 0px 0px;
                font-size: 18px !important;
            }
        }


        @media only screen and (max-width: 700px) {
            .modal-dialog
            {
                max-width:95% !important;
                width: 95% !important;
            }
            .form-control
            {
                padding: 0px 0px;
                font-size: 12px !important;
            }
            .headerIcon
            {
                margin-top: 2px;
                font-size: 10px !important;
            }
        }

        @media only screen and (max-width: 450px) {
            .modal-dialog
            {
                max-width:95% !important;
                width: 95% !important;
            }
            .form-control
            {
                padding: 0px 0px;
                width: 200%;
                font-size: 15px !important;
            }
            .headerIcon
            {
                margin-top: 8px;
                font-size: 5px !important;
            }
        }
        @media only screen and (max-width: 350px) {
            .headerIcon
            {
                display: none;
            }
        }
    </style>
</head>
<body class="az-body flexcroll" oncontextmenu="return false">
<div class="az-iconbar az-iconbar-primary">
    <a href="/burtgel/key" class="az-iconbar-logo"><img src="{{ asset('img/logo.png') }}" width="45px" /></a>
</div>
<div class="az-iconbar-aside az-iconbar-aside-primary">
</div>
<div class="az-content az-content-dashboard-ten">

    <div class="az-content-body">
        <div class="az-content-body-left">
            <form id="seriesForm" action="" method="POST">
                {{ csrf_field() }}
                <div class="row row-sm mg-b-20">
                    <div class="col-lg-4 col-md-12 col-sm-12">
                        <div class="card-header tx-medium bd-0 tx-white bg-primary" style=" background: #0062cb !important; ">
                            검색
                        </div>
                        <div class="card card-body card-dashboard-twentyfive mg-b-20">
                            <div class="row flexcroll" style=" max-height: 550px; overflow-x: hidden; overflow-y: scroll; ">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="row">
                                        <div class="col" style=" padding: 0; ">
                                            <select name="d1" id="select-reg-2" class="form-control form-control select2-no-search" required style=" font-size: 25px; height: 50px !important; ">
                                            <!--<option value="*" @if(isset($d1) && $d1=="*") {{"selected"}} @endif>*</option>-->
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
                                            <!--<option value="*" @if(isset($d2) && $d2=="*") {{"selected"}} @endif>*</option>-->
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
                                            <!--<option value="*" @if(isset($d3) && $d3=="*") {{"selected"}} @endif>*</option>-->
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
                                            <!--<option value="*" @if(isset($d4) && $d4=="*") {{"selected"}} @endif>*</option>-->
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

                        <div class="card-header tx-medium bd-0 tx-white bg-primary" style=" background: #0062cb !important; ">
                            시리즈
                        </div>
                        <div class="card card-body card-dashboard-twentyfive mg-b-20">
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
                        <div class="card-header tx-medium bd-0 tx-white bg-primary" style=" background: #0062cb !important; ">
                            <span>가능한 번호</span>
                            <span class="headerIcon" style=" float: right; margin-left:10px; color:#ffdf00;"><i class="icon ion-ios-radio-button-on"> 대기 중</i></span>
                            <span class="headerIcon" style=" float: right; margin-left:10px; color:#42ff14;"><i class="icon ion-ios-radio-button-on"> 주문됨</i></span>
                            <span class="headerIcon" style=" float: right; margin-left:10px; color:#ff0002;"><i class="icon ion-ios-radio-button-on"> 부여됨</i></span>
                            <span class="headerIcon" style=" float: right; margin-left:10px; color:#fff;"><i class="icon ion-ios-radio-button-on"> 여유</i></span>
                        </div>
                        <div class="card card-body card-dashboard-twentyfive mg-b-20" style="width:100%;">
                            @if(!isset($seriesId) && isset($d1))
                                <div class="alert alert-outline-warning" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    주(도시)를 선택하세요!
                                </div>
                            @endif

                            <div class="row flexcroll" style=" max-height: 608px; overflow-x: hidden; overflow-y: scroll; ">
                                <div class="col">
                                    <label class="az-content-label tx-base">월요일</label>
                                    <hr class="mg-y-5 line" >
                                    <?php $count=0; ?>
                                    @if(isset($numbers))
                                        <?php $number = $numbers; ?>
                                        @foreach($number as $row)
                                            <?php
                                            $enc = "";
                                            if($row->show_date == null){
                                                $enc = \App\Http\Controllers\BaseController::enc("'".\Carbon\Carbon::now()->addDay(-1)."'");
                                            } else {
                                                $enc = $row->show_date;
                                            }
                                            $nowTime=date("Y-m-d H:i:s");
                                            $timediff = strtotime($nowTime) - strtotime(\App\Http\Controllers\BaseController::dec($enc));
                                            $day = (int)mb_substr($row->name, 3, 1); if(($day==1 || $day==6) && $count<$limitPerDay) { ?>
                                            <button type="button" class="btnNumber btn btn-outline-primary btn-block <?php if($row->is_order==1) echo " ordered_number ";  if($timediff<0) echo " ordered_pending "; if($row->is_given==1) echo " given_number ";?>" value="<?php if($row->is_order!=1 && $timediff>0 && $row->is_given != 1 ) echo \App\Http\Controllers\BaseController::enc($row->id); ?>" style="<?php if($timediff<0 && (isset($searchNumber) && $searchNumber=="000")) echo "display:none;"; ?>">{{$row->name}}</button>
                                            <?php $count++ ;} ?>
                                        @endforeach
                                    @endif
                                </div>

                                <div class="col">
                                    <label class="az-content-label tx-base">화요일</label>
                                    <hr class="mg-y-5 line" >
                                    <?php $count=0; ?>
                                    @if(isset($numbers))
                                        <?php $number = $numbers; ?>
                                        @foreach($number as $row)
                                            <?php
                                            $enc = "";
                                            if($row->show_date == null){
                                                $enc = \App\Http\Controllers\BaseController::enc("'".\Carbon\Carbon::now()->addDay(-1)."'");
                                            } else {
                                                $enc = $row->show_date;
                                            }
                                            $nowTime=date("Y-m-d H:i:s");
                                            $timediff = strtotime($nowTime) - strtotime(\App\Http\Controllers\BaseController::dec($enc));
                                            $day = (int)mb_substr($row->name, 3, 1); if(($day==2 || $day==7) && $count<$limitPerDay) { ?>
                                            <button type="button" class="btnNumber btn btn-outline-primary btn-block <?php if($row->is_order==1) echo " ordered_number ";  if($timediff<0) echo " ordered_pending "; if($row->is_given==1) echo " given_number ";?>" value="<?php if($row->is_order!=1 && $timediff>0 && $row->is_given != 1 ) echo \App\Http\Controllers\BaseController::enc($row->id); ?>" style="<?php if($timediff<0 && (isset($searchNumber) && $searchNumber=="000")) echo "display:none;"; ?>">{{$row->name}}</button>
                                            <?php $count++ ;} ?>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="col">
                                    <label class="az-content-label tx-base">수요일</label>
                                    <hr class="mg-y-5 line" >
                                    <?php $count=0; ?>
                                    @if(isset($numbers))
                                        <?php $number = $numbers; ?>
                                        @foreach($number as $row)
                                            <?php
                                            $enc = "";
                                            if($row->show_date == null){
                                                $enc = \App\Http\Controllers\BaseController::enc("'".\Carbon\Carbon::now()->addDay(-1)."'");
                                            } else {
                                                $enc = $row->show_date;
                                            }
                                            $nowTime=date("Y-m-d H:i:s");
                                            $timediff = strtotime($nowTime) - strtotime(\App\Http\Controllers\BaseController::dec($enc));
                                            $day = (int)mb_substr($row->name, 3, 1); if(($day==3 || $day==8) && $count<$limitPerDay) { ?>
                                            <button type="button" class="btnNumber btn btn-outline-primary btn-block <?php if($row->is_order==1) echo " ordered_number ";  if($timediff<0) echo " ordered_pending "; if($row->is_given==1) echo " given_number ";?>" value="<?php if($row->is_order!=1 && $timediff>0 && $row->is_given != 1 ) echo \App\Http\Controllers\BaseController::enc($row->id); ?>" style="<?php if($timediff<0 && (isset($searchNumber) && $searchNumber=="000")) echo "display:none;"; ?>">{{$row->name}}</button>
                                            <?php $count++ ;} ?>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="col">
                                    <label class="az-content-label tx-base">목요일</label>
                                    <hr class="mg-y-5 line" >
                                    <?php $count=0; ?>
                                    @if(isset($numbers))
                                        <?php $number = $numbers; ?>
                                        @foreach($numbers as $row)
                                            <?php
                                            $enc = "";
                                            if($row->show_date == null){
                                                $enc = \App\Http\Controllers\BaseController::enc("'".\Carbon\Carbon::now()->addDay(-1)."'");
                                            } else {
                                                $enc = $row->show_date;
                                            }
                                            $nowTime=date("Y-m-d H:i:s");
                                            $timediff = strtotime($nowTime) - strtotime(\App\Http\Controllers\BaseController::dec($enc));
                                            $day = (int)mb_substr($row->name, 3, 1); if(($day==4 || $day==9) && $count<$limitPerDay) { ?>
                                            <button type="button" class="btnNumber btn btn-outline-primary btn-block <?php if($row->is_order==1) echo " ordered_number ";  if($timediff<0) echo " ordered_pending "; if($row->is_given==1) echo " given_number ";?>" value="<?php if($row->is_order!=1 && $timediff>0 && $row->is_given != 1 ) echo \App\Http\Controllers\BaseController::enc($row->id); ?>" style="<?php if($timediff<0 && (isset($searchNumber) && $searchNumber=="000")) echo "display:none;"; ?>">{{$row->name}}</button>
                                            <?php $count++ ;} ?>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="col">
                                    <label class="az-content-label tx-base">금요일</label>
                                    <hr class="mg-y-5 line" >
                                    <?php $count=0; ?>
                                    @if(isset($numbers))
                                        <?php $number = $numbers; ?>
                                        @foreach($number as $row)
                                            <?php
                                            $enc = "";
                                            if($row->show_date == null){
                                                $enc = \App\Http\Controllers\BaseController::enc("'".\Carbon\Carbon::now()->addDay(-1)."'");
                                            } else {
                                                $enc = $row->show_date;
                                            }
                                            $nowTime=date("Y-m-d H:i:s");
                                            $timediff = strtotime($nowTime) - strtotime(\App\Http\Controllers\BaseController::dec($enc));
                                            $day = (int)mb_substr($row->name, 3, 1); if(($day==5 || $day==0) && $count<$limitPerDay) { ?>
                                            <button type="button" class="btnNumber btn btn-outline-primary btn-block <?php if($row->is_order==1) echo " ordered_number ";  if($timediff<0) echo " ordered_pending "; if($row->is_given==1) echo " given_number ";?>" value="<?php if($row->is_order!=1 && $timediff>0 && $row->is_given != 1 ) echo \App\Http\Controllers\BaseController::enc($row->id); ?>" style="<?php if($timediff<0 && (isset($searchNumber) && $searchNumber=="000")) echo "display:none;"; ?>">{{$row->name}}</button>
                                            <?php $count++ ;} ?>
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
    <form action="" method="POST">
        {{ csrf_field() }}
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document" style=" max-width: 65%; ">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" style=" width: 100%; ">번호 주문 창
                        <center><span style="font-size: 14px; color: #f61717; display: block;"> * Регистрийн болон арлын дугаар буруу оруулсан тохиолдолд 번호판 олгохгүй болохыг анхаарна уу!</span></center>
                    </h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" class="form-control" id="seriesNumberId" name="seriesNumberId">
                        <input type="hidden" id="seriesModal" name="seriesModal" value="@if(isset($seriesId)) {{$seriesId}} @endif">
                        <div class="col-lg-12">
                            <div class="row" style="margin-bottom:15px;">
                                <div class="col-lg-2 mg-t-20 mg-lg-t-0">
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
                                <div class="col-lg-5 col-md-8 col-sm-8">
                                    <label class="form-label mg-b-0">주문 дугаар</label>
                                </div>
                                <div class="col-lg-7 col-md-8 col-sm-8">
                                    <button id="orderNumberLbl" type="button" class="btn btn-primary btn-block" style=" background: #0062cb !important; "></button>
                                </div>
                            </div>
                            <div class="row row-xs align-items-center mg-b-5">
                                <div class="col-lg-5 col-md-4 col-sm-4">
                                    <label id="reg_title" class="form-label mg-b-0 required-input">등록번호</label>
                                </div>
                                <div class="col-lg-7 col-md-8 col-sm-8">
                                    <div class="row">
                                        <div class="col-12 keyboard">
                                            <input name="keyboard" id="keyboard" required class="form-control" oninput="translate2MGL(this.value)" autocomplete="off" style=" font-size: 25px; height: 50px !important; " value=""/>
                                        </div>
                                    </div>
                                </div>
                                <br/>
                            </div>

                            <div class="row row-xs align-items-center mg-b-5">
                                <div class="col-lg-5 col-md-8 col-sm-8">
                                    <label class="form-label mg-b-0 required-input">차체번호ын сүүлийн 5 орон</label>
                                </div>
                                <div class="col-lg-7 col-md-8 col-sm-8">
                                    <div class="row">
                                        <div class="col-12 keyboard">
                                            <input name="aralNo" id="aralNo" class="form-control" required autocomplete="off" style=" font-size: 25px; height: 50px !important; " value=""/>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row row-xs align-items-center mg-b-5">
                                <div class="col-lg-5 col-md-4 col-sm-4">
                                    <label class="form-label mg-b-0 required-input">Баталгаажуулах код</label>
                                </div>
                                <div class="col-lg-7 col-md-8 col-sm-8">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <label class="form-label mg-b-0" style="height: 50px !important; "> {{ captcha_img('math') }}</label>
                                        </div>
                                        <div class="col-lg-4 col-md-8 col-sm-8">
                                            <input id="valid" type="number" placeholder="검정иу бичих" class="form-control keyboard" required autocomplete="off" style=" font-size: 25px; height: 50px !important; " name="captcha">
                                        </div>

                                        <div class="col-lg-2 col-md-2 col-sm-2">
                                            <select onchange="concat(this.value, '')" class="form-control form-control select2-no-search" style=" font-size: 25px; height: 50px !important; ">
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

                                        <div class="col-lg-2 col-md-2 col-sm-2">
                                            <button type="button" onclick="concat(0, 'clear')" class="btn btn-primary btn-block btnnopadding" style=" font-size: 25px; height: 50px !important; "><i class="fas fa-backspace"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" style=" background: #0062cb !important; ">주문</button>
                        <button type="button" class="btn btn-outline-light" data-dismiss="modal">닫기</button>
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
                <h6 class="modal-title">알림</h6>
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
<script src="{{ asset('lib/ionicons/ionicons.js') }}"></script>
<script src="{{ asset('lib/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('lib/jQuery-Mask-Plugin-master/src/jquery.mask.js') }}"></script>
<script src="{{ asset('js/vrs.js') }}"></script>
<script src="{{ asset('js/avtoteever.js') }}"></script>

<script>
    $(document).ready(function(){
        'use strict';
        $( ".btnNumber" ).click(function() {
            var numberId = $( this ).val();
            var numberText = $( this ).text();
            $( "#orderModal" ).modal();
            $( "#seriesNumberId" ).val(numberId);
            $( "#orderNumberLbl" ).text(numberText);
        });

        $("#aralNo").on("keypress keyup",function (event) {
            this.value = this.value.toUpperCase();
            limitText(this, 5)
            //$(this).val($(this).val().replace(/[^\d].+/, ""));
            if ((event.which < 48 || event.which > 57)) {
                // event.preventDefault();
            }
        });

        $( "#company" ).click(function() {
            $("#reg_title").text("등록번호");
            $("#reg_title").addClass("required-input");
            $('#keyboard').on('keyup', function() {
                limitText(this, 7)
            });
        });

        $( "#person" ).click(function() {
            $("#reg_title").text("등록번호");
            $("#reg_title").addClass("required-input");
            $('#keyboard').on('keyup', function() {
                limitText(this, 10)
            });
        });

        $( "#foreign" ).click(function() {
            $("#reg_title").text("Паспортын дугаар /Passport number/");
            $("#reg_title").addClass("required-input");
            $('#keyboard').on('keyup', function() {
                limitText(this, 10)
            });
        });

        $('#keyboard').keyup(function(){
            this.value = this.value.toUpperCase();
        });
        $('#keyboard').on('keyup', function() {
            limitText(this, 11)
        });

        $('.number').mask('SSSSSSSS', {'translation': {
            S: {pattern: /[0-9]/}
        }
        });

        @if(ISSET($message))
            var type = "{{ $message['type'] }}";
            var color = "";
            if(type == "info"){
                color = "red";
            } else if(type == "warning"){
                color = "red";
            } else if(type == "success"){
                color = "green";
            }
            $("#info_body").html('<div style="font-size:24px;color:'+color+'">{!! $message['message'] !!}</div>');
            $("#document").modal("show");
        @endif
    });

    function limitText(field, maxChar){
        var ref = $(field),
            val = ref.val();
        if ( val.length >= maxChar ){
            ref.val(function() {
                return val.substr(0, maxChar);
            });
        }
    }
    function getNumbers(id)
    {
        $("#series").val(id);
        $("#seriesForm").submit();
    }

    var Lat2Cyr = {
        "a": "Й",
        "b": "М",
        "c": "Ё",
        "d": "Б",
        "e": "У",
        "f": "Ө",
        "g": "А",
        "h": "Х",
        "i": "Ш",
        "j": "Р",
        "k": "О",
        "l": "Л",
        "m": "Т",
        "n": "И",
        "o": "О",
        "p": "З",
        "q": "Ф",
        "r": "Ж",
        "s": "Ы",
        "t": "Э",
        "u": "Г",
        "v": "С",
        "w": "Ц",
        "x": "Ч",
        "y": "Н",
        "z": "Я",
        "-": "Е",
        "[": "К",
        ".": "В",
        ";": "Д",
        "'": "П",

        "A": "Й",
        "B": "М",
        "C": "Ё",
        "D": "Б",
        "E": "У",
        "F": "Ө",
        "G": "А",
        "H": "Х",
        "I": "Ш",
        "J": "Р",
        "K": "О",
        "L": "Л",
        "M": "Т",
        "N": "И",
        "O": "Ү",
        "P": "З",
        "Q": "Ф",
        "R": "Ж",
        "S": "Ы",
        "T": "Э",
        "U": "Г",
        "V": "С",
        "W": "Ц",
        "X": "Ч",
        "Y": "Н",
        "Z": "Я",
    };

    function translate2MGL(word){
        if(word){
            word = word.toUpperCase();
        }
        word =  word.split('').map(function (char) {
            return Lat2Cyr[char] || char;
        }).join("");
        $("#keyboard").val(word);
    }

    function concat($num, $type){
        if($type == "clear"){
            $("#valid").val("");
        } else {
            $("#valid").val($("#valid").val()+$num);
        }
    }
</script>
</body>
</html>