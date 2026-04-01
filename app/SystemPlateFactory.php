<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SystemPlateFactory extends Model
{
    protected $primaryKey = 'Id';
    const CREATED_AT = 'CREATE_DATE';
    const UPDATED_AT = 'UPDATE_DATE';
    protected $table = 'SYSTEM_PLATE_FACTORY';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Id',
        'TYPE_ID',
        'PLATE_NO',
        'SERVICE_ID',
        'USER_ID',
        'PRINT_ID',
        'IS_PRINT',
        'PLATECOLOR',
        'CREATE_DATE',
        'UPDATE_DATE'
    ];
}
