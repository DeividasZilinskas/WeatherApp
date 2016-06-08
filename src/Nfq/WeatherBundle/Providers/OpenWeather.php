<?php
/**
 * Created by PhpStorm.
 * User: deividas
 * Date: 4/6/16
 * Time: 8:37 PM
 */

namespace Nfq\WeatherBundle\Providers;

use GuzzleHttp\Client;
use Nfq\WeatherBundle\Interfaces\WeatherProviderInterface;
use Nfq\WeatherBundle\Document\Location;
use Nfq\WeatherBundle\Document\Weather;

/**
 * Class OpenWeather
 * @package Nfq\WeatherBundle\API
 */
class OpenWeather implements WeatherProviderInterface
{
    private $weatherApiKey;

    /**
     * OpenWeather constructor.
     * @param string $weatherApiKey
     */
    public function __construct(string $weatherApiKey)
    {
        $this->weatherApiKey = $weatherApiKey;
    }

    /**
     * @param Location $location
     * @return Weather
     */
    public function fetchWeather(Location $location): Weather
    {
        $client = new Client([
            'base_uri' => 'http://api.openweathermap.org/data/2.5/',
            'timeout' => 2.0,
        ]);

        $response = $client->request(
            'GET',
            'weather?q='.$location->getCity().'&appid='.$this->weatherApiKey.'&units=metric'
        )->getBody();
        $parser = new OpenWeatherParser();

        return $parser->parseData($response);
    }
}
