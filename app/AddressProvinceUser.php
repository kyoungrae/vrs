<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AddressProvinceUser extends Model
{
    /**
     * Устгасан үеийн огноог авна
     * @var array
     */
    protected $primaryKey = 'Id';
    const CREATED_AT = 'CreatedDate';
    const UPDATED_AT = 'ModifiedDate';
    protected $table = 'ADDRESS_PROVINCE_OLD';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Id',
        'Name',
        'CreatedBy',
        'ModifiedBy'
    ];
}
