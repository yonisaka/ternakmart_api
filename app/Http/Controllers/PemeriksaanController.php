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
                ->orderByDesc('id')
                ->get();

        return response()->json(['pemeriksaan' =>  $data], 200);
    } 

    public function show($id){
        try {
            $pemeriksaan = DB::table('pemeriksaan')
                            ->where('id_ternak','=',$id)
                            ->orderByDesc('id')
                            ->first();

            return response()->json(['pemeriksaan' => $pemeriksaan], 200);

        } catch (\Exception $e) {

            return response()->json(['message' => 'ternak not found!'], 404);
        }
    }

    public function detail($id){
        try {
            $pemeriksaan = DB::table('pemeriksaan')
                            ->where('id','=',$id)
                            ->first();

            return response()->json(['pemeriksaan' => $pemeriksaan], 200);

        } catch (\Exception $e) {

            return response()->json(['message' => 'ternak not found!'], 404);
        }
    }

    public function store(Request $request){
        //validate incoming request 
        // $this->validate($request, [
        //     'anamnesa' => 'required',
        //     'ekspresi_muka' => 'required',
        //     'kondisi_badan' => 'required',
        //     'pulsus' => 'required',
        //     'crt' => 'required',
        //     'kelenjar_limfe' => 'required',
        //     'alat_pernafasan' => 'required',
        //     'alat_peredaran_darah' => 'required',
        //     'alat_pencernaan' => 'required',
        //     'alat_kelamin_perkencingan' => 'required',
        //     'saraf' => 'required',
        //     'anggota_gerak' => 'required',
        //     'lain_lain' => 'required',
        //     'diagnosa_awal' => 'required',
        //     'pemeriksaan_lab' => 'required',
        //     'diagnosa_akhir' => 'required',
        //     'prognosa' => 'required',
        //     'tindakan_lainnya' => 'required',
        //     'tgl_pemeriksaan' => 'required|date',
        // ]);
        // try {
            $data = new Pemeriksaan();
            $data->id_ternak = $request->input('id_ternak');
            $data->anamnesa = $request->input('anamnesa');
            $data->ekspresi_muka = $request->input('ekspresi_muka');
            $data->kondisi_badan = $request->input('kondisi_badan');
            $data->frekuensi_nafas = $request->input('frekuensi_nafas');
            $data->pulsus = $request->input('pulsus');
            $data->suhu = $request->input('suhu');
            $data->crt = $request->input('crt');
            $data->kelenjar_limfe = $request->input('kelenjar_limfe');
            $data->alat_pernafasan = $request->input('alat_pernafasan');
            $data->alat_peredaran_darah = $request->input('alat_peredaran_darah');
            $data->alat_pencernaan = $request->input('alat_pencernaan');
            $data->alat_kelamin_perkencingan = $request->input('alat_kelamin_perkencingan');
            $data->saraf = $request->input('saraf');
            $data->anggota_gerak = $request->input('anggota_gerak');
            $data->lain_lain = $request->input('lain_lain');
            $data->diagnosa_awal = $request->input('diagnosa_awal');
            $data->pemeriksaan_lab = $request->input('pemeriksaan_lab');
            $data->diagnosa_akhir = $request->input('diagnosa_akhir');
            $data->prognosa = $request->input('prognosa');
            $data->tindakan_lainnya = $request->input('tindakan_lainnya');
            $data->terapi = $request->input('terapi');
            $data->tgl_pemeriksaan = $request->input('tgl_pemeriksaan');
            $data->save();

            return response()->json(['message' => 'Berhasil Tambah Data'], 200);
        // } catch (\Exception $e) {
        //     return response()->json(['message' => 'Gagal Tambah Data!'], 404);
        // }
    }

    public function update(Request $request, $id){
        // $this->validate($request, [
        //     'anamnesa' => 'required',
        //     'ekspresi_muka' => 'required',
        //     'kondisi_badan' => 'required|numeric',
        //     'pulsus' => 'required|date',
        //     'crt' => 'required',
        //     'kelenjar_limfe' => 'required|numeric',
        //     'alat_pernafasan' => 'required',
        //     'alat_peredaran_darah' => 'required',
        //     'alat_pencernaan' => 'required',
        //     'alat_kelamin_perkencingan' => 'required',
        //     'saraf' => 'required',
        //     'anggota_gerak' => 'required',
        //     'lain_lain' => 'required',
        //     'diagnosa_awal' => 'required',
        //     'pemeriksaan_lab' => 'required',
        //     'diagnosa_akhir' => 'required',
        //     'prognosa' => 'required',
        //     'tindakan_lainnya' => 'required',
        //     'terapi' => 'required',
        //     'tgl_pemeriksaan' => 'required|date',
        // ]);
        try {
            $data = Pemeriksaan::where('id_ternak', $id)->first();
            $data->id_dokter = empty($request->input('id_dokter')) ? $data->id_dokter : $request->input('id_dokter');
            $data->rfid = empty($request->input('rfid')) ? $data->rfid : $request->input('rfid');
            $data->anamnesa = empty($request->input('anamnesa')) ? $data->anamnesa : $request->input('anamnesa');
            $data->ekspresi_muka = empty($request->input('ekspresi_muka')) ? $data->ekspresi_muka : $request->input('ekspresi_muka');
            $data->kondisi_badan = empty($request->input('kondisi_badan')) ? $data->kondisi_badan : $request->input('kondisi_badan');
            $data->frekuensi_nafas = empty($request->input('frekuensi_nafas')) ? $data->frekuensi_nafas : $request->input('frekuensi_nafas');
            $data->pulsus = empty($request->input('pulsus')) ? $data->pulsus : $request->input('pulsus');
            $data->suhu = empty($request->input('suhu')) ? $data->suhu : $request->input('suhu');
            $data->crt = empty($request->input('crt')) ? $data->crt : $request->input('crt');
            $data->kelenjar_limfe = empty($request->input('kelenjar_limfe')) ? $data->kelenjar_limfe : $request->input('kelenjar_limfe');
            $data->alat_pernafasan = empty($request->input('alat_pernafasan')) ? $data->alat_pernafasan : $request->input('alat_pernafasan');
            $data->alat_peredaran_darah = empty($request->input('alat_peredaran_darah')) ? $data->alat_peredaran_darah : $request->input('alat_peredaran_darah');
            $data->alat_pencernaan = empty($request->input('alat_pencernaan')) ? $data->alat_pencernaan : $request->input('alat_pencernaan');
            $data->alat_kelamin_perkencingan = empty($request->input('alat_kelamin_perkencingan')) ? $data->alat_kelamin_perkencingan : $request->input('alat_kelamin_perkencingan');
            $data->saraf = empty($request->input('saraf')) ? $data->saraf : $request->input('saraf');
            $data->anggota_gerak = empty($request->input('anggota_gerak')) ? $data->anggota_gerak : $request->input('anggota_gerak');
            $data->lain_lain = empty($request->input('lain_lain')) ? $data->lain_lain : $request->input('lain_lain');
            $data->diagnosa_awal = empty($request->input('diagnosa_awal')) ? $data->diagnosa_awal : $request->input('diagnosa_awal');
            $data->pemeriksaan_lab = empty($request->input('pemeriksaan_lab')) ? $data->pemeriksaan_lab : $request->input('pemeriksaan_lab');
            $data->diagnosa_akhir = empty($request->input('diagnosa_akhir')) ? $data->diagnosa_akhir : $request->input('diagnosa_akhir');
            $data->prognosa = empty($request->input('prognosa')) ? $data->prognosa : $request->input('prognosa');
            $data->tindakan_lainnya = empty($request->input('tindakan_lainnya')) ? $data->tindakan_lainnya : $request->input('tindakan_lainnya');
            $data->terapi = empty($request->input('terapi')) ? $data->terapi : $request->input('terapi');
            $data->tgl_pemeriksaan = empty($request->input('tgl_pemeriksaan')) ? $data->tgl_pemeriksaan : $request->input('tgl_pemeriksaan');
            $data->save();

            return response()->json(['message' => 'Berhasil Mengupdate Data'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal Tambah Data!'], 404);
        }
    }
}