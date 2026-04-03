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
        <div class="az-content-body">
            <div class="card card-body card-dashboard-twentyfive mg-b-20">
                <div class="row row-sm">
                    <!--왼쪽 영역 시작-->
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        {{--<hr class="mg-y-10">--}}
                        <div class="" style="width: 100%;">
                            <div class="row">
                                <div class="card-title col-lg-7 col-md-6 col-sm-12">
                                    인쇄 번호 확인 및 목록
                                </div>
                            </div>
                            <div class="row row-sm">
                                <div class="col-12 col-sm-1 col-lg">
                                    @if(ISSET($message) || session()->has("message"))
                                        @include("System.message")
                                    @endif
                                    <form action="" method="POST">
                                        {{ csrf_field() }}
                                        <div class="row row-sm">
                                            <div class="col-2">
                                                <div class="row row-xs align-items-center mg-b-5">
                                                    <div class="col-lg-3 col-md-12 col-sm-12">
                                                        <label class="form-label mg-b-0 required-input">번호</label>
                                                    </div>
                                                    <div class="col-lg-9 col-md-12 col-sm-12">
                                                        <input type="text" id="plate" name="plate" required value="0589АР" class="form-control" oninput="translate2MGL(this.value)" autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="row row-xs align-items-center mg-b-5">
                                                    <div class="col-lg-4 col-md-12 col-sm-12">
                                                        <label class="form-label mg-b-0 required-input">차량 유형</label>
                                                    </div>
                                                    <div class="col-lg-8 col-md-12 col-sm-12">
                                                        <select id="type" name="type" required class="form-control select2">
                                                            @if(ISSET($types))
                                                                @foreach($types as $type)
                                                                    <option value="{{ $type->id }}">{{ \App\Helpers\TranslationHelper::translate($type->name) }}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                           
                                          <div class="col-3">
                                                <div class="row row-xs align-items-center mg-b-5">
                                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                                        <label style="display: none"  id="plateColorLabel" class="form-label mg-b-0 required-input">번호판 배경색 </label>
                                                    </div>
                                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                                        <div id="plateColorDiv"> </div>
                                                  
                                                    </div>
                                                </div>
                                            </div>  




                                            <div class="col-2">
                                                <div class="row row-xs align-items-center mg-b-5">
                                                    <div class="col-lg-8 col-md-12 col-sm-12">
                                                        <button id="check" type="button" onclick="checkPrintPlate();" class="btn btn-primary btn-block btnnopadding">확인</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="row row-xs align-items-center mg-b-5">
                                                    <div class="col-lg-8 col-md-12 col-sm-12">
                                                        <button id="printButton" type="submit" style="display: none;" class="btn btn-primary btn-block btnnopadding">인쇄</button>
                                                    </div>
                                                </div>
                                            </div>
                                          
                                        </div>
                                    </form>
                                    <hr class="mg-y-10">
                                    <table id="referenceTable" class="display responsive nowrap" style="width:100%;">
                                        <thead>
                                        <tr>
                                            <th>№</th>
                                            <th>차량 번호</th>
                                            <th>번호판 배경색</th>
                                            <th>날짜</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(ISSET($numbers))
                                        
                                            @foreach($numbers as $row)
                                            
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>
                                                        <div class="@if ($row->platecolor == 1)
                                                            plateFactory
                                                       
                                                       @elseif ($row->platecolor == 2)
                                                       plateFactoryYellow
                                                       @elseif ($row->platecolor == 3)
                                                       plateFactoryGreen
                                                       @elseif ($row->platecolor == 4)
                                                       plateFactoryRed
                                                       @elseif ($row->platecolor == 5)
                                                       plateFactoryBlack
                                                       @elseif ($row->platecolor == 6)
                                                       plateFactoryBlue
                                                       @else
                                                       plateFactory
                                                       @endif">{{ $row->plate_no }}</div>
                                                        </td>

                                                    <td>@if ($row->platecolor == 1)
                                                         배경색: 흰색
                                                    
                                                    @elseif ($row->platecolor == 2)
                                                     배경색: 노란색
                                                    @elseif ($row->platecolor == 3)
                                                     배경색: 녹색
                                                    @elseif ($row->platecolor == 4)
                                                     배경색: 빨간색
                                                    @elseif ($row->platecolor == 5)
                                                     배경색: 검정색
                                                    @elseif ($row->platecolor == 6)
                                                     배경색: 파란색
                                                    @else 
                                                    배경색: 하얀색
                                                    @endif
                                                
                                                
                                                
                                                </td>

                                                    <td>{{ $row->update_date }}</td>
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
	<style>
	.plateFactory{
    width: 111px;
    height: 33px;
    background: rgb(255 255 255);
    border: 5px solid;
    text-align: center;
    font-weight: 700;
    border-style: double;
    padding: 3px;
    border-color: #040404;
    color: #0e0e0e;
    border-radius: 4px;
}
.plateFactoryYellow{
    width: 111px;
    height: 33px;
    background: rgb(185 167 14);
    border: 5px solid;
    text-align: center;
    font-weight: 700;
    border-style: double;
  
    padding: 3px;
    border-color: #fff;
    color: #fff;
    border-radius: 4px;
}
.plateFactoryGreen{
    width: 111px;
    height: 33px;
    background: rgb(8 162 70);
    border: 5px solid;
    text-align: center;
    font-weight: 700;
    border-style: double;
    padding: 3px;
    border-color: #fff;
    color: #fff;
    border-radius: 4px;
}
.plateFactoryRed{
    width: 111px;
    height: 33px;
    background: rgb(212 10 10);
    border: 5px solid;
    text-align: center;
    font-weight: 700;
    border-style: double;
    padding: 3px;
    border-color: #fff;
    color: #fff;
    border-radius: 4px;
}
.plateFactoryBlack{
    border-radius: 4px;
    width: 111px;
    height: 33px;
    background: rgb(33 32 30);
    border: 5px solid;
    text-align: center;
    font-weight: 700;
    border-style: double;
    padding: 3px;
    border-color: #fff;
    color: #fff;
    border-radius: 4px;
}
.plateFactoryBlue{
    border-radius: 4px;
    width: 111px;
    height: 33px;
    background: #0062cb;
    border: 5px solid;
    text-align: center;
    font-weight: 700;
    border-style: double;
    padding: 3px;
    border-color: #fff;
    color: #fff;
    border-radius: 4px;
}
	
	</style>
