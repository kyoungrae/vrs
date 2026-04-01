<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use OwenIt\Auditing\Contracts\Auditable;
class Owner extends Model 
{
  //  use \OwenIt\Auditing\Auditable;
    /**
     * Устгасан үеийн огноог авна
     * @var array
     */
    protected $primaryKey = 'id';
    const CREATED_AT = 'Create_Date';
    const UPDATED_AT = 'Update_Date';
    protected $table = 'OWNER';
    /**
     * The attributes that are mass assignable.
     *
     * @var array 
     */
    protected $fillable = [
        'Id',
        'NAME',
        'ADDRESS_DETAIL',
        'APARTMENT_NO',
        'CELLPHONE',
        'CIVIL_ID',
        'DOOR_NO',
        'FAMILY_NAME',
        'FIRST_NAME',
        'GENDER',
        'HOMEPHONE',
        'LAST_NAME',
        'MORE_INFO',
        'REGISTER_NO',
        'STREET',
        'WorkPhone',
        'COUNTRY_ID',
        'TYPE_ID',
        'PROVINCE_ID',
        'DEVISION_UNIT_ID',
        'MICRO_DISTRICT_ID',
        'DISTRICT_ID',
        'OLD_ID',
        'ZIP',
        'ORDER_QTY',
        'Created_By_Id',
        'Updated_By_Id'
    ];
}
