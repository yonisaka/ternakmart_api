<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lokasi;
use Illuminate\Support\Facades\DB;

class LokasiController extends Controller
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

    public function index(){
        $data = DB::table('lokasi')
                ->get();

        return response()->json(['daftar_kota' =>  $data], 200);
    }

    //
}
