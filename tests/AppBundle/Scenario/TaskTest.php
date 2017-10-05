<?php
/**
 * Created by PhpStorm.
 * User: Menedyl
 * Date: 02/10/2017
 * Time: 15:33
 */

namespace AppBundle\Scenario;


use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskTest extends WebTestCase
{

    /** @var Client $client */
    private $client = null;


    public function setUp()
    {
        $this->client = static::createClient();
        $this->client->followRedirects();
    }

    public function testTaskCreate()
    {
        $crawler = $this->client->request(
            'GET',
            '/tasks/create',
            [],
            [],
            [
                'PHP_AUTH_USER' => 'Nicolas',
                'PHP_AUTH_PW' => 'test'
            ]);

        $form = $crawler->selectButton('Ajouter')->form();

        $form['task[title]'] = 'Se lever';
        $form['task[content]'] = 'Commencer la journée en se réveillant tôt !';

        $crawler = $this->client->submit($form);

        $this->assertSame(1, $crawler->filter('div.alert-success:contains("La tâche a bien été ajoutée")')->count());

        $this->assertSame(1, $crawler->filter('h4>a:contains("Se lever")')->count());
    }

    public function testTaskEdit()
    {
        $crawler = $this->client->request(
            'GET',
            '/tasks/1/edit',
            [],
            [],
            [
                'PHP_AUTH_USER' => 'Nicolas',
                'PHP_AUTH_PW' => 'test'
            ]);

        $form = $crawler->selectButton('Modifier')->form();

        $form['task[title]'] = 'Se coucher';
        $form['task[content]'] = 'Finir la journée en se couchant tôt !';

        $crawler = $this->client->submit($form);

        $this->assertSame(1, $crawler->filter('div.alert-success:contains("La tâche a bien été modifiée")')->count());

        $this->assertSame(1, $crawler->filter('h4>a:contains("Se coucher")')->count());
    }

    public function testTaskToggleOn()
    {
        $crawler = $this->client->request(
            'GET',
            '/tasks',
            [],
            [],
            [
                'PHP_AUTH_USER' => 'Nicolas',
                'PHP_AUTH_PW' => 'test'
            ]);

        $form = $crawler->selectButton('Marquer comme faite')->form();

        $crawler = $this->client->submit($form);

        $this->assertSame(1, $crawler->filter('div.alert-success:contains("été marquée comme faite")')->count());
    }

    public function testTaskToggleOff()
    {
        $crawler = $this->client->request(
            'GET',
            '/tasks',
            [],
            [],
            [
                'PHP_AUTH_USER' => 'Nicolas',
                'PHP_AUTH_PW' => 'test'
            ]);

        $form = $crawler->selectButton('Marquer non terminée')->form();

        $crawler = $this->client->submit($form);

        $this->assertSame(1, $crawler->filter('div.alert-success:contains("été marquée comme non terminée")')->count());
    }

    public function testTaskDelete()
    {
        $crawler = $this->client->request(
            'GET',
            '/tasks',
            [],
            [],
            [
                'PHP_AUTH_USER' => 'Nicolas',
                'PHP_AUTH_PW' => 'test'
            ]);


        $form = $crawler->selectButton('Supprimer')->form();

        $crawler = $this->client->submit($form);

        $this->assertSame(1, $crawler->filter('div.alert-success:contains("La tâche a bien été supprimée")')->count());
    }

}
