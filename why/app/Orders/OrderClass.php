<?php


namespace App\Orders;
use App\Order;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use mysql_xdevapi\Exception;

class OrderClass
{
    /**
     * Берем все ордера с шопифая макс 250 в принципе сейчас больше и не надо
     * @return mixed
     */
    public function getAllOpenOrders()
    {
        $httpClient = new Client();
        $response = $httpClient->get(
            env('SHOPIFY_API_KEY').'orders.json',
            [
                RequestOptions::QUERY => [
                    'limit' => 250,
                //    'created_at_min' => '2020-08-31T14:42:26+08:00',
                ],
            ]
        );
        $orders=json_decode($response->getBody()->getContents());
        return $orders;
    }

    /**
     * По датам берем ордера с шопифая
     * @param $date1
     * @param $date2
     * @return mixed
     */
    public function getAllOpenOrdersByDate($date1, $date2)
    {
        $httpClient = new Client();
        $response = $httpClient->get(
            env('SHOPIFY_API_KEY').'orders.json',
            [
                RequestOptions::QUERY => [
                    'limit' => 250,
                    'created_at_min' => $date1,
                    'created_at_max' => $date2,
                ],
            ]
        );
        $orders=json_decode($response->getBody()->getContents());
        return $orders;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getOrderById($id)
    {
        $httpClient = new Client();
        $response = $httpClient->get(
            env('SHOPIFY_API_KEY').'orders/'.$id.'.json'
        );
        $orders=json_decode($response->getBody()->getContents());
        return $orders->order;
    }

    /**
     * @return mixed
     */
    public function close()
    {
        $httpClient = new Client();
        $response = $httpClient->post(
            env('SHOPIFY_API_KEY').'orders/2675799425178/close.json'
        );
        $orders=json_decode($response->getBody()->getContents());
        return $orders->order;
    }


    /**
     * То что нужно делаем ордер закрытым и архивным
     * @param $id
     * @return mixed
     */
    public function fulfillments($id)
    {
        $httpClient = new Client();
        $response = $httpClient->post(
            env('SHOPIFY_API_KEY').'orders/'.$id.'/fulfillments.json',
            [
                RequestOptions::QUERY => [
                    'fulfillment' => array('location_id' => env('LocationId'), 'tracking_number' => 'success' ),
                ],
            ]
        );
        $orders=json_decode($response->getBody()->getContents());
        return $orders;
    }

    /**
     * @param $array1
     * @param $array2
     */
    public function saveOrderToBase($array1, $array2)
    {
        try {
            Order::updateOrCreate($array1, $array2);
        } catch (\Exception $e)
        {
        }
    }

}
