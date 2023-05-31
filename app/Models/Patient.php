<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Gender;
use App\Models\MaritalStatus;
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

}
