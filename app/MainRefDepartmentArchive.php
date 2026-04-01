<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MainRefDepartmentArchive extends Model
{
    use SoftDeletes;
    /**
     * Устгасан үеийн огноог авна
     * @var array
     */
    protected $primaryKey = 'PkId';
    protected $dates = ['deleted_at'];
    const CREATED_AT = 'CreatedDate';
    const UPDATED_AT = 'ModifiedDate';
    protected $table = 'main_ref_department_archive';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'PkId',
        'ProvincePkId',
        'DistrictPkId',
        'DepartmentPkId',
        'Name',
        'Abbr',
        'NewPrefix',
        'EditPrefix',
        'MovePrefix',
        'DeletePrefix',
        'OtherPrefix',
        'CreatedBy',
        'ModifiedBy',
        'deleted_at'
    ];

}
