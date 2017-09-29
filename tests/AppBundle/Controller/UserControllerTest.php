<?php
/**
 * Created by PhpStorm.
 * User: Menedyl
 * Date: 29/09/2017
 * Time: 02:38
 */

namespace Tests\AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class UserControllerTest extends WebTestCase
{
    /** @var Client */
    private $client = null;

    public function setUp()
    {
        $this->client = static::createClient();
        $this->client->followRedirects();
    }

    public function testUsersCreatePageIsUp()
    {
        $this->client->request('GET', '/users/create');

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }


    public function testUsersPageIsUp()
    {
        $this->client->request('GET', '/users');

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    public function testFormUsersCreateIsUp()
    {
        $crawler = $this->client->request('GET', '/users/create');

        $form = $crawler->selectButton('Ajouter')->form();

        $form['user[username]'] = 'Nicolas';
        $form['user[password][first]'] = 'test';
        $form['user[password][second]'] = 'test';
        $form['user[email]'] = 'nicolas@gmail.com';

        $crawler = $this->client->submit($form);


        $this->assertSame(1, $crawler->filter('div.alert-success')->count());
    }

    public function testUsersEditPageIsUp()
    {
        $this->client->request('GET', '/users/1/edit');

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    public function testFormUsersEditIsUp()
    {
        $crawler = $this->client->request('GET', '/users/1/edit');

        $form = $crawler->selectButton('Modifier')->form();

        $form['user[username]'] = 'Mickael';
        $form['user[password][first]'] = 'pass';
        $form['user[password][second]'] = 'pass';
        $form['user[email]'] = 'nicolas@gmail.com';

        $crawler = $this->client->submit($form);

        $this->assertSame(1, $crawler->filter('div.alert-success')->count());
    }

    public function testLinkCreateUsersIsUp()
    {
        $crawler = $this->client->request('GET', '/login');

        $link = $crawler->selectLink('Créer un utilisateur')->link();
        $crawler = $this->client->click($link);

        $this->assertSame(1, $crawler->filter('h1:contains("Créer un utilisateur")')->count());
    }

    public function testLinkEditUsersIsUp()
    {
        $crawler = $this->client->request('GET', '/users');

        $link = $crawler->selectLink('Edit')->link();
        $crawler = $this->client->click($link);

        $this->assertSame(1, $crawler->filter('h1:contains("Modifier")')->count());


    }

}