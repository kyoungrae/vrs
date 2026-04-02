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
                    <div class="" style="width: 100%;">
                        <h6 class="card-title">
                            <div class="row">
                                <div class="col-lg-7 col-md-6 col-sm-12">
                                    {{ \App\Helpers\TranslationHelper::translate("ХЭРЭГЛЭГЧДИЙН ЖАГСААЛТ") }}
                                </div>
                                <div id="headerButton" class="col-lg-5 col-md-6 col-sm-12 rightAlign">
                                    <a href="/user"><span id="btnPrint" class="headerButton"><i class="icon ion-ios-paper headerButtonIcon"></i> 신규사용자</span></a>
                                </div>
                            </div>
                        </h6>
                        <div class="row row-sm">
                            <div class="col-12 col-sm-12 col-lg-12 col-md-12 ">
                                @if(ISSET($message) || session()->has("message"))
                                    @include("System.message")
                                @endif
                                <table id="userTable" class="display responsive nowrap" style="width:100%;text-align: center;">
                                    <thead>
                                    <tr>
                                        <th>성</th>
                                        <th>이름</th>
                                        <th>{{ \App\Helpers\TranslationHelper::translate("Хэрэглэгчийн нэр") }}</th>
                                        <th>지점</th>
                                        <th>{{ \App\Helpers\TranslationHelper::translate("Хэлтэс") }}</th>
                                        <th>직위(공무)</th>
                                        <th>상태</th>
                                        <th>{{ \App\Helpers\TranslationHelper::translate("Үндсэн") }} 기관/단체</th>
                                        <th>작업</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(ISSET($users))
                                        @foreach($users->chunk(100) as $rows)
                                            @foreach($rows as $user)
                                                <tr>
                                                    <td>{{ \App\Helpers\TranslationHelper::translate($user->lastname) }}</td>
                                                    <td>{{ \App\Helpers\TranslationHelper::translate($user->firstname) }}</td>
                                                    <td>{{ \App\Helpers\TranslationHelper::translate($user->username) }}</td>
                                                    <td>{{ \App\Helpers\TranslationHelper::translate($user->name) }}</td>
                                                    <td>{{ \App\Helpers\TranslationHelper::translate($user->department) }}</td>
                                                    <td>{{ \App\Helpers\TranslationHelper::translate($user->position) }}</td>
                                                    <td>{{ \App\Helpers\TranslationHelper::translate($user->isactive == 1 ? "ИДЭВХТЭЙ" : "ИДЭВХГҮЙ") }}</td>
                                                    <td>{{ $user->isatvt == 1 ? "ATUT" : ($user->iscity == 1 ? \App\Helpers\TranslationHelper::translate("Нийслэл") : "기타") }}</td>
                                                    <td>
                                                        <a href="/user/edit/{{ \App\Http\Controllers\BaseController::enc($user->id) }}">
                                                            <i class="typcn typcn-edit text-primary"></i>
                                                        </a>
                                                        <a style="cursor: pointer;" onclick="if(confirm('이 레코드를 삭제하시겠습니까?')){
                                                                window.location='/user/delete/{{ \App\Http\Controllers\BaseController::enc($user->id) }}'
                                                                } return false;">
                                                            <i class="typcn typcn-trash text-warning"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
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
    <script src="{{ asset('lib/preloader/js/fakeLoader.min.js') }}"></script>
    <script>
        $(function(){
            'use strict'
            $( "#restrictDate" ).datepicker({
                changeMonth: true,
                changeYear: true
            });
            $( "#restrictDate" ).datepicker( "option", "dateFormat", "yy-mm-dd" );

            $('#userTable').DataTable({
                responsive: true,
                aaSorting: [],
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

