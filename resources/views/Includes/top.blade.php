<div class="container-fluid">
    <div class="az-header-left">
        <a href="" id="azIconbarShow" class="az-header-menu-icon d-lg-none"><span></span></a>
    </div>
    <div class="az-header-center">

        @if (isset($vehicle))
            <div class="row">

                <div class="col-lg-2 col-md-6 col-sm-12">
                    <div style="height:30px;display:flex;align-items:center;">
                        <label class="ckbox">
                            <input type="checkbox"
                                {{ isset($vehicle) ? ($vehicle->is_enabled == 0 ? 'checked' : '') : '' }}
                                disabled><span
                            style="{{ isset($vehicle) ? ($vehicle->is_enabled == 0 ? 'color:red;font-size:18px;font-weight: bold;' : '') : '' }}">비활성</span>
                        </label>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-12">
                    <div style="height:30px;display:flex;align-items:center;">
                        <label class="ckbox">
                            <input type="checkbox"
                                {{ isset($vehicle) ? ($vehicle->is_warning == 1 ? 'checked' : '') : '' }}
                                disabled><span
                            style="{{ isset($vehicle) ? ($vehicle->is_warning == 1 ? 'color:red;font-size:18px;font-weight: bold;' : '') : '' }}">경고</span>
                        </label>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-12">
                    <div style="height:30px;display:flex;align-items:center;">
                        <label class="ckbox">
                            <input type="checkbox" disabled><span>정보 변경됨</span>
                        </label>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-12">
                    <div style="height:30px;display:flex;align-items:center;">
                        <label class="ckbox">
                            <input type="checkbox"
                                {{ isset($vehicle) ? ($vehicle->is_stolen == 1 ? 'checked' : '') : '' }}
                                disabled><span
                            style="{{ isset($vehicle) ? ($vehicle->is_stolen == 1 ? 'color:red;font-size:18px;font-weight: bold;' : '') : '' }}">도난</span>
                        </label>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-12">
                    <div style="height:30px;display:flex;align-items:center;">
                        <button type="button" onclick="checkFingerOther();"
                            class="btn btn-primary btn-block btnnopadding"
                            style="padding-top: 0 !important;padding-left: 8px;background-color: #0069d9;color: #ced4da;font-size: 14px;color: white;font-weight: bold;">지문
                            정보 조회</button>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="row row-xs align-items-center mg-b-5">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <button type="button" onclick="eRequestCheckModal();"
                                class="btn btn-primary btn-block btnnopadding"
                                style="position: absolute;background-color: green;height: 30px;color: #ced4da;font-size: 14px;padding-top: 0px !important;color: white;font-weight: bold;">전자
                                요청 조회</button>
                        </div>
                    </div>
                </div>

            </div>
        @else
            <form id="topSeachForm" name="topSeachForm" class="topSeachForm" action="{{ route('vehicle') }}"
                method="POST">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-6">
                        <input type="search" id="numbertop_id" style="margin-left: -5px; height: 30px !important;"
                            name="numberTop" class="form-control searchBox topSeachFormNumberId" autocomplete="off"
                            placeholder="차량 검색...">
                        <button class="btn"><i class="fas fa-search"></i></button>
                    </div>
                    <div class="col-md-3">
                        <div class="row row-xs align-items-center mg-b-5">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <button type="button" onclick="checkFingerOther();"
                                    class="btn btn-primary btn-block btnnopadding"
                                    style="position: absolute;background-color: #0069d9;height: 30px;color: #ced4da;font-size: 16px;padding-top: 0px !important;color: white;font-weight: bold;">지문
                                    정보 조회</button>
                            </div>
                        </div>
                    </div>
            </form>
            <div class="col-md-3">
                <div class="row row-xs align-items-center mg-b-5">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <button type="button" onclick="eRequestCheckModal();"
                            class="btn btn-primary btn-block btnnopadding"
                            style="position: absolute;background-color: green;height: 30px;color: #ced4da;font-size: 16px;padding-top: 0px !important;color: white;font-weight: bold;">전자
                            요청 조회</button>
                    </div>
                </div>
            </div>
    </div>
    @endif

</div>

