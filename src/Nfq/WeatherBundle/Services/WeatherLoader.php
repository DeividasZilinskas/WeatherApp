<?php
/**
 * Created by PhpStorm.
 * User: deividas
 * Date: 4/6/16
 * Time: 10:45 PM
 */

namespace Nfq\WeatherBundle\Services;

use Nfq\WeatherBundle\Document\Location;
use Nfq\WeatherBundle\Document\Weather;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class WeatherLoader
 * @package Nfq\WeatherBundle\Services
 */
class WeatherLoader
{
    private $weatherProviders;
    private $apiKeys;
    private $ttl;

    /**
     * WeatherLoader constructor.
     * @param array $weatherProviders
     * @param int   $ttl
     * @param array $apiKeys
     */
    public function __construct(array $weatherProviders, int $ttl, array $apiKeys)
    {
        $this->weatherProviders = $weatherProviders;
        $this->apiKeys = $apiKeys;
        $this->ttl = $ttl;
    }

    /**
     * @param Location $location
     * @return Weather
     */
    public function getWeather(Location $location): Weather
    {
        foreach ($this->weatherProviders as $provider) {
            $providerData = explode('\\', $provider);
            $providerObject = null;
            switch ($providerData[3]) {
                case 'OpenWeather':
                    $providerObject = new $provider($this->apiKeys[$providerData[3]]);
                    break;
                case 'YahooWeather':
                    $providerObject = new $provider();
                    break;
            }
            try {
                if ($this->getTtl() > 0) {
                    $cache = new ProviderCache($providerData[3], $location, $this->getTtl());
                    $cachedWeather = $cache->getCachedWeatherData();
                    if ($cachedWeather !== null) {
                        return $cachedWeather;
                    }
                    $weather = $providerObject->fetchWeather($location);
                    $cache->cacheWeatherData($weather);
                } else {
                    $weather = $providerObject->fetchWeather($location);
                }
                if ($weather !== null) {
                    return $weather;
                }
            } catch (\Exception $e) {
                error_log($e->getMessage());
            }
        }

        throw new HttpException(404, "All weather providers are down!");
    }

    /**
     * @return int
     */
    public function getTtl()
    {
        return $this->ttl;
    }
}
