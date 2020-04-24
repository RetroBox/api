<?php

namespace App\Colissimo;

class Client
{

    /**
     * @var \GuzzleHttp\Client
     */
    private \GuzzleHttp\Client $client;

    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client([]);
    }

    /**
     * Get the price of a shipment using Colissimo shipping service
     *
     * @param string $from The ISO code of the departure country
     * @param string $to The ISO code of the destination country
     * @param int $weight The weight of the packet in SI grams
     *
     * @return float
     */
    public function getPrice(string $from, string $to, int $weight): float
    {
        $res = $this->client->post('https://www.laposte.fr/colissimo-en-ligne/getprice', [
            'form_params' => [
                'fromIsoCode' => mb_strtolower($from),
                'toIsoCode' => mb_strtolower($to),
                'weight' => $weight / 1000
            ]
        ]);
        $json = json_decode($res->getBody()->getContents(), true);
        return (float) $json['value'];
    }
}
