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
        $crawler = $this->client->request('GET', '/login');

        $form = $crawler->selectButton('Se connecter')->form();

        $form['_username'] = 'Nicolas';
        $form['_password'] = 'test';

        $crawler = $this->client->submit($form);

        $link = $crawler->selectLink('Créer une nouvelle tâche')->link();

        $crawler = $this->client->click($link);

        $form = $crawler->selectButton('Ajouter')->form();

        $form['task[title]'] = 'Se lever';
        $form['task[content]'] = 'Commencer la journée en se réveillant tôt !';

        $crawler = $this->client->submit($form);

        $this->assertSame(1, $crawler->filter('div.alert-success:contains("La tâche a bien été ajoutée")')->count());

        $this->assertSame(1, $crawler->filter('h4>a:contains("Se lever")')->count());
    }

    public function testTaskEdit()
    {
        $crawler = $this->client->request('GET', '/login');

        $form = $crawler->selectButton('Se connecter')->form();

        $form['_username'] = 'Nicolas';
        $form['_password'] = 'test';

        $crawler = $this->client->submit($form);

        $link = $crawler->selectLink('Consulter la liste des tâches à faire')->link();

        $crawler = $this->client->click($link);

        $link = $crawler->selectLink('Se lever')->link();

        $crawler = $this->client->click($link);

        $form = $crawler->selectButton('Modifier')->form();

        $form['task[title]'] = 'Se coucher';
        $form['task[content]'] = 'Finir la journée en se couchant tôt !';

        $crawler = $this->client->submit($form);

        $this->assertSame(1, $crawler->filter('div.alert-success:contains("La tâche a bien été modifiée")')->count());

        $this->assertSame(1, $crawler->filter('h4>a:contains("Se coucher")')->count());
    }

    public function testTaskToggleOn()
    {
        $crawler = $this->client->request('GET', '/login');

        $form = $crawler->selectButton('Se connecter')->form();

        $form['_username'] = 'Nicolas';
        $form['_password'] = 'test';

        $crawler = $this->client->submit($form);

        $link = $crawler->selectLink('Consulter la liste des tâches à faire')->link();

        $crawler = $this->client->click($link);

        $form = $crawler->selectButton('Marquer comme faite')->form();

        $crawler = $this->client->submit($form);

        $this->assertSame(1, $crawler->filter('div.alert-success:contains("été marquée comme faite")')->count());
    }

    public function testTaskToggleOff()
    {
        $crawler = $this->client->request('GET', '/login');

        $form = $crawler->selectButton('Se connecter')->form();

        $form['_username'] = 'Nicolas';
        $form['_password'] = 'test';

        $crawler = $this->client->submit($form);

        $link = $crawler->selectLink('Consulter la liste des tâches à faire')->link();

        $crawler = $this->client->click($link);

        $form = $crawler->selectButton('Marquer non terminée')->form();

        $crawler = $this->client->submit($form);

        $this->assertSame(1, $crawler->filter('div.alert-success:contains("été marquée comme non terminée")')->count());
    }

    public function testTaskDelete()
    {
        $crawler = $this->client->request('GET', '/login');

        $form = $crawler->selectButton('Se connecter')->form();

        $form['_username'] = 'Nicolas';
        $form['_password'] = 'test';

        $crawler = $this->client->submit($form);

        $link = $crawler->selectLink('Consulter la liste des tâches à faire')->link();

        $crawler = $this->client->click($link);

        $form = $crawler->selectButton('Supprimer')->form();

        $crawler = $this->client->submit($form);

        $this->assertSame(1, $crawler->filter('div.alert-success:contains("La tâche a bien été supprimée")')->count());
    }

}