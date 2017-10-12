<?php

namespace AppBundle\Entity;

use PHPUnit\Framework\TestCase;

/**
 * Created by PhpStorm.
 * User: Menedyl
 * Date: 10/10/2017
 * Time: 19:05
 */
class TaskTest extends TestCase
{

    public function testTaskCreate_withUser()
    {
        $user = new User();
        $task = new Task($user);

        $this->assertFalse($task->isDone());
        $this->assertTrue($task->asAuthor());
        $this->assertEquals($user, $task->getAuthor());
    }

    public function testTaskCreate_withoutUser()
    {
        $task = new Task();

        $this->assertFalse($task->isDone());
        $this->assertFalse($task->asAuthor());
        $this->assertNull($task->getAuthor());
    }

}