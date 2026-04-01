<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PositionLog extends Model
{
    /**
     * Устгасан үеийн огноог авна
     * @var array
     */
    protected $primaryKey = 'Id';
    public $timestamps = false;
    protected $table = 'SYSTEM_POSITION_LOG';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Id',
        'Name',
        'Action_Id',
        'Position_Id',
        'Type_Id',
        'CreatedDate',
        'CreatedBy',
        'UpdatedBy'
    ];
}
