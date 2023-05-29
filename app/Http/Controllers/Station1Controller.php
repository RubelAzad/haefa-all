<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use App\Models\RefBloodGroup;
use App\Models\MDataHeightWeight;

class Station1Controller extends Controller
{
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
    public function Blood(){
        try{
            $BloodGroup = RefBloodGroup::select('RefBloodGroupId','BloodGroupCode')->get();
            $status = [
                'code' => 200,
                'message' => 'Blood Group Information Successfully'
            ];
            return response()->json([
                'status' => $status,
                'BloodGroup' => $BloodGroup,
            ]);
        }catch (Exception $e) {
            throw new Exception($e->getMessage());
        }  
        return $this->responseJson(false, HttpResponse::HTTP_BAD_GATEWAY, 'Error. Could Not Sava data');
    }

    public function patientHeightWidthCreate(){

        $PatientId=$request->heightWeightInfo['PatientId'];
        $OrgId=$request->heightWeightInfo['OrgId'];
        $usersID=$request->heightWeightInfo['usersID'];
        try{
        DB::beginTransaction();

        $currentTime = Carbon::now();
        $date=$currentTime->toDateTimeString();

        //patient start
        $heightWeight = new MDataHeightWeight();
        $heightWeight->Id = Str::uuid();
        $heightWeight->PatientId = $PatientId;
        $heightWeight->CollectionDate = $date;
        $heightWeight->Height = $request->heightWeightInfo['Height'];
        $heightWeight->Weight = $request->heightWeightInfo['Weight'];
        $heightWeight->BMI = $request->heightWeightInfo['BMI'];
        $heightWeight->BMIStatus = $request->heightWeightInfo['BMIClass'];
        $heightWeight->MUAC = $request->heightWeightInfo['MUAC'];
        $heightWeight->MUACStatus = $request->heightWeightInfo['MUACClass'];
        $heightWeight->RefBloodGroupId = $request->heightWeightInfo['RefBloodGroupId'];
        $heightWeight->Status = 1;
        $heightWeight->CreateDate = $date;
        $heightWeight->CreateUser = "Azad";
        $heightWeight->UpdateDate = $date;
        $heightWeight->UpdateUser = "Rubel";
        $heightWeight->OrgId = $OrgId;
        $heightWeight->save();
        //patient End

        //patient Registration id wise patient id
        $patientInfo=Patient::where('PatientId','=',$PatientId)->first();
        $PatientId=$patientInfo->PatientId;

        //station start

        Station::where('PatientId','=' ,$PatientId)->update(['StationStatus' => '2']);
        
        //station End
        
        
        return response()->json(['status' => true, 'code'=>200, 'message'=>'Data Save successfully'], 200);
        DB::commit();

        }catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }  

        return $this->responseJson(false, HttpResponse::HTTP_BAD_GATEWAY, 'Error. Could Not Sava Patient data');
    }   
}
