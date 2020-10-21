<?php

namespace App\Http\Controllers;

use App\Orders\OrderClass;
use App\User;
use App\Zipcode;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;


class RoadWarriarServiceController extends Controller
{

    public $date1;
    public $date2;
    public $date3;
    private $url;

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
        $this->url='https://teamapi.roadwarrior.app/api/route/add?token=4yqwESDlsE5ZKaQYU2nFbdj5D20vZQ83&accountid=9ae3e9fd-0d92-17dd-329f-a3c662bf5ae8';
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('roadwarriar')->with(["dt1"=> $this->date1, "dt2"=> $this->date2, "dt3"=> $this->date3]);
    }

    /**
     * @param string $name
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function routeAll($name='')
    {
        if ($name=='') $name="All ".date("d.m.Y");
        $order=new OrderClass();
        $orders=$order->getAllOpenOrders()->orders;
        $errorRoutes=$this->routeRoadWarriar($orders, $name);
        return view('success')->with(["Orders"=>$errorRoutes]);
    }

    /**
     * @param string $name
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function routeCurrent($name='')
    {
        if ($name=='') $name="Current Week ".date("d.m.Y", strtotime($this->date1))." - ".date("d.m.Y", strtotime($this->date2));
        $order=new OrderClass();
        $orders=$order->getAllOpenOrdersByDate($this->date1, $this->date2)->orders;
        $errorRoutes=$this->routeRoadWarriar($orders, $name);
        return view('success')->with(["Orders"=>$errorRoutes]);
    }

    /**
     * @param string $name
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function routeNext($name='')
    {
        if ($name=='') $name="Next week ".date("d.m.Y", strtotime($this->date2))." - ".date("d.m.Y", strtotime($this->date3));
        $order=new OrderClass();
        $orders=$order->getAllOpenOrdersByDate($this->date2, $this->date3)->orders;
        $errorRoutes=$this->routeRoadWarriar($orders, $name);
        return view('success')->with(["Orders"=>$errorRoutes]);
    }

    /**
     * Собираем данные и Строим график роадварьер
     * @param $orders
     * @param $name
     * @return array
     */
    public function routeRoadWarriar($orders, $name)
    {
        $errorRoutes=array();
        $xxx=array();
        $orderCls=new OrderClass();
        foreach ($orders as $order)
        {
            if (isset($order->shipping_address))
            {
                $arr=array(
                    "Name" => $order->order_number." / ".$order->shipping_address->name." / ".$order->shipping_address->address1." ".$order->shipping_address->address2,
                    "Address" => $order->shipping_address->address1." ".$order->shipping_address->address2,
                    "Lat" => $order->shipping_address->latitude,
                    "Lng" => $order->shipping_address->longitude,
                    "ServiceTime" => 10,
                    "Email" => $order->email,
                    "Note" => $order->note,
                    "Phone" => $order->shipping_address->phone,
                );

                $arrEroorr=array(
                    "Name" => $order->shipping_address->name,
                    "Address" => $order->shipping_address->address1." ".$order->shipping_address->address2,
                    "Lat" => $order->shipping_address->latitude,
                    "Lng" => $order->shipping_address->longitude,
                    "ServiceTime" => 10,
                    "Email" => $order->email,
                    "Note" => $order->note,
                    "Phone" => $order->shipping_address->phone,
                    "Error" => "no error"
                );

                $array1=array('id' => $order->id);
                $array2=array(
                    'order_number' => $order->order_number,
                    'customer' => $order->shipping_address->name,
                    'billing_address' => $order->shipping_address->address1." ".$order->shipping_address->address2,
                    'total_price' => $order->total_price,
                    'created_at' => date("Y-m-d", strtotime($order->created_at)),
                    'updated_at' => date("Y-m-d"),
                    'phone' => $order->shipping_address->phone,
                    'email' => $order->email,
                    'zip' => $order->shipping_address->zip,
                    'latitude' => $order->shipping_address->latitude,
                    'longitude' => $order->shipping_address->longitude,
                    'note' => $order->note,
                    "error" => ""
                );

                $zip=Zipcode::where('zip', $order->shipping_address->zip)->get()->toArray();

            }
            else
            {
                $arr=array(
                    "Name" => $order->order_number." / ".$order->billing_address->name." / ".$order->billing_address->address1." ".$order->billing_address->address2,
                    "Address" => $order->billing_address->address1." ".$order->billing_address->address2,
                    "Lat" => $order->billing_address->latitude,
                    "Lng" => $order->billing_address->longitude,
                    "ServiceTime" => 10,
                    "Email" => $order->email,
                    "Note" => $order->note,
                    "Phone" => $order->billing_address->phone,
                );

                $arrEroorr=array(
                    "Name" => $order->billing_address->name,
                    "Address" => $order->billing_address->address1." ".$order->billing_address->address2,
                    "Lat" => $order->billing_address->latitude,
                    "Lng" => $order->billing_address->longitude,
                    "ServiceTime" => 10,
                    "Email" => $order->email,
                    "Note" => $order->note,
                    "Phone" => $order->billing_address->phone,
                    "Error" => "no error"
                );

                $array1=array('id' => $order->id);
                $array2=array(
                    'order_number' => $order->order_number,
                    'customer' => $order->billing_address->name,
                    'billing_address' => $order->billing_address->address1." ".$order->billing_address->address2,
                    'total_price' => $order->total_price,
                    'created_at' => date("Y-m-d", strtotime($order->created_at)),
                    'updated_at' => date("Y-m-d"),
                    'phone' => $order->billing_address->phone,
                    'email' => $order->email,
                    'zip' => (int)$order->billing_address->zip,
                    'latitude' => $order->billing_address->latitude,
                    'longitude' => $order->billing_address->longitude,
                    'note' => $order->note,
                    "error" => ""
                );

                $zip=Zipcode::where('zip', $order->billing_address->zip)->get()->toArray();

            }

            if (!$zip)
            {
                if (isset($order->shipping_address))
                {
                    $arrEroorr['Error']='zip code error ('.$order->shipping_address->zip.')';
                    $array2['error']='zip code error ('.$order->shipping_address->zip.')';
                }
                else
                {
                    $arrEroorr['Error']='zip code error ('.$order->billing_address->zip.')';
                    $array2['error']='zip code error ('.$order->billing_address->zip.')';
                }
                array_push($errorRoutes, $arrEroorr);
                $orderCls->saveOrderToBase($array1, $array2);
                continue;
            }

            if($order->shipping_lines) {
                if ($order->shipping_lines[0]->code == "59 Roberts St") {
                    $arrEroorr['Error'] = '59 Roberts St, no delivery';
                    array_push($errorRoutes, $arrEroorr);
                    $array2['error']='59 Roberts St';
                    $orderCls->saveOrderToBase($array1, $array2);

                    continue;
                }
            }

            if((int)$order->total_price<80) {
                $arrEroorr['Error']='total price < 80';
                array_push($errorRoutes, $arrEroorr);
                $array2['error']='total price < 80';
                $orderCls->saveOrderToBase($array1, $array2);
                continue;
            }

            if (!isset($order->shipping_address)) {
                $arrEroorr['Error']='Shipping address missing';
                array_push($errorRoutes, $arrEroorr);
                $array2['error']='Shipping address missing';
                $orderCls->saveOrderToBase($array1, $array2);
                continue;
            }


            if (isset($order->shipping_address)) {
                if ($order->shipping_address->latitude == null) {
                    $arrEroorr['Error'] = 'does not have coordinates';
                    array_push($errorRoutes, $arrEroorr);
                    $array2['error'] = 'does not have coordinates';
                    $orderCls->saveOrderToBase($array1, $array2);
                    continue;
                }
            }

            $orderCls->saveOrderToBase($array1, $array2);
            array_push($xxx, $arr);
        }

        $client = new Client();
        $result = $client->post($this->url, [
            'json' => [
                'Name' => $name,
                'HardStart' => false,
                'HardStop' => false,
                "TravelMode" => 0,
                "Driver" => "Dispatcher (hello@whly.com.au)",
                "IsRoundTrip" => true,
                'Stops' => $xxx
            ]
        ]);

        return $errorRoutes;
        //echo($result->getBody()->getContents());
    }

    /**
     * @return Zipcode[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getZip()
    {
        return Zipcode::all();
    }

}
