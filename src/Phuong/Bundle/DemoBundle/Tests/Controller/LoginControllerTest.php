<?php

namespace Phuong\Bundle\DemoBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginControllerTest extends WebTestCase
{
    public function testShowlogin()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/showLogin');
    }

}
