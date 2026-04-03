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
                    <!--왼쪽 영역 시작-->
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <h6 class="card-title">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    {{ \App\Helpers\TranslationHelper::translate('УЛСЫН ДУГААРЫН ДЭВСГЭР ӨНГӨ ТАЙЛАН') }}
                                </div>
                            </div>
                        </h6>
                        <div class="row row-sm">
                            <div class="col-12 col-sm-1 col-lg">
                                <form action="{{ route('plateFactoryColor') }}" method="POST">
                                    {{ csrf_field() }}
                                    <div class="row row-sm">
                                        <div class="col-4">
                                            <div class="row row-xs align-items-center mg-b-5">
                                                <div class="col-lg-5 col-md-12 col-sm-12">
                                                    <label class="form-label mg-b-0 required-input">{{ \App\Helpers\TranslationHelper::translate('Дугаарын өнгө сонгох') }}</label>
                                                </div>
                                                <div class="col-lg-7 col-md-12 col-sm-12">
                                                    <select class="form-control select2" name="plateColor" value="{{ isset($plateColor) ? $plateColor : "" }}"> 
                                                 
                                                      
                                                                <option value="1">흰색</option>
                                                                <option value="2">노랑</option>
                                                                <option value="3">녹색</option>
                                                               
                                                                <option value="4">빨강</option>
                                                                <option value="5">검정</option>
                                                                <option value="6">파랑</option>
                                                               
                                                               
                                                      
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="row row-xs align-items-center mg-b-5">
                                                <div class="col-lg-5 col-md-12 col-sm-12">
                                                    <label class="form-label mg-b-0 required-input">{{ \App\Helpers\TranslationHelper::translate('Эхлэх огноо') }}</label>
                                                </div>
                                                <div class="col-lg-7 col-md-12 col-sm-12">
                                                    <input id="sdate" name="startDate" type="text" value="{{ isset($startDate) ? $startDate : "" }}" class="form-control fc-datepicker" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="row row-xs align-items-center mg-b-5">
                                                <div class="col-lg-5 col-md-12 col-sm-12">
                                                    <label class="form-label mg-b-0 required-input">{{ \App\Helpers\TranslationHelper::translate('Дуусах огноо') }}</label>
                                                </div>
                                                <div class="col-lg-7 col-md-12 col-sm-12">
                                                    <input id="edate" name="endDate" type="text" class="form-control fc-datepicker"  value="{{ isset($endDate) ? $endDate : "" }}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="row row-xs align-items-center mg-b-5">
                                                <div class="col-lg-4 col-md-12 col-sm-12">
                                                    <button type="submit" class="btn btn-primary btn-block btnnopadding">{{ \App\Helpers\TranslationHelper::translate('Хайх') }}</button>
                                                </div>
                                                <div class="col-lg-4 col-md-12 col-sm-12">
                                                    <button type="button" onclick="exportToExcel()" class="btn btn-primary btn-block btnnopadding"><i class="far fa-file-excel"></i> {{ \App\Helpers\TranslationHelper::translate('Excel') }}</button>
                                                </div>
                                                <div class="col-lg-4 col-md-12 col-sm-12">
                                                    <button type="button" onclick="clearFields()" class="btn btn-primary btn-block btnnopadding">{{ \App\Helpers\TranslationHelper::translate('Арилгах') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <hr class="mg-y-10">
                                <table id="referenceTable" class="display responsive nowrap" style="width:100%">
                                    <thead>
                                    <tr style="text-align: center;">
                                        <th>№</th>
                                        <th>{{ \App\Helpers\TranslationHelper::translate('Салбар') }}</th>
                                        <th>{{ \App\Helpers\TranslationHelper::translate('Нэр') }}</th>
                                        <th>{{ \App\Helpers\TranslationHelper::translate('Өнгө') }}</th>
                                        
                                        <th>{{ \App\Helpers\TranslationHelper::translate('Тоо хэмжээ') }}</th>
                                   
                                        <th>{{ \App\Helpers\TranslationHelper::translate('Огноо') }}</th>
                                        {{-- <th>상세</th> --}}
                                    </tr>
                                    </thead>
                                    <tbody style="text-align: center;">
                                    @if(ISSET($results))
                                        @foreach($results as $data)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $data->province_id }}</td>
                                                <td>{{ \App\Helpers\TranslationHelper::translate($data->first_name) }}</td>
                                                <td>
                                                    @if ($data->platecolor ==1 )
                                                        흰색
                                                        @elseif($data->platecolor ==2)
                                                        노랑
                                                        @elseif($data->platecolor ==3)
                                                        녹색
                                                        @elseif($data->platecolor ==4)
                                                        빨강
                                                        @elseif($data->platecolor ==5)
                                                        검정
                                                        @elseif($data->platecolor ==6)
                                                        파랑
                                                    
                                                        
                                                    @endif
                                                    
                                                    </td>
                                                
                                                <td>{{ $data->count }}</td>
                                                
                                             
                                                <td>{{ $data->create_date }}</td>
                                                {{-- <td> 
                                                  
                                                        <input type="hidden" id="getPrintId" value="{{$data->platecolor}}" name="print_id">
                                                        <input type="hidden" id="getStartDate" value="@if(ISSET($startDate)){{ $startDate }}@else{{ "none" }}@endif" name="startDate">
                                                        <input type="hidden" id="getEndDate" value="@if(ISSET($endDate)){{ $endDate }}@else{{ "none" }}@endif" name="endDate">
                                                        <a href="#factoryViewModal" data-toggle="modal" data-effect="effect-scale">
                                                    <button  data-id="{{$data->platecolor}}"  type="submit" class="btn  btn-primary" style="padding: 3px 13px;">
                                                    <i class="typcn typcn-eye  "></i>
                                                    </button>
                                                        </a>
                                           
                                            
                                            </td> --}}
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!--왼쪽 영역 끝-->
                </div>
            </div>
        </div>
        @include('Includes.footer')
    </div>
