<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
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
        $data = DB::select(
                "SELECT * 
                FROM role a
                LEFT JOIN (
                    SELECT COUNT(*) AS total_menu, role_id FROM role_menu
                    GROUP BY role_id
                )b ON a.id = b.role_id");

        return response()->json(['role' =>  $data], 200);
    }

    public function role_menu(){
        try {
            $role_menu = DB::table('role_menu AS a')
                        ->leftJoin('menu AS b','b.id','=','a.menu_id')
                        ->leftJoin('menu AS c', 'c.id','=','b.parent_id')
                        ->select('a.*','b.*','c.nav_title AS parent_title')
                        ->get();

            return response()->json(['role_menu' => $role_menu], 200);

        } catch (\Exception $e) {

            return response()->json(['message' => 'menu not found!'], 404);
        }
    }

    public function show($id){
        try {
            $role = DB::table('role')
                        ->where('id','=', $id)
                        ->first();

            return response()->json(['role' => $role], 200);

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

    public function destroy($role_id, $menu_id){
        $data = DB::table('role_menu')
                    ->where('role_id','=', $role_id)
                    ->where('menu_id','=', $menu_id)
                    ->first();
                    
        $data->delete();

        return response()->json(['message' => 'Berhasil Menghapus Data'], 200);
    }
}
