<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SeriesNumber extends Model
{
    /**
     * Устгасан үеийн огноог авна
     * @var array
     */
    protected $primaryKey = 'Id';
    const CREATED_AT = 'Create_Date';
    const UPDATED_AT = 'Update_Date';
    protected $table = 'SERIES_NUMBER';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Id',
        'NAME',
        'IS_GIVEN',
        'IS_HIDDEN',
        'IS_LOCAL',
        'IS_OPENED',
        'LIMITED_DAY',
        'NO',
        'ORDER_DATE',
        'ORDER_USER',
        'ORDER_CABIN',
        'TYPE',
        'SERIES_ID',
        'VEHICLE_ID',
        'IS_ORDER',
        'IS_AUTO',
        'SHOW_DATE',
        'WEEKEND',
        'IP_ADDRESS',
        'IP_INFO',
        'LOCAL_USER_ID',
        'Created_By_Id',
        'Updated_By_Id'
    ];
}
