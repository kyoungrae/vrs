<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegReferenceLog extends Model
{
    /**
     * Устгасан үеийн огноог авна
     * @var array
     */
    protected $primaryKey = 'Id';
    const CREATED_AT = 'CreatedDate';
    const UPDATED_AT = 'ModifiedDate';
    protected $table = 'REG_REFERENCE_LOG';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Id',
        'Ref_Type', //Одоогийн ТХ болон Өмнөх ТХ
        'Type_Id', //Өөрийн хүсэлтээр болон Эрх бүхий байгууллага
        'User_Type_Id', //Хувь хүн болон албан байгууллага
        'User_Id', //Хувь хүн болон албан байгууллага ID
        'DocNumber', //Тоотын дугаар
        'Vehicle_Count', //Нэг лавлагаагаар авсан ТХ -ийн тоо
        'Request_Type', //Нэг лавлагаагаар авсан ТХ -ийн тоо
        'Request_Name', //Нэг лавлагаагаар авсан ТХ -ийн тоо
        'Description', //Хурууны хээ болон дугаар тайлбар
        'CreatedBy', //Лавлагаа гаргасан
        'CreatedDate',
        'ModifiedBy', //Лавлагаа зассан
        'ModifiedDate'
    ];
}
