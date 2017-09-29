<?php

namespace AppBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Created by PhpStorm.
 * User: Menedyl
 * Date: 29/09/2017
 * Time: 05:48
 */
class RunTestsCommand extends Command
{

    protected function configure()
    {
        $this
            ->setName('tests:run')
            ->setDescription('Drop, create and update schema for database and run tests PHPUnit.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dropDb = $this->getApplication()->find('doctrine:database:drop');
        $argsDrop = [
            'command' => 'doctrine:database:drop',
            '--force' => true
        ];
        $dropDbInput = new ArrayInput($argsDrop);

        $createDb = $this->getApplication()->find('doctrine:database:create');
        $argsCreate = [
            'command' => 'doctrine:database:create',
        ];
        $createDbInput = new ArrayInput($argsCreate);

        $schemaDb = $this->getApplication()->find('doctrine:schema:create');
        $argsSchema = [
            'command' => 'doctrine:schema:create'
        ];
        $schemaDbInput = new ArrayInput($argsSchema);


        try {
            $dropDb->run($dropDbInput, $output);
        } catch (\Exception $exception) {
            echo $exception;
        }

        $createDb->run($createDbInput, $output);

        $schemaDb->run($schemaDbInput, $output);

        system('php vendor/phpunit/phpunit/phpunit');
        //system('php vendor/phpunit/phpunit/phpunit --coverage-html web/test-coverage');

    }

}