<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehicleArchive extends Model
{
    /**
     * Устгасан үеийн огноог авна
     * @var array
     */
    protected $primaryKey = 'Id';
    const CREATED_AT = 'CREATED_DATE';
    const UPDATED_AT = 'UPDATED_DATE';
    protected $table = 'REG_VEHICLE_ARCHIVE';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Id',
        'PLATE_NO',
        'CABIN_NO',
        'ENGINE_NO',
        'COLOR_ID',
        'CERTIFICATE_NO',
        'IMPORT_DATE',
        'DECLARATION_NO',
        'MODEL_ID',
        'SPECIAL_ID',
        'BUILD_YEAR',
        'BUILD_MONTH',
        'PAR_TYPE_ID',
        'OWNER_ID',
        'ARCHIVE_DEPARTMENT',
        'ARCHIVE_ABBR',
        'ARCHIVE_NO',
        'FIRST_ARCHIVE_NO',
        'PAGE_COUNT',
        'DESCRIPTION',
        'IS_ENABLED',
        'IS_STOLEN',
        'IS_WARNING',
        'WHEEL_ID',
        'STEERING_TYPE_ID',
        'ENGINE_MODEL_ID',
        'PAR_MARKER_ID',
        'STATUS',
        'IS_PENDING',
        'OLD_PROVINCE_ID',
        'PROVINCE_ID',
        'VIN_NO',
        'COLOR_NAME',
        'COUNTRY_ID',
        'MARK_ID',
        'MARK_NAME',
        'MODEL_NAME',
        'VEHICLE_ID',
        'SERVICE_ID',
        'SERVICE_NAME',
        'INSERT_CERTIFICATE_NO',
        'INSERT_ARCHIVE_NO',
        'INSERT_PLATE_NO',
        'INSERT_SERVICE_ID',
        'INSERT_MODEL_ID',
        'INSERT_OWNER_ID',
        'INSERT_PAGE_COUNT',
        'INSERT_FINGER',
        'INSERT_FINGER_DESCRIPTION',
        'INSERT_DESCRIPTION',
        'CREATED_BY',
        'UPDATED_BY'
    ];
}
