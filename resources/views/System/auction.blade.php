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
                                    경매
                                </div>
       
                            </div>
                        </h6>
                        <div class="row row-sm">
                            <div class="col-12 col-sm-12 col-lg-12 col-md-12 ">
                                @if(ISSET($message) || session()->has("message"))
                                    @include("System.message")
                                @endif
                                <form action="{{route('auction')}}" method="POST">
                                    {{ csrf_field() }}
                                    <div class="row row-sm">
                                        <div class="col-4">
                                            <div class="row row-xs align-items-center mg-b-5">
                                                <div class="col-lg-4 col-md-12 col-sm-12">
                                                    <label class="form-label mg-b-0 required-input">차량 번호</label>
                                                </div>
                                                <div class="col-lg-8 col-md-12 col-sm-12">
                                                    <input id="plateNo" name="plateNo" required type="text" placeholder="차량 번호" value="" class="form-control" oninput="translate2MGL(this.value)" autocomplete="off" autofocus>

                                                </div>
                                            </div>
                                        
                                        {{-- <div class="col-3"> --}}
                                            <div class="row row-xs align-items-center mg-b-5">
                                                <div class="col-lg-4 col-md-12 col-sm-12">
                                                    <label class="form-label mg-b-0 required-input">차대 번호</label>
                                                </div>
                                                <div class="col-lg-8 col-md-12 col-sm-12">
                                                    <input id="cabin" name="cabin"  required type="number" placeholder="차대 번호"  value="" class="form-control" autocomplete="off">
                                                </div>
                                            </div>
                                            <div  class="row row-xs align-items-center mg-b-5">
                                                <div class="col-lg-4 col-md-4 col-sm-4">
                                                    <label class="form-label mg-b-0 required-input">낙찰자 등록번호</label>
                                                </div>
                                                <div class="col-lg-8 col-md-8 col-sm-8">
                                                    <input id="register" name="register"  required type="text" placeholder="낙찰자 등록번호"  value="" class="form-control" autocomplete="off">
                                                </div>
                                            </div>
                                            {{-- <div class="row row-xs align-items-center mg-b-5">
                                              
                                                <div class="col-lg-8 col-md-12 col-sm-12" style="">
                                                    <input id="register" name="register"  required type="hidden" value="" class="form-control" autocomplete="off">
                                                </div>
                                            </div> --}}
                                            </div>
                                        {{-- </div> --}}
                                        <div class="col-3">
                                            <div class="row row-xs align-items-center mg-b-5">
                                                <div class="col-lg-4 col-md-12 col-sm-12">
                                                    <button type="button"  onclick="auctionCheck();" class="btn btn-success btn-block btnnopadding">확인</button>
                                                </div>
                                               
                                                {{-- <div class="col-lg-4 col-md-12 col-sm-12">
                                                    <button type="button" onclick="exportToExcel()" class="btn btn-primary btn-block btnnopadding"><i class="far fa-file-excel"></i> 엑셀</button>
                                                </div>
                                                <div class="col-lg-4 col-md-12 col-sm-12">
                                                    <button type="button" onclick="clearFields()" class="btn btn-primary btn-block btnnopadding">지우기</button>
                                                </div> --}}
                                            </div>
                                        </div>
                                    </div>
                                    <div style="    padding: 0;" class="col-lg-4 col-md-6 col-sm-12" id="ntrDetail">
                                        {{-- <h6 id="servicename" style=" text-align: center;color: #2f8605;"></h6> --}}
                                        <table class="table table-bordered" id="ntrTable">
                                          
                                            <tbody id="auctionTableBody"></tbody>
                                        </table>
                                    </div>
                                </form>
                                
                               
                               
                              
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
         function auctionCheck(){
        
         $(".avtoteeverPreloader").fadeIn();
        try {
            var plate = $("#plateNo").val();
           // alert(plate);
            $.ajax({
                type: 'post',
                url: vrsUrl('/api/auctionCheck'),
                dataType: "json",
                data: {
                    param1: plate,
                    param2: '{{ \App\Http\Controllers\BaseController::enc(\Carbon\Carbon::now()->format("Y-m-d")) }}'
                },
                timeout: 60000,
                error: function (data) {
                    $(".avtoteeverPreloader").fadeOut();
                    $(".containerBody").fadeIn();
                },
                success: function (data) {
                   //  console.log(data);
                   if (data['data'].is_paid == 1) {

                    $("#registerOwn").css("display", "block");
                    document.getElementById("register").value =data['data']['winner_info'].regnum;
                    
                     $("#auctionTableBody").html("");
                   
                    var html = 
                    '<tr>'+'<td colspan="2" style="text-align: center;font-weight: bold;">'+"경매 낙찰자 정보" +'</td>'+'</tr>'+
                    
                    '<tr >' +
                        ' <td>' + '<strong> 성 </strong>'+ ' </td>' +
                        ' <td>'  +data['data']['winner_info'].lastname + ' </td>' +
                                        
                     ' </tr>'+
                     '<tr >' +
                       ' <td>' + '<strong> 이름</strong>'+ ' </td>' +
                       ' <td>'  + data['data']['winner_info'].firstname + ' </td>' +
                                   
                     ' </tr>'+
                     '<tr >' +
                       ' <td>' + '<strong> 등록번호 </strong>'+ ' </td>' +
                        ' <td>'  +data['data']['winner_info'].regnum+ ' </td>' +
                                     
                      ' </tr>'+
                      '<tr >' +
                        ' <td>' + '<strong>결제 </strong>' + ' </td>' +
                         ' <td style="color:green;">'  +"결제완료"+ ' </td>' +
                      ' </tr>'+
                      '<tr>'+
                      '<td colspan="2" >'+ '<div style="margin: 0 auto;" class="col-6">'+
                             '<button type="submit"  class="btn btn-primary btn-block btnnopadding">주문</button>'+
                             '</div>'+
                              ' </td>' +
                      ' </tr>';
                                    $("#auctionTableBody").append(html);
                                    $(".avtoteeverPreloader").fadeOut();
                 }else{
                     const msg =data['status'].message;
                    $("#auctionTableBody").html("");
                   
                   var html = 
                   '<tr>'+'<td style="color:red;" colspan="2" style="text-align: center;font-weight: bold;">'+msg +'</td>'+
                   ' </tr>';
                                    $("#auctionTableBody").append(html);
                                    $(".avtoteeverPreloader").fadeOut();

                 }
               

                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $(".avtoteeverPreloader").fadeOut();
                    $(".containerBody").fadeIn();
                }
            });
        }catch(err) {
            $(".avtoteeverPreloader").fadeOut();
            $(".containerBody").fadeIn();
        }

    }
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
            $( "#start" ).datepicker({
            changeMonth: true,
            changeYear: true
        });
        $( "#start" ).datepicker( "option", "dateFormat", "yy-mm-dd" );

        $( "#end" ).datepicker({
            changeMonth: true,
            changeYear: true
        });
        $( "#end" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
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
        "/": "Ю",

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

    var Cyr2Lat = {
        "Й":"a" ,
        "М":"b" ,
        "Ё":"c" ,
        "Б":"d",
        "У": "e" ,
        "Ө":"f" ,
        "А":"g" ,
        "Х":"h" ,
        "Ш":"i" ,
        "Р":"j" ,
        "О":"k" ,
        "Л":"l" ,
        "Т":"m" ,
        "И":"n" ,
        "О":"o" ,
        "З":"p" ,
        "Ф":"q" ,
        "Ж":"r" ,
        "Ы":"s" ,
        "Э":"t" ,
        "Г":"u" ,
        "С":"v" ,
        "Ц":"w" ,
        "Ч":"x" ,
        "Н":"y" ,
        "Я":"z",
        "Е":"-" ,
        "К":"[" ,
        "В":"." ,
        "Д":";" ,
        "П":"'" ,

        "Й":"A" ,
        "М":"B" ,
        "Ё":"C" ,
        "Б":"D" ,
        "У":"E" ,
        "Ө":"F" ,
        "А":"G" ,
        "Х":"H" ,
        "Ш":"I",
        "Р":"J" ,
        "О": "K" ,
        "Л":"L" ,
        "Т":"M" ,
        "И":"N" ,
        "Ү":"O" ,
        "З":"P" ,
        "Ф":"Q" ,
        "Ж": "R",
        "Ы":"S" ,
        "Э":"T" ,
        "Г":"U" ,
        "С": "V" ,
        "Ц": "W" ,
        "Ч":"X",
        "Н": "Y" ,
        "Я": "Z",
    };

    function translate2MGLTwo(id, word){
        if(word){
            word = word.toUpperCase();
        }
        word =  word.split('').map(function (char) {
            return Lat2Cyr[char] || char;
        }).join("");
        $("#" + id).val(word);
    }

    function translate2MGL(word){
        if(word){
            word = word.toUpperCase();
        }
        word =  word.split('').map(function (char) {
            return Lat2Cyr[char] || char;
        }).join("");
        $("#plateNo").val(word);
    }

    function translate2LATIN(word){
        if(word){
            word = word.toUpperCase();
        }
        word =  word.split('').map(function (char) {
            return Cyr2Lat[char] || char;
        }).join("");
        $("#cabin_no_id").val(word);
    }

    function translate2MGL_Register(word){
        if(word){
            word = word.toUpperCase();
        }
        word =  word.split('').map(function (char) {
            return Lat2Cyr[char] || char;
        }).join("");
        $("#register_own").val(word);
    }
    </script>
</div>
</body>
</html>
