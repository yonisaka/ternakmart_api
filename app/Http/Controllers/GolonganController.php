<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Golongan;
use Illuminate\Support\Facades\DB;

class GolonganController extends Controller
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
        $data = Golongan::all();

        return response()->json(['golongan' =>  $data], 200);
    }

    public function show($id){
        try {
            $golongan = DB::table('golongan')
                        ->where('id','=', $id)
                        ->first();

            return response()->json(['golongan' => $golongan], 200);

        } catch (\Exception $e) {

            return response()->json(['message' => 'golongan not found!'], 404);
        }
    }
}
