<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
class SearchPatientController extends Controller
{
    public function searchPatient(Request $request){

        
        if($request->Card){
            $patientDetails=Patient::where('RegistrationId','=',$request->Card)->get();
            return $patientDetails;
        }
        if($request->NID){
            $patientDetails=Patient::where('IdNumber','=',$request->NID)->get();
            return $patientDetails;
        }
        if($request->Name){
            $patientDetails=Patient::where('GivenName','=',$request->Name)->get();
            return $patientDetails;
        }
        if($request->Mobile){
            $patientDetails=Patient::where('CellNumber','=',$request->Mobile)->get();
            return $patientDetails;
        }
    }
}
