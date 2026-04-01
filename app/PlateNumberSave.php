<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Notifications\Notifiable;
//use OwenIt\Auditing\Contracts\Auditable;
class PlateNumberSave extends Model 
{

    protected $primaryKey = 'Id';
    const CREATED_AT = 'CREATE_DATE';
    const UPDATED_AT = 'UPDATE_DATE';
    protected $table = 'REG_PLATENUMBER_SAVE';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
  
    protected $fillable = [
        'Id',
        'VEHICLE_ID',
        'OWNER_ID',
        'ARCHIVE_NUMBER',
        'IS_DELETE',
        'IS_ACTIVE',
        'EXTEND_COUNT',
        'PLATE_NO',
        'CUSTOMER_REGNUM',
        'CUSTOMER_LASTNAME',
        'CUSTOMER_FIRSTNAME',
        'CUSTOMER_PHONE',
        'BEGIN_DATE',
        'END_DATE',
        'CREATED_BY',
        'CREATE_DATE',
        'UPDATED_BY',
        'UPDATE_DATE',
        'DELETED_BY',
        'DELETE_AT'
    ];
  

    
    
}
