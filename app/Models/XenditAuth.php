<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class XenditAuth extends Model
{
    public static function basic_auth() {
        $dev = 'Basic eG5kX2RldmVsb3BtZW50X3dhdzlucmJ0TlNRQk5VVmJvNDdoUXdrVXdQcWRNNTVkQ0lWM0RORk5lVFBEa2w1Sndad2VST25RYWE0aW1qZUY6';
        $prod = 'Basic eG5kX3Byb2R1Y3Rpb25fTHB6bE1BM2dDQXBrN242M2JJT2xpTTVVeGVuZEV4YUkwZ2VZSUZ0ZVdJa0o3eEx1RUljczdFWUE5VDVBZ0I6';
        return $dev;
    } 
}