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

    public function provinsi(){
        $data = DB::table('lokasi')
                ->select('province_id', 'province')
                ->groupBy('province_id', 'province')
                ->get();

        return response()->json(['provinsi' =>  $data], 200);
    }

    public function kota($province_id){
        $data = DB::table('lokasi')
                ->select('city_id', 'type', 'city_name', 'postal_code','latitude','longitude')
                ->where('province_id', $province_id)
                ->get();

        return response()->json(['kota' =>  $data], 200);
    }

    public function detail_kota($city_id){
        $data = DB::table('lokasi')
                ->select('city_id', 'type', 'city_name', 'postal_code','latitude','longitude')
                ->where('city_id', $city_id)
                ->first();

        return response()->json(['kota' =>  $data], 200);
    }
    
}
