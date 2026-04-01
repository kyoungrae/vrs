<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SystemPrinter extends Model
{
    /**
     * Устгасан үеийн огноог авна
     * @var array
     */
    protected $primaryKey = 'Id';
    const CREATED_AT = 'CREATED_DATE';
    const UPDATED_AT = 'UPDATED_DATE';
    protected $table = 'SYSTEM_PRINTER';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Id',
        'NAME',
        'X',
        'Y',
        'LINE',
        'TEXT'
    ];
}
