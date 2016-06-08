<?php

namespace Nfq\WeatherBundle\Controller;

use Nfq\WeatherBundle\Document\Location;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class DefaultController
 * @package Nfq\WeatherBundle\Controller
 */
class DefaultController extends Controller
{
    /**
     * @Route("/{city}", defaults={"city" = "Vilnius"})
     * @param string $city
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction($city)
    {
        $weatherLoader = $this->get('nfq_weather.provider');
        $location = new Location();
        $location->setCity($city);
        $weather = $weatherLoader->getWeather($location);

        return $this->render('WeatherBundle:Default:index.html.twig', ['weather' => $weather]);
    }
}
