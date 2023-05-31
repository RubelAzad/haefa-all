<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
class SearchPatientController extends Controller
{
    public function searchPatient(Request $request){

        $searchQuery = $request->query('search');
        $searchOption = $request->query('option');

        $query = Patient::query();

        if ($searchQuery && $searchOption) {
            $query->where($searchOption, 'like', '%' . $searchQuery . '%');
        }

        $data = $query->get();

        return response()->json($data);
        
    }

    public function searchPatient1(Request $request){
        
        if($request->Card){
            $patientDetails=Patient::with('Gender','MartitalStatus')->where('RegistrationId','=',$request->Card)->get();
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
