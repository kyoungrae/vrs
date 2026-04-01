<!DOCTYPE html>
<html lang="en">
<head>
    @include('Includes.head')
    <style>
        .dataTables_paginate
        {
            display: none;
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
        <div class="az-content-body" style="max-height: 200px !important;">
            <div class="card card-body card-dashboard-twentyfive mg-b-20">
                <div class="row row-sm">
                    <!--왼쪽 영역 시작-->
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        {{--<hr class="mg-y-10">--}}
                        <div class="" style="width: 200%;">
                            <div class="row">
                                <div class="card-title col-lg-7 col-md-6 col-sm-12">
                                    디지털 아카이브 검색
                                </div>
                            </div>
                            <div class="row row-sm">
                                <div class="col-12 col-sm-1 col-lg">
                                    <form action="" method="POST">
                                        {{ csrf_field() }}
                                        <div class="row row-sm">
                                            <div class="col-2">
                                                <div class="row row-xs align-items-center mg-b-5">
                                                    <div class="col-lg-5 col-md-12 col-sm-12">
                                                        <label class="form-label mg-b-0 required-input">아카이브 번호</label>
                                                    </div>
                                                    <div class="col-lg-7 col-md-12 col-sm-12">
                                                        <input type="text" id="archive" name="archive" value="{{ isset($archive) ? $archive : "" }}" class="form-control" oninput="translate2MGL(this.value)" required autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-10">
                                                <div class="row row-xs align-items-center mg-b-5">
                                                    <div class="col-lg-1 col-md-4 col-sm-4">
                                                        <button id="search" type="submit" class="btn btn-primary btn-block btnnopadding">검색</button>
                                                    </div>
                                                    <div class="col-lg-11 col-md-8 col-sm-8">
                                                        <label class="form-label mg-b-0" style="color: red;font-weight: 700">@if(isset($message)){{ $message }}@endif</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
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
            $('#archive').keyup(function(){
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
            $( "#search" ).click(function() {
                $(".containerBody").fadeOut();
                $(".avtoteeverPreloader").fadeIn();
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
            $("#archive").val(word);
        }
    </script>
</div>
</body>
</html>

