<?php

namespace App\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use App\Helpers\Helpers;
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
        ->addArgument('path', InputArgument::REQUIRED, '')
        ->addArgument('parent', InputArgument::REQUIRED, '')
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
            $checkRepository= Repository::where('name', $input->getArgument('repository'))
                                        ->where('remote_url', $input->getArgument('repository-origin'))
                                        ->first();
            // validate parent Repo
            $getParent      = [];
            if(!empty($input->getArgument('parent'))) {
                $idParent   = Repository::where('path', $input->getArgument('parent'))->first();
                array_push($getParent, $idParent->id); 
            } else {
                $issetPath = explode("/".$input->getArgument('repository'), $input->getArgument('path'));
                $idParent   = Repository::where('path', $issetPath[0])->first();
                array_push($getParent, $idParent->id);
            }

            $listParentsRepo = $getParent;

            if (!$checkRepository) {
                $isHome = strpos($input->getArgument('repository-origin'), self::HOME_NAME_REPO);

                // new Repository
                $repository = new Repository;
                $repository->name = $input->getArgument('repository');
                $repository->remote_url = $input->getArgument('repository-origin');
                $repository->path = $input->getArgument('path');
                $repository->parent = json_encode($getParent);
                $repository->is_home = ($isHome > 0);
                $repository->save();
            } else {
                $thisParents= json_decode($checkRepository->parent);
                if(isset($idParent) && !in_array($idParent->id, $thisParents)) array_push($thisParents, $idParent->id);

                $checkRepository->parent = json_encode($thisParents);
                $checkRepository->save();

                $listParentsRepo = $thisParents;
            }

            // validate isset Branch with relation Repo 
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
            $commit->description = $input->getArgument('description-commit');
            $commit->author = $input->getArgument('author-commit');
            $commit->email = $input->getArgument('email-commit');
            $commit->save();

            $output->writeLn("Tree of Repositories affected. Sub-Project with Parent-Project");

            Helpers::print_x($this->outputTreeRepo($listParentsRepo));

            return Command::SUCCESS;

        } catch (\Exception $err) {
            var_dump($err);
            return Command::FAILURE;
        }
    }

    public function outputTreeRepo($childrens)
    {
        try {
            // set level
            $treeRepos = [];
            foreach ($childrens as $children)
            {
                $dataRepo = $this->getRepository($children);

                if(!empty(json_decode($dataRepo->parent)))
                {
                    foreach (json_decode($dataRepo->parent) as $key => $parent)
                    {
                        $treeRepos[$dataRepo->name][$parent] = $this->getRepository($parent)->name;
                    }
                } else {
                    $treeRepos[$dataRepo->id] = $dataRepo->name;
                }
            }

            return $treeRepos;

        } catch (\Exception $err) {
            var_dump($err);
        }
    }

    public function getRepository($id)
    {
        try {
            return Repository::find($id);
        } catch (\Exception $err) {
            var_dump($err);
        }
    }
}
