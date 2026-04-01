<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SeriesInterval extends Model
{
    /**
     * Устгасан үеийн огноог авна
     * @var array
     */
    protected $primaryKey = 'Id';
    const CREATED_AT = 'Create_Date';
    const UPDATED_AT = 'Update_Date';
    protected $table = 'SERIES_INTERVAL';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Id',
        'NAME',
        'FROM_NUMBER',
        'TO_NUMBER',
        'LOCAL_USER_ID',
        'SERIES_ID',
        'IS_LOCAL',
        'IS_ORDER',
        'IS_HIDDEN',
        'IS_OPENED',
        'IS_AUTO',
        'TYPE',
        'Created_By_Id',
        'Updated_By_Id'
    ];
}
