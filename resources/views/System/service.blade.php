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
                                {{ isset($service) ? "서비스 수정" : "신규 서비스 등록" }}
                            </div>
                        </div>
                    </h6>
                    <form action="{{ route("refservice") }}" method="POST">
                        {{ csrf_field() }}
                        <div class="row">
                            <!--왼쪽 영역 시작-->
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                @if(ISSET($message) || session()->has("message"))
                                    @include("System.message")
                                @endif
                                <div class="row row-xs align-items-center mg-b-5">
                                    <input type="text" name="env" style="display: none;" value="{{ isset($service) ? \App\Http\Controllers\BaseController::enc($service->id) : "" }}">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0 required-input">코드</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <input type="text" name="code" value="{{ isset($service) ? $service->code : "" }}" required class="form-control">
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0 required-input">이름</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <input type="text" name="name" value="{{ isset($service) ? $service->name : "" }}" required class="form-control">
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0 required-input">아카이브</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <input type="text" id="archiveNumber" name="archive" value="{{ isset($service) ? $service->serviceprefix : "" }}" required class="form-control">
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0 required-input">수수료</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <input type="number" name="fee" value="{{ isset($service) ? $service->fee : "" }}" required class="form-control">
                                    </div>
                                </div>
                            </div>
                            <!--왼쪽 영역 끝-->
                            <!--오른쪽 영역 시작-->
                            <!--오른쪽 영역 끝-->
                        </div>
                        {{--<hr class="mg-y-10">--}}
                        <div class="row">
                            <div class="col-lg-4 col-md-6 col-sm-6"></div>
                            <div class="col-lg-2 col-md-6 col-sm-6">
                                <button class="btn btn-primary btn-block">{{ isset($service) ? "수정" : "등록" }}</button>
                            </div>
                            {{--<div class="col-lg-2 col-md-6 col-sm-6">--}}
                                {{--<button class="btn btn-outline-primary btn-block">확인</button>--}}
                            {{--</div>--}}
                        </div>
                    </form>

                    <hr class="mg-y-10">
                    <div style="width: 100%">
                        <h6 class="card-title">서비스 목록</h6>
                        <div class="row row-sm">
                            <div class="col-12 col-sm-1 col-lg">
                                <table id="referenceTable" class="display responsive nowrap" style="width:100%;text-align: center;">
                                    <thead>
                                    <tr>
                                        <th>코드</th>
                                        <th>이름</th>
                                        <th>아카이브</th>
                                        <th>수수료</th>
                                        <th>작업</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(ISSET($services))
                                        @foreach($services as $service)
                                            <tr>
                                                <td>{{ \App\Helpers\TranslationHelper::translate($service->code) }}</td>
                                                <td>{{ \App\Helpers\TranslationHelper::translate($service->name) }}</td>
                                                <td>{{ \App\Helpers\TranslationHelper::translate($service->serviceprefix) }}</td>
                                                <td>{{ \App\Helpers\TranslationHelper::translate($service->fee) }}</td>
                                                <td>
                                                    <a href="/reference/service/edit/{{ \App\Http\Controllers\BaseController::enc($service->id) }}">
                                                        <i class="typcn typcn-edit text-primary"></i>
                                                    </a>
                                                    <a style="cursor: pointer;" onclick="if(confirm('이 기록을 삭제하시겠습니까?')){
                                                        window.location='/reference/service/delete/{{ \App\Http\Controllers\BaseController::enc($service->id) }}'
                                                    } return false;">
                                                        <i class="typcn typcn-trash text-warning"></i>
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
        $('#archiveNumber').keyup(function(){
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
    $(document).ready(function () {
        $(".avtoteeverPreloader").fadeOut();
        $(".containerBody").fadeIn();
    });
</script>
</div>
</body>
</html>