<div class="az-header-right">
    <b>{{ session()->has('archive') == 1? (session()->get('archive') != 'many'? \App\Helpers\TranslationHelper::translate(session()->get('archive')->archive): ''): '' }}</b>
    <div class="dropdown az-profile-menu">
        <a href="" class="az-img-user"><img src="{{ asset('img/noavatar.png') }}" alt=""></a>
        <div class="dropdown-menu">
            <div class="az-dropdown-header d-sm-none">
                <a href="" class="az-header-arrow"><i class="icon ion-md-arrow-back"></i></a>
            </div>
            <div class="az-header-profile">
                @php
    $auth = session()->get('auth');
    $authPosition = null;
    $authLastName = null;
    $authFirstName = null;
    $authProvinceId = null;
    if (is_object($auth)) {
        $authPosition = $auth->position ?? $auth->Position ?? $auth->POSITION ?? null;
        $authLastName = $auth->lastname ?? $auth->LastName ?? $auth->LASTNAME ?? null;
        $authFirstName = $auth->firstname ?? $auth->FirstName ?? $auth->FIRSTNAME ?? null;
        $authProvinceId = $auth->provinceid ?? $auth->ProvinceId ?? $auth->PROVINCEID ?? null;
    }
    $positionLabel = is_string($authPosition) ? $authPosition : null;
    $positionMap = [
        '부서장' => '부서장',
        '담당자' => '담당자',
        'DK 수석' => 'DK 수석',
        '수도 등록 담당자' => '수도 등록 담당자',
        '수도 아카이브 담당자' => '수도 아카이브 담당자',
        '수도 수석 등록 담당자' => '수도 수석 등록 담당자',
        '센터장' => '센터장',
    ];
    if (is_string($positionLabel) && isset($positionMap[$positionLabel])) {
        $positionLabel = $positionMap[$positionLabel];
    }
@endphp
                <h6>{{ substr($authLastName ?? '', 0, 2) . '. ' . ($authFirstName ?? '') }}  
                </h6>
                <span style="text-align: center;">{{ $positionLabel }}</span>
            </div>
            <a href="/user/password" class="dropdown-item"><i class="typcn typcn-edit"></i> 비밀번호 변경</a>
            @if ($authProvinceId != 22 || $authPosition =="부서장" || 
            $authPosition =="담당자" || $authPosition =="DK 수석" || $authPosition =="수도 등록 담당자" || $authPosition =="수도 아카이브 담당자" || $authPosition =="수도 수석 등록 담당자" || $authPosition == "센터장")
                <a href="/user/mynumbers" class="dropdown-item"><i class="typcn typcn-book"></i> 전송한 번호</a>
            @endif
            <a href="#document" class="dropdown-item" data-toggle="modal" data-effect="effect-scale"><i
                    class="far fa-question-circle"></i>사용 안내 </a>
            <a href="/logout" class="dropdown-item"><i class="typcn typcn-power-outline"></i> 로그아웃</a>
        </div>
    </div>
</div>




</div>

