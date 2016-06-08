<?php
/**
 * Created by PhpStorm.
 * User: deividas
 * Date: 4/6/16
 * Time: 8:27 PM
 */

namespace Nfq\WeatherBundle\Interfaces;

use Nfq\WeatherBundle\Document\Location;
use Nfq\WeatherBundle\Document\Weather;

/**
 * Interface WeatherProvider
 * @package Nfq\WeatherBundle\Interfaces
 */
interface WeatherProviderInterface
{

    /**
     * @param Location $location
     * @return Weather
     */
    public function fetchWeather(Location $location): Weather;
}
