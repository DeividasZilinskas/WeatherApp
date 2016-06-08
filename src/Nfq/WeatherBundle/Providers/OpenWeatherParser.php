<?php
/**
 * Created by PhpStorm.
 * User: deividas
 * Date: 4/6/16
 * Time: 10:54 PM
 */

namespace Nfq\WeatherBundle\Providers;

use Nfq\WeatherBundle\Document\Weather;

/**
 * Class OpenWeatherParser
 * @package Nfq\WeatherBundle\API
 */
class OpenWeatherParser
{

    /**
     * @param string $data
     * @return Weather
     * @throws \Exception
     */
    public function parseData(string $data): Weather
    {
        $weatherInfo = json_decode($data, true);
        if ($weatherInfo['name'] == null) {
            throw new \Exception();
        }
        $weather = new Weather(
            $weatherInfo['name'],
            $weatherInfo['sys']['country'],
            $weatherInfo['main']['temp'],
            $weatherInfo['wind']['speed']
        );

        return $weather;
    }
}
