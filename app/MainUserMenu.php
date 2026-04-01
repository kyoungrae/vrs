<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MainUserMenu extends Model
{
    /**
     * Устгасан үеийн огноог авна
     * @var array
     */
    protected $primaryKey = 'ID';
    const CREATED_AT = 'CREATE_DATE';
    const UPDATED_AT = 'UPDATE_DATE';
    protected $table = 'SYSTEM_MENU';
    protected $connection = 'oracle';

    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);
        if ($key === 'Id' || $key === 'id' || $key === 'ID') return $this->attributes['ID'] ?? $this->attributes['id'] ?? null;
        if ($key === 'URL' || $key === 'url') return $this->attributes['URL'] ?? $this->attributes['url'] ?? null;
        if ($key === 'Name' || $key === 'name') return $this->attributes['NAME'] ?? $this->attributes['name'] ?? null;
        return $value;
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Id',
        'IS_PARENT',
        'Name',
        'ORDR',
        'ICON',
        'DESCRIPTION',
        'URL',
        'CreatedBy',
        'ModifiedBy'
    ];
}
