<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SystemArchive extends Model
{
    /**
     * Устгасан үеийн огноог авна
     * @var array
     */
    protected $primaryKey = 'ID';
    const CREATED_AT = 'CREATEDDATE';
    const UPDATED_AT = 'MODIFIEDDATE';
    protected $table = 'SYSTEM_ARCHIVE';
    protected $connection = 'oracle';

    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);
        if ($key === 'Id' || $key === 'id') return $this->attributes['ID'] ?? null;
        if ($key === 'ProvinceId' || $key === 'provinceid') return $this->attributes['PROVINCEID'] ?? null;
        if ($key === 'DepartmentId' || $key === 'departmentid') return $this->attributes['DEPARTMENTID'] ?? null;
        if ($key === 'Archive' || $key === 'archive') return $this->attributes['ARCHIVE'] ?? null;
        if ($key === 'Abbr' || $key === 'abbr') return $this->attributes['ABBR'] ?? null;
        if ($key === 'IsType' || $key === 'is_type' || $key === 'istype') return $this->attributes['IS_TYPE'] ?? null;
        return $value;
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Id',
        'ProvinceId',
        'DepartmentId',
        'Archive',
        'Abbr',
        'CreatedBy',
        'ModifiedBy'
    ];
}
