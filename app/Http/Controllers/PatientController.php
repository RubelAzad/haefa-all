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
use Illuminate\Support\Facades\DB;
use App\Models\Address;
use App\Models\Station;



class PatientController extends Controller
{
    private $PatientTransformer;

    public function __construct(PatientTransformer $PatientTransformer){
        $this->PatientTransformer = $PatientTransformer;
    }
    /**
     * @method_name :- method_name
     * -------------------------------------------------------- 
     * @param  :-  {{}|any}
     * ?return :-  {{}|any}
     * author :-  API
     * created_by:- Abul Kalam Azad
     * created_at:- 28/05/2023 09:22:54
     * description :- Patient Genders All Information.
     */
    public function genders(){
        try{
            $Gender = Gender::select('GenderId','GenderCode')->get();
            $status = [
                'code' => 200,
                'message' => 'Gender Information Successfully'
            ];
            return response()->json([
                'status' => $status,
                'Gender' => $Gender,
            ]);
        }catch (Exception $e) {
            throw new Exception($e->getMessage());
        }  
        return $this->responseJson(false, HttpResponse::HTTP_BAD_GATEWAY, 'Error. Could Not Sava Patient data');
    }
    public function maritalStatus(){
        try{
            $MaritalStatus = MaritalStatus::select('MaritalStatusId','MaritalStatusCode')->get();
            $status = [
                'code' => 200,
                'message' => 'Marital Status Information Successfully'
            ];
            return response()->json([
                'status' => $status,
                'MaritalStatus' => $MaritalStatus,
            ]);
        }catch (Exception $e) {
            throw new Exception($e->getMessage());
        }  
        return $this->responseJson(false, HttpResponse::HTTP_BAD_GATEWAY, 'Error. Could Not Sava Patient data');
    }
    public function district(){
        try{
            $District = District::select('Id','districtName')->get();
            $status = [
                'code' => 200,
                'message' => 'District Information Successfully'
            ];
            return response()->json([
                'status' => $status,
                'District' => $District,
            ]);
        }catch (Exception $e) {
            throw new Exception($e->getMessage());
        }  
        return $this->responseJson(false, HttpResponse::HTTP_BAD_GATEWAY, 'Error. Could Not Sava Patient data');
    }
    public function SelfType(){
        try{
            $SelfType = SelfType::select('HeadOfFamilyId','HeadOfFamilyCode')->get();
            $status = [
                'code' => 200,
                'message' => 'District Information Successfully'
            ];
            return response()->json([
                'status' => $status,
                'SelfType' => $SelfType,
            ]);
        }catch (Exception $e) {
            throw new Exception($e->getMessage());
        }  
        return $this->responseJson(false, HttpResponse::HTTP_BAD_GATEWAY, 'Error. Could Not Sava Patient data');
    }

    public function patientRegCreate(Request $request){

        $registrationNo=$request->patientInfo['registrationNo'];
        $OrgId=$request->patientInfo['OrgId'];
        $usersID=$request->patientInfo['usersID'];
        try{
        DB::beginTransaction();

        $currentTime = Carbon::now();
        $date=$currentTime->toDateTimeString();

        //patient start
        $patient = new Patient();
        $patient->PatientId = Str::uuid();
        $patient->PatientCode = $registrationNo;
        $patient->RegistrationId = $registrationNo;
        $patient->GivenName = $request->patientInfo['fName'];
        $patient->FamilyName = $request->patientInfo['lName'];
        $patient->Age = $request->patientInfo['patientAge'];
        $patient->BirthDate = $request->patientInfo['DOB'];
        $patient->CellNumber = $request->patientInfo['contactNumber'];
        $patient->GenderId = $request->patientInfo['gender'];
        $patient->IdType = $request->patientInfo['idType'];
        $patient->IdNumber = $request->patientInfo['ID'];
        $patient->MaritalStatusId = $request->patientInfo['MariatalStatus'];
        $patient->PatientImage = $request->patientInfo['PatientPhoto'];
        $patient->IdOwner = $request->patientInfo['SelfType'];
        $patient->WorkPlaceId =$request->patientInfo['WorkPlace'];
        $patient->WorkPlaceBranchId = $request->patientInfo['WorkBranch'];
        $patient->BarCode = $request->patientInfo['BarCode'];
        $patient->FingerPrint = $request->patientInfo['FingerPrint'];
        $patient->OrgId = $OrgId;
        $patient->usersID = $usersID;
        $patient->Status = 1;
        $patient->CreateDate = $date;
        $patient->CreateUser = "Azad";
        $patient->UpdateDate = $date;
        $patient->UpdateUser = "Rubel";
        $patient->save();
        //patient End

        //patient Registration id wise patient id
        $patientId=Patient::where('RegistrationId','=',$registrationNo)->first();
        $PatientId=$patientId->PatientId;

        //station start
        $station = new Station();
        $station->StationId = Str::uuid();
        $station->PatientId = $PatientId;
        $station->StationStatus = '1';
        $station->CreateDate = $date;
        $station->CreateUser = "Azad";
        $station->UpdateDate = $date;
        $station->UpdateUser = "Rubel";
        $station->save();
        //station End
        
        
        //address start
        $address = new Address();
        $address->AddressId = Str::uuid();
        $address->PatientId = $PatientId;
        $address->AddressLine1 = $request->addressInfo['AddressLine1'];
        $address->AddressLine2 = $request->addressInfo['AddressLine2'];
        $address->Village = $request->addressInfo['Village'];
        $address->Thana = $request->addressInfo['Thana'];
        $address->PostCode = $request->addressInfo['PostCode'];
        $address->District = $request->addressInfo['District'];
        $address->Country = $request->addressInfo['Country'];
        $address->AddressLine1Parmanent = $request->addressInfo['AddressLine1Parmanent'];
        $address->AddressLine2Parmanent = $request->addressInfo['AddressLine2Parmanent'];
        $address->VillageParmanent = $request->addressInfo['VillageParmanent'];
        $address->ThanaParmanent = $request->addressInfo['ThanaParmanent'];
        $address->PostCodeParmanent = $request->addressInfo['PostCodeParmanent'];
        $address->DistrictParmanent = $request->addressInfo['DistrictParmanent'];
        $address->CountryParmanent = $request->addressInfo['CountryParmanent'];
        $address->Status = $request->addressInfo['Status'];
        $address->Camp = $request->addressInfo['Camp'];
        $address->BlockNumber = $request->addressInfo['BlockNumber'];
        $address->Majhi = $request->addressInfo['Majhi'];
        $address->TentNumber = $request->addressInfo['TentNumber'];
        $address->FCN = $request->addressInfo['FCN'];
        $address->Status = 1;
        $address->OrgId = $OrgId;
        $address->CreateDate = $date;
        $address->CreateUser = "Azad";
        $address->UpdateDate = $date;
        $address->UpdateUser = "Rubel";
        $address->save();
        //address start
        return response()->json(['status' => true, 'code'=>200, 'message'=>'Data Save successfully'], 200);
        DB::commit();

        }catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }  

        return $this->responseJson(false, HttpResponse::HTTP_BAD_GATEWAY, 'Error. Could Not Sava Patient data');
    }


}