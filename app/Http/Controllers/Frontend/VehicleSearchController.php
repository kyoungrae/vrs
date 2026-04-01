<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade as PDF;

class VehicleSearchController extends BaseController
{
    private $export_datas = null;
    private $export_datas1 = null;
    public function center($cell)
    {
        $cell->setValignment('center');
        $cell->setAlignment('center');
    }

    public function searchVehicle(Request $request){
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        if (self::isRealUiWithoutDb() && $request->isMethod('GET')) {
            $empty = collect([]);
            $countries = $wheels = $geerboxs = $provinces = $classifications = $gases = $purposes = $limits = $statuses = $types = $marks = $owner_types = $districts = $empty;
            $isArchive = null;

            return view('System.search', compact(
                'countries',
                'wheels',
                'geerboxs',
                'provinces',
                'classifications',
                'gases',
                'purposes',
                'limits',
                'statuses',
                'isArchive',
                'types',
                'marks',
                'owner_types',
                'districts'
            ));
        }
        try{
            $wheels = DB::table("REF_GENERAL")->where("REF_TYPE", 3)->get();
            $geerboxs = DB::table("REF_GENERAL")->where("REF_TYPE", 7)->get();
            $classifications = DB::table("REF_GENERAL")->where("REF_TYPE", 2)->get();
            $gases = DB::table("REF_GENERAL")->where("REF_TYPE", 10)->where("STATUS", 1)->get();
            $purposes = DB::table("REF_PURPOSE")->get();
            $statuses = DB::table("REG_STATUS")->get();
            $limits = DB::table("REG_LIMIT_TYPE")->get();
            $types = DB::table("REG_VEHICLE_TYPE")->orderBy("NAME", "ASC")->get();
            $owner_types = DB::table("OWNER_TYPE")->get();
            $countries = DB::table("REF_COUNTRY")->orderBy("NAME", "ASC")->get();
            $districts = DB::table("ADDRESS_SUBDEV")->orderBy("NAME", "ASC")->get();
            $provinces = DB::table("ADDRESS_PROVINCE")->orderBy("NAME", "ASC")->get();
            $marks = DB::table("REG_MARK")->orderBy("NAME", "ASC")->get();

            $isArchive = $request->get("isArchive");
            $registerNum = $request->get("registernumber");
            $search = false;

            if($isArchive == "on" ){
                if ($registerNum != "" || $registerNum != null) {
                  
                    $vehicles = DB::table("ARCHIVE_SEARCH_VIEW")->where("STATUS", "!=", 9)->where("STATUS", "!=", 10)->where("STATUS", "!=", 11);
                 //   dd(  $vehicles );
                } else {
                    $vehicles = DB::table("ARCHIVE_SEARCH_VIEW");
                 //   dd(  $vehicles );
                  //  return  $vehicles;
                }
                
              
            } else {
                $vehicles = DB::table("REG_VEHICLE_VIEW")->where("STATUS", "!=", 9)->where("STATUS", "!=", 10)->where("STATUS", "!=", 11);
            }
            //번호판аар
            $plate_no = $request->get("number");
            if($plate_no !== null && $plate_no !== ""){
                $plate_no = str_replace("*", "%", $plate_no);
                $vehicles = $vehicles->where("PLATE_NO", "LIKE", $plate_no);
                $plate_no = str_replace("%", "*", $plate_no);
                $search = true;
            }

            //섬ын 번호
            $cabin_no = $request->get("cabinnumber");
            if($cabin_no !== null && $cabin_no !== ""){
                $cabin_no = str_replace("*", "%", $cabin_no);
                $vehicles = $vehicles->where("CABIN_NO", "LIKE", $cabin_no);
                $cabin_no = str_replace("%", "*", $cabin_no);
                $search = true;
            }

            //제조국
            $factorycountry = $request->get("factorycountry");
            if($factorycountry !== null && $factorycountry !== ""){
                $vehicles = $vehicles->where("COUNTRY_ID", $factorycountry);
                $search = true;
            }

            //브랜드аар
            $mark = $request->get("mark");
            if($mark !== null && $mark !== ""){
                $vehicles = $vehicles->where("MARK_ID", $mark);
                $search = true;
            }

            //Моделоор
            $model = $request->get("model");
            if($model !== null && $model !== ""){
                $vehicles = $vehicles->where("MODEL_ID", $model);
                $search = true;
            }

            //Vin 번호аар
            $vin = $request->get("vin");
            if($vin !== null && $vin !== ""){
                $vin = str_replace("*", "%", $vin);
                $vehicles = $vehicles->where("VIN_NO", "LIKE", $vin);
                $vin = str_replace("%", "*", $vin);
                $search = true;
            }

            //Өөрчлөлт оруулсан 날짜гоор
            $modifieddate = $request->get("modifieddate");
            $modifieddate2 = $request->get("modifieddate2");

            if(($modifieddate !== null && $modifieddate !== "") && ($modifieddate2 !== null && $modifieddate2 !== "")){
                $vehicles = $vehicles->whereRaw("UPDATED_DATE BETWEEN '".$modifieddate."' AND '".$modifieddate2." 23:59:59'");
                $search = true;
            }

            //용도аар
            $purpose = $request->get("purpose");
            if($purpose !== null && $purpose !== ""){
                $vehicles = $vehicles->where("PURPOSE_ID", $purpose);
                $search = true;
            }

            //유형өөр
            $type = $request->get("type");
            if($type !== null && $type !== ""){
                $vehicles = $vehicles->where("VEHICLE_TYPE_ID", $type);
                $search = true;
            }

            //등급аар
            $class = $request->get("class");
            if($class !== null && $class !== ""){
                $vehicles = $vehicles->where("CLASSIFICATION_ID", $class);
                $search = true;
            }

            //제조 연도оор
            $factoryyear = $request->get("factoryyear");
            if($factoryyear !== null && $factoryyear !== ""){
                $vehicles = $vehicles->where("BUILD_YEAR", ">=", (int)$factoryyear);
                $search = true;
            } 

            $factoryyear2 = $request->get("factoryyear2");
            if($factoryyear2 !== null && $factoryyear2 !== ""){
                $vehicles = $vehicles->where("BUILD_YEAR", "<=", (int)$factoryyear2);
                $search = true;
            }

            //엔진 번호аар
            $enginenumber = $request->get("enginenumber");
            if($enginenumber !== null && $enginenumber !== ""){
                $enginenumber = str_replace("*", "%", $enginenumber);
                $vehicles = $vehicles->where("ENGINE_NO", "LIKE", $enginenumber);
                $enginenumber = str_replace("%", "*", $enginenumber);
                $search = true;
            }

            //색상өр
            $color = $request->get("color");
            if($color !== null && $color !== ""){
                $vehicles = $vehicles->whereRaw("lower(COLOR_NAME) LIKE '%".mb_strtolower($color)."%'");
                $search = true;
            }

            //Шатахууны төрлөөр
            $gas = $request->get("petroltype");
            if($gas !== null && $gas !== ""){
                if($gas == "is_hybrid"){
                    $vehicles = $vehicles->where("IS_HYBRID", 1);
                } else {
                    $vehicles = $vehicles->where("FUEL_PARENT_TYPE_ID", $gas)->where("IS_HYBRID", "!=", 1);
                }
                $search = true;
            }

            //핸들 위치аар
            $wheel = $request->get("wheel");
            if($wheel !== null && $wheel !== ""){
                $vehicles = $vehicles->where("WHEEL_ID", $wheel);
                $search = true;
            }

            $modificace_name = $request->get("modificace_name");
            if($modificace_name !== null && $modificace_name !== ""){
                $vehicles = $vehicles->where("modificace_name", $modificace_name);
                $search = true;
            }

            //Хурдны хайрцгаар
//        $gearbox = $request->get("transmission");
//        if($gearbox != "" || $gearbox != null){
//            $vehicles = $vehicles->where("FUEL_PARENT_TYPE_ID", $gas);
//            $search = true;
//        }

            //증명서 번호аар
            $certificatenumber = $request->get("certificatenumber");
            if($certificatenumber !== null && $certificatenumber !== ""){
                $certificatenumber = str_replace("*", "%", $certificatenumber);
                $vehicles = $vehicles->where("CERTIFICATE_NO", "LIKE", $certificatenumber);
                $certificatenumber = str_replace("%", "*", $certificatenumber);
                $search = true;
            }
            /*---------------*/
            //아카이브 번호аар
            $archive = $request->get("archive");
            if($archive !== null && $archive !== ""){
                $archive = str_replace("*", "%", $archive);
                $vehicles = $vehicles->where("ARCHIVE_NO", "LIKE", $archive);
                $archive = str_replace("%", "*", $archive);
                $search = true;
            }

            //최초 아카이브ын 번호аар
            $firstarchive = $request->get("firstarchive");
            if($firstarchive !== null && $firstarchive !== ""){
                $firstarchive = str_replace("*", "%", $firstarchive);
                $vehicles = $vehicles->where("FIRST_ARCHIVE_NO", "LIKE", $firstarchive);
                $firstarchive = str_replace("%", "*", $firstarchive);
                $search = true;
            }

            //제한 사항ын төрлөөр
            $limit = $request->get("restrict");
            if($limit !== null && $limit !== ""){
                $limited_vehicles = DB::table("REG_LIMITED")->whereNull("RESTORE_USER_ID")->where("TYPE_ID", $limit)->orderBy("VEHICLE_ID", "ASC")->pluck("vehicle_id");
                $vehicles = $vehicles->whereIn("ID", $limited_vehicles);
                $search = true;
            }

            //차량 төлөвөөр
            $status = $request->get("status");
            if($status !== null && $status !== ""){
                $vehicles = $vehicles->where("STATUS", $status);
                $search = true;
            }

            //Үндсэн харъяалал
            $region = $request->get("region");
            if($region !== null && $region !== ""){
                $vehicles = $vehicles->where("OWNER_COUNTRY", $region);
                $search = true;
            }

            //유형
            $owner_type = $request->get("ownertype");
            if($owner_type !== null && $owner_type !== ""){
                $vehicles = $vehicles->where("OWNER_TYPE_ID", $owner_type);
                $search = true;
            }

            //등록번호аар
            $register = $request->get("registernumber");
            if($register !== null && $register !== ""){
                $register = str_replace("*", "%", $register);
                $vehicles = $vehicles->where("REGISTER_NO", "LIKE", $register);
                $register = str_replace("%", "*", $register);
                $search = true;
            }
			
			$modificacename = $request->get("modificacename");
            if($modificacename !== null && $modificacename !== ""){
                $modificacename = str_replace("*", "%", $modificacename);
                $vehicles = $vehicles->where("modificace_name", "LIKE", $modificacename);
                $modificacename = str_replace("%", "*", $modificacename);
                $search = true;
            }

            //Эцэг/эхийн нэрээр
            $parent = $request->get("parent");
            if($parent !== null && $parent !== ""){
                $parent = str_replace("*", "%", $parent);
                $vehicles = $vehicles->where("LAST_NAME", "LIKE", $parent);
                $parent = str_replace("%", "*", $parent);
                $search = true;
            }

            //Өөрийн нэрээр
            $surname = $request->get("surname");
            if($surname !== null && $surname !== ""){
                $surname = str_replace("*", "%", $surname);
                $vehicles = $vehicles->where("FIRST_NAME", "LIKE", $surname);
                $surname = str_replace("%", "*", $surname);
                $search = true;
            }

            //Аймаг хотоор
            $province = $request->get("province");
            if($province !== null && $province !== ""){
                $vehicles = $vehicles->where("OWNER_PROVINCE_ID", $province);
                $search = true;
            }

            //Өөрчлөлт оруулсан 날짜гоор
            $importdate = $request->get("importdate");
            $importdate2 = $request->get("importdate2");

            if(($importdate !== null && $importdate !== "") && ($importdate2 !== null && $importdate2 !== "")){
                $vehicles = $vehicles->whereRaw("IMPORT_DATE BETWEEN '".$importdate."' AND '".$importdate2." 23:59:59'");
                $search = true;
            }

            //Сум дүүргээр
            $district = $request->get("district");
            if($district !== null && $district !== ""){
                $vehicles = $vehicles->where("OWNER_DISTRICT_ID", $district);
                $search = true;
            }

            //Баг хороогоор
            $commission = $request->get("commission");
            if($commission !== null && $commission !== ""){
                $vehicles = $vehicles->where("OWNER_DEVISION_UNIT_ID", $commission);
                $search = true;
            }

            //Хорооллоор шүүх
            $town = $request->get("town");
            if($town !== null && $town !== ""){
                $vehicles = $vehicles->where("OWNER_MICRO_DISTRICT_ID", $town);
                $search = true;
            }

            //거리аар
            $street = $request->get("street");
            if($street !== null && $street !== ""){
                $street = str_replace("*", "%", $street);
                $vehicles = $vehicles->whereRaw("lower(OWNER_STREET) LIKE '". $street."'");
                $street = str_replace("%", "*", $street);
                $search = true;
            }

            //동аар
            $apartment = $request->get("apartment");
            if($apartment !== null && $apartment !== ""){
                $apartment = str_replace("*", "%", $apartment);
                $vehicles = $vehicles->whereRaw("lower(OWNER_APARTMENT_NO) LIKE '". $apartment ."'");
                $apartment = str_replace("%", "*", $apartment);
                $search = true;
            }

            //호ны 번호аар
            $door = $request->get("door");
            if($door !== null && $door !== ""){
                $door = str_replace("*", "%", $door);
                $vehicles = $vehicles->whereRaw("lower(OWNER_DOOR_NO) LIKE '". $door."'");
                $door = str_replace("%", "*", $door);
                $search = true;
            }

            //직장 전화ны 번호аар
            $workphone = $request->get("workphone");
            if($workphone !== null && $workphone !== ""){
                $vehicles = $vehicles->where("OWNER_WORKPHONE", "LIKE", "%".$workphone."%");
                $search = true;
            }

            //자택 전화ны 번호аар
            $homephone = $request->get("homephone");
            if($homephone !== null && $homephone !== ""){
                $vehicles = $vehicles->where("OWNER_HOMEPHONE", "LIKE", "%".$homephone."%");
                $search = true;
            }

            //Гар утасны 번호аар
            $mobile = $request->get("mobile");
            if($mobile !== null && $mobile !== ""){
                $vehicles = $vehicles->where("OWNER_CELLPHONE", "LIKE", "%".$mobile."%");
                $search = true;
            }

            //엔진 배기량аар
            $enginecapacity = $request->get("enginecapacity");
            if($enginecapacity !== null && $enginecapacity !== ""){
                $vehicles = $vehicles->where("ENGINE_CAPACITY", ">=", (int)$enginecapacity);
                $search = true;
            }

            $enginecapacity2 = $request->get("enginecapacity2");
            if($enginecapacity2 !== null && $enginecapacity2 !== ""){
                $vehicles = $vehicles->where("ENGINE_CAPACITY", "<=", (int)$enginecapacity2);
                $search = true;
            }

            //Хүйсээр
            $gender = $request->get("gender");
            if($gender != ""){
                $vehicles = $vehicles->where("OWNER_GENDER", "=", (int)$gender);
                $search = true;
            }

            //Мэдүүлгийн 번호аар
            $dec = $request->get("applicationNumber");
            if($dec !== null && $dec !== ""){
                $dec = str_replace("*", "%", $dec);
                $vehicles = $vehicles->where("DECLARATION_NO", "LIKE", $dec);
                $dec = str_replace("%", "*", $dec);
                $search = true;
            }

            //Өөрчлөлт оруулсан 날짜гоор
            $ownerdate = $request->get("ownerdate");
            $ownerdate2 = $request->get("ownerdate2");

            if(($ownerdate !== null && $ownerdate !== "") && ($ownerdate2 !== null && $ownerdate2 !== "")){
                $vehicles = $vehicles->whereRaw("START_DATE BETWEEN '".$ownerdate."' AND '".$ownerdate2." 23:59:59'");
                $search = true;
            }

            if($search){
                $total_count = $vehicles->count();
                $excel = $request->get("is_excel");
                if($excel == 1){
                    try{
                        $columns = $request->get("excel_columns");
                        if(strlen($columns) > 0){
                            $columns_delete = explode(',', $columns);
                            $columns_diff = array();
                            $titles = array();
                            foreach ($columns_delete as $delete){
                                if($delete == "ehelsenognoo"){
                                    array_push($columns_diff, "start_date");
                                    array_push($titles, "시작 일자");
                                }
                                elseif($delete == "ulsiindugaar"){
                                    array_push($columns_diff, "plate_no");
                                    array_push($titles, "번호판");
                                }
                                elseif($delete == "arliindugaar"){
                                    array_push($columns_diff, "cabin_no");
                                    array_push($titles, "차체번호");
                                }
                                elseif($delete == "vin"){
                                    array_push($columns_diff, "vin_no");
                                    array_push($titles, "Vin 번호");
                                }
                                elseif($delete == "factory"){
                                    array_push($columns_diff, "country_name");
                                    array_push($titles, "제조국");
                                }
                                elseif($delete == "mark"){
                                    array_push($columns_diff, "mark_name");
                                    array_push($titles, "브랜드");
                                }
                                elseif($delete == "model"){
                                    array_push($columns_diff, "model_name");
                                    array_push($titles, "모델");
                                }
                                elseif($delete == "color"){
                                    array_push($columns_diff, "color_name");
                                    array_push($titles, "색상");
                                }
                                elseif($delete == "uildverlesenognoo"){
                                    array_push($columns_diff, "build_year");
                                    array_push($titles, "제조 일자");
                                }
                                elseif($delete == "uurchilsunognoo"){
                                    array_push($columns_diff, "updated_date");
                                    array_push($titles, "변경 일자");
                                }
                                elseif($delete == "archivedugaar"){
                                    array_push($columns_diff, "archive_no");
                                    array_push($titles, "아카이브 번호");
                                }
                                elseif($delete == "urgiinovog"){
                                    array_push($columns_diff, "family_name");
                                    array_push($titles, "본관성");
                                }
                                elseif($delete == "estegekh"){
                                    array_push($columns_diff, "last_name");
                                    array_push($titles, "Эцэр/эхийн нэр");
                                }
                                elseif($delete == "uuriinner"){
                                    array_push($columns_diff, "first_name");
                                    array_push($titles, "Өөрийн нэр");
                                }
                                elseif($delete == "bagtaamj"){
                                    array_push($columns_diff, "engine_capacity");
                                    array_push($titles, "Багтаамж");
                                }
                                elseif($delete == "zoriulalt"){
                                    array_push($columns_diff, "purpose_name");
                                    array_push($titles, "용도");
                                }
                                elseif($delete == "turul"){
                                    array_push($columns_diff, "vehicle_type_name");
                                    array_push($titles, "유형");
                                }
                                elseif($delete == "angilal"){
                                    array_push($columns_diff, "class_name");
                                    array_push($titles, "등급");
                                }
                                elseif($delete == "hurd"){
                                    array_push($columns_diff, "steering_type_name");
                                    array_push($titles, "Хурдний байрлал");
                                }
                                elseif($delete == "motor"){
                                    array_push($columns_diff, "engine_no");
                                    array_push($titles, "엔진 번호");
                                }
                                elseif($delete == "gasoline"){
                                    array_push($columns_diff, "fuel_name");
                                    array_push($titles, "연료 유형");
                                }
                                elseif($delete == "urt"){
                                    array_push($columns_diff, "length");
                                    array_push($titles, "Урт");
                                }
                                elseif($delete == "urgun"){
                                    array_push($columns_diff, "width");
                                    array_push($titles, "Өргөн");
                                }
                                elseif($delete == "undur"){
                                    array_push($columns_diff, "height");
                                    array_push($titles, "Өндөр");
                                }
                                elseif($delete == "buhjin"){
                                    array_push($columns_diff, "total_weight");
                                    array_push($titles, "Бүх жин");
                                }
                                elseif($delete == "uuriinjin"){
                                    array_push($columns_diff, "own_weight");
                                    array_push($titles, "Өөрийн жин");
                                }
                                elseif($delete == "gerchilgee"){
                                    array_push($columns_diff, "certificate_no");
                                    array_push($titles, "증명서 번호");
                                }
                                elseif($delete == "oruuljirsen"){
                                    array_push($columns_diff, "import_date");
                                    array_push($titles, "Импорт 날짜");
                                }
                                elseif($delete == "modificacename"){
                                    array_push($columns_diff, "modificace_name");
                                    array_push($titles, "Модификац");
                                }
                                if($delete == "meduulgiindugaar"){
                                    array_push($columns_diff, "declaration_no");
                                    array_push($titles, "Мэдүүлэгийн 번호");
                                }
                                elseif($delete == "archivedugaar"){
                                    array_push($columns_diff, "first_archive_no");
                                    array_push($titles, "Анхны аривын 번호");
                                }
                                elseif($delete == "teevriinheregselturul"){
                                    array_push($columns_diff, "status_name");
                                    array_push($titles, "차량-н төлөв");
                                }
                                elseif($delete == "aimag" || $delete == "duureg" || $delete == "baghoroo" || $delete == "horoolol" || $delete == "gudamj" || $delete == "bair" || $delete == "haalga"){
                                    array_push($columns_diff, "address_detail");
                                    array_push($titles, "주소");
                                }
                            }

                            $this->export_datas = clone $vehicles;
                            $datas = json_decode(json_encode($this->export_datas->select($columns_diff)->get()), true);
                            return Excel::create('Хайлтын үр дүн', function ($excel) use($datas, $titles){
                                $excel->setTitle("Үр дүн");
                                $excel->setCreator("ATUT");
                                $excel->sheet("보고서", function ($sheet) use($datas, $titles) {
                                    $sheet->rows($datas);
                                    $sheet->prependRow($titles);
                                });
                            })->export('xls');
                        } else {
                            return redirect(route("search"));
                        }
                    } catch (\Exception $ex){
                        $this->writeLog("Хайлтын үр дүн EXCEL -рүү гаргах алдаа.".$ex);
                    }
                }

                $vehicles = $vehicles->paginate(1200)->setPath("");
                $vehicles->appends(array(
                    "purpose"=>$purpose,
                    "type"=>$type,
                    "class"=>$class,
                    "status"=>$status,
                    "certificatenumber"=>$certificatenumber,
                    "enginenumber"=>$enginenumber,
                    "number"=>$plate_no,
                    "petroltype"=>$gas,
                    "wheel"=>$wheel,
                    "region"=>$region,
                    "ownertype"=>$owner_type,
                    "registernumber"=>$register,
                    "modificacename"=>$modificacename,
                    "parent"=>$parent,
                    "surname"=>$surname,
                    "street"=>$street,
                    "mobile"=>$mobile,
                    "homephone"=>$homephone,
                    "workphone"=>$workphone,
                    "door"=>$door,
                    "apartment"=>$apartment,
                    "province"=>$province,
                    "restrict"=>$limit,
                    "gender"=>$gender,
                    "applicationNumber"=>$dec,
                    "town"=>$town,
                    "district"=>$district,
                    "commission"=>$commission,
                    "isArchive"=>$isArchive,
                    "importdate"=>$importdate,
                    "importdate2"=>$importdate2,
                    "ownerdate"=>$ownerdate,
                    "ownerdate2"=>$ownerdate2,
                    "vin"=>$vin,
                    "factorycountry"=>$factorycountry,
                    "cabinnumber"=>$cabin_no,
                    "archive"=>$archive,
                    "firstarchive"=>$firstarchive,
                    "mark"=>$mark,
                    "model"=>$model,
                    "color"=>$color,
                    "factoryyear"=>$factoryyear,
                    "factoryyear2"=>$factoryyear2,
                    "modifieddate"=>$modifieddate,
                    "modifieddate2"=>$modifieddate2
                ));

                session(["results" => $vehicles]);
                return view('System.search',
                    compact(
                        "vehicles",
                        "total_count",
                        "countries",
                        "wheels",
                        "geerboxs",
                        "provinces",
                        "classifications",
                        "gases",
                        "purposes",
                        "types",
                        "marks",
                        "limits",
                        "statuses",
                        "owner_types",
                        "districts",
                        "modificacename",
                        "purpose",
                        "type",
                        "class",
                        "status",
                        "certificatenumber",
                        "enginenumber",
                        "plate_no",
                        "gas",
                        "wheel",
                        "region",
                        "owner_type",
                        "register",
                        "parent",
                        "surname",
                        "street",
                        "mobile",
                        "homephone",
                        "workphone",
                        "door",
                        "apartment",
                        "province",
                        "limit",
                        "gender",
                        "dec",
                        "town",
                        "district",
                        "commission",
                        "isArchive",
                        "importdate",
                        "importdate2",
                        "ownerdate",
                        "ownerdate2",
                        "vin",
                        "factorycountry",
                        "cabin_no",
                        "archive",
                        "firstarchive",
                        "mark",
                        "model",
                        "color",
                        "factoryyear",
                        "factoryyear2",
                        "modifieddate",
                        "modifieddate2"
                    ));

            } else {
                return view('System.search', compact(
                    "countries",
                    "wheels",
                    "geerboxs",
                    "provinces",
                    "classifications",
                    "gases",
                    "purposes",
                    "limits",
                    "statuses",
                    "isArchive",
                    "types",
                    "marks",
                    "owner_types",
                    "districts"
                ));
            }
        } catch (\Exception $ex){
            $this->writeLog("Search vehicle error: ".$ex->getMessage());
        }
    }

