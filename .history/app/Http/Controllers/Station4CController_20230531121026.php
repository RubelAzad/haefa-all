<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\RefProvisionalDiagnosis;
use App\Models\RefLabInvestigation;
use App\Models\RefDrug;

class Station4CController extends Controller
{
    public function provisionalDiagonisis(){
        try{

            $provisionalDiagonisis = RefProvisionalDiagnosis::select('RefProvisionalDiagnosisId',
                                    'ProvisionalDiagnosisCode','ProvisionalDiagnosisName')->get();

            $status = [
                'code'=> 200,
                'message' =>'Provisional Diagnosis data get successfully'
               ];
            return response()->json(['status'=>$status,'data'=>$provisionalDiagonisis]);  

        }catch(\Exception $e){
            $status = [
                'code'=>403,
                'message'=>$e->getMessage()
            ];

            return response()->json(['status'=>$status]);
        }
    }

    public function investigations(){
        try{
            $RefLabInvestigation = RefLabInvestigation::select('RefLabInvestigationId',
                                'RefLabInvestigationCode','Investigation','Description')->get();
            $status = [
                'code'=>200,
                'message'=>'Lab investigations data get successfully!'
            ];
            return response()->json(['status'=> $status, 'data'=>$RefLabInvestigation]);

        }catch(\Exception $e){
            $status = [
                'code'=>403,
                'message'=>$e->getMessage()
            ];
            return response()->json(['status'=>$status]);
        }   
    }

    // Treatment Suggestions
    public function treatmentSuggestins(){
        try{
            $RefDrug = RefDrug::select('DrugId','DrugCode','DrugDose','Description')->get();
            $status = [
                'code'=>200,
                'message'=>'Treatment suggestion data get successfully!'
            ];
            return response()->json(['status'=>$status,'data'=>$RefDrug]);

        }catch(\Exception $e){
            $status = [
                'code'=>403,
                'message'=> $e->getMessage()
            ];
            return response()->json(['status'=>$status]);
        }
    }
    
    // Frequency Hours
    public function frequencyHours(){
        try{
            $FrequencyHours = RefFrequency::select('FrequencyId','FrequencyCode','FrequencyInEnglish')->get();
            $status = [
                'code'=>200,
                'message'=>'Treatment suggestion data get successfully!'
            ];
            return response()->json(['status'=>$status,'data'=>$FrequencyHours]);

        }catch(\Exception $e){
            $status = [
                'code'=>403,
                'message'=> $e->getMessage()
            ];
            return response()->json(['status'=>$status]);
        }
    }
    
    // Referral Section
    public function referralSection(){
        try{
            $RefReferral = RefReferral::select('RId','RCode','Description')->get();
            $status = [
                'code'=>200,
                'message'=>'Referral section data get successfully!'
            ];
            return response()->json(['status'=>$status,'data'=>$RefReferral]);

        }catch(\Exception $e){
            $status = [
                'code'=>403,
                'message'=> $e->getMessage()
            ];
            return response()->json(['status'=>$status]);
        }
    }
    
    // Health Center
    public function healthCenter(){
        try{
            $HealthCenter = HealthCenter::select('HealthCenterId','HealthCenterCode','HealthCenterName')->get();
            $status = [
                'code'=>200,
                'message'=>'Health center data get successfully!'
            ];
            return response()->json(['status'=>$status,'data'=>$HealthCenter]);

        }catch(\Exception $e){
            $status = [
                'code'=>403,
                'message'=> $e->getMessage()
            ];
            return response()->json(['status'=>$status]);
        }
    }
    
    // Advice
    public function Advice(){
        try{
            $RefAdvice = RefAdvice::select('RId','RCode','Description')->get();
            $status = [
                'code'=>200,
                'message'=>'Advice data get successfully!'
            ];
            return response()->json(['status'=>$status,'data'=>$RefAdvice]);

        }catch(\Exception $e){
            $status = [
                'code'=>403,
                'message'=> $e->getMessage()
            ];
            return response()->json(['status'=>$status]);
        }
    }
}
