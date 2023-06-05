<?php

namespace App\Http\Controllers;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Illuminate\Http\Request;
use App\Models\Patient;
use Illuminate\Support\Facades\DB;
use App\Models\MDataBP;
use App\Models\MDataHeightWeight;
use App\Models\MDataGlucoseHb;
use App\Models\MDataPatientCCDetails;
use App\Models\MDataPhysicalExamGeneral;
use App\Models\MDataPhysicalFinding;
use App\Models\MDataRxDetails;
use App\Models\MDataInvestigation;

class PrescriptionController extends Controller
{
    public function prescription(Request $request){

        // $mdatabp=Patient::with('cc_details_patient','bps_patient','height_weights_patient','glucose_hbs_patient')->where('PatientId','=',$request->patientId)->get();

        // return $mdatabp;

        // $dataPatient=DB::table('Patient as p')
        //     ->select('p.*','c.*','hw.*')
        // ->join('MDataPatientCCDetails as c','p.PatientId','=','c.PatientId')
        // ->join('MDataHeightWeight as hw','p.PatientId','=','hw.PatientId')
        // ->where('p.PatientId','=',$request->patientId)
        // ->get();
        
        // $ProvisionalDx = DB::select("SELECT MAX(ProvisionalDiagnosis) AS ProvisionalDiagnosis, MAX(DiagnosisStatus) AS DiagnosisStatus, MAX(OtherProvisionalDiagnosis) AS OtherProvisionalDiagnosis, CAST(CreateDate AS date) as CreateDate
        // FROM MDataProvisionalDiagnosis WHERE PatientId = '$request->patientId' AND CAST(CreateDate AS date) 
        // = CAST(
        //     (SELECT TOP 1 MAX(CreateDate) AS MaxCreateDate
        //     FROM MDataProvisionalDiagnosis
        //     GROUP BY CAST(CreateDate AS date)
        //     ORDER BY MaxCreateDate DESC)
        //     AS date) GROUP BY CreateDate ORDER BY CreateDate");

        // return $ProvisionalDx;

        // $Complaints= DB::select("SELECT MAX(ChiefComplain) AS ChiefComplain, CAST(CreateDate AS date) as CreateDate
        //     FROM MDataPatientCCDetails WHERE PatientId = '$request->patientId' AND CAST(CreateDate AS date) 
        //     = CAST(
        //         (SELECT TOP 1 MAX(CreateDate) AS MaxCreateDate
        //         FROM MDataPatientCCDetails
        //         GROUP BY CAST(CreateDate AS date)
        //         ORDER BY MaxCreateDate DESC)
        //         AS date) GROUP BY CreateDate ORDER BY CreateDate");

        
        // return $Complaints;

        //$cc=MDataPatientCCDetails::where('PatientId','=',$request->patientId)->->get();

        $Complaints= DB::select("SELECT MAX(ChiefComplain) AS ChiefComplain, CAST(CreateDate AS date) as CreateDate
            FROM MDataPatientCCDetails WHERE PatientId = '$request->patientId' AND CAST(CreateDate AS date) 
            = CAST(
                (SELECT TOP 1 MAX(CreateDate) AS MaxCreateDate
                FROM MDataPatientCCDetails
                GROUP BY CAST(CreateDate AS date)
                ORDER BY MaxCreateDate DESC)
                AS date) GROUP BY CreateDate ORDER BY CreateDate");

        $OS = Patient::with('bps_patient','height_weights_patient','glucose_hbs_patient')->where('PatientId','=',$request->patientId)->get();

        $ProvisionalDx = DB::select("SELECT MAX(ProvisionalDiagnosis) AS ProvisionalDiagnosis, MAX(DiagnosisStatus) AS DiagnosisStatus, MAX(OtherProvisionalDiagnosis) AS OtherProvisionalDiagnosis, CAST(CreateDate AS date) as CreateDate
        FROM MDataProvisionalDiagnosis WHERE PatientId = '$request->patientId' AND CAST(CreateDate AS date) 
        = CAST(
            (SELECT TOP 1 MAX(CreateDate) AS MaxCreateDate
            FROM MDataProvisionalDiagnosis
            GROUP BY CAST(CreateDate AS date)
            ORDER BY MaxCreateDate DESC)
            AS date) GROUP BY CreateDate ORDER BY CreateDate");


       $Investigation= DB::select("SELECT  MAX(RI.Investigation) AS Investigation, MAX(I.OtherInvestigation) AS OtherInvestigation, CAST(I.CreateDate AS date) as CreateDate
            FROM MDataInvestigation as I
            INNER JOIN RefLabInvestigation as RI on RI.RefLabInvestigationId = I.InvestigationId
            WHERE PatientId = '$request->patientId' AND CAST(I.CreateDate AS date) 
            = CAST(
                (SELECT TOP 1 MAX(CreateDate) AS MaxCreateDate
                FROM MDataInvestigation
                GROUP BY CAST(CreateDate AS date)
                ORDER BY MaxCreateDate DESC)
                AS date) GROUP BY I.CreateDate ORDER BY I.CreateDate");


        $Treatment= DB::select("SELECT MAX(T.Frequency) AS Frequency, MAX(T.DrugDurationValue) AS DrugDurationValue,MAX(T.OtherDrug) AS OtherDrug, MAX(Dr.DrugCode) AS DrugCode, MAX(Dr.DrugDose) AS DrugDose, MAX(Ins.InstructionInBangla) AS InstructionInBangla, CAST(T.CreateDate AS date) as CreateDate
            FROM MDataTreatmentSuggestion as T
            INNER JOIN RefDrug as Dr on Dr.DrugId = T.DrugId
            INNER JOIN RefInstruction as Ins on Ins.RefInstructionId = T.RefInstructionId
            WHERE PatientId = '$request->patientId' AND CAST(T.CreateDate AS date) 
            = CAST(
                (SELECT TOP 1 MAX(CreateDate) AS MaxCreateDate
                FROM MDataTreatmentSuggestion
                GROUP BY CAST(CreateDate AS date)
                ORDER BY MaxCreateDate DESC)
                AS date) GROUP BY T.CreateDate ORDER BY T.CreateDate");


        $Advice= DB::select("SELECT MAX(RA.AdviceInBangla) AS AdviceInBangla, MAX(RA.AdviceInEnglish) AS AdviceInEnglish, CAST(A.CreateDate AS date) as CreateDate
            FROM MDataAdvice as A
            INNER JOIN RefAdvice as RA on RA.AdviceId = A.AdviceId
            WHERE PatientId = '$request->patientId' AND CAST(A.CreateDate AS date) 
            = CAST(
                (SELECT TOP 1 MAX(CreateDate) AS MaxCreateDate
                FROM MDataAdvice
                GROUP BY CAST(CreateDate AS date)
                ORDER BY MaxCreateDate DESC)
                AS date) GROUP BY A.CreateDate ORDER BY A.CreateDate");


        $PatientReferral= DB::select("SELECT MAX(RR.Description) AS Description, MAX(HC.HealthCenterName) AS HealthCenterName, CAST(PR.CreateDate AS date) as CreateDate
            FROM MDataPatientReferral as PR
            INNER JOIN RefReferral as RR on RR.RId = PR.RId
            INNER JOIN HealthCenter as HC on HC.HealthCenterId = PR.HealthCenterId
            WHERE PatientId = '$request->patientId' AND CAST(PR.CreateDate AS date) 
            = CAST(
                (SELECT TOP 1 MAX(CreateDate) AS MaxCreateDate
                FROM MDataPatientReferral
                GROUP BY CAST(CreateDate AS date)
                ORDER BY MaxCreateDate DESC)
                AS date) GROUP BY PR.CreateDate ORDER BY PR.CreateDate");

        

        $FollowUpDate= DB::select("SELECT MAX(FD. FollowUpDate) AS FollowUpDate, MAX(FD.Comment) AS Comment, CAST(FD.CreateDate AS date) as CreateDate
            FROM MDataFollowUpDate as FD
            WHERE PatientId = '$request->patientId' AND CAST(FD.CreateDate AS date) 
            = CAST(
                (SELECT TOP 1 MAX(CreateDate) AS MaxCreateDate
                FROM MDataPatientReferral
                GROUP BY CAST(CreateDate AS date)
                ORDER BY MaxCreateDate DESC)
                AS date) GROUP BY FD.CreateDate ORDER BY FD.CreateDate");


        return response()->json([
            'message' => 'Final Prescription',
            'code'=>200,
            'Complaints'=>$Complaints,
            'OS'=>$OS,
            'ProvisionalDx'=>$ProvisionalDx,
            'Investigation'=>$Investigation,
            'Treatment'=>$Treatment,
            'Advice'=>$Advice,
            'PatientReferral'=>$PatientReferral,
            'FollowUpDate'=>$FollowUpDate,

        ],200);

        
        

        
    }
}
