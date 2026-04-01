<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MainUserDepartment extends Model
{
    protected $primaryKey = 'Id';
    const CREATED_AT = 'CreatedDate';
    const UPDATED_AT = 'ModifiedDate';
    protected $table = 'SYSTEM_DEPARTMENT';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Id',
        'Name',
        'PROVINCE_ID',
        'department_type',
        'dep_license_number',
        'dep_license_start_date',
        'dep_license_end_date',
        'dep_register',
        'dep_director',
        'dep_phone',
        'dep_address',
        'CreatedBy',
        'ModifiedBy',
        'DELETED_AT',
    ];
}
