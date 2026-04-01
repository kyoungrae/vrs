<?php

use Illuminate\Database\Seeder;
use App\MainUserPosition;
use App\MainRefGender;
use App\MainUserDepartment;
use App\MainUser;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$this->createGender();
        $this->createUserPosition();
        $this->createDepartment();
        $this->createUser();
        //$this->createDepartmentArchive();
    }

    public function createProvince(){
        $provinces = [
            "Улаанбаатар"
            ,"Архангай"
            ,"Баян-Өлгий"
            ,"Баянхонгор"
            ,"Булган"
            ,"Говь-Алтай"
            ,"Говьсүмбэр"
            ,"Дархан-Уул"
            ,"Дорноговь"
            ,"Дорнод"
            ,"Дундговь"
            ,"Завхан"
            ,"Орхон"
            ,"Өвөрхангай"
            ,"Өмнөговь"
            ,"Сүхбаатар"
            ,"Сэлэнгэ"
            ,"Төв"
            ,"Увс"
            ,"Ховд"
            ,"Хөвсгөл"
            ,"Хэнтий"
        ];
        foreach ($provinces as $province){
            MainRefProvince::create([
                    'Name' => $province,
                    'CreatedBy' => 1,
                    'ModifiedBy' => 1
                ]
            );
        }
    }

    public function createDistrict(){
        $districts = [
            "Баянзүрх"
            ,"Баянгол"
            ,"Сүхбаатар"
            ,"Сонгино хайрхан"
            ,"Хан-Уул"
            ,"Налайх"
            ,"Багануур"
            ,"Чингэлтэй"
        ];
        foreach ($districts as $district){
            MainRefDistrict::create([
                    'ProvincePkId' => 1,
                    'Name' => $district,
                    'CreatedBy' => 1,
                    'ModifiedBy' => 1
                ]
            );
        }

        $districts = [
            "Цэцэрлэг"
            ,"Хотонт"
            ,"Цэнхэр"
            ,"Их тамр"
            ,"Чулуут"
        ];
        foreach ($districts as $district){
            MainRefDistrict::create([
                    'ProvincePkId' => 2,
                    'Name' => $district,
                    'CreatedBy' => 1,
                    'ModifiedBy' => 1
                ]
            );
        }
    }

    public function createDepartmentArchive(){
        MainRefDepartmentArchive::create([
            'ProvincePkId' => "1",
            'DistrictPkId' => "1",
            'DepartmentPkId' => "1",
            'Name' => "Да хүрээ",
            'Abbr' => "ДаХү",
            'NewPrefix' => "ШИ",
            'EditPrefix' => "ЗА",
            'MovePrefix' => "ШЖ",
            'DeletePrefix' => "ХАС",
            'OtherPrefix' => "",
            'CreatedBy' => 1,
            'ModifiedBy' => 1
        ]);
    }

    public function createUser(){
        MainUser::create([
            'ProvinceId' => 1,
            'UserPositionId' => 1,
            'UserDepartmentId' => 1,
            'UserName' => "ayush",
            'FirstName' => "Tsend-Ayush",
            'LastName' => "Gansukh",
            'Email' => "sw10d301@gmail.com",
            'Phone' => "99380740",
            'Password' => \Illuminate\Support\Facades\Hash::make("Test111;"),
            'PasswordAnother' => "Test111;",
            'IsActive' => 1,
            'CreatedBy' => 1,
            'ModifiedBy' => 1,
        ]);
    }

    public function createGender(){
        MainRefGender::create([
            'Name' => "Эрэгтэй",
            'CreatedBy' => 1,
            'ModifiedBy' => 1
        ]);
        MainRefGender::create([
            'Name' => "Эмэгтэй",
            'CreatedBy' => 1,
            'ModifiedBy' => 1
        ]);
    }

    public function createService(){
        MainService::create([
            'Code' => "Code",
            'ServicePrefix' => "ШХ",
            'Name' => "Шилжилт хөдөлгөөн",
            'Fee' => 0,
            'CreatedBy' => 1,
            'ModifiedBy' => 1
        ]);

        MainService::create([
            'Code' => "Code",
            'ServicePrefix' => "ӨШ",
            'Name' => "Өмчлөгч шилжүүлэх",
            'Fee' => 0,
            'CreatedBy' => 1,
            'ModifiedBy' => 1
        ]);

        MainService::create([
            'Code' => "Code",
            'ServicePrefix' => "УДС",
            'Name' => "Улсын дугаар солих",
            'Fee' => 0,
            'CreatedBy' => 1,
            'ModifiedBy' => 1
        ]);

        MainService::create([
            'Code' => "Code",
            'ServicePrefix' => "БХ",
            'Name' => "Бүртгэлээс хасах",
            'Fee' => 0,
            'CreatedBy' => 1,
            'ModifiedBy' => 1
        ]);

        MainService::create([
            'Code' => "Code",
            'ServicePrefix' => "ГНО",
            'Name' => "Гэрчилгээ нөхөн олгох",
            'Fee' => 0,
            'CreatedBy' => 1,
            'ModifiedBy' => 1
        ]);

        MainService::create([
            'Code' => "Code",
            'ServicePrefix' => "ГС",
            'Name' => "Гэрчилгээ солилт",
            'Fee' => 0,
            'CreatedBy' => 1,
            'ModifiedBy' => 1
        ]);

        MainService::create([
            'Code' => "Code",
            'ServicePrefix' => "УДШ",
            'Name' => "УД солилттой шилжилт",
            'Fee' => 0,
            'CreatedBy' => 1,
            'ModifiedBy' => 1
        ]);
    }

    public function createRestricionType(){
        MainRefRestrictionType::create([
            'Name' => "Зөрчилтэй",
            'CreatedBy' => 1,
            'ModifiedBy' => 1
        ]);
        MainRefRestrictionType::create([
            'Name' => "Прокурор",
            'CreatedBy' => 1,
            'ModifiedBy' => 1
        ]);
        MainRefRestrictionType::create([
            'Name' => "Зарлагдсан",
            'CreatedBy' => 1,
            'ModifiedBy' => 1
        ]);
        MainRefRestrictionType::create([
            'Name' => "Зээлийн барьцаа",
            'CreatedBy' => 1,
            'ModifiedBy' => 1
        ]);
        MainRefRestrictionType::create([
            'Name' => "Хууль бус тээврийн хэрэгсэл",
            'CreatedBy' => 1,
            'ModifiedBy' => 1
        ]);
    }

    public function createOwnerType(){
        MainRefOwnerType::create([
            'Name' => "Хувь хүн",
            'CreatedBy' => 1,
            'ModifiedBy' => 1
        ]);
        MainRefOwnerType::create([
            'Name' => "Хувийн хэвшил",
            'CreatedBy' => 1,
            'ModifiedBy' => 1
        ]);
        MainRefOwnerType::create([
            'Name' => "Төрийн байгууллага",
            'CreatedBy' => 1,
            'ModifiedBy' => 1
        ]);
        MainRefOwnerType::create([
            'Name' => "Олон улс",
            'CreatedBy' => 1,
            'ModifiedBy' => 1
        ]);
        MainRefOwnerType::create([
            'Name' => "УҮГ",
            'CreatedBy' => 1,
            'ModifiedBy' => 1
        ]);
        MainRefOwnerType::create([
            'Name' => "Гадаадын байгууллага",
            'CreatedBy' => 1,
            'ModifiedBy' => 1
        ]);
        MainRefOwnerType::create([
            'Name' => "Хамтарсан компани",
            'CreatedBy' => 1,
            'ModifiedBy' => 1
        ]);
    }

    public function createDepartment(){
        MainUserDepartment::create([
            "Name" => "Бүртгэлийн хэлтэс",
            'CreatedBy' => 1,
            'ModifiedBy' => 1
        ]);

        MainUserDepartment::create([
            "Name" => "Орон нутгийн бүртгэлийн хэлтэс",
            'CreatedBy' => 1,
            'ModifiedBy' => 1
        ]);
    }

    public function createUserPosition(){
        MainUserPosition::create([
            'Name' => "Админ",
            'CreatedBy' => 1,
            'ModifiedBy' => 1
        ]);

        MainUserPosition::create([
            'Name' => "Дэд админ",
            'CreatedBy' => 1,
            'ModifiedBy' => 1
        ]);

        MainUserPosition::create([
            'Name' => "Хэлтсийн дарга",
            'CreatedBy' => 1,
            'ModifiedBy' => 1
        ]);

        MainUserPosition::create([
            'Name' => "Тасгийн дарга",
            'CreatedBy' => 1,
            'ModifiedBy' => 1
        ]);

        MainUserPosition::create([
            'Name' => "Ахлах мэргэжилтэн",
            'CreatedBy' => 1,
            'ModifiedBy' => 1
        ]);

        MainUserPosition::create([
            'Name' => "Мэргэжилтэн",
            'CreatedBy' => 1,
            'ModifiedBy' => 1
        ]);
    }
}
