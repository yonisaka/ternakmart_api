<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
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
        $data = Menu::all();

        return response()->json(['menu' =>  $data], 200);
    }

    public function show($id){
        try {
            $menu = DB::table('menu AS a')
                        ->leftJoin('menu AS b', 'b.id','=','a.parent_id')
                        ->select('a.*','b.nav_title AS parent_title')
                        ->where('a.id','=', $id)
                        ->first();

            return response()->json(['menu' => $menu], 200);

        } catch (\Exception $e) {

            return response()->json(['message' => 'menu not found!'], 404);
        }
    }

    public function update(Request $request, $id){

        $data = Menu::where('id', $id)->first();
        
        $data->nav_title = empty($request->input('nav_title')) ? $data->nav_title : $request->input('nav_title');
        $data->parent_id = empty($request->input('parent_id')) ? $data->parent_id : $request->input('parent_id');
        $data->url = empty($request->input('url')) ? $data->url : $request->input('url');
        $data->icon = empty($request->input('icon')) ? $data->icon : $request->input('icon');
      
        $data->save();

        return response()->json(['message' => 'Berhasil Mengupdate Data'], 200);
    }
}
