<?php

namespace App\Services;

class RajaOngkirService
{
    private $endpoint = '';
    private $apiKey = '';


    public function __construct() {
        $this->endpoint = env('RAJA_ONGKIR_ENDPOINT','');
        $this->apiKey = env('RAJA_ONGKIR_API_KEY', '');
    }

    public function callApi($url, $method = 'GET', $option = []) {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'key: ' . $this->apiKey,
            'Content-Type: application/json'
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $result = curl_exec($curl);

        return $result;
    }

    public function getProvinces() {
        $url = "https://api.rajaongkir.com/" . $this->endpoint . "/province";

        $result = $this->callApi($url);
        $result = json_decode($result);

        if($result->rajaongkir->status->code == 200){
            return $result->rajaongkir->results;
        }

        return $result;
    }

    public function getCities() {
        $url = "https://api.rajaongkir.com/" . $this->endpoint. "/city";

        $result = $this->callApi($url);
        $result = json_decode($result);

        if($result->rajaongkir->status->code == 200){
            return $result->rajaongkir->results;
        }

        return $result;
    }

    public function checkOngkir($data) {
        $jne = json_decode($this->getRate($data, 'jne'));
        $pos = json_decode($this->getRate($data, 'pos'));
        $tiki = json_decode($this->getRate($data, 'tiki'));

        if($jne->rajaongkir->status->code == 400) {
            return 404;
        };

        $response = [
            'jne' => $jne->rajaongkir->results[0],
            'pos' => $pos->rajaongkir->results[0],
            'tiki' => $tiki->rajaongkir->results[0]
        ];


        return $response;
    }

    public function getRate($data, $courier) {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.rajaongkir.com/' . $this->endpoint . '/cost',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array('origin' => $data['origin_city'],'destination' => $data['destination_city'],'weight' => $data['weight'] * 1000,'courier' => $courier),
        CURLOPT_HTTPHEADER => array(
            'key: ' . $this->apiKey,
        ),
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_SSL_VERIFYPEER => false,
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return $response;
    }
}
