<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;
use Illuminate\Support\Facades\DB;

class DeviceController extends Controller
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
        //asd
    }
    public function show($id){
        //asd
    }
    public function store(Request $request){
        //asd
        $data = new Device();
        $data->id_rfid = $request->input('id_rfid');
        $data->id_device = $request->input('id_device');
        $data->save();

        return response()->json(['Status' =>  "Success"], 200);
    }
    public function update(Request $request){
        //asd
    }
    public function destroy($id){
        //asd
    }

    //
}
