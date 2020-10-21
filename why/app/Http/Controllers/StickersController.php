<?php

namespace App\Http\Controllers;

use App\Orders\OrderClass;
use App\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;

class StickersController extends Controller
{

    public $date1;
    public $date2;
    public $date3;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->date1=date(DATE_ATOM, strtotime('monday last week +9 hour'));
        $this->date2=date(DATE_ATOM, strtotime('monday this week +9 hour'));
        $this->date3=date(DATE_ATOM, strtotime('monday next week +9 hour'));
        ini_set('max_execution_time', 180);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $orders=new OrderClass();
        return view('stickers')->with(['orders' => $orders->getAllOpenOrdersByDate($this->date1, $this->date2), 'ordersNext' => $orders->getAllOpenOrdersByDate($this->date2, $this->date3), 'dt1' => $this->date1, 'dt2' => $this->date2, 'dt3' => $this->date3]);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function pdf($id)
    {
        $order=new OrderClass();
        $CurrentOrder=$order->getOrderById($id);
        $data = [
            'title' => 'First PDF for Medium',
            'heading' => 'Hello from 99Points.info',
            'order' => $CurrentOrder,
            ];
        $pdf = PDF::loadView('pdf_view', $data);
        return $pdf->download($CurrentOrder->billing_address->name.".pdf");
    }

    /**
     * @return mixed
     */
    public function allpdf()
    {
        $order=new OrderClass();
        $CurrentOrder=$order->getAllOpenOrders();
        $arrSend=array();
        foreach ($CurrentOrder->orders as $order)
        {
           $arrOrder=array();
           array_push($arrOrder, $order->order_number);
           array_push($arrOrder, $order->billing_address->name);
           $billingAdressString='<span style="font-size: 20px; font-weight: 900; text-transform: uppercase">Delivery address: </span>';
           array_push($arrOrder, $billingAdressString.' <b>city:</b> '.$order->billing_address->city." | ".$order->billing_address->address1." ".$order->billing_address->address2);
           array_push($arrOrder, $this->renderProductsToArray($order->line_items));
           array_push($arrOrder, $order->total_price);
           array_push($arrSend, $arrOrder);
        }
        $data = [
            'title' => 'First PDF for Medium',
            'heading' => 'Hello from 99Points.info',
            'order' => $arrSend,
        ];

        $pdf = PDF::loadView('pdf_view_all', $data);
        return $pdf->download("all.pdf");
    }

    /**
     * @return mixed
     */
    public function allpdfCurrent()
    {
        $order=new OrderClass();
        $CurrentOrder=$order->getAllOpenOrdersByDate($this->date1, $this->date2);
        $arrSend=array();
        foreach ($CurrentOrder->orders as $order)
        {
            $arrOrder=array();
            array_push($arrOrder, $order->order_number);
            array_push($arrOrder, $order->billing_address->name);
            $billingAdressString='<span style="font-size: 20px; font-weight: 900; text-transform: uppercase">Delivery address: </span>';
            array_push($arrOrder, $billingAdressString.' <b>city:</b> '.$order->billing_address->city." | ".$order->billing_address->address1." ".$order->billing_address->address2);
            array_push($arrOrder, $this->renderProductsToArray($order->line_items));
            array_push($arrOrder, $order->total_price);
            array_push($arrSend, $arrOrder);
        }
        $data = [
            'title' => 'First PDF for Medium',
            'heading' => 'Hello from 99Points.info',
            'order' => $arrSend,
        ];
        $pdf = PDF::loadView('pdf_view_all', $data);
        return $pdf->download("all.pdf");
    }

    /**
     * @return mixed
     */
    public function allpdfNext()
    {
        $order=new OrderClass();
        $CurrentOrder=$order->getAllOpenOrdersByDate($this->date2, $this->date3);
        $arrSend=array();
        foreach ($CurrentOrder->orders as $order)
        {
            $arrOrder=array();
            array_push($arrOrder, $order->order_number);
            array_push($arrOrder, $order->billing_address->name);
            $billingAdressString='<span style="font-size: 20px; font-weight: 900; text-transform: uppercase">Delivery address: </span>';
            array_push($arrOrder, $billingAdressString.' <b>city:</b> '.$order->billing_address->city." | ".$order->billing_address->address1." ".$order->billing_address->address2);

            array_push($arrOrder, $this->renderProductsToArray($order->line_items));
            array_push($arrOrder, $order->total_price);
            array_push($arrSend, $arrOrder);
        }
        $data = [
            'title' => 'First PDF for Medium',
            'heading' => 'Hello from 99Points.info',
            'order' => $arrSend,
        ];
        $pdf = PDF::loadView('pdf_view_all', $data);
        return $pdf->download("all.pdf");
    }

    /**
     * Не пригодилось fufeled и закрывает и в архив сам ложит
     * @param $id
     * @return string
     */
    public function close($id)
    {
        $order= new OrderClass();
        try {
            $order->fulfillments($id);
            return $id . " closed";
        } catch (\Exception $e)
        {
            return "Some error";
        }
    }

    /**
     * @param $productsArray
     * @return array
     */
    public function renderProductsToArray($productsArray)
    {
        $arrproducts=array();
        foreach ($productsArray as $product)
        {
            $arrProduct=array('name' => $product->name, 'quantity' => $product->quantity, 'price' => $product->price);
            array_push($arrproducts, $arrProduct);

        }
        return $arrproducts;
    }


    public function test()
    {
        $orders=new OrderClass();
        echo "<pre>";
        foreach ($orders->getAllOpenOrders()->orders as $order) {
            if (isset($order->shipping_address)) echo "<br>-------------------<br>";
            echo $order->id."<br>";
            echo $order->order_number."<br>";
            var_dump($order->billing_address);
            if (isset($order->shipping_address)) var_dump($order->shipping_address);
        }
        echo "</pre>";
    }

}
