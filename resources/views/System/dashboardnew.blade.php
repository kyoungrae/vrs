<!DOCTYPE html>
<html lang="en">
<head>
    @include('Includes.head')
    <style>
        .az-header-center {
            flex: 1;
            margin: 0;
        }
      </style>
</head>
<body class="az-body az-body-sidebar flexcroll">
<div class="az-sidebar" style=" background: #f8f8f8; ">
    <div class="az-sidebar-header">
        <a href="/dashboard" class="az-logo"><img src="{{ asset('img/logo.png') }}" width="45px" /></a>
    </div><!-- az-sidebar-header -->
    <div class="az-sidebar-body">
        <ul class="nav">
            <li class="nav-label">주 메뉴</li>
            <li class="nav-item">
                <a href="" class="nav-link with-sub"><i class="typcn typcn-user"></i>사용자</a>
                <nav class="nav-sub">
                    <a href="/user" class="nav-link">사용자 등록</a>
                    <a href="/userlist" class="nav-link">사용자 목록</a>
                </nav>
            </li><!-- nav-item -->
            <li class="nav-item">
                <a href="/vehicle" class="nav-link"><i class="ion-ios-car"></i>차량</a>
            </li><!-- nav-item -->
            <li class="nav-item">
                <a href="/search" class="nav-link"><i class="typcn typcn-filter"></i>검색</a>
            </li><!-- nav-item -->
            <li class="nav-item">
                <a href="" class="nav-link with-sub"><i class="typcn typcn-book"></i>참조</a>
                <nav class="nav-sub">
                    <a href="/reference/service" class="nav-link">서비스</a>
                    <a href="/reference/position" class="nav-link">직위</a>
                    <a href="/reference/address" class="nav-link">주소 참조</a>
                    <a href="/reference/factorycountry" class="nav-link">제조국</a>
                    <a href="/reference/owner" class="nav-link">소유자 참조</a>
                    <a href="/reference/series" class="nav-link">시리즈 참조</a>
                </nav>
            </li><!-- nav-item -->
            <li class="nav-item">
                <a href="" class="nav-link with-sub"><i class="typcn typcn-chart-area-outline"></i>보고서</a>
                <nav class="nav-sub">
                    <a href="/report/vehicle/total" class="nav-link">전체 차량</a>
                    <a href="/report/vehicle/archive" class="nav-link">색인</a>
                </nav>
            </li><!-- nav-item -->
            <li class="nav-item">
                <a href="" class="nav-link with-sub"><i class="typcn typcn-cog-outline"></i>시스템 참조</a>
                <nav class="nav-sub">
                    <a href="/settings/department" class="nav-link">부서</a>
                    <a href="/settings/archive" class="nav-link">아카이브 지점</a>
                </nav>
            </li><!-- nav-item -->
            <li class="nav-item">
                <a href="#document" class="nav-link" data-toggle="modal" data-effect="effect-scale"><i class="far fa-question-circle"></i>시스템 안내</a>
            </li><!-- nav-item -->
        </ul><!-- nav -->
    </div><!-- az-sidebar-body -->
</div>
<div class="az-content az-content-dashboard-two">
    <div class="az-header">
        @include('Includes.top')
    </div>

    <div class="az-content-body">
        <div class="az-content-body-left">
            <div class="row row-sm mg-b-20">
                <div class="col-sm-6 col-lg-4">
                    <div class="card card-dashboard-twentysix">
                        <div class="card-header">
                            <h6 class="card-title">차량</h6>
                            <div class="chart-legend">
                                <div><span class="bg-primary"></span> 신규</div>
                                <div><span class="bg-teal"></span> 이전</div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="pd-x-15">
                                <h6>156 <span class="tx-success"><i class="icon ion-md-arrow-up"></i> 3.7%</span></h6>
                                <label>평균. 월</label>
                            </div>
                            <div class="chart-wrapper">
                                <div id="flotChart7" class="flot-chart"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4 mg-t-20 mg-sm-t-0">
                    <div class="card card-dashboard-twentysix card-dark-one">
                        <div class="card-header">
                            <h6 class="card-title">소유자</h6>
                        </div>
                        <div class="card-body">
                            <div class="pd-x-15">
                                <h6>0.23% <span><i class="icon ion-md-arrow-up"></i> 0.20%</span></h6>
                                <label>전체 신규 등록</label>
                            </div>
                            <div class="chart-wrapper">
                                <div id="flotChart8" class="flot-chart"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mg-t-20 mg-lg-t-0">
                    <div class="card card-dashboard-twentysix card-dark-two">
                        <div class="card-header">
                            <h6 class="card-title">시리즈 목록</h6>
                        </div>
                        <div class="card-body">
                            <div class="pd-x-15">
                                <h6>7,299 <span><i class="icon ion-md-arrow-up"></i> 1.18%</span></h6>
                                <label>전체 잔여</label>
                            </div>
                            <div class="chart-wrapper">
                                <div id="flotChart9" class="flot-chart"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-body card-dashboard-twentyfive mg-b-20" style="display: none;">
                <h6 class="card-title">사용자 목록</h6>
                <div class="row row-sm">
                    <div class="col-12 col-sm-1 col-lg">
                        <table id="userTable" class="display responsive nowrap" style="width:100%;text-align: center;">
                            <thead>
                            <tr>
                                <th>성</th>
                                <th>이름</th>
                                <th>사용자 이름</th>
                                <th>부서</th>
                                <th>지점</th>
                                <th>직위</th>
                                <th>상태</th>
                                <th>작업</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(ISSET($users1))
                                @foreach($users1 as $user)
                                    <tr>
                                        <td>{{ $user->lastname }}</td>
                                        <td>{{ $user->firstname }}</td>
                                        <td>{{ $user->username }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->department }}</td>
                                        <td>{{ $user->position }}</td>
                                        <td>{{ $user->isactive == 1 ? "활성" : "비활성" }}</td>
                                        <td>
                                            <a href="/user/edit/{{ \App\Http\Controllers\BaseController::enc($user->id) }}">
                                                <i class="typcn typcn-edit text-primary"></i>
                                            </a>
                                            <a style="cursor: pointer;" onclick="if(confirm('이 레코드를 삭제하시겠습니까?')){
                                                    window.location='/user/delete/{{ \App\Http\Controllers\BaseController::enc($user->id) }}'
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
    </div>
    @include('Includes.footer')
