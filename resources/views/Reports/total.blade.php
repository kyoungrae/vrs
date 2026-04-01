<!DOCTYPE html>
<html lang="en">
<head>
    @include('Includes.head')
</head>
<body class="az-body flexcroll">
<div class="avtoteeverPreloader"></div>
<div class="containerBody" style="display: none;">
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
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <h6 class="card-title">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    НИЙТ ТЭЭВРИЙН ХЭРЭГСЛИЙН ТАЙЛАН /Төрлөөр/
                                </div>
                            </div>
                        </h6>
                        <div class="row row-sm">
                            <div class="col-12 col-sm-1 col-lg">
                                <form action="{{ route('total_vehicle') }}" method="POST">
                                    {{ csrf_field() }}
                                    <div class="row row-sm">
                                        <div class="col-3">
                                            <div class="row row-xs align-items-center mg-b-5">
                                                <div class="col-lg-5 col-md-12 col-sm-12">
                                                    <label class="form-label mg-b-0 required-input">시작 일자</label>
                                                </div>
                                                <div class="col-lg-7 col-md-12 col-sm-12">
                                                    <input id="sdate" name="startDate" type="text" class="form-control fc-datepicker" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="row row-xs align-items-center mg-b-5">
                                                <div class="col-lg-5 col-md-12 col-sm-12">
                                                    <label class="form-label mg-b-0 required-input">종료 일자</label>
                                                </div>
                                                <div class="col-lg-7 col-md-12 col-sm-12">
                                                    <input id="edate" name="endDate" type="text" class="form-control fc-datepicker" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="row row-xs align-items-center mg-b-5">
                                                <div class="col-lg-4 col-md-12 col-sm-12">
                                                    <button type="submit" class="btn btn-primary btn-block btnnopadding">검색</button>
                                                </div>
                                                <div class="col-lg-4 col-md-12 col-sm-12">
                                                    <button type="button" onclick="exportToExcel()" class="btn btn-primary btn-block btnnopadding"><i class="far fa-file-excel"></i> 엑셀</button>
                                                </div>
                                                <div class="col-lg-4 col-md-12 col-sm-12">
                                                    <button type="button" onclick="clearFields()" class="btn btn-primary btn-block btnnopadding">지우기</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <hr class="mg-y-10">
                                <table id="referenceTable" class="display responsive nowrap" style="width:100%;">
                                    <thead>
                                    <tr style="text-align: center;">
                                        <th>№</th>
                                        <th>운송수단 유형</th>
                                        <th>개수</th>
                                    </tr>
                                    </thead>
                                    <tbody style="text-align: center;">
                                    @if(ISSET($datas))
                                        @foreach($datas as $data)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $data->purpose_name }}</td>
                                                <td>{{ $data->count }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!--왼쪽 영역 끝-->
                </div>
            </div>
        </div>
        @include('Includes.footer')
    </div>
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
    $(function(){
        'use strict'
        $( "#sdate" ).datepicker({
            changeMonth: true,
            changeYear: true
        });
        $( "#edate" ).datepicker({
            changeMonth: true,
            changeYear: true
        });

        $( "#sdate" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
        $( "#edate" ).datepicker( "option", "dateFormat", "yy-mm-dd" );

        $('#referenceTable').DataTable({
            responsive: true,
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

    $( document ).ready(function() {
        @if(ISSET($startDate))
$("#sdate").val('{{ $startDate }}');
        @else
$("#sdate").val('2008-12-31');
        @endif

        @if(ISSET($endDate))
$("#edate").val('{{ $endDate }}');
        @else
$("#edate").val('{{ \Carbon\Carbon::now()->format("Y-m-d") }}');
        @endif

$(".avtoteeverPreloader").fadeOut();
        $(".containerBody").fadeIn();
    });

    function clearFields() {
        $("#sdate").val('2008-12-31');
        $("#edate").val('{{ \Carbon\Carbon::now()->format("Y-m-d") }}');
    }

    function exportToExcel() {
        $(".containerBody").fadeOut();
        $(".avtoteeverPreloader").fadeIn();
        $.ajax({
            type: "GET",
            url: "/api/report/allvehicle/@if(ISSET($startDate)){{ $startDate }}@else{{ "none" }}@endif/@if(ISSET($endDate)){{ $endDate }}@else{{ "none" }}@endif",
            success: function (data) {
                @if(ISSET($startDate))
                    $(".avtoteeverPreloader").fadeOut();
                    $(".containerBody").fadeIn();
                    window.location = "/api/report/allvehicle/@if(ISSET($startDate)){{ $startDate }}@else{{ "none" }}@endif/@if(ISSET($endDate)){{ $endDate }}@else{{ "none" }}@endif";
                @else
                    $(".avtoteeverPreloader").fadeOut();
                    $(".containerBody").fadeIn();
                    alert("보고서 시작·종료 일자를 선택하세요!");
                @endif
            }
        });
    }
</script>
</body>
</html>