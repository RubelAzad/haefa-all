<?php

namespace App\Http\Controllers;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Illuminate\Http\Request;
use App\Models\Patient;

class PrescriptionPreviewController extends Controller
{
    public function patientPrescriptionPreview(Request $request){
        $patientDetails=Patient::with('height_weights','bps','glucose_hbs','cc_details','physical_exam_general','physical_finding','rx_details','investigation')->where('patientId','=',$request->patientId)->get();

        return response()->json(['status' => true, 'code'=>200, 'message'=>'Get Patient Data','patientAllInfo'=>$patientDetails], 200);
    }
}
