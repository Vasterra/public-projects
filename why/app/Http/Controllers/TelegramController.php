<?php

namespace App\Http\Controllers;

use App\Log;
use App\Mail\MailSender;
use App\Order;
use App\Orders\OrderClass;
use App\telegram\Telegram;
use Illuminate\Http\Request;

class TelegramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $array=['chat_id' => env("DriverTelegramID"), 'text' => "textq" ];
        $telegram=new Telegram();
        $this->saveLog($telegram->sendMessage("sendMessage", $array));
    }

    /**
     * @param $string
     */
    public function saveLog($string)
    {
        $block = new Log();
        $block->request=$string;
        $block->created_at = date( "Y-m-d" );
        $block->updated_at = date( "Y-m-d" );
        $block->save();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $postData = file_get_contents('php://input');
        $data=json_decode($postData, true);
        $ms=$data['message']['text'];
        $iduser=$data['message']['from']['id'];

        $telegram=new Telegram();
        $this->saveLog(print_r($data, true));

        $order = Order::where('order_number', $ms)->where('status', '!=','Compleate')->first();
        if (isset($order))
        {
            $orderSend='#'.$order->order_number;
            $name=' Name: '.$order->customer."\n";
            $adress="Adress: ".$order->billing_address."\n";
            $phone="phone: ".$order->phone."\n";
            $email="email: ".$order->email."\n";
            $note="Note: ".$order->note;
            $str=$orderSend.$name.$adress.$phone.$email.$note;
            $array=[
                'chat_id' => $iduser,
                'text' => $str
            ];
            $array['reply_markup'] = [
                'keyboard' => [["Compleate order: ".$order->order_number], ["Cancel"]],
                'resize_keyboard' => true,
                'one_time_keyboard' => true,
                'parse_mode' => 'HTML',
                'selective' => true,
                'hide_keyboard' => true
            ];
        } else {
            $str=$this->telegramLogic($ms);
            $array=[
                'chat_id' => $iduser,
                'text' => $str
            ];
            $array['reply_markup'] = [
                'hide_keyboard' => true
            ];
        }

        $telegram->sendPostMessage($array);
    }


    /**
     * @param $ms
     * @return string
     */
    public function telegramLogic($ms)
    {
        $orderId=0;
        if (substr_count($ms, 'Compleate order:')>0) {
            $orderId=(int)str_replace("Compleate order: ", "", $ms);
            $ms = "Compleated";
            Order::where('order_number', $orderId)->update(['status' => "Compleate"]);
        }
        switch ($ms)
        {
            case "/start": $str="Hello. I am a bot."; break;
            case "start":
            case "Start":
            case "START": MailSender::sendAllMessage(); $str="Today delivery messages have been sent to customers."; break;
            case "Cancel": $str="Operation Canceled. Write new order."; break;
            case "Compleated":
                $str="Order #".$orderId." Compleated.";
                $this->new_mail(Order::where('order_number', $orderId)->get()[0]->toArray());
                break;
            default:
            {
                $str="Order compleated or doesn't not exists. Please try again.";
            }
        }
        return $str;
    }

    /**
     * @param $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function new_mail($order)
    {
        $orderShopify=new OrderClass();
        $CurrentOrder=$orderShopify->getOrderById($order['id']);
        $details = [
            'to' => $order['email'],
            'from' => ['address' => env('MAIL_USERNAME', 'notifications@wholistically-healthy.com'), 'name' => env('APP_NAME', 'wholistically-healthy.com')],
            'subject' => '7979',
            'title' => 'myau ',
            "body"  => $CurrentOrder
        ];

        $x=new \App\Mail\MailerTelegram($details);

        \Mail::to($order['email'])->send(new \App\Mail\MailerTelegram($details));

        if (\Mail::failures()) {
            return response()->json([
                'status'  => false,
                'data'    => $details,
                'message' => 'Nnot sending mail.. retry again...'
            ]);
        }

        return response()->json([
            'status'  => true,
            'data'    => $details,
            'message' => 'Your details mailed successfully'
        ]);
    }
}
