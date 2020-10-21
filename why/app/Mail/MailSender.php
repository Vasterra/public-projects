<?php


namespace App\Mail;


use App\Order;
use App\Orders\OrderClass;

class MailSender
{

    /**
     * Отправляем всем из временной таблицы orders письма о сегоднешней доставки
     */
    public static function sendAllMessage()
    {
        $ordes=Order::all()->toArray();

        foreach ($ordes as $order) {
            $orderShopify=new OrderClass();
            if($order['error']!="") {
                $CurrentOrder = $orderShopify->getOrderById($order['id']);
                $details = [
                    'to' => $order['email'],
                    'from' => ['address' => env('MAIL_USERNAME', 'notifications@wholistically-healthy.com'), 'name' => env('APP_NAME', 'wholistically-healthy.com')],
                    'subject' => 'delivery_mail',
                    'title' => 'title',
                    "body" => $CurrentOrder
                ];

                $x = new \App\Mail\Mailer($details);

                \Mail::to($order['email'])->send(new \App\Mail\Mailer($details));
            }
        }
    }

}
