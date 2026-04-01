<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AddressSubDevUnit extends Model
{
    /**
     * Устгасан үеийн огноог авна
     * @var array
     */
    protected $primaryKey = 'Id';
    const CREATED_AT = 'Create_Date';
    const UPDATED_AT = 'Update_Date';
    protected $table = 'ADDRESS_SUBDEV_UNIT';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Id',
        'DEVISION_ID',
        'Name',
        'Created_By_Id',
        'Updated_By_Id'
    ];
}
