<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArchiveNumber extends Model
{
    protected $primaryKey = 'Id';
    const CREATED_AT = 'CREATEDDATE';
    const UPDATED_AT = 'UPDATEDDATE';
    protected $table = 'ARCHIVE_NUMBER';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Id',
        'MONTH',
        'YEAR',
        'ABBR',
        'ARCHIVE_DEPARTMENT_ID',
        'NEW_COUNT',
        'OTHER_COUNT',
        'DELETE_COUNT',
        'CREATEDBY',
        'MODIFIEDBY'
    ];
}
