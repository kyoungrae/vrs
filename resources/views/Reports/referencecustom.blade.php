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
                    <div class="col-4">
                        <img class="img gmlogo" style="display: block; margin: 0 auto;width: 80px;" src="{{ asset('img/logo.png') }}">
                    </div>
                    <div class="col-6">
                        <p class="gm-position-title" style="text-align: right;width: 200px;float: right;font-size: 18px;margin-right: -37px;">АВТО ТЭЭВРИЙН ҮНДЭСНИЙ ТӨВ</p>
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
                        <p style="text-align: center;font-size: 20px;font-weight: bolder;font-family: 'Arial', Times, serif;color: #000;">{{$title}}</p>
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
                                <th>№</th>
                                <th style="@if(isset($ehelsenognoo)) {{"display:table-cell" }} @else {{"display:none"}} @endif">시작 일자</th>
                                <th style="@if(isset($ulsiindugaar)) {{"display:table-cell" }} @else {{"display:none"}} @endif">번호판</th>
                                <th style="@if(isset($arliindugaar)) {{"display:table-cell" }} @else {{"display:none"}} @endif">차체번호</th>
                                <th style="@if(isset($vin)) {{"display:table-cell" }} @else {{"display:none"}} @endif">VIN 번호</th>
                                <th style="@if(isset($factory)) {{"display:table-cell" }} @else {{"display:none"}} @endif">제조국</th>
                                <th style="@if(isset($mark)) {{"display:table-cell" }} @else {{"display:none"}} @endif">브랜드</th>
                                <th style="@if(isset($model)) {{"display:table-cell" }} @else {{"display:none"}} @endif">모델</th>
                                <th style="@if(isset($modificacename)) {{"display:table-cell" }} @else {{"display:none"}} @endif">Модификац</th>
                                <th style="@if(isset($vinmodel)) {{"display:table-cell" }} @else {{"display:none"}} @endif">VIN загвар</th>
                                <th style="@if(isset($uurchilsunognoo)) {{"display:table-cell" }} @else {{"display:none"}} @endif">변경 일자</th>
                                <th style="@if(isset($bagtaamj)) {{"display:table-cell" }} @else {{"display:none"}} @endif">Багтаамж</th>
                                <th style="@if(isset($zoriulalt)) {{"display:table-cell" }} @else {{"display:none"}} @endif">용도</th>
                                <th style="@if(isset($turul)) {{"display:table-cell" }} @else {{"display:none"}} @endif">유형</th>
                                <th style="@if(isset($angilal)) {{"display:table-cell" }} @else {{"display:none"}} @endif">등급</th>
                                <th style="@if(isset($hurd)) {{"display:table-cell" }} @else {{"display:none"}} @endif">핸들 위치</th>
                                <th style="@if(isset($hairtsag)) {{"display:table-cell" }} @else {{"display:none"}} @endif">변속기</th>
                                <th style="@if(isset($uildverlesenognoo)) {{"display:table-cell" }} @else {{"display:none"}} @endif">제조 일자</th>
                                <th style="@if(isset($motor)) {{"display:table-cell" }} @else {{"display:none"}} @endif">Моторын 번호</th>
                                <th style="@if(isset($gasoline)) {{"display:table-cell" }} @else {{"display:none"}} @endif">연료 유형</th>
                                <th style="@if(isset($urt)) {{"display:table-cell" }} @else {{"display:none"}} @endif">Урт</th>
                                <th style="@if(isset($urgun)) {{"display:table-cell" }} @else {{"display:none"}} @endif">Өргөн</th>
                                <th style="@if(isset($undur)) {{"display:table-cell" }} @else {{"display:none"}} @endif">Өндөр</th>
                                <th style="@if(isset($buhjin)) {{"display:table-cell" }} @else {{"display:none"}} @endif">Бүх жин</th>
                                <th style="@if(isset($uuriinjin)) {{"display:table-cell" }} @else {{"display:none"}} @endif">Өөрийн жин</th>
                                <th style="@if(isset($color)) {{"display:table-cell" }} @else {{"display:none"}} @endif">색상</th>
                                <th style="@if(isset($gerchilgee)) {{"display:table-cell" }} @else {{"display:none"}} @endif">증명서 번호</th>
                                <th style="@if(isset($oruuljirsen)) {{"display:table-cell" }} @else {{"display:none"}} @endif">Оруулж ирсэн огноо</th>
                                <th style="@if(isset($archivedugaar)) {{"display:table-cell" }} @else {{"display:none"}} @endif">아카이브 번호</th>
                                <th style="@if(isset($anhniiarchive)) {{"display:table-cell" }} @else {{"display:none"}} @endif">최초 아카이브</th>
                                <th style="@if(isset($meduulgiindugaar)) {{"display:table-cell" }} @else {{"display:none"}} @endif">Мэдүүлгийн 번호</th>
                                <th style="@if(isset($teevriinheregselturul)) {{"display:table-cell" }} @else {{"display:none"}} @endif">차량-н төлөв</th>
                                <th style="@if(isset($uls)) {{"display:table-cell" }} @else {{"display:none"}} @endif">검정ъяа улс</th>
                                <th style="@if(isset($registernumber)) {{"display:table-cell" }} @else {{"display:none"}} @endif">등록번호</th>
                                <th style="@if(isset($urgiinovog)) {{"display:table-cell" }} @else {{"display:none"}} @endif">본관성</th>
                                <th style="@if(isset($etsegekh)) {{"display:table-cell" }} @else {{"display:none"}} @endif">Эцэг/эхийн нэр</th>
                                <th style="@if(isset($uuriinner)) {{"display:table-cell" }} @else {{"display:none"}} @endif">Өөрийн нэр</th>
                                <th style="@if(isset($aimag)) {{"display:table-cell" }} @else {{"display:none"}} @endif">Аймаг/хот</th>
                                <th style="@if(isset($duureg)) {{"display:table-cell" }} @else {{"display:none"}} @endif">Сум/ Дүүрэг</th>
                                <th style="@if(isset($baghoroo)) {{"display:table-cell" }} @else {{"display:none"}} @endif">Баг/Хороо</th>
                                <th style="@if(isset($horoolol)) {{"display:table-cell" }} @else {{"display:none"}} @endif">Хороолол</th>
                                <th style="@if(isset($gudamj)) {{"display:table-cell" }} @else {{"display:none"}} @endif">거리</th>
                                <th style="@if(isset($bair)) {{"display:table-cell" }} @else {{"display:none"}} @endif">동</th>
                                <th style="@if(isset($haalga)) {{"display:table-cell" }} @else {{"display:none"}} @endif">호</th>
                                <th style="@if(isset($geriinutas)) {{"display:table-cell" }} @else {{"display:none"}} @endif">자택 전화</th>
                                <th style="@if(isset($ajiliinutas)) {{"display:table-cell" }} @else {{"display:none"}} @endif">직장 전화</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(session()->has("results"))
                                @foreach(session("results") as $result)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td style="@if(isset($ehelsenognoo)) {{"display:table-cell" }} @else {{"display:none"}} @endif">{{ $result->updated_date }}</td>
                                        <td style="@if(isset($ulsiindugaar)) {{"display:table-cell" }} @else {{"display:none"}} @endif">{{ $result->plate_no }}</td>
                                        <td style="@if(isset($arliindugaar)) {{"display:table-cell" }} @else {{"display:none"}} @endif">{{ $result->cabin_no }}</td>
                                        <td style="@if(isset($vin)) {{"display:table-cell" }} @else {{"display:none"}} @endif">{{ $result->vin_no }}</td>
                                        <td style="@if(isset($factory)) {{"display:table-cell" }} @else {{"display:none"}} @endif">{{ $result->country_name }}</td>
                                        <td style="@if(isset($mark)) {{"display:table-cell" }} @else {{"display:none"}} @endif">{{ $result->mark_name }}</td>
                                        <td style="@if(isset($model)) {{"display:table-cell" }} @else {{"display:none"}} @endif">{{ $result->model_name }}</td>
                                        <td style="@if(isset($modificacename)) {{"display:table-cell" }} @else {{"display:none"}} @endif">{{ $result->modificace_name }}</td>
                                        <td style="@if(isset($vinmodel)) {{"display:table-cell" }} @else {{"display:none"}} @endif">{{ $result->vehicle_type_name }}</td>
                                        <td style="@if(isset($uurchilsunognoo)) {{"display:table-cell" }} @else {{"display:none"}} @endif">{{ $result->updated_date }}</td>
                                        <td style="@if(isset($bagtaamj)) {{"display:table-cell" }} @else {{"display:none"}} @endif">{{ $result->seat_count }}</td>
                                        <td style="@if(isset($zoriulalt)) {{"display:table-cell" }} @else {{"display:none"}} @endif">{{ $result->purpose_name }}</td>
                                        <td style="@if(isset($turul)) {{"display:table-cell" }} @else {{"display:none"}} @endif">{{ $result->vehicle_type_name }}</td>
                                        <td style="@if(isset($angilal)) {{"display:table-cell" }} @else {{"display:none"}} @endif">{{ $result->class_name }}</td>
                                        <td style="@if(isset($hurd)) {{"display:table-cell" }} @else {{"display:none"}} @endif">{{ $result->steering_type_name }}</td>
                                        <td style="@if(isset($hairtsag)) {{"display:table-cell" }} @else {{"display:none"}} @endif">{{ $result->par_type_name }}</td>
                                        <td style="@if(isset($uildverlesenognoo)) {{"display:table-cell" }} @else {{"display:none"}} @endif">{{ $result->build_year }}</td>
                                        <td style="@if(isset($motor)) {{"display:table-cell" }} @else {{"display:none"}} @endif">{{ $result->engine_no }}</td>
                                        <td style="@if(isset($gasoline)) {{"display:table-cell" }} @else {{"display:none"}} @endif">{{ $result->fuel_name }}</td>
                                        <td style="@if(isset($urt)) {{"display:table-cell" }} @else {{"display:none"}} @endif">{{ $result->length }}</td>
                                        <td style="@if(isset($urgun)) {{"display:table-cell" }} @else {{"display:none"}} @endif">{{ $result->width }}</td>
                                        <td style="@if(isset($undur)) {{"display:table-cell" }} @else {{"display:none"}} @endif">{{ $result->height }}</td>
                                        <td style="@if(isset($buhjin)) {{"display:table-cell" }} @else {{"display:none"}} @endif">{{ $result->total_weight }}</td>
                                        <td style="@if(isset($uuriinjin)) {{"display:table-cell" }} @else {{"display:none"}} @endif">{{ $result->own_weight }}</td>
                                        <td style="@if(isset($color)) {{"display:table-cell" }} @else {{"display:none"}} @endif">{{ $result->color_name }}</td>
                                        <td style="@if(isset($gerchilgee)) {{"display:table-cell" }} @else {{"display:none"}} @endif">{{ $result->certificate_no }}</td>
                                        <td style="@if(isset($oruuljirsen)) {{"display:table-cell" }} @else {{"display:none"}} @endif">{{ \Carbon\Carbon::parse($result->import_date)->format("Y-m-d") }}</td>
                                        <td style="@if(isset($archivedugaar)) {{"display:table-cell" }} @else {{"display:none"}} @endif">{{ $result->archive_no }}</td>
                                        <td style="@if(isset($anhniiarchive)) {{"display:table-cell" }} @else {{"display:none"}} @endif">{{ $result->first_archive_no }}</td>
                                        <td style="@if(isset($meduulgiindugaar)) {{"display:table-cell" }} @else {{"display:none"}} @endif">{{ $result->declaration_no }}</td>
                                        <td style="@if(isset($teevriinheregselturul)) {{"display:table-cell" }} @else {{"display:none"}} @endif">{{ $result->status_name }}</td>
                                        <td style="@if(isset($uls)) {{"display:table-cell" }} @else {{"display:none"}} @endif">{{ $result->owner_country_name }}</td>
                                        <td style="@if(isset($registernumber)) {{"display:table-cell" }} @else {{"display:none"}} @endif">{{ $result->register_no }}</td>
                                        <td style="@if(isset($urgiinovog)) {{"display:table-cell" }} @else {{"display:none"}} @endif">{{ $result->family_name }}</td>
                                        <td style="@if(isset($etsegekh)) {{"display:table-cell" }} @else {{"display:none"}} @endif">{{ $result->last_name }}</td>
                                        <td style="@if(isset($uuriinner)) {{"display:table-cell" }} @else {{"display:none"}} @endif">{{ $result->first_name }}</td>
                                        <td style="@if(isset($aimag)) {{"display:table-cell" }} @else {{"display:none"}} @endif">{{ $result->owner_province_id }}</td>
                                        <td style="@if(isset($duureg)) {{"display:table-cell" }} @else {{"display:none"}} @endif">{{ $result->owner_district_id }}</td>
                                        <td style="@if(isset($baghoroo)) {{"display:table-cell" }} @else {{"display:none"}} @endif">{{ $result->owner_micro_district_id }}</td>
                                        <td style="@if(isset($horoolol)) {{"display:table-cell" }} @else {{"display:none"}} @endif">{{ $result->owner_devision_unit_id }}</td>
                                        <td style="@if(isset($gudamj)) {{"display:table-cell" }} @else {{"display:none"}} @endif">{{ $result->owner_street }}</td>
                                        <td style="@if(isset($bair)) {{"display:table-cell" }} @else {{"display:none"}} @endif">{{ $result->owner_apartment_no }}</td>
                                        <td style="@if(isset($haalga)) {{"display:table-cell" }} @else {{"display:none"}} @endif">{{ $result->owner_door_no }}</td>
                                        <td style="@if(isset($geriinutas)) {{"display:table-cell" }} @else {{"display:none"}} @endif"></td>
                                        <td style="@if(isset($ajiliinutas)) {{"display:table-cell" }} @else {{"display:none"}} @endif">{{ $result->owner_cellphone }}</td>
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