</div>

@include('Includes.helper')

<div id="registerBranch" class="modal">
    <form action="{{ route("dashboard") }}" method="POST">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">지점 선택</h6>
                </div>
                <div class="modal-body">
                    {{ csrf_field() }}
                    <div class="row row-sm">
                        <div class="col-12">
                            <div class="row row-xs align-items-center mg-b-5">
                                <div class="col-lg-5 col-md-12 col-sm-12">
                                    <label class="form-label mg-b-0 required-input">지점</label>
                                </div>
                                <div class="col-lg-7 col-md-12 col-sm-12">
                                    <select class="form-control select2" name="branch">
                                        @if(ISSET($archives))
                                            @foreach($archives as $archive)
                                                <option value="{{ \App\Http\Controllers\BaseController::enc($archive->id) }}">{{ $archive->archive }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">확인</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script src="{{ asset('lib/jquery/jquery.min.js') }}"></script>
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
<script src="{{ asset('js/dashboard.sampledata.js') }}"></script>
<script src="{{ asset('js/chart.flot.sampledata.js') }}"></script>
<script>
    $(document).ready(function(){
        'use strict';

        $('#userTable').DataTable({
            responsive: true,
            language: {
                searchPlaceholder: '검색...',
                sSearch: '',
                lengthMenu: '_MENU_ 1/페이지에 표시',
            }
        });

        @if(session()->has("archive"))
            @if(session()->get("archive") == "many")
                $('#registerBranch').modal({'backdrop': 'static'});
                $('#registerBranch').modal('show');
            @endif
        @endif
           $('.az-sidebar .with-sub').on('click', function(e){
                e.preventDefault();
                $(this).parent().toggleClass('show');
                $(this).parent().siblings().removeClass('show');
            })

        $(document).on('click touchstart', function(e){
            e.stopPropagation();

            // closing of sidebar menu when clicking outside of it
            if(!$(e.target).closest('.az-header-menu-icon').length) {
                var sidebarTarg = $(e.target).closest('.az-sidebar').length;
                if(!sidebarTarg) {
                    $('body').removeClass('az-sidebar-show');
                }
            }
        });


        $('#azSidebarToggle').on('click', function(e){
            e.preventDefault();

            if(window.matchMedia('(min-width: 992px)').matches) {
                $('body').toggleClass('az-sidebar-hide');
            } else {
                $('body').toggleClass('az-sidebar-show');
            }
        })



        /******************* DASHBOARD CHARTS **************************/

        $.plot('#flotChart7', [{
            data: dashData3,
            color: '#00cccc',
            curvedLines: { apply: true }
        },{
            data: dashData4,
            color: '#560bd0',
            curvedLines: { apply: true }
        }], {
            series: {
                shadowSize: 0,
                lines: {
                    show: true,
                    lineWidth: 0,
                    fill: true,
                    fillColor: { colors: [ { opacity: .5 }, { opacity: 1 } ] }
                },
                curvedLines: { active: true }
            },
            grid: {
                borderWidth: 0,
                labelMargin: 0
            },
            yaxis: {
                show: true,
                min: 0,
                max: 50,
                ticks: [[0,''],[10,'100'],[20,'200'],[30,'300']],
                tickColor: '#f3f3f3'
            },
            xaxis: {
                show: true,
                ticks: [[0,''],[20,'2월'],[40,'3월'],[60,'4월']],
                tickColor: 'rgba(255,255,255,0)'
            }
        });

        $.plot('#flotChart8', [{
            data: dashData4,
            color: '#3381d6'
        }], {
            series: {
                bars: {
                    show: true,
                    lineWidth: 0,
                    fill: 1,
                    barWidth: .5
                }
            },
            grid: {
                borderWidth: 0,
                labelMargin: 0
            },
            yaxis: {
                show: true,
                min: 0,
                max: 30,
                ticks: [[0,''],[10,'100'],[20,'200']],
                tickColor: 'rgba(255,255,255,0)'
            },
            xaxis: {
                show: true,
                max: 40,
                ticks: [[0,''],[3,'2월'],[30,'3월']],
                tickColor: 'rgba(255,255,255,0)'
            }
        });

        $.plot('#flotChart9', [{
            data: dashData3,
            color: '#fff',
            bars: {
                show: true,
                lineWidth: 0,
                barWidth: .5
            }
        },{
            data: dashData4,
            color: '#fff',
            lines: {
                show: true,
                lineWidth: 2,
                fill: .16
            }
        }], {
            series: {
                shadowSize: 0
            },
            grid: {
                borderWidth: 0,
                labelMargin: 0
            },
            yaxis: {
                show: true,
                min: 0,
                max: 30,
                ticks: [[0,''],[10,'100'],[20,'200']],
                tickColor: 'rgba(255,255,255,0)'
            },
            xaxis: {
                show: true,
                max: 40,
                ticks: [[0,''],[3,'2월'],[30,'3월']],
                tickColor: 'rgba(255,255,255,0)'
            }
        });
    });
</script>
</body>
</html>