<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use App\Models\MDataGlucoseHb;

class Station3Controller extends Controller
{
    public function patientGlucoseHbCreate(){

        $PatientId=$request->PatientId;
        $OrgId=$request->OrgId;
        $usersID=$request->usersID;
        try{
        DB::beginTransaction();

        $currentTime = Carbon::now();
        $date=$currentTime->toDateTimeString();

        //patient start
        $MDataGlucoseHb = new MDataGlucoseHb();
        $MDataGlucoseHb->Id = Str::uuid();
        $MDataGlucoseHb->PatientId = $PatientId;
        $MDataGlucoseHb->CollectionDate = $date;
        $MDataGlucoseHb->RBG = $request->RBG;
        $MDataGlucoseHb->FBG = $request->FBG;
        $MDataGlucoseHb->HrsFromLastEat = $request->HrsFromLastEat;
        $MDataGlucoseHb->Hemoglobin = $request->Hemoglobin;
        $MDataGlucoseHb->Status = 1;
        $MDataGlucoseHb->CreateDate = $date;
        $MDataGlucoseHb->CreateUser = $request->CreateUser;
        $MDataGlucoseHb->UpdateDate = $date;
        $MDataGlucoseHb->UpdateUser = "";
        $MDataGlucoseHb->OrgId = $OrgId;
        $MDataGlucoseHb->save();
        //patient End

        //patient Registration id wise patient id
        $patientInfo=Patient::where('PatientId','=',$PatientId)->first();
        $PatientId=$patientInfo->PatientId;

        //station start

        Station::where('PatientId','=' ,$PatientId)->update(['StationStatus' => '3']);
        
        //station End
        
        
        return response()->json(['status' => true, 'code'=>200, 'message'=>'Data Save successfully'], 200);
        DB::commit();

        }catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }  

        return $this->responseJson(false, HttpResponse::HTTP_BAD_GATEWAY, 'Error. Could Not Sava data');
    }  
}
