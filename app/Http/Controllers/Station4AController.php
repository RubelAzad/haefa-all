<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\RefChiefComplain;
use App\Models\RefIllness;
use App\Models\RefVaccine;
use App\Models\RefQuestion;
use App\Models\RefFrequency;
use App\Models\RefDiseaseGroup;
use App\Models\RefDuration;
use Carbon\Carbon;
use App\Models\RefSocialBehavior;
use App\Models\MDataPatientCCDetails;
use App\Models\MDataPatientIllnessHistory;
use Illuminate\Support\Facades\DB;

class Station4AController extends Controller
{
    public function complaintsListDay(){
        try{
           $data = RefDuration::select('DurationId','DurationCode')->get();

           $status = [
            'code'=> 200,
            'message' =>'Complain options data get successfully'
           ];
           return response()->json(['data'=>$data,'status'=>$status]);
        }
        catch(\Exception $e){
            return response()->json(['status' => false,'message'=>$e->getMessage()],403);
        }
    }
    
    public function complaintsList(Request $request){
        try{
            //RefChiefComplain 
           $data = RefChiefComplain::where('CCCode', 'like', '%' . $request->searchKey . '%')
           ->select('CCId','CCCode')->get();

           $status = [
            'code'=> 200,
            'message' =>'complaint list get successfully'
           ];
           return response()->json(['data'=>$data,'status'=>$status]);
        }
        catch(\Exception $e){
            return response()->json(['status' => false, 'message'=>$e->getMessage()], 403);
        }
    }
    
    public function patientS4Create(Request $request){
        try{
            $CurrentTime = Carbon::now();
            $DateTime =$currentTime->toDateTimeString();

            //MDataPatientCCDetails 
            DB::beginTransaction();
           $Complaints = MDataPatientCCDetails::create([
            'MDCCId' => Str::uuid(),
            'PatientId'  => $request->PatientId,
            'CollectionDate'  => $DateTime,
            'CCId'  => $request->CCId,//RefChiefComplain
            'ChiefComplain'  => $request->ChiefComplain,//RefChiefComplain
            'DurationId'  => $request->DurationId,//
            'CCDurationValue'  => $request->CCDurationValue,//
            'OtherCC'  => $request->OtherCC,
            'Nature'  => $request->Nature,
            'Status'  => $request->Status,
            'CreateDate'  => $request->CreateDate,
            'CreateUser'  => $request->CreateUser,
            'UpdateDate'  => $request->UpdateDate,
            'UpdateUser'  => $request->UpdateUser,
            'OrgId'  => $request->OrgId
           ]);

           //Present illness
           $PresentIllness = $request->illnesses;
           for($i=0;$i<count($PresentIllness); $i++){
               $PresentIll = new MDataPatientIllnessHistory();
               $PresentIll->MDPatientIllnessId = Str::uuid();
               $PresentIll->PatientId = $PresentIllness[$i]['PatientId'];
               $PresentIll->CollectionDate = $DateTime;
               $PresentIll->IllnessId = $PresentIllness[$i]['IllnessId'];
               $PresentIll->OtherIllness = $PresentIllness[$i]['OtherIllness'];
               $PresentIll->Status = $PresentIllness[$i]['Status[]'];
               $PresentIll->CreateUser = $PresentIllness[$i]['CreateUser[]'];
               $PresentIll->CreateDate = $DateTime;
               $PresentIll->UpdateUser = $PresentIllness[$i]['UpdateUser[]'];
               $PresentIll->UpdateDate =  $DateTime;
               $PresentIll->OrgId = $PresentIllness[$i]['OrgId[]'];
               $PresentIll->save();
           }
            //Save Past illness
            $PastIllness = $request->illnesses;
            for($i=0;$i<count($PastIllness); $i++){
                $pastIll = new MDataPatientIllnessHistory();
                $pastIll->MDPatientIllnessId = Str::uuid();
                $pastIll->PatientId = $PresentIllness[$i]['PatientId'];
                $pastIll->CollectionDate = $DateTime;
                $pastIll->IllnessId = $PresentIllness[$i]['IllnessId'];
                $pastIll->OtherIllness = $PresentIllness[$i]['OtherIllness'];
                $pastIll->Status = $PresentIllness[$i]['Status[]'];
                $pastIll->CreateUser = $PresentIllness[$i]['CreateUser[]'];
                $pastIll->CreateDate = $DateTime;
                $pastIll->UpdateUser = $PresentIllness[$i]['UpdateUser[]'];
                $pastIll->UpdateDate =  $DateTime;
                $pastIll->OrgId = $PresentIllness[$i]['OrgId[]'];
                $pastIll->save();
            }
           // Commit [save] the transaction
            DB::commit(); 

           return response()->json(['status' => true, 'message'=>'Chief complaints saved successfully',
            'data'=>$complaints], 200);
        }
        catch(\Exception $e){
            // Rollback the transaction in case of an exception
            DB::rollBack();
            return response()->json(['status' => false,'message'=>$e->getMessage()], 403);
        }
    }
    
    public function presentIllness(){
        try{
           $data = RefIllness::select('IllnessId','IllnessCode')->get();
           $status = [
            'code'=> 200,
            'message' =>'Present illness get successfully'
           ];
           
           return response()->json(['data'=>$data,'status'=>$status]);
        }
        catch(\Exception $e){
            return response()->json(['status' => false, 'message'=>$e->getMessage(),'status' => false], 403);
        }
    }
    
    public function pastIllness(){
        try{
           $data = RefIllness::select('IllnessId','IllnessCode')->get();
           $status = [
            'code'=> 200,
            'message' =>'Past illness get successfully'
           ];
           return response()->json(['data'=>$data,'status'=>$status]);
        }
        catch(\Exception $e){
            return response()->json(['status' =>false, 'message'=>$e->getMessage()],403);
        }
    }

    public function familyIllness(){
        try{
            $data = RefIllness::select('IllnessId','IllnessCode')->get();
            $status = [
                'code'=> 200,
                'message' =>'Familly illness get successfully'
               ];
            return response()->json(['data'=>$data,'status'=>$status]);

        }catch(\Exception $e){
            return response()->json(['status' =>false, 'message'=>$e->getMessage()],403);
        }
    }

    public function socialHistory(){
        try{
            $data = RefSocialBehavior::select('SocialBehaviorId','SocialBehaviorCode')->get();
            $status = [
                'code'=> 200,
                'message' =>'Social history get successfully'
               ];
            return response()->json(['data'=>$data,'status'=>$status]);
        }catch(\Exception $e){
            return response()->json(['status'=>false, 'message'=>$e->getMessage()],403);
        }
    }
    
    public function currentMedicationTaken(){
        try{
            $data = RefDuration::select('DurationId','DurationCode')->get();
            $status = [
                'code'=> 200,
                'message' =>'Current medication taken get successfully'
               ];
            return response()->json(['data'=>$data,'status'=>$status]);

        }catch(\Exception $e){
            return response()->json(['status' =>false, 'message'=>$e->getMessage()],403);
        }
    }
    
    public function patientMentalHealth(){
        try{
            $data = RefQuestion::select('QuestionId','QuestionTitle')->get();
            $status = [
                'code'=> 200,
                'message' =>'Patient mental health get successfully'
               ];

            return response()->json(['data'=>$data,'status'=>$status]);

        }catch(\Exception $e){
            return response()->json(['status' =>false, 'message'=>$e->getMessage()],403);
        }
    }
    
    public function childVaccination(){
        try{
            $data = RefVaccine::select('VaccineId','VaccineCode')->get();
            $status = [
                'code'=> 200,
                'message' =>'Child vaccination get successfully'
               ];
            return response()->json(['data'=>$data,'status'=>$status]);

        }catch(\Exception $e){
            return response()->json(['status' =>false, 'message'=>$e->getMessage()],403);
        }
    }
    
    public function adultVaccination(){
        try{
            $data = RefVaccine::select('VaccineId','VaccineCode')->get();
            $status = [
                'code'=> 200,
                'message' =>'Adult vaccination get successfully'
               ];
            
            return response()->json(['data'=>$data,'status'=>$status]);

        }catch(\Exception $e){
            return response()->json(['status' =>false, 'message'=>$e->getMessage()],403);
        }
    }


}
