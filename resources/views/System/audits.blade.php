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
                    <div class="" style="width: 100%;">
                        <h6 class="card-title">
                            <div class="row">
                                <div class="col-lg-7 col-md-6 col-sm-12">
                                    감사 로그 목록
                                </div>
       
                            </div>
                        </h6>
                        <div class="row row-sm">
                            <div class="col-12 col-sm-12 col-lg-12 col-md-12 ">
                                @if(ISSET($message) || session()->has("message"))
                                    @include("System.message")
                                @endif
                                <form action="" method="POST">
                                    {{ csrf_field() }}
                                    <div class="row row-sm">
                                        <div class="col-3">
                                            <div class="row row-xs align-items-center mg-b-5">
                                                <div class="col-lg-4 col-md-12 col-sm-12">
                                                    <label class="form-label mg-b-0 required-input">시작일</label>
                                                </div>
                                                <div class="col-lg-8 col-md-12 col-sm-12">
                                                    <input id="start" name="start" required type="text" value="{{ isset($start) ? $start : "" }}" class="form-control" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="row row-xs align-items-center mg-b-5">
                                                <div class="col-lg-4 col-md-12 col-sm-12">
                                                    <label class="form-label mg-b-0 required-input">종료일</label>
                                                </div>
                                                <div class="col-lg-8 col-md-12 col-sm-12">
                                                    <input id="end" name="end" required type="text" value="{{ isset($end) ? $end : "" }}" class="form-control" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="row row-xs align-items-center mg-b-5">
                                                <div class="col-lg-4 col-md-12 col-sm-12">
                                                    <button type="submit" class="btn btn-primary btn-block btnnopadding">검색</button>
                                                </div>
                                                {{-- <div class="col-lg-4 col-md-12 col-sm-12">
                                                    <button type="button" onclick="exportToExcel()" class="btn btn-primary btn-block btnnopadding"><i class="far fa-file-excel"></i> 엑셀</button>
                                                </div>
                                                <div class="col-lg-4 col-md-12 col-sm-12">
                                                    <button type="button" onclick="clearFields()" class="btn btn-primary btn-block btnnopadding">초기화</button>
                                                </div> --}}
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                
                                <table id="userTable" class="display responsive nowrap" style="width:100%;text-align: center;">
                                    <thead>
                                    <tr >
                                        <th>작업</th>
                                        
                                        <th>작업자</th>
                                        <th>작업일</th>
                                          
                                       
                                        <th>접속 주소/기기</th>
                                        <th>사용자 IP 주소</th>       
                                        <th>수행 작업</th>  
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                        
                                        $i=0;
                                        ?>
                                     
                                        @if(ISSET($audits))
                                   
                                        @foreach($audits as $audit) 
                                                 <?php 
                                                 $i++;
                                                 ?>
                                        <tr >
                                            @if ($audit->auditable_type == "App\MainUser" && $audit->event=="created" )
                                            <td>사용자 등록 (id: {{ $audit->auditable_id }})</td>
                                                
                                            @elseif($audit->auditable_type == "App\MainUser" && $audit->event=="updated" && $audit->url == "https://vrs.transdep.mn/login?"  )
                                            <td >사용자 로그인  (id: {{ $audit->auditable_id }})</td>
                                            @elseif($audit->auditable_type == "App\MainUser" && $audit->event=="updated" && $audit->url == "https://vrs.transdep.mn/logout?"  )
                                            <td >사용자 로그아웃  (id: {{ $audit->auditable_id }})</td>
                                            @elseif($audit->auditable_type == "App\MainUser" && $audit->event=="deleted" )
                                          
                                            <td>사용자 정보 삭제 (id: {{ $audit->auditable_id }})</td>
                                            @elseif($audit->auditable_type == "App\Owner" && $audit->event=="updated"  )

                                            <td>소유자 정보 수정 (id: {{ $audit->auditable_id }})</td>

                                        
                                               
                                            
                                           
                                            @else
                                            <td>{{ $audit->auditable_type }} (id: {{ $audit->auditable_id }})</td>
                                            @endif    
                                           
                                            <td>{{substr($audit->user['lastname'],0,2).".". $audit->user['firstname'] }}</td>
                                            <td>{{ $audit->created_at }}</td>    
                                           
                                        
                                            <td>{{ substr($audit->url,0 ,56) }}..... <br> {{ $audit->user_agent }}</td>
                                            <td>{{ $audit->ip_address }}</td>
                                           <td>
                                                <table class="table table-bordered table-hover" style="width:100%">
                                                 
                                                
                                                        
                                         
                                                   
                                                     @foreach($audit->new_values as  $attribute  => $value)
                                                     
                                                        <tr>
                                                            <td><b>{{  $attribute  }}</b></td>
                                                            <td>{{ $value }}</td>
                                                        </tr>
                                                    @endforeach
                                                  
                                                       
                                                </table>
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
    <script src="{{ asset('lib/preloader/js/fakeLoader.min.js') }}"></script>
    

    
    <script>
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
            $(".avtoteeverPreloader").fadeOut();
            $(".containerBody").fadeIn();
        });
    </script>
</div>
</body>
</html>

