<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    /**
     * Устгасан үеийн огноог авна
     * @var array
     */
    protected $primaryKey = 'Id';
    const CREATED_AT = 'Create_Date';
    const UPDATED_AT = 'Update_Date';
    protected $table = 'SERIES';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Id',
        'NAME',
        'TYPE',
        'PROVINCE_ID',
        'IS_DUPLICATE',
        'IS_OLD',
        'IS_CHECK_ADDRESS',
        'Created_By_Id',
        'Updated_By_Id'
    ];
}
