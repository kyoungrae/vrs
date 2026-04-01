<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegLimited extends Model
{
    /**
     * Устгасан үеийн огноог авна
     * @var array
     */
    protected $primaryKey = 'Id';
    const CREATED_AT = 'CreatedDate';
    const UPDATED_AT = 'ModifiedDate';
    protected $table = 'REG_LIMITED';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Id',
        'Name',
        'Dec_date',
        'Dec_No',
        'Phone_No',
        'Type_Id',
        'Vehicle_Id',
        'Restore_User_Id',
        'Is_Restored',
        'End_Date',
        'Restore_Dec_no',
        'Restore_Type_Id',
        'CreatedBy',
        'ModifiedBy'
    ];
}
