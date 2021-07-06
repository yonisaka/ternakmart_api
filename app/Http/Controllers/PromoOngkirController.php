<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PromoOngkirController extends Controller
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

    public function promo($city_id){
        $data = DB::select("
                    SELECT a.*,IFNULL(b.total,0) AS slot_terpakai, IF(IFNULL(b.total,0) >= a.slot,0,1) AS status_promo FROM promo_ongkir a
                    LEFT JOIN(
                        SELECT city_id, COUNT(*) AS total FROM transaksi 
                        WHERE transaksi_st <> 'CART'
                        GROUP BY city_id
                    ) b ON a.city_id = b.city_id
                    WHERE a.city_id = '$city_id'
                ");
        if($data){
            $data = $data[0];
        } else {
            $data = null;
        }
        
        return response()->json(['data' =>  $data], 200);
    }
}
