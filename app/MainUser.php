<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
//use OwenIt\Auditing\Contracts\Auditable;
class MainUser extends Authenticatable 
{
 //   use \OwenIt\Auditing\Auditable;
    use Notifiable;
    use SoftDeletes;
    /** 
     * Устгасан үеийн огноог авна
     * @var array
     */ 
    protected $primaryKey = 'ID';
    protected $dates = ['deleted_at'];
    const CREATED_AT = 'CREATEDDATE';
    const UPDATED_AT = 'MODIFIEDDATE';
    protected $table = 'SYSTEM_USER';
    protected $connection = 'oracle';
    public $incrementing = true;
    protected $sequence = 'SYSTEM_USER_SEQ';

    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);
        if ($key === 'Id' || $key === 'id') return $this->attributes['ID'] ?? $this->attributes['id'] ?? null;
        if ($key === 'UserName' || $key === 'username') return $this->attributes['USERNAME'] ?? $this->attributes['username'] ?? null;
        if ($key === 'Password' || $key === 'password') return $this->attributes['PASSWORD'] ?? $this->attributes['password'] ?? null;
        if ($key === 'IsActive' || $key === 'isactive') return $this->attributes['ISACTIVE'] ?? $this->attributes['isactive'] ?? null;
        if ($key === 'UserPositionId' || $key === 'userpositionid') return $this->attributes['USERPOSITIONID'] ?? $this->attributes['userpositionid'] ?? null;
        if ($key === 'UserDepartmentId' || $key === 'userdepartmentid') return $this->attributes['USERDEPARTMENTID'] ?? $this->attributes['userdepartmentid'] ?? null;
        if ($key === 'ProvinceId' || $key === 'provinceid') return $this->attributes['PROVINCEID'] ?? $this->attributes['provinceid'] ?? null;
        if ($key === 'IsAtvt' || $key === 'isatvt') return $this->attributes['ISATVT'] ?? $this->attributes['isatvt'] ?? null;
        if ($key === 'IsCity' || $key === 'iscity') return $this->attributes['ISCITY'] ?? $this->attributes['iscity'] ?? null;
        if ($key === 'LAST_CHANGE_PASSWORD' || $key === 'last_change_password') return $this->attributes['LAST_CHANGE_PASSWORD'] ?? $this->attributes['last_change_password'] ?? null;
        if ($key === 'Session_Id' || $key === 'session_id' || $key === 'SESSION_ID') return $this->attributes['SESSION_ID'] ?? $this->attributes['session_id'] ?? null;
        return $value;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $auditInclude = [
        'LastName',
        'FirstName',
        'UserName',
        'LAST_CHANGE_PASSWORD',
        'Email',
        'Phone',
        'deleted_at'
    ];
    protected $fillable = [
        'Id',
        'ProvinceId',
        'UserPositionId',
        'UserDepartmentId',
        'RefDepartmentArchiveId',
        'UserName',
        'FirstName',
        'LastName',
        'Email',
        'Phone',
        'Session_Id',
        'Password',
        'PasswordAnother',
        'IsActive',
        'IsAtvt',
        'IsCity',
        'LAST_CHANGE_PASSWORD',
        'CreatedBy',
        'ModifiedBy',
        'deleted_at'
    ];

    protected $casts = [
        'Id' => 'integer',
        'IsActive' => 'integer',
        'UserPositionId' => 'integer',
        'ProvinceId' => 'integer',
        'UserDepartmentId' => 'integer',
        'CreatedBy' => 'integer',
        'ModifiedBy' => 'integer',
    ];
  
    protected $hidden = [
        'Password', 'remember_token',
    ];
  
    public function getAuthPassword()
    {
        return $this->Password;
    }

    public function position()
    {
        return $this->belongsTo(MainUserPosition::class, 'UserPositionId', 'Id');
    }
}
