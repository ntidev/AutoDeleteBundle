<?php

namespace NTI\AutoDeleteBundle\Command;

use NTI\AutoDeleteBundle\Entity\AutoDeleteEntry;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class RemoveAutoDeleteEntryCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('nti:auto-delete:remove')
            ->setDescription('This command will delete the provided AutoDeleteEntry.')
            ->setHelp('This command will delete the provided AutoDeleteEntry. ')
            ->addArgument('id', InputArgument::REQUIRED, 'The AutoDeleteEntry to be deleted')

        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $id = $input->getArgument('id');
        $em = $this->getContainer()->get('doctrine')->getManager();
        $entry = $em->getRepository('NTIAutoDeleteBundle:AutoDeleteEntry')->find($id);
        $em->remove($entry);
        try {
            $em->flush();
            $output->writeln("<success>Success: The AutoDeleteEntry was successfully deleted.</success>");
        } catch (\Exception $ex) {
            if($this->getContainer()->has('nti.logger')) {
                $this->getContainer()->get('nti.logger')->logException($ex);
            }
            $output->writeln("<error>Error: ".$ex->getMessage()."</error>");
        }
    }
}