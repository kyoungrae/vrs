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
                <div class="col-lg-8 col-md-12 col-sm-12">
                    <h6 class="card-title">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                사용자별 전송 시리즈 목록
                            </div>
                        </div>
                    </h6>
                    <div class="row row-sm">
                        <div class="col-12 col-sm-1 col-lg">
                            <form action="{{ route("sentfilter") }}" method="POST">
                                {{ csrf_field() }}
                                <div class="row row-sm">
                                    <div class="col-5">
                                        <div class="row row-xs align-items-center mg-b-5">
                                            <div class="col-lg-5 col-md-12 col-sm-12">
                                                <label class="form-label mg-b-0 required-input">직위</label>
                                            </div>
                                            <div class="col-lg-7 col-md-12 col-sm-12">
                                                <select class="form-control select2" name="position">
                                                    <option value="">전체</option>
                                                    @if(isset($positions))
                                                        @foreach($positions as $position)
                                                            <option value="{{ $position->id }}" {{ isset($s_position) ? ($s_position == $position->id ? "selected" : "") : ""}}>{{ $position->name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="row row-xs align-items-center mg-b-5">
                                            <div class="col-lg-4 col-md-12 col-sm-12">
                                                <label class="form-label mg-b-0 required-input">지점</label>
                                            </div>
                                            <div class="col-lg-8 col-md-12 col-sm-12">
                                                <select class="form-control select2" name="department">
                                                    <option value="">전체</option>
                                                    @if(isset($departments))
                                                        @foreach($departments as $department)
                                                            <option value="{{ $department->id }}" {{ isset($s_department) ? ($s_department == $department->id ? "selected" : "") : ""}}>{{ $department->name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="row row-xs align-items-center mg-b-5">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <button type="submit" class="btn btn-primary btn-block btnnopadding">검색</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <hr class="mg-y-10">
                            <table id="referenceTable" class="display responsive nowrap" style="width:100%;">
                                <thead>
                                <tr>
                                    <th>번호</th>
                                    <th>성씨</th>
                                    <th>이름</th>
                                    <th>부서</th>
                                    <th>지점</th>
                                    <th>직위</th>
                                    <th>작업</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(ISSET($series))
                                    @foreach($series as $item)
                                        <tr style="cursor:pointer;" onclick="numberList('{{ \App\Http\Controllers\BaseController::enc($item->id) }}')">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->lastname }}</td>
                                            <td>{{ $item->firstname }}</td>
                                            <td>{{ $item->department }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->position }}</td>
                                            <td style="text-align: center;">
                                                <a href="/series/send/edit/{{ \App\Http\Controllers\BaseController::enc($item->id) }}" target="_blank">
                                                    <i class="typcn typcn-edit text-primary"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!--왼쪽 영역 끝-->
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="az-media-list-activity mg-b-20 moreNumbers flexcroll">
                        <table id="numberTable" class="display responsive nowrap" style="width:100%;">
                            <thead>
                            <tr>
                                <th>№</th>
                                <th>번호</th>
                                <th>등록일</th>
                            </tr>
                            </thead>
                            <tbody id="numberBody">

                            </tbody>
                        </table>
                    </div>
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
    $(function(){
        'use strict'
        $( "#restrictDate" ).datepicker({
            changeMonth: true,
            changeYear: true
        });

        $('.select2').select2({
            placeholder: '전체'
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

        drawNumberTable();

        function drawNumberTable()
        {
            $('#numberTable').DataTable({
                responsive: true,
                bFilter: true,
                bPaginate: false,
                bLengthChange: false,
                language: {
                    searchPlaceholder: '검색...',
                    sSearch: '',
                    lengthMenu: '_MENU_ 1/페이지에 표시',
                }
            });
        }

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

    function numberList(interval) {
        $.ajax({
            type: "POST",
            url: '/api/numbers',
            data: {"interval": interval},
            success: function( response ) {
                $("#numberBody").html();

                var table = $('#numberTable').DataTable();
                table.destroy();
                $('#example').html('<thead><tr><th></th></tr></thead><tbody></tbody>');
                $("#numberBody").html(response);
                $('#numberTable').DataTable({
                    responsive: true,
                    bFilter: true,
                    bPaginate: false,
                    bLengthChange: false,
                    language: {
                        searchPlaceholder: '검색...',
                        sSearch: '',
                        lengthMenu: '_MENU_ 1/페이지에 표시',
                    }
                });
            }
        })
    }
    $(document).ready(function () {
        $(".avtoteeverPreloader").fadeOut();
        $(".containerBody").fadeIn();
    });
</script>
</div>
</body>
</html>

