<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use Illuminate\Support\Facades\DB;

class ProdukController extends Controller
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
        $data = Produk::leftJoin('lokasi','produk.city_id','=','lokasi.city_id')
                        ->select('produk.*','lokasi.city_name')
                        ->get();

        return response()->json(['data' =>  $data], 200);
    }

    public function show($id){
        $data = Produk::leftJoin('lokasi','produk.city_id','=','lokasi.city_id')
                        ->select('produk.*','lokasi.latitude','lokasi.longitude')
                        ->where('id',$id)->first();

        return response()->json(['data' =>  $data], 200);
    }

    public function search(Request $request){
        try {
            $query = Produk::leftJoin('lokasi','produk.city_id','=','lokasi.city_id')
                    ->select('produk.*','lokasi.city_name')
                    ->where('produk.produk_nama','like', '%'.$request->input('nama').'%')
                    ->where('produk.produk_jenis','like', '%'.$request->input('produk_jenis').'%')
                    ->where('produk.city_id','like', '%'.$request->input('city_id').'%')
                    ;

            $data = $query->get();
            return response()->json(['data' => $data], 200);

        } catch (\Exception $e) {

            return response()->json(['message' => $e], 404);
        }
    }
}
