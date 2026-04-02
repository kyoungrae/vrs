<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SystemArchive extends Model
{
    use SoftDeletes;
    
    /**
     * Устгасан үеийн огноог авна
     * @var array
     */
    protected $primaryKey = 'ID';
    const CREATED_AT = 'CREATEDDATE';
    const UPDATED_AT = 'MODIFIEDDATE';
    protected $table = 'SYSTEM_ARCHIVE';
    protected $connection = 'oracle';
    protected $dates = ['deleted_at'];

    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);
        
        // Try uppercase first (Oracle default), then lowercase
        if ($key === 'Id' || $key === 'id') 
            return $this->attributes['ID'] ?? $this->attributes['id'] ?? null;
        if ($key === 'ProvinceId' || $key === 'provinceid') 
            return $this->attributes['PROVINCEID'] ?? $this->attributes['provinceid'] ?? null;
        if ($key === 'DepartmentId' || $key === 'departmentid') 
            return $this->attributes['DEPARTMENTID'] ?? $this->attributes['departmentid'] ?? null;
        if ($key === 'Archive' || $key === 'archive') 
            return $this->attributes['ARCHIVE'] ?? $this->attributes['archive'] ?? null;
        if ($key === 'Abbr' || $key === 'abbr') 
            return $this->attributes['ABBR'] ?? $this->attributes['abbr'] ?? null;
        if ($key === 'IsType' || $key === 'is_type' || $key === 'istype') 
            return $this->attributes['IS_TYPE'] ?? $this->attributes['is_type'] ?? null;
        
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
        'IsType',
        'CreatedBy',
        'ModifiedBy'
    ];
}
