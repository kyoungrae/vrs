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
                        {{--<hr class="mg-y-10">--}}
                        <div class="" style="width: 100%;">
                            <div class="row">
                                <div class="card-title col-lg-7 col-md-6 col-sm-12">
                                    소유자 목록
                                </div>
                                <div id="headerButton" class="col-lg-5 col-md-6 col-sm-12 rightAlign">
                                    <a href="/reference/createowner"><span id="btnPrint" class="headerButton"><i class="icon ion-ios-paper headerButtonIcon"></i> 신규 소유자</span></a>
                                </div>
                            </div>
                            <div class="row row-sm">
                                <div class="col-12 col-sm-1 col-lg">
                                    @if(ISSET($message) || session()->has("message"))
                                        @include("System.message")
                                    @endif
                                    <form action="{{ route("owner") }}" method="POST">
                                        {{ csrf_field() }}
                                        <div class="row row-sm">
                                            <div class="col-3">
                                                <div class="row row-xs align-items-center mg-b-5">
                                                    <div class="col-lg-5 col-md-12 col-sm-12">
                                                        <label class="form-label mg-b-0">주민번호/사업자번호</label>
                                                    </div>
                                                    <div class="col-lg-7 col-md-12 col-sm-12">
                                                        <input type="text"  id="owneregister" name="register" value="{{ isset($register) ? $register : "" }}"  class="form-control">
                                                        {{-- <input type="hidden"  id="owneregister" name="register" value="{{ isset($register) ? $register : "" }}" oninput="translate2MGL(this.value)" class="form-control"> --}}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="row row-xs align-items-center mg-b-5">
                                                    <div class="col-lg-4 col-md-12 col-sm-12">
                                                        <label class="form-label mg-b-0">전화번호</label>
                                                    </div>
                                                    <div class="col-lg-8 col-md-12 col-sm-12">
                                                        <input type="text" name="phone" value="{{ isset($phone) ? $phone : "" }}"  class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="row row-xs align-items-center mg-b-5">
                                                    <div class="col-lg-4 col-md-12 col-sm-12">
                                                        <label class="form-label mg-b-0">이름</label>
                                                    </div>
                                                    <div class="col-lg-8 col-md-12 col-sm-12">
                                                        <input type="text" id="ownername" name="name" value="{{ isset($name) ? $name : "" }}"  class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-3">
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
                                            <th>국적/거주지</th>
                                            <th>유형</th>
                                            <th>주민번호/사업자번호</th>
                                            <th>성씨</th>
                                            <th>부/모 성명</th>
                                            <th>이름</th>
                                            <th>직장 전화번호</th>
                                            <th>작업</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(ISSET($owners))
                                            @foreach($owners as $owner)
                                                <tr>
                                                    <td>{{ $owner->country }}</td>
                                                    <td>{{ $owner->name }}</td>
                                                    <td>{{ $owner->register_no }}</td>
                                                    <td>{{ $owner->family_name }}</td>
                                                    <td>{{ $owner->last_name }}</td>
                                                    <td>{{ $owner->first_name }}</td>
                                                    <td>{{ $owner->phone_no }}</td>
                                                    <td>
                                                        <a href="/reference/createowner/edit/{{ \App\Http\Controllers\BaseController::enc($owner->id) }}">
                                                            <i class="typcn typcn-edit text-primary"></i>
                                                        </a>
                                                        {{--<a style="cursor: pointer;" onclick="if(confirm('이 레코드를 삭제하시겠습니까?')){--}}
                                                                {{--window.location='/reference/createowner/delete/{{ \App\Http\Controllers\BaseController::enc($owner->id) }}'--}}
                                                                {{--} return false;">--}}
                                                            {{--<i class="typcn typcn-trash text-warning"></i>--}}
                                                        {{--</a>--}}
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
                </div>
                <!--왼쪽 영역 끝-->
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

            $('#referenceTable').DataTable({
                responsive: true,
                language: {
                    searchPlaceholder: '검색...',
                    sSearch: '',
                    lengthMenu: '_MENU_ 페이지당 표시',
                }
            });

            $('.select2').select2({
                placeholder: '선택하세요'
            });

            $('#owneregister').keyup(function(){
                this.value = this.value.toUpperCase();
            });

            $('#ownername').keyup(function(){
                this.value = this.value.toUpperCase();
            });

            $('#owneregister').on('keyup', function() {
                limitText(this, 12)
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

        var Lat2Cyr = {
            "a": "Й",
            "b": "М",
            "c": "Ё",
            "d": "Б",
            "e": "У",
            "f": "Ө",
            "g": "А",
            "h": "Х",
            "i": "Ш",
            "j": "Р",
            "k": "О",
            "l": "Л",
            "m": "Т",
            "n": "И",
            "o": "О",
            "p": "З",
            "q": "Ф",
            "r": "Ж",
            "s": "Ы",
            "t": "Э",
            "u": "Г",
            "v": "С",
            "w": "Ц",
            "x": "Ч",
            "y": "Н",
            "z": "Я",
            "-": "Е",
            "[": "К",
            ".": "В",
            ";": "Д",
            "'": "П",

            "A": "Й",
            "B": "М",
            "C": "Ё",
            "D": "Б",
            "E": "У",
            "F": "Ө",
            "G": "А",
            "H": "Х",
            "I": "Ш",
            "J": "Р",
            "K": "О",
            "L": "Л",
            "M": "Т",
            "N": "И",
            "O": "Ү",
            "P": "З",
            "Q": "Ф",
            "R": "Ж",
            "S": "Ы",
            "T": "Э",
            "U": "Г",
            "V": "С",
            "W": "Ц",
            "X": "Ч",
            "Y": "Н",
            "Z": "Я",
        };
        function translate2MGL(word){
            if(word){
                word = word.toUpperCase();
            }
            word =  word.split('').map(function (char) {
                return Lat2Cyr[char] || char;
            }).join("");
            $("#owneregister").val(word);
        }

        function districtHTML(location, id, type, selected) {
            $.ajax({
                type: "POST",
                url: '/api/location',
                data: {"location": location, "type": type, "selected": selected},
                success: function( response ) {
                    $("#"+id).html(response);
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

