<?php
/**
 * Created by PhpStorm.
 * User: Menedyl
 * Date: 02/10/2017
 * Time: 15:16
 */

namespace AppBundle\Scenario;


use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityTest extends WebTestCase
{

    /** @var Client $client */
    private $client = null;


    public function setUp()
    {
        $this->client = static::createClient();
        $this->client->followRedirects();
    }

    public function testLogin()
    {
        $crawler = $this->client->request('GET', '/login');

        $form = $crawler->selectButton('Se connecter')->form();
        $form['_username'] = 'Nicolas';
        $form['_password'] = 'test';

        $crawler = $this->client->submit($form);

        $this->assertSame(1, $crawler->filter('h1:contains("Bienvenue sur Todo List,")')->count());
    }

    public function testLogout()
    {
        $crawler = $this->client->request(
            'GET',
            '/',
            [],
            [],
            [
                'PHP_AUTH_USER' => 'Nicolas',
                'PHP_AUTH_PW' => 'test'
            ]);

        $link = $crawler->selectLink('Se déconnecter')->link();

        $crawler = $this->client->click($link);

        $this->assertSame(1, $crawler->filter('img.slide-image')->count());
    }
}
