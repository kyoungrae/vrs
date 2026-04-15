<!DOCTYPE html>
<html lang="en">

<head>
    @include('Includes.head')
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
                        <div class="" style="width: 100%;">
                            <h6 class="card-title">
                                <div class="row">
                                    <div class="col-lg-7 col-md-6 col-sm-12">
                                        전자 결제 확인
                                    </div>

                                </div>
                            </h6>
                            <div class="row row-sm">
                                <div class="col-8">
                                    <div id="transaction"></div>
                                </div>
                                <div class="col-4">
                                    <div id="vehicleInfo">
                                        <div class="stats">
                                            <div>
                                                <div class="sub-title">차량 번호</div>
                                                <div class="stat-value" id="plateNo"></div>
                                            </div>

                                            <div>
                                                <div class="sub-title">소유자</div>
                                                <div class="stat-value" id="owner"></div>
                                            </div>

                                        </div>
                                        <div id="description" style="    text-align: center;"></div>
                                        <div id="serviceName" style="    text-align: center;"></div>
                                        <hr>
                                        <div class="dx-fieldset plateInfoSearch"  style="display: none">
                                            <div class="dx-fieldset-header">결제 차량 변경</div>
                                            <div class="dx-field">
                                                <div class="dx-field-label">변경할 차량:</div>
                                                <div id="plateCheck" class="dx-field-value" data-bind="
                                               dxTextBox: plateCheckSettings"></div>

                                            </div>
                                        </div>
                                        <div style="display: none" class="plate2Div">

                                    
                                        <div class="stats">
                                            <div>
                                                <div class="sub-title">차량 번호</div>
                                                <div class="stat-value" id="plateNo2"></div>
                                            </div>

                                            <div>
                                                <div class="sub-title">소유자</div>
                                                <div class="stat-value" id="owner2"></div>
                                            </div>
                                        </div>
                                        <div>
                                            <input type="hidden" id="payDetial">
                                            <input type="hidden" id="serviceType">
                                            <input type="hidden" id="vehiceId">
                                            <input type="hidden" id="otherData">
                                           
                                        </div>
                                        <form action="{{ route('payment') }}" id="mainForm" method="POST">
                                            {{ csrf_field() }}
                                            <input  type="hidden" id="transactionId" name="transactionId">
                                            <div class="row">
                                            <div class="col-9">
                                                <input style="width:100%"  type="text" id="submitData" name="submitData">
                                            </div>
                                            <div class="col-3">
                                             
                                                <button type="button" id="yes" onclick="submitForm()" data-dismiss="modal" class="btn btn-success btn-block btnnopadding" style=" width: 80px; margin-left: 5px; margin-top: 0;">저장</button>

                                            </div>
                                        </div>
                                        </form>
                                    </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-lg-12 col-md-12 ">
                                    @if (isset($message) || session()->has('message'))
                                        @include('System.message')
                                    @endif

                                    {{-- @if (isset($payment))
                                @foreach ($payment as $item)
                                {{$item->name}}
                                @endforeach 
                                @endif --}}
                                    <center>
                                        <h3 style="color: green">확인된 결제 내역</h3>
                                    </center>


                                    <div id="paymentDataList"></div>



                                 




                                </div>
                            </div>
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
        <script src="{{ asset('lib/jQuery-Mask-Plugin-master/src/jquery.mask.js') }}"></script>
        <script src="{{ asset('js/vrs.js') }}"></script>
        <script src="{{ asset('js/avtoteever.js') }}"></script>
        <script src="{{ asset('lib/dev-extreme/js/dx.all.js')}}"></script>
        <script src="{{ asset('data.js') }}"></script>

        <script>
           
      
             function submitForm(){

                var checkVehPlate=$('#submitData').val();
                if (checkVehPlate !="") {
                    var result = confirm("이 작업을 수행하시겠습니까?");
                                if (result == true) {
                                    // $(".containerBody").fadeOut();
                                    // $(".loader14").fadeIn();
                                    $("#mainForm").submit();
                                }
                }else{
                    DevExpress.ui.notify(
                                        "변경할 차량 번호를 입력하세요!", 'error',
                                        2000);
                }
                
             }
            $(document).ready(function() {
              //  $(".containerBody").fadeOut();
      //  $(".avtoteeverPreloader").fadeIn();
                const passwordEditor = $('#plateCheck').dxTextBox({
                    onInput: function(e) {
                        var val = e.element.find(":input:not([type=hidden])")[0].value;

                        translate2MGL(val);
                    },
                    placeholder: '차량 번호',
                    mode: 'text',
                    // value: '번호판',
                    stylingMode: 'filled',
                    buttons: [{
                        name: '번호판',
                        location: 'after',
                        options: {
                            text: "검색",
                            type: 'default',
                            onClick() {
                                if (passwordEditor._changedValue == "") {
                                    DevExpress.ui.notify(
                                        "변경할 차량 번호를 입력하세요!", 'error',
                                        2000);
                                } else {
                                    const vehPlateNo=passwordEditor._changedValue;
                                    $.ajax({
                                        type: 'post',
                                        url: vrsUrl('/api/vehCheck'),
                                        dataType: "json",
                                        data: {
                                            param:0,
                                            param1: vehPlateNo,
                                            param2: '{{ \App\Http\Controllers\BaseController::enc(\Carbon\Carbon::now()->format('Y-m-d')) }}'
                                        },
                                        timeout: 60000,
                                        error: function(data) {
                                         //   $(".avtoteeverPreloader").fadeOut();
                                          //  $(".containerBody").fadeIn();
                                        },
                                        success: function(data) {
                                        //    $(".avtoteeverPreloader").fadeOut();
                                        //    $(".containerBody").fadeIn();

                                            if (data.length > 0) {
                                                $( ".plate2Div" ).css( "display", "block" );
                                                $('#vehiceId').val(data[0].id);
                                                $('#plateNo2').text(data[0].plate_no);
                                                $('#cabinNo2').text(data[0].cabin_no);

                                                $('#owner2').text( data[0].first_name);
                                               

                                  const  payDetial= $('#payDetial').val();
                                  const  serviceType= $('#serviceType').val();
                                  const  otherData= $('#otherData').val();
                                  const  vehiceId= $('#vehiceId').val();
                                  
                                            $('#submitData').val(payDetial+" "+serviceType+"-"+vehiceId+otherData);          
                                            }
                                        }
                                    });
                                  //  alert(passwordEditor._changedValue);
                                }
                                //console.log(passwordEditor._changedValue);
                            },
                        },
                    }],
                }).dxTextBox('instance');



                $.ajax({
                    type: 'POST',
                    url: vrsUrl('/api/paymentData'),
                    dataType: "json",
                    data: {
                        // param1: "param",
                        param: '{{ \App\Http\Controllers\BaseController::enc(\Carbon\Carbon::now()->format('Y-m-d')) }}'
                    },
                    timeout: 60000,
                    error: function(data) {
                        // $(".avtoteeverPreloader").fadeOut();
                        // $(".containerBody").fadeIn();
                    },
                    success: function(data) {
                        try {
                            console.log("API Response:", data);
                            console.log("paymentData:", data[0] ? data[0]['paymentData'] : 'undefined');
                            console.log("transaction:", data[1] ? data[1]['transaction'] : 'undefined');
                            if (data.length > 0) {
                                $(".avtoteeverPreloader").fadeOut();
                                 $(".containerBody").fadeIn();
                            }
                            const dataGrid = $('#paymentDataList').dxDataGrid({
                                dataSource: data[0]['paymentData'] || [],
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
                                    pageSize: 10,
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
                                            cellElement.text(cellInfo.row.rowIndex -
                                                parseInt(-1))
                                        }
                                        // width: 80,
                                    },

                                    {
                                        dataField: 'related_account',
                                        caption: '계좌 번호',
                                    },
                                    {
                                        dataField: 'owner_name',
                                        caption: '계좌 명의',
                                    },
                                    {
                                        dataField: 'description',
                                        caption: '거래 내역',
                                    },
                                    {
                                        dataField: 'amount',
                                        caption: '결제 금액',
                                    },
                                    {
                                        dataField: 'transaction_date',
                                        caption: '결제 시간',
                                    },

                                    {
                                        dataField: 'plate_no',
                                        caption: '차량 번호',
                                    },

                                    {
                                        dataField: 'arkhive_no',
                                        caption: '아카이브',
                                        // calculateCellValue: function(rowData) {
                                        //     return rowData.new_owner_info.lastname != null ? rowData.new_owner_info.lastname.substring(0, 1) +
                                        //         "." + rowData.new_owner_info.firstname : "-";
                                        // }
                                    },
                                    {
                                        dataField: 'name',
                                        caption: '서비스',

                                    },
                                    {
                                        dataField: 'created_at',
                                        caption: '작업 일자',

                                    },

                                    // {
                                    //     dataField: 'is_paid',
                                    //     caption: '결제',
                                    //     // calculateCellValue: function(rowData) {
                                    //     //     return rowData.is_paid == 0 ? "미납" : "납부";
                                    //     // }
                                    //     cellTemplate: function(element, info) {
                                    //         info.text == 0 ? element.append("<div>미납</div>")
                                    //             .css("color", "red") : element.append(
                                    //                 "<div>납부</div>")
                                    //             .css("color", "green");
                                    //     }
                                    // },

                                ],
                            }).dxDataGrid('instance');
                            const transaction = $('#transaction').dxDataGrid({
                                dataSource: data[1] ? data[1]['transaction'] || [] : [],
                                keyExpr: 'id',
                                showColumnLines: true,
                                showRowLines: true,
                                rowAlternationEnabled: false,
                                showBorders: true,
                                columnAutoWidth: true,
                                remoteOperations: true,
                                focusedRowEnabled: true,
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
                                    pageSize: 10,
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
                                            cellElement.text(cellInfo.row.rowIndex -
                                                parseInt(-1))
                                        }
                                        // width: 80,
                                    },

                                    {
                                        dataField: 'related_account',
                                        caption: '계좌 번호',
                                    },
                                    {
                                        dataField: 'owner_name',
                                        caption: '계좌 명의',
                                    },
                                    {
                                        dataField: 'description',
                                        caption: '거래 내역',
                                    },
                                    {
                                        dataField: 'transaction_date',
                                        caption: '결제 시간',
                                    },
                                    {
                                        dataField: 'amount',
                                        caption: '결제 금액',
                                    },






                                    // {
                                    //     dataField: 'is_paid',
                                    //     caption: '결제',
                                    //     // calculateCellValue: function(rowData) {
                                    //     //     return rowData.is_paid == 0 ? "미납" : "납부";
                                    //     // }
                                    //     cellTemplate: function(element, info) {
                                    //         info.text == 0 ? element.append("<div>미납</div>")
                                    //             .css("color", "red") : element.append(
                                    //                 "<div>납부</div>")
                                    //             .css("color", "green");
                                    //     }
                                    // },

                                ],
                                onSelectionChanged(selectedItems) {
                                    const dataList = selectedItems.selectedRowsData[0];
                                    const myArray = dataList.description.split(/[\s,]+/);
                                    const payData = myArray[2];
                                    const data = payData.split(/[-_]+/);
                                    const serviceType = data[0];
                                    const vehicle_id = data[1];
                                    const dataId = data[2];

                                    // console.log(myArray);
                                    // console.log(payData);
                                    // console.log(data);
                                    // console.log(serviceType);
                                    $( ".plate2Div" ).css( "display", "none" );
                                    $( ".plateInfoSearch" ).css( "display", "block" );
                                    var serviceName;
                                    $('#description').text(dataList.description );
                                    switch (serviceType) {
                                        case "VRS":
                                        serviceName ="신규 차량";
                                            break;
                                        case "VRS2":
                                        serviceName ="명의 변경";
                                            break;
                                        case "VRS3":
                                        serviceName ="번호판 변경 포함 명의 변경";
                                            break;
                                        case "VRS4":
                                        serviceName ="번호판 변경";
                                            break;
                                        case "VRS6":
                                        serviceName ="이륜차 등록증 재발급";
                                            break;
                                        case "VRS5":
                                        serviceName ="이륜차 번호판 재발급";
                                            break;
                                        case "VRS7":
                                        serviceName ="이륜차/기계 기술적 변경";
                                            break;
                                        case "VRS8":
                                        serviceName ="이륜차/기계 신규";
                                            break;
                                        case "VRS9":
                                        serviceName ="Мото,МЕХ, 신규";
                                            break;
                                        case "VRS10":
                                        serviceName ="이륜차/기계/트레일러 명의 변경";
                                            break;
                                        case "VRS11":
                                        serviceName ="말소";
                                            break;
                                    
                                        default:
                                            break;
                                    }
                                    $('#serviceName').text(serviceName );
                                    $('#transactionId').val(dataList.id );
                                   
                                    $('#serviceType').val(serviceType);
                                    $('#payDetial').val(myArray[0]+" "+myArray[1]);
                                    $('#otherData').val("_"+data[2]+" "+myArray[3]+" "+myArray[4]);
                                    
                                   
                                    $.ajax({
                                        type: 'post',
                                        url: vrsUrl('/api/vehCheck'),
                                        dataType: "json",
                                        data: {
                                            param:1,
                                            param1: vehicle_id,
                                            param2: '{{ \App\Http\Controllers\BaseController::enc(\Carbon\Carbon::now()->format('Y-m-d')) }}'
                                        },
                                        timeout: 60000,
                                        error: function(data) {
                                            $(".avtoteeverPreloader").fadeOut();
                                            $(".containerBody").fadeIn();
                                        },
                                        success: function(data) {
                                           // console.log(data);

                                            if (data.length > 0) {
                                                $('#plateNo').text(data[0].plate_no);
                                                $('#cabinNo').text(data[0].cabin_no);

                                                $('#owner').text( data[0].first_name);
                                              
                                            }
                                        }
                                    });
                                },
                            }).dxDataGrid('instance');

                        } catch (err) {

                        }
                    }
                });

            });

       
            $(function(){
            'use strict'
            $( "#restrictDate" ).datepicker({
                changeMonth: true,
                changeYear: true
            });
            $( "#restrictDate" ).datepicker( "option", "dateFormat", "yy-mm-dd" );

            $('#userTable').DataTable({
                responsive: true,
                aaSorting: [],
                language: {
                    searchPlaceholder: '검색...',
                    sSearch: '',
                    lengthMenu: '_MENU_ 페이지당 표시',
                }
            });
            $( "#start" ).datepicker({
            changeMonth: true,
            changeYear: true
        });
        $( "#start" ).datepicker( "option", "dateFormat", "yy-mm-dd" );

        $( "#end" ).datepicker({
            changeMonth: true,
            changeYear: true
        });
        $( "#end" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
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
            // $(".avtoteeverPreloader").fadeOut();
            // $(".containerBody").fadeIn();
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

            var Cyr2Lat = {
                "Й": "a",
                "М": "b",
                "Ё": "c",
                "Б": "d",
                "У": "e",
                "Ө": "f",
                "А": "g",
                "Х": "h",
                "Ш": "i",
                "Р": "j",
                "О": "k",
                "Л": "l",
                "Т": "m",
                "И": "n",
                "О": "o",
                "З": "p",
                "Ф": "q",
                "Ж": "r",
                "Ы": "s",
                "Э": "t",
                "Г": "u",
                "С": "v",
                "Ц": "w",
                "Ч": "x",
                "Н": "y",
                "Я": "z",
                "Е": "-",
                "К": "[",
                "В": ".",
                "Д": ";",
                "П": "'",

                "Й": "A",
                "М": "B",
                "Ё": "C",
                "Б": "D",
                "У": "E",
                "Ө": "F",
                "А": "G",
                "Х": "H",
                "Ш": "I",
                "Р": "J",
                "О": "K",
                "Л": "L",
                "Т": "M",
                "И": "N",
                "Ү": "O",
                "З": "P",
                "Ф": "Q",
                "Ж": "R",
                "Ы": "S",
                "Э": "T",
                "Г": "U",
                "С": "V",
                "Ц": "W",
                "Ч": "X",
                "Н": "Y",
                "Я": "Z",
            };

            function translate2MGLTwo(id, word) {
                if (word) {
                    word = word.toUpperCase();
                }
                word = word.split('').map(function(char) {
                    return Lat2Cyr[char] || char;
                }).join("");
                $("#" + id).val(word);
            }

            function translate2MGL(word) {
                if (word) {
                    word = word.toUpperCase();
                }
                word = word.split('').map(function(char) {
                    return Lat2Cyr[char] || char;
                }).join("");
                $("#plateCheck").dxTextBox({
                    value: word
                })
                //return word;
            }

            function translate2LATIN(word) {
                if (word) {
                    word = word.toUpperCase();
                }
                word = word.split('').map(function(char) {
                    return Cyr2Lat[char] || char;
                }).join("");
                $("#cabin_no_id").val(word);
            }

            function translate2MGL_Register(word) {
                if (word) {
                    word = word.toUpperCase();
                }
                word = word.split('').map(function(char) {
                    return Lat2Cyr[char] || char;
                }).join("");
                $("#register_own").val(word);
            }
        </script>
    </div>

    <style>
         .avtoteeverPreloader {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url("/img/preloader.gif") center no-repeat #fff;
        }
        .container {
            position: relative;
        }

        .container,
        .left-content {
            min-height: 530px;
        }

        .left-content {
            display: inline-block;
            width: 180px;
            padding: 0 10px 10px;
            background-color: rgba(191, 191, 191, 0.15);
            box-shadow: -5px 0 14px -8px rgba(0, 0, 0, 0.25) inset;
        }

        .right-content {
            position: absolute;
            right: 0;
            left: 220px;
            top: 0;
            height: 100%;
        }

        sup {
            font-size: 0.8em;
            vertical-align: super;
            line-height: 0;
        }

        .right-content .sub-title {
            font-size: 90%;
            color: rgba(152, 152, 152, 0.8);
        }

        .title-container {
            min-height: 140px;
            margin-bottom: 10px;
        }

        .title-container .country-name {
            font-size: 240%;
            font-weight: bold;
            line-height: 34px;
            margin-bottom: 10px;
        }

        .title-container>div:not(.flag) {
            margin-left: 204px;
        }

        .stats {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }

        .stats>div {
            display: table-cell;
            text-align: center;
            border: 1px solid rgba(191, 191, 191, 0.25);
            padding: 20px 0 25px;
            width: 33%;
        }

        .stats>div:first-child,
        .stats>div:last-child {
            border-right-width: 0;
            border-left-width: 0;
        }

        .stats .stat-value {
            font-size: 150%;
        }

        #tabpanel {
            margin-top: 10px;
        }

        #tabpanel .dx-multiview-wrapper {
            border-left: 0;
            border-right: 0;
            border-bottom: 0;
        }

        #tabpanel .tab-panel-title {
            font-size: 120%;
            font-weight: 500;
        }

        #tabpanel .dx-multiview-item-content {
            padding: 20px 0 22px;
            min-height: 178px;
            position: relative;
        }

        #tabpanel .right-content {
            top: 15px;
            left: 202px;
        }

        #tabpanel .stats {
            width: 398px;
            margin-top: 20px;
            border-top: 1px solid rgba(191, 191, 191, 0.25);
        }

        #tabpanel .stats>div {
            padding: 7px 0;
            text-align: left;
            border: 0;
        }

        #tabpanel .stats>div:first-child {
            width: 40%;
        }

        #tabpanel .stats>div:not(:first-child) {
            width: 30%;
        }

        .flag {
            width: 172px;
            max-height: 122px;
            border: 1px solid rgba(191, 191, 191, 0.25);
            float: left;
            margin: 0 30px 10px 0;
        }

        #treeview .dx-treeview-node.dx-state-selected>.dx-item>.dx-item-content {
            font-weight: 500;
        }

    </style>
</body>

</html>
