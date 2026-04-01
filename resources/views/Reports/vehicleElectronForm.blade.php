<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/logo.png') }}">
 
  
    
    {{--  <link href="{{ asset('css/vrs.css') }}" rel="stylesheet"> 
    <link href="{{ asset('css/avtoteever.css') }}" rel="stylesheet">  --}} 

    <style>
        @page {
            margin: 0cm 0cm;
            font-size: 11px;
        }

        /* header{
        position: fixed;
        top:0cm;
        left:0cm;
        right:0cm;
       
        height:1cm;
        text-align:center;
    }*/
        footer {
            position: relative;
            bottom: 0cm;
            left: 0cm;
            right: 2cm;
            
           
        }
      
        .upn {

            background-image: url('/img/soyombo_bg.png');
            background-repeat: no-repeat;
            width: 100%;
            height: 100vh;
            background-size: cover;
        }

        body {

            font-size: 13px;

            /* background: url({{asset('/img/soyombo_bg.png')}}); 
             background-repeat: no-repeat; background-position: center; */
            font-family: "arial", DejaVu Sans;
            margin: 25px 2cm 1cm;
        

        }

        table tbody tr td {
            padding-left: 5px;
            color: #252424;

        }
table{
    border-collapse: collapse;
}
        .table1 {
            width: 100%;
           
            border: 1px solid #000;
        }

        table td {
            height: 30px;
            
        }
        .ckbox
        {
            margin-bottom: 3px !important;
            line-height: unset !important;
        }
    </style>
</head>

