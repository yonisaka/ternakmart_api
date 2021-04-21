<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jenis;
use Illuminate\Support\Facades\DB;

class JenisController extends Controller
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
        $data = Jenis::all();

        return response()->json(['jenis' =>  $data], 200);
    }

    public function show($id_golongan, $jenis_kelamin){
        try {
            $jenis = DB::table('jenis')
                        ->where('id_golongan','=', $id_golongan)
                        ->where('jenis_kelamin','=', $jenis_kelamin)
                        ->get();

            return response()->json(['jenis' => $jenis], 200);

        } catch (\Exception $e) {

            return response()->json(['message' => 'ternak not found!'], 404);
        }
}
}
