<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'Address';
    public $timestamps = false;
    protected $fillable = [ 'PatientId', 'AddressLine1', 'AddressLine1Parmanent','AddressLine2','AddressLine2Parmanent','Village','VillageParmanent','Thana','ThanaParmanent','PostCode','PostCodeParmanent','District','DistrictParmanent','Country','CountryParmanent','Status','Camp', 'BlockNumber', 'Majhi', 'TentNumber', 'FCN','OrgId','CreateUser','CreateDate','UpdateUser','UpdateDate'];
}
