<?php

namespace AppBundle\Scenario;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


/**
 * Created by PhpStorm.
 * User: Menedyl
 * Date: 02/10/2017
 * Time: 11:49
 */
class UserTest extends WebTestCase
{
    /** @var Client $client */
    private $client = null;


    public function setUp()
    {
        $this->client = static::createClient();
        $this->client->followRedirects();
    }

    public function testCreateUser()
    {
        $crawler = $this->client->request('GET', '/users/create');

        $form = $crawler->selectButton('Ajouter')->form();

        $form['user[username]'] = 'Mickael';
        $form['user[password][first]'] = 'test';
        $form['user[password][second]'] = 'test';
        $form['user[email]'] = 'nicolas@gmail.com';

        $crawler = $this->client->submit($form);

        $this->assertSame(1, $crawler->filter('div.alert-success:contains("L\'utilisateur a bien été ajouté")')->count());
    }

}
