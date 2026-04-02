<!DOCTYPE html>
<html lang="en">
<head>
    @include('Includes.head')
    <style>
        .checkbox {
            margin-top: 8px;
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
                    @if(ISSET($message) || session()->has("message"))
                        @include("System.message")
                    @endif
                    <h6 class="card-title">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                {{ isset($curr_series) ? "시리즈 수정" : "시리즈 신규 등록" }}
                            </div>
                        </div>
                    </h6>
                    <form action="{{ route("createseries") }}" method="POST">
                        {{ csrf_field() }}
                        <div class="row">
                            <!--왼쪽 영역 시작-->
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="row row-xs align-items-center mg-b-5">
                                    <input type="text" name="env" style="display: none;" value="{{ isset($curr_series) ? \App\Http\Controllers\BaseController::enc($curr_series->id) : "" }}">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0 required-input">지점</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <select id="province" name="province" required class="form-control select2" id="province">
                                        @if(ISSET($provinces))
                                            @foreach($provinces as $province)
                                                <option value="{{ $province->id }}" {{ isset($curr_series) ? $curr_series->province_id == $province->id ? "selected" : "" : "" }}>{{ $province->name }}</option>
                                            @endforeach
                                        @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0 required-input">시리즈</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <input type="text" id="type" required name="series" value="{{ isset($curr_series) ? $curr_series->name : "" }}" class="form-control">
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0 required-input">유형</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <select id="type" name="type" required class="form-control select2">
                                            @if(ISSET($types))
                                                @foreach($types as $type)
                                                    <option value="{{ $type->id }}" {{ isset($curr_series) ? ($type->id == $curr_series->type ? "selected" : "") : "" }}>{{\App\Helpers\TranslationHelper::translate($type->name) }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5 checkbox">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">구버전 여부</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="ckbox">
                                            <input type="checkbox" name="old" {{ isset($curr_series) ? $curr_series->is_old == 1 ? "checked" : "" : "" }}><span></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5 checkbox">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">중복 여부</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="ckbox">
                                            <input type="checkbox" name="duplicate" {{ isset($curr_series) ? $curr_series->is_duplicate == 1 ? "checked" : "" : "" }}><span></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5 checkbox">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">주소 확인 여부</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="ckbox">
                                            <input type="checkbox" name="check" {{ isset($curr_series) ? $curr_series->is_check_address == 1 ? "checked" : "" : "" }}><span></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="mg-y-10">
                        <div class="row">
                            <div class="col-lg-4 col-md-6 col-sm-6"></div>
                            <div class="col-lg-2 col-md-6 col-sm-6">
                                <button type="submit" class="btn btn-primary btn-block">{{ isset($curr_series) ? "수정" : "생성" }}</button>
                            </div>
                        </div>
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
            placeholder: '선택하세요'
        });

        $('#type').keyup(function(){
            this.value = this.value.toUpperCase();
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
                lengthMenu: '_MENU_ 페이지당 표시',
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

