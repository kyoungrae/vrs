<!DOCTYPE html>
<html lang="en">

<head>
    @include('Includes.head')
    <style>
        .formContainer {
            background-image: url('/img/soyombo_bg.png');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
            background-size: 300px;
            height: 700px;
        }

        body {
            font-family: "arial";
        }

        .table-bordered {
            border: 2px solid #000000;
        }

        .table-bordered th,
        .table-bordered td {
            border: 2px solid #000000;
        }

        .table thead th,
        .table thead td {
            color: #000000;
            font-weight: 700;
            font-size: 14px;
            letter-spacing: .5px;
            text-transform: uppercase;
            border-bottom-width: 1px;
            border-top-width: 0;
            padding: 0 15px 5px;
        }

        .table {
            font-size: 14px;
            font-weight: bolder;
        }

        .table th,
        .table td {
            padding: 10px 8px;
            line-height: 1;
            border: 2px solid #000;
        }

        @media print {

            .table th,
            .table td {
                padding: 10px 8px;
                line-height: 1;
                border: 2px solid #000;
            }

            #factoryDate {
                height: 52px !important;
            }
        }

        input[type=checkbox] {
            background: white;
            border-radius: 0px;
            border: 2px solid #000;
            width: 17px;
            height: 17px;
        }

        input[type="checkbox"]:checked {
            background: #fff;
        }

        input[type="checkbox"]:disabled {
            background: #fff;
        }
        .checkbox {
  width:20px;
  height:20px;
  border: 1px solid #000;
  display: inline-block;
}

/* This is what simulates a checkmark icon */
.checkbox.checked:after {
  content: '';
  display: block;
  width: 4px;
  height: 7px;
  
  /* "Center" the checkmark */
  position:relative;
  top:4px;
  left:7px;
  
  border: solid #000;
  border-width: 0 2px 2px 0;
  transform: rotate(45deg);
}
    </style>
</head>

