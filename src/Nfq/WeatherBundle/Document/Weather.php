<?php
/**
 * Created by PhpStorm.
 * User: deividas
 * Date: 4/6/16
 * Time: 8:34 PM
 */

namespace Nfq\WeatherBundle\Document;

/**
 * Class Weather
 * @package Nfq\WeatherBundle\Document
 */
class Weather
{
    private $cityName;
    private $country;
    private $temp;
    private $wind;

    /**
     * Weather constructor.
     * @param string $cityName
     * @param string $country
     * @param float  $temp
     * @param float  $wind
     */
    public function __construct(string $cityName, string $country, float $temp, float$wind)
    {
        $this->cityName = $cityName;
        $this->country = $country;
        $this->temp = $temp;
        $this->wind = $wind;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @return float
     */
    public function getWind(): float
    {
        return $this->wind;
    }

    /**
     * @return string
     */
    public function getCityName(): string
    {
        return $this->cityName;
    }

    /**
     * @return float
     */
    public function getTemp(): float
    {
        return $this->temp;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $objectArray = array();
        $objectArray['miestas'] = $this->getCityName();
        $objectArray['salis'] = $this->getCountry();
        $objectArray['temperatura'] = $this->getTemp();
        $objectArray['vejas'] = $this->getWind();

        return $objectArray;
        //return $this->getCityName().' '.$this->getCountry().' '.$this->getTemp().' '.$this->getWind();
    }
}
