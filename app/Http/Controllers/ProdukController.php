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
                        ->select('produk.*','lokasi.city_name','lokasi.province')
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

    public function store(Request $request){
        
        try {
            // upload file
            $file = $request->file('file');
            $filename = $file->getClientOriginalName();
            $path = 'foto';
            $file->move($path,$filename);
            // input
            $data = new Produk();
            $data->produk_nama = $request->input('produk_nama');
            $data->produk_jenis = $request->input('produk_jenis');
            $data->produk_deskripsi = $request->input('produk_deskripsi');
            $data->qty = $request->input('qty');
            $data->produk_harga = $request->input('produk_harga');
            $data->province_id = $request->input('province_id');
            $data->city_id = $request->input('city_id');
            $data->file_name = $filename;
            $data->file_path = url('/').'/'.$path.'/'.$filename;
            $data->save();

            return response()->json(['message' => 'Berhasil Tambah Data'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal Tambah Data!'], 404);
        }
    }

    public function update(Request $request, $id){
        
        try {
            $data = Produk::where('id', $id)->first();
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

            $data->produk_nama = empty($request->input('produk_nama')) ? $data->produd_nama : $request->input('produk_nama');
            $data->produk_jenis = empty($request->input('produk_jenis')) ? $data->produd_nama : $request->input('produk_jenis');
            $data->produk_deskripsi = empty($request->input('produk_deskripsi')) ? $data->produd_nama : $request->input('produk_deskripsi');
            $data->qty = empty($request->input('qty')) ? $data->produd_nama : $request->input('qty');
            $data->produk_harga = empty($request->input('produk_harga')) ? $data->produd_nama : $request->input('produk_harga');
            $data->province_id = empty($request->input('province_id')) ? $data->produd_nama : $request->input('province_id');
            $data->city_id = empty($request->input('city_id')) ? $data->produd_nama : $request->input('city_id');
            $data->file_name = $filename;
            $data->file_path = url('/').'/'.$path.'/'.$filename;
            $data->save();

            return response()->json(['message' => 'Berhasil Mengupdate Data'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal Tambah Data!'], 404);
        }
    }

    public function destroy($id){
        
        $data = Produk::where('id', $id)->first();
        $data->delete();

        return response()->json(['message' => 'Berhasil Menghapus Data'], 200);
    }
}
