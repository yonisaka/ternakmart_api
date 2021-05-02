<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
        $this->middleware('cors');
    }

    public function index(){
        $data = DB::table('transaksi')
                ->leftJoin('ternak', 'ternak.id', '=', 'transaksi.id_ternak')
                ->leftJoin('users', 'users.id', '=', 'transaksi.id_user')
                ->select('transaksi.*','ternak.ternak_nama','users.name')
                ->get();

        return response()->json(['transaksi' =>  $data], 200);
    }
    public function show($id){
        try {
            $query = DB::table('transaksi')
                    ->leftJoin('ternak', 'transaksi.id_ternak', '=', 'ternak.id')
                    ->select('transaksi.*','ternak.ternak_nama','ternak.ternak_deskripsi', 
                    'ternak.file_path')
                    ->where('transaksi.id_user','=',$id)
                    ->where('transaksi.transaksi_st','=', "cart");
            $cart = $query->get();
            $count = $query->count();

            return response()->json(['cart' => $cart, 'counts' => $count], 200);

        } catch (\Exception $e) {

            return response()->json(['message' => $e], 404);
        }
    }
    public function store(Request $request){
        $data = new Transaksi;

        $data->id_ternak = $request->input('id_ternak');
        $data->id_user = $request->input('id_user');
        $data->ternak_harga = $request->input('ternak_harga');
        $data->masa_perawatan = $request->input('masa_perawatan');
        $data->total_harga = $request->input('total_harga');
        // $data->total_harga = $request->input('total_harga');
        $data->transaksi_st = $request->input('transaksi_st');
        $data->transaksi_alamat = $request->input('transaksi_alamat');

        $data->save();

        return response()->json(['message' => 'Berhasil Tambah Data'], 200);
    }
    public function update(Request $request){
        //asd
    }
    public function destroy($id){
        //asd
    }

    //
}
