<!DOCTYPE html>
<html lang="en">
<head>
    @include('Includes.head')
    <style>
        body
        {
            font-family: 'Arial', Times, serif !important;
        }
        .gm-position-title
        {
            margin: 0 auto;
            text-align: center;
            margin-top: 15px;

            font-weight: bolder;
            color: #000;
            font-size: 14px;
        }
        .gm-position-title-span
        {
            border-bottom: 1px solid #000;
            color: #000;font-weight: bolder;
            white-space: pre;font-size: 11px;
        }
        .gm-noborder
        {
            border-bottom: 0px; white-space: pre;
        }
        @media print{@page {size: landscape}}
        .table th, .table td {
            padding: 3px 0px !important;
        }
    </style>
</head>
<body class="az-body">
<div class="row">
    <div class="col-12">
        <div class="card" style="padding: 10px;border: 0px;">
            <div class="card-body">
                <div class="row">
                    {{-- {{session()->get('auth')->iscity}} --}}
                    <div class="col-4"> 
                        <img class="img gmlogo" style="display: block; margin: 0 auto;width: 80px;" src="{{session()->get('auth')->iscity == 1 ? asset('img/niislel.jpg') : asset('img/logo.png') }}">
                    </div>
                    <div class="col-6">
                        <p class="gm-position-title" style="text-align: right;width: auto;float: right;font-size: 18px;margin-right: -37px;">{!!session()->get('auth')->iscity == 1 ? "Нийслэлийн автотээврийн </br>хэрэгслийн 등록·관리 센터 ":"АВТО ТЭЭВРИЙН ҮНДЭСНИЙ ТӨВ"!!}</p>
                    </div>
                </div>
                <hr id="line" class="mg-y-10" style="background: #000;height: 2px;">

                <div class="row" style="width:100%;text-align: center;margin-top: 10px;display: none;">
                    <div class="col-4">
                        <span class="gm-position-title-span">{{ date("Y") }}</span>
                        <span class="gm-position-title-span gm-noborder">оны</span>
                        <span class="gm-position-title-span">{{ date("m") }}</span>
                        <span class="gm-position-title-span gm-noborder">сарын</span>
                        <span class="gm-position-title-span">{{ date("d") }}</span>
                        <span class="gm-position-title-span gm-noborder">일</span>
                    </div>
                    <div class="col-4">
                        <span class="gm-position-title-span gm-noborder">Лавлагаа</span>
                        <span class="gm-position-title-span">          </span>
                        <span class="gm-position-title-span gm-noborder"> </span>
                    </div>
                    <div class="col-4">
                        <span class="gm-position-title-span gm-noborder" style="line-height: 25px;">울란바토르 хот</span>
                    </div>
                </div>

                <div class="row" style="width:100%;text-align: center;margin-top:45px;">
                    <div class="col-12">
                        <p style="text-align: center;font-size: 20px;font-weight: bolder;font-family: 'Arial', Times, serif;color: #000;">Тээврийн хэрэгслийн лавлагаа</br>/машинаар/</p>
                    </div>
                </div>

                <div class="row" style="width:100%;text-align: center;margin-top:10px;">
                    <div class="col-12" style="text-align: center;   padding: 0px 50px;">
                        <p style="text-align: center;font-size: 13px;font-weight: bolder;font-family: 'Arial', Times, serif"></p>
                    </div>
                </div>

                <div class="row" style="width:100%;text-align: center;margin-top:10px;">
                    <div class="col-12" style="text-align: center; ">
                        <table class="table table-bordered mg-b-0" style="border: 1px solid black">
                            <thead>
                            <tr>
                                <th rowspan="2">№</th>
                                <th colspan="6">Тээврийн хэрэгсэл</th>
                                <th colspan="5">Эзэмшигч</th>
                            </tr>
                            <tr>
                                <th>번호판</th>
                                <th>브랜드</th>
                                <th>모델</th>
                                <th>섬. дугаар</th>
                                <th>작업일</th>
                                <th>색상</th>
                                <th>성</th>
                                <th>이름</th>
                                <th>Регистр</th>
                                <th>주소</th>
                                <th>전화</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(session()->has("results"))
                                @foreach(session("results") as $result)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $result->plate_no }}</td>
                                        <td>{{ $result->mark_name }}</td>
                                        <td>{{ $result->model_name }}</td>
                                        <td>{{ $result->cabin_no }}</td>
                                        <td>{{ $result->build_year }}</td>
                                        <td>{{ $result->color_name }}</td>
                                        <td>{{ $result->last_name }}</td>
                                        <td>{{ $result->first_name }}</td>
                                        <td>{{ $result->register_no }}</td>
                                        <td>{{ $result->address_detail }}</td>
                                        <td>{{ $result->phone_no }}</td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row" style="width:100%;text-align: center;margin-top:145px;">
                    <div class="col-12">
                        <span style="font-size: 16px;font-weight: bolder;font-family: 'Arial', Times, serif;">Хянасан:</span>
                        <span style="font-size: 16px;font-weight: bolder;font-family: 'Arial', Times, serif;margin-left: 170px;"> /___________________/</span>
                    </div>
                    <div class="col-12" style="margin-top: 20px;">
                        <span style="font-size: 16px;font-weight: bolder;font-family: 'Arial', Times, serif;">담당자:</span>
                        <span style="font-size: 16px;font-weight: bolder;font-family: 'Arial', Times, serif;margin-left: 150px;">{{ substr(session()->get("auth")->lastname, 0, 2).". ".session()->get("auth")->firstname }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../lib/jquery/jquery.min.js"></script>
    <script src="../lib/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../lib/ionicons/ionicons.js"></script>
    <script src="../js/azia.js"></script>
</div>
</body>
</html>
