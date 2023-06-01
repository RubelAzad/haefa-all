<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
            return response()->json(['status'=>$status,'data'=>$data]);  

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
            $RefInstruction = RefInstruction::select('')->get();
            $status = [
                'code'=>200,
                'message'=>'Treatment suggestion data get successfully!'
            ];
            return response()->json(['status'=>$status,'data'=>$RefInstruction]);

        }catch(\Exception $e){
            $status = [
                'code'=>403,
                'message'=> $e->getMessage()
            ];
            return response()->json(['status'=>$status]);
        }
    }
}
