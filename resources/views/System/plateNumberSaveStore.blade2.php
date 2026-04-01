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
                              번호판 보관 서비스
                            </div>
                        </div>
                    </h6>
                    <div class="row row-sm">
                        <div class="col-12 col-sm-1 col-lg">
                            <form action="{{route('plateSaveStore')}}" method="POST">
                                {{ csrf_field() }}
                                <div class="row row-sm">
                                    <div class="col-4">
                                        <div class="row row-xs align-items-center mg-b-5">
                                            <div class="col-lg-4 col-md-12 col-sm-12">
                                                <label class="form-label mg-b-0 required-input">번호판</label>
                                            </div>
                                            <div class="col-lg-8 col-md-12 col-sm-12">
                                                <input id="plateNo" name="plateNo" required type="text" placeholder="번호판" value="" class="form-control" oninput="translate2MGL(this.value)" autocomplete="off" autofocus required>
                                                {{-- <input id="customerRegnum" name="customerRegnum" style="display: none"  type="text"  value="" class="form-control"  autocomplete="off" autofocus>
                                                <input id="customerLastname" name="customerLastname"  style="display: none"  type="text"  value="" class="form-control"  autocomplete="off" autofocus>
                                                <input id="customerFirstname" name="customerFirstname" style="display: none"  type="text"  value="" class="form-control"  autocomplete="off" autofocus>
                                                <input id="customerPhoneNumber" name="customerPhoneNumber" style="display: none"  type="text"  value="" class="form-control"  autocomplete="off" autofocus> --}}

                                          
                                        
                                            </div>
                                        </div>
                                    
                                    {{-- <div class="col-3"> --}}
                                        {{-- <div class="row row-xs align-items-center mg-b-5">
                                            <div class="col-lg-4 col-md-12 col-sm-12">
                                                <label class="form-label mg-b-0 required-input">차체번호</label>
                                            </div>
                                            <div class="col-lg-8 col-md-12 col-sm-12">
                                                <input id="cabin" name="cabin"  required type="number" placeholder="차체번호"  value="" class="form-control" autocomplete="off">
                                            </div>
                                        </div> --}}
                                        {{-- <div  class="row row-xs align-items-center mg-b-5">
                                            <div class="col-lg-4 col-md-4 col-sm-4">
                                                <label class="form-label mg-b-0 required-input">낙찰자 등록번호</label>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-8">
                                                <input id="register" name="register"  required type="text" placeholder="낙찰자 등록번호"  value="" class="form-control" autocomplete="off">
                                            </div>
                                        </div> --}}
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
                                                <button type="button"  onclick="auctionCheck();" class="btn btn-success btn-block btnnopadding">검색</button>
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
                                <div class="row">
                                <div style="    padding: 0;" class="col-lg-6 col-md-6 col-sm-12" id="ntrDetail">
                                    {{-- <h6 id="servicename" style=" text-align: center;color: #2f8605;"></h6> --}}
                               
                                    <table class="table table-bordered" id="plateSaveDate" style="display: none" >
                                      <tr>
                                        <td>   시작일
                                          
                                        </td>
                                        <td>   <input id="sdate" readonly name="startDate" type="text" class="form-control fc-datepicker" required>
                                          
                                        </td>
                                        <td>  종료 일자</td>
                                        <td>  <input id="edate" readonly name="endDate" type="text" class="form-control fc-datepicker" required></td>
                                      </tr>
                                    </table>
                                    <div id="errorMessage" style="display:none; color:red;text-align:center; margin-top:10px"></div>
                                      {{-- <tr>
                                        <td></td>
                                        <td>rr</td>
                                        <td>rrr</td>
                                        <td>rrrr</td>
                                        <td>rrrrr</td>
                                      </tr> --}}
                                      
                                      {{-- <table class="table table-bordered" id="ntrTable" style="display: none; ">
                                      <tbody style="width:100%" id="auctionTableBody"></tbody>                                   
                                    </table> --}}
                                    <div id="ntrTable">
                                    <div id="auctionTableBody"></div>
                                    </div>
                                      {{-- <table class="table table-bordered" id="vehicleTable" style="display: none; ">
                                        <tbody style="width:100%" id="vehicleTableBody"></tbody>
                                        
                                     
                                    </table> --}}
                                   
                                    <div id="vehicleTable">
                                    <div id="vehicleTableBody"></div>
                                </div>
                                 <div id="orderPlate"></div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    {{-- <input id="customerRegnum" name="customerRegnum" style="display: none"  type="text"  value="" class="form-control"  autocomplete="off" autofocus> --}}

                                    <table class="table table-bordered" id="customerTable" style="display: none">
                                        <tbody>
                                            <tr>
                                                <td>주문자 성</td>
                                                <td> <input id="customerLastname" name="customerLastname"  style="display: block" placeholder="주문자 성"  type="text"  value="" class="form-control"  autocomplete="off" autofocus required></td>
                                            </tr>
                                            <tr>
                                                <td>주문자 이름</td>
                                                <td>  <input id="customerFirstname" name="customerFirstname" style="display: block" placeholder="주문자 이름"  type="text"  value="" class="form-control"  autocomplete="off" autofocus required></td></tr>
                                            <tr>
                                                <td>주문자 등록번호</td>
                                                <td>   
                                                    
                                                    <input id="customerRegnum" name="customerRegnum" style="display: block" placeholder="주문자 등록번호"  type="text"  oninput="this.value = this.value.toUpperCase()" class="form-control"  required/>
                                                  <input id="customerRegnum1" name="customerRegnum1" style="display: none" disabled   placeholder="주문자 등록번호"  type="text"  class="form-control"  required/>
                                                </td></tr>
                                                <tr>
                                                <td>주문자 전화</td>
                                                <td>      <input id="customerPhoneNumber" name="customerPhoneNumber" placeholder="주문자 전화" style="display: block"  type="text"  value="" class="form-control"  autocomplete="off" autofocus required></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                   
                                  
                               

                              
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
    
      function auctionCheck(){
        
      //  $(".avtoteeverPreloader").fadeIn();
       try {
           var plate = $("#plateNo").val();
          // alert(plate);
           $.ajax({
               type: 'post',
               url: '/api/plateSaveVehicleSearch',
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
                 // console.log(data);
                 var usePos='{{ \session()->get("auth")->position }}';
              
                  if (data['status']==400) {
                    alert(data['message']);
                  }
                    if (typeof data['is_auction'] ==='undefined') {
                   
                        $("#vehicleTable").css("display", "none");
                        $("#orderPlate").css("display", "none");
                        $("#customerTable").css("display", "none");


                  if (data['data'].is_paid == 1) {

                   $("#registerOwn").css("display", "block");
                   $("#customerRegnum").val(data['data']['winner_info'].regnum);
                   $("#customerLastname").val(data['data']['winner_info'].lastname);
                   $("#customerFirstname").val(data['data']['winner_info'].firstname);
                   $("#customerPhoneNumber").val(data['data']['winner_info'].phone_number);
           
                   $("#ntrTable").css("display", "block");
                   $("#plateSaveDate").css("display", "block");
                 //  document.getElementById("register").value =data['data']['winner_info'].regnum;
                 if (data['data']['winner_info'].phone_number == "" || data['data']['winner_info'].phone_number == null) {
                    $("#customerTable").css("display", "block");
                 }
                   
                 $("#errorMessage").css("display", "none");
                    $("#auctionTableBody").html("");
                  
                   var html = '<table class="table table-bordered" id="ntrTable ">'+
                   '<tr>'+'<td colspan="4" style="text-align: center;font-weight: bold;">'+"경매 낙찰자 정보" +'</td>'+'</tr>'+
                   
                   '<tr >' +
                       ' <td colspan="2"> ' + '<strong> 성 </strong>'+ ' </td>' +
                       ' <td colspan="3"> '  +data['data']['winner_info'].lastname + ' </td>' +
                                       
                    ' </tr>'+
                    '<tr >' +
                      ' <td colspan="2">' + '<strong> 이름</strong>'+ ' </td>' +
                      ' <td colspan="2">'  + data['data']['winner_info'].firstname + ' </td>' +
                                  
                    ' </tr>'+
                    '<tr >' +
                      ' <td colspan="2">' + '<strong> 등록번호 № </strong>'+ ' </td>' +
                       ' <td colspan="2">'  +data['data']['winner_info'].regnum+ ' </td>' +
                                    
                     ' </tr>'+
                    '<tr >' +
                      ' <td colspan="2">' + '<strong> 전화번호 </strong>'+ ' </td>' +
                       ' <td colspan="2">'  +data['data']['winner_info'].phone_number+ ' </td>' +
                                    
                     ' </tr>'+
                     '<tr >' +
                       ' <td colspan="2">' + '<strong>결제 </strong>' + ' </td>' +
                        ' <td style="color:green;" colspan="2">'  +"결제 완료"+ ' </td>' +
                     ' </tr>'+
                 
                 
                     '<tr>'+
                     '<td colspan="4" >'+ '<div style="margin: 0 auto;" class="col-6">'+
                            '<button type="submit"  class="btn btn-primary btn-block btnnopadding">번호 저장</button>'+
                            '</div>'+
                             ' </td>' +
                     ' </tr>' + '</table>';
                                   $("#auctionTableBody").append(html);
                                //   $(".avtoteeverPreloader").fadeOut();
                }else{
                    const msg =data['status'].message;
                   $("#auctionTableBody").html("");
                  
                  var html = 
                  '<tr>'+'<td style="color:red;" colspan="2" style="text-align: center;font-weight: bold;">'+msg +'</td>'+
                  ' </tr>';
                                   $("#auctionTableBody").append(html);
                              //     $(".avtoteeverPreloader").fadeOut();

                }
            } else {
               // console.log(data['register_no']);
     //console.log(data['last_name'] );
            //console.log(data);
                $("#ntrTable").css("display", "none");
             
                $("#plateSaveDate").css("display", "block");
                $("#registerOwn").css("display", "block");
                 
                   $("#customerLastname").val(data['last_name']);
                   $("#customerFirstname").val(data['first_name']);
                   $("#customerPhoneNumber").val(data['phone_no']);
                
          if (typeof data['order_cabin'] ==='undefined' && typeof data['order_date'] ==='undefined') {
          $("#orderPlate").css("display", "none");
  
                   $("#vehicleTable").css("display", "block");
                   if ( data['last_name'] == null || data['last_name'] == "" ) {
                $("#customerTable").css("display", "block"); 
                usePos =="수석 등록 전문가" || usePos =="수석 등록 전문가, дуудлага худалдаа хариуцсан"  ? $("#customerRegnum").prop("readonly", false) :   $("#customerRegnum").prop("readonly", false);
                $("#customerRegnum").val(data['register_no'].substring(0,7));
               }else{
                $("#customerRegnum").val(data['register_no']);
                $("#customerTable").css("display", "block");
               }
               $("#errorMessage").css("display", "none");
                    $("#vehicleTableBody").html("");
                  
                   var html = '<table class="table table-bordered" id="vehicleTable">'+
                   '<tr>'+'<td colspan="2" style="text-align: center;font-weight: bold;">'+"소유자 정보" +'</td>'+'</tr>'+
                   
                   '<tr >' +
                       ' <td > ' + '<strong> 성 </strong>'+ ' </td>' +
                       ' <td > '  +data['last_name']+ ' </td>' +
                                       
                    ' </tr>'+
                    '<tr >' +
                      ' <td >' + '<strong> 이름</strong>'+ ' </td>' +
                      ' <td >'  + data['first_name'] + ' </td>' +
                                  
                    ' </tr>'+
                    '<tr >' +
                      ' <td >' + '<strong> 등록번호 № </strong>'+ ' </td>' +
                       ' <td >'  +data['register_no']+ ' </td>' +
                                    
                     ' </tr>'+
                    '<tr >' +
                      ' <td >' + '<strong> 전화번호 </strong>'+ ' </td>' +
                       ' <td >'  +data['phone_no']+ ' </td>' +
                                    
                     ' </tr>'+
                   
                 
                 
                     '<tr>'+
                     '<td colspan="2" >'+ '<div style="margin: 0 auto;" class="col-6">'+
                            '<button type="submit"  class="btn btn-primary btn-block btnnopadding">번호 저장</button>'+
                            '</div>'+
                             ' </td>' +
                     ' </tr>'+'</table>';
                                   $("#vehicleTableBody").append(html);

                 }else{
                     $("#plateSaveDate").css("display", "none");
                     $("#errorMessage").css("display", "block");
                     $("#errorMessage").text("번호판 주문 창에서 주문한 번호판은 보관할 수 없습니다 !!!");
                    // $("#plateSaveDate").css("display", "block");
                    // $("#orderPlate").css("display", "block");
                    // $("#customerTable").css("display", "block");
                     $("#vehicleTable").css("display", "none");
                     $("#customerRegnum").css("display", "none");
                    // $("#customerRegnum1").css("display", "block");
                       $("#ntrTable").css("display", "none");
                    //   $("#customerRegnum").val(data['register_no']);
                    //   $("#customerRegnum1").val(data['register_no']);
                    // $("#orderPlate").html("");
                    // var html = '<table class="table table-bordered" >'+
                    //     '<tr>'+'<td colspan="2" style="text-align: center;font-weight: bold;">'+"Захиалсан 번호ын мэдээлэл"+'</td>'+'</tr>'+
                    //     '<tr >' +
                    //   ' <td >' + '<strong> 예약된 등록번호 </strong>'+ ' </td>' +
                    //    ' <td >'  +data['register_no']+ ' </td>' +
                                    
                    //  ' </tr>'+
                    //     '<tr >' +
                    //   ' <td >' + '<strong> 예약된 차대번호 </strong>'+ ' </td>' +
                    //    ' <td >'  +data['order_cabin']+ ' </td>' +
                                    
                    //  ' </tr>'+
                    //  ' </tr>'+
                    //     '<tr >' +
                    //   ' <td >' + '<strong> 주문 일자 </strong>'+ ' </td>' +
                    //    ' <td >'  +data['order_date']+ ' </td>' +
                                    
                    //  ' </tr>'+
                       
                    //  '<tr>'+
                    //  '<td colspan="2" >'+ '<div style="margin: 0 auto;" class="col-6">'+
                    //         '<button type="submit"  class="btn btn-primary btn-block btnnopadding">번호 저장</button>'+
                    //         '</div>'+
                    //          ' </td>' +
                    //  ' </tr>';
                    //     +'</table>';
                    // $("#orderPlate").append(html);

                     }     
                    }

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
            changeYear: true,
            minDate: 0,
             maxDate: "+0M +0D"
          
        });
        $( "#edate" ).datepicker({
            changeMonth: true,
            changeYear: true,
              minDate: 0, maxDate: "+1Y +1D"
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
