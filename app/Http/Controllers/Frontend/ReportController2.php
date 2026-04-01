<?php

namespace App\Http\Controllers\Frontend;

use App\AddressProvince;
use App\Archive;
use App\Http\Controllers\BaseController;
use App\MainUser;
use App\MainUserPosition;
use App\RefReferenceOrg;
use App\SystemArchive;
use Carbon\Carbon;
use App\Owner;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\EpayTransaction;
use Illuminate\Support\Str;
class ReportController extends BaseController
{
    public function center($cell)
    {
        $cell->setValignment('center');
        $cell->setAlignment('center');
    }

    public function cellRight($cell)
    {
        $cell->setValignment('right');
        $cell->setAlignment('right');
    }

    public function cellLeft($cell)
    {
        $cell->setValignment('left');
        $cell->setAlignment('left');
    }

    public function valRight($cell)
    {
        $cell->setValignment('right');
        $cell->setAlignment('center');
    }

    public function alignLeft($cell)
    {
        $cell->setValignment('right');
        $cell->setAlignment('left');
    }

    public function setPrintMargins($sheet, $top, $right, $bottom, $left)
    {
        $sheet->getPageMargins()->setTop($top);
        $sheet->getPageMargins()->setRight($right);
        $sheet->getPageMargins()->setLeft($left);
        $sheet->getPageMargins()->setBottom($bottom);
    }

    public function setPrintFitToWidth($sheet)
    {
        $sheet->getPageSetup()->setFitToWidth(1);
    }

