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
    
    public function kota_aktif(){
        $data = DB::table('lokasi')
                ->join('ternak','lokasi.city_id','=','ternak.city_id')
                ->where('ternak.ternak_st',1)
                ->select('lokasi.city_id','lokasi.city_name')
                ->groupBy('city_id','city_name')
                ->get();

        // $data = DB::select(" SELECT * FROM (
        //                 SELECT a.city_name FROM lokasi a
        //                 INNER JOIN ternak b ON a.city_id = b.city_id
        //                 GROUP BY city_name 
        //                 ) a
        //             ");

        // print_r($data);exit;
        return response()->json(['kota' =>  $data], 200);
    }

    public function kota_aktif_produk(){
        $data = DB::table('lokasi')
                ->join('produk','lokasi.city_id','=','produk.city_id')
                ->select('lokasi.city_id','lokasi.city_name')
                ->where('produk.kategori','=', 'produk')
                ->groupBy('city_id','city_name')
                ->get();

        // $data = DB::select(" SELECT * FROM (
        //                 SELECT a.city_name FROM lokasi a
        //                 INNER JOIN ternak b ON a.city_id = b.city_id
        //                 GROUP BY city_name 
        //                 ) a
        //             ");

        // print_r($data);exit;
        return response()->json(['kota' =>  $data], 200);
    }

    public function kota_aktif_aqiqah(){
        $data = DB::table('lokasi')
                ->join('produk','lokasi.city_id','=','produk.city_id')
                ->select('lokasi.city_id','lokasi.city_name')
                ->where('produk.kategori','=', 'aqiqah')
                ->groupBy('city_id','city_name')
                ->get();

        // $data = DB::select(" SELECT * FROM (
        //                 SELECT a.city_name FROM lokasi a
        //                 INNER JOIN ternak b ON a.city_id = b.city_id
        //                 GROUP BY city_name 
        //                 ) a
        //             ");

        // print_r($data);exit;
        return response()->json(['kota' =>  $data], 200);
    }
}
