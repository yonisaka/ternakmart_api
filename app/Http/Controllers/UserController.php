<?php

namespace App\Http\Controllers;

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

    public function destroy($id){
        $data = User::where('id', $id)->first();
        $data->delete();

        return response()->json(['message' => 'Berhasil Menghapus Data'], 200);
    }

}
