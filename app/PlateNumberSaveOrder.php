<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Notifications\Notifiable;
//use OwenIt\Auditing\Contracts\Auditable;
class PlateNumberSaveOrder extends Model 
{

    protected $primaryKey = 'Id';
    const CREATED_AT = 'CREATE_DATE';
    const UPDATED_AT = 'UPDATE_DATE';
    protected $table = 'REG_PLATENUMBER_SAVE_ORDER';
    /**
     * The attributes that are mass assignable.REG_PLATENUMBER_SAVE_ORDER
     *
     * @var array
     */
  
    protected $fillable = [
        'Id',
       
    
        'PLATE_NO',
        'CABIN',
        'CUSTOMER_REGNUM',
        'CUSTOMER_LASTNAME',
        'CUSTOMER_FIRSTNAME',
        'CREATED_BY',
        'CREATE_DATE',
        'UPDATED_BY',
        'UPDATE_DATE',
        
       
    ];
  

    
    
}
