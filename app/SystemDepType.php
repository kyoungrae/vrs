<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SystemDepType extends Model
{
   
   protected $primaryKey = 'Id';
  
   protected $table = 'SYSTEM_DEPTYPE';
   /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
   protected $fillable = [
       'Id',
       'name'
   ];

}
