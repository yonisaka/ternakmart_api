<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjual;
use Illuminate\Support\Facades\DB;

class PenjualController extends Controller
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
        $data = DB::table('penjual')
                ->leftJoin('users','users.id','=','penjual.id_user')
                ->select('penjual.*', 'users.user_st')
                ->get();
        // $data = Penjual::all();

        return response()->json(['penjual' =>  $data], 200);
    }

    public function show($id){
        try {
            $penjual = DB::table('penjual')
                        ->leftJoin('users','users.id','=','penjual.id_user')
                        ->where('penjual.id','=', $id)
                        ->first();

            return response()->json(['penjual' => $penjual], 200);

        } catch (\Exception $e) {

            return response()->json(['message' => 'penjual not found!'], 404);
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

            $data = new Penjual;
            $data->nama_lengkap = $request->input('nama_lengkap');
            $data->nomor_hp = $request->input('nomor_hp');
            $data->tanggal_lahir = $request->input('tanggal_lahir');
            $data->alamat = $request->input('alamat');
            $data->jenis_kelamin = $request->input('jenis_kelamin');
            $data->id_user = $request->input('id_user');

            $data->save();

            //return successful response
            return response()->json(['penjual' => $data, 'message' => 'CREATED'], 201);

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

            $data = Penjual::where('id', $id)->first();
            $data->nama_lengkap = $request->input('nama_lengkap');
            $data->nomor_hp = $request->input('nomor_hp');
            $data->tanggal_lahir = $request->input('tanggal_lahir');
            $data->alamat = $request->input('alamat');
            $data->jenis_kelamin = $request->input('jenis_kelamin');
            $data->id_user = $request->input('id_user');

            $data->save();

            //return successful response
            return response()->json(['penjual' => $data, 'message' => 'UPDATED'], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => $e], 409);
        }

    }

    public function destroy($id){
        $data = Penjual::where('id', $id)->first();
        $data->delete();

        return response()->json(['message' => 'Berhasil Menghapus Data'], 200);
    }
}
