<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AddressSubDev extends Model
{
    /**
     * Устгасан үеийн огноог авна
     * @var array
     */
    protected $primaryKey = 'Id';
    const CREATED_AT = 'CreatedDate';
    const UPDATED_AT = 'ModifiedDate';
    protected $table = 'ADDRESS_SUBDEV';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Id',
        'Province_Id',
        'Name',
        'CreatedBy',
        'ModifiedBy'
    ];
}
