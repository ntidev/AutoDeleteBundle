<?php

namespace NTI\AutoDeleteBundle\Tests\Command;

use Doctrine\ORM\EntityManagerInterface;
use NTI\AutoDeleteBundle\Command\NewAutoDeleteEntryCommand;
use NTI\AutoDeleteBundle\Command\RemoveAutoDeleteEntryCommand;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Bundle\FrameworkBundle\Console\Application;

class RemoveAutoDeleteEntryCommandTest extends KernelTestCase
{
    public function testExecute()
    {
        $kernel = static::createKernel();
        $kernel->boot();

        $application = new Application($kernel);

        $container = $kernel->getContainer();

        /** @var EntityManagerInterface $em */
        $em = $container->get('doctrine')->getManager();
        $entry = $em->getRepository('NTIAutoDeleteBundle:AutoDeleteEntry')->findOneBy(array("path" => __DIR__ . "/testdir/"));

        if($entry) {
            $application->add(new RemoveAutoDeleteEntryCommand());

            $command = $application->find('nti:auto-delete:remove');
            $commandTester = new CommandTester($command);
            $commandTester->execute(array(
                'command' => $command->getName(),
                'id' => $entry->getId(),
            ));
            $output = $commandTester->getDisplay();
            $this->assertContains('Success', $output);
        }
    }
}