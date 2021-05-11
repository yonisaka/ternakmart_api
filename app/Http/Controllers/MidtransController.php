<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;

class MidtransController extends Controller
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

    public function paymentHandling(Request $request){
        $order_id = $request->input('order_id');

        $data = Transaksi::where('order_id', $order_id)->first();

        $data->transaksi_st = $request->input('transaction_status');
        $data->transaksi_detail = $request->input();
        $data->transaksi_tanggal = date("Y-m-d");

        $data->save();

        return response()->json(['message' => $order_id], 200);

    }

    //
}
