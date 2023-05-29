<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MDataGlucoseHb extends Model
{
    protected $table = 'MDataGlucoseHb';
    protected $fillable = [
        'Id','PatientId','CollectionDate','RBG','FBG','HrsFromLastEat','Hemoglobin','Status','CreateDate','CreateUser','UpdateDate','UpdateUser','OrgId'
    ];
    public $timestamps = false;
}
