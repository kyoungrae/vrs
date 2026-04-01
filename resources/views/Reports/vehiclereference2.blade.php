<!DOCTYPE html>
<html lang="en">
<head>
    @include('Includes.head')
    <style>
        table.dataTable tfoot th, table.dataTable tfoot td {
            padding: 5px 18px 5px 18px;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
        }
        .modal-title {
            font-weight:600;
            color:#0062cb !important;  
        }
    </style>
</head>
<body class="az-body flexcroll">
<div class="avtoteeverPreloader"></div>
<div class="containerBody" style="display: none;">
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
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    {{ \App\Helpers\TranslationHelper::translate("차량 -ИЙН ЛАВЛАГАА ЭЗЭМШИГЧЭЭР") }}
                                </div>
                            </div>
                        </h6>
                        <div class="row row-sm">
                            <div class="col-12 col-sm-1 col-lg">
                                <form action="" method="POST">
                                    {{ csrf_field() }}
                                    <div class="row row-sm">
                                        <div class="col-3">
                                            <div class="row row-xs align-items-center mg-b-5">
                                                <div class="col-lg-4 col-md-12 col-sm-12">
                                                    <label class="form-label mg-b-0">성</label>
                                                </div>
                                                <div class="col-lg-8 col-md-12 col-sm-12">
                                                    <input readonly id="last" name="lastName" type="text" value="{{ isset($lastName) ? $lastName : "" }}" class="form-control" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="row row-xs align-items-center mg-b-5">
                                                <div class="col-lg-4 col-md-12 col-sm-12">
                                                    <label class="form-label mg-b-0">이름</label>
                                                </div>
                                                <div class="col-lg-8 col-md-12 col-sm-12">
                                                    <input readonly id="first" name="firstName" type="text" value="{{ isset($firstName) ? $firstName : "" }}" class="form-control" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="row row-xs align-items-center mg-b-5">
                                                <div class="col-lg-4 col-md-12 col-sm-12">
                                                    <label class="form-label mg-b-0">{{ \App\Helpers\TranslationHelper::translate("Регистр") }}</label>
                                                </div>
                                                <div class="col-lg-8 col-md-12 col-sm-12">
                                                    <input id="reg" name="register" oninput="translate2MGL(this.value)" type="text" value="{{ isset($register) ? $register : "" }}" class="form-control" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="row row-xs align-items-center mg-b-5">
                                                <div class="col-lg-4 col-md-12 col-sm-12">
                                                    <button type="submit" onclick="" class="btn btn-primary btn-block btnnopadding">검색</button>
                                                </div>
                                                <div class="col-lg-4 col-md-12 col-sm-12">
                                                    <button type="button" onclick="finger()" class="btn btn-primary btn-block btnnopadding"><i class="far fa-file-excel"></i> 엑셀</button>
                                                </div>
                                                <div class="col-lg-4 col-md-12 col-sm-12">
                                                    <button type="button" onclick="clearFields()" class="btn btn-primary btn-block btnnopadding">지우기</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <hr class="mg-y-10">
                                <table id="referenceTable" class="display responsive nowrap" style="width:100%;">
                                    <thead>
                                    <tr style="text-align: center;">
                                        <th style="width:10%;">№</th>
                                        <th>번호판</th>
                                        <th>브랜드</th>
                                        <th>모델</th>
                                        <th>차체번호</th>
                                        <th>증명서 번호</th>
                                        <th>색상</th>
                                    </tr>
                                    </thead>
                                    <tbody style="text-align: center;">
                                     
                                    @if(ISSET($results))
                                  
                                  
                                        @foreach($results as $result)
                                      
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $result->plate_no }}</td>
                                                <td>{{ \App\Helpers\TranslationHelper::translate($result->mark_name ?? "") }}</td>
                                                <td>{{ \App\Helpers\TranslationHelper::translate($result->model_name ?? "") }}</td>
                                                <td>{{ $result->cabin_no }}</td>
                                                <td>{{ $result->certificate_no }}</td>
                                                <td>{{ \App\Helpers\TranslationHelper::translate($result->color_name ?? "") }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="fingerModal" class="modal">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">조회서 확인(인증)</h6>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <label class="ckbox">
                                    <input type="checkbox" id="checkFinger" onchange="isCheck(this.id);"><span>지문으로</span>
                                </label>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <label class="ckbox">
                                    <input type="checkbox" id="contract" onchange="isCheck(this.id);"><span>공문으로</span>
                                </label>
                            </div>
                        </div>
                        <div style="margin-bottom: 15px;">
                            <span id="fingerInfo" style="display: none;text-align:center;margin-top: 10px;"></span>
                        </div>
                        <div class="row">
                            <div class="col-lg-5 col-md-12 col-sm-12">
                                <input type="text" id="fingerDesc" style="display: none;" class="form-control" value="" placeholder="">
                            </div>
                            <div class="col-lg-7 col-md-12 col-sm-12">
                                <select class="form-control select2 required-input" id="fingerOrg" name="fingerOrg" style="display: none;">
                                    <option value="0">본인 요청으로</option>
                                    @if(ISSET($orgs))
                                        @foreach($orgs as $org)
                                            <option value="{{ $org->id }}">{{ \App\Helpers\TranslationHelper::translate($org->name ?? "") }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="closeFingerData();">취소</button>
                        <button type="button" class="btn btn-primary" onclick="checkFingerData();">조회서 받기</button>
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
        $(function(){
            'use strict'

            $('#referenceTable').DataTable({
                responsive: true,
                language: {
                    searchPlaceholder: '검색...',
                    sSearch: '',
                    lengthMenu: '_MENU_ 1/페이지에 표시',
                }
            });

            $('#reg').keyup(function(){
                this.value = this.value.toUpperCase();
            });

            $('#reg').on('keyup', function() {
                limitText(this, 12)
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

        var register = '{{ ISSET($register) ? $register : null }}';
        var lastName = '{{ ISSET($lastName) ? $lastName : null }}';
        var firstName = '{{ ISSET($firstName) ? $firstName : null }}';
        var total = {{ ISSET($results) ? sizeof($results) : 0 }};

        $("#last").val(lastName);
        $("#first").val(firstName);
        $("#reg").val(register);

        if(lastName == '') lastName = "none";
        if(firstName == '') firstName = "none";
        if(register == '') register = "none";

        function exportToExcel() {
            $(".containerBody").fadeOut();
            $(".avtoteeverPreloader").fadeIn();
            $.ajax({
                type: "GET",
                url: "/api/report/exportToExcelVehicleRef2/"+register+"/"+lastName+"/"+firstName,
                success: function (data) {
                    if(register != "none" || lastName != "none" || firstName != "none"){
                        window.location = "/api/report/exportToExcelVehicleRef2/"+register+"/"+lastName+"/"+firstName;
                        $(".avtoteeverPreloader").fadeOut();
                        $(".containerBody").fadeIn();
                    }
                    else{
                        $(".avtoteeverPreloader").fadeOut();
                        $(".containerBody").fadeIn();
                        alert("필터 값을 입력하세요!");
                    }
                },
            });
        }

        var fingerResult = null;
        var fingerResultText = null;

        function finger(){
            if(register != "none" || lastName != "none" || firstName != "none"){
                if(total > 0){
                    $( "#fingerInfo" ).css( "display", "none" );
                    $( "#fingerDesc" ).css( "display", "none" );
                    $( "#fingerOrg" ).css( "display", "none" );
                    $( "#checkFinger" ).prop( "checked", false );
                    $( "#contract" ).prop( "checked", false );
                    $("#fingerModal").modal({backdrop: 'static', keyboard: false, show: true});
                } else {
                    alert("검색 결과가 없습니다.");
                }
            }
            else{
                alert("필터 값을 입력하세요!");
            }
        }

        function closeFingerData(){
            window.location.reload();
        }

        var old_finger = "";
        function isCheck(text){
            $( "#fingerInfo" ).text( "" );
            $( "#fingerDesc" ).val( "" );
            $( "#fingerOrg" ).css( "display", "none" );
            $( "#fingerDesc" ).css( "display", "none" );
            if(old_finger != text){
                if(text == "checkFinger"){
                    $( "#contract" ).prop( "checked", false );
                    onConnect();
                } else {
                    $( "#checkFinger" ).prop( "checked", false );
                    $( "#fingerOrg" ).css( "display", "block" );
                    $( "#fingerDesc" ).css( "display", "block" );
                    $( "#fingerDesc" ).focus(  );
                    $( "#fingerDesc" ).attr( "placeholder", "공문 번호를 입력하세요." );
                }
            } else {
                if(text == "checkFinger"){
                    $( "#checkFinger" ).prop( "checked", true );
                    $( "#fingerInfo" ).css( "display", "block" );
                    $( "#fingerInfo" ).css( "color", "black" );
                    $( "#fingerInfo" ).text( "장치에 연결하는 중입니다." );
                    onConnect();
                } else {
                    $( "#contract" ).prop( "checked", true );
                    $( "#fingerOrg" ).css( "display", "block" );
                    $( "#fingerDesc" ).css( "display", "block" );
                    $( "#fingerDesc" ).focus(  );
                    $( "#fingerDesc" ).attr( "placeholder", "공문 번호를 입력하세요." );
                }
            }
            old_finger = text;
        }

        function onConnect() {
            var webSocket = new WebSocket("ws://localhost:81/service");
            webSocket.onopen = function () {
                webSocket.send("show");
            };

            webSocket.onmessage = function (evt) {
                if(evt.data!='' && evt.data!='Hello'){
                    checkPerson(evt.data);
                }
            };
            webSocket.onclose = function () {
                $( "#fingerInfo" ).css( "display", "block" );
                $( "#fingerInfo" ).css( "color", "red" );
                $( "#fingerInfo" ).text( "장치 연결이 끊어졌습니다." );
            };
        };

        function checkPerson(finger){
            if(finger != "" && finger != null && register.length > 0){
                try {
                    $( "#fingerInfo" ).css( "display", "block" );
                    $( "#fingerInfo" ).text( "지문 정보를 확인하는 중..." );
                    $.ajax({
                        type: 'POST',
                        url: 'https://vrs.transdep.mn/XYPMRTD/ClientFinger.php',
                        //url: 'http://spark.transdep.mn:8080/XYPMRTD/ClientFinger.php',
                        dataType: "text",
                        crossDomain : true,
                        data: {regnum: register, fingerprint: finger},
                        success: function (data) {
                            $( "#fingerInfo" ).css( "display", "block" );
                            $( "#fingerInfo" ).css( "font-size", "16px" );
                            $( "#fingerInfo" ).css( "font-weigth", "bold" );
                            var text = "";
                            if(data == "0"){
                                $( "#fingerInfo" ).css( "color", "green" );
                                text = "지문이 일치합니다.";
                            } else if(data == "302"){
                                $( "#fingerInfo" ).css( "color", "red" );
                                text = "지문이 일치하지 않습니다.";
                            } else {
                                $( "#fingerInfo" ).css( "color", "red" );
                                text = "등록번호 및 지문 정보가 잘못되었습니다.";
                            }
                            fingerResult = data;
                            fingerResultText = text;
                            $( "#fingerInfo" ).text( text );
                        }
                    });
                }catch(err) {
                    $( "#fingerInfo" ).css( "color", "red" );
                    $( "#fingerInfo" ).css( "display", "block" );
                    $( "#fingerInfo" ).text( "지문 확인 중 오류가 발생했습니다." );
                }
            } else {
                $( "#fingerInfo" ).css( "display", "block" );
                $( "#fingerInfo" ).text( "지문 정보가 불완전합니다." );
            }
        }

        var request_type = null;
        function checkFingerData(){
            var contract = $("#contract").is(':checked');
            var fingerDescription = "";
            var is_export = false;
            if(contract == true){
                if($("#fingerDesc").val().length > 0){
                    fingerDescription = "공문 번호: " + $("#fingerDesc").val();
                    $("#fingerTotalDescription").val(fingerDescription);
                    is_export = true;
                    request_type = 1;
                    $("#fingerModal").modal("hide");
                } else {
                    $( "#fingerInfo" ).css( "display", "block" );
                    $( "#fingerInfo" ).css( "color", "red" );
                    $( "#fingerInfo" ).text( "공문 번호를 입력하세요." );
                }
            } else {
                if(fingerResult == 0){
                    fingerDescription = "지문으로: " + fingerResultText;
                    $("#fingerTotalDescription").val(fingerDescription);
                    request_type = 2;
                    is_export = true;
                    $("#fingerModal").modal("hide");
                } else {
                    $( "#fingerInfo" ).css( "display", "block" );
                    $( "#fingerInfo" ).css( "color", "red" );
                    $( "#fingerInfo" ).text( fingerResultText );
                }
            }
            if(is_export){
                var req_type = $("#fingerOrg option:selected").val();
                var req_name = $("#fingerOrg option:selected").text();
                var desc = $("#fingerDesc").val();

                if(contract == false){
                    req_type = 0;
                    req_name = "본인 요청으로";
                    desc = "";
                }
                var result = saveLog(1, request_type, register, req_type, req_name, desc, total, fingerDescription, {{ session()->get("auth")->id }}, '{{ \Carbon\Carbon::now()->format('Y-m-d H:i:s') }}');
            } else {
                alert("지문 또는 공문 번호로 인증해야 합니다.");
            }
        }

        function saveLog(RefType, TypeId, Register, RequestType, RequestText, Number, VehicleCount, Description, CreatedBy, CreatedDate){
            try {
                $(".containerBody").fadeOut();
                $(".avtoteeverPreloader").fadeIn();
                $.ajax({
                    type: 'POST',
                    url: '/api/reference/log',
                    data: {RefType: RefType, TypeId: TypeId, Register: Register, RequestType: RequestType, RequestText: RequestText, DocNumber: Number, VehicleCount: VehicleCount, Description: Description, CreatedBy: CreatedBy, CreatedDate: CreatedDate},
                    success: function (data) {
                        if(data == "1"){
                            exportToExcel();
                        } else {
                            $(".avtoteeverPreloader").fadeOut();
                            $(".containerBody").fadeIn();
                            alert("조회서를 받는 중 오류가 발생했습니다.");
                        }
                    }
                });
            }catch(err) {

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
            $("#reg").val(word);
        }

        function clearFields() {
            $("#first").val(null);
            $("#last").val(null);
            $("#reg").val(null);
        }

        $(".avtoteeverPreloader").fadeOut();
        $(".containerBody").fadeIn();
    </script>
</div>
</body>
</html>
