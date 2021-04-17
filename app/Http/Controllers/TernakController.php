<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ternak;
use Illuminate\Support\Facades\DB;

class TernakController extends Controller
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
        $data = DB::table('ternak')
                ->leftJoin('jenis', 'ternak.id_jenis', '=', 'jenis.id')
                ->get();

        return response()->json(['ternak' =>  $data], 200);
    }

    public function show($id){
            try {
                $ternak = Ternak::findOrFail($id);
    
                return response()->json(['ternak' => $ternak], 200);
    
            } catch (\Exception $e) {
    
                return response()->json(['message' => 'ternak not found!'], 404);
            }
    }

    public function store(Request $request){
        $data = new Ternak();
        $data->ternak_nama = $request->input('ternak_nama');
        $data->ternak_berat = $request->input('ternak_berat');
        $data->ternak_tinggi = $request->input('ternak_tinggi');
        $data->ternak_umur = $request->input('ternak_umur');
        $data->ternak_deskripsi = $request->input('ternak_deskripsi');
        $data->id_pedagang = $request->input('id_pedagang');
        $data->id_verifikator = $request->input('id_verifikator');
        $data->ternak_harga = $request->input('ternak_harga');
        $data->tgl_penerimaan = $request->input('tgl_penerimaan');
        $data->ternak_st = $request->input('ternak_st');
        $data->verifikasi_st = $request->input('verifikasi_st');
        $data->id_jenis = $request->input('id_jenis');
        $data->save();

        return response()->json(['message' => 'Berhasil Tambah Data'], 200);
    }
    
    public function update(Request $request, $id){
        $data = Ternak::where('id', $id)->first();
        $data->ternak_nama = $request->input('ternak_nama');
        $data->save();

        return response()->json(['message' => 'Berhasil Mengupdate Data'], 200);
    }

    public function destroy($id){
        $data = Ternak::where('id', $id)->first();
        $data->delete();

        return response()->json(['message' => 'Berhasil Menghapus Data'], 200);
    }
}
