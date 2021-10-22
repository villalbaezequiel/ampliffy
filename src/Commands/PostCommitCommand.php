<?php

namespace App\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use App\Helpers\Helpers;
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
            $output->writeLn("Observing asdand Saving changes post-commit...");

            $parseDate = explode(" ", $input->getArgument('date-commit'));

            // update last Commit
            $commit = Commit::orderBy('id', 'DESC')->where('hash', '')->first();

            if ($commit) {
                $commit->hash = $input->getArgument('hash-commit');
                $commit->date = "$parseDate[0] $parseDate[1]";
                $commit->save();
            }
            
            $output->writeLn("This Commit");
            Helpers::print_x([
                'id-commit' => $commit->id,
                'hash-commit' => $commit->hash
            ]);

            return Command::SUCCESS;

        } catch (\Exception $err) {
            var_dump($err);
            return Command::FAILURE;
        }
    }
}
