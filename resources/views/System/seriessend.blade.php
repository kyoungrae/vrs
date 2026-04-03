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
                    <h6 class="card-title">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                시리즈 {{ isset($interval) ? "수정" : "전송" }}
                            </div>
                        </div>
                    </h6>
                    <form action="{{ route("sendSeries") }}" method="POST">
                        {{ csrf_field() }}
                        <div class="row">
                            <!--왼쪽 영역 시작-->
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                @if(ISSET($message) || session()->has("message"))
                                    @include("System.message")
                                @endif
                                <div class="row row-xs align-items-center mg-b-5">
                                    <input type="text" name="env" style="display: none;" value="{{ isset($interval) ? \App\Http\Controllers\BaseController::enc($interval->id) : "" }}" class="form-control">
                                    <div class="col-lg-4 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0 required-input">부서</label>
                                    </div>
                                    <div class="col-lg-8 col-md-12 col-sm-12">
                                        <select class="form-control select2" required  id="department_id" name="department" onchange="loadUsers(this.value, 'user_id', '', 0)">
                                            <option label="선택하세요"></option>
                                            @if(isset($departments))
                                                @foreach($departments as $item)
                                                    <option value="{{ $item->id }}">{{ \App\Helpers\TranslationHelper::translate($item->name) }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-4 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0 required-input">전문가</label>
                                    </div>
                                    <div class="col-lg-8 col-md-12 col-sm-12">
                                        <select class="form-control select2" required id="user_id" name="user">
                                            {{--<option label="선택"></option>--}}
                                            {{--@if(isset($users))--}}
                                                {{--@foreach($users as $user)--}}
                                                    {{--<option value="{{ $user->id }}">{{ $user->firstname }}</option>--}}
                                                {{--@endforeach--}}
                                            {{--@endif--}}
                                        </select>
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-4 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0 required-input">시리즈</label>
                                    </div>
                                    <div class="col-lg-8 col-md-12 col-sm-12">
                                        <select class="form-control select2" required id="series_id" name="series">
                                            {{--<option label="선택"></option>--}}
                                            {{--@if(isset($seriess))--}}
                                                {{--@foreach($seriess as $item)--}}
                                                    {{--<option value="{{ $item->id }}">{{ $item->name }}</option>--}}
                                                {{--@endforeach--}}
                                            {{--@endif--}}
                                        </select>
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-4 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0 required-input">범위</label>
                                    </div>
                                    <div class="col-lg-4 col-md-12 col-sm-12">
                                        <input type="number" min="0" max="9999" id="type" name="start" value="{{ isset($interval) ? $interval->from_number : "" }}" required class="form-control">
                                    </div>
                                    <div class="col-lg-4 col-md-12 col-sm-12">
                                        <input type="number" min="0" max="9999" id="type" name="end" value="{{ isset($interval) ? $interval->to_number : "" }}" required class="form-control">
                                    </div>
                                </div>
                            </div>
                            <!--왼쪽 영역 끝-->
                            <!--오른쪽 영역 시작-->
                            <!--오른쪽 영역 끝-->
                        </div>
                        <hr class="mg-y-10">
                        <div class="row">
                            <div class="col-lg-4 col-md-6 col-sm-6"></div>
                            <div class="col-lg-2 col-md-6 col-sm-6">
                                <button class="btn btn-primary btn-block">{{ isset($interval) ? "수정" : "전송" }}</button>
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

    function loadUsers(department, id, selected, type) {
        $.ajax({
            type: "POST",
            url: vrsUrl('/api/depusers'),
            data: {"department": department, "selected": selected},
            success: function( response ) {
                $("#"+id).html(response);
                if(type == 0){
                    loadSeries(department, "series_id", "");
                } else {
                    loadSeries(department, "series_id", type);
                }
            }
        })
    }

    function loadSeries(department, id, selected) {
        $.ajax({
            type: "POST",
            url: vrsUrl('/api/depseries'),
            data: {"department": department, "selected": selected},
            success: function( response ) {
                $("#"+id).html(response);
            }
        })
    }

    $(document).ready(function () {
        @if(ISSET($interval))
            $("#department_id").val("{{ $interval->department_id }}").change();
            loadUsers("{{ $interval->department_id }}", "user_id", "{{ $interval->local_user_id }}", "{{ $interval->series_id }}")
            $("#department_id").attr("disabled", true);
        @endif
        $(".avtoteeverPreloader").fadeOut();
        $(".containerBody").fadeIn();
    });
</script>
</div>
</body>
</html>

