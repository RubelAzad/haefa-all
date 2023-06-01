<?php

namespace App\Http\Controllers;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
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

    public function searchPatientAllInfo(Request $request){
        $stationId=$request->station;
        $stationId=$request->station;
        if($stationId == ""){
            return $this->responseJson(false, HttpResponse::HTTP_BAD_GATEWAY, 'Error. Could Not Found Station Id');
        }else{
            if($stationId == "1"){
                if($request->Card){
                    $patientDetails=Patient::with('Gender','MartitalStatus')->where('RegistrationId','=',$request->Card)->get();
                    return $patientDetails;
                }
                if($request->NID){
                    $patientDetails=Patient::with('Gender','MartitalStatus')->where('IdNumber','=',$request->NID)->get();
                    return $patientDetails;
                }
                if($request->Name){
                    $patientDetails=Patient::with('Gender','MartitalStatus')->where('GivenName','=',$request->Name)->get();
                    return $patientDetails;
                }
                if($request->Mobile){
                    $patientDetails=Patient::with('Gender','MartitalStatus')->where('CellNumber','=',$request->Mobile)->get();
                    return $patientDetails;
                }
    
            }elseif($stationId == "2"){
                if($request->Card){
                    $patientDetails=Patient::with('Gender','MartitalStatus')->where('RegistrationId','=',$request->Card)->get();
                    return $patientDetails;
                }
                if($request->NID){
                    $patientDetails=Patient::with('Gender','MartitalStatus')->where('IdNumber','=',$request->NID)->get();
                    return $patientDetails;
                }
                if($request->Name){
                    $patientDetails=Patient::with('Gender','MartitalStatus')->where('GivenName','=',$request->Name)->get();
                    return $patientDetails;
                }
                if($request->Mobile){
                    $patientDetails=Patient::with('Gender','MartitalStatus')->where('CellNumber','=',$request->Mobile)->get();
                    return $patientDetails;
                }
    
            }elseif($stationId == "3"){
                if($request->Card){
                    $patientDetails=Patient::with('Gender','MartitalStatus')->where('RegistrationId','=',$request->Card)->get();
                    return $patientDetails;
                }
                if($request->NID){
                    $patientDetails=Patient::with('Gender','MartitalStatus')->where('IdNumber','=',$request->NID)->get();
                    return $patientDetails;
                }
                if($request->Name){
                    $patientDetails=Patient::with('Gender','MartitalStatus')->where('GivenName','=',$request->Name)->get();
                    return $patientDetails;
                }
                if($request->Mobile){
                    $patientDetails=Patient::with('Gender','MartitalStatus')->where('CellNumber','=',$request->Mobile)->get();
                    return $patientDetails;
                }
    
            }elseif($stationId == "4"){
                if($request->patientId){
                    $patientDetails=Patient::with('Gender','MartitalStatus','bps','height_weights','glucose_hbs')->where('patientId','=',$request->patientId)->get();
                    return response()->json(['status' => true, 'code'=>200, 'message'=>'Get Patient Data','patientAllInfo'=>$patientDetails], 200);
                }
                if($request->Card){
                    $patientDetails=Patient::with('Gender','MartitalStatus')->where('RegistrationId','=',$request->Card)->get();
                    return response()->json(['status' => true, 'code'=>200, 'message'=>'Get Patient Data','patientAllInfo'=>$patientDetails], 200);
                }
                if($request->NID){
                    $patientDetails=Patient::with('Gender','MartitalStatus')->where('IdNumber','=',$request->NID)->get();
                    return response()->json(['status' => true, 'code'=>200, 'message'=>'Get Patient Data','patientAllInfo'=>$patientDetails], 200);
                }
                if($request->Name){
                    $patientDetails=Patient::with('Gender','MartitalStatus')->where('GivenName','=',$request->Name)->get();
                    return response()->json(['status' => true, 'code'=>200, 'message'=>'Get Patient Data','patientAllInfo'=>$patientDetails], 200);
                }
                if($request->Mobile){
                    $patientDetails=Patient::with('Gender','MartitalStatus')->where('CellNumber','=',$request->Mobile)->get();
                    return response()->json(['status' => true, 'code'=>200, 'message'=>'Get Patient Data','patientAllInfo'=>$patientDetails], 200);
                }
    
            }else{
                return $this->responseJson(false, HttpResponse::HTTP_BAD_GATEWAY, 'Error. Could Not Found Data');
            }
        }

        
        
        // if($request->Card){
        //     $patientDetails=Patient::with('Gender','MartitalStatus')->where('RegistrationId','=',$request->Card)->get();
        //     return $patientDetails;
        // }
        // if($request->NID){
        //     $patientDetails=Patient::with('Gender','MartitalStatus')->where('IdNumber','=',$request->NID)->get();
        //     return $patientDetails;
        // }
        // if($request->Name){
        //     $patientDetails=Patient::with('Gender','MartitalStatus')->where('GivenName','=',$request->Name)->get();
        //     return $patientDetails;
        // }
        // if($request->Mobile){
        //     $patientDetails=Patient::with('Gender','MartitalStatus')->where('CellNumber','=',$request->Mobile)->get();
        //     return $patientDetails;
        // }
    }
}
