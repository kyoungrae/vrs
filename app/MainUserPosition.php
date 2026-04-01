<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MainUserPosition extends Model
{
    use SoftDeletes;
    /**
     * Устгасан үеийн огноог авна
     * @var array
     */
    protected $primaryKey = 'ID';
    protected $dates = ['deleted_at'];
    const CREATED_AT = 'CREATEDDATE';
    const UPDATED_AT = 'MODIFIEDDATE';
    protected $table = 'SYSTEM_POSITION';
    protected $connection = 'oracle';

    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);
        if ($key === 'Id' || $key === 'id') return $this->attributes['ID'] ?? null;
        if ($key === 'Name' || $key === 'name') return $this->attributes['NAME'] ?? null;
        return $value;
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Id',
        'Name',
        'CreatedBy',
        'ModifiedBy',
        'deleted_at'
    ];
}
