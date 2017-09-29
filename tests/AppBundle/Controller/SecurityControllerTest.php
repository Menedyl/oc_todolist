<?php
/**
 * Created by PhpStorm.
 * User: Menedyl
 * Date: 29/09/2017
 * Time: 02:03
 */

namespace Tests\AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class SecurityControllerTest extends WebTestCase
{
    /** @var Client */
    private $client = null;


    public function setUp()
    {
        $this->client = static::createClient();
        $this->client->followRedirects();
    }


    public function testLoginPageIsUp()
    {
        $this->client->request('GET', '/login');

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());

    }


    public function testLinkLoginIsUp()
    {
        $crawler = $this->client->request('GET', 'users/create');

        $link = $crawler->selectLink('Se connecter')->link();

        $crawler = $this->client->click($link);

        $this->assertSame(1, $crawler->filter('img.slide-image')->count());
    }
}
