<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Gender;
use App\Models\MaritalStatus;
use App\Models\MDataBP;
use App\Models\MDataHeightWeight;
use App\Models\MDataGlucoseHb;
class Patient extends Model
{
    
    use HasFactory;
    protected $table = 'Patient';
    public $timestamps = false;


    protected $fillable = [ 'PatientId', 'WorkPlaceId', 'WorkPlaceBranchId','PatientCode','RegistrationId','GivenName','FamilyName','GenderId','BirthDate','Age','AgeYear','AgeMonth','AgeDay','JoiningDate','ReligionId','RefDepartmentId','RefDesignationId','MaritalStatusId','EducationId','FatherName','MotherName','SpouseName','HeadOfFamilyId','IdNumber','CellNumber','FamilyMembers','ChildrenNumber','ChildAge0To1','ChildAge1To5','ChildAgeOver5','EmailAddress','PatientImage','Status','CreateDate', 'CreateUser', 'UpdateDate', 'UpdateUser', 'OrgId'];

    public function Gender()
    {
        return $this->hasOne(Gender::class, 'GenderId', 'GenderId')->select('GenderId','GenderCode'); 
    }
    public function MartitalStatus()
    {
        return $this->hasOne(MaritalStatus::class, 'MaritalStatusId', 'MaritalStatusId')->select('MaritalStatusId','MaritalStatusCode'); 
    }
    public function bps()
    {
        return $this->hasMany(MDataBP::class, 'PatientId', 'PatientId'); 
    }
    public function height_weights()
    {
        return $this->hasMany(MDataHeightWeight::class, 'PatientId', 'PatientId'); 
    }
    public function glucose_hbs()
    {
        return $this->hasMany(MDataGlucoseHb::class, 'PatientId', 'PatientId'); 
    }

}
