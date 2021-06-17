<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;

class Test extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function Test(){

        $invoice = DB::table('transaksi')
            ->select('*')
            ->where('order_id','=', "ORDER-1623s919504855")
            ->get()->first();
        if($invoice[0]->order_id == ""){

            return response()->json(['message' => "hehe kosong"], 200);
        }
        else{
            return response()->json([ "message" => $invoice], 200);
            
        }

    }

    //
}
