<?php

namespace App\Http\Controllers;

use App\Mail\MailSender;
use App\Order;
use App\Orders\OrderClass;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ordes=Order::all();
        return view('orders')->with(["orders" => $ordes]);
    }


    /**
     * Отменяем все заказы отмеченные как выполненные
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function CancelAll()
    {
        Order::where('order_number', ">", 0)->update(['status' => "not delivered"]);
        return redirect('/orders');
    }

    /**
     * обновить заказ по id
     * не шопифаевский
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show($order)
    {
        Order::where('order_number', $order)->update(['status' => "not delivered"]);
        return redirect('/orders');
    }

    /**
     * Удалить все заказы в админке
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function deletelist()
    {
        Order::where('order_number', '>', 0)->delete();
        return redirect('/orders');
    }

    /**
     * Удалить запись о заказе в админке
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function deleteRecord($id)
    {
        Order::where('order_number', $id)->delete();
        return redirect('/orders');
    }

    /**
     * Закрываем заказ по id
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order=Order::where('order_number', $id)->get();
        $orderId=$order[0]->id;
        Order::where('order_number', $id)->delete();
        $order= new OrderClass();
        try {
            $order->fulfillments($orderId);
            return redirect('/orders');
        } catch (\Exception $e)
        {
            return redirect('/orders');
        }
    }

    /**
     * отправить письма о том что будет развоз сешодня
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delivery_mail()
    {
        MailSender::sendAllMessage();
        return redirect('/orders');
    }

    /**
     * Закрыть все заказы в шопифае. Сделать их выполненными
     */
    public function CompleateAllOrder()
    {
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

    }

}
