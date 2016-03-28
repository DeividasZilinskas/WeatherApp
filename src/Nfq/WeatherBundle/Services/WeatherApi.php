<?php
namespace Nfq\WeatherBundle\Services;

use GuzzleHttp\Client;

class WeatherApi {

    private $api_key;

    public function __construct($weather_api_key)
    {
        $this->api_key = $weather_api_key;
    }

    public function getWeather($city)
    {
        $client = new Client([
            'base_uri' => 'http://api.openweathermap.org/data/2.5/',
            'timeout'  => 2.0,
        ]);
        $string = $client->request('GET','weather?q='.$city.'&appid='.$this->api_key.'add&units=metric')->getBody();

        return json_decode($string,true);
    }

}
?>