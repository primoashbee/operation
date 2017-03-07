<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CBU;
class CBUController extends Controller
{
    public function byDisbursementID($id){
        //$cbu = CBU::where('disbursement_id','=',$id)->where('amount','>','0')->get();
        $cbu = CBU::where('disbursement_id','=',$id)->get();
        return view('pages.view-collected-cbu',['data'=>$cbu]);
    }
}
