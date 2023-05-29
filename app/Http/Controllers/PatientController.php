<?php

namespace App\Http\Controllers;
use App\Models\Patient;
use Illuminate\Http\Request;
use App\Transformers\PatientTransformer;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\WorkPlace;
use App\Models\Gender;
use App\Models\MaritalStatus;
use App\Models\District;
use App\Models\SelfType;


class PatientController extends Controller
{
    private $PatientTransformer;

    public function __construct(PatientTransformer $PatientTransformer){
        $this->PatientTransformer = $PatientTransformer;
    }
    public function index(){

        try{

            
            $Gender = Gender::select('GenderId','GenderCode')->get();
            $MaritalStatus = MaritalStatus::select('MaritalStatusId','MaritalStatusCode')->get();
            $District = District::select('Id','districtName')->get();
            $SelfType = SelfType::select('HeadOfFamilyId','HeadOfFamilyCode')->get();
            $status = [
                'code' => 200,
                'message' => 'Patient Ref Data'
            ];
            // $data = [
            //     'Gender' => $Gender,
            //     'MaritalStatus' => $MaritalStatus,
            //     'District' => $District,
            //     'SelfType' => $SelfType
            // ];
            // return response()->json([
            //     'status' => $status,
            //     'data' => $data
            // ]);

            return response()->json([
                'status' => $status,
                'Gender' => $Gender,
                'MaritalStatus' => $MaritalStatus,
                'District' => $District,
                'SelfType' => $SelfType
            ]);

            
            //return $patient;
           // return response()->json(['status' => $status,'data'=>$data], 200);
            //return $this->respondWithCollection($patient, $this->PatientTransformer, true, HttpResponse::HTTP_OK, 'Patient List');
            //return response()->json(['status' => false,'patient'=>$abc, 'code' => 200,'message' => 'Incorrect email or password'],422);
        }catch (Exception $e) {
            throw new Exception($e->getMessage());
        }  
    }

    public function store(Request $request){

        $currentTime = Carbon::now();
        $date=$currentTime->toDateTimeString();

        $patient = new Patient;

        $patient->PatientId = Str::uuid();
        $patient->WorkPlaceId = Str::uuid();
        $patient->WorkPlaceBranchId = Str::uuid();
        $patient->PatientCode = $request->registrationNo;
        $patient->RegistrationId = $request->registrationNo;
        $patient->GivenName = $request->fName;
        $patient->FamilyName = $request->lName;
        $patient->BirthDate = $request->DOB;
        $patient->CellNumber = $request->contactNumber;
        $patient->GenderId = $request->gender;
        $patient->Age = $request->idType;
        $patient->Age = $request->patientAge;
        $patient->Age = $request->patientAge;
        $patient->Age = $request->patientAge;
        $patient->Age = $request->patientAge;
        $patient->Age = $request->patientAge;
        $patient->Age = $request->patientAge;
        $patient->Age = $request->patientAge;
        $patient->Age = $request->patientAge;
        $patient->Age = $request->patientAge;
        $patient->Age = $request->patientAge;
        $patient->Age = $request->patientAge;
        $patient->Age = $request->patientAge;
        $patient->Age = $request->patientAge;
        $patient->Age = $request->patientAge;
        $patient->Status = 1;
        $patient->CreateDate = $date;
        $patient->CreateUser = "Azad";
        $patient->UpdateDate = $date;
        $patient->UpdateUser = "Rubel";
        $patient->OrgId = Str::uuid();
        if($patient->save()){
            
            return response()->json(['status' => true,'patient'=>$abc, 'code' => 200,'message' => 'patient save successfully'],200);
        }

        return $this->responseJson(false, HttpResponse::HTTP_BAD_GATEWAY, 'Error. Could Not Sava Patient data');
    }


}
