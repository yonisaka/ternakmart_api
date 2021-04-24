<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Hash;
use Illuminate\Support\Facades\DB;
//import auth facades
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Store a new user.
     *
     * @param  Request  $request
     * @return Response
     */
    public function register(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ]);

        try {

            $user = new User;
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $plainPassword = $request->input('password');
            $user->password = app('hash')->make($plainPassword);

            $user->role_id = 1;
            $user->user_st = 'aktif';

            $user->save();

            //return successful response
            return response()->json(['user' => $user, 'message' => 'CREATED'], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => $e], 409);
        }

    }

    /**
     * Get a JWT via given credentials.
     *
     * @param  Request  $request
     * @return Response
     */
    public function login(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);
        //input
        $email = $request->input('email');
        $plainPassword = $request->input('password');
        //check user
        $user = User::where('email', $email)->first();
        if ( $user && app('hash')->check($plainPassword, $user->password)){
            //token
            $credentials = $request->only(['email', 'password']);
        
            if (! $token = Auth::attempt($credentials)) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
            
            $user->remember_token = $token;
            $user->save();
            
            return response()->json([
                'message' => 'Success',
                'user' => $user,
                'token' => $this->respondWithToken($token)
            ]);
            //token only
            // return $this->respondWithToken($token);
        } else {
            return response()->json(['message' => ['Incorrect Email or Password']], 401);
        }
    }

    public function navigation($role_id){

        try {
            $main_nav = DB::table('menu')
                    ->leftJoin('role_menu', 'menu.id', '=', 'role_menu.menu_id')
                    ->where('parent_id',0)
                    ->where('role_id',$role_id)
                    ->get();
            $result_array = json_decode(json_encode($main_nav), true);
            
            $res=array();
            foreach ($main_nav as $key => $data) {
                $data = json_decode(json_encode($data), true);
                $rs_id = DB::table('menu')
                        ->where('parent_id',$data['id'])
                        ->get();
                $rs_id = json_decode(json_encode($rs_id), true);
                $res[$key] = $data;
                if ($rs_id){
                    $res[$key]['subLinks'] = $rs_id;
                }
                    
            }

            return response()->json($res, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e], 409);
        }
    }
}