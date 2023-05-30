<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MDataPhysicalFinding extends Model
{
    protected $table = 'MDataPhysicalFinding';

    protected $fillable = [
        'MDPhysicalFindingId','PatientId','CollectionDate','PhysicalFinding',
        'Status','CreateUser','CreateDate','UpdateUser','UpdateDate','OrgId'
    ];

    public $timestamps = false;
}
