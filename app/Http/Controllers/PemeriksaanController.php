<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemeriksaan;
use Illuminate\Support\Facades\DB;

class PemeriksaanController extends Controller
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
        $data = DB::table('pemeriksaan')
                ->get();

        return response()->json(['pemeriksaan' =>  $data], 200);
    } 

    public function show($id){
        try {
            $pemeriksaan = DB::table('pemeriksaan')
                            ->where('id_ternak','=',$id)
                            ->first();

            return response()->json(['pemeriksaan' => $pemeriksaan], 200);

        } catch (\Exception $e) {

            return response()->json(['message' => 'ternak not found!'], 404);
        }
    }

    public function store(Request $request){
        // input
        $data = new Pemeriksaan();
        $data->id_ternak = $request->input('id_ternak');
        $data->id_dokter = $request->input('id_dokter');
        $data->rfid = $request->input('rfid');
        $data->vaksin_st = $request->input('vaksin_st');
        $data->obat_cacing = $request->input('obat_cacing');
        $data->umur_bunting = $request->input('umur_bunting');
        $data->perkiraan_lahir = $request->input('perkiraan_lahir');
        $data->riwayat_kasus = $request->input('riwayat_kasus');
        $data->temperatur = $request->input('temperatur');
        $data->tonus_rumen = $request->input('tonus_rumen');
        $data->inseminasi = $request->input('inseminasi');
        $data->pengobatan = $request->input('pengobatan');
        $data->tgl_pemeriksaan = $request->input('tgl_pemeriksaan');
        $data->save();

        return response()->json(['message' => 'Berhasil Tambah Data'], 200);
    }

    public function update(Request $request, $id){

        $data = Pemeriksaan::where('id_ternak', $id)->first();
        // dd($id);exit;
        $data->id_dokter = empty($request->input('id_dokter')) ? $data->id_dokter : $request->input('id_dokter');
        $data->rfid = empty($request->input('rfid')) ? $data->rfid : $request->input('rfid');
        $data->vaksin_st = empty($request->input('vaksin_st')) ? $data->vaksin_st : $request->input('vaksin_st');
        $data->obat_cacing = empty($request->input('obat_cacing')) ? $data->obat_cacing : $request->input('obat_cacing');
        $data->umur_bunting = empty($request->input('umur_bunting')) ? $data->umur_bunting : $request->input('umur_bunting');
        $data->perkiraan_lahir = empty($request->input('perkiraan_lahir')) ? $data->perkiraan_lahir : $request->input('perkiraan_lahir');
        $data->riwayat_kasus = empty($request->input('riwayat_kasus')) ? $data->riwayat_kasus : $request->input('riwayat_kasus');
        $data->temperatur = empty($request->input('temperatur')) ? $data->temperatur : $request->input('temperatur');
        $data->tonus_rumen = empty($request->input('tonus_rumen')) ? $data->tonus_rumen : $request->input('tonus_rumen');
        $data->inseminasi = empty($request->input('inseminasi')) ? $data->inseminasi : $request->input('inseminasi');
        $data->pengobatan = empty($request->input('pengobatan')) ? $data->pengobatan : $request->input('pengobatan');
        $data->tgl_pemeriksaan = empty($request->input('tgl_pemeriksaan')) ? $data->tgl_pemeriksaan : $request->input('tgl_pemeriksaan');
        $data->save();

        return response()->json(['message' => 'Berhasil Mengupdate Data'], 200);
    }
}