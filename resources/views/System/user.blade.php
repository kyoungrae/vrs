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
                    <div class="col-12 col-sm-12 col-lg-12 col-md-12 ">
                        <h6 class="card-title">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    {{ isset($user) ? "사용자 수정" : "사용자 등록" }}
                                </div>
                            </div>
                        </h6>
                        <form action="{{ route("user") }}" method="POST">
                            {{ csrf_field() }}
                            <div class="row">
                                <!--왼쪽 영역 시작-->
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    @if(ISSET($message) || session()->has("message"))
                                        @include("System.message")
                                    @endif
                                    <input type="text" name="env" style="display: none;" value="{{ isset($user) ? \App\Http\Controllers\BaseController::enc($user->id) : "" }}" class="form-control">
                                    <div class="row row-xs align-items-center mg-b-5">
                                        <div class="col-lg-6 col-md-12 col-sm-12">
                                            <label class="form-label mg-b-0 required-input">성</label>
                                        </div>
                                        <div class="col-lg-6 col-md-12 col-sm-12">
                                            <input type="text" id="lastName" name="lastName" value="{{ isset($user) ? $user->lastname : "" }}" required class="form-control">
                                        </div>
                                    </div>
                                    <div class="row row-xs align-items-center mg-b-5">
                                        <div class="col-lg-6 col-md-12 col-sm-12">
                                            <label class="form-label mg-b-0 required-input">이름</label>
                                        </div>
                                        <div class="col-lg-6 col-md-12 col-sm-12">
                                            <input type="text" id="firstName" name="firstName" value="{{ isset($user) ? $user->firstname : "" }}" required class="form-control">
                                        </div>
                                    </div>
                                    <div class="row row-xs align-items-center mg-b-5">
                                        <div class="col-lg-6 col-md-12 col-sm-12">
                                            <label class="form-label mg-b-0 required-input">사용자 이름</label>
                                        </div>
                                        <div class="col-lg-6 col-md-12 col-sm-12">
                                            <input type="text" name="userName" value="{{ isset($user) ? $user->username : "" }}" required class="form-control">
                                        </div>
                                    </div>
                                    <div class="row row-xs align-items-center mg-b-5">
                                        <div class="col-lg-6 col-md-12 col-sm-12">
                                            <label class="form-label mg-b-0">비밀번호</label>
                                        </div>
                                        <div class="col-lg-6 col-md-12 col-sm-12">
                                            <input type="password" name="password" value="{{ isset($user) ? "" : "" }}" class="form-control">
                                        </div>
                                    </div>



                                    <div class="row row-xs align-items-center mg-b-5">
                                        <div class="col-lg-6 col-md-12 col-sm-12">
                                            <label class="form-label mg-b-0 required-input ">지점</label>
                                        </div>
                                        <div class="col-lg-6 col-md-12 col-sm-12">
                                            <select class="form-control select2" name="systemDepType" id="systemDepType">
                                                <option value=""></option>
                                                @if(ISSET($systemDepType))
                                                    @foreach($systemDepType as $systemDepType)
                                                        <option value="{{ $systemDepType->id }}">{{ $systemDepType->name }}</option>
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
                                    
                                            <select class="form-control select2 " name="province" id="branch" data-dependet="branch">
                                                @if(ISSET($provinces))
                                                    @foreach($provinces as $province)
                                                        <option value="{{ $province->id }}" {{ isset($user) ? ($province->id == $user->provinceid ? "selected" : "") : "" }}>{{ $province->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row row-xs align-items-center mg-b-5">
                                        <div class="col-lg-6 col-md-12 col-sm-12">
                                            <label class="form-label mg-b-0 required-input">부서</label>
                                        </div>
                                        <div class="col-lg-6 col-md-12 col-sm-12">
                                            {{--  <select class="form-control select2" name="department">
                                                @if(ISSET($departments))
                                                    @foreach($departments as $department)
                                                        <option value="{{ $department->id }}" {{ isset($user) ? ($department->id == $user->userdepartmentid ? "selected" : "") : "" }}>{{ $department->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>  --}}
                                            <select class="form-control select2" name="department" id="state"></select>
                                        </div>
                                    </div>
                                    <div class="row row-xs align-items-center mg-b-5">
                                        <div class="col-lg-6 col-md-12 col-sm-12">
                                            <label class="form-label mg-b-0 required-input">직위</label>
                                        </div>
                                        <div class="col-lg-6 col-md-12 col-sm-12">
                                            <select class="form-control select2" name="position">
                                                @if(ISSET($positions))
                                                    @foreach($positions as $position)
                                                        <option value="{{ $position->id }}" {{ isset($user) ? ($position->id == $user->userpositionid ? "selected" : "") : "" }}>{{ $position->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row row-xs align-items-center mg-b-5"style="margin-top: 8px;">
                                        <div class="col-lg-6 col-md-12 col-sm-12">
                                            <label class="form-label mg-b-0">상태</label>
                                        </div>
                                        <div class="col-lg-6 col-md-12 col-sm-12">
                                            <label class="ckbox">
                                                <input type="checkbox" name="status" {{ isset($user) ? ($user->isactive == 1 ? "checked" : "" ) : "" }}><span>활성</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="row row-xs align-items-center mg-b-5"style="margin-top: 8px;">
                                        <div class="col-lg-6 col-md-12 col-sm-12">
                                            <label class="form-label mg-b-0">수도 직원 여부</label>
                                        </div>
                                        <div class="col-lg-6 col-md-12 col-sm-12">
                                            <label class="ckbox">
                                                <input type="checkbox" name="iscity" {{ isset($user) ? ($user->iscity == 1 ? "checked" : "" ) : "" }}><span>수도</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="row row-xs align-items-center mg-b-5"style="margin-top: 8px;">
                                        <div class="col-lg-6 col-md-12 col-sm-12">
                                            <label class="form-label mg-b-0">ATUT 직원 여부</label>
                                        </div>
                                        <div class="col-lg-6 col-md-12 col-sm-12">
                                            <label class="ckbox">
                                                <input type="checkbox" name="atvt" {{ isset($user) ? ($user->isatvt == 1 ? "checked" : "" ) : "" }}><span>ATUT</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>  
                                <!--왼쪽 영역 끝-->

                                <!-----DugUildwer----->

                              
                                <!---------->


                            </div>
                            <hr class="mg-y-10">
                           
                           
                           
                            
                            <div class="row">
                                <div class="col-lg-4 col-md-6 col-sm-6"></div>
                                <div class="col-lg-2 col-md-6 col-sm-6">
                                    <button class="btn btn-primary btn-block">{{ isset($user) ? "수정" : "등록" }}</button>
                                </div>
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
            $('#systemDepType').change(function(){
                $("#state option").remove();
              
               var id =  document.getElementById("systemDepType").value;
           
               $.ajax({
           
                  url : "{{ route( 'fetch' ) }}",
                  data: {
                    "_token": "{{ csrf_token() }}",
                    id: id
                    },
                  type: 'post',
                  dataType: 'json',
                  success: function( result )
                  {

                      console.log(result);
                      $.each( result, function(k, v) {
                            $('#state').append($('<option>', {value:k, text:v},'</option>'));
                       });

                      
                  }
                
               });
            });
           
        });


    </script>
    <script>
        $(function(){
            'use strict'
            $( "#restrictDate" ).datepicker({
                changeMonth: true,
                changeYear: true
            });

            $('.select2').select2({
                placeholder: '선택하세요'
            });

            $('#lastName').keyup(function(){
                $(this).val($(this).val().substr(0, 1).toUpperCase() + $(this).val().substr(1).toLowerCase());
            });

            $('#firstName').keyup(function(){
                $(this).val($(this).val().substr(0, 1).toUpperCase() + $(this).val().substr(1).toLowerCase());
            });

            $( "#restrictDate" ).datepicker( "option", "dateFormat", "yy-mm-dd" );

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


