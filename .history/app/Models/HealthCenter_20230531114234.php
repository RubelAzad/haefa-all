<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HealthCenter extends Model
{
    protected $table = "HealthCenter";

    protected $fillable = [
        'HealthCenterId','HealthCenterCode','HealthCenterName','HealthCenterContactNumber','ContactPersonName',
        'ContactPersonMobile','ContactPersonEmail','IsProvideAmbulance','AmbulanceFee','NearestLandmark',
        'DistanceFrom','IsProvideOTFacility','OTFee','IsProvidePostOperativeFacility','PostOperativeFee',
        ''
    ];
}
