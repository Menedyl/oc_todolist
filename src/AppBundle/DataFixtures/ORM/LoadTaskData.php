<?php
/**
 * Created by PhpStorm.
 * User: Menedyl
 * Date: 10/10/2017
 * Time: 17:23
 */

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Task;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class LoadTaskData extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $task1 = new Task();
        $task1->setTitle("Test d'une tâche !");
        $task1->setContent("Ajout d'une tâche grace aux data-fixtures.");

        $task2 = new Task();
        $task2->setTitle("Test d'une autre tâche");
        $task2->setContent("Ajout d'une seconde tâche !");

        $manager->persist($task1);
        $manager->persist($task2);
        $manager->flush();
    }

}
