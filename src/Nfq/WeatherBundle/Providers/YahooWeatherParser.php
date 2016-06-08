<?php
/**
 * Created by PhpStorm.
 * User: deividas
 * Date: 4/13/16
 * Time: 9:32 PM
 */

namespace Nfq\WeatherBundle\Providers;

use Nfq\WeatherBundle\Document\Weather;

/**
 * Class YahooWeatherParser
 * @package Nfq\WeatherBundle\API
 */
class YahooWeatherParser
{

    /**
     * @param string $data
     * @return Weather
     * @throws \Exception
     */
    public function parseData(string $data): Weather
    {
        $weatherInfo = json_decode($data, true);
        if ($weatherInfo['query']['results']['channel']['location']['city'] == null) {
            throw new \Exception();
        }
        $weather = new Weather(
            $weatherInfo['query']['results']['channel']['location']['city'],
            $weatherInfo['query']['results']['channel']['location']['country'],
            $weatherInfo['query']['results']['channel']['item']['condition']['temp'],
            $this->convertWindSpeed($weatherInfo['query']['results']['channel']['wind']['speed'])
        );

        return $weather;
    }

    /**
     * @param float $wind
     * @return float
     */
    private function convertWindSpeed(float $wind): float
    {
        return number_format($wind/3.6, 2, '.', '');
    }
}
