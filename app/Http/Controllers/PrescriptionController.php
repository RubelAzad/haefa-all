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

        $prescriptionCreation= DB::select("SELECT TOP 1 MAX(PPC.PrescriptionId) AS PrescriptionId,MAX(E.FirstName) AS FirstName,MAX(E.LastName) AS LastName,MAX(E.Designation) AS Designation,MAX(E.EmployeeSignature) AS EmployeeSignature, CAST(PPC.CreateDate AS date) as CreateDate
            FROM PrescriptionCreation as PPC 
            INNER JOIN Employee as E on E.EmployeeId = PPC.EmployeeId
            WHERE PatientId = '$request->patientId' AND CAST(PPC.CreateDate AS date) 
            = CAST(
                (SELECT TOP 1 MAX(CreateDate) AS MaxCreateDate
                FROM PrescriptionCreation WHERE PatientId = '$request->patientId'
                GROUP BY CAST(CreateDate AS date)
                ORDER BY MaxCreateDate DESC)
                AS date) GROUP BY PPC.CreateDate ORDER BY PPC.CreateDate");

        $Complaints= DB::select("SELECT PC.ChiefComplain AS ChiefComplain, PC.CCDurationValue AS CCDurationValue, PC.OtherCC AS OtherCC, RD.DurationInEnglish AS DurationInEnglish, PC.CreateDate
            FROM MDataPatientCCDetails as PC 
            INNER JOIN RefDuration as RD on RD.DurationId = PC.DurationId
            WHERE PatientId = '$request->patientId' AND CAST(PC.CreateDate AS date) 
            = CAST(
                (SELECT TOP 1 MAX(CreateDate) AS MaxCreateDate
                FROM MDataPatientCCDetails WHERE PatientId = '$request->patientId'
                GROUP BY CAST(CreateDate AS date)
                ORDER BY MaxCreateDate DESC)
                AS date) ORDER BY PC.CreateDate");

        $HeightWeight= DB::select("SELECT TOP 1 MAX(Height) AS Height, MAX(Weight) AS Weight, MAX(BMI) AS BMI, MAX(BMIStatus) AS BMIStatus, CAST(CreateDate AS date) as CreateDate
            FROM MDataHeightWeight WHERE PatientId = '$request->patientId' AND CAST(CreateDate AS date) 
            = CAST(
                (SELECT TOP 1 MAX(CreateDate) AS MaxCreateDate
                FROM MDataHeightWeight WHERE PatientId = '$request->patientId'
                GROUP BY CAST(CreateDate AS date)
                ORDER BY MaxCreateDate DESC)
                AS date) GROUP BY CreateDate ORDER BY CreateDate");
        
        $BP= DB::select("SELECT TOP 1 MAX(BPSystolic1) AS BPSystolic1, MAX(BPDiastolic1) AS BPDiastolic1, MAX(BPSystolic2) AS BPSystolic2, MAX(BPDiastolic2) AS BPDiastolic2, MAX(HeartRate) AS HeartRate, MAX(CurrentTemparature) AS CurrentTemparature, CAST(CreateDate AS date) as CreateDate
            FROM MDataBP WHERE PatientId = '$request->patientId' AND CAST(CreateDate AS date) 
            = CAST(
                (SELECT TOP 1 MAX(CreateDate) AS MaxCreateDate
                FROM MDataBP WHERE PatientId = '$request->patientId'
                GROUP BY CAST(CreateDate AS date)
                ORDER BY MaxCreateDate DESC)
                AS date) GROUP BY CreateDate ORDER BY CreateDate");
        
        $GlucoseHb = DB::select("SELECT TOP 1 MAX(RBG) AS RBG, MAX(FBG) AS FBG, MAX(Hemoglobin) AS Hemoglobin, MAX(HrsFromLastEat) AS HrsFromLastEat, CAST(CreateDate AS date) as CreateDate
            FROM MDataGlucoseHb WHERE PatientId = '$request->patientId' AND CAST(CreateDate AS date) 
            = CAST(
                (SELECT TOP 1 MAX(CreateDate) AS MaxCreateDate
                FROM MDataGlucoseHb WHERE PatientId = '$request->patientId'
                GROUP BY CAST(CreateDate AS date)
                ORDER BY MaxCreateDate DESC)
                AS date) GROUP BY CreateDate ORDER BY CreateDate");

        $ProvisionalDx = DB::select("SELECT ProvisionalDiagnosis, DiagnosisStatus, OtherProvisionalDiagnosis, CreateDate
        FROM MDataProvisionalDiagnosis WHERE PatientId = '$request->patientId' AND CAST(CreateDate AS date) 
        = CAST(
            (SELECT TOP 1 MAX(CreateDate) AS MaxCreateDate
            FROM MDataProvisionalDiagnosis WHERE PatientId = '$request->patientId'
            GROUP BY CAST(CreateDate AS date)
            ORDER BY MaxCreateDate DESC)
            AS date) ORDER BY CreateDate");


       $Investigation= DB::select("SELECT  RI.Investigation AS Investigation, I.OtherInvestigation AS OtherInvestigation, I.CreateDate
            FROM MDataInvestigation as I
            INNER JOIN RefLabInvestigation as RI on RI.RefLabInvestigationId = I.InvestigationId
            WHERE PatientId = '$request->patientId' AND CAST(I.CreateDate AS date) 
            = CAST(
                (SELECT TOP 1 MAX(CreateDate) AS MaxCreateDate
                FROM MDataInvestigation WHERE PatientId = '$request->patientId'
                GROUP BY CAST(CreateDate AS date)
                ORDER BY MaxCreateDate DESC)
                AS date) ORDER BY I.CreateDate");


        $Treatment= DB::select("SELECT T.Frequency AS Frequency, T.DrugDurationValue AS DrugDurationValue,T.OtherDrug AS OtherDrug,T.SpecialInstruction AS SpecialInstruction,T.DrugDose AS DrugDose, Dr.DrugCode AS DrugCode, Dr.Description AS Description, Dr.DrugDose AS DrugDose, Ins.InstructionInBangla AS InstructionInBangla, T.CreateDate
            FROM MDataTreatmentSuggestion as T
            INNER JOIN RefDrug as Dr on Dr.DrugId = T.DrugId
            INNER JOIN RefInstruction as Ins on Ins.RefInstructionId = T.RefInstructionId
            WHERE PatientId = '$request->patientId' AND CAST(T.CreateDate AS date) 
            = CAST(
                (SELECT TOP 1 MAX(CreateDate) AS MaxCreateDate
                FROM MDataTreatmentSuggestion WHERE PatientId = '$request->patientId'
                GROUP BY CAST(CreateDate AS date)
                ORDER BY MaxCreateDate DESC)
                AS date) ORDER BY T.CreateDate");


        $Advice= DB::select("SELECT RA.AdviceInBangla AS AdviceInBangla, RA.AdviceInEnglish AS AdviceInEnglish, A.CreateDate
            FROM MDataAdvice as A
            INNER JOIN RefAdvice as RA on RA.AdviceId = A.AdviceId
            WHERE PatientId = '$request->patientId' AND CAST(A.CreateDate AS date) 
            = CAST(
                (SELECT TOP 1 MAX(CreateDate) AS MaxCreateDate
                FROM MDataAdvice WHERE PatientId = '$request->patientId'
                GROUP BY CAST(CreateDate AS date)
                ORDER BY MaxCreateDate DESC)
                AS date) ORDER BY A.CreateDate");


        $PatientReferral= DB::select("SELECT RR.Description AS Description, HC.HealthCenterName AS HealthCenterName, PR.CreateDate
            FROM MDataPatientReferral as PR
            INNER JOIN RefReferral as RR on RR.RId = PR.RId
            INNER JOIN HealthCenter as HC on HC.HealthCenterId = PR.HealthCenterId
            WHERE PatientId = '$request->patientId' AND CAST(PR.CreateDate AS date) 
            = CAST(
                (SELECT TOP 1 MAX(CreateDate) AS MaxCreateDate
                FROM MDataPatientReferral WHERE PatientId = '$request->patientId'
                GROUP BY CAST(CreateDate AS date)
                ORDER BY MaxCreateDate DESC)
                AS date) ORDER BY PR.CreateDate");

        

        $FollowUpDate= DB::select("SELECT TOP 1 MAX(FD. FollowUpDate) AS FollowUpDate, MAX(FD.Comment) AS Comment, CAST(FD.CreateDate AS date) as CreateDate
            FROM MDataFollowUpDate as FD
            WHERE PatientId = '$request->patientId' AND CAST(FD.CreateDate AS date) 
            = CAST(
                (SELECT TOP 1 MAX(CreateDate) AS MaxCreateDate
                FROM MDataPatientReferral WHERE PatientId = '$request->patientId'
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
