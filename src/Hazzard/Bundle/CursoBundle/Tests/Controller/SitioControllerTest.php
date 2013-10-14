<?php

namespace Hazzard\Bundle\CursoBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SitioControllerTest extends WebTestCase
{
    public function testEstatica()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/estatica');
    }

}
