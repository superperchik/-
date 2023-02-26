<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store()
    {
        $api_token = str_replace('Bearer','',$_SERVER['HTTP_AUTHORIZATION']);
        $api_token = str_replace(' ','',$api_token);
        $user = User::where('api_token', $api_token)->first();
        $order = Order::create([
            'user_id' => $user['id'],
        ]);

        //$order = Auth::user()->ordering();
       // Order::create()
        return response()->json([
            'data' => [
                'order_id' => $order['id'],
                'message' => 'Order is processed',
            ]
        ])->setStatusCode(201);
    }

    public function index()
    {
        $api_token = str_replace('Bearer','',$_SERVER['HTTP_AUTHORIZATION']);
        $api_token = str_replace(' ','',$api_token);
        $user = User::where('api_token', $api_token)->first();
        $allOrders = DB::table('orders')->where('user_id','=', $user['id'])->get();

        return  Order::where('user_id', $user['id'])->get();
    }
}
