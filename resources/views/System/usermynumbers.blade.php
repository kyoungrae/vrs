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
                        <div class="" style="width: 100%;">
                            <div class="row">
                                <div class="card-title col-lg-7 col-md-6 col-sm-12">
                                    할당 가능 번호
                                </div>
                            </div>
                            <div class="row row-sm">
                                <div class="col-5 col-sm-1 col-lg">
                                    <hr class="mg-y-10">
                                    <table id="orderTable" class="display responsive nowrap" style="width:100%;text-align: center;">
                                        <thead>
                                        <tr>
                                            <th>번호</th>
                                            <th>차량 번호</th>
                                            <th>상태</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(ISSET($numbers))
                                            <?php $count=1; ?>
                                            @foreach($numbers as $row)
                                                @if($row->is_order == 0)
                                                    <tr>
                                                        <td>{{ $count }}</td>
                                                        <td>{{ $row->name }}</td>
                                                        <td><a onclick="javascript:orderNumber({{ $row->id }},'{{ $row->name }}');" style="color:blue;cursor:pointer;">주문</a></td>
                                                    </tr>
                                                @endif
                                                <?php $count++; ?>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-7 col-sm-1 col-lg">
                                    <hr class="mg-y-10">
                                    <table id="orderedTable" class="display responsive nowrap" style="width:100%;text-align: center;">
                                        <thead>
                                        <tr>
                                            <th>№</th>
                                            <th>차량 번호</th>
                                            <th>등록번호</th>
                                            <th>차대번호</th>
                                            <th>상태</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(ISSET($number_orders))
                                            <?php $count=1; ?>
                                            @foreach($number_orders as $row)
                                                @if($row->is_order == 1)
                                                    <tr>
                                                        <td>{{ $count }}</td>
                                                        <td>{{ $row->name }}</td>
                                                        <td>{{ $row->order_user }}</td>
                                                        <td>{{ $row->order_cabin }}</td>
                                                        <td style="color:#ffdf00;cursor:pointer;">주문됨</td>
                                                    </tr>
                                                @endif
                                                <?php $count++; ?>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--왼쪽 영역 끝-->
            </div>
        </div>
        @include('Includes.footer')
    </div>
    <div id="orderModal" class="modal">
        <form action="" method="POST" accept-charset="UTF-8">
            {{ csrf_field() }}
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document" style=" max-width: 65%; ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" style=" width: 100%; ">번호 주문 창</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" class="form-control" id="seriesNumberId" name="seriesNumberId">
                            <input type="hidden" class="form-control" id="seriesName" name="seriesName">
                            <input type="hidden" id="seriesModal" name="seriesModal" value="@if(isset($seriesId)) {{$seriesId}} @endif">
                            <div class="col-lg-12">
                                <center><h4><span style="color: #f61717;display: block;">등록번호 또는 차대번호를 잘못 입력할 경우 번호가 발급되지 않으니 주의하시기 바랍니다!</span></h4></center>
                                <div class="row" style="margin-top: 15px;margin-bottom:15px;">
                                    <div class="col-lg-1 mg-t-20 mg-lg-t-0">
                                    </div>
                                    <div class="col-lg-3 mg-t-20 mg-lg-t-0">
                                        <label class="rdiobox">
                                            <input id="person" name="registeroption" type="radio" checked value="person">
                                            <span>개인</span>
                                        </label>
                                    </div><!-- col-3 -->
                                    <div class="col-lg-3 mg-t-20 mg-lg-t-0">
                                        <label class="rdiobox">
                                            <input id="company" name="registeroption" type="radio" value="company">
                                            <span>기업</span>
                                        </label>
                                    </div><!-- col-3 -->
                                    <div class="col-lg-4 mg-t-20 mg-lg-t-0">
                                        <label class="rdiobox">
                                            <input id="foreign" name="registeroption" type="radio" value="foreign">
                                            <span>외국인 /Foreign citizen/</span>
                                        </label>
                                    </div><!-- col-3 -->
                                </div>

                                <div class="row row-xs align-items-center mg-b-5" style=" margin-bottom: 15px !important; ">
                                    <div class="col-lg-4 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">주문할 차량 번호</label>
                                    </div>
                                    <div class="col-lg-8 col-md-12 col-sm-12">
                                        <button id="orderNumberLbl" type="button" class="btn btn-primary btn-block" style=" background: #0062cb !important; "></button>
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-4 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0 required-input">등록 번호</label>
                                    </div>
                                    <div class="col-lg-8 col-md-12 col-sm-12">
                                        <div class="row">
                                            <div class="col-3 person" style="width: 100%;">
                                                <div class="row">
                                                    <div class="col-6 person" style=" padding-right: 1px; padding-top: 1px; padding-bottom: 1px; ">
                                                        <select name="first" id="select-reg-1" class="form-control form-control select2-no-search person" required style=" font-size: 25px; height: 50px !important; ">
                                                            <option value="У">У</option>
                                                            <option value="А">А</option>
                                                            <option value="Б">Б</option>
                                                            <option value="В">В</option>
                                                            <option value="Г">Г</option>
                                                            <option value="Д">Д</option>
                                                            <option value="Е">Е</option>
                                                            <option value="Ё">Ё</option>
                                                            <option value="Ж">Ж</option>
                                                            <option value="З">З</option>
                                                            <option value="И">И</option>
                                                            <option value="Й">Й</option>
                                                            <option value="К">К</option>
                                                            <option value="Л">Л</option>
                                                            <option value="М">М</option>
                                                            <option value="Н">Н</option>
                                                            <option value="О">О</option>
                                                            <option value="Ө">Ө</option>
                                                            <option value="П">П</option>
                                                            <option value="Р">Р</option>
                                                            <option value="С">С</option>
                                                            <option value="Т">Т</option>
                                                            <option value="Ү">Ү</option>
                                                            <option value="Ф">Ф</option>
                                                            <option value="Х">Х</option>
                                                            <option value="Ч">Ч</option>
                                                            <option value="Ц">Ц</option>
                                                            <option value="Ш">Ш</option>
                                                            <option value="Щ">Щ</option>
                                                            <option value="Ъ">Ъ</option>
                                                            <option value="Ы">Ы</option>
                                                            <option value="Ь">Ь</option>
                                                            <option value="Э">Э</option>
                                                            <option value="Ю">Ю</option>
                                                            <option value="Я">Я</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-6 person"  style=" padding-right: 1px; padding-top: 1px; padding-bottom: 1px; ">
                                                        <select name="second" id="select-reg-2" class="form-control form-control select2-no-search person" required style=" font-size: 25px; height: 50px !important; ">
                                                            <option value="А">А</option>
                                                            <option value="Б">Б</option>
                                                            <option value="В">В</option>
                                                            <option value="Г">Г</option>
                                                            <option value="Д">Д</option>
                                                            <option value="Е">Е</option>
                                                            <option value="Ё">Ё</option>
                                                            <option value="Ж">Ж</option>
                                                            <option value="З">З</option>
                                                            <option value="И">И</option>
                                                            <option value="Й">Й</option>
                                                            <option value="К">К</option>
                                                            <option value="Л">Л</option>
                                                            <option value="М">М</option>
                                                            <option value="Н">Н</option>
                                                            <option value="О">О</option>
                                                            <option value="Ө">Ө</option>
                                                            <option value="П">П</option>
                                                            <option value="Р">Р</option>
                                                            <option value="С">С</option>
                                                            <option value="Т">Т</option>
                                                            <option value="У">У</option>
                                                            <option value="Ү">Ү</option>
                                                            <option value="Ф">Ф</option>
                                                            <option value="Х">Х</option>
                                                            <option value="Ч">Ч</option>
                                                            <option value="Ц">Ц</option>
                                                            <option value="Ш">Ш</option>
                                                            <option value="Щ">Щ</option>
                                                            <option value="Ъ">Ъ</option>
                                                            <option value="Ы">Ы</option>
                                                            <option value="Ь">Ь</option>
                                                            <option value="Э">Э</option>
                                                            <option value="Ю">Ю</option>
                                                            <option value="Я">Я</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-9 company" style="width: 100%;">
                                                <div class="row" style=" margin-right: 0px; ">
                                                    <div class="col" style=" padding-right: 1px; padding-top: 1px; padding-bottom: 1px; ">
                                                        <select name="r1" id="select-reg-2" class="form-control form-control select2-no-search" required style=" font-size: 25px; height: 50px !important; ">
                                                            <option value="0">0</option>
                                                            <option value="1">1</option>
                                                            <option value="2">2</option>
                                                            <option value="3">3</option>
                                                            <option value="4">4</option>
                                                            <option value="5">5</option>
                                                            <option value="6">6</option>
                                                            <option value="7">7</option>
                                                            <option value="8">8</option>
                                                            <option value="9">9</option>
                                                        </select>
                                                    </div>
                                                    <div class="col" style=" padding: 1px; ">
                                                        <select name="r2" id="select-reg-2" class="form-control form-control select2-no-search" required style=" font-size: 25px; height: 50px !important; ">
                                                            <option value="0">0</option>
                                                            <option value="1">1</option>
                                                            <option value="2">2</option>
                                                            <option value="3">3</option>
                                                            <option value="4">4</option>
                                                            <option value="5">5</option>
                                                            <option value="6">6</option>
                                                            <option value="7">7</option>
                                                            <option value="8">8</option>
                                                            <option value="9">9</option>
                                                        </select>
                                                    </div>
                                                    <div class="col" style=" padding: 1px; ">
                                                        <select name="r3" id="select-reg-2" class="form-control form-control select2-no-search" required style=" font-size: 25px; height: 50px !important; ">
                                                            <option value="0">0</option>
                                                            <option value="1">1</option>
                                                            <option value="2">2</option>
                                                            <option value="3">3</option>
                                                            <option value="4">4</option>
                                                            <option value="5">5</option>
                                                            <option value="6">6</option>
                                                            <option value="7">7</option>
                                                            <option value="8">8</option>
                                                            <option value="9">9</option>
                                                        </select>
                                                    </div>
                                                    <div class="col" style=" padding: 1px; ">
                                                        <select name="r4" id="select-reg-2" class="form-control form-control select2-no-search" required style=" font-size: 25px; height: 50px !important; ">
                                                            <option value="0">0</option>
                                                            <option value="1">1</option>
                                                            <option value="2">2</option>
                                                            <option value="3">3</option>
                                                            <option value="4">4</option>
                                                            <option value="5">5</option>
                                                            <option value="6">6</option>
                                                            <option value="7">7</option>
                                                            <option value="8">8</option>
                                                            <option value="9">9</option>
                                                        </select>
                                                    </div>
                                                    <div class="col" style=" padding: 1px; ">
                                                        <select name="r5" id="select-reg-2" class="form-control form-control select2-no-search" required style=" font-size: 25px; height: 50px !important; ">
                                                            <option value="0">0</option>
                                                            <option value="1">1</option>
                                                            <option value="2">2</option>
                                                            <option value="3">3</option>
                                                            <option value="4">4</option>
                                                            <option value="5">5</option>
                                                            <option value="6">6</option>
                                                            <option value="7">7</option>
                                                            <option value="8">8</option>
                                                            <option value="9">9</option>
                                                        </select>
                                                    </div>
                                                    <div class="col" style=" padding: 1px; ">
                                                        <select name="r6" id="select-reg-2" class="form-control form-control select2-no-search" required style=" font-size: 25px; height: 50px !important; ">
                                                            <option value="0">0</option>
                                                            <option value="1">1</option>
                                                            <option value="2">2</option>
                                                            <option value="3">3</option>
                                                            <option value="4">4</option>
                                                            <option value="5">5</option>
                                                            <option value="6">6</option>
                                                            <option value="7">7</option>
                                                            <option value="8">8</option>
                                                            <option value="9">9</option>
                                                        </select>
                                                    </div>
                                                    <div class="col" style=" padding: 1px; ">
                                                        <select name="r7" id="select-reg-2" class="form-control form-control select2-no-search" required style=" font-size: 25px; height: 50px !important; ">
                                                            <option value="0">0</option>
                                                            <option value="1">1</option>
                                                            <option value="2">2</option>
                                                            <option value="3">3</option>
                                                            <option value="4">4</option>
                                                            <option value="5">5</option>
                                                            <option value="6">6</option>
                                                            <option value="7">7</option>
                                                            <option value="8">8</option>
                                                            <option value="9">9</option>
                                                        </select>
                                                    </div>
                                                    <div class="col" style=" padding: 1px; ">
                                                        <select name="r8" id="select-reg-2" class="form-control form-control select2-no-search person" required style=" font-size: 25px; height: 50px !important; ">
                                                            <option value="0">0</option>
                                                            <option value="1">1</option>
                                                            <option value="2">2</option>
                                                            <option value="3">3</option>
                                                            <option value="4">4</option>
                                                            <option value="5">5</option>
                                                            <option value="6">6</option>
                                                            <option value="7">7</option>
                                                            <option value="8">8</option>
                                                            <option value="9">9</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12 foreign">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <input class="form-control foreign" id="foreign_in" name="foreign" autocomplete="off" style="display:none;font-size: 25px; height: 50px !important; " value=""/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br/>
                                </div>

                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-4 col-md-12 col-sm-12">
                                        <label class="form-label required-input">차대번호 마지막 5자리</label>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="row" style=" margin-left: 0px;  margin-right: 0px; ">
                                            <div class="col" style=" padding: 4px 4px 4px 0px; ">
                                                <select name="a1" id="select-reg-2" class="form-control form-control select2-no-search" required style=" font-size: 25px; height: 50px !important; ">
                                                    <option value="0">0</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                    <option value="7">7</option>
                                                    <option value="8">8</option>
                                                    <option value="9">9</option>
                                                    <option value="A">A</option>
                                                    <option value="B">B</option>
                                                    <option value="C">C</option>
                                                    <option value="D">D</option>
                                                    <option value="E">E</option>
                                                    <option value="F">F</option>
                                                    <option value="G">G</option>
                                                    <option value="H">H</option>
                                                    <option value="I">I</option>
                                                    <option value="J">J</option>
                                                    <option value="K">K</option>
                                                    <option value="L">L</option>
                                                    <option value="M">M</option>
                                                    <option value="N">N</option>
                                                    <option value="O">O</option>
                                                    <option value="P">P</option>
                                                    <option value="Q">Q</option>
                                                    <option value="R">R</option>
                                                    <option value="S">S</option>
                                                    <option value="T">T</option>
                                                    <option value="U">U</option>
                                                    <option value="V">V</option>
                                                    <option value="W">W</option>
                                                    <option value="X">X</option>
                                                    <option value="Y">Y</option>
                                                    <option value="Z">Z</option>
                                                </select>
                                            </div>
                                            <div class="col" style=" padding: 4px; ">
                                                <select name="a2" id="select-reg-2" class="form-control form-control select2-no-search" required style=" font-size: 25px; height: 50px !important; ">
                                                    <option value="0">0</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                    <option value="7">7</option>
                                                    <option value="8">8</option>
                                                    <option value="9">9</option>
                                                    <option value="A">A</option>
                                                    <option value="B">B</option>
                                                    <option value="C">C</option>
                                                    <option value="D">D</option>
                                                    <option value="E">E</option>
                                                    <option value="F">F</option>
                                                    <option value="G">G</option>
                                                    <option value="H">H</option>
                                                    <option value="I">I</option>
                                                    <option value="J">J</option>
                                                    <option value="K">K</option>
                                                    <option value="L">L</option>
                                                    <option value="M">M</option>
                                                    <option value="N">N</option>
                                                    <option value="O">O</option>
                                                    <option value="P">P</option>
                                                    <option value="Q">Q</option>
                                                    <option value="R">R</option>
                                                    <option value="S">S</option>
                                                    <option value="T">T</option>
                                                    <option value="U">U</option>
                                                    <option value="V">V</option>
                                                    <option value="W">W</option>
                                                    <option value="X">X</option>
                                                    <option value="Y">Y</option>
                                                    <option value="Z">Z</option>
                                                </select>
                                            </div>
                                            <div class="col" style=" padding: 4px; ">
                                                <select name="a3" id="select-reg-2" class="form-control form-control select2-no-search" required style=" font-size: 25px; height: 50px !important; ">
                                                    <option value="0">0</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                    <option value="7">7</option>
                                                    <option value="8">8</option>
                                                    <option value="9">9</option>
                                                    <option value="A">A</option>
                                                    <option value="B">B</option>
                                                    <option value="C">C</option>
                                                    <option value="D">D</option>
                                                    <option value="E">E</option>
                                                    <option value="F">F</option>
                                                    <option value="G">G</option>
                                                    <option value="H">H</option>
                                                    <option value="I">I</option>
                                                    <option value="J">J</option>
                                                    <option value="K">K</option>
                                                    <option value="L">L</option>
                                                    <option value="M">M</option>
                                                    <option value="N">N</option>
                                                    <option value="O">O</option>
                                                    <option value="P">P</option>
                                                    <option value="Q">Q</option>
                                                    <option value="R">R</option>
                                                    <option value="S">S</option>
                                                    <option value="T">T</option>
                                                    <option value="U">U</option>
                                                    <option value="V">V</option>
                                                    <option value="W">W</option>
                                                    <option value="X">X</option>
                                                    <option value="Y">Y</option>
                                                    <option value="Z">Z</option>
                                                </select>
                                            </div>
                                            <div class="col" style=" padding: 4px; ">
                                                <select name="a4" id="select-reg-2" class="form-control form-control select2-no-search" required style=" font-size: 25px; height: 50px !important; ">
                                                    <option value="0">0</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                    <option value="7">7</option>
                                                    <option value="8">8</option>
                                                    <option value="9">9</option>
                                                    <option value="A">A</option>
                                                    <option value="B">B</option>
                                                    <option value="C">C</option>
                                                    <option value="D">D</option>
                                                    <option value="E">E</option>
                                                    <option value="F">F</option>
                                                    <option value="G">G</option>
                                                    <option value="H">H</option>
                                                    <option value="I">I</option>
                                                    <option value="J">J</option>
                                                    <option value="K">K</option>
                                                    <option value="L">L</option>
                                                    <option value="M">M</option>
                                                    <option value="N">N</option>
                                                    <option value="O">O</option>
                                                    <option value="P">P</option>
                                                    <option value="Q">Q</option>
                                                    <option value="R">R</option>
                                                    <option value="S">S</option>
                                                    <option value="T">T</option>
                                                    <option value="U">U</option>
                                                    <option value="V">V</option>
                                                    <option value="W">W</option>
                                                    <option value="X">X</option>
                                                    <option value="Y">Y</option>
                                                    <option value="Z">Z</option>
                                                </select>
                                            </div>
                                            <div class="col" style=" padding: 4px 0px 4px 4px; ">
                                                <select name="a5" id="select-reg-2" class="form-control form-control select2-no-search" required style=" font-size: 25px; height: 50px !important; ">
                                                    <option value="0">0</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                    <option value="7">7</option>
                                                    <option value="8">8</option>
                                                    <option value="9">9</option>
                                                    <option value="A">A</option>
                                                    <option value="B">B</option>
                                                    <option value="C">C</option>
                                                    <option value="D">D</option>
                                                    <option value="E">E</option>
                                                    <option value="F">F</option>
                                                    <option value="G">G</option>
                                                    <option value="H">H</option>
                                                    <option value="I">I</option>
                                                    <option value="J">J</option>
                                                    <option value="K">K</option>
                                                    <option value="L">L</option>
                                                    <option value="M">M</option>
                                                    <option value="N">N</option>
                                                    <option value="O">O</option>
                                                    <option value="P">P</option>
                                                    <option value="Q">Q</option>
                                                    <option value="R">R</option>
                                                    <option value="S">S</option>
                                                    <option value="T">T</option>
                                                    <option value="U">U</option>
                                                    <option value="V">V</option>
                                                    <option value="W">W</option>
                                                    <option value="X">X</option>
                                                    <option value="Y">Y</option>
                                                    <option value="Z">Z</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-4 col-md-12 col-sm-12">
                                        <label class="form-label required-input">보안 코드</label>
                                    </div>
                                    <div class="col-lg-8 col-md-12 col-sm-12">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-12 col-sm-12">
                                                <label class="form-label" style="height: 50px !important;"> {{ captcha_img('math') }}</label>
                                            </div>
                                            <div class="col-lg-4 col-md-12 col-sm-12">
                                                <input id="valid" type="text" class="form-control keyboard" placeholder="답변 입력" required autocomplete="off" style=" font-size: 25px; height: 50px !important; " name="captcha">
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-sm-2">
                                                <select id="calRow"  onchange="concat(this.value, '')" class="form-control form-control select2-no-search" style=" font-size: 25px; height: 50px !important; ">
                                                    <option value="0">0</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                    <option value="7">7</option>
                                                    <option value="8">8</option>
                                                    <option value="9">9</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-2 col-md-12 co33l-sm-12">
                                                <button type="button" onclick="concat(0, 'clear')" class="btn btn-primary btn-block btnnopadding" style=" font-size: 25px; height: 50px !important; "><i class="fas fa-backspace"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer" style="justify-content: center">
                            <button type="submit" class="btn btn-primary col-md-4" style="font-size: 24px; min-width: 80px !important;;background: #0062cb !important; ">주문</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div id="document" class="modal" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">알림</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="info_body" style="text-align: center">
                </div>
                <div class="modal-footer" style="text-align: center;">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">닫기</button>
                </div>
            </div>
        </div>
    </div>
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
            $('#orderTable').DataTable({
                responsive: true,
                language: {
                searchPlaceholder: '검색...',
                sSearch: '',
                lengthMenu: '_MENU_ 페이지당 표시',
                }
            });

            $('#orderedTable').DataTable({
                responsive: true,
                language: {
                    searchPlaceholder: '검색...',
                    sSearch: '',
                    lengthMenu: '_MENU_ 1/페이지에 표시',
                }
            });

            $('.select2').select2({
                placeholder: '선택하세요'
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

            $(".btnNumber").click(function() {
                var n = $(this).val(),
                    e = $(this).text();
                $("#orderModal").modal(), $("#seriesNumberId").val(n), $("#orderNumberLbl").text(e)
            }), $("#company").click(function() {
                $(".company").fadeIn(), $(".person").css("display", "none"), $(".foreign").css("display", "none")
            }), $("#person").click(function() {
                $(".person").fadeIn(), $(".company").css("display", "block"), $(".foreign").css("display", "none")
            }), $("#foreign").click(function() {
                $(".foreign").fadeIn(), $(".person").css("display", "none"), $(".company").css("display", "none")
            })
        });

        function orderNumber(id, number)
        {
            var numberId = id;
            var numberText = number;
            $( "#seriesNumberId" ).val(numberId);
            $( "#orderNumberLbl" ).text(numberText);
            $( "#orderModal" ).modal();
        }

        function concat(n, e) {
            "clear" == e ? $("#valid").val("") : $("#valid").val($("#valid").val() + n);
            $("#calRow").val("");
        }

        $('#foreign_in').keyup(function(){
            this.value = this.value.toUpperCase();
        });

        $(document).ready(function () {
            $(".avtoteeverPreloader").fadeOut();
            $(".containerBody").fadeIn();
        });
        @if(ISSET($message))
            var type = "{{ $message['type'] }}";
            var color = "";
            var title = "";
            if (type == "info") {
                color = "red"; title = "주문 정보 처리에 실패했습니다!";
            }
            else if (type == "warning") {
                color = "red";title = "주문 정보 처리에 실패했습니다!";
            } else if (type == "success") {
                color = "green"; title = "주문이 성공적으로 완료되었습니다!";
            }
            $("#titileDiv").text(title);
            $("#info_body").html('<div style="font-size:24px;color:' + color + '">{!! $message['message'] !!}</div>');
            $("#document").modal("show");
        @endif
    </script>
</div>
</body>
</html>

