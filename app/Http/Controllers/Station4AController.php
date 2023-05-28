<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\RefChiefComplain;
use App\Models\RefIllness;
use App\Models\RefDuration;

class Station4AController extends Controller
{

    public function chiefComplainDays(){
        try{
           $days = RefDuration::all();
           return response()->json([$days,200]);
        }
        catch(\Exception $e){
            return response()->json(['message'=>$e->getMessage(),403]);
        }
    }

    // public function match(){
    //     RefChiefComplain::where('',)->get();
    // }
    
    public function presentIllness(){
        try{
           $illness = RefIllness::all();
           return response()->json([$illness,200]);
        }
        catch(\Exception $e){
            return response()->json(['message'=>$e->getMessage(),403]);
        }
    }
    
    
    public function pastIllness(){
        try{
           $illness = RefIllness::all();
           return response()->json([$illness,200]);
        }
        catch(\Exception $e){
            return response()->json(['message'=>$e->getMessage(),403]);
        }
    }
}
