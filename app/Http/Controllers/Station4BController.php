<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RefContraceptionMethod;
use App\Models\RefMenstruationProduct;
use App\Models\RefMnstProductUsageTime;

class Station4BController extends Controller
{
    public function patientS4bMensContraception(){
        try{
            $data = RefContraceptionMethod::select('ContraceptionMethodId','ContraceptionMethodCode')->get();
            $status = [
                'code' => 200,
                'message' =>'Contraception method get successfully'
            ];

            return response()->json(['data'=>$data,'status'=>$status]);

        }catch(\Exception $e){
            return response()->json(['code'=>200,'status'=>false,'message'=> $e->getMessage()]);
        }
    }
    
    public function patientS4bDuringMenstruation(){
        try{
            $data = RefMenstruationProduct::select('MenstruationProductId','MenstruationProductCode')->get();
            $status = [
                'code' => 200,
                'message' =>'Menstruation get successfully'
            ];

            return response()->json(['data'=>$data,'status'=>$status]);

        }catch(\Exception $e){
            return response()->json(['code'=>200,'status'=>false,'message'=> $e->getMessage()]);
        }
    }
    
    public function patientS4bHowOften(){
        try{
            $data = RefMnstProductUsageTime::select('MenstruationProductUsageTimeId','MenstruationProductUsageTimeCode')->get();
            $status = [
                'code' => 200,
                'message' =>'Menstruation product usage get successfully'
            ];

            return response()->json(['data'=>$data,'status'=>$status]);

        }catch(\Exception $e){
            return response()->json(['code'=>200,'status'=>false,'message'=> $e->getMessage()]);
        }
    }
}
