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
                                    주문 번호 필터
                                </div>
                            </div>
                            <div class="row row-sm">
                                <div class="col-12 col-sm-1 col-lg">
                                    @if(ISSET($message) || session()->has("message"))
                                        @include("System.message")
                                    @endif
                                    @if(!(\App\Http\Controllers\BaseController::hasMenuShow("/reference/ordered_numbers", 1, \App\Http\Controllers\BaseController::enc(session()->get("auth")->userpositionid))))
                                    <form action="" method="POST">
                                        {{ csrf_field() }}
                                        <div class="row row-sm">
                                            <div class="col-3">
                                                <div class="row row-xs align-items-center mg-b-5">
                                                    <div class="col-lg-5 col-md-12 col-sm-12">
                                                        <label class="form-label mg-b-0 required-input">주민번호/사업자번호</label>
                                                    </div>
                                                    <div class="col-lg-7 col-md-12 col-sm-12">
                                                        <input type="text"  id="owneregister" name="register" value="{{ isset($register) ? $register : "" }}" class="form-control" oninput="translate2MGL(this.value)" autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-9">
                                                <div class="row row-xs align-items-center mg-b-5">
                                                    <div class="col-lg-2 col-md-4 col-sm-4">
                                                        <button type="submit" class="btn btn-primary btn-block btnnopadding">검색</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    @endif
                                    <hr class="mg-y-10">
                                    <table id="referenceTable" class="display responsive nowrap" style="width:100%;">
                                        <thead>
                                        <tr>
                                            <th>주민번호/사업자번호</th>
                                            <th>차대번호 마지막 5자리</th>
                                            <th>번호</th>
                                            <th>날짜</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(ISSET($numbers))
                                            @foreach($numbers as $row)
                                                <tr>
                                                    <td>{{ $row->order_user }}</td>
                                                    <td>{{ $row->order_cabin }}</td>
                                                    <td>{{ $row->name }}</td>
                                                    <td>{{ $row->order_date }}</td>
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
    <script>
        $(function(){
            'use strict'

            $('#referenceTable').DataTable({
                responsive: true,
                aLengthMenu: [30,50,100],
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
    </script>
</div>
</body>
</html>

