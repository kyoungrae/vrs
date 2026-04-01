<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MainService extends Model
{
    /**
     * Устгасан үеийн огноог авна
     * @var array
     */
    protected $primaryKey = 'Id';
    const CREATED_AT = 'CreatedDate';
    const UPDATED_AT = 'ModifiedDate';
    protected $table = 'SYSTEM_SERVICE';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'PkId',
        'Code',
        'Name',
        'ServicePrefix',
        'Fee',
        'Icon',
        'Description',
        'View_Order',
        'Is_Show',
        'URL',
        'CreatedBy',
        'ModifiedBy'.
        'DELETED_AT'
    ];
}
