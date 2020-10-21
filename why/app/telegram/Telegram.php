<?php


namespace App\telegram;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class Telegram
{
    private $url;

    public function __construct()
    {
        $this->url=env("TELEGRAM_URL");
    }

    /**
     * @param $action
     * @param $array
     * @return string
     */
    public function sendMessage($action, $array)
    {
        $httpClient = new Client();
        $response = $httpClient->post(
            $this->url.$action,
            [
                RequestOptions::QUERY => $array,
            ]
        );
        return $response->getBody()->getContents();
    }

}
