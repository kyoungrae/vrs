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
                                    전체 담당자 보고서
                                </div>
                            </div>
                        </h6>
                        <div class="row row-sm">
                            <div class="col-12 col-sm-1 col-lg">
                                <form action="" method="POST">
                                    {{ csrf_field() }}
                                    <div class="row row-sm">
                                        <div class="col-2">
                                            <div class="row row-xs align-items-center mg-b-5">
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <select class="form-control select2 required-input" name="operation" required>
                                                        @if (session()->get('auth')->iscity == 1)
                                                        <option value="1" {{ isset($op) ? $op == "1" ? "selected" : "" : "" }}>울란바토르</option>
                                                        @else
                                                        <option value="2" {{ isset($op) ? $op == "2" ? "selected" : "" : "" }}>지방</option>
                                                        @endif
                                                        
                                                       
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="row row-xs align-items-center mg-b-5">
                                                <div class="col-lg-4 col-md-12 col-sm-12">
                                                    <label class="form-label mg-b-0 required-input">직위(공무)</label>
                                                </div>
                                                <div class="col-lg-8 col-md-12 col-sm-12">
                                                    <select class="form-control select2" name="position">
                                                        @if(ISSET($positions))
                                                            @foreach($positions as $position)
                                                                <option value="{{ $position->id }}" {{ isset($curr_pos) ? $curr_pos == $position->id ? "selected" : "" : "" }}>{{ $position->name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="row row-xs align-items-center mg-b-5">
                                                <div class="col-lg-4 col-md-12 col-sm-12">
                                                    <label class="form-label mg-b-0 required-input">시작</label>
                                                </div>
                                                <div class="col-lg-8 col-md-12 col-sm-12">
                                                    <input id="start" name="start" required type="text" value="{{ isset($start) ? $start : "" }}" class="form-control" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-2">
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
                                    <tr style="text-align: center;">
                                        <th>№</th>
                                        <th>담당자</th>
                                        <th>일자</th>
                                        <th>신규</th>
                                        <th>이전</th>
                                        <th>번호판 교체 이전</th>
                                        <th>증명서 교체</th>
                                        <th>증명서 갱신</th>
                                        <th>Хязгаарлалт</th>
                                        <th>말소</th>
                                        <th>번호판 교체</th>
                                        <th>번호판 간 교체</th>
                                        <th>인쇄</th>
                                        <th>수정</th>
                                        <th>문자 말소</th>
                                        <th>말소에서 복구됨</th>
                                    </tr>
                                    </thead>
                                    <tbody style="text-align: center;">
                                    @if(ISSET($results))
                                        @foreach($results as $result)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $result->name.' '.$result->lastname }}</td>
                                                <td>{{ \Carbon\Carbon::parse($result->archive_date)->format("Y-m-d") }}</td>
                                                <td>{{ $result->new_v }}</td>
                                                <td>{{ $result->move_v }}</td>
                                                <td>{{ $result->change_plate_move_v }}</td>
                                                <td>{{ $result->change_cert_v }}</td>
                                                <td>{{ $result->again_cert_v }}</td>
                                                <td>{{ $result->limited_v }}</td>
                                                <td>{{ $result->remove_v }}</td>
                                                <td>{{ $result->change_plate_v }}</td>
                                                <td>{{ $result->change_two_v }}</td>
                                                <td>{{ $result->print_v }}</td>
                                                <td>{{ $result->edit_v }}</td>
                                                <td>{{ $result->delete_plate }}</td>
                                                <td>{{ $result->restore_plate }}</td>
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
            url: "/api/report/all/users/@if(ISSET($op)){{ $op }}@else{{ "none" }}@endif/@if(ISSET($curr_pos)){{ $curr_pos }}@else{{ "none" }}@endif/@if(ISSET($startDate)){{ $startDate }}@else{{ "none" }}@endif/@if(ISSET($endDate)){{ $endDate }}@else{{ "none" }}@endif",
            success: function (data) {
                @if(ISSET($startDate))
                    window.location = "/api/report/all/users/@if(ISSET($op)){{ $op }}@else{{ "none" }}@endif/@if(ISSET($curr_pos)){{ $curr_pos }}@else{{ "none" }}@endif/@if(ISSET($startDate)){{ $startDate }}@else{{ "none" }}@endif/@if(ISSET($endDate)){{ $endDate }}@else{{ "none" }}@endif";
                    $(".avtoteeverPreloader").fadeOut();
                    $(".containerBody").fadeIn();
                @else
                    $(".avtoteeverPreloader").fadeOut();
                    $(".containerBody").fadeIn();
                    alert("보고서 시작·종료 일자를 선택하세요!");
                @endif
            },
        });
    }

    $( document ).ready(function() {
        @if(ISSET($startDate))
$("#start").val('{{ $startDate }}');
        @else
$("#start").val('{{ \Carbon\Carbon::now()->format("Y-m-d") }}');
        @endif

        @if(ISSET($endDate))
$("#end").val('{{ $endDate }}');
        @else
$("#end").val('{{ \Carbon\Carbon::now()->format("Y-m-d") }}');
        @endif

$(".avtoteeverPreloader").fadeOut();
        $(".containerBody").fadeIn();
    });

    function clearFields() {
        $("#start").val(null);
        $("#end").val(null);
    }
</script>
</body>
</html>
