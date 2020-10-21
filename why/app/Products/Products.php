<?php


namespace App\Products;


use App\Consist;
use App\Product;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class Products
{
    /**
     * @return mixed
     */
    public function getAllProductsFirst()
    {
        $httpClient = new Client();
        $response = $httpClient->get(
            env('SHOPIFY_API_KEY').'products.json',
            [
                RequestOptions::QUERY => [
                    'limit' => 200,
                    'direction' => 'next',
//                    'last_id' => 9598616206,
                    'order' => 'id',
//                    'status'=> 'active'
                    //    'created_at_min' => '2020-08-31T14:42:26+08:00',
                ], //берем 200 склееваем с другим 200 и отдаем
            ]
        );
        $orders=json_decode($response->getBody()->getContents());
        return $orders->products;
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function getimagesProduct($id)
    {
        $httpClient = new Client();
        $response = $httpClient->get(
            env('SHOPIFY_API_KEY').'products/'.$id.'/images.json',
            [
                RequestOptions::QUERY => [
                ],
            ]
        );
        $images=json_decode($response->getBody()->getContents());
        return $images;
    }

    /**
     * Тут делиться все по страницам и поэтому нам надо брать последний id
     * только в первой и второй сортировки одно условие должно совпадать сортировка иначе будет пропуски товаров
     * @param $id
     * @return mixed
     */
    public function getAllProductsNext($id)
    {
        $httpClient = new Client();
        $response = $httpClient->get(
            env('SHOPIFY_API_KEY').'products.json',
            [
                RequestOptions::QUERY => [
                    'limit' => 250,
                    'direction' => 'next',
                    'last_id' => $id,
                    'order' => 'id',
                ], //берем 200 склееваем с другим 200 и отдаем
            ]
        );
        $orders=json_decode($response->getBody()->getContents());
        return $orders->products;
    }

    /**
     * @return mixed
     */
    public function getCount()
    {
        $httpClient = new Client();
        $response = $httpClient->get(
            env('SHOPIFY_API_KEY').'products/count.json',
            [
                RequestOptions::QUERY => [
                    //'published_status'=> 'published'
                ],
            ]
            );
        $orders=json_decode($response->getBody()->getContents());
        return $orders;
    }

    /**
     * @return array
     */
    public static function getProductsList()
    {
        $sendArray=array();
        foreach (Product::where("iscomplect", ">", 0)->get()->sortBy("name")->toArray() as $product)
        {
            array_push($sendArray, [
                'id'=> $product["id"],
                'name' => $product["name"],
                'consist' => Consist::getProductsConsists($product["id"])
            ]);
        }
        return $sendArray;
    }

    /**
     * @param $id
     * @return array
     */
    public static function getProduct($id)
    {
        $sendArray=array();
        foreach (Product::where('id', $id)->get()->sortBy("name")->toArray() as $product)
        {
            array_push($sendArray, [
                'id'=> $product["id"],
                'name' => $product["name"],
                'consist' => Consist::getProductsConsists($product["id"])
            ]);
        }
        return $sendArray;
    }
}