</div>
@include('Includes.helper')
<div id="factoryViewModal" class="modal printable">
    <div class="modal-dialog modal-dialog-centered" role="document" style=" max-width: 1050px; ">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">{{ \App\Helpers\TranslationHelper::translate('Номерын үйлдвэр дэлгэрэнгүй') }}</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               

                <div style="
                padding: 10px 7px;
                font-weight: 600;">@if(ISSET($startDate)){{ $startDate }}@else{{ "none" }}@endif -наас @if(ISSET($endDate)){{ $endDate }}@else{{ "none" }}@endif -까지 인쇄된 번호의 상세 정보
              </div>

                    <div class="row" style="border:0px solid black" >
                        <div class="col-12"  style="width:100%;" id="reportDetial"></div>
                      <div style="width:100%;     height: 500px; overflow-y: scroll;">
                         
                      
                        {{-- <table  id="referenceTable2" class="display responsive nowrap" style="width:100%;" >
                            <thead>
                               
                                <th>법인 등록번호</th>
                                <th>법인 명칭</th>
                                <th>인쇄된 번호</th>
                                <th>인쇄 번호 색상</th>
                                <th>인쇄 일자</th>
                                
                            </thead>
                         <tbody id="plateFactoryTable"></tbody>
                      </table> --}}
                     
                      </div>
                   
                     
                    </div>
               
            </div>
            <div class="modal-footer">
                <button id="button-excel" class="btn btn-primary"><i class="far fa-file-excel"></i> {{ \App\Helpers\TranslationHelper::translate('Excel') }}</button>
                <button type="button" class="btn btn-outline-light" data-dismiss="modal">{{ \App\Helpers\TranslationHelper::translate('Хаах') }}</button>

            </div>
        </div>
    </div>
</div>
<style>

.plateFactory{
    width: 111px;
    height: 33px;
    background: rgb(255 255 255);
    border: 5px solid;
    text-align: center;
    font-weight: 700;
    border-style: double;
    padding: 3px; 
    border-color: #040404;
    color: #0e0e0e;
    border-radius: 4px;
}
.plateFactoryYellow{
    width: 111px;
    height: 33px;
    background: rgb(185 167 14);
    border: 5px solid;
    text-align: center;
    font-weight: 700;
    border-style: double;
  
    padding: 3px;
    border-color: #fff;
    color: #fff;
    border-radius: 4px;
}
.plateFactoryGreen{
    width: 111px;
    height: 33px;
    background: rgb(8 162 70);
    border: 5px solid;
    text-align: center;
    font-weight: 700;
    border-style: double;
    padding: 3px;
    border-color: #fff;
    color: #fff;
    border-radius: 4px;
}
.plateFactoryRed{
    width: 111px;
    height: 33px;
    background: rgb(212 10 10);
    border: 5px solid;
    text-align: center;
    font-weight: 700;
    border-style: double;
    padding: 3px;
    border-color: #fff;
    color: #fff;
    border-radius: 4px;
}
.plateFactoryBlack{
    border-radius: 4px;
    width: 111px;
    height: 33px;
    background: rgb(33 32 30);
    border: 5px solid;
    text-align: center;
    font-weight: 700;
    border-style: double;
    padding: 3px;
    border-color: #fff;
    color: #fff;
    border-radius: 4px;
}
</style>
<script src="{{ asset('js/tableExport.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/plateFactory.css') }}">
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
<script src="{{ asset('lib/dev-extreme/js/dx.all.js')}}"></script>
<script src="{{ asset('js/vrs.js') }}"></script>
<script src="{{ asset('js/avtoteever.js') }}"></script>
<script>

