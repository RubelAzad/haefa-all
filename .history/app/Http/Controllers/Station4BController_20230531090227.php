<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\RefContraceptionMethod;
use App\Models\RefMenstruationProduct;
use App\Models\RefMnstProductUsageTime;
use Carbon\Carbon;


class Station4BController extends Controller
{
    
    public function patientS4bCreate(Request $request){
        try{
            DB::beginTransaction();

            $CurrentTime = Carbon::now();
            $DateTime = $CurrentTime->toDateTimeString();
            //Obstetrics Information 
            $PatientObsGynae = new MDataPatientObsGynae();
            $PatientObsGynae->MDPatientObsGynaeId = Str::uuid();
            $PatientObsGynae->PatientId = $request->PatientId;
            $PatientObsGynae->CollectionDate = $DateTime;

            // $PatientObsGynae->Gravida = ;
            // $PatientObsGynae->StillBirth = ;
            // $PatientObsGynae->MiscarraigeOrAbortion = ;
            // $PatientObsGynae->MR = ;
            // $PatientObsGynae->LivingBirth = ;
            // $PatientObsGynae->LivingMale = ;
            // $PatientObsGynae->LivingFemale = ;
            // $PatientObsGynae->ChildMortality0To1 = ;
            // $PatientObsGynae->ChildMortalityBelow5 = ;
            // $PatientObsGynae->ChildMortalityOver5 = ;
            // $PatientObsGynae->LMP = ;
            // $PatientObsGynae->ContraceptionMethodId = ;
            // $PatientObsGynae->OtherContraceptionMethod = ;
            // $PatientObsGynae->Comment = ;
            // $PatientObsGynae->MenstruationProductId = ;
            // $PatientObsGynae->save();

            // Commit [save] the transaction
            DB::commit(); 

            $status = [
                'code'=> 200,
                'message' =>'Present illness get successfully'
               ];

        }catch(\Exception $e){

            // Rollback the transaction in case of an exception
            DB::rollBack();

            $status = [
                'code' =>403,
                'message' =>$e->getMessage()
            ];
        }
    }
    public function patientS4bMensContraception(){
        try{
            $data = RefContraceptionMethod::select('ContraceptionMethodId','ContraceptionMethodCode')->get();
            $status = [
                'code' => 200,
                'message' =>'Contraception method get successfully'
            ];

            return response()->json(['data'=>$data,'status'=>$status]);

        }catch(\Exception $e){
            $status = [
                'code'=> 403,
                'message' =>$e->getMessage()
               ];
            return response()->json(['status' => $status]);
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
            $status = [
                'code'=> 403,
                'message' =>$e->getMessage()
               ];
            return response()->json(['status' => $status]);
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
            $status = [
                'code'=> 403,
                'message' =>$e->getMessage()
               ];
            return response()->json(['status' => $status]);
        }
    }
}
