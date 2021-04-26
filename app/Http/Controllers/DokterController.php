<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dokter;
use Illuminate\Support\Facades\DB;

class DokterController extends Controller
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
        $data = Dokter::all();

        return response()->json(['dokter' =>  $data], 200);
    }

    public function show($id){
        try {
            $dokter = DB::table('dokter')
                        ->leftJoin('users','users.id','=','dokter.id_user')
                        ->where('dokter.id','=', $id)
                        ->first();

            return response()->json(['dokter' => $dokter], 200);

        } catch (\Exception $e) {

            return response()->json(['message' => 'dokter not found!'], 404);
        }
    }

    public function store(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'nama_lengkap' => 'required|string',
            'nomor_hp' => 'required',
            'tanggal_lahir' => 'required',
            'alamat' => 'required',
            'jenis_kelamin' => 'required',
        ]);

        try {

            $data = new Dokter;
            $data->nama_lengkap = $request->input('nama_lengkap');
            $data->nomor_hp = $request->input('nomor_hp');
            $data->tanggal_lahir = $request->input('tanggal_lahir');
            $data->alamat = $request->input('alamat');
            $data->jenis_kelamin = $request->input('jenis_kelamin');
            $data->id_user = $request->input('id_user');

            $data->save();

            //return successful response
            return response()->json(['dokter' => $data, 'message' => 'CREATED'], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => $e], 409);
        }

    }

    public function update(Request $request, $id)
    {
        //validate incoming request 
        $this->validate($request, [
            'nama_lengkap' => 'required|string',
            'nomor_hp' => 'required',
            'tanggal_lahir' => 'required',
            'alamat' => 'required',
            'jenis_kelamin' => 'required',
        ]);

        try {

            $data = Dokter::where('id', $id)->first();
            $data->nama_lengkap = $request->input('nama_lengkap');
            $data->nomor_hp = $request->input('nomor_hp');
            $data->tanggal_lahir = $request->input('tanggal_lahir');
            $data->alamat = $request->input('alamat');
            $data->jenis_kelamin = $request->input('jenis_kelamin');
            $data->id_user = $request->input('id_user');

            $data->save();

            //return successful response
            return response()->json(['dokter' => $data, 'message' => 'UPDATED'], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => $e], 409);
        }

    }

    public function destroy($id){
        $data = Dokter::where('id', $id)->first();
        $data->delete();

        return response()->json(['message' => 'Berhasil Menghapus Data'], 200);
    }
}
