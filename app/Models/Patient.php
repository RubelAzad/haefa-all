<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\WorkPlace;
class Patient extends Model
{
    
    use HasFactory;
    protected $table = 'Employee';
    public $timestamps = false;

    public function WorkPlace()
    {
        return $this->hasOne(WorkPlace::class, 'WorkPlaceId', 'WorkPlaceId'); 
    }

    // protected $fillable = [ 'MappingEmployeeAddressId', 'EmployeeId', 'AddressId','Status','CreateDate', 'CreateUser', 'UpdateDate', 'UpdateUser',
    //  'OrgId'];
}
