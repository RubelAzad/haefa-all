<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MDataRxDetails extends Model
{
    protected $table = 'MDataRxDetails';

    protected $fillable = [
        'RxId','PatientId','CollectionDate','Rx','DurationId','RxDurationValue',
        'Status','CreateUser','CreateDate','UpdateUser','UpdateDate','OrgId'
    ];

    public $timestamps = false;
}
