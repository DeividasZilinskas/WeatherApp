<?php

namespace Nfq\WeatherBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", defaults={"city" = "Vilnius"})
     * @Route("/{city}")
     * @param string $city
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction($city)
    {
        $WeatherInfo = $this->get('app.weather')->getWeather($city);

        return $this->render('WeatherBundle:Default:index.html.twig', [
            'temp' => $WeatherInfo['main']['temp'],
            'temp_min' => $WeatherInfo['main']['temp_min'],
            'temp_max' => $WeatherInfo['main']['temp_max'],
            'humidity' => $WeatherInfo['main']['humidity'],
            'wind' => $WeatherInfo['wind']['speed'],
            'city' => $WeatherInfo['name'],
            'country' => $WeatherInfo['sys']['country']
        ]);
    }
}