<body>




   {{--  {{ $historie1['historie1']->id}}  --}}


 


    <div id="printer">
        <div class="row">
           


            {{-- <div class="col-12" style="margin-top:0px;">
              
                <center>
                    <table class=" " style=" width: 100%;    margin: 0; text-align: center;" border=0>

                        <tbody>
                            <tr>
                                <td>
                                    <img src="{{asset('img/logo.png')}}" alt="" style="width:120px;  margin-left:50px; margin-bottom:15px;  padding-right: 28px;padding-left: 122px; padding-top: 15px;">
                                </td>
                                <td style="width: 30%; text-align: end;">   Зам, тээврийн хөгжлийн сайдын 
                                    ..... оны  ... 번호 тушаалаар батлагдсан
                                    "자동차운송 хэрэгслийн бүртгэл хөтлөх,
                                     번호판 олгох журам"-ын нэгдүгээр хавсралт
                                   </td>
                            </tr>
                        </tbody>
                    </table>
                </center>

</div> --}}
</div>

        <div class="row">



            <div class="col-12" style="margin-top:0px;">
              
                <center>
                <table class="" style=" width: 100%;     text-align: center;" border=0>

                    <tbody>
                        <tr> 
                            <td>

                                <p style="font-weight: bold;float:left; font-size: 11px; ">
                                    огноо:{{ $vehicle ? $vehicle->updated_date : '' }}
                                </p>
                            </td>
                            <td style="padding-top:5px;  font-weight: bold;    font-size: 15px" >
                             <strong style=" ">  БҮРТГЭЛИЙН МЭДҮҮЛЭГ</strong>
                            </td>
                            <td style="width: 35%;">
                                <p style="font-weight: bold; float:right;font-size: 11px; ">아카이브:{{ $vehicle ? $vehicle->archive_no : '' }}
                                </p>
                            </td>
                    </tbody>

                </table>
            </center>
            </div>
        </div>




        <div class="row">
            <div class="col-12" style="margin-top:0px;   margin:8px 1px; position:relative;">
                <center>


                    <table class="table1" style=" width: 100%;  " border=1>
                        <tbody>
                            <tr>
                                <td style=" text-align: center;"><strong>서비스 유형</strong> </td>
                                <td style="    text-align: center;">신규эр бүртгүүлэх
                                    <div style=" width: 0;       margin: 2px 27px;">

                                        <input type="checkbox" name=""
                                            {{  $vehicle->status == 1 ? 'checked' : '' }} disabled>
                                    </div>
                                </td>
                                <td style="    text-align: center;">이전 хөдөлгөөн

                                    <div style=" width: 0;       margin: 2px 26px;">
                                        <input type="checkbox" name=""
                                            {{    $vehicle->status == 3 || $vehicle->status == 14  ? 'checked'  : ''  }} disabled>
                                    </div>
                                </td>
                                <td style="    text-align: center;">차량Г нөхөлт, солилт
                                    <div style=" width: 0;       margin: 2px 61px;">
                                        <input type="checkbox" name=""
                                            {{   $vehicle->status || $vehicle->status == 13 ? 'checked' : ''  }}
                                            disabled>
                                    </div>
                                </td>
                                <td style="    text-align: center;     width: 135px;">Дугаар өөрчлөх, хадгалах
                                    <div style=" width: 0;       margin: 2px 46px;">
                                        <input type="checkbox" name=""
                                            {{   $vehicle->status == 15 ? 'checked' : '' }} disabled>
                                    </div>
                                </td>
                                <td style="    text-align: center;">Бүртгэлээс хасах
                                    <div style=" width: 0;       margin: 2px 26px;">
                                        <input type="checkbox" name=""
                                            {{   $vehicle->status == 9 ? 'checked' : '' }} disabled>
                                    </div>
                                </td>


                            </tr>

                        </tbody>
                    </table>
                </center>
            </div>

        </div>


        <div class="row">

            <div class="col-12" style="margin-top:0px;">
                <center>
                    <table class="table1" style=" width: 100%;  " border=1>
                        <tr>
                            <td><strong>증명서 №</strong></td>
                            <td>{{ $vehicle ? $vehicle->certificate_no : '' }}</td>
                            <td><strong>용도</strong></td>
                            <td>{{ $vehicle ? $vehicle->purpose_name : '' }}</td>
                        </tr>
                        <tr>
                            <td style=" "><strong>번호판</strong></td>
                            <td>{{ $vehicle ? $vehicle->plate_no : '' }}</td>
                            <td><strong>제조 연도</strong></td>
                            <td>{{ $vehicle ? $vehicle->build_year : '' }}</td>
                        </tr>
                        <tr>
                            <td><strong>브랜드</strong></td>
                            <td>{{ $vehicle ? $vehicle->mark_name : '' }}</td>
                            <td><strong>섬 №</strong></td>
                            <td>{{ $vehicle ? $vehicle->cabin_no : '' }}</td>
                        </tr>
                        <tr>
                            <td><strong>형식</strong></td>
                            <td>{{ $vehicle ? $vehicle->model_name : '' }}</td>
                            <td><strong>엔진 배기량 V(c.c)</strong></td>
                            <td>{{ $vehicle ? $vehicle->engine_capacity : '' }}</td>
                        </tr>
                        <tr>
                            <td><strong>유형</strong></td>
                            <td>{{ $vehicle ? $vehicle->vehicle_type_name : '' }}</td>
                            <td><strong>색상</strong></td>
                            <td>{{ $vehicle ? $vehicle->color_name : '' }}</td>
                        </tr>
                        <tr>
                            <td><strong>등급</strong></td>
                            <td>{{ $vehicle ? $vehicle->class_name : '' }}</td>
                            <td style="    "><strong>엔진 <br>연료원</strong></td>
                            <td style="width:35%; ">
                                <div class="row" style=" margin-left: 0px;  margin-right: 0px; ">
                                    @if ($vehicle)
                                        <center>
                                            <table style="margin-top:-10;">
                                                <tbody>
                                                    <tr>
                                                        <td style=""><span style="font-size: 8px;">휘발유</span> <input
                                                                style="margin-top:8px; margin-left:4px; "
                                                                type="checkbox" name=""
                                                                {{ $vehicle->fuel_type_id == 48 ? 'checked' : '' }}
                                                                disabled>
                                                        </td>
                                                        <td style="">
                                                        </td>
                                                        <td style=""><span style="font-size: 8px;">디젤</span> <input
                                                                style="margin-top:8px; margin-left:4px; "
                                                                type="checkbox" name=""
                                                                {{ $vehicle->fuel_type_id == 17 || $vehicle->fuel_type_id == 18 ? 'checked' : '' }}
                                                                disabled>
                                                        </td>
                                                        <td style="">
                                                        </td>
                                                        <td style=""><span style="font-size: 8px;">가스 연료</span>
                                                            <input style="margin-top:8px; margin-left:4px; "
                                                                type="checkbox" name=""
                                                                {{ $vehicle->fuel_type_id == 22 ? 'checked' : '' }}
                                                                disabled>
                                                        </td>
                                                        <td style="">
                                                        </td>
                                                        <td style=""><span style="font-size: 8px;">기타</span> <input
                                                                style="margin-top:8px; margin-left:4px; "
                                                                type="checkbox" name=""
                                                                {{ $vehicle->fuel_type_id == '' ? 'checked' : '' }}
                                                                disabled>
                                                        </td>
                                                        <td style="">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </center>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>세관 모드</strong></td>
                            <td>
                                <canvas id="dclrTypeCd"></canvas>
                            </td>
                            <td><strong>R 번호</strong></td>
                            <td>{{ $vehicle->declaration_no }}</td>
                        </tr>

                    </table>
                </center>
            </div>

        </div>


        <div class="row">


            <div class="col-12" style="margin-top:0px;">
              
                    <table style=" width: 100%;">
                        <tbody>
                            <tr>
                                <td style="font-size:13px;">
                                    <p style="font-weight: bold;  text-align:left;">ШИЛЖҮҮЛСЭН (Иргэн, 기관,
                                        ААН)</p>
                                </td>
                                @if (isset($finger['ntrBookdate']))
                                <td style="font-size:13px;">
                                    <p style="font-weight: bold;  text-align:right;    text-transform: uppercase;">Нотриатын гэрээгээр (Иргэн, 기관,
                                        ААН)</p>
                                </td>
                                @endif 
                            </tr>
                        </tbody>
                    </table> 
                    <table class="table1 " style=" width: 100%;" border=1>
                        <tbody>
                            @if (!empty($owners[1]))
                                @if ($owners[1]->ship_id > 1)
                                    <tr>
                                        <td style=" width: 25%; "><strong>본관성</strong></td>
                                        <td colspan="2">{{ $owners[1]
                                                ? $owners[1]->family_name
                                                : '' }}</td>
                                                  @if (isset($finger['ntrBookdate']))
                                                <td><strong>계약 번호</strong></td>
                                             
                                               <td>{{ $finger['ntrBooknumber']}}</td>
                                               @endif 
                                    </tr>
                                    <tr>
                                        <td><strong>부모 이름</strong> <br /><span
                                                style="font-size: 8px;">/기관, ААН-ийн төрөл/</span></td>
                                        <td colspan="2">{{ $owners[1]
                                                ? $owners[1]->last_name
                                                : '' }}</td>
                                                  @if (isset($finger['ntrBookdate']))
                                                 <td><strong>부모 이름</strong></td>
                                                 <td>{{$finger['ntrLastname']}}</td>
                                                 @endif
                                    </tr>
                                    <tr>
                                        <td><strong>이름</strong> <br /><span style="font-size: 8px;">/기관,
                                                ААН-ийн нэр/</span></td>
                                        <td colspan="2">{{ $owners[1]
                                                ? $owners[1]->first_name
                                                : '' }}</td>
                                                  @if (isset($finger['ntrBookdate']))
                                                 <td><strong><strong>이름</strong> <br /><span style="font-size: 8px;">/기관,
                                                    ААН-ийн нэр/</span></strong></td>
                                                 <td>{{$finger['ntrFirstname']}}</td>
                                                 @endif
                                    </tr>
                                    <tr>
                                        <td><strong>등록번호</strong></td>
                                        <td colspan="2">{{ $owners[1]
                                                ? $owners[1]->register_no
                                                : '' }}</td>
                                                  @if (isset($finger['ntrBookdate']))
                                                 <td><strong>등록번호</strong></td>
                                                 <td>{{$finger['ntrStateregnumber']}}</td>
                                                 @endif
                                    </tr>
                                    <tr>
                                        <td><strong>주소</strong> <br /><span style="font-size: 8px;">/세금 төлдөг
                                                хаяг/</span></td>
                                        <td colspan="2">{{ $owners[1]
                                                ? $owners[1]->address_detail
                                                : '' }}</td>
                                                  @if (isset($finger['ntrBookdate']))
                                                 <td><strong><strong>주소</strong> <br /><span style="font-size: 8px;">/세금 төлдөг
                                                    хаяг/</span></strong></td>
                                                 <td>{{$finger['ntrAddress']}}</td>
                                                 @endif
                                    </tr>
                                    <tr>
                                        <td style=" "><strong>전화</strong></td>
                                        <td colspan="2">
                                            <table>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            {{ $owners[1]
                                                        ? $owners[1]->cellphone
                                                        : '' }},
                                                            {{ $owners[1]
                                                         ? $owners[1]->workphone
                                                         : '' }},
                                                            {{ $owners[1]
                                                        ? $owners[1]->homephone
                                                        : '' }}


                                                        </td>
                                                     
                                                    </tr>
                                                </tbody>
                                            </table>

                                        </td>
                                        @if (isset($finger['ntrBookdate']))
                                        <td><strong>전화</strong></td>
                                        <td>{{$finger['ntrPhone']}}</td>
                                        @endif

                                    </tr>

                                @endif
                            @endif
                        </tbody>
                    </table>
                 
           
             
            </div>
        </div>

        <div class="row">

            <div class="col-12" style="margin-top:0px;">
                <center>
                    <table style=" width: 100%;">
                        <tbody>
                            <tr>
                                <td style="font-size:13px;">
                                    <p style="font-weight: bold;  text-align:center;">ШИЛЖҮҮЛЭН АВСАН (Иргэн,
                                        기관, ААН)</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table1" style=" width: 100%;" border=1>
                        <tbody>
                            <tr>
                                <td style=" width: 25%; "><strong>본관성</strong></td>
                                <td colspan="4">{{ $owners[0]
                                        ? $owners[0]->family_name
                                        : '' }}</td>
                            </tr>
                            <tr>
                                <td><strong>부모 이름</strong> <br /><span style="font-size: 8px;">/기관,
                                        ААН-ийн төрөл/</span></td>
                                <td colspan="4">{{ $owners[0]
                                        ? $owners[0]->last_name
                                        : '' }}</td>
                            </tr>
                            <tr>
                                <td><strong>이름</strong> <br /><span style="font-size: 8px;">/기관, ААН-ийн
                                        нэр/</span></td>
                                <td colspan="4">{{ $owners[0]
                                        ? $owners[0]->first_name
                                        : '' }}</td>
                            </tr>
                            <tr>
                                <td><strong>등록번호</strong></td>
                                <td colspan="4">{{ $owners[0]
                                        ? $owners[0]->register_no
                                        : '' }}</td>
                            </tr>
                            <tr>
                                <td><strong>주소</strong> <br /><span style="font-size: 8px;">/세금 төлдөг
                                        хаяг/</span></td>
                                <td colspan="4">{{ $owners[0]
                                        ? $owners[0]->address_detail
                                        : '' }}</td>
                            </tr>
                            <tr>
                                <td style=" "><strong>전화</strong></td>
                                <td colspan="4">
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td> {{ $owners[0]
                                            ? $owners[0]->cellphone
                                            : '' }},
                                                    {{ $owners[0]
                                                ? $owners[0]->workphone
                                                : '' }},
                                                    {{ $owners[0]
                                            ? $owners[0]->homephone
                                            : '' }},

                                                </td>

                                            </tr>
                                        </tbody>
                                    </table>

                                </td>

                            </tr>

                            <tr>

                                <td >
  
                                      <table>
                                          <tbody>
                                              <tr>
                                                  <td>     <input type="checkbox" style="" name=""
                                                    {{ $finger['finger'] == 2 || $finger['finger'] == 0 ? 'checked' : '' }}
                                                    disabled> </td>
                                                  <td style="    padding-left: 15px;"> <p style=""> Иргэний үнэмлэхээр баталгаажсан</p></td>
                                              </tr>
                                          </tbody>
                                      </table>
                                           
                                      
                                </td>

                                <td >
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td>    <label class="ckbox"> <input type="checkbox" style="" name=""{{ $finger['finger'] == 1 ? 'checked' : '' }} disabled></label> </td>
                                                <td style="    padding-left: 15px;"> <p style=""> 지문으로 баталгаажсан</p></td>
                                            </tr>
                                        </tbody>
                                    </table>

                                       

                                       
          
                                   
                                  </td>
                                <td >
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td>    <label class="ckbox"> <input type="checkbox" style="" name=""{{ $finger['finger'] == 3 ? 'checked' : '' }} disabled></label> </td>
                                                <td style="    padding-left: 15px;"> <p style=""> Нотриатын гэрээгээр баталгаажсан</p></td>
                                            </tr>
                                        </tbody>
                                    </table>

                                       

                                       
          
                                   
                                  </td>
                                <td >
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td>    <label class="ckbox"> <input type="checkbox" style="" name=""{{ $finger['finger'] == 4 ? 'checked' : '' }} disabled></label> </td>
                                                <td style="    padding-left: 15px;"> <p style=""> 공문</p></td>
                                            </tr>
                                        </tbody>
                                    </table>

                                       

                                       
          
                                   
                                  </td>
                                <td >
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td>    <label class="ckbox"> <input type="checkbox" style="" name=""{{ $finger['finger'] == 5 ? 'checked' : '' }} disabled></label> </td>
                                                <td style="    padding-left: 15px;"> <p style=""> 전자 이전 이동 </p></td>
                                            </tr>
                                        </tbody>
                                    </table>

                                       

                                       
          
                                   
                                  </td>
                            </tr>

                          
            </tbody>
            </table>
            {{-- <div class="page-break"></div> --}}
         
            </center>
        </div>
    </div>

