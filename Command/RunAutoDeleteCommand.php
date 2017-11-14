<?php

namespace NTI\AutoDeleteBundle\Command;

use NTI\AutoDeleteBundle\Entity\AutoDeleteEntry;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class RunAutoDeleteCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('nti:auto-delete:run')
            ->setDescription('This command will run all the enabled AutoDeleteEntry.')
            ->setHelp('This command will run all the enabled AutoDeleteEntry. ')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $entries = $em->getRepository('NTIAutoDeleteBundle:AutoDeleteEntry')->findBy(array("enabled" => true));
        $autoDeleteService = $this->getContainer()->get('nti.auto_delete');
        foreach($entries as $entry) {
            $deleted = $autoDeleteService->clean($entry);
            $output->writeln("Auto deleted the path {$entry->getPath()}. {$deleted} file(s) were deleted.");
        }
        $output->writeln("Finished executing all the entries.");
    }
}