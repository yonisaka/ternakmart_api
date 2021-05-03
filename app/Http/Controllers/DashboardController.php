<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class DashboardController extends Controller
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

    public function total_ternak(){
        $total = DB::table('ternak')
                        ->count();

        return response()->json($total, 200);
    }

    public function total_transaksi(){
        $total = DB::table('transaksi')
                    ->count();

        return response()->json($total, 200);
    }

    public function total_ternak_verifikasi(){
        $total = DB::table('ternak')
                        ->where('verifikasi_st','=','1')
                        ->count();

        return response()->json($total, 200);
    }

    public function total_ternak_harga_transaksi(){
        $total = DB::table('transaksi')
                    ->select(DB::raw('SUM(total_harga) as total_transaksi'))
                    ->first();

        return response()->json($total, 200);
    }

    public function total_user($role){
        $total = DB::table('users')
                        ->where('role_id','=', $role)
                        ->count();

        return response()->json($total, 200);
    }

    public function total_menu(){
        $total = DB::table('menu')
                        ->count();

        return response()->json($total, 200);
    }

    public function chart_transkasi(){
        $total = DB::table('transaksi')
                    ->select(DB::raw('COUNT(*) AS total'), 'transaksi_tanggal')
                    ->where('transaksi_tanggal', '>=', Carbon::now()->subDays(7)->startOfDay())
                    ->groupBy('transaksi_tanggal')
                    ->orderBy('transaksi_tanggal')
                    ->get();
        $data = json_decode(json_encode($total), true);
        foreach($data as $val){
            $arr[] = $val['total'];
        }

        
        return response()->json($arr, 200);                    
    }
}