<br>



<footer>
    <div class="row">

        <div class="col-6" style="margin-top:0px;">
            <center>

                <table style=" width: 100%; " >
                    <tbody>
                        <tr>
                            <td style="font-size:13px;">
                                <p style="font-weight: bold;  text-align:center;">ТОРГУУЛИЙН МЭДЭЭЛЭЛ</p>
                                <hr>
                            </td>
                    </tr>
                        <tr>
                        <td>
                            @if (isset($finger['checkTorguuli'][0]) != null)
                            Уг 차량ийн торгуулийг {{ Carbon\Carbon::now()->format("Y-m-d H:i:s")}}-ний 일 шалгахад <br> {{$finger['checkTorguuli'][0] }}
                            @else
                            Уг 차량ийн торгуулийг шалгаагүй !!!
                            @endif
        </td>
                        </tr>
                    </tbody>
                    </table> 
                </center>
           
        </div>
    </div>
    <footer>
<hr>
<br>
@if (isset($finger["signed_data"]))
<div style="  page-break-after: always;"></div>

<center>
    <h3 style="font-weight: bold;  text-align:center;">
    ЦАХИМ ШИЛЖИЛТ ХӨДӨЛГӨӨН ХИЙСЭН ТООН ГАРЫН ҮСЭГ
</h3></center>
        <div  style="word-wrap: break-word;">
       
                        
                 
                  
                               
         {{$finger['signed_data']}}
        
    
        </div>
  
        @endif
    </div>


    {{-- <footer>
        <p>dsfdsfsd</p>
    </footer> --}}

    {{-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
    </script>

    <!-- Option 2: jQuery, Popper.js, and Bootstrap JS
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>

   --}}

  
  </body>
</html>
