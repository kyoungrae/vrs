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
                                    오류 보고
                                </div>
                            </div>
                        </h6>
                        <div class="row row-sm">
                            <div class="col-12 col-sm-12 col-lg-12 col-md-12 ">
                                <form action="{{ route("issue") }}" method="POST" enctype="multipart/form-data" >
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <input type="text" name="env" style="display: none;" value="{{ isset($selected_issue) ? \App\Http\Controllers\BaseController::enc($selected_issue->id) : "" }}">
                                        <!--왼쪽 영역 시작-->
                                        <div class="col-lg-12 col-md-6 col-sm-12">
                                            @if(ISSET($message) || session()->has("message"))
                                                @include("System.message")
                                            @endif
                                            <div class="row row-xs align-items-center mg-b-5">
                                                <div class="col-lg-3 col-md-3 col-sm-3">
                                                    <label class="form-label mg-b-0 required-input">전화번호</label>
                                                </div>
                                                <div class="col-lg-8 col-md-8 col-sm-8">
                                                    <input type="text" id="phone" name="phone" class="form-control" value="{{ isset($selected_issue) ? $selected_issue->phone_no : "" }}" placeholder="연락처 전화번호" required style=" width: 100%; " />
                                                </div>
                                            </div>
                                            <div class="row row-xs align-items-center mg-b-5">
                                                <div class="col-lg-3 col-md-3 col-sm-3">
                                                    <label class="form-label mg-b-0 required-input">오류 설명</label>
                                                </div>
                                                <div class="col-lg-8 col-md-8 col-sm-8">
                                                    <textarea id="description" name="description" rows="5" class="form-control" required placeholder="오류에 대한 자세한 설명을 입력하세요" style=" width: 100%;     height: 150px !important;">{{ isset($selected_issue) ? $selected_issue->question : "" }}</textarea>
                                                </div>
                                            </div>
                                            <div class="row row-xs align-items-center mg-b-5">
                                                <div class="col-lg-3 col-md-3 col-sm-3">
                                                    <label class="form-label mg-b-0 required-input">이미지 첨부</label>
                                                </div>
                                                <div class="col-lg-8 col-md-8 col-sm-8">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" name="importfile">
                                                        <label class="custom-file-label" for="customFile">파일 선택</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--왼쪽 영역 끝-->
                                    </div>
                                    <hr class="mg-y-10">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-6 col-sm-6"></div>
                                        <div class="col-lg-2 col-md-6 col-sm-6">
                                            <button class="btn btn-primary btn-block">보내기</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <hr class="mg-y-10">
                        <div class="row row-sm">
                            <div class="col-12 col-sm-12 col-lg-12 col-md-12 ">
                                <div class="row">
                                    <div class="col-lg-7 col-md-6 col-sm-12">
                                        <h6 class="card-title">
                                            <div class="row">
                                                <div class="col-lg-7 col-md-6 col-sm-12">
                                                    목록
                                                </div>
                                            </div>
                                        </h6>
                                    </div>
                                </div>
                                @if(session()->get("auth")->userpositionid == 1)
                                    <table id="userTable" class="display responsive nowrap" style="width:100%;text-align: center;">
                                        <thead>
                                        <tr>
                                            <th style="width: 5%;">№</th>
                                            <th style="width: 10%;">개설일</th>
                                            <th style="width: 10%;">종료일</th>
                                            <th style="width: 10%;">상태</th>
                                            <th style="width: 14%;">보낸 직원</th>
                                            <th style="width: 14%;">전화번호</th>
                                            <th style="width: 27%;">문의</th>
                                            <th style="width: 8%;">문의 이미지</th>
                                            <th style="width: 27%;">답변</th>
                                            <th style="width: 8%;">답변 이미지</th>
                                            <th style="width: 8%;">#</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(ISSET($issues))
                                            @foreach($issues as $issue)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $issue->open_date }}</td>
                                                    <td>{{ $issue->close_date }}</td>
                                                    <td>{{ $issue->status == 0 ? "열림" : "닫힘" }}</td>
                                                    <td>{{ $issue->getUser($issue->open_user_id) }}</td>
                                                    <td>{{ $issue->phone_no }}</td>
                                                    <td>{{ $issue->question }}</td>
                                                    <td>
                                                        @if($issue->question_image != null && $issue->question_image != "")
                                                            <a href="{{ asset($issue->question_image) }}" target="_blank">이미지</a>
                                                        @endif
                                                    </td>
                                                    <td>{{ $issue->answer }}</td>
                                                    <td>
                                                        @if($issue->answer_image != "" && $issue->answer_image != "")
                                                            <a href="{{ asset($issue->answer_image) }}" target="_blank">이미지</a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="/send/issue/{{ \App\Http\Controllers\BaseController::enc($issue->id) }}">
                                                            <i class="typcn typcn-edit text-primary"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                @else
                                    <table id="userTable" class="display responsive nowrap" style="width:100%;text-align: center;">
                                        <thead>
                                        <tr>
                                            <th style="width: 5%;">№</th>
                                            <th style="width: 10%;">보낸 날짜</th>
                                            <th style="width: 10%;">답변 날짜</th>
                                            <th style="width: 10%;">상태</th>
                                            <th style="width: 27%;">문의</th>
                                            <th style="width: 8%;">이미지</th>
                                            <th style="width: 27%;">답변</th>
                                            <th style="width: 8%;">이미지</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(ISSET($issues))
                                            @foreach($issues as $issue)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $issue->open_date }}</td>
                                                    <td>{{ $issue->close_date }}</td>
                                                    <td>{{ $issue->status == 0 ? "열림" : "닫힘" }}</td>
                                                    <td>{{ $issue->question }}</td>
                                                    <td>
                                                        @if($issue->question_image != null && $issue->question_image != "")
                                                            <a href="{{ asset($issue->question_image) }}" target="_blank">이미지</a>
                                                        @endif
                                                    </td>
                                                    <td>{{ $issue->answer }}</td>
                                                    <td>
                                                        @if($issue->answer_image != "" && $issue->answer_image != "")
                                                            <a href="{{ asset($issue->answer_image) }}" target="_blank">이미지</a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                @endif
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