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
use App\Models\RefSocialBehavior;
use App\Models\MDataPatientCCDetails;
use App\Models\MDataPatientIllnessHistory;
use Illuminate\Support\Facades\DB;

class Station4AController extends Controller
{
    public function complaintsListDay(){
        try{
           $Days = RefDuration::all();
           return response()->json(['status' => true, 'message'=>'Complain days get successfully',
           'data'=>$Days], 200);
        }
        catch(\Exception $e){
            return response()->json(['status' => false,'message'=>$e->getMessage()],403);
        }
    }
    
    public function complaintsList(Request $request){
        try{
            //RefChiefComplain 
           $Complaints = RefChiefComplain::where('CCCode', 'like', '%' . $request->CCCode . '%')->get();
           return response()->json(['status' => true, 'message'=>'Complain list get successfully',
           'data'=>$Complaints], 200); 
        }
        catch(\Exception $e){
            return response()->json(['status' => false, 'message'=>$e->getMessage()], 403);
        }
    }
    
    public function patientS4Create(Request $request){
        try{
            //MDataPatientCCDetails 
            DB::beginTransaction();
           $Complaints = MDataPatientCCDetails::create([
            'MDCCId' => Str::uuid(),
            'PatientId'  => $request->PatientId,
            'CollectionDate'  => $request->CollectionDate,
            'CCId'  => $request->CCId,
            'ChiefComplain'  => $request->ChiefComplain,
            'DurationId'  => $request->DurationId,
            'CCDurationValue'  => $request->CCDurationValue,
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
               $present_ill = new MDataPatientIllnessHistory();
               $present_ill->patient_id = $PresentIllness[$i]['patient_id'];
               $present_ill->present_illness = $PresentIllness[$i]['present_illness[]'];
               $present_ill->save();
           }
            //Save Past illness
            $PresentIllness = $request->illnesses;
            for($i=0;$i<count($PresentIllness); $i++){
                $present_ill = new MDataPatientIllnessHistory();
                $present_ill->patient_id = $PresentIllness[$i]['patient_id'];
                $present_ill->present_illness = $PresentIllness[$i]['present_illness[]'];
                $present_ill->save();
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
           $Illness = RefIllness::all();
           return response()->json(['status' => true, 'message'=>'Present illness get successfully',
           'data'=>$Illness], 200);
        }
        catch(\Exception $e){
            return response()->json(['status' => false, 'message'=>$e->getMessage(),'status' => false], 403);
        }
    }
    
    public function pastIllness(){
        try{
           $Illness = RefIllness::all();
           return response()->json(['status' =>true, 'message'=>'Past illness get successfully',
            'data'=>$Illness], 200);
        }
        catch(\Exception $e){
            return response()->json(['status' =>false, 'message'=>$e->getMessage()],403);
        }
    }

    public function familyIllness(){
        try{
            $FamilyIllness = RefDiseaseGroup::all();
            return response()->json(['status' => true, 'data'=>$FamilyIllness, 'message'=>'Familly illness get successfully!'
            ], 200);

        }catch(\Exception $e){
            return response()->json(['status' =>false, 'message'=>$e->getMessage()],403);
        }
    }

    public function socialHistory(){
        try{
            $RefSocialBehavior = RefSocialBehavior::get();
            return response()->json(['status'=>true,'data'=>$RefSocialBehavior, 
            'message'=>'Social history get successfully!'],200);
        }catch(\Exception $e){
            return response()->json(['status'=>false, 'message'=>$e->getMessage()],403);
        }
    }

    public function generalExamination(){
        try{
            $GeneralExamination = RefDiseaseGroup::all();
            return response()->json(['status' => true, 'data'=>$GeneralExamination, 'message'=>'General examination get successfully!'
            ], 200);

        }catch(\Exception $e){
            return response()->json(['status' =>false, 'message'=>$e->getMessage()],403);
        }
    }
    
    public function currentMedicationTaken(){
        try{
            $CurrentMedicationTaken = RefFrequency::all();
            return response()->json(['status' => true, 'data'=>$CurrentMedicationTaken, 'message'=>'Current medication taken get successfully!'
            ], 200);

        }catch(\Exception $e){
            return response()->json(['status' =>false, 'message'=>$e->getMessage()],403);
        }
    }
    
    public function patientMentalHealth(){
        try{
            $PatientMentalHealth = RefQuestion::all();
            return response()->json(['status' => true, 'data'=>$PatientMentalHealth, 'message'=>'Patient mental health get successfully!'
            ], 200);

        }catch(\Exception $e){
            return response()->json(['status' =>false, 'message'=>$e->getMessage()],403);
        }
    }
    
    public function adultVaccination(){
        try{
            $AdultVaccination = RefVaccine::all();
            return response()->json(['status' => true, 'data'=>$AdultVaccination, 'message'=>'Adult vaccination get successfully!'
            ], 200);

        }catch(\Exception $e){
            return response()->json(['status' =>false, 'message'=>$e->getMessage()],403);
        }
    }


}
