<!DOCTYPE html>
<html lang="en">
<head>
    @include('Includes.head')
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
        <div class="card card-body card-dashboard-twentyfive mg-b-20">
            <div class="row row-sm">
                <!--왼쪽 영역 시작-->
                <div class="col-lg-10 col-md-12 col-sm-12">
                    {{--<div class="card card-body card-dashboard-twentyfive mg-b-20">--}}

                    {{--</div>--}}
                    <h6 class="card-title">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                               보관 번호 목록!!
                            </div>
                        </div>
                    </h6>
                    @if(ISSET($message) || session()->has("message"))
                    @include("System.message") 
                @endif
                 
                    <div class="row row-sm">
                        <div class="col-12 col-sm-1 col-lg">
                            <form action="{{ route("plateSave") }}" method="POST">
                                {{ csrf_field() }}
                                <div class="row row-sm">
                                
                                    <div class="col-4">
                                        <div class="row row-xs align-items-center mg-b-5">
                                            <div class="col-lg-4 col-md-12 col-sm-12">
                                                <label class="form-label mg-b-0 ">차량 번호</label>
                                            </div>
                                            <div class="col-lg-8 col-md-12 col-sm-12">
                                                <input id="plateNo" name="plateNo" oninput="this.value = this.value.toUpperCase()" onkeyup="edValueKeyPress(1)" value="{{isset($plateNo) ?  $plateNo : ''}}"  type="text" class="form-control" placeholder="차량 번호...">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="row row-xs align-items-center mg-b-5">
                                            <div class="col-lg-4 col-md-12 col-sm-12">
                                                <label class="form-label mg-b-0 ">등록 번호</label>
                                            </div>
                                            <div class="col-lg-8 col-md-12 col-sm-12">
                                                <input id="regNo" name="regNo" oninput="this.value = this.value.toUpperCase()" onkeyup="edValueKeyPress(2)" value="{{isset($regNo) ?  $regNo : ''}}" type="text" class="form-control" placeholder="등록 번호...">
                                            </div>
                                        </div>
                                    </div>
                                  
                                    <div class="col-3">
                                        <div class="row row-xs align-items-center mg-b-5">
                                            <div class="col-lg-4 col-md-12 col-sm-12">
                                                <button type="submit" class="btn btn-primary btn-block btnnopadding">검색</button>
                                            </div>
                                           
                                            <div class="col-lg-4 col-md-12 col-sm-12">
                                                <button type="button" onclick="clearFields()" class="btn btn-primary btn-block btnnopadding">초기화</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <hr class="mg-y-10">
                            <table id="referenceTable" class="display responsive table" style="width:100%;">
                                <thead>
                                <tr>
                                    <th>차량 번호</th>
                                    <th>성씨,이름</th>
                                    {{-- <th>이름</th> --}}
                                    <th>등록번호</th>
                                    <th>전화</th>
                                    <th>시작일</th>
                                    <th>만료일</th>
                                    <th>상태</th>
                                    <th>일수</th>
                                    <th>연장 권한</th>
                                    <th>결제</th>
                                    <th>아카이브</th>
                                    <th>전문가</th>
                                    <th>날짜</th>
                                    {{-- <th>작업</th> --}}
                                </tr>
                                </thead>
                                <tbody>
                                @if($plateNumberSaveList)
                                    @foreach($plateNumberSaveList as $plateNumberSaveList)
                                        <tr>
                                            <td>{{ $plateNumberSaveList->plate_no }}</td>
                                            <td>{{ \Illuminate\Support\Str::limit(\App\Helpers\TranslationHelper::translate($plateNumberSaveList->customer_lastname), 1, $end='.') }} {{ \App\Helpers\TranslationHelper::translate($plateNumberSaveList->customer_firstname)}}</td>
                                            {{-- <td>{{ $plateNumberSaveList->customer_lastname }}</td>
                                            <td>{{ $plateNumberSaveList->customer_firstname }}</td> --}}
                                            <td>{{ $plateNumberSaveList->customer_regnum }}</td>
                                            <td>{{ $plateNumberSaveList->customer_phone }}</td>
                                            <td>{{date('Y-m-d', strtotime($plateNumberSaveList->begin_date)) }}</td>
                                            <td>{{date('Y-m-d', strtotime($plateNumberSaveList->end_date))  }}</td>
                                           
                                            <td>
                                             
                                                @if (\Carbon\Carbon::parse($plateNumberSaveList->end_date)->format("Y-m-d") <= \Carbon\Carbon::now()->format("Y-m-d"))
                                                <strong style="color:red">  기간 만료 </strong>   
                                                @else
                                                <strong style="color: green">기간 유효</strong>
                                                @endif
                                            </td>
                                            <td>
                                                <?PHP
                                                $to = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $plateNumberSaveList->begin_date);
                                                $from = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $plateNumberSaveList->end_date);
                                                $diff_in_days = $to->diffInDays($from);
                                                echo $diff_in_days;
                                                    
                                                      
                                                    
                                                    ?>
                                            </td>
                                            <td>{{$plateNumberSaveList->extend_count}}</td>
                                            <td>
                                                <strong style="color: green">
                                                <?PHP
                                                $checkDate = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', '2024-11-15 00:00:00');
                                                $to = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $plateNumberSaveList->begin_date);
                                                $from = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $plateNumberSaveList->end_date);
                                                $diff_in_days = $to->diffInDays($from);
                                               // echo $checkDate;
                                                if ($checkDate < $to ) {
                                                    if ($diff_in_days <= 90) {
                                                        echo (10000)."₮";
                                                    } else {
                                                        echo (20000)."₮";
                                                    }
                                                    
                                                  
                                                } else {
                                                    echo ($diff_in_days * 5500)."₮";
                                                }
                                                
                                               
                                                    
                                                    
                                                    
                                                    ?>
                                                    </strong>
                                            </td>
                                            <td><a href="{{ url('/archive/documentAr/' . $plateNumberSaveList->archive_number) }}" target="_blank"  >{{ $plateNumberSaveList->archive_number }}</a></td>
                                            <td>{{ \Illuminate\Support\Str::limit(\App\Helpers\TranslationHelper::translate($plateNumberSaveList->lastname), 1, $end='.') }} {{ \App\Helpers\TranslationHelper::translate($plateNumberSaveList->firstname)}}</td>
                                            <td> {{ $plateNumberSaveList->create_date}}</td>
                                            {{-- <td>
                                                <a href="{{ url('/plateSave/edit/' . \App\Http\Controllers\BaseController::enc($plateNumberSaveList->id)) }}">
                                                    <i class="typcn typcn-edit text-primary"></i>
                                                </a>
                                            </td> --}}
                                        
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!--왼쪽 영역 끝-->
                <div class="col-lg-2 col-md-6 col-sm-12">
                    @include('Includes.platesavemenu')
                </div>
            </div>
        </div>
    </div>
    @include('Includes.footer')
