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
               
                <div class="col-lg-12 col-md-12 col-sm-12">
                    {{-- {{var_dump($owner)}} --}}
                    <div class="row">
                        <div class="card-title col-lg-7 col-md-6 col-sm-12">
                            {{ isset($owner) ? "소유자 수정" : "신규 소유자 등록" }}
                        </div>
                        <div id="headerButton" class="col-lg-5 col-md-6 col-sm-12 rightAlign">
                            <a href="/reference/owner"><span id="btnPrint" class="headerButton"><i class="icon ion-ios-paper headerButtonIcon"></i> 소유자 목록</span></a>
                        </div>
                    </div>
                    <form action="{{ route("createowner") }}" method="POST">
                        {{ csrf_field() }}
                        <div class="row">
                            <!--왼쪽 영역 시작-->
                            <div class="col-lg-6 col-md-6 col-sm-12">
                              
                                <input type="text" name="env" style="display: none;" value="{{ isset($owner) ? \App\Http\Controllers\BaseController::enc($owner->id) : "" }}" class="form-control">
                                @if(ISSET($message) || session()->has("message"))
                                    @include("System.message")
                                @endif
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0 required-input">국적/거주지</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <select id="location" name="location" required class="form-control select2-no-search">
                                            @if(ISSET($countries))
                                                @foreach($countries as $country)
                                                    <option value="{{ $country->id }}" {{ isset($owner) ? ($country->id == $owner->country_id ? "selected" : "") : "" }}>{{ $country->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0 required-input">유형</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <select id="type" name="type" required class="form-control form-control select2-no-search" required>
                                            <option label="선택하세요"></option>
                                            @if(ISSET($types))
                                                @foreach($types as $type)
                                                    <option value="{{ $type->id }}" {{ isset($owner) ? ($type->id == $owner->owner_type_id ? "selected" : "") : "" }}>{{ $type->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0 required-input">주민번호/사업자번호</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <input type="text" id="register" required name="register" value="{{ isset($owner) ? $owner->register_no : "" }}" autocomplete="off" class="form-control">
                                        {{-- <input type="text" id="register" required name="register" value="{{ isset($owner) ? $owner->register_no : "" }}" oninput="translate2MGL(this.value)" autocomplete="off" class="form-control"> --}}
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">성씨</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <input type="text" id="familyname" name="familyname" value="{{ isset($owner) ? $owner->family_name : "" }}" class="form-control">
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0 required-input">부/모 성명</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <input type="text" id="parent" name="parent" value="{{ isset($owner) ? $owner->last_name : "" }}" class="form-control">
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0 required-input">이름</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <input type="text" id="surname" required name="surname" value="{{ isset($owner) ? $owner->first_name : "" }}" class="form-control">
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0 required-input">성별</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <select id="gender" name="gender" required class="form-control form-control select2-no-search">
                                            <option value="1" {{ isset($owner) ? (1 == $owner->gender ? "selected" : "") : "" }}>남성</option>
                                            <option value="2" {{ isset($owner) ? (2 == $owner->gender ? "selected" : "") : "" }}>여성</option>
                                            <option value="3" {{ isset($owner) ? (3 == $owner->gender ? "selected" : "") : "" }}>기타</option>
                                        </select>
                                    </div>
                                </div>
                            
                            </div>
                            <!--왼쪽 영역 끝-->
                            <!--오른쪽 영역 시작-->
                          
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                {{-- <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">거리</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <input type="text" id="street" name="street" value="{{ isset($owner) ? $owner->street : "" }}" class="form-control">
                                    </div>
                                </div> --}}
                                {{-- <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">건물</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <input type="text" id="apartment" name="apartment" value="{{ isset($owner) ? $owner->apartment_no : "" }}" class="form-control">
                                    </div>
                                </div> --}}
                                {{-- <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0 required-input">문</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <input type="text" id="door" name="door" value="{{ isset($owner) ? $owner->door_no : "" }}" class="form-control">
                                    </div>
                                </div> --}}
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0 required-input">시/도</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <select id="province" name="province" required class="form-control form-control select2" onchange="districtHTML(this.value, 'district', 'district', '')">
                                            <option label="선택하세요"></option>
                                            @if(ISSET($provinces))
                                                @foreach($provinces as $province)
                                                    <option value="{{ $province->id }}" >{{ $province->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0 required-input">군/구</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <select id="district" name="district" required class="form-control form-control select2" onchange="districtHTML(this.value, 'commission', 'commission', '')">

                                        </select>
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">읍/면/리/동</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <select id="commission" name="commission" required class="form-control form-control select2" onchange="districtHTML(this.value, 'town', 'town', '')">

                                        </select>
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-5 col-md-12 col-sm-12">
                                        <label  class="form-label mg-b-0">상세 주소 정보</label>
                                    </div>
                                    <div class="col-lg-7 col-md-12 col-sm-12">
                                    <strong style=" color: darkred; font-size: 12px;" id="addresDiv">{{ isset($addressDet) ? $addressDet : "" }}</strong>
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0 required-input">아파트/거리/동/호수</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        {{-- <select id="town" name="town" class="form-control form-control select2">

                                        </select> --}}
                                        <input type="text" id="town_own" required name="town" value="{{ isset($address) ? $address : "" }}" class="form-control" >
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0 required-input">휴대폰</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <input type="text" id="cellphone" required name="cellphone" value="{{ isset($owner) ? $owner->cellphone : "" }}" class="form-control">
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">집 전화번호</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <input type="text" id="homephone" name="homephone" value="{{ isset($owner) ? $owner->homephone : "" }}" class="form-control">
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">직장 전화번호</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <input type="text" id="workphone" name="workphone" value="{{ isset($owner) ? $owner->workphone : "" }}" class="form-control">
                                    </div>
                                </div> 
                                {{-- <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">우편번호</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <input type="text" id="zipcode" name="zipcode" value="{{ isset($owner) ? $owner->zip : "" }}" class="form-control">
                                    </div>
                                </div>  --}}
                                {{-- <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">특기 사항</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <input type="text" id="specialnote" name="specialnote" value="{{ isset($owner) ? $owner->more_info : "" }}" class="form-control">
                                    </div>
                                </div> --}}

                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">1일 번호 주문 수량</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <input type="number" id="max_order_qty" name="orderQty" value="3" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <!--오른쪽 영역 끝-->
                        </div>
                        <hr class="mg-y-10">
                        <div class="row">
                            <div class="col-lg-10 col-md-6 col-sm-6"></div>
                            <div class="col-lg-2 col-md-6 col-sm-6">
                                <button type="submit" class="btn btn-primary btn-block">{{ isset($owner) ? "수정" : "등록" }}</button>
                            </div>
                            {{--<div class="col-lg-2 col-md-6 col-sm-6">--}}
                            {{--<button class="btn btn-outline-primary btn-block">확인</button>--}}
                            {{--</div>--}}
                        </div>
                    </form>
                </div>
                <!--왼쪽 영역 끝-->
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

        $('#register').keyup(function(){
            this.value = this.value.toUpperCase();
        });

        $('#register').on('keyup', function() {
            limitText(this, 13)
        });

        $('#surname').keyup(function(){
            this.value = this.value.toUpperCase();
        });

         $('#familyname').keyup(function(){
             $(this).val($(this).val().substr(0, 1).toUpperCase() + $(this).val().substr(1).toLowerCase());
        });

        $('#parent').keyup(function(){
            var result = $(this).val().split("-");
            if(result.length == 1){
                $(this).val(result[0].substr(0, 1).toUpperCase() + result[0].substr(1).toLowerCase());
            } else {
                $(this).val(result[0].substr(0, 1).toUpperCase() + result[0].substr(1).toLowerCase()+"-"+result[1].substr(0, 1).toUpperCase() + result[1].substr(1).toLowerCase());
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
        $("#register").val(word);
    }
    function districtHTML(location, id, type, selected) {
        $.ajax({
            type: "POST",
            url: '/api/location',
            data: {"location": location, "type": type, "selected": selected},
            success: function( response ) {
               // console.log(response);
                $("#"+id).html(response);
            }
        })
    }
    $( document ).ready(function() {
       // console.log($province_id);
        @if(ISSET($province_id))
            $("#province").val("{{ $province_id }}").change();
            @if(ISSET($district_id))
                districtHTML({{ $province_id }}, "district", "district", {{ $owner->district_id }});
                $("#district").change();
                @if(ISSET($owner->devision_unit_id))
                    districtHTML({{ $district_id }}, "commission", "commission", {{ $owner->devision_unit_id }});
                    $("#commission").change();
                    @if(ISSET($owner->micro_district_id))
                        districtHTML({{ $owner->devision_unit_id }}, "town", "town", {{ $owner->micro_district_id }});
                    @endif
                @endif
            @endif
        @endif 
        @if(!isset($owner))
            $("#location option:contains(몽골)").prop('selected', true).change();
        @endif
    });
    $(document).ready(function () {
        $(".avtoteeverPreloader").fadeOut();
        $(".containerBody").fadeIn();
    });
</script>
</div>
</body>
</html>
