<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EpayTransaction extends Model
{
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $table = 'EPAY_TRANSACTION';
    protected $fillable = [
        
        'TRANSACTION_ID',
        'VEHICLE_ID',
        'ARKHIVE_NO',
        'AMOUNT',
        'PAY_TYPE',
        'CREATED_BY',
        'CREATED_AT',
        'PAY_TYPE_NAME',
        'SERVICE_TYPE',
        'SERVICE_ID'
     ];
}
