<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Translatable;

class BaseModel extends Model
{
    use Translatable;
}