    public function searchArchive(Request $request){
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        $archive = $request->route("number");
        try{
            $action = mb_substr($archive, 0, 2);
            $end = mb_substr($archive, 2, strlen($archive));
            $branch = "";
            for($i = 0; $i < strlen($end); $i++){
                $sub = mb_substr($end, $i, 1);
                if(is_numeric($sub)){
                  //  break;
                  $branch = mb_substr($branch.$sub,0,7);
                } else {
                    $branch = $branch.$sub;
                }
            }   

            $len = mb_strlen($branch);
            $year = mb_substr($end, $len, 2);
            $month = mb_substr($end, $len + 2, 2);
            $number = mb_substr($end, $len + 4, strlen($end));
           // return  $branch;
            if(Storage::disk('ftp')->has("/".$action."/".$branch."/".$year."/".$month."/".$number.".pdf")){
                //$filecontent = Storage::disk('ftp')->get("//".$action."/".$branch."/".$year."/".$month."/".$number."#ntr.pdf");
                $filecontentElectr = Storage::disk('ftp')->get("/".$action."/".$branch."/".$year."/".$month."/".$number.".pdf");
                //return $filecontentElectr; 
    
               
                return response($filecontentElectr)
                    ->withHeaders([
                        'Content-Type' => 'application/pdf'
                    ]);
            } else {
                return view("Errors.404");
            }
        } catch (\Exception $ex){
            $this->writeLog("Archive file view error: ". $ex->getMessage());
            return view("Errors.404");
        }
    }
    public function searchArchive2(Request $request){
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
 
        $archive = $request->route("number");
     
        try{
            $action = mb_substr($archive, 0, 2);
            $end = mb_substr($archive, 2, strlen($archive));

            $branch = "";

            for($i = 0; $i < strlen($end); $i++){
                $sub = mb_substr($end, $i, 1);
                if(is_numeric($sub)){
                    break;
                } else {
                    $branch = $branch.$sub;
                }
            }   

            $len = mb_strlen($branch);
            $year = mb_substr($end, $len, 2);
            $month = mb_substr($end, $len + 2, 2);
            $number = mb_substr($end, $len + 4, strlen($end));
           
            if(Storage::disk('ftp')->has("/".$action."/".$branch."/".$year."/".$month."/".$number.".pdf")){
                $filecontent = Storage::disk('ftp')->get("/".$action."/".$branch."/".$year."/".$month."/".$number.".pdf");
               // $filecontentElectr = Storage::disk('ftp')->get("//".$action."/".$branch."/".$year."/".$month."/".$number."#.pdf");
                //return $action; 
            
              
       
               
                return response($filecontent)
                    ->withHeaders([
                        'Content-Type' => 'application/pdf'
                    ]);
            } else {
                return view("Errors.404");
            }
        } catch (\Exception $ex){
            $this->writeLog("Archive file view error: ". $ex->getMessage());
            return view("Errors.404");
        }
    }
    public function searchArchive3(Request $request){
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
 
        $archive = $request->route("number");
     
        try{
            $action = mb_substr($archive, 0, 2);
            $end = mb_substr($archive, 2, strlen($archive));

            $branch = "";

            for($i = 0; $i < strlen($end); $i++){
                $sub = mb_substr($end, $i, 1);
                if(is_numeric($sub)){
                    break;
                } else {
                    $branch = $branch.$sub;
                }
            }   

            $len = mb_strlen($branch);
            $year = mb_substr($end, $len, 2);
            $month = mb_substr($end, $len + 2, 2);
            $number = mb_substr($end, $len + 4, strlen($end));
           
            if(Storage::disk('ftp')->has("/".$action."/".$branch."/".$year."/".$month."/".$number."#ntr.pdf")){
                $filecontent = Storage::disk('ftp')->get("/".$action."/".$branch."/".$year."/".$month."/".$number."#ntr.pdf");
               // $filecontentElectr = Storage::disk('ftp')->get("//".$action."/".$branch."/".$year."/".$month."/".$number."#.pdf");
                //return $action; 
            
              
       
               
                return response($filecontent)
                    ->withHeaders([
                        'Content-Type' => 'application/pdf'
                    ]);
            } else {
                return view("Errors.404");
            }
        } catch (\Exception $ex){
            $this->writeLog("Archive file view error: ". $ex->getMessage());
            return view("Errors.404");
        }
    }
}