<body class="az-body formContainer">
    <div id="printer">
        <div class="container">
            <div class="row">

                {{-- {{ $historie1->id }} --}}
                {{-- {{ $historie1->service_name }}<br>
                {{ session('historie1')->get(1)->service_name }}<br> --}}

                <div class="col-4" style="">

                </div>
                <div class="col-3" style="">

                    <img src="{{ asset('img/logo.png') }}" alt="" style="width:100%;    padding-right: 28px;
              padding-left: 122px;
              padding-top: 15px;">

                </div>
                <div class="col-3" style="padding: 21px 1px;">

                    <p style="text-align: end;"> Зам, тээврийн хөгжлийн сайдын
                        ..... оны ... 번호 тушаалаар батлагдсан
                        "자동차운송 хэрэгслийн бүртгэл хөтлөх,
                        번호판 олгох журам"-ын нэгдүгээр хавсралт
                    </p>

                </div>
                <div class="container">
                    <div class="row" style=" margin-left: 0;     padding: 7px 27px;">
                        <div class="col-4" style="    margin-top: 4px;">
                            <center> <span>
                                    <h6 style="font-weight: bold; float: right; ">
                                        огноо:{{ session()->has('vehicle') ? session()->get('vehicle')->updated_date : '' }}
                                    </h6>
                                </span></center>
                        </div>
                        <div class="col-3" style="">
                            <center><span>
                                    <h6 style="font-weight: bold;     font-size: 18px;">БҮРТГЭЛИЙН МЭДҮҮЛЭГ</h6>
                                </span></center>
                        </div>
                        <div class="col-4" style="    margin-top: 4px;">
                            <span>
                                <h6 style="font-weight: bold;">архивын
                                    번호:{{ session()->has('vehicle') ? session()->get('vehicle')->archive_no : '' }}
                                </h6>
                            </span>
                        </div>
                    </div>
                </div>


            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12" style="margin-top:0px;">
                    <center>


                        <table class="table table-bordered" style=" width: 733px; ">
                            <tbody>
                                <tr>
                                    <td style=" width: 19%;padding: 33px 15px; text-align: center;">서비스 유형:
                                    </td>
                                    <td style="    text-align: center;"><p>신규 서비스 등록</p>
                                        <div style=" width: 0;       margin: 9px 26px;">
                                           
                                           
                                                <div class="checkbox {{$historie1->service_id == 1 ? 'checked' :  '' }}"></div>
                                        </div>
                                    </td>
                                    <td style="    text-align: center;"><p>이전 хөдөлгөөн</p>

                                        <div style=" width: 0;       margin: 9px 26px;">
                                            <div class="checkbox {{$historie1->service_id == 3 ? 'checked' :  '' }}"></div>
                                            
                                        </div>
                                    </td>
                                    <td style="    text-align: center;"><p>차량Г нөхөлт, солилт, техникийн өөрчлөлт</p>
                                        <div style=" width: 0;       margin: 9px 61px;">
                                        
                                                <div class="checkbox {{$historie1->service_id == 13 || $historie1->service_id == 14 || $historie1->service_id == 4 || $historie1->service_id == 2  ? 'checked' :  '' }}"></div>
                                        </div>
                                    </td>
                                    <td style="    text-align: center;     width: 135px;"><p>Дугаар өөрчлөх, хадгалах</p>
                                        <div style=" width: 0;       margin: 9px 46px;">
                                            <div class="checkbox {{$historie1->service_id == 15 ? 'checked' :  '' }}"></div>
                                        </div>
                                    </td>
                                    <td style="    text-align: center; "><p>Бүртгэлээс хасах</p>
                                        <div class="checkbox {{$historie1->service_id == 9 ? 'checked' :  '' }}"></div>
                                        </div>
                                    </td>


                                </tr>

                            </tbody>
                        </table>
                    </center>
                </div>

            </div>
        </div>
        <div class="container">
            <div class="row">

                <div class="col-12" style="margin-top:0px;">
                    <center>
                        <table class="table table-bordered" style=" width: 733px;  ">
                            <tr>
                                <td>증명서 №</td>
                                <td>{{ session()->has('vehicle') ? session()->get('vehicle')->certificate_no : '' }}
                                </td>
                                <td>용도</td>
                                <td>{{ session()->has('vehicle') ? session()->get('vehicle')->purpose_name : '' }}</td>
                            </tr>
                            <tr>
                                <td style=" ">번호판</td>
                                <td>{{ session()->has('vehicle') ? session()->get('vehicle')->plate_no : '' }}</td>
                                <td>제조 연도</td>
                                <td>{{ session()->has('vehicle') ? session()->get('vehicle')->build_year : '' }}</td>
                            </tr>
                            <tr>
                                <td>브랜드</td>
                                <td>{{ session()->has('vehicle') ? session()->get('vehicle')->mark_name : '' }}</td>
                                <td>섬 №</td>
                                <td>{{ session()->has('vehicle') ? session()->get('vehicle')->cabin_no : '' }}</td>
                            </tr>
                            <tr>
                                <td>형식</td>
                                <td>{{ session()->has('vehicle') ? session()->get('vehicle')->model_name : '' }}</td>
                                <td>엔진 배기량 V(c.c)</td>
                                <td>{{ session()->has('vehicle') ? session()->get('vehicle')->engine_capacity : '' }}
                                </td>
                            </tr>
                            <tr>
                                <td>유형</td>
                                <td>{{ session()->has('vehicle') ? session()->get('vehicle')->vehicle_type_name : '' }}
                                </td>
                                <td>색상</td>
                                <td>{{ session()->has('vehicle') ? session()->get('vehicle')->color_name : '' }}</td>
                            </tr>
                            <tr>
                                <td>등급</td>
                                <td>{{ session()->has('vehicle') ? session()->get('vehicle')->class_name : '' }}</td>
                                <td>엔진<br> 연료원</td>
                                <td style=" padding: 5px 16px; ">
                                    <div class="row" style=" margin-left: 0px;  margin-right: 0px; ">
                                        @if (session()->has('vehicle'))
                                            <div style=" width: 0;     margin-left: 5px;"><span
                                                    style="margin-left: -4px;font-size: 8px;">휘발유</span>
                                                <input type="checkbox" name=""
                                                    {{ session()->get('vehicle')->fuel_type_id == 48 ? 'checked' : '' }}
                                                    disabled>
                                            </div>
                                            <div style=" width: 0;margin-left: 40px; "><span
                                                    style="margin-left: -4px;font-size: 8px;">디젤</span>
                                                <input type="checkbox" name=""
                                                    {{ session()->get('vehicle')->fuel_type_id == 17 || session()->get('vehicle')->fuel_type_id == 18 ? 'checked' : '' }}
                                                    disabled>
                                            </div>
                                            <div style="width: 45px;margin-left: 40px;"><span
                                                    style="margin-left: -4px;font-size: 8px;">가스 연료</span>
                                                <input type="checkbox" name=""
                                                    {{ session()->get('vehicle')->fuel_type_id == 22 ? 'checked' : '' }}
                                                    disabled>
                                            </div>
                                            <div style=" width: 0; margin-left: 8px;"><span
                                                    style="margin-left: -4px;font-size: 8px;">기타</span>
                                                <input type="checkbox" name=""
                                                    {{ session()->get('vehicle')->fuel_type_id == '' ? 'checked' : '' }}
                                                    disabled>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>세관 모드</td>
                                <td><span id="dclrTypeCd"></span></td>
                                <td>R 번호</td>
                                <td>{{ session()->get('vehicle')->declaration_no }}</td>
                            </tr>

                        </table>
                    </center>
                </div>
                {{-- <div class="col-6" style="margin-top:0px;">
                    <center>

                        <table class="table table-bordered" style=" width: 350px; float: right; ">
                            <tbody>
                                <tr>
                                    <td>증명서 №</td>
                                    <td>{{ session()->has('vehicle') ? session()->get('vehicle')->certificate_no : '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style=" width: 40%; ">번호판</td>
                                    <td>{{ session()->has('vehicle') ? session()->get('vehicle')->plate_no : '' }}</td>
                                </tr>
                                <tr>
                                    <td>브랜드</td>
                                    <td>{{ session()->has('vehicle') ? session()->get('vehicle')->mark_name : '' }}</td>
                                </tr>
                                <tr>
                                    <td>형식</td>
                                    <td>{{ session()->has('vehicle') ? session()->get('vehicle')->model_name : '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>유형</td>
                                    <td>{{ session()->has('vehicle') ? session()->get('vehicle')->vehicle_type_name : '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>등급</td>
                                    <td>{{ session()->has('vehicle') ? session()->get('vehicle')->class_name : '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>세관 모드</td>
                                    <td></td>
                                </tr>

                            </tbody>
                        </table>
                    </center>
                </div>
                <div class="col-6" style="margin-top:0px;">
                    <table class="table table-bordered" style=" width: 350px; float: left; ">
                        <tbody>
                            <tr style=" ">
                                <td>용도</td>
                                <td>{{ session()->has('vehicle') ? session()->get('vehicle')->purpose_name : '' }}</td>
                            </tr>
                            <tr id="factoryDate" style=" ">
                                <td>제조 연도</td>
                                <td>{{ session()->has('vehicle') ? session()->get('vehicle')->build_year : '' }}</td>
                            </tr>
                            <tr>
                                <td>섬 №</td>
                                <td>{{ session()->has('vehicle') ? session()->get('vehicle')->cabin_no : '' }}</td>
                            </tr>

                            <tr>
                                <td>엔진 배기량 V(c.c)</td>
                                <td>{{ session()->has('vehicle') ? session()->get('vehicle')->engine_capacity : '' }}
                                </td>
                            </tr>
                            <tr>
                                <td>색상</td>
                                <td>{{ session()->has('vehicle') ? session()->get('vehicle')->color_name : '' }}</td>
                            </tr>
                            <tr>
                                <td>엔진<br> 연료원</td>
                                <td style=" padding: 0px 5px; ">
                                    <div class="row" style=" margin-left: 0px;  margin-right: 0px; ">
                                        @if (session()->has('vehicle'))
                                            <div style=" width: 0;     margin-left: 5px;"><span
                                                    style="margin-left: -4px;font-size: 8px;">휘발유</span>
                                                <input type="checkbox" name=""
                                                    {{ session()->get('vehicle')->fuel_type_id == 48 ? 'checked' : '' }}
                                                    disabled>
                                            </div>
                                            <div style=" width: 0;margin-left: 40px; "><span
                                                    style="margin-left: -4px;font-size: 8px;">디젤</span>
                                                <input type="checkbox" name=""
                                                    {{ session()->get('vehicle')->fuel_type_id == 17 ? 'checked' : '' }}
                                                    disabled>
                                            </div>
                                            <div style="width: 45px;margin-left: 40px;"><span
                                                    style="margin-left: -4px;font-size: 8px;">가스 연료</span>
                                                <input type="checkbox" name=""
                                                    {{ session()->get('vehicle')->fuel_type_id == 22 ? 'checked' : '' }}
                                                    disabled>
                                            </div>
                                            <div style=" width: 0; margin-left: 8px;"><span
                                                    style="margin-left: -4px;font-size: 8px;">기타</span>
                                                <input type="checkbox" name=""
                                                    {{ session()->get('vehicle')->fuel_type_id == '' ? 'checked' : '' }}
                                                    disabled>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>R 번호</td>
                                <td></td>
                            </tr>

                        </tbody>
                    </table>
                    </center>
                </div> --}}
            </div>
        </div>

        <div class="row">
            <div class="col-12" style="margin-top:5px;">
                <center><span>
                        <h6 style="font-weight: bold;">ШИЛЖҮҮЛСЭН (Иргэн, 기관, ААН)</h6>
                    </span></center>
            </div>
            <div class="col-12" style="margin-top:0px;">
                <center>
                    <table class="table table-bordered" style="width: 727px;">
                        <tbody>
                            @if (session()->has('owners'))
                                @if (session()
        ->get('owners')
        ->count() > 1)
                                    <tr>
                                        <td style=" width: 25%; ">본관성</td>
                                        <td colspan="4">{{ session()->has('owners')
                                    ? session()->get('owners')->get(1)->family_name
                                    : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>부모 이름 <br /><span style="font-size: 8px;">/기관, ААН-ийн
                                                төрөл/</span></td>
                                        <td colspan="4">{{ session()->has('owners')
                                    ? session()->get('owners')->get(1)->last_name
                                    : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>이름 <br /><span style="font-size: 8px;">/기관, ААН-ийн нэр/</span>
                                        </td>
                                        <td colspan="4">{{ session()->has('owners')
                                    ? session()->get('owners')->get(1)->first_name
                                    : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>등록번호</td>
                                        <td colspan="4">{{ session()->has('owners')
                                    ? session()->get('owners')->get(1)->register_no
                                    : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>주소 <br /><span style="font-size: 8px;">/세금 төлдөг хаяг/</span></td>
                                        <td colspan="4">{{ session()->has('owners')
                                    ? session()->get('owners')->get(1)->address_detail
                                    : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td rowspan="2" style=" text-align: center; vertical-align: middle; ">전화</td>
                                        <td>А년</td>
                                        <td>Гэр</td>
                                        <td>Гар</td>
                                        <td>기타</td>
                                    </tr>
                                    <tr>
                                        <td>{{ session()->has('owners')
                                    ? session()->get('owners')->get(1)->workphone
                                    : '' }}</td>
                                        <td>{{ session()->has('owners')
                                    ? session()->get('owners')->get(1)->homephone
                                    : '' }}</td>
                                        <td>{{ session()->has('owners')
                                    ? session()->get('owners')->get(1)->cellphone
                                    : '' }}</td>
                                        <td></td>
                                    </tr>
                                @endif
                            @endif
                        </tbody>
                    </table>
                </center>
            </div>
        </div>

        <div class="row">
            <div class="col-12" style="margin-top:5px;">
                <center><span>
                        <h6 style="font-weight: bold;">ШИЛЖҮҮЛЭН АВСАН (Иргэн, 기관, ААН)</h6>
                    </span></center>
            </div>
            <div class="col-12" style="margin-top:0px;">
                <center>
                    <table class="table table-bordered" style="width: 727px;">
                        <tbody>
                            <tr>
                                <td style=" width: 25%; ">본관성</td>
                                <td colspan="4">{{ session()->has('owners')
                            ? session()->get('owners')->first()->family_name
                            : '' }}</td>
                            </tr>
                            <tr>
                                <td>부모 이름 <br /><span style="font-size: 8px;">/기관, ААН-ийн
                                        төрөл/</span></td>
                                <td colspan="4">{{ session()->has('owners')
                            ? session()->get('owners')->first()->last_name
                            : '' }}</td>
                            </tr>
                            <tr>
                                <td>이름 <br /><span style="font-size: 8px;">/기관, ААН-ийн нэр/</span></td>
                                <td colspan="4">{{ session()->has('owners')
                            ? session()->get('owners')->first()->first_name
                            : '' }}</td>
                            </tr>
                            <tr>
                                <td>등록번호</td>
                                <td colspan="4">{{ session()->has('owners')
                            ? session()->get('owners')->first()->register_no
                            : '' }}</td>
                            </tr>
                            <tr>
                                <td>주소 <br /><span style="font-size: 8px;">/세금 төлдөг хаяг/</span></td>
                                <td colspan="4">{{ session()->has('owners')
                            ? session()->get('owners')->first()->address_detail
                            : '' }}</td>
                            </tr>
                            <tr>
                                <td rowspan="2" style=" text-align: center; vertical-align: middle; ">전화</td>
                                <td>А년</td>
                                <td>Гэр</td>
                                <td>Гар</td>
                                <td>기타</td>
                            </tr>
                            <tr>
                                <td>{{ session()->has('owners')
                            ? session()->get('owners')->first()->workphone
                            : '' }}</td>
                                <td>{{ session()->has('owners')
                            ? session()->get('owners')->first()->homephone
                            : '' }}</td>
                                <td>{{ session()->has('owners')
                            ? session()->get('owners')->first()->cellphone
                            : '' }}</td>
                                <td></td>
                            </tr>
                            <tr>

                                <td colspan="3">
                                    <center>
                                        <div class="row">
                                            <div class="col-3" style="    padding-right: 6px;">
                                                <input type="checkbox" style="float: right;" name=""
                                                    {{ $historie1->insert_finger == 2 || $historie1->insert_finger == 0 ? 'checked' : '' }}
                                                    disabled>

                                            </div>
                                            <div class="col-9" style="margin-top: 2px; padding: 0;"><span
                                                    style="    float: left;"> Иргэний үнэмлэхээр баталгаажсан</span>
                                            </div>
                                        </div>
                                    </center>
                                </td>

                                <td colspan="2">
                                    <center>
                                        <div class="row">
                                            <div class="col-3" style="    padding-right: 6px;">
                                                <input type="checkbox" style="float: left;" name=""
                                                    {{ $historie1->insert_finger == 1 ? 'checked' : '' }} disabled>
                                            </div>
                                            <div class="col-9" style="margin-top: 2px; padding: 0;"><span
                                                    style="    float: left;"> 지문으로 баталгаажсан</span></div>
                                        </div>
                                    </center>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </center>
            </div>
        </div>

        <div class="container" style="    width: 742px;">
            <div class="row">




                <div class="col-3" style="margin-top:0px;">



                    {{-- <center><img
                            src="https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl={{ session()->get('vehicle')->plate_no }}&choe=UTF-8"
                            title="Link to Gocom" /></center> --}}


                </div>
                <div class="col-9" style="margin-top:20px;">
                    <center><span style=" font-weight: bolder; ">Бүртгэгч:
                            {{ session()->get('vehicle')->firstname }}</span></center>
                </div>
            </div>
        </div>




        {{-- <div class="row">
            <div class="col-6" style="margin-top:0px;">
                <center><span>
                        <h6 style="font-weight: bold;margin-left: 400px;">Өөрчилсөн</h6>
                    </span></center>
                <center>
                    <table class="table table-bordered" style=" width: 350px; float: right; ">
                        <tbody>
                            <tr>
                                <td style=" width: 50%; ">섬 №</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Бүхээг №</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Хөдөлгүүр №</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>색상</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Гэрчилгээ</td>
                                <td>
                                    <div class="row" style=" margin-left: 0px;  margin-right: 0px; ">
                                        <input type="checkbox" name="" checked=""> <span
                                            style=" margin-top: 3px; margin-left: 4px;margin-right: 4px; ">Солив</span>
                                        <input type="checkbox" name=""><span
                                            style=" margin-top: 3px; margin-left: 4px; ">Нөхөв</span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </center>
            </div>
            <div class="col-6" style="margin-top:20px;">
                <span style=" font-weight: bolder; ">Шилжүүлсэн хүний <br /> гарын
                    үсэг:__________________________________</span><br /><br />
                <span style=" font-weight: bolder;margin-top:20px; ">Шилжүүлэн авсан хүний <br /> гарын
                    үсэг:__________________________________</span><br /><br />
                <span style="font-weight: bolder;margin-left: 180px;">{{ \Carbon\Carbon::now()->format('Y') }} он
                    {{ \Carbon\Carbon::now()->format('m') }} сар {{ \Carbon\Carbon::now()->format('d') }} 일</span>
            </div>
        </div> --}}



        <script src="../lib/jquery/jquery.min.js"></script>
        <script src="../lib/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script>
            // alert("gdfgdf");
            $(document).ready(function() {
                var gaali = '{{ session()->get('
                vehicle ') ? \App\Http\Controllers\BaseController::enc(session()->get('
                vehicle ')->declaration_no) : '
                ' }}';
                // alert(gaali);
                $.ajax({
                    type: 'POST',
                    url: '/api/gaali',
                    dataType: "json",
                    data: {
                        param1: gaali,
                        param2: '{{ \App\Http\Controllers\BaseController::enc(\Carbon\Carbon::now()->format('
                        Y - m - d ')) }}'
                    },
                    timeout: 60000,
                    error: function(data) {

                    },
                    success: function(data) {
                        //  console.log(data);
                        try {

                            $.each(data, function(key, value) {

                                var dclrTypeCd = value.response["dclrTypeCd"];
                                $("#dclrTypeCd").html(dclrTypeCd);

                            });
                        } catch (err) {

                        }

                    }
                });
            });

        </script>
    </div>
</body>

</html>
