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
                <div class="col-lg-9 col-md-12 col-sm-12">
                    {{--<div class="card card-body card-dashboard-twentyfive mg-b-20">--}}

                    {{--</div>--}}
                    <h6 class="card-title">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                               보관 번호 목록
                            </div>
                        </div>
                    </h6>
                    @if(ISSET($message) || session()->has("message"))
                    @include("System.message")
                @endif
                 
                    <div class="row row-sm">
                        <div class="col-12 col-sm-1 col-lg">
                            <form action="{{ route("plateOrderList") }}" method="POST">
                                {{ csrf_field() }}
                                <div class="row row-sm">
                                
                                    <div class="col-4">
                                        <div class="row row-xs align-items-center mg-b-5">
                                            <div class="col-lg-4 col-md-12 col-sm-12">
                                                <label class="form-label mg-b-0 ">차량 번호</label>
                                            </div>
                                            <div class="col-lg-8 col-md-12 col-sm-12">
                                                <input id="plateNo" name="plateNo" oninput="this.value = this.value.toUpperCase()" onkeyup="edValueKeyPress(1)" value="{{isset($plateNo) ?  $plateNo : ''}}"  type="text" class="form-control" placeholder="차량 번호...">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="row row-xs align-items-center mg-b-5">
                                            <div class="col-lg-4 col-md-12 col-sm-12">
                                                <label class="form-label mg-b-0 ">등록 번호</label>
                                            </div>
                                            <div class="col-lg-8 col-md-12 col-sm-12">
                                                <input id="regNo" name="regNo" oninput="this.value = this.value.toUpperCase()" onkeyup="edValueKeyPress(2)" value="{{isset($regNo) ?  $regNo : ''}}" type="text" class="form-control" placeholder="등록 번호...">
                                            </div>
                                        </div>
                                    </div>
                                  
                                    <div class="col-3">
                                        <div class="row row-xs align-items-center mg-b-5">
                                            <div class="col-lg-4 col-md-12 col-sm-12">
                                                <button type="submit" class="btn btn-primary btn-block btnnopadding">검색</button>
                                            </div>
                                           
                                            <div class="col-lg-4 col-md-12 col-sm-12">
                                                <button type="button" onclick="clearFields()" class="btn btn-primary btn-block btnnopadding">초기화</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <hr class="mg-y-10">
                            <table id="referenceTable" class="display responsive table" style="width:100%;">
                                <thead>
                                <tr>
                                    <th>차량 번호</th>
                                    <th>차대번호</th>
                                    <th>성씨</th>
                                    <th>이름</th>
                                    <th>등록번호</th>                                 
                                    <th>주문 전문가</th>
                                    <th>주문일</th>
                                    <th>취소</th>
                                    {{-- <th>작업</th> --}}
                                </tr>
                                </thead>
                                <tbody>
                                @if($plateNumberOrderList)
                                    @foreach($plateNumberOrderList as $plateNumberOrderList)
                                   
                                    {{-- {{var_dump($plateNumberOrderList)}} --}}
                                        <tr>
                                      
                                            <td>{{ $plateNumberOrderList->plate_no }}
                                             </td> 
                                            <td>{{ $plateNumberOrderList->cabin }}</td>
                                           
                                            <td>{{ App\Helpers\TranslationHelper::translate($plateNumberOrderList->customer_lastname) }}</td>
                                            <td>{{ App\Helpers\TranslationHelper::translate($plateNumberOrderList->customer_firstname) }}</td>
                                            <td>{{ $plateNumberOrderList->customer_regnum }}</td>
                                            <td>{{ \Illuminate\Support\Str::limit(App\Helpers\TranslationHelper::translate($plateNumberOrderList->lastname), 1, $end='.') }} {{ App\Helpers\TranslationHelper::translate($plateNumberOrderList->firstname)}}</td>                                   
                                            <td> {{ $plateNumberOrderList->create_date}}</td>
                                            <td>
                                                @if (session()->get('auth')->id == $plateNumberOrderList->created_by)
                                                <form id="editForm" action="{{ route('plateOrderCancel') }}"  method="POST" onsubmit="confirmBeforeSubmit(event)" >
                                                    {{ csrf_field() }}
                                                    <input name="plateSaveId" value="{{ $plateNumberOrderList->id }}" style="display:none"/>
                                                    <input name="plateNo" value="{{ $plateNumberOrderList->plate_no }}" style="display:none"/>
                                                    <input name="plateCabin" value="{{ $plateNumberOrderList->cabin }}" style="display:none"/>
                                                    <button type="submit" class="btn" > <i class="typcn typcn-delete text-danger" style="font-size: 18px"></i></button>
                                                   
                                                </form>
                                                @else
                                                    
                                                @endif
                                               
                                            
                                            </td>
                                        
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                    
                        </div>
                    </div>
                </div>
                <!--왼쪽 영역 끝-->
                <div class="col-lg-3 col-md-6 col-sm-12">
                    @include('Includes.platesavemenu')
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
      function confirmBeforeSubmit(event) {
      const confirmed = confirm("이 번호의 주문을 취소하시겠습니까?");
      if (!confirmed) {
        event.preventDefault(); // Stop the form from submitting
      }
    }
    function edValueKeyPress(type) {
       // console.log(type);
        if (type == 1) {
            var edValue = document.getElementById("plateNo");
            var s = edValue.value;
            var lblValue = document.getElementById("regNo");
            lblValue.value = "";
        } else {
            var edValue = document.getElementById("regNo");
            var s = edValue.value;
            var lblValue = document.getElementById("plateNo");
            lblValue.value = "";
        }

   
}
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

        $('#searchResult').DataTable({
            responsive: true,
            bFilter: false,
            bLengthChange: false,
            language: {
                searchPlaceholder: '검색...',
                sSearch: '',
                lengthMenu: '_MENU_ 1/페이지에 표시',
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
    $(document).ready(function () {
        $(".avtoteeverPreloader").fadeOut();
        $(".containerBody").fadeIn();
    });
</script>
</div>
</body>
</html>
