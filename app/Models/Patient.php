<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\WorkPlace;
class Patient extends Model
{
    
    use HasFactory;
    protected $table = 'Patient';
    public $timestamps = false;

    protected $fillable = [ 'PatientId', 'WorkPlaceId', 'WorkPlaceBranchId','PatientCode','RegistrationId', 'GivenName', 'FamilyName', 'GenderId','BirthDate','Age','AgeYear','AgeMonth','AgeDay','JoiningDate','ReligionId','RefDepartmentId','RefDesignationId','MaritalStatusId','EducationId','FatherName','MotherName','SpouseName','HeadOfFamilyId','IdNumber','CellNumber','FamilyMembers','ChildrenNumber','ChildAge0To1','ChildAge1To5','ChildAgeOver5','EmailAddress','PatientImage','Status','OrgId','IsCalculatedBirthday','usersID','IdType','IdOwner','StationStatus','BarCode','FingerPrint','CreateDate','CreateUser','UpdateDate','UpdateUser'];

    public function WorkPlace()
    {
        return $this->hasOne(WorkPlace::class, 'WorkPlaceId', 'WorkPlaceId'); 
    }

    
}
