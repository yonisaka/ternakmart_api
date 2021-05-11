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
        //
    }

    public function store(Request $request){
        $total = count($request->all());

        for ($i = 0; $i < $total; $i++) {
            $data = new Lokasi();
            $data->city_id = $request[$i]['city_id'];
            $data->province_id = $request[$i]['province_id'];
            $data->province = $request[$i]['province'];
            $data->type = $request[$i]['type'];
            $data->city_name = $request[$i]['city_name'];
            $data->postal_code = $request[$i]['postal_code'];
         
            $data->save();
        }
        // try {
            // $data = new Lokasi();
            // $data->city_id = $request->input('city_id');
            // $data->province_id = $request->input('province_id');
            // $data->province = $request->input('province');
            // $data->type = $request->input('type');
            // $data->city_name = $request->input('city_name');
            // $data->postal_code = $request->input('postal_code');
         
            // $data->save();

            // return response()->json(['message' => 'Berhasil Tambah Data'], 200);
        // } catch (\Exception $e) {
        //     return response()->json(['message' => 'Gagal Tambah Data!'], 404);
        // }
    }
}
