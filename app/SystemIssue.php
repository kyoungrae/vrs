<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SystemIssue extends Model
{
    /**
     * Устгасан үеийн огноог авна
     * @var array
     */
    protected $primaryKey = 'Id';
    const CREATED_AT = 'OPEN_DATE';
    const UPDATED_AT = 'CLOSE_DATE';
    protected $table = 'SYSTEM_ISSUE';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Id',
        'OPEN_USER_ID',
        'CLOSE_USER_ID',
        'QUESTION',
        'ANSWER',
        'QUESTION_IMAGE',
        'ANSWER_IMAGE',
        'PHONE_NO',
        'STATUS',
        'OPEN_DATE',
        'CLOSE_DATE'
    ];

    public function getUser($Id){
        $user = MainUser::where("ID", $Id)->get()->first();
        return $user->lastname." ".$user->firstname;
    }
}
