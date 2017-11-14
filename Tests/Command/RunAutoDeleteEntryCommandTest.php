<?php

namespace NTI\AutoDeleteBundle\Tests\Command;

use Doctrine\ORM\EntityManagerInterface;
use NTI\AutoDeleteBundle\Command\NewAutoDeleteEntryCommand;
use NTI\AutoDeleteBundle\Command\RemoveAutoDeleteEntryCommand;
use NTI\AutoDeleteBundle\Command\RunAutoDeleteCommand;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Bundle\FrameworkBundle\Console\Application;

class RunAutoDeleteEntryCommandTest extends KernelTestCase
{
    public function testExecute()
    {
        $kernel = static::createKernel();
        $kernel->boot();

        $application = new Application($kernel);

        $application->add(new RunAutoDeleteCommand());

        $command = $application->find('nti:auto-delete:run');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command' => $command->getName(),
        ));
        $output = $commandTester->getDisplay();
        $this->assertContains('Finished', $output);
    }
}