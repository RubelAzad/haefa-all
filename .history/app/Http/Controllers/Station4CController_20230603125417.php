<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MDataProvisionalDiagnosis;
use App\Models\MDataTreatmentSuggestion;
use App\Models\MDataInvestigation;
use App\Models\RefProvisionalDiagnosis;
use App\Models\MDataPatientReferral;
use Illuminate\Support\Facades\DB;
use App\Models\RefLabInvestigation;
use App\Models\MDataFollowUpDate;
use App\Models\MDataAdvice;
use App\Models\RefFrequency;
use App\Models\RefAdvice;
use Illuminate\Support\Str;
use App\Models\RefReferral;
use App\Models\HealthCenter;
use App\Models\RefDrug;
use Carbon\Carbon;

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
            $RefAdvice = RefAdvice::select('AdviceId','AdviceCode','AdviceInEnglish')->get();
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
    //4c save
    public function patientS4cCreate(Request $request){
        DB::beginTransaction();
        try{
            $CurrentTime = Carbon::now();
            $DateTime =$CurrentTime->toDateTimeString();

            //Provesional diagnosis
            $ProvisionalDiagnosis = $request->ProvisionalDiagnosis;
            for($i=0;$i<count($ProvisionalDiagnosis); $i++){
               $ProvisionalD = new MDataProvisionalDiagnosis();
               $ProvisionalD->MDProvisionalDiagnosisId = Str::uuid();
               $ProvisionalD->PatientId = $ProvisionalDiagnosis[$i]['PatientId'];
               $ProvisionalD->CollectionDate = $DateTime;
               $ProvisionalD->RefProvisionalDiagnosisId = $ProvisionalDiagnosis[$i]['RefProvisionalDiagnosisId'];
               $ProvisionalD->Category = $ProvisionalDiagnosis[$i]['category'];
               $ProvisionalD->ProvisionalDiagnosis = $ProvisionalDiagnosis[$i]['provisionalDiagnosis'];
               $ProvisionalD->OtherProvisionalDiagnosis = $ProvisionalDiagnosis[$i]['otherProvisionalDiagnosis'];
               $ProvisionalD->DiagnosisStatus = $ProvisionalDiagnosis[$i]['diagnosisStatus'];
               $ProvisionalD->Status  = "A";
               $ProvisionalD->CreateDate  = $DateTime;
               $ProvisionalD->CreateUser  = $ProvisionalDiagnosis[$i]['CreateUser'];
               $ProvisionalD->UpdateDate  = $DateTime;
               $ProvisionalD->UpdateUser  = $ProvisionalDiagnosis[$i]['UpdateUser'];
               $ProvisionalD->OrgId  = $ProvisionalDiagnosis[$i]['OrgId'];
               $ProvisionalD->save();
            }    
            
            //Lab Investigations
            $LabInvestigations = $request->LabInvestigation;

            for($i=0;$i<count($LabInvestigations); $i++){
                $LabInvestigation = new MDataInvestigation();
                $LabInvestigation->MDInvestigationId = Str::uuid();
                $LabInvestigation->PatientId = $LabInvestigations[$i]['PatientId'];
                $LabInvestigation->CollectionDate = $DateTime;
                $LabInvestigation->InvestigationId = $LabInvestigations[$i]['investigationId'];
                $LabInvestigation->OtherInvestigation = $LabInvestigations[$i]['otherInvestigation'];
                $LabInvestigation->Instruction = $LabInvestigations[$i]['instruction'];
                $LabInvestigation->PositiveNegativeStatus = $LabInvestigations[$i]['positiveNegativeStatus'];
                $LabInvestigation->Status  = "A";
                $LabInvestigation->CreateDate  = $DateTime;
                $LabInvestigation->CreateUser  = $LabInvestigations[$i]['CreateUser'];
                $LabInvestigation->UpdateDate  = $DateTime;
                $LabInvestigation->UpdateUser  = $LabInvestigations[$i]['UpdateUser'];
                $LabInvestigation->OrgId  = $LabInvestigations[$i]['OrgId'];
                $LabInvestigation->save();
            }   

            //Treatment Suggestions
            $TreatmentSuggestion = $request->TreatmentSuggestion;

            for($i=0;$i<count($TreatmentSuggestion); $i++){
                $MDataTreatmentSuggestion = new MDataTreatmentSuggestion();
                $MDataTreatmentSuggestion->MDTreatmentSuggestionId = Str::uuid();
                $MDataTreatmentSuggestion->PatientId = $TreatmentSuggestion[$i]['PatientId'];
                $MDataTreatmentSuggestion->CollectionDate = $DateTime;
                $MDataTreatmentSuggestion->DrugId = $TreatmentSuggestion[$i]['drugId'];
                $MDataTreatmentSuggestion->DurationId = $TreatmentSuggestion[$i]['durationId'];
                $MDataTreatmentSuggestion->RefFrequencyId = $TreatmentSuggestion[$i]['frequencyId'];
                $MDataTreatmentSuggestion->Frequency = $TreatmentSuggestion[$i]['frequency'];
                $MDataTreatmentSuggestion->Hourly = $TreatmentSuggestion[$i]['hourly'];
                $MDataTreatmentSuggestion->DrugDurationValue = $TreatmentSuggestion[$i]['drugDurationValue'];
                $MDataTreatmentSuggestion->OtherDrug = $TreatmentSuggestion[$i]['OtherDrug'];
                $MDataTreatmentSuggestion->RefInstructionId = $TreatmentSuggestion[$i]['RefInstructionId'];
                $MDataTreatmentSuggestion->SpecialInstruction = $TreatmentSuggestion[$i]['SpecialInstruction'];
                $MDataTreatmentSuggestion->Comment = $TreatmentSuggestion[$i]['Comment'];
                $MDataTreatmentSuggestion->Status  = "A";
                $MDataTreatmentSuggestion->CreateDate  = $DateTime;
                $MDataTreatmentSuggestion->CreateUser  = $TreatmentSuggestion[$i]['CreateUser'];
                $MDataTreatmentSuggestion->UpdateDate  = $DateTime;
                $MDataTreatmentSuggestion->UpdateUser  = $TreatmentSuggestion[$i]['UpdateUser'];
                $MDataTreatmentSuggestion->OrgId  = $TreatmentSuggestion[$i]['OrgId'];
                $MDataTreatmentSuggestion->save();
            }    
            
            //Referral Section
            $Referral = $request->Referral;

            for($i=0;$i<count($Referral); $i++){
                $MDataPatientReferral = new MDataPatientReferral();
                $MDataPatientReferral->MDPatientReferralId = Str::uuid();
                $MDataPatientReferral->PatientId = $Referral[$i]['PatientId'];
                $MDataPatientReferral->RId = $Referral[$i]['RId'];
                $MDataPatientReferral->HealthCenterId = $Referral[$i]['HealthCenterId'];
                $MDataPatientReferral->CollectionDate = $DateTime;
                $MDataPatientReferral->Status  = "A";
                $MDataPatientReferral->CreateDate  = $DateTime;
                $MDataPatientReferral->CreateUser  = $Referral[$i]['CreateUser'];
                $MDataPatientReferral->UpdateDate  = $DateTime;
                $MDataPatientReferral->UpdateUser  = $Referral[$i]['UpdateUser'];
                $MDataPatientReferral->OrgId  = $Referral[$i]['OrgId'];
                $MDataPatientReferral->save();
            }   

            //Advice
            $Advice = $request->Advice;
            for($i=0;$i<count($Advice); $i++){
                $MDataAdvice = new MDataAdvice();
                $MDataAdvice->MDAdviceId = Str::uuid();
                $MDataAdvice->PatientId = $Advice[$i]['PatientId'];
                $MDataAdvice->CollectionDate = $DateTime;
                $MDataAdvice->AdviceId = $Advice[$i]['AdviceId'];
                $MDataAdvice->Advice = $Advice[$i]['Advice'];
                $MDataAdvice->Status  = "A";
                $MDataAdvice->CreateDate  = $DateTime;
                $MDataAdvice->CreateUser  = $Advice[$i]['CreateUser'];
                $MDataAdvice->UpdateDate  = $DateTime;
                $MDataAdvice->UpdateUser  = $Advice[$i]['UpdateUser'];
                $MDataAdvice->OrgId  = $Advice[$i]['OrgId'];
                $MDataAdvice->save();
            }    

            //Follow up Dates
            $FollowUpDate = $request->FollowUpDate;
            for($i=0;$i<count($FollowUpDate); $i++){
                $MDataFollowUpDate = new MDataFollowUpDate();
                $MDataFollowUpDate->MDFollowUpDateId = Str::uuid();
                $MDataFollowUpDate->PatientId = $FollowUpDate[$i]['PatientId'];
                $MDataFollowUpDate->CollectionDate = $DateTime;
                $MDataFollowUpDate->FollowUpDate = $FollowUpDate[$i]['FollowUpDate'];
                $MDataFollowUpDate->Status  = "A";
                $MDataFollowUpDate->CreateDate  = $DateTime;
                $MDataFollowUpDate->CreateUser  = $FollowUpDate[$i]['CreateUser'];
                $MDataFollowUpDate->UpdateDate  = $DateTime;
                $MDataFollowUpDate->UpdateUser  = $FollowUpDate[$i]['UpdateUser'];
                $MDataFollowUpDate->OrgId  = $FollowUpDate[$i]['OrgId'];
                $MDataFollowUpDate->save();
            }    
            DB::commit();
            $status = [
                'code'=> 200,
                'message' =>'Station 4C saved successfully!'
               ];

           return response()->json($status);

        }
        catch(\Exception $e){
            // Rollback the transaction in case of an exception
            DB::rollBack();
            $status = [
                'code'=> 403,
                'message'=>$e->getMessage()
            ];

            return response()->json(['status'=>$status]);

        }
    }
}
