<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\RefContraceptionMethod;
use App\Models\RefMenstruationProduct;
use App\Models\RefMnstProductUsageTime;
use App\Models\MDataPatientObsGynae;
use App\Models\MDataPatientPregnancy;
use App\Models\MDataPatientCervicalCancer;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class Station4BController extends Controller
{
    
    public function patientS4bCreate(Request $request){
        DB::beginTransaction();

        try{
            $CurrentTime = Carbon::now();
            $DateTime = $CurrentTime->toDateTimeString();
            //Obstetrics Information 
            $PatientObsGynae = new MDataPatientObsGynae();
            $PatientObsGynae->MDPatientObsGynaeId = Str::uuid();
            $PatientObsGynae->PatientId = $request->PatientId;
            $PatientObsGynae->CollectionDate = $DateTime;
            $PatientObsGynae->Gravida = $request->Gravida;
            $PatientObsGynae->Para = $request->Para;
            $PatientObsGynae->StillBirth = $request->StillBirth;
            $PatientObsGynae->MiscarraigeOrAbortion = $request->MiscarraigeOrAbortion;
            $PatientObsGynae->MR = $request->MR;
            $PatientObsGynae->LivingMale = $request->LivingMale;
            $PatientObsGynae->LivingFemale = $request->LivingFemale;

            if($request->male==1){
                $PatientObsGynae->ChildMortality0To1 = "M";
            }
            elseif($request->male==2){
                $PatientObsGynae->ChildMortalityBelow5 = "M";
            }
            elseif($request->male==3){
                $PatientObsGynae->ChildMortalityOver5 = "M";
            }
            if($request->female==1){
                $PatientObsGynae->ChildMortality0To1 = "F";
            } 
            elseif($request->female==2){
                $PatientObsGynae->ChildMortalityBelow5 = "F";
            }
            elseif($request->male==3){
                $PatientObsGynae->ChildMortalityOver5 = "F";
            }
            $PatientObsGynae->IsPregnant = $request->IsPregnant;
            $PatientObsGynae->LMP = $request->LMP;
            $PatientObsGynae->ContraceptionMethodId = $request->ContraceptionMethodId;
            $PatientObsGynae->Comment = $request->Comment;
            $PatientObsGynae->MenstruationProductId = $request->MenstruationProductId;
            $PatientObsGynae->MenstruationProductUsageTimeId = $request->MenstruationProductUsageTimeId;
            $PatientObsGynae->Status = $request->Status;
            $PatientObsGynae->CreateUser = $request->CreateUser;
            $PatientObsGynae->CreateDate = $DateTime;
            $PatientObsGynae->UpdateUser = $request->UpdateUser;
            $PatientObsGynae->UpdateDate =  $DateTime;
            $PatientObsGynae->OrgId = $request->OrgId;
            $PatientObsGynae->save();

            $MDataPatientPregnancy = new MDataPatientPregnancy();
            $MDataPatientPregnancy->MDPatientPregnancyId = Str::uuid();
            $MDataPatientPregnancy->PatientId = $request->PatientId;
            $MDataPatientPregnancy->CollectionDate = $DateTime;
            $MDataPatientPregnancy->LMP = $request->LMP;
            $MDataPatientPregnancy->Status = $request->Status;
            $MDataPatientPregnancy->CreateUser = $request->CreateUser;
            $MDataPatientPregnancy->CreateDate = $DateTime;
            $MDataPatientPregnancy->UpdateUser = $request->UpdateUser;
            $MDataPatientPregnancy->UpdateDate =  $DateTime;
            $MDataPatientPregnancy->OrgId = $request->OrgId;
            $MDataPatientPregnancy->save();   

            //Cervical cancer screening
            $MDataPatientCervicalCancer = new MDataPatientCervicalCancer();
            $MDataPatientCervicalCancer->MDataPatientCervicalCancerId = Str::uuid();
            $MDataPatientCervicalCancer->PatientId = $request->PatientId;
            $MDataPatientCervicalCancer->CollectionDate = $DateTime;
            $MDataPatientCervicalCancer->CCScreeningDiagnosis = $request->CCScreeningDiagnosis;
            $MDataPatientCervicalCancer->CCScreeningResultStatus = $request->CCScreeningResultStatus;
            $MDataPatientCervicalCancer->ReferralBiopsyStatus = $request->ReferralBiopsyStatus;
            $MDataPatientCervicalCancer->Status = $request->Status;
            $MDataPatientCervicalCancer->CreateUser = $request->CreateUser;
            $MDataPatientCervicalCancer->CreateDate = $DateTime;
            $MDataPatientCervicalCancer->UpdateUser = $request->UpdateUser;
            $MDataPatientCervicalCancer->UpdateDate =  $DateTime;
            $MDataPatientCervicalCancer->OrgId = $request->OrgId;
            $MDataPatientCervicalCancer->save();

            // Commit [save] the transaction
            DB::commit(); 

            $status = [
                'code'=> 200,
                'message' =>'Station 4B data saved successfully'
               ];

            return response()->json(['status'=>$status, 'data'=>$MDataPatientCervicalCancer]); 

        }catch(\Exception $e){

            // Rollback the transaction in case of an exception
            DB::rollBack();

            $status = [
                'code' =>403,
                'message' =>$e->getMessage()
            ];

            return response()->json(['status'=>$status]);
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
