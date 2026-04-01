<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Archive extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'Id';
    const CREATED_AT = 'CREATEDDATE';
    const UPDATED_AT = 'MODIFIEDDATE';
    protected $table = 'SYSTEM_ARCHIVE';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Id',
        'PROVINCEID',
        'DEPARTMENTID',
        'ARCHIVE',
        'ABBR',
        'CREATEDBY',
        'MODIFIEDBY',
        'DELETED_AT'
    ];

    // public static function getDepartmentName($abbr){
    //     return Archive::where("ABBR", $abbr)->get()->first()->archive;
    // }
      public static function getDepartmentName($abbr) {
        $record = Archive::where("ABBR", $abbr)->first(); // No need for get() + first()
    
        return $record ? $record->archive : null; // or a fallback like 'Unknown'
    }
}
