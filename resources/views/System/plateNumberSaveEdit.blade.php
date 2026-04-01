<!DOCTYPE html>
<html lang="en">
<head>
    @include('Includes.head')
    <style>
        .checkbox {
            margin-top: 8px;
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
                <div class="col-lg-9 col-md-12 col-sm-12">
                    @if(ISSET($message) || session()->has("message"))
                        @include("System.message")
                    @endif
                    <h6 class="card-title">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                보관 번호 연장
                            </div>
                        </div>
                    </h6>
                   <form action="{{ route("plateSaveUpdate") }}" method="POST">
                        {{ csrf_field() }}
                            <div class="row row-sm">
                                    <div class="col-4">
                                        <div class="row row-xs align-items-center mg-b-5">
                                            <div class="col-lg-4 col-md-12 col-sm-12">
                                                <label class="form-label mg-b-0 required-input">차량 번호</label>
                                            </div>
                                            <div class="col-lg-8 col-md-12 col-sm-12">
                                                <input id="plateNo" name="plateNo" required type="text" placeholder="차량 번호" value="" class="form-control" oninput="translate2MGL(this.value)" autocomplete="off" autofocus required>
                                            
                                        
                                            </div>
                                        </div>
                                     
                                  
                                        </div>
                                   
                                  
                                    <div class="col-3">
                                        <div class="row row-xs align-items-center mg-b-5">
                                            <div class="col-lg-4 col-md-12 col-sm-12">
                                                <button type="button"  onclick="plateCheck();" class="btn btn-success btn-block btnnopadding">검색</button>
                                            </div>
                                           
                                    
                                        </div>
                                    </div>
                                   
                             
                                </div>
                         
                           
                                        <table class="table table-bordered" id="customerTable" style="display: block">
                                            <tbody>
                                              
                                                    <td>시작 기간</td>
                                                    <td>     <input id="sdate" readonly name="startDate" type="text" class="form-control fc-datepicker" required></td>
                                                  
                                                    <td>만료 기간</td>
                                                    <td>    <input id="edate" readonly name="endDate" type="text" class="form-control fc-datepicker" required></td>
                                                </tr>
                                                <tr>
                                                  
                                                        
                                              
                                                  
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="col-6" id="vehicleTableBody"></div>
                                      
                                     
                                     
                                    
    
                                  
                   </form>
                       {{--   <div class="row">
                            <!--Зүүн талын хэсэг   \App\Http\Controllers\BaseController::enc($curr_saved_data->id) : "" эхлэл-->
                            <input type="text" name="id" style="display: none; width:70%" value="{{ isset($curr_saved_data) ? \App\Http\Controllers\BaseController::enc($curr_saved_data->id) : "" }}">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="row row-xs align-items-center mg-b-5">
                                  
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0 required-input">번호판</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <input type="text" name="plateNo" style="display: block; width:70%" value="{{ isset($curr_saved_data) ? $curr_saved_data->plate_no : "" }}" readonly/>

                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0 required-input">성씨</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <input type="text" name="customerLastname" style="display: block; width:70%" value="{{ isset($curr_saved_data) ? $curr_saved_data->customer_lastname : "" }}" readonly/>

                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0 required-input">이름</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <input type="text" name="customerFirstname" style="display: block; width:70%" value="{{ isset($curr_saved_data) ? $curr_saved_data->customer_firstname : "" }}" readonly/>

                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0 required-input">등록번호</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <input type="text" name="customerRegnum" style="display: block; width:70%" value="{{ isset($curr_saved_data) ? $curr_saved_data->customer_regnum : "" }}"readonly/>

                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0 required-input">전화</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <input type="text" name="customerPhoneNumber" style="display: block; width:70%" value="{{ isset($curr_saved_data) ? $curr_saved_data->customer_phone : "" }}"readonly/>

                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0 required-input">시작</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <input type="text" id="sdat3e" name="startDate" style="display: block; width:70%" value="{{ isset($curr_saved_data) ? date('Y-m-d', strtotime($curr_saved_data->begin_date))  : "" }}">

                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0 required-input">만료</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <input type="text" id="edat3e" name="endDate" style="display: block; width:70%" value="{{ isset($curr_saved_data) ? date('Y-m-d', strtotime($curr_saved_data->end_date))  : "" }}">

                                    </div>
                                </div>
                            
                              
                        
                            </div>
                        </div>
                        <hr class="mg-y-10">
                        <div class="row">
                            <div class="col-lg-3 col-md-6 col-sm-6"></div>
                            <div class="col-lg-2 col-md-6 col-sm-6">
                                <button type="submit" class="btn btn-primary btn-block"> 수정 </button>
                            </div>
                        </div>
                    </form> --}}
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
<script>
      function translate2MGL(word){
        if(word){
            word = word.toUpperCase();
        }
        word =  word.split('').map(function (char) {
            return Lat2Cyr[char] || char;
        }).join("");
        $("#plateNo").val(word);
    } 
       function plateCheck(){
        
        //  $(".avtoteeverPreloader").fadeIn();
         try {
             var plate = $("#plateNo").val();
            // alert(plate);
             $.ajax({
                 type: 'post',
                 url: '/api/plateEditCheck',
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
                    $("#vehicleTable").css("display", "block");
                    $("#orderCabin").css("display", "block");
                    $("#customerRegnum").val(data['customer_regnum']);
                     $("#customerLastname").val(data['customer_lastname']);
                     $("#customerFirstname").val(data['customer_firstname']);
                     $("#customerPhoneNumber").val(data['customer_phone']);
                     $("#sdate").val(data['begin_date'].substring(0,10));
                     $("#edate").val(data['end_date'].substring(0,10));
                    $("#vehicleTableBody").html("");
                    if ( data["extend_count"] == 1) {
                        
                   
                    var html = 
                    '<table class="table table-bordered" id="vehicleTable"  ">'+
                    '<tr>'+'<td colspan="2" style="text-align: center;font-weight: bold;">'+"보관자 정보" +'</td>'+'</tr>'+
                    
                    '<tr >' +
                        ' <td > ' + '<strong> 성씨 </strong>'+ ' </td>' +
                        ' <td > '  +data['customer_lastname']+ ' </td>' +
                                        
                     ' </tr>'+
                     '<tr >' +
                       ' <td >' + '<strong> 이름</strong>'+ ' </td>' +
                       ' <td >'  + data['customer_firstname'] + ' </td>' +
                                   
                     ' </tr>'+
                     '<tr >' +
                       ' <td >' + '<strong> 등록번호 № </strong>'+ ' </td>' +
                        ' <td >'  +data['customer_regnum']+ ' </td>' +
                                     
                      ' </tr>'+
                     '<tr >' +
                       ' <td >' + '<strong> 전화번호 </strong>'+ ' </td>' +
                        ' <td >'  +data['customer_phone']+ ' </td>' +
                                     
                      ' </tr>'+
                     '<tr >' +
                       ' <td >' + '<strong> 연장 권한 </strong>'+ ' </td>' +
                        ' <td >'+ data["extend_count"]+
                        ' </td>' +
                                     
                      ' </tr>'+
                     '<tr >' +
                       ' <td >' + '<strong> 보관 기간 </strong>'+ ' </td>' +
                        ' <td >'  +data['begin_date'].substring(0,10) + " - " + data['end_date'].substring(0,10) +' </td>' +
                                     
                      ' </tr>'+
                    
                  
                  
                      '<tr>'+
                      '<td colspan="2" >'+ '<div style="margin: 0 auto;" class="col-6">'+
                             `<button  type="submit"  class="btn btn-primary btn-block btnnopadding">저장</button>`+
                             '</div>'+
                              ' </td>' +
                      ' </tr>' + '</table>';
                    } else {
                        
                    
                    var html = 
                    '<table class="table table-bordered" id="vehicleTable"  ">'+
                    '<tr>'+'<td colspan="2" style="text-align: center;font-weight: bold;">'+"보관자 정보" +'</td>'+'</tr>'+
                    
                    '<tr >' +
                        ' <td > ' + '<strong> 성씨 </strong>'+ ' </td>' +
                        ' <td > '  +data['customer_lastname']+ ' </td>' +
                                        
                     ' </tr>'+
                     '<tr >' +
                       ' <td >' + '<strong> 이름</strong>'+ ' </td>' +
                       ' <td >'  + data['customer_firstname'] + ' </td>' +
                                   
                     ' </tr>'+
                     '<tr >' +
                       ' <td >' + '<strong> 등록번호 № </strong>'+ ' </td>' +
                        ' <td >'  +data['customer_regnum']+ ' </td>' +
                                     
                      ' </tr>'+
                     '<tr >' +
                       ' <td >' + '<strong> 전화번호 </strong>'+ ' </td>' +
                        ' <td >'  +data['customer_phone']+ ' </td>' +
                                     
                      ' </tr>'+
                     '<tr >' +
                       ' <td >' + '<strong> 연장 권한 </strong>'+ ' </td>' +
                        ' <td >'+ '<strong style="font-weight: bold; color:red"> 연장 권한 만료 </strong>'+
                        ' </td>' +
                                     
                      ' </tr>'+
                     '<tr >' +
                       ' <td >' + '<strong> 보관 기간 </strong>'+ ' </td>' +
                        ' <td >'  +data['begin_date'].substring(0,10) + " - " + data['end_date'].substring(0,10) +' </td>' +
                                     
                      ' </tr>'+
                    
                  
                  
                      '<tr>'+
                      '<td colspan="2" >'+ '<div style="margin: 0 auto;" class="col-6">'+
                             `<button  type="submit"  disabled class="btn btn-primary btn-block btnnopadding">저장</button>`+
                             '</div>'+
                              ' </td>' +
                      ' </tr>' + '</table>';
                    }
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
    $(function(){
        'use strict'
        $( "#sdate" ).datepicker({
            changeMonth: true,
            changeYear: true,
            minDate: "+0M +0D",
             maxDate: "+0M+3D"
         //   minDate: -20, maxDate: "+1M +10D"
        });
        $( "#edate" ).datepicker({
            changeMonth: true,
            changeYear: true,
            minDate: "+0M +0D",
             maxDate: "+3M +3D"
           // minDate: -20, maxDate: "+1M +10D"
        });

        $( "#sdate" ).datepicker( "option", "dateFormat", "yy-mm-dd");
        $( "#edate" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
        $( "#restrictDate" ).datepicker({
            changeMonth: true,
            changeYear: true
        });

        $('.select2').select2({
            placeholder: '선택하세요'
        });

        $('#type').keyup(function(){
            this.value = this.value.toUpperCase();
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
