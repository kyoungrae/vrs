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
                                    АРХИВЫН ТАЙЛАН
                                </div>
                            </div>
                        </h6>
                        <div class="row row-sm">
                            <div class="col-12 col-sm-1 col-lg">
                                <form action="{{ route("total_archive") }}" method="POST">
                                    {{ csrf_field() }}
                                    <div class="row row-sm">
                                        <div class="col-2">
                                            <div class="row row-xs align-items-center mg-b-5">
                                                <div class="col-lg-4 col-md-12 col-sm-12">
                                                    <label class="form-label mg-b-0 required-input">작업</label>
                                                </div>
                                                <div class="col-lg-8 col-md-12 col-sm-12">
                                                    <select class="form-control select2 required-input" name="operation" required>
                                                        <option value="ШЭ" {{ isset($op) ? $op == "ШЭ" ? "selected" : "" : "" }}>ШЭ</option>
                                                        <option value="ШХ" {{ isset($op) ? $op == "ШХ" ? "selected" : "" : "" }}>ШХ</option>
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
                                                    <input id="start" name="start" required type="text" value="{{ isset($start) ? $start : "" }}" class="form-control" placeholder="БЗД1904000001">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="row row-xs align-items-center mg-b-5">
                                                <div class="col-lg-4 col-md-12 col-sm-12">
                                                    <label class="form-label mg-b-0 required-input">종료</label>
                                                </div>
                                                <div class="col-lg-8 col-md-12 col-sm-12">
                                                    <input id="end" name="end" required type="text" value="{{ isset($end) ? $end : "" }}" class="form-control" placeholder="БЗД1904000040">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-1">
                                            <div class="row row-xs align-items-center mg-b-5">
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <label class="form-label mg-b-0">Хуудас: {{ isset($page_sum) ? $page_sum : 0 }}</label>
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
                                        <th>일자</th>
                                        <th>아카이브 번호</th>
                                        <th>번호판</th>
                                        <th>면수</th>
                                        <th>시작 дугаар</th>
                                        <th>종료 дугаар</th>
                                        <th>Устгах гэрчилгээ №</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(ISSET($archives))
                                        <?PHP $count = 0; ?>
                                        <?PHP $tmp_count = 0; ?>
                                        @foreach($archives as $data)
                                            <tr style="text-align: center">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ \Carbon\Carbon::parse($data->created_date)->format("Y-m-d") }}</td>
                                                <td>{{ $data->archive_no }}</td>
                                                <td>{{ $data->insert_plate_no }}</td>
                                                <td>{{ $data->page_count }}</td>
                                                @if($data->page_count != null)
                                                    <td>{{ $count == 0 ? 1 : $count + $tmp_count }}</td>
                                                    <td>{{ $count == 0 ? $data->page_count : $tmp_count + $data->page_count }}</td>
                                                    <?PHP $count = 1; ?>
                                                    <?PHP $tmp_count += $data->page_count; ?>
                                                @else
                                                    <td></td>
                                                    <td></td>
                                                @endif
                                                @if($data->certificate_no != $data->insert_certificate_no)
                                                <td>{{$data->certificate_no}}</td>
                                                @else
                                                <td></td>
                                                @endif
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

        $('#start').keyup(function(){
            this.value = this.value.toUpperCase();
        });

        $('#end').keyup(function(){
            this.value = this.value.toUpperCase();
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

    function exportToExcel() {
        $(".containerBody").fadeOut();
        $(".avtoteeverPreloader").fadeIn();
        $.ajax({
            type: "GET",
            url: "/api/report/archivevehicle/@if(ISSET($op)){{ $op }}@else{{ "none" }}@endif/@if(ISSET($start)){{ $start }}@else{{ "none" }}@endif/@if(ISSET($end)){{ $end }}@else{{ "none" }}@endif",
            success: function (data) {
                @if(ISSET($start))
                    window.location = "/api/report/archivevehicle/@if(ISSET($op)){{ $op }}@else{{ "none" }}@endif/@if(ISSET($start)){{ $start }}@else{{ "none" }}@endif/@if(ISSET($end)){{ $end }}@else{{ "none" }}@endif";
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