<link rel="stylesheet" href="{{ asset('css/plateFactory.css') }}">
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
            $("form").keypress(function(e) {
                //Enter key
                if (e.which == 13) {
                    return false;
                }
            });
        });

        function checkPrintPlate() {
            var plate = $("#plate").val();
            var type = $("#type").val();
           // var plateColor = $("#plateColor").val();
            if(plate.length > 0 && type.length > 0){
                $.ajax({
                    type: "POST",
                    url: '/api/checkprintplate',
                    data: {"plate": plate, "type": type},
                    success: function( response ) {
                    
                  // console.log(response.id);
                     
                        if(response.id > 0 ){

                            $("#printButton").css("display", "block");
                            $("#plateColorLabel").css("display", "block");
                            document.getElementById("check").disabled = true;
                       // $.each(response, function (key, value) {
                               // var plateColor=value.platecolor;
                            

                                var color=[];
                                var plateBackground=[];
                                if(response.platecolor==1){
                                      color.push("번호판 배경색 하얀색");
                                      plateBackground.push("plateFactory");
                                 }else if(response.platecolor==2){
                                      color.push("번호판 배경색 노란색");
                                      plateBackground.push("plateFactoryYellow");
                                 }else if(response.platecolor==3){
                                      color.push("번호판 배경색 초록색");
                                      plateBackground.push("plateFactoryGreen");
                                 }else if(response.platecolor==4){
                                     color.push("번호판 배경색 빨간색");
                                     plateBackground.push("plateFactoryRed");
                                      
                                 }else if(response.platecolor==5){
                                         color.push("번호판 배경색 검정색");
                                         plateBackground.push("plateFactoryBlack");
                                 }else if(response.platecolor==6){
                                         color.push("번호판 배경색 파란색");
                                         plateBackground.push("plateFactoryBlue");
                                 }else{
                                     color.push("이 번호를 인쇄할 때 색상이 선택되지 않았습니다");
                                     plateBackground.push("plateFactory");
                                  }
                                var html=
                                '<div class='+plateBackground+'>'+ plate +'</div>'
                                $("#plateColorDiv").append(html);
                       // });

                    }else{
                            $("#printButton").css("display", "none");
                            $("#plateColorLabel").css("display", "none");
                            $("#plateColorDiv").css("display", "none");
                            alert(plate+" 차량 번호를 인쇄할 수 없습니다.");
                    }
                      //  if(response == "true"){
                      //      $("#printButton").css("display", "block");
                      //  } else {
                        //    $("#printButton").css("display", "none");
                       ///     alert(plate+" 차량 번호를 인쇄할 수 없습니다.");
                       // }
                    }
                })
            } else {
                alert("차량 번호를 입력하세요!");
            }
        }
        $(document).ready(function () {
            $(".avtoteeverPreloader").fadeOut();
            $(".containerBody").fadeIn();

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
            $("#plate").val(word);
        }
    });
    </script>
</div>
</body>
</html>
