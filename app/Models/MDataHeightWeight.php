<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Patient;

class MDataHeightWeight extends Model
{
    protected $table = 'MDataHeightWeight';
    protected $fillable = [
        'Id','PatientId','CollectionDate','Height','Weight','BMI','BMIStatus','MUAC','MUACStatus','RefBloodGroupId','Status','CreateDate','CreateUser','UpdateDate','UpdateUser','OrgId'
    ];
    public $timestamps = false;

    public function patient()
    {
      return $this->belongsTo(Patient::class, 'PatientId', 'PatientId');
    }
}
