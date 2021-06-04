<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemesanan;
use Illuminate\Support\Facades\DB;

class PemesananController extends Controller
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

    public function store(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'email' => 'required|string',
            'nama' => 'required|string',
            'nomor_hp' => 'required',
            'province_id' => 'required',
            'city_id' => 'required',
            'tgl_pengiriman' => 'required',
        ]);

        try {
            $data = new Pemesanan;
            $data->email = $request->input('email');
            $data->nama = $request->input('nama');
            $data->nomor_hp = $request->input('nomor_hp');
            $data->province_id = $request->input('province_id');
            $data->city_id = $request->input('city_id');
            $data->detail_alamat = $request->input('detail_alamat');
            $data->kurban_sapi = $request->input('kurban_sapi');
            $data->jumlah_sapi = $request->input('jumlah_sapi');
            $data->kurban_kambing = $request->input('kurban_kambing');
            $data->jumlah_kambing = $request->input('jumlah_kambing');
            $data->kurban_domba = $request->input('kurban_domba');
            $data->jumlah_domba = $request->input('jumlah_domba');

            $data->save();

            //return successful response
            return response()->json(['Pemesanan' => $data, 'message' => 'CREATED'], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => $e], 409);
        }

    }

}
