<!DOCTYPE html>
<html lang="en">
<head>
    @include('Includes.head')
    <style>
        .checkbox {
            margin-top: 8px;
        }
        .searchButton
        {
            height: 28px;
            min-height: 10px;
            padding-top: 3px;
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
            <div class="card card-body card-dashboard-twentyfive mg-b-20">
                <div class="row row-sm">
                    <!--왼쪽 영역 시작-->
                    <div class="col-lg-9 col-md-12 col-sm-12">
                        <h6 class="card-title">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    시리즈 검색
                                </div>
                            </div>
                        </h6>
                        <form action="{{ route("seriessearch") }}" method="POST">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-lg-3 col-md-12 col-sm-12">
                                    <div class="row row-xs align-items-center mg-b-5">
                                        <div class="col-lg-3 col-md-12 col-sm-12">
                                            <label class="form-label mg-b-0">시리즈</label>
                                        </div>
                                        <div class="col-lg-9 col-md-12 col-sm-12">
                                            <select class="form-control select2" name="series">
                                                @if($seriess)
                                                    @foreach($seriess as $series)
                                                        <option value="{{ $series->id }}" {{ isset($select_series) ? ($series->id == $select_series ? "selected" : "") : "" }}>{{ $series->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-12 col-sm-12">
                                    <div class="row row-xs align-items-center mg-b-5">
                                        <div class="col-lg-6 col-md-12 col-sm-12">
                                            <label class="form-label mg-b-0">시작</label>
                                        </div>
                                        <div class="col-lg-6 col-md-12 col-sm-12">
                                            <input type="number" min="0" max="9999" id="type" name="start" value="{{ isset($start) ? $start : "" }}" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-12 col-sm-12">
                                    <div class="row row-xs align-items-center mg-b-5">
                                        <div class="col-lg-6 col-md-12 col-sm-12">
                                            <label class="form-label mg-b-0">종료</label>
                                        </div>
                                        <div class="col-lg-6 col-md-12 col-sm-12">
                                            <input type="number" min="0" max="9999" id="type" name="end" value="{{ isset($end) ? $end : "" }}" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-12 col-sm-12">
                                    <div class="row row-xs align-items-center mg-b-5">
                                        <div class="col-lg-6 col-md-12 col-sm-12">
                                        </div>
                                        <div class="col-lg-6 col-md-12 col-sm-12">
                                            <button type="submit" class="btn btn-primary btn-block searchButton">검색</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="mg-y-10">
                            <div class="row">
                                <!--왼쪽 영역 시작-->
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="row row-sm">
                                        <div class="col-12 col-sm-1 col-lg">
                                            <table id="searchTable1" class="display responsive nowrap" style="width:100%;text-align: center;">
                                                <thead>
                                                <tr>
                                                    <th>할당된 번호</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @if(ISSET($givens))
                                                    @foreach($givens as $given)
                                                        @if($given->is_hidden == 0)
                                                            <tr>
                                                                <td>{{ $given->name }}</td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!--왼쪽 영역 끝-->
                                <!--오른쪽 영역 시작-->
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="row row-sm">
                                        <div class="col-12 col-sm-1 col-lg">
                                            <table id="searchTable2" class="display responsive nowrap" style="width:100%;text-align: center;">
                                                <thead>
                                                <tr>
                                                    <th>미할당 번호</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @if(ISSET($notgivens))
                                                    @foreach($notgivens as $given)
                                                        @if($given->is_hidden == 0)
                                                            <tr>
                                                                <td>{{ $given->name }}</td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                @endif
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                                <!--오른쪽 영역 끝-->
                            </div>
                            <hr class="mg-y-10">
                        </form>
                    </div>
                    <!--왼쪽 영역 끝-->
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        @include('Includes.seriesmenu')
                    </div>
                </div>
            </div>
        </div>
        @include('Includes.footer')
    </div>б

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
                placeholder: '선택하세요'
            });

            $( "#restrictDate" ).datepicker( "option", "dateFormat", "yy-mm-dd" );

            $('#searchTable1').DataTable({
                responsive: true,
                language: {
                    searchPlaceholder: '검색...',
                    sSearch: '',
                    lengthMenu: '_MENU_ 1/페이지에 표시',
                }
            });

            $('#searchTable2').DataTable({
                responsive: true,
                language: {
                    searchPlaceholder: '검색...',
                    sSearch: '',
                    lengthMenu: '_MENU_ 1/페이지에 표시',
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
        });
        $(document).ready(function () {
            $(".avtoteeverPreloader").fadeOut();
            $(".containerBody").fadeIn();
        });
    </script>
</div>
</body>
</html>

