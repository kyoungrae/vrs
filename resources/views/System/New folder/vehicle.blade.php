<!DOCTYPE html>
<html lang="en">
<head>
    @include('Includes.head')
    <style>
        #button .dx-button-content {
  padding: 0;
}
.dx-form-group-caption {
    font-size: 16px;
}
.form-avatar {
  height: 80px;
  width: 80px;
  margin-right: 10px;
  border: 1px solid #d2d3d5;
  /* border-radius: 50%; */
  /* background-image: url('https://e-transport.mn/pg/user_data/pic/605_201912311116387906.jpg'); */
  background-size: contain;
  background-repeat: no-repeat;
  background-position: center;
}
.long-title h3 {
  font-family: 'Segoe UI Light', 'Helvetica Neue Light', 'Segoe UI', 'Helvetica Neue', 'Trebuchet MS', Verdana;
  font-weight: 200;
  font-size: 28px;
  text-align: center;
  margin-bottom: 20px;
}
#button .button-indicator {
  height: 32px;
  width: 32px;
  display: inline-block;
  vertical-align: middle;
  margin-right: 5px;
}

.indicators {
  display: flex;
  align-items: center;
}

        .modal-title {
            font-weight:600;
            color:#0062cb !important;
        }
        .torguuliList
        {
            padding-right: 15px;
            font-size: 12px;
        }
        .print-body{
            background-repeat:no-repeat;
            height: 440px;
            width: 1000px;
            font-size: 14px;
        }
        .az-content-dashboard-ten .az-content-body-right {

            display: block !important;
            width: 100%;
        }

        .card-dashboard-twentysix.card-dark-one .card-body h6 span, .card-dashboard-twentysix.card-dark-two .card-body h6 span {
            color: #FFF;
            font-size: 28px;
        }
        .card-dashboard-twentysix .card-header {
            padding: 10px 15px 0px !important;
        }
        .readMoreTorguuli
        {
            cursor: pointer;
            font-size: 15px !important;
        }
        .card {
            border: 0px !important;
        }
        .moreService
        {
            height: auto !important; width: 100% !important; overflow-y: hidden !important;
        }
        .avtoteeverPreloader1 {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url("/img/preloader.gif") center no-repeat #fff;
        }
        /********************  Preloader Demo-14 *******************/
        .loader14{	position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: #fff}
        .loader14 .loader-inner{width:60px;height:60px;position:relative;margin:0 auto}
        .loader14 .loader-inner div{content:"" ;width:16px;height:16px;border-radius:50%;background:#00bee0;position:absolute;top:10px;left:10px;transform-origin:20px 20px;-webkit-animation:loading-14 2s infinite cubic-bezier(.5,0,.5,1);animation:loading-14 2s infinite cubic-bezier(.5,0,.5,1)}
        .loader14 .loader-inner .box-2{top:10px;left:auto;right:10px;transform-origin:-4px 20px;-webkit-animation:loading-142 2s infinite cubic-bezier(.5,0,.5,1);animation:loading-142 2s infinite cubic-bezier(.5,0,.5,1)}
        .loader14 .loader-inner .box-3{top:auto;left:auto;right:10px;bottom:10px;transform-origin:-4px -4px;-webkit-animation:loading-143 2s infinite cubic-bezier(.5,0,.5,1);animation:loading-143 2s infinite cubic-bezier(.5,0,.5,1)}
        .loader14 .loader-inner .box-4{top:auto;bottom:10px;transform-origin:20px -4px;-webkit-animation:loading-144 2s infinite cubic-bezier(.5,0,.5,1);animation:loading-144 2s infinite cubic-bezier(.5,0,.5,1)}
        .loader14 .text{display:block;font-size:18px;color:#00bee0;text-align:center}
        @-webkit-keyframes loading-14{
            0%{transform:rotate(90deg)}
            50%{transform:rotate(180deg)}
            75%{transform:rotate(270deg)}
            100%{transform:rotate(360deg)}
        }
        @keyframes loading-14{
            0%{transform:rotate(90deg)}
            50%{transform:rotate(180deg)}
            75%{transform:rotate(270deg)}
            100%{transform:rotate(360deg)}
        }
        @-webkit-keyframes loading-142{
            0%,25%{transform:rotate(90deg)}
            25%{transform:rotate(180deg)}
            75%{transform:rotate(270deg)}
            100%{transform:rotate(360deg)}
        }
        @keyframes loading-142{
            0%,25%{transform:rotate(90deg)}
            25%{transform:rotate(180deg)}
            75%{transform:rotate(270deg)}
            100%{transform:rotate(360deg)}
        }
        @-webkit-keyframes loading-143{
            0%,25%{transform:rotate(90deg)}
            50%{transform:rotate(270deg)}
            100%{transform:rotate(360deg)}
        }
        @keyframes loading-143{
            0%,25%{transform:rotate(90deg)}
            50%{transform:rotate(270deg)}
            100%{transform:rotate(360deg)}
        }
        @-webkit-keyframes loading-144{
            0%,25%{transform:rotate(90deg)}
            50%{transform:rotate(180deg)}
            100%,75%{transform:rotate(360deg)}
        }
        @keyframes loading-144{
            0%,25%{transform:rotate(90deg)}
            50%{transform:rotate(180deg)}
            100%,75%{transform:rotate(360deg)}
        }
    </style>
</head>
<body class="az-body flexcroll">

<div class="avtoteeverPreloader"></div>
{{-- <div style="display: none; text-align" class="avtoteeverPreloader1">hfhdhdhdfhfdhfdhdhdfhdfhdfhdfhdf</div> --}}
<div class="loader14" style="display:none">
    <div class="loader-inner" style="    margin-top: 253px;">
        <div class="box-1"></div>
        <div class="box-2"></div>
        <div class="box-3"></div>
        <div class="box-4"></div>
    </div>
    <span class="text">잠시만 기다려 주세요....</span>
</div>
<div class="az-iconbar az-iconbar-primary">
    @include('Includes.menu')
</div>
<div class="az-iconbar-aside az-iconbar-aside-primary">
    @include('Includes.menulist')
</div>
<div class="az-content az-content-dashboard-ten">
    <div class="az-header">
        @include('Includes.top')
    </div>
    <div class="az-content-body">
        <div class="card card-body card-dashboard-twentyfive" style="padding: 15px 15px 5px 15px;">
            <div class="row row-sm">
                <!--왼쪽 영역 시작-->
                <div class="col-lg-9 col-md-6 col-sm-12">
                    <h6 class="card-title">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                운송수단 등록
                            </div>

                            @if(session()->get("auth")->isatvt == 1 || session()->get("auth")->iscity == 1 )
                                <div id="headerButton" class="col-lg-6 col-md-6 col-sm-12 rightAlign">
                                    <a href="{{ url('/report/form') }}" target="_blank">
                                        <span class="headerButton"><i class="icon ion-ios-list-box headerButtonIcon"></i> 서식</span>
                                    </a>
                                    <a href="#printModal" data-toggle="modal" data-effect="effect-scale">
                                        <span id="btnPrint" class="headerButton"><i class="icon ion-ios-print headerButtonIcon"></i> 인쇄</span>
                                    </a>
                                    <a href="#printModalNEW" data-toggle="modal" data-effect="effect-scale">
                                        <span id="btnPrintNEW" class="headerButton"><i class="icon ion-ios-print headerButtonIcon"></i> 신규 인쇄</span>
                                    </a>
                                    <a onclick="submitForm()">
                                        <span class="headerButton"><i class="icon ion-ios-save headerButtonIcon"></i> 저장</span>
                                    </a>
                                    <a onclick="cancel_selected_menu();">
                                        <span id="btnCancel" class="headerButton"><i class="icon ion-ios-exit headerButtonIcon"></i> 취소</span>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </h6>

                    @if(ISSET($message) || session()->has("message"))
                        @include("System.message")
                    @endif

                    @if(ISSET($vehicle))
                        @if(ISSET($vehicle_count))
                            @if($vehicle_count > 1)
                                <div class="alert alert-outline-danger" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    <h5>{{ $vehicle->plate_no }} 번호판이 {{ $vehicle_count }}대의 차량에 부여되었습니다. 중복을 해소한 뒤 서비스를 진행하세요.</h5>
                                </div>
                            @endif
                        @endif
                        @if($vehicle->is_cert_revoke == 1)
                            <div class="alert alert-outline-danger" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                <h5>{{ $vehicle->plate_no }} 번호판 차량은 증명서가 압수된 표시가 있습니다.</h5>
                            </div>
                        @endif
                      
                        @if($vehicle->rft_is_active == 0 ||  $vehicle->rft_is_active == '0' || $vehicle->rft_is_active == null)
                        <div class="alert alert-outline-danger" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            <h5>{{ $vehicle->plate_no }} 번호판 차량에는 RFID TAG가 부착되어 있지 않습니다.</h5>
                        </div>
                    @endif
                    <div id="buildYearText" style="display: none" class="alert alert-outline-danger" role="alert">

                    </div>
                        @if($vehicle->is_pending == 1)
                            <div class="alert alert-outline-danger" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                <h5>{{ $vehicle->plate_no }} 해당 번호판 차량은 아카이브 자료 편철을 위한 기술 변경이 있어 아카이브를 편철해야 합니다.</h5>
                            </div>
                        @endif
                  
                        @if( $vehicle->status == null)
                        @if ( $Diagnostic != null && \Carbon\Carbon::parse($Diagnostic->dateagain)->format("Y-m-d") <= \Carbon\Carbon::now()->format("Y-m-d"))
                        <div class="alert alert-outline-danger" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            @if ( $vehicle->purpose_id ==7 )
                            <h5>차량이 검사에 참여하지 않았습니다. MNS 6278 기준을 초과한 경우 MMA를 부여합니다.</h5>
                            @else     
                            <h5>수입 차량은 반드시 검사를 받아야 합니다.</h5>
                            @endif
                            
                         
             
                       
                        </div>
                        @endif 
                            @if($Diagnostic == null ) 
                            
                                <div class="alert alert-outline-danger" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    {{-- {{$vehicle->vehicle_type_id}} --}}
                                    @if ($vehicle->purpose_id != 2 && $vehicle->purpose_id !=4 && $vehicle->purpose_id !=5 && $vehicle->purpose_id !=7 && $vehicle->purpose_id !=8)
                                    <h5>수입 차량은 반드시 검사를 받아야 합니다.</h5>
                                 
                                    @else
                                    <h5>해당 차량이 검사에 참여하지 않았습니다. MNS 6278 기준을 초과한 경우 MMA를 부여합니다.</h5>
                                    @endif
                                </div>
                            @else

                                @if(in_array($Diagnostic->passed_name, ['불합격/실패', '불합격'], true))
                                    <div class="alert alert-outline-danger" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                        @if ( $vehicle->purpose_id ==7 )
                                        <h5>차량이 검사에 참여하지 않았습니다. MNS 6278 기준을 초과한 경우 MMA를 부여합니다.</h5>
                                        @else     
                                        <h5>수입 차량은 반드시 검사에 합격해야 합니다.</h5>
                                        @endif
                                        
                                    </div>
                                @endif
                            @endif
                        @else
                            @if($Diagnostic == null || in_array($Diagnostic->passed_name, ['불합격/실패', '불합격'], true)  )
                                <div class="alert alert-outline-danger" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    @if ( in_array(\Illuminate\Support\Str::substr($vehicle->plate_no, -3), ['MMA', 'ММА'], true) || $vehicle->purpose_id == 2 || $vehicle->purpose_id ==4 || $vehicle->purpose_id ==5 ||$vehicle->purpose_id ==7 || $vehicle->purpose_id ==8)
                                    <h5>차량이 검사에 참여하지 않았습니다. MNS 6278 기준을 초과한 경우 MMA를 부여합니다.</h5>
                                    @else     
                                    <h5>차량은 반드시 검사를 받아야 합니다.</h5>
                                    @endif
                                  
                                 
                                </div>
                            @else
                  
                                @if($Diagnostic->dateagain != null && \Carbon\Carbon::parse($Diagnostic->dateagain)->format("Y-m-d") <= \Carbon\Carbon::now()->format("Y-m-d"))
               
                                    
                      
                                    <div class="alert alert-outline-danger" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                        @if ($vehicle->purpose_id != 2 && $vehicle->purpose_id !=4 && $vehicle->purpose_id !=5 && $vehicle->purpose_id !=7  && $vehicle->purpose_id !=8)
                                        <h5>차량의 재검사 기한이 지났습니다.</h5>
                                        @elseif ( in_array(\Illuminate\Support\Str::substr($vehicle->plate_no, -3), ['MMA', 'ММА'], true) || $vehicle->purpose_id == 2 || $vehicle->purpose_id ==4 || $vehicle->purpose_id ==5 || $vehicle->purpose_id ==7 || $vehicle->purpose_id ==8)
                                        <h5>차량이 검사에 참여하지 않았습니다. MNS 6278 기준을 초과한 경우 MMA를 부여합니다.</h5>
                                        @else
                                        <h5>해당 차량이 검사에 참여하지 않았습니다. MNS 6278 기준을 초과한 경우 MMA를 부여합니다.</h5>
                                        @endif
                                     
                                 
                                     
                                    </div>
                                @endif
                            @endif
                        @endif
                    @endif
                    <form id="main_form" action="{{ route("vehicle") }}" method="POST">
                        {{ csrf_field() }}
                        <div class="row">
                          
                            <input type="text" name="current_plate" style="display: none;" value="{{ isset($vehicle) ? (isset($vehicle->plate_no) ? \App\Http\Controllers\BaseController::enc($vehicle->plate_no) : "") : "" }}" class="form-control">
                            <input type="text" name="vvcabinid" style="display: none;" value="{{ isset($vehicle) ? (isset($vehicle->id) ? \App\Http\Controllers\BaseController::enc($vehicle->id) : "") : "" }}" class="form-control">
                            <input type="text" id="new_owner_id" name="new_owner" style="display: none;" value="" class="form-control">
                            <input type="text" id="is_build" name="is_build" style="display: none;" value="1" class="form-control">
                            <input type="text" id="arkhCheckNum" name="arkhCheckNum" style="display: none;" value="" class="form-control">
                          
                            <input type="text" id="fingerTotalDescription" name="fingerTotalDescription" style="display: none;" value="" class="form-control">
                            <input type="text" id="ntrBookdate" name="ntrBookdate" style="display: none;" value="" class="form-control">
                            <input type="text" id="ntrBooknumber" name="ntrBooknumber" style="display: none;" value="" class="form-control">
                            <input type="text" id="restoreStatusCheck" name="restoreStatusCheck" style="display: none;" value="" class="form-control">
                            <input type="text" id="ntrLastname" name="ntrLastname" style="display: none;" value="" class="form-control">
                            <input type="text" id="ntrFirstname" name="ntrFirstname" style="display: none;" value="" class="form-control">
             
                            <input type="text" id="ntrServiceFile" name="ntrServiceFile" style="display: none;" value="" class="form-control">
                            <input type="text" id="ntrStateregnumber" name="ntrStateregnumber" style="display: none;" value="" class="form-control">
                            <input type="text" id="ntrAddress" name="ntraddress" style="display: none;" value="" class="form-control">
                            <input type="text" id="ntrPhone" name="ntrPhone" style="display: none;" value="" class="form-control">
                            <input type="number" id="fingerDescription" name="fingerDescription" style="display: none;" value="0" class="form-control">

                            <input type="number" id="payDescription" name="payDescription" style="display: none;" value="0" class="form-control">
                            <input type="text" id="payDescriptionName" name="payDescriptionName" style="display: none;" value="" class="form-control">
                            <input type="number" id="transactionId" name="transactionId" style="display: none;" value="0" class="form-control">

                            <input type="number" id="payAmount" name="payAmount" style="display: none;" value="0" class="form-control">
                            <input type="text" id="serviceTypeName" name="serviceTypeName" style="display: none;" value="" class="form-control">
                            
                            <input type="text" id="checkTorguuli" name="checkTorguuli[]" style="display: none;" value="" class="form-control">
                            <input type="text" id="approveCode" name="approveCode" style="display: none;" value="" class="form-control">
                            <input type="text" id="signed_data" name="signed_data" style="display: none;" value="" class="form-control">
                           
                            
                            <!--왼쪽 영역 시작-->
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">번호판(이전소유자 정보 : 0373УНГ , 아카이브 정보 :0446УНГ )</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <input type="text" id="number_id" name="number" value="{{ isset($vehicle) ? (isset($vehicle->plate_no) ? $vehicle->plate_no : "0373УНГ") : "0373УНГ" }}" class="form-control number text-uppercase" oninput="translate2MGL(this.value)" autocomplete="off" autofocus>
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">차체번호</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <input type="text" id="cabin_no_id" name="cabin_no" class="form-control cabin_no_id" value="{{ isset($vehicle) ? $vehicle->cabin_no : "" }}" oninput="translate2LATIN(this.value)" autocomplete="off">
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">세관 신고 번호</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <input type="text" id="gaali_inv_id" class="form-control" value="{{ isset($vehicle) ? $vehicle->declaration_no : "" }}" readonly>
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">VIN 번호</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <input type="text" class="form-control" value="{{ isset($vehicle) ? $vehicle->vin_no : "" }}" readonly>
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">엔진 번호</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <input type="text" class="form-control" value="{{ isset($vehicle) ? $vehicle->engine_no : "" }}" readonly>
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">제조 연도/월</label>
                                    </div>
                                    <div class="col-lg-3 col-md-12 col-sm-12">
                                        <input id="build_year_id" name="build_year" type="text" class="form-control" readonly value="{{ isset($vehicle) ? $vehicle->build_year : "" }}">
                                    </div>
                                    <div class="col-lg-3 col-md-12 col-sm-12">
                                        <input id="build_month_id" name="build_month" type="text" class="form-control" readonly value="{{ isset($vehicle) ? $vehicle->build_month : "" }}">
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">색상</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <input type="text" class="form-control" value="{{ isset($vehicle) ? \App\Helpers\TranslationHelper::translate($vehicle->color_name ?? "") : "" }}" readonly>
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">몽골 반입 일자</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <input id="importdate" name="importdate" type="text" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">증명서 번호</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <input id="cert_id" type="text" name="certificate" class="form-control" readonly value="{{ isset($vehicle) ? $vehicle->certificate_no : "" }}" tabindex="1">
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">제조국</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <input type="text" class="form-control" value="{{ isset($vehicle) ? \App\Helpers\TranslationHelper::translate($vehicle->country_name ?? "") : "" }}" readonly>
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">용도</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <input type="text" class="form-control" value="{{ isset($vehicle) ? \App\Helpers\TranslationHelper::translate($vehicle->purpose_name ?? "") : "" }}" readonly>
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">유형</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <input type="text" class="form-control" value="{{ isset($vehicle) ? \App\Helpers\TranslationHelper::translate($vehicle->vehicle_type_name ?? "") : "" }}" readonly>
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">브랜드</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <input type="text" class="form-control" value="{{ isset($vehicle) ? \App\Helpers\TranslationHelper::translate($vehicle->mark_name ?? "") : "" }}" readonly>
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">모델</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <input type="text" class="form-control" value="{{ isset($vehicle) ? \App\Helpers\TranslationHelper::translate($vehicle->model_name ?? "") : "" }}" readonly>
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">환경 등급</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <input type="text" class="form-control" value="{{ isset($vehicle) ? \App\Helpers\TranslationHelper::translate($vehicle->eco_class_name ?? "") : "" }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <!--왼쪽 영역 끝-->
                            <!--오른쪽 영역 시작-->
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">배기량·등급</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <input type="text" class="form-control" value="{{ isset($vehicle) ? $vehicle->engine_capacity.", ".\App\Helpers\TranslationHelper::translate($vehicle->class_name ?? "") : "" }}" readonly>
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">엔진 유형</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <input type="text" class="form-control" value="{{ isset($vehicle) ? \App\Helpers\TranslationHelper::translate($vehicle->engine_model_name ?? "") : "" }}" readonly>
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">연료 유형</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <input type="text" class="form-control" value="{{ isset($vehicle) ? \App\Helpers\TranslationHelper::translate($vehicle->fuel_name ?? "") : "" }}" readonly>
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">변속기</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <input type="text" class="form-control" value="" readonly>
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">조향 유형</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <input type="text" class="form-control" value="{{ isset($vehicle) ? \App\Helpers\TranslationHelper::translate($vehicle->steering_type_name ?? "") : "" }}" readonly>
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">핸들 위치</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <input type="text" class="form-control" value="{{ isset($vehicle) ? \App\Helpers\TranslationHelper::translate($vehicle->wheel_name ?? "") : "" }}" readonly>
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">길이·높이·폭</label>
                                    </div>
                                    <div class="col-lg-2 col-md-12 col-sm-12">
                                        <input type="text" class="form-control" value="{{ isset($vehicle) ? $vehicle->length : "" }}" readonly>
                                    </div>
                                    <div class="col-lg-2 col-md-12 col-sm-12">
                                        <input type="text" class="form-control" value="{{ isset($vehicle) ? $vehicle->height : "" }}" readonly>
                                    </div>
                                    <div class="col-lg-2 col-md-12 col-sm-12">
                                        <input type="text" class="form-control" value="{{ isset($vehicle) ? $vehicle->width : "" }}" readonly>
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">자중·총중량·적재량</label>
                                    </div>
                                    <div class="col-lg-2 col-md-12 col-sm-12">
                                        <input type="text" class="form-control" value="{{ isset($vehicle) ? $vehicle->own_weight : "" }}" readonly>
                                    </div>
                                    <div class="col-lg-2 col-md-12 col-sm-12">
                                        <input type="text" class="form-control" value="{{ isset($vehicle) ? $vehicle->total_weight : "" }}" readonly>
                                    </div>
                                    <div class="col-lg-2 col-md-12 col-sm-12">
                                        <input type="text" class="form-control" value="{{ isset($vehicle) ? $vehicle->max_load : "" }}" readonly>
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">축·좌석·문 개수</label>
                                    </div>
                                    <div class="col-lg-2 col-md-12 col-sm-12">
                                        <input type="text" class="form-control" value="{{ isset($vehicle) ? $vehicle->axle_count : "" }}" readonly>
                                    </div>
                                    <div class="col-lg-2 col-md-12 col-sm-12">
                                        <input type="text" class="form-control" value="{{ isset($vehicle) ? $vehicle->seat_count : "" }}" readonly>
                                    </div>
                                    <div class="col-lg-2 col-md-12 col-sm-12">
                                        <input type="text" class="form-control" value="{{ isset($vehicle) ? $vehicle->door_count : "" }}" readonly>
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">특수 용도</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <input type="text" class="form-control" value="{{ isset($vehicle) ? $vehicle->special_name : "" }}" readonly>
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">면수</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <input id="page_count_id" type="number" class="form-control" readonly name="page_count" value="{{ isset($vehicle) ? $vehicle->page_count : "" }}" tabindex="2">
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">번호판 색상 선택</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                      
                                        {{-- {{$systemPlateFactory->platecolor}} --}}
                                        <select name="plateColor" id="plateColor" class="form-control select2" required>
                                            @if (isset($vehicle))
                                                {{-- @if ($vehicle->fuel_type_id==22)
                                                    <option value="3" >녹색</option>
                                                @elseif($vehicle->max_load >= 18000 || $vehicle->length >=12000 || $vehicle->width >= 2550 || $vehicle->height >= 4000)
                                                    <option value="5">검정</option> --}}
                                                @if(substr($vehicle->plate_no,4)=="ДК")
                                                    <option value="4">빨강</option>
                                                @else
                                            
                                          
                                               
                                            @if (isset($systemPlateFactory))

                                       
                                            <option value="{{$systemPlateFactory->platecolor}}">
                                                @if ($systemPlateFactory->platecolor == 1)
                                            흰색
                                                @elseif($systemPlateFactory->platecolor == 2)
                                                노랑
                                                @elseif($systemPlateFactory->platecolor == 6)
                                                파랑
                                                @elseif($systemPlateFactory->platecolor == 3)
                                                녹색
                                                @elseif($systemPlateFactory->platecolor == 5)
                                                검정
                                             @endif
                                        </option>
                                        <option value="1" >흰색</option>
                                        <option value="2" >노랑</option>
                                    
                                        <option value="6" >파랑</option>
                                        <option value="3" >녹색</option>
                                        <option value="5">검정</option>

                                        @else
                                        <option value="1" >흰색</option>
                                        <option value="2" >노랑</option>
                                        <option value="6" >파랑</option>
                                        <option value="3" >녹색</option>
                                        <option value="5">검정</option>
                                           
                                        @endif
                                        
                                               
                                                {{-- {{$systemPlateFactory->platecolor}} --}}
                                            
                                            
                                      
                                                @endif
                                           
                                                   
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">변경 일자</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <input type="text" class="form-control" value="{{ isset($vehicle) ? $vehicle->updated_date : "" }}" readonly>
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">아카이브 번호</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <input type="text" class="form-control" value="{{ isset($vehicle) ? $vehicle->archive_no : "" }}" readonly>
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">최초 아카이브</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <input type="text" class="form-control" value="{{ isset($vehicle) ? $vehicle->first_archive_no : "" }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <!--오른쪽 영역 끝-->
                        </div>
                        <hr class="mg-y-10">
                        <div class="row">
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="form-group mg-b-0">
                                    <label class="form-label">이전 번호</label>
                                    <textarea style="height: 30px !important;" id="old_number_id" class="form-control richtextbox" readonly="">{{ isset($vehicle) ? $oldNumbers : "" }}</textarea>
                                </div>
                                <div class="form-group mg-b-0">
                                    <label class="form-label">상태 변경</label>
                                    <textarea style="height: 30px !important;" id="lastmod_id" class="form-control richtextbox" readonly="">{{ isset($vehicle) ? \App\Helpers\TranslationHelper::translate($vehicle->status_name ?? "").", ".\App\Helpers\TranslationHelper::translate($vehicle->firstname ?? "") : "" }}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-8 col-md-6 col-sm-12">
                                <div class="form-servgroup mg-b-0">
                                    <label class="form-label">특이사항</label>
                                    <textarea rows="5" style="height: 85px !important;color: red" readonly id="description_id" readonly name="description" class="form-control richtextbox">{{ isset($vehicle) ? $vehicle->description : "" }}</textarea>
                                </div>
                            </div>
                        </div>
                        <hr class="mg-y-10">
                        <div class="row">
                            <div class="col-lg-12">
                                <table class="table table-bordered table-striped mg-b-10" style="text-align: center;">
                                    <thead>
                                    <tr>
                                        <th style=" width: 18%; ">시작 일자</th>
                                        <th>등록번호</th>
                                        <th>성명</th>
                                        <th>자택 주소</th>
                                        <th>연락처</th>
                                    </tr>
                                    </thead>
                                    <tbody id="owners_crr_table_id">
                                    @if(ISSET($owners))
                                        @foreach($owners as $owner)
                                            {{-- @if($owner->end_date == null && $vehicle->status != 9) --}}
                                            @if($owner->end_date == null)
                                                <tr>
                                                    <?PHP $register = $owner->register_no; ?>
                                                    <th>{{ \Carbon\Carbon::parse($owner->start_date)->format("Y-m-d") }}</th>
                                                    <td>{{ $owner->register_no }}</td>
                                                    <td>{{ $owner->last_name }} {{ $owner->first_name }}</td>
                                                    <td>{{ $owner->address_detail }}</td>
                                                    <td>{{ $owner->phone_no }}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
                <!--왼쪽 영역 끝-->
                <!--오른쪽 영역 시작-->
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="az-content-body-right flexcroll" style=" max-height: 682px !important; min-height: 682px !important; overflow-y: scroll; ">
                        <label id="moreHistory" class="az-content-label tx-base mg-b-15">차량 이력</label>
                        <div class="az-media-list-activity mg-b-20 moreHistory" style="display: none;">
                            <div class="media">
                                <div class="media-icon bg-success"><i class="typcn typcn-tick-outline"></i></div>
                                <a onclick="vehicleActionArchive('{{ isset($vehicle) ? \App\Http\Controllers\BaseController::enc($vehicle->id) : "" }}');" style="cursor:pointer;" data-toggle="modal" data-effect="effect-scale">
                                    <div class="media-body">
                                        <h6>아카이브</h6>
                                        <span>운송수단 아카이브 이력</span>
                                    </div>
                                </a>
                            </div>
                            <div class="media">
                                <div class="media-icon bg-primary"><i class="typcn typcn-group"></i></div>
                                <a onclick="vehicleOwners('{{ isset($vehicle) ? \App\Http\Controllers\BaseController::enc($vehicle->id) : "" }}');" style="cursor:pointer;" data-toggle="modal" data-effect="effect-scale">
                                    <div class="media-body">
                                        <h6>이전 소유자들</h6>
                                        <span>해당 차량의 이전 소유자들</span>
                                    </div>
                                </a>
                            </div>
                            <div class="media">
                                <div class="media-icon bg-primary"><i class="typcn typcn-group"></i></div>
                                <a onclick="vehicleOwners1('{{ isset($vehicle) ? \App\Http\Controllers\BaseController::enc($vehicle->id) : "" }}');" style="cursor:pointer;" data-toggle="modal" data-effect="effect-scale">
                                    <div class="media-body">
                                        <h6>이전 소유자들</h6>
                                        <span>해당 차량의 이전 소유자들</span>
                                    </div>
                                </a>
                            </div>
                            <div class="media">
                                <div class="media-icon bg-info"><i class="typcn typcn-user"></i></div>
                                <a onclick="ownerTwo('{{ isset($vehicle) ? \App\Http\Controllers\BaseController::enc($vehicle->owner1_id) : "" }}');" style="cursor: pointer;" data-toggle="modal" data-effect="effect-scale">
                                    <div class="media-body">
                                        <h6>소유자</h6>
                                        <span>해당 차량의 소유자</span>
                                    </div>
                                </a>
                            </div>
                            <div class="media">
                                <div class="media-icon bg-purple"><i class="typcn typcn-times-outline"></i></div>
                                <a onclick="vehicleLimitHistory('{{ isset($vehicle) ? \App\Http\Controllers\BaseController::enc($vehicle->id) : "" }}');" style="cursor:pointer;" data-toggle="modal" data-effect="effect-scale">
                                    <div class="media-body">
                                        <h6>제한/압류</h6>
                                        <span>해당 차량의 제한 이력</span>
                                    </div>
                                </a>
                            </div>
                            <div class="media">
                                <div class="media-icon bg-danger"><i class="typcn typcn-arrow-forward-outline"></i></div>
                                <a onclick="vehicleAnother('{{ isset($vehicle) ? \App\Http\Controllers\BaseController::enc($vehicle->id) : "" }}');" style="cursor: pointer;" data-toggle="modal" data-effect="effect-scale">
                                    <div class="media-body">
                                        <h6>기타 차량</h6>
                                        <span>기타 정보</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <hr class="mg-y-10">
                        <label id="moreInformation" class="az-content-label tx-base mg-b-15">기타 정보</label>
                        <div class="az-media-list-activity mg-b-20 moreInformation">
                            <div class="media">
                                <div class="media-icon bg-success"><i class="typcn typcn-flow-merge"></i></div>
                                <a onclick="gaali('{{ isset($vehicle) ? \App\Http\Controllers\BaseController::enc($vehicle->declaration_no) : "" }}');" style="cursor: pointer;">
                                    <div class="media-body">
                                        <h6>세관</h6>
                                        <span>세관 정보</span>
                                    </div>
                                </a>
                            </div>
                            <div class="media">
                                <div class="media-icon bg-purple"><i class="typcn typcn-news"></i></div>
                                {{-- @if (isset($vehicle))
                                {{$vehicle->owner1_id}} 
                                @endif --}}
                           
                                <a onclick="wayPayCheckLogin('{{ isset($vehicle) ? \App\Http\Controllers\BaseController::enc($vehicle->plate_no): "" }}','{{ isset($vehicle) ? $vehicle->owner_id : "" }}','{{ isset($vehicle) ? $vehicle->owner1_id : "" }}');" style="cursor: pointer;">
                                    <div class="media-body">
                                        <h6>도로 통행료</h6>
                                        <span>도로 통행료 납부 여부</span>
                                    </div>
                                </a>
                            </div>
                            <div class="media">
                                <div class="media-icon bg-primary"><i class="typcn typcn-input-checked-outline"></i></div>
                                <a onclick="onoshilgoo();" style="cursor: pointer;">
                                    <div class="media-body">
                                        <h6>검사</h6>
                                        <span>검사 참여 여부</span>
                                    </div>
                                </a>
                            </div>
                            <div class="media">
                                <div class="media-icon bg-danger"><i class="typcn typcn-info-outline"></i></div>
                                <a onclick="torguuli('{{ isset($vehicle) ? \App\Http\Controllers\BaseController::enc($vehicle->plate_no) : "" }}');" style="cursor: pointer;">
                                    <div class="media-body">
                                        <h6>과태료</h6>
                                        <span>기타 정보</span>
                                    </div>
                                </a>
                            </div>
                            <div class="media">
                                <div class="media-icon bg-purple"><i class="typcn typcn-lock-closed"></i></div>
                                <a onclik="">
                                    <div class="media-body">
                                        <h6>보험</h6>
                                        <span>보험 정보</span>
                                    </div>
                                </a>
                            </div>
                            <div class="media">
                                <div class="media-icon bg-info"><i class="typcn typcn-point-of-interest-outline"></i></div>
                                <a onclick="tatvar('{{ isset($vehicle) ? \App\Http\Controllers\BaseController::enc($vehicle->plate_no) : "" }}');" style="cursor: pointer;">
                                    <div class="media-body">
                                        <h6>세금</h6>
                                        <span>세금 납부 이력</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <hr class="mg-y-10">
                        @if(isset($isMobile) && $isMobile==false)
                        {{-- {{var_dump($vehicle)}} --}}
                            <label id="moreService" class="az-content-label tx-base mg-b-15">서비스</label>
                            <div id="servicePanel" class="az-media-list-activity mg-b-20 moreService">
                                @if(ISSET($limit_count) && ISSET($vehicle))
                           
                                    @if($limit_count <= 0 && $vehicle->is_stolen != 1 && $vehicle->is_warning != 1 && $vehicle->is_enabled != 0 && ($vehicle->status != 9 && $vehicle->status != 10 && $vehicle->status != 11 && $vehicle->is_cert_revoke != 1))
                                        @if(isset($services) && (string)strpos($vehicle->archive_no, "SHEDK") != "0" && (string)strpos($vehicle->archive_no, "SHEBUTS") != "0")
                                       
                                            @foreach($services as $service)
                                   
                                                @if(\App\Http\Controllers\BaseController::hasMenuShow($service->id, 2, \App\Http\Controllers\BaseController::enc(session()->get("auth")->userpositionid)))
                                              
                                          {{-- {{var_dump( session()->get('auth')->provinceid)}} --}}
                                                {{----------------------------------------------------------}}
                                                @if ($Diagnostic == null || in_array($Diagnostic->passed_name, ['불합격/실패', '불합격'], true) ||  \Carbon\Carbon::parse($Diagnostic->dateagain)->format("Y-m-d") <= \Carbon\Carbon::now()->format("Y-m-d"))
                                                @if ($vehicle->purpose_id ==7)
                                                @if($service->code == "NEW")
                                                <div id="menu_{{ $service->code }}" class="media">
                                                    <div class="media-icon bg-success"><i class="{{ $service->icon }}"></i></div>
                                                    <a id="{{ $service->code }}" style="cursor: pointer;" onclick="menu('{{ $service->code }}')">
                                                        <div class="media-body">
                                                            <h6>{{ \App\Helpers\TranslationHelper::translate($service->name ?? "") }}</h6>
                                                            <span>{{ \App\Helpers\TranslationHelper::translate($service->description ?? "") }}</span>
                                                        </div>
                                                    </a>
                                                </div>
                                                @endif
                                                @endif 
                                                @if ( session()->get('auth')->iscity == 1 && $vehicle->owner_province_id == 11)
                                                @if (  $vehicle->purpose_id == 2 || $vehicle->purpose_id ==4 || $vehicle->purpose_id ==5 || $vehicle->purpose_id ==7 || $vehicle->purpose_id ==8)
                                                @if($service->code == "MOVE")
                                                <div id="menu_{{ $service->code }}" class="media">
                                                    <div class="media-icon bg-success"><i class="{{ $service->icon }}"></i></div>
                                                    <a id="{{ $service->code }}" style="cursor: pointer;" onclick="menu('{{ $service->code }}')">
                                                        <div class="media-body">
                                                            <h6>{{ \App\Helpers\TranslationHelper::translate($service->name ?? "") }}</h6>
                                                            <span>{{ \App\Helpers\TranslationHelper::translate($service->description ?? "") }}</span>
                                                 
       </div>
                                                    </a>
                                                </div>
                                                @endif
                                                @endif
                                       
                                                @if ($vehicle->purpose_id == 2 || $vehicle->purpose_id ==4 || $vehicle->purpose_id ==5 || $vehicle->purpose_id ==7  || $vehicle->purpose_id ==8)
                                                @if($service->code == "CHANGE_PLATE")
                                                <div id="menu_{{ $service->code }}" class="media">
                                                    <div class="media-icon bg-success"><i class="{{ $service->icon }}"></i></div>
                                                    <a id="{{ $service->code }}" style="cursor: pointer;" onclick="menu('{{ $service->code }}')">
                                                        <div class="media-body">
                                                            <h6>{{ \App\Helpers\TranslationHelper::translate($service->name ?? "") }}</h6>
                                                            <span>{{ \App\Helpers\TranslationHelper::translate($service->description ?? "") }}</span>
                                                 
       </div>
                                                    </a>
                                                </div>
                                                @endif
                                                @endif
                                                @elseif ( session()->get('auth')->iscity == 0 && $vehicle->owner_province_id != 11)
                                                @if ( in_array(\Illuminate\Support\Str::substr($vehicle->plate_no, -3), ['MMA', 'ММА'], true) || $vehicle->purpose_id == 2 || $vehicle->purpose_id ==4 || $vehicle->purpose_id ==5 || $vehicle->purpose_id ==7 || $vehicle->purpose_id ==8)
                                                @if($service->code == "MOVE")
                                                <div id="menu_{{ $service->code }}" class="media">
                                                    <div class="media-icon bg-success"><i class="{{ $service->icon }}"></i></div>
                                                    <a id="{{ $service->code }}" style="cursor: pointer;" onclick="menu('{{ $service->code }}')">
                                                        <div class="media-body">
                                                            <h6>{{ \App\Helpers\TranslationHelper::translate($service->name ?? "") }}</h6>
                                                            <span>{{ \App\Helpers\TranslationHelper::translate($service->description ?? "") }}</span>
                                                 
       </div>
                                                    </a>
                                                </div>
                                                @endif
                                                @endif
                                             
                                            
                                                @if ($vehicle->purpose_id == 2 || $vehicle->purpose_id ==4 || $vehicle->purpose_id ==5 || $vehicle->purpose_id ==7  || $vehicle->purpose_id ==8)
                                                @if($service->code == "CHANGE_PLATE")
                                                <div id="menu_{{ $service->code }}" class="media">
                                                    <div class="media-icon bg-success"><i class="{{ $service->icon }}"></i></div>
                                                    <a id="{{ $service->code }}" style="cursor: pointer;" onclick="menu('{{ $service->code }}')">
                                                        <div class="media-body">
                                                            <h6>{{ \App\Helpers\TranslationHelper::translate($service->name ?? "") }}</h6>
                                                            <span>{{ \App\Helpers\TranslationHelper::translate($service->description ?? "") }}</span>
                                                 
       </div>
                                                    </a>
                                                </div>
                                                @endif
                                                @endif
                                                @endif

                                                @endif
                                                @if ( in_array(\Illuminate\Support\Str::substr($vehicle->plate_no, -3), ['MMA', 'ММА'], true) )
                                                @if($service->code == "MOVE")
                                                <div id="menu_{{ $service->code }}" class="media">
                                                    <div class="media-icon bg-success"><i class="{{ $service->icon }}"></i></div>
                                                    <a id="{{ $service->code }}" style="cursor: pointer;" onclick="menu('{{ $service->code }}')">
                                                        <div class="media-body">
                                                            <h6>{{ \App\Helpers\TranslationHelper::translate($service->name ?? "") }}</h6>
                                                            <span>{{ \App\Helpers\TranslationHelper::translate($service->description ?? "") }}</span>
                                                 
       </div>
                                                    </a>
                                                </div>
                                                @endif
                                                @endif
                                                @if ( in_array(\Illuminate\Support\Str::substr($vehicle->plate_no, -3), ['MMA', 'ММА'], true) ) 
                                                @if($service->code == "AGAIN_CERT")
                                                <div id="menu_{{ $service->code }}" class="media">
                                                    <div class="media-icon bg-success"><i class="{{ $service->icon }}"></i></div>
                                                    <a id="{{ $service->code }}" style="cursor: pointer;" onclick="menu('{{ $service->code }}')">
                                                        <div class="media-body">
                                                            <h6>{{ \App\Helpers\TranslationHelper::translate($service->name ?? "") }}</h6>
                                                            <span>{{ \App\Helpers\TranslationHelper::translate($service->description ?? "") }}</span>
                                                 
       </div>
                                                    </a>
                                                </div>
                                                @endif
                                                @endif
                                                @if ( in_array(\Illuminate\Support\Str::substr($vehicle->plate_no, -3), ['MMA', 'ММА'], true) ) 
                                                @if($service->code == "CHANGE_CERT")
                                                <div id="menu_{{ $service->code }}" class="media">
                                                    <div class="media-icon bg-success"><i class="{{ $service->icon }}"></i></div>
                                                    <a id="{{ $service->code }}" style="cursor: pointer;" onclick="menu('{{ $service->code }}')">
                                                        <div class="media-body">
                                                            <h6>{{ \App\Helpers\TranslationHelper::translate($service->name ?? "") }}</h6>
                                                            <span>{{ \App\Helpers\TranslationHelper::translate($service->description ?? "") }}</span>
                                                 
       </div>
                                                    </a>
                                                </div>
                                                @endif
                                                @endif
                                                
                                                @if($service->code == "MOVE_PLATE")
                                                <div id="menu_{{ $service->code }}" class="media">
                                                    <div class="media-icon bg-success"><i class="{{ $service->icon }}"></i></div>
                                                    <a id="{{ $service->code }}" style="cursor: pointer;" onclick="menu('{{ $service->code }}')">
                                                        <div class="media-body">
                                                            <h6>{{ \App\Helpers\TranslationHelper::translate($service->name ?? "") }}</h6>
                                                            <span>{{ \App\Helpers\TranslationHelper::translate($service->description ?? "") }}</span>
                                                 
       </div>
                                                    </a>
                                                </div>
                                                @endif
{{---------------------------Menu-------------------------------}}

                                                    @if($vehicle->plate_no != "")
                                                    @if($vehicle->purpose_id ==7  || $vehicle->purpose_id ==8)
                                                    @if($service->code != "NEW"  && $service->code != "RESTRICT" && $service->code != "CHANGE_PLATE_TWO" && $service->code != "ACTIVE_VEHICLE" && $service->code != "RESTORE_PLATE" && $service->code != "REMOVE" )
                                                    @if($Diagnostic != null)
                                                    @if(!in_array($Diagnostic->passed_name, ['불합격/실패', '불합격'], true))
                                                        @if($Diagnostic->dateagain == null || \Carbon\Carbon::parse($Diagnostic->dateagain)->format("Y-m-d") > \Carbon\Carbon::now()->format("Y-m-d") )
                                                            <div id="menu_{{ $service->code }}" class="media">
                                                                <div class="media-icon bg-success"><i class="{{ $service->icon }}"></i></div>
                                                                <a id="{{ $service->code }}" style="cursor: pointer;" onclick="menu('{{ $service->code }}')">
                                                                    <div class="media-body">
                                                                     
                                                                        <h6>{{ \App\Helpers\TranslationHelper::translate($service->name ?? "") }}</h6>
                                                                        
                                                                        <span>{{ \App\Helpers\TranslationHelper::translate($service->description ?? "") }}</span>
                                                                     
                                                                      
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        @endif
                                                    @endif
                                                    @endif
                                                @endif
                                                    @endif

                                                    @if ( session()->get('auth')->iscity == 1 && $vehicle->owner_province_id == 11)
                                                        @if($service->code != "NEW"  && $service->code != "RESTRICT" && $service->code != "CHANGE_PLATE_TWO" && $service->code != "ACTIVE_VEHICLE" && $service->code != "RESTORE_PLATE" && $service->code != "REMOVE" )
                                                        
                                                            @if($Diagnostic != null)
                                                            @if(!in_array($Diagnostic->passed_name, ['불합격/실패', '불합격'], true))
                                                                @if($Diagnostic->dateagain == null || \Carbon\Carbon::parse($Diagnostic->dateagain)->format("Y-m-d") > \Carbon\Carbon::now()->format("Y-m-d") )
                                                             

                                                                    <div id="menu_{{ $service->code }}" class="media">
                                                                        <div class="media-icon bg-success"><i class="{{ $service->icon }}"></i></div>
                                                                        <a id="{{ $service->code }}" style="cursor: pointer;" onclick="menu('{{ $service->code }}')">
                                                                            <div class="media-body">
                                                                             
                                                                                <h6>{{ \App\Helpers\TranslationHelper::translate($service->name ?? "") }}</h6>
                                                                                
                                                                                <span>{{ \App\Helpers\TranslationHelper::translate($service->description ?? "") }}</span>
                                                                             
                                                                              
                                                                            </div>
                                                                        </a>
                                                                    </div>
                                                                @endif
                                                            @endif
                                                            @endif
                                                        @endif

                                                        @elseif ( session()->get('auth')->iscity == 0 && $vehicle->owner_province_id != 11)  
                                                        @if($service->code != "NEW"  && $service->code != "RESTRICT" && $service->code != "CHANGE_PLATE_TWO" && $service->code != "ACTIVE_VEHICLE" && $service->code != "RESTORE_PLATE" && $service->code != "REMOVE" )
                                                            @if($Diagnostic != null)
                                                            @if(!in_array($Diagnostic->passed_name, ['불합격/실패', '불합격'], true))
                                                                @if($Diagnostic->dateagain == null || \Carbon\Carbon::parse($Diagnostic->dateagain)->format("Y-m-d") > \Carbon\Carbon::now()->format("Y-m-d") )
                                                                    <div id="menu_{{ $service->code }}" class="media">
                                                                        <div class="media-icon bg-success"><i class="{{ $service->icon }}"></i></div>
                                                                        <a id="{{ $service->code }}" style="cursor: pointer;" onclick="menu('{{ $service->code }}')">
                                                                            <div class="media-body">
                                                                             
                                                                                <h6>{{ \App\Helpers\TranslationHelper::translate($service->name ?? "") }}</h6>
                                                                                
                                                                                <span>{{ \App\Helpers\TranslationHelper::translate($service->description ?? "") }}</span>
                                                                             
                                                                              
                                                                            </div>
                                                                        </a>
                                                                    </div>
                                                                @endif
                                                            @endif
                                                            @endif
                                                        @endif

                                                        @else <div></div>




                                                        @endif
                                                    @else
                                                    {{-- {{\Carbon\Carbon::parse($Diagnostic->dateagain)->format("Y-m-d")}} --}}
                                                    
                                                        @if($vehicle->status == null && $Diagnostic != null)
                                                            @if(!in_array($Diagnostic->passed_name, ['불합격/실패', '불합격'], true) &&  \Carbon\Carbon::parse($Diagnostic->dateagain)->format("Y-m-d") > \Carbon\Carbon::now()->format("Y-m-d"))
                                                            
                                                            
                                                            @if($service->code == "NEW")
                                                                    <div id="menu_{{ $service->code }}" class="media">
                                                                        <div class="media-icon bg-success"><i class="{{ $service->icon }}"></i></div>
                                                                        <a id="{{ $service->code }}" style="cursor: pointer;" onclick="menu('{{ $service->code }}')">
                                                                            <div class="media-body">
                                                                                <h6>{{ \App\Helpers\TranslationHelper::translate($service->name ?? "") }}</h6>
                                                                                <span>{{ \App\Helpers\TranslationHelper::translate($service->description ?? "") }}</span>
                                                                            </div>
                                                                        </a>
                                                                    </div>
                                                                @endif
                                                            @endif
                                                            @else
                                                            
                                                        @if ($vehicle->purpose_id == 2 || $vehicle->purpose_id ==4 || $vehicle->purpose_id ==5 || $vehicle->purpose_id ==7  || $vehicle->purpose_id ==8)
                                                              @if($service->code == "NEW")
                                                            <div id="menu_{{ $service->code }}" class="media">
                                                                <div class="media-icon bg-success"><i class="{{ $service->icon }}"></i></div>
                                                                <a id="{{ $service->code }}" style="cursor: pointer;" onclick="menu('{{ $service->code }}')">
                                                                    <div class="media-body">
                                                                        <h6>{{ $service->name }}</h6>
                                                                        <span>{{ $service->description }}</span>
                                                                 
                                                                    </div>
                                                                </a>
                                                            </div>
                                                            @endif
                                                         @endif
                                                         
                                                        @endif
                                                    @endif
                                                @endif
                                            @endforeach
                                        @else
                                           
                                        @endif
                                    @endif
                                   
                                    @if ( session()->get('auth')->iscity == 1 && $vehicle->owner_province_id == 11 )
                                    <!-- @if((string)strpos($vehicle->archive_no, "SHEDK") != "0" && (string)strpos($vehicle->archive_no, "SHEBUTS") != "0" && \App\Http\Controllers\BaseController::hasMenuShow(12, 2, \App\Http\Controllers\BaseController::enc(session()->get("auth")->userpositionid)))
                                        <div id="menu_RESTRICT" class="media">
                                            <div class="media-icon bg-success"><i class="typcn typcn-delete"></i></div>
                                            <a id="RESTRICT" style="cursor: pointer;" onclick="menu('RESTRICT')">
                                                <div class="media-body">
                                                    <h6>제한하기</h6>
                                                    <span>운송수단 제한</span>
                                                </div>
                                            </a>
                                        </div>
                                    @endif -->
                                    
                                    @if(\App\Http\Controllers\BaseController::hasMenuShow(9, 2, \App\Http\Controllers\BaseController::enc(session()->get("auth")->userpositionid)) && ($vehicle->status != 9 && $vehicle->status != 10 && $vehicle->status != 11))
                                        <div id="menu_REMOVE" class="media">
                                            <div class="media-icon bg-success"><i class="typcn typcn-minus-outline"></i></div>
                                            <a id="REMOVE" style="cursor: pointer;" onclick="menu('REMOVE')">
                                                <div class="media-body">
                                                    <h6>제외</h6>
                                                    <span>차량 말소</span>
                                                </div>
                                            </a>
                                        </div>
                                    @endif
                                    @if(\App\Http\Controllers\BaseController::hasMenuShow(26, 2, \App\Http\Controllers\BaseController::enc(session()->get("auth")->userpositionid)) && ($vehicle->status != 9 && $vehicle->status != 10 && $vehicle->status != 11))
                                        <div id="menu_PLATE_COLOR_CHANGE" class="media">
                                            <div class="media-icon bg-success"><i class="typcn typcn-arrow-shuffle"></i></div>
                                            <a id="PLATE_COLOR_CHANGE" style="cursor: pointer;" onclick="menu('PLATE_COLOR_CHANGE')">
                                                <div class="media-body">
                                                    <h6>번호판 색상 변경</h6>
                                                    <span>번호판 색상 변경</span>
                                                </div>
                                            </a>
                                        </div>
                                    @endif
                                    @if(\App\Http\Controllers\BaseController::hasMenuShow(17, 2, \App\Http\Controllers\BaseController::enc(session()->get("auth")->userpositionid)) && ($vehicle->status != 9 && $vehicle->status != 10 && $vehicle->status != 11))
                                        <div id="menu_OWNER_REG" class="media">
                                            <div class="media-icon bg-success"><i class="typcn typcn-user-add-outline"></i></div>
                                                        <a id="OWNER_REG" style="cursor: pointer;" onclick="menu('OWNER_REG')">
                                                <div class="media-body">
                                                <h6>소유자 등록</h6>
                                                <span>차량에 소유자 등록</span>
                                                </div>
                                            </a>
                                        </div>
                                    @endif
                                    @if(\App\Http\Controllers\BaseController::hasMenuShow(19, 2, \App\Http\Controllers\BaseController::enc(session()->get("auth")->userpositionid)) && ($vehicle->status == 9 || $vehicle->status == 10 || $vehicle->status == 11))
                                        <div id="menu_RESTORE_PLATE" class="media">
                                            <div class="media-icon bg-success"><i class="typcn typcn-arrow-sync"></i></div>
                                            <a id="RESTORE_PLATE" style="cursor: pointer;" onclick="menu('RESTORE_PLATE')">
                                                <div class="media-body">
                                                    <h6>말소에서 복구</h6>
                                                    <span>말소 상태 차량 복구</span>
                                                </div>
                                            </a>
                                        </div>
                                    @endif
                                    @if(\App\Http\Controllers\BaseController::hasMenuShow(16, 2, \App\Http\Controllers\BaseController::enc(session()->get("auth")->userpositionid)) &&  $vehicle->status != 10)
                                        <div id="menu_CHANGE_PLATE_TWO" class="media">
                                            <div class="media-icon bg-success"><i class="typcn typcn-arrow-shuffle"></i></div>
                                            <a id="CHANGE_PLATE_TWO" style="cursor: pointer;" onclick="menu('CHANGE_PLATE_TWO')">
                                                <div class="media-body">
                                                    <h6>차량 간 번호 교체</h6>
                                                    <span>두 차량 번호 교환</span>
                                                </div>
                                            </a>
                                        </div>
                                    @endif
                                    @if(\App\Http\Controllers\BaseController::hasMenuShow(18, 2, \App\Http\Controllers\BaseController::enc(session()->get("auth")->userpositionid)) && $vehicle->is_enabled == 0)
                                        <div id="menu_ACTIVE_VEHICLE" class="media">
                                            <div class="media-icon bg-success"><i class="typcn typcn-input-checked-outline"></i></div>
                                            <a id="ACTIVE_VEHICLE" style="cursor: pointer;" onclick="menu('ACTIVE_VEHICLE')">
                                                <div class="media-body">
                                                    <h6>차량 활성화</h6>
                                                    <span>비활성 차량 활성화</span>
                                                </div>
                                            </a>
                                        </div> 
                                    @endif
                                    <!-- <div id="menu_DESCRIPTION_VEHICLE" class="media">
                                        <div class="media-icon bg-success"><i class="typcn typcn-input-checked-outline"></i></div>
                                        <a id="DESCRIPTION_VEHICLE" style="cursor: pointer;" onclick="menu('DESCRIPTION_VEHICLE')">
                                            <div class="media-body">
                                                <h6>특이사항</h6>
                                                <span>차량 위반 표시</span>
                                            </div>
                                        </a>
                                    </div> -->
                                    @elseif ( session()->get('auth')->iscity == 0 && $vehicle->owner_province_id != 11)
                                    <!-- @if((string)strpos($vehicle->archive_no, "SHEDK") != "0" && (string)strpos($vehicle->archive_no, "SHEBUTS") != "0" && \App\Http\Controllers\BaseController::hasMenuShow(12, 2, \App\Http\Controllers\BaseController::enc(session()->get("auth")->userpositionid)))
                                    <div id="menu_RESTRICT" class="media">
                                        <div class="media-icon bg-success"><i class="typcn typcn-delete"></i></div>
                                        <a id="RESTRICT" style="cursor: pointer;" onclick="menu('RESTRICT')">
                                            <div class="media-body">
                                                <h6>제한하기</h6>
                                                <span>운송수단 제한</span>
                                            </div>
                                        </a>
                                    </div>
                                @endif -->
                                @if(\App\Http\Controllers\BaseController::hasMenuShow(9, 2, \App\Http\Controllers\BaseController::enc(session()->get("auth")->userpositionid)) && ($vehicle->status != 9 && $vehicle->status != 10 && $vehicle->status != 11))
                                    <div id="menu_REMOVE" class="media">
                                        <div class="media-icon bg-success"><i class="typcn typcn-minus-outline"></i></div>
                                        <a id="REMOVE" style="cursor: pointer;" onclick="menu('REMOVE')">
                                            <div class="media-body">
                                                <h6>제외</h6>
                                                <span>차량 말소</span>
                                            </div>
                                        </a>
                                    </div>
                                @endif
                                @if(\App\Http\Controllers\BaseController::hasMenuShow(26, 2, \App\Http\Controllers\BaseController::enc(session()->get("auth")->userpositionid)) && ($vehicle->status != 9 && $vehicle->status != 10 && $vehicle->status != 11))
                                    <div id="menu_PLATE_COLOR_CHANGE" class="media">
                                        <div class="media-icon bg-success"><i class="typcn typcn-arrow-shuffle"></i></div>
                                        <a id="PLATE_COLOR_CHANGE" style="cursor: pointer;" onclick="menu('PLATE_COLOR_CHANGE')">
                                            <div class="media-body">
                                                <h6>번호판 색상 변경</h6>
                                                <span>번호판 색상 변경</span>
                                            </div>
                                        </a>
                                    </div>
                                @endif
                                @if(\App\Http\Controllers\BaseController::hasMenuShow(17, 2, \App\Http\Controllers\BaseController::enc(session()->get("auth")->userpositionid)) && ($vehicle->status != 9 && $vehicle->status != 10 && $vehicle->status != 11))
                                    <div id="menu_OWNER_REG" class="media">
                                        <div class="media-icon bg-success"><i class="typcn typcn-user-add-outline"></i></div>
                                                    <a id="OWNER_REG" style="cursor: pointer;" onclick="menu('OWNER_REG')">
                                            <div class="media-body">
                                            <h6>소유자 등록</h6>
                                            <span>차량에 소유자 등록</span>
                                            </div>
                                        </a>
                                    </div>
                                @endif
                                @if(\App\Http\Controllers\BaseController::hasMenuShow(19, 2, \App\Http\Controllers\BaseController::enc(session()->get("auth")->userpositionid)) && ($vehicle->status == 9 || $vehicle->status == 10 || $vehicle->status == 11))
                                    <div id="menu_RESTORE_PLATE" class="media">
                                        <div class="media-icon bg-success"><i class="typcn typcn-arrow-sync"></i></div>
                                        <a id="RESTORE_PLATE" style="cursor: pointer;" onclick="menu('RESTORE_PLATE')">
                                            <div class="media-body">
                                                <h6>말소에서 복구</h6>
                                                <span>말소 상태 차량 복구</span>
                                            </div>
                                        </a>
                                    </div>
                                @endif
                                @if(\App\Http\Controllers\BaseController::hasMenuShow(16, 2, \App\Http\Controllers\BaseController::enc(session()->get("auth")->userpositionid)) &&  $vehicle->status != 10)
                                    <div id="menu_CHANGE_PLATE_TWO" class="media">
                                        <div class="media-icon bg-success"><i class="typcn typcn-arrow-shuffle"></i></div>
                                        <a id="CHANGE_PLATE_TWO" style="cursor: pointer;" onclick="menu('CHANGE_PLATE_TWO')">
                                            <div class="media-body">
                                                <h6>차량 간 번호 교체</h6>
                                                <span>두 차량 번호 교환</span>
                                            </div>
                                        </a>
                                    </div>
                                @endif
                                @if(\App\Http\Controllers\BaseController::hasMenuShow(18, 2, \App\Http\Controllers\BaseController::enc(session()->get("auth")->userpositionid)) && $vehicle->is_enabled == 0)
                                    <div id="menu_ACTIVE_VEHICLE" class="media">
                                        <div class="media-icon bg-success"><i class="typcn typcn-input-checked-outline"></i></div>
                                        <a id="ACTIVE_VEHICLE" style="cursor: pointer;" onclick="menu('ACTIVE_VEHICLE')">
                                            <div class="media-body">
                                                <h6>차량 활성화</h6>
                                                <span>비활성 차량 활성화</span>
                                            </div>
                                        </a>
                                    </div> 
                                @endif
                             

                                    @endif
                                    {{--DK 번호인 경우 다음 서비스를 이용할 수 있습니다--}} 
                             @if(session()->get("auth")->userpositionid == 87 && $archive_department_abbr = session()->get("archive")->abbr == "ДК")
                             @if($Diagnostic != null)
                                 @if($Diagnostic->dateagain == null || \Carbon\Carbon::parse($Diagnostic->dateagain)->format("Y-m-d") > \Carbon\Carbon::now()->format("Y-m-d"))
                                 @if(\App\Http\Controllers\BaseController::hasMenuShow(17, 2, \App\Http\Controllers\BaseController::enc(session()->get("auth")->userpositionid)))
                                         <div id="menu_MOVE" class="media">
                                             <div class="media-icon bg-success"><i class="typcn typcn-flow-switch"></i></div>
                                             <a id="MOVE" style="cursor: pointer;" onclick="menu('MOVE')">
                                                 <div class="media-body">
                                                     <h6>소유자 이전</h6>
                                                     <span>DK 소유자 이전</span>
                                                 </div>
                                             </a>
                                         </div>
                                     @endif

                                     @if(\App\Http\Controllers\BaseController::hasMenuShow(17, 2, \App\Http\Controllers\BaseController::enc(session()->get("auth")->userpositionid)))
                                         <div id="menu_AGAIN_CERT" class="media">
                                             <div class="media-icon bg-success"><i class="typcn typcn-book"></i></div>
                                             <a id="AGAIN_CERT" style="cursor: pointer;" onclick="menu('AGAIN_CERT')">
                                                 <div class="media-body">
                                                     <h6>증명서 재발급</h6>
                                                     <span>DK 폐기·분실 증명서</span>
                                                 </div>
                                             </a>
                                         </div>
                                     @endif

                                     @if(\App\Http\Controllers\BaseController::hasMenuShow(17, 2, \App\Http\Controllers\BaseController::enc(session()->get("auth")->userpositionid)))
                                         <div id="menu_CHANGE_CERT" class="media">
                                             <div class="media-icon bg-success"><i class="typcn typcn-arrow-sync"></i></div>
                                             <a id="CHANGE_CERT" style="cursor: pointer;" onclick="menu('CHANGE_CERT')">
                                                 <div class="media-body">
                                                     <h6>증명서 교체</h6>
                                                     <span>DK 요건 미충족 증명서</span>
                                                 </div>
                                             </a>
                                         </div>
                                     @endif
                                 @endif
                             @endif

                             @if(\App\Http\Controllers\BaseController::hasMenuShow(17, 2, \App\Http\Controllers\BaseController::enc(session()->get("auth")->userpositionid)))
                                 <div id="menu_RESTRICT" class="media">
                                     <div class="media-icon bg-success"><i class="typcn typcn-delete"></i></div>
                                     <a id="RESTRICT" style="cursor: pointer;" onclick="menu('RESTRICT')">
                                         <div class="media-body">
                                             <h6>제한лах</h6>
                                             <span>DK 운송수단 제한</span>
                                         </div>
                                     </a>
                                 </div>
                             @endif

                             @if(\App\Http\Controllers\BaseController::hasMenuShow(17, 2, \App\Http\Controllers\BaseController::enc(session()->get("auth")->userpositionid)))
                                 <div id="menu_DELETE_PLATE" class="media">
                                     <div class="media-icon bg-success"><i class="typcn typcn-thumbs-down"></i></div>
                                     <a id="DELETE_PLATE" style="cursor: pointer;" onclick="menu('DELETE_PLATE')">
                                         <div class="media-body">
                                             <h6>문자 말소</h6>
                                             <span>DK 차량 번호판 분실</span>
                                         </div>
                                     </a>
                                 </div>
                             @endif

                             {{-- @if(!\App\Http\Controllers\BaseController::hasMenuShow(9, 2, \App\Http\Controllers\BaseController::enc(session()->get("auth")->userpositionid)) && ((string)strpos($vehicle->archive_no, "SHEDK") == "0" || (string)strpos($vehicle->archive_no, "SHEBUTS") == "0")) --}}
                            
                             @if(\App\Http\Controllers\BaseController::hasMenuShow(17, 2, \App\Http\Controllers\BaseController::enc(session()->get("auth")->userpositionid)))
                                 <div id="menu_REMOVE" class="media">
                                     <div class="media-icon bg-success"><i class="typcn typcn-minus-outline"></i></div>
                                     <a id="REMOVE" style="cursor: pointer;" onclick="menu('REMOVE')">
                                         <div class="media-body">
                                             <h6>제외</h6>
                                             <span>DK 차량 말소</span>
                                         </div>
                                     </a>
                                 </div>
                             @endif

                             @if(\App\Http\Controllers\BaseController::hasMenuShow(17, 2, \App\Http\Controllers\BaseController::enc(session()->get("auth")->userpositionid)))
                                 <div id="menu_REMOVE" class="media">
                                     <div class="media-icon bg-success"><i class="typcn typcn-minus-outline"></i></div>
                                     <a id="OWNER_REG" style="cursor: pointer;" onclick="menu('OWNER_REG')">
                                         <div class="media-body">
                                             <h6>소유자 등록</h6>
                                             <span>DK 차량에 소유자 등록</span>
                                         </div>
                                     </a>
                                 </div>
                             @endif
                             {{--DK 번호인 경우 다음 서비스를 이용할 수 있습니다--}}
                         @endif
                         
                                    @if((string)strpos($vehicle->archive_no, "SHEDK") != "0" && (string)strpos($vehicle->archive_no, "SHEBUTS") != "0" && \App\Http\Controllers\BaseController::hasMenuShow(12, 2, \App\Http\Controllers\BaseController::enc(session()->get("auth")->userpositionid)))
                                    <div id="menu_RESTRICT" class="media">
                                        <div class="media-icon bg-success"><i class="typcn typcn-delete"></i></div>
                                        <a id="RESTRICT" style="cursor: pointer;" onclick="menu('RESTRICT')">
                                            <div class="media-body">
                                                <h6>제한лах</h6>
                                                <span>운송수단 제한</span>
                                            </div>
                                        </a>
                                    </div>
                                @endif
                                @if(\App\Http\Controllers\BaseController::hasMenuShow(19, 2, \App\Http\Controllers\BaseController::enc(session()->get("auth")->userpositionid)) && ($vehicle->status == 9 || $vehicle->status == 10 || $vehicle->status == 11))
                                <div id="menu_RESTORE_PLATE" class="media">
                                    <div class="media-icon bg-success"><i class="typcn typcn-arrow-sync"></i></div>
                                    <a id="RESTORE_PLATE" style="cursor: pointer;" onclick="menu('RESTORE_PLATE')">
                                        <div class="media-body">
                                            <h6>말소에서 복구</h6>
                                            <span>말소 상태 차량 복구</span>
                                        </div>
                                    </a>
                                </div>
                            @endif
                             
                                @endif
                            
                                    <div id="menu_DESCRIPTION_VEHICLE" class="media">
                                    <div class="media-icon bg-success"><i class="typcn typcn-input-checked-outline"></i></div>
                                    <a id="DESCRIPTION_VEHICLE" style="cursor: pointer;" onclick="menu('DESCRIPTION_VEHICLE')">
                                        <div class="media-body">
                                            <h6>특이사항</h6>
                                            <span>차량 위반 표시</span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <!--오른쪽 영역 끝-->
            </div>
        </div>
    </div>

    @include('Includes.footer')
</div>

@include('Includes.helper')

<div id="changePlateModal" class="modal">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">차량 번호 교체</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="change_plate_two_form" action="{{ route("change_plate_two") }}" method="POST">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="flexcroll">
                                <table class="table table-bordered table-striped mg-b-10" style="text-align: center;">
                                    <thead>
                                    <tr>
                                        <th style="width: 5%">№</th>
                                        <th style="width: 12%">교체 번호</th>
                                        <th style="width: 12%">번호판</th>
                                        <th style="width: 15%">차체번호</th>
                                        <th style="width: 12%">브랜드</th>
                                        <th style="width: 12%">모델</th>
                                        {{--<th style="width: 10%">상태</th>--}}
                                        <th style="width: 16%">성</th>
                                        <th style="width: 16%">이름</th>
                                        <th style="width: 16%">결제</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td><input type="text" id="change_plate1_id" name="change_plate1_number" value="" class="form-control number" oninput="translate2MGLTwo('change_plate1_id', this.value)" autocomplete="off" ></td>
                                        <td><input type="text" id="change_old_number1_id" name="change_old_number1_number" value="" class="form-control number" oninput="translate2MGLTwo('change_old_number1_id', this.value)" autocomplete="off" ></td>
                                        <td id="change_cabin_no1_id"></td>
                                        <td id="change_mark1_id"></td>
                                        <td id="change_model1_id"></td>
                                        {{--<td id="change_status1_id"></td>--}}
                                        <td id="change_last_name1_id"></td>
                                        <td id="change_first_name1_id"></td>
                                        <td id="change_first_pay1"></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td><input type="text" id="change_plate2_id" name="change_plate2_number" value="" class="form-control number" oninput="translate2MGLTwo('change_plate2_id', this.value)" autocomplete="off" ></td>
                                        <td><input type="text" id="change_old_number2_id" name="change_old_number2_number" value="" class="form-control number" oninput="translate2MGLTwo('change_old_number2_id', this.value)" autocomplete="off" ></td>
                                        <td id="change_cabin_no2_id"></td>
                                        <td id="change_mark2_id"></td>
                                        <td id="change_model2_id"></td>
                                        {{--<td id="change_status2_id"></td>--}}
                                        <td id="change_last_name2_id"></td>
                                        <td id="change_first_name2_id"></td>
                                        <td id="change_first_pay2"></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    
                    <button id="change_plate_two_btn" style="display: none;" type="button" class="btn btn-primary">저장</button>
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">닫기</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="ownerModal" class="modal">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">이전 소유자 정보</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="modalTableContainer flexcroll">
                            <table class="table table-bordered table-striped mg-b-10" style="text-align: center;">
                                <thead>
                                <tr>
                                    <th>시작 일자</th>
                                    <th>종료 일자</th>
                                    <th>등록번호</th>
                                    <th>성명</th>
                                    <th>주소</th>
                                    <th>연락처</th>
                                </tr>
                                </thead>
                                <tbody id="owners_table_id">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">닫기</button>
            </div>
        </div>
    </div>
</div>
<div id="ownerModal1" class="modal">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">이전 소유자 정보</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="modalTableContainer flexcroll">
                            <table class="table table-bordered table-striped mg-b-10" style="text-align: center;">
                                <thead>
                                <tr>
                                    <th>시작 일자</th>
                                    <th>종료 일자</th>
                                    <th>등록번호</th>
                                    <th>성명</th>
                                    <th>주소</th>
                                    <th>연락처</th>
                                </tr>
                                </thead>
                                <tbody id="owners_table_id1">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">닫기</button>
            </div>
        </div>
    </div>
</div>

<div id="ownerTwoModal" class="modal">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">소유자 정보</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="modalTableContainer flexcroll" style="height: 100px;">
                            <table class="table table-bordered table-striped mg-b-10" style="text-align: center;">
                                <thead>
                                <tr>
                                    {{--<th>시작 일자</th>--}}
                                    <th>국가</th>
                                    <th>등록번호</th>
                                    <th>유형</th>
                                    <th>성</th>
                                    <th>이름</th>
                                    <th>자택 주소</th>
                                    <th>자택 전화</th>
                                    <th>휴대폰</th>
                                    <th>직장 전화</th>
                                </tr>
                                </thead>
                                <tbody id="ownertwo_table">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">닫기</button>
            </div>
        </div>
    </div>
</div>

<div id="restrictModal" class="modal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">제한 등록</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route("restrict") }}" method="POST">
                    {{ csrf_field() }}
                    <input type="text" name="form" class="form-control" style="display: none;" value="limit">
                    <input type="text" name="form_plate" class="form-control" style="display: none;" value="{{ isset($vehicle) ? \App\Http\Controllers\BaseController::enc($vehicle->plate_no) : "" }}">
                    <input type="text" name="vvcabinid" class="form-control" style="display: none;" value="{{ isset($vehicle) ? \App\Http\Controllers\BaseController::enc($vehicle->id) : "" }}">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row row-xs align-items-center mg-b-5">
                                <div class="col-lg-6 col-md-12 col-sm-12">
                                    <label class="form-label mg-b-0">유형</label>
                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12">
                                    <select class="form-control select2-no-search" name="type">
                                        @if(ISSET($limits))
                                            @foreach($limits as $limit)
                                                <option value="{{ $limit->id ?? $limit->ID ?? $limit->Id }}">{{ \App\Helpers\TranslationHelper::translate($limit->name ?? $limit->NAME ?? $limit->Name ?? "") }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="row row-xs align-items-center mg-b-5">
                                <div class="col-lg-6 col-md-12 col-sm-12">
                                    <label class="form-label mg-b-0 required-input">일자</label>
                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12">
                                    <input id="restrictDate" name="date" type="text" class="form-control fc-datepicker" required autocomplete="off">
                                </div>
                            </div>
                            
                            <div class="row row-xs align-items-center mg-b-5">
                                <div class="col-lg-6 col-md-12 col-sm-12">
                                    <label class="form-label mg-b-0 required-input">공문 번호</label>
                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12">
                                    <input type="text" class="form-control" name="number" required autocomplete="off">
                                </div>
                            </div>
                            <div class="row row-xs align-items-center mg-b-5">
                                <div class="col-lg-6 col-md-12 col-sm-12">
                                    <label class="form-label mg-b-0 required-input">전화</label>
                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12">
                                    <input type="text" class="form-control" name="phone" required autocomplete="off">
                                </div>
                            </div>
                            <br/>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">저장</button>
                        <button type="button" class="btn btn-outline-light" data-dismiss="modal">닫기</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="restoreModalVehicle" class="modal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">말소에서 복구</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <label class="ckbox">
                            <input type="checkbox" id="isCheckRestoreArkh" onchange="isCheck(this.id);"><span>아카이브와 함께 복구</span>
                        </label>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <label class="ckbox">
                            <input type="checkbox" id="isCheckRestoreArkhNo" onchange="isCheck(this.id);"><span>아카이브 없이 복구</span>
                        </label>
                    </div>
                  
                </div>
            </div>
            <div class="modal-footer">
               
                <button type="button" class="btn btn-outline-light" data-dismiss="modal">닫기</button>
            </div>
        </div>
    </div>
</div>

<div id="activeModal" class="modal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">활성화</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route("active_vehicle") }}" method="POST">
                    {{ csrf_field() }}
                    <input type="text" name="form_plate" class="form-control" style="display: none;" value="{{ isset($vehicle) ? \App\Http\Controllers\BaseController::enc($vehicle->plate_no) : "" }}">
                    <input type="text" name="vvcabinid" class="form-control" style="display: none;" value="{{ isset($vehicle) ? \App\Http\Controllers\BaseController::enc($vehicle->id) : "" }}">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row row-xs align-items-center mg-b-5">
                                <div class="col-lg-6 col-md-12 col-sm-12">
                                    <label class="form-label mg-b-0 required-input">비고/설명</label>
                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12">
                                    <textarea type="text" rows="4" class="form-control richtextbox" name="description" required></textarea>
                                </div>
                            </div>
                            <br/>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">활성화</button>
                        <button type="button" class="btn btn-outline-light" data-dismiss="modal">닫기</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="descriptionModal" class="modal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">특이사항 입력</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route("description_vehicle") }}" method="POST">
                    {{ csrf_field() }}
                    <input type="text" name="form_plate" class="form-control" style="display: none;" value="{{ isset($vehicle) ? \App\Http\Controllers\BaseController::enc($vehicle->plate_no) : "" }}">
                    <input type="text" name="vvcabinid" class="form-control" style="display: none;" value="{{ isset($vehicle) ? \App\Http\Controllers\BaseController::enc($vehicle->id) : "" }}">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row row-xs align-items-center mg-b-5">
                                <div class="col-lg-4 col-md-12 col-sm-12">
                                    <label class="form-label mg-b-0 required-input">특이사항</label>
                                </div>
                                <div class="col-lg-8 col-md-12 col-sm-12">
                                    <textarea type="text" class="form-control richtextbox" style="height: 90px !important;" name="description" required></textarea>
                                </div>
                            </div>
                            <br/>
                            <h5 style="color: red;text-align: center">저장 버튼 클릭 시 즉시 등록되니 주의하세요!</h5>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">저장</button>
                        <button type="button" class="btn btn-outline-light" data-dismiss="modal">닫기</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="restoreModal" class="modal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">제한 해제/복구</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route("restrictrestore") }}" method="POST">
                    {{ csrf_field() }}
                    <input type="text" id="restore_form_plate" name="form_plate" class="form-control" style="display: none;" value="">
                    <input type="text" name="form_plate_no" class="form-control" style="display: none;" value="{{ isset($vehicle) ? \App\Http\Controllers\BaseController::enc($vehicle->plate_no) : "" }}">
                    <input type="text" name="vvcabinid" class="form-control" style="display: none;" value="{{ isset($vehicle) ? \App\Http\Controllers\BaseController::enc($vehicle->id) : "" }}">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row row-xs align-items-center mg-b-5">
                                <div class="col-lg-6 col-md-12 col-sm-12">
                                    <label class="form-label mg-b-0">유형</label>
                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12">
                                    <select class="form-control select2-no-search" name="type">
                                        @if(ISSET($limits))
                                            @foreach($limits as $limit)
                                                <option value="{{ $limit->id ?? $limit->ID ?? $limit->Id }}">{{ \App\Helpers\TranslationHelper::translate($limit->name ?? $limit->NAME ?? $limit->Name ?? "") }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="row row-xs align-items-center mg-b-5">
                                <div class="col-lg-6 col-md-12 col-sm-12">
                                    <label class="form-label mg-b-0 required-input">일자</label>
                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12">
                                    <input id="restrictDate1" name="date" type="text" class="form-control fc-datepicker" required autocomplete="off">
                                </div>
                            </div>
                            <div class="row row-xs align-items-center mg-b-5">
                                <div class="col-lg-6 col-md-12 col-sm-12">
                                    <label class="form-label mg-b-0 required-input">공문 번호</label>
                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12">
                                    <input type="text" class="form-control" name="number" required autocomplete="off">
                                </div>
                            </div>
                            <div class="row row-xs align-items-center mg-b-5">
                                <div class="col-lg-6 col-md-12 col-sm-12">
                                    <label class="form-label mg-b-0 required-input">전화</label>
                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12">
                                    <input type="text" class="form-control" name="phone" required autocomplete="off">
                                </div>
                            </div>
                            <br/>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">저장</button>
                        <button type="button" class="btn btn-outline-light" data-dismiss="modal">닫기</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="ownerShipModal" class="modal">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 id="owner_titile_id" class="modal-title">소유자 정보</h6><h5 style="color: red">소유자 정보 조회 시 주민번호(RD) 입력 및 소유자 유형을 반드시 선택해야 합니다!!!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>  
            <div class="modal-body">
                @include("System.ownercreatesection")
            </div>
        </div>
    </div>
</div>

<div id="archiveModal" class="modal">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">아카이브 정보</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="modalTableContainer flexcroll">
                            <table class="table table-bordered table-striped mg-b-10" style="text-align: center;width: 100%">
                                <thead>
                                <tr>
                                    <th>아카이브 번호</th>
                                    <th style="width: 7%;">일자</th>
                                    <th>번호판</th>
                                    <th>차체번호</th>
                                    <th>엔진 번호</th>
                                    <th>제조 연도</th>
                                    <th>수입 일자</th>
                                    <th>증명서 번호</th>
                                    <th>소유자</th>
                                    <th>담당자</th>
                                    <th>추가 정보</th>
                                    <th>작업</th>
                                </tr>
                                </thead>
                                <tbody id="archive_table_id">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">닫기</button>
            </div>
        </div>
    </div>
</div>

<div id="otherModal" class="modal">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">기타 차량 정보</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="modalTableContainer flexcroll">
                            <table class="table table-bordered table-striped mg-b-10" style="text-align: center;">
                                <thead>
                                <tr>
                                    <th>시작 일자</th>
                                    <th>번호판</th>
                                    <th>차체번호</th>
                                    <th>엔진 번호</th>
                                    <th>브랜드</th>
                                    <th>모델</th>
                                    <th>제조 일자</th>
                                    <th>색상</th>
                                </tr>
                                </thead>
                                <tbody id="vehicle_anothers_table">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">닫기</button>
            </div>
        </div>
    </div>
</div>

<div id="restrictHistoryModal" class="modal">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">제한 정보</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="modalTableContainer flexcroll">
                            <table class="table table-bordered table-striped mg-b-10" style="text-align: center;">
                                <thead>
                                <tr>
                                    <th>유형</th>
                                    <th>공문 №</th>
                                    <th>전화번호</th>
                                    <th>제한 일자</th>
                                    <th>제한 담당자</th>
                                    <th>복구 유형</th>
                                    <th>복구 공문 번호</th>
                                    <th>복구 일자</th>
                                    <th>복구 담당자</th>
                                    <th>작업</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(ISSET($limitedHistories))
                                    @foreach($limitedHistories as $history)
                                        <tr>
                                            <td>{{ $history->typename }}</td>
                                            <td>{{ $history->dec_no }}</td>
                                            <td>{{ $history->phone_no }}</td>
                                            <td>{{ $history->createddate }}</td>
                                            <td>{{ $history->createduser }}</td>
                                            <td>{{ $history->restoretypename }}</td>
                                            <td>{{ $history->restore_dec_no }}</td>
                                            <td>{{ $history->end_date }}</td>
                                            <td>{{ $history->restoreuser }}</td>
                                            <td>
                                                @if($history->is_restored == 0)
                                                    <a style="cursor:pointer;" onclick="restoreLimit('{{ \App\Http\Controllers\BaseController::enc($history->id) }}');">복구</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                                <tbody id="restrict_table">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">닫기</button>
            </div>
        </div>
    </div>
</div>

<div id="printModal" class="modal printable">
    <div class="modal-dialog modal-dialog-centered" role="document" style=" max-width: 1050px; ">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">증명서 인쇄</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="printSaveMessage" class="alert alert-outline-success" role="alert" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    저장되었습니다
                </div>
                <div class="row">
                    <div class="form-inline" style="margin: 10px">
                        <b  >프린터: </b>
                        <select id="device" class="form-control select2">
                            @if(ISSET($Printers))
                                @foreach($Printers as $printer)
                                    <option value="{{$printer->id}}">{{ \App\Helpers\TranslationHelper::translate($printer->name ?? "") }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="form-inline" style="margin: 10px">
                        <b  >위치: </b>
                        X: <input type="text" id="confX" width="50" value="60" class="form-control" style=" width: 50px; margin-left: 5px;"/>
                        Y: <input type="text" id="confY" width="50" value="10" class="form-control" style=" width: 50px; margin-left: 5px;"/>
                        행 간격: <input type="text" id="confRow" width="50" value="20" class="form-control" style=" width: 50px; margin-left: 5px;"/>
                        T텍스트 간격: <input type="text" id="confText" width="50" value="0" class="form-control" style=" width: 50px; margin-left: 5px;"/>
                        <button type="button" id="btnSavePrinter" class="btn btn-primary btn-block btnnopadding" style=" width: 80px; margin-left: 5px; ">저장</button>
                        <button type="button" id="yes" onclick="print('print_body')" data-dismiss="modal" class="btn btn-success btn-block btnnopadding" style=" width: 80px; margin-left: 5px; margin-top: 0;">인쇄</button>
                        <button type="button" data-dismiss="modal" class="btn btn-warning btn-block btnnopadding" style=" width: 80px; margin-left: 5px; margin-top: 0;color:#fff;">닫기</button>
                    </div>
                </div>
                <div class="print-body"  style="overflow: auto;border:1px solid black;font-size:14px; position: relative;background-image: url('{{asset("img/print_bg.jpg")}}');    overflow-x: hidden;" id="print_body">
                    <style>
                        @page { size: auto;  margin: 0mm; }
                    </style>

                    <div class="row" style="border:0px solid black" >
                        <div   style="border:0px solid red;float:left">
                            <div id="pflatNo" style="position: absolute;top:10px;left:60px" >
                                <span>{{ isset($vehicle) ? $vehicle->plate_no : "" }}</span>
                            </div>
                            <div id="pmark" style="position: absolute;top:30px;left:60px">
                                <span>{{ isset($vehicle) ? \App\Helpers\TranslationHelper::translate($vehicle->mark_name ?? "") : "" }}</span>
                            </div>
                            <div id="pmodel" style="position: absolute;top:50px;left:60px">
                                <span>{{ isset($vehicle) ? \App\Helpers\TranslationHelper::translate($vehicle->model_name ?? "") : "" }}</span>
                            </div>
                            <div id="pmod" style="position: absolute;top:70px;left:60px">
                                <span>{{ isset($vehicle) ? \App\Helpers\TranslationHelper::translate($vehicle->modificace_name ?? "") : "" }}</span>
                            </div>

                            <div id="pcapacity" style="position: absolute;top:70px;left:125px">
                                <span>{{ isset($vehicle) ? $vehicle->engine_capacity.", ".$vehicle->class_name.", ".$vehicle->eco_class_name : "" }}</span>
                            </div>

                            <div id="pweight" style="position: absolute;top:100px;left:50px;font-size:12px;">
                                <span>{{ isset($vehicle) ? $vehicle->total_weight : "" }} kg, 자중 {{ isset($vehicle) ? $vehicle->own_weight : "" }} кг</span>
                            </div>
                            <div id="pseat" style="position: absolute;top:120px;left:140px;">
                                <span>{{ isset($vehicle) ? $vehicle->max_load : "" }} kg, {{ isset($vehicle) ? $vehicle->seat_count : "" }}</span>
                            </div>
                            <div id="ptype" style="position: absolute;top:140px;left:90px;">
                                <span>{{ isset($vehicle) ? $vehicle->vehicle_type_name : "" }}</span>
                            </div>
                            <div id="pdedication" style="position: absolute;top:160px;left:90px;">
                                <span>{{ isset($vehicle) ? $vehicle->purpose_name : "" }}</span>
                            </div>
                            <div id="pmakeyear" style="position: absolute;top:180px;left:90px;">
                                <span>{{ isset($vehicle) ? $vehicle->build_year : "" }}</span>
                            </div>
                            <div id="pmotorNumber" style="position: absolute;top:200px;left:90px;">
                                <span>{{ isset($vehicle) ? $vehicle->engine_no : "" }}</span>
                            </div>

                            <div id="pshaftNumber" style="position: absolute;top:220px;left:90px;">
                                <span>{{ isset($vehicle) ? $vehicle->cabin_no : "" }}</span>
                            </div>
                            <div id="pcabinNumber" style="position: absolute;top:240px;left:90px;">
                                <span style="visibility: hidden;"></span>
                            </div>
                            <div id="pcolor" style="position: absolute;top:265px;left:120px;">
                                <span>{{ isset($vehicle) ? \App\Helpers\TranslationHelper::translate($vehicle->color_name ?? "") : "" }}</span>
                            </div>
                            <div id="pimportDate" style="position: absolute;top:290px;left:90px;">
                                <span>{{ isset($vehicle) ? \Carbon\Carbon::parse($vehicle->import_date)->format("Y-m-d") : "" }}</span>
                            </div>

                            {{--                            <div id="pYear" style="position: absolute;top:395px;left:105px;">--}}
                            {{--                                <span>{{ date("y")%10 }}</span>--}}
                            {{--                            </div>--}}
                            {{--                            <div id="pMonth" style="position: absolute;top:395px;left:145px;">--}}
                            {{--                                <span>{{ date("m") }}</span>--}}
                            {{--                            </div>--}}
                            {{--                            <div id="pDay" style="position: absolute;top:395px;left:205px;">--}}
                            {{--                                <span>{{ date("d") }}</span>--}}
                            {{--                            </div>--}}

                        </div>
                        <div  style="border:0px solid red;float:left;">
                            <div id="powner" style="position: absolute;top:40px;left:350px;font-size:14px;">
                                <?PHP
                                $name = isset($owners) && $owners->isNotEmpty() ? $owners->first()->last_name." ".$owners->first()->first_name : "";
                                if(mb_strlen($name) > 32){
                                    $extract = explode(" ", $name);
                                    $name = "";
                                    $str = false;
                                    foreach($extract as $ex){
                                        $name = $name." ".$ex;
                                        if(mb_strlen($name) > 32 && $str == false){
                                            $name = $name."<br>";
                                            $str = true;
                                        }
                                    }
                                }
                                echo "<span>".$name."</span>";
                                ?>
                            </div>
                            <div id="paddress" style="position: absolute;top:120px;left:330px;font-size:11px;">
                                <?PHP
                                $name = isset($owners) && $owners->isNotEmpty() ? $owners->first()->address_detail : "";
                                if(mb_strlen($name) > 48){
                                    $extract = explode(" ", $name);
                                    $name = "";
                                    $str = false;
                                    foreach($extract as $ex){
                                        $name = $name." ".$ex;
                                        if(mb_strlen($name) > 48 && $str == false){
                                            $name = $name."<br>";
                                            $str = true;
                                        }
                                    }
                                }
                                echo "<span>".$name."</span>";
                                ?>
                            </div>
                        </div>
                        <div class="col" style="border:0px solid red;">

                        </div>
                    </div>
                </div>
            </div>
            <!--<div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" id="yes" onclick="print('print_body')" value="인쇄" data-dismiss="modal">인쇄</button>
                <button type="button" class="btn btn-outline-light" data-dismiss="modal">닫기</button>
            </div>-->
        </div>
    </div>
</div>

<div id="printModalNEW" class="modal printable">
    <div class="modal-dialog modal-dialog-centered" role="document" style=" max-width: 1050px; ">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">증명서 인쇄</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="printSaveMessage2" class="alert alert-outline-success" role="alert" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    저장되었습니다
                </div>
                <div class="row">
                    <div class="form-inline" style="margin: 10px">
                        <b  >프린터: </b>
                        <select id="device2" class="form-control select2">
                            @if(ISSET($Printers))
                                @foreach($Printers as $printer)
                                    <option value="{{$printer->id}}">{{ \App\Helpers\TranslationHelper::translate($printer->name ?? "") }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="form-inline" style="margin: 10px">
                        <b  >위치: </b>
                        X: <input type="text" id="confX2" width="50" value="60" class="form-control" style=" width: 50px; margin-left: 5px;"/>
                        Y: <input type="text" id="confY2" width="50" value="10" class="form-control" style=" width: 50px; margin-left: 5px;"/>
                        행 간격: <input type="text" id="confRow2" width="50" value="20" class="form-control" style=" width: 50px; margin-left: 5px;"/>
                        T텍스트 간격: <input type="text" id="confText2" width="50" value="0" class="form-control" style=" width: 50px; margin-left: 5px;"/>
                        <button type="button" id="btnSavePrinter2" class="btn btn-primary btn-block btnnopadding" style=" width: 80px; margin-left: 5px; ">저장</button>
                        <button type="button" id="yes2" onclick="print2('print_body2')" data-dismiss="modal" class="btn btn-success btn-block btnnopadding" style=" width: 80px; margin-left: 5px; margin-top: 0;">인쇄</button>
                        <button type="button" data-dismiss="modal" class="btn btn-warning btn-block btnnopadding" style=" width: 80px; margin-left: 5px; margin-top: 0;color:#fff;">닫기</button>
                    </div>
                </div>
                <div class="print-body"  style="overflow: auto;border:1px solid black;font-size:14px; position: relative;background-image: url('{{asset("img/gerchilgee.png")}}');    overflow-x: hidden;" id="print_body2">
                    <style>
                        @page { size: auto;  margin: 0mm; }
                    </style>

                    <div class="row" style="border:0px solid black" >
                        <div   style="border:0px solid red;float:left">
                            <div id="pflatNo2" style="position: absolute;top:10px;left:60px" >
                                <span>{{ isset($vehicle) ? $vehicle->plate_no : "" }}</span>
                            </div>
                            <div id="pmark2" style="position: absolute;top:30px;left:60px">
                                <span>{{ isset($vehicle) ? \App\Helpers\TranslationHelper::translate($vehicle->modificace_name !='0' && $vehicle->modificace_name != "" ? $vehicle->mark_name.".".$vehicle->model_name."-".$vehicle->modificace_name : $vehicle->mark_name.".".$vehicle->model_name) : "" }}</span>
                            </div>

                            <div id="pcapacity2" style="position: absolute;top:70px;left:125px">
                                <span>{{ isset($vehicle) ? $vehicle->engine_capacity.", ".$vehicle->class_name.", ".$vehicle->eco_class_name : "" }}</span>
                            </div>

                            <div id="pweight2" style="position: absolute;top:100px;left:50px;font-size:12px;">
                                <span>{{ isset($vehicle) ? $vehicle->total_weight : "" }} kg, 자중 {{ isset($vehicle) ? $vehicle->own_weight : "" }} кг</span>
                            </div>
                            <div id="pseat2" style="position: absolute;top:120px;left:140px;">
                                <span>{{ isset($vehicle) ? $vehicle->max_load : "" }} kg, {{ isset($vehicle) ? $vehicle->seat_count : "" }}</span>
                            </div>
                            <div id="ptype2" style="position: absolute;top:140px;left:90px;">
                                <span>{{ isset($vehicle) ? $vehicle->vehicle_type_name : "" }}</span>
                            </div>
                            <div id="pdedication2" style="position: absolute;top:234px;left:90px;">
                                <span>{{ isset($vehicle) ? $vehicle->purpose_name : "" }}</span>
                            </div>
                            <div id="pmakeyear2" style="position: absolute;top:180px;left:90px;">
                                <span>{{ isset($vehicle) ? $vehicle->build_year : "" }}</span>
                            </div>
                            <div id="pmotorNumber2" style="position: absolute;top:200px;left:90px;">
                                <span>{{ isset($vehicle) ? $vehicle->engine_no : "" }}</span>
                            </div>

                            <div id="pshaftNumber2" style="position: absolute;top:220px;left:90px;">
                                <span>{{ isset($vehicle) ? $vehicle->cabin_no : "" }}</span>
                            </div>
                            <div id="pcabinNumber2" style="position: absolute;top:240px;left:90px;">
                                <span style="visibility: hidden;"></span>
                            </div>
                            <div id="pcolor2" style="position: absolute;top:265px;left:120px;">
                                <span>{{ isset($vehicle) ? \App\Helpers\TranslationHelper::translate($vehicle->color_name ?? "") : "" }}</span>
                            </div>
                            <div id="pspecial" style="position: absolute;top:275px;left:180px; font-size:12px;text-transform: uppercase; ">
                                <span>{{ isset($vehicle) ? $vehicle->special_name : "" }}</span>
                            </div>
                            <div id="pusername" style="position: absolute;top:275px;left:180px;  ">
                                <h6>{{ substr(session()->get("auth")->lastname, 0, 2).". ".session()->get("auth")->firstname }}</h6>
                            </div>
                            {{-- <div id="pusername2" style="position: absolute;top:295px;left:180px;  ">
                                <h6>{{\Carbon\Carbon::now()->format('Y')}}</h6>
                            </div> --}}

                            <div id="pimportDate2" style="position: absolute;top:290px;left:90px;">
                                <span>{{ isset($vehicle) ? \Carbon\Carbon::parse($vehicle->import_date)->format("Y-m-d") : "" }}</span>
                            </div>
                            {{--                            <div id="pYear2" style="position: absolute;top:395px;left:105px;">--}}
                            {{--                                <span>{{ date("y")%10 }}</span>--}}
                            {{--                            </div>--}}
                            {{--                            <div id="pMonth2" style="position: absolute;top:395px;left:145px;">--}}
                            {{--                                <span>{{ date("m") }}</span>--}}
                            {{--                            </div>--}}
                            {{--                            <div id="pDay2" style="position: absolute;top:395px;left:205px;">--}}
                            {{--                                <span>{{ date("d") }}</span>--}}
                            {{--                            </div>--}}
                        </div>
                        <div  style="border:0px solid red;float:left;">
                            <div id="powner2" style="position: absolute;top:40px;left:350px;font-size:17px;">
                                <?PHP
                                $name = isset($owners) && $owners->isNotEmpty() ? $owners->first()->last_name." ".$owners->first()->first_name : "";
                                if(mb_strlen($name) > 32){
                                    $extract = explode(" ", $name);
                                    $name = "";
                                    $str = false;
                                    foreach($extract as $ex){
                                        $name = $name." ".$ex;
                                        if(mb_strlen($name) > 32 && $str == false){
                                            $name = $name."<br>";
                                            $str = true;
                                        }
                                    }
                                }
                                echo "<span>".$name."</span>";
                                ?>
                            </div>
                            <div id="paddress2" style="position: absolute;top:120px;left:330px;font-size:14px;">
                                <?PHP
                                $name = isset($owners) && $owners->isNotEmpty() ? $owners->first()->address_detail : "";
                                if(mb_strlen($name) > 48){
                                    $extract = explode(" ", $name);
                                    $name = "";
                                    $str = false;
                                    foreach($extract as $ex){
                                        $name = $name." ".$ex;
                                        if(mb_strlen($name) > 48 && $str == false){
                                            $name = $name."<br>";
                                            $str = true;
                                        }
                                    }
                                }
                                echo "<span>".$name."</span>";
                                ?>
                            </div>

                        </div>
                        <div class="col" style="border:0px solid red;">

                        </div>
                    </div>
                </div>
            </div>
            <!--<div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" id="yes2" onclick="print2('print_body2')" value="인쇄" data-dismiss="modal">인쇄</button>
                <button type="button" class="btn btn-outline-light" data-dismiss="modal">닫기</button>
            </div>-->
        </div>
    </div>
</div>

<div id="gaali" class="modal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">세관 정보</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tbody id="gaaliTableBody"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div id="edit_onosh" class="modal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">알림</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if(ISSET($vehicle))
                    @if($vehicle->is_pending == 1)
                        <h2 style="color: red;"> {{ $vehicle->plate_no }} 해당 번호판 차량은 아카이브 자료 편철을 위한 기술 변경이 있어 아카이브를 편철해야 합니다.</h2>
                    @endif
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-light" data-dismiss="modal">닫기</button>
            </div>
        </div>
    </div>
</div>

<div id="onoshilgoo" class="modal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">검사 정보</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <table class="table table-bordered">
                    <tbody>
                    @if(isset($Diagnostic))

                        <tr>
                            <th><div style="font-weight: bold;">검사 일자</div></th>
                            <th><div>{{$Diagnostic->dateinspappr}}</div></th>
                        </tr>
                        <tr>
                            <th><div style="font-weight: bold;">재검사 일자</div></th>
                            <th><div>{{$Diagnostic->dateagain}}</div></th>
                        </tr>
                        <tr>
                            <th><div style="font-weight: bold;">합격 여부</div></th>
                            <th><div>{{$Diagnostic->passed_name}}</div></th>
                        </tr>
                        <tr>
                            <th><div style="font-weight: bold;">지점</div></th>
                            <th><div>{{$Diagnostic->branch_name}}</div></th>
                        </tr>
                        <tr>
                            <th><div style="font-weight: bold;">담당자</div></th>
                            <th><div>{{$Diagnostic->fullname}}</div></th>
                        </tr>
                        <tr>
                            <th><div style="font-weight: bold;">전화번호</div></th>
                            <th><div>{{$Diagnostic->insp_mobile_num}}</div></th>
                        </tr>
                        <tr>
                            <th><div style="font-weight: bold;">등록번호</div></th>
                            <th><div>{{$Diagnostic->insp_reg_no}}</div></th>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div id="torguuli" class="modal">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document" style=" width: 65%; ">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">과태료 정보</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row row-sm mg-b-20">
                    <div class="col-lg-6  mg-t-20 mg-sm-t-0">
                        <div class="card card-dashboard-twentysix card-dark-one readMoreTorguuli" style="background-color: #673ab7; background-image: linear-gradient(to bottom, #673ab7 0%, #673ab7 100%); background-repeat: repeat-x;">
                            <div class="card-header">
                                <h6 class="card-title"><i class="icon ion-md-cash"></i> 미납 과태료</h6>
                            </div>
                            <div class="card-body" style=" height: 60px; ">
                                <div class="pd-x-15">
                                    <h6><span id="totalUnPaid"></span></h6>
                                    <label class="readMoreTorguuli">상세</label>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mg-t-20 mg-lg-t-0">
                        <div class="card card-dashboard-twentysix card-dark-two readMoreTorguuli" style="background-color: #4caf50; background-image: linear-gradient(to bottom, #4caf50 0%, #4caf50 100%); background-repeat: repeat-x;">
                            <div class="card-header">
                                <h6 class="card-title"><i class="icon ion-md-card"></i> 검사 및 진단</h6>
                            </div>
                            <div class="card-body" style="    height: 60px;">
                                <div class="pd-x-15">
                                    @if(isset($Diagnostic))
                                        <h6><span id="totalPaid">{{$Diagnostic->passed_name}}</span></h6>
                                        <label class="readMoreTorguuli">{{$Diagnostic->dateinspappr}}</label>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered" id="torguuliTable" style="display: none;">
                    <thead>
                    <tr>
                        <th>
                            <div>상세</div>
                        </th>
                        <th>
                            <div style="text-align: center;">금액</div>
                        </th>
                        <th>
                            <div style="text-align: center;">일자</div>
                        </th>
                        <th>
                            <div style="text-align: center;">상태</div>
                        </th>
                    </tr>
                    </thead>
                    <tbody id="torguuliTableBody"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div id="tatvar" class="modal">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document" style=" width: 65%; ">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">세금 정보</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered" id="tatvarTable">
                    <thead>
                    <tr style="text-align: center;">
                        <th>
                            <div>연도</div>
                        </th>
                        <th>
                            <div>납부 일자</div>
                        </th>
                        <th>
                            <div>상세</div>
                        </th>
                        <th>
                            <div>합계 금액</div>
                        </th>
                        <th>
                            <div>상태</div>
                        </th>
                    </tr>
                    </thead>
                    <tbody id="tatvarTableBody"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div id="way" class="modal">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document" style=" width: 40%; ">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">도로 이용료 정보</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="col-lg-9  mg-t-20 mg-sm-t-0">
                    <div class="card card-dashboard-twentysix card-dark-one readMoreTorguuli" style=" background-color: #673ab7; background-image: linear-gradient(to bottom, #673ab7 0%, #673ab7 100%); background-repeat: repeat-x;">
                        <div class="card-header">
                            <h6 class="card-title"><i class="icon ion-md-cash"></i> 미납 도로 이용료</h6>
                        </div>
                        <div class="card-body" style=" height: 60px; ">
                            <div class="pd-x-15">
                                <h6><span id="unPaidWay"></span></h6>
                             
                            </div>

                        </div>
                    </div>
                </div>
                {{-- <table class="table table-bordered" id="tatvarTable">
                    <thead>
                    <tr style="text-align: center;">
                        <th>
                            <div>이름</div>
                        </th>
                        <th>
                            <div>결제</div>
                        </th>
                      
                    </tr>
                    </thead>
                    <tbody id="wayTableBody"></tbody>
                </table> --}}
            </div>
        </div>
    </div>
</div>

<div id="fingerModal" class="modal">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document" style="width: 50%">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">현재 소유자 본인 인증</h6>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <label class="ckbox">
                            <input type="checkbox" id="notCheckFinger" onchange="isCheck(this.id);"><span>미인식</span>
                        </label>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <label class="ckbox">
                            <input type="checkbox" id="checkFinger" onchange="isCheck(this.id);"><span>인식됨</span>
                        </label>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                      
                        <label class="ckbox">
                            <input type="checkbox" id="ntrCheck" onchange="isCheck(this.id);"><span>공증</span>
                        </label>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <label class="ckbox">
                            <input type="checkbox" id="contractFinger" onchange="isCheck(this.id);"><span>공문</span>
                        </label>
                    </div>
                </div>
                <div style="margin-bottom: 15px;">
                    <span id="fingerInfo" style="display: none;text-align:center;margin-top: 10px;"></span>
                    <span id="fingerImage" style="display: none;text-align:center;margin-top: 10px;"></span>
                </div>
                <div>
                    <input type="text" id="fingerDesc" style="display: none;" class="form-control" value="" placeholder="">
                </div>
                <div id="threeDiv" style="display: none;margin-top:10px">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <input type="text" id="registerThree" class="form-control" oninput="translate2MGLTwo('registerThree', this.value);" value="" placeholder="제3자 등록번호">
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <button type="button" class="btn btn-warning btn-block btnnopadding" onclick="threeConnect();">확인</button>
                        </div>
                    </div>
                </div>
                <div id="ntrCheckDiv" style="display: none;margin-top:10px">
                    <span style="font-size: 11px;
                    color: red;">주의: 0으로 시작하는 계약 번호의 마지막 3자리를 입력하여 확인하세요!!!</span>
                    <div class="row">
                       
                        <div class="col-lg-4 col-md-4 col-sm-12">
                           <div style="    margin-bottom: 8px;">
                            <input type="text" id="ntrBookNumber" class="form-control">
                           </div>
                           
                          
                            <input type="hidden"   id="cabinNumberNtr" value="{{ isset($vehicle) ? $vehicle->cabin_no : "" }}" class="form-control">
                            <input type="text" id="registerThreeNtr" class="form-control" oninput="translate2MGLTwo('registerThree', this.value);" value="" placeholder="제3자 등록번호">

                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-12">
                            <button type="button" style="
                            color: #fff;" class="btn btn-info btn-block btnnopadding" onclick="ntrlogin1();">확인</button>
                             <button type="button" style="
                             color: #fff;" class="btn btn-warning btn-block btnnopadding" onclick="threeConnect();">지문 확인</button>
                        </div>
                       
                        <div class="col-lg-6 col-md-6 col-sm-12" id="ntrDetail">
                            {{-- <h6 id="servicename" style=" text-align: center;color: #2f8605;"></h6> --}}
                            <table class="table table-bordered" id="ntrTable">
                              
                                <tbody id="ntrTableBody"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
           
            <div class="modal-footer" style="justify-content: center">
                <button type="button" class="btn btn-primary" onclick="closeFingerData();">닫기</button>
                <button type="button" class="btn btn-success" onclick="checkFingerData();">계속</button>
            </div>
        </div>
    </div>
</div>
<div id="transaction" class="modal">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document" style="width: 70%">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">결제 정보 확인</h6>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-2 col-md-6 col-sm-12">
                        <label class="ckbox">
                            <input type="checkbox" id="qPay" onchange="isCheck(this.id);"><span>QPAY & SocialPAY</span>
                        </label>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-12">
                        <label class="ckbox">
                            <input type="checkbox" id="esignPay" onchange="isCheck(this.id);"><span>전자 요청으로</span>
                        </label>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-12">
                        <label class="ckbox">
                            <input type="checkbox" id="geregePay" onchange="isCheck(this.id);"><span>Gerege</span>
                        </label>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-12">
                        <label class="ckbox">
                            <input type="checkbox" id="bankPay" onchange="isCheck(this.id);"><span>은행</span>
                        </label>
                    </div>
                   
                    <div class="col-lg-2 col-md-6 col-sm-12">
                        <label class="ckbox">
                            <input type="checkbox" id="moneyPay" onchange="isCheck(this.id);"><span>은행 POS</span>
                        </label>
                    </div>
                </div>
                
               
                <div style="margin-bottom: 15px;">
                    <span id="payInfo" style="display: none;text-align:center;margin-top: 10px;"></span>
                   
                </div>
                <div>
                    <input type="text" id="payDesc" style="display: none;" class="form-control" value="" placeholder="">
                </div>
              
            </div>
         
            <div class="col-lg-12 " id="payTableDiv" >
             <table style="display:none; " id="selectPay">
                 <td><span>결제 선택:</span></td>
                 <td>  <select name="" style="   height: 40px !important;
                    font-size: 14px;
                    font-weight: bold;
                    color: green;" class="form-control select2" id="paySelectData">
                  
             
    
                </select></td>
             </table>
              
                   
                
                  
                  
         
            
                {{-- <h6 id="servicename" style=" text-align: center;color: #2f8605;"></h6> --}}
                <table class="table table-bordered" border="1" id="payTable">
                  
                    <tbody id="payTableBody"></tbody>
                </table>
              
            </div>
            <div class="modal-footer" style="justify-content: center">
                <button type="button" class="btn btn-primary" onclick="closeFingerData();">닫기</button>
                <button type="button" class="btn btn-success" onclick="checkPayData();">계속</button>
            </div>
        </div>
    </div>
</div>

<div id="fingerOtherModal" class="modal">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document" style="width: 40%">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">지문 정보 확인</h6>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-8">
                        <div class="row row-xs align-items-center mg-b-5">
                            <div class="col-lg-3 col-md-12 col-sm-12">
                                <label class="form-label mg-b-0 required-input">등록번호/ID</label>
                            </div>
                            <div class="col-lg-9 col-md-12 col-sm-12">
                                <input id="otherRegister" name="otherRegister" oninput="translate2MGLTwo('otherRegister', this.value)" type="text" value="" class="form-control" autocomplete="off">
                            </div>
                        </div>
                        
                    </div>
                    <div class="col-4">
                        <div class="row row-xs align-items-center mg-b-5">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <button type="button" onclick="fingerOtherCheck();" class="btn btn-primary btn-block btnnopadding">확인</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="margin-bottom: 15px;">
                    <span id="fingerOtherImage" style="display: none;text-align:center;margin-top: 10px;"></span>
                </div>
              
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">닫기</button>
            </div>
        </div>
    </div>
</div>
<div id="eRequestCheckModal" class="modal">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document" style="width: 60%">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">전자 요청 목록</h6>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        {{-- <div class="row row-xs align-items-center mg-b-5">
                            <div class="col-lg-3 col-md-12 col-sm-12">
                                <label class="form-label mg-b-0 required-input">등록번호/ID</label>
                            </div>
                            <div class="col-lg-9 col-md-12 col-sm-12">
                                <input id="otherRegister" name="otherRegister" oninput="translate2MGLTwo('otherRegister', this.value)" type="text" value="" class="form-control" autocomplete="off">
                            </div>
                        </div> --}}
                        <div class="demo-container">
                            <div id="onlineRequestList"></div>
                            <div class="long-title" style="    margin-bottom: 15px;    text-align: center;"><h3 id="reqTitle" style="    margin-bottom: 1px;"></h3><span id="reqType" style="font-size: 13px;"></span></div>

                           
                                <div class="demo-container" id="reqDetial" style="display: none">
                                    <div  class="boxOptions1" >
                                        <div class="rect demo-dark" data-options="dxItem: {ratio: 2}" id="leftBox">
                                         
                                         
                                            <div id="formLeft"> </div>
                                         </div>
                                        <div class="rect demo-light" data-options="dxItem: {ratio: 2}">
                                        
                                         
                                            <div id="formRight"> </div>
                                            
                                   
                                        
                                         
                                            {{-- <div id="formRight2"> </div> --}}
                                            
                                         </div>
                                     
                                      </div>
                                    
                                    
                                  </div>
                                {{-- <img class="employeePhoto" /> --}}
                               
                                
                            
                          </div>
                    </div>
                  
                </div>
                <div style="margin-bottom: 15px;">
                    <span id="fingerOtherImage" style="display: none;text-align:center;margin-top: 10px;"></span>
                </div>
              
            </div>
            <div class="modal-footer">
                <div id="button"></div>
                    <button type="button" class="btn btn-default" data-dismiss="modal">닫기</button>
               
                <div id="buttonContainer">
                    
                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="userPkId" value="<?php if(isset($vehicle)) echo $userPkId; ?>"/>
<input type="hidden" id="vehicleId" value="<?php if(isset($vehicle)) echo $vehicle->id; ?>"/>
<input type="hidden" id="purposeId" value="<?php if(isset($vehicle)) echo $vehicle->purpose_id; ?>"/>

<script src="{{ asset('lib/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('lib/jquery-ui/ui/widgets/datepicker.js') }}"></script>
<script src="{{ asset('lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('lib/ionicons/ionicons.js') }}"></script>
<script src="{{ asset('lib/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('lib/datatables.net-dt/js/dataTables.dataTables.min.js') }}"></script>
<script src="{{ asset('lib/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('lib/datatables.net-responsive-dt/js/responsive.dataTables.min.js') }}"></script>
<script src="{{ asset('lib/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('lib/jquery.flot/jquery.flot.js') }}"></script>
<script src="{{ asset('lib/jquery.flot/jquery.flot.categories.js') }}"></script>
<script src="{{ asset('lib/jquery.flot/jquery.flot.resize.js') }}"></script>
<script src="{{ asset('lib/flot.curvedlines/curvedLines.js') }}"></script>
<script src="{{ asset('lib/jQuery-Mask-Plugin-master/src/jquery.mask.js') }}"></script>
<script src="{{ asset('js/vrs.js') }}"></script>
<script src="{{ asset('js/avtoteever.js') }}"></script>
<script src="{{ asset('lib/dev-extreme/js/dx.all.js')}}"></script>
<script src="{{ asset('data.js') }}"></script>
{{--<script src='https://www.jeasyui.com/easyui/jquery.easyui.min.js'></script>--}}
<script>
    $(document).ready(function() {
        //var sesionCheck =sessionStorage.getItem("isCheckRequset");
function hasNYearsPassed(year, n = 10) {
  const currentYear = new Date().getFullYear();
  return currentYear - year > n;
}
        var sesionCheck = sessionStorage.getItem('isCheckRequset');

                           
      var checkReq =JSON.parse(sesionCheck);
     // console.log(checkReq);
      var checkVeh= $('#purposeId').val();
      var is_moto = '{{ isset($vehicle) ? $vehicle->purpose_id == 9 ? 1 : 0 : 0 }}';
      var purposeCheck = '{{ isset($vehicle) ? $vehicle->purpose_id : 0 }}';
      var is_build = '{{ isset($vehicle) ? $vehicle->build_year  : 0 }}';
      var total_weight = '{{ isset($vehicle) ? $vehicle->total_weight  : 0 }}';
      var user =  {{session()->get("auth")->iscity }};
      var number =  $("#number_id").val();
//console.log(number);
    // console.log(total_weight);
if (hasNYearsPassed(is_build) && total_weight < 3500 && (purposeCheck == 1 || purposeCheck == 2 || purposeCheck == 3) && user == 1 && number == ""  ) {
    $("#menu_NEW").css('display', 'none');
    $("#buildYearText").css('display', 'block');
    $("#buildYearText").text("해당 차량은 10년 이상 노후화되어 울란바토르 번호판 발급이 불가능합니다!!!");
    $("#is_build").val("0");
}else if(hasNYearsPassed(is_build) && total_weight < 3500 && (purposeCheck == 1 || purposeCheck == 2 || purposeCheck == 3 ) && (user == 0 || user == 1)){
    $("#is_build").val("0");
}
     // if (is_moto == 1) {
      //  $("#menu_CHANGE_PLATE").css('display', 'none');
    //  }
    if (checkReq ) {
        $("#approveCode  ").val(checkReq.approveCode);
        $("#signed_data  ").val(checkReq.signed_data);
        if (checkReq.service_code == "VRS1") {
            menu_tor('NEW');
         //$("#cabin_no_id").attr("readonly", false);
         $("#fingerModal").modal("hide");
         $("#transaction").modal("show");
    //   //  sessionStorage.clear();
      
          $("#cert_id").attr("readonly", false);
         
    //      $("#number_id").attr("readonly", true);
          $("#page_count_id").attr("readonly", false);
          $("#description_id").attr("readonly", false);
          $('#plateColor').prop('disabled',false);
          $("#description_id").val("");
          $("#serviceTypeName").val("VRS");
          $("#fingerDescription").val(5);
          $("#page_count_id").val(1);
          $("#register_own").val(checkReq.new_owner);
          $("#fingerDesc").val("전자 소유권 이전");
          $("#fingerTotalDescription").val("전자 요청으로");
        //   $("#payDescription").val(1);
        //   $("#payDescriptionName").val("qPay & socialPay");
        //   if (checkVeh == 7 || checkVeh == 8 || checkVeh ==9) {
        //             $("#payAmount").val(14200);
        //       } else {
        //         $("#payAmount").val(14700);
        //       }
        sessionStorage.clear();
        }else if (checkReq.service_code == "VRS2") {
            menu_tor('MOVE');
         $("#fingerModal").modal("hide");
         $("#transaction").modal("show");
    //   //  sessionStorage.clear();
         $("#fingerDescription").val(5);
          $("#cert_id").attr("readonly", false);
    //      $("#number_id").attr("readonly", true);
          $("#page_count_id").attr("readonly", false);
          $("#description_id").attr("readonly", false);
          $('#plateColor').prop('disabled',false);
          $("#description_id").val("");
          $("#fingerDesc").val("전자 요청에 의한 이전");
          $("#fingerTotalDescription").val("전자 요청에 의한 이전");
          $("#serviceTypeName").val("VRS2");
         // $("#transactionId").val("VRS2");
         
          $("#page_count_id").val(1);
          $("#register_own").val(checkReq.new_owner);
         
        //   $("#payDescription").val(1);
        //   $("#payDescriptionName").val("qPay & socialPay");
        //   $("#payAmount").val(12500);

         // return false;
         sessionStorage.clear();
        } else if(checkReq.service_code == "VRS3") {
           
            menu_tor('MOVE_PLATE');
         $("#fingerModal").modal("hide");
         $("#transaction").modal("show");
    //   //  sessionStorage.clear();
         $("#fingerDescription").val(5);
          $("#cert_id").attr("readonly", false);
    //      $("#number_id").attr("readonly", true);
          $("#page_count_id").attr("readonly", false);
          $("#description_id").attr("readonly", false);
          $('#plateColor').prop('disabled',false);
          $("#description_id").val("");
          $("#serviceTypeName").val("VRS2");
         
          $("#page_count_id").val(1);
          $("#register_own").val(checkReq.new_owner);
          $("#fingerDesc").val("전자 이전 이동");
          $("#fingerTotalDescription").val("전자 요청으로 이전함");
        //   $("#payDescription").val(1);
        //   $("#payDescriptionName").val("qPay & socialPay");
          
        //     if (checkVeh == 7 || checkVeh == 8 || checkVeh ==9) {
        //             $("#payAmount").val(14200);
        //       } else {
        //         $("#payAmount").val(14700);
        //       }

          sessionStorage.clear();
        }
      
    }
   
        $(document).keydown(function(event) {
            if (event.keyCode == 27) {
                window.location.href = "{{ url('/vehicle') }}";
                return false;
            }
        });

        $('#cabin_no_id').keydown(function(event) {
            // enter has keyCode = 13, change it if you want to use another button
            if(is_new) {
                if (event.keyCode == 13) {
                    this.form.submit();
                    return false;
                }
            }

            if (event.keyCode == 27) {
                window.location.href = "{{ url('/vehicle') }}";
                return false;
            }
        });

        $('#change_old_number1_id').keydown(function(event) {
            if (event.keyCode == 13) {
                var plate = $("#change_old_number1_id").val();
                $("#change_plate2_id").val(plate);
                getVehicleInfo(1, plate);
            }
        });

        $('#change_old_number2_id').keydown(function(event) {
            if (event.keyCode == 13) {
                var plate = $("#change_old_number2_id").val();
                $("#change_plate1_id").val(plate);
                getVehicleInfo(2, plate);
            }
        });

        $('#number_id').keydown(function(event) {
            if (event.keyCode == 13) {
                // 차량번호 입력창에서는 작업 모드와 무관하게 조회를 우선한다.
                $("#main_form").attr('action', '{{ route("vehicle") }}');
                this.form.submit();
                return false;
            }
        });

        $('.number').keydown(function(event) {
            // enter has keyCode = 13, change it if you want to use another button
            if(is_new) {
                if (event.keyCode == 13) {
                    this.form.submit();
                    return false;
                }
            }

            if (event.keyCode == 27) {
                window.location.href = "{{ url('/vehicle') }}";
                return false;
            }
        });

        $( "#change_plate_two_btn" ).click(function() {
            $( "#change_plate_two_form" ).submit();
        });

        $('#register_own').keydown(function(event) {
            if (event.keyCode == 13) {
                var register = this.value;
                var type = $("#type_own").val();
                if(type == 1){
                    /*if(register.search(/[^а-яА-Я]+/) > 0){
                     if(register.length == 10){
                     var month = parseInt(register.substring(4, 6));
                     var day = parseInt(register.substring(6, 8));
                     if(day > 0 && day < 32 && month > 0 && month < 33){
                     loadData(this.value, "man");
                     } else {
                     alert('등록번호 алдаатай 입니다!');
                     }
                     } else {
                     alert('등록번호를 올바르게 입력하세요!');
                     }
                     } else {

                     }*/
                    if(register.length >= 6){
                        loadData(this.value, "man");
                    } else {
                        alert('등록번호를 올바르게 입력하세요!');
                    }
                } else {
                    if(register.length >= 7){
                        loadData(this.value, "company");
                    } else {
                        alert('등록번호를 올바르게 입력하세요!');
                    }
                }
            }
        });

        $('.number').on('keyup', function() {
            limitText(this, 13)
        });

        $('.cabin_no_id').on('keyup', function() {
            limitText(this, 18)
        });

        $('.number').keyup(function(){
            this.value = this.value.toUpperCase();
        });

        //Эхлэл
        $('#register').keyup(function(){
            this.value = this.value.toUpperCase();
        });

        $('#register').on('keyup', function() {
            limitText(this, 12)
        });

        $('#register_own').keyup(function(){
            this.value = this.value.toUpperCase();
        });

        $("#cert_id").on("keypress keyup",function (event) {
            this.value = this.value.toUpperCase();
           // $(this).val($(this).val().replace(/[^\d].+/, ""));
            // if ((event.which < 48 || event.which > 57)) {
              // event.preventDefault();
            // }
        });

        $('#register_own').on('keyup', function() {
            limitText(this, 13)
        });

        $('#surname').keyup(function(){
            this.value = this.value.toUpperCase();
        });

        $('#surname_own').keyup(function(){
            this.value = this.value.toUpperCase();
        });

        $('#familyname_own').keyup(function(){
            $(this).val($(this).val().substr(0, 1).toUpperCase() + $(this).val().substr(1).toLowerCase());
        });

        $('#parent_own').keyup(function(){
            var result = $(this).val().split("-");
            if(result.length == 1){
                $(this).val(result[0].substr(0, 1).toUpperCase() + result[0].substr(1).toLowerCase());
            } else {
                $(this).val(result[0].substr(0, 1).toUpperCase() + result[0].substr(1).toLowerCase()+"-"+result[1].substr(0, 1).toUpperCase() + result[1].substr(1).toLowerCase());
            }
        });


        $(".avtoteeverPreloader").fadeOut();
        $(".containerBody").fadeIn();

        //Принтерийн тохиргоо авчрах
        $('#device').on('change', function() {
            var printerID = this.value;
            $.ajax({
                type: 'POST',
                url: vrsUrl('/api/getPrinterConfig'),
                dataType: "json",
                data: {printerID: printerID},
                success: function (data) {
                    try {
                        $("#confX").val(data.x);
                        $("#confY").val(data.y);
                        $("#confRow").val(data.line);
                        $("#confText").val(data.text);
                        changeConfig();
                    }catch(err) {
                        console.log(err);
                    }
                }
            });
        });

        $("#device").change();

        $('#device2').on('change', function() {
            var printerID = this.value;
            $.ajax({
                type: 'POST',
                url: vrsUrl('/api/getPrinterConfig'),
                dataType: "json",
                data: {printerID: printerID},
                success: function (data) {
                    try {
                        $("#confX2").val(data.x);
                        $("#confY2").val(data.y);
                        $("#confRow2").val(data.line);
                        $("#confText2").val(data.text);
                        changeConfig2();
                    }catch(err) {
                        console.log(err);
                    }
                }
            });
        });
        $("#device2").change();
        //Принтер тохиргоо 저장
        $("#btnSavePrinter").click(function(){
            var printerDevice=$("#device").val();
            var printerX=$("#confX").val();
            var printerY=$("#confY").val();
            var printerLine=$("#confRow").val();
            var printerText=$("#confText").val();
            try {
                $.ajax({
                    type: 'POST',
                    url: vrsUrl('/api/savePrinterConfig'),
                    dataType: "text",
                    data: {id: printerDevice,x: printerX,y: printerY,line: printerLine,text: printerText},
                    success: function (data) {
                        if(data==1)
                        {
                            $("#printSaveMessage").show();
                            changeConfig();
                            setTimeout(function(){ $("#printSaveMessage").hide(); }, 3000);
                        }
                    }
                });
            }catch(err) {
                console.log(err);
            }
        });

        $("#btnSavePrinter2").click(function(){
            var printerDevice2=$("#device2").val();
            var printerX2=$("#confX2").val();
            var printerY2=$("#confY2").val();
            var printerLine2=$("#confRow2").val();
            var printerText2=$("#confText2").val();
            try {
                $.ajax({
                    type: 'POST',
                    url: vrsUrl('/api/savePrinterConfig'),
                    dataType: "text",
                    data: {id: printerDevice2,x: printerX2,y: printerY2,line: printerLine2,text: printerText2},
                    success: function (data) {
                        if(data==1)
                        {
                            $("#printSaveMessage2").show();
                            changeConfig2();
                            setTimeout(function(){ $("#printSaveMessage2").hide(); }, 3000);
                        }
                    }
                });
            }catch(err) {
                console.log(err);
            }
        });

        $( ".readMoreTorguuli" ).click(function() {
            $( "#torguuliTable" ).show();
        });

        //var printer_device_id = getCookie("printerdevice");
        //$('#device option[value="'+printer_device_id+'"]').attr("selected", "selected");
    });

    $(function(){
        'use strict'
        $( "#restrictDate" ).datepicker({
            changeMonth: true,
            changeYear: true
        });
        $( "#restrictDate" ).datepicker( "option", "dateFormat", "yy-mm-dd" );

        $( "#restrictDate1" ).datepicker({
            changeMonth: true,
            changeYear: true
        });
        $( "#restrictDate1" ).datepicker( "option", "dateFormat", "yy-mm-dd" );

        $( "#importdate" ).datepicker({
            changeMonth: true,
            changeYear: true
        });

        $( "#importdate" ).datepicker( "option", "dateFormat", "yy-mm-dd" );

        @if(ISSET($vehicle))
        $( "#importdate" ).val('{{ \Carbon\Carbon::parse($vehicle->import_date)->format("Y-m-d") }}');
        @endif

        $("#location_own option:contains(몽골)").prop('selected', true).change();
        $("#type_own option:contains(비율 хүн)").prop('selected', true).change();
        //화면 크기 관련 스크립트
        $('.az-iconbar .nav-link').on('click', function(e){
            e.preventDefault();

            $(this).addClass('active');
            $(this).siblings().removeClass('active');

            $('.az-iconbar-aside').addClass('show');

            var targ = $(this).attr('href');
            $(targ).addClass('show');
            $(targ).siblings().removeClass('show');
        });

        $('.az-iconbar-toggle-menu').on('click', function(e){
            e.preventDefault();

            if(window.matchMedia('(min-width: 992px)').matches) {
                $('.az-iconbar .nav-link.active').removeClass('active');
                $('.az-iconbar-aside').removeClass('show');
            } else {
                $('body').removeClass('az-iconbar-show');
            }
        })

        $('#azIconbarShow').on('click', function(e){
            e.preventDefault();
            $('body').toggleClass('az-iconbar-show');

            var targ = $('.az-iconbar .nav-link.active').attr('href');
            $(targ).addClass('show');
        });

        $(document).bind('click touchstart', function(e){
            e.stopPropagation();

            var azContent = $(e.target).closest('.az-content').length;
            var azIconBarMenu = $(e.target).closest('.az-header-menu-icon').length;

            if(azContent) {
                $('.az-iconbar-aside').removeClass('show');

                // for mobile
                if(!azIconBarMenu) {
                    $('body').removeClass('az-iconbar-show');
                }
            }
        });

        $('.modal.printable').on('shown.bs.modal', function () {
            $('.modal-dialog', this).addClass('focused');
            $('body').addClass('modalprinter');

            if ($(this).hasClass('autoprint')) {
                window.print();
            }
        }).on('hidden.bs.modal', function () {
            $('.modal-dialog', this).removeClass('focused');
            $('body').removeClass('modalprinter');
        });
    });

    function getVehicleInfo(type, plate) {
        $.ajax({
            type: "POST",
            url: vrsUrl('/api/rest_vehicle_info_data_test'),
            data: {"plate": plate},
            success: function( response ) {
                if(response == "false"){
                    alert(plate + " 번호тай 차량 찾을 수 없습니다.");
                    $("#change_plate_two_btn").css("display", "none");
                    $("#change_plate_two_pay").css("display", "none");
                } else if(response == "limited"){
                    $("#change_plate_two_btn").css("display", "none");
                    $("#change_plate_two_pay").css("display", "none");
                    alert(plate + " 번호тай 차량 제한тай 입니다.");
                } else {
                    
                    $("#change_cabin_no" + type + "_id").text(response["cabin_no"]);
                    $("#change_mark" + type + "_id").text(response["mark_name"]);
                    $("#change_model" + type + "_id").text(response["model_name"]);
                    //$("#change_status" + type + "_id").text(response["cabin_no"]);
                    $("#change_last_name" + type + "_id").text(response["last_name"]);
                    $("#change_first_name" + type + "_id").text(response["first_name"]);
                    change_count += 1;
                    $("#change_plate_two_btn").css("display", "block");
                    $("#change_plate_two_pay").css("display", "block");

                    twoPlateChangePay(response['id'],type);
                  console.log(type);
                }
            }
        })
    }
    function twoPlateChangePay(vehId,type) {
       // var param2 = JSON.stringify(serviceType);
        var param2 =  $("#serviceTypeName").val();
       // var param1 =JSON.stringify(vehId);
       var val = 14700;
        var param3 = JSON.stringify('{{ \App\Http\Controllers\BaseController::enc(\Carbon\Carbon::now()->format("Y-m-d")) }}');
        //console.log(val);
   
            $.ajax({
                type: 'post',
                url: vrsUrl('/api/transaction'),
                dataType: "json",
                data: {
                    param1: vehId,
                    param2: param2,
                    param3: param3,
                    param4: val,
                   
                },
               
                success: function (data) {

                   // console.log(data);
                    if (data.status=="error") {
                  $("#change_first_pay"+type).text("미납");
                  $( "#change_first_pay"+type ).css( "color", "red" );
                  change_count += 1;
                    }else{
                        if (data.account_number) {
                            
                       
                        $("#change_first_pay"+type).text("납부");
                        $( "#change_first_pay"+type ).css( "color", "green" );
                    }
                    }
                 
                   // var data1 =JSON.parse(data);
                // console.log(data);
                //   if (data.status=="error") {
                //    // console.log(data.msg);
                //    $("#payAmount").val(0);
                //    $( "#payInfo" ).css( "display", "block" );
                //     $( "#payTableDiv" ).css( "display", "none" );
                //     $( "#payInfo" ).css( "color", "red" );
                //     $( "#payInfo" ).text( data.msg );
                //   }else{
                  
                //    // const myArr = data.description.split(" ");
                //       //  var lastName=myArr[8].substring(0,1);
                //        // var firstName=myArr[7];
                    
                //    // $('#servicename').text(item['servicename']);
                //    $( "#payInfo" ).css( "display", "none" );
                //    $( "#payTableDiv" ).css( "display", "block" );
                //     document.getElementById("transactionId").value =data.id;
                //     document.getElementById("payAmount").value =data.amount;
               
                //      $("#payTableBody").html("");
                   
                //     var html = '<tr >' +
                       
                //                         ' <td>' + '<strong>Орлого орж ирсэн данс</strong>' + ' </td>' +
                //                         ' <td>' + data.account_number + ' </td>' +
                //                         '</tr>'+
                                        
                                      
                //                         '<tr style="">' +
                //                         ' <td>' +'<strong>검정ицсан данс</strong>' + ' </td>' +
                //                         ' <td>' + data.related_account + ' </td>'+
                //                         '<tr style="">' +
                //                         '<tr style="">' +
                //                         ' <td>' +'<strong>거래 일자</strong>' + ' </td>' +
                //                         ' <td>' + data.transaction_date + ' </td>'+
                //                         '<tr style="">' +
                //                         ' <td>' + '<strong style="color:green;">금액</strong>' + ' </td>' +
                //                         ' <td>' +'<strong style="color:green;">'+data.amount +"₮"+'</strong>' + ' </td>' +
                //                         '</tr>';
                                       
                                      
                //                     $("#payTableBody").append(html);



                //   }
                     
                      
               
                // },
                // error: function (jqXHR, textStatus, errorThrown) {
                //   console.log(errorThrown);
                }
            });
          
    }

    function submitForm(){
        var number = $("#number_id").val();
        var plateColor = $("#plateColor").val();

        if(number != "" && number != null){
            if(!is_new) {
                var page_count = $("#page_count_id").val().length;
                //alert(plateColor);
                if(page_count > 0 && page_count < 3){
                    if (selected_menu_name != "NEW" && selected_menu_name != "MOVE_PLATE" && selected_menu_name != "MOVE" && selected_menu_name != "RESTORE_PLATE") {
                        if(selected_menu_name == "EDIT"){
                            var text = $("#description_id").val();
                            if(text.length > 0){

                                var result = confirm("이 작업을 수행하시겠습니까?");
                                if (result == true) {
                                    $(".containerBody").fadeOut();
                                    $(".loader14").fadeIn();
                                    $("#main_form").submit();
                                }
                            }
                            else {
                                alert("비고/추가 정보 항목을 반드시 입력해 주세요.");
                            }
                        } else {
                            if(plateColor > 0){

                                var result = confirm("이 작업을 수행하시겠습니까?");
                                if (result == true) {
                                    $(".containerBody").fadeOut();
                                    $(".loader14").fadeIn();
                                    $("#main_form").submit();
                                }
                            }else{
                                alert("번호ын дэвсгэр өнгө 선택해 주세요.");
                            }
                        }
                    } else {
                        var is_show_modal = 0;
                        if(selected_menu_name == "NEW"){
                          
                            var gaali_text = $.trim($("#gaali_inv_id").val()).toUpperCase();
                            var curr_plate = $("#number_id").val();

                            if(gaali_text.length < 1){
                                is_show_modal = 1;
                                alert("세관 신고 번호를 반드시 입력해 주세요.");
                            }
                            if(plateColor < 1){
                                is_show_modal = 1;
                                alert("번호판 색상을 반드시 선택해 주세요.");
                            }
                            if(gaali_text == "DK"){
                                if(!curr_plate.includes("ДК")){
                                    is_show_modal = 1;
                                    alert("DK 세관 신고 차량에는 반드시 DK 번호를 부여해야 합니다.");
                                }
                            } else {
                                if(curr_plate.includes("ДК") && gaali_text != "DK"){
                                    is_show_modal = 1;
                                    alert("DK 세관 신고 차량에는 DK 번호만 부여할 수 있습니다.");
                                }
                            }
                        }
                        if(selected_menu_name == "CHANGE_PLATE_TWO"){
                            is_show_modal = 1;
                        }
                        if(is_show_modal == 0){
                            $("#owner_titile_id").text("소유자 정보");
                            $("#ownerShipModal").modal({'backdrop': 'static'});
                            $("#ownerShipModal").modal("show");
                        }
                    }
                } else {
                    alert("페이지 번호는 0보다 크고 99보다 작아야 합니다.");
                }
            } else {
                alert("저장하려면 서비스를 선택해야 합니다.");
            }
        } else {
            alert("차량 번호판을 반드시 입력해 주세요.");
        }
    }

    function restoreLimit(id) {
        $("#restrictHistoryModal").modal("hide");
        $("#restore_form_plate").val(id);
        $("#restoreModal").modal({'backdrop': 'static'});
        $("#restoreModal").modal("show");
    }

    function gaali(param) {
        $(".containerBody").fadeOut();
        $(".avtoteeverPreloader").fadeIn();
        $.ajax({
            type: 'POST',
            url: vrsUrl('/api/gaali'),
            dataType: "json",
            data: {
                param1: param,
                param2: '{{ \App\Http\Controllers\BaseController::enc(\Carbon\Carbon::now()->format("Y-m-d")) }}'
            },
            timeout: 60000,
            error: function (data) {
                $(".avtoteeverPreloader").fadeOut();
                $(".containerBody").fadeIn();
            },
            success: function (data) {
                try {

              //  console.log(data);
           
                    $("#gaaliTableBody").html("");
                    $.each(data, function (key, value) {
                    //    console.log(value.response.listData["buildDate"]);
                  //  console.log(Array.isArray(value.response.listData));
                    if(Array.isArray(value.response.listData) === false) {
                        var html =
                            '<tr>' +
                            '<td style="width:35%;font-weight: bold;"> 제조 일자 </td>' +
                            '<td style="width:75%"> ' + value.response.listData["buildDate"] + ' </td>' +
                            '</tr>'+
                            '<tr>' +
                            '<td style="font-weight: bold;"> 등록 일자 </td>' +
                            '<td> ' + value.response.listData["regDate"] + ' </td>' +
                            '</tr>'+
                            '<tr>' +
                            '<td style="font-weight: bold;"> 상태 </td>' +
                            '<td> ' + value.response.listData["changeMode"] + ' </td>' +
                            '</tr>'+
                            '<tr>' +
                            '<td style="font-weight: bold;"> 납부 </td>' +
                            '<td> ' + value.response.listData["cstmDutySumAmt"] + ' ₮</td>' +
                            '</tr>'+
                            '<tr>' +
                            '<td style="font-weight: bold;">세관 신고 번호 </td>' +
                            '<td> ' + value.response.listData["impExpDclrNo"] + '</td>' +
                            '</tr>'+
                            '<tr>' +
                            '<td style="font-weight: bold;">편철 모드 </td>' +
                            '<td> ' + value.response.listData["dclrTypeCd"] + '</td>' +
                            '</tr>'+
                            '<td style="font-weight: bold;"> 수령인 </td>' +
                            '<td> ' + value.response.listData["importerNm"] + '</td>' +
                            '</tr>'+
                            '</tr>'+
                            '<td style="font-weight: bold;"> 수령인 등록번호 </td>' +
                            '<td> ' + value.response.listData["importerRgNo"] + '</td>' +
                            '</tr>'+
                            '<tr>' +
                            '<td style="font-weight: bold;"> 전화 </td>' +
                            '<td> ' + value.response.listData["importerPhone"] + '</td>' +
                            '</tr>'+
                            '<tr>' +
                            '<td style="font-weight: bold;"> 주소 </td>' +
                            '<td> ' + value.response.listData["importerAddr"] + '</td>' +
                            '</tr>'+
                            '<tr>' +
                            '<td style="font-weight: bold;"> Хөдөлгүүр </td>' +
                            '<td> ' + value.response.listData["vehEngineNo"] + '</td>' +
                            '</tr>'+
                            '<tr>' +
                            '<td style="font-weight: bold;"> 브랜드 </td>' +
                            '<td> ' + value.response.listData["vehMark"] + '</td>' +
                            '</tr>'+
                            '<tr>' +
                            '<td style="font-weight: bold;"> 모델 </td>' +
                            '<td> ' + value.response.listData["vehModelNo"] + '</td>' +
                            '</tr>'+
                            '<tr>' +
                            '<td style="font-weight: bold;"> 상세 </td>' +
                            '<td> ' + value.response.listData["moreImpormation"] + '</td>' +
                            ' </tr>'
                    }else{
                        var html =
                            '<tr>' +
                            '<td style="width:35%;font-weight: bold;"> 제조 일자 </td>' +
                            '<td style="width:75%"> ' + value.response.listData[0]["buildDate"] + ' </td>' +
                            '</tr>'+
                            '<tr>' +
                            '<td style="font-weight: bold;"> 등록 일자 </td>' +
                            '<td> ' + value.response.listData[0]["regDate"] + ' </td>' +
                            '</tr>'+
                            '<tr>' +
                            '<td style="font-weight: bold;"> 상태 </td>' +
                            '<td> ' + value.response.listData[0]["changeMode"] + ' </td>' +
                            '</tr>'+
                            '<tr>' +
                            '<td style="font-weight: bold;"> 납부 </td>' +
                            '<td> ' + value.response.listData[0]["cstmDutySumAmt"] + ' ₮</td>' +
                            '</tr>'+
                            '<tr>' +
                            '<td style="font-weight: bold;">세관 신고 번호 </td>' +
                            '<td> ' + value.response.listData[0]["impExpDclrNo"] + '</td>' +
                            '</tr>'+
                            '<tr>' +
                            '<td style="font-weight: bold;">편철 모드 </td>' +
                            '<td> ' + value.response.listData[0]["dclrTypeCd"] + '</td>' +
                            '</tr>'+
                            '<td style="font-weight: bold;"> 수령인 </td>' +
                            '<td> ' + value.response.listData[0]["importerNm"] + '</td>' +
                            '</tr>'+
                            '</tr>'+
                            '<td style="font-weight: bold;"> 수령인 등록번호 </td>' +
                            '<td> ' + value.response.listData[0]["importerRgNo"] + '</td>' +
                            '</tr>'+
                            '<tr>' +
                            '<td style="font-weight: bold;"> 전화 </td>' +
                            '<td> ' + value.response.listData[0]["importerPhone"] + '</td>' +
                            '</tr>'+
                            '<tr>' +
                            '<td style="font-weight: bold;"> 주소 </td>' +
                            '<td> ' + value.response.listData[0]["importerAddr"] + '</td>' +
                            '</tr>'+
                            '<tr>' +
                            '<td style="font-weight: bold;"> Хөдөлгүүр </td>' +
                            '<td> ' + value.response.listData[0]["vehEngineNo"] + '</td>' +
                            '</tr>'+
                            '<tr>' +
                            '<td style="font-weight: bold;"> 브랜드 </td>' +
                            '<td> ' + value.response.listData[0]["vehMark"] + '</td>' +
                            '</tr>'+
                            '<tr>' +
                            '<td style="font-weight: bold;"> 모델 </td>' +
                            '<td> ' + value.response.listData[0]["vehModelNo"] + '</td>' +
                            '</tr>'+
                            '<tr>' +
                            '<td style="font-weight: bold;"> 상세 </td>' +
                            '<td> ' + value.response.listData[0]["moreImpormation"] + '</td>' +
                            ' </tr>'
                    }
                        $("#gaaliTableBody").append(html);
                    });
                    $('#gaali').modal('show');
                    $(".avtoteeverPreloader").fadeOut();
                    $(".containerBody").fadeIn();
                }catch(err) {
                    $(".avtoteeverPreloader").fadeOut();
                    $(".containerBody").fadeIn();
                }
            }
        });
    }
    function wayPayCheckLogin(param,param2,param3) {
 //console.log(param3);

        $.ajax({
            type: 'GET',
            url: vrsUrl('/api/wayPayLogin'),
            dataType: "json",
            // data: {
            //     param1: param,
            //     param2: '{{ \App\Http\Controllers\BaseController::enc(\Carbon\Carbon::now()->format("Y-m-d")) }}'
            // },
            timeout: 60000,
            success: function (data) {
                try {
                    var ownerRegNo="";

                    if (param2 !="" && param3 =="") {
                        ownerRegNo=param2;
                    } else if(param3 !="" && param2 !="" ) {
                        ownerRegNo=param3;
                    }

                //    console.log(ownerRegNo);
var token=data['data']['token'];
var plateNo=param;
             //console.log(data['data']['token']);
             wayPayCheck(token,plateNo,ownerRegNo);
        
                }catch(err) {
                    console.log(err);
                }
            }
        });
    }
    function wayPayCheck(token,plate_no,ownerRegNo) {
    //wayPayCheckLogin();
    //console.log(token);
     //var token= wayPayCheckLogin();
        $(".containerBody").fadeOut();
        $(".avtoteeverPreloader").fadeIn();
        $.ajax({
            type: 'POST',
            url: vrsUrl('/api/wayPay'),
            dataType: "json",
            data: {
                param1: plate_no,
                param4: ownerRegNo,

                param2: '{{ \App\Http\Controllers\BaseController::enc(\Carbon\Carbon::now()->format("Y-m-d")) }}',
                param3:token,
            },
            timeout: 60000,
            error: function (data) {

                $(".avtoteeverPreloader").fadeOut();
                $(".containerBody").fadeIn();
            },
            success: function (data) {
                try {

               console.log(data);
             $("#unPaidWay").html(data["data"]["invoiceSum"]+"₮");
                //     $("#wayTableBody").html("");
                 
                //     //    console.log(value.response.listData["buildDate"]);
                //   //  console.log(Array.isArray(value.response.listData));
                //  //   if(Array.isArray(value.response.listData) === false) {
                //         var html =
                //             '<tr>' +
                //             '<td style="width:35%;font-weight: bold;">결제 잔액 </td>' +
                //             '<td style="width:75%"> ' + data["data"]["invoiceSum"]+"₮" + ' </td>' +
                //             '</tr>'+
                //             '<tr>' ;
                        
                         
                    
                //         $("#wayTableBody").append(html);
               
                    $('#way').modal('show');
                    $(".avtoteeverPreloader").fadeOut();
                    $(".containerBody").fadeIn();
                }catch(err) {
                    $(".avtoteeverPreloader").fadeOut();
                    $(".containerBody").fadeIn();
                }
            }
        });
    }
    function torguuli(param) {
        $(".containerBody").fadeOut();
        $(".avtoteeverPreloader").fadeIn();
        var torguuli_count = 0;
       var torguuliData=[];
       const today = '{{ Carbon\Carbon::now()->format("Y-m-d H:i:s")}}';
        $.ajax({
            type: 'POST',
            url: vrsUrl('/api/penalty'),
            dataType: "json",
            data: {
                param1: param,
                param2: '{{ \App\Http\Controllers\BaseController::enc(\Carbon\Carbon::now()->format("Y-m-d")) }}'
            },
            timeout: 60000,
            error: function (data) {
                $(".avtoteeverPreloader").fadeOut();
                $(".containerBody").fadeIn();
            },
            success: function (data) {
                console.log(data);
                try {
                    
               
                    if(data["return"]["resultCode"] == 0){
                        $("#torguuliTableBody").html("");
                        $.each(data, function (key, value) {
                            // var size = Object.keys(value.response).length;

                             
                         
                            if (Array.isArray(value.response.listData) == false) {
                        //         console.log(Array.isArray(value.response.listData));
                       // console.log(value.response.listData);
                           
                      
                        var status = "납부";

if (value.response.listData['paid'] == false) torguuli_count = torguuli_count + 1;
  


if (value.response.listData['paid'] == false) status = "미납";


var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                                var passDate  = new Date( value.response.listData["passDate"]);
                                var style = status == '미납' ? "badge badge-danger" : "badge badge-success";
                                if (value.response.listData['paid'] == false) {
                                    var checkTorguuli= value.response.listData['passDate']+"-일에 부과된 과태료 "+value.response.listData["amount"].toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
                            
                                    torguuliData.push(checkTorguuli);
                               }
var html = '<tr>' +
    '<td style="width:70%;"><h5>' + value.response.listData["reasonType"] + '</h5>' +
    ' <small class="torguuliList"><i class="icon ion-ios-barcode"></i>' + value.response.listData["barCode"] + '</small>' +
    ' <small class="torguuliList"><i class="icon ion-ios-pin"></i>' + value.response.listData["localName"] + '</small>' +
    ' <small class="torguuliList"><i class="icon ion-ios-time"></i>' + value.response.listData["passDate"] + '</small></td>' +
    
    ' <td style="text-align: center;"><h5>' + value.response.listData["amount"].toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,') + ' ₮</h5></td>' +
    ' <td style="text-align: center;"><h5>' + passDate.toLocaleDateString( options) + '</h5></td>' +
    ' <td style="text-align: center;"><h5 class="'+style+'">' + status + '</h5></td>' +
    ' </tr>'
 $("#torguuliTableBody").append(html); 

                  
                            } else {
                                  // console.log(value.response.listData);
                              //  $("#torguuliTableBody").html("");
                            
                              value.response.listData.sort(function (a, b) {
	                            var passDateA = new Date(a.passDate), passDateB = new Date(b.passDate);
	                            return  passDateB-passDateA; 
   
                               });
//console.log(value.response.listData);
                                var tor = $('#number_id').val()+" 번호판 운송수단에 납부할 과태료가 없습니다 ";
                                torguuliData.push(tor);
                        value.response.listData.forEach(function (item) {
                           
                            
                              //  if(Date.parse(item.passDate) >= Date.parse('@if(isset($owners) && $owners->isNotEmpty()){{ $owners->first()->start_date }}@endif') && item.paid ==false) {
                                    var status = "납부";
                                 
                                    if (item.paid == false) torguuli_count = torguuli_count + 1;
                                    if (item.paid == false) status = "미납";
                                   var style = status == '미납' ? "badge badge-danger" : "badge badge-success";
                               // console.log(style);
                               if (item['paid'] == false) {
                                var checkTorguuli= item['passDate']+"-ний өдар торгуулсан "+item["amount"].toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
                              
                                torguuliData.push(checkTorguuli);
                               
                               }
                               var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                                var passDate  = new Date( item["passDate"]);
                                    var html =
                                    '<tr  >' +
                                        '<td style="width:70%;"><h5>' + item["reasonType"] + '</h5>' +
                                        ' <small class="torguuliList"><i class="icon ion-ios-barcode"></i>' + item["barCode"] + '</small>' +
                                        ' <small class="torguuliList"><i class="icon ion-ios-pin"></i>' + item["localName"] + '</small>' +
                                        ' <small class="torguuliList"><i class="icon ion-ios-time"></i>' + item["passDate"] + '</small></td>' +
                                        ' <td style="text-align: center;"><h5>' + item["amount"].toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,') + ' ₮</h5></td>' +
                                        ' <td style="text-align: center;"><h5>' + passDate.toLocaleDateString( options) + '</h5></td>' +
                                        ' <td style="text-align: center;  " ><h1 style="font-size: 14px;" class="'+style+'" >' + status + '</h1></td>' +
                                        ' </tr>'
                                       
                                    $("#torguuliTableBody").append(html);
                                   
                              //  }
                             
                            });
                        }
                        });
                       
                        $("#checkTorguuli").val(torguuliData);
                      
                       // console.log(torguuliData.length < 1 ? $('#number_id').val()+" 번호판тай тээврийн хэрэгслийг "+ today +" 확인할 때 төлөх торгууль байхгүй 입니다 " : torguuliData);
                        //console.log(torguuli_count);
                        $("#totalUnPaid").html(torguuli_count);
                        $('#torguuli').modal('show');
                       
                    }else{
                        var torguuliChk = $('#number_id').val()+" 번호판 운송수단에 납부할 과태료가 없습니다 ";
                                torguuliData.push(torguuliChk);
                                  // console.log(torguuliData);
                                   $("#checkTorguuli").val(torguuliData);
                    }
                    $(".avtoteeverPreloader").fadeOut();
                    $(".containerBody").fadeIn();
                }catch(err) {
                    //console.log(err);
                    $(".avtoteeverPreloader").fadeOut();
                    $(".containerBody").fadeIn();
                }
            }
        });
       
    }

    function tatvar(param) {
        $(".containerBody").fadeOut();
        $(".avtoteeverPreloader").fadeIn();
        try {
            $.ajax({
                type: 'post',
                url: vrsUrl('/api/tax'),
                dataType: "json",
                data: {
                    param1: param,
                    param2: '{{ \App\Http\Controllers\BaseController::enc(\Carbon\Carbon::now()->format("Y-m-d")) }}'
                },
                timeout: 60000,
                error: function (data) {
                    $(".avtoteeverPreloader").fadeOut();
                    $(".containerBody").fadeIn();
                },
                success: function (data) {
                   // console.log(data);
                    if(data["return"]["resultCode"] == 0){
                        $("#tatvarTableBody").html("");
                        $.each(data, function (key, value) {
                            try {
                                value.response.listData.forEach(function (item) {
                                    var status = "미납";
                                    if((parseFloat( item["airPollAmount"] )+ parseFloat( item["taxAmount"] )+ parseFloat( item["trafficAmount"] )) == (parseFloat( item["paidAirPollAmount"] )+ parseFloat( item["paidTaxAmount"] )+ parseFloat( item["paidTrafficAmount"] )))
                                        var status = "납부";
                                    var description = "<b>차량 취득세</b>: "+item["paidTaxAmount"]+"₮<br><b>대기 환경 개선 부담금:</b> "+item["paidAirPollAmount"]+"₮<br><b>도로 이용료:</b> "+item["paidTrafficAmount"]+"₮";
                                    var total = (parseFloat( item["paidAirPollAmount"] )+ parseFloat( item["paidTaxAmount"] )+ parseFloat( item["paidTrafficAmount"] ));
                                    var html = '<tr style="text-align:center">' +
                                        ' <td>' + item["year"] + ' </td>' +
                                        ' <td>' + item["paidDate"] + ' </td>' +
                                        ' <td>' + description + ' </td>' +
                                        ' <td>' + total + ' ₮</td>' +
                                        ' <td>' + status + '</td>' +
                                        ' </tr>';
                                    $("#tatvarTableBody").append(html);

                                });
                            } catch (err) {
                                $(".avtoteeverPreloader").fadeOut();
                                $(".containerBody").fadeIn();
                            }
                        });
                        $(".avtoteeverPreloader").fadeOut();
                        $(".containerBody").fadeIn();
                        $('#tatvar').modal('show');
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $(".avtoteeverPreloader").fadeOut();
                    $(".containerBody").fadeIn();
                }
            });
        }catch(err) {
            $(".avtoteeverPreloader").fadeOut();
            $(".containerBody").fadeIn();
        }
    }
 function ntrlogin1() {
        const bookNumber= $('#ntrBookNumber').val();
        const cabin= $('#cabinNumberNtr').val();
      //  console.log(bookNumber);
        $(".containerBody").fadeOut();
        $(".avtoteeverPreloader").fadeIn();
        try {
            $.ajax({
                type: 'post',
                url: vrsUrl('/api/serviceNTRLogin'),
                dataType: "json",
                data: {
                  
                    param1: '{{ \App\Http\Controllers\BaseController::enc(\Carbon\Carbon::now()->format("Y-m-d")) }}'
                },
                timeout: 60000,
                error: function (data) {
                    $(".avtoteeverPreloader").fadeOut();
                    $(".containerBody").fadeIn();
                },
                success: function (data) {
               //  console.log(data);

                    if (bookNumber !="") {
                        $( "#fingerInfo" ).css( "display", "none" );
                    
                   // var data1 =JSON.parse(data);
              // console.log(bookNumber);
               var sessionid=data['response'].result['sessionid'];
               var userKeyId=data['response'].result['userkeys'][0]['id'];
                    //  console.log(sessionid);
                    //  console.log(userKeyId);
                    //  console.log(bookNumber);
                    //  console.log(cabin);
                    // console.log(data['response'].result['userkeys'][0]['id']);
                   
                   if (bookNumber && cabin ) {
                    ntrLogin3(sessionid,userKeyId,bookNumber,cabin);
                    NtrRestWS(sessionid,userKeyId,bookNumber,cabin);
                    
                   }else{
                      // alert("fghgfhfg");
                   }
                }else{
                    $(".avtoteeverPreloader").fadeOut();
                    $(".containerBody").fadeIn();
                    $( "#fingerInfo" ).css( "display", "block" );
                    $( "#fingerInfo" ).css( "color", "red" );
                    $( "#fingerInfo" ).text( "계약 번호를 입력하세요." );
                }
               
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $(".avtoteeverPreloader").fadeOut();
                    $(".containerBody").fadeIn();
                }
            });
        }catch(err) {
            $(".avtoteeverPreloader").fadeOut();
            $(".containerBody").fadeIn();
        }
    };
    function ntrLogin3(param1,param2,param3,param4){
    // console.log(param3);
        // console.log(param4);
        
        $(".containerBody").fadeOut();
        $(".avtoteeverPreloader").fadeIn();
        try {
            $.ajax({
                type: 'post',
                url: vrsUrl('/api/ntrLogin3'),
                dataType: "json",
                data: {
                    param1: param1,
                    param2: param2,
                    param3: '{{ \App\Http\Controllers\BaseController::enc(\Carbon\Carbon::now()->format("Y-m-d")) }}'
                },
                timeout: 60000,
                error: function (data) {
                    $(".avtoteeverPreloader").fadeOut();
                    $(".containerBody").fadeIn();
                },
                success: function (data) {
                    //var data1 =JSON.parse(data);
              
              
                   //console.log(data);
                   // NtrRestWS(param1,param2,param3,param4);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $(".avtoteeverPreloader").fadeOut();
                    $(".containerBody").fadeIn();
                }
            });
        }catch(err) {
            $(".avtoteeverPreloader").fadeOut();
            $(".containerBody").fadeIn();
        }

    }

    function NtrRestWS(param1,param2,param3,param4){
        // console.log(param1);
        // console.log(param2);
        $(".containerBody").fadeOut();
        $(".avtoteeverPreloader").fadeIn();
        try {
            $.ajax({
                type: 'post',
                url: vrsUrl('/api/NtrRestWS'),
                dataType: "json",
                data: {
                    param1: param1,
                    param2: param2,
                    param3: param3,
                    param4: param4,
                    param5: '{{ \App\Http\Controllers\BaseController::enc(\Carbon\Carbon::now()->format("Y-m-d")) }}'
                },
                timeout: 60000,
                error: function (data) {
                    $(".avtoteeverPreloader").fadeOut();
                    $(".containerBody").fadeIn();
                },
                success: function (data) {
                   
//                     var size = Object.keys(data['response']['result']).length;
// //console.log(data['response']['result'] == "" ? "ok":"no");
//                     var ntrB=data['response']['result']['ntr_web_service_vehicle_party'][1];
//console.log(data['response']['result']);
                
                    //var data1 =JSON.parse(data);
                   
                //     if (data['response']['result'][0]) {
                //         console.log(data['response']['result'][0].id);
                //     }else{
                //         $(".avtoteeverPreloader").fadeOut();
                //    // $(".containerBody").fadeIn();
                //     console.log("fghgfdhfhfdh");
                //     }
                   if (data) {
                  //  if(data['response']['status'] =="error" || size <= 2    ){
                    if (data['response']['result'] == "") {
                        document.getElementById("fingerDesc").value ="";
                    document.getElementById("ntrBookdate").value ="";
                    document.getElementById("ntrBooknumber").value ="";
                    document.getElementById("ntrLastname").value ="";
                    document.getElementById("ntrFirstname").value ="";
                    document.getElementById("ntrServiceFile").value ="";
                    document.getElementById("ntrStateregnumber").value ="";
                   document.getElementById("registerThreeNtr").value ="";
                   document.getElementById("ntrPhone").value ="";
                   document.getElementById("ntrAddress").value ="";
                      //  console.log(data.response.text);
                        $("#ntrTableBody").html("");
                        $( "#fingerDesc" ).prop( "disabled", false );
                    

                   var html = '<tr >' +
                      
                                       ' <td style="color:red;">' + '오류 해당 차량에 대한 계약이 존재하지 않습니다.' + ' </td>' +
                                      
                                       
                                       ' </tr>';
                                    $("#ntrTableBody").append(html);
                    $(".avtoteeverPreloader").fadeOut();
                   // $(".containerBody").fadeOut();
                    }else{
                        $(".avtoteeverPreloader").fadeOut();
                        $( "#fingerDesc" ).prop( "disabled", true );
                      //  var size = Object.keys(data['response']['result']).length;
//console.log(data['response']['result'] == "" ? "ok":"no");
                    var ntrB=data['response']['result']['ntr_web_service_vehicle_party'][1];
                       
                    const item=data['response']['result'];
                   // $('#servicename').text(item['servicename']);
                  
                    document.getElementById("fingerDesc").value =item['servicename']+"№ "+item["booknumber"]+ ', 제3자 등록번호:'+ ntrB['stateregnumber'];
                    document.getElementById("ntrBookdate").value =item['bookdate'];
                    document.getElementById("ntrBooknumber").value =item['booknumber'];
                    document.getElementById("ntrLastname").value =ntrB['lastname'];
                    document.getElementById("ntrFirstname").value =ntrB['firstname'];
                    document.getElementById("ntrAddress").value =ntrB['address'];
                    document.getElementById("ntrPhone").value =ntrB['firstphone'];
                    document.getElementById("ntrServiceFile").value =item['physicalpath'];
                    document.getElementById("ntrStateregnumber").value =ntrB['stateregnumber'];
                   document.getElementById("registerThreeNtr").value =ntrB['stateregnumber'];
                //    document.getElementById("ntrPhone").value =item['firstphone'];
                //    document.getElementById("ntrAddress").value =item['address'];
                    //$("#registerThree").val(item['stateregnumber']);

               
                     $("#ntrTableBody").html("");
                   
                    

                    var html = '<tr >' +
                       
                                        ' <td>' + '<strong>계약 번호</strong>' + ' </td>' +
                                        ' <td>' + item["booknumber"] + ' </td>' +
                                        '</tr>'+
                                        '<tr style="">' +
                                        ' <td>' + '<strong>Гэрээ хийсэн</strong>' + ' </td>' +
                                        ' <td>' + item["bookdate"] + ' </td>' +
                                        '</tr>'+
                                      
                                        '<tr style="">' +
                                        ' <td>' +'<strong>성</strong>' + ' </td>' +
                                        ' <td>' + ntrB["lastname"] + ' </td>' +
                                        '</tr>'+
                                        '<tr style="">' +
                                        ' <td>' +'<strong>이름</strong>' + ' </td>' +
                                        ' <td>' + ntrB["firstname"] + ' </td>' +
                                      
                                        ' </tr>'+
                                        '<tr style="">' +
                                        ' <td>' +'<strong>등록번호</strong>' + ' </td>' +
                                        ' <td>' + ntrB["stateregnumber"] + ' </td>' +
                                      
                                        ' </tr>'+
                                        '<tr style="">' +
                                        ' <td>' +'<strong>전화</strong>' + ' </td>' +
                                        ' <td>' + ntrB["firstphone"] + ' </td>' +
                                      
                                        ' </tr>'+
                                        '<tr style="">' +
                                        ' <td>' +'<strong>상태</strong>' + ' </td>' +
                                        ' <td>' + item["statusname"] + ' </td>' +
                                      
                                        ' </tr>'+
                                        '<tr style="text-align:center;">' +
                                        ' <td>' +'<strong style="float: left;">Тээврийн хэрэгсэлд хийсэн<br> гэрээг <a href="'+item["physicalpath"]+'" target="_blank">Энд дарж</a>  харна уу</strong>' + ' </td>' +
                                        ' <td>' +  '<img style="max-width:142px;float: left;" src= "data:image/jpeg;base64,'+item["servicefile"]+'"/>' + ' </td>' +
                                      
                                        ' </tr>';
                                    $("#ntrTableBody").append(html);
                    $(".avtoteeverPreloader").fadeOut();
                 }
                   }

                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $(".avtoteeverPreloader").fadeOut();
                    $(".containerBody").fadeIn();
                }
            });
        }catch(err) {
            $(".avtoteeverPreloader").fadeOut();
            $(".containerBody").fadeIn();
        }

    }
    function onoshilgoo(id) {
        $('#onoshilgoo').modal('show');
    }

    var menus = ["NEW", "MOVE", "MOVE_PLATE", "EDIT", "CHANGE_PLATE", "CHANGE_CERT", "AGAIN_CERT", "RESTRICT", "REMOVE", "CHANGE_PLATE_TWO", "OWNER_REG", "DELETE_PLATE", "ACTIVE_VEHICLE", "RESTORE_PLATE", "DESCRIPTION_VEHICLE","PLATE_COLOR_CHANGE"];
    var menus_route = ['{{ route("new_vehicle") }}', '{{ route("move_owner_vehicle") }}', '{{ route("move_owner_plate_vehicle") }}', '{{ route("edit_vehicle") }}', '{{ route("change_plate") }}', '{{ route("change_cert") }}', '{{ route("again_cert") }}', "RESTRICT", '{{ route("remove") }}', '{{ route("change_plate_two") }}', '{{ route("owner_two_reg") }}', '{{ route("delete_plate") }}', 'ACTIVE_VEHICLE', '{{ route("restore_plate") }}', '{{ route("description_vehicle") }}','{{route("change_plate_color")}}'];
    var is_new = true;
    var is_select_vehicle = '{{ isset($vehicle) ? 1 : 0 }}';
    var is_pending = '{{ isset($vehicle) ? $vehicle->is_pending == 1 ? 1 : 0 : 0 }}';
    var selected_menu_name = null;
    var change_count = 0;

    @if(isset($vehicle_status))
    @if($vehicle_status == "old")
    $("#cabin_no_id").attr("readonly", false);
    @endif
    @if($vehicle_status == "new")
    $("#cabin_no_id").attr("readonly", false);
    @endif
    @endif

    function menu(name) {
        if(is_pending == 1){
            $("#edit_onosh").modal('show');
        }
        if(is_select_vehicle == 1 || name == "CHANGE_PLATE_TWO"){
            if(is_new){
                var torguuli_count = 0;
                menu_tor(name);
            }
        } else {
            alert("차량을 선택한 후에 작업을 수행할 수 있습니다.");
        }
    }

    function cancel_selected_menu(){
        if(is_select_vehicle == 1 && is_new == false){
            $.each( menus, function( menu_index, menu_name ){
                $("#menu_"+menu_name).css('display', 'flex');
            });
            selected_menu_name = null;
            is_new = true;
            $("#cert_id").attr("readonly", true);
            $("#page_count_id").attr("readonly", true);
            $("#description_id").attr("readonly", true);
            $("#build_month_id").attr("readonly", true);
            $("#build_year_id").attr("readonly", true);
            $("#importdate").attr("readonly", true);
            $("#main_form").attr('action', '{{ route("vehicle") }}');
        } else {
            window.location.href = "{{ url('/vehicle') }}";
            return false;
        }
    }

    function menu_tor(name){
       
        $.each( menus, function( menu_index, menu_name ){
            if(name != menu_name){
                $("#menu_"+menu_name).css('display', 'none');
            } else {
                $("#main_form").attr('action', menus_route[menu_index]);
                if(name == "CHANGE_CERT"){
                    $("#cert_id").attr("readonly", false);
                    $("#number_id").attr("readonly", true);
                    $("#page_count_id").attr("readonly", false);
                    $("#description_id").attr("readonly", false);
                    $("#description_id").val("");
                    $('#plateColor').prop('disabled',false);
                    $("#cabin_no_id").attr("readonly", true);
                    $("#serviceTypeName").val("VRS2");


                    $("#payAmount").val(0);
                    $( "#payTableDiv" ).css( "display", "none" );
                    $( "#bankPay" ).prop( "checked", false );
                    $( "#geregePay" ).prop( "checked", false );
                    $( "#moneyPay" ).prop( "checked", false );
                    $( "#qPay" ).prop( "checked", false );
                    finger();
                }
                if(name == "AGAIN_CERT"){
                    $("#cert_id").attr("readonly", false);
                    $("#number_id").attr("readonly", true);
                    $("#page_count_id").attr("readonly", false);
                    $("#description_id").attr("readonly", false);
                    $("#description_id").val("");
                    $('#plateColor').prop('disabled',false);
                    $("#cabin_no_id").attr("readonly", true);
                    $("#serviceTypeName").val("VRS6");


                    $("#payAmount").val(0);
                    $( "#payTableDiv" ).css( "display", "none" );
                    $( "#bankPay" ).prop( "checked", false );
                    $( "#geregePay" ).prop( "checked", false );
                    $( "#moneyPay" ).prop( "checked", false );
                    $( "#qPay" ).prop( "checked", false );

                    finger();
                }
                if(name == "CHANGE_PLATE"){
                    $("#cert_id").attr("readonly", false);
                    $("#number_id").attr("readonly", false);
                    $("#page_count_id").attr("readonly", false);
                    $("#description_id").attr("readonly", false);
                    $("#serviceTypeName").val("VRS4");
                    $("#description_id").val("");
                    $('#plateColor').prop('disabled',false);


                    $("#payAmount").val(0);
                    $( "#payTableDiv" ).css( "display", "none" );
                    $( "#bankPay" ).prop( "checked", false );
                    $( "#geregePay" ).prop( "checked", false );
                    $( "#moneyPay" ).prop( "checked", false );
                    $( "#qPay" ).prop( "checked", false );
                    finger();
                }
                if(name == "RESTORE_PLATE"){
                    $("#cert_id").attr("readonly", false);
                    $("#number_id").attr("readonly", false);
                    $("#page_count_id").attr("readonly", false);
                    $("#description_id").attr("readonly", false);
                    $("#description_id").val("");
                   
                        var statusCheck ='{{

                           isset($vehicle) ? $vehicle->status : ""}}';
                        if (statusCheck === "10") {
                            $("#restoreModalVehicle").modal("show");
                        } 
                    
                  
                    //console.log(userCheck);
                   // alert("kkkk");
                }
                if(name == "RESTRICT"){
                    $("#number_id").attr("readonly", true);
                    $("#restrictModal").modal("show");
                 //   alert("eeee");
                }
                if(name == "ACTIVE_VEHICLE"){
                    $("#number_id").attr("readonly", true);
                    $("#activeModal").modal("show");
                   // alert("tttt");
                }
                if(name == "EDIT"){
                    $("#cert_id").attr("readonly", false);
                    $("#number_id").attr("readonly", false);
                    $("#page_count_id").attr("readonly", false);
                    $("#description_id").attr("readonly", false);
                    $("#description_id").attr("required", true);
                    $("#description_id").val("");
                    $("#build_month_id").attr("readonly", false);
                    $("#build_year_id").attr("readonly", false);
                    $("#importdate").attr("readonly", false);
                    $('#plateColor').prop('disabled',false);
                    $("#serviceTypeName").val("VRSEDIT");
                    // $("#payAmount").val(0);
                    // $( "#payTableDiv" ).css( "display", "none" );
                    // $( "#bankPay" ).prop( "checked", false );
                    // $( "#geregePay" ).prop( "checked", false );
                    // $( "#moneyPay" ).prop( "checked", false );
                    // $( "#qPay" ).prop( "checked", false );
                    //alert("yyyyyy");
                    finger();
                }
                if(name == "MOVE"){
                    $("#cert_id").attr("readonly", false);
                    $("#number_id").attr("readonly", true);
                    $("#page_count_id").attr("readonly", false);
                    $("#description_id").attr("readonly", false);
                  
                    $('#plateColor').prop('disabled',false);
                    $("#description_id").val("");
                    $("#serviceTypeName").val("VRS2");


                    $("#payAmount").val(0);
                    $( "#payTableDiv" ).css( "display", "none" );
                    $( "#bankPay" ).prop( "checked", false );
                    $( "#geregePay" ).prop( "checked", false );
                    $( "#moneyPay" ).prop( "checked", false );
                    $( "#qPay" ).prop( "checked", false );

                    finger();
                   // alert("fdgfdg");
                }
                if(name == "MOVE_PLATE"){
                    $("#cert_id").attr("readonly", false);
                    $("#number_id").attr("readonly", false);
                    $("#page_count_id").attr("readonly", false);
                    $("#description_id").attr("readonly", false);
                    $("#serviceTypeName").val("VRS3");
                    $("#description_id").val("");
                    $('#plateColor').prop('disabled',false);

                    $("#payAmount").val(0);
                    $( "#payTableDiv" ).css( "display", "none" );
                    $( "#bankPay" ).prop( "checked", false );
                    $( "#geregePay" ).prop( "checked", false );
                    $( "#moneyPay" ).prop( "checked", false );
                    $( "#qPay" ).prop( "checked", false );
                    finger();
                }
                if(name == "NEW"){
                   
                    {{-- archive is stdClass in session; {{ }} cannot echo objects (htmlspecialchars). JS needs .id --}}
                    var userCheck = {!! json_encode(session()->get('archive')) !!} || {};
                    $("#transaction").modal({backdrop: 'static', keyboard: false, show: true});
                    $("#serviceTypeName").val("VRS");
                    $("#cert_id").attr("readonly", false);
                    $("#number_id").attr("readonly", false);
                    $("#page_count_id").attr("readonly", false);
                    $("#description_id").attr("readonly", false);
                    $("#description_id").val("");
                    $("#cabin_no_id").attr("readonly", false);
                    $('#plateColor').prop('disabled',false);
                 // alert(userCheck);
                 if(userCheck.id != 85){

                        $("#transaction").modal("show");
                       
                    
                    }else{

                        $("#transaction").modal("hide");
                       // console.log(userCheck); 
                    }
                   // $("#transaction").modal("show");
                    $("#serviceTypeName").val("VRS");
                    $("#payAmount").val(0);
                    $( "#payTableDiv" ).css( "display", "none" );
                    $( "#bankPay" ).prop( "checked", false );
                    $( "#geregePay" ).prop( "checked", false );
                    $( "#moneyPay" ).prop( "checked", false );
                    $( "#qPay" ).prop( "checked", false );
                }
                if(name == "REMOVE"){
                    $("#transaction").modal({backdrop: 'static', keyboard: false, show: true});
                    $("#number_id").attr("readonly", true);
                    $("#cabin_no_id").attr("readonly", true);
                    $("#page_count_id").attr("readonly", false);
                    $("#description_id").attr("readonly", false);
                    $("#description_id").val("");
                    $("#transaction").modal("show");
                   
                    $("#serviceTypeName").val("VRS11");

                    $("#payAmount").val(0);
                    $( "#payTableDiv" ).css( "display", "none" );
                    $( "#bankPay" ).prop( "checked", false );
                    $( "#geregePay" ).prop( "checked", false );
                    $( "#moneyPay" ).prop( "checked", false );
                    $( "#qPay" ).prop( "checked", false );
                   // alert("hasalt");
                }
                if(name == "CHANGE_PLATE_TWO"){
                    $("#changePlateModal").modal('show');
                    $("#serviceTypeName").val("VRS12");
                    $('#plateColor').prop('disabled',false);
                }
                if(name == "PLATE_COLOR_CHANGE"){
               
                    $('#plateColor').prop('disabled',false);
                    $("#page_count_id").attr("readonly", false);
                 
                }
                if(name == "OWNER_REG"){
                    $("#owner_titile_id").text("소유자 정보");
                    $("#page_count_id").attr("readonly", false);
                    $("#ownerShipModal").modal('show');
                }
                if(name == "DELETE_PLATE"){
                    $("#number_id").attr("readonly", true);
                    $("#cabin_no_id").attr("readonly", true);
                    $("#page_count_id").attr("readonly", false);
                    $("#description_id").attr("readonly", false);
                    $("#description_id").val("");
                    $('#plateColor').prop('disabled',false);
                    $("#serviceTypeName").val("VRS5");

                    $("#payAmount").val(0);
                    $( "#payTableDiv" ).css( "display", "none" );
                    $( "#bankPay" ).prop( "checked", false );
                    $( "#geregePay" ).prop( "checked", false );
                    $( "#moneyPay" ).prop( "checked", false );
                    $( "#qPay" ).prop( "checked", false );
                   // alert("문자 말소");
                    finger();
                }
                if(name == "DESCRIPTION_VEHICLE"){
                    $("#number_id").attr("readonly", true);
                    $("#cabin_no_id").attr("readonly", true);
                    $("#page_count_id").attr("readonly", true);
                    $("#description_id").attr("readonly", true);
                    $("#descriptionModal").modal("show");
                  //  alert("lllll");
                }
            }
        });
        selected_menu_name = name;
        is_new = false;
    }

    var fingerResult = null;
    var fingerResultText = null;

    function finger(){
        $( "#fingerInfo" ).css( "display", "none" );
        $( "#fingerImage" ).css( "display", "none" );
        $( "#fingerDesc" ).css( "display", "none" );
        $( "#checkFinger" ).prop( "checked", false );
        $( "#notCheckFinger" ).prop( "checked", false );
        $( "#contractFinger" ).prop( "checked", false );
        $( "#confirmFinger" ).prop( "checked", false );
        $("#fingerModal").modal({backdrop: 'static', keyboard: false, show: true});
       
    }

    function closeFingerData(){
        window.location.reload();
    }
  
function checkPayData() {

    var qPay = $('#qPay').is(':checked');
    var bankPay = $('#bankPay').is(':checked');
    var esignPay = $('#esignPay').is(':checked');
    var geregePay = $('#geregePay').is(':checked');
    var moneyPay = $('#moneyPay').is(':checked');
    var amount =  $("#payAmount").val();
    var payDescription="";
    $("#transaction").modal({backdrop: 'static', keyboard: false, show: true});
    if (qPay == true) {

        if (amount > 1) {
            $("#transaction").modal("hide");
        }else{
            $("#transaction").modal("show");
        }
        
        
       
    }else if(geregePay == true){
       
        $("#transaction").modal("hide");
        
    
    }
    else if(bankPay == true){
       
        $("#transaction").modal("hide");
        
    
    }
    
    else if(esignPay == true){
       
        $("#transaction").modal("hide");
        
    
    }
    
    else if(moneyPay == true){
      
        $("#transaction").modal("hide");
        
    }else{
        $( "#payInfo" ).css( "display", "block" );
                    $( "#payInfo" ).css( "color", "red" );
                    $( "#payInfo" ).text( "결제 수단을 반드시 선택해야 합니다." );
    }
    
}
    function checkFingerData(){
        $( "#fingerImage" ).css( "display", "none" );
        var nocheck = $("#notCheckFinger").is(':checked');
        var contract = $("#contractFinger").is(':checked');
        var confirm = $("#confirmFinger").is(':checked');
        var serviceCheck=$('#serviceTypeName').val();
        var ntrCheck = $("#ntrCheck").is(':checked');
       
   // console.log(userCheck);
  
        var fingerDescription = "";
        $("#transaction").modal({backdrop: 'static', keyboard: false, show: true});
        if(nocheck == true || contract == true || confirm == true || ntrCheck == true){
            if(contract == true){
                if($("#fingerDesc").val().length > 0){
                    if(is_three && is_three_valid){
                        $("#fingerTotalDescription").val($("#fingerDesc").val() + ", 제3자 등록번호:"+$("#registerThree").val());
                    } else {
                        $("#fingerTotalDescription").val($("#fingerDesc").val());
                    }
                    $("#fingerDescription").val(4);
                    $("#fingerModal").modal("hide");

                    if (serviceCheck != "VRSEDIT" ) {
                        
                        $("#transaction").modal("show");
                    }else{
                        //alert("gjgj");
                        $("#transaction").modal("hide");

                        }
                
                   
                } else {
                    $( "#fingerInfo" ).css( "display", "block" );
                    $( "#fingerInfo" ).css( "color", "red" );
                    $( "#fingerInfo" ).text( "공문 번호를 반드시 입력해야 합니다." );
                }
            }else if(ntrCheck == true){
                if($("#fingerDesc").val().length > 0){
                   
                   // alert("fgdf");
                    // if(is_three && is_three_valid){
                    //     $("#fingerTotalDescription").val($("#fingerDesc").val() + ", 제3자 등록번호:"+$("#registerThree").val());
                    // } else {
                       $("#fingerTotalDescription").val($("#fingerDesc").val());
                    // }
                    $("#fingerDescription").val(3);
                    $("#fingerModal").modal("hide");
                } else {
                    $( "#fingerInfo" ).css( "display", "block" );
                    $( "#fingerInfo" ).css( "color", "red" );
                    $( "#fingerInfo" ).text( "공증 계약 번호를 반드시 입력해야 합니다." );
                }
            } else if(confirm == true){
                if($("#fingerDesc").val().length > 0){
                    if(is_three && is_three_valid){
                        $("#fingerTotalDescription").val($("#fingerDesc").val() + ", 제3자 등록번호:"+$("#registerThree").val());
                    } else {
                        $("#fingerTotalDescription").val($("#fingerDesc").val());
                    }
                    $("#fingerDescription").val(3);
                    $("#fingerModal").modal("hide");

                    if (serviceCheck != "VRSEDIT" ) {
                        
                        $("#transaction").modal("show");
                    }else{

                        $("#transaction").modal("hide");
                           // alert("gf");

                        }

                  
                } else {
                    $( "#fingerInfo" ).css( "display", "block" );
                    $( "#fingerInfo" ).css( "color", "red" );
                    $( "#fingerInfo" ).text( "공증 서류 번호를 반드시 입력해야 합니다." );
                }
            } else {
                $("#fingerTotalDescription").val($("#fingerDesc").val());
                $("#fingerDescription").val(2);
                $("#fingerModal").modal("hide");
                if (serviceCheck != "VRSEDIT" ) {
                        
                   $("#transaction").modal("show");
                }else{
                    //alert("gjgj");
                   $("#transaction").modal("hide");

                      }
                     
            }
        } else {
           
            if(fingerResult == 0){
                $("#fingerTotalDescription").val(fingerResultText);
                $("#fingerDescription").val(1);
                $("#fingerModal").modal("hide");
               // alert("ghgfh");
               
            } else {
                $( "#fingerInfo" ).css( "display", "block" );
                $( "#fingerInfo" ).css( "color", "red" );
                $( "#fingerInfo" ).text( fingerResultText );
               
            }
          
        }
        
    }

    function checkFingerOther(){
        $("#fingerOtherModal").modal({backdrop: 'static', keyboard: false, show: true});
    }

    function fingerOtherCheck(){
        onConnectOther();
    }

    function onConnectOther() {
        var webSocket = new WebSocket("ws://localhost:81/service");
        webSocket.onopen = function () {
            webSocket.send("show");
        };

        webSocket.onmessage = function (evt) {
            if(evt.data!='' && evt.data!='Hello'){
                checkPersonOther(evt.data);
            }
        };
        webSocket.onclose = function () {
            $( "#fingerOtherImage" ).css( "display", "block" );
            $( "#fingerOtherImage" ).css( "color", "red" );
            $( "#fingerOtherImage" ).text( "장치 연결이 끊어졌습니다." );
        };
    };

    function checkPersonOther(finger){
        var register = $("#otherRegister").val();
        if(finger != "" && finger != null && register.length > 0){
            try {
                $( "#fingerOtherImage" ).css( "display", "block" );
                $( "#fingerOtherImage" ).css( "color", "green" );
                $( "#fingerOtherImage" ).text( "지문 정보를 확인하는 중..." );
                $.ajax({
                    type: 'POST',
                    url: vrsUrl('/api/fingerInfoImage'),
                    dataType: "text",
                    crossDomain : true,
                    data: {
                        param1: finger,
                        param2: register,
                        param3: '{{ \App\Http\Controllers\BaseController::enc(\Carbon\Carbon::now()->format("Y-m-d")) }}'
                    },
                    success: function (data) {
                        $( "#fingerOtherImage" ).css( "display", "block" );
                        $( "#fingerOtherImage" ).css( "font-size", "16px" );
                        $( "#fingerOtherImage" ).css( "font-weight", "bold" );
                        var text = "";
                        fingerResult = data;
                        if(data == "<div style='color:red'>지문 정보가 일치하지 않습니다</div>"){
                            $( "#fingerOtherImage" ).css( "color", "red" );
                            text = "지문이 일치하지 않습니다.";
                            $( "#fingerOtherImage" ).text(text);
                        } else if(data == "<div style='color:red'>잘못된 정보가 전송되었습니다</div>"){
                            $( "#fingerOtherImage" ).css( "color", "red" );
                            text = "등록번호 및 지문 정보가 잘못되었습니다.";
                            $( "#fingerOtherImage" ).text(text);
                        } else {
                            $( "#fingerOtherImage" ).css( "color", "green" );
                            $( "#fingerOtherImage" ).css( "display", "block" );
                            $( "#fingerOtherImage" ).html( data );
                        }
                    }
                });
            }catch(err) {
                $( "#fingerOtherImage" ).css( "color", "red" );
                $( "#fingerOtherImage" ).css( "display", "block" );
                $( "#fingerOtherImage" ).text( "지문 확인 중 오류가 발생했습니다." );
            }
        } else {
            $( "#fingerOtherCheck" ).css( "display", "block" );
            $( "#fingerOtherCheck" ).text( "지문 정보가 불완전합니다." );
        }
    }

    function onConnect() {
        var webSocket = new WebSocket("ws://localhost:81/service");
        webSocket.onopen = function () {
            webSocket.send("show");
        };

        webSocket.onmessage = function (evt) {
            if(evt.data!='' && evt.data!='Hello'){
                checkPerson(evt.data);
            }
        };
        webSocket.onclose = function () {
            $( "#fingerImage" ).css( "display", "none" );
            $( "#fingerInfo" ).css( "display", "block" );
            $( "#fingerInfo" ).css( "color", "red" );
            $( "#fingerInfo" ).text( "장치 연결이 끊어졌습니다." );
        };
    };

    function threeConnect(){
        onConnect();
    }
    var is_three = false;
    var is_three_valid = false;
    function checkPerson(finger){
        var register = '@if(isset($register)){{ $register }}@endif';
        var three_register = $("#registerThree").val();
        var three_register_ntr = $("#registerThreeNtr").val();
        if(three_register.length > 0){
            register = three_register;
            is_three = true;
        }else if(three_register_ntr.length >0){
            register = three_register_ntr;
            is_three = true;
        }
        if(finger != "" && finger != null && register.length > 0 ){
            try {
                $( "#fingerInfo" ).css( "display", "block" );
                $( "#fingerInfo" ).text( "지문 정보를 확인하는 중..." );
                $.ajax({
                    type: 'POST',
                    url: vrsUrl('/api/fingerInfoImage'),
                    dataType: "text",
                    crossDomain : true,
                    data: {
                        param1: finger,
                        param2: register,
                        param3: '{{ \App\Http\Controllers\BaseController::enc(\Carbon\Carbon::now()->format("Y-m-d")) }}'
                    },
                    success: function (data) {
                        $( "#fingerInfo" ).css( "display", "block" );
                        $( "#fingerInfo" ).css( "font-size", "16px" );
                        $( "#fingerInfo" ).css( "font-weigth", "bold" );
                        var text = "";
                        fingerResult = data;
                        if(data == "<div style='color:red'>지문 정보가 일치하지 않습니다</div>"){
                            $( "#fingerInfo" ).css( "color", "red" );
                            if(is_three){
                                text = "Гуравдагч этгээдийн хурууны хээ 일치하지 않음 입니다. РД:"+register;
                                $("#registerThree").val("");
                            } else {
                                text = "지문이 일치하지 않습니다. РД:"+register;
                            }
                            $( "#fingerImage" ).css( "display", "none" );
                        } else if(data == "<div style='color:red'>잘못된 정보가 전송되었습니다</div>"){
                            $( "#fingerInfo" ).css( "color", "red" );
                            text = "등록번호 및 지문 정보가 잘못되었습니다.";
                            $("#registerThree").val("");
                            $( "#fingerImage" ).css( "display", "none" );
                        } else {
                            $( "#fingerInfo" ).css( "color", "green" );
                            if(is_three){
                                text = "Гуравдагч этгээдийн хурууны хээ таарч 입니다. РД:"+register;
                                is_three_valid = true;
                            } else {
                                text = "지문이 일치합니다. РД:"+register;
                            }
                            $( "#fingerImage" ).css( "display", "block" );
                            $( "#fingerImage" ).html( data );
                            fingerResult = 0;
                        }
                        fingerResultText = text;
                        $( "#fingerInfo" ).text( text );
                    }
                });
            }catch(err) {
                $( "#fingerInfo" ).css( "color", "red" );
                $( "#fingerInfo" ).css( "display", "block" );
                $( "#fingerInfo" ).text( "지문 확인 중 오류가 발생했습니다." );
            }
        } else {
            $( "#fingerInfo" ).css( "display", "block" );
            $( "#fingerInfo" ).text( "지문 정보가 불완전합니다." );
        }
    }

    var old_finger = "";
    function isCheck(text){
        $( "#fingerImage" ).css( "display", "none" );
        $( "#threeDiv" ).css( "display", "none" );
        $( "#fingerInfo" ).text( "" );
        $( "#fingerDesc" ).val( "" );
        $( "#fingerDesc" ).css( "display", "none" );
        is_three = false;
        is_three_valid = false;
        if(old_finger != text){
            if(text == "notCheckFinger"){
                $( "#fingerDesc" ).prop( "disabled", false );
                $( "#checkFinger" ).prop( "checked", false );
                $( "#contractFinger" ).prop( "checked", false );
                $( "#confirmFinger" ).prop( "checked", false );
                $( "#ntrCheck" ).prop( "checked", false );
                $( "#fingerDesc" ).css( "display", "block" );
                $( "#ntrCheckDiv" ).css( "display", "none" );
                $( "#fingerDesc" ).focus(  );
                $( "#fingerDesc" ).attr( "placeholder", "비고를 입력하세요." );
            } else if(text == "checkFinger"){
                $( "#notCheckFinger" ).prop( "checked", false );
                $( "#contractFinger" ).prop( "checked", false );
                $( "#confirmFinger" ).prop( "checked", false );
                $( "#ntrCheck" ).prop( "checked", false );
                $( "#fingerInfo" ).css( "display", "block" );
                $( "#ntrCheckDiv" ).css( "display", "none" );
                $( "#fingerInfo" ).css( "color", "black" );
                $( "#fingerInfo" ).text( "장치에 연결하는 중입니다." );
                onConnect();
             } 
            //else if(text == "confirmFinger"){
            //     $( "#notCheckFinger" ).prop( "checked", false );
            //     $( "#checkFinger" ).prop( "checked", false );
            //     $( "#contractFinger" ).prop( "checked", false );
            //     $( "#fingerDesc" ).css( "display", "block" );
            //     $( "#threeDiv" ).css( "display", "block" );
            //     $( "#fingerDesc" ).focus(  );
            //     $( "#fingerDesc" ).attr( "placeholder", "공증 서류 번호를 입력하세요." );
            // } 
            else if(text == "ntrCheck"){
                $( "#fingerDesc" ).prop( "disabled", false );
               // $( "#fingerDesc" ).attr( "placeholder", "공증 서류 번호를 입력하세요." );
                $( "#notCheckFinger" ).prop( "checked", false );
                $( "#checkFinger" ).prop( "checked", false );
                $( "#contractFinger" ).prop( "checked", false );
                $( "#contractFinger" ).prop( "checked", false );
                 $( "#fingerDesc" ).css( "display", "block" );
                $( "#fingerDesc" ).attr( "placeholder", "" );
                $( "#ntrCheckDiv" ).css( "display", "block" );
                $( "#ntrBookNumber" ).css( "display", "block" );
                $( "#cabinNumberNtr" ).css( "display", "block" );
                $( "#fingerDesc" ).focus(  );
                $( "#ntrBookNumber" ).attr( "placeholder", "공증 계약 번호." );
            } else {
                $( "#fingerDesc" ).prop( "disabled", false );
                $( "#notCheckFinger" ).prop( "checked", false );
                $( "#checkFinger" ).prop( "checked", false );
                $( "#confirmFinger" ).prop( "checked", false );
                $( "#ntrCheck" ).prop( "checked", false );
                $( "#fingerDesc" ).css( "display", "block" );
                $( "#threeDiv" ).css( "display", "block" );
                $( "#ntrCheckDiv" ).css( "display", "none" );
                $( "#fingerDesc" ).focus(  );
                $( "#fingerDesc" ).attr( "placeholder", "공문 번호를 입력하세요." );
            }
        } else {
            if(text == "checkFinger"){
                $( "#checkFinger" ).prop( "checked", true );
                $( "#fingerInfo" ).css( "display", "block" );
                $( "#fingerInfo" ).css( "color", "black" );
                $( "#fingerInfo" ).text( "장치에 연결하는 중입니다." );
                onConnect();
            } else if(text == "notCheckFinger"){
                $( "#fingerDesc" ).prop( "disabled", false );
                $( "#notCheckFinger" ).prop( "checked", true );
                $( "#fingerDesc" ).css( "display", "block" );
                $( "#fingerDesc" ).focus(  );
                $( "#fingerDesc" ).attr( "placeholder", "공문 번호를 입력하세요." );
            // } else if(text == "confirmFinger"){
            //     $( "#confirmFinger" ).prop( "checked", true );
            //     $( "#fingerDesc" ).css( "display", "block" );
            //     $( "#threeDiv" ).css( "display", "block" );
            //     $( "#fingerDesc" ).focus(  );
            //     $( "#fingerDesc" ).attr( "placeholder", "공증 서류 번호를 입력하세요." );
            } else {
                $( "#fingerDesc" ).prop( "disabled", false );
                $( "#contractFinger" ).prop( "checked", true );
                $( "#fingerDesc" ).css( "display", "block" );
                $( "#threeDiv" ).css( "display", "block" );
                $( "#fingerDesc" ).focus(  );
                $( "#fingerDesc" ).attr( "placeholder", "비고를 입력하세요." );
            }
        }
        old_finger = text;
        if (text == "qPay") {
            $( "#bankPay" ).prop( "checked", false );
            $( "#esignPay" ).prop( "checked", false );
            $( "#geregePay" ).prop( "checked", false );
            $( "#moneyPay" ).prop( "checked", false );
            $("#payDescription").val(1);
            $("#payDescriptionName").val("qPay & socialPay");
            $( "#payTableDiv" ).css( "display", "block" );
            $("#payAmount").val(0);
         
            var checkVeh= $('#purposeId').val();
           
            var vehId =$('#vehicleId').val();
            var serviceType =document.getElementById("serviceTypeName").value;
           

            var serviceCheck=$('#serviceTypeName').val();
            if (serviceCheck == "VRS2") {
            
                $("#payAmount").val(12500);
            }else if (serviceCheck == "VRS3") {
                if (checkVeh == 7 || checkVeh == 8 || checkVeh ==9) {
                    $("#payAmount").val(14200);
              } else {
                $("#payAmount").val(14700);
              }
              //  $("#payAmount").val(14700);
            
            }else if (serviceCheck == "VRS4") {
           
                $("#payAmount").val(14700);
            
            }else if (serviceCheck == "VRS5") {
                
                $("#payAmount").val(31000);
            
            }else if (serviceCheck == "VRS") {
                if (checkVeh == 7 || checkVeh == 8 || checkVeh ==9) {
                    $("#payAmount").val(13600);
              } else {
                $("#payAmount").val(14700);
              }

               
            
            }else if (serviceCheck == "VRS6") {
             
                $("#payAmount").val(32500);
              
               // $("#payAmount").val(32500);
            
            }else if (serviceCheck == "VRS10") {
                $("#payAmount").val(12500);
            
            }else if (serviceCheck == "VRS11") {
                $("#payAmount").val(11000);
            
            }else if (serviceCheck == "VRS12") {
                $("#payAmount").val(14700);
            }
           var payCheck= $("#payAmount").val();
            transactionCheck(vehId,serviceType,payCheck);
        }else if (text == "geregePay") {
            $( "#bankPay" ).prop( "checked", false );
            $( "#esignPay" ).prop( "checked", false );
            $( "#esignPay" ).prop( "checked", false );
            $( "#qPay" ).prop( "checked", false );
            $( "#moneyPay" ).prop( "checked", false );
            $("#payDescription").val(2);
            $("#payDescriptionName").val("키오스크");
            $( "#payInfo" ).css( "display", "none" );
            $( "#payTableDiv" ).css( "display", "none" );
            var serviceCheck=$('#serviceTypeName').val();
            if (serviceCheck == "VRS2") {
                $("#payAmount").val(12500);
            }else if (serviceCheck == "VRS3") {
                if (checkVeh == 7 || checkVeh == 8 || checkVeh ==9) {
                    $("#payAmount").val(14200);
              } else {
                $("#payAmount").val(14700);
              }
            
            }else if (serviceCheck == "VRS4") {
                $("#payAmount").val(14700);
            
            }else if (serviceCheck == "VRS5") {
                $("#payAmount").val(31000);
            
            }else if (serviceCheck == "VRS") {
                if (checkVeh == 7 || checkVeh == 8 || checkVeh ==9) {
                    $("#payAmount").val(14200);
              } else {
                $("#payAmount").val(14700);
              }
               // $("#payAmount").val(14700);
            
            }else if (serviceCheck == "VRS6") {
                $("#payAmount").val(32500);
            
            }else if (serviceCheck == "VRS10") {
                $("#payAmount").val(11000);
            }
            
          
           
           // alert("fghgf");
        
        }
        else if (text == "bankPay") {
            $( "#geregePay" ).prop( "checked", false );
            $( "#esignPay" ).prop( "checked", false );
            $( "#qPay" ).prop( "checked", false );
            $( "#moneyPay" ).prop( "checked", false );
            $("#payDescriptionName").val("은행");
            $("#payDescription").val(3);
            $( "#payTableDiv" ).css( "display", "none" );
            $( "#payInfo" ).css( "display", "none" );
            var serviceCheck=$('#serviceTypeName').val();
            if (serviceCheck == "VRS2") {
                $("#payAmount").val(12500);
            }else if (serviceCheck == "VRS3") {
                $("#payAmount").val(14700);
            
            }else if (serviceCheck == "VRS4") {
                $("#payAmount").val(14700);
            
            }else if (serviceCheck == "VRS5") {
                $("#payAmount").val(31000);
            
            }else if (serviceCheck == "VRS") {
                $("#payAmount").val(14700);
            
            }else if (serviceCheck == "VRS6") {
                $("#payAmount").val(32500);
               
            }else if (serviceCheck == "VRS10") {
                $("#payAmount").val(11000);
            }
        
        }
        else if (text == "esignPay") {
            $( "#geregePay" ).prop( "checked", false );
            $( "#bankPay" ).prop( "checked", false );
            $( "#qPay" ).prop( "checked", false );
            $( "#moneyPay" ).prop( "checked", false );
            $("#payDescriptionName").val("전자 요청으로");
            $("#payDescription").val(5);
            $( "#payTableDiv" ).css( "display", "none" );
            $( "#payInfo" ).css( "display", "none" );
            var serviceCheck=$('#serviceTypeName').val();
            if (serviceCheck == "VRS2") {
                $("#payAmount").val(12500);
            }else if (serviceCheck == "VRS3") {
                $("#payAmount").val(14700);
            
            }else if (serviceCheck == "VRS4") {
                $("#payAmount").val(14700);
            
            }else if (serviceCheck == "VRS5") {
                $("#payAmount").val(31000);
            
            }else if (serviceCheck == "VRS") {
                $("#payAmount").val(14700);
            
            }else if (serviceCheck == "VRS6") {
                $("#payAmount").val(32500);
               
            }else if (serviceCheck == "VRS10") {
                $("#payAmount").val(11000);
            }
        
        }
        else if (text == "moneyPay") {
            $( "#geregePay" ).prop( "checked", false );
            $( "#qPay" ).prop( "checked", false );
            $( "#bankPay" ).prop( "checked", false );
            $( "#esignPay" ).prop( "checked", false );
            $("#payDescription").val(4);
            $("#payDescriptionName").val("은행 POS");
            $( "#payTableDiv" ).css( "display", "none" );
            $( "#payInfo" ).css( "display", "none" );
            var serviceCheck=$('#serviceTypeName').val();
            if (serviceCheck == "VRS2") {
                $("#payAmount").val(12500);
            }else if (serviceCheck == "VRS3") {
                $("#payAmount").val(14700);
            
            }else if (serviceCheck == "VRS4") {
                $("#payAmount").val(14700);
            
            }else if (serviceCheck == "VRS5") {
                $("#payAmount").val(31000);
            
            }else if (serviceCheck == "VRS") {
                $("#payAmount").val(14700);
            
            }else if (serviceCheck == "VRS6") {
                $("#payAmount").val(32500);
            
            }else if (serviceCheck == "VRS10") {
                $("#payAmount").val(11000);
            }
        }else if (text === "isCheckRestoreArkh") {
            $("#restoreStatusCheck").val(1);
            $( "#isCheckRestoreArkhNo" ).prop( "checked", false );
        } else if (text === "isCheckRestoreArkhNo"){
            $("#restoreStatusCheck").val(2);
            $( "#isCheckRestoreArkh" ).prop( "checked", false );
        }else {
            
        }

        
    }

function transactionCheck(vehId,serviceType,payCheck) {
        // console.log(serviceType);
        // console.log(param2);
        
        var param2 = JSON.stringify(serviceType);
        var param3 = JSON.stringify('{{ \App\Http\Controllers\BaseController::enc(\Carbon\Carbon::now()->format("Y-m-d")) }}');
      
        try {
            $.ajax({
                type: 'post',
                url: vrsUrl('/api/transaction'),
                dataType: "json",
                data: {
                    param1: vehId,
                    param2: param2,
                    param3: param3,
                    param4: payCheck,
                },
               
                success: function (data) {
                   // var data1 =JSON.parse(data);
                // console.log(data);
                
                  if (data.status=="error") {
                    console.log(data.msg);
                   $("#payAmount").val(0);
                    $( "#payInfo" ).css( "display", "block" );
                    $( "#payTableDiv" ).css( "display", "none" );
                    $( "#payInfo" ).css( "color", "red" );
                    $( "#payInfo" ).text( data.msg );
                  }else{
                  
                   // const myArr = data.description.split(" ");
                      //  var lastName=myArr[8].substring(0,1);
                       // var firstName=myArr[7];
                    
                   // $('#servicename').text(item['servicename']);
                   $( "#payInfo" ).css( "display", "none" );
                   $( "#payTableDiv" ).css( "display", "block" );
                   $( "#selectPay" ).css( "display", "block" );
                  
                    $('#paySelectData').html("");
                    $("#payTableBody").html("");
                    document.getElementById("transactionId").value =data[0].id;
                  //  document.getElementById("payAmount").data[0].amount;
                   $("#paySelectData").change(function(){

var thisval = $(this).val();  
let newArray = thisval.split(','); 

//console.log(newArray);
document.getElementById("transactionId").value =newArray[0];
document.getElementById("payAmount").value =newArray[1];
});
                    for (var i = 0; i < data.length; i++) {
                      
                     // console.log(data);
             
                     
    
                     var selOpts = "";
        
                var id = data[i].id;
                var amount = data[i].amount;
                var related_account = data[i].related_account ;
                var transaction_date = data[i].transaction_date;
                selOpts += "<option  value='"+id+','+amount+"'>"+"<label>금액:"+amount+"₮_</label>"+"<strong>확정 계좌:"+related_account+"_</strong>" + "<strong>일자:"+transaction_date+"</strong>"+"</option>";
       
              
               
                // document.getElementById("transactionId").value =1;
                //     document.getElementById("payAmount").value =222;
            $('#paySelectData').append(selOpts);
          
                 
                                }
                                $.each(data, function(key, value) {
            // here I want to loop through the returned results - for example
            $("#payTableBody").prepend(
                                         
                                           '<tr style="">' +
                                           ' <td>' +'<strong>확정 계좌</strong>' + ' </td>' +
                                           ' <td>' +value.related_account + ' </td>'+
                                         
                                           ' <td>' +'<strong>거래 일자</strong>' + ' </td>' +
                                           ' <td>' + value.transaction_date + ' </td>'+
                                          
                                           ' <td>' + '<strong style="color:green;">금액</strong>' + ' </td>' +
                                           ' <td>' +'<strong style="color:green;">'+value.amount +"₮"+'</strong>' + ' </td>' +
                                           '</tr>');
        });

                  }
                  
                      
               
                },
                error: function (jqXHR, textStatus, errorThrown) {
                  console.log(errorThrown);
                }
            });
        }catch(err) {
            console.log(err);
        }

    }
    function print(elem){
        try {
            setRegCertificate(elem);
        } catch (e) {
            alert(e);
        }
    }

    function print2(elem){
        try {
            setRegCertificate(elem);
        } catch (e) {
            alert(e);
        }
    }

    function changeConfig(){
        try{
            var confX = parseInt($("#confX").val());
            var confY = parseInt($("#confY").val());
            var confRow = parseInt($("#confRow").val());
            var confText = parseInt($("#confText").val());
            //First column
            $("#pflatNo").css({top: confY+'px', left: confX+'px', position:'absolute'});
            $("#pmark").css({top: (confY+1*confRow)+'px', left: (confX)+'px', position:'absolute'});
            $("#pmodel").css({top: (confY+2*confRow)+"px", left: (confX)+"px", position:'absolute'});
            $("#pcapacity").css({top: (confY+3*confRow)+"px", left: (confX+65)+"px", position:'absolute'});
            $("#pweight").css({top: (confY+4*confRow)+"px", left: (confX)+"px"});
            $("#pseat").css({top: (confY+5*confRow)+"px", left: (confX+100)+"px"});
            $("#ptype").css({top: (confY+6*confRow)+"px", left: (confX+30)+"px"});
            $("#pdedication").css({top: (confY+7*confRow)+"px", left: (confX+30)+"px"});
            $("#pmakeyear").css({top: (confY+8*confRow)+"px", left: (confX+30)+"px"});
            $("#pmotorNumber").css({top: (confY+9*confRow)+"px", left: (confX+30)+"px"});
            $("#pshaftNumber").css({top: (confY+10*confRow)+"px", left: (confX+30)+"px"});
            $("#pcabinNumber").css({top: (confY+11*confRow)+"px", left: (confX+30)+"px"});
            $("#pcolor").css({top: (confY+12*confRow)+"px", left: (confX+30)+"px"});
            $("#pimportDate").css({top: (confY+13*confRow)+"px", left: (confX+30)+"px"});
            $("#powner").css({top: (confY+10)+"px", left: (confX+270)+"px"});
            $("#paddress").css({top: (confY+10+40)+"px", left: (confX+250)+"px"});

        }catch(e){
            alert(e);
        }
    }

    function changeConfig2(){
        try{
            var confX2 = parseInt($("#confX2").val());
            var confY2 = parseInt($("#confY2").val());
            var confRow2 = parseInt($("#confRow2").val());
            var confText2 = parseInt($("#confText2").val());
            //First column
            $("#pflatNo2").css({top: (confY2+0.5*confRow2)+'px', left: confX2+'px', position:'absolute'});
            $("#pmark2").css({top: (confY2+2.5*confRow2)+'px', left: (confX2)+'px', position:'absolute'});
            // $("#pmodel2").css({top: (confY2+2.5*confRow2)+"px", left: (confX2+140)+"px", position:'absolute'});
            $("#pcapacity2").css({top: (confY2+4*confRow2)+"px", left: (confX2+90)+"px", position:'absolute'});
            $("#pweight2").css({top: (confY2+6.5*confRow2)+"px", left: (confX2)+"px"});
            $("#pseat2").css({top: (confY2+8*confRow2)+"px", left: (confX2+12)+"px"});
            $("#ptype2").css({top: (confY2+10*confRow2)+"px", left: (confX2+30)+"px"});


            $("#pdedication2").css({top: (confY2+12*confRow2)+"px", left: (confX2+30)+"px"});
            $("#pcabinNumber2").css({top: (confY2+13*confRow2)+"px", left: (confX2+30)+"px"});
            $("#pshaftNumber2").css({top: (confY2+14*confRow2)+"px", left: (confX2+30)+"px"});


            $("#pmotorNumber2").css({top: (confY2+0.5*confRow2)+"px", left: (confX2+350)+"px"});
            $("#pmakeyear2").css({top: (confY2+2*confRow2)+"px", left: (confX2+350)+"px"});
            $("#pimportDate2").css({top: (confY2+3.5*confRow2)+"px", left: (confX2+350)+"px"});
            $("#pcolor2").css({top: (confY2+5*confRow2)+"px", left: (confX2+320)+"px"});

            $("#powner2").css({top: (confY2+11*confRow2)+"px", left: (confX2+270)+"px"});
            $("#paddress2").css({top: (confY2+15*confRow2)+"px", left: (confX2+230)+"px"});

            $("#pspecial").css({top: (confY2+12*confRow2)+"px", left: (confX2+600)+"px"});
            $("#pusername").css({top: (confY2+0.5*confRow2)+"px", left: (confX2+660)+"px"});
            $("#pusername2").css({top: (confY2+5*confRow2)+"px", left: (confX2+660)+"px"});
        }catch(e){
            alert(e);
        }
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
        "/": "Ю",

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

    var Cyr2Lat = {
        "Й":"a" ,
        "М":"b" ,
        "Ё":"c" ,
        "Б":"d",
        "У": "e" ,
        "Ө":"f" ,
        "А":"g" ,
        "Х":"h" ,
        "Ш":"i" ,
        "Р":"j" ,
        "О":"k" ,
        "Л":"l" ,
        "Т":"m" ,
        "И":"n" ,
        "О":"o" ,
        "З":"p" ,
        "Ф":"q" ,
        "Ж":"r" ,
        "Ы":"s" ,
        "Э":"t" ,
        "Г":"u" ,
        "С":"v" ,
        "Ц":"w" ,
        "Ч":"x" ,
        "Н":"y" ,
        "Я":"z",
        "Е":"-" ,
        "К":"[" ,
        "В":"." ,
        "Д":";" ,
        "П":"'" ,

        "Й":"A" ,
        "М":"B" ,
        "Ё":"C" ,
        "Б":"D" ,
        "У":"E" ,
        "Ө":"F" ,
        "А":"G" ,
        "Х":"H" ,
        "Ш":"I",
        "Р":"J" ,
        "О": "K" ,
        "Л":"L" ,
        "Т":"M" ,
        "И":"N" ,
        "Ү":"O" ,
        "З":"P" ,
        "Ф":"Q" ,
        "Ж": "R",
        "Ы":"S" ,
        "Э":"T" ,
        "Г":"U" ,
        "С": "V" ,
        "Ц": "W" ,
        "Ч":"X",
        "Н": "Y" ,
        "Я": "Z",
    };

    function translate2MGLTwo(id, word){
        if(word){
            word = word.toUpperCase();
        }
        word =  word.split('').map(function (char) {
            return Lat2Cyr[char] || char;
        }).join("");
        $("#" + id).val(word);
    }

    function translate2MGL(word){
        if(word){
            word = word.toUpperCase();
        }
        word =  word.split('').map(function (char) {
            return Lat2Cyr[char] || char;
        }).join("");
        $("#number_id").val(word);
    }

    function translate2LATIN(word){
        if(word){
            word = word.toUpperCase();
        }
        word =  word.split('').map(function (char) {
            return Cyr2Lat[char] || char;
        }).join("");
        $("#cabin_no_id").val(word);
    }

    function translate2MGL_Register(word){
        if(word){
            word = word.toUpperCase();
        }
        word =  word.split('').map(function (char) {
            return Lat2Cyr[char] || char;
        }).join("");
        $("#register_own").val(word);
    }

    function ownerTwo(owner){
        $(".containerBody").fadeOut();
        $(".avtoteeverPreloader").fadeIn();
        $.ajax({
            type: 'POST',
            url: vrsUrl('/api/history/ownertwo'),
            data: {owner1: owner},
            timeout: 60000,
            error: function (data) {
                $(".avtoteeverPreloader").fadeOut();
                $(".containerBody").fadeIn();
            },
            success: function (data) {
                try {
                    if(data != "false"){
                        $("#ownertwo_table").html();
                        $("#ownertwo_table").html(data);
                        $('#ownerTwoModal').modal('show');
                        $(".avtoteeverPreloader").fadeOut();
                        $(".containerBody").fadeIn();

                    } else {
                        $('#ownerTwoModal').modal('show');
                        $(".avtoteeverPreloader").fadeOut();
                        $(".containerBody").fadeIn();
                    }
                }catch(err) {
                    $(".avtoteeverPreloader").fadeOut();
                    $(".containerBody").fadeIn();
                }
            }
        });
    }

    function vehicleLimitHistory(vehicle){
        $(".containerBody").fadeOut();
        $(".avtoteeverPreloader").fadeIn();
        $.ajax({
            type: 'POST',
            url: vrsUrl('/api/history/vehiclelimit'),
            data: {vid: vehicle},
            timeout: 60000,
            error: function (data) {
                $(".avtoteeverPreloader").fadeOut();
                $(".containerBody").fadeIn();
            },
            success: function (data) {
                try {
                    if(data != "false"){

                        $("#restrict_table").html("");
                        $("#restrict_table").html(data);
                        $('#restrictHistoryModal').modal('show');
                        $(".avtoteeverPreloader").fadeOut();
                        $(".containerBody").fadeIn();
                    } else {
                        $('#restrictHistoryModal').modal('show');
                        $(".avtoteeverPreloader").fadeOut();
                        $(".containerBody").fadeIn();
                    }
                }catch(err) {
                    $(".avtoteeverPreloader").fadeOut();
                    $(".containerBody").fadeIn();
                }
            }
        });
    }

    function vehicleAnother(vehicle){
        $(".containerBody").fadeOut();
        $(".avtoteeverPreloader").fadeIn();
        $.ajax({
            type: 'POST',
            url: vrsUrl('/api/history/vehicleanothers'),
            data: {vid: vehicle},
            timeout: 60000,
            error: function (data) {
                $(".avtoteeverPreloader").fadeOut();
                $(".containerBody").fadeIn();
            },
            success: function (data) {
                try {
                    if(data != "false"){
                        $("#vehicle_anothers_table").html("");
                        $("#vehicle_anothers_table").html(data);
                        $('#otherModal').modal('show');
                        $(".avtoteeverPreloader").fadeOut();
                        $(".containerBody").fadeIn();
                    } else {
                        $('#otherModal').modal('show');
                        $(".avtoteeverPreloader").fadeOut();
                        $(".containerBody").fadeIn();
                    }
                }catch(err) {
                    $(".avtoteeverPreloader").fadeOut();
                    $(".containerBody").fadeIn();
                }
            }
        });
    }
 
    function vehicleActionArchive(vehicle){
        $(".containerBody").fadeOut();
        $(".avtoteeverPreloader").fadeIn();
        try {
            $.ajax({
                type: 'POST',
                url: vrsUrl('/api/history/vehiclearchive'),
                data: {vid: vehicle},
                timeout: 60000,
                error: function (data) {
                    $(".avtoteeverPreloader").fadeOut();
                    $(".containerBody").fadeIn();
                },
                success: function (data) {

                    if(data != "false"){
                        $("#archive_table_id").html("");
                        $("#archive_table_id").html(data);
                        $('#archiveModal').modal('show');
                        $(".avtoteeverPreloader").fadeOut();
                        $(".containerBody").fadeIn();
                    } else {
                        $('#archiveModal').modal('show');
                        $(".avtoteeverPreloader").fadeOut();
                        $(".containerBody").fadeIn();
                    }
                }
            });
        }catch(err) {
            $(".avtoteeverPreloader").fadeOut();
            $(".containerBody").fadeIn();
        }
    }

    function vehicleOwners(vehicle) {
        $(".containerBody").fadeOut();
        $(".avtoteeverPreloader").fadeIn();
        $.ajax({
            type: 'POST',
            url: vrsUrl('/api/history/vehicleowners'),
            data: {vid: vehicle},
            timeout: 60000,
            error: function (data) {
                $(".avtoteeverPreloader").fadeOut();
                $(".containerBody").fadeIn();
            },
            success: function (data) {
                try {
                    if(data != "false"){
                        $("#owners_table_id").html("");
                        $("#owners_table_id").html(data[0]);
                        $('#ownerModal').modal('show');
                    } else {
                        $('#ownerModal').modal('show');
                    }
                    $(".avtoteeverPreloader").fadeOut();
                    $(".containerBody").fadeIn();
                }catch(err) {
                    $(".avtoteeverPreloader").fadeOut();
                    $(".containerBody").fadeIn();
                }
            }
        });
    }
    function vehicleOwners1(vehicle) {
        $(".containerBody").fadeOut();
        $(".avtoteeverPreloader").fadeIn();
        $.ajax({
            type: 'POST',
            url: vrsUrl('/api/history/vehicleowners1'),
            data: {vid: vehicle},
            timeout: 60000,
            error: function (data) {
                $(".avtoteeverPreloader").fadeOut();
                $(".containerBody").fadeIn();
            },
            success: function (data) {
                try {
                    if(data != "false"){
                        $("#owners_table_id1").html("");
                        $("#owners_table_id1").html(data[0]);
                        $('#ownerModal1').modal('show');
                    } else {
                        $('#ownerModal1').modal('show');
                    }
                    $(".avtoteeverPreloader").fadeOut();
                    $(".containerBody").fadeIn();
                }catch(err) {
                    $(".avtoteeverPreloader").fadeOut();
                    $(".containerBody").fadeIn();
                }
            }
        });
    }

    function setRegCertificate(elem) {
        $(".containerBody").fadeOut();
        $(".avtoteeverPreloader").fadeIn();
        var id=$("#userPkId").val();
        var no=$("#cert_id").val();
        var vehicle=$("#vehicleId").val();
        var plate=$("#number_id").val();
        var printer=$('#device').find(":selected").val();
        document.cookie = "printerdevice=" + printer;
        $.ajax({
            type: 'POST',
            url: vrsUrl('/api/createPrintCertificate'),
            data: {id: id,no: no,vehicle: vehicle,plate: plate},
            timeout: 60000,
            error: function (data) {
                $(".avtoteeverPreloader").fadeOut();
                $(".containerBody").fadeIn();
            },
            success: function (data) {
                $(".avtoteeverPreloader").fadeOut();
                $(".containerBody").fadeIn();
                if(data == "success"){
                    var mywindow = window.open('', 'PRINT');
                    mywindow.document.write('<html><head><title>' + document.title  + ' </title> ');
                    mywindow.document.write('</head><body >');
                    mywindow.document.write(document.getElementById(elem).innerHTML);
                    mywindow.document.write('</body></html>');
                    mywindow.document.close(); // necessary for IE >= 10
                    mywindow.focus(); // necessary for IE >= 10*/
                    mywindow.print();
                    mywindow.close();
                    return true;
                } else {
                    alert("증명서 인쇄 중 오류가 발생했습니다. 다시 시도해 주세요!");
                }
                $(".avtoteeverPreloader").fadeOut();
                $(".containerBody").fadeIn();
            }
        });
    }

    // $('#number_id').combogrid({
    //     panelWidth: 700,
    //     url: vrsUrl('/api/numberlist'),
    //     queryParams: {
    //         number: $("#number_id").val()
    //     },
    //     textField: 'plate_no',
    //     mode: 'remote',
    //     method: 'post',
    //     fitColumns:'true',
    //     loadMsg: 'Хайж 입니다...',
    //     columns: [[
    //         {field: 'plate_no', title: '번호판', width: 60},
    //         {field: 'cabin_no', title: '차체번호', width: 80},
    //         {field: 'mark_name', title: '브랜드', width: 80},
    //         {field: 'model_name', title: '형식', width: 80},
    //         {field: 'vehicle_type_name', title: '차량 유형', width: 80},
    //         {field: 'color_name', title: '색상', width: 60},
    //         {field: 'purpose_name', title: '용도', width: 90},
    //         {field: 'build_year', title: '작업일', width: 60},
    //         {field: 'import_date', title: 'Импорт он', width: 60}
    //     ]],
    //     onChange: function(plate){
    //         $('#number_id').val(plate);
    //     },
    //     onSelect: function(index, row){
    //         $('#number_id').val(row["plate_no"]);
    //         $('#main_form').submit();
    //     }
    // });
</script>
</body>
</html>
