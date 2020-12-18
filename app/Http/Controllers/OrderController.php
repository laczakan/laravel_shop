<?php

namespace App\Http\Controllers;


use App\Models\Order;


class OrderController extends Controller
{
    public function show(Order $order)
    {
        $order_details = $order->orderDetails;

        return view('orders.show')
            ->with('order', $order)
            ->with('order_details', $order_details);
    }
}
