<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MDataFamilyIllnessHistory extends Model
{
    protected $table = "MDataFamilyIllnessHistory";

    protected $fillable = [
        'MDFollowUpDateId','PatientId','CollectionDate','FollowUpDate','Status','CreateUser',
        'CreateDate','UpdateUser','UpdateDate','OrgId','FollowupIndicator','Comment'
    ];

    public $timestamps = false;
}
