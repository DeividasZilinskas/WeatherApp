<?php
/**
 * Created by PhpStorm.
 * User: deividas
 * Date: 4/6/16
 * Time: 8:44 PM
 */

namespace Nfq\WeatherBundle\Document;

/**
 * Class Location
 * @package Nfq\WeatherBundle\Document
 */
class Location
{
    private $city;
    private $long;
    private $lat;

    /**
     * @return String
     */
    public function getCity() : String
    {
        return $this->city;
    }

    /**
     * @param String $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getLong(): float
    {
        return $this->long;
    }

    /**
     * @param mixed $long
     */
    public function setLong($long)
    {
        $this->long = $long;
    }

    /**
     * @return mixed
     */
    public function getLat():float
    {
        return $this->lat;
    }

    /**
     * @param mixed $lat
     */
    public function setLat($lat)
    {
        $this->lat = $lat;
    }
}
