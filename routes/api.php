<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| 
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API! 
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/paymentData', 'Frontend\ServiceController@payment');
Route::post('/vehCheck', 'Frontend\ServiceController@vehCheck');
Route::post('/plateEditCheck', 'Frontend\PlateNumberSaveController@plateEditCheck');


Route::post('892890790756ed1afb457ea2be616', 'Frontend\AutoboxController@getConflictData');
Route::post('dOo0KXQkdCQ0K_QoCIsImxhc3RuYW1lIjoi0JTQsNC70YXQsN', 'Frontend\AutoboxController@createOwnerAutobox');
Route::get('dOo0KXQkdCQ0K_QoCIsImxhc3RuYW1lIjoi0JTQsNC70YXQsRDsd', 'Frontend\AutoboxController@indexBurtgelAutoBox');
Route::post('dOo0KXQkdCQ0K_QoCIsImxhc3RuYW1lIjoi0JTQsNC70YXQsRDsd', 'Frontend\AutoboxController@indexBurtgelAutoBox');
Route::post('transaction', 'Frontend\ServiceController@transactionCheck');
Route::post('auctionCheck', 'Frontend\ServiceController@auction');
Route::post('removeVehicleCheck', 'Frontend\ServiceController@removeVehicleSearch');
Route::post('plateSaveVehicleSearch', 'Frontend\ServiceController@plateSaveVehicleSearch');
Route::post('plateSaveVehicleOrder', 'Frontend\ServiceController@plateSaveVehicleOrder');
Route::post('location', 'Frontend\AjaxController@district');
Route::post('carmodel', 'Frontend\AjaxController@model');
Route::post('carmark', 'Frontend\AjaxController@mark');
Route::post('owner_deps', 'Frontend\AjaxController@owner_deps');
Route::post('depusers', 'Frontend\AjaxController@departmentUsers');
Route::post('depseries', 'Frontend\AjaxController@departmentSeries');
Route::post('numbers', 'Frontend\AjaxController@numberList');
Route::post('createowner', 'Frontend\AjaxController@createOwner');
Route::post('checkprintplate', 'Frontend\PlateFactoryController@checkPrintPlate');
Route::post('owner', 'Frontend\AjaxController@owner');
Route::post('/history/ownertwo', 'Frontend\AjaxController@ownerTwo');
Route::post('/history/vehiclelimit', 'Frontend\AjaxController@vehicleLimit');
Route::post('/history/vehicleanothers', 'Frontend\AjaxController@vehicleAnothers');
Route::post('/history/vehiclearchive', 'Frontend\AjaxController@vehicleActionHistory');
Route::post('/history/vehicleowners', 'Frontend\AjaxController@vehicleOwners');
Route::post('/history/vehicleowners1', 'Frontend\AjaxController@vehicleOwners1');
Route::post('/reference/log', 'Frontend\AjaxController@referenceLog');
Route::post('getPrinterConfig', 'Frontend\AjaxController@printerList');
Route::post('savePrinterConfig', 'Frontend\AjaxController@printerSave');
Route::post('getSeriesList', 'Frontend\AjaxController@getSeriesList');
Route::post('createPrintCertificate', 'Frontend\AjaxController@createPrintCertificate');
Route::post('rest_vehicle_info_data_test', 'Frontend\AjaxController@getVehicleInfo');

Route::post('fingerInfoImage', 'Frontend\ServiceController@service1');
Route::post('gaali', 'Frontend\ServiceController@service2');
Route::post('penalty', 'Frontend\ServiceController@service3');
Route::post('tax', 'Frontend\ServiceController@service4');
Route::get('wayPayLogin', 'Frontend\ServiceController@wayPayLogin');
Route::post('wayPay', 'Frontend\ServiceController@service5');
Route::post('serviceNTRLogin', 'Frontend\ServiceController@serviceNTRLogin2');
Route::post('ntrLogin3', 'Frontend\ServiceController@ntrLogin3');
Route::post('NtrRestWS', 'Frontend\ServiceController@NtrRestWS');

Route::post('getRequestList', 'Frontend\ServiceController@getRequestList');


Route::get('/report/exportToExcelFlateColor/{type}/{startDate}/{endDate}', 'Frontend\ReportController@exportToExcelFlateColor');


Route::get('/report/allvehicle/{startDate}/{endDate}', 'Frontend\ReportController@exportToExcelItem');
Route::get('/report/archivevehicle/{op}/{start}/{end}', 'Frontend\ReportController@exportToExcelArchive');
Route::get('/report/archiveusers/{user}/{start}/{end}', 'Frontend\ReportController@exportToExcelDailyUser');
Route::get('/report/department/{department}/{start}/{end}', 'Frontend\ReportController@exportToExcelDepartment');
Route::get('/report/archiveusers/info/{branch}/{user}/{start}/{end}', 'Frontend\ReportController@exportToExcelDailyUserInfo');
Route::get('/report/archivetransfer/{branch}/{start}/{end}', 'Frontend\ReportController@exportToExcelDailyTransfer');
Route::get('/report/exportdaily/{branch}/{start}/{end}', 'Frontend\ReportController@exportToExcelDailyImport');
Route::get('/report/all/users/{op}/{pos}/{start}/{end}', 'Frontend\ReportController@exportToExcelAllUser');

Route::get('/report/epay/users/{op}/{userId}/{start}/{end}', 'Frontend\ReportController@exportToExcelEpayReportr');

Route::get('/report/newplate/{branch}/{start}/{end}', 'Frontend\ReportController@exportToExcelDailyNewPlate');
Route::get('/report/exportToExcelVehicleRef/{register}/{last}/{first}', 'Frontend\ReportController@exportToExcelVehicleRef');
Route::get('/report/exportToExcelVehicleRef2/{register}/{last}/{first}', 'Frontend\ReportController@exportToExcelVehicleRef2');
Route::get('/report/exportToExcelVehicleRefOld/{register}/{last}/{first}', 'Frontend\ReportController@exportToExcelVehicleRefOld');
Route::get('/report/aging/{pro}/{start}', 'Frontend\ReportController@exportToExcelAging');
Route::get('/report/position/log/{op}/{start}/{end}', 'Frontend\ReportController@exportToExcelPositionLog');
Route::get('/report/total/province/{start}/{end}', 'Frontend\ReportController@exportToExcelTotalProvince');
Route::get('/report/certificate/{user}/{start}/{end}', 'Frontend\ReportController@exportToExcelCertificate');
Route::get('/report/vehicleremove/{start}/{end}', 'Frontend\ReportController@exportToExcelRemove');

Route::get('/report/exportToExcelPlateSave/{startDate}/{endDate}', 'Frontend\ReportController@exportToExcelPlateSave');