<?php

namespace App\Http\Controllers;
use App\Models\Order;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function orders(){
        $orders = Order::All();

        $orders->transform(function($order,$key){
            $order->cart = unserialize($order->cart);

            return $order;


        });
        return view('admin.orders')->with('orders',$orders);
    }
}
