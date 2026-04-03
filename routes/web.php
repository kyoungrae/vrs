<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
 
Route::get('/test', 'TestController@index');
/*Нүүр хуудас харуулах*/

Route::get('/home', function () {
    return redirect()->route('dashboard');
})->name('home');

Route::get('/', 'Frontend\IndexController@index');

/** Local only: APP_ENV=local + DEV_BYPASS_LOGIN=true — see .env.example */
Route::get('/dev/local-login', 'DevLocalAuthController@login')->name('dev.local-login');
Route::get('/dev/create-test-user', 'DevLocalAuthController@createTestUser')->name('dev.create-test-user');
Route::get('/dev/debug-archives', 'DevLocalAuthController@debugArchives')->name('dev.debug-archives');
Route::get('/dev/scan-mongolian', function() {
    require_once base_path('scripts/scan_mongolian_data.php');
    return 'Scan complete - check scripts/mn_ko_pairs.tsv';
})->name('dev.scan-mongolian');
Route::get('/dev/extract-db-text', function() {
    try {
        ob_start();
        require_once base_path('scripts/extract_db_text.php');
        $output = ob_get_clean();
        return response('<pre>' . $output . '</pre>');
    } catch (Exception $e) {
        return response('<pre>에러 발생: ' . $e->getMessage() . '\n\n' . $e->getTraceAsString() . '</pre>', 500);
    }
})->name('dev.extract-db-text');

Route::get('/auction', 'Frontend\AuctionController@auction');
Route::post('/auction', 'Frontend\AuctionController@auction')->name('auction');

Route::get('/payment', 'Frontend\paymentController@payment');
Route::post('/payment', 'Frontend\paymentController@payment')->name('payment');

Route::get('/audit', 'AuditController@index');
Route::post('/audit', 'AuditController@index');

Route::get('/qrVehicleForm', 'Frontend\VehicleController@vehicleFormQr')->name("qrCode");


Route::get('/index', 'Frontend\IndexController@index');
Route::post('/login', 'Auth\LoginController@login')->name("login");
Route::get('/login', 'Auth\LoginController@login')->name("login");
Route::get('/logout', 'Auth\LoginController@logout');
Route::post('/logout', 'Auth\LoginController@logout')->name("logout");
Route::get('/404', 'Frontend\SettingsController@errorpage')->name("error");

Route::get('/dashboard', 'Frontend\DashboardController@index')->name("dashboard");
Route::post('/dashboard', 'Frontend\DashboardController@index')->name("dashboard");
Route::post('/dashboard-service', 'Frontend\DashboardController@service_total')->name("service_total");

Route::get('/user', 'Frontend\UserController@createUser')->name("user");
Route::post('/user', 'Frontend\UserController@createUser')->name("user");
Route::post('/userBranch', 'Frontend\UserController@fetch')->name("fetch");

Route::get('/user/edit/{code}', 'Frontend\UserController@createUser');
Route::get('/user/delete/{code}', 'Frontend\UserController@deleteUser');

Route::get('/userlist', 'Frontend\UserController@userList')->name("userlist");
Route::post('/userlist', 'Frontend\UserController@userList')->name("userlist");

Route::get('/user/password', 'Frontend\UserController@changePassword')->name("password");
Route::post('/user/password', 'Frontend\UserController@changePassword')->name("password");

Route::get('/user/mynumbers', 'Frontend\UserController@myNumbers');
Route::post('/user/mynumbers', 'Frontend\UserController@myNumbers');


Route::get('/vehicle', 'Frontend\VehicleController@indexVehicle')->name("vehicle");
Route::post('/vehicle', 'Frontend\VehicleController@indexVehicle')->name("vehicle");
Route::get('/vehicle/{plate_no}', 'Frontend\VehicleController@indexVehicle');
Route::get('/vehicle/{cabin_no}/new', 'Frontend\VehicleController@indexVehicle');
Route::get('/vehicle/{plate_no}/new/{vehicle_id}', 'Frontend\VehicleController@indexVehicle');
Route::post('/vehicle/restore', 'Frontend\VehicleController@restoreVehicle')->name("restorelimit");

//MH -ийн үйлдлүүд
//1. Гэрчилгээ солилт, нөхөлт
Route::post('/vehicle/change/plateColor', 'Frontend\VehicleController@changePlateColor')->name("change_plate_color");


Route::post('/vehicle/change/cert', 'Frontend\VehicleController@changeCert')->name("change_cert");
Route::post('/vehicle/again/cert', 'Frontend\VehicleController@againCert')->name("again_cert");
Route::post('/vehicle/change/plate', 'Frontend\VehicleController@changePlate')->name("change_plate");
Route::post('/vehicle/restore/plate', 'Frontend\VehicleController@restorePlate')->name("restore_plate");
Route::post('/vehicle/restrict', 'Frontend\VehicleController@restrict')->name("restrict");
Route::post('/vehicle/active', 'Frontend\VehicleController@activeVehicle')->name("active_vehicle");
Route::post('/vehicle/restrict/restore', 'Frontend\VehicleController@restoreRestrict')->name("restrictrestore");
Route::post('/vehicle/edit', 'Frontend\VehicleController@editVehicle')->name("edit_vehicle");
Route::post('/vehicle/move/owner', 'Frontend\VehicleController@moveOwnerVehicle')->name("move_owner_vehicle");
Route::post('/vehicle/move/ownerplate', 'Frontend\VehicleController@moveOwnerVehiclePlate')->name("move_owner_plate_vehicle");
Route::post('/vehicle/new', 'Frontend\VehicleController@newVehicle')->name("new_vehicle");
Route::post('/vehicle/remove', 'Frontend\VehicleController@removeVehicle')->name("remove");
Route::post('/vehicle/change/platetwo', 'Frontend\VehicleController@changePlateTwo')->name("change_plate_two");
Route::post('/vehicle/delete/plate', 'Frontend\VehicleController@deletePlate')->name("delete_plate");
Route::post('/vehicle/description', 'Frontend\VehicleController@writeDescription')->name("description_vehicle");

Route::any('/search', 'Frontend\VehicleSearchController@searchVehicle')->name("search");

Route::get('/searcharchive', 'Frontend\VehicleController@searchArchive');
Route::post('/searcharchive', 'Frontend\VehicleController@searchArchive');
 
Route::get('/vehicle/search/reference', 'Frontend\VehicleController@referenceVehicle')->name("print_ref");
Route::post('/vehicle/search/reference', 'Frontend\VehicleController@referenceVehicle')->name("print_ref");

Route::get('/vehicle/search/reference/custom', 'Frontend\VehicleController@referenceCustomVehicle')->name("custom_ref");
Route::post('/vehicle/search/reference/custom', 'Frontend\VehicleController@referenceCustomVehicle')->name("custom_ref");

Route::get('/reference/service', 'Frontend\ReferenceController@indexService')->name("refservice");
Route::post('/reference/service', 'Frontend\ReferenceController@indexService')->name("refservice");
Route::get('/reference/service/edit/{code}', 'Frontend\ReferenceController@indexService'); 
Route::get('/reference/service/delete/{code}', 'Frontend\ReferenceController@deleteService');

Route::get('/reference/position', 'Frontend\ReferenceController@indexPosition')->name("refposition");
Route::post('/reference/position', 'Frontend\ReferenceController@indexPosition')->name("refposition");
Route::get('/reference/position/edit/{code}', 'Frontend\ReferenceController@indexPosition');
Route::get('/reference/position/delete/{code}', 'Frontend\ReferenceController@deletePosition');

Route::get('/reference/vehicle', 'Frontend\ReferenceController@indexVehicle');
Route::post('/reference/vehicle', 'Frontend\ReferenceController@indexVehicle');

Route::get('/reference/address', 'Frontend\ReferenceController@indexAddress');
Route::post('/reference/address', 'Frontend\ReferenceController@indexAddress');

Route::get('/reference/address/province', 'Frontend\ReferenceController@indexProvince');
Route::post('/reference/address/province', 'Frontend\ReferenceController@indexProvince');

Route::get('/reference/address/destrict', 'Frontend\ReferenceController@indexDestrict');
Route::post('/reference/address/destrict', 'Frontend\ReferenceController@indexDestrict');

Route::get('/reference/address/commission', 'Frontend\ReferenceController@indexCommission')->name("adrefcomm");
Route::post('/reference/address/commission', 'Frontend\ReferenceController@indexCommission')->name("adrefcomm");

Route::get('/reference/address/town', 'Frontend\ReferenceController@indexTown')->name("refaddresstown");
Route::post('/reference/address/town', 'Frontend\ReferenceController@indexTown')->name("refaddresstown");

Route::get('/reference/address/town/edit/{code}', 'Frontend\ReferenceController@createTown');
Route::get('/reference/address/town/delete/{code}', 'Frontend\ReferenceController@deleteTown');

Route::get('/reference/address/create/town', 'Frontend\ReferenceController@createTown')->name("createtown");
Route::post('/reference/address/create/town', 'Frontend\ReferenceController@createTown')->name("createtown");

Route::get('/reference/address/commission/edit/{code}', 'Frontend\ReferenceController@createCommission');
Route::get('/reference/address/commission/delete/{code}', 'Frontend\ReferenceController@deleteCommssion');

Route::get('/reference/address/create/commission', 'Frontend\ReferenceController@createCommission')->name("createcommission");
Route::post('/reference/address/create/commission', 'Frontend\ReferenceController@createCommission')->name("createcommission");

Route::get('/reference/factorycountry', 'Frontend\ReferenceController@indexFactoryCountry');
Route::post('/reference/factorycountry', 'Frontend\ReferenceController@indexFactoryCountry');

Route::get('/reference/org', 'Frontend\ReferenceController@referenceOrg')->name("archiveorg");
Route::get('/reference/org/edit/{code}', 'Frontend\ReferenceController@referenceOrg');
Route::post('/reference/org', 'Frontend\ReferenceController@referenceOrg')->name("archiveorg");

Route::get('/reference/owner', 'Frontend\ReferenceController@indexOwner')->name("owner");
Route::post('/reference/owner', 'Frontend\ReferenceController@indexOwner')->name("owner");

Route::get('/reference/createowner/edit/{code}', 'Frontend\ReferenceController@createOwner');
Route::get('/reference/createowner/delete/{code}', 'Frontend\ReferenceController@deleteOwner');

Route::get('/reference/createowner', 'Frontend\ReferenceController@createOwner')->name("createowner");
Route::post('/reference/createowner', 'Frontend\ReferenceController@createOwner')->name("createowner");

Route::post('/reference/ownertwo', 'Frontend\ReferenceController@ownerTwo')->name("owner_two_reg");

Route::get('/reference/series', 'Frontend\ReferenceController@indexSeries');
Route::post('/reference/series', 'Frontend\ReferenceController@indexSeries');

Route::get('/reference/orderednumbers', 'Frontend\ReferenceController@orderedNumbers');
Route::post('/reference/orderednumbers', 'Frontend\ReferenceController@orderedNumbers');

Route::get('/settings/department', 'Frontend\SettingsController@indexDepartment')->name("refdepartment");
Route::post('/settings/department', 'Frontend\SettingsController@indexDepartment')->name("refdepartment");
Route::get('/reference/department/edit/{code}', 'Frontend\SettingsController@indexDepartment');
Route::get('/reference/department/delete/{code}', 'Frontend\SettingsController@deleteDepartment');

Route::get('/series/create', 'Frontend\SeriesController@createSeries')->name("createseries");
Route::post('/series/create', 'Frontend\SeriesController@createSeries')->name("createseries");
Route::get('/series/edit/{code}', 'Frontend\SeriesController@createSeries');

Route::get('/series/open', 'Frontend\SeriesController@openSeries')->name("openseries");
Route::post('/series/open', 'Frontend\SeriesController@openSeries')->name("openseries");
Route::get('/series/open/edit/{code}', 'Frontend\SeriesController@openSeries')->name("editseries");

Route::get('/series/open/list', 'Frontend\SeriesController@openSeriesList');
Route::post('/series/open/list', 'Frontend\SeriesController@openSeriesList');

Route::get('/series/send', 'Frontend\SeriesController@sendSeries')->name("sendSeries");
Route::post('/series/send', 'Frontend\SeriesController@sendSeries')->name("sendSeries");
Route::get('/series/send/edit/{code}', 'Frontend\SeriesController@sendSeries');

Route::get('/series/sent', 'Frontend\SeriesController@seriesSent')->name("sentfilter");
Route::post('/series/sent', 'Frontend\SeriesController@seriesSent')->name("sentfilter");

Route::get('/series/search', 'Frontend\SeriesController@searchSeries')->name("seriessearch");
Route::post('/series/search', 'Frontend\SeriesController@searchSeries')->name("seriessearch");

Route::get('/settings/department', 'Frontend\SettingsController@indexDepartment')->name("refdepartment");
Route::post('/settings/department', 'Frontend\SettingsController@indexDepartment')->name("refdepartment");
Route::get('/reference/department/edit/{code}', 'Frontend\SettingsController@indexDepartment');
Route::get('/reference/department/delete/{code}', 'Frontend\SettingsController@deleteDepartment');

Route::get('/settings/archive', 'Frontend\SettingsController@indexArchive')->name("archive");
Route::post('/settings/archive', 'Frontend\SettingsController@indexArchive')->name("archive");
Route::get('/settings/archive/edit/{code}', 'Frontend\SettingsController@indexArchive');
Route::get('/settings/archive/delete/{code}', 'Frontend\SettingsController@deleteArchive'); 

Route::post('/report/total', 'Frontend\ReportController@allVehicle')->name("total_vehicle");
Route::get('/report/total', 'Frontend\ReportController@allVehicle')->name("total_vehicle");

Route::get('/report/archive', 'Frontend\ReportController@indexArchive')->name("total_archive");
Route::post('/report/archive', 'Frontend\ReportController@indexArchive')->name("total_archive");

Route::get('/report/daily/transfer', 'Frontend\ReportController@indexDailyTransfer');
Route::post('/report/daily/transfer', 'Frontend\ReportController@indexDailyTransfer');

Route::get('/report/daily/import', 'Frontend\ReportController@indexDailyImport');
Route::post('/report/daily/import', 'Frontend\ReportController@indexDailyImport');

Route::get('/report/daily/department', 'Frontend\ReportController@indexDepartment');
Route::post('/report/daily/department', 'Frontend\ReportController@indexDepartment');

Route::get('/report/daily/users', 'Frontend\ReportController@indexDailyUser');
Route::post('/report/daily/users', 'Frontend\ReportController@indexDailyUser');

Route::get('/report/all/users', 'Frontend\ReportController@indexAllUser'); 
Route::post('/report/all/users', 'Frontend\ReportController@indexAllUser');

Route::get('/report/ePay/users', 'Frontend\ReportController@indexEpayUser'); 
Route::post('/report/ePay/users', 'Frontend\ReportController@indexEpayUser');

Route::get('/report/aging', 'Frontend\ReportController@indexAging');
Route::post('/report/aging', 'Frontend\ReportController@indexAging');

Route::get('/report/daily/users/info', 'Frontend\ReportController@indexDailyUserInfo');
Route::post('/report/daily/users/info', 'Frontend\ReportController@indexDailyUserInfo');

Route::get('/report/daily/newplate', 'Frontend\ReportController@indexDailyNewPlate');
Route::post('/report/daily/newplate', 'Frontend\ReportController@indexDailyNewPlate');

Route::get('/report/daily/vehicleref', 'Frontend\ReportController@indexDailyVehicleRef');
Route::post('/report/daily/vehicleref', 'Frontend\ReportController@indexDailyVehicleRef');

Route::get('/report/daily/vehicleref2', 'Frontend\ReportController@indexDailyVehicleRef2');
Route::post('/report/daily/vehicleref2', 'Frontend\ReportController@indexDailyVehicleRef2');

Route::get('/report/daily/vehiclerefold', 'Frontend\ReportController@indexDailyVehicleRefOld');
Route::post('/report/daily/vehiclerefold', 'Frontend\ReportController@indexDailyVehicleRefOld'); 

Route::get('/report/total/province', 'Frontend\ReportController@indexTotalProvince');
Route::post('/report/total/province', 'Frontend\ReportController@indexTotalProvince');

Route::get('/report/position/log', 'Frontend\ReportController@positionLog');
Route::post('/report/position/log', 'Frontend\ReportController@positionLog');

Route::get('/report/reportFactoryColor', 'Frontend\ReportController@reportFactoryColor');
Route::post('/report/reportFactoryColor', 'Frontend\ReportController@reportFactoryColor')->name('plateFactoryColor');


Route::get('/report/reportFactory', 'Frontend\ReportController@reportFactory');

Route::get('/report/reportFactoryPlate', 'Frontend\ReportController@reportFactoryPlate');

