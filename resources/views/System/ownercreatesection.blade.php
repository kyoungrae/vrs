<div class="col-lg-12 col-md-12 col-sm-12">
    <div class="avtoteeverPreloader"></div>
    <div class="row">
        <!--왼쪽 영역 시작-->
        <div class="col-lg-4 col-md-6 col-sm-12">
            {{--<input type="text" name="env" style="display: none;" value="{{ isset($owner) ? \App\Http\Controllers\BaseController::enc($owner->id) : "" }}" class="form-control">--}}
            <div class="row row-xs align-items-center mg-b-5">
                <div class="col-lg-5 col-md-12 col-sm-12">
                    <label class="form-label mg-b-0 required-input">기본 소속</label>
                </div>
                <div class="col-lg-7 col-md-12 col-sm-12">
                    <select id="location_own" name="location" required class="form-control select2-no-search">
                        @if(ISSET($countries)) 
                            @foreach($countries as $country)
                                <option value="{{ $country->id ?? $country->ID ?? $country->Id }}">{{ $country->name ?? $country->NAME ?? $country->Name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="row row-xs align-items-center mg-b-5">
                <div class="col-lg-5 col-md-12 col-sm-12">
                    <label class="form-label mg-b-0 required-input">유형</label>
                </div>
                <div class="col-lg-7 col-md-12 col-sm-12">
                    <select id="type_own" name="type" required class="form-control form-control select2-no-search" required>
                        <option label="선택하세요"></option>
                        @if(ISSET($types))
                            @foreach($types as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        @endif
                    </select> 
                </div>
            </div>
            <div class="row row-xs align-items-center mg-b-5">
                <div class="col-lg-5 col-md-12 col-sm-12">
                    <label class="form-label mg-b-0 required-input">등록 번호</label>
                </div>
                <div class="col-lg-7 col-md-12 col-sm-12">
                    <input type="text" id="register_own" name="register" value="" autocomplete="off" class="form-control">
                    {{-- <input type="text" id="register_own" name="register" value="" oninput="translate2MGL_Register(this.value)" autocomplete="off" class="form-control"> --}}
                </div>
            </div>
            <div class="row row-xs align-items-center mg-b-5">
                <div class="col-lg-5 col-md-12 col-sm-12">
                    <label id="dep_div" style="display: none;" class="form-label mg-b-0">지점</label>
                </div>
                <div class="col-lg-7 col-md-12 col-sm-12">
                    <select id="company_dep" name="company_dep" style="display: none" onchange="selectDepartment(this.value);" class="form-control form-control select2">

                    </select>
                </div>
            </div>
            <div class="row row-xs align-items-center mg-b-5">
                <div class="col-lg-5 col-md-12 col-sm-12">
                    <label class="form-label mg-b-0">성씨</label>
                </div>
                <div class="col-lg-7 col-md-12 col-sm-12">
                    <input type="text" id="familyname_own" name="familyname" value="" class="form-control">
                </div>
            </div>
            <div class="row row-xs align-items-center mg-b-5">
                <div class="col-lg-5 col-md-12 col-sm-12">
                    <label class="form-label mg-b-0 required-input">부모 이름</label>
                </div>
                <div class="col-lg-7 col-md-12 col-sm-12">
                    <input type="text" id="parent_own" name="parent" value="" class="form-control">
                </div>
            </div>
            <div class="row row-xs align-items-center mg-b-5">
                <div class="col-lg-5 col-md-12 col-sm-12">
                    <label class="form-label mg-b-0 required-input">본인 이름</label>
                </div>
                <div class="col-lg-7 col-md-12 col-sm-12">
                    <input type="text" id="surname_own" name="surname" value="" class="form-control">
                </div>
            </div>
            <div class="row row-xs align-items-center mg-b-5">
                <div class="col-lg-5 col-md-12 col-sm-12">
                    <label class="form-label mg-b-0">성별</label>
                </div>
                <div class="col-lg-7 col-md-12 col-sm-12">
                    <select id="gender_own" name="gender" class="form-control form-control select2-no-search">
                        <option value="1">남성</option>
                        <option value="2">여성</option>
                        <option value="3">기타</option>
                    </select>
                </div>
            </div>
        
        </div>
        <!--왼쪽 영역 끝-->
        <!--오른쪽 영역 시작-->
        <div class="col-lg-4 col-md-6 col-sm-12">
           
            <div class="row row-xs align-items-center mg-b-5">
                <div class="col-lg-5 col-md-12 col-sm-12">
                    <label class="form-label mg-b-0 required-input">도/시</label>
                </div>
                <div class="col-lg-7 col-md-12 col-sm-12">
                    <select id="province_own"  name="province" class="form-control form-control select2"  onchange="districtHTML(this.value, 'district_own', 'district', '')">
                        @if(ISSET($provinces))
                            @foreach($provinces as $province)
                    
                            <option value="{{ $province->id ?? $province->ID ?? $province->Id  }}">{{ $province->name ?? $province->NAME ?? $province->Name }}</option>
                   
                             
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="row row-xs align-items-center mg-b-5">
                <div class="col-lg-5 col-md-12 col-sm-12">
                    <label class="form-label mg-b-0">군/구</label>
                </div>
                <div class="col-lg-7 col-md-12 col-sm-12">
                    <select id="district_own" name="district" class="form-control form-control select2" onchange="districtHTML(this.value, 'commission_own', 'commission', '')">

                    </select>
                </div>
            </div>
           
            <div class="row row-xs align-items-center mg-b-5">
                <div class="col-lg-5 col-md-12 col-sm-12">
                    <label class="form-label mg-b-0">반/동</label>
                </div>
                <div class="col-lg-7 col-md-12 col-sm-12">
                    <select id="commission_own" name="commission" class="form-control form-control select2" onchange="districtHTML(this.value, 'town_own', 'town', '')">

                    </select>
                </div>
            </div> 
            <div class="row row-xs align-items-center mg-b-5">
                <div class="col-lg-5 col-md-12 col-sm-12">
                    <label  class="form-label mg-b-0">상세 주소 정보</label>
                </div>
                <div class="col-lg-7 col-md-12 col-sm-12">
                <strong style=" color: darkred; font-size: 12px;" id="addresDiv"></strong>
                </div>
            </div>
            <div class="row row-xs align-items-center mg-b-5">
                <div class="col-lg-5 col-md-12 col-sm-12">
                    <label class="form-label mg-b-0 required-input">단지,거리/건물,호수</label>
                </div>
                <div class="col-lg-7 col-md-12 col-sm-12">
                    {{-- <select id="town_own" name="town" class="form-control form-control select2">

                    </select> --}}
                    <input type="text" id="town_own" required name="town" value="" class="form-control" required>
                </div>
            </div>
            {{-- <div class="row row-xs align-items-center mg-b-5">
                <div class="col-lg-5 col-md-12 col-sm-12">
                    <label class="form-label mg-b-0">거리</label>
                </div>
                <div class="col-lg-7 col-md-12 col-sm-12">
                    <input type="text" id="street_own" name="street" value="" class="form-control">
                </div>
            </div>
            <div class="row row-xs align-items-center mg-b-5">
                <div class="col-lg-5 col-md-12 col-sm-12">
                    <label class="form-label mg-b-0">동</label>
                </div>
                <div class="col-lg-7 col-md-12 col-sm-12">
                    <input type="text" id="apartment_own" name="apartment" value="" class="form-control">
                </div>
            </div>
            <div class="row row-xs align-items-center mg-b-5">
                <div class="col-lg-5 col-md-12 col-sm-12">
                    <label class="form-label mg-b-0 required-input">호</label>
                </div>
                <div class="col-lg-7 col-md-12 col-sm-12">
                    <input type="text" id="door_own" name="door" value="" class="form-control">
                </div>
            </div> --}}
            <div class="row row-xs align-items-center mg-b-5">
                <div class="col-lg-5 col-md-12 col-sm-12">
                    <label class="form-label mg-b-0 required-input">휴대폰</label>
                </div>
                <div class="col-lg-7 col-md-12 col-sm-12">
                    <input type="text" id="cellphone_own" name="cellphone" value="" class="form-control">
                </div>
            </div>
            <div class="row row-xs align-items-center mg-b-5">
                <div class="col-lg-5 col-md-12 col-sm-12">
                    <label class="form-label mg-b-0">집 전화</label>
                </div>
                <div class="col-lg-7 col-md-12 col-sm-12">
                    <input type="text" id="homephone_own" name="homephone" value="" class="form-control">
                </div>
            </div>
            <div class="row row-xs align-items-center mg-b-5">
                <div class="col-lg-5 col-md-12 col-sm-12">
                    <label class="form-label mg-b-0">직장 전화</label>
                </div>
                <div class="col-lg-7 col-md-12 col-sm-12">
                    <input type="text" id="workphone_own" name="workphone" value="" class="form-control">
                </div>
            </div>
            {{-- <div class="row row-xs align-items-center mg-b-5">
                <div class="col-lg-5 col-md-12 col-sm-12">
                    <label class="form-label mg-b-0">Зип код</label>
                </div>
                <div class="col-lg-7 col-md-12 col-sm-12">
                    <input type="text" id="zipcode_own" name="zipcode" value="" class="form-control">
                </div>
            </div> --}}
            {{-- <div class="row row-xs align-items-center mg-b-5">
                <div class="col-lg-5 col-md-12 col-sm-12">
                    <label class="form-label mg-b-0">특이사항</label>
                </div>
                <div class="col-lg-7 col-md-12 col-sm-12">
                    <input type="text" id="specialnote_own" name="specialnote" value="" class="form-control">
                </div>
            </div> --}}
            <div class="row row-xs align-items-center mg-b-5">
                <div class="col-lg-5 col-md-12 col-sm-12">
                    <label class="form-label mg-b-0">하루 번호 주문 수</label>
                </div>
                <div class="col-lg-7 col-md-12 col-sm-12">
                    <input type="number" id="max_order_qty" name="orderQty" value="3" class="form-control">
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="row row-xs align-items-center mg-b-5">
                <div class="col-lg-8 col-md-12 col-sm-12">
                    <label class="form-label mg-b-0" style="font-weight: bold">시민등록청에서 시민 주소 정보 조회</label>
                </div>
                <div class="col-lg-4 col-md-12 col-sm-12">
                    <label class="ckbox">
                        <input type="checkbox" id="otpCheckbox" onchange="checkOtp();"><span></span>
                    </label>
                </div>
            </div>
            <div id="otpDiv">
 
            </div>
            {{-- <div class="row row-xs align-items-center mg-b-5">
                <div class="col-lg-8 col-md-12 col-sm-12">
                    <label class="form-label mg-b-0" style="font-weight: bold">신규 өмчлөгийн ИБ -ийн мэдээлэл харах</label>
                </div>
                <div class="col-lg-4 col-md-12 col-sm-12">
                    <label class="ckbox">
                        <input type="checkbox" id="lastFinger" onchange="checkFingerModal();"><span></span>
                    </label>
                </div>
            </div>
            <div id="fingerDataLast">
 
            </div> --}}
            <div class="row row-xs align-bottom-center mg-b-5">
                <div class="col-lg-8 col-md-12 col-sm-12">
                    <label class="form-label mg-b-0" style="font-weight: bold">아카이브와 함께 등록</label>
                </div>
                <div class="col-lg-4 col-md-12 col-sm-12">
                    <label class="ckbox">
                        <input type="checkbox" id="arkhCheck" name="arkhCheck" value=0 onchange="checkIsArkh();"><span></span>
                    </label>
                </div>
            </div>
        </div>
        <!--오른쪽 영역 끝-->
    </div>
    <hr class="mg-y-10">
    <div class="row">
        <div class="col-lg-2 col-md-6 col-sm-6">
            <button id="editBtn" style="display: none" type="button" onclick="insertData()" class="btn btn-primary btn-block">소유자 수정</button>
        </div>
        <div class="col-lg-8"><h5 id="owner_message"></h5></div>
        <div class="col-lg-2 col-md-6 col-sm-6">
            <button id="owner_btn" class="btn btn-primary btn-block" style="display: none" onclick="selectOwner()"></button>
        </div>
    </div>
</div>

<script>
    var is_owner = false;
    var owner = null;
 
    function checkFingerModal(){
        var is_check = $( "#lastFinger" ).prop( "checked");
        if(is_check){
            $("#fingerDataLast").html("");
            onConnectLast();
        }
    }
    function checkOtp(e){
        var regnum=  $("#register_own").val();
        const otpCheckbox = document.getElementById('otpCheckbox');
    if (otpCheckbox.checked) {
     
           $(".containerBody").fadeOut();
        $(".avtoteeverPreloader").fadeIn();
       $.ajax({ 
                    type: 'POST',
                    url: '/api/otpApprove',
                    dataType: "text",
                    crossDomain : true,
                    data: {
                        param1: regnum,
                      
                        param2: '{{ \App\Http\Controllers\BaseController::enc(\Carbon\Carbon::now()->format("Y-m-d")) }}'
                    },
                    timeout: 60000,
            error: function (data) {
                $(".containerBody").fadeIn();
                $(".avtoteeverPreloader").fadeOut();
          
            },
                    success: function (data) {
                  
                     //   console.log(data);
                        var response =JSON.parse(data);
                     //   console.log(response);
                        $(".containerBody").fadeIn();
                $(".avtoteeverPreloader").fadeOut();
                        if (response['return']['resultCode'] == 0) {
                     
                      
                            var otp = prompt('OTP 코드를 입력하세요!');
                        
                            if(otp != null)
                            {   
                                cleintOtp(regnum,otp);
                         
                            }
                        }else{
                      
                            alert(response['return']['resultMessage']);
                        }
             
                    }
                });
    }
    }
    function cleintOtp(regnum,otp) {
//console.log(regnum);
          $.ajax({
                    type: 'POST',
                    url: '/api/xypClientOTP',
                    dataType: "text",
                 
                    data: {
                        param1: regnum,
                        param2: otp,
                        param3: '{{ \App\Http\Controllers\BaseController::enc(\Carbon\Carbon::now()->format("Y-m-d")) }}'
                    },
                    timeout: 60000,
                    success: function (data) {
                    console.log(data);
                       $("#otpDiv").html(data);
                    }
                });
        
    }

    function checkIsArkh(){
        var is_check = $( "#arkhCheck" ).prop( "checked");
        if(is_check){
            $("#arkhCheck").val(1);
           
        }else{
            $("#arkhCheck").val(0);
        }
    }

    function onConnectLast() {
        var webSocket = new WebSocket("ws://localhost:81/service");
        webSocket.onopen = function () {
            webSocket.send("show");
        };

        webSocket.onmessage = function (evt) {
            if(evt.data!='' && evt.data!='Hello'){
                checkPersonLast(evt.data);
            }
        };
        webSocket.onclose = function () {
            $( "#fingerDataLast" ).css( "color", "red" );
            $( "#fingerDataLast" ).text( "장치 연결이 끊어졌습니다." );
        };
    };

    function checkPersonLast(finger){
        var register = $("#register_own").val();
        if(finger != "" && finger != null && register.length > 0 && register.length > 0){
            try {
                $( "#fingerDataLast" ).css( "color", "green" );
                $( "#fingerDataLast" ).text( "지문 정보를 확인 중입니다. . . ." );
                $.ajax({
                    type: 'POST',
                    url: '/api/fingerInfoImage',
                    dataType: "text",
                    crossDomain : true,
                    data: {
                        param1: finger,
                        param2: register,
                        param3: '{{ \App\Http\Controllers\BaseController::enc(\Carbon\Carbon::now()->format("Y-m-d")) }}'
                    },
                    success: function (data) {
                        $("#fingerDataLast").html(data);
                    }
                });
            }catch(err) {
                $( "#fingerDataLast" ).css( "color", "red" );
                $( "#fingerDataLast" ).text( "지문 확인 중 오류가 발생했습니다." );
            }
        } else {
            $( "#fingerDataLast" ).css( "color", "red" );
            $( "#fingerDataLast" ).text( "지문 정보가 불완전합니다." );
        }
    }

    function selectOwner() {
        var arkh_check_num=$("#arkhCheck").val();
        if(is_owner){
            var message = validateFields();
            if(message.length == 0) {
                $(".containerBody").fadeOut();
                $(".loader14").fadeIn();
                $("#new_owner_id").val(owner);
               
                $("#arkhCheckNum").val(arkh_check_num);
                $("#ownerShipModal").modal("hide");
                $("#main_form").submit();
            } else {
                alert(message.substr(0, message.length - 2) + " 필드를 반드시 작성해 주세요.");
            }
        } else {
            alert("소유자가 선택되지 않았습니다.");
        }
    }

    function validateFields() {
        var province_own = $("#province_own").val();
        var district_own = $("#district_own").val();
        var commission_own = $("#commission_own").val();
        var cellphone_own = $("#cellphone_own").val();
        var town_own = $("#town_own").val();
        var register_own = $("#register_own").val();
        var surname_own = $("#surname_own").val();
        var type_own = $("#type_own").val();
        var message = "";
        if(register_own.length == 0){message = message + "등록번호, ";}
        if(type_own.length == 0){message = message + "유형, ";}
        if(surname_own.length == 0){message = message + "본인 이름, ";}
        if(province_own == 0 || province_own == null){message = message + "도/시, ";}
        if(district_own == 0 || district_own == null){message = message + "군/구, ";}
        if(commission_own == 0 || commission_own == null){message = message + "반/동, ";}
        if(town_own.length == 0){message = message + "단지/거리/건물,호수, ";}
        if(cellphone_own.length == 0){message = message + "휴대폰, ";}
        return message;
    }

    function insertData(){
        var message = validateFields();
        if(message.length == 0){
            $.ajax({
                type: "POST",
                url: '/api/createowner', 
                data: {
                    "env": '{{ \App\Http\Controllers\BaseController::enc(session()->get("auth")->id) }}',
                    "owner": owner,
                    "location": $("#location_own").val(),
                    "type": $("#type_own").val(),
                    "register": $("#register_own").val(),
                    "familyname": $("#familyname_own").val(),
                    "parent": $("#parent_own").val(),
                    "surname": $("#surname_own").val(),
                    "gender": $("#gender_own").val(),
                    "province": $("#province_own").val(), 
                    "district": $("#district_own").val(),
                    "commission": $("#commission_own").val(),
                    "town": $("#town_own").val(),
                    "street": $("#street_own").val(),
                    "apartment": $("#apartment_own").val(),
                    "door": $("#door_own").val(),
                    "cellphone": $("#cellphone_own").val(),
                    "homephone": $("#homephone_own").val(),
                    "workphone": $("#workphone_own").val(),
                    "zipcode": $("#zipcode_own").val(),
                    "specialnote": $("#specialnote_own").val(),
                    "orderqty": $("#max_order_qty").val(),
                    "arkhCheck": $("#arkhCheck").val(),
                },
                success: function( response ) {
                  //  console.log(response);
                    if (response['statusCode'] == 400) {
                        $("#owner_message").text(response['message']);
                      
                    }else{

                    
                    if(response != "duplicated" && response != "updated"){
                        owner = response;
                        is_owner = true;
                        if(selected_menu_name == "OWNER_REG"){
                            $("#owner_message").text("소유자 정보가 성공적으로 등록되었습니다.");
                            $("#editBtn").html("정보 저장");
                           
                        } else {
                            $("#owner_message").text("소유자 정보가 성공적으로 등록되었습니다.");
                            $("#editBtn").html("정보 저장");
                           
                        }
                        $("#owner_btn").css("display", "block");
                    } else {
                        if(selected_menu_name == "OWNER_REG"){
                            $("#owner_message").text("소유자 정보가 성공적으로 수정되었습니다.");
                            $("#editBtn").html("정보 저장");
                        } else {
                            $("#owner_message").text("소유자 정보가 성공적으로 수정되었습니다.");
                            $("#editBtn").html("정보 저장");
                        }
                        $("#owner_btn").css("display", "block");
                       
                    }
                }
            }
            })
        } else {
            alert(message.substr(0, message.length - 2) + " 필드를 반드시 작성해 주세요.");
        }
    }

    function loadData(register, type){
        clearFields();
  
        $.ajax({
            type: "POST",
            url: '/api/owner',
            data: {"register": register, "type": type},
            success: function( response ) {
               console.log(response);
               
                if(response != "false" && response != "true"){
                    var response = response[0];
                    owner = response["id"];
                    is_owner = true;
                    var address = response["address"].split('   -');
                   // console.log(address);
                    $("#town_own").val(address[1]);
                    $("#addresDiv").text(response['address']);
                    

                    $("#location_own").val(response["country_id"]);
                    $("#type_own").val(response["owner_type_id"]);
                    $("#register_own").val(response["register_no"]);
                    $("#familyname_own").val(response["family_name"]);
                    $("#parent_own").val(response["last_name"]); 
                    $("#surname_own").val(response["first_name"]);
                    $("#gender_own").val(response["gender"]);
                   
                    $("#province_own").val(response["province_id"]);
                  //  $("#district_own").val(response["district_id"]);
                    districtHTML(response["province_id"], "district_own", "district", response["district_id"]);
                    districtHTML(response["district_id"], "commission_own", "commission", response["devision_unit_id"]);
                   // districtHTML(response["devision_unit_id"], "town_own", "town", response["micro_district_id"]);
                    $("#street_own").val(response["street"]);
                    $("#apartment_own").val(response["apartment_no"]);
                    $("#door_own").val(response["door_no"]);
                    $("#cellphone_own").val(response["cellphone"]);
                    $("#homephone_own").val(response["homephone"]);
                    $("#workphone_own").val(response["workphone"]);
                    $("#zipcode_own").val(response["zip"]);
                    $("#specialnote_own").val(response["more_info"]);
                    $("#max_order_qty").val(3);
                    if(selected_menu_name == "OWNER_REG"){
                        $("#editBtn").html("정보 저장");
                        $("#owner_btn").html("소유자 등록")
                    } else {
                        $("#editBtn").html("정보 저장");
                        $("#owner_btn").html("소유자 등록");
                    } 
                    // if(selected_menu_name == "OWNER_REG"){
                    //         $("#owner_btn").html("ЭЗЭМШИГЧ БҮРТГЭХ");
                    //     }else{
                    //         $("#owner_btn").html("ӨМЧЛӨГЧ БҮРТГЭХ");
                    //     }
                    $("#editBtn").css("display", "block");
                    $("#owner_btn").css("display", "block");
                    $("#dep_div").css("display", "none");
                    $("#company_dep").css("display", "none");
                } else if(response == "true"){
                    $.ajax({
                        type: "POST",
                        url: '/api/owner_deps',
                        data: {"register": register},
                        success: function( response ) {
                            $("#company_dep").html(response);
                        }
                    })
                    if(selected_menu_name == "OWNER_REG"){
                        $("#editBtn").html("소유자 등록");
                    } else {
                        $("#editBtn").html("소유자 등록");
                    }

                    $("#editBtn").css("display", "block");
                    $("#dep_div").css("display", "block");
                    $("#company_dep").css("display", "block");
                } else if(response == "false"){
                    is_owner = false;
                    owner = null;
                    if(selected_menu_name == "OWNER_REG"){
                        $("#editBtn").html("소유자 등록");
                    } else {
                        $("#editBtn").html("소유자 등록");
                    }
                    $("#editBtn").css("display", "block");
                    $("#owner_btn").css("display", "none");
                    $("#dep_div").css("display", "none");
                    $("#fingerDataLast").html("");
                    $("#company_dep").css("display", "none");
                }
                $("#owner_message").text("");
            }
        })
    }

    function clearFields(){
        $("#location_own option:contains(몽골)").prop('selected', true).change();
        $("#type_own option:contains(비율 хүн)").prop('selected', true).change();
        $("#familyname_own").val("");
        $("#parent_own").val("");
        $("#surname_own").val("");
        $("#province_own").val("");
        $("#district_own").val("");
        $("#commission_own").val("");
        $("#town_own").val("");
        $("#street_own").val("");
        $("#apartment_own").val("");
        $("#door_own").val("");
        $("#cellphone_own").val("");
        $("#homephone_own").val("");
        $("#workphone_own").val("");
        $("#zipcode_own").val("");
        $("#specialnote_own").val("");
        $("#max_order_qty").val("");
    }

    function selectDepartment(id){
        if(id != 0){
            var register = $("#ownerdep"+id).attr("reg");
            loadData(register, "man");
        }
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
</script>