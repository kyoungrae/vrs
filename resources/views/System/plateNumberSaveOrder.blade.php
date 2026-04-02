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
                <div class="col-lg-9 col-md-12 col-sm-12">
                    {{--<div class="card card-body card-dashboard-twentyfive mg-b-20">--}}

                    {{--</div>--}}
                    <h6 class="card-title">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                              보관된 번호판 예약 서비스
                            </div>
                        </div>
                    </h6>
                    <div class="row row-sm">
                        <div class="col-12 col-sm-1 col-lg">
                            <form action="{{route('plateSaveOrder')}}" method="POST">
                                {{ csrf_field() }}
                                <div class="row row-sm">
                                    <div class="col-4">
                                        <div class="row row-xs align-items-center mg-b-5">
                                            <div class="col-lg-4 col-md-12 col-sm-12">
                                                <label class="form-label mg-b-0 required-input">차량 번호</label>
                                            </div>
                                            <div class="col-lg-8 col-md-12 col-sm-12">
                                                <input id="plateNo" name="plateNo" required type="text" placeholder="번호판" value="0138УНГ" class="form-control" oninput="translate2MGL(this.value)" autocomplete="off" autofocus required>
                                            
                                        
                                            </div>
                                        </div>
                                     
                                  
                                        </div>
                                   
                                  
                                    <div class="col-3">
                                        <div class="row row-xs align-items-center mg-b-5">
                                            <div class="col-lg-4 col-md-12 col-sm-12">
                                                <button type="button"  onclick="auctionCheck();" class="btn btn-success btn-block btnnopadding">검색</button>
                                            </div>
                                           
                                    
                                        </div>
                                    </div>
                                  
                                </div>
                                <div class="row">
                                
                                <div style="    padding: 0;" class="col-lg-6 col-md-6 col-sm-12" id="ntrDetail">
                                    {{-- <h6 id="servicename" style=" text-align: center;color: #2f8605;"></h6> --}}
                               
                                    <div class="col-8 align-items-center mg-b-5" id="orderCabin" style="display: none">
                                        <div class="row row-xs">
                                        <div class="col-lg-4 col-md-12 col-sm-12">
                                            <label class="form-label mg-b-0 required-input">차대 번호</label>
                                        </div>
                                        <div class="col-lg-8 col-md-12 col-sm-12">
                                            <input id="customerOrderCabin" name="customerOrderCabin"  style="display: block" placeholder="차대번호 마지막 5자리"  type="text"  value="" class="form-control"  autocomplete="off" autofocus required>
                                        
                                    
                                        
                                    
                                        </div>
                                   
                                    </div>
                                 
                                    </div>
                                    {{-- <div class="col-8 align-items-center mg-b-5" id="orderBank" style="display: none">
                                        <div class="row row-xs">
                                        <div class="col-lg-9 col-md-10 col-sm-10">
                                            <label class="form-label mg-b-0 required-input">은행 및 비은행 주문 여부:</label>
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-2" >
                                            <input id="isBank" name="isBank" onclick="banCheck()" style="display: block;width:20px" type="checkbox"  value="" class="form-control"  autocomplete="off" >
                                        </div>
                                   
                                    </div>
                                 
                                    </div> --}}
                             
                                      {{-- <table class="table table-bordered" id="vehicleTable" style="display: none; ">
                                        <tbody style="width:100%" id="vehicleTableBody"></tbody>
                                        
                                     
                                    </table> --}}
                                    <div id="vehicleTableBody"></div>
                             
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                             
                                    {{-- <table class="table table-bordered" id="customerTable" style="display: none">
                                        <tbody>
                                            <tr>
                                                <td>주문자 등록번호</td>
                                                <td> <input id="customerRegnum" name="customerRegnum"  style="display: block" placeholder="주문자 등록번호"  type="text"  value="" class="form-control"  autocomplete="off" autofocus required></td>
                                            </tr>
                                            <tr>
                                                <td>주문자 성씨</td>
                                                <td> <input id="customerLastname" name="customerLastname"  style="display: block" placeholder="주문자 성"  type="text"  value="" class="form-control"  autocomplete="off" autofocus required></td>
                                            </tr>
                                            <tr>
                                                <td>주문자 이름</td>
                                                <td>  <input id="customerFirstname" name="customerFirstname" style="display: block" placeholder="주문자 이름"  type="text"  value="" class="form-control"  autocomplete="off" autofocus required></td></tr>
                                                <tr>
                                                <td>주문자 전화</td>
                                                <td>      <input id="customerPhoneNumber" name="customerPhoneNumber" placeholder="주문자 전화" style="display: block"  type="text"  value="" class="form-control"  autocomplete="off" autofocus required></td>
                                            </tr>
                                        </tbody>
                                    </table> --}}
                                   
                                  
                               

                              
                                </div>
                        </div>
                        </div>
                    </div>
                </div>
                <!--왼쪽 영역 끝-->
                <div class="col-lg-3 col-md-6 col-sm-12">
                    @include('Includes.platesavemenu')
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
          $(document).ready(function(){
            var minLength = 5;
var maxLength = 5;
    $('#customerOrderCabin').on('keydown keyup change', function(){
        var char = $(this).val();
        var charLength = $(this).val().length;
        if(charLength < minLength){
            $('#warning-message').text('Length is short, minimum '+minLength+' required.');
        }else if(charLength > maxLength){
            $('#warning-message').text('Length is not valid, maximum '+maxLength+' allowed.');
            $(this).val(char.substring(0, maxLength));
        }else{
            $('#warning-message').text('');
        }
    });}); 
    function banCheck() {
        var minLength = 7;
var maxLength = 7;
        if($('#isBank').is(':checked')){
            $('#customerRegnum').attr('type', 'number');
            $("#customerTable").css("display", "block");
            $("#customerRegnum").prop("readonly", false);
          
             $("#customerLastname").val("");
             $("#customerFirstname").val("");
             $("#customerPhoneNumber").val("");
           
    $('#customerRegnum').on('keydown keyup change', function(){
        var char = $(this).val();
        var charLength = $(this).val().length;
        if(charLength < minLength){
            $('#warning-message').text('Length is short, minimum '+minLength+' required.');
        }else if(charLength > maxLength){
            $('#warning-message').text('Length is not valid, maximum '+maxLength+' allowed.');
            $(this).val(char.substring(0, maxLength));
        }else{
            $('#warning-message').text('');
        }
    });
                
    //console.log("checked");
    }else{
       // console.log("unchecked");

        $("#customerTable").css("display", "none");
        $('#customerRegnum').attr('type', 'text');
        auctionCheck();
        $("#customerRegnum").prop("readonly", true);
    
       
  
        
    
    }
    //I am checked
}
     //   $('#customerRegnum').attr('type', 'text');
    
      function auctionCheck(){
        
      //  $(".avtoteeverPreloader").fadeIn();
       try {
           var plate = $("#plateNo").val();
          // alert(plate);
           $.ajax({
               type: 'post',
               url: '/api/plateSaveVehicleOrder',
               dataType: "json",
               data: {
                   param1: plate,
                   param2: '{{ \App\Http\Controllers\BaseController::enc(\Carbon\Carbon::now()->format("Y-m-d")) }}'
               },
               timeout: 60000,
               error: function (data) {
               //    $(".avtoteeverPreloader").fadeOut();
                //   $(".containerBody").fadeIn();
               },
               success: function (data) {
                //  console.log(data);
                  $("#vehicleTable").css("display", "block");
                  $("#orderCabin").css("display", "block");
                  $("#orderBank").css("display", "block");
                  $("#customerRegnum").val(data['customer_regnum']);
                   $("#customerLastname").val(data['customer_lastname']);
                   $("#customerFirstname").val(data['customer_firstname']);
                   $("#customerPhoneNumber").val(data['customer_phone']);
                
                  $("#vehicleTableBody").html("");
                  
                  var html = 
                  '<table class="table table-bordered" id="vehicleTable"  ">'+
                  '<tr>'+'<td colspan="2" style="text-align: center;font-weight: bold;">'+"보관자 정보" +'</td>'+'</tr>'+
                  
                  '<tr >' +
                      ' <td > ' + '<strong> 성 </strong>'+ ' </td>' +
                     
                      ' <td >'+ '<input value="'+data['customer_lastname']+'" name="customerLastname" class="form-control"  autocomplete="off" autofocus required />' + ' </td>' +
                                      
                   ' </tr>'+
                   '<tr >' +
                     ' <td >' + '<strong> 이름</strong>'+ ' </td>' +
                     
                     ' <td >'+ '<input value="'+data['customer_firstname']+'" name="customerFirstname" class="form-control"  autocomplete="off" autofocus required/>' + ' </td>' +
                                 
                   ' </tr>'+
                   '<tr >' +
                     ' <td >' + '<strong> 등록번호 № </strong>'+ ' </td>' +
                     ' <td >'+ '<input value="'+data['customer_regnum']+'" name="customerRegnum" class="form-control" style="text-transform:uppercase" oninput="this.value = this.value.toUpperCase()" autocomplete="off" autofocus required/>' + ' </td>' +
                                   
                    ' </tr>'+
                   '<tr >' +
                     ' <td >' + '<strong> 전화번호 </strong>'+ ' </td>' +
                      ' <td >'  +data['customer_phone']+ ' </td>' +
                      
                                   
                    ' </tr>'+
                   '<tr >' +
                     ' <td >' + '<strong> 보관 기간 </strong>'+ ' </td>' +
                      ' <td >'  +data['begin_date'].substring(0,10) + " - " + data['end_date'].substring(0,10) +' </td>' +
                                   
                    ' </tr>'+
                  
                
                
                    '<tr>'+
                    '<td colspan="2" >'+ '<div style="margin: 0 auto;" class="col-6">'+
                           '<button type="submit"  class="btn btn-primary btn-block btnnopadding">번호 주문</button>'+
                           '</div>'+
                            ' </td>' +
                    ' </tr>' + '</table>';
                                  $("#vehicleTableBody").append(html);
               },
               error: function (jqXHR, textStatus, errorThrown) {
               //    $(".avtoteeverPreloader").fadeOut();
               //    $(".containerBody").fadeIn();
               }
           });
       }catch(err) {
           $(".avtoteeverPreloader").fadeOut();
           $(".containerBody").fadeIn();
       }

   }
    $(function(){
        'use strict'
        $( "#sdate" ).datepicker({
            changeMonth: true,
            changeYear: true
        });
        $( "#edate" ).datepicker({
            changeMonth: true,
            changeYear: true
        });

        $( "#sdate" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
        $( "#edate" ).datepicker( "option", "dateFormat", "yy-mm-dd" );

        $('#referenceTable').DataTable({
            responsive: true,
            language: {
                searchPlaceholder: '검색...',
                sSearch: '',
                lengthMenu: '_MENU_ 1/페이지에 표시',
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
