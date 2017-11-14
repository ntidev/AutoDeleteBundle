<?php

namespace NTI\AutoDeleteBundle\Command;

use NTI\AutoDeleteBundle\Entity\AutoDeleteEntry;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class NewAutoDeleteEntryCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('nti:auto-delete:new-entry')
            ->setDescription('This command will create a new AutoDeleteEntry.')
            ->setHelp('This command will create a new AutoDeleteEntry. ')
            ->addArgument('path', InputArgument::REQUIRED, 'The path to be deleted')
            ->addArgument('seconds', InputArgument::REQUIRED, 'The amount of seconds until the path is deleted.')
            ->addOption(
                'disabled',
                null,
                InputOption::VALUE_OPTIONAL,
                'If the entry should be disabled when created.',
                false
            )
            ->addOption(
                'no-recursive',
                null,
                InputOption::VALUE_OPTIONAL,
                'If set and the path is a directory the process won\'t proceed recursively through subdirectories.',
                false
            )
            ->addOption(
                'keep-empty-dir',
                null,
                InputOption::VALUE_OPTIONAL,
                'If set, empty directories won\'t be removed.',
                false
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $seconds = ($input->getArgument('seconds') > 0) ? $input->getArgument('seconds') : 3600;
        $path = $input->getArgument('path');
        $recursive = $input->getOption('no-recursive');
        $keepEmptyDir = $input->getOption('keep-empty-dir');
        $disabled = $input->getOption('disabled');

        if(!file_exists($path)) {
            $output->writeln("<warning>Warning: The path specified doesn't exists.</warning>");
        }

        if(!is_writable($path)) {
            $output->writeln("<warning>Warning: The path specified is not writable by PHP.</warning>");
        }

        $entry = new AutoDeleteEntry();
        $entry->setEnabled(!$disabled);
        $entry->setRecursive(!$recursive);
        $entry->setKeepEmptyDir($keepEmptyDir);
        $entry->setPath($path);
        $entry->setSeconds($seconds);

        try {
            $em = $this->getContainer()->get('doctrine')->getManager();
            $em->persist($entry);
            $em->flush();
            $output->writeln("<success>Success: The entry was successfully created and will be executed on the next command call</success>");
        } catch (\Exception $ex) {
            if($this->getContainer()->has('nti.logger')) {
                $this->getContainer()->get('nti.logger')->logException($ex);
            }

            $output->writeln("<error>Error: ".$ex->getMessage()."</error>");
        }

    }
}