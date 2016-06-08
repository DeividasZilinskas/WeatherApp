<?php

namespace Nfq\WeatherBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class DefaultControllerTest
 * @package Nfq\WeatherBundle\Tests\Controller
 */
class DefaultControllerTest extends WebTestCase
{
    /**
     *
     */
    public function testIndex()
    {
        $client = static::createClient();

        $this->assertContains('Hello World', $client->getResponse()->getContent());
    }
}
