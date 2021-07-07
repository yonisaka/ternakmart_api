<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Xendit;
use Illuminate\Support\Facades\DB;

class XenditController extends Controller
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
        $log = new Xendit;

        $entityBody = file_get_contents('php://input');

        $log->log = $entityBody;

        $log->save();

        //update status tabel transaksi
        $affected = DB::table('transaksi')
                ->where('invoice', $request->input('external_id'))
                ->update(['transaksi_st' => $request->input('status')]);

        //update status tabel invoices
        $affectedInvoices = DB::table('invoices')
                ->where('invoice', $request->input('external_id'))
                ->update(['status' => $request->input('status')]);

        return response()->json(['message' => 'Success'], 200);

    }

    public function logHandling(Request $request){
        $log = new Xendit;

        $entityBody = file_get_contents('php://input');

        $log->log = $entityBody;

        $log->save();
    }

    //
}
