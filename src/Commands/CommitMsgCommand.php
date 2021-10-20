<?php

namespace App\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use App\Models\Repository;
use App\Models\Branch;
use App\Models\Commit;

class CommitMsgCommand extends Command
{
    const HOME_NAME_REPO = "villalbaezequiel";

    protected function configure()
    {
        $this->setName('git:commit-msg');
        $this->setDescription('Observe and Save the changes commit-msg.');

        $this
        ->addArgument('repository', InputArgument::REQUIRED, '')
        ->addArgument('repository-origin', InputArgument::REQUIRED, '')
        ->addArgument('branch', InputArgument::REQUIRED, '')
        ->addArgument('description-commit', InputArgument::REQUIRED, '')
        ->addArgument('author-commit', InputArgument::REQUIRED, '')
        ->addArgument('email-commit', InputArgument::REQUIRED, '');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $output->writeLn("Observing and Saving changes commit-msg...");

            // validate isset Repo
            $checkRepository = Repository::where('name', $input->getArgument('repository'))
                                        ->where('remote_url', $input->getArgument('repository-origin'))
                                        ->first();

            if (!$checkRepository) {

                $isHome = strpos($input->getArgument('repository-origin'), self::HOME_NAME_REPO);

                // new Repository
                $repository = new Repository;
                $repository->name = $input->getArgument('repository');
                $repository->remote_url = $input->getArgument('repository-origin');
                $repository->is_home = ($isHome > 0);
                $repository->save();
            }

            // validate isset Repo with relation Branch
            $idRepository = ($checkRepository ? $checkRepository->id : $repository->id);
            $checkBranch = Branch::where('name', $input->getArgument('branch'))
                                ->where('id_repository', $idRepository)
                                ->first();

            if (!$checkBranch) {
                // new Branch
                $branch = new Branch;
                $branch->name = $input->getArgument('branch');
                $branch->id_repository = $idRepository;
                $branch->save();
            }

            $idBranch = ($checkBranch ? $checkBranch->id : $branch->id);

            // new Commit
            $commit = new Commit;
            $commit->id_branch = $idBranch;
            // $commit->hash = $input->getArgument('hash-commit');
            $commit->description = $input->getArgument('description-commit');
            $commit->author = $input->getArgument('author-commit');
            $commit->email = $input->getArgument('email-commit');
            // $commit->date = $input->getArgument('date-commit');
            $commit->save();
            
            return Command::SUCCESS;
        } catch (\Exception $err) {
            var_dump($err);
            return Command::FAILURE;
        }
    }
}
