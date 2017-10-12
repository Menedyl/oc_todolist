<?php
/**
 * Created by PhpStorm.
 * User: Menedyl
 * Date: 02/10/2017
 * Time: 15:33
 */

namespace AppBundle\Scenario;


use AppBundle\Entity\Task;
use AppBundle\RandomString;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskTest extends WebTestCase
{
    use RandomString;

    /** @var Client $client */
    private $client = null;

    /** @var EntityManagerInterface $manager */
    private $manager;


    public function setUp()
    {
        $this->client = static::createClient();
        $this->client->followRedirects();
        $this->manager = $this->client->getContainer()->get('doctrine.orm.entity_manager');
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
        /** @var Task $task */
        $task = $this->manager->getRepository(Task::class)->findOneBy(['title' => 'Se lever']);

        $crawler = $this->client->request(
            'GET',
            '/tasks/' . $task->getId() . '/edit',
            [],
            [],
            [
                'PHP_AUTH_USER' => 'Nicolas',
                'PHP_AUTH_PW' => 'test'
            ]);

        $string = $this->randomString(8);

        $form = $crawler->selectButton('Modifier')->form();

        $form['task[title]'] = $string;
        $form['task[content]'] = 'Finir la journée en se couchant tôt !';
        $crawler = $this->client->submit($form);

        $this->assertSame(1, $crawler->filter('div.alert-success:contains("La tâche a bien été modifiée")')->count());
        $this->assertSame(1, $crawler->filter('h4>a:contains(' . $string . ')')->count());
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
