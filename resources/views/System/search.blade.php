<!DOCTYPE html>
<html lang="en">
<head>
    @include('Includes.head')
    <style>
        .ckbox
        {
            margin-top:10px;
        }
        #searchResult
        {
            color: #494c57;
            font-weight: 400;
        }

        .outer-div
        {
            padding: 0px;
            text-align: center;
        }

        .inner-div
        {
            display: inline-block;
            padding: 0px;
        }
    </style>
</head>
<body class="az-body flexcroll">
<div class="avtoteeverPreloader"></div>
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
                    <h6 class="card-title">
                        <div class="row">
                            <div class="mg-b-20" style="width: 100%;">
                                <div class="row mg-10">
                                    <h6 class="card-title">@if(ISSET($total_count)){{ "총 ".$total_count." " }}@endif검색 결과</h6>
                                    <div class="col-lg-12 col-md-12 col-sm-12" style="overflow-x: scroll;">
                                        <table id="searchResult" class="responsive nowrap" style="width:100%;text-align: center;">
                                            <thead>
                                            <tr>
                                                <th>№</th>
                                                <th>시작일</th>
                                                <th>차량 번호</th>
                                                <th>차대 번호</th>
                                                <th>VIN 번호</th>
                                                <th>제조국</th>
                                                <th>제조사</th>
                                                <th>모델</th>
                                                <th>상세 모델</th>
                                                <th>색상</th>
                                                <th>제조일</th>
                                                <th>수정일</th>
                                                <th>소유 시작일</th>
                                                <th>아카이브 번호</th>
                                                <th>성</th>
                                                <th>부모 성명</th>
                                                <th>본인 이름</th>
                                                <th>배기량</th>
                                                <th>용도</th>
                                                <th>유형</th>
                                                <th>분류</th>
                                                <th>핸들 위치</th>
                                                <th>엔진 번호</th>
                                                <th>연료 유형</th>
                                                <th>길이</th>
                                                <th>너비</th>
                                                <th>높이</th>
                                                <th>총 중량</th>
                                                <th>자체 중량</th>
                                                <th>증명서 번호</th>
                                                <th>수입일</th>
                                                <th>최초 아카이브</th>
                                                <th>신고 번호</th>
                                                <th>상태</th>
                                                <th>국적</th>
                                                <th>주민 번호</th>
                                                <th>소유자 유형</th>
                                                <th>주소 정보</th>
                                                <th>집 전화</th>
                                                <th>직장 전화</th>
                                                <th>휴대폰</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if(ISSET($vehicles))
                                                @foreach($vehicles as $vehicle)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ ISSET($vehicle) ? \Carbon\Carbon::parse($vehicle->start_date)->format("Y-m-d") : "" }}</td>
                                                        @if($isArchive == "on")
                                                            <td>{{ ISSET($vehicle) ? $vehicle->plate_no : "" }}
                                                                @if($vehicle->vehicle_id != "null")
                                                                    <a href="{{ ISSET($vehicle) ? url('/vehicle/'.\App\Http\Controllers\BaseController::getVehiclePlate($vehicle->vehicle_id)) : "#" }}" target="_blank"><i class="ion-ios-car"></i></a>
                                                                @endif
                                                            </td>
                                                        @else
                                                            <td>{{ ISSET($vehicle) ? $vehicle->plate_no : "" }} <a href="{{ ISSET($vehicle) ? url('/vehicle/'.\App\Http\Controllers\BaseController::enc($vehicle->plate_no).'/new/'.($vehicle->id ?? $vehicle->ID ?? $vehicle->Id)) : "#" }}" target="_blank"><i class="ion-ios-car"></i></a></td>
                                                        @endif
                                                        <td>{{ ISSET($vehicle) ? $vehicle->cabin_no : "" }}</td>
                                                        <td>{{ ISSET($vehicle) ? $vehicle->vin_no : "" }}</td>
                                                        <td>{{ ISSET($vehicle) ? \App\Helpers\TranslationHelper::translate($vehicle->country_name ?? "") : "" }}</td>
                                                        <td>{{ ISSET($vehicle) ? \App\Helpers\TranslationHelper::translate($vehicle->mark_name ?? "") : "" }}</td>
                                                        <td>{{ ISSET($vehicle) ? \App\Helpers\TranslationHelper::translate($vehicle->model_name ?? "") : "" }}</td>
                                                        <td>{{ ISSET($vehicle) ? \App\Helpers\TranslationHelper::translate($vehicle->modificace_name ?? "") : "" }}</td>
                                                        <td>{{ ISSET($vehicle) ? \App\Helpers\TranslationHelper::translate($vehicle->color_name ?? "") : "" }}</td>
                                                        <td>{{ ISSET($vehicle) ? $vehicle->build_year : "" }}</td>
                                                        <td>{{ ISSET($vehicle) ? $vehicle->updated_date : "" }}</td>
                                                        <td>{{ ISSET($vehicle) ? $vehicle->start_date : "" }}</td>
                                                        <td>{{ ISSET($vehicle) ? $vehicle->archive_no : "" }}</td>
                                                        <td>{{ ISSET($vehicle) ? ($vehicle->family_name ?? $vehicle->FAMILY_NAME ?? $vehicle->FamilyName ?? "") : "" }}</td>
                                                        <td>{{ ISSET($vehicle) ? ($vehicle->last_name ?? $vehicle->LAST_NAME ?? $vehicle->LastName ?? "") : "" }}</td>
                                                        <td>{{ ISSET($vehicle) ? ($vehicle->first_name ?? $vehicle->FIRST_NAME ?? $vehicle->FirstName ?? "") : "" }}</td>
                                                        <td>{{ ISSET($vehicle) ? $vehicle->engine_capacity : "" }}</td>
                                                        <td>{{ ISSET($vehicle) ? \App\Helpers\TranslationHelper::translate($vehicle->purpose_name ?? "") : "" }}</td>
                                                        <td>{{ ISSET($vehicle) ? \App\Helpers\TranslationHelper::translate($vehicle->vehicle_type_name ?? "") : "" }}</td>
                                                        <td>{{ ISSET($vehicle) ? \App\Helpers\TranslationHelper::translate($vehicle->class_name ?? "") : "" }}</td>
                                                        <td>{{ ISSET($vehicle) ? \App\Helpers\TranslationHelper::translate($vehicle->wheel_name ?? "") : "" }}</td>
                                                        <td>{{ ISSET($vehicle) ? $vehicle->engine_no : "" }}</td>
                                                        <td>{{ ISSET($vehicle) ? \App\Helpers\TranslationHelper::translate($vehicle->fuel_name ?? "") : "" }}</td>
                                                        <td>{{ ISSET($vehicle) ? $vehicle->length : "" }}</td>
                                                        <td>{{ ISSET($vehicle) ? $vehicle->width : "" }}</td>
                                                        <td>{{ ISSET($vehicle) ? $vehicle->height : "" }}</td>
                                                        <td>{{ ISSET($vehicle) ? $vehicle->total_weight : "" }}</td>
                                                        <td>{{ ISSET($vehicle) ? $vehicle->own_weight : "" }}</td>
                                                        <td>{{ ISSET($vehicle) ? $vehicle->certificate_no : "" }}</td>
                                                        <td>{{ ISSET($vehicle) ? \Carbon\Carbon::parse($vehicle->import_date)->format("Y-m-d") : "" }}</td>
                                                        <td>{{ ISSET($vehicle) ? $vehicle->first_archive_no : "" }}</td>
                                                        <td>{{ ISSET($vehicle) ? $vehicle->declaration_no : "" }}</td>
                                                        <td>{{ ISSET($vehicle) ? \App\Helpers\TranslationHelper::translate($vehicle->status_name ?? "") : "" }}</td>
                                                        <td>{{ ISSET($vehicle) ? \App\Helpers\TranslationHelper::translate($vehicle->owner_country_name ?? $vehicle->OWNER_COUNTRY_NAME ?? $vehicle->OwnerCountryName ?? "") : "" }}</td>
                                                        <td>{{ ISSET($vehicle) ? $vehicle->register_no : "" }}</td>
                                                        <td>{{ ISSET($vehicle) ? \App\Helpers\TranslationHelper::translate($vehicle->owner_type_name ?? $vehicle->OWNER_TYPE_NAME ?? $vehicle->OwnerTypeName ?? "") : "" }}</td>
                                                        <td>{{ ISSET($vehicle) ? $vehicle->address_detail : "" }}</td>
                                                        <td>{{ ISSET($vehicle) ? $vehicle->owner_homephone : "" }}</td>
                                                        <td>{{ ISSET($vehicle) ? $vehicle->owner_workphone : "" }}</td>
                                                        <td>{{ ISSET($vehicle) ? $vehicle->owner_cellphone : "" }}</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                @if(ISSET($vehicles))
                                    <div class="outer-div">
                                        <div class="inner-div">
                                            @if(ISSET($total_count)){{ "총 ".$total_count." 건" }}@endif
                                            {{ $vehicles->links( "pagination::bootstrap-4") }}
                                        </div>
                                    </div>
                                @endif
                                <div class="col-lg-12 col-md-12 col-sm-12" style="text-align: center; color: red">
                                    <b>주의사항:</b> 차량 정보를 검색할 때 <b>*</b> 기호를 사용하는 것이 더 효과적입니다.
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12" style="text-align: center; margin-top: 10px;">
                                    예: 8181로 끝나는 모든 시리즈를 검색하려면 8181*, 9로 시작해서 9로 끝나는 번호를 찾으려면 9*9; 차대 번호를 일부만 입력할 때 *4518*, DH89* 등으로 작성합니다. * 기호는 선택 필드를 제외한 모든 필드에서 사용할 수 있습니다.
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                차량 정보
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                소유자 정보
                            </div>
                        </div>
                    </h6>
                    <form id="searchForm" name="searchForm" action="{{ route("search") }}" method="POST" role="search">
                        {{ csrf_field() }}
                        <div class="row">
                            <!--왼쪽 영역 시작-->
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-4 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">차량 번호</label>
                                        <input type="number" id="is_excel_id" name="is_excel" value="0" style="display: none;">
                                        <input type="text" id="excel_columns_id" name="excel_columns" value="" style="display: none;"/>
                                        <input type="text" id="number" name="number" value="{{ isset($plate_no) ? $plate_no : "0373УНГ" }}" class="form-control number" oninput="translate2MGL(this.value)" autocomplete="off">
                                    </div>
                                    <div class="col-lg-4 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">용도</label>
                                        <select id="purpose" name="purpose" class="form-control">
                                            <option label="선택하세요"></option>
                                            @if(ISSET($purposes))
                                                @foreach($purposes as $item)
                                                    <option value="{{ $item->id ?? $item->ID ?? $item->Id }}" {{ isset($purpose) ? (($item->id ?? $item->ID ?? $item->Id) == $purpose ? "selected" : "") : "" }}>{{ \App\Helpers\TranslationHelper::translate($item->name ?? $item->NAME ?? $item->Name ?? "") }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-lg-4 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">핸들 위치</label>
                                        <select id="wheel" name="wheel" class="form-control select2-no-search">
                                            <option label="선택하세요"></option>
                                            @if(ISSET($wheels))
                                                @foreach($wheels as $item)
                                                    <option value="{{ $item->id ?? $item->ID ?? $item->Id }}" {{ isset($wheel) ? (($item->id ?? $item->ID ?? $item->Id) == $wheel ? "selected" : "") : "" }}>{{ \App\Helpers\TranslationHelper::translate($item->name ?? $item->NAME ?? $item->Name ?? "") }}</option>
                                                @endforeach
                                            @endif
                                        </select>

                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-4 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">차대 번호</label>
                                        <input type="text" id="cabinnumber" name="cabinnumber" value="{{ isset($cabin_no) ? $cabin_no : "" }}" class="form-control cabin_no_id" oninput="translate2LATIN(this.value)" autocomplete="off">
                                    </div>
                                    <div class="col-lg-4 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">유형</label>
                                        <select id="type" name="type" class="form-control select2-no-search">
                                            <option label="선택하세요"></option>
                                            @if(ISSET($types))
                                                @foreach($types as $item)
                                                    <option value="{{ $item->id ?? $item->ID ?? $item->Id }}" {{ isset($type) ? (($item->id ?? $item->ID ?? $item->Id) == $type ? "selected" : "") : "" }}>{{ \App\Helpers\TranslationHelper::translate($item->name ?? $item->NAME ?? $item->Name ?? "") }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-lg-4 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">변속기 위치</label>
                                        <select id="transmission" name="transmission" class="form-control select2-no-search">
                                            <option label="선택하세요"></option>
                                            @if(ISSET($geerboxs))
                                                @foreach($geerboxs as $item)
                                                    <option value="{{ $item->id ?? $item->ID ?? $item->Id }}" {{ isset($steering) ? (($item->id ?? $item->ID ?? $item->Id) == $geerbox ? "selected" : "") : "" }}>{{ \App\Helpers\TranslationHelper::translate($item->name ?? $item->NAME ?? $item->Name ?? "") }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-4 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">세관 신고 번호</label>
                                        <input type="text" id="applicationNumber" name="applicationNumber" value="{{ isset($dec) ? $dec : "" }}" class="form-control">
                                    </div>

                                    <div class="col-lg-4 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">증명서 번호</label>
                                        <input type="text" id="certificatenumber" name="certificatenumber" value="{{ isset($certificatenumber) ? $certificatenumber : "" }}" class="form-control">
                                    </div>
                                    <div class="col-lg-4 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">분류</label>
                                        <select id="class" name="class" class="form-control select2-no-search">
                                            <option label="선택하세요"></option>
                                            @if(ISSET($classifications))
                                                @foreach($classifications as $item)
                                                    <option value="{{ $item->id ?? $item->ID ?? $item->Id }}" {{ isset($class) ? (($item->id ?? $item->ID ?? $item->Id) == $class ? "selected" : "") : "" }}>{{ $item->name ?? $item->NAME ?? $item->Name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-4 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">제조국</label>
                                        <select id="factorycountry" name="factorycountry" class="form-control select2" onchange="selectMark(this.value, '')">
                                            <option value="" label="선택하세요"></option>
                                            @if(ISSET($countries))
                                                @foreach($countries as $country)
                                                    <option value="{{ $country->id ?? $country->ID ?? $country->Id }}" {{ isset($factorycountry) ? (($country->id ?? $country->ID ?? $country->Id) == $factorycountry ? "selected" : "") : "" }}>{{ \App\Helpers\TranslationHelper::translate($country->name ?? $country->NAME ?? $country->Name ?? "") }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-lg-4 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">연료 유형</label>
                                        <select id="petroltype" name="petroltype" class="form-control select2-no-search">
                                            <option label="선택하세요"></option>
                                            @if(ISSET($gases))
                                                @foreach($gases as $item)
                                                    <option value="{{ $item->id ?? $item->ID ?? $item->Id }}" {{ isset($gas) ? (($item->id ?? $item->ID ?? $item->Id) == $gas ? "selected" : "") : "" }}>{{ \App\Helpers\TranslationHelper::translate($item->name ?? $item->NAME ?? $item->Name ?? "") }}</option>
                                                @endforeach
                                                    <option value="is_hybrid" {{ isset($gas) ? ("is_hybrid" == $gas ? "selected" : "") : "" }}>Hybrid</option>
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-lg-4 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">차량 상태</label>
                                        <select id="status" name="status" class="form-control select2-no-search">
                                            <option label="선택하세요"></option>
                                            @if(ISSET($statuses))
                                                @foreach($statuses as $item)
                                                    <option value="{{ $item->id ?? $item->ID ?? $item->Id }}" {{ isset($status) ? (($item->id ?? $item->ID ?? $item->Id) == $status ? "selected" : "") : "" }}>{{ \App\Helpers\TranslationHelper::translate($item->name ?? $item->NAME ?? $item->Name ?? "") }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-4 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">제조사</label>
                                        <select id="mark" name="mark" class="form-control select2" onchange="selectModel(this.value, '')">
                                            <option label="선택하세요"></option>
                                        </select>
                                    </div>
                                    <div class="col-lg-2 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">제조년</label>
                                        <input type="text" id="factoryyear" name="factoryyear" value="{{ isset($factoryyear) ? $factoryyear : "" }}" class="form-control">
                                    </div>
                                    <div class="col-lg-2 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">&nbsp;</label>
                                        <input type="text" id="factoryyear2" name="factoryyear2" value="{{ isset($factoryyear2) ? $factoryyear2 : "" }}" class="form-control">
                                    </div>
                                    <div class="col-lg-4 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">아카이브 번호</label>
                                        <input type="text" id="archive" name="archive" value="{{ isset($archive) ? $archive : "" }}" class="form-control">
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-4 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">모델</label>
                                        <select id="model" name="model" class="form-control select2">
                                            <option label="선택하세요"></option>
                                        </select>
                                    </div>
                                    <div class="col-lg-4 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">엔진 번호</label>
                                        <input type="text" id="enginenumber" name="enginenumber" value="{{ isset($enginenumber) ? $enginenumber : "" }}" class="form-control">
                                    </div>
                                    <div class="col-lg-4 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">최초 아카이브</label>
                                        <input type="text" id="firstarchive" name="firstarchive" value="{{ isset($firstarchive) ? $firstarchive : "" }}" class="form-control">
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-4 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">VIN</label>
                                        <input type="text" id="vin" name="vin" value="{{ isset($vin) ? $vin : "" }}" class="form-control">
                                    </div>
									 <div class="col-lg-4 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">상세 모델</label>
                                        <input type="text" id="modificacename" name="modificacename" value="{{ isset($modificacename) ? $modificacename : "" }}" class="form-control">
                                    </div>
                                    <div class="col-lg-4 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">색상</label>
                                        <input type="text" id="color" name="color" value="{{ isset($color) ? $color : "" }}" class="form-control">
                                    </div>
                                    <div class="col-lg-4 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">제한 사항</label>
                                        <select id="restrict" name="restrict" class="form-control select2-no-search">
                                            <option label="선택하세요"></option>
                                            @if(ISSET($limits))
                                                @foreach($limits as $item)
                                                    <option value="{{ $item->id ?? $item->ID ?? $item->Id }}" {{ isset($limit) ? (($item->id ?? $item->ID ?? $item->Id) == $limit ? "selected" : "") : "" }}>{{ \App\Helpers\TranslationHelper::translate($item->name ?? $item->NAME ?? $item->Name ?? "") }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!--왼쪽 영역 끝-->
                            <!--오른쪽 영역 시작-->
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-4 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">기본 국적</label>
                                        <select id="region" name="region" class="form-control select2">
                                            <option label="선택하세요"></option>
                                            @if(ISSET($countries))
                                                @foreach($countries as $item)
                                                    <option value="{{ $item->id ?? $item->ID ?? $item->Id }}" {{ isset($region) ? (($item->id ?? $item->ID ?? $item->Id) == $region ? "selected" : "") : "" }}{{ isset($region) ? (($item->id ?? $item->ID ?? $item->Id) == $region ? "selected" : "") : "" }}>{{ \App\Helpers\TranslationHelper::translate($item->name ?? $item->NAME ?? $item->Name ?? "") }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-lg-4 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">구/군</label>
                                        <select id="district" name="district" class="form-control select2" onchange="districtHTML(this.value, 'commission', 'commission', '')">
                                            <option label="선택하세요"></option>
                                            @if(ISSET($districts))
                                                @foreach($districts as $item)
                                                    <option value="{{ $item->id }}" {{ isset($district) ? ($item->id == $district ? "selected" : "") : "" }}>{{ \App\Helpers\TranslationHelper::translate($item->name ?? "") }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-lg-2 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">소유일</label>
                                        <input type="text" id="ownerdate" name="ownerdate" onchange="dateRange('ownerdate2', this.value)" class="form-control" autocomplete="off">
                                    </div>
                                    <div class="col-lg-2 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">&nbsp;</label>
                                        <input type="text" id="ownerdate2" name="ownerdate2" class="form-control" autocomplete="off">
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-4 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">유형</label>
                                        <select id="ownertype" name="ownertype" class="form-control select2-no-search">
                                            <option label="선택하세요"></option>
                                            @if(ISSET($owner_types))
                                                @foreach($owner_types as $item)
                                                    <option value="{{ $item->id }}" {{ isset($owner_type) ? ($item->id == $owner_type ? "selected" : "") : "" }}>{{ \App\Helpers\TranslationHelper::translate($item->name ?? "") }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-lg-4 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">동/읍/면</label>
                                        <select id="commission" name="commission" class="form-control select2" onchange="districtHTML(this.value, 'town', 'town', '')">
                                            <option label="선택하세요"></option>
                                        </select>
                                    </div>
                                    <div class="col-lg-4 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">연령</label>
                                        <input type="text" id="age" name="age" class="form-control">
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-4 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">주민 번호</label>
                                        <input type="text" id="registernumber" name="registernumber" value="{{ isset($register) ? $register : "" }}" oninput="translate2MGL_Register(this.value)" autocomplete="off" class="form-control">
                                    </div>
                                    <div class="col-lg-4 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">단지/구역</label>
                                        <select id="town" name="town" class="form-control select2-no-search">
                                            <option label="선택하세요"></option>
                                        </select>
                                    </div>
                                    <div class="col-lg-4 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">성별</label>
                                        <select id="gender" name="gender" class="form-control select2-no-search">
                                            <option label="선택하세요"></option>
                                            <option value="1" {{ isset($gender) ? ($gender == 1 ? "selected" : "") : "" }}>남성</option>
                                            <option value="2" {{ isset($gender) ? ($gender == 2 ? "selected" : "") : "" }}>여성</option>
                                            <option value="3" {{ isset($gender) ? ($gender == 3 ? "selected" : "") : "" }}>기타</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-4 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">부모 성명</label>
                                        <input type="text" id="parent" name="parent" value="{{ isset($parent) ? $parent : "" }}" class="form-control">
                                    </div>
                                    <div class="col-lg-4 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">거리</label>
                                        <input type="text" id="street" name="street" value="{{ isset($street) ? $street : "" }}" class="form-control">
                                    </div>
                                    <div class="col-lg-4 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">집 전화</label>
                                        <input type="text" id="homephone" name="homephone" value="{{ isset($homephone) ? $homephone : "" }}" class="form-control">
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-4 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">본인 이름</label>
                                        <input type="text" id="surname" name="surname" value="{{ isset($surname) ? $surname : "" }}" class="form-control">
                                    </div>
                                    <div class="col-lg-4 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">건물/아파트</label>
                                        <input type="text" id="apartment" name="apartment" class="form-control" value="{{ isset($apartment) ? $apartment : "" }}">
                                    </div>
                                    <div class="col-lg-4 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">휴대폰</label>
                                        <input type="text" id="mobile" name="mobile" value="{{ isset($mobile) ? $mobile : "" }}" class="form-control">
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-4 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">도시/도</label>
                                        <select id="province" name="province" class="form-control select2-no-search" onchange="districtHTML(this.value, 'district', 'district', '')">
                                            <option label="선택하세요"></option>
                                            @if(ISSET($provinces))
                                                @foreach($provinces as $item)
                                                    <option value="{{ $item->id }}" {{ isset($province) ? ($item->id == $province ? "selected" : "") : "" }}>{{ $item->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-lg-4 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">호수</label>
                                        <input type="text" id="door" name="door" value="{{ isset($door) ? $door : "" }}" class="form-control">
                                    </div>
                                    <div class="col-lg-4 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">직장 전화</label>
                                        <input type="text" id="workphone" name="workphone" value="{{ isset($workphone) ? $workphone : "" }}" class="form-control">
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-2 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">수입일</label>
                                        <input type="text" id="importdate" name="importdate" onchange="dateRange('importdate2', this.value)" class="form-control" autocomplete="off">
                                    </div>
                                    <div class="col-lg-2 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">&nbsp;</label>
                                        <input type="text" id="importdate2" name="importdate2" class="form-control" autocomplete="off">
                                    </div>
                                    <div class="col-lg-2 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">배기량</label>
                                        <input type="text" id="enginecapacity" name="enginecapacity" value="{{ isset($enginecapacity) ? $enginecapacity : "" }}" class="form-control">
                                    </div>
                                    <div class="col-lg-2 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">&nbsp;</label>
                                        <input type="text" id="enginecapacity2" name="enginecapacity2" value="{{ isset($enginecapacity2) ? $enginecapacity2 : "" }}" class="form-control">
                                    </div>
                                    <div class="col-lg-2 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">변경일</label>
                                        <input type="text" id="modifieddate" name="modifieddate" value="{{ isset($modifieddate) ? $modifieddate : "" }}" onchange="dateRange('modifieddate2', this.value)" class="form-control" autocomplete="off">
                                    </div>
                                    <div class="col-lg-2 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">&nbsp;</label>
                                        <input type="text" id="modifieddate2" name="modifieddate2" value="{{ isset($modifieddate2) ? $modifieddate2 : "" }}" class="form-control" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <!--오른쪽 영역 끝-->
                        </div>
                        <hr class="mg-y-10">
                        <div class="row">
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <a href="{{ url("/vehicle/search/reference") }}" target="_blank" class="btn btn-primary btn-block">조회서 발급</a>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <a id="customview" class="btn btn-primary btn-block" style="background-color: #1bb620; border-color: #1bb620;color:#fff;">조회서 옵션 선택</a>
                            </div>
                            <div class="col-lg-5 col-md-12 col-sm-12">
                                <label class="ckbox">
                                    <input type="checkbox" name="isArchive" {{ $isArchive == "on" ? "checked" : "" }}><span>아카이브에서 검색</span>
                                </label>
                            </div>
                            <div class="col-lg-2 col-md-6 col-sm-6">
                                <button type="submit" id="searchButton" class="btn btn-primary btn-block">검색</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!--왼쪽 영역 끝-->
            </div>
            </br>
            <form name="searchCustomForm" action="{{ route("custom_ref") }}" method="POST" target="_blank">
                {{ csrf_field() }}
                <div class="row row-sm customview" style="display: none;">
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="flexcroll" style=" height: 300px !important; overflow-y: scroll; ">
                            <div class="col">
                                <label class="ckbox">
                                    <input type="checkbox" class="checkboxlist" name="ehelsenognoo"><span>시작일</span>
                                </label>
                            </div>
                            <div class="col">
                                <label class="ckbox">
                                    <input type="checkbox" class="checkboxlist" name="ulsiindugaar"><span>차량 번호</span>
                                </label>
                            </div>
                            <div class="col">
                                <label class="ckbox">
                                    <input type="checkbox" class="checkboxlist" name="arliindugaar"><span>차대 번호</span>
                                </label>
                            </div>
                            <div class="col">
                                <label class="ckbox">
                                    <input type="checkbox" class="checkboxlist" name="vin"><span>VIN 번호</span>
                                </label>
                            </div>
                            <div class="col">
                                <label class="ckbox">
                                    <input type="checkbox" class="checkboxlist" name="factory"><span>제조국</span>
                                </label>
                            </div>
                            <div class="col">
                                <label class="ckbox">
                                    <input type="checkbox" class="checkboxlist" name="mark"><span>제조사</span>
                                </label>
                            </div>
                            <div class="col">
                                <label class="ckbox">
                                    <input type="checkbox" class="checkboxlist" name="model"><span>모델</span>
                                </label>
                            <div class="col">
                                <label class="ckbox">
                                    <input type="checkbox" class="checkboxlist" name="modificacename"><span>상세 모델</span>
                                </label>
                            </div>
                            <div class="col">
                                <label class="ckbox">
                                    <input type="checkbox" class="checkboxlist" name="color"><span>색상</span>
                                </label>
                            </div>
                            <div class="col">
                                <label class="ckbox">
                                    <input type="checkbox" class="checkboxlist" name="uildverlesenognoo"><span>제조일</span>
                                </label>
                            </div>
                            <div class="col">
                                <label class="ckbox">
                                    <input type="checkbox" class="checkboxlist" name="uurchilsunognoo"><span>변경일</span>
                                </label>
                            </div>
                            <div class="col">
                                <label class="ckbox">
                                    <input type="checkbox" class="checkboxlist" name="anhniiarchive"><span>최초 아카이브</span>
                                </label>
                            </div>
                            <div class="col">
                                <label class="ckbox">
                                    <input type="checkbox" class="checkboxlist" name="bagtaamj"><span>배기량</span>
                                </label>
                            </div>
                            <div class="col">
                                <label class="ckbox">
                                    <input type="checkbox" class="checkboxlist" name="zoriulalt"><span>용도</span>
                                </label>
                            </div>
                            <div class="col">
                                <label class="ckbox">
                                    <input type="checkbox" class="checkboxlist" name="turul"><span>유형</span>
                                </label>
                            </div>
                            <div class="col">
                                <label class="ckbox">
                                    <input type="checkbox" class="checkboxlist" name="angilal"><span>분류</span>
                                </label>
                            </div>
                            <div class="col">
                                <label class="ckbox">
                                    <input type="checkbox" class="checkboxlist" name="hurd"><span>핸들 위치</span>
                                </label>
                            </div>
                            <div class="col">
                                <label class="ckbox">
                                    <input type="checkbox" class="checkboxlist" name="hairtsag"><span>변속기</span>
                                </label>
                            </div>
                            <div class="col">
                                <label class="ckbox">
                                    <input type="checkbox" class="checkboxlist" name="motor"><span>엔진 번호</span>
                                </label>
                            </div>
                            <div class="col">
                                <label class="ckbox">
                                    <input type="checkbox" class="checkboxlist" name="gasoline"><span>연료 유형</span>
                                </label>
                            </div>
                            <div class="col">
                                <label class="ckbox">
                                    <input type="checkbox" class="checkboxlist" name="urt"><span>길이</span>
                                </label>
                            </div>
                            <div class="col">
                                <label class="ckbox">
                                    <input type="checkbox" class="checkboxlist" name="urgun"><span>너비</span>
                                </label>
                            </div>
                            <div class="col">
                                <label class="ckbox">
                                    <input type="checkbox" class="checkboxlist" name="undur"><span>높이</span>
                                </label>
                            </div>
                            <div class="col">
                                <label class="ckbox">
                                    <input type="checkbox" class="checkboxlist" name="buhjin"><span>총 중량</span>
                                </label>
                            </div>
                            <div class="col">
                                <label class="ckbox">
                                    <input type="checkbox" class="checkboxlist" name="uuriinjin"><span>자체 중량</span>
                                </label>
                            </div>
                            <div class="col">
                                <label class="ckbox">
                                    <input type="checkbox" class="checkboxlist" name="gerchilgee"><span>증명서 번호</span>
                                </label>
                            </div>
                            <div class="col">
                                <label class="ckbox">
                                    <input type="checkbox" class="checkboxlist" name="oruuljirsen"><span>임포트일</span>
                                </label>
                            </div>
                            <div class="col">
                                <label class="ckbox">
                                    <input type="checkbox" class="checkboxlist" name="archivedugaar"><span>아카이브 번호</span>
                                </label>
                            </div>
                            <div class="col">
                                <label class="ckbox">
                                    <input type="checkbox" class="checkboxlist" name="meduulgiindugaar"><span>세관 신고 번호</span>
                                </label>
                            </div>
                            <div class="col">
                                <label class="ckbox">
                                    <input type="checkbox" class="checkboxlist" name="teevriinheregselturul"><span>차량 상태</span>
                                </label>
                            </div>
                            <div class="col">
                                <label class="ckbox">
                                    <input type="checkbox" class="checkboxlist" name="uls"><span>국적</span>
                                </label>
                            </div>
                            <div class="col">
                                <label class="ckbox">
                                    <input type="checkbox" class="checkboxlist" name="registernumber"><span>주민 번호</span>
                                </label>
                            </div>
                            <div class="col">
                                <label class="ckbox">
                                    <input type="checkbox" class="checkboxlist" name="urgiinovog"><span>성</span>
                                </label>
                            </div>
                            <div class="col">
                                <label class="ckbox">
                                    <input type="checkbox" class="checkboxlist" name="estegekh"><span>부모 성명</span>
                                </label>
                            </div>
                            <div class="col">
                                <label class="ckbox">
                                    <input type="checkbox" class="checkboxlist" name="uuriinner"><span>본인 이름</span>
                                </label>
                            </div>
                            <div class="col">
                                <label class="ckbox">
                                    <input type="checkbox" class="checkboxlist" name="aimag"><span>도시/도</span>
                                </label>
                            </div>
                            <div class="col">
                                <label class="ckbox">
                                    <input type="checkbox" class="checkboxlist" name="duureg"><span>구/군</span>
                                </label>
                            </div>
                            <div class="col">
                                <label class="ckbox">
                                    <input type="checkbox" class="checkboxlist" name="baghoroo"><span>동/읍/면</span>
                                </label>
                            </div>
                            <div class="col">
                                <label class="ckbox">
                                    <input type="checkbox" class="checkboxlist" name="horoolol"><span>단지/구역</span>
                                </label>
                            </div>
                            <div class="col">
                                <label class="ckbox">
                                    <input type="checkbox" class="checkboxlist" name="gudamj"><span>거리</span>
                                </label>
                            </div>
                            <div class="col">
                                <label class="ckbox">
                                    <input type="checkbox" class="checkboxlist" name="bair"><span>건물/아파트</span>
                                </label>
                            </div>
                            <div class="col">
                                <label class="ckbox">
                                    <input type="checkbox" class="checkboxlist" name="haalga"><span>호수</span>
                                </label>
                            </div>
                            <div class="col">
                                <label class="ckbox">
                                    <input type="checkbox" class="checkboxlist" name="geriinutas"><span>집 전화</span>
                                </label>
                            </div>
                            <div class="col">
                                <label class="ckbox">
                                    <input type="checkbox" class="checkboxlist" name="ajiliinutas"><span>직장 전화</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="row row-xs align-items-center mg-b-5" style="{{ isset($user) ? "display:none;":""}}">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <textarea name="title" class="form-control" placeholder="제목 입력" style="height: 100px !important;"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <button class="btn btn-primary btn-block" style="background-color: #1bb620; border-color: #1bb620;">조회서 발급</button>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <button type="button" onclick="exportToExcel();" class="btn btn-info btn-block">조회서 EXCEL 다운로드</button>
                    </div>
                </div>
            </form>
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
<script src="{{ asset('lib/jQuery-Mask-Plugin-master/src/jquery.mask.js') }}"></script>
<script src="{{ asset('js/vrs.js') }}"></script>
<script src="{{ asset('js/avtoteever.js') }}"></script>
<script>
    $(function(){
        'use strict'

        $(document).keydown(function(event) {
            if (event.keyCode == 27) {
                window.location.href = "{{ url('/search') }}";
                return false;
            }
        });

        $('#searchForm').keydown(function(event) {
            if (event.keyCode == 13) {
                $(".containerBody").fadeOut();
                $(".avtoteeverPreloader").fadeIn();
                $("#is_excel_id").val(0);
                $("#searchForm").removeAttr("target");
                $("#searchForm").submit();
                return false;
            }
        });

        $('.select2').select2({
            placeholder: '선택하세요'
        });

        $( "#modifieddate" ).datepicker({
            changeMonth: true,
            changeYear: true
        });
        $( "#modifieddate" ).datepicker( "option", "dateFormat", "yy-mm-dd" );

        //일자 шүүлтүүр 2-р багана
        $( "#modifieddate2" ).datepicker({
            changeMonth: true,
            changeYear: true
        });
        $( "#modifieddate2" ).datepicker( "option", "dateFormat", "yy-mm-dd" );

        $( "#importdate" ).datepicker({
            changeMonth: true,
            changeYear: true
        });
        $( "#importdate" ).datepicker( "option", "dateFormat", "yy-mm-dd" );

        $( "#importdate2" ).datepicker({
            changeMonth: true,
            changeYear: true
        });
        $( "#importdate2" ).datepicker( "option", "dateFormat", "yy-mm-dd" );

        $( "#ownerdate" ).datepicker({
            changeMonth: true,
            changeYear: true
        });
        $( "#ownerdate" ).datepicker( "option", "dateFormat", "yy-mm-dd" );

        $( "#ownerdate2" ).datepicker({
            changeMonth: true,
            changeYear: true
        });
        $( "#ownerdate2" ).datepicker( "option", "dateFormat", "yy-mm-dd" );

        $('#searchResult').DataTable({
            responsive: false,
            aLengthMenu: [1200],
            paging: false,
            language: {
                searchPlaceholder: '검색...',
                sSearch: '',
                lengthMenu: '_MENU_ 페이지당 표시',
            }
        });

        $('#searchResult tbody').on( 'click', 'tr', function () {
            if ( $(this).hasClass('selected') ) {
                $(this).removeClass('selected');
            }
            else {
                $('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        } );

        $('input.number').on('keyup', function() {
            limitText(this, 7)
        });

        $('#number').keyup(function(){
            this.value = this.value.toUpperCase();
        });

        $('.cabin_no_id').on('keyup', function() {
            limitText(this, 17)
        });

        $('#archive').keyup(function(){
            this.value = this.value.toUpperCase();
        });
        $('#firstarchive').keyup(function(){
            this.value = this.value.toUpperCase();
        });
        $('#registernumber').keyup(function(){
            this.value = this.value.toUpperCase();
        });
        $('#registernumber').on('keyup', function() {
            limitText(this, 12)
        });
        $('#surname').keyup(function(){
            this.value = this.value.toUpperCase();
        });
        $('#parent').keyup(function(){
            $(this).val($(this).val().substr(0, 1).toUpperCase() + $(this).val().substr(1).toLowerCase());
        });

        $('#certificatenumber').keyup(function(){
            this.value = this.value.toUpperCase();
        });

        $( "#customview" ).click(function() {
            $( ".customview" ).toggle();
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

        $('#searchButton').on('click', function(e){
            $("#is_excel_id").val(0);
            $("#searchForm").removeAttr("target");
            $(".containerBody").fadeOut();
            $(".avtoteeverPreloader").fadeIn();
        });

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

    function districtHTML(location, id, type, selected) {
        $.ajax({
            type: "POST",
            url: vrsUrl('/api/location'),
            data: {"location": location, "type": type, "selected": selected},
            success: function( response ) {
                $("#"+id).html(response);
            }
        })
    }

    function selectModel(type, selected) {
        $.ajax({
            type: "POST",
            url: vrsUrl('/api/carmodel'),
            data: {"type": type, "selected": selected},
            success: function( response ) {
                $("#model").html(response);
            }
        })
    }

    function selectMark(country, selected) {
        $.ajax({
            type: "POST",
            url: vrsUrl('/api/carmark'),
            data: {"country": country, "selected": selected},
            success: function( response ) {
                $("#mark").html(response);
            }
        })
    }

    function exportToExcel() {
        var checkboxes = document.getElementsByClassName('checkboxlist');
        var selected = [];
        for (var i=0; i<checkboxes.length; i++) {
            if (checkboxes[i].checked) {
                selected.push(checkboxes[i].name);
            }
        }

        if(selected.length > 0){
            $("#searchForm").attr("target", "_blank");
            $("#is_excel_id").val(1);
            $("#excel_columns_id").val(selected.toString());
            $("#searchForm").submit();
            $("#searchForm").removeAttr("target");
        } else {
            alert("Excel 파일로 내보낼 필드를 선택하세요!");
        }
    }

    $( document ).ready(function() {

        $(".avtoteeverPreloader").fadeOut();
        $(".containerBody").fadeIn();
        @if(ISSET($importdate))
$( "#importdate" ).val('{{ $importdate }}');
        @endif

        @if(ISSET($importdate2))
$( "#importdate2" ).val('{{ $importdate2 }}');
        @endif

         @if(ISSET($modifieddate))
$( "#modifieddate" ).val('{{ $modifieddate }}');
        @endif

        @if(ISSET($modifieddate2))
$( "#modifieddate2" ).val('{{ $modifieddate2 }}');
        @endif

        @if(ISSET($ownerdate))
$( "#ownerdate" ).val('{{ $ownerdate }}');
        @endif

        @if(ISSET($ownerdate2))
$( "#ownerdate2" ).val('{{ $ownerdate2 }}');
        @endif

@if(ISSET($factorycountry))
selectMark({{ $factorycountry }}, {{ $mark }});
        @endif

        @if(ISSET($mark))
selectModel({{ $mark }}, {{ $model }});
        @endif

        @if(ISSET($province))
$("#province").val("{{ $province }}").change();
        @endif

        @if(ISSET($district))
districtHTML({{ $province }}, "district", "district", {{ $district }});
        $("#district").change();
        @endif
        @if(ISSET($commission))
districtHTML({{ $district }}, "commission", "commission", {{ $commission }});
        $("#commission").change();
        @endif
        @if(ISSET($town))
districtHTML({{ $commission }}, "town", "town", {{ $town }});
        @endif
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
        "Т": "m" ,
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

    function translate2MGL(word){
        if(word){
            word = word.toUpperCase();
        }
        word =  word.split('').map(function (char) {
            return Lat2Cyr[char] || char;
        }).join("");

        $("#number").val(word);
    }

    function translate2MGL_Register(word){
        if(word){
            word = word.toUpperCase();
        }
        word =  word.split('').map(function (char) {
            return Lat2Cyr[char] || char;
        }).join("");

        $("#registernumber").val(word);
    }

    function translate2LATIN(word){
        if(word){
            word = word.toUpperCase();
        }
        word =  word.split('').map(function (char) {
            return Cyr2Lat[char] || char;
        }).join("");
        $("#cabinnumber").val(word);
    }

    function dateRange(id, value){
        $( "#" + id ).val(value);
    }
</script>
</div>
</body>
</html>
