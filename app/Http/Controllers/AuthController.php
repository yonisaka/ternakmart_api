<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Customer;
use App\Http\Controllers\Hash;
use Illuminate\Support\Facades\DB;
//import auth facades
use Illuminate\Support\Facades\Auth;
use App\Mail\ConfirmMail;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    /**
     * Store a new user.
     *
     * @param  Request  $request
     * @return Response
     */
    public function __construct()
    {
        //
        // $this->middleware('cors');
    }

    public function register(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'nomor_hp' => 'required',
            'tanggal_lahir' => 'required',
            'alamat' => 'required',
            'jenis_kelamin' => 'required',
        ]);

        //insert tabel users
        try {

            $user = new User;
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $plainPassword = $request->input('password');
            $user->password = app('hash')->make($plainPassword);

            $user->role_id = $request->input('role_id');
            $user->user_st = $request->input('user_st');

            $user->save();

            $id_user = DB::table('users')
                    ->select('id')
                    ->orderByDesc('id')
                    ->limit(1)
                    ->first();
                    // print_r($id_user->id);exit;

            //insert tabel customer
            $data = new Customer;
            $data->nama_lengkap = $request->input('nama_lengkap');
            $data->nomor_hp = $request->input('nomor_hp');
            $data->tanggal_lahir = $request->input('tanggal_lahir');
            $data->alamat = $request->input('alamat');
            $data->jenis_kelamin = $request->input('jenis_kelamin');
            $data->id_user = $id_user->id;

            $data->save();

            // email verification
            $this->send_mail($user->id);
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
            if ($user['user_st'] == 'Aktif'){
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
                return response()->json(['message' => ['User Belum di verifikasi / Tidak Aktif']], 400);
            }
        } else {
            return response()->json(['message' => ['Incorrect Email or Password']], 400);
        }
    }

    public function navigation($role_id){

        try {
            $main_nav = DB::table('menu')
                    ->leftJoin('role_menu', 'menu.id', '=', 'role_menu.menu_id')
                    ->where('parent_id',0)
                    ->where('status','1')
                    ->where('role_id',$role_id)
                    ->orderby('urutan','asc')
                    ->get();
            $result_array = json_decode(json_encode($main_nav), true);
            
            $res=array();
            foreach ($main_nav as $key => $data) {
                $data = json_decode(json_encode($data), true);
                $rs_id = DB::table('menu')
                        ->leftJoin('role_menu', 'menu.id', '=', 'role_menu.menu_id')
                        ->where('parent_id',$data['id'])
                        ->where('status','1')
                        ->where('role_id',$role_id)
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

    public function send_mail($id){
        $data = User::where('id',$id)->first();
        // print_r($data);exit;
        // Mail::to('yonisaka0@gmail.com')->send(new ConfirmMail($data));
        Mail::to($data->email)->send(new ConfirmMail($data));
    }

    public function verifikasi_akun($id)
    {
        try {

            $user = User::where('id', $id)->first();
            $user->user_st = 'Aktif';
            $user->save();

            //return successful response
            return redirect('https://caltymart.com');

        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => $e], 409);
        }

    }
}