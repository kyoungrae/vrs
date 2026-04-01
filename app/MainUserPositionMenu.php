<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MainUserPositionMenu extends Model
{
    /**
     * Устгасан үеийн огноог авна
     * @var array
     */
    protected $primaryKey = 'ID';
    const CREATED_AT = 'CreatedDate';
    const UPDATED_AT = 'UpdatedDate';
    protected $table = 'SYSTEM_USER_MENU';
    protected $connection = 'oracle';

    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);
        if ($key === 'Id' || $key === 'id') return $this->attributes['ID'] ?? null;
        if ($key === 'Action_Id' || $key === 'action_id') return $this->attributes['ACTION_ID'] ?? null;
        if ($key === 'Position_Id' || $key === 'position_id') return $this->attributes['POSITION_ID'] ?? null;
        if ($key === 'Type_Id' || $key === 'type_id') return $this->attributes['TYPE_ID'] ?? null;
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
        'Action_Id',
        'Position_Id',
        'Type_Id',
        'CreatedBy',
        'UpdatedBy'
    ];
}
