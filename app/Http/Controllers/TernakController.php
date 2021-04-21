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
                ->select('ternak.*','jenis.jenis_nama')
                ->get();

        return response()->json(['ternak' =>  $data], 200);
    }

    public function show($id){
            try {
                $ternak = DB::table('ternak')
                        ->leftJoin('jenis', 'ternak.id_jenis', '=', 'jenis.id')
                        ->leftJoin('golongan', 'jenis.id_golongan','=','golongan.id')
                        ->select('ternak.*','jenis.jenis_nama','jenis.id_golongan','golongan.golongan_nama')
                        ->where('ternak.id','=',$id)
                        ->first();
    
                return response()->json(['ternak' => $ternak], 200);
    
            } catch (\Exception $e) {
    
                return response()->json(['message' => 'ternak not found!'], 404);
            }
    }

    public function store(Request $request){
        // upload file
        $file = $request->file('file');
        $filename = $file->getClientOriginalName();
        $path = 'foto';
        $file->move($path,$filename);
        // input
        $data = new Ternak();
        $data->ternak_nama = $request->input('ternak_nama');
        $data->id_jenis = $request->input('id_jenis');
        $data->jenis_kelamin = $request->input('jenis_kelamin');
        $data->ternak_berat = $request->input('ternak_berat');
        $data->ternak_tinggi = $request->input('ternak_tinggi');
        $data->ternak_umur = $request->input('ternak_umur');
        $data->ternak_deskripsi = $request->input('ternak_deskripsi');
        $data->id_customer = $request->input('id_customer');
        $data->id_dokter = $request->input('id_dokter');
        $data->id_penjual = $request->input('id_penjual');
        $data->ternak_harga = $request->input('ternak_harga');
        $data->tgl_penerimaan = $request->input('tgl_penerimaan');
        $data->tgl_keluar = $request->input('tgl_keluar');
        $data->file_name = $filename;
        $data->file_path = url('/').'/'.$path.'/'.$filename;
        $data->ternak_st = $request->input('ternak_st');
        $data->verifikasi_st = $request->input('verifikasi_st');
        $data->verifikasi_note = $request->input('verifikasi_note');
        $data->save();

        return response()->json(['message' => 'Berhasil Tambah Data'], 200);
    }
    
    public function update(Request $request, $id){

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
        
        $data->ternak_nama = empty($request->input('ternak_nama')) ? $data->ternak_nama : $request->input('ternak_nama');
        $data->id_jenis = empty($request->input('id_jenis')) ? $data->id_jenis : $request->input('id_jenis');
        $data->jenis_kelamin = empty($request->input('jenis_kelamin')) ? $data->jenis_kelamin : $request->input('jenis_kelamin');
        $data->ternak_berat = empty($request->input('ternak_berat')) ? $data->ternak_berat : $request->input('ternak_berat');
        $data->ternak_tinggi = empty($request->input('ternak_tinggi')) ? $data->ternak_tinggi : $request->input('ternak_tinggi');
        $data->ternak_umur = empty($request->input('ternak_umur')) ? $data->ternak_umur : $request->input('ternak_umur');
        $data->ternak_deskripsi = empty($request->input('ternak_deskripsi')) ? $data->ternak_deskripsi : $request->input('ternak_deskripsi');
        $data->id_customer = empty($request->input('id_customer')) ? $data->id_customer : $request->input('id_customer');
        $data->id_dokter = empty($request->input('id_dokter')) ? $data->id_dokter : $request->input('id_dokter');
        $data->id_penjual = empty($request->input('id_penjual')) ? $data->id_penjual : $request->input('id_penjual');
        $data->ternak_harga = empty($request->input('ternak_harga')) ? $data->ternak_harga : $request->input('ternak_harga');
        $data->tgl_penerimaan = empty($request->input('tgl_penerimaan')) ? $data->tgl_penerimaan : $request->input('tgl_penerimaan');
        $data->tgl_keluar = empty($request->input('tgl_keluar')) ? $data->tgl_keluar : $request->input('tgl_keluar');
        $data->file_name = $filename;
        $data->file_path = url('/').'/'.$path.'/'.$filename;
        $data->ternak_st = empty($request->input('ternak_st')) ? $data->ternak_st : $request->input('ternak_st');
        $data->verifikasi_st = empty($request->input('verifikasi_st')) ? $data->verifikasi_st : $request->input('verifikasi_st');
        $data->verifikasi_note = empty($request->input('verifikasi_note')) ? $data->verifikasi_note : $request->input('verifikasi_note');
        $data->save();

        return response()->json(['message' => 'Berhasil Mengupdate Data'], 200);
    }

    public function destroy($id){
        $data = Ternak::where('id', $id)->first();
        $data->delete();

        return response()->json(['message' => 'Berhasil Menghapus Data'], 200);
    }
}
