<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Owner1Ship extends Model
{
    protected $primaryKey = 'Id';
    const CREATED_AT = 'CREATED_DATE';
    const UPDATED_AT = 'UPDATED_DATE';
    protected $table = 'REG_VEHICLE_OWNER1SHIP';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Id',
        'VEHICLE_ID',
        'OWNER1_ID',
        'START_DATE',
        'END_DATE',
        'OWNERSHIP_TYPE_ID',
        'STATUS',
        'CREATED_BY',
        'UPDATED_BY'
    ];
}
