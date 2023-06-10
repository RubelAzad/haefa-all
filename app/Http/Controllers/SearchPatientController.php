<?php

namespace App\Http\Controllers;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Patient;
use App\Models\Station;
class SearchPatientController extends Controller
{
    public function searchPatientAllInfo(Request $request){
        $stationId=$request->station;
        $Card=$request->Card;
        $Name=$request->Name;
        $NID=$request->NID;
        $Mobile=$request->Mobile;


        $patientDetails=Patient::select('PatientId')->where('RegistrationId','=',$Card)->orWhere('IdNumber','=',$NID)->orWhere('CellNumber','=',$Mobile)->first();

        $StationStatus = Station::select('StationStatus')->where('PatientId','=',$patientDetails->PatientId)->first();

        if($StationStatus->StationStatus === $stationId){
            if($StationStatus->StationStatus === "4"){
                $PatientDetails= DB::select("SELECT PD.RegistrationId AS RegistrationId, PD.GivenName AS GivenName, PD.FamilyName AS FamilyName, PD.BirthDate AS BirthDate, PD.Age AS Age, PD.IdNumber AS IdNumber, PD.CellNumber AS CellNumber, RG.GenderCode AS GenderCode, RMS.MaritalStatusCode AS MaritalStatusCode
                FROM Patient as PD
                INNER JOIN RefGender as RG on RG.GenderId = PD.GenderId
                INNER JOIN RefMaritalStatus as RMS on RMS.MaritalStatusId = PD.MaritalStatusId
                WHERE PatientId = '$patientDetails->PatientId'");

                $HeightWeight= DB::select("SELECT TOP 1 MAX(Height) AS Height, MAX(Weight) AS Weight, MAX(BMI) AS BMI, MAX(BMIStatus) AS BMIStatus, CAST(CreateDate AS date) as CreateDate
                FROM MDataHeightWeight WHERE PatientId = '$patientDetails->PatientId' AND CAST(CreateDate AS date) 
                = CAST(
                    (SELECT TOP 1 MAX(CreateDate) AS MaxCreateDate
                    FROM MDataHeightWeight WHERE PatientId = '$patientDetails->PatientId'
                    GROUP BY CAST(CreateDate AS date)
                    ORDER BY MaxCreateDate DESC)
                    AS date) GROUP BY CreateDate ORDER BY CreateDate");

                $BP= DB::select("SELECT TOP 1 MAX(BPSystolic1) AS BPSystolic1, MAX(BPDiastolic1) AS BPDiastolic1, MAX(BPSystolic2) AS BPSystolic2, MAX(BPDiastolic2) AS BPDiastolic2, MAX(HeartRate) AS HeartRate, MAX(CurrentTemparature) AS CurrentTemparature, CAST(CreateDate AS date) as CreateDate
                FROM MDataBP WHERE PatientId = '$patientDetails->PatientId' AND CAST(CreateDate AS date) 
                = CAST(
                    (SELECT TOP 1 MAX(CreateDate) AS MaxCreateDate
                    FROM MDataBP WHERE PatientId = '$patientDetails->PatientId'
                    GROUP BY CAST(CreateDate AS date)
                    ORDER BY MaxCreateDate DESC)
                    AS date) GROUP BY CreateDate ORDER BY CreateDate");
                
                $GlucoseHb = DB::select("SELECT TOP 1 MAX(RBG) AS RBG, MAX(FBG) AS FBG, MAX(Hemoglobin) AS Hemoglobin, MAX(HrsFromLastEat) AS HrsFromLastEat, CAST(CreateDate AS date) as CreateDate
                FROM MDataGlucoseHb WHERE PatientId = '$patientDetails->PatientId' AND CAST(CreateDate AS date) 
                = CAST(
                    (SELECT TOP 1 MAX(CreateDate) AS MaxCreateDate
                    FROM MDataGlucoseHb WHERE PatientId = '$patientDetails->PatientId'
                    GROUP BY CAST(CreateDate AS date)
                    ORDER BY MaxCreateDate DESC)
                    AS date) GROUP BY CreateDate ORDER BY CreateDate");

                return response()->json([
                    'message' => 'Final Prescription',
                    'code'=>200,
                    'PatientDetails'=>$PatientDetails,
                    'HeightWeight'=>$HeightWeight,
                    'BP'=>$BP,
                    'GlucoseHb'=>$GlucoseHb,

                ],200);
            }else{
                $patientDetails=Patient::with('Gender','MartitalStatus')->where('PatientId','=',$patientDetails->PatientId)->get();
                return $patientDetails;
            }
            
        }else{
            return 'Please Check Station - '.$StationStatus->StationStatus;
        }
        
        





        if($stationId == ""){
            return $this->responseJson(false, HttpResponse::HTTP_BAD_GATEWAY, 'Error. Could Not Found Station Id');
        }else{
            if($stationId == "1"){
                if($request->Card){
                    $patientDetails=Patient::with('Gender','MartitalStatus')->where('RegistrationId','=',$request->Card)->get();
                    if(count($patientDetails) === 0){
                        return 'Station 1 User data not found, This Patient is not Registered.';
                    }else{
                        return $patientDetails;
                    }
                }
                if($request->Name){
                    $patientDetails=Patient::with('Gender','MartitalStatus')->where('RegistrationId','=',$request->Name)->get();
                    if(count($patientDetails) === 0){
                        return 'Station 1 User data not found, This Patient is not Registered.';
                    }else{
                        return $patientDetails;
                    }
                }
                if($request->NID){
                    $patientDetails=Patient::with('Gender','MartitalStatus')->where('RegistrationId','=',$request->NID)->get();
                    if(count($patientDetails) === 0){
                        return 'Station 1 User data not found, This Patient is not Registered.';
                    }else{
                        return $patientDetails;
                    }
                }
                if($request->Mobile){
                    $patientDetails=Patient::with('Gender','MartitalStatus')->where('RegistrationId','=',$request->Mobile)->get();
                    if(count($patientDetails) === 0){
                        return 'Station 1 User data not found, This Patient is not Registered.';
                    }else{
                        return $patientDetails;
                    }
                }
            }
            if($stationId == "2"){
                if($request->Card){
                    $patientDetails=Patient::with('Gender','MartitalStatus')->where('RegistrationId','=',$request->Card)->get();
                    if(count($patientDetails) === 0){
                        return 'Station 1 User data not found, This Patient is not Registered.';
                    }else{
                        return $patientDetails;
                    }
                }
                if($request->Name){
                    $patientDetails=Patient::with('Gender','MartitalStatus')->where('RegistrationId','=',$request->Name)->get();
                    if(count($patientDetails) === 0){
                        return 'Station 1 User data not found, This Patient is not Registered.';
                    }else{
                        return $patientDetails;
                    }
                }
                if($request->NID){
                    $patientDetails=Patient::with('Gender','MartitalStatus')->where('RegistrationId','=',$request->NID)->get();
                    if(count($patientDetails) === 0){
                        return 'Station 1 User data not found, This Patient is not Registered.';
                    }else{
                        return $patientDetails;
                    }
                }
                if($request->Mobile){
                    $patientDetails=Patient::with('Gender','MartitalStatus')->where('RegistrationId','=',$request->Mobile)->get();
                    if(count($patientDetails) === 0){
                        return 'Station 1 User data not found, This Patient is not Registered.';
                    }else{
                        return $patientDetails;
                    }
                }
            }
            if($stationId == "3"){
                if($request->Card){
                    $patientDetails=Patient::with('Gender','MartitalStatus')->where('RegistrationId','=',$request->Card)->get();
                    if(count($patientDetails) === 0){
                        return 'Station 1 User data not found, This Patient is not Registered.';
                    }else{
                        return $patientDetails;
                    }
                }
                if($request->Name){
                    $patientDetails=Patient::with('Gender','MartitalStatus')->where('RegistrationId','=',$request->Name)->get();
                    if(count($patientDetails) === 0){
                        return 'Station 1 User data not found, This Patient is not Registered.';
                    }else{
                        return $patientDetails;
                    }
                }
                if($request->NID){
                    $patientDetails=Patient::with('Gender','MartitalStatus')->where('RegistrationId','=',$request->NID)->get();
                    if(count($patientDetails) === 0){
                        return 'Station 1 User data not found, This Patient is not Registered.';
                    }else{
                        return $patientDetails;
                    }
                }
                if($request->Mobile){
                    $patientDetails=Patient::with('Gender','MartitalStatus')->where('RegistrationId','=',$request->Mobile)->get();
                    if(count($patientDetails) === 0){
                        return 'Station 1 User data not found, This Patient is not Registered.';
                    }else{
                        return $patientDetails;
                    }
                }
            }
            if($stationId == "4"){
                if($request->Card){
                    $patientDetails=Patient::with('Gender','MartitalStatus','bps','height_weights','glucose_hbs')->where('RegistrationId','=',$request->Card)->get();
                    if(count($patientDetails) === 0){
                        return 'Station 1 User data not found, This Patient is not Registered.';
                    }else{
                        return $patientDetails;
                    }
                }
                if($request->Name){
                    $patientDetails=Patient::with('Gender','MartitalStatus')->where('RegistrationId','=',$request->Name)->get();
                    if(count($patientDetails) === 0){
                        return 'Station 1 User data not found, This Patient is not Registered.';
                    }else{
                        return $patientDetails;
                    }
                }
                if($request->NID){
                    $patientDetails=Patient::with('Gender','MartitalStatus')->where('RegistrationId','=',$request->NID)->get();
                    if(count($patientDetails) === 0){
                        return 'Station 1 User data not found, This Patient is not Registered.';
                    }else{
                        return $patientDetails;
                    }
                }
                if($request->Mobile){
                    $patientDetails=Patient::with('Gender','MartitalStatus')->where('RegistrationId','=',$request->Mobile)->get();
                    if(count($patientDetails) === 0){
                        return 'Station 1 User data not found, This Patient is not Registered.';
                    }else{
                        return $patientDetails;
                    }
                }
            }
        }
                    
    }
}
