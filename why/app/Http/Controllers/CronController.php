<?php

namespace App\Http\Controllers;

use App\Log;
use App\Order;
use App\Orders\OrderClass;
use Illuminate\Http\Request;

class CronController extends Controller
{
    public function index()
    {
        // Пока проверяем
        Log::insert(
            ['request' => date('Y-m-d H:i'), 'created_at' => date('Y-m-d'), 'updated_at' => date('Y-m-d')]
        );
/*
        $orders=Order::all()->toArray();
        foreach ($orders as $order)
        {
            Order::where('order_number', $order["order_number"])->delete();
            try {
                $orderCLS= new OrderClass();
                $orderCLS->fulfillments($order["id"]);
            } catch (\Exception $e)
            {
            }
        }
*/
        return 999;
    }
}