</div>

@include('Includes.helper')

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

<script src="{{ asset('js/vrs.js') }}"></script>
<script src="{{ asset('js/avtoteever.js') }}"></script>
<script>
    function clearFields() {
        window.location = "{{ url('/plateSave') }}";

    }
    function edValueKeyPress(type) {
       // console.log(type);
        if (type == 1) {
            var edValue = document.getElementById("plateNo");
    var s = edValue.value;

    var lblValue = document.getElementById("regNo");
    lblValue.value = "";
        } else {
            var edValue = document.getElementById("regNo");
    var s = edValue.value;

    var lblValue = document.getElementById("plateNo");
    lblValue.value = "";
        }

   
}
    $(function(){
        'use strict'
        $( "#restrictDate" ).datepicker({
            changeMonth: true,
            changeYear: true
        });
        $( "#restrictDate" ).datepicker( "option", "dateFormat", "yy-mm-dd" );

        $('#referenceTable').DataTable({
            responsive: true,
            language: {
                searchPlaceholder: '검색...',
                sSearch: '',
                lengthMenu: '_MENU_ 페이지당 표시',
            }
        });

        $('#searchResult').DataTable({
            responsive: true,
            bFilter: false,
            bLengthChange: false,
            language: {
                searchPlaceholder: '검색...',
                sSearch: '',
                lengthMenu: '_MENU_ 1/페이지에 표시',
            }
        });

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
    });
    $(document).ready(function () {
        $(".avtoteeverPreloader").fadeOut();
        $(".containerBody").fadeIn();
    });
</script>
</div>
</body>
</html>
