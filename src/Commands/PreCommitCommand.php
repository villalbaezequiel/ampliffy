<?php

namespace App\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class PreCommitCommand extends Command
{
    protected function configure()
    {
        $this->setName('git:pre-commit');
        $this->setDescription('Observe and Save the changes pre-commit.');

        $this
            ->addArgument('repository', InputArgument::REQUIRED, '')
            ->addArgument('branch', InputArgument::REQUIRED, '')
            ->addArgument('hash-commit', InputArgument::REQUIRED, '')
            ->addArgument('description-commit', InputArgument::REQUIRED, '')
            ->addArgument('author-commit', InputArgument::REQUIRED, '')
            ->addArgument('date-commit', InputArgument::REQUIRED, '');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $output->writeLn("Observing and Saving changes pre-commit...");
            return Command::SUCCESS;
        } catch (\Exception $err) {
        }
    }
}