Route::post('/report/reportFactoryPlate', 'Frontend\ReportController@reportFactoryPlate')->name('reportFactoryPlate');

Route::post('/report/reportFactory', 'Frontend\ReportController@reportFactory')->name('reportFactory');
Route::post('/report/reportFactoryView', 'Frontend\ReportController@reportFactoryView')->name('plateFactoryView');

Route::get('/report/form', 'Frontend\ReportController@indexForm');
Route::post('/report/form', 'Frontend\ReportController@indexForm');

Route::get('/send/issue', 'Frontend\HelperController@createIssue')->name("issue");
Route::post('/send/issue', 'Frontend\HelperController@createIssue')->name("issue");
Route::get('/send/issue/{id}', 'Frontend\HelperController@createIssue');

Route::get('/issues', 'Frontend\HelperController@issueList');
Route::post('/issues', 'Frontend\HelperController@issueList');




Route::get('/mehanizm/search', 'Frontend\SeriesController@searchMehanizm')->name("seriessearchmehanizm");
Route::post('/mehanizm/search', 'Frontend\SeriesController@searchMehanizm')->name("seriessearchmehanizm");

Route::get('/plate/print', 'Frontend\PlateFactoryController@index')->name("plate_print");
Route::post('/plate/print', 'Frontend\PlateFactoryController@index')->name("plate_print");

Route::get('/report/user/certificate', 'Frontend\ReportController@certificate')->name("certificate");
Route::post('/report/user/certificate', 'Frontend\ReportController@certificate')->name("certificate");

Route::get('/report/vehicle/remove', 'Frontend\ReportController@remove');
Route::post('/report/vehicle/remove', 'Frontend\ReportController@remove');

Route::get('/report/plateSaveReport', 'Frontend\ReportController@reportPlateSave');
Route::post('/report/plateSaveReport', 'Frontend\ReportController@reportPlateSave')->name("plateSaveReport");

Route::get('/archive/documentArNtr/{number}', 'Frontend\VehicleSearchController@searchArchive3')->name("search_archive3");
Route::get('/archive/documentAr/{number}', 'Frontend\VehicleSearchController@searchArchive2')->name("search_archive2");
Route::get('/archive/document/{number}', 'Frontend\VehicleSearchController@searchArchive')->name("search_archive");


Route::get('/excel/result', 'Frontend\VehicleSearchController@excelResult');


Route::get('/plateSavePay', 'Frontend\PaymentController@plateSavePay');
Route::get('/plateSave', 'Frontend\PlateNumberSaveController@indexSavePlate');
Route::post('/plateSave', 'Frontend\PlateNumberSaveController@indexSavePlate')->name("plateSave");

Route::get('/plateSave/indexSavePlateStore', 'Frontend\PlateNumberSaveController@indexSavePlateStore');
Route::post('/plateSave/indexSavePlateStore', 'Frontend\PlateNumberSaveController@indexSavePlateStore');
Route::post('/plateSave/store', 'Frontend\PlateNumberSaveController@plateSaveStore')->name("plateSaveStore");
Route::get('/plateSave/edit', 'Frontend\PlateNumberSaveController@plateSaveEdit');
Route::post('/plateSave/edit', 'Frontend\PlateNumberSaveController@plateSaveEdit')->name("plateSaveUpdate");
Route::get('/plateSave/plateNumberSaveOrder', 'Frontend\PlateNumberSaveController@plateSaveOrder');
Route::post('/plateSave/plateNumberSaveOrder', 'Frontend\PlateNumberSaveController@plateSaveOrder')->name("plateSaveOrder");
Route::post('/plateSave/plateOrderCancel', 'Frontend\PlateNumberSaveController@plateOrderCancel')->name("plateOrderCancel");

Route::get('/plateSave/plateNumberOrderList', 'Frontend\PlateNumberSaveController@plateNumberOrderList');
Route::post('/plateSave/plateNumberOrderList', 'Frontend\PlateNumberSaveController@plateNumberOrderList')->name("plateOrderList");
Route::get('/recovery/vehiclePlateRecovery', 'Frontend\VehicleController@vehiclePlateRecovery');
Route::post('/recovery/vehiclePlateRecovery', 'Frontend\VehicleController@vehiclePlateRecovery')->name('vehiclePlateRecover');
Route::get('/testPdf', 'TestPdfController@testPdf');