//     let button = document.querySelector("#button-excel");
   
//    button.addEventListener("click", e => {
//   let table = document.querySelector("#simpleTable");
//   TableToExcel.convert(table);

// });
// button.addEventListener("click", e => {
// let table = document.querySelector("#referenceTable");
//   TableToExcel.convert(table);

// });
</script>
<script>


    $(document).on('click', 'button[data-id]', function (e) {
        var print_id = $(this).attr('data-id');
        var startDate =document.getElementById("getStartDate").value;
        var endDate =document.getElementById("getEndDate").value;
       // console.log(requested_to);
        // Do whatever else you need to do.
        $.ajax({
           
            url : "{{ route( 'plateFactoryView' ) }}",
            data: {
              "_token": "{{ csrf_token() }}",
              print_id: print_id,
              startDate:startDate,
              endDate:endDate
              },
            type: 'post',
            dataType: 'json',
            success: function( result )
            {
              //  console.log(result);
                const dataGrid = $('#reportDetial').dxDataGrid({
                                dataSource: result,
                                keyExpr: 'print_id',
                                showColumnLines: true,
                                showRowLines: true,
                                rowAlternationEnabled: false,
                                showBorders: true,
                                columnAutoWidth: true,
                                remoteOperations: true,
                                width:500,

                                filterRow: {
                                    visible: false,
                                    applyFilter: 'auto',
                                },
                                searchPanel: {
                                    visible: true,
                                    width: 250,
                                    placeholder: '검색...',
                                },
                                headerFilter: {
                                    visible: false,
                                },
                                paging: {
                                    enabled: true,
                                    pageSize: 15,
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
                                //     <th>법인 등록번호</th>
                                // <th>법인 명칭</th>
                                // <th>인쇄된 번호</th>
                                // <th>인쇄 번호 색상</th>
                                // <th>인쇄 일자</th>
                                {
                                        dataField: 'plate_no',
                                        caption: '{{ \App\Helpers\TranslationHelper::translate('Хэвлэсэн дугаар') }}',
                                    },
                                    {
                                        dataField: 'dep_register',
                                        caption: '{{ \App\Helpers\TranslationHelper::translate('Хуулийн этгээдийн регистрийн дугаар') }}',
                                    },
                                    {
                                        dataField: 'firstname',
                                        caption: '{{ \App\Helpers\TranslationHelper::translate('Хуулийн этгээдийн нэр') }}',
                                    },
                                    {
                                        dataField: 'dep_director',
                                        caption: '{{ \App\Helpers\TranslationHelper::translate('Дарга') }}',
                                    },
                                    {
                                        dataField: 'phone',
                                        caption: '{{ \App\Helpers\TranslationHelper::translate('Утас') }}',
                                    },
                                    {
                                        dataField: 'dep_director',
                                        caption: '{{ \App\Helpers\TranslationHelper::translate('Хэвлэгдсэн дугаар') }}',
                                    },
                                   
                                    {
                                        dataField: 'update_date',
                                        caption: '{{ \App\Helpers\TranslationHelper::translate('Хэвлэсэн огноо') }}',
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
    
                  
                //     $("#plateFactoryTable").html("");
                //     $.each(result, function (key, value) {
                //        // console.log(value);
                //        var platecolor =value.platecolor;
                //        var color=[];
                //        var plateBackground=[];
                //        if(value.platecolor==1){
                //              color.push("번호판 바탕색 흰색");
                //              plateBackground.push("plateFactory");
                //         }else if(value.platecolor==2){
                //              color.push("번호판 바탕색 노랑");
                //              plateBackground.push("plateFactoryYellow");
                //         }else if(value.platecolor==3){
                //              color.push("번호판 바탕색 녹색");
                //              plateBackground.push("plateFactoryGreen");
                //         }else if(value.platecolor==4){
                //             color.push("번호판 바탕색 빨강");
                //             plateBackground.push("plateFactoryRed");
                             
                //         }else if(value.platecolor==5){
                //                 color.push("번호판 바탕색 검정");
                //                 plateBackground.push("plateFactoryBlack");
                //         }else{
                //             color.push("이 번호를 인쇄할 때 색상을 선택하지 않았습니다");
                //             plateBackground.push("plateFactory");
                //          }
                //         var html =
                         


                //             '<tr>'+
                            
                //             '<td> ' + value.dep_register + ' </td>' +
                           
                //             '<td> ' + value.firstname + ' </td>' +
                //             '<td>' +'<div class='+plateBackground+'>'+ value.plate_no +'</div>' +' </td>' +
                            
                //             '<td> ' + color + ' </td>' +
                             
                //             '<td> ' + value.update_date + ' </td>' +
                //             '</tr>'
                           
                           
                           
                          
                //         $("#plateFactoryTable").append(html);
                // });
              
               
    
                
            }
          
             });  
    });
</script>

<script>
    $(function(){
        'use strict'
        $('.select2').select2({
            placeholder: '{{ \App\Helpers\TranslationHelper::translate('Бүх') }}',
        });
        $( "#sdate" ).datepicker({
            changeMonth: true,
            changeYear: true
        });
        $( "#edate" ).datepicker({
            changeMonth: true,
            changeYear: true
        });

        $( "#sdate" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
        $( "#edate" ).datepicker( "option", "dateFormat", "yy-mm-dd" );

        $('#referenceTable').DataTable({
            responsive: true,
            language: {
                searchPlaceholder: '{{ \App\Helpers\TranslationHelper::translate('Хайх') }}...',
                sSearch: '',
                lengthMenu: '_MENU_ {{ \App\Helpers\TranslationHelper::translate('-1 хуудас дахь мөр') }}',
            }
        });
        $('#referenceTable2').DataTable({
            responsive: true,
            language: {
                searchPlaceholder: '{{ \App\Helpers\TranslationHelper::translate('Хайх') }}...',
                sSearch: '',
                lengthMenu: '_MENU_ {{ \App\Helpers\TranslationHelper::translate('-1 хуудас дахь мөр') }}',
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

    $( document ).ready(function() {
        @if(ISSET($startDate))
$("#sdate").val('{{ $startDate }}');
        @else
$("#sdate").val('{{ \Carbon\Carbon::now()->format("Y-m-01") }}');
        @endif

        @if(ISSET($endDate))
$("#edate").val('{{ $endDate }}');
        @else
$("#edate").val('{{ \Carbon\Carbon::now()->format("Y-m-d") }}');
        @endif

$(".avtoteeverPreloader").fadeOut();
        $(".containerBody").fadeIn();
    });

    function clearFields() {
        $("#sdate").val('{{ \Carbon\Carbon::now()->format("Y-m-01") }}');
        $("#edate").val('{{ \Carbon\Carbon::now()->format("Y-m-d") }}');
    }

    function exportToExcel() {
        $(".containerBody").fadeOut();
        $(".avtoteeverPreloader").fadeIn();
        $.ajax({
            type: "GET",
            url: "/api/report/exportToExcelFlateColor/@if(ISSET($plateColor)){{$plateColor}}@else{{"none"}}@endif/@if(ISSET($startDate)){{ $startDate }}@else{{ "none" }}@endif/@if(ISSET($endDate)){{ $endDate }}@else{{ "none" }}@endif",
            success: function (data) {
              
              
            //  console.log(data);
                @if(ISSET($startDate))
                    $(".avtoteeverPreloader").fadeOut();
                    $(".containerBody").fadeIn();
                    window.location = "/api/report/exportToExcelFlateColor/@if(ISSET($plateColor)){{$plateColor}}@else{{"none"}}@endif/@if(ISSET($startDate)){{ $startDate }}@else{{ "none" }}@endif/@if(ISSET($endDate)){{ $endDate }}@else{{ "none" }}@endif";
                @else
                    $(".avtoteeverPreloader").fadeOut();
                    $(".containerBody").fadeIn();
                    alert("보고서 시작·종료 일자를 선택하세요!");
                @endif
            }
        });
    }
</script>
</body>
</html>