<script>
   
    function eRequestCheckModal() {

        $.ajax({
            type: 'POST',
            url: '/api/getRequestList',
            dataType: "json",
            data: { 
                // param1: "param",
                param: '{{ \App\Http\Controllers\BaseController::enc(\Carbon\Carbon::now()->format('Y-m-d')) }}'
            },
            timeout: 60000,
            error: function(data) {
                $(".avtoteeverPreloader").fadeOut();
                $(".containerBody").fadeIn();
            },
            success: function(data) {
                try {

                    const count = 0;
                 console.log(data);
                    const dataGrid = $('#onlineRequestList').dxDataGrid({
                        dataSource: data['data'] ,
                        keyExpr: 'id',
                        showColumnLines: true,
                        showRowLines: true,
                        rowAlternationEnabled: false,
                        showBorders: true,
                        columnAutoWidth: true,
                        remoteOperations: true,

                        filterRow: {
                            visible: false,
                            applyFilter: 'auto',
                        },
                        searchPanel: {
                            visible: true,
                            width: 240,
                            placeholder: '검색...',
                        },
                        headerFilter: {
                            visible: false,
                        },
                        paging: {
                            enabled: true,
                            pageSize: 5,
                        },
                        pager: {
                            showInfo: true,
                            //     showPageSizeSelector: true,
                            //     allowedPageSizes: [10, 25, 50, 100],
                        },
                        selection: {
                            mode: 'single',
                            // showCheckBoxesMode:"checkBoxesMode"
                        },
                        hoverStateEnabled: true,
                        columns: [{
                                // dataField: 'id',
                                caption: '№',
                                cellTemplate: function(cellElement, cellInfo) {
                                    cellElement.text(cellInfo.row.rowIndex - parseInt(-1))
                                }
                                // width: 80,
                            },

                            {
                                dataField: 'request_code',
                                caption: '코드',
                            },
                            {
                                dataField: 'plate_no',
                                caption: '차량 번호',
                            },
                            {
                                dataField: 'cabin_no',
                                caption: '차대 번호',
                            },
                            {
                                dataField: 'mark_name',
                                caption: '제조사',
                            },
                            {
                                dataField: 'model_name',
                                caption: '모델',
                            },

                            {
                                dataField: 'owner_firstname',
                                caption: '소유자',
                                calculateCellValue: function(rowData) {
                                    return rowData.owner_lastname != null ? rowData.owner_firstname.substring(0, 1) +
                                        "." + rowData.owner_firstname : "-";
                                }
                            },
                            {
                                dataField: 'owner_regnum',
                                caption: '등록번호',

                            },

                            {
                                dataField: 'is_paid',
                                caption: '결제',
                                // calculateCellValue: function(rowData) {
                                //     return rowData.is_paid == 0 ? "미결제" : "결제완료";
                                // }
                                cellTemplate: function(element, info) {
                                    info.text == 0 ? element.append("<div>미결제</div>")
                                        .css("color", "red") : element.append(
                                            "<div>결제완료</div>")
                                        .css("color", "green");
                                }
                            },
                            {
                                dataField: 'is_approved',
                                caption: '상태',
                                // calculateCellValue: function(rowData) {
                                //     return rowData.is_paid == 0 ? "미결제" : "결제완료";
                                // }
                                cellTemplate: function(element, info) {
                                    info.text == 1 ? element.append("<div>승인됨</div>")
                                        .css("color", "green") : element.append(
                                            "<div>미승인</div>")
                                        .css("color", "blue");
                                }
                            },
                            // {
                            //     dataField: 'note',
                            //     caption: '유형',
                            //     dataType: 'string',
                            // },
                            {
                                dataField: 'created_date',
                                caption: '일자',
                                dataType: 'dateTime',
                            },

                            // {
                            //     dataField: 'note',
                            //     width: 130,
                            // },
                        ],
                        onSelectionChanged(selectedItems) {
                            const dataList = selectedItems.selectedRowsData[0];
                           // console.log(dataList);
                            $('#reqTitle').text("상세 정보");
                            $('#reqNote').text(dataList.note);
                            $('#reqType').text("(이전 처리-" + dataList.registered_date +
                                ")");
                            $("#reqDetial").css("display", "block");
                           
                            if (dataList) {
                             
                                $('.boxOptions1').dxBox({
                                    direction: 'row',
                                    width: '100%',
                                    //height: 75,

                                });
                                $('#boxOptions3').dxBox({
                                    direction: 'col',
                                    width: '70%',
                                    height: 100,
                                });
                               // console.log(dataList.picture);
                            $('.form-avatar').css('background-image', 'url('+dataList.picture+')');
                                $('#formLeft').dxForm({
                                    formData: selectedItems.selectedRowsData,
                                    items: [{
                                        itemType: 'group',
                                        cssClass: 'first-group',
                                        colCount: 4,
                                        caption: '양도인 (개인/기관/법인)',
                                        items: [
                                            // {
                                            //             template: "<img class='form-avatar' src="+dataList.picture+">",
                                            //         },
                                            // {
                                            //     template: "<div class='form-avatar'></div>",
                                            // },
                                             {
                                                itemType: 'group',
                                                colSpan: 2,
                                                items: [{
                                                        template: "<div> 성 / 기관유형</div>",
                                                    },
                                                    {
                                                        template: "<div> 이름 / 기관명</div>",
                                                    },
                                                    {
                                                        template: "<div> 등록번호</div>",
                                                    },
                                              
                                                    {
                                                        template: "<div>주소</div>",
                                                    },

                                                ],
                                            },
                                            {
                                                itemType: 'group',
                                                colSpan: 2,
                                                items: [{
                                                     
                                                    template: "<br><div>" +
                                                            dataList
                                                            .owner_lastname +
                                                            "</div>",

                                                    },
                                                    {
                                                        template: "<br><div>" +
                                                            dataList
                                                            .owner_firstname +
                                                            "</div>",

                                                    },
                                                    {
                                                        template: "<br><div>" +
                                                            dataList
                                                            .owner_regnum +
                                                            "</div>",

                                                    },
                                                
                                                    {
                                                        template: "<div style='font-size: 13px;'>" +
                                                            dataList
                                                            .owner_address +
                                                            "</div>",

                                                    },

                                                ],
                                            },
                                            {
                                                colSpan: 4,
                                                colCount: 5,
                                                itemType: 'group',
                                                caption: '차량 정보',
                                                cssClass: 'first-group',
                                                items: [{
                                                        colSpan: 3,
                                                        itemType: 'group',

                                                        items: [{
                                                                template: "<div> 증명서 번호",
                                                            },
                                                            {
                                                                template: "<div> 차량 번호",
                                                            },
                                                            {
                                                                template: "<div>차대 번호",
                                                            },


                                                        ],

                                                    },
                                                    {
                                                        colSpan: 2,
                                                        itemType: 'group',

                                                        items: [{
                                                                template: "<div> 546545",
                                                            },
                                                            {
                                                                template: "<div>" +
                                                                    dataList
                                                                    .plate_no,
                                                            },
                                                            {
                                                                template: "<div>" +
                                                                    dataList
                                                                    .cabin_no,
                                                            },


                                                        ],

                                                    },



                                                ]
                                            },




                                        ],
                                    }],



                                });



                                $('#formRight').dxForm({

                                    formData: dataList,

                                    items: [{
                                        itemType: 'group',
                                        cssClass: 'first-group',
                                        colCount: 4,
                                        caption: '양수인 (개인/기관/법인)',
                                        items: [
                                            // {
                                            //     template: "<div class='form-avatar'></div>",
                                            // },
                                            // {
                                            //             template: "<img class='form-avatar' src="+dataList.picture+">",
                                            //         },
                                            
                                            {
                                                itemType: 'group',
                                                colSpan: 2,
                                                items: [
                                                    {
                                                        template: "<div> 성 / 기관유형</div>",
                                                    },
                                                   
                                                    {
                                                        template: "<div> 이름 / 기관명</div>",
                                                    },
                                                    {
                                                        template: "<div> 등록번호</div>",
                                                    },
                                                 
                                                    {
                                                        template: "<div>주소</div>",
                                                    },

                                                ],
                                            },
                                            {
                                                itemType: 'group',
                                                colSpan: 2,

                                                items: [{
                                                    
                                                    template: "<br><div>" +
                                                            dataList
                                                            .new_owner_lastname+
                                                            "</div>",

                                                    },
                                                    {
                                                        template: "<br><div>" +
                                                            dataList
                                                            .new_owner_firstname+
                                                            "</div>",

                                                    },
                                                    {
                                                        template: "<br><div>" +
                                                            dataList
                                                            .new_owner_regnum +
                                                            "</div>",

                                                    },
                                              
                                                    {
                                                        template: "<div style='font-size: 13px;'>" +
                                                            dataList
                                                            .new_owner_address +
                                                            "</div>",

                                                    },

                                                ],
                                            },
                                            {
                                        itemType: 'group',
                                        cssClass: 'first-group',
                                        colSpan: 4,
                                                colCount: 5,
                                        caption: '사용자 (개인/기관/법인)',
                                        items: [
                                            // {
                                            //     template: "<div class='form-avatar'></div>",
                                            // },
                                            // {
                                            //             template: "<img class='form-avatar' src="+dataList.picture+">",
                                            //         },
                                            
                                            {
                                                itemType: 'group',
                                                colSpan: 2,
                                                items: [
                                                    {
                                                        template: "<div> 성 / 기관유형</div>",
                                                    },
                                                   
                                                    {
                                                        template: "<div> 이름 / 기관명</div>",
                                                    },
                                                    {
                                                        template: "<div> 등록번호</div>",
                                                    },
                                                 
                                                    {
                                                        template: "<div>주소</div>",
                                                    },

                                                ],
                                            },
                                            {
                                                itemType: 'group',
                                                colSpan: 2,

                                                items: [{
                                                    
                                                        template: function() {
                                                            return dataList
                                                                .borrower_lastname ==
                                                                null ?
                                                                dataList
                                                                .borrower_firstname :
                                                                dataList
                                                                .borrower_lastname;
                                                        }
                                                        // template: "<div>" +
                                                        //     dataList
                                                        //     .new_owner_info
                                                        //     .lastname   +
                                                        //     "</div>",

                                                    },
                                                    {
                                                        template: "<br><div>" +
                                                            dataList
                                                            .borrower_firstname +
                                                            "</div>",

                                                    },
                                                    {
                                                        template: "<br><div>" +
                                                            dataList
                                                            .borrower_regnum +
                                                            "</div>",

                                                    },
                                                 
                                                    {
                                                        template: "<div style='font-size: 13px;'>" +
                                                            dataList
                                                            .borrower_address +
                                                            "</div>",

                                                    },

                                                ],
                                            },
                                            
                                       
                                        ],

                                    }  ,
                                    {
                                                colSpan: 4,
                                         
                                                itemType: 'group',
                                                caption: '추가 정보',
                                                items: [{
                                                    template: "<div id='editing-textarea'></div>"
                                                    // dataField: 'note',

                                                    // editorType: 'dxTextArea',

                                                    // editorOptions: {
                                                    //     showClearButton: true,
                                                    //     height: 90,

                                                    // },

                                                }],
                                            },
                                        ],

                                    }],



                                });
                           
                               
                                const editingTextArea = $('#editing-textarea').dxTextArea({
                                    value: dataList.note,
                                    height: 90,
                                    valueChangeEvent: 'change',
                                    onValueChanged(data) {
                                        // disabledTextArea.option('value', data.value);
                                      //  console.log(data.value);
                                    },
                                }).dxTextArea('instance');

                             
                                $('#button').dxButton({
                                    text: dataList.is_approved == 1 ? '승인됨':'승인',
                                    height: 40,
                                    width: 180,
                                    icon: 'check',
                                    disabled: dataList.is_approved == 1 ? true : false,
                                     type:  dataList.is_approved == 1 ? 'success' : 'default',
                                    template(data, container) {
                                        $(`<div class='button-indicator'></div><span class='dx-button-text'>${data.text}</span>`)
                                            .appendTo(container);
                                        buttonIndicator = container.find(
                                            '.button-indicator').dxLoadIndicator({
                                            visible: false,
                                        }).dxLoadIndicator('instance');
                                    },
                                    onClick(data) {
                                        data.component.option('text', '확인 중...');
                                        buttonIndicator.option('visible', true);

                                        setTimeout(() => {

                                       
                                          
                                         
                                            buttonIndicator.option('visible',
                                                false);
                                            data.component.option('text',
                                                '승인');


                                        }, 5000);
                                        if (dataList.service_code == "VRS1") {
                                            $('#cabin_no_id').val(dataList
                                                
                                                .cabin_no);
                                        }else{
                                            $('#number_id').val(dataList
                                                
                                                .plate_no);
                                        }
                                       
                                            // window.location.href = "/vehicle";
                                            // return false;
                                            let requestData = { new_owner:dataList.new_owner_regnum , service_code: dataList.service_code,approveCode:dataList.request_code,signed_data:"data" };
                                    	
                                            
                                            sessionStorage.setItem('isCheckRequset', JSON.stringify(requestData));
                                       //  var isCheckRequset = sessionStorage.getItem('isCheckRequset');
                                        //     var checkReq =JSON.parse(isCheckRequset);

                                        //    if (checkReq.service_code !="VRS") {
                                        //         $('#number_id').val(dataList
                                        //         .vehicle_info
                                        //         .plate_no);
                                        //      }else{
                                        //         $('#cabin_no_id').val(dataList
                                        //         .vehicle_info
                                        //         .cabin_no);
                                        //      }
                                           
                                    
                                       // console.log('retrievedObject: ', JSON.parse(isCheckRequset));


                                            // sessionStorage.setItem("isCheckRequset",dataList
                                            //                 .new_owner_info
                                            //                 .regnum  );
                                             $("#main_form").submit();


                                    },
                                });
                                //s$('.ownerFirstname').text(dataList.vehicle_info.plate_no);
                                // $('.employeePhoto').attr('src', data.City);
                                $('.newOwnerFirstname').text(dataList.registered_date);
                                // $('#titleLeft').text("양도인 (개인/기관/법인)");
                                // $('#titleRight').text("양수인 (개인/기관/법인)");
                            }
                        },
                    }).dxDataGrid('instance');

                    $("#eRequestCheckModal").modal({
                        backdrop: 'static',
                        keyboard: false,
                        show: true
                    });

                } catch (err) {

                }
            }
        });


    }
   
</script>
