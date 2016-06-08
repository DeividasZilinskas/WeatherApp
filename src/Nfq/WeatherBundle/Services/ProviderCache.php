<?php
/**
 * Created by PhpStorm.
 * User: deividas
 * Date: 4/16/16
 * Time: 11:09 PM
 */

namespace Nfq\WeatherBundle\Services;

use Nfq\WeatherBundle\Document\Location;
use Nfq\WeatherBundle\Document\Weather;

/**
 * Class CachedWeatherProvider
 * @package Nfq\WeatherBundle\Services
 */
class ProviderCache
{
    const CACHE_LOCATION = '/tmp/ProviderCache.json';

    private $provider;
    private $location;
    private $ttl;

    /**
     * ProviderCache constructor.
     * @param string   $provider
     * @param Location $location
     * @param int      $ttl
     */
    public function __construct(string $provider, Location $location, int $ttl)
    {
        $this->provider = $provider;
        $this->location = $location;
        $this->ttl = $ttl;
    }

    /**
     * @return string
     */
    public function getProvider()
    {
        return $this->provider;
    }
    /**
     * @return Location
     */
    public function getLocation()
    {
        return $this->location;
    }
    /**
     * @return int
     */
    public function getTtl()
    {
        return $this->ttl;
    }

    /**
     * @param Weather $weather
     */
    public function cacheWeatherData(Weather $weather)
    {
        try {
            $cacheDate = new \DateTime('now');
            $cacheJson = array();
            $cacheJson['issaugota'] = $cacheDate->getTimestamp();
            $cacheJson['provider'] = $this->getProvider();
            $cacheJson['galiojimas'] = $this->ttl;
            $cacheJson['route'] = $this->getLocation()->getCity();
            $array = array_unique(array_merge($cacheJson, $weather->toArray()));
            $cacheContent = json_encode($array).PHP_EOL;

            $fileContent = '';
            if (file_exists(self::CACHE_LOCATION)) {
                $fileContent = file_get_contents(self::CACHE_LOCATION);
            }
            $cacheContent .= $fileContent;
            file_put_contents(self::CACHE_LOCATION, $cacheContent);
        } catch (\Exception $e) {
            dump($e->getMessage());
            exit;
        }
    }

    /**
     * @return Weather
     */
    public function getCachedWeatherData()
    {
        if (!file_exists(self::CACHE_LOCATION)) {
            return null;
        }
        $this->cacheCleanUp();
        $timeStamp = new \DateTime('now');
        $content = file_get_contents(self::CACHE_LOCATION);
        $rows = explode(PHP_EOL, $content);
        foreach ($rows as $data) {
            // parse row data
            $rowData = json_decode($data, true);
            if ($rowData['provider'] == null) {
                continue;
            }

            if (strcasecmp($rowData['route'], $this->getLocation()->getCity()) == 0 &&
                strcasecmp($this->getProvider(), $rowData['provider']) == 0 &&
                (intval($rowData['issaugota']) + $this->getTtl()) >= $timeStamp->getTimestamp()) {
                return new Weather($rowData['miestas'], $rowData['salis'], $rowData['temperatura'], $rowData['vejas']);
            }
        }

        return null;
    }

    private function cacheCleanUp()
    {
        if (!file_exists(self::CACHE_LOCATION)) {
            return null;
        }
        $timeStamp = new \DateTime('now');
        $content = file_get_contents(self::CACHE_LOCATION);
        $rows = explode(PHP_EOL, $content);
        $newCache = '';
        foreach ($rows as $data) {
            $rowData = json_decode($data, true);
            if ((intval($rowData['issaugota']) + $this->getTtl()) >= $timeStamp->getTimestamp()) {
                $newCache .= $data.PHP_EOL;
            }
        }
        file_put_contents(self::CACHE_LOCATION, $newCache);
    }
}
