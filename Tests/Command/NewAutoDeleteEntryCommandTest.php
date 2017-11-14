<?php

namespace NTI\AutoDeleteBundle\Tests\Command;

use NTI\AutoDeleteBundle\Command\NewAutoDeleteEntryCommand;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Bundle\FrameworkBundle\Console\Application;

class NewAutoDeleteEntryCommandTest extends KernelTestCase
{
    public function testExecute()
    {
        $kernel = static::createKernel();
        $kernel->boot();

        $application = new Application($kernel);

        $application->add(new NewAutoDeleteEntryCommand());

        $command = $application->find('nti:auto-delete:new-entry');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command' => $command->getName(),
            'path' => __DIR__ . "/testdir/",
            'seconds' => 5,
        ));

        $output = $commandTester->getDisplay();
        $this->assertContains('Success', $output);
    }
}