<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $primaryKey = 'id'; 
    public $timestamps = false;
    protected $table = 'TRANSACTION';

    protected $fillable = ['arkhive_no','description'];
}
