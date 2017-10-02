<?php

namespace AppBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Created by PhpStorm.
 * User: Menedyl
 * Date: 02/10/2017
 * Time: 15:51
 */
class testCommand extends Command
{

    protected function configure()
    {
        $this
            ->setName('test:db:init')
            ->setDescription('Drop, Create and Update the test database');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $drop = $this->getApplication()->find('doctrine:database:drop');
        $dropArgs = [
            'command' => 'doctrine:database:drop',
            '--force' => true,
            '--env' => 'dev'
        ];

        $dropInput = new ArrayInput($dropArgs);

        $create = $this->getApplication()->find('doctrine:database:create');
        $createArgs = [
            'command' => 'doctrine:database:create',
            '--env' => 'dev'
        ];

        $createInput = new ArrayInput($createArgs);

        $update = $this->getApplication()->find('doctrine:schema:update');
        $updateArgs = [
            'command' => 'doctrine:schema:update',
            '--force' => true,
            '--env' => 'dev'
        ];

        $updateInput = new ArrayInput($updateArgs);

        $drop->run($dropInput, $output);
        $create->run($createInput, $output);
        $update->run($updateInput, $output);


    }


}