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

        $patientDetails=Patient::with('Gender','MartitalStatus')->where('PatientId','=',$request->patientId)->get();

        $prescriptionCreation= DB::select("SELECT TOP 1 MAX(PrescriptionId) AS PrescriptionId, CAST(CreateDate AS date) as CreateDate
            FROM PrescriptionCreation WHERE PatientId = '$request->patientId' AND CAST(CreateDate AS date) 
            = CAST(
                (SELECT TOP 1 MAX(CreateDate) AS MaxCreateDate
                FROM PrescriptionCreation
                GROUP BY CAST(CreateDate AS date)
                ORDER BY MaxCreateDate DESC)
                AS date) GROUP BY CreateDate ORDER BY CreateDate");

        $Complaints= DB::select("SELECT MAX(PC.ChiefComplain) AS ChiefComplain, MAX(PC.CCDurationValue) AS CCDurationValue, MAX(PC.OtherCC) AS OtherCC, MAX(RD.DurationInEnglish) AS DurationInEnglish, CAST(PC.CreateDate AS date) as CreateDate
            FROM MDataPatientCCDetails as PC
            INNER JOIN RefDuration as RD on RD.DurationId = PC.DurationId
            WHERE PatientId = '$request->patientId' AND CAST(PC.CreateDate AS date) 
            = CAST(
                (SELECT TOP 1 MAX(CreateDate) AS MaxCreateDate
                FROM MDataPatientCCDetails
                GROUP BY CAST(CreateDate AS date)
                ORDER BY MaxCreateDate DESC)
                AS date) GROUP BY PC.CreateDate ORDER BY PC.CreateDate");

        $HeightWeight= DB::select("SELECT TOP 1 MAX(Height) AS Height, MAX(Weight) AS Weight, MAX(BMI) AS BMI, MAX(BMIStatus) AS BMIStatus, CAST(CreateDate AS date) as CreateDate
            FROM MDataHeightWeight WHERE PatientId = '$request->patientId' AND CAST(CreateDate AS date) 
            = CAST(
                (SELECT TOP 1 MAX(CreateDate) AS MaxCreateDate
                FROM MDataHeightWeight
                GROUP BY CAST(CreateDate AS date)
                ORDER BY MaxCreateDate DESC)
                AS date) GROUP BY CreateDate ORDER BY CreateDate");
        
        $BP= DB::select("SELECT TOP 1 MAX(BPSystolic1) AS BPSystolic1, MAX(BPDiastolic1) AS BPDiastolic1, MAX(BPSystolic2) AS BPSystolic2, MAX(BPDiastolic2) AS BPDiastolic2, MAX(HeartRate) AS HeartRate, MAX(CurrentTemparature) AS CurrentTemparature, CAST(CreateDate AS date) as CreateDate
            FROM MDataBP WHERE PatientId = '$request->patientId' AND CAST(CreateDate AS date) 
            = CAST(
                (SELECT TOP 1 MAX(CreateDate) AS MaxCreateDate
                FROM MDataBP
                GROUP BY CAST(CreateDate AS date)
                ORDER BY MaxCreateDate DESC)
                AS date) GROUP BY CreateDate ORDER BY CreateDate");
        
        $GlucoseHb = DB::select("SELECT TOP 1 MAX(RBG) AS RBG, MAX(FBG) AS FBG, MAX(Hemoglobin) AS Hemoglobin, MAX(HrsFromLastEat) AS HrsFromLastEat, CAST(CreateDate AS date) as CreateDate
            FROM MDataGlucoseHb WHERE PatientId = '$request->patientId' AND CAST(CreateDate AS date) 
            = CAST(
                (SELECT TOP 1 MAX(CreateDate) AS MaxCreateDate
                FROM MDataGlucoseHb
                GROUP BY CAST(CreateDate AS date)
                ORDER BY MaxCreateDate DESC)
                AS date) GROUP BY CreateDate ORDER BY CreateDate");

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


        $Treatment= DB::select("SELECT MAX(T.Frequency) AS Frequency, MAX(T.DrugDurationValue) AS DrugDurationValue,MAX(T.OtherDrug) AS OtherDrug,MAX(T.SpecialInstruction) AS SpecialInstruction, MAX(Dr.DrugCode) AS DrugCode, MAX(Dr.Description) AS Description, MAX(Dr.DrugDose) AS DrugDose, MAX(Ins.InstructionInBangla) AS InstructionInBangla, CAST(T.CreateDate AS date) as CreateDate
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
            'PatientDetails'=>$patientDetails,
            'prescriptionCreation'=>$prescriptionCreation,
            'Complaints'=>$Complaints,
            'HeightWeight'=>$HeightWeight,
            'BP'=>$BP,
            'GlucoseHb'=>$GlucoseHb,
            'ProvisionalDx'=>$ProvisionalDx,
            'Investigation'=>$Investigation,
            'Treatment'=>$Treatment,
            'Advice'=>$Advice,
            'PatientReferral'=>$PatientReferral,
            'FollowUpDate'=>$FollowUpDate,

        ],200);

        
        

        
    }
}
