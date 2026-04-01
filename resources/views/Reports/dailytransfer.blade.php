<!DOCTYPE html>
<html lang="en">
<head>
    @include('Includes.head')
    <style>
        table.dataTable tfoot th, table.dataTable tfoot td {
            padding: 5px 18px 5px 18px;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
        }
    </style>
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
                                    ӨДРИЙН ШИЛЖИЛТИЙН ТАЙЛАН
                                </div>
                            </div>
                        </h6>
                        <div class="row row-sm">
                            <div class="col-12 col-sm-1 col-lg">
                                <form action="" method="POST">
                                    {{ csrf_field() }}
                                    <div class="row row-sm">
                                        <div class="col-3">
                                            <div class="row row-xs align-items-center mg-b-5">
                                                <div class="col-lg-4 col-md-12 col-sm-12">
                                                    <label class="form-label mg-b-0 required-input">지점</label>
                                                </div>
                                                <div class="col-lg-8 col-md-12 col-sm-12">
                                                    <select class="form-control select2" name="branch">
                                                        @if(ISSET($archives))
                                                            @foreach($archives as $archive)
                                                                <option value="{{ $archive->abbr }}" {{ isset($abbr) ? $abbr == $archive->abbr ? "selected" : "" : "" }}>{{ $archive->archive }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="row row-xs align-items-center mg-b-5">
                                                <div class="col-lg-4 col-md-12 col-sm-12">
                                                    <label class="form-label mg-b-0 required-input">시작</label>
                                                </div>
                                                <div class="col-lg-8 col-md-12 col-sm-12">
                                                    <input id="start" name="start" required type="text" value="{{ isset($start) ? $start : "" }}" class="form-control" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="row row-xs align-items-center mg-b-5">
                                                <div class="col-lg-4 col-md-12 col-sm-12">
                                                    <label class="form-label mg-b-0 required-input">종료</label>
                                                </div>
                                                <div class="col-lg-8 col-md-12 col-sm-12">
                                                    <input id="end" name="end" required type="text" value="{{ isset($end) ? $end : "" }}" class="form-control" autocomplete="off">
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
                                    <tr style="text-align: center">
                                        <th style="width:10%;">№</th>
                                        <th>아카이브 번호</th>
                                        <th>이전 날짜</th>
                                        <th>현재 날짜</th>
                                        <th>증명서 번호</th>
                                        <th>서비스</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(ISSET($results))
                                        @foreach($results as $data)
                                            <tr style="text-align: center">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $data->insert_archive_no }}</td>
                                                <td>{{ $data->plate_no }}</td>
                                                <td>{{ $data->insert_plate_no }}</td>
                                                <td>{{ $data->insert_certificate_no }}</td>
                                                <td>{{ $data->name }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td><strong>번호판 солилт</strong></td>
                                        <td colspan="5">{{ isset($total_array) ? $total_array[0] : 0 }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>소유자 이전</strong></td>
                                        <td colspan="5">{{ isset($total_array) ? $total_array[1] : 0 }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>번호판 교체 이전</strong></td>
                                        <td colspan="5">{{ isset($total_array) ? $total_array[2] : 0 }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>증명서 갱신</strong></td>
                                        <td colspan="5">{{ isset($total_array) ? $total_array[3] : 0 }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>증명서 교체</strong></td>
                                        <td colspan="5">{{ isset($total_array) ? $total_array[4] : 0 }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>문자 말소</strong></td>
                                        <td colspan="5">{{ isset($total_array) ? $total_array[5] : 0 }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>말소에서 복구됨</strong></td>
                                        <td colspan="5">{{ isset($total_array) ? $total_array[6] : 0 }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>울란바토르-지방</strong></td>
                                        <td colspan="5">{{ isset($total_array) ? $total_array[7] : 0 }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>지방-울란바토르</strong></td>
                                        <td colspan="5">{{ isset($total_array) ? $total_array[8] : 0 }}</td>
                                    </tr>
                                    </tfoot>
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

        $('#referenceTable').DataTable({
            responsive: true,
            language: {
                searchPlaceholder: '검색...',
                sSearch: '',
                lengthMenu: '_MENU_ 1/페이지에 표시',
            }
        });

        $( "#start" ).datepicker({
            changeMonth: true,
            changeYear: true
        });
        $( "#start" ).datepicker( "option", "dateFormat", "yy-mm-dd" );

        $( "#end" ).datepicker({
            changeMonth: true,
            changeYear: true
        });
        $( "#end" ).datepicker( "option", "dateFormat", "yy-mm-dd" );

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

    function exportToExcel() {
        $(".containerBody").fadeOut();
        $(".avtoteeverPreloader").fadeIn();
        $.ajax({
            type: "GET",
            url: "/api/report/archivetransfer/@if(ISSET($abbr)){{ $abbr }}@else{{ "none" }}@endif/@if(ISSET($start)){{ $start }}@else{{ "none" }}@endif/@if(ISSET($end)){{ $end }}@else{{ "none" }}@endif",
            success: function (data) {
                @if(ISSET($start))
                    $(".avtoteeverPreloader").fadeOut();
                    $(".containerBody").fadeIn();
                    window.location = "/api/report/archivetransfer/@if(ISSET($abbr)){{ $abbr }}@else{{ "none" }}@endif/@if(ISSET($start)){{ $start }}@else{{ "none" }}@endif/@if(ISSET($end)){{ $end }}@else{{ "none" }}@endif";
                @else
                    $(".avtoteeverPreloader").fadeOut();
                    $(".containerBody").fadeIn();
                    alert("보고서 시작·종료 일자를 선택하세요!");
                @endif
            },
        });
    }

    function clearFields() {
        $("#start").val('{{ \Carbon\Carbon::now()->format("Y-m-d") }}');
        $("#end").val('{{ \Carbon\Carbon::now()->format("Y-m-d") }}');
    }

    $( document ).ready(function() {
        @if(ISSET($start))
$("#start").val('{{ $start }}');
        @else
$("#start").val('{{ \Carbon\Carbon::now()->format("Y-m-d") }}');
        @endif

        @if(ISSET($end))
$("#end").val('{{ $end }}');
        @else
$("#end").val('{{ \Carbon\Carbon::now()->format("Y-m-d") }}');
        @endif

$(".avtoteeverPreloader").fadeOut();
        $(".containerBody").fadeIn();
    });
</script>
</body>
</html>
