<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegCertificate extends Model
{
    /**
     * Устгасан үеийн огноог авна
     * @var array
     */
    protected $primaryKey = 'Id';
    public $timestamps = false;
    protected $table = 'REG_CERTIFICATE';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Id',
        'USER_ID',
        'CERTIFICATE_NO',
        'CREATED_DATE',
        'VEHICLE_ID',
        'SERVICE_ID',
        'FEE',
        'VEHICLE_PLATE'
    ];
}
