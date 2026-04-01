<!DOCTYPE html>
<html lang="en">
<head>
    @include('Includes.head')
    <style>
        .az-content-dashboard-ten .card {  
            margin: 5px !important;
        }
    </style>
</head>
<body class="az-body flexcroll"> 
<div class="avtoteeverPreloader"></div>
<div class="containerBody"  style="display: none;">
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
            <div class="az-content-body-left" style="padding: 10px;">
                <div class="row row-sm mg-b-20">
                    <div class="col-sm-6 col-lg-2">
                        <div class="card card-dashboard-twentysix">
                            <div class="card-header">
                                <h6 class="card-title">차량</h6>
                              
                            </div>
                            <div class="card-body">
                                <div class="pd-x-15">
                                    <h6>@if(isset($totalVehicle)) {{$totalVehicle}} @endif <span class="tx-success"><i class="icon ion-md-arrow-up"></i> </span></h6>
                                    <label>총 등록 수</label>
                                </div>
                                <div class="chart-wrapper">
                                    <div id="flotChart7" class="flot-chart"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-2 mg-t-20 mg-sm-t-0">
                        <div class="card card-dashboard-twentysix card-dark-one">
                            <div class="card-header">
                                <h6 class="card-title">소유자</h6>
                            </div>
                            <div class="card-body">
                                <div class="pd-x-15">
                                    <h6>@if(isset($totalOwners)) {{$totalOwners}} @endif <span><i class="icon ion-md-arrow-up"></i></span></h6>
                                    <label>총 등록 수</label>
                                </div>
                                <div class="chart-wrapper">
                                    <div id="flotChart8" class="flot-chart"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 mg-t-20 mg-lg-t-0">
                        <div class="card card-dashboard-twentysix card-dark-two">
                            <div class="card-header">
                                <h6 class="card-title">시리얼 번호</h6>
                            </div>
                            <div class="card-body">
                                <div class="pd-x-15">
                                    <h6>@if(isset($totalNumbers)) {{$totalNumbers}} @endif  <span><i class="icon ion-md-arrow-up"></i> </span></h6>
                                    <label>잔여 수량</label>
                                </div>
                                <div class="chart-wrapper">
                                    <div id="flotChart9" class="flot-chart"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 mg-t-20 mg-lg-t-0">
                        <div class="card card-dashboard-twentysix " style="background-color: #337ab7;
                        background-image: linear-gradient(to bottom, #337ab7 0%, #337ab7 100%);
                        background-repeat: repeat-x; ">
                            <div class="card-header">
                                <h6 style="color:white;" class="card-title">전자 요청</h6>
                            </div>
                            <div class="card-body">
                                <div class="pd-x-15">
                                    <h6  style="color:white;"><span style="font-size: 22px;
                                        font-weight: 600;" id="reqAll"></span> <span><i class="icon ion-md-globe"></i> </span></h6>
                                    <label style="color:white;">총 접수</label>
                                </div>
                                <div class="chart-wrapper">
                                    <div id="flotChart9" class="flot-chart">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 mg-t-20 mg-lg-t-0">
                        <div class="card card-dashboard-twentysix " style="background-color: #3bb001;
                        background-image: linear-gradient(to bottom, #3bb001 0%, #3bb001 100%);
                        background-repeat: repeat-x; ">
                            <div class="card-header">
                                <h6 style="color:white;" class="card-title">처리 완료 요청</h6>
                            </div>
                            <div class="card-body">
                                <div class="pd-x-15">
                                    <h6 style="color:white;"><span style="font-size: 22px;
                                        font-weight: 600;" id="reqApprov"></span> <span><i class="icon ion-md-globe"></i> </span></h6>
                                    <label style="color:white;">총 처리 완료</label>
                                </div>
                                <div class="chart-wrapper">
                                    <div id="flotChart9" class="flot-chart">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 mg-t-20 mg-lg-t-0">
                        <div class="card card-dashboard-twentysix " style="background-color: #d9534f;
                        background-image: linear-gradient(to bottom, #d9534f 0%, #d9534f 100%);
                        background-repeat: repeat-x; ">
                            <div class="card-header">
                                <h6 style="color:white;" class="card-title">취소된 요청</h6>
                            </div>
                            <div class="card-body">
                                <div class="pd-x-15">
                                    <h6 style="color:white;">0 <span><i class="icon ion-md-trash"></i> </span></h6>
                                    <label style="color:white;">총 취소 수</label>
                                </div>
                                <div class="chart-wrapper">
                                    <div id="flotChart9" class="flot-chart">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
        @include('Includes.footer')
    </div>

    @include('Includes.helper')

    <div id="registerBranch" class="modal">
        <form action="{{ route("dashboard") }}" method="POST">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">지점 선택</h6>
                    </div>
                    <div class="modal-body">
                        {{ csrf_field() }}
                        <div class="row row-sm">
                            <div class="col-12">
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-5 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0 required-input">지점</label>
                                    </div>
                                    <div class="col-lg-7 col-md-12 col-sm-12">
                                        <select class="form-control select2" name="branch">
                                            @if(ISSET($archives))
                                            @foreach($archives as $archive)
                                            @if ($archive->is_type == 1 && session()->get("auth")->isatvt == 1 && session()->get("auth")->iscity == 0)
                                                <option value="{{ \App\Http\Controllers\BaseController::enc($archive->id) }}">{{ $archive->archive }}</option>
                                            @elseif ($archive->is_type == 2 && session()->get("auth")->iscity == 1 && session()->get("auth")->isatvt == 0 )
                                                <option value="{{ \App\Http\Controllers\BaseController::enc($archive->id) }}">{{ $archive->archive }}</option>
                                            @elseif ($archive->is_type == 1 && session()->get("auth")->isatvt == 0 && session()->get("auth")->iscity == 0)
                                                <option value="{{ \App\Http\Controllers\BaseController::enc($archive->id) }}">{{ $archive->archive }} </option>
                                            @endif
                                                   
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">확인</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
 
    <script src="{{ asset('lib/jquery/jquery.min.js') }}"></script>
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
    <script src="{{ asset('js/vrs.js') }}"></script>
    <script src="{{ asset('data.js') }}"></script>
    <script src="{{ asset('js/avtoteever.js') }}"></script>
    <script src="{{ asset('js/dashboard.sampledata.js') }}"></script>
    <script src="{{ asset('js/chart.flot.sampledata.js') }}"></script>
    <script src="{{ asset('lib/dev-extreme/js/dx.all.js')}}"></script>
    <script>
        $(document).ready(function(){
            'use strict';
      //--------------------------------------------------
            $("#buttonContainer").dxButton({
        text: "Click me!",
        onClick: function () {
            alert("Hello world!");
        }
    });

    $.ajax({
            type: 'POST',
            url: '/api/getRequestList',
            dataType: "json",
            data: {
               // param1: "param",
                param: '{{ \App\Http\Controllers\BaseController::enc(\Carbon\Carbon::now()->format("Y-m-d")) }}'
            },
            timeout: 60000,
            error: function (data) {
                $(".avtoteeverPreloader").fadeOut();
                $(".containerBody").fadeIn();
            },
            success: function (data) {
                try {
                  if (data['status']['code'] == 200) {
                    const propertyNames = Object.keys(data['data']);
                   //ssss console.log(propertyNames.length); 

                   var approved =[];
               for (let i = 0; i < data['data'].length; i++) {
           

                if (data['data'][i].is_approved == 1) {
                    approved.push(data['data'][i].is_approved);
                }
               
               }
              // console.log(approved.length);
                     const requestCount=propertyNames.length;
                    $('#reqAll').text(requestCount);
                    $('#reqApprov').text(approved.length);
                  }
                  

                }catch(err){

                }
                }
                });
  
//----------------------------------------------------------------------------
            $('#userTable').DataTable({
                responsive: true,
                language: {
                    searchPlaceholder: '검색...',
                    sSearch: '',
                    lengthMenu: '_MENU_ 개씩 표시',
                }
            });

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

            @if(session()->has("archive"))
               @if(session()->get("archive") == "many")
            $('#registerBranch').modal({'backdrop': 'static'});
            $('#registerBranch').modal('show');
            @endif
            @endif

            /******************* DASHBOARD CHARTS **************************/
         
        });
        $(document).ready(function () {
            $(".avtoteeverPreloader").fadeOut();
            $(".containerBody").fadeIn();
        });
    </script>
</div>
</body>
</html>