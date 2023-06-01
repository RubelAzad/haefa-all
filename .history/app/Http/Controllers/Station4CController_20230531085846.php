<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Station4CController extends Controller
{
    public function provisionalDiagonisis(){
        try{

            $provisionalDiagonisis = RefProvisionalDiagnosis::
            where('ProvisionalDiagnosisCode','like','%'.$request->searchKey.'%')->get();

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

            return response()->json($status);
        }
    }
}
