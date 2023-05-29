<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MDataInvestigation extends Model
{
    protected $table = "MDataInvestigation";

    protected $fillable = [
        'MDInvestigationId','PatientId','CollectionDate','InvestigationId','OtherInvestigation','Instruction',
        'PositiveNegativeStatus','Status','CreateUser','CreateDate','UpdateUser','UpdateDate','OrgId'
    ];

    public $timestamps = false;
}
