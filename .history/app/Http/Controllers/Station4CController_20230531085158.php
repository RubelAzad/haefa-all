<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Station4CController extends Controller
{
    public function provisionalDiagonisis(){
        try{

        }catch(\Exception $e){
            $status = [
                'code'=>403,
                'message'=>$e->getMessage()
            ]
        }
    }
}
