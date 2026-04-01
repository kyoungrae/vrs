<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RefReferenceOrg extends Model
{
    /**
     * Устгасан үеийн огноог авна
     * @var array
     */
    protected $primaryKey = 'Id';
    const CREATED_AT = 'CreatedDate';
    const UPDATED_AT = 'UpdatedDate';
    protected $table = 'REF_REFERENCE_ORG';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Id',
        'Name',
        'CreatedBy', //Лавлагаа гаргасан
        'CreatedDate',
        'ModifiedBy', //Лавлагаа зассан
        'ModifiedDate'
    ];
}
