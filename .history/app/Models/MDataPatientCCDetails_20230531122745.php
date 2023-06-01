<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MDataPatientCCDetails extends Model
{
    protected $table = 'MDataPatientCCDetails';
    protected $fillable = [
        'MDCCId','PatientId','CollectionDate','CCId','ChiefComplain','DurationId','CCDurationValue','OtherCC',
        'Nature','Status','CreateDate','CreateUser','UpdateDate','UpdateUser','OrgId'
    ];
    public $timestamps = false;
}
