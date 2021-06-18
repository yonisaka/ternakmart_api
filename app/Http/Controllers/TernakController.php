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
        // $this->middleware('cors');
    }

    public function index(){
        $data = DB::select("SELECT a.*, b.jenis_nama, c.tgl_pemeriksaan, c.id_dokter, d.nama_lengkap AS dokter_nama FROM ternak a
                            LEFT JOIN jenis b ON a.id_jenis = b.id
                            LEFT JOIN (
                                SELECT id_ternak, MAX(id_dokter) AS id_dokter, MAX(tgl_pemeriksaan) AS tgl_pemeriksaan, MAX(id) AS id_pemeriksaan FROM
                                pemeriksaan 
                                GROUP BY id_ternak
                            )c ON a.id = c.id_ternak
                            LEFT JOIN dokter d ON c.id_dokter = d.id")
                            ;
        // $data = DB::table('ternak')
        //         ->leftJoin('jenis', 'ternak.id_jenis', '=', 'jenis.id')
                
        //         ->select('ternak.*','jenis.jenis_nama')
        //         ->get();

        return response()->json(['ternak' =>  $data], 200);
    }

    public function show($id){
        
            try {
                $ternak = DB::select("SELECT a.*, b.jenis_nama, b.perawatan_harga, c.tgl_pemeriksaan, c.id_dokter, d.nama_lengkap AS dokter_nama, e.latitude, e.longitude
                                FROM ternak a
                                LEFT JOIN jenis b ON a.id_jenis = b.id
                                LEFT JOIN (
                                    SELECT id_ternak, MAX(id_dokter) AS id_dokter, MAX(tgl_pemeriksaan) AS tgl_pemeriksaan, MAX(id) AS id_pemeriksaan FROM
                                    pemeriksaan 
                                    GROUP BY id_ternak
                                )c ON a.id = c.id_ternak
                                LEFT JOIN dokter d ON c.id_dokter = d.id
                                LEFT JOIN lokasi e ON a.city_id = e.city_id
                                WHERE a.id = '$id'
                                ")[0]
                                ;
                            
                // $ternak = DB::table('ternak')
                //         ->leftJoin('jenis', 'ternak.id_jenis', '=', 'jenis.id')
                //         ->leftJoin('golongan', 'jenis.id_golongan','=','golongan.id')
                //         ->leftJoin('lokasi', 'ternak.city_id','=','lokasi.city_id')
                //         ->select('ternak.*','jenis.jenis_nama','jenis.id_golongan','golongan.golongan_nama','lokasi.city_name')
                //         ->where('ternak.id','=',$id)
                //         ->first();
    
                return response()->json(['ternak' => $ternak], 200);
    
            } catch (\Exception $e) {
    
                return response()->json(['message' => 'ternak not found!'], 404);
            }
    }

    public function store(Request $request){
        //validate incoming request 
        $this->validate($request, [
            'ternak_nama' => 'required|string',
            'id_jenis' => 'required',
            'jenis_kelamin' => 'required',
            'ternak_berat' => 'required|numeric',
            'lingkar_perut' => 'required|numeric',
            'ternak_umur' => 'required|numeric',
            'ternak_deskripsi' => 'required',
            'harga_pengajuan' => 'required|numeric',
            'tgl_penerimaan' => 'required|date',
        ]);
        // if (isset($request->validator) && $request->validator->fails()) {
        //     return response()->json([
        //         'error_code'=> 'VALIDATION_ERROR', 
        //         'message'   => 'The given data was invalid.', 
        //         'errors'    => $request->validator->errors()
        //     ]);
        // }
        try {
            // upload file
            $file = $request->file('file');
            $filename = $file->getClientOriginalName();
            $path = 'foto';
            $file->move($path,$filename);
            // input
            $data = new Ternak();
            $data->rfid = $request->input('rfid');
            $data->ternak_nama = $request->input('ternak_nama');
            $data->id_jenis = $request->input('id_jenis');
            $data->jenis_kelamin = $request->input('jenis_kelamin');
            $data->ternak_berat = $request->input('ternak_berat');
            $data->lingkar_perut = $request->input('lingkar_perut');
            $data->ternak_umur = $request->input('ternak_umur');
            $data->ternak_deskripsi = $request->input('ternak_deskripsi');
            $data->id_customer = $request->input('id_customer');
            $data->id_dokter = $request->input('id_dokter');
            $data->id_penjual = $request->input('id_penjual');
            $data->harga_pengajuan = $request->input('harga_pengajuan');
            $data->ternak_harga = $request->input('ternak_harga');
            $data->harga_perkilo = $request->input('harga_perkilo');
            $data->tgl_penerimaan = $request->input('tgl_penerimaan');
            $data->province_id = $request->input('province_id');
            $data->city_id = $request->input('city_id');
            $data->tgl_keluar = $request->input('tgl_keluar');
            $data->file_name = $filename;
            $data->file_path = url('/').'/'.$path.'/'.$filename;
            $data->ternak_st = $request->input('ternak_st');
            $data->verifikasi_st = $request->input('verifikasi_st');
            $data->verifikasi_note = $request->input('verifikasi_note');
            $data->save();

            return response()->json(['message' => 'Berhasil Tambah Data'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal Tambah Data!'], 404);
        }
        
    }
    
    public function update(Request $request, $id){

        $this->validate($request, [
            'ternak_nama' => 'required|string',
            'id_jenis' => 'required',
            'jenis_kelamin' => 'required',
            'ternak_berat' => 'required|numeric',
            'lingkar_perut' => 'required|numeric',
            'ternak_umur' => 'required|numeric',
            'ternak_deskripsi' => 'required',
            'harga_pengajuan' => 'required|numeric',
            'tgl_penerimaan' => 'required|date',
        ]);
        
        try {
            $data = Ternak::where('id', $id)->first();
            
            // upload file
            if ($request->file('file')){
                $file = $request->file('file');
                $filename = $file->getClientOriginalName();
                $path = 'foto';
                $file->move($path,$filename);
            } else {
                $filename = $data->file_name;
                $path = 'foto';
            }
            // input
            
            $data->rfid = empty($request->input('rfid')) ? $data->rfid : $request->input('rfid');
            $data->ternak_nama = empty($request->input('ternak_nama')) ? $data->ternak_nama : $request->input('ternak_nama');
            $data->id_jenis = empty($request->input('id_jenis')) ? $data->id_jenis : $request->input('id_jenis');
            $data->jenis_kelamin = empty($request->input('jenis_kelamin')) ? $data->jenis_kelamin : $request->input('jenis_kelamin');
            $data->ternak_berat = empty($request->input('ternak_berat')) ? $data->ternak_berat : $request->input('ternak_berat');
            $data->lingkar_perut = empty($request->input('lingkar_perut')) ? $data->lingkar_perut : $request->input('lingkar_perut');
            $data->ternak_umur = empty($request->input('ternak_umur')) ? $data->ternak_umur : $request->input('ternak_umur');
            $data->ternak_deskripsi = empty($request->input('ternak_deskripsi')) ? $data->ternak_deskripsi : $request->input('ternak_deskripsi');
            $data->id_customer = empty($request->input('id_customer')) ? $data->id_customer : $request->input('id_customer');
            $data->id_dokter = empty($request->input('id_dokter')) ? $data->id_dokter : $request->input('id_dokter');
            $data->id_penjual = empty($request->input('id_penjual')) ? $data->id_penjual : $request->input('id_penjual');
            $data->harga_pengajuan = empty($request->input('harga_pengajuan')) ? $data->harga_pengajuan : $request->input('harga_pengajuan');
            $data->ternak_harga = empty($request->input('ternak_harga')) ? $data->ternak_harga : $request->input('ternak_harga');
            $data->harga_perkilo = empty($request->input('harga_perkilo')) ? $data->harga_perkilo : $request->input('harga_perkilo');
            $data->tgl_penerimaan = empty($request->input('tgl_penerimaan')) ? $data->tgl_penerimaan : $request->input('tgl_penerimaan');
            $data->diskon_st = empty($request->input('diskon_st')) ? $data->diskon_st : $request->input('diskon_st');
            $data->diskon_harga = empty($request->input('diskon_harga')) ? $data->diskon_harga : $request->input('diskon_harga');
            $data->province_id = empty($request->input('province_id')) ? $data->province_id : $request->input('province_id');
            $data->city_id = empty($request->input('city_id')) ? $data->city_id : $request->input('city_id');
            $data->tgl_keluar = empty($request->input('tgl_keluar')) ? $data->tgl_keluar : $request->input('tgl_keluar');
            $data->file_name = $filename;
            $data->file_path = url('/').'/'.$path.'/'.$filename;
            $data->ternak_st = $request->input('ternak_st');
            // $data->ternak_st = empty($request->input('ternak_st')) ? $data->ternak_st : $request->input('ternak_st');
            // $data->verifikasi_st = $request->input('verifikasi_st');
            $data->verifikasi_st = empty($request->input('verifikasi_st')) ? $data->verifikasi_st : $request->input('verifikasi_st');
            $data->verifikasi_note = empty($request->input('verifikasi_note')) ? $data->verifikasi_note : $request->input('verifikasi_note');
            $data->save();

            return response()->json(['message' => 'Berhasil Mengupdate Data'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal Tambah Data!'], 404);
        }
    }

    public function destroy($id){
        $data = Ternak::where('id', $id)->first();
        $data->delete();

        return response()->json(['message' => 'Berhasil Menghapus Data'], 200);
    }

    public function search(Request $request){
        // $lokasi = $request->input('lokasi');
        $ukuran = $request->input('ukuran');
        if ($ukuran == '<400'){
            $uk1 = '250';
            $uk2 = '400';
        } elseif ($ukuran == '<500'){
            $uk1 = '401';
            $uk2 = '500';
        } elseif ($ukuran == '<650'){
            $uk1 = '501';
            $uk2 = '650';
        } else {
            $uk1 = '651';
            $uk2 = '1000';
        }
        try {
            $query = DB::table('ternak')
                    ->leftJoin('jenis', 'ternak.id_jenis', '=', 'jenis.id')
                    ->leftJoin('golongan', 'jenis.id_golongan','=','golongan.id')
                    ->leftJoin('dokter', 'ternak.id_dokter', '=', 'dokter.id')
                    ->select('ternak.*','jenis.jenis_nama','jenis.id_golongan','golongan.golongan_nama',
                    'dokter.nama_lengkap')
                    ->where('ternak.ternak_nama','like', '%'.$request->input('nama').'%');

            if ($ukuran != ''){
                $query->whereBetween('ternak.ternak_berat',[$uk1, $uk2]);
            }

            // if ($lokasi != ''){
            //     $query->where('ternak.province_id','=',$lokasi);
            // }

            $ternak = $query->get();
            return response()->json(['ternak' => $ternak], 200);

        } catch (\Exception $e) {

            return response()->json(['message' => $e], 404);
        }
    }
}
