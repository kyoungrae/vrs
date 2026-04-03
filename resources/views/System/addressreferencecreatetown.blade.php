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
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <h6 class="card-title">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                아파트/단지 {{ isset($name) ? "수정" : "등록" }}
                            </div>
                        </div>
                    </h6>
                    <form action="{{ route("createtown") }}" method="POST">
                        {{ csrf_field() }}
                        <div class="row">
                            <!--왼쪽 영역 시작-->
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                @if(ISSET($message) || session()->has("message"))
                                    @include("System.message")
                                @endif
                                <input type="text" name="env" style="display: none;" value="{{ \App\Http\Controllers\BaseController::enc(session()->get("auth")->id) }}" class="form-control">
                                <input type="text" name="env1" style="display: none;" value="{{ isset($code) ? $code : "" }}" class="form-control">
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0 required-input">시, 도</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <select id="province" name="province" class="form-control form-control select2" onchange="districtHTML(this.value, 'district', 'district', '')">
                                            <option label="선택하세요"></option>
                                            @if(ISSET($provinces))
                                                @foreach($provinces as $province)
                                                    <option value="{{ $province->id }}">{{ $province->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0 required-input">군, 구</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <select id="district" name="district" class="form-control select2" onchange="districtHTML(this.value, 'commission', 'commission', '')">

                                        </select>
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0 required-input">읍, 면, 리, 동</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <select id="commission" name="commission" class="form-control select2">
                                            <option label="선택"></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5" style="{{ isset($user) ? "display:none;":""}}">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0 required-input">이름</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <input type="text" name="khoroolol" value="{{ isset($name) ? $name : "" }}" class="form-control">
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0 required-input">약어</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <input type="text" name="shorten" value="{{ isset($abbr) ? $abbr : "" }}" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <!--왼쪽 영역 끝-->
                        </div>
                        <hr class="mg-y-10">
                        <div class="row">
                            <div class="col-lg-4 col-md-6 col-sm-6"></div>
                            <div class="col-lg-2 col-md-6 col-sm-6">
                                <button class="btn btn-primary btn-block">{{ isset($name) ? "수정" : "등록" }}</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!--왼쪽 영역 끝-->
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
        $( "#restrictDate" ).datepicker( "option", "dateFormat", "yy-mm-dd" );

        $('.select2').select2({
            placeholder: '선택하세요'
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

    function districtHTML(location, id, type, selected) {
        $.ajax({
            type: "POST",
            url: vrsUrl('/api/location'),
            data: {"location": location, "type": type, "selected": selected},
            success: function( response ) {
                $("#"+id).html(response);
            }
        })
    }

    @if(ISSET($province_id))
        $("#province").val("{{ $province_id }}").change();
    @endif
    @if(ISSET($district_id))
        districtHTML({{ $province_id }}, "district", "district", {{ $district_id }});
        $("#district").change();
    @endif
     @if(ISSET($devision_unit_id))
        districtHTML({{ $district_id }}, "commission", "commission", {{ $devision_unit_id }});
        $("#commission").change();
    @endif
    $(document).ready(function () {
        $(".avtoteeverPreloader").fadeOut();
        $(".containerBody").fadeIn();
    });
</script>
</div>
</body>
</html>