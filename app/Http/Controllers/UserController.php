<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
     /**
     * Instantiate a new UserController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('cors');
    }

    /**
     * Get the authenticated User.
     *
     * @return Response
     */
    public function profile()
    {
        return response()->json(['user' => Auth::user()], 200);
    }

    /**
     * Get all User.
     *
     * @return Response
     */
    public function allUsers()
    {
        $data = DB::table('users')
                ->leftJoin('role', 'users.role_id', '=', 'role.id')
                ->select('users.*','role.role_nama')
                ->get();

        return response()->json(['users' =>  $data], 200);
    }

    /**
     * Get one user.
     *
     * @return Response
     */
    public function singleUser($id)
    {
        try {
            $data = DB::table('users')
                    ->where('id', $id)
                    ->first();

            if($data){
                $result_array = json_decode(json_encode($data), true);
                return response()->json([
                    'message' => 'Success',
                    'user' => $data,
                    'token' => $this->respondWithToken($result_array['remember_token'])
                ]);
            } else {
                return response()->json(['message' => 'user not found!'], 404);
            }

        } catch (\Exception $e) {

            return response()->json(['message' => 'user not found!'], 404);
        }

    }

    public function store(Request $request)
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

            $user->role_id = $request->input('role_id');
            $user->user_st = $request->input('user_st');

            $user->save();

            //return successful response
            return response()->json(['user' => $user, 'message' => 'CREATED'], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => $e], 409);
        }

    }

    public function update(Request $request, $id)
    {
        //validate incoming request 
        // $this->validate($request, [
        //     'name' => 'required|string',
        //     'email' => 'required|email|unique:users',
        //     'password' => 'required|confirmed',
        // ]);

        try {

            $user = User::where('id', $id)->first();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            // $plainPassword = $request->input('password');
            // $user->password = app('hash')->make($plainPassword);

            // $user->role_id = $request->input('role_id');
            $user->user_st = $request->input('user_st');
            $user->save();

            //return successful response
            return response()->json(['user' => $user, 'message' => 'UPDATED'], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => $e], 409);
        }

    }

    public function destroy($id){
        $data = User::where('id', $id)->first();
        $data->delete();

        return response()->json(['message' => 'Berhasil Menghapus Data'], 200);
    }

}
