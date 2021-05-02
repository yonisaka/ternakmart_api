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
        $jenis = DB::table('jenis')
                        ->leftJoin('golongan','golongan.id','=','jenis.id_golongan')
                        ->select('jenis.*','golongan.golongan_nama')
                        ->get();

        return response()->json(['jenis' =>  $jenis], 200);
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

    public function detail($id){
        try {
            $jenis = DB::table('jenis')
                        ->leftJoin('golongan','golongan.id','=','jenis.id_golongan')
                        ->select('jenis.*','golongan.golongan_nama')
                        ->where('jenis.id','=', $id)
                        ->first();

            return response()->json(['jenis' => $jenis], 200);

        } catch (\Exception $e) {

            return response()->json(['message' => 'jenis not found!'], 404);
        }
    }
}
