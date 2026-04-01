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
                        <h6 class="card-title">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    신규 부서 및 지점 등록
                                </div>
                            </div>
                        </h6>
                        <form action="{{ route("refdepartment") }}" method="POST">
                            {{ csrf_field() }}
                            <div class="row">
                                <!--왼쪽 영역 시작-->
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    @if(ISSET($message) || session()->has("message"))
                                        @include("System.message")
                                    @endif
                                    <input type="text" name="env" style="display: none;" value="{{ isset($department) ? \App\Http\Controllers\BaseController::enc($department->id) : "" }}">
                            

                                    <div class="row row-xs align-items-center mg-b-5">
                                        <div class="col-lg-6 col-md-12 col-sm-12">
                                            <label class="form-label mg-b-0 required-input">부서 유형</label>
                                        </div>
                                        <div class="col-lg-6 col-md-12 col-sm-12">
                                           
                                            <select class="form-control select2" name="systemDepType" id="systemDepType" > required>
                                                <option value=""></option>
                                                @if(ISSET($systemDepType1))
                                                    @foreach($systemDepType1 as $systemDepType)
                                                        <option value="{{ $systemDepType->id }}" {{ isset($department) ? ($department->deptype_id == $systemDepType->id ? "selected" : "") : "" }}>{{ $systemDepType->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>

                                        </div>
                                    </div>


                                    <div class="row row-xs align-items-center mg-b-5">
                                        <div class="col-lg-6 col-md-12 col-sm-12">
                                            <label class="form-label mg-b-0 required-input">도시/도</label>
                                        </div>
                                        <div class="col-lg-6 col-md-12 col-sm-12">
                                            <select id="province" name="province" required class="form-control select2">
                                                <option label="선택하세요"></option>
                                                @if(ISSET($provinces))
                                                    @foreach($provinces as $province)
                                                        <option value="{{ $province->id }}" {{ isset($department) ? ($department->province_id == $province->id ? "selected" : "") : "" }}>{{ $province->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row row-xs align-items-center mg-b-5">
                                        <div class="col-lg-6 col-md-12 col-sm-12">
                                            <label class="form-label mg-b-0 required-input">이름</label>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <input type="text" name="name" value="{{ isset($department) ? $department->name : "" }}" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <!------->

                                <div class="col-lg-6 col-md-6 col-sm-12" id="plateFactory" style="visibility: hidden;">
                                    <div class="row row-xs align-items-center mg-b-5">
                                        <div class="col-lg-4 col-md-3 col-sm-12">
                                            <label class="form-label mg-b-0 required-input">면허 번호</label>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <input type="text" id="license_no" name="license_no" value="{{ isset($department) ? $department->comp_license_number : "" }}"  class="form-control">
                                        </div>
                                    </div>

                                    <div class="row row-xs align-items-center mg-b-5">
                                        <div class="col-lg-4 col-md-3 col-sm-12">
                                            <label class="form-label mg-b-0 required-input">면허 시작일</label>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <input type="text" id="license_start" name="license_start" value="{{ isset($department) ? $department->comp_license_start : "" }}"  class="form-control">
                                        </div>
                                    </div>

                                    <div class="row row-xs align-items-center mg-b-5">
                                        <div class="col-lg-4 col-md-3 col-sm-12">
                                            <label class="form-label mg-b-0 required-input">면허 종료일</label>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <input type="text" id="license_end" name="license_end" value="{{ isset($department) ? $department->comp_license_end : "" }}"  class="form-control">
                                        </div>
                                    </div>


                                    <div class="row row-xs align-items-center mg-b-5">
                                        <div class="col-lg-4 col-md-3 col-sm-12">
                                            <label class="form-label mg-b-0 required-input">사업자 등록 번호</label>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <input type="text" id="comp_register" name="comp_register" value="{{ isset($department) ? $department->comp_register : "" }}"  class="form-control">
                                        </div>
                                    </div>

                                    {{--  <div class="row row-xs align-items-center mg-b-5">
                                        <div class="col-lg-4 col-md-3 col-sm-12">
                                            <label class="form-label mg-b-0 required-input">사업체 이름</label>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <input type="text" id="comp_name" name="comp_name" value=""  class="form-control">
                                        </div>
                                    </div>  --}}

                                    <div class="row row-xs align-items-center mg-b-5">
                                        <div class="col-lg-4 col-md-3 col-sm-12">
                                            <label class="form-label mg-b-0 required-input">관리자 이름</label>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <input type="text" id="comp_director" name="comp_director" value="{{ isset($department) ? $department->comp_director : "" }}"  class="form-control">
                                        </div>
                                    </div>

                                    <div class="row row-xs align-items-center mg-b-5">
                                        <div class="col-lg-4 col-md-3 col-sm-12">
                                            <label class="form-label mg-b-0 required-input">회사 전화번호</label>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <input type="text" id="comp_phone" name="comp_phone" value="{{ isset($department) ? $department->comp_phone : "" }}"  class="form-control">
                                        </div>
                                    </div>

                                    <div class="row row-xs align-items-center mg-b-5">
                                        <div class="col-lg-4 col-md-3 col-sm-12">
                                            <label class="form-label mg-b-0 required-input">회사 주소</label>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <input type="text" id="comp_address" name="comp_address" value="{{ isset($department) ? $department->comp_address : "" }}"  class="form-control">
                                        </div>
                                    </div>

                                </div>
                                <!------->
                            </div>
                           
                            {{--<hr class="mg-y-10">--}}
                            <div class="row">
                                <div class="col-lg-4 col-md-6 col-sm-6"></div>
                                <div class="col-lg-2 col-md-6 col-sm-6">
                                    <button class="btn btn-primary btn-block" >{{ isset($department) ? "수정" : "등록" }}</button>
                                </div>
                                {{--<div class="col-lg-2 col-md-6 col-sm-6">--}}
                                {{--<button class="btn btn-outline-primary btn-block">확인</button>--}}
                                {{--</div>--}}
                            </div>
                        </form>

                        <hr class="mg-y-10">
                        <div class="" style="width: 100%">
                            <h6 class="card-title">부서 목록</h6>
                            <div class="row row-sm">
                                <div class="col-12 col-sm-1 col-lg">
                                    <table id="referenceTable" class="display responsive nowrap" style="width:100%;text-align: center;">
                                        <thead>
                                        <tr>
                                            <th>도시/도</th>
                                            <th>이름</th>
                                            <th>작업</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(ISSET($departments))
                                            @foreach($departments as $department)
                                                <tr>
                                                    <td>{{ $department->province_name }}</td>
                                                    <td>{{ $department->name }}</td>
                                                    <td>
                                                        <a href="/reference/department/edit/{{ \App\Http\Controllers\BaseController::enc($department->id) }}">
                                                            <i class="typcn typcn-edit text-primary"></i>
                                                        </a>
                                                        <a style="cursor: pointer;" onclick="if(confirm('이 기록을 삭제하시겠습니까?')){
                                                                window.location='/reference/department/delete/{{ \App\Http\Controllers\BaseController::enc($department->id) }}'
                                                                } return false;">
                                                            <i class="typcn typcn-trash text-warning"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
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

        var license_no =  document.getElementById("license_no").value;
        if(license_no !=""){
        document.getElementById("plateFactory").style.visibility = "visible";

        }
    </script>
    <script>
        $(function(){
            
            
        
            $('#systemDepType').change(function(){
               // $("#state option").remove();
            //  alert("ffddf");
               var id =  document.getElementById("systemDepType").value;
               var proviceId =  document.getElementById("province").value;
              // alert(proviceId);
               if(id==4){

                document.getElementById("plateFactory").style.visibility = "visible";
               
               // $("#license_no").attr("required");
                document.getElementById('license_no').required = true;
                document.getElementById('license_start').required = true;
                document.getElementById('license_end').required = true;
                document.getElementById('comp_director').required = true;
                document.getElementById('comp_phone').required = true;
                document.getElementById('comp_register').required = true;
               }else{
                document.getElementById("plateFactory").style.visibility = "hidden"; 
                document.getElementById('license_no').required = false;
                document.getElementById('license_start').required = false;
                document.getElementById('license_end').required = false;
                document.getElementById('comp_director').required = false;
                document.getElementById('comp_phone').required = false;
                document.getElementById('comp_register').required = false;
               }
         
            });
           
        });


    </script>
    <script>
        $(function(){
            'use strict'

            $('.select2').select2({
                placeholder: '선택하세요'
            });

            $( "#restrictDate" ).datepicker({
                changeMonth: true,
                changeYear: true
            });
            $( "#restrictDate" ).datepicker( "option", "dateFormat", "yy-mm-dd" );

            $('#referenceTable').DataTable({
                responsive: true,
                aaSorting: [],
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
                    lengthMenu: '_MENU_ 페이지당 표시',
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
