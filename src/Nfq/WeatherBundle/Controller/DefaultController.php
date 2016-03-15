<?php

namespace Nfq\WeatherBundle\Controller;

use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/{city}")
     * @param string $city
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction($city = "Vilnius")
    {
        $client = new Client([
            'base_uri' => 'http://api.openweathermap.org/data/2.5/',
            'timeout'  => 2.0,
        ]);

        $api_key = $this->container->getParameter('weather_api_key');

        $string = $client->request("GET","weather?q={$city}&appid={$api_key}add&units=metric")->getBody();

        $JSON_ARRAY = json_decode($string,true);

        return $this->render('WeatherBundle:Default:index.html.twig', [
            "temp" => $JSON_ARRAY["main"]["temp"],
            "temp_min" => $JSON_ARRAY["main"]["temp_min"],
            "temp_max" => $JSON_ARRAY["main"]["temp_max"],
            "humidity" => $JSON_ARRAY["main"]["humidity"],
            "wind" => $JSON_ARRAY["wind"]["speed"],
            "city" => $JSON_ARRAY["name"],
            "country" => $JSON_ARRAY["sys"]["country"]
        ]);
    }
}
