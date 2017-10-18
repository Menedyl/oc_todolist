<?php

namespace AppBundle\Scenario;

use AppBundle\Entity\User;
use AppBundleTests\RandomString;
use Doctrine\ORM\EntityManagerInterface;
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
    use RandomString;


    /** @var Client $client */
    private $client = null;

    /** @var EntityManagerInterface */
    private $manager;


    public function setUp()
    {
        $this->client = static::createClient();
        $this->client->followRedirects();
        $this->manager = $this->client->getContainer()->get('doctrine.orm.entity_manager');
    }


    public function testCreateUser()
    {
        $crawler = $this->client->request('GET', '/users/create');

        $string = $this->randomString(7);

        $form = $crawler->selectButton('Ajouter')->form();
        $form['user[username]'] = 'Thomas';
        $form['user[password][first]'] = 'test';
        $form['user[password][second]'] = 'test';
        $form['user[email]'] = 'thomas@gmail.com';
        $form['user[roles]'] = 'ROLE_USER';

        $crawler = $this->client->submit($form);

        $this->assertSame(1, $crawler->filter('div.alert-success:contains("L\'utilisateur a bien été ajouté")')->count());
    }

    public function testUserEdit()
    {
        /** @var User $user */
        $user = $this->manager->getRepository(User::class)->findOneBy(['username' => 'Thomas']);

        $crawler = $this->client->request(
            'GET/',
            '/users/' . $user->getId() . '/edit',
            [],
            [],
            [
                'PHP_AUTH_USER' => 'Nicolas',
                'PHP_AUTH_PW' => 'test'
            ]);

        $form = $crawler->selectButton('Modifier')->form();

        $string = $this->randomString(6);

        $form['user[username]'] = $string;
        $form['user[email]'] = $string . '@gmail.com';
        $form['user[roles]'] = 'ROLE_ADMIN';

        $crawler = $this->client->submit($form);

        $this->assertSame(1, $crawler->filter('div.alert-success:contains("L\'utilisateur a bien été modifié")')->count());
    }

}
