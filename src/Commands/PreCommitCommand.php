<?php

namespace App\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use App\Models\Repository;
use App\Models\Branch;
use App\Models\Commit;

class PreCommitCommand extends Command
{
    protected function configure()
    {
        $this->setName('git:pre-commit');
        $this->setDescription('Observe and Save the changes pre-commit.');

        $this
            ->addArgument('repository', InputArgument::REQUIRED, '')
            ->addArgument('repository-origin', InputArgument::REQUIRED, '')
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

            // validate isset Repo
            $checkRepository = Repository::where('name', $input->getArgument('repository'))
                                        ->where('remote_url', $input->getArgument('repository-origin'))
                                        ->first();

            if (!$checkRepository) {
                // new Repository
                $repository = new Repository;
                $repository->name = $input->getArgument('repository');
                $repository->remote_url = $input->getArgument('repository-origin');
                $repository->save();
            }

            // validate isset Repo with relation Branch
            $checkBranch = Branch::where('name', $input->getArgument('branch'))
                                ->where('id_repository', '!=', $repository->id)
                                ->first();

            if (!$checkBranch) {
                // new Branch
                $branch = new Branch;
                $branch->name = $input->getArgument('branch');
                $branch->id_repository = $repository->id;
                $branch->save();
            }

            // new Commit
            $commit = new Commit;
            $commit->id_branch = $branch->id;
            $commit->hash = $input->getArgument('hash-commit');
            $commit->description = $input->getArgument('description-commit');
            $commit->author = $input->getArgument('author-commit');
            $commit->date = $input->getArgument('date-commit');
            $commit->save();

            return Command::SUCCESS;
        } catch (\Exception $err) {
            var_dump($err);
        }
    }
}
