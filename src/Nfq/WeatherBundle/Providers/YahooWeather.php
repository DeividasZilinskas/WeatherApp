<?php
/**
 * Created by PhpStorm.
 * User: deividas
 * Date: 4/13/16
 * Time: 9:21 PM
 */

namespace Nfq\WeatherBundle\Providers;

use Nfq\WeatherBundle\Interfaces\WeatherProviderInterface;
use Nfq\WeatherBundle\Document\Location;
use Nfq\WeatherBundle\Document\Weather;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class YahooWeather
 * @package Nfq\WeatherBundle\API
 */
class YahooWeather implements WeatherProviderInterface
{
    /**
     * @param Location $location
     * @return Weather
     */
    public function fetchWeather(Location $location): Weather
    {
        $yahooUrl = 'http://query.yahooapis.com/v1/public/yql';
        $yqlQuery = 'SELECT * FROM weather.forecast
        WHERE woeid IN (SELECT woeid FROM geo.places(1)
        WHERE text= "'.$location->getCity().'") and u="c"';
        $yqlQueryUrl = $yahooUrl.'?q='.urlencode($yqlQuery).'&format=json';
        //throw new HttpException(401, "Whoa there cowboy!");
        $session = curl_init($yqlQueryUrl);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
        $json = curl_exec($session);
        if (strlen($json) == 0) {
            throw new HttpException(404, "Yahoo weather api is down!");
        }
        $parser = new YahooWeatherParser();

        return $parser->parseData($json);
    }
}
