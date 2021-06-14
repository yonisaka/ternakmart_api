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

        return response()->json(['message' => 'Success'], 200);

    }

    //
}