    protected function parseCssProperties($sheet, $column, $row, $name, $value)
    {
        $cells = $sheet->getStyle($column . $row);
        switch ($name) {
            // Cell width
            case 'width':
                $this->parseWidth($sheet, $column, $row, $value);
                break;
            // Row height
            // Row height
            case 'height':
                $this->parseHeight($sheet, $column, $row, $value);
                break;
            // BACKGROUND
            // BACKGROUND
            case 'background':
            case 'background-color':
                $original = $value;
                $value = $this->getColor($value);
                $cells->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => $value)));
                break;
            // TEXT COLOR
            // TEXT COLOR
            case 'color':
                $value = $this->getColor($value);
                $cells->getFont()->getColor()->applyFromArray(array('rgb' => $value));
                break;
            // FONT SIZE
            // FONT SIZE
            case 'font-size':
                $cells->getFont()->setSize($value);
                break;
            // FONT WEIGHT
            // FONT WEIGHT
            case 'font-weight':
                if ($value == 'bold' || $value >= 500) {
                    $cells->getFont()->setBold(true);
                }
                break;
            // FONT STYLE
            // FONT STYLE
            case 'font-style':
                if ($value == 'italic') {
                    $cells->getFont()->setItalic(true);
                }
                break;
            // FONT FACE
            // FONT FACE
            case 'font-family':
                $cells->getFont()->applyFromArray(array('name' => $value));
                break;
            // TEXT DECORATION
            // TEXT DECORATION
            case 'text-decoration':
                switch ($value) {
                    case 'underline':
                        $cells->getFont()->setUnderline(PHPExcel_Style_Font::UNDERLINE_SINGLE);
                        break;
                    case 'line-through':
                        $cells->getFont()->setStrikethrough(true);
                        break;
                }
                break;
            // Text align
            // Text align
            case 'text-align':
                $horizontal = false;
                switch ($value) {
                    case 'center':
                        $horizontal = PHPExcel_Style_Alignment::HORIZONTAL_CENTER;
                        break;
                    case 'left':
                        $horizontal = PHPExcel_Style_Alignment::HORIZONTAL_LEFT;
                        break;
                    case 'right':
                        $horizontal = PHPExcel_Style_Alignment::HORIZONTAL_RIGHT;
                        break;
                    case 'justify':
                        $horizontal = PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY;
                        break;
                }
                if ($horizontal) {
                    $cells->getAlignment()->applyFromArray(array('horizontal' => $horizontal));
                }
                break;
            // Vertical align
            // Vertical align
            case 'vertical-align':
                $vertical = false;
                switch ($value) {
                    case 'top':
                        $vertical = PHPExcel_Style_Alignment::VERTICAL_TOP;
                        break;
                    case 'middle':
                        $vertical = PHPExcel_Style_Alignment::VERTICAL_CENTER;
                        break;
                    case 'bottom':
                        $vertical = PHPExcel_Style_Alignment::VERTICAL_BOTTOM;
                        break;
                    case 'justify':
                        $vertical = PHPExcel_Style_Alignment::VERTICAL_JUSTIFY;
                        break;
                }
                if ($vertical) {
                    $cells->getAlignment()->applyFromArray(array('vertical' => $vertical));
                }
                break;
            // Borders
            // Borders
            case 'border':
            case 'borders':
                $borders = explode(' ', $value);
                $style = $borders[1];
                $color = end($borders);
                $color = $this->getColor($color);
                $borderStyle = $this->borderStyle($style);
                $cells->getBorders()->applyFromArray(array('allborders' => array('style' => $borderStyle, 'color' => array('rgb' => $color))));
                break;
            // Border-top
            // Border-top
            case 'border-top':
                $borders = explode(' ', $value);
                $style = $borders[1];
                $color = end($borders);
                $color = $this->getColor($color);
                $borderStyle = $this->borderStyle($style);
                $cells->getBorders()->getTop()->applyFromArray(array('style' => $borderStyle, 'color' => array('rgb' => $color)));
                break;
            // Border-bottom
            // Border-bottom
            case 'border-bottom':
                $borders = explode(' ', $value);
                $style = $borders[1];
                $color = end($borders);
                $color = $this->getColor($color);
                $borderStyle = $this->borderStyle($style);
                $cells->getBorders()->getBottom()->applyFromArray(array('style' => $borderStyle, 'color' => array('rgb' => $color)));
                break;
            // Border-right
            // Border-right
            case 'border-right':
                $borders = explode(' ', $value);
                $style = $borders[1];
                $color = end($borders);
                $color = $this->getColor($color);
                $borderStyle = $this->borderStyle($style);
                $cells->getBorders()->getRight()->applyFromArray(array('style' => $borderStyle, 'color' => array('rgb' => $color)));
                break;
            // Border-left
            // Border-left
            case 'border-left':
                $borders = explode(' ', $value);
                $style = $borders[1];
                $color = end($borders);
                $color = $this->getColor($color);
                $borderStyle = $this->borderStyle($style);
                $cells->getBorders()->getLeft()->applyFromArray(array('style' => $borderStyle, 'color' => array('rgb' => $color)));
                break;
            // wrap-text
            // wrap-text
            case 'wrap-text':
                if ($value == 'true') {
                    $wrap = true;
                }
                if (!$value || $value == 'false') {
                    $wrap = false;
                }
                $cells->getAlignment()->setWrapText($wrap);
                break;
        }
    }
   
    public function reportAllVehicleData($startDate, $endDate){
        $data = DB::table("TOTAL_VEHICLE_VIEW")
            ->select("PURPOSE_ID", "PURPOSE_NAME", DB::raw("COUNT(ID) as COUNT"))
            ->whereBetween("CREATED_DATE", [$startDate, $endDate])
            ->groupBy("PURPOSE_ID", "PURPOSE_NAME")
            ->orderBy("PURPOSE_ID", "ASC")
            ->get();
        return $data;
    }

    public function allVehicle(Request $request){
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        if(!$this->checkAccess("/report/vehicle/total", $this->enc(session()->get("auth")->userpositionid))){
            return redirect(route($this->redirectAccess));
        }

        $startDate = $request->get("startDate");
        $endDate = $request->get("endDate");
        if($request->isMethod("POST")){
            $datas = $this->reportAllVehicleData($startDate, $endDate);
            return view("Reports.total", compact('startDate', 'endDate', 'datas'));
        } else {
            return view("Reports.total");
        }
    }

    protected function exportToExcelItem(Request $request){
        $startDate = $request->route("startDate");
        $endDate = $request->route("endDate");
        if($startDate != "none" && $endDate != "none"){
            Excel::create("운송수단 유형별 합계", function($excel) use($startDate, $endDate) {
                $excel->setTitle("운송수단 유형별 합계");
                $excel->setCreator("ATUT");
                $excel->sheet("보고서", function($sheet) use($startDate, $endDate) {
                    //Header үүсгэх
                    $sheet->setWidth(array(
                        'D'     =>  5,
                        'E'     =>  35,
                        'F'     =>  15,
                        'G'     =>  5
                    ));

                    //로고 입력
                    if (session()->get('auth')->iscity == 1) {
                        $objDrawing = new \PHPExcel_Worksheet_Drawing;
                        $objDrawing->setPath(public_path('/img/niislel.jpg')); //your image path
                        $objDrawing->setCoordinates('B1');
                        $objDrawing->setWidthAndHeight(55, 55);
                        $objDrawing->setWorksheet($sheet);
                        $sheet->setOrientation('landscape');
                        $sheet->appendRow(array("", "", "", "", "수도 자동차운송 차량","", ""));
                        $sheet->appendRow(array("", "", "", "","등록·관리 센터 ","", ""));                
                        $sheet->mergeCells('E1:F1');
                        $sheet->mergeCells('E2:F2');
                } else {
                    $objDrawing = new \PHPExcel_Worksheet_Drawing;
                    $objDrawing->setPath(public_path('/img/logo.png')); //your image path
                    $objDrawing->setCoordinates('D1');
                    $objDrawing->setWidthAndHeight(55, 55);
                    $objDrawing->setWorksheet($sheet);
                    $sheet->appendRow(array("","","","", "자동차운송", "", ""));
                    $sheet->appendRow(array("","","","", "국가센터", "", ""));
                    $sheet->mergeCells('E1:F1');
                    $sheet->mergeCells('E2:F2');
                }
                    $sheet->cell('E1', function ($cell) {
                        $this->cellRight($cell);
                    });
                    $sheet->cell('E2', function ($cell) {
                        $this->cellRight($cell);
                    });
                    $sheet->getStyle('E1')->getFont()->setBold(true);
                    $sheet->getStyle('E2')->getFont()->setBold(true);
                    $sheet->setPaperSize(\PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
                    $sheet->appendRow(array("","","","", "", "", ""));
                    $sheet->appendRow(array("","","","", "", "", ""));
                    $sheet->appendRow(array("","","",'ATUT нийт импортлогдсон 차량 /төрлөөр/', ""));
                    $sheet->getStyle('D5:F5')->getFont()->setBold(true);
                    $sheet->getStyle('D5:F5')->getFont()->setSize(12);
                    $sheet->mergeCells('D5:F5');
                    $sheet->cell('D5', function ($cell) {
                        $this->center($cell);
                    });
                    $sheet->appendRow(array(
                        "","","","일자: ".$startDate." - ".$endDate
                    ));
                    $sheet->mergeCells('D6:F6');
                    $sheet->getStyle('D6:F6')->getFont()->setBold(true);
                    $sheet->appendRow(array("","","","", "", ""));
                    $sheet->appendRow(array("","","","№", "운송수단 유형", "개수"));
                    $sheet->getStyle('D8:F8')->getFont()->setBold(true);
                    $sheet->getStyle('D8:F8')->getFont()->setSize(12);
                    //열 서식 지정
                    $sheet->setColumnFormat(array('@','@','@','0', '@', '0', '@'));
                    //위에서 준비한 Array 값을 Excel 파일로보내기
                    $datas = $this->reportAllVehicleData($startDate, $endDate);
                    $init = array();
                    $i = 1;
                    $sum = 0;
                    foreach ($datas as $data){
//                        if($data->purpose_name != ""){
                        array_push($init, array("","","",$i, $data->purpose_name, $data->count, ""));
                        $sum += $data->count;
                        $i++;
//                        }
                    }
                    $sheet->rows($init);
                    $sheet->appendRow(array(
                        "","","","합계","",$sum
                    ));
                    $sheet->getStyle('D'.($i+8).':F'.($i+8))->getFont()->setBold(true);
                    $sheet->mergeCells('D'.($i+8).':E'.($i+8));
                    for($j = 3; $j <= $i + 8; $j++){
                        $sheet->cell('D'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('E'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('F'.($j), function ($cell) {
                            $this->center($cell);
                        });
                    }
                    $sheet->getStyle('D8:F'.($i + 8))->applyFromArray([
                        'borders' => array(
                            'allborders' => array(
                                'style' => \PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    ]);

                    $sheet->appendRow(array(
                        "","","","","",""
                    ));
                    $sheet->appendRow(array(
                        "","","","","",""
                    ));
                    $sheet->appendRow(array(
                        "","","","보고서 작성: . . . . . . . . . . . /____________________/"
                    ));
                    $sheet->getStyle('D21:F21')->getFont()->setBold(true);
                    $sheet->mergeCells('D21:F21');
                    $sheet->setFitToPage(true);
                    $sheet->setScale(80);
                });
            })->download('xls');
        }
    }
   
    protected function exportToExcelItem1( Request $request){
        $startDate = $request->route("startDate");
        $endDate = $request->route("endDate");
 
        if($startDate != "none" && $endDate != "none"){
            Excel::create("운송수단 유형별 합계", function($excel) use($startDate, $endDate) {
                $excel->setTitle("운송수단 유형별 합계");
                $excel->setCreator("ATUT");
                $excel->sheet("보고서", function($sheet) use($startDate, $endDate) {
                    //Header үүсгэх
                    $sheet->setWidth(array(
                        'D'     =>  5,
                        'E'     =>  35,
                        'F'     =>  15,
                        'G'     =>  5
                    ));

                    //로고 입력
                    if (session()->get('auth')->iscity == 1) {
                        $objDrawing = new \PHPExcel_Worksheet_Drawing;
                        $objDrawing->setPath(public_path('/img/niislel.jpg')); //your image path
                        $objDrawing->setCoordinates('B1');
                        $objDrawing->setWidthAndHeight(55, 55);
                        $objDrawing->setWorksheet($sheet);
                        $sheet->setOrientation('landscape');
                        $sheet->appendRow(array("", "", "", "", "",  "수도 자동차운송 차량","", ""));
                        $sheet->appendRow(array("", "", "", "", "", "등록·관리 센터 ","", ""));                
                        $sheet->mergeCells('E1:F1');
                        $sheet->mergeCells('E2:F2');
                } else {
                    $objDrawing = new \PHPExcel_Worksheet_Drawing;
                    $objDrawing->setPath(public_path('/img/logo.png')); //your image path
                    $objDrawing->setCoordinates('D1');
                    $objDrawing->setWidthAndHeight(55, 55);
                    $objDrawing->setWorksheet($sheet);
                    $sheet->appendRow(array("","","","", "자동차운송", "", ""));
                    $sheet->appendRow(array("","","","", "국가센터", "", ""));
                    $sheet->mergeCells('E1:F1');
                    $sheet->mergeCells('E2:F2');
                }
                    $sheet->cell('E1', function ($cell) {
                        $this->cellRight($cell);
                    });
                    $sheet->cell('E2', function ($cell) {
                        $this->cellRight($cell);
                    });
                    $sheet->getStyle('E1')->getFont()->setBold(true);
                    $sheet->getStyle('E2')->getFont()->setBold(true);
                    $sheet->setPaperSize(\PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
                    $sheet->appendRow(array("","","","", "", "", ""));
                    $sheet->appendRow(array("","","","", "", "", ""));
                    $sheet->appendRow(array("","","",'ATUT нийт импортлогдсон 차량 /төрлөөр/', ""));
                    $sheet->getStyle('D5:F5')->getFont()->setBold(true);
                    $sheet->getStyle('D5:F5')->getFont()->setSize(12);
                    $sheet->mergeCells('D5:F5');
                    $sheet->cell('D5', function ($cell) {
                        $this->center($cell);
                    });
                    $sheet->appendRow(array(
                        "","","","일자: ".$startDate." - ".$endDate
                    ));
                    $sheet->mergeCells('D6:F6');
                    $sheet->getStyle('D6:F6')->getFont()->setBold(true);
                    $sheet->appendRow(array("","","","", "", ""));
                    $sheet->appendRow(array("","","","№", "운송수단 유형", "개수"));
                    $sheet->getStyle('D8:F8')->getFont()->setBold(true);
                    $sheet->getStyle('D8:F8')->getFont()->setSize(12);
                    //열 서식 지정
                    $sheet->setColumnFormat(array('@','@','@','0', '@', '0', '@'));
                    //위에서 준비한 Array 값을 Excel 파일로보내기
                    $datas = $this->reportAllPlateFactory($startDate, $endDate);
                    $init = array();
                    $i = 1;
                    $sum = 0;
                    foreach ($datas as $data){
            //                        if($data->purpose_name != ""){
                        array_push($init, array("","","",$i, $data->firstname, $data->count, ""));
                        $sum += $data->count;
                        $i++;
            //                        }
                    }
                    $sheet->rows($init);
                    $sheet->appendRow(array(
                        "","","","합계","",$sum
                    ));
                    $sheet->getStyle('D'.($i+8).':F'.($i+8))->getFont()->setBold(true);
                    $sheet->mergeCells('D'.($i+8).':E'.($i+8));
                    for($j = 3; $j <= $i + 8; $j++){
                        $sheet->cell('D'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('E'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('F'.($j), function ($cell) {
                            $this->center($cell);
                        });
                    }
                    $sheet->getStyle('D8:F'.($i + 8))->applyFromArray([
                        'borders' => array(
                            'allborders' => array(
                                'style' => \PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    ]);

                    $sheet->appendRow(array(
                        "","","","","",""
                    ));
                    $sheet->appendRow(array(
                        "","","","","",""
                    ));
                    $sheet->appendRow(array(
                        "","","","보고서 작성: . . . . . . . . . . . /____________________/"
                    ));
                    $sheet->getStyle('D21:F21')->getFont()->setBold(true);
                    $sheet->mergeCells('D21:F21');
                    $sheet->setFitToPage(true);
                    $sheet->setScale(80);
                });
            })->download('xls');
        }
    
    }

    public function indexArchive(Request $request){
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        if(!$this->checkAccess("/report/vehicle/archive", $this->enc(session()->get("auth")->userpositionid))){
            return redirect(route($this->redirectAccess));
        }
        try{
            if($request->isMethod("POST")){
                $op = trim($request->get("operation"));
                $start = trim($request->get("start"));
                $end = trim($request->get("end"));

                if($op == "ШЭ"){
                    $archives = DB::table("REG_VEHICLE_ARCHIVE")
                        ->select(["ARCHIVE_NO", "CREATED_DATE", "INSERT_PLATE_NO", "INSERT_PAGE_COUNT AS PAGE_COUNT","certificate_no","insert_certificate_no"])
                        ->whereRaw("STATUS = 1 AND FIRST_ARCHIVE_NO BETWEEN '".$op.$start."' AND '".$op.$end."'")
                        ->orderBy("FIRST_ARCHIVE_NO")
                        ->get();
                    $page_sum = DB::table("REG_VEHICLE_ARCHIVE")->select(["INSERT_PAGE_COUNT AS PAGE_COUNT"])->whereRaw("STATUS = 1 AND FIRST_ARCHIVE_NO BETWEEN '".$op.$start."' AND '".$op.$end."'")->sum("PAGE_COUNT");
                } else {
                    $archives = DB::table("REG_VEHICLE_ARCHIVE")
                        ->select(["INSERT_ARCHIVE_NO AS ARCHIVE_NO", "CREATED_DATE", "INSERT_PLATE_NO", "INSERT_PAGE_COUNT AS PAGE_COUNT","certificate_no","insert_certificate_no"])
                        ->whereRaw("(INSERT_SERVICE_ID = 2 OR INSERT_SERVICE_ID = 3 OR INSERT_SERVICE_ID = 5 OR INSERT_SERVICE_ID = 13 OR INSERT_SERVICE_ID = 14 OR INSERT_SERVICE_ID = 15 OR INSERT_SERVICE_ID = 19 or  INSERT_SERVICE_ID = 17) AND INSERT_ARCHIVE_NO BETWEEN '".$op.$start."' AND '".$op.$end."'")
                        ->orderBy("INSERT_ARCHIVE_NO")
                        ->get();
                    $page_sum = DB::table("REG_VEHICLE_ARCHIVE")->select(["INSERT_PAGE_COUNT AS PAGE_COUNT"])->whereRaw("(INSERT_SERVICE_ID = 2 OR INSERT_SERVICE_ID = 3 OR INSERT_SERVICE_ID = 5 OR INSERT_SERVICE_ID = 13 OR INSERT_SERVICE_ID = 14 OR INSERT_SERVICE_ID = 15 OR INSERT_SERVICE_ID = 19) AND INSERT_ARCHIVE_NO BETWEEN '".$op.$start."' AND '".$op.$end."'")->sum("PAGE_COUNT");
                }
                return view('Reports.archive', compact('start', 'end', 'archives', 'page_sum', 'op'));
            } else {
                return view('Reports.archive');
            }
        } catch (\Exception $ex){
            return view('Reports.archive');
        }
    }

    protected function exportToExcelArchive(Request $request){
        $op = $request->route("op");
        $start = $op.$request->route("start");
        $end = $op.$request->route("end");
        if($start != "none" && $end != "none"){
            Excel::create("아카이브ын товъёог", function($excel) use($op, $start, $end) {
                $excel->setTitle("아카이브ын товъёог");
                $excel->setCreator("ATUT");
                $excel->sheet("보고서", function($sheet) use($op, $start, $end) {
                    //Header үүсгэх
                    $sheet->setWidth(array(
                        'A'     =>  10,
                        'B'     =>  8,
                        'C'     =>  13,
                        'D'     =>  21,
                        'E'     =>  10,
                        'F'     =>  12,
                        'G'     =>  10,
                        'H'     =>  10,
                        'I'     =>  14
                    ));

                    //로고 입력
                    if (session()->get('auth')->iscity == 1) {
                        $objDrawing = new \PHPExcel_Worksheet_Drawing;
                        $objDrawing->setPath(public_path('/img/niislel.jpg')); //your image path
                        $objDrawing->setCoordinates('B1');
                        $objDrawing->setWidthAndHeight(55, 55);
                        $objDrawing->setWorksheet($sheet);
                        $sheet->setOrientation('landscape');
                        $sheet->appendRow(array("", "", "", "", "", "",  "수도 자동차운송 차량", ""));
                        $sheet->appendRow(array("", "", "", "", "", "", "등록·관리 센터 ", ""));                
                        $sheet->mergeCells('G1:I1');
                        $sheet->mergeCells('G2:I2');
                } else {
                    $objDrawing = new \PHPExcel_Worksheet_Drawing;
                    $objDrawing->setPath(public_path('/img/logo.png')); //your image path
                    $objDrawing->setCoordinates('B1');
                    $objDrawing->setWidthAndHeight(55, 55);
                    $objDrawing->setWorksheet($sheet);
                    $sheet->appendRow(array("", "", "", "", "", "", "자동차운송", ""  ));
                    $sheet->appendRow(array("", "", "", "", "", "", "국가센터", ""));
                    $sheet->mergeCells('G1:I1');
                    $sheet->mergeCells('G2:I2');
                }
                    $sheet->cell('G1', function ($cell) {
                        $this->cellRight($cell);
                    });
                    $sheet->cell('G2', function ($cell) {
                        $this->cellRight($cell);
                    });
                    $sheet->getStyle('G1')->getFont()->setBold(true);
                    $sheet->getStyle('G2')->getFont()->setBold(true);
                    $sheet->setPaperSize(\PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
                    $sheet->appendRow(array("","","","", "", "", "",""));

                    $sheet->appendRow(array('','ATUT архивын товъёог'));
                    $sheet->getStyle('B4:I4')->getFont()->setBold(true);
                    $sheet->getStyle('B4:I4')->getFont()->setSize(12);
                    $sheet->mergeCells('B4:I4');
                    $sheet->cell('B4', function ($cell) {
                        $this->center($cell);
                    });
                    $sheet->appendRow(array("","","","", "", "", "",""));
                    $sheet->appendRow(array(
                        "","아카이브 번호: ".$start." -с ".$end
                    ));
                    $sheet->mergeCells('B6:I6');
                    $sheet->getStyle('B6:I6')->getFont()->setBold(true);
                    $sheet->cell('B6', function ($cell) {
                        $this->center($cell);
                    });
                    $sheet->appendRow(array("","","","", "", "",""));
                    $sheet->appendRow(array("","№", "일자", "아카이브 번호", "번호판", "면수", "시작 번호", "종료 번호","Устгах гэрчилгээ"));
                    $sheet->getStyle('B8:I8')->getFont()->setBold(true);
                    $sheet->getStyle('B8:I8')->getFont()->setSize(12);
                    $sheet->getStyle('B8:I8')->getAlignment()->setWrapText(true);
                    //열 서식 지정
                    $sheet->setColumnFormat(array('0', '0', '@', '@', '@', '0', '0', '0','@'));
                    //위에서 준비한 Array 값을 Excel 파일로보내기
                    if($op == "ШЭ"){
                        $datas = DB::table("REG_VEHICLE_ARCHIVE")
                            ->select(["ARCHIVE_NO", "CREATED_DATE", "INSERT_PLATE_NO", "INSERT_PAGE_COUNT AS PAGE_COUNT","certificate_no","insert_certificate_no"   ])
                            ->whereRaw("STATUS = 1 AND FIRST_ARCHIVE_NO BETWEEN '".$start."' AND '".$end."'")
                            ->orderBy("FIRST_ARCHIVE_NO")
                            ->get();
                    } else {
                        $datas = DB::table("REG_VEHICLE_ARCHIVE")
                            ->select(["INSERT_ARCHIVE_NO AS ARCHIVE_NO", "CREATED_DATE", "INSERT_PLATE_NO", "INSERT_PAGE_COUNT AS PAGE_COUNT","certificate_no","insert_certificate_no"])
                            ->whereRaw("(INSERT_SERVICE_ID = 2 OR INSERT_SERVICE_ID = 3 OR INSERT_SERVICE_ID = 5 OR INSERT_SERVICE_ID = 13 OR INSERT_SERVICE_ID = 14 OR INSERT_SERVICE_ID = 15 OR INSERT_SERVICE_ID = 19 or  INSERT_SERVICE_ID = 17) AND INSERT_ARCHIVE_NO BETWEEN '".$start."' AND '".$end."'")
                            ->orderBy("INSERT_ARCHIVE_NO")
                            ->get();
                    }
                    $init = array();
                    $i = 1;
                    $sum = 0;
                    $count = 0;
                    $tmp_count = 0;
                   
                    foreach ($datas as $data){
                      
                        if($data->archive_no != ""){
                            $sum += $data->page_count;
                            if($sum <= 250){
                                if($data->page_count != null){
                                   
                                    array_push($init, array("", $i, Carbon::parse($data->created_date)->format("Y-m-d"), $data->archive_no, $data->insert_plate_no, $data->page_count, $count == 0 ? 1 : $count + $tmp_count, $count == 0 ? $data->page_count : $tmp_count + $data->page_count,$data->certificate_no != $data->insert_certificate_no ? $data->certificate_no : ""));
                                    $count = 1;
                                    $tmp_count += $data->page_count;
                                } else {
                                    array_push($init, array("", $i, Carbon::parse($data->created_date)->format("Y-m-d"), $data->archive_no, $data->insert_plate_no, $data->page_count, 0, 0));
                                }
                                $i++;
                            } else {
                                $sum -= $data->page_count;
                                break;
                            }
                        }
                    }
                    $sheet->rows($init);
                    $sheet->appendRow(array(
                        "","합계","","","",$sum
                    ));
                    $sheet->getStyle('B'.($i+8).':I'.($i+8))->getFont()->setBold(true);
                    $sheet->mergeCells('B'.($i+8).':E'.($i+8));
                    for($j = 8; $j <= $i + 8; $j++){
                        $sheet->cell('B'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('C'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('D'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('E'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('F'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('G'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('H'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('I'.($j), function ($cell) {
                            $this->center($cell);
                        });
                    }
                    $sheet->getStyle('B8:I'.($i + 9))->applyFromArray([
                        'borders' => array(
                            'allborders' => array(
                                'style' => \PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    ]);
                    $sheet->appendRow(array(
                        "","","","","",""
                    ));
                    $sheet->appendRow(array(
                        "","","","","",""
                    ));
                    $sheet->appendRow(array(
                        "","","","보고서 작성: . . . . . . . . . . . /____________________/"
                    ));
                    $sheet->setFitToPage(true);
                    $sheet->setScale(80);
                });
            })->download('xls');
        }
    } 

    public function indexForm(Request $request){ 
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        $vehId= session()->get("vehicle")->id;
        $historie1 = DB::table("REG_VEHICLE_ARCHIVE")
                            ->select("*")
                            ->where("VEHICLE_ID", $vehId)
                            ->distinct("PLATE_NO")
                            ->whereNotNull("PLATE_NO")
                            ->whereNotNull("ARCHIVE_NO")
                            ->orderBy("UPDATED_DATE", "DESC")
                            ->get();
        
                          
      if (empty($historie1[0])) {
     
     
      $historie1 = collect([
        (object) [
            'service_id' => 1,
            'insert_service_id' => 0,
            'insert_finger' => 0,
            
        ]
        
    ]);
        $historie1=$historie1[0];
   }else{
        $historie1=$historie1[0];
    }
            
           // return $historie1->service_id;
        return view('Reports.vehicleform',compact('historie1'));
    }

    public function indexDailyTransfer(Request $request){
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        if(!$this->checkAccess("/report/daily/transfer", $this->enc(session()->get("auth")->userpositionid))){
            return redirect(route($this->redirectAccess));
        }
        if (session()->get('auth')->iscity ==1) {
            $archives = SystemArchive::where('is_type',2)->orderBy("ARCHIVE")->get();
        } else {
            $archives = SystemArchive::where('is_type',1)->orderBy("ARCHIVE")->get();
        }
        
        
        if($request->isMethod("POST")){
            $abbr = $request->get("branch");
            $start = $request->get("start");
            $end = $request->get("end");
            $results = DB::select(DB::raw("SELECT v.INSERT_ARCHIVE_NO, v.PLATE_NO, v.INSERT_PLATE_NO, v.INSERT_CERTIFICATE_NO, s.name FROM REG_VEHICLE_ARCHIVE v left join SYSTEM_SERVICE s on v.INSERT_SERVICE_ID=s.id WHERE SUBSTR(v.INSERT_ARCHIVE_NO,3,3)=N'".$abbr."' AND (v.INSERT_SERVICE_ID=2 OR v.INSERT_SERVICE_ID=3 OR v.INSERT_SERVICE_ID=5 OR v.INSERT_SERVICE_ID=13 OR v.INSERT_SERVICE_ID=14 OR v.INSERT_SERVICE_ID=15 OR v.INSERT_SERVICE_ID=19) and v.CREATED_DATE BETWEEN '".$start."' AND '".$end." 23:59:59' ORDER BY v.INSERT_ARCHIVE_NO"));
            $sum_results = DB::select(DB::raw("SELECT INSERT_SERVICE_ID, COUNT(*) total FROM REG_VEHICLE_ARCHIVE WHERE SUBSTR(INSERT_ARCHIVE_NO,3,3)='".$abbr."' AND CREATED_DATE BETWEEN '".$start."' AND '".$end." 23:59:59' GROUP BY INSERT_SERVICE_ID"));
            $sum_to = DB::select(DB::raw("SELECT COUNT (CASE WHEN OLD_PROVINCE_ID=22 AND PROVINCE_ID!=22 THEN 1 END) ub_on FROM  REG_VEHICLE_ARCHIVE v WHERE  SUBSTR(v.INSERT_ARCHIVE_NO,3,3)=N'".$abbr."' AND (v.SERVICE_ID=14) and v.CREATED_DATE BETWEEN '".$start."' AND '".$end." 23:59:59'"));
            $sum_from = DB::select(DB::raw("SELECT COUNT (CASE WHEN OLD_PROVINCE_ID!=22 AND PROVINCE_ID=22 THEN 1 END) on_ub FROM  REG_VEHICLE_ARCHIVE v WHERE SUBSTR(v.INSERT_ARCHIVE_NO,3,3)=N'".$abbr."' AND (v.SERVICE_ID=14) and v.CREATED_DATE BETWEEN '".$start."' AND '".$end." 23:59:59'"));
            $total_array = array(0,0,0,0,0,0,0,0,0);
            foreach ($sum_results as $result){
                if($result->insert_service_id == 15){
                    $total_array[0] += $result->total;
                }
                if($result->insert_service_id == 3){
                    $total_array[1] += $result->total;
                }
                if($result->insert_service_id == 14){
                    $total_array[2] += $result->total;
                }
                if($result->insert_service_id == 2){
                    $total_array[3] += $result->total;
                }
                if($result->insert_service_id == 13){
                    $total_array[4] += $result->total;
                }
                if($result->insert_service_id == 5){
                    $total_array[5] += $result->total;
                }
                if($result->insert_service_id == 19){
                    $total_array[6] += $result->total; 
                }
            }
            if(sizeof($sum_to) > 0){
                $total_array[7] += $sum_to[0]->ub_on;
            }
            if(sizeof($sum_from) > 0){
                $total_array[8] += $sum_from[0]->on_ub;
            }
            return view('Reports.dailytransfer', compact('archives', 'results', 'total_array', 'abbr', 'start', 'end'));
        } else {
            return view('Reports.dailytransfer', compact('archives'));
        }
    }

    protected function exportToExcelDailyTransfer(Request $request){
        $branch = $request->route("branch");
        $start = $request->route("start");
        $end = $request->route("end");
        if($branch != "none" && $start != "none" && $end != "none"){
            Excel::create("이전ийн тайлан", function($excel) use($branch, $start, $end) {
                $excel->setTitle("이전ийн тайлан");
                $excel->setCreator("ATUT");
                $excel->sheet("보고서", function($sheet) use($branch, $start, $end) {
                    //Header үүсгэх
                    $sheet->setWidth(array(
                        'A'     =>  5,
                        'B'     =>  18,
                        'C'     =>  15,
                        'D'     =>  14,
                        'E'     =>  16,
                        'F'     =>  25
                    ));

                    //로고 입력
                    if (session()->get('auth')->iscity == 1) {
                        $objDrawing = new \PHPExcel_Worksheet_Drawing;
                        $objDrawing->setPath(public_path('/img/niislel.jpg')); //your image path
                        $objDrawing->setCoordinates('B1');
                        $objDrawing->setWidthAndHeight(55, 55);
                        $objDrawing->setWorksheet($sheet);
                        $sheet->setOrientation('landscape');
                        $sheet->appendRow(array("", "", "", "",  "수도 자동차운송 차량", ""));
                        $sheet->appendRow(array("", "", "", "",  "등록·관리 센터 ", ""));                
                        $sheet->mergeCells('E1:F1');
                        $sheet->mergeCells('E2:F2');
                    }else{

                    $objDrawing = new \PHPExcel_Worksheet_Drawing;
                    $objDrawing->setPath(public_path('/img/logo.png')); //your image path
                    $objDrawing->setCoordinates('B1');
                    $objDrawing->setWidthAndHeight(55, 55);
                    $objDrawing->setWorksheet($sheet);
                    $sheet->appendRow(array("", "", "", "", "자동차운송", ""));
                    $sheet->appendRow(array("", "", "", "", "국가센터", ""));
                    $sheet->mergeCells('E1:F1');
                    $sheet->mergeCells('E2:F2');
                     }
                    $sheet->cell('E1', function ($cell) {
                        $this->cellRight($cell);
                    });
                    $sheet->cell('E2', function ($cell) {
                        $this->cellRight($cell);
                    });
                    $sheet->getStyle('E1')->getFont()->setBold(true);
                    $sheet->getStyle('E2')->getFont()->setBold(true);
                    $sheet->setPaperSize(\PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
                    $sheet->appendRow(array("","","","","",""));

                    $sheet->appendRow(array('ШИЛЖИЛТИЙН ДЭЛГЭРЭНГҮЙ ТАЙЛАН'));
                    $sheet->getStyle('A4:F4')->getFont()->setBold(true);
                    $sheet->getStyle('A4:F4')->getFont()->setSize(12);
                    $sheet->mergeCells('A4:F4');
                    $sheet->cell('F4', function ($cell) {
                        $this->center($cell);
                    });
                    $sheet->appendRow(array("","","","","",""));

                    $names = SystemArchive::where("Abbr", $branch)->get();
                    $branch_name = "";
                    if($names->count() > 0){
                        $branch_name = $names->first()->archive;
                    }

                    $sheet->appendRow(array(
                        "지점: ".$branch_name, "", "", "", "일자: ".$start." - ".$end, ""
                    ));
                    $sheet->mergeCells('A6:C6');
                    $sheet->mergeCells('E6:F6');

                    $sheet->getStyle('A6:C6')->getFont()->setBold(true);
                    $sheet->getStyle('E6:F6')->getFont()->setBold(true);

                    $sheet->appendRow(array(
                        "№",
                        "아카이브 번호",
                        "Өмнөх 번호",
                        "Одоогийн 번호",
                        "증명서 번호",
                        "서비스"
                    ));

                    $this->setPrintMargins($sheet, 0.5, 1, 0.5, 1);
                    $this->setPrintFitToWidth($sheet);
                    $this->parseCssProperties($sheet, "D", "7", "wrap-text", "true");
                    $this->parseCssProperties($sheet, "E", "7", "wrap-text", "true");

                    $sheet->getStyle('A7:F7')->getFont()->setBold(true);
                    $sheet->getStyle('A7:F7')->getFont()->setSize(12);
                    $datas = DB::select(DB::raw("SELECT v.INSERT_ARCHIVE_NO, v.PLATE_NO, v.INSERT_PLATE_NO, v.INSERT_CERTIFICATE_NO, s.name FROM REG_VEHICLE_ARCHIVE v left join SYSTEM_SERVICE s on v.INSERT_SERVICE_ID=s.id WHERE SUBSTR(v.INSERT_ARCHIVE_NO,3,3)=N'".$branch."' AND (v.INSERT_SERVICE_ID=2 OR v.INSERT_SERVICE_ID=3 OR v.INSERT_SERVICE_ID=5 OR v.INSERT_SERVICE_ID=13 OR v.INSERT_SERVICE_ID=14 OR v.INSERT_SERVICE_ID=15 OR v.INSERT_SERVICE_ID=19) and v.CREATED_DATE BETWEEN '".$start."' AND '".$end." 23:59:59' ORDER BY v.INSERT_ARCHIVE_NO"));
                    $init = array();
                    $i = 1;

                    $sum_results = DB::select(DB::raw("SELECT INSERT_SERVICE_ID, COUNT(*) total FROM REG_VEHICLE_ARCHIVE WHERE SUBSTR(INSERT_ARCHIVE_NO,3,3)='".$branch."' AND CREATED_DATE BETWEEN '".$start."' AND '".$end." 23:59:59' GROUP BY INSERT_SERVICE_ID"));
                    $sum_to = DB::select(DB::raw("SELECT COUNT (CASE WHEN OLD_PROVINCE_ID=22 AND PROVINCE_ID!=22  THEN 1 END) ub_on FROM REG_VEHICLE_ARCHIVE v WHERE SUBSTR(v.INSERT_ARCHIVE_NO,3,3)=N'".$branch."' AND (v.SERVICE_ID=14) and v.CREATED_DATE BETWEEN '".$start."' AND '".$end." 23:59:59'"));
                    $sum_from = DB::select(DB::raw("SELECT COUNT (CASE WHEN OLD_PROVINCE_ID!=22 AND PROVINCE_ID=22  THEN 1 END) on_ub FROM REG_VEHICLE_ARCHIVE v WHERE SUBSTR(v.INSERT_ARCHIVE_NO,3,3)=N'".$branch."' AND (v.SERVICE_ID=14) and v.CREATED_DATE BETWEEN '".$start."' AND '".$end." 23:59:59'"));
                    $total_array = array(0,0,0,0,0,0,0,0,0);
                    foreach ($sum_results as $result){
                        if($result->insert_service_id == 15){
                            $total_array[0] += $result->total;
                        }
                        if($result->insert_service_id == 3){
                            $total_array[1] += $result->total;
                        }
                        if($result->insert_service_id == 14){
                            $total_array[2] += $result->total;
                        }
                        if($result->insert_service_id == 2){
                            $total_array[3] += $result->total;
                        }
                        if($result->insert_service_id == 13){
                            $total_array[4] += $result->total;
                        }
                        if($result->insert_service_id == 5){
                            $total_array[5] += $result->total;
                        }
                        if($result->insert_service_id == 19){
                            $total_array[6] += $result->total;
                        }
                    }
                    if(sizeof($sum_to) > 0){
                        $total_array[7] += $sum_to[0]->ub_on;
                    }
                    if(sizeof($sum_from) > 0){
                        $total_array[8] += $sum_from[0]->on_ub;
                    }
                    foreach ($datas as $data){
                        if($data->insert_archive_no != ""){
                            array_push($init, array(
                                $i,
                                $data->insert_archive_no,
                                $data->plate_no,
                                $data->insert_plate_no,
                                $data->insert_certificate_no,
                                $data->name
                            ));
                            $i++;
                        }
                    }
                    $sheet->rows($init);
                    $sheet->appendRow(
                        array("번호판 солилт","","","","",$total_array[0])
                    );
                    $sheet->appendRow(
                        array("소유자 이전","","","","",$total_array[1])
                    );
                    $sheet->appendRow(
                        array("번호판 교체 이전","","","","",$total_array[2])
                    );
                    $sheet->appendRow(
                        array("증명서 갱신","","","","",$total_array[3])
                    );
                    $sheet->appendRow(
                        array("증명서 교체","","","","",$total_array[4])
                    );
                    $sheet->appendRow(
                        array("문자 말소","","","","",$total_array[5])
                    );
                    $sheet->appendRow(
                        array("말소에서 복구됨","","","","",$total_array[6])
                    );
                    $sheet->appendRow(
                        array("울란바토르-지방","","","","",$total_array[7])
                    );
                    $sheet->appendRow(
                        array("지방-울란바토르","","","","",$total_array[8])
                    );
                    //$sheet->getStyle('A'.($i+13).':F'.($i+13))->getFont()->setBold(true);
                    //$sheet->mergeCells('A'.($i+7).':B'.($i+7));
                    for($j = 1; $j <= $i + 15; $j++){
                        $sheet->cell('A'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('B'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('C'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('D'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('E'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('F'.($j), function ($cell) {
                            $this->center($cell);
                        });
                    }
                    for($j = $i + 7; $j <= $i + 15; $j++) {
                        $sheet->mergeCells('A' . ($j) . ':E' . ($j));
                        $sheet->getStyle('A' . ($j) . ':F' . ($j))->getFont()->setBold(true);
                    }
                    $sheet->getStyle('A7:F'.($i + 15))->applyFromArray([
                        'borders' => array(
                            'allborders' => array(
                                'style' => \PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    ]);
                    $sheet->appendRow(array(
                        "","","","","",""
                    ));
                    $sheet->appendRow(array(
                        "","","","","",""
                    ));
                    $sheet->appendRow(array(
                        "","","보고서 작성: . . . . . . . . . . . /____________________/"
                    ));
                    $sheet->setFitToPage(true);
                    $sheet->setScale(80);
                });
            })->download('xls');
        }
    }

    public function indexDailyImport(Request $request){
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        if(!$this->checkAccess("/report/daily/import", $this->enc(session()->get("auth")->userpositionid))){
            return redirect(route($this->redirectAccess));
        }
        if (session()->get('auth')->iscity ==1) {
            $archives = SystemArchive::where('is_type',2)->orderBy("ARCHIVE")->get();
        } else {
            $archives = SystemArchive::where('is_type',1)->orderBy("ARCHIVE")->get();
        }
       // $archives = SystemArchive::orderBy("ARCHIVE")->get();
       
        if($request->isMethod("POST")){
           // dd($request);
            $abbr = $request->get("branch");
            $startDate = $request->get("start");
            $endDate = $request->get("end");
            if (session()->get("auth")->iscity == 1) {
                $results = DB::select(DB::raw("SELECT v.FIRST_ARCHIVE_NO ARCHIVE_NO, v.PLATE_NO, v.CERTIFICATE_NO, v.UPDATED_DATE ARCHIVE_DATE FROM REG_VEHICLE_ARCHIVE v WHERE 
                 v.FIRST_ARCHIVE_NO LIKE '%".$abbr."%'  AND v.STATUS = 1 AND v.FIRST_ARCHIVE_NO = v.INSERT_ARCHIVE_NO AND v.UPDATED_DATE BETWEEN '".$startDate."' AND '".$endDate." 23:59:59' ORDER BY v.FIRST_ARCHIVE_NO ASC"));
                $move_data = DB::select(DB::raw("SELECT COUNT (CASE WHEN PROVINCE_ID = 22 THEN 1 END) ULAANBAATAR, COUNT (CASE WHEN PROVINCE_ID != 22 THEN 1  END) ORON_NUTAG FROM REG_VEHICLE_ARCHIVE v WHERE v.FIRST_ARCHIVE_NO LIKE '%".$abbr."%'  AND v.status = 1 AND v.FIRST_ARCHIVE_NO = v.INSERT_ARCHIVE_NO AND v.UPDATED_DATE BETWEEN '".$startDate."' AND '".$endDate." 23:59:59' ORDER BY v.FIRST_ARCHIVE_NO ASC"));
                $type_data = DB::select(DB::raw("SELECT COUNT (CASE WHEN PURPOSE_ID =1 THEN 1 END) suudal,COUNT (CASE WHEN PURPOSE_ID =2 THEN 1 END) achaa,COUNT (CASE WHEN PURPOSE_ID =3 THEN 1 END) avtobus,COUNT (CASE WHEN PURPOSE_ID =4 THEN 1 END) tusgai,COUNT (CASE WHEN PURPOSE_ID =5 THEN 1 END) tsisteren,COUNT (CASE WHEN PURPOSE_ID =6 THEN 1 END) zvtgvvr,COUNT (CASE WHEN PURPOSE_ID =7 THEN 1 END) mehanizm,COUNT (CASE WHEN PURPOSE_ID =8 THEN 1 END) chirguul,COUNT (CASE WHEN PURPOSE_ID =9 THEN 1 END) motocycle FROM ARCHIVE_SEARCH_VIEW WHERE FIRST_ARCHIVE_NO LIKE '%".$abbr."%'  AND STATUS = 1 AND FIRST_ARCHIVE_NO = INSERT_ARCHIVE_NO AND CREATED_DATE BETWEEN '".$startDate."' AND '".$endDate." 23:59:59'"));
            }else{
                $results = DB::select(DB::raw("SELECT v.FIRST_ARCHIVE_NO ARCHIVE_NO, v.PLATE_NO, v.CERTIFICATE_NO, v.UPDATED_DATE ARCHIVE_DATE FROM REG_VEHICLE_ARCHIVE v WHERE SUBSTR(v.FIRST_ARCHIVE_NO,3,3)=N'".$abbr."' AND v.STATUS = 1 AND v.FIRST_ARCHIVE_NO = v.INSERT_ARCHIVE_NO AND v.UPDATED_DATE BETWEEN '".$startDate."' AND '".$endDate." 23:59:59' ORDER BY v.FIRST_ARCHIVE_NO ASC"));
                $move_data = DB::select(DB::raw("SELECT COUNT (CASE WHEN PROVINCE_ID = 22 THEN 1 END) ULAANBAATAR, COUNT (CASE WHEN PROVINCE_ID != 22 THEN 1  END) ORON_NUTAG FROM REG_VEHICLE_ARCHIVE v WHERE SUBSTR(v.FIRST_ARCHIVE_NO,3,3)=N'".$abbr."' AND v.status = 1 AND v.FIRST_ARCHIVE_NO = v.INSERT_ARCHIVE_NO AND v.UPDATED_DATE BETWEEN '".$startDate."' AND '".$endDate." 23:59:59' ORDER BY v.FIRST_ARCHIVE_NO ASC"));
                $type_data = DB::select(DB::raw("SELECT COUNT (CASE WHEN PURPOSE_ID =1 THEN 1 END) suudal,COUNT (CASE WHEN PURPOSE_ID =2 THEN 1 END) achaa,COUNT (CASE WHEN PURPOSE_ID =3 THEN 1 END) avtobus,COUNT (CASE WHEN PURPOSE_ID =4 THEN 1 END) tusgai,COUNT (CASE WHEN PURPOSE_ID =5 THEN 1 END) tsisteren,COUNT (CASE WHEN PURPOSE_ID =6 THEN 1 END) zvtgvvr,COUNT (CASE WHEN PURPOSE_ID =7 THEN 1 END) mehanizm,COUNT (CASE WHEN PURPOSE_ID =8 THEN 1 END) chirguul,COUNT (CASE WHEN PURPOSE_ID =9 THEN 1 END) motocycle FROM ARCHIVE_SEARCH_VIEW WHERE SUBSTR(FIRST_ARCHIVE_NO,3,3)=N'".$abbr."' AND STATUS = 1 AND FIRST_ARCHIVE_NO = INSERT_ARCHIVE_NO AND CREATED_DATE BETWEEN '".$startDate."' AND '".$endDate." 23:59:59'"));
            }
           
            $move = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
            if(sizeof($move_data) > 0){
                $move[0] = $move_data[0]->ulaanbaatar;
                $move[1] = $move_data[0]->oron_nutag;
                $move[2] = $type_data[0]->suudal;
                $move[3] = $type_data[0]->achaa;
                $move[4] = $type_data[0]->avtobus;
                $move[5] = $type_data[0]->tusgai;
                $move[6] = $type_data[0]->tsisteren;
                $move[7] = $type_data[0]->zvtgvvr;
                $move[8] = $type_data[0]->mehanizm;
                $move[9] = $type_data[0]->chirguul;
                $move[10] = $type_data[0]->motocycle;
            }
            return view('Reports.dailyimport', compact('archives', 'results', 'archive', 'abbr', 'startDate', 'endDate', 'total', 'car', 'mehanizm', 'chirguul', 'move', 'bycycle'));
        } else {
            return view('Reports.dailyimport', compact('archives'));
        }
    }

    protected function exportToExcelDailyImport(Request $request){
        $branch = $request->route("branch");
        $start = $request->route("start");
        $end = $request->route("end");
        if($branch != "none" && $start != "none" && $end != "none"){
            Excel::create("Импортын дэлгэрэнгүй", function($excel) use($branch, $start, $end) {
                $excel->setTitle("Импортын дэлгэрэнгүй");
                $excel->setCreator("ATUT");
                $excel->sheet("보고서", function($sheet) use($branch, $start, $end) {
                    //Header үүсгэх
                    $sheet->setWidth(array(
                        'A'     =>  5,
                        'B'     =>  18,
                        'C'     =>  15,
                        'D'     =>  18,
                        'E'     =>  18
                    ));

                    //로고 입력
                    if (session()->get('auth')->iscity == 1) {
                        $objDrawing = new \PHPExcel_Worksheet_Drawing;
                        $objDrawing->setPath(public_path('/img/niislel.jpg')); //your image path
                        $objDrawing->setCoordinates('B1');
                        $objDrawing->setWidthAndHeight(55, 55);
                        $objDrawing->setWorksheet($sheet);
                        $sheet->setOrientation('landscape');
                        $sheet->appendRow(array("", "", "", "",  "수도 자동차운송 차량", ""));
                        $sheet->appendRow(array("", "", "", "",  "등록·관리 센터 ", ""));                
                        $sheet->mergeCells('E1:E1');
                        $sheet->mergeCells('E2:E2');
                    }else{
                    $objDrawing = new \PHPExcel_Worksheet_Drawing;
                    $objDrawing->setPath(public_path('/img/logo.png')); //your image path
                    $objDrawing->setCoordinates('B1');
                    $objDrawing->setWidthAndHeight(55, 55);
                    $objDrawing->setWorksheet($sheet);
                    $sheet->appendRow(array("", "", "", "", "자동차운송", ""));
                    $sheet->appendRow(array("", "", "", "", "국가센터", ""));
                    $sheet->mergeCells('E1:E1');
                    $sheet->mergeCells('E2:E2');
                    }
                    $sheet->cell('E1', function ($cell) {
                        $this->cellRight($cell);
                    });
                    $sheet->cell('E2', function ($cell) {
                        $this->cellRight($cell);
                    });
                    $sheet->getStyle('E1')->getFont()->setBold(true);
                    $sheet->getStyle('E2')->getFont()->setBold(true);
                    $sheet->setPaperSize(\PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
                    $sheet->appendRow(array("","","","",""));

                    $sheet->appendRow(array('ИМПОРТЫН ДЭЛГЭРЭНГҮЙ ТАЙЛАН'));
                    $sheet->getStyle('A4:E4')->getFont()->setBold(true);
                    $sheet->getStyle('A4:E4')->getFont()->setSize(12);
                    $sheet->mergeCells('A4:E4');
                    $sheet->cell('F4', function ($cell) {
                        $this->center($cell);
                    });
                    $sheet->appendRow(array("","","","",""));

                    $names = SystemArchive::where("Abbr", $branch)->get();
                    $branch_name = "";
                    if($names->count() > 0){
                        $branch_name = $names->first()->archive;
                    }

                    $sheet->appendRow(array(
                        "지점: ".$branch_name, "", "", "일자: ".$start." - ".$end, ""
                    ));
                    $sheet->mergeCells('A6:C6');
                    $sheet->mergeCells('D6:E6');

                    $sheet->getStyle('A6:C6')->getFont()->setBold(true);
                    $sheet->getStyle('D6:E6')->getFont()->setBold(true);

                    $sheet->appendRow(array(
                        "№",
                        "아카이브 번호",
                        "번호판",
                        "증명서 번호",
                        "일자"
                    ));

                    $this->setPrintMargins($sheet, 0.5, 1, 0.5, 1);
                    $this->setPrintFitToWidth($sheet);
                    $this->parseCssProperties($sheet, "C", "7", "wrap-text", "true");
                    $this->parseCssProperties($sheet, "D", "7", "wrap-text", "true");

                    $sheet->getStyle('A7:E7')->getFont()->setBold(true);
                    $sheet->getStyle('A7:E7')->getFont()->setSize(12);
                if (session()->get('auth')->iscity == 1) {
                    $datas = DB::select(DB::raw("SELECT v.FIRST_ARCHIVE_NO ARCHIVE_NO, v.PLATE_NO, v.CERTIFICATE_NO, v.UPDATED_DATE ARCHIVE_DATE FROM REG_VEHICLE_ARCHIVE v WHERE  
                     v.FIRST_ARCHIVE_NO LIKE '%".$branch."%' AND v.STATUS=1 AND v.FIRST_ARCHIVE_NO = v.INSERT_ARCHIVE_NO AND v.UPDATED_DATE BETWEEN '".$start."' AND '".$end." 23:59:59' ORDER BY v.FIRST_ARCHIVE_NO ASC"));
                    $move_data = DB::select(DB::raw("SELECT COUNT (CASE WHEN PROVINCE_ID =22 THEN 1 END) ULAANBAATAR, COUNT (CASE WHEN PROVINCE_ID !=22 THEN 1  END) ORON_NUTAG FROM REG_VEHICLE_ARCHIVE v WHERE   v.FIRST_ARCHIVE_NO LIKE '%".$branch."%'  AND v.STATUS=1 AND v.FIRST_ARCHIVE_NO = v.INSERT_ARCHIVE_NO AND v.UPDATED_DATE BETWEEN '".$start."' AND '".$end." 23:59:59' ORDER BY v.FIRST_ARCHIVE_NO ASC"));
                    $type_data = DB::select(DB::raw("SELECT COUNT (CASE WHEN PURPOSE_ID =1 THEN 1 END) suudal,COUNT (CASE WHEN PURPOSE_ID =2 THEN 1 END) achaa,COUNT (CASE WHEN PURPOSE_ID =3 THEN 1 END) avtobus,COUNT (CASE WHEN PURPOSE_ID =4 THEN 1 END) tusgai,COUNT (CASE WHEN PURPOSE_ID =5 THEN 1 END) tsisteren,COUNT (CASE WHEN PURPOSE_ID =6 THEN 1 END) zvtgvvr,COUNT (CASE WHEN PURPOSE_ID =7 THEN 1 END) mehanizm,COUNT (CASE WHEN PURPOSE_ID =8 THEN 1 END) chirguul,COUNT (CASE WHEN PURPOSE_ID =9 THEN 1 END) motocycle FROM ARCHIVE_SEARCH_VIEW WHERE FIRST_ARCHIVE_NO LIKE '%".$branch."%'  AND STATUS = 1  AND FIRST_ARCHIVE_NO = INSERT_ARCHIVE_NO AND CREATED_DATE BETWEEN '".$start."' AND '".$end." 23:59:59'"));
                }else{
                    $datas = DB::select(DB::raw("SELECT v.FIRST_ARCHIVE_NO ARCHIVE_NO, v.PLATE_NO, v.CERTIFICATE_NO, v.UPDATED_DATE ARCHIVE_DATE FROM REG_VEHICLE_ARCHIVE v WHERE  SUBSTR(v.FIRST_ARCHIVE_NO,3,3)=N'".$branch."' AND v.STATUS=1 AND v.FIRST_ARCHIVE_NO = v.INSERT_ARCHIVE_NO AND v.UPDATED_DATE BETWEEN '".$start."' AND '".$end." 23:59:59' ORDER BY v.FIRST_ARCHIVE_NO ASC"));
                    $move_data = DB::select(DB::raw("SELECT COUNT (CASE WHEN PROVINCE_ID =22 THEN 1 END) ULAANBAATAR, COUNT (CASE WHEN PROVINCE_ID !=22 THEN 1  END) ORON_NUTAG FROM REG_VEHICLE_ARCHIVE v WHERE SUBSTR(v.FIRST_ARCHIVE_NO,3,3)=N'".$branch."' AND v.STATUS=1 AND v.FIRST_ARCHIVE_NO = v.INSERT_ARCHIVE_NO AND v.UPDATED_DATE BETWEEN '".$start."' AND '".$end." 23:59:59' ORDER BY v.FIRST_ARCHIVE_NO ASC"));
                    $type_data = DB::select(DB::raw("SELECT COUNT (CASE WHEN PURPOSE_ID =1 THEN 1 END) suudal,COUNT (CASE WHEN PURPOSE_ID =2 THEN 1 END) achaa,COUNT (CASE WHEN PURPOSE_ID =3 THEN 1 END) avtobus,COUNT (CASE WHEN PURPOSE_ID =4 THEN 1 END) tusgai,COUNT (CASE WHEN PURPOSE_ID =5 THEN 1 END) tsisteren,COUNT (CASE WHEN PURPOSE_ID =6 THEN 1 END) zvtgvvr,COUNT (CASE WHEN PURPOSE_ID =7 THEN 1 END) mehanizm,COUNT (CASE WHEN PURPOSE_ID =8 THEN 1 END) chirguul,COUNT (CASE WHEN PURPOSE_ID =9 THEN 1 END) motocycle FROM ARCHIVE_SEARCH_VIEW WHERE SUBSTR(FIRST_ARCHIVE_NO,3,3)=N'".$branch."' AND STATUS = 1  AND FIRST_ARCHIVE_NO = INSERT_ARCHIVE_NO AND CREATED_DATE BETWEEN '".$start."' AND '".$end." 23:59:59'"));
                }
                    $move = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
                    if(sizeof($move_data) > 0){
                        $move[0] = $move_data[0]->ulaanbaatar;
                        $move[1] = $move_data[0]->oron_nutag;
                        $move[2] = $type_data[0]->suudal;
                        $move[3] = $type_data[0]->achaa;
                        $move[4] = $type_data[0]->avtobus;
                        $move[5] = $type_data[0]->tusgai;
                        $move[6] = $type_data[0]->tsisteren;
                        $move[7] = $type_data[0]->zvtgvvr;
                        $move[8] = $type_data[0]->mehanizm;
                        $move[9] = $type_data[0]->chirguul;
                        $move[10] = $type_data[0]->motocycle;
                    }
                    $init = array();
                    $i = 1;

                    foreach ($datas as $data){
                        if($data->archive_no != ""){
                            array_push($init, array(
                                $i,
                                $data->archive_no,
                                $data->plate_no,
                                $data->certificate_no,
                                $data->archive_date
                            ));
                            $i++;
                        }
                    }
                    $sheet->rows($init);
                    $sheet->appendRow(
                        array("울란바토르","","","",$move[0])
                    );
                    $sheet->appendRow(
                        array("지방","","","",$move[1])
                    );
                    $sheet->appendRow(
                        array("좌석","","","",$move[2])
                    );
                    $sheet->appendRow(
                        array("화물","","","",$move[3])
                    );
                    $sheet->appendRow(
                        array("버스","","","",$move[4])
                    );
                    $sheet->appendRow(
                        array("특수","","","",$move[5])
                    );
                    $sheet->appendRow(
                        array("탱크","","","",$move[6])
                    );
                    $sheet->appendRow(
                        array("기관차","","","",$move[7])
                    );
                    $sheet->appendRow(
                        array("기계","","","",$move[8])
                    );
                    $sheet->appendRow(
                        array("트레일러","","","",$move[9])
                    );
                    $sheet->appendRow(
                        array("오토바이","","","",$move[10])
                    );
                    for($j = 1; $j <= $i + 17; $j++){
                        $sheet->cell('A'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('B'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('C'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('D'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('E'.($j), function ($cell) {
                            $this->center($cell);
                        });
                    }
                    for($j = $i + 7; $j <= $i + 17; $j++) {
                        $sheet->mergeCells('A' . ($j) . ':D' . ($j));
                        $sheet->getStyle('A' . ($j) . ':E' . ($j))->getFont()->setBold(true);
                        $sheet->cell('A'.($j), function ($cell) {
                            $this->cellRight($cell);
                        });
                    }
                    $sheet->getStyle('A7:E'.($i + 17))->applyFromArray([
                        'borders' => array(
                            'allborders' => array(
                                'style' => \PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    ]);

                    $sheet->appendRow(array(
                        "",""
                    ));
                    $sheet->appendRow(array(
                        "",""
                    ));
                    $sheet->appendRow(array(
                        "","보고서 гаргасан: . . . . . . . . . . . . . /____________________/"
                    ));
                    $sheet->setFitToPage(true);
                    $sheet->setScale(80);
                });
            })->download('xls');
        }
    }

    public function indexDailyUser(Request $request){
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        if(!$this->checkAccess("/report/daily/users", $this->enc(session()->get("auth")->userpositionid))){
            return redirect(route($this->redirectAccess));
        }

        if (session()->get("auth")->iscity == 1 && session()->get("auth")->isatvt == 0) {
            $users = DB::table("MAIN_USER_VIEW")->where("PROVINCEID", $userPkId = session()->get("auth")->provinceid)->where('IsCity',1)->orderBy("FIRSTNAME")->get();
        } else {
            $users = DB::table("MAIN_USER_VIEW")->where("PROVINCEID", $userPkId = session()->get("auth")->provinceid)->where("IsAtvt", 1)->orderBy("FIRSTNAME")->get();
        }
        
      //  $users = DB::table("MAIN_USER_VIEW")->where("PROVINCEID", $userPkId = session()->get("auth")->provinceid)->where("IsAtvt", 1)->OrWhere('IsCity',1)->orderBy("FIRSTNAME")->get();
        if($request->isMethod("POST")){
            $curr_user = $request->get("user");
            $startDate = $request->get("start");
            $endDate = $request->get("end");
            $results = DB::select(DB::raw(
                "SELECT to_char(CREATED_DATE, 'YYYY-MM-DD') ARCHIVE_DATE, 
                0  NEW_V ,	
                COUNT (CASE  WHEN INSERT_SERVICE_ID = 3  THEN 1  END) MOVE_V ,	
                COUNT (CASE  WHEN INSERT_SERVICE_ID =14  THEN 1  END) MOVE_PLATE_V , 
                COUNT (CASE  WHEN INSERT_SERVICE_ID =13  THEN 1  END) CERT_CHANGE_V ,
                COUNT (CASE  WHEN INSERT_SERVICE_ID =2  THEN 1  END) CERT_AGAIN_V ,
                COUNT (CASE  WHEN INSERT_SERVICE_ID =12  THEN 1  END) LIMIT_V ,
                COUNT (CASE  WHEN INSERT_SERVICE_ID =9  THEN 1  END) REMOVE_V ,
                COUNT (CASE  WHEN INSERT_SERVICE_ID =15  THEN 1  END) CHANGE_PLATE_V ,
                COUNT (CASE  WHEN INSERT_SERVICE_ID =16  THEN 1  END) CHANGE_PLATE_TWO_V ,
                COUNT (CASE  WHEN INSERT_SERVICE_ID =8  THEN 1  END) EDIT_V,
                COUNT (CASE  WHEN INSERT_SERVICE_ID =5  THEN 1  END) DELETE_PLATE,
                COUNT (CASE  WHEN INSERT_SERVICE_ID =19  THEN 1  END) RESTORE_PLATE,
                COUNT (CASE  WHEN INSERT_SERVICE_ID =6  THEN 1  END) PRINT_V 
                FROM REG_VEHICLE_ARCHIVE WHERE UPDATED_BY='".$curr_user."' AND CREATED_DATE BETWEEN '".$startDate."' AND '".$endDate." 23:59:59'  
                GROUP BY to_char(CREATED_DATE, 'YYYY-MM-DD') ORDER BY ARCHIVE_DATE"
            ));


            $results1 = DB::select(DB::raw("SELECT to_char(UPDATED_DATE, 'YYYY-MM-DD') ARCHIVE_DATE, COUNT(CASE WHEN STATUS=1 THEN 1 END) NEW_V FROM REG_VEHICLE_ARCHIVE WHERE CREATED_BY='".$curr_user."' AND UPDATED_DATE BETWEEN '".$startDate."' AND '".$endDate." 23:59:59' GROUP BY to_char(UPDATED_DATE, 'YYYY-MM-DD') ORDER BY ARCHIVE_DATE"));
            foreach ($results as $result){
                foreach ($results1 as $r){
                    if($result->archive_date == $r->archive_date){
                        $result->new_v += $r->new_v;
                    }
                }
            }
            return view('Reports.dailyusers', compact('users', 'results', 'curr_user', 'startDate', 'endDate'));
        } else {
            return view('Reports.dailyusers', compact('users'));
        }
    }

    protected function exportToExcelDailyUser(Request $request){
        $user = $request->route("user");
        $start = $request->route("start");
        $end = $request->route("end");
        if($user != "none" && $start != "none" && $end != "none"){
            Excel::create("Мэргэ년тний тайлан", function($excel) use($user, $start, $end) {
                $excel->setTitle("Мэргэ년тний тайлан");
                $excel->setCreator("ATUT");
                $excel->sheet("보고서", function($sheet) use($user, $start, $end) {
                    //Header үүсгэх
                    $sheet->setWidth(array(
                        'A'     =>  5,
                        'B'     =>  12,
                        'C'     =>  8,
                        'D'     =>  12,
                        'E'     =>  15,
                        'F'     =>  12,
                        'G'     =>  12,
                        'H'     =>  14,
                        'I'     =>  10,
                        'J'     =>  12,
                        'K'     =>  15,
                        'L'     =>  10,
                        'M'     =>  10,
                        'N'     =>  12,
                        'O'     =>  12
                    ));

                    //로고 입력
                    if (session()->get('auth')->iscity == 1) {
                        $objDrawing = new \PHPExcel_Worksheet_Drawing;
                        $objDrawing->setPath(public_path('/img/niislel.jpg')); //your image path
                        $objDrawing->setCoordinates('B1');
                        $objDrawing->setWidthAndHeight(55, 55);
                        $objDrawing->setWorksheet($sheet);
                        $sheet->setOrientation('landscape');
                        $sheet->appendRow(array("", "", "", "", "", "", "", "", "", "", "", "", "",  "수도 자동차운송 차량", ""));
                        $sheet->appendRow(array("", "", "", "", "", "", "", "", "", "", "", "", "", "등록·관리 센터 ",  ""));
                        $sheet->mergeCells('N1:O1');
                        $sheet->mergeCells('N2:O2');
                } else {
                    $objDrawing = new \PHPExcel_Worksheet_Drawing;
                    $objDrawing->setPath(public_path('/img/logo.png')); //your image path
                    $objDrawing->setCoordinates('B1');
                    $objDrawing->setWidthAndHeight(55, 55);
                    $objDrawing->setWorksheet($sheet);
                    $sheet->setOrientation('landscape');
                    $sheet->appendRow(array("", "", "", "", "", "", "", "", "", "", "", "", "", "자동차운송", ""));
                    $sheet->appendRow(array("", "", "", "", "", "", "", "", "", "", "", "", "", "국가센터", ""));
                    $sheet->mergeCells('N1:O1');
                    $sheet->mergeCells('N2:O2');
                }
                    $sheet->cell('N1', function ($cell) {
                        $this->cellRight($cell);
                    });
                    $sheet->cell('N2', function ($cell) {
                        $this->cellRight($cell);
                    });
                    $sheet->getStyle('N1')->getFont()->setBold(true);
                    $sheet->getStyle('N2')->getFont()->setBold(true);
                    $sheet->setPaperSize(\PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
                    $sheet->appendRow(array("","","","", "", "", ""));

                    $sheet->appendRow(array('МЭРГЭЖИЛТНИЙ ТАЙЛАН'));
                    $sheet->getStyle('A4:O4')->getFont()->setBold(true);
                    $sheet->getStyle('A4:O4')->getFont()->setSize(12);
                    $sheet->mergeCells('A4:O4');
                    $sheet->cell('O4', function ($cell) {
                        $this->center($cell);
                    });

                    $sheet->cell('O1', function ($cell) {
                        $this->cellRight($cell);
                    });

                    $sheet->cell('M2', function ($cell) {
                        $this->cellRight($cell);
                    });
                    $names = DB::table("MAIN_USER_VIEW")->where("ID", $user)->get()->first();
                    $sheet->appendRow(array(
                        "담당자 이름: ".$names->lastname." ".$names->firstname, "", "", "", "", "", "", "", "", "", "", "", "일자: ".$start." - ".$end, ""
                    ));
                    $sheet->mergeCells('A5:D5');
                    $sheet->mergeCells('M5:O5');

                    $sheet->getStyle('A5:D5')->getFont()->setBold(true);
                    $sheet->getStyle('M5:O5')->getFont()->setBold(true);

                    $sheet->appendRow(array(
                        "№",
                        "일자",
                        "신규",
                        "이전",
                        "번호판 교체 이전",
                        "증명서 교체",
                        "증명서 갱신",
                        "제한 사항",
                        "말소",
                        "번호판 교체",
                        "번호판 간 교체",
                        "인쇄",
                        "수정",
                        "문자 말소",
                        "말소에서 복구됨"
                    ));

                    $this->setPrintMargins($sheet, 0.5, 0.1, 0.5, 0.1);
                    //$this->setPrintFitToWidth($sheet);
                    $this->parseCssProperties($sheet, "F", "6", "wrap-text", "true");
                    $this->parseCssProperties($sheet, "E", "6", "wrap-text", "true");
                    $this->parseCssProperties($sheet, "G", "6", "wrap-text", "true");
                    $this->parseCssProperties($sheet, "K", "6", "wrap-text", "true");
                    $this->parseCssProperties($sheet, "N", "6", "wrap-text", "true");
                    $this->parseCssProperties($sheet, "O", "6", "wrap-text", "true");

                    $sheet->getStyle('A6:O6')->getFont()->setBold(true);
                    $sheet->getStyle('A6:O6')->getFont()->setSize(12);
                    $datas = DB::select(DB::raw(
                        "SELECT to_char(CREATED_DATE, 'YYYY-MM-DD') ARCHIVE_DATE, 
                        0  NEW_V ,	
                        COUNT (CASE  WHEN SERVICE_ID = 3  THEN 1  END) MOVE_V ,	
                        COUNT (CASE  WHEN INSERT_SERVICE_ID =14  THEN 1  END) MOVE_PLATE_V , 
                        COUNT (CASE  WHEN INSERT_SERVICE_ID =13  THEN 1  END) CERT_CHANGE_V ,
                        COUNT (CASE  WHEN INSERT_SERVICE_ID =2  THEN 1  END) CERT_AGAIN_V ,
                        COUNT (CASE  WHEN INSERT_SERVICE_ID =12  THEN 1  END) LIMIT_V ,
                        COUNT (CASE  WHEN INSERT_SERVICE_ID =9  THEN 1  END) REMOVE_V ,
                        COUNT (CASE  WHEN INSERT_SERVICE_ID =15  THEN 1  END) CHANGE_PLATE_V ,
                        COUNT (CASE  WHEN INSERT_SERVICE_ID =16  THEN 1  END) CHANGE_PLATE_TWO_V ,
                        COUNT (CASE  WHEN INSERT_SERVICE_ID =8  THEN 1  END) EDIT_V,
                        COUNT (CASE  WHEN INSERT_SERVICE_ID =5  THEN 1  END) DELETE_PLATE,
                        COUNT (CASE  WHEN INSERT_SERVICE_ID =19  THEN 1  END) RESTORE_PLATE,
                        COUNT (CASE  WHEN INSERT_SERVICE_ID =6  THEN 1  END) PRINT_V 
                        FROM REG_VEHICLE_ARCHIVE WHERE UPDATED_BY='".$user."' AND CREATED_DATE BETWEEN '".$start."' AND '".$end." 23:59:59'  
                        GROUP BY to_char(CREATED_DATE, 'YYYY-MM-DD') ORDER BY ARCHIVE_DATE"
                    ));

                    $results1 = DB::select(DB::raw("SELECT to_char(UPDATED_DATE, 'YYYY-MM-DD') ARCHIVE_DATE, COUNT(CASE WHEN STATUS=1 THEN 1 END) NEW_V FROM REG_VEHICLE_ARCHIVE WHERE CREATED_BY='".$user."' AND UPDATED_DATE BETWEEN '".$start."' AND '".$end." 23:59:59' GROUP BY to_char(UPDATED_DATE, 'YYYY-MM-DD') ORDER BY ARCHIVE_DATE"));
                    foreach ($datas as $result){
                        foreach ($results1 as $r){
                            if($result->archive_date == $r->archive_date){
                                $result->new_v += $r->new_v;
                            }
                        }
                    }
                    $init = array();
                    $i = 1;
                    $sum = array(0,0,0,0,0,0,0,0,0,0,0,0,0);
                    foreach ($datas as $data){
                        if($data->archive_date != ""){
                            array_push($init, array(
                                $i,
                                $data->archive_date,
                                $data->new_v,
                                $data->move_v,
                                $data->move_plate_v,
                                $data->cert_change_v,
                                $data->cert_again_v,
                                $data->limit_v,
                                $data->remove_v,
                                $data->change_plate_v,
                                $data->change_plate_two_v,
                                $data->print_v,
                                $data->edit_v,
                                $data->delete_plate,
                                $data->restore_plate
                            ));

                            $sum[0] += $data->new_v;
                            $sum[1] += $data->move_v;
                            $sum[2] += $data->move_plate_v;
                            $sum[3] += $data->cert_change_v;
                            $sum[4] += $data->cert_again_v;
                            $sum[5] += $data->limit_v;
                            $sum[6] += $data->remove_v;
                            $sum[7] += $data->change_plate_v;
                            $sum[8] += $data->change_plate_two_v;
                            $sum[9] += $data->print_v;
                            $sum[10] += $data->edit_v;
                            $sum[11] += $data->delete_plate;
                            $sum[12] += $data->restore_plate;
                            $i++;
                        }
                    }
                    $sheet->rows($init);
                    $sheet->appendRow(array(
                        "합계",
                        "",
                        $sum[0],
                        $sum[1],
                        $sum[2],
                        $sum[3],
                        $sum[4],
                        $sum[5],
                        $sum[6],
                        $sum[7],
                        $sum[8],
                        $sum[9],
                        $sum[10],
                        $sum[11],
                        $sum[12]
                    ));
                    $sheet->getStyle('A'.($i+6).':O'.($i+6))->getFont()->setBold(true);
                    $sheet->mergeCells('A'.($i+6).':B'.($i+6));
                    for($j = 1; $j <= $i + 6; $j++){
                        $sheet->cell('A'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('B'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('C'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('D'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('E'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('F'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('G'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('H'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('I'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('J'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('K'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('L'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('M'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('N'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('O'.($j), function ($cell) {
                            $this->center($cell);
                        });
                    }
                    $sheet->getStyle('A6:O'.($i + 6))->applyFromArray([
                        'borders' => array(
                            'allborders' => array(
                                'style' => \PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    ]);
                    $sheet->appendRow(array(
                        "","","","","",""
                    ));
                    $sheet->appendRow(array(
                        "","","","","",""
                    ));
                    $sheet->appendRow(array(
                        "","","","","","보고서 작성: . . . . . . . . . . . /____________________/"
                    ));
                    $sheet->setFitToPage(true);
                    $sheet->setScale(80);
                });
            })->download('xls');
        }
    }

    public function indexDailyUserInfo(Request $request){
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        if(!$this->checkAccess("/report/daily/users/info", $this->enc(session()->get("auth")->userpositionid))){
            return redirect(route($this->redirectAccess));
        }
        if (session()->get("auth")->iscity == 1 && session()->get("auth")->isatvt == 0) {
            $users = DB::table("MAIN_USER_VIEW")->where("PROVINCEID", $userPkId = session()->get("auth")->provinceid)->where('IsCity',1)->orderBy("FIRSTNAME")->get();
        } else {
            $users = DB::table("MAIN_USER_VIEW")->where("PROVINCEID", $userPkId = session()->get("auth")->provinceid)->where("IsAtvt", 1)->orderBy("FIRSTNAME")->get();
        }
       // $users = DB::table("MAIN_USER_VIEW")->where("IsAtvt", 1)->where("PROVINCEID", $userPkId = session()->get("auth")->provinceid)->orderBy("FIRSTNAME")->get();
        if($request->isMethod("POST")){
            $op = $request->get("operation");
            $curr_user = $request->get("user");
            $startDate = $request->get("start");
            $endDate = $request->get("end");

            if($op == "ШХ"){
                $results = DB::select(DB::raw(
                    "SELECT ar.INSERT_ARCHIVE_NO ARCHIVE_NO, ar.PLATE_NO,VEN.MARK_NAME,
                    VEN.MODEL_NAME,VEN.PURPOSE_NAME,VEN.CABIN_NO,VEN.BUILD_YEAR,OW.LAST_NAME, SS.NAME SERVICE_NAME,
                      OW.FIRST_NAME,OW.REGISTER_NO,OW.ADDRESS_DETAIL FROM VRS.REG_VEHICLE_VIEW VEN JOIN  
                      VRS.REG_VEHICLE_ARCHIVE ar ON VEN.ID=ar.VEHICLE_ID join VRS.OWNER OW ON 
                      ar.OWNER_ID=OW.ID JOIN VRS.SYSTEM_SERVICE SS ON ar.INSERT_SERVICE_ID=SS.ID JOIN VRS.SYSTEM_USER US ON ar.UPDATED_BY=US.ID WHERE ar.UPDATED_BY='".$curr_user."' AND
                       (ar.INSERT_SERVICE_ID=2 OR ar.INSERT_SERVICE_ID=3 OR ar.INSERT_SERVICE_ID=13 OR ar.INSERT_SERVICE_ID=5 OR ar.INSERT_SERVICE_ID=19 OR
                        ar.INSERT_SERVICE_ID=14 OR ar.INSERT_SERVICE_ID=15) and ar.CREATED_DATE BETWEEN '".$startDate."' AND '".$endDate." 23:59:59' ORDER BY ar.INSERT_ARCHIVE_NO"
                ));
            } else {
                $results = DB::select(DB::raw(
                    "SELECT ar.FIRST_ARCHIVE_NO ARCHIVE_NO,
                  ar.CREATED_BY,ar.PLATE_NO, SS.NAME SERVICE_NAME,
                  VEN.MARK_NAME,VEN.MODEL_NAME,VEN.PURPOSE_NAME,VEN.CABIN_NO,VEN.BUILD_YEAR,OW.LAST_NAME, 
                  OW.FIRST_NAME, OW.REGISTER_NO, OW.ADDRESS_DETAIL FROM VRS.REG_VEHICLE_VIEW VEN JOIN 
                  VRS.REG_VEHICLE_ARCHIVE ar ON VEN.ID=ar.VEHICLE_ID JOIN VRS.SYSTEM_SERVICE SS ON ar.INSERT_SERVICE_ID=SS.ID JOIN VRS.OWNER OW ON ar.OWNER_ID=OW.ID JOIN 
                  VRS.SYSTEM_USER US ON ar.CREATED_BY=US.ID WHERE ar.CREATED_BY='".$curr_user."' AND  ar.STATUS=1 and 
                  ar.UPDATED_DATE BETWEEN '".$startDate."' AND '".$endDate." 23:59:59' ORDER BY ar.INSERT_ARCHIVE_NO"
                ));
            }
            return view('Reports.dailyusersinfo', compact('users', 'results', 'curr_user', 'op', 'startDate', 'endDate'));
        } else {
            return view('Reports.dailyusersinfo', compact('users'));
        }
    }

    protected function exportToExcelDailyUserInfo(Request $request){
        $op = $request->route("branch");
        $user = $request->route("user");
        $start = $request->route("start");
        $end = $request->route("end");
        if($user != "none" && $start != "none" && $end != "none"){
            Excel::create("Мэргэ년тний дэлгэрэнгүй тайлан", function($excel) use($op, $user, $start, $end) {
                $excel->setTitle("Мэргэ년тний дэлгэрэнгүй тайлан");
                $excel->setCreator("ATUT");
                $excel->sheet("보고서", function($sheet) use($op, $user, $start, $end) {
                    //Header үүсгэх
                    $sheet->setWidth(array(
                        'A'     =>  5,
                        'B'     =>  18,
                        'C'     =>  10,
                        'D'     =>  15,
                        'E'     =>  12,
                        'F'     =>  12,
                        'G'     =>  18,
                        'H'     =>  8,
                        'I'     =>  20,
                        'J'     =>  15,
                        'K'     =>  20,
                        'L'     =>  22
                    ));

                    //로고 입력
                    if (session()->get('auth')->iscity == 1) {
                        $objDrawing = new \PHPExcel_Worksheet_Drawing;
                        $objDrawing->setPath(public_path('/img/niislel.jpg')); //your image path
                        $objDrawing->setCoordinates('B1');
                        $objDrawing->setWidthAndHeight(55, 55);
                        $objDrawing->setWorksheet($sheet);
                        $sheet->setOrientation('landscape');
                        $sheet->appendRow(array("", "", "", "", "", "", "", "", "",  "수도 자동차운송 차량", ""));
                        $sheet->appendRow(array("", "", "", "", "", "", "", "", "",  "등록·관리 센터 ",  ""));
                        $sheet->mergeCells('J1:L1');
                        $sheet->mergeCells('J2:L2');
                } else {
                    $objDrawing = new \PHPExcel_Worksheet_Drawing;
                    $objDrawing->setPath(public_path('/img/logo.png')); //your image path
                    $objDrawing->setCoordinates('B1');
                    $objDrawing->setWidthAndHeight(55, 55);
                    $objDrawing->setWorksheet($sheet);
                    $sheet->setOrientation('landscape');
                    $sheet->appendRow(array("", "", "", "", "", "", "", "", "", "자동차운송", ""));
                    $sheet->appendRow(array("", "", "", "", "", "", "", "", "", "국가센터", ""));
                    $sheet->mergeCells('J1:L1');
                    $sheet->mergeCells('J2:L2');
                }
                    $sheet->cell('J1', function ($cell) {
                        $this->cellRight($cell);
                    });
                    $sheet->cell('J2', function ($cell) {
                        $this->cellRight($cell);
                    });
                    $sheet->getStyle('J1')->getFont()->setBold(true);
                    $sheet->getStyle('J2')->getFont()->setBold(true);
                    $sheet->setPaperSize(\PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
                    $sheet->appendRow(array("","","","", "", "", ""));

                    if($op == "ШХ"){
                        $sheet->appendRow(array('МЭРГЭЖИЛТНИЙ ШИЛЖИЛТ ХӨДӨЛГӨӨНИЙ ДЭЛГЭРЭНГҮЙ ТАЙЛАН'));
                    } else {
                        $sheet->appendRow(array('МЭРГЭЖИЛТНИЙ ИМПОРТЫН ДЭЛГЭРЭНГҮЙ ТАЙЛАН'));
                    }

                    $sheet->getStyle('A4:L4')->getFont()->setBold(true);
                    $sheet->getStyle('A4:L4')->getFont()->setSize(12);
                    $sheet->mergeCells('A4:L4');

                    $sheet->cell('L1', function ($cell) {
                        $this->cellRight($cell);
                    });

                    $sheet->cell('L2', function ($cell) {
                        $this->cellRight($cell);
                    });

                    $names = DB::table("MAIN_USER_VIEW")->where("ID", $user)->get()->first();
                    $sheet->appendRow(array(
                        "담당자 이름: ".$names->lastname." ".$names->firstname, "", "", "", "", "", "", "", "", "일자: ".$start." - ".$end, ""
                    ));
                    $sheet->mergeCells('A5:D5');
                    $sheet->mergeCells('J5:L5');

                    $sheet->getStyle('A5:D5')->getFont()->setBold(true);
                    $sheet->getStyle('J5:L5')->getFont()->setBold(true);

                    $sheet->appendRow(array(
                        "№",
                        "아카이브 번호",
                        "번호판",
                        "브랜드",
                        "모델",
                        "용도",
                        "Арлын дгаар",
                        "작업일",
                        "Өмч. 성명",
                        "Регистрийн №",
                        "주소",
                        "서비스"
                    ));

                    $this->setPrintMargins($sheet, 0.1, 0.25, 0.5, 0.1);
                    $this->setPrintFitToWidth($sheet);
                    $sheet->getStyle('A6:L6')->getFont()->setBold(true);
                    $sheet->getStyle('A6:L6')->getFont()->setSize(12);

                    if($op == "ШХ"){
                        $datas = DB::select(DB::raw(
                            "SELECT ar.INSERT_ARCHIVE_NO ARCHIVE_NO, ar.PLATE_NO,VEN.MARK_NAME,
                    VEN.MODEL_NAME,VEN.PURPOSE_NAME,VEN.CABIN_NO,VEN.BUILD_YEAR,OW.LAST_NAME, SS.NAME SERVICE_NAME,
                      OW.FIRST_NAME,OW.REGISTER_NO,OW.ADDRESS_DETAIL FROM VRS.REG_VEHICLE_VIEW VEN JOIN  
                      VRS.REG_VEHICLE_ARCHIVE ar ON VEN.ID=ar.VEHICLE_ID JOIN VRS.SYSTEM_SERVICE SS ON ar.INSERT_SERVICE_ID=SS.ID JOIN VRS.OWNER OW ON 
                      ar.OWNER_ID=OW.ID JOIN VRS.SYSTEM_USER US ON ar.UPDATED_BY=US.ID WHERE ar.UPDATED_BY='".$user."' AND
                       (ar.INSERT_SERVICE_ID=2 OR ar.INSERT_SERVICE_ID=3 OR ar.INSERT_SERVICE_ID=13 OR ar.INSERT_SERVICE_ID=5 OR ar.INSERT_SERVICE_ID=19 OR
                        ar.INSERT_SERVICE_ID=14 OR ar.INSERT_SERVICE_ID=15) and ar.CREATED_DATE BETWEEN '".$start."' AND '".$end." 23:59:59'  ORDER BY ar.INSERT_ARCHIVE_NO"
                        ));
                    } else {
                        $datas = DB::select(DB::raw(
                            "SELECT ar.FIRST_ARCHIVE_NO ARCHIVE_NO,
                  ar.CREATED_BY,ar.PLATE_NO, SS.NAME SERVICE_NAME,
                  VEN.MARK_NAME,VEN.MODEL_NAME, VEN.PURPOSE_NAME,VEN.CABIN_NO,VEN.BUILD_YEAR,OW.LAST_NAME, 
                  OW.FIRST_NAME, OW.REGISTER_NO, OW.ADDRESS_DETAIL FROM VRS.REG_VEHICLE_VIEW VEN JOIN 
                  VRS.REG_VEHICLE_ARCHIVE ar ON VEN.ID=ar.VEHICLE_ID JOIN VRS.SYSTEM_SERVICE SS ON ar.INSERT_SERVICE_ID=SS.ID JOIN VRS.OWNER OW ON ar.OWNER_ID=OW.ID JOIN 
                  VRS.SYSTEM_USER US ON ar.CREATED_BY=US.ID WHERE ar.CREATED_BY='".$user."' AND  ar.STATUS=1 and 
                  ar.UPDATED_DATE BETWEEN '".$start."' AND '".$end." 23:59:59' ORDER BY ar.INSERT_ARCHIVE_NO"
                        ));
                    }
                    $i = 1;
                    $init = array();
                    foreach ($datas as $data){
                        if($data->archive_no != ""){
                            array_push($init, array(
                                $i,
                                $data->archive_no,
                                $data->plate_no,
                                $data->mark_name,
                                $data->model_name,
                                $data->purpose_name,
                                $data->cabin_no,
                                $data->build_year,
                                $data->last_name." ".$data->first_name,
                                $data->register_no,
                                $data->address_detail,
                                $data->service_name
                            ));
                            $i++;
                        }
                    }
                    $sheet->rows($init);
                    for($j = 1; $j <= $i + 5; $j++){
                        $sheet->cell('A'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('B'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('C'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('D'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('E'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('F'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('G'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('H'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('I'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('J'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('K'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('L'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $this->parseCssProperties($sheet, "E", $j+6, "wrap-text", "true");
                        $this->parseCssProperties($sheet, "F", $j+6, "wrap-text", "true");
                        $this->parseCssProperties($sheet, "I", $j+6, "wrap-text", "true");
                        $this->parseCssProperties($sheet, "K", $j+6, "wrap-text", "true");
                    }
                    $sheet->getStyle('A6:L'.($i + 5))->applyFromArray([
                        'borders' => array(
                            'allborders' => array(
                                'style' => \PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    ]);
                    $sheet->appendRow(array(
                        "","","","","",""
                    ));
                    $sheet->appendRow(array(
                        "","","","","","보고서 작성: . . . . . . . . . . . /____________________/"
                    ));
                    $sheet->setFitToPage(true);
                    $sheet->setScale(80);
                });
            })->download('xls');
        }
    }

    public function indexDailyNewPlate(Request $request){
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        if(!$this->checkAccess("/report/daily/newplate", $this->enc(session()->get("auth")->userpositionid))){
            return redirect(route($this->redirectAccess));
        }
        $archives = SystemArchive::orderBy("ARCHIVE")->get();
        if($request->isMethod("POST")){
            $abbr = $request->get("branch");
            $startDate = $request->get("start");
            $endDate = $request->get("end");
            $results = DB::select(DB::raw(
                "SELECT to_char(ARCHIVE_DATE, 'YYYY-MM-DD') ARCHIVE_DATE,
                    COUNT (CASE WHEN TYPE_ID =1 THEN 1 END) PERSON,		
                    COUNT (CASE WHEN TYPE_ID =3 THEN 1 END) STATE_P,		
                    COUNT (CASE WHEN TYPE_ID =2 THEN 1 WHEN TYPE_ID =4 THEN 1 WHEN TYPE_ID =5 THEN 1 WHEN TYPE_ID =6 THEN 1 WHEN TYPE_ID=8 THEN 1 END) AAN
                    FROM ARCHIVE_VIEW WHERE SUBSTR(ARCHIVE_NO,3,3)=N'".$abbr."' AND (SERVICE_ID =1 OR  SERVICE_ID =14) AND ARCHIVE_DATE BETWEEN TO_DATE ('".$startDate."', 'YYYY-MM-DD') AND TO_DATE('".$endDate."', 'YYYY-MM-DD')  	
                    GROUP BY to_char(ARCHIVE_DATE, 'YYYY-MM-DD') ORDER BY ARCHIVE_DATE"
            ));
            return view('Reports.dailynewplate', compact('archives', 'results', 'abbr', 'startDate', 'endDate'));
        } else {
            return view('Reports.dailynewplate', compact('archives'));
        }
    }

    protected function exportToExcelDailyNewPlate(Request $request){
        $branch = $request->route("branch");
        $start = $request->route("start");
        $end = $request->route("end");
        if($branch != "none" && $start != "none" && $end != "none"){
            Excel::create("차량 -ийн УД шинээр олголтын тайлан", function($excel) use($branch, $start, $end) {
                $excel->setTitle("Тээврийн хэрэгслийн 번호판 шинээр олголтын тайлан");
                $excel->setCreator("ATUT");
                $excel->sheet("보고서", function($sheet) use($branch, $start, $end) {
                    //Header үүсгэх
                    $sheet->setWidth(array(
                        'A'     =>  5,
                        'B'     =>  12,
                        'C'     =>  15,
                        'D'     =>  22,
                        'E'     =>  25,
                        'F'     =>  10
                    ));
                    //로고 입력
                    if (session()->get('auth')->iscity == 1) {
                        $objDrawing = new \PHPExcel_Worksheet_Drawing;
                        $objDrawing->setPath(public_path('/img/niislel.jpg')); //your image path
                        $objDrawing->setCoordinates('B1');
                        $objDrawing->setWidthAndHeight(55, 55);
                        $objDrawing->setWorksheet($sheet);
                        $sheet->setOrientation('landscape');
                        $sheet->appendRow(array("", "", "", "",  "수도 자동차운송 차량", ""));
                        $sheet->appendRow(array("", "", "", "",  "등록·관리 센터 ",  ""));
                        $sheet->mergeCells('E1:F1');
                        $sheet->mergeCells('E2:F2');
                } else {
                    $objDrawing = new \PHPExcel_Worksheet_Drawing;
                    $objDrawing->setPath(public_path('/img/logo.png')); //your image path
                    $objDrawing->setCoordinates('A1');
                    $objDrawing->setWidthAndHeight(55, 55);
                    $objDrawing->setWorksheet($sheet);
                    $sheet->appendRow(array("", "", "", "", "자동차운송", ""));
                    $sheet->appendRow(array("", "", "", "", "국가센터", ""));
                    $sheet->mergeCells('E1:F1');
                    $sheet->mergeCells('E2:F2');
                }
                    $sheet->cell('E1', function ($cell) {
                        $this->cellRight($cell);
                    });
                    $sheet->cell('E2', function ($cell) {
                        $this->cellRight($cell);
                    });
                    $sheet->getStyle('E1')->getFont()->setBold(true);
                    $sheet->getStyle('E2')->getFont()->setBold(true);
                    $sheet->setPaperSize(\PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
                    $sheet->appendRow(array("","","","", "", "", ""));

                    $sheet->cell('E1', function ($cell) {
                        $this->cellRight($cell);
                    });

                    $sheet->cell('E2', function ($cell) {
                        $this->cellRight($cell);
                    });

                    $sheet->appendRow(array('차량 -ИЙН УД ШИНЭЭР ОЛГОЛТЫН ТАЙЛАН'));
                    $sheet->getStyle('A4:F4')->getFont()->setBold(true);
                    $sheet->getStyle('A4:F4')->getFont()->setSize(12);
                    $sheet->mergeCells('A4:F4');
                    $sheet->cell('A4', function ($cell) {
                        $this->center($cell);
                    });
                    $sheet->appendRow(array("","","","", "", "", ""));
                    $sheet->appendRow(array(
                        "지점: ".$branch, "", "", "", "일자: ".$start." - ".$end, "", ""
                    ));

                    $sheet->mergeCells('A6:C6');
                    $sheet->mergeCells('E6:F6');
                    $sheet->getStyle('A6:F6')->getFont()->setBold(true);
                    $sheet->cell('E6', function ($cell) {
                        $this->cellRight($cell);
                    });
                    $sheet->appendRow(array(
                        "№",
                        "일자",
                        "비율 хүнд",
                        "ААН, 기관д",
                        "Төрийн байгууллагад",
                        "합계"
                    ));

                    $sheet->getStyle('A7:F7')->getFont()->setBold(true);
                    $sheet->getStyle('A7:F7')->getFont()->setSize(12);
                    $datas = DB::select(DB::raw(
                        "SELECT to_char(ARCHIVE_DATE, 'YYYY-MM-DD') ARCHIVE_DATE,
                    COUNT (CASE WHEN TYPE_ID =1 THEN 1 END) PERSON,		
                    COUNT (CASE WHEN TYPE_ID =3 THEN 1 END) STATE_P,		
                    COUNT (CASE WHEN TYPE_ID =2 THEN 1 WHEN TYPE_ID =4 THEN 1 WHEN TYPE_ID =5 THEN 1 WHEN TYPE_ID =6 THEN 1 WHEN TYPE_ID=8 THEN 1 END) AAN
                    FROM ARCHIVE_VIEW WHERE SUBSTR(ARCHIVE_NO,3,3)=N'".$branch."' AND (SERVICE_ID =1 OR  SERVICE_ID =14) AND ARCHIVE_DATE BETWEEN TO_DATE ('".$start."', 'YYYY-MM-DD') AND TO_DATE('".$end."', 'YYYY-MM-DD')  	
                    GROUP BY to_char(ARCHIVE_DATE, 'YYYY-MM-DD') ORDER BY ARCHIVE_DATE"
                    ));
                    $init = array();
                    $i = 1;
                    foreach ($datas as $data){
                        if($data->archive_date != ""){
                            array_push($init, array(
                                $i,
                                $data->archive_date,
                                $data->person,
                                $data->state_p,
                                $data->aan,
                                $data->person + $data->state_p + $data->aan
                            ));
                            $i++;
                        }
                    }
                    $sheet->rows($init);
                    $sheet->getStyle('A'.($i+7).':F'.($i+7))->getFont()->setBold(true);
                    for($j = 7; $j <= $i + 7; $j++){
                        $sheet->cell('A'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('B'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('C'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('D'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('E'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('F'.($j), function ($cell) {
                            $this->center($cell);
                        });
                    }
                    $sheet->getStyle('A7:F'.($i + 7))->applyFromArray([
                        'borders' => array(
                            'allborders' => array(
                                'style' => \PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    ]);
                    $this->setPrintMargins($sheet, 0.5, 1, 0.5, 1);
                    $sheet->setFitToPage(true);
                    $sheet->setScale(80);
                });
            })->download('xls');
        }
    }

    public function indexDailyVehicleRef(Request $request){

      
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        if(!$this->checkAccess("/report/daily/vehicleref", $this->enc(session()->get("auth")->userpositionid))){
            return redirect(route($this->redirectAccess));
        }

        $orgs = RefReferenceOrg::orderBy("Name")->get(); 
        try {
            if($request->isMethod("POST")){
                $lastName = $request->get("lastName");
                $firstName = $request->get("firstName");
                $register = $request->get("register");
                $where = array();
                if(strlen($register) > 0){
                    array_push($where, "REGISTER_NO LIKE '".$register."%'");
                }
                if(strlen($lastName) > 0){ 
                    array_push($where, "LAST_NAME='".$lastName."'");
                }
                if(strlen($firstName) > 0){
                    array_push($where, "FIRST_NAME='".$firstName."'");
                }

                $filter = "WHERE ";
                $filter .= implode(" AND ", $where);
                if($filter == "WHERE "){
                    $filter .= "END_DATE IS NULL";
                } else {
                    $filter .= " AND END_DATE IS NULL AND STATUS != 9 AND STATUS != 10 ";
                }

                if(strlen($lastName) > 0 || strlen($firstName) > 0 || strlen($register) > 0){
                  
                    $results = DB::select(DB::raw(
                        "SELECT PLATE_NO,MARK_NAME,MODEL_NAME,CABIN_NO,CERTIFICATE_NO,COLOR_NAME,LAST_NAME,FIRST_NAME,REGISTER_NO FROM VEHICLE_OWNER_REF ".$filter." ORDER BY PLATE_NO"
                    ));
                
                    if(sizeof($results) > 0){
                        $lastName = $results[0]->last_name;
                        $firstName = $results[0]->first_name;
                        $register = $results[0]->register_no;
                       // return $userPkId;
                        return view('Reports.vehiclereference', compact('results', 'register', 'lastName', 'firstName', 'orgs'));
                    } else {
                        return view('Reports.vehiclereference', compact('orgs'));
                    }
                } else {
                    return view('Reports.vehiclereference', compact('orgs'));
                }
            } else {
                return view('Reports.vehiclereference', compact('orgs'));
            }
        } catch (\Exception $ex){
            $this->writeLog("Owner vehicle ref error: ". $ex->getMessage());
            return view('Reports.vehiclereference', compact('orgs'));
        }
    }
    public function indexDailyVehicleRef2(Request $request){

      
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        if(!$this->checkAccess("/report/daily/vehicleref2", $this->enc(session()->get("auth")->userpositionid))){
            return redirect(route($this->redirectAccess));
        }

        $orgs = RefReferenceOrg::orderBy("Name")->get(); 
        try {
            if($request->isMethod("POST")){
                $lastName = $request->get("lastName");
                $firstName = $request->get("firstName");
                $register = $request->get("register");

             

               // return $owner_register[0]->register_no;
                $where = array();
                if(strlen($register) > 0){
                    $ownerId = Owner::where("register_no", $register)->get()->first();

                    array_push($where, "owner1_id LIKE '".$ownerId->id."%'");
                }
                if(strlen($lastName) > 0){ 
                    $ownerId = Owner::where("last_name", $lastName)->get()->first();

                    $owner_register = DB::table("REG_VEHICLE_VIEW")
                    ->select("*")
                    ->where("owner1_id", $ownerId->id)
                  
                    ->get();
                    array_push($where, "LAST_NAME='".$owner_register[0]->last_name."'");
                }
                if(strlen($firstName) > 0){
                    $ownerId = Owner::where("first_name", $firstName)->get()->first();

                    $owner_register = DB::table("REG_VEHICLE_VIEW")
                    ->select("*")
                    ->where("owner1_id", $ownerId->id)
                  
                    ->get();
                    array_push($where, "FIRST_NAME='".$owner_register[0]->first_name."'");
                }

                $filter = "WHERE ";
                $filter .= implode(" AND ", $where);
                if($filter == "WHERE "){
                    $filter .= "";
                } else {
                    $filter .= "  AND STATUS != 9 AND STATUS != 10 ";
                }
//dd($filter);
                if(strlen($lastName) > 0 || strlen($firstName) > 0 || strlen($register) > 0){
                  
                    $results = DB::select(DB::raw(
                      //  "SELECT PLATE_NO,MARK_NAME,MODEL_NAME,CABIN_NO,CERTIFICATE_NO,COLOR_NAME,LAST_NAME,FIRST_NAME,REGISTER_NO FROM VEHICLE_OWNER_REF ".$filter." ORDER BY PLATE_NO"
                        "SELECT PLATE_NO,MARK_NAME,MODEL_NAME,CABIN_NO,CERTIFICATE_NO,COLOR_NAME,LAST_NAME,FIRST_NAME,REGISTER_NO FROM REG_VEHICLE_VIEW ".$filter." ORDER BY PLATE_NO"
                    ));
                
                    if(sizeof($results) > 0){
                    //     $lastName = $results[0]->last_name;
                    //     $firstName = $results[0]->first_name;
                    //     $register = $results[0]->register_no;
                        $lastName = $ownerId->last_name;
                        $firstName = $ownerId->first_name;
                        $register = $ownerId->register_no;
                    //    // return $userPkId;
                        return view('Reports.vehiclereference2', compact('results', 'register', 'lastName', 'firstName', 'orgs'));
                    } else {
                        return view('Reports.vehiclereference2', compact('orgs'));
                    }
                } else {
                    return view('Reports.vehiclereference2', compact('orgs'));
                }
            } else {
                return view('Reports.vehiclereference2', compact('orgs'));
            }
        } catch (\Exception $ex){
            $this->writeLog("Owner vehicle ref error: ". $ex->getMessage());
            return view('Reports.vehiclereference2', compact('orgs'));
        }
    }

    protected function exportToExcelVehicleRef2(Request $request){
        $register = $request->route("register");
        $lastName = $request->route("last");
        $firstName = $request->route("first");
        
        if($register != "none" || $lastName != "none" || $firstName != "none"){
            $where = array();
                   

         
            if($register != "none"){
      

           // array_push($where, "owner1_id LIKE '".$owner->id."%'");
            }
            if($lastName != "none"){
                array_push($where, "last_name='".$lastName."'");
            }
            if($firstName != "none"){
                array_push($where, "first_name='".$firstName."'");
            }
            $filter = "WHERE ";
            $filter .= implode(" AND ",$where);
            if($filter == "WHERE "){
                $filter .= "";
            } else {
                $filter .= "AND STATUS != 9 AND STATUS != 10 ";
            }
            Excel::create("차량 -ийн лавлагаа", function($excel) use($filter, $register, $lastName, $firstName) {
                $excel->setTitle("Тээврийн хэрэгслийн лавлагаа /Эзэмшигчээр/");
                $excel->setCreator("ATUT");
                $excel->sheet("보고서", function($sheet) use($filter, $register, $lastName, $firstName) {
                    //Header үүсгэх
                    $sheet->setWidth(array(
                        'A'     =>  5,
                        'B'     =>  15,
                        'C'     =>  15,
                        'D'     =>  15,
                        'E'     =>  22,
                        'F'     =>  22,
                        'G'     =>  15
                    ));
                    $sheet->setOrientation('landscape');
                    //로고 입력
                    if (session()->get('auth')->iscity == 1) {
                        $objDrawing = new \PHPExcel_Worksheet_Drawing;
                        $objDrawing->setPath(public_path('/img/niislel.jpg')); //your image path
                        $objDrawing->setCoordinates('B1');
                        $objDrawing->setWidthAndHeight(55, 55);
                        $objDrawing->setWorksheet($sheet);
                        $sheet->setOrientation('landscape');
                        $sheet->appendRow(array("", "", "", "","",  "수도 자동차운송 차량", ""));
                        $sheet->appendRow(array("", "", "", "","",  "등록·관리 센터 ",  ""));
                        $sheet->mergeCells('F1:G1');
                        $sheet->mergeCells('F2:G2');
                } else {
                    $objDrawing = new \PHPExcel_Worksheet_Drawing;
                    $objDrawing->setPath(public_path('/img/logo.png')); //your image path
                    $objDrawing->setCoordinates('A1');
                    $objDrawing->setWidthAndHeight(55, 55);
                    $objDrawing->setWorksheet($sheet);
                    $sheet->appendRow(array("", "", "", "", "", "자동차운송", ""));
                    $sheet->appendRow(array("", "", "", "", "", "국가센터", ""));
                    $sheet->mergeCells('F1:G1');
                    $sheet->mergeCells('F2:G2');
                }
                    $sheet->cell('F1', function ($cell) {
                        $this->cellRight($cell);
                    });
                    $sheet->cell('F2', function ($cell) {
                        $this->cellRight($cell);
                    });
                    $sheet->getStyle('F1')->getFont()->setBold(true);
                    $sheet->getStyle('F2')->getFont()->setBold(true);
                    $sheet->setPaperSize(\PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
                    $sheet->appendRow(array("","","","", "", "", ""));

                    $sheet->appendRow(array('ТЭЭВРИЙН ХЭРЭГСЛИЙН ЛАВЛАГАА ЭЗЭМШИГЧЭЭР'));
                    $sheet->getStyle('A4:G4')->getFont()->setBold(true);
                    $sheet->getStyle('A4:G4')->getFont()->setSize(12);
                    $sheet->mergeCells('A4:G4');
                    $sheet->cell('A4', function ($cell) {
                        $this->center($cell);
                    });
                    $sheet->appendRow(array("","","","", "", "", ""));
                    $owner = Owner::where("register_no", $register)->get()->first();
                    $datas = DB::select(DB::raw("SELECT * FROM REG_VEHICLE_VIEW WHERE  owner1_id LIKE '".$owner->id."%' AND  STATUS != 9 AND STATUS != 10  ORDER BY PLATE_NO"
                    ));
                    $init = array();
                    $i = 1;
                    foreach ($datas as $data){
                        if($data->plate_no != ""){
                            array_push($init, array(
                                $i,
                                $data->plate_no,
                                $data->mark_name,
                                $data->model_name,
                                $data->cabin_no,
                                $data->certificate_no,
                                $data->color_name
                            ));
                            if($i == 1){
                                if($register == "none"){
                                    $register = $data->register_no;
                                }
                                if($lastName == "none"){
                                    $lastName = $data->last_name;
                                }
                                if($firstName == "none"){
                                    $firstName = $data->first_name;
                                }
                            }
                            $i++;
                        }
                    }

                    $sheet->appendRow(array(
                        "성: ".$lastName, "", "이름: ".$firstName, "", "", "Регистр: ".$register, "", ""
                    ));
                    $sheet->mergeCells('A6:B6');
                    $sheet->mergeCells('C6:D6');
                    $sheet->mergeCells('F6:G6');
                    $sheet->getStyle('A6:G6')->getFont()->setBold(true);
                    $sheet->cell('F6', function ($cell) {
                        $this->cellRight($cell);
                    });
                    $sheet->cell('C6', function ($cell) {
                        $this->cellRight($cell);
                    });
                    $sheet->appendRow(array(
                        "№",
                        "번호판",
                        "브랜드",
                        "모델",
                        "차체번호",
                        "증명서 번호",
                        "색상"
                    ));

                    $sheet->getStyle('A7:G7')->getFont()->setBold(true);
                    $sheet->getStyle('A7:G7')->getFont()->setSize(12);

                    $sheet->rows($init);
                    //$sheet->setColumnFormat(array('0', '@', '@', '@', '@', '@', '@'));
                    //$sheet->getStyle('A'.($i+7).':G'.($i+7))->getFont()->setBold(true);
                    for($j = 7; $j < $i + 7; $j++){
                        $sheet->cell('A'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('B'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('C'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('D'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('E'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('F'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('G'.($j), function ($cell) {
                            $this->center($cell);
                        });
                    }
                    $sheet->getStyle('A7:G'.($i + 6))->applyFromArray([
                        'borders' => array(
                            'allborders' => array(
                                'style' => \PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    ]);

                    $sheet->appendRow(array(
                        "","","","","",""
                    ));
                    $sheet->appendRow(array(
                        "","","","","",""
                    ));

                    $sheet->appendRow(array(
                        "","","","검토: . . . . . . . . . . . /____________________/"
                    ));

                    $sheet->appendRow(array(
                        "","","","","",""
                    ));

                    $sheet->appendRow(array(
                        "","","","보고서 작성: . . . . . . . . . . . /____________________/"
                    ));

                    $this->setPrintMargins($sheet, 0.5, 1, 0.5, 1);
                    $sheet->setFitToPage(true);
                    $sheet->setScale(80);
                });
            })->download('xls');
        }
    }
    protected function exportToExcelVehicleRef(Request $request){
        $register = $request->route("register");
        $lastName = $request->route("last");
        $firstName = $request->route("first");
        if($register != "none" || $lastName != "none" || $firstName != "none"){
            $where = array();
            if($register != "none"){
                array_push($where, "REGISTER_NO LIKE '".$register."%'");
            }
            if($lastName != "none"){
                array_push($where, "last_name='".$lastName."'");
            }
            if($firstName != "none"){
                array_push($where, "first_name='".$firstName."'");
            }
            $filter = "WHERE ";
            $filter .= implode(" AND ",$where);
            if($filter == "WHERE "){
                $filter .= "END_DATE IS NULL";
            } else {
                $filter .= " AND END_DATE IS NULL AND STATUS != 9 AND STATUS != 10 ";
            }
            Excel::create("차량 -ийн лавлагаа", function($excel) use($filter, $register, $lastName, $firstName) {
                $excel->setTitle("Тээврийн хэрэгслийн лавлагаа /Өмчлөгчөөр/");
                $excel->setCreator("ATUT");
                $excel->sheet("보고서", function($sheet) use($filter, $register, $lastName, $firstName) {
                    //Header үүсгэх
                    $sheet->setWidth(array(
                        'A'     =>  5,
                        'B'     =>  15,
                        'C'     =>  15,
                        'D'     =>  15,
                        'E'     =>  22,
                        'F'     =>  22,
                        'G'     =>  15
                    ));
                    $sheet->setOrientation('landscape');
                    //로고 입력
                    if (session()->get('auth')->iscity == 1) {
                        $objDrawing = new \PHPExcel_Worksheet_Drawing;
                        $objDrawing->setPath(public_path('/img/niislel.jpg')); //your image path
                        $objDrawing->setCoordinates('B1');
                        $objDrawing->setWidthAndHeight(55, 55);
                        $objDrawing->setWorksheet($sheet);
                        $sheet->setOrientation('landscape');
                        $sheet->appendRow(array("", "", "", "","",  "수도 자동차운송 차량", ""));
                        $sheet->appendRow(array("", "", "", "","",  "등록·관리 센터 ",  ""));
                        $sheet->mergeCells('F1:G1');
                        $sheet->mergeCells('F2:G2');
                } else {
                    $objDrawing = new \PHPExcel_Worksheet_Drawing;
                    $objDrawing->setPath(public_path('/img/logo.png')); //your image path
                    $objDrawing->setCoordinates('A1');
                    $objDrawing->setWidthAndHeight(55, 55);
                    $objDrawing->setWorksheet($sheet);
                    $sheet->appendRow(array("", "", "", "", "", "자동차운송", ""));
                    $sheet->appendRow(array("", "", "", "", "", "국가센터", ""));
                    $sheet->mergeCells('F1:G1');
                    $sheet->mergeCells('F2:G2');
                }
                    $sheet->cell('F1', function ($cell) {
                        $this->cellRight($cell);
                    });
                    $sheet->cell('F2', function ($cell) {
                        $this->cellRight($cell);
                    });
                    $sheet->getStyle('F1')->getFont()->setBold(true);
                    $sheet->getStyle('F2')->getFont()->setBold(true);
                    $sheet->setPaperSize(\PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
                    $sheet->appendRow(array("","","","", "", "", ""));

                    $sheet->appendRow(array('ТЭЭВРИЙН ХЭРЭГСЛИЙН ЛАВЛАГАА ӨМЧЛӨГЧӨӨР'));
                    $sheet->getStyle('A4:G4')->getFont()->setBold(true);
                    $sheet->getStyle('A4:G4')->getFont()->setSize(12);
                    $sheet->mergeCells('A4:G4');
                    $sheet->cell('A4', function ($cell) {
                        $this->center($cell);
                    });
                    $sheet->appendRow(array("","","","", "", "", ""));
                    $datas = DB::select(DB::raw(
                     
                        "SELECT * FROM VEHICLE_OWNER_REF ".$filter." ORDER BY PLATE_NO"
                    ));
                    $init = array();
                    $i = 1;
                    foreach ($datas as $data){
                        if($data->plate_no != ""){
                            array_push($init, array(
                                $i,
                                $data->plate_no,
                                $data->mark_name,
                                $data->model_name,
                                $data->cabin_no,
                                $data->certificate_no,
                                $data->color_name
                            ));
                            if($i == 1){
                                if($register == "none"){
                                    $register = $data->register_no;
                                }
                                if($lastName == "none"){
                                    $lastName = $data->last_name;
                                }
                                if($firstName == "none"){
                                    $firstName = $data->first_name;
                                }
                            }
                            $i++;
                        }
                    }

                    $sheet->appendRow(array(
                        "성: ".$lastName, "", "이름: ".$firstName, "", "", "Регистр: ".$register, "", ""
                    ));
                    $sheet->mergeCells('A6:B6');
                    $sheet->mergeCells('C6:D6');
                    $sheet->mergeCells('F6:G6');
                    $sheet->getStyle('A6:G6')->getFont()->setBold(true);
                    $sheet->cell('F6', function ($cell) {
                        $this->cellRight($cell);
                    });
                    $sheet->cell('C6', function ($cell) {
                        $this->cellRight($cell);
                    });
                    $sheet->appendRow(array(
                        "№",
                        "번호판",
                        "브랜드",
                        "모델",
                        "차체번호",
                        "증명서 번호",
                        "색상"
                    ));

                    $sheet->getStyle('A7:G7')->getFont()->setBold(true);
                    $sheet->getStyle('A7:G7')->getFont()->setSize(12);

                    $sheet->rows($init);
                    //$sheet->setColumnFormat(array('0', '@', '@', '@', '@', '@', '@'));
                    //$sheet->getStyle('A'.($i+7).':G'.($i+7))->getFont()->setBold(true);
                    for($j = 7; $j < $i + 7; $j++){
                        $sheet->cell('A'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('B'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('C'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('D'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('E'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('F'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('G'.($j), function ($cell) {
                            $this->center($cell);
                        });
                    }
                    $sheet->getStyle('A7:G'.($i + 6))->applyFromArray([
                        'borders' => array(
                            'allborders' => array(
                                'style' => \PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    ]);

                    $sheet->appendRow(array(
                        "","","","","",""
                    ));
                    $sheet->appendRow(array(
                        "","","","","",""
                    ));

                    $sheet->appendRow(array(
                        "","","","검토: . . . . . . . . . . . /____________________/"
                    ));

                    $sheet->appendRow(array(
                        "","","","","",""
                    ));

                    $sheet->appendRow(array(
                        "","","","보고서 작성: . . . . . . . . . . . /____________________/"
                    ));

                    $this->setPrintMargins($sheet, 0.5, 1, 0.5, 1);
                    $sheet->setFitToPage(true);
                    $sheet->setScale(80);
                });
            })->download('xls');
        }
    }

    public function indexDailyVehicleRefOld(Request $request){
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        if(!$this->checkAccess("/report/daily/vehiclerefold", $this->enc(session()->get("auth")->userpositionid))){
            return redirect(route($this->redirectAccess));
        }
        $orgs = RefReferenceOrg::orderBy("Name")->get();
        try{
            if($request->isMethod("POST")){
                $lastName = $request->get("lastName");
                $firstName = $request->get("firstName");
                $register = $request->get("register");
              //  return $register;
                $where = array();
                if(strlen($register) > 0){
                    array_push($where, "REGISTER_NO LIKE '".$register."%'");
                }
                if(strlen($lastName) > 0){
                    array_push($where, "LAST_NAME='".$lastName."'");
                }
                if(strlen($firstName) > 0){
                    array_push($where, "FIRST_NAME='".$firstName."'");
                }
               
                $filter = "WHERE ";
                $filter .= implode(" AND ",$where);
                
                if($filter == "WHERE "){
                    $filter .= " (END_DATE IS NOT NULL OR STATUS IN(9,10,11))";
                   
                } else {
                   // $filter .= " AND END_DATE IS NOT NULL AND STATUS != 9 AND STATUS != 10";
                    $filter .= " AND (END_DATE IS NOT NULL OR STATUS IN(9,10,11))";
                    
                  
                }
 //return $filter;
                if(strlen($lastName) > 0 || strlen($firstName) > 0 || strlen($register) > 0){
                    $results = DB::select(DB::raw(
                        "SELECT * FROM VEHICLE_OWNER_REF ".$filter
                    ));
                   // return($results);
                    if(sizeof($results) > 0){
                        $lastName = $results[0]->last_name;
                        $firstName = $results[0]->first_name;
                        $register = $results[0]->register_no;
                        // if (strlen(register) > 10) {
                            
                        //     $register = Str::substr($results[0]->register_no, 7);
                        // }else{
                        //     $register = $results[0]->register_no;
                        // }
                        return view('Reports.vehiclereferenceold', compact('results', 'register', 'lastName', 'firstName', 'orgs'));
                    } else {
                        return view('Reports.vehiclereferenceold', compact('orgs'));
                    }
                } else {
                    return view('Reports.vehiclereferenceold', compact('orgs'));
                }
            } else {
                return view('Reports.vehiclereferenceold', compact('orgs'));
            }
        } catch (\Exception $ex){
            $this->writeLog("Owner old vehicle ref error: ".$ex->getMessage());
            return view('Reports.vehiclereferenceold', compact('orgs'));
        }
    }

    protected function exportToExcelVehicleRefOld(Request $request){
        $register = $request->route("register");
        $lastName = $request->route("last");
        $firstName = $request->route("first");
      
//return $register;
        if($register != "none" || $lastName != "none" || $firstName != "none"){
            $where = array();
            if($register != "none"){
                array_push($where, "REGISTER_NO LIKE '".$register."%'");
            }

            $filter = "WHERE ";
            $filter .= implode(" AND ",$where);
            if($filter == "WHERE "){
                $filter .= " (END_DATE IS NOT NULL OR STATUS IN(9,10,11))";
               
            } else {
               // $filter .= " AND END_DATE IS NOT NULL AND STATUS != 9 AND STATUS != 10";
                $filter .= " AND (END_DATE IS NOT NULL OR STATUS IN(9,10,11))";
                
              
            }
            Excel::create("차량 -ийн лавлагаа", function($excel) use($filter, $register, $lastName, $firstName) {
                $excel->setTitle("Тээврийн хэрэгслийн лавлагаа өмнөх өмчлөгчөөр");
                $excel->setCreator("ATUT");
                $excel->sheet("보고서", function($sheet) use($filter, $register, $lastName, $firstName) {
                    //Header үүсгэх
                    $sheet->setWidth(array(
                        'A'     =>  5,
                        'B'     =>  15,
                        'C'     =>  15,
                        'D'     =>  18,
                        'E'     =>  25,
                        'F'     =>  25,
                        'G'     =>  18,
                        'H'     =>  18,
                        'I'     =>  18
                    ));
                    $sheet->setOrientation('landscape');
                    //로고 입력
                    if (session()->get('auth')->iscity == 1) {
                        $objDrawing = new \PHPExcel_Worksheet_Drawing;
                        $objDrawing->setPath(public_path('/img/niislel.jpg')); //your image path
                        $objDrawing->setCoordinates('B1');
                        $objDrawing->setWidthAndHeight(55, 55);
                        $objDrawing->setWorksheet($sheet);
                        $sheet->setOrientation('landscape');
                        $sheet->appendRow(array("", "", "", "", "", "", "", "수도 자동차운송 차량", ""));
                        $sheet->appendRow(array("", "", "", "", "", "", "", "등록·관리 센터 ",  ""));
                        $sheet->mergeCells('H1:I1');
                        $sheet->mergeCells('H2:I2');
                } else {
                    $objDrawing = new \PHPExcel_Worksheet_Drawing;
                    $objDrawing->setPath(public_path('/img/logo.png')); //your image path
                    $objDrawing->setCoordinates('A1');
                    $objDrawing->setWidthAndHeight(55, 55);
                    $objDrawing->setWorksheet($sheet);
                    $sheet->appendRow(array("", "", "", "", "", "", "", "자동차운송", ""));
                    $sheet->appendRow(array("", "", "", "", "", "", "", "국가센터", ""));
                    $sheet->mergeCells('H1:I1');
                    $sheet->mergeCells('H2:I2');
                }
                    $sheet->cell('H1', function ($cell) {
                        $this->cellRight($cell);
                    });
                    $sheet->cell('H2', function ($cell) {
                        $this->cellRight($cell);
                    });
                    $sheet->getStyle('H1')->getFont()->setBold(true);
                    $sheet->getStyle('H2')->getFont()->setBold(true);
                    $sheet->setPaperSize(\PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
                    $sheet->appendRow(array("","","","", "", "", ""));

                    $sheet->appendRow(array('ТЭЭВРИЙН ХЭРЭГСЛИЙН ЛАВЛАГАА ӨМНӨХ ӨМЧЛӨГЧӨӨР'));
                    $sheet->getStyle('A4:I4')->getFont()->setBold(true);
                    $sheet->getStyle('A4:I4')->getFont()->setSize(12);
                    $sheet->mergeCells('A4:I4');
                    $sheet->cell('A4', function ($cell) {
                        $this->center($cell);
                    });
                    $sheet->appendRow(array("","","","", "", "", ""));
                    $datas = DB::select(DB::raw(
                        "SELECT * FROM VEHICLE_OWNER_REF ".$filter
                    ));
                    $init = array();
                    $i = 1;
                    foreach ($datas as $data){
                        if($data->plate_no != ""){
                            array_push($init, array(
                                $i,
                                $data->plate_no,
                                $data->mark_name,
                                $data->model_name,
                                $data->cabin_no,
                                $data->certificate_no,
                                $data->color_name,
                                $data->start_date,
                                $data->end_date
                            ));
                            if($i == 1){
                                if($register == "none"){
                                    $register = $data->register_no;
                                }
                                if($lastName == "none"){
                                    $lastName = $data->last_name;
                                }
                                if($firstName == "none"){
                                    $firstName = $data->first_name;
                                }
                            }
                            $i++;
                        }
                    }

                    $sheet->appendRow(array(
                        "성: ".$lastName, "", "", "이름: ".$firstName, "", "", "", "Регистр: ".$register, "", ""
                    ));
                    $sheet->mergeCells('A6:C6');
                    $sheet->mergeCells('D6:F6');
                    $sheet->mergeCells('H6:I6');
                    $sheet->getStyle('A6:I6')->getFont()->setBold(true);
                    $sheet->cell('H6', function ($cell) {
                        $this->cellRight($cell);
                    });
                    $sheet->cell('D6', function ($cell) {
                        $this->cellRight($cell);
                    });
                    $sheet->appendRow(array(
                        "№",
                        "번호판",
                        "브랜드",
                        "모델",
                        "차체번호",
                        "증명서 번호",
                        "색상",
                        "시작됨",
                        "Дууссан"
                    ));

                    $sheet->getStyle('A7:I7')->getFont()->setBold(true);
                    $sheet->getStyle('A7:I7')->getFont()->setSize(12);

                    $sheet->rows($init);
                    for($j = 7; $j < $i + 7; $j++){
                        $sheet->cell('A'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('B'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('C'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('D'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('E'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('F'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('G'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('H'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('I'.($j), function ($cell) {
                            $this->center($cell);
                        });
                    }
                    $sheet->getStyle('A7:I'.($i + 6))->applyFromArray([
                        'borders' => array(
                            'allborders' => array(
                                'style' => \PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    ]);

                    $sheet->appendRow(array(
                        "","","","","",""
                    ));
                    $sheet->appendRow(array(
                        "","","","","",""
                    ));

                    $sheet->appendRow(array(
                        "","","","검토: . . . . . . . . . . . /____________________/"
                    ));

                    $sheet->appendRow(array(
                        "","","","","",""
                    ));

                    $sheet->appendRow(array(
                        "","","","보고서 작성: . . . . . . . . . . . /____________________/"
                    ));

                    $this->setPrintMargins($sheet, 0.5, 1, 0.5, 1);
                    $sheet->setFitToPage(true);
                    $sheet->setScale(80);
                });
            })->download('xls');
        }
    }

    public function indexAllUser(Request $request){
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        if(!$this->checkAccess("/report/all/users", $this->enc(session()->get("auth")->userpositionid))){
            return redirect(route($this->redirectAccess));
        }
    
   
            $positions = MainUserPosition::whereNull("deleted_at")->orderBy("NAME")->get();
        
        //return $positions;
       
        if($request->isMethod("POST")){
            $op = $request->get("operation");
            $curr_pos = $request->get("position");
            $startDate = $request->get("start");
            $endDate = $request->get("end");
            $oper = $op == "1" ? "='583'" : "!='1'";
            //return $request;
            $results = DB::select(DB::raw("SELECT t1.NAME, t1.LASTNAME, t1.ARCHIVE_DATE, t2.NEW_V, t1.MOVE_V, t1.CHANGE_PLATE_MOVE_V, t1.CHANGE_CERT_V, 
            t1.AGAIN_CERT_V, t1.LIMITED_V, t1.REMOVE_V, t1.CHANGE_PLATE_V, t1.CHANGE_TWO_V, 
            t1.EDIT_V, t1.PRINT_V, t1.DELETE_PLATE, t1.RESTORE_PLATE FROM (SELECT US.FIRSTNAME NAME, US.LASTNAME LASTNAME, to_char(ar.CREATED_DATE, 'YYYY-MM-DD') ARCHIVE_DATE, 
            COUNT (CASE WHEN ar.INSERT_SERVICE_ID =3 THEN 1 END) MOVE_V, 
            COUNT (CASE WHEN ar.INSERT_SERVICE_ID =14 THEN 1 END) CHANGE_PLATE_MOVE_V, 
            COUNT (CASE WHEN ar.INSERT_SERVICE_ID =13 THEN 1 END) CHANGE_CERT_V, 
            COUNT (CASE WHEN ar.INSERT_SERVICE_ID =2 THEN 1 END) AGAIN_CERT_V, 
            COUNT (CASE WHEN ar.INSERT_SERVICE_ID =12 THEN 1 END) LIMITED_V, 
            COUNT (CASE WHEN ar.INSERT_SERVICE_ID =9 THEN 1 END) REMOVE_V, 
            COUNT (CASE WHEN ar.INSERT_SERVICE_ID =15 THEN 1 END) CHANGE_PLATE_V, 
            COUNT (CASE WHEN ar.INSERT_SERVICE_ID =16 THEN 1 END) CHANGE_TWO_V,  
            COUNT (CASE WHEN ar.INSERT_SERVICE_ID =8 THEN 1 END) EDIT_V, 
            COUNT (CASE WHEN ar.INSERT_SERVICE_ID =5  THEN 1  END) DELETE_PLATE,
            COUNT (CASE WHEN ar.INSERT_SERVICE_ID =19  THEN 1  END) RESTORE_PLATE,
            COUNT (CASE WHEN ar.INSERT_SERVICE_ID =6 THEN 1 END) PRINT_V FROM VRS.REG_VEHICLE_ARCHIVE ar 
            JOIN VRS.SYSTEM_USER US ON ar.UPDATED_BY=US.ID WHERE US.USERDEPARTMENTID".$oper." 
            AND US.USERPOSITIONID='".$curr_pos."' AND ar.CREATED_DATE BETWEEN '".$startDate."'
             AND '".$endDate." 23:59:59' GROUP BY US.FIRSTNAME, US.LASTNAME, to_char(ar.CREATED_DATE, 'YYYY-MM-DD')) t1 
             INNER JOIN 
             (SELECT US.FIRSTNAME NAME, to_char(UPDATED_DATE, 'YYYY-MM-DD') ARCHIVE_DATE, COUNT (CASE WHEN ar.STATUS =1 THEN 1 END) NEW_V FROM 
             VRS.REG_VEHICLE_ARCHIVE ar JOIN VRS.SYSTEM_USER US ON ar.CREATED_BY=US.ID WHERE 
             US.USERDEPARTMENTID".$oper." AND US.USERPOSITIONID= '".$curr_pos."' AND 
             UPDATED_DATE BETWEEN '".$startDate."' AND '".$endDate." 23:59:59' GROUP BY US.FIRSTNAME, to_char(UPDATED_DATE, 'YYYY-MM-DD')) t2 ON t1.NAME=t2.NAME AND t1.ARCHIVE_DATE=t2.ARCHIVE_DATE ORDER BY t1.NAME, t1.ARCHIVE_DATE"));
            return view('Reports.dailyallusers', compact('positions', 'results', 'op', 'curr_pos', 'startDate', 'endDate'));
        } else {
            return view('Reports.dailyallusers', compact('positions'));
        }
    }
public function indexEpayUser(Request $request){
    if(!session()->has("auth")){
        return redirect(route($this->redirectURL));
    }
    if(!$this->checkAccess("/report/ePay/users", $this->enc(session()->get("auth")->userpositionid))){
        return redirect(route($this->redirectAccess));
    }
   // $positions = MainUserPosition::whereNull("deleted_at")->orderBy("NAME")->get();
   // $users = DB::select(DB::raw("SELECT * FROM system_user WHERE isactive =1 and deleted_at is null"));
   if (session()->get("auth")->iscity == 1 && session()->get("auth")->isatvt == 0) {
    $users = DB::table("MAIN_USER_VIEW")->whereNull("deleted_at")->where("PROVINCEID", $userPkId = session()->get("auth")->provinceid)->where('IsCity',1)->orderBy("FIRSTNAME")->get();
} else {
    $users = DB::table("MAIN_USER_VIEW")->whereNull("deleted_at")->where("PROVINCEID", $userPkId = session()->get("auth")->provinceid)->where("IsAtvt", 1)->orderBy("FIRSTNAME")->get();
}
 // $users=MainUser::whereNull("deleted_at")-> where('isactive',1)->where('userpositionid','!=',528)->where('isatvt',1)->orderBy("FIRSTNAME")->get();
    if($request->isMethod("POST")){
       // return $request;
        $op = $request->get("operation");
       // $curr_pos = $request->get("position");
        $userId = $request->get("user");
        $startDate = $request->get("start");
        $endDate = $request->get("end");
       // $oper = $op == "1" ? "='1'" : "!='1'";
     
//return $curr_pos;
        
        $results = DB::select(DB::raw("SELECT  etr.created_by,usr.lastname,usr.firstname, service.name as servicename,service.id as serviceid,
        count(service.id) as servicecount,etr.pay_type_name,sum(etr.amount) as amount, to_char(etr.created_at, 'YYYY-MM-DD') as created_at
                FROM epay_transaction  etr
                JOIN system_service service on etr.service_id=service.id
                JOIN system_user usr on etr.created_by= usr.id WHERE 
                pay_type=".$op." AND
                etr.created_at BETWEEN TO_DATE ('".$startDate."', 'yyyy-mm-dd') AND TO_DATE ('".$endDate."', 'yyyy-mm-dd') AND created_by='".$userId."'
                GROUP BY etr.created_by,service.id, service.name,usr.lastname,usr.firstname,to_char(etr.created_at, 'YYYY-MM-DD'),etr.pay_type_name ORDER BY created_at desc"));
//$ttt= json_encode($results, true);
       return view('Reports.ePayReport', compact('users', 'results', 'op','userId', 'startDate', 'endDate'));
     // return $results;
       // dd($results);
       
    }else{
       
        return view('Reports.ePayReport', compact('users'));
    }
   

}
protected function exportToExcelEpayReportr(Request $request){
   // return  $request;
    $op = $request->route("op");
   
    $userId = $request->route("userId");
    $startDate = $request->route("start");
    $endDate = $request->route("end");
  
  //return $userId;
// $curr_pos= $curr_pos !="none" ? $curr_pos : '""';
//return $curr_pos;
    if( $startDate != "none" && $endDate != "none"){
       // return "fggdfgf";
        Excel::create("전문가별 요금 통계 보고서", function($excel) use($op, $userId,  $startDate, $endDate) {
            $excel->setTitle("전문가별 요금 통계 보고서");
            $excel->setCreator("ATUT");
            $excel->sheet("보고서", function($sheet) use($op, $userId, $startDate, $endDate) {
                //Header үүсгэх
                $sheet->setWidth(array(
                    'A'     =>  5,
                    'B'     =>  18,
                    'C'     =>  12,
                    'D'     =>  10,
                    'E'     =>  10,
                    'F'     =>  12,
                    'G'     =>  11,
                    'H'     =>  11,
                    'I'     =>  12,
                    'J'     =>  10,
                    'K'     =>  12,
                    'L'     =>  10,
                   
                ));

                //로고 입력
                if (session()->get('auth')->iscity == 1) {
                    $objDrawing = new \PHPExcel_Worksheet_Drawing;
                    $objDrawing->setPath(public_path('/img/niislel.jpg')); //your image path
                    $objDrawing->setCoordinates('B1');
                    $objDrawing->setWidthAndHeight(55, 55);
                    $objDrawing->setWorksheet($sheet);
                    $sheet->setOrientation('landscape');
                    $sheet->appendRow(array("", "", "", "", "", "", "", "", "", "",  "수도 자동차운송 차량"));
                    $sheet->appendRow(array("", "", "", "", "", "", "", "", "", "",  "등록·관리 센터 "));
                    $sheet->mergeCells('K1:L1');
                    $sheet->mergeCells('K2:L2');
            } else {
                $objDrawing = new \PHPExcel_Worksheet_Drawing;
                $objDrawing->setPath(public_path('/img/logo.png')); //your image path
                $objDrawing->setCoordinates('B1');
                $objDrawing->setWidthAndHeight(55, 55);
                $objDrawing->setWorksheet($sheet);
                $sheet->setOrientation('landscape');
                $sheet->appendRow(array("", "", "", "", "", "", "", "", "", "",   "자동차운송"));
                $sheet->appendRow(array("", "", "", "", "", "", "", "", "", "",  "국가센터", ));
                $sheet->mergeCells('K1:L1');
                $sheet->mergeCells('K2:L2');
            }
                $sheet->cell('K1', function ($cell) {
                    $this->cellRight($cell);
                });
                $sheet->cell('K2', function ($cell) {
                    $this->cellRight($cell);
                });
                $sheet->getStyle('K1')->getFont()->setBold(true);
                $sheet->getStyle('K2')->getFont()->setBold(true);
                $sheet->setPaperSize(\PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
                $sheet->appendRow(array("","","","", "", "", ""));

                $sheet->appendRow(array('전체 담당자 보고서'));
                $sheet->getStyle('A4:L4')->getFont()->setBold(true);
                $sheet->getStyle('A4:L4')->getFont()->setSize(12);
                $sheet->mergeCells('A4:L4');
                $sheet->cell('L4', function ($cell) {
                    $this->center($cell);
                });
             
              //  $names = MainUserPosition::where("ID", $curr_pos)->get()->first();
                $epay = EpayTransaction::where("pay_type", $op)->get()->first();
               // $oper = $op == "2" ? "지방" : "울란바토르";
             // return $names;
                $sheet->appendRow(array(
                    "결제 유형:".$epay->pay_type_name,
                   "",
                   "",
                  
                    "",
                    "",
                    "",
                    "",
                    "",
                
                    "일자: ".$startDate." - ".$endDate
                 
                    
                ));

                $sheet->mergeCells('A5:C5');
                $sheet->mergeCells('D5:I5');
                $sheet->mergeCells('J5:L5');

                $sheet->getStyle('A5:D5')->getFont()->setBold(true);
                $sheet->getStyle('D5:I5')->getFont()->setBold(true);
                $sheet->getStyle('J5:L5')->getFont()->setBold(true);

                $sheet->cell('A5', function ($cell) {
                    $this->cellLeft($cell);
                });

                $sheet->appendRow(array(
                    "№",
                    "담당자",
                    "일자",
                    "신규",
                    "이전",
                    "번호판 교체 이전",
                    "증명서 교체",
                    "증명서 갱신",
                    "말소",
                    "번호판 교체",
                    "번호판 간 교체",
                    "결제",
               
                ));

                $this->setPrintMargins($sheet, 0.5, 0.1, 0.5, 0.1);
                //$this->setPrintFitToWidth($sheet);
                $this->parseCssProperties($sheet, "F", "6", "wrap-text", "true");
                $this->parseCssProperties($sheet, "G", "6", "wrap-text", "true");
                $this->parseCssProperties($sheet, "H", "6", "wrap-text", "true");
                $this->parseCssProperties($sheet, "L", "6", "wrap-text", "true");
                // $this->parseCssProperties($sheet, "O", "6", "wrap-text", "true");
                // $this->parseCssProperties($sheet, "P", "6", "wrap-text", "true");

                $sheet->getStyle('A6:L6')->getFont()->setBold(true);
                $sheet->getStyle('A6:L6')->getFont()->setSize(12);
               // $operation = $op == "1" ? "='1'" : "!='1'";
               
                $datas = DB::select(DB::raw("SELECT  etr.created_by,usr.lastname,usr.firstname, service.name as servicename,service.id as serviceid,
                count(service.id) as servicecount,etr.pay_type_name,sum(etr.amount) as amount, to_char(etr.created_at, 'YYYY-MM-DD') as created_at
                        FROM epay_transaction  etr
                        JOIN system_service service on etr.service_id=service.id
                        JOIN system_user usr on etr.created_by= usr.id WHERE 
                        pay_type=".$op." AND
                        etr.created_at BETWEEN TO_DATE ('".$startDate."', 'yyyy-mm-dd') AND TO_DATE ('".$endDate."', 'yyyy-mm-dd') AND created_by=".$userId."
                        GROUP BY etr.created_by,service.id,service.name,usr.lastname,usr.firstname,to_char(etr.created_at, 'YYYY-MM-DD'),etr.pay_type_name ORDER BY created_at desc"));
  
                $init = array();
                $all_names = array();
                $i = 1; 
                foreach ($datas as $data){
                   // if($data->archive_date != ""){
                        array_push($all_names, $data->lastname. ' ' .$data->firstname);
                        array_push($init, array(
                            $i,
                            $data->lastname. ' ' .$data->firstname,
                            $data->created_at,
                            $data->serviceid == 1 ? $data->servicecount : 0, 
                            $data->serviceid == 3 ? $data->servicecount : 0, 
                            $data->serviceid == 14 ? $data->servicecount : 0,
                            $data->serviceid == 13 ? $data->servicecount : 0,
                            $data->serviceid == 2 ?  $data->servicecount : 0,
                            $data->serviceid == 9 ? $data->servicecount : 0, 
                            $data->serviceid == 15 ? $data->servicecount : 0,
                            $data->serviceid == 16 ? $data->servicecount : 0,
                            $data->amount
                          
                        ));
                        $i++;
                   // }
                }

                $all_names = array_unique($all_names);
                $name_count = array();
                for ($i = 0; $i < sizeof($all_names); $i++){
                    array_push($name_count, 0);
                }

                $count_index = 0;
                foreach ($all_names as $name){
                    $count = 0;
                    foreach ($init as $in){
                        if($name == $in[1]){
                            $count++;
                        }
                    }
                    $name_count[$count_index] = $count;
                    $count_index++;
                }
                $new_init = array();
                $tmp = 0;
                $tmp1 = 0;

                for($i = 0; $i < sizeof($name_count); $i++){
                    $sum = array(0,0,0,0,0,0,0,0,0);
                    for($j = $tmp; $j < $name_count[$i] + $tmp1; $j++){
                        $init[$j][0] = ($i+1);
                        $sum[0] += $init[$j][3];
                        $sum[1] += $init[$j][4];
                        $sum[2] += $init[$j][5];
                        $sum[3] += $init[$j][6];
                        $sum[4] += $init[$j][7];
                        $sum[5] += $init[$j][8];
                        $sum[6] += $init[$j][9];
                        $sum[7] += $init[$j][10];
                        $sum[8] += $init[$j][11];

                      
                        array_push($new_init, $init[$j]);
                        $tmp++;
                    }
                    $tmp1 = $tmp;
                    array_push($new_init, array(($i+1),"","합계",$sum[0],$sum[1],$sum[2],$sum[3],$sum[4],$sum[5],$sum[6],$sum[7],$sum[8]));
                    $name_count[$i] += 1;
                }

                $sheet->rows($new_init);
                $count_merge = 7;
                for ($i = 0; $i < sizeof($name_count); $i++) {
                    if ($name_count[$i] > 1) {
                        $sheet->mergeCells('A' . $count_merge . ':A' . ($count_merge + $name_count[$i] - 1));
                        $sheet->mergeCells('B' . $count_merge . ':B' . ($count_merge + $name_count[$i] - 1));
                        $sheet->getStyle('C' . ($count_merge + $name_count[$i] - 1) . ':L' . ($count_merge + $name_count[$i] - 1))->getFont()->setBold(true);

                        $sheet->cell('C' . ($count_merge + $name_count[$i] - 1) . ':L' . ($count_merge + $name_count[$i] - 1), function($row) {
                            $row->setBackground('#CCCCCC');
                        });

                        $sheet->cell('A'.$count_merge, function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('B'.$count_merge, function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('C'.$count_merge.':C'.($count_merge + $name_count[$i] - 1), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('D'.$count_merge.':D'.($count_merge + $name_count[$i] - 1), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('E'.$count_merge.':E'.($count_merge + $name_count[$i] - 1), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('F'.$count_merge.':F'.($count_merge + $name_count[$i] - 1), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('G'.$count_merge.':G'.($count_merge + $name_count[$i] - 1), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('H'.$count_merge.':H'.($count_merge + $name_count[$i] - 1), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('I'.$count_merge.':I'.($count_merge + $name_count[$i] - 1), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('J'.$count_merge.':J'.($count_merge + $name_count[$i] - 1), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('K'.$count_merge.':K'.($count_merge + $name_count[$i] - 1), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('L'.$count_merge.':L'.($count_merge + $name_count[$i] - 1), function ($cell) {
                            $this->center($cell);
                        });
                       
                        $sheet->getStyle('A'.$count_merge.':A'.($count_merge + $name_count[$i] - 1))->applyFromArray([
                            'borders' => array(
                                'allborders' => array(
                                    'style' => \PHPExcel_Style_Border::BORDER_THIN
                                )
                            )
                        ]);
                        $sheet->getStyle('B'.$count_merge.':B'.($count_merge + $name_count[$i] - 1))->applyFromArray([
                            'borders' => array(
                                'allborders' => array(
                                    'style' => \PHPExcel_Style_Border::BORDER_THIN
                                )
                            )
                        ]);
                        $sheet->getStyle('C'.$count_merge.':C'.($count_merge + $name_count[$i] - 1))->applyFromArray([
                            'borders' => array(
                                'allborders' => array(
                                    'style' => \PHPExcel_Style_Border::BORDER_THIN
                                )
                            )
                        ]);
                        $sheet->getStyle('D'.$count_merge.':D'.($count_merge + $name_count[$i] - 1))->applyFromArray([
                            'borders' => array(
                                'allborders' => array(
                                    'style' => \PHPExcel_Style_Border::BORDER_THIN
                                )
                            )
                        ]);
                        $sheet->getStyle('E'.$count_merge.':E'.($count_merge + $name_count[$i] - 1))->applyFromArray([
                            'borders' => array(
                                'allborders' => array(
                                    'style' => \PHPExcel_Style_Border::BORDER_THIN
                                )
                            )
                        ]);
                        $sheet->getStyle('F'.$count_merge.':F'.($count_merge + $name_count[$i] - 1))->applyFromArray([
                            'borders' => array(
                                'allborders' => array(
                                    'style' => \PHPExcel_Style_Border::BORDER_THIN
                                )
                            )
                        ]);
                        $sheet->getStyle('G'.$count_merge.':G'.($count_merge + $name_count[$i] - 1))->applyFromArray([
                            'borders' => array(
                                'allborders' => array(
                                    'style' => \PHPExcel_Style_Border::BORDER_THIN
                                )
                            )
                        ]);
                        $sheet->getStyle('H'.$count_merge.':H'.($count_merge + $name_count[$i] - 1))->applyFromArray([
                            'borders' => array(
                                'allborders' => array(
                                    'style' => \PHPExcel_Style_Border::BORDER_THIN
                                )
                            )
                        ]);
                        $sheet->getStyle('I'.$count_merge.':I'.($count_merge + $name_count[$i] - 1))->applyFromArray([
                            'borders' => array(
                                'allborders' => array(
                                    'style' => \PHPExcel_Style_Border::BORDER_THIN
                                )
                            )
                        ]);
                        $sheet->getStyle('J'.$count_merge.':J'.($count_merge + $name_count[$i] - 1))->applyFromArray([
                            'borders' => array(
                                'allborders' => array(
                                    'style' => \PHPExcel_Style_Border::BORDER_THIN
                                )
                            )
                        ]);
                        $sheet->getStyle('K'.$count_merge.':K'.($count_merge + $name_count[$i] - 1))->applyFromArray([
                            'borders' => array(
                                'allborders' => array(
                                    'style' => \PHPExcel_Style_Border::BORDER_THIN
                                )
                            )
                        ]);
                        $sheet->getStyle('L'.$count_merge.':L'.($count_merge + $name_count[$i] - 1))->applyFromArray([
                            'borders' => array(
                                'allborders' => array(
                                    'style' => \PHPExcel_Style_Border::BORDER_THIN
                                )
                            )
                        ]);
                      
                    }
                    $count_merge += $name_count[$i];
                }
                $sheet->cell('A6:L6', function ($cell) {
                    $this->center($cell);
                });
                $sheet->cell('A4:L4', function ($cell) {
                    $this->center($cell);
                });
                $sheet->getStyle('A6:L6')->applyFromArray([
                    'borders' => array(
                        'allborders' => array(
                            'style' => \PHPExcel_Style_Border::BORDER_THIN
                        )
                    )
                ]);
                $sheet->appendRow(array(
                    "","","","","",""
                ));
                $sheet->appendRow(array(
                    "","","","","",""
                ));

                $sheet->appendRow(array(
                    "","","","","","검토: . . . . . . . . . . . /____________________/"
                ));

                $sheet->appendRow(array(
                    "","","","","",""
                ));

                $sheet->appendRow(array(
                    "","","","","","보고서 작성: . . . . . . . . . . . /____________________/"
                ));
                $sheet->setFitToPage(true);
                $sheet->setScale(80);
            });
        })->download('xls');
    }
}
    protected function exportToExcelAllUser(Request $request){
        $op = $request->route("op");
        $curr_pos = $request->route("pos");
        $startDate = $request->route("start");
        $endDate = $request->route("end");
        if($curr_pos != "none" && $startDate != "none" && $endDate != "none"){
            Excel::create("전문가별 통계 보고서", function($excel) use($op, $curr_pos, $startDate, $endDate) {
                $excel->setTitle("전문가별 통계 보고서");
                $excel->setCreator("ATUT");
                $excel->sheet("보고서", function($sheet) use($op, $curr_pos, $startDate, $endDate) {
                    //Header үүсгэх
                    $sheet->setWidth(array(
                        'A'     =>  5,
                        'B'     =>  18,
                        'C'     =>  12,
                        'D'     =>  10,
                        'E'     =>  10,
                        'F'     =>  12,
                        'G'     =>  11,
                        'H'     =>  11,
                        'I'     =>  12,
                        'J'     =>  10,
                        'K'     =>  12,
                        'L'     =>  10,
                        'M'     =>  9,
                        'N'     =>  9,
                        'O'     =>  9,
                        'P'     =>  11
                    ));

                    //로고 입력
                         if (session()->get('auth')->iscity == 1) {
                            $objDrawing = new \PHPExcel_Worksheet_Drawing;
                            $objDrawing->setPath(public_path('/img/niislel.jpg')); //your image path
                            $objDrawing->setCoordinates('B1');
                            $objDrawing->setWidthAndHeight(55, 55);
                            $objDrawing->setWorksheet($sheet);
                            $sheet->setOrientation('landscape');
                            $sheet->appendRow(array("", "", "", "", "", "", "", "", "","","", "",  "수도 자동차운송 차량", ""));
                            $sheet->appendRow(array("", "", "", "", "", "", "", "", "", "","","","", "등록·관리 센터 ",  ""));
                            $sheet->mergeCells('M1:P1');
                            $sheet->mergeCells('N2:O2');
                    } else {
                        $objDrawing = new \PHPExcel_Worksheet_Drawing;
                        $objDrawing->setPath(public_path('/img/logo.png')); //your image path
                        $objDrawing->setCoordinates('B1');
                        $objDrawing->setWidthAndHeight(55, 55);
                        $objDrawing->setWorksheet($sheet);
                        $sheet->setOrientation('landscape');
                        $sheet->appendRow(array("", "", "", "", "", "", "", "", "", "", "", "", "", "자동차운송", "", ""));
                        $sheet->appendRow(array("", "", "", "", "", "", "", "", "", "", "", "", "", "국가센터", "", ""));
                        $sheet->mergeCells('N1:O1');
                        $sheet->mergeCells('N2:O2');
                    }
                   
                    $sheet->cell('N1', function ($cell) {
                        $this->cellRight($cell);
                    });
                    $sheet->cell('N2', function ($cell) {
                        $this->cellRight($cell);
                    });
                    $sheet->getStyle('M1')->getFont()->setBold(true);
                    $sheet->getStyle('N2')->getFont()->setBold(true);
                    $sheet->setPaperSize(\PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
                    $sheet->appendRow(array("","","","", "", "", ""));

                    $sheet->appendRow(array('전체 담당자 보고서'));
                    $sheet->getStyle('A4:P4')->getFont()->setBold(true);
                    $sheet->getStyle('A4:P4')->getFont()->setSize(12);
                    $sheet->mergeCells('A4:P4');
                    $sheet->cell('P4', function ($cell) {
                        $this->center($cell);
                    });

                    $names = MainUserPosition::where("ID", $curr_pos)->get()->first();
                    $oper = $op == "2" ? "지방" : "울란바토르";
                    $sheet->appendRow(array(
                        "기본 소속: ".$oper,
                        "",
                        "",
                        "",
                        "",
                        "",
                        "직위(공무): ".$names->name,
                        "",
                        "",
                        "",
                        "",
                        "",
                        "",
                        "일자: ".$startDate." - ".$endDate,
                        "",
                        ""
                    ));

                    $sheet->mergeCells('A5:D5');
                    $sheet->mergeCells('G5:L5');
                    $sheet->mergeCells('N5:P5');

                    $sheet->getStyle('A5:D5')->getFont()->setBold(true);
                    $sheet->getStyle('G5:L5')->getFont()->setBold(true);
                    $sheet->getStyle('N5:P5')->getFont()->setBold(true);

                    $sheet->cell('A5', function ($cell) {
                        $this->cellRight($cell);
                    });

                    $sheet->appendRow(array(
                        "№",
                        "담당자",
                        "일자",
                        "신규",
                        "이전",
                        "번호판 교체 이전",
                        "증명서 교체",
                        "증명서 갱신",
                        "제한 사항",
                        "말소",
                        "번호판 교체",
                        "번호판 간 교체",
                        "인쇄",
                        "수정",
                        "문자 말소",
                        "말소에서 복구됨"
                    ));

                    $this->setPrintMargins($sheet, 0.5, 0.1, 0.5, 0.1);
                    //$this->setPrintFitToWidth($sheet);
                    $this->parseCssProperties($sheet, "F", "6", "wrap-text", "true");
                    $this->parseCssProperties($sheet, "G", "6", "wrap-text", "true");
                    $this->parseCssProperties($sheet, "H", "6", "wrap-text", "true");
                    $this->parseCssProperties($sheet, "L", "6", "wrap-text", "true");
                    $this->parseCssProperties($sheet, "O", "6", "wrap-text", "true");
                    $this->parseCssProperties($sheet, "P", "6", "wrap-text", "true");

                    $sheet->getStyle('A6:P6')->getFont()->setBold(true);
                    $sheet->getStyle('A6:P6')->getFont()->setSize(12);
                    $operation = $op == "1" ? "='583'" : "!='1'";
                    $datas = DB::select(DB::raw("SELECT t1.NAME, t1.LASTNAME, t1.ARCHIVE_DATE, t2.NEW_V, t1.MOVE_V, t1.CHANGE_PLATE_MOVE_V, t1.CHANGE_CERT_V, 
            t1.AGAIN_CERT_V, t1.LIMITED_V, t1.REMOVE_V, t1.CHANGE_PLATE_V, t1.CHANGE_TWO_V, 
            t1.EDIT_V, t1.PRINT_V, t1.DELETE_PLATE, t1.RESTORE_PLATE FROM (SELECT US.FIRSTNAME NAME, US.LASTNAME LASTNAME, to_char(ar.CREATED_DATE, 'YYYY-MM-DD') ARCHIVE_DATE, 
            COUNT (CASE WHEN ar.INSERT_SERVICE_ID =3 THEN 1 END) MOVE_V, 
            COUNT (CASE WHEN ar.INSERT_SERVICE_ID =14 THEN 1 END) CHANGE_PLATE_MOVE_V, 
            COUNT (CASE WHEN ar.INSERT_SERVICE_ID =13 THEN 1 END) CHANGE_CERT_V, 
            COUNT (CASE WHEN ar.INSERT_SERVICE_ID =2 THEN 1 END) AGAIN_CERT_V, 
            COUNT (CASE WHEN ar.INSERT_SERVICE_ID =12 THEN 1 END) LIMITED_V, 
            COUNT (CASE WHEN ar.INSERT_SERVICE_ID =9 THEN 1 END) REMOVE_V, 
            COUNT (CASE WHEN ar.INSERT_SERVICE_ID =15 THEN 1 END) CHANGE_PLATE_V, 
            COUNT (CASE WHEN ar.INSERT_SERVICE_ID =16 THEN 1 END) CHANGE_TWO_V, 
            COUNT (CASE WHEN ar.INSERT_SERVICE_ID =8 THEN 1 END) EDIT_V, 
            COUNT (CASE WHEN ar.INSERT_SERVICE_ID =5  THEN 1  END) DELETE_PLATE,
            COUNT (CASE WHEN ar.INSERT_SERVICE_ID =19  THEN 1  END) RESTORE_PLATE,
            COUNT (CASE WHEN ar.INSERT_SERVICE_ID =6 THEN 1 END) PRINT_V FROM VRS.REG_VEHICLE_ARCHIVE ar 
            JOIN VRS.SYSTEM_USER US ON ar.UPDATED_BY=US.ID WHERE US.USERDEPARTMENTID".$operation."
            AND US.USERPOSITIONID='".$curr_pos."' AND ar.CREATED_DATE BETWEEN '".$startDate."'
             AND '".$endDate." 23:59:59' GROUP BY US.FIRSTNAME, US.LASTNAME, to_char(ar.CREATED_DATE, 'YYYY-MM-DD')) t1 
             INNER JOIN 
             (SELECT US.FIRSTNAME NAME, to_char(UPDATED_DATE, 'YYYY-MM-DD') ARCHIVE_DATE, COUNT (CASE WHEN ar.STATUS =1 THEN 1 END) NEW_V FROM 
             VRS.REG_VEHICLE_ARCHIVE ar JOIN VRS.SYSTEM_USER US ON ar.CREATED_BY=US.ID WHERE 
             US.USERDEPARTMENTID".$operation." AND US.USERPOSITIONID= '".$curr_pos."' AND 
             UPDATED_DATE BETWEEN '".$startDate."' AND '".$endDate." 23:59:59' GROUP BY US.FIRSTNAME, to_char(UPDATED_DATE, 'YYYY-MM-DD')) t2 ON t1.NAME=t2.NAME AND t1.ARCHIVE_DATE=t2.ARCHIVE_DATE ORDER BY t1.NAME, t1.ARCHIVE_DATE"));

                    $init = array();
                    $all_names = array();
                    $i = 1;
                    foreach ($datas as $data){
                        if($data->archive_date != ""){
                            array_push($all_names, $data->name. ' ' .$data->lastname);
                            array_push($init, array(
                                $i,
                                $data->name. ' ' .$data->lastname,
                                $data->archive_date,
                                $data->new_v,
                                $data->move_v,
                                $data->change_plate_move_v,
                                $data->change_cert_v,
                                $data->again_cert_v,
                                $data->limited_v,
                                $data->remove_v,
                                $data->change_plate_v,
                                $data->change_two_v,
                                $data->print_v,
                                $data->edit_v,
                                $data->delete_plate,
                                $data->restore_plate
                            ));
                            $i++;
                        }
                    }

                    $all_names = array_unique($all_names);
                    $name_count = array();
                    for ($i = 0; $i < sizeof($all_names); $i++){
                        array_push($name_count, 0);
                    }

                    $count_index = 0;
                    foreach ($all_names as $name){
                        $count = 0;
                        foreach ($init as $in){
                            if($name == $in[1]){
                                $count++;
                            }
                        }
                        $name_count[$count_index] = $count;
                        $count_index++;
                    }
                    $new_init = array();
                    $tmp = 0;
                    $tmp1 = 0;

                    for($i = 0; $i < sizeof($name_count); $i++){
                        $sum = array(0,0,0,0,0,0,0,0,0,0,0,0,0);
                        for($j = $tmp; $j < $name_count[$i] + $tmp1; $j++){
                            $init[$j][0] = ($i+1);
                            $sum[0] += $init[$j][3];
                            $sum[1] += $init[$j][4];
                            $sum[2] += $init[$j][5];
                            $sum[3] += $init[$j][6];
                            $sum[4] += $init[$j][7];
                            $sum[5] += $init[$j][8];
                            $sum[6] += $init[$j][9];
                            $sum[7] += $init[$j][10];
                            $sum[8] += $init[$j][11];
                            $sum[9] += $init[$j][12];
                            $sum[10] += $init[$j][13];
                            $sum[11] += $init[$j][14];
                            $sum[12] += $init[$j][15];
                            array_push($new_init, $init[$j]);
                            $tmp++;
                        }
                        $tmp1 = $tmp;
                        array_push($new_init, array(($i+1),"","합계",$sum[0],$sum[1],$sum[2],$sum[3],$sum[4],$sum[5],$sum[6],$sum[7],$sum[8],$sum[9],$sum[10],$sum[11],$sum[12]));
                        $name_count[$i] += 1;
                    }

                    $sheet->rows($new_init);
                    $count_merge = 7;
                    for ($i = 0; $i < sizeof($name_count); $i++) {
                        if ($name_count[$i] > 1) {
                            $sheet->mergeCells('A' . $count_merge . ':A' . ($count_merge + $name_count[$i] - 1));
                            $sheet->mergeCells('B' . $count_merge . ':B' . ($count_merge + $name_count[$i] - 1));
                            $sheet->getStyle('C' . ($count_merge + $name_count[$i] - 1) . ':P' . ($count_merge + $name_count[$i] - 1))->getFont()->setBold(true);

                            $sheet->cell('C' . ($count_merge + $name_count[$i] - 1) . ':P' . ($count_merge + $name_count[$i] - 1), function($row) {
                                $row->setBackground('#CCCCCC');
                            });

                            $sheet->cell('A'.$count_merge, function ($cell) {
                                $this->center($cell);
                            });
                            $sheet->cell('B'.$count_merge, function ($cell) {
                                $this->center($cell);
                            });
                            $sheet->cell('C'.$count_merge.':C'.($count_merge + $name_count[$i] - 1), function ($cell) {
                                $this->center($cell);
                            });
                            $sheet->cell('D'.$count_merge.':D'.($count_merge + $name_count[$i] - 1), function ($cell) {
                                $this->center($cell);
                            });
                            $sheet->cell('E'.$count_merge.':E'.($count_merge + $name_count[$i] - 1), function ($cell) {
                                $this->center($cell);
                            });
                            $sheet->cell('F'.$count_merge.':F'.($count_merge + $name_count[$i] - 1), function ($cell) {
                                $this->center($cell);
                            });
                            $sheet->cell('G'.$count_merge.':G'.($count_merge + $name_count[$i] - 1), function ($cell) {
                                $this->center($cell);
                            });
                            $sheet->cell('H'.$count_merge.':H'.($count_merge + $name_count[$i] - 1), function ($cell) {
                                $this->center($cell);
                            });
                            $sheet->cell('I'.$count_merge.':I'.($count_merge + $name_count[$i] - 1), function ($cell) {
                                $this->center($cell);
                            });
                            $sheet->cell('J'.$count_merge.':J'.($count_merge + $name_count[$i] - 1), function ($cell) {
                                $this->center($cell);
                            });
                            $sheet->cell('K'.$count_merge.':K'.($count_merge + $name_count[$i] - 1), function ($cell) {
                                $this->center($cell);
                            });
                            $sheet->cell('L'.$count_merge.':L'.($count_merge + $name_count[$i] - 1), function ($cell) {
                                $this->center($cell);
                            });
                            $sheet->cell('M'.$count_merge.':M'.($count_merge + $name_count[$i] - 1), function ($cell) {
                                $this->center($cell);
                            });
                            $sheet->cell('N'.$count_merge.':N'.($count_merge + $name_count[$i] - 1), function ($cell) {
                                $this->center($cell);
                            });
                            $sheet->cell('O'.$count_merge.':O'.($count_merge + $name_count[$i] - 1), function ($cell) {
                                $this->center($cell);
                            });
                            $sheet->cell('P'.$count_merge.':P'.($count_merge + $name_count[$i] - 1), function ($cell) {
                                $this->center($cell);
                            });
                            $sheet->getStyle('A'.$count_merge.':A'.($count_merge + $name_count[$i] - 1))->applyFromArray([
                                'borders' => array(
                                    'allborders' => array(
                                        'style' => \PHPExcel_Style_Border::BORDER_THIN
                                    )
                                )
                            ]);
                            $sheet->getStyle('B'.$count_merge.':B'.($count_merge + $name_count[$i] - 1))->applyFromArray([
                                'borders' => array(
                                    'allborders' => array(
                                        'style' => \PHPExcel_Style_Border::BORDER_THIN
                                    )
                                )
                            ]);
                            $sheet->getStyle('C'.$count_merge.':C'.($count_merge + $name_count[$i] - 1))->applyFromArray([
                                'borders' => array(
                                    'allborders' => array(
                                        'style' => \PHPExcel_Style_Border::BORDER_THIN
                                    )
                                )
                            ]);
                            $sheet->getStyle('D'.$count_merge.':D'.($count_merge + $name_count[$i] - 1))->applyFromArray([
                                'borders' => array(
                                    'allborders' => array(
                                        'style' => \PHPExcel_Style_Border::BORDER_THIN
                                    )
                                )
                            ]);
                            $sheet->getStyle('E'.$count_merge.':E'.($count_merge + $name_count[$i] - 1))->applyFromArray([
                                'borders' => array(
                                    'allborders' => array(
                                        'style' => \PHPExcel_Style_Border::BORDER_THIN
                                    )
                                )
                            ]);
                            $sheet->getStyle('F'.$count_merge.':F'.($count_merge + $name_count[$i] - 1))->applyFromArray([
                                'borders' => array(
                                    'allborders' => array(
                                        'style' => \PHPExcel_Style_Border::BORDER_THIN
                                    )
                                )
                            ]);
                            $sheet->getStyle('G'.$count_merge.':G'.($count_merge + $name_count[$i] - 1))->applyFromArray([
                                'borders' => array(
                                    'allborders' => array(
                                        'style' => \PHPExcel_Style_Border::BORDER_THIN
                                    )
                                )
                            ]);
                            $sheet->getStyle('H'.$count_merge.':H'.($count_merge + $name_count[$i] - 1))->applyFromArray([
                                'borders' => array(
                                    'allborders' => array(
                                        'style' => \PHPExcel_Style_Border::BORDER_THIN
                                    )
                                )
                            ]);
                            $sheet->getStyle('I'.$count_merge.':I'.($count_merge + $name_count[$i] - 1))->applyFromArray([
                                'borders' => array(
                                    'allborders' => array(
                                        'style' => \PHPExcel_Style_Border::BORDER_THIN
                                    )
                                )
                            ]);
                            $sheet->getStyle('J'.$count_merge.':J'.($count_merge + $name_count[$i] - 1))->applyFromArray([
                                'borders' => array(
                                    'allborders' => array(
                                        'style' => \PHPExcel_Style_Border::BORDER_THIN
                                    )
                                )
                            ]);
                            $sheet->getStyle('K'.$count_merge.':K'.($count_merge + $name_count[$i] - 1))->applyFromArray([
                                'borders' => array(
                                    'allborders' => array(
                                        'style' => \PHPExcel_Style_Border::BORDER_THIN
                                    )
                                )
                            ]);
                            $sheet->getStyle('L'.$count_merge.':L'.($count_merge + $name_count[$i] - 1))->applyFromArray([
                                'borders' => array(
                                    'allborders' => array(
                                        'style' => \PHPExcel_Style_Border::BORDER_THIN
                                    )
                                )
                            ]);
                            $sheet->getStyle('M'.$count_merge.':M'.($count_merge + $name_count[$i] - 1))->applyFromArray([
                                'borders' => array(
                                    'allborders' => array(
                                        'style' => \PHPExcel_Style_Border::BORDER_THIN
                                    )
                                )
                            ]);
                            $sheet->getStyle('N'.$count_merge.':N'.($count_merge + $name_count[$i] - 1))->applyFromArray([
                                'borders' => array(
                                    'allborders' => array(
                                        'style' => \PHPExcel_Style_Border::BORDER_THIN
                                    )
                                )
                            ]);
                            $sheet->getStyle('O'.$count_merge.':O'.($count_merge + $name_count[$i] - 1))->applyFromArray([
                                'borders' => array(
                                    'allborders' => array(
                                        'style' => \PHPExcel_Style_Border::BORDER_THIN
                                    )
                                )
                            ]);
                            $sheet->getStyle('P'.$count_merge.':P'.($count_merge + $name_count[$i] - 1))->applyFromArray([
                                'borders' => array(
                                    'allborders' => array(
                                        'style' => \PHPExcel_Style_Border::BORDER_THIN
                                    )
                                )
                            ]);
                        }
                        $count_merge += $name_count[$i];
                    }
                    $sheet->cell('A6:P6', function ($cell) {
                        $this->center($cell);
                    });
                    $sheet->cell('A4:P4', function ($cell) {
                        $this->center($cell);
                    });
                    $sheet->getStyle('A6:P6')->applyFromArray([
                        'borders' => array(
                            'allborders' => array(
                                'style' => \PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    ]);
                    $sheet->appendRow(array(
                        "","","","","",""
                    ));
                    $sheet->appendRow(array(
                        "","","","","",""
                    ));

                    $sheet->appendRow(array(
                        "","","","","","검토: . . . . . . . . . . . /____________________/"
                    ));

                    $sheet->appendRow(array(
                        "","","","","",""
                    ));

                    $sheet->appendRow(array(
                        "","","","","","보고서 작성: . . . . . . . . . . . /____________________/"
                    ));
                    $sheet->setFitToPage(true);
                    $sheet->setScale(80);
                });
            })->download('xls');
        }
    }

    public function indexAging(Request $request){
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        if(!$this->checkAccess("/report/aging", $this->enc(session()->get("auth")->userpositionid))){
            return redirect(route($this->redirectAccess));
        }
        $provinces = AddressProvince::orderBy("NAME")->get();
        if($request->isMethod("POST")){
            $curr_pro = $request->get("province");
            $startDate = $request->get("start");
            $curr_pro == "0" ? $text = "" : $text = "AND PO.ID=".$curr_pro;
            $results = DB::select(DB::raw("SELECT PO.NAME, VEN.PURPOSE_NAME,
            COUNT ( CASE WHEN  to_number(to_char(sysdate, 'YYYY'))-VEN.BUILD_YEAR <=3 THEN 1 END) NAS_0_3, 
            COUNT ( CASE WHEN  to_number(to_char(sysdate, 'YYYY'))-VEN.BUILD_YEAR >3 AND to_number(to_char(sysdate, 'YYYY'))-VEN.BUILD_YEAR <=6 THEN 1 END) NAS_4_6,
            COUNT ( CASE WHEN  to_number(to_char(sysdate, 'YYYY'))-VEN.BUILD_YEAR >6 AND to_number(to_char(sysdate, 'YYYY'))-VEN.BUILD_YEAR <=10 THEN 1 END) NAS_7_10,
            COUNT ( CASE WHEN  to_number(to_char(sysdate, 'YYYY'))-VEN.BUILD_YEAR >10 THEN 1 END) NAS_10_IKH
            FROM REG_VEHICLE_VIEW  VEN JOIN VRS.OWNER OW ON VEN.OWNER_ID=OW.ID
            JOIN ADDRESS_PROVINCE PO ON OW.PROVINCE_ID=PO.ID WHERE CREATED_DATE < '".$startDate."' ".$text."
            GROUP BY  PO.NAME ,VEN.PURPOSE_NAME order by PO.NAME ,VEN.PURPOSE_NAME"));
            return view('Reports.aging', compact('provinces', 'results', 'curr_pro', 'startDate'));
        } else {
            return view('Reports.aging', compact('provinces'));
        }
    }

    protected function exportToExcelAging(Request $request){
        $curr_pro = $request->route("pro");
        $startDate = $request->route("start");
        if($curr_pro != "none" && $startDate != "none"){
            Excel::create("연식 보고서", function($excel) use($curr_pro, $startDate) {
                $excel->setTitle("연식 보고서");
                $excel->setCreator("ATUT");
                $excel->sheet("보고서", function($sheet) use($curr_pro, $startDate) {
                    //Header үүсгэх
                    $sheet->setWidth(array(
                        'A'     =>  15,
                        'B'     =>  9,
                        'C'     =>  8,
                        'D'     =>  9,
                        'E'     =>  8,
                        'F'     =>  9,
                        'G'     =>  8,
                        'H'     =>  9,
                        'I'     =>  8,
                        'J'     =>  8
                    ));

                    //로고 입력
                    if (session()->get('auth')->iscity == 1) {
                        $objDrawing = new \PHPExcel_Worksheet_Drawing;
                        $objDrawing->setPath(public_path('/img/niislel.jpg')); //your image path
                        $objDrawing->setCoordinates('B1');
                        $objDrawing->setWidthAndHeight(55, 55);
                        $objDrawing->setWorksheet($sheet);
                        $sheet->setOrientation('landscape');
                        $sheet->appendRow(array("", "", "", "", "", "",  "수도 자동차운송 차량", ""));
                        $sheet->appendRow(array("", "", "", "", "", "", "",  "등록·관리 센터 ", ""));
                        
                        $sheet->mergeCells('G1:J1');
                        $sheet->mergeCells('H2:J2');
                } else {
                    $objDrawing = new \PHPExcel_Worksheet_Drawing;
                    $objDrawing->setPath(public_path('/img/logo.png')); //your image path
                    $objDrawing->setCoordinates('B1');
                    $objDrawing->setWidthAndHeight(55, 55);
                    $objDrawing->setWorksheet($sheet);
                    $sheet->appendRow(array("", "", "", "", "", "", "", "", "자동차운송", ""));
                    $sheet->appendRow(array("", "", "", "", "", "", "", "", "국가센터", ""));
                    $sheet->mergeCells('I1:J1');
                    $sheet->mergeCells('I2:J2');
                }
                   
                    $sheet->cell('I1', function ($cell) {
                        $this->cellRight($cell);
                    });
                    $sheet->cell('I2', function ($cell) {
                        $this->cellRight($cell);
                    });
                    $sheet->getStyle('G1')->getFont()->setBold(true);
                    $sheet->getStyle('H2')->getFont()->setBold(true);
                    $sheet->setPaperSize(\PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
                    $sheet->appendRow(array("","","","", "", "", ""));

                    $sheet->appendRow(array('차량 연식 텡계 보고서'));
                    $sheet->getStyle('A4:J4')->getFont()->setBold(true);
                    $sheet->getStyle('A4:J4')->getFont()->setSize(12);
                    $sheet->mergeCells('A4:J4');
                    $sheet->cell('A4', function ($cell) {
                        $this->center($cell);
                    });
                    $sheet->appendRow(array('/아이막, 시별/'));
                    $sheet->getStyle('A5:J5')->getFont()->setBold(true);
                    $sheet->getStyle('A5:J5')->getFont()->setSize(12);
                    $sheet->mergeCells('A5:J5');
                    $sheet->cell('A5', function ($cell) {
                        $this->center($cell);
                    });

                    $name = "전체";
                    if($curr_pro != "0"){
                        $name = AddressProvince::where("ID", $curr_pro)->get()->first()->name;
                    }
                    $sheet->appendRow(array(
                        "도시, 아이막: ".$name,
                        "",
                        "",
                        "",
                        "",
                        "보고 기간: ".$startDate. " -기준",
                        "",
                        "",
                        ""
                    ));

                    $sheet->mergeCells('A6:D6');
                    $sheet->mergeCells('F6:J6');

                    $sheet->getStyle('A6:D6')->getFont()->setBold(true);
                    $sheet->getStyle('F6:J6')->getFont()->setBold(true);

                    $sheet->appendRow(array(
                        "운송수단 유형",
                        "차량 연식",
                        "",
                        "",
                        "",
                        "",
                        "",
                        "",
                        "",
                        "합계"
                    ));
                    $sheet->appendRow(array(
                        "",
                        "0-3 년",
                        "비율",
                        "4-6 년",
                        "비율",
                        "7-9 년",
                        "비율",
                        "9년 이상",
                        "비율",
                        ""
                    ));

                    $sheet->getStyle('A7:J8')->getFont()->setBold(true);
                    $sheet->getStyle('A7:J8')->getFont()->setSize(12);

                    $sheet->mergeCells('A7:A8');
                    $sheet->mergeCells('B7:I7');
                    $sheet->mergeCells('J7:J8');

                    $this->setPrintMargins($sheet, 0.5, 1, 0.5, 1);
                    $this->parseCssProperties($sheet, "A", "7", "wrap-text", "true");
                    $sheet->cell('A7', function ($cell) {
                        $this->center($cell);
                    });
                    $sheet->cell('J7', function ($cell) {
                        $this->center($cell);
                    });
                    $sheet->getStyle('A6:N6')->getFont()->setBold(true);
                    $sheet->getStyle('A6:N6')->getFont()->setSize(12);
                    $curr_pro == "0" ? $text = "" : $text = "AND PO.ID=".$curr_pro;
                    $datas = DB::select(DB::raw("SELECT PO.NAME, VEN.PURPOSE_NAME,
                    COUNT ( CASE WHEN  to_number(to_char(sysdate, 'YYYY'))-VEN.BUILD_YEAR <=3 THEN 1 END) NAS_0_3, 
                    COUNT ( CASE WHEN  to_number(to_char(sysdate, 'YYYY'))-VEN.BUILD_YEAR >3 AND to_number(to_char(sysdate, 'YYYY'))-VEN.BUILD_YEAR <=6 THEN 1 END) NAS_4_6,
                    COUNT ( CASE WHEN  to_number(to_char(sysdate, 'YYYY'))-VEN.BUILD_YEAR >6 AND to_number(to_char(sysdate, 'YYYY'))-VEN.BUILD_YEAR <=10 THEN 1 END) NAS_7_10,
                    COUNT ( CASE WHEN  to_number(to_char(sysdate, 'YYYY'))-VEN.BUILD_YEAR >10 THEN 1 END) NAS_10_IKH
                    FROM REG_VEHICLE_VIEW  VEN JOIN VRS.OWNER OW ON VEN.OWNER_ID=OW.ID
                    JOIN ADDRESS_PROVINCE PO ON OW.PROVINCE_ID=PO.ID WHERE CREATED_DATE <= '".$startDate."' ".$text."
                    GROUP BY  PO.NAME ,VEN.PURPOSE_NAME order by PO.NAME ,VEN.PURPOSE_NAME"));

                    $init = array();
                    $all_names = array();
                    $i_g = 0;
                    foreach ($datas as $data){
                        if($data->name != ""){
                            $total = $data->nas_0_3 + $data->nas_4_6 + $data->nas_7_10 + $data->nas_10_ikh;
                            array_push($all_names, $data->name);
                            array_push($init, array(
                                $data->name,
                                $data->purpose_name,
                                $data->nas_0_3,
                                round((100 * $data->nas_0_3) / $total, 1),
                                $data->nas_4_6,
                                round((100  * $data->nas_4_6) / $total, 1),
                                $data->nas_7_10,
                                round((100  * $data->nas_7_10) / $total, 1),
                                $data->nas_10_ikh,
                                round((100  * $data->nas_10_ikh) / $total, 1),
                                $total
                            ));
                            $i_g++;
                        }
                    }
                    $all_names = array_unique($all_names);
                    $name_count = array();
                    for ($i = 0; $i < sizeof($all_names); $i++){
                        array_push($name_count, 0);
                    }

                    $all_names_last = array();
                    foreach ($all_names as $name){
                        array_push($all_names_last, $name);
                    }

                    $count_index = 0;
                    foreach ($all_names as $name){
                        $count = 0;
                        foreach ($init as $in){
                            if($name == $in[0]){
                                $count++;
                            }
                        }
                        $name_count[$count_index] = $count;
                        $count_index++;
                    }
                    $new_init = array();
                    $tmp = 0;
                    $tmp1 = 0;
                    for($i = 0; $i < sizeof($name_count); $i++){
                        $sum = array(0,0,0,0,0,0,0,0,0);
                        array_push($new_init, array($all_names_last[$i], "", "", "", "", "", "", "", "", ""));
                        $i_g++;
                        for($j = $tmp; $j < $name_count[$i] + $tmp1; $j++){
                            $sum[0] += $init[$j][2];
                            $sum[1] += $init[$j][3];
                            $sum[2] += $init[$j][4];
                            $sum[3] += $init[$j][5];
                            $sum[4] += $init[$j][6];
                            $sum[5] += $init[$j][7];
                            $sum[6] += $init[$j][8];
                            $sum[7] += $init[$j][9];
                            $sum[8] += $init[$j][10];
                            array_shift($init[$j]);
                            array_push($new_init, $init[$j]);
                            $tmp++;
                        }
                        $tmp1 = $tmp;
                        array_push($new_init, array("합계",round($sum[0]/$name_count[$i], 2),round($sum[1]/$name_count[$i], 2),round($sum[2]/$name_count[$i], 2),round($sum[3]/$name_count[$i], 2),$sum[4],round($sum[5]/$name_count[$i], 2),round($sum[6]/$name_count[$i], 2),round($sum[7]/$name_count[$i], 2),round($sum[8]/$name_count[$i], 2)));
                        $name_count[$i] += 2;
                        $i_g++;
                    }

                    $sheet->rows($new_init);
                    for($j = 1; $j <= $i_g + 8; $j++){
                        $sheet->cell('A'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('B'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('C'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('D'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('E'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('F'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('G'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('H'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('I'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('J'.($j), function ($cell) {
                            $this->center($cell);
                        });
                    }
                    $count_merge = 9;
                    for ($i = 0; $i < sizeof($name_count); $i++) {
                        if ($name_count[$i] > 1) {
                            $sheet->mergeCells('A' . $count_merge . ':J' . $count_merge);
                            $sheet->getStyle('A' . $count_merge . ':J' . $count_merge)->getFont()->setBold(true);
                            $sheet->getStyle('A' . $count_merge . ':J' . $count_merge)->getFont()->setSize(12);
                            $sheet->cell('A' . $count_merge, function ($cell) {
                                $this->alignLeft($cell);
                            });
                            $sheet->getStyle('A' . ($count_merge + $name_count[$i] - 1) . ':J' . ($count_merge + $name_count[$i] - 1))->getFont()->setBold(true);

                            $sheet->cell('A' . ($count_merge + $name_count[$i] - 1) . ':J' . ($count_merge + $name_count[$i] - 1), function($row) {
                                $row->setBackground('#CCCCCC');
                            });
                        }
                        $count_merge += $name_count[$i];
                    }

                    $sheet->getStyle('A7:J'.($i_g+8))->applyFromArray([
                        'borders' => array(
                            'allborders' => array(
                                'style' => \PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    ]);
                    $sheet->appendRow(array(
                        "","","","","",""
                    ));
                    $sheet->appendRow(array(
                        "","","","","",""
                    ));

                    $sheet->appendRow(array(
                        "","","검토: . . . . . . . . . . . /____________________/"
                    ));

                    $sheet->appendRow(array(
                        "","","","","",""
                    ));

                    $sheet->appendRow(array(
                        "","","보고서 작성: . . . . . . . . . . . /____________________/"
                    ));
                    $sheet->setFitToPage(true);
                    $sheet->setScale(80);
                });
            })->download('xls');
        }
    }

    public function positionLog(Request $request){
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        if(session()->get("auth")->userpositionid != 1 && session()->get("auth")->userpositionid != 103){
            return redirect(route($this->redirectAccess));
        }
        try{
            $positions = MainUserPosition::whereNull("deleted_at")->orderby("NAME")->get();
            if($request->isMethod("POST")){
                $pos = trim($request->get("position"));
                $start = trim($request->get("start"));
                $end = trim($request->get("end"));
                $logs = DB::table("SYSTEM_POSITION_LOG_VIEW")->where("POSITION_ID", $pos)->whereBetween("CREATEDDATE", [$start, $end." 23:59:59"])->get();
                return view('Reports.positionlog', compact('positions', 'logs', 'start', 'end', 'pos'));
            } else {
                return view('Reports.positionlog', compact('positions'));
            }
        } catch (\Exception $ex){
            return view('Reports.positionlog');
        }
    }

    protected function exportToExcelPositionLog(Request $request){
        $op = $request->route("op");
        $start = $request->route("start");
        $end = $request->route("end");

        if($start != "none" && $end != "none"){
            Excel::create("직위 권한 로그", function($excel) use($op, $start, $end) {
                $excel->setTitle("직위 권한 로그");
                $excel->setCreator("ATUT");
                $excel->sheet("보고서", function($sheet) use($op, $start, $end) {
                    //Header үүсгэх
                    $sheet->setWidth(array(
                        'A'     =>  5,
                        'B'     =>  8,
                        'C'     =>  20,
                        'D'     =>  32,
                        'E'     =>  32,
                        'F'     =>  32,
                        'G'     =>  25,
                        'H'     =>  25
                    ));

                    //로고 입력
                    if (session()->get('auth')->iscity == 1) {
                        $objDrawing = new \PHPExcel_Worksheet_Drawing;
                        $objDrawing->setPath(public_path('/img/niislel.jpg')); //your image path
                        $objDrawing->setCoordinates('B1');
                        $objDrawing->setWidthAndHeight(55, 55);
                        $objDrawing->setWorksheet($sheet);
                        $sheet->setOrientation('landscape');
                        $sheet->appendRow(array("", "", "", "", "", "",  "수도 자동차운송 차량", ""));
                        $sheet->appendRow(array("", "", "", "", "", "",   "등록·관리 센터 ", ""));
                        
                        $sheet->mergeCells('G1:J1');
                        $sheet->mergeCells('G2:J2');
                } else {
                    $objDrawing = new \PHPExcel_Worksheet_Drawing;
                    $objDrawing->setPath(public_path('/img/logo.png')); //your image path
                    $objDrawing->setCoordinates('B1');
                    $objDrawing->setWidthAndHeight(55, 55);
                    $objDrawing->setWorksheet($sheet);
                    $sheet->setOrientation('landscape');
                    $sheet->appendRow(array("", "", "", "", "", "", "자동차운송", ""));
                    $sheet->appendRow(array("", "", "", "", "", "", "국가센터", ""));
                    $sheet->mergeCells('G1:H1');
                    $sheet->mergeCells('G2:H2');
                }
                    $sheet->cell('G1', function ($cell) {
                        $this->cellRight($cell);
                    });
                    $sheet->cell('G2', function ($cell) {
                        $this->cellRight($cell);
                    });
                    $sheet->getStyle('G1')->getFont()->setBold(true);
                    $sheet->getStyle('G2')->getFont()->setBold(true);
                    $sheet->setPaperSize(\PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
                    $sheet->appendRow(array("","","","", "", "", ""));

                    $sheet->appendRow(array('','직위 권한 로그'));
                    $sheet->getStyle('B4:H4')->getFont()->setBold(true);
                    $sheet->getStyle('B4:H4')->getFont()->setSize(12);
                    $sheet->mergeCells('B4:H4');
                    $sheet->cell('B4', function ($cell) {
                        $this->center($cell);
                    });
                    $sheet->appendRow(array("","","","", "", "", ""));
                    $pos_name = MainUserPosition::where("ID", $op)->get()->first()->name;
                    $sheet->appendRow(array(
                        "","직위(공무): ".$pos_name, "", "", "", "", "일자: ".$start." -с ".$end
                    ));
                    $sheet->mergeCells('B6:D6');
                    $sheet->getStyle('B6:D6')->getFont()->setBold(true);
                    $sheet->cell('B6', function ($cell) {
                        $this->center($cell);
                    });
                    $sheet->mergeCells('G6:H6');
                    $sheet->getStyle('G6:H6')->getFont()->setBold(true);
                    $sheet->cell('F6', function ($cell) {
                        $this->center($cell);
                    });
                    $sheet->appendRow(array("","","","", "", ""));
                    $sheet->appendRow(array("","№", "일자", "직위명 /변경 전/", "직위명 /변경 후/", "작업", "생성됨", "수정됨"));
                    $sheet->getStyle('B8:H8')->getFont()->setBold(true);
                    $sheet->getStyle('B8:H8')->getFont()->setSize(12);
                    //열 서식 지정
                    $sheet->setColumnFormat(array('0', '0', '@', '@', '@', '@', '@', '@'));
                    //위에서 준비한 Array 값을 Excel 파일로보내기
                    $datas = DB::table("SYSTEM_POSITION_LOG_VIEW")->where("POSITION_ID", $op)->whereBetween("CREATEDDATE", [$start, $end." 23:59:59"])->get();
                    $init = array();
                    $i = 1;
                    foreach ($datas as $data){
                        array_push($init, array("", $i, Carbon::parse($data->createddate)->format("Y-m-d H:i:s"), $data->old_position_name, $data->position_name, $data->op_name, $data->firstname ." ". $data->lastname, $data->u_firstname ." ". $data->u_lastname));
                        $i++;
                    }
                    $sheet->rows($init);

                    for($j = 8; $j <= $i + 7; $j++){
                        $sheet->cell('B'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('C'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('D'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('E'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('F'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('G'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('H'.($j), function ($cell) {
                            $this->center($cell);
                        });
                    }
                    $sheet->getStyle('B8:H'.($i + 7))->applyFromArray([
                        'borders' => array(
                            'allborders' => array(
                                'style' => \PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    ]);
                    $sheet->appendRow(array(
                        "","","","","",""
                    ));
                    $sheet->appendRow(array(
                        "","","","","",""
                    ));
                    $sheet->appendRow(array(
                        "","","","보고서 작성: . . . . . . . . . . . /____________________/"
                    ));
                    $sheet->setFitToPage(true);
                    $sheet->setScale(80);
                });
            })->download('xls');
        }
    }

    public function indexTotalProvince(Request $request){
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        try{
            $provinces = array(
                "아르항가이",
                "바양울기",
                "바얀홍고르",
                "불간",
                "고비알타이",
                "고비숨버",
                "다르항올",
                "도르노고비",
                "도르노드",
                "둔드고비",
                "자브한",
                "오르홍",
                "셀렝게",
                "수흐바타르",
                "중앙",
                "울란바토르",
                "우브스",
                "호브드",
                "헹티",
                "홉스골",
                "오보르항가이",
                "옴노고비",
            );

            if($request->isMethod("POST")){
                $start = trim($request->get("start"));
                $end = trim($request->get("end"));
                $results = DB::select(DB::raw("SELECT PO.NAME, COUNT ( CASE WHEN  VEN.ENGINE_CAPACITY <=1500 THEN 1 END) X_1500_baga, COUNT ( CASE WHEN  VEN.ENGINE_CAPACITY >1500 AND VEN.ENGINE_CAPACITY <=2500 THEN 1 END) X_1501_2500, COUNT ( CASE WHEN  VEN.ENGINE_CAPACITY >2500 AND VEN.ENGINE_CAPACITY <=3500 THEN 1 END) X_2501_3500, COUNT ( CASE WHEN  VEN.ENGINE_CAPACITY >3501 AND VEN.ENGINE_CAPACITY <=4500 THEN 1 END) X_3501_4500, COUNT ( CASE WHEN  VEN.ENGINE_CAPACITY >4501 THEN 1 END) X_4501_IKH FROM VRS.REG_VEHICLE_VIEW VEN JOIN VRS.OWNER OW ON VEN.OWNER_ID=OW.ID JOIN VRS.ADDRESS_PROVINCE PO ON OW.PROVINCE_ID=PO.ID WHERE VEN.ENGINE_CAPACITY IS NOT NULL and VEN.UPDATED_DATE BETWEEN TO_DATE ('".$start."', 'YYYY/MM/DD') AND TO_DATE('".$end."', 'YYYY/MM/DD') GROUP BY PO.NAME ORDER BY PO.NAME"));
                $datas_cap = array(
                    array('1500 cc 이하', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '배기량'),
                    array('1501-2500 cc', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '배기량'),
                    array('2501-3500 cc', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '배기량'),
                    array('3501-4500 cc', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '배기량'),
                    array('4501 cc 이상', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '배기량')
                );

                $i = 1;
                $is_check = false;
                foreach ($provinces as $province){
                    foreach ($results as $result){
                        if($province == $result->name){
                            $datas_cap[0][$i] = $result->x_1500_baga;
                            $datas_cap[1][$i] = $result->x_1501_2500;
                            $datas_cap[2][$i] = $result->x_2501_3500;
                            $datas_cap[3][$i] = $result->x_3501_4500;
                            $datas_cap[4][$i] = $result->x_4501_ikh;

                            $datas_cap[0][23] += $result->x_1500_baga;
                            $datas_cap[1][23] += $result->x_1501_2500;
                            $datas_cap[2][23] += $result->x_2501_3500;
                            $datas_cap[3][23] += $result->x_3501_4500;
                            $datas_cap[4][23] += $result->x_4501_ikh;
                            $i++;
                            $is_check =true;
                            break;
                        }
                    }
                    if($is_check == false){
                        $datas_cap[0][$i] = 0;
                        $datas_cap[1][$i] = 0;
                        $datas_cap[2][$i] = 0;
                        $datas_cap[3][$i] = 0;
                        $datas_cap[4][$i] = 0;
                        $i++;
                    }
                }

                $results_nas = DB::select(DB::raw("SELECT PO.NAME,COUNT ( CASE WHEN  to_number(to_char(sysdate, 'YYYY'))-VEN.BUILD_YEAR <=3 THEN 1 END) NAS_0_3 , COUNT ( CASE WHEN  to_number(to_char(sysdate, 'YYYY'))-VEN.BUILD_YEAR >3 AND to_number(to_char(sysdate, 'YYYY'))-VEN.BUILD_YEAR <=6 THEN 1 END) NAS_4_6,COUNT ( CASE WHEN  to_number(to_char(sysdate, 'YYYY'))-VEN.BUILD_YEAR >6 AND to_number(to_char(sysdate, 'YYYY'))-VEN.BUILD_YEAR <=10 THEN 1 END) NAS_7_10 ,COUNT ( CASE WHEN  to_number(to_char(sysdate, 'YYYY'))-VEN.BUILD_YEAR >10 THEN 1 END) NAS_10_IKH FROM VRS.REG_VEHICLE_VIEW VEN JOIN VRS.OWNER OW ON VEN.OWNER_ID=OW.ID JOIN VRS.ADDRESS_PROVINCE PO ON OW.PROVINCE_ID=PO.ID WHERE VEN.UPDATED_DATE BETWEEN TO_DATE ('".$start."', 'YYYY/MM/DD') AND TO_DATE('".$end."', 'YYYY/MM/DD') GROUP BY PO.NAME ORDER BY PO.NAME"));
                $datas_nas = array(
                    array('0-3', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '연식'),
                    array('4-6', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '연식'),
                    array('7-9', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '연식'),
                    array('10년 이상', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '연식')
                );

                $i = 1;
                $is_check = false;
                foreach ($provinces as $province){
                    foreach ($results_nas as $result){
                        if($province == $result->name){
                            $datas_nas[0][$i] = $result->nas_0_3;
                            $datas_nas[1][$i] = $result->nas_4_6;
                            $datas_nas[2][$i] = $result->nas_7_10;
                            $datas_nas[3][$i] = $result->nas_10_ikh;

                            $datas_nas[0][23] += $result->nas_0_3;
                            $datas_nas[1][23] += $result->nas_4_6;
                            $datas_nas[2][23] += $result->nas_7_10;
                            $datas_nas[3][23] += $result->nas_10_ikh;
                            $i++;
                            $is_check =true;
                            break;
                        }
                    }
                    if($is_check == false){
                        $datas_nas[0][$i] = 0;
                        $datas_nas[1][$i] = 0;
                        $datas_nas[2][$i] = 0;
                        $datas_nas[3][$i] = 0;
                        $i++;
                    }
                }

                $results_wheel = DB::select(DB::raw("SELECT PO.NAME,COUNT ( CASE WHEN  VEN.WHEEL_ID =14 THEN 1 END) baruun, COUNT ( CASE WHEN  VEN.WHEEL_ID =15 THEN 1 END) zuun FROM VRS.REG_VEHICLE_VIEW VEN JOIN VRS.OWNER OW ON VEN.OWNER_ID=OW.ID JOIN VRS.ADDRESS_PROVINCE PO ON OW.PROVINCE_ID=PO.ID WHERE VEN.WHEEL_ID IS NOT NULL and VEN.UPDATED_DATE BETWEEN TO_DATE ('".$start."', 'YYYY/MM/DD') AND TO_DATE('".$end."', 'YYYY/MM/DD') GROUP BY PO.NAME ORDER BY PO.NAME"));
                $datas_wheel = array(
                    array('우측', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '핸들'),
                    array('좌측', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '핸들')
                );

                $i = 1;
                $is_check = false;
                foreach ($provinces as $province){
                    foreach ($results_wheel as $result){
                        if($province == $result->name){
                            $datas_wheel[0][$i] = $result->baruun;
                            $datas_wheel[1][$i] = $result->zuun;

                            $datas_wheel[0][23] += $result->baruun;
                            $datas_wheel[1][23] += $result->zuun;
                            $i++;
                            $is_check =true;
                            break;
                        }
                    }
                    if($is_check == false){
                        $datas_wheel[0][$i] = 0;
                        $datas_wheel[1][$i] = 0;
                        $i++;
                    }
                }

//                $results_tulsh = DB::select(DB::raw("SELECT PO.NAME,COUNT ( CASE WHEN  VEN.FUEL_TYPE_ID =23 THEN 1 END) usturugch, COUNT ( CASE WHEN  VEN.FUEL_TYPE_ID =22 THEN 1 END) tsahilgaan,COUNT ( CASE WHEN  VEN.FUEL_TYPE_ID =21 THEN 1 END) baigali, COUNT ( CASE WHEN  VEN.FUEL_TYPE_ID =20 THEN 1 END) nevt,COUNT ( CASE WHEN  VEN.FUEL_TYPE_ID =19 THEN 1 END) binzen_hii, COUNT ( CASE WHEN  VEN.FUEL_TYPE_ID =18 THEN 1 END) disel, COUNT ( CASE WHEN  VEN.FUEL_TYPE_ID =48 THEN 1 END) binzen FROM VRS.REG_VEHICLE_VIEW VEN JOIN VRS.OWNER OW ON VEN.OWNER_ID=OW.ID JOIN VRS.ADDRESS_PROVINCE PO ON OW.PROVINCE_ID=PO.ID WHERE VEN.FUEL_TYPE_ID IS NOT NULL AND VEN.UPDATED_DATE BETWEEN TO_DATE ('".$start."', 'YYYY/MM/DD') AND TO_DATE('".$end."', 'YYYY/MM/DD') GROUP BY PO.NAME ORDER BY PO.NAME"));
                $results_tulsh = DB::select(DB::raw("SELECT PO.NAME, COUNT ( CASE WHEN VEN.FUEL_PARENT_TYPE_ID =52 THEN 1 END) tsahilgaan,COUNT ( CASE WHEN  VEN.FUEL_PARENT_TYPE_ID =51 THEN 1 END) gaz, COUNT ( CASE WHEN  VEN.FUEL_PARENT_TYPE_ID =50 THEN 1 END) disel, COUNT ( CASE WHEN  VEN.FUEL_PARENT_TYPE_ID =49 THEN 1 END) binzen FROM VRS.REG_VEHICLE_VIEW VEN JOIN VRS.OWNER OW ON VEN.OWNER_ID=OW.ID JOIN VRS.ADDRESS_PROVINCE PO ON OW.PROVINCE_ID=PO.ID WHERE VEN.FUEL_PARENT_TYPE_ID IS NOT NULL AND VEN.UPDATED_DATE BETWEEN TO_DATE ('".$start."', 'YYYY/MM/DD') AND TO_DATE('".$end."', 'YYYY/MM/DD') GROUP BY PO.NAME ORDER BY PO.NAME"));
                $datas_tulsh = array(
//                    array('Устөрөгчийн', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '연료'),
//                    array('전기', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '연료'),
//                    array('Байгалийн шахсан хий /CNG/', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '연료'),
//                    array('Шингэрүүлсэн нефтийн хий /LPG/', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '연료'),
//                    array('휘발유 - хий хосолсон', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '연료'),
//                    array('디젤', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '연료'),
//                    array('휘발유', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '연료')

                    array('휘발유', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '연료'),
                    array('디젤', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '연료'),
                    array('전기', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '연료'),
                    array('가스', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '연료')
                );

                $i = 1;
                $is_check = false;
                foreach ($provinces as $province){
                    foreach ($results_tulsh as $result){
                        if($province == $result->name){
                            $datas_tulsh[0][$i] = $result->binzen;
                            $datas_tulsh[1][$i] = $result->disel;
                            $datas_tulsh[2][$i] = $result->tsahilgaan;
                            $datas_tulsh[3][$i] = $result->gaz;
//                            $datas_tulsh[4][$i] = $result->binzen_hii;
//                            $datas_tulsh[5][$i] = $result->disel;
//                            $datas_tulsh[6][$i] = $result->binzen;

                            $datas_tulsh[0][23] += $result->binzen;
                            $datas_tulsh[1][23] += $result->disel;
                            $datas_tulsh[2][23] += $result->tsahilgaan;
                            $datas_tulsh[3][23] += $result->gaz;
//                            $datas_tulsh[4][23] += $result->binzen_hii;
//                            $datas_tulsh[5][23] += $result->disel;
//                            $datas_tulsh[6][23] += $result->binzen;

                            $i++;
                            $is_check =true;
                            break;
                        }
                    }
                    if($is_check == false){
                        $datas_tulsh[0][$i] = 0;
                        $datas_tulsh[1][$i] = 0;
                        $datas_tulsh[2][$i] = 0;
                        $datas_tulsh[3][$i] = 0;
//                        $datas_tulsh[4][$i] = 0;
//                        $datas_tulsh[5][$i] = 0;
//                        $datas_tulsh[6][$i] = 0;
                        $i++;
                    }
                }

                $results_zoriulalt = DB::select(DB::raw("SELECT PO.NAME,COUNT ( CASE WHEN  VEN.PURPOSE_ID =1 THEN 1 END) suudal, COUNT ( CASE WHEN  VEN.PURPOSE_ID =2 THEN 1 END) achaa,COUNT ( CASE WHEN  VEN.PURPOSE_ID =3 THEN 1 END) avtobus, COUNT ( CASE WHEN  VEN.PURPOSE_ID =4 THEN 1 END) tusgai,COUNT ( CASE WHEN  VEN.PURPOSE_ID =5 THEN 1 END) tsister, COUNT ( CASE WHEN  VEN.PURPOSE_ID =6 THEN 1 END) zvtgvvr, COUNT ( CASE WHEN  VEN.PURPOSE_ID =7 THEN 1 END) mehanizm, COUNT ( CASE WHEN  VEN.PURPOSE_ID =8 THEN 1 END) chirgvvl, COUNT ( CASE WHEN  VEN.PURPOSE_ID =9 THEN 1 END) mototsikl FROM VRS.REG_VEHICLE_VIEW VEN JOIN VRS.OWNER OW ON VEN.OWNER_ID=OW.ID JOIN VRS.ADDRESS_PROVINCE PO ON OW.PROVINCE_ID=PO.ID WHERE VEN.UPDATED_DATE BETWEEN TO_DATE ('".$start."', 'YYYY/MM/DD') AND TO_DATE('".$end."', 'YYYY/MM/DD') GROUP BY PO.NAME ORDER BY PO.NAME"));
                $datas_zoriulalt = array(
                    array('좌석', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '용도'),
                    array('화물', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '용도'),
                    array('버스', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '용도'),
                    array('특수', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '용도'),
                    array('탱크', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '용도'),
                    array('기관차', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '용도'),
                    array('기계', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '용도'),
                    array('트레일러', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '용도'),
                    array('오토바이', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '용도')
                );

                $i = 1;
                $is_check = false;
                foreach ($provinces as $province){
                    foreach ($results_zoriulalt as $result){
                        if($province == $result->name){
                            $datas_zoriulalt[0][$i] = $result->suudal;
                            $datas_zoriulalt[1][$i] = $result->achaa;
                            $datas_zoriulalt[2][$i] = $result->avtobus;
                            $datas_zoriulalt[3][$i] = $result->tusgai;
                            $datas_zoriulalt[4][$i] = $result->tsister;
                            $datas_zoriulalt[5][$i] = $result->zvtgvvr;
                            $datas_zoriulalt[6][$i] = $result->mehanizm;
                            $datas_zoriulalt[7][$i] = $result->chirgvvl;
                            $datas_zoriulalt[8][$i] = $result->mototsikl;

                            $datas_zoriulalt[0][23] += $result->suudal;
                            $datas_zoriulalt[1][23] += $result->achaa;
                            $datas_zoriulalt[2][23] += $result->avtobus;
                            $datas_zoriulalt[3][23] += $result->tusgai;
                            $datas_zoriulalt[4][23] += $result->tsister;
                            $datas_zoriulalt[5][23] += $result->zvtgvvr;
                            $datas_zoriulalt[6][23] += $result->mehanizm;
                            $datas_zoriulalt[7][23] += $result->chirgvvl;
                            $datas_zoriulalt[8][23] += $result->mototsikl;

                            $i++;
                            $is_check =true;
                            break;
                        }
                    }
                    if($is_check == false){
                        $datas_zoriulalt[0][$i] = 0;
                        $datas_zoriulalt[1][$i] = 0;
                        $datas_zoriulalt[2][$i] = 0;
                        $datas_zoriulalt[3][$i] = 0;
                        $datas_zoriulalt[4][$i] = 0;
                        $datas_zoriulalt[5][$i] = 0;
                        $datas_zoriulalt[6][$i] = 0;
                        $datas_zoriulalt[7][$i] = 0;
                        $datas_zoriulalt[8][$i] = 0;
                        $i++;
                    }
                } 
                  //  dd($curr_pro);
                return view('Reports.totalprovince', compact( 'start', 'end', 'datas_cap', 'datas_nas', 'datas_wheel', 'datas_tulsh', 'datas_zoriulalt'));
            } else {
                return view('Reports.totalprovince');
            }
        } catch (\Exception $ex){
            $this->writeLog("Total province report error: ".$ex->getMessage());
            return view('Reports.totalprovince');
        }
    }

    protected function exportToExcelTotalProvince(Request $request){
        $start = $request->route("start");
        $end = $request->route("end");
//return $start;
        if($start != "none" && $end != "none"){
            Excel::create("전체 차량 통계 자료", function($excel) use($start, $end) {
                $excel->setTitle("전체 차량 통계 자료");
                $excel->setCreator("ATUT");
                $excel->sheet("보고서", function($sheet) use($start, $end) {
                    //Header үүсгэх
                    $sheet->setWidth(array(
                        'A'     =>  30,
                        'B'     =>  10,
                        'C'     =>  13,
                        'D'     =>  13,
                        'E'     =>  8,
                        'F'     =>  12,
                        'G'     =>  12,
                        'H'     =>  12,
                        'I'     =>  12,
                        'J'     =>  9,
                        'K'     =>  11,
                        'L'     =>  9,
                        'M'     =>  8,
                        'N'     =>  8,
                        'O'     =>  11,
                        'P'     =>  8,
                        'Q'     =>  14,
                        'R'     =>  10,
                        'S'     =>  10,
                        'T'     =>  10,
                        'U'     =>  10,
                        'V'     =>  12,
                        'W'     =>  12,
                        'X'     =>  12
                    ));

                    //로고 입력
                    if (session()->get('auth')->iscity == 1) {
                        $objDrawing = new \PHPExcel_Worksheet_Drawing;
                        $objDrawing->setPath(public_path('/img/niislel.jpg')); //your image path
                        $objDrawing->setCoordinates('B1');
                        $objDrawing->setWidthAndHeight(55, 55);
                        $objDrawing->setWorksheet($sheet);
                        $sheet->setOrientation('landscape');
                        $sheet->appendRow(array("", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "",  "수도 자동차운송 차량", ""));
                        $sheet->appendRow(array("", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "",  "등록·관리 센터 ", ""));                
                        $sheet->mergeCells('T1:V1');
                        $sheet->mergeCells('U2:V2');
                } else {
                        $objDrawing = new \PHPExcel_Worksheet_Drawing;
                        $objDrawing->setPath(public_path('/img/logo.png')); //your image path
                        $objDrawing->setCoordinates('B1');
                        $objDrawing->setWidthAndHeight(65, 65);
                        $objDrawing->setWorksheet($sheet);
                        $sheet->setOrientation('landscape');
                        $sheet->appendRow(array("", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "자동차운송", ""));
                        $sheet->appendRow(array("", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "","국가센터", ""));
                        $sheet->mergeCells('U1:V1');
                        $sheet->mergeCells('U2:V2');

                }
                    $sheet->cell('U1', function ($cell) {
                        $this->cellRight($cell);
                    });
                    $sheet->cell('U2', function ($cell) {
                        $this->cellRight($cell);
                    });
                    $sheet->getStyle('T1')->getFont()->setBold(true);
                    $sheet->getStyle('U2')->getFont()->setBold(true);
                    $sheet->setPaperSize(\PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
                    $sheet->appendRow(array("","","","", "", "", ""));

                    $sheet->appendRow(array('전체 차량 통계 자료'));
                    $sheet->getStyle('A4:W4')->getFont()->setBold(true);
                    $sheet->getStyle('A4:W4')->getFont()->setSize(12);
                    $sheet->mergeCells('A4:W4');
                    $sheet->cell('A4', function ($cell) {
                        $this->center($cell);
                    });
                    $sheet->appendRow(array('/아이막 수도별/'));
                    $sheet->getStyle('A5:W5')->getFont()->setBold(true);
                    $sheet->getStyle('A5:W5')->getFont()->setSize(12);
                    $sheet->mergeCells('A5:W5');
                    $sheet->cell('A5', function ($cell) {
                        $this->center($cell);
                    });

                    $sheet->appendRow(array("","","","", "", "", ""));
                    $sheet->appendRow(array(
                        "", "", "", "", "", "", "", "", "보고 기간: ".$start." -с ".$end. " -일 기준"
                    ));
                    $sheet->mergeCells('I7:N7');
                    $sheet->getStyle('I7:N7')->getFont()->setBold(true);
                    $sheet->cell('I7', function ($cell) {
                        $this->center($cell);
                    });

                    $sheet->appendRow(array("","","","", "", ""));
                    $sheet->appendRow(array(
                        "유형",
                        "아르항가이",
                        "바양울기",
                        "바얀홍고르",
                        "불간",
                        "고비알타이",
                        "고비숨버",
                        "다르항올",
                        "도르노고비",
                        "도르노드",
                        "둔드고비",
                        "자브한",
                        "오르홍",
                        "셀렝게",
                        "수흐바타르",
                        "중앙",
                        "울란바토르",
                        "우브스",
                        "호브드",
                        "헹티",
                        "홉스골",
                        "오보르항가이",
                        "옴노고비",
                        "합계"
                    ));

                    $provinces = array(
                        "아르항가이",
                        "바양울기",
                        "바얀홍고르",
                        "불간",
                        "고비알타이",
                        "고비숨버",
                        "다르항올",
                        "도르노고비",
                        "도르노드",
                        "둔드고비",
                        "자브한",
                        "오르홍",
                        "셀렝게",
                        "수흐바타르",
                        "중앙",
                        "울란바토르",
                        "우브스",
                        "호브드",
                        "헹티",
                        "홉스골",
                        "오보르항가이",
                        "옴노고비",
                    );

                    $sheet->getStyle('A9:X9')->getFont()->setBold(true);
                    $sheet->getStyle('A9:X9')->getFont()->setSize(12);
                    $sheet->cell('A9:X9', function($row) {
                        $row->setBackground('#CCCCCC');
                    });
                    $sheet->getStyle('A9:X9')->getFont()->setBold(true);
                    //열 서식 지정
                    //$sheet->setColumnFormat(array('@', '@', '@', '@', '@', '@', '@', '@', '@', '@', '@', '@', '@', '@', '@', '@', '@', '@', '@', '@', '@', '@', '@', '@', '@', '@', '@'));
                    $results_zoriulalt = DB::select(DB::raw("SELECT PO.NAME,COUNT ( CASE WHEN  VEN.PURPOSE_ID =1 THEN 1 END) suudal, COUNT ( CASE WHEN  VEN.PURPOSE_ID =2 THEN 1 END) achaa,COUNT ( CASE WHEN  VEN.PURPOSE_ID =3 THEN 1 END) avtobus, COUNT ( CASE WHEN  VEN.PURPOSE_ID =4 THEN 1 END) tusgai,COUNT ( CASE WHEN  VEN.PURPOSE_ID =5 THEN 1 END) tsister, COUNT ( CASE WHEN  VEN.PURPOSE_ID =6 THEN 1 END) zvtgvvr, COUNT ( CASE WHEN  VEN.PURPOSE_ID =7 THEN 1 END) mehanizm, COUNT ( CASE WHEN  VEN.PURPOSE_ID =8 THEN 1 END) chirgvvl, COUNT ( CASE WHEN  VEN.PURPOSE_ID =9 THEN 1 END) mototsikl FROM VRS.REG_VEHICLE_VIEW VEN JOIN VRS.OWNER OW ON VEN.OWNER_ID=OW.ID JOIN VRS.ADDRESS_PROVINCE PO ON OW.PROVINCE_ID=PO.ID WHERE  VEN.CREATED_DATE BETWEEN TO_DATE ('".$start."', 'YYYY/MM/DD') AND TO_DATE('".$end."', 'YYYY/MM/DD') AND VEN.STATUS NOT IN(9,10,11) GROUP BY PO.NAME ORDER BY PO.NAME"));
                    $datas_zoriulalt = array(
                        array('좌석', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
                        array('화물', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
                        array('버스', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
                        array('특수', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
                        array('탱크', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
                        array('기관차', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
                        array('기계', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
                        array('트레일러', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
                        array('오토바이', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
                        array('합계', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0)
                    );

                    $i = 1;
                    $is_check = false;
                    foreach ($provinces as $province){
                        foreach ($results_zoriulalt as $result){
                            if($province == $result->name){
                                $datas_zoriulalt[0][$i] = $result->suudal;
                                $datas_zoriulalt[1][$i] = $result->achaa;
                                $datas_zoriulalt[2][$i] = $result->avtobus;
                                $datas_zoriulalt[3][$i] = $result->tusgai;
                                $datas_zoriulalt[4][$i] = $result->tsister;
                                $datas_zoriulalt[5][$i] = $result->zvtgvvr;
                                $datas_zoriulalt[6][$i] = $result->mehanizm;
                                $datas_zoriulalt[7][$i] = $result->chirgvvl;
                                $datas_zoriulalt[8][$i] = $result->mototsikl;

                                $datas_zoriulalt[0][23] += $result->suudal;
                                $datas_zoriulalt[1][23] += $result->achaa;
                                $datas_zoriulalt[2][23] += $result->avtobus;
                                $datas_zoriulalt[3][23] += $result->tusgai;
                                $datas_zoriulalt[4][23] += $result->tsister;
                                $datas_zoriulalt[5][23] += $result->zvtgvvr;
                                $datas_zoriulalt[6][23] += $result->mehanizm;
                                $datas_zoriulalt[7][23] += $result->chirgvvl;
                                $datas_zoriulalt[8][23] += $result->mototsikl;

                                $datas_zoriulalt[9][$i] = $result->suudal + $result->achaa + $result->avtobus + $result->tusgai +
                                    $result->tsister + $result->zvtgvvr + $result->mehanizm + $result->chirgvvl + $result->mototsikl;

                                $i++;
                                $is_check =true;
                                break;
                            }
                        }
                        if($is_check == false){
                            $datas_zoriulalt[0][$i] = 0;
                            $datas_zoriulalt[1][$i] = 0;
                            $datas_zoriulalt[2][$i] = 0;
                            $datas_zoriulalt[3][$i] = 0;
                            $datas_zoriulalt[4][$i] = 0;
                            $datas_zoriulalt[5][$i] = 0;
                            $datas_zoriulalt[6][$i] = 0;
                            $datas_zoriulalt[7][$i] = 0;
                            $datas_zoriulalt[8][$i] = 0;
                            $datas_zoriulalt[9][$i] = 0;
                            $i++;
                        }
                    }
                    $datas_zoriulalt[9][23] = $datas_zoriulalt[0][23] + $datas_zoriulalt[1][23] + $datas_zoriulalt[2][23] + $datas_zoriulalt[3][23] + $datas_zoriulalt[4][23] + $datas_zoriulalt[5][23] + $datas_zoriulalt[6][23] + $datas_zoriulalt[7][23] + $datas_zoriulalt[8][23];
                    $sheet->rows($datas_zoriulalt);
                    $sheet->cell('A19:X19', function($row) {
                        $row->setBackground('#CCCCCC');
                    });
                    $sheet->getStyle('A19:X19')->getFont()->setBold(true);
                    $results_wheel = DB::select(DB::raw("SELECT PO.NAME,COUNT ( CASE WHEN  VEN.WHEEL_ID =14 THEN 1 END) baruun, COUNT ( CASE WHEN  VEN.WHEEL_ID =15 THEN 1 END) zuun FROM VRS.REG_VEHICLE_VIEW VEN JOIN VRS.OWNER OW ON VEN.OWNER_ID=OW.ID JOIN VRS.ADDRESS_PROVINCE PO ON OW.PROVINCE_ID=PO.ID WHERE VEN.WHEEL_ID IS NOT NULL and  VEN.CREATED_DATE BETWEEN TO_DATE ('".$start."', 'YYYY/MM/DD') AND TO_DATE('".$end."', 'YYYY/MM/DD') AND VEN.STATUS NOT IN(9,10,11) GROUP BY PO.NAME ORDER BY PO.NAME"));
                    $datas_wheel = array(
                        array('우측', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
                        array('좌측', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
                        array('합계', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0)
                    );

                    $i = 1;
                    $is_check = false;
                    foreach ($provinces as $province){
                        foreach ($results_wheel as $result){
                            if($province == $result->name){
                                $datas_wheel[0][$i] = $result->baruun;
                                $datas_wheel[1][$i] = $result->zuun;

                                $datas_wheel[0][23] += $result->baruun;
                                $datas_wheel[1][23] += $result->zuun;

                                $datas_wheel[2][$i] += $result->baruun + $result->zuun;
                                $i++;
                                $is_check =true;
                                break;
                            }
                        }
                        if($is_check == false){
                            $datas_wheel[0][$i] = 0;
                            $datas_wheel[1][$i] = 0;
                            $datas_wheel[2][$i] = 0;
                            $i++;
                        }
                    }
                    $datas_wheel[2][23] =  $datas_wheel[0][23] +  $datas_wheel[1][23];
                    $sheet->rows($datas_wheel);
                    $sheet->cell('A22:X22', function($row) {
                        $row->setBackground('#CCCCCC');
                    });
                    $sheet->getStyle('A22:X22')->getFont()->setBold(true);

                    $results_tulsh = DB::select(DB::raw("SELECT PO.NAME,COUNT ( CASE WHEN  VEN.FUEL_PARENT_TYPE_ID =52 THEN 1 END) tsahilgaan,
                    COUNT ( CASE WHEN  VEN.FUEL_PARENT_TYPE_ID =51 THEN 1 END) gaz, COUNT ( CASE WHEN  VEN.FUEL_PARENT_TYPE_ID =50 THEN 1 END) disel, 
                    COUNT ( CASE WHEN  VEN.FUEL_PARENT_TYPE_ID =49 AND VEN.IS_HYBRID=0  THEN 1 END) binzen,
                    COUNT ( CASE WHEN  VEN.FUEL_PARENT_TYPE_ID =49 AND VEN.IS_HYBRID=1  THEN 1 END) hosolson
                    FROM VRS.REG_VEHICLE_VIEW VEN JOIN VRS.OWNER OW ON VEN.OWNER_ID=OW.ID JOIN VRS.ADDRESS_PROVINCE PO ON OW.PROVINCE_ID=PO.ID WHERE
                     VEN.FUEL_TYPE_ID IS NOT NULL AND VEN.CREATED_DATE BETWEEN TO_DATE ('".$start."', 'YYYY/MM/DD') AND TO_DATE('".$end."', 'YYYY/MM/DD') AND VEN.STATUS NOT IN(9,10,11) GROUP BY PO.NAME ORDER BY PO.NAME"));
                    $datas_tulsh = array(
                        array('휘발유', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
                       
                        array('디젤', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
                        array('전기', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
                        array('가스', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
                        array('Хосолсон', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
                        array('합계', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0)
                    );

                    $i = 1;
                    $is_check = false;
                    foreach ($provinces as $province){
                        foreach ($results_tulsh as $result){
                            if($province == $result->name){
                               // dd($result);
                                $datas_tulsh[0][$i] = $result->binzen;
                                $datas_tulsh[1][$i] = $result->disel;
                                $datas_tulsh[2][$i] = $result->tsahilgaan;
                                $datas_tulsh[3][$i] = $result->gaz;
                                $datas_tulsh[4][$i] = $result->hosolson;
//                                $datas_tulsh[4][$i] = $result->binzen_hii;
//                                $datas_tulsh[5][$i] = $result->disel;
//                                $datas_tulsh[6][$i] = $result->binzen;

                                $datas_tulsh[0][23] += $result->binzen;
                                $datas_tulsh[1][23] += $result->disel;
                                $datas_tulsh[2][23] += $result->tsahilgaan;
                                $datas_tulsh[3][23] += $result->gaz;
                                $datas_tulsh[4][23] += $result->hosolson;
//                                $datas_tulsh[4][23] += $result->binzen_hii;
//                                $datas_tulsh[5][23] += $result->disel;
//                                $datas_tulsh[6][23] += $result->binzen;

                                $datas_tulsh[5][$i] = $result->tsahilgaan + $result->gaz + $result->disel + $result->binzen + $result->hosolson;

                                $i++;
                                $is_check =true;
                                break;
                            }
                        }
                        if($is_check == false){
                            $datas_tulsh[0][$i] = 0;
                            $datas_tulsh[1][$i] = 0;
                            $datas_tulsh[2][$i] = 0;
                            $datas_tulsh[3][$i] = 0;
                            $datas_tulsh[4][$i] = 0;
//                            $datas_tulsh[4][$i] = 0;
//                            $datas_tulsh[5][$i] = 0;
//                            $datas_tulsh[6][$i] = 0;
//                            $datas_tulsh[7][$i] = 0;
                            $i++;
                        }
                    }
                    $datas_tulsh[5][23] = $datas_tulsh[0][23] + $datas_tulsh[1][23] + $datas_tulsh[2][23] + $datas_tulsh[3][23] + $datas_tulsh[4][23];
                    $sheet->rows($datas_tulsh);
                    $sheet->cell('A28:X28', function($row) {
                        $row->setBackground('#CCCCCC');
                    });
                    $sheet->getStyle('A28:X28')->getFont()->setBold(true);

                    $results_nas = DB::select(DB::raw("SELECT PO.NAME,COUNT ( CASE WHEN  to_number(to_char(sysdate, 'YYYY'))-VEN.BUILD_YEAR <=3 THEN 1 END) NAS_0_3 , COUNT ( CASE WHEN  to_number(to_char(sysdate, 'YYYY'))-VEN.BUILD_YEAR >3 AND to_number(to_char(sysdate, 'YYYY'))-VEN.BUILD_YEAR <=6 THEN 1 END) NAS_4_6,COUNT ( CASE WHEN  to_number(to_char(sysdate, 'YYYY'))-VEN.BUILD_YEAR >6 AND to_number(to_char(sysdate, 'YYYY'))-VEN.BUILD_YEAR <=10 THEN 1 END) NAS_7_10 ,COUNT ( CASE WHEN  to_number(to_char(sysdate, 'YYYY'))-VEN.BUILD_YEAR >10 THEN 1 END) NAS_10_IKH FROM VRS.REG_VEHICLE_VIEW VEN JOIN VRS.OWNER OW ON VEN.OWNER_ID=OW.ID JOIN VRS.ADDRESS_PROVINCE PO ON OW.PROVINCE_ID=PO.ID WHERE VEN.CREATED_DATE BETWEEN TO_DATE ('".$start."', 'YYYY/MM/DD') AND TO_DATE('".$end."', 'YYYY/MM/DD') AND VEN.STATUS NOT IN(9,10,11) GROUP BY PO.NAME ORDER BY PO.NAME"));
                    $datas_nas = array(
                        array('0-3', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
                        array('4-6', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
                        array('7-9', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
                        array('10년 이상', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
                        array('합계', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0)
                    );

                    $i = 1;
                    $is_check = false;
                    foreach ($provinces as $province){
                        foreach ($results_nas as $result){
                            if($province == $result->name){
                                $datas_nas[0][$i] = $result->nas_0_3;
                                $datas_nas[1][$i] = $result->nas_4_6;
                                $datas_nas[2][$i] = $result->nas_7_10;
                                $datas_nas[3][$i] = $result->nas_10_ikh;

                                $datas_nas[0][23] += $result->nas_0_3;
                                $datas_nas[1][23] += $result->nas_4_6;
                                $datas_nas[2][23] += $result->nas_7_10;
                                $datas_nas[3][23] += $result->nas_10_ikh;

                                $datas_nas[4][$i] = $result->nas_0_3 + $result->nas_4_6 + $result->nas_7_10 + $result->nas_10_ikh;
                                $i++;
                                $is_check =true;
                                break;
                            }
                        }
                        if($is_check == false){
                            $datas_nas[0][$i] = 0;
                            $datas_nas[1][$i] = 0;
                            $datas_nas[2][$i] = 0;
                            $datas_nas[3][$i] = 0;
                            $datas_nas[4][$i] = 0;
                            $i++;
                        }
                    }
                    $datas_nas[4][23] = $datas_nas[0][23] + $datas_nas[1][23] + $datas_nas[2][23] + $datas_nas[3][23];
                    $sheet->rows($datas_nas);
                    $sheet->cell('A33:X33', function($row) {
                        $row->setBackground('#CCCCCC');
                    });
                    $sheet->getStyle('A33:X33')->getFont()->setBold(true);

                    $results = DB::select(DB::raw("SELECT PO.NAME, COUNT ( CASE WHEN  VEN.ENGINE_CAPACITY <=1500 THEN 1 END) X_1500_baga, COUNT ( CASE WHEN  VEN.ENGINE_CAPACITY >1500 AND VEN.ENGINE_CAPACITY <=2500 THEN 1 END) X_1501_2500, COUNT ( CASE WHEN  VEN.ENGINE_CAPACITY >2500 AND VEN.ENGINE_CAPACITY <=3500 THEN 1 END) X_2501_3500, COUNT ( CASE WHEN  VEN.ENGINE_CAPACITY >3501 AND VEN.ENGINE_CAPACITY <=4500 THEN 1 END) X_3501_4500, COUNT ( CASE WHEN  VEN.ENGINE_CAPACITY >4501 THEN 1 END) X_4501_IKH FROM VRS.REG_VEHICLE_VIEW VEN JOIN VRS.OWNER OW ON VEN.OWNER_ID=OW.ID JOIN VRS.ADDRESS_PROVINCE PO ON OW.PROVINCE_ID=PO.ID WHERE VEN.ENGINE_CAPACITY IS NOT NULL and  VEN.CREATED_DATE BETWEEN TO_DATE ('".$start."', 'YYYY/MM/DD') AND TO_DATE('".$end."', 'YYYY/MM/DD')  AND VEN.STATUS NOT IN(9,10,11) GROUP BY PO.NAME ORDER BY PO.NAME"));
                    $datas = array(
                        array('1500 cc 이하', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
                        array('1501-2500 cc', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
                        array('2501-3500 cc', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
                        array('3501-4500 cc', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
                        array('4501 cc 이상', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
                        array('합계', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0)
                    );

                    $i = 1;
                    $is_check = false;
                    foreach ($provinces as $province){
                        foreach ($results as $result){
                            if($province == $result->name){
                                $datas[0][$i] = $result->x_1500_baga;
                                $datas[1][$i] = $result->x_1501_2500;
                                $datas[2][$i] = $result->x_2501_3500;
                                $datas[3][$i] = $result->x_3501_4500;
                                $datas[4][$i] = $result->x_4501_ikh;

                                $datas[0][23] += $result->x_1500_baga;
                                $datas[1][23] += $result->x_1501_2500;
                                $datas[2][23] += $result->x_2501_3500;
                                $datas[3][23] += $result->x_3501_4500;
                                $datas[4][23] += $result->x_4501_ikh;

                                $datas[5][$i] = $result->x_1500_baga + $result->x_1501_2500 + $result->x_2501_3500 + $result->x_3501_4500 + $result->x_4501_ikh;
                                $i++;
                                $is_check =true;
                                break;
                            }
                        }
                        if($is_check == false){
                            $datas[0][$i] = 0;
                            $datas[1][$i] = 0;
                            $datas[2][$i] = 0;
                            $datas[3][$i] = 0;
                            $datas[4][$i] = 0;
                            $datas[5][$i] = 0;
                            $i++;
                        } 
                    }
                    $datas[5][23] = $datas[0][23] + $datas[1][23] + $datas[2][23] + $datas[3][23] + $datas[4][23];
                    $sheet->rows($datas);
                    $sheet->cell('A39:X39', function($row) {
                        $row->setBackground('#CCCCCC');
                    });
                    $sheet->getStyle('A41:X41')->getFont()->setBold(true);

                    for($j = 9; $j <= 39; $j++){
                        $sheet->cell('A'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('B'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('C'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('D'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('E'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('F'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('G'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('H'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('I'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('K'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('L'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('M'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('N'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('O'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('P'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('Q'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('R'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('S'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('T'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('U'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('V'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('W'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('X'.($j), function ($cell) {
                            $this->center($cell);
                        });
                    }
                    $sheet->getStyle('A9:X39')->applyFromArray([
                        'borders' => array(
                            'allborders' => array(
                                'style' => \PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    ]);
                    $sheet->appendRow(array(
                        "","","","","",""
                    ));
                    $sheet->appendRow(array(
                        "","","","","",""
                    ));
                    $sheet->appendRow(array(
                        "","","","","",""
                    ));
                    $sheet->appendRow(array(
                        "","","","","","","","","보고서 гаргасан: . . . . . . . . . . . . . . . . . /____________________/"
                    ));
                    $sheet->appendRow(array(
                        "","","","","",""
                    ));
                    $sheet->appendRow(array(
                        "","","","","",""
                    ));
                    $sheet->appendRow(array(
                        "","","","","","","","","보고서 хянасан: . . . . . . . . . . . . . . . . . /____________________/"
                    ));
                    $sheet->setFitToPage(true);
                    $sheet->setScale(80);
                });
            })->download('xls');
        }
    }
    
    public function certificate(Request $request){ 
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        if(!$this->checkAccess("/report/user/certificate", $this->enc(session()->get("auth")->userpositionid))){
            return redirect(route($this->redirectAccess));
        }
        if (session()->get("auth")->iscity == 1 && session()->get("auth")->isatvt == 0) {
            $users = DB::table("MAIN_USER_VIEW")->whereNull("deleted_at")->where("PROVINCEID", $userPkId = session()->get("auth")->provinceid)->where('IsCity',1)->orderBy("FIRSTNAME")->get();
        } else {
            $users = DB::table("MAIN_USER_VIEW")->whereNull("deleted_at")->where("PROVINCEID", $userPkId = session()->get("auth")->provinceid)->where("IsAtvt", 1)->orderBy("FIRSTNAME")->get();
        }
       // $users = DB::table("MAIN_USER_VIEW")->whereNull("deleted_at")->where("IsAtvt", 1)->whereNotNull("FIRSTNAME")->orderBy("FIRSTNAME")->get();
        if($request->isMethod("POST")){
            
            $curr_user = $request->get("user");
            $startDate = $request->get("start");
            $endDate = $request->get("end");

            $results = DB::select(DB::raw("SELECT CERT.UPDATED_DATE as CREATED_DATE, CERT.CERTIFICATE_NO, CERT.PLATE_NO as VEHICLE_PLATE, SS.NAME AS SERVICE_NAME, ss.FEE FROM ARCHIVE_VIEW CERT LEFT JOIN VRS.SYSTEM_SERVICE SS ON CERT.SERVICE_ID=SS.ID WHERE CERT.UPDATED_DATE BETWEEN '".$startDate."' AND '".$endDate." 23:59:59' AND CERT.CREATED_BY = '".$curr_user."' AND SS.ID != 6 ORDER BY CERT.UPDATED_DATE, CERT.CERTIFICATE_NO"));
            return view("Reports.certificate", compact("users", "results", "curr_user", "startDate", "endDate"));
        } else {
            return view("Reports.certificate", compact("users"));
        }
    }

    protected function exportToExcelCertificate(Request $request){
        $user = $request->route("user");
        $start = $request->route("start");
        $end = $request->route("end");

        if($start != "none" && $end != "none"){
            Excel::create("증명서 보고서", function($excel) use($user, $start, $end) {
                $excel->setTitle("증명서 보고서");
                $excel->setCreator("ATUT");
                $excel->sheet("보고서", function($sheet) use($user, $start, $end) {
                    //Header үүсгэх
                    $sheet->setWidth(array(
                        'A'     =>  6,
                        'B'     =>  20,
                        'C'     =>  17,
                        'D'     =>  14,
                        'E'     =>  32,
                        'F'     =>  12,
                        'G'     =>  13
                    ));

                    //로고 입력
                    if (session()->get('auth')->iscity == 1) {
                        $objDrawing = new \PHPExcel_Worksheet_Drawing;
                        $objDrawing->setPath(public_path('/img/niislel.jpg')); //your image path
                        $objDrawing->setCoordinates('B1');
                        $objDrawing->setWidthAndHeight(55, 55);
                        $objDrawing->setWorksheet($sheet);
                        $sheet->setOrientation('landscape');
                        $sheet->appendRow(array("", "", "","","", "수도 자동차운송 차량", ""));
                        $sheet->appendRow(array("", "", "", "","", "등록·관리 센터 ", ""));                
                        $sheet->mergeCells('F1:G1');
                        $sheet->mergeCells('F2:G2');
                } else {
                    $objDrawing = new \PHPExcel_Worksheet_Drawing;
                    $objDrawing->setPath(public_path('/img/logo.png')); //your image path
                    $objDrawing->setCoordinates('A1');
                    $objDrawing->setWidthAndHeight(55, 55);
                    $objDrawing->setWorksheet($sheet);
                    $sheet->setOrientation('portrait');
                    $sheet->appendRow(array("", "", "", "", "", "자동차운송", ""));
                    $sheet->appendRow(array("", "", "", "", "", "국가센터", ""));
                    $sheet->mergeCells('F1:G1');
                    $sheet->mergeCells('F2:G2');
                }
                    $sheet->cell('F1', function ($cell) {
                        $this->cellRight($cell);
                    });
                    $sheet->cell('F2', function ($cell) {
                        $this->cellRight($cell);
                    });
                    $sheet->getStyle('F1')->getFont()->setBold(true);
                    $sheet->getStyle('F2')->getFont()->setBold(true);
                    $sheet->setPaperSize(\PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
                    $sheet->appendRow(array("","","","", "", "", ""));

                    $sheet->appendRow(array('','증명서 보고서'));
                    $sheet->getStyle('A4:G4')->getFont()->setBold(true);
                    $sheet->getStyle('A4:G4')->getFont()->setSize(12);
                    $sheet->mergeCells('A4:G4');
                    $sheet->cell('A4', function ($cell) {
                        $this->center($cell);
                    });
                    $sheet->appendRow(array("","","","", "", "", ""));
                    $firstname = MainUser::where("ID", $user)->get()->first()->firstname;
                    $sheet->appendRow(array(
                        "담당자 이름: ".$firstname, "", "", "", "일자: ", $start." -с ".$end
                    ));
                    $sheet->mergeCells('A6:C6');
                    $sheet->getStyle('A6:C6')->getFont()->setBold(true);
                    $sheet->cell('A6', function ($cell) {
                        $this->cellLeft($cell);
                    });
                    $sheet->cell('E6', function ($cell) {
                        $this->cellRight($cell);
                    });
                    $sheet->getStyle('E6')->getFont()->setBold(true);
                    $sheet->mergeCells('F6:G6');
                    $sheet->getStyle('F6:G6')->getFont()->setBold(true);
                    $sheet->cell('F6', function ($cell) {
                        $this->cellRight($cell);
                    });
                    $sheet->appendRow(array("","","","", "", ""));
                    $sheet->appendRow(array("№", "일자", "증명서 №", "번호판", "서비스 유형", "결제", "합계 орлого"));
                    $sheet->getStyle('A8:G8')->getFont()->setBold(true);
                    $sheet->getStyle('A8:G8')->getFont()->setSize(12);
                    $this->setPrintMargins($sheet, 0.2, 0.25, 0.2, 0.25);
                    $this->setPrintFitToWidth($sheet);
                    //열 서식 지정
                    $sheet->setColumnFormat(array('0', '@', '@', '@', '@', '@', '@'));
                    //위에서 준비한 Array 값을 Excel 파일로보내기
                    $datas = DB::select(DB::raw("SELECT CERT.UPDATED_DATE as CREATED_DATE, CERT.CERTIFICATE_NO, CERT.PLATE_NO as VEHICLE_PLATE, SS.NAME AS SERVICE_NAME, ss.FEE FROM ARCHIVE_VIEW CERT LEFT JOIN VRS.SYSTEM_SERVICE SS ON CERT.SERVICE_ID=SS.ID WHERE CERT.UPDATED_DATE BETWEEN '".$start."' AND '".$end." 23:59:59' AND CERT.CREATED_BY = '".$user."' AND SS.ID !=6  ORDER BY CERT.UPDATED_DATE, CERT.CERTIFICATE_NO"));
                    $init = array();
                    $i = 1;
                    $sum = 0;
                    foreach ($datas as $data){
                        array_push($init, array($i, Carbon::parse($data->created_date)->format("Y-m-d H:i:s"), $data->certificate_no, $data->vehicle_plate, $data->service_name, $data->fee, $data->fee));
                        $sum += $data->fee;
                        $i++;
                    }
                    array_push($init, array("НИЙТ", "", "", "", "", $sum, $sum));
                    $sheet->rows($init);
                    $sheet->mergeCells('A'.($i + 8).':E'.($i + 8));
                    $sheet->getStyle('A'.($i + 8).':G'.($i + 8))->getFont()->setBold(true);
                    for($j = 8; $j <= $i + 8; $j++){
                        $sheet->cell('A'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('B'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('C'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('D'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('E'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('F'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('G'.($j), function ($cell) {
                            $this->center($cell);
                        });
                    }
                    $sheet->getStyle('A8:G'.($i + 8))->applyFromArray([
                        'borders' => array(
                            'allborders' => array(
                                'style' => \PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    ]);
                    $sheet->appendRow(array(
                        "","","","","",""
                    ));
                    $sheet->appendRow(array(
                        "","","","","",""
                    ));
                    $sheet->appendRow(array(
                        "","","","보고서 작성: . . . . . . . . . . . /____________________/"
                    ));
                    $sheet->setFitToPage(true);
                    $sheet->setScale(80);
                });
            })->download('xls');
        }
    }
 
    public function remove(Request $request){
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        if(!$this->checkAccess("/report/vehicle/remove", $this->enc(session()->get("auth")->userpositionid))){
            return redirect(route($this->redirectAccess));
        }
        if($request->isMethod("POST")){
            $startDate = $request->get("start");
            $endDate = $request->get("end");
            $results = DB::select(DB::raw("SELECT RV.UPDATED_DATE, RV.PLATE_NO, RV.MARK_NAME, RV.MODEL_NAME, RV.CABIN_NO, SU.FIRSTNAME, SU.LASTNAME FROM VRS.REG_VEHICLE_VIEW RV LEFT JOIN SYSTEM_USER SU ON RV.UPDATED_BY = SU.ID WHERE RV.UPDATED_DATE BETWEEN '".$startDate."' AND '".$endDate." 23:59:59' AND RV.STATUS = 9 ORDER BY RV.UPDATED_DATE"));
            return view("Reports.remove", compact( "results", "startDate", "endDate"));
        } else {
            return view("Reports.remove");
        }
    }

    protected function exportToExcelRemove(Request $request){
        $user = $request->route("user");
        $start = $request->route("start");
        $end = $request->route("end");

        if($start != "none" && $end != "none"){
            Excel::create("말소ын тайлан", function($excel) use($user, $start, $end) {
                $excel->setTitle("말소ын тайлан");
                $excel->setCreator("ATUT");
                $excel->sheet("보고서", function($sheet) use($user, $start, $end) {
                    //Header үүсгэх
                    $sheet->setWidth(array(
                        'A'     =>  6,
                        'B'     =>  20,
                        'C'     =>  17,
                        'D'     =>  32,
                        'E'     =>  32,
                        'F'     =>  25,
                        'G'     =>  32
                    ));

                    //로고 입력
                    if (session()->get('auth')->iscity == 1) {
                        $objDrawing = new \PHPExcel_Worksheet_Drawing;
                        $objDrawing->setPath(public_path('/img/niislel.jpg')); //your image path
                        $objDrawing->setCoordinates('B1');
                        $objDrawing->setWidthAndHeight(55, 55);
                        $objDrawing->setWorksheet($sheet);
                        $sheet->setOrientation('landscape');
                        $sheet->appendRow(array("", "", "","","", "수도 자동차운송 차량", ""));
                        $sheet->appendRow(array("", "", "", "","", "등록·관리 센터 ", ""));                
                        $sheet->mergeCells('F1:G1');
                        $sheet->mergeCells('F2:G2');
                } else {
                    $objDrawing = new \PHPExcel_Worksheet_Drawing;
                    $objDrawing->setPath(public_path('/img/logo.png')); //your image path
                    $objDrawing->setCoordinates('A1');
                    $objDrawing->setWidthAndHeight(55, 55);
                    $objDrawing->setWorksheet($sheet);
                    $sheet->setOrientation('landscape');
                    $sheet->appendRow(array("", "", "", "", "", "자동차운송", ""));
                    $sheet->appendRow(array("", "", "", "", "", "국가센터", ""));
                    $sheet->mergeCells('F1:G1');
                    $sheet->mergeCells('F2:G2');
                }
                    $sheet->cell('F1', function ($cell) {
                        $this->cellRight($cell);
                    });
                    $sheet->cell('F2', function ($cell) {
                        $this->cellRight($cell);
                    });
                    $sheet->getStyle('F1')->getFont()->setBold(true);
                    $sheet->getStyle('F2')->getFont()->setBold(true);
                    $sheet->setPaperSize(\PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
                    $sheet->appendRow(array("","","","", "", "", ""));

                    $sheet->appendRow(array('ХАСАГДСАН 차량 -ИЙН ТАЙЛАН'));
                    $sheet->getStyle('A4:G4')->getFont()->setBold(true);
                    $sheet->getStyle('A4:G4')->getFont()->setSize(12);
                    $sheet->mergeCells('A4:G4');
                    $sheet->cell('A4', function ($cell) {
                        $this->center($cell);
                    });
                    $sheet->appendRow(array("","","","", "", "", ""));
                    $sheet->appendRow(array(
                        "", "", "", "", "", "일자: ".$start." -с ".$end
                    ));

                    $sheet->mergeCells('F6:G6');
                    $sheet->getStyle('F6:G6')->getFont()->setBold(true);
                    $sheet->cell('F6', function ($cell) {
                        $this->cellRight($cell);
                    });
                    $sheet->appendRow(array("","","","", "", ""));
                    $sheet->appendRow(array("№", "일자", "말소ын 번호", "브랜드", "모델", "차체번호", "담당자"));
                    $sheet->getStyle('A8:G8')->getFont()->setBold(true);
                    $sheet->getStyle('A8:G8')->getFont()->setSize(12);
                    $this->setPrintMargins($sheet, 0.2, 0.25, 0.2, 0.25);
                    $this->setPrintFitToWidth($sheet);
                    //열 서식 지정
                    $sheet->setColumnFormat(array('0', '@', '@', '@', '@', '@', '@'));
                    //위에서 준비한 Array 값을 Excel 파일로보내기
                    $datas = DB::select(DB::raw("SELECT RV.UPDATED_DATE, RV.PLATE_NO, RV.MARK_NAME, RV.MODEL_NAME, RV.CABIN_NO, SU.FIRSTNAME, SU.LASTNAME FROM VRS.REG_VEHICLE_VIEW RV LEFT JOIN SYSTEM_USER SU ON RV.UPDATED_BY = SU.ID WHERE RV.UPDATED_DATE BETWEEN '".$start."' AND '".$end." 23:59:59' AND RV.STATUS = 9 ORDER BY RV.UPDATED_DATE"));
                    $init = array();
                    $i = 1;
                    foreach ($datas as $data){
                        array_push($init, array($i, Carbon::parse($data->updated_date)->format("Y-m-d H:i:s"), $data->plate_no, $data->mark_name, $data->model_name, $data->cabin_no, $data->firstname." ".$data->lastname));
                        $i++;
                    }
                    $sheet->rows($init);
                    for($j = 8; $j <= $i + 7; $j++){
                        $sheet->cell('A'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('B'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('C'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('D'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('E'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('F'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('G'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('F'.($j), function ($cell) {
                            $this->center($cell);
                        });
                    }
                    $sheet->getStyle('A8:G'.($i + 7))->applyFromArray([
                        'borders' => array(
                            'allborders' => array(
                                'style' => \PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    ]);
                    $sheet->appendRow(array(
                        "","","","","",""
                    ));
                    $sheet->appendRow(array(
                        "","","","","",""
                    ));
                    $sheet->appendRow(array(
                        "","","","보고서 작성: . . . . . . . . . . . /____________________/"
                    ));
                    $sheet->setFitToPage(true);
                    $sheet->setScale(80);
                });
            })->download('xls');
        }
    }


    public function reportAllPlateFactory($startDate, $endDate){
        $data = DB::select(" SELECT count(print_id) as count,factory.print_id,us.firstname,department.name,department.dep_phone as phone,department.dep_address as address
        FROM system_user  us 
        LEFT JOIN system_plate_factory factory ON factory.print_id=us.id
        LEFT JOIN system_department department ON us.userdepartmentid=department.id
        where  factory.is_print=1 and  factory.update_date between TO_DATE ('".$startDate."', 'YYYY-MM-DD')  and TO_DATE ('".$endDate."', 'YYYY-MM-DD')+.9999999 
        and factory.print_id = nvl('', factory.print_id) GROUP BY factory.print_id,us.firstname,department.name,department.dep_phone,department.dep_address
        ");
           
        return $data; 
    }




    public function reportFactoryPlate(Request $request){
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }

        if(!$this->checkAccess("/report/reportFactoryPlate", $this->enc(session()->get("auth")->userpositionid))){
            return redirect(route($this->redirectAccess));
        }

        $departments = Archive::whereNull("deleted_at")->orderBy("ARCHIVE")->get();
        
        $depName = DB::select(
            "SELECT factory.print_id,us.firstname from system_user us LEFT JOIN system_plate_factory factory ON factory.print_id=us.id where print_id is not null
            
            group by factory.print_id,us.firstname order by firstname asc
            ");
           // return  $depName;
        if($request->isMethod("POST")){
            $curr_dep = $request->get("department");
            $startDate = $request->startDate;
            $endDate = $request->endDate;
            $plateNo = $request->plateNo;
            
            $eq = "='".$curr_dep."'";
            if($curr_dep == "0"){
                $eq = "!='".$curr_dep."'";
            }

            $results = DB::select(DB::raw(" SELECT factory.update_date,factory.platecolor,factory.print_id,factory.plate_no ,us.firstname,department.name,department.dep_license_number,department.dep_license_start_date,
           department.dep_license_end_date,department.dep_register,department.dep_director ,department.dep_phone as phone,department.dep_address as address
                           FROM system_user  us 
                           LEFT JOIN system_plate_factory factory ON factory.print_id=us.id
                           LEFT JOIN system_department department ON us.userdepartmentid=department.id
                           where factory.plate_no='".$plateNo."' and factory.is_print=1 and  factory.update_date between TO_DATE ('".$startDate."', 'YYYY-MM-DD')  and TO_DATE ('".$endDate."', 'YYYY-MM-DD')+.9999999"
           ));
         // return $results;
          // dd($results);
            return view('Reports.reportFactoryPlate', compact('departments','depName', 'results','startDate','endDate'));
        } else {
            return view('Reports.reportFactoryPlate', compact('departments','depName'));
        }
    }
    public function reportFactory(Request $request){
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }

        if(!$this->checkAccess("/report/reportFactory", $this->enc(session()->get("auth")->userpositionid))){
            return redirect(route($this->redirectAccess));
        }

        $departments = Archive::whereNull("deleted_at")->orderBy("ARCHIVE")->get();
        
        $depName = DB::select(
            "SELECT factory.print_id,us.firstname from system_user us LEFT JOIN system_plate_factory factory ON factory.print_id=us.id where print_id is not null
            
            group by factory.print_id,us.firstname order by firstname asc
            ");
           // return  $depName;
        if($request->isMethod("POST")){
            $curr_dep = $request->get("department");
            $startDate = $request->startDate;
            $endDate = $request->endDate;
            $departUser = $request->depUser;
            
            $eq = "='".$curr_dep."'";
            if($curr_dep == "0"){
                $eq = "!='".$curr_dep."'";
            }

            $results = DB::select(DB::raw(
                " SELECT count(print_id) as count,factory.print_id,us.firstname,department.name,department.dep_phone as phone,department.dep_address as address
                FROM system_user  us 
                LEFT JOIN system_plate_factory factory ON factory.print_id=us.id
                LEFT JOIN system_department department ON us.userdepartmentid=department.id
                where  factory.is_print=1 and  factory.update_date between TO_DATE ('".$startDate."', 'YYYY-MM-DD')  and TO_DATE ('".$endDate."', 'YYYY-MM-DD')+.9999999 
                and factory.print_id = nvl('".$departUser."', factory.print_id) GROUP BY factory.print_id,us.firstname,department.name,department.dep_phone,department.dep_address
                 "));
         // return $results;
          // dd($results);
            return view('Reports.reportFactory', compact('departments','depName', 'results','startDate','endDate'));
        } else {
            return view('Reports.reportFactory', compact('departments','depName'));
        }
    }
 

            public function reportFactoryView(Request $request){
           
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }

        if(!$this->checkAccess("/report/reportFactory", $this->enc(session()->get("auth")->userpositionid))){
            return redirect(route($this->redirectAccess));
        }
        // if($request->isMethod("POST")){

            $startDate = $request->startDate;
            $endDate = $request->endDate;
            $departUser = $request->print_id;
          //  return $departUser;
            $resultsFactoryView = DB::select(DB::raw(
                " SELECT factory.update_date,factory.platecolor,factory.print_id,factory.plate_no ,us.firstname,department.name,department.dep_license_number,department.dep_license_start_date,
                department.dep_license_end_date,department.dep_register,department.dep_director ,department.dep_phone as phone,department.dep_address as address
                                FROM system_user  us 
                                LEFT JOIN system_plate_factory factory ON factory.print_id=us.id
                                LEFT JOIN system_department department ON us.userdepartmentid=department.id
                                where  factory.is_print=1 and  factory.update_date between TO_DATE ('".$startDate."', 'YYYY-MM-DD')  and TO_DATE ('".$endDate."', 'YYYY-MM-DD')+.9999999 
                                and factory.print_id = nvl('".$departUser."', factory.print_id) "));
                                
              return $resultsFactoryView;
                               //return view('Reports.reportFactory', compact( 'resultsFactoryView','startDate','endDate'));
       // }

                }



                public function reportPlateSave(Request $request){
                    if(!session()->has("auth")){
                        return redirect(route($this->redirectURL));
                    }
            
                    // if(!$this->checkAccess("/report/plateSave", $this->enc(session()->get("auth")->userpositionid))){
                    //     return redirect(route($this->redirectAccess));
                    // } 
            
                    $departments = Archive::whereNull("deleted_at")->orderBy("ARCHIVE")->get();
                    
                
                       // return  $depName;
                 
                    if($request->isMethod("POST")){
                      //  return $request;
                        $curr_dep = $request->get("department");
                        $startDate = $request->startDate;
                        $endDate = $request->endDate;
                        $plateColor = $request->plateColor;
                       // return $request;
                        $eq = "='".$curr_dep."'";
                        if($curr_dep == "0"){
                            $eq = "!='".$curr_dep."'";
                        }
            
                        // $results = DB::select(DB::raw(
                        //     " SELECT count(print_id) as count,factory.print_id,us.firstname,department.name,department.dep_phone as phone,department.dep_address as address
                        //     FROM system_user  us 
                        //     LEFT JOIN system_plate_factory factory ON factory.print_id=us.id
                        //     LEFT JOIN system_department department ON us.userdepartmentid=department.id
                        //     where  factory.is_print=1 and  factory.update_date between TO_DATE ('".$startDate."', 'YYYY-MM-DD')  and TO_DATE ('".$endDate."', 'YYYY-MM-DD')+.9999999 
                        //     and factory.print_id = nvl('".$departUser."', factory.print_id) GROUP BY factory.print_id,us.firstname,department.name,department.dep_phone,department.dep_address
                        //      "));
                             $results = DB::select(DB::raw(
                                "SELECT REG_PLATENUMBER_SAVE.plate_no, REG_PLATENUMBER_SAVE.ARCHIVE_NUMBER , REG_PLATENUMBER_SAVE.IS_ACTIVE,REG_PLATENUMBER_SAVE.CUSTOMER_LASTNAME,REG_PLATENUMBER_SAVE.CUSTOMER_FIRSTNAME,
                                REG_PLATENUMBER_SAVE.CUSTOMER_PHONE,REG_PLATENUMBER_SAVE.CUSTOMER_REGNUM,REG_PLATENUMBER_SAVE.BEGIN_DATE,REG_PLATENUMBER_SAVE.END_DATE,REG_PLATENUMBER_SAVE.EXTEND_COUNT,
                                                        to_char(REG_PLATENUMBER_SAVE.create_date, 'YYYY-MM-DD') as create_date,SU.LASTNAME,SU.FIRSTNAME from REG_PLATENUMBER_SAVE LEFT JOIN SYSTEM_USER SU ON REG_PLATENUMBER_SAVE.CREATED_BY = SU.ID
                        where  REG_PLATENUMBER_SAVE.create_date  between TO_DATE ('".$startDate."', 'YYYY-MM-DD')  and TO_DATE ('".$endDate."', 'YYYY-MM-DD')+.9999999    ORDER BY REG_PLATENUMBER_SAVE.create_date DESC
                                 "));
                     // return $results;
                     //  dd($results);
                        return view('Reports.reportPlateSave', compact('departments','plateColor', 'results','startDate','endDate'));
                    } else {
                              $results = DB::select(DB::raw(
                        " SELECT REG_PLATENUMBER_SAVE.plate_no, REG_PLATENUMBER_SAVE.ARCHIVE_NUMBER , REG_PLATENUMBER_SAVE.IS_ACTIVE,REG_PLATENUMBER_SAVE.CUSTOMER_LASTNAME,REG_PLATENUMBER_SAVE.CUSTOMER_FIRSTNAME,
                        REG_PLATENUMBER_SAVE.CUSTOMER_PHONE,REG_PLATENUMBER_SAVE.CUSTOMER_REGNUM,REG_PLATENUMBER_SAVE.BEGIN_DATE,REG_PLATENUMBER_SAVE.END_DATE,REG_PLATENUMBER_SAVE.EXTEND_COUNT,
                                                to_char(REG_PLATENUMBER_SAVE.create_date, 'YYYY-MM-DD') as create_date,SU.LASTNAME,SU.FIRSTNAME from REG_PLATENUMBER_SAVE LEFT JOIN SYSTEM_USER SU ON REG_PLATENUMBER_SAVE.CREATED_BY = SU.ID
                                                  ORDER BY REG_PLATENUMBER_SAVE.create_date DESC  FETCH NEXT 10000 ROWS ONLY
                         "));
                        return view('Reports.reportPlateSave', compact('departments','results'));
                    }
                }

                protected function exportToExcelPlateSave(Request $request){
              
            
                    //  return $endDate;
             
                   //   $plateColor = $request->route("type");
         
                   
                  
                    $startDate = $request->route("startDate");
                    $endDate = $request->route("endDate");
         //   return $plateColor;
                    if($startDate != "none" && $endDate != "none"){
                        Excel::create("Дугаарын хадаглалт тайлан", function($excel) use( $startDate, $endDate) {
                            $excel->setTitle("Дугаарын хадаглалт тайлан");
                            $excel->setCreator("ATUT");
                            $excel->sheet("보고서", function($sheet) use( $startDate, $endDate) {
                                //Header үүсгэх
                                $sheet->setWidth(array(
                                    'A'     =>  6,
                                    'B'     =>  20,
                                    'C'     =>  17,
                                    'D'     =>  32,
                              
                                  
                                ));
            
                                //로고 입력
                                if (session()->get('auth')->iscity == 1) {
                                    $objDrawing = new \PHPExcel_Worksheet_Drawing;
                                    $objDrawing->setPath(public_path('/img/niislel.jpg')); //your image path
                                    $objDrawing->setCoordinates('B1');
                                    $objDrawing->setWidthAndHeight(55, 55);
                                    $objDrawing->setWorksheet($sheet);
                                    $sheet->setOrientation('landscape');
                                    $sheet->appendRow(array("", "", "","","", "수도 자동차운송 차량", ""));
                                    $sheet->appendRow(array("", "", "", "","", "등록·관리 센터 ", ""));                
                                    $sheet->mergeCells('F1:G1');
                                    $sheet->mergeCells('F2:G2');
                            } else {
                                $objDrawing = new \PHPExcel_Worksheet_Drawing;
                                $objDrawing->setPath(public_path('/img/logo.png')); //your image path
                                $objDrawing->setCoordinates('A1');
                                $objDrawing->setWidthAndHeight(55, 55);
                                $objDrawing->setWorksheet($sheet);
                                $sheet->setOrientation('landscape');
                                $sheet->appendRow(array("", "", "", "", "", "자동차운송", ""));
                                $sheet->appendRow(array("", "", "", "", "", "국가센터", ""));
                                $sheet->mergeCells('F1:G1');
                                $sheet->mergeCells('F2:G2');
                            }
                                $sheet->cell('F1', function ($cell) {
                                    $this->cellRight($cell);
                                });
                                $sheet->cell('F2', function ($cell) {
                                    $this->cellRight($cell);
                                });
                                $sheet->getStyle('F1')->getFont()->setBold(true);
                                $sheet->getStyle('F2')->getFont()->setBold(true);
                                $sheet->setPaperSize(\PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
                                $sheet->appendRow(array("","","","", "", "", ""));
            
                                $sheet->appendRow(array('ДУГААРЫН ХАДАГЛАЛТ ТАЙЛАН'));
                                $sheet->getStyle('A4:G4')->getFont()->setBold(true);
                                $sheet->getStyle('A4:G4')->getFont()->setSize(12);
                                $sheet->mergeCells('A4:G4');
                                $sheet->cell('A4', function ($cell) {
                                    $this->center($cell);
                                });
                                $sheet->appendRow(array("","","","", "", ""));
                                $sheet->appendRow(array(
                                    "", "", "", "", "", "일자: ".$startDate." -с ".$endDate
                                ));
            
                                $sheet->mergeCells('F6:G6');
                                $sheet->getStyle('F6:G6')->getFont()->setBold(true);
                                $sheet->cell('F6', function ($cell) {
                                    $this->cellRight($cell);
                                });
                                $sheet->appendRow(array("","","","", "", ""));
                                $sheet->appendRow(array("№", "Хадгалсан", "Захиалсан", "개수"));
                                $sheet->getStyle('A8:G8')->getFont()->setBold(true);
                                $sheet->getStyle('A8:G8')->getFont()->setSize(12);
                                $this->setPrintMargins($sheet, 0.2, 0.25, 0.2, 0.25);
                                $this->setPrintFitToWidth($sheet);
                                //열 서식 지정
                                $sheet->setColumnFormat(array('0', '@', '@', '@','@'));
                                //위에서 준비한 Array 값을 Excel 파일로보내기
                                $datas = DB::select(DB::raw("SELECT COUNT(CASE WHEN is_active > 0 then 1 end) as active,COUNT(CASE WHEN is_active < 1 then 1 end) as noneactive, to_char(REG_PLATENUMBER_SAVE.create_date, 'YYYY-MM-DD') as create_at  from REG_PLATENUMBER_SAVE 
                        where  REG_PLATENUMBER_SAVE.create_date  between TO_DATE ('".$startDate."', 'YYYY-MM-DD')  and TO_DATE ('".$endDate."', 'YYYY-MM-DD')+.9999999 GROUP BY to_char(REG_PLATENUMBER_SAVE.create_date, 'YYYY-MM-DD')
                                       "));
                                $init = array();
                                $i = 1;
                               
                                $sum = array(0,0,0,0);
                                 foreach ($datas as $data){
                                    $i++;
                                     array_push($init, array($i,  $data->active,
                                      $data->noneactive,  $data->create_at));
                                    
                               
  
                                 $sum[1] += $data->active;
                                 $sum[2] += $data->noneactive;
                                 }
                                $sheet->rows($init);
                                for($j = 8; $j <= $i +7; $j++){
                                    $sheet->cell('A'.($j), function ($cell) {
                                        $this->center($cell);
                                    });
                                    $sheet->cell('B'.($j), function ($cell) {
                                        $this->center($cell);
                                    });
                                    $sheet->cell('C'.($j), function ($cell) {
                                        $this->center($cell);
                                    });
                                    $sheet->cell('D'.($j), function ($cell) {
                                        $this->center($cell);
                                    });
                                    $sheet->cell('E'.($j), function ($cell) {
                                        $this->center($cell);
                                    });
                                    $sheet->cell('F'.($j), function ($cell) {
                                        $this->center($cell);
                                    });
                                    $sheet->cell('G'.($j), function ($cell) {
                                        $this->center($cell);
                                    });
                             
                                }
                                $sheet->appendRow(array(
                                  "합계",
                                

                                  $sum[1],
                                  $sum[2],
                                  "",

                                  "",
                               
                          
                                
                               
                              ));
                                $sheet->getStyle('A8:G'.($i + 8))->applyFromArray([
                                    'borders' => array(
                                        'allborders' => array(
                                            'style' => \PHPExcel_Style_Border::BORDER_THIN
                                        )
                                    )
                                ]);
                                $sheet->appendRow(array(
                                    "","","","","",""
                                ));
                                $sheet->appendRow(array(
                                    "","","","","",""
                                ));
                                $sheet->appendRow(array(
                                    "","","","보고서 작성: . . . . . . . . . . . /____________________/"
                                ));
                                $sheet->setFitToPage(true);
                                $sheet->setScale(80);
                            });
                        })->download('xls');
                    }
                  }











                public function reportFactoryColor(Request $request){
                    if(!session()->has("auth")){
                        return redirect(route($this->redirectURL));
                    }
            
                    if(!$this->checkAccess("/report/reportFactoryColor", $this->enc(session()->get("auth")->userpositionid))){
                        return redirect(route($this->redirectAccess));
                    } 
            
                    $departments = Archive::whereNull("deleted_at")->orderBy("ARCHIVE")->get();
                    
                    $depName = DB::select("SELECT factory.print_id,us.firstname from system_user us LEFT JOIN system_plate_factory factory ON factory.print_id=us.id where print_id is not null
                        group by factory.print_id,us.firstname order by firstname asc");
                       // return  $depName;
                 
                    if($request->isMethod("POST")){
                      //  return $request;
                        $curr_dep = $request->get("department");
                        $startDate = $request->startDate;
                        $endDate = $request->endDate;
                        $plateColor = $request->plateColor;
                       // return $request;
                        $eq = "='".$curr_dep."'";
                        if($curr_dep == "0"){
                            $eq = "!='".$curr_dep."'";
                        }
            
                        // $results = DB::select(DB::raw(
                        //     " SELECT count(print_id) as count,factory.print_id,us.firstname,department.name,department.dep_phone as phone,department.dep_address as address
                        //     FROM system_user  us 
                        //     LEFT JOIN system_plate_factory factory ON factory.print_id=us.id
                        //     LEFT JOIN system_department department ON us.userdepartmentid=department.id
                        //     where  factory.is_print=1 and  factory.update_date between TO_DATE ('".$startDate."', 'YYYY-MM-DD')  and TO_DATE ('".$endDate."', 'YYYY-MM-DD')+.9999999 
                        //     and factory.print_id = nvl('".$departUser."', factory.print_id) GROUP BY factory.print_id,us.firstname,department.name,department.dep_phone,department.dep_address
                        //      "));
                             $results = DB::select(DB::raw(
                                " SELECT reg_vehicle_view.province_name, reg_vehicle_view.first_name,  count(platecolor) as count,platecolor,to_char(create_date, 'YYYY-MM-DD') as create_date from system_plate_factory  INNER JOIN reg_vehicle_view   ON system_plate_factory.plate_no = reg_vehicle_view.plate_no 
                        where platecolor  is not null and  create_date  between TO_DATE ('".$startDate."', 'YYYY-MM-DD')  and TO_DATE ('".$endDate."', 'YYYY-MM-DD')+.9999999   and platecolor = nvl('".$plateColor."', platecolor) GROUP BY reg_vehicle_view.first_name,reg_vehicle_view.province_name, platecolor,to_char(create_date, 'YYYY-MM-DD')  ORDER BY create_date DESC
                                 "));
                     // return $results;
                     //  dd($results);
                        return view('Reports.reportPlateColor', compact('departments','plateColor','depName', 'results','startDate','endDate'));
                    } else {
                              $results = DB::select(DB::raw(
                        " SELECT reg_vehicle_view.province_name,reg_vehicle_view.first_name, count(platecolor) as count,platecolor,to_char(create_date, 'YYYY-MM-DD') as create_date from system_plate_factory INNER JOIN reg_vehicle_view   ON system_plate_factory.plate_no = reg_vehicle_view.plate_no 
                        where   platecolor
                         is not null  GROUP BY reg_vehicle_view.first_name,reg_vehicle_view.province_name,
                   platecolor,to_char(create_date, 'YYYY-MM-DD')  ORDER BY create_date DESC  FETCH NEXT 1000 ROWS ONLY
                         "));
                        return view('Reports.reportPlateColor', compact('departments','depName','results'));
                    }
                }
       protected function exportToExcelFlateColor(Request $request){
              
            
                  //  return $endDate;
           
                    $plateColor = $request->route("type");
       
                 
                
                  $startDate = $request->route("startDate");
                  $endDate = $request->route("endDate");
       //   return $plateColor;
                  if($startDate != "none" && $endDate != "none"){
                      Excel::create("Дугаарын өнгө тайлан", function($excel) use($plateColor, $startDate, $endDate) {
                          $excel->setTitle("Дугаарын өнгө тайлан");
                          $excel->setCreator("ATUT");
                          $excel->sheet("보고서", function($sheet) use($plateColor, $startDate, $endDate) {
                              //Header үүсгэх
                              $sheet->setWidth(array(
                                  'A'     =>  6,
                                  'B'     =>  20,
                                  'C'     =>  17,
                                  'D'     =>  32,
                                  'E'     =>  32,
                                  'F'     =>  25,
                                
                              ));
          
                              //로고 입력
                              if (session()->get('auth')->iscity == 1) {
                                $objDrawing = new \PHPExcel_Worksheet_Drawing;
                                $objDrawing->setPath(public_path('/img/niislel.jpg')); //your image path
                                $objDrawing->setCoordinates('B1');
                                $objDrawing->setWidthAndHeight(55, 55);
                                $objDrawing->setWorksheet($sheet);
                                $sheet->setOrientation('landscape');
                                $sheet->appendRow(array("", "", "","","", "수도 자동차운송 차량", ""));
                                $sheet->appendRow(array("", "", "", "","", "등록·관리 센터 ", ""));                
                                $sheet->mergeCells('F1:G1');
                                $sheet->mergeCells('F2:G2');
                        } else {
                              $objDrawing = new \PHPExcel_Worksheet_Drawing;
                              $objDrawing->setPath(public_path('/img/logo.png')); //your image path
                              $objDrawing->setCoordinates('A1');
                              $objDrawing->setWidthAndHeight(55, 55);
                              $objDrawing->setWorksheet($sheet);
                              $sheet->setOrientation('landscape');
                              $sheet->appendRow(array("", "", "", "", "", "자동차운송", ""));
                              $sheet->appendRow(array("", "", "", "", "", "국가센터", ""));
                              $sheet->mergeCells('F1:G1');
                              $sheet->mergeCells('F2:G2');
                        }
                              $sheet->cell('F1', function ($cell) {
                                  $this->cellRight($cell);
                              });
                              $sheet->cell('F2', function ($cell) {
                                  $this->cellRight($cell);
                              });
                              $sheet->getStyle('F1')->getFont()->setBold(true);
                              $sheet->getStyle('F2')->getFont()->setBold(true);
                              $sheet->setPaperSize(\PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
                              $sheet->appendRow(array("","","","", "", ""));
          
                              $sheet->appendRow(array('ДУГААРЫН ӨНГӨ ТАЙЛАН'));
                              $sheet->getStyle('A4:G4')->getFont()->setBold(true);
                              $sheet->getStyle('A4:G4')->getFont()->setSize(12);
                              $sheet->mergeCells('A4:G4');
                              $sheet->cell('A4', function ($cell) {
                                  $this->center($cell);
                              });
                              $sheet->appendRow(array("","","","", "",""));
                              $sheet->appendRow(array(
                                  "", "", "", "", "", "일자: ".$startDate." -с ".$endDate
                              ));
          
                              $sheet->mergeCells('F6:H6');
                              $sheet->getStyle('F6:H6')->getFont()->setBold(true);
                              $sheet->cell('F6', function ($cell) {
                                  $this->cellRight($cell);
                              });
                              $sheet->appendRow(array("","","","", "",""));
                              $sheet->appendRow(array("№", "지점", "차량-н төрөл","이름", "색상","개수", "일자"));
                              $sheet->getStyle('A8:G8')->getFont()->setBold(true);
                              $sheet->getStyle('A8:G8')->getFont()->setSize(12);
                              $this->setPrintMargins($sheet, 0.2, 0.25, 0.2, 0.25);
                              $this->setPrintFitToWidth($sheet);
                              //열 서식 지정
                              $sheet->setColumnFormat(array('0', '@', '@', '@', '@','@'));
                              //위에서 준비한 Array 값을 Excel 파일로보내기
                              $datas = DB::select(DB::raw(" SELECT reg_vehicle_view.province_name,reg_vehicle_view.purpose_name,reg_vehicle_view.first_name,  count(platecolor) as count,
                              platecolor,to_char(create_date, 'YYYY-MM-DD') as create_date 
                              from system_plate_factory  INNER JOIN reg_vehicle_view   ON system_plate_factory.plate_no = reg_vehicle_view.plate_no 
                              where platecolor  is not null and 
                              create_date  between TO_DATE ('".$startDate."', 'YYYY-MM-DD')  and TO_DATE ('".$endDate."', 'YYYY-MM-DD')+.9999999  
                              and platecolor = nvl('".$plateColor."', platecolor) GROUP BY to_char(create_date, 'YYYY-MM-DD'),reg_vehicle_view.province_name,reg_vehicle_view.purpose_name,platecolor,reg_vehicle_view.first_name ORDER BY create_date DESC
                                     "));
                            //   $datas = DB::select(DB::raw(" SELECT reg_vehicle_view.province_name, reg_vehicle_view.first_name,  count(platecolor) as count,platecolor,to_char(create_date, 'YYYY-MM-DD') as create_date from system_plate_factory  INNER JOIN reg_vehicle_view   ON system_plate_factory.plate_no = reg_vehicle_view.plate_no 
                            //   where platecolor  is not null and  create_date  between TO_DATE ('".$startDate."', 'YYYY-MM-DD')  and TO_DATE ('".$endDate."', 'YYYY-MM-DD')+.9999999   and platecolor = nvl('".$plateColor."', platecolor) GROUP BY reg_vehicle_view.first_name,reg_vehicle_view.province_name, platecolor,to_char(create_date, 'YYYY-MM-DD')  ORDER BY create_date DESC
                            //          "));
                              $init = array();
                              $i = 1;
                              $color = "";
                              $sum = array(0,0,0,0,0,0,0);
                              foreach ($datas as $data){
                                switch ($data->platecolor) {
                                    case 1:
                                      $color= "흰색";
                                        break;
                                    case 2:
                                      $color= "노랑";
                                        break;
                                    case 3:
                                      $color= "녹색";
                                        break;
                                    case 4:
                                      $color= "빨강";
                                        break;
                                    case 5:
                                      $color= "검정";
                                        break;
                                    case 6:
                                      $color= "파랑";
                                        break;
                                   
                                    
                                    default:
                                        # code...
                                        break;
                                  }
                                  array_push($init, array($i,  $data->province_name,
                                   $data->purpose_name,$data->first_name, $color, $data->count, $data->create_date));
                                  $i++;
                             

                                  $sum[4] += $data->count;
                              }
                              $sheet->rows($init);
                              for($j = 8; $j <= $i +7; $j++){
                                  $sheet->cell('A'.($j), function ($cell) {
                                      $this->center($cell);
                                  });
                                  $sheet->cell('B'.($j), function ($cell) {
                                      $this->center($cell);
                                  });
                                  $sheet->cell('C'.($j), function ($cell) {
                                      $this->center($cell);
                                  });
                                  $sheet->cell('D'.($j), function ($cell) {
                                      $this->center($cell);
                                  });
                                  $sheet->cell('E'.($j), function ($cell) {
                                      $this->center($cell);
                                  });
                                  $sheet->cell('F'.($j), function ($cell) {
                                      $this->center($cell);
                                  });
                                  $sheet->cell('G'.($j), function ($cell) {
                                      $this->center($cell);
                                  });
                                
                              
                           
                              }
                              $sheet->appendRow(array(
                                "합계",
                                "",
                                "",
                                "",
                                "",
                                $sum[4],
                                "",
                              
                             
                            ));
                              $sheet->getStyle('A8:G'.($i + 8))->applyFromArray([
                                  'borders' => array(
                                      'allborders' => array(
                                          'style' => \PHPExcel_Style_Border::BORDER_THIN
                                      )
                                  )
                              ]);
                              $sheet->appendRow(array(
                                  "","","","","",""
                              ));
                              $sheet->appendRow(array(
                                  "","","","","",""
                              ));
                              $sheet->appendRow(array(
                                  "","","","보고서 작성: . . . . . . . . . . . /____________________/"
                              ));
                              $sheet->setFitToPage(true);
                              $sheet->setScale(80);
                          });
                      })->download('xls');
                  }
                }
    public function indexDepartment(Request $request){
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }

        if(!$this->checkAccess("/report/daily/department", $this->enc(session()->get("auth")->userpositionid))){
            return redirect(route($this->redirectAccess));
        }

        $departments = Archive::whereNull("deleted_at")->orderBy("ARCHIVE")->get();
        if($request->isMethod("POST")){
            $curr_dep = $request->get("department");
            $startDate = $request->get("start");
            $endDate = $request->get("end");

            $eq = "='".$curr_dep."'";
            if($curr_dep == "0"){
                $eq = "!='".$curr_dep."'";
            }

            $results = DB::select(DB::raw(
                "SELECT ARCHIVE_ABBR, to_char(CREATED_DATE, 'YYYY-MM-DD') ARCHIVE_DATE, 
                0  NEW_V ,	
                COUNT (CASE  WHEN INSERT_SERVICE_ID = 3  THEN 1  END) MOVE_V ,	
                COUNT (CASE  WHEN INSERT_SERVICE_ID =14  THEN 1  END) MOVE_PLATE_V , 
                COUNT (CASE  WHEN INSERT_SERVICE_ID =13  THEN 1  END) CERT_CHANGE_V ,
                COUNT (CASE  WHEN INSERT_SERVICE_ID =2  THEN 1  END) CERT_AGAIN_V ,
                COUNT (CASE  WHEN INSERT_SERVICE_ID =12  THEN 1  END) LIMIT_V ,
                COUNT (CASE  WHEN INSERT_SERVICE_ID =9  THEN 1  END) REMOVE_V ,
                COUNT (CASE  WHEN INSERT_SERVICE_ID =15  THEN 1  END) CHANGE_PLATE_V ,
                COUNT (CASE  WHEN INSERT_SERVICE_ID =16  THEN 1  END) CHANGE_PLATE_TWO_V ,
                COUNT (CASE  WHEN INSERT_SERVICE_ID =8  THEN 1  END) EDIT_V,
                COUNT (CASE  WHEN INSERT_SERVICE_ID =5  THEN 1  END) DELETE_PLATE,
                COUNT (CASE  WHEN INSERT_SERVICE_ID =19  THEN 1  END) RESTORE_PLATE,
                COUNT (CASE  WHEN INSERT_SERVICE_ID =6  THEN 1  END) PRINT_V 
                FROM REG_VEHICLE_ARCHIVE WHERE ARCHIVE_ABBR".$eq." AND CREATED_DATE BETWEEN '".$startDate."' AND '".$endDate." 23:59:59'  
                GROUP BY to_char(CREATED_DATE, 'YYYY-MM-DD'),ARCHIVE_ABBR ORDER BY ARCHIVE_DATE"
            ));

            $results1 = DB::select(DB::raw("SELECT ARCHIVE_ABBR, to_char(UPDATED_DATE, 'YYYY-MM-DD') ARCHIVE_DATE, COUNT(CASE WHEN STATUS=1 THEN 1 END) NEW_V FROM REG_VEHICLE_ARCHIVE WHERE ARCHIVE_ABBR".$eq." AND UPDATED_DATE BETWEEN '".$startDate."' AND '".$endDate." 23:59:59' GROUP BY to_char(UPDATED_DATE, 'YYYY-MM-DD'),ARCHIVE_ABBR ORDER BY ARCHIVE_DATE"));
            foreach ($results as $result){
                foreach ($results1 as $r){
                    if($result->archive_abbr == $r->archive_abbr && $result->archive_date == $r->archive_date){
                        $result->new_v += $r->new_v;
                    }
                }
            } 
            return view('Reports.department', compact('departments', 'results', 'curr_dep', 'startDate', 'endDate'));
        } else {
            return view('Reports.department', compact('departments'));
        }
    }


    protected function exportToExcelDepartment(Request $request){
        $department = $request->route("department");
        $start = $request->route("start");
        $end = $request->route("end");
        if($department != "none" && $start != "none" && $end != "none"){
            Excel::create("지점ын тайлан", function($excel) use($department, $start, $end) {
                $excel->setTitle("지점ын тайлан");
                $excel->setCreator("ATUT");
                $excel->sheet("보고서", function($sheet) use($department, $start, $end) {
                    //Header үүсгэх
                    $sheet->setWidth(array(
                        'A'     =>  5,
                        'B'     =>  24,
                        'C'     =>  12,
                        'D'     =>  8,
                        'E'     =>  12,
                        'F'     =>  15,
                        'G'     =>  12,
                        'H'     =>  12,
                        'I'     =>  14,
                        'J'     =>  10,
                        'K'     =>  12,
                        'L'     =>  15,
                        'M'     =>  10,
                        'N'     =>  10,
                        'O'     =>  12,
                        'P'     =>  12
                    ));

                    //로고 입력
                    if (session()->get('auth')->iscity == 1) {
                        $objDrawing = new \PHPExcel_Worksheet_Drawing;
                        $objDrawing->setPath(public_path('/img/niislel.jpg')); //your image path
                        $objDrawing->setCoordinates('B1');
                        $objDrawing->setWidthAndHeight(55, 55);
                        $objDrawing->setWorksheet($sheet);
                        $sheet->setOrientation('landscape');
                        $sheet->appendRow(array("", "", "", "", "", "", "", "", "", "", "", "", "",  "수도 자동차운송 차량","", ""));
                        $sheet->appendRow(array("", "", "", "", "", "", "", "", "", "", "", "", "","등록·관리 센터 ","", ""));                
                        $sheet->mergeCells('M1:P1');
                        $sheet->mergeCells('M2:P2');
                } else {
                    $objDrawing = new \PHPExcel_Worksheet_Drawing;
                    $objDrawing->setPath(public_path('/img/logo.png')); //your image path
                    $objDrawing->setCoordinates('B1');
                    $objDrawing->setWidthAndHeight(55, 55);
                    $objDrawing->setWorksheet($sheet);
                    $sheet->setOrientation('landscape');
                    $sheet->appendRow(array("", "", "", "", "", "", "", "", "", "", "", "", "", "자동차운송", "", ""));
                    $sheet->appendRow(array("", "", "", "", "", "", "", "", "", "", "", "", "", "국가센터", "", ""));
                    $sheet->mergeCells('M1:P1');
                    $sheet->mergeCells('M2:P2');
                }
                    $sheet->cell('M1', function ($cell) {
                        $this->cellRight($cell);
                    });
                    $sheet->cell('M2', function ($cell) {
                        $this->cellRight($cell);
                    });
                    $sheet->getStyle('M1')->getFont()->setBold(true);
                    $sheet->getStyle('M2')->getFont()->setBold(true);
                    $sheet->setPaperSize(\PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
                    $sheet->appendRow(array("","","","", "", "", ""));

                    $sheet->appendRow(array('САЛБАРЫН ТАЙЛАН'));
                    $sheet->getStyle('A4:P4')->getFont()->setBold(true);
                    $sheet->getStyle('A4:P4')->getFont()->setSize(12);
                    $sheet->mergeCells('A4:P4');
                    $sheet->cell('P4', function ($cell) {
                        $this->center($cell);
                    });

                    $sheet->cell('P1', function ($cell) {
                        $this->cellRight($cell);
                    });

                    $sheet->cell('N2', function ($cell) {
                        $this->cellRight($cell);
                    });

                    if($department == "0"){
                        $name = "Бүх салбар";
                    } else {
                        $names = Archive::where("ABBR", $department)->get()->first();
                        $name = $names->archive;
                    }

                    $sheet->appendRow(array(
                        "지점ын нэр: ".$name, "", "", "", "", "", "", "", "", "", "", "", "", "일자: ".$start." - ".$end, ""
                    ));
                    $sheet->mergeCells('A5:D5');
                    $sheet->mergeCells('N5:P5');

                    $sheet->getStyle('A5:D5')->getFont()->setBold(true);
                    $sheet->getStyle('N5:P5')->getFont()->setBold(true);

                    $sheet->appendRow(array(
                        "№",
                        "지점",
                        "일자",
                        "신규",
                        "이전",
                        "번호판 교체 이전",
                        "증명서 교체",
                        "증명서 갱신",
                        "제한 사항",
                        "말소",
                        "번호판 교체",
                        "번호판 간 교체",
                        "인쇄",
                        "수정",
                        "문자 말소",
                        "말소에서 복구됨"
                    ));

                    $this->setPrintMargins($sheet, 0.5, 0.1, 0.5, 0.1);
                    //$this->setPrintFitToWidth($sheet);
                    $this->parseCssProperties($sheet, "F", "6", "wrap-text", "true");
                    $this->parseCssProperties($sheet, "E", "6", "wrap-text", "true");
                    $this->parseCssProperties($sheet, "G", "6", "wrap-text", "true");
                    $this->parseCssProperties($sheet, "K", "6", "wrap-text", "true");
                    $this->parseCssProperties($sheet, "N", "6", "wrap-text", "true");
                    $this->parseCssProperties($sheet, "H", "6", "wrap-text", "true");
                    $this->parseCssProperties($sheet, "L", "6", "wrap-text", "true");
                    $this->parseCssProperties($sheet, "O", "6", "wrap-text", "true");
                    $this->parseCssProperties($sheet, "P", "6", "wrap-text", "true");

                    $sheet->getStyle('A6:P6')->getFont()->setBold(true);
                    $sheet->getStyle('A6:P6')->getFont()->setSize(12);

                    $eq = "='".$department."'";
                    if($department == "0"){
                        $eq = "!='".$department."'";
                    }

                    $datas = DB::select(DB::raw(
                        "SELECT ARCHIVE_ABBR, to_char(CREATED_DATE, 'YYYY-MM-DD') ARCHIVE_DATE, 
                        0  NEW_V ,	
                        COUNT (CASE  WHEN SERVICE_ID = 3  THEN 1  END) MOVE_V ,	
                        COUNT (CASE  WHEN INSERT_SERVICE_ID =14  THEN 1  END) MOVE_PLATE_V , 
                        COUNT (CASE  WHEN INSERT_SERVICE_ID =13  THEN 1  END) CERT_CHANGE_V ,
                        COUNT (CASE  WHEN INSERT_SERVICE_ID =2  THEN 1  END) CERT_AGAIN_V ,
                        COUNT (CASE  WHEN INSERT_SERVICE_ID =12  THEN 1  END) LIMIT_V ,
                        COUNT (CASE  WHEN INSERT_SERVICE_ID =9  THEN 1  END) REMOVE_V ,
                        COUNT (CASE  WHEN INSERT_SERVICE_ID =15  THEN 1  END) CHANGE_PLATE_V ,
                        COUNT (CASE  WHEN INSERT_SERVICE_ID =16  THEN 1  END) CHANGE_PLATE_TWO_V ,
                        COUNT (CASE  WHEN INSERT_SERVICE_ID =8  THEN 1  END) EDIT_V,
                        COUNT (CASE  WHEN INSERT_SERVICE_ID =5  THEN 1  END) DELETE_PLATE,
                        COUNT (CASE  WHEN INSERT_SERVICE_ID =19  THEN 1  END) RESTORE_PLATE,
                        COUNT (CASE  WHEN INSERT_SERVICE_ID =6  THEN 1  END) PRINT_V 
                        FROM REG_VEHICLE_ARCHIVE WHERE ARCHIVE_ABBR".$eq." AND CREATED_DATE BETWEEN '".$start."' AND '".$end." 23:59:59'  
                        GROUP BY to_char(CREATED_DATE, 'YYYY-MM-DD'),ARCHIVE_ABBR ORDER BY ARCHIVE_ABBR, ARCHIVE_DATE"
                    ));

                    $results1 = DB::select(DB::raw("SELECT ARCHIVE_ABBR,to_char(UPDATED_DATE, 'YYYY-MM-DD') ARCHIVE_DATE, COUNT(CASE WHEN STATUS=1 THEN 1 END) NEW_V FROM REG_VEHICLE_ARCHIVE WHERE ARCHIVE_ABBR".$eq." AND UPDATED_DATE BETWEEN '".$start."' AND '".$end." 23:59:59' GROUP BY to_char(UPDATED_DATE, 'YYYY-MM-DD'),ARCHIVE_ABBR ORDER BY ARCHIVE_ABBR, ARCHIVE_DATE"));
                    foreach ($datas as $result){
                        foreach ($results1 as $r){
                            if($result->archive_abbr == $r->archive_abbr && $result->archive_date == $r->archive_date){
                                $result->new_v += $r->new_v;
                            }
                        }
                    }
                    $init = array();
                    $i = 1;
                    $sum = array(0,0,0,0,0,0,0,0,0,0,0,0,0);
                    foreach ($datas as $data){
                        if($data->archive_date != ""){
                            array_push($init, array(
                                $i,
                                Archive::getDepartmentName($data->archive_abbr),
                                $data->archive_date,
                                $data->new_v,
                                $data->move_v,
                                $data->move_plate_v,
                                $data->cert_change_v,
                                $data->cert_again_v,
                                $data->limit_v,
                                $data->remove_v,
                                $data->change_plate_v,
                                $data->change_plate_two_v,
                                $data->print_v,
                                $data->edit_v,
                                $data->delete_plate,
                                $data->restore_plate
                            ));

                            $sum[0] += $data->new_v;
                            $sum[1] += $data->move_v;
                            $sum[2] += $data->move_plate_v;
                            $sum[3] += $data->cert_change_v;
                            $sum[4] += $data->cert_again_v;
                            $sum[5] += $data->limit_v;
                            $sum[6] += $data->remove_v;
                            $sum[7] += $data->change_plate_v;
                            $sum[8] += $data->change_plate_two_v;
                            $sum[9] += $data->print_v;
                            $sum[10] += $data->edit_v;
                            $sum[11] += $data->delete_plate;
                            $sum[12] += $data->restore_plate;
                            $i++;
                        }
                    }
                    $sheet->rows($init);
                    $sheet->appendRow(array(
                        "합계",
                        "",
                        "",
                        $sum[0],
                        $sum[1],
                        $sum[2],
                        $sum[3],
                        $sum[4],
                        $sum[5],
                        $sum[6],
                        $sum[7],
                        $sum[8],
                        $sum[9],
                        $sum[10],
                        $sum[11],
                        $sum[12]
                    ));
                    $sheet->getStyle('A'.($i+6).':O'.($i+6))->getFont()->setBold(true);
                    $sheet->mergeCells('A'.($i+6).':C'.($i+6));
                    for($j = 1; $j <= $i + 6; $j++){
                        $sheet->cell('A'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('B'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('C'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('D'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('E'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('F'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('G'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('H'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('I'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('J'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('K'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('L'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('M'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('N'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('O'.($j), function ($cell) {
                            $this->center($cell);
                        });
                        $sheet->cell('P'.($j), function ($cell) {
                            $this->center($cell);
                        });
                    }
                    $sheet->getStyle('A6:P'.($i + 6))->applyFromArray([
                        'borders' => array(
                            'allborders' => array(
                                'style' => \PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    ]);
                    $sheet->appendRow(array(
                        "","","","","",""
                    ));
                    $sheet->appendRow(array(
                        "","","","","",""
                    ));
                    $sheet->appendRow(array(
                        "","","","","","보고서 작성: . . . . . . . . . . . /____________________/"
                    ));
                    $sheet->setFitToPage(true);
                    $sheet->setScale(80);
                });
            })->download('xls');
        }
    }
}
