<?php

namespace AppBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @codeCoverageIgnore
 */
class TestCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('database:initialization')
            ->setDescription('Execute "database:drop, database:create, update:schema, fixtures:load" in the database');
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


        $fixtures = $this->getApplication()->find('doctrine:fixtures:load');
        $fixturesArgs = [
            'command' => 'doctrine:fixtures:load'
        ];

        $fixturesInput = new ArrayInput($fixturesArgs);


        $drop->run($dropInput, $output);
        $create->run($createInput, $output);
        $update->run($updateInput, $output);
        $fixtures->run($fixturesInput, $output);

    }
}
