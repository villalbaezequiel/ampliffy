<?php

namespace App\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use App\Models\Commit;

class PostCommitCommand extends Command
{
    protected function configure()
    {
        $this->setName('git:post-commit');
        $this->setDescription('Observe and Save the changes post-commit.');
        
        $this
        ->addArgument('hash-commit', InputArgument::REQUIRED, '')
        ->addArgument('date-commit', InputArgument::REQUIRED, '');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $output->writeLn("Observing and Saving changes post-commit...");

            // update last Commit
            $commit = Commit::orderBy('id', 'DESC')->first();
            $commit->hash = $input->getArgument('hash-commit');
            $commit->date = $input->getArgument('date-commit');
            $commit->save();
            
            return Command::SUCCESS;
        } catch (\Exception $err) {
            var_dump($err);
            return Command::FAILURE;
        }
    }
}
