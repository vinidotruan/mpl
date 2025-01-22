<?php

namespace App\Services;

use Exception;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class GithubService {
    public function commit(string $message)
    {
        $repoPath = env('GIT_REPO_PATH');
        $branch = env('GIT_BRANCH');

        try {
            $fetchProcess = new Process(['git', 'fetch']);
            $fetchProcess->setWorkingDirectory($repoPath);
            $fetchProcess->run();

            if (!$fetchProcess->isSuccessful()) {
                throw new ProcessFailedException($fetchProcess);
            }

            $checkBranchProcess = new Process(['git', 'branch', '-r', '--list', "origin/{$branch}"]);
            $checkBranchProcess->setWorkingDirectory($repoPath);
            $checkBranchProcess->run();

            $branchExists = trim($checkBranchProcess->getOutput()) !== '';

            if ($branchExists) {
                $checkoutProcess = new Process(['git', 'checkout', $branch]);
            } else {
                $checkoutProcess = new Process(['git', 'checkout', '-b', $branch, 'origin/main']);
            }

            $checkoutProcess->setWorkingDirectory($repoPath);
            $checkoutProcess->run();

            if (!$checkoutProcess->isSuccessful()) {
                throw new ProcessFailedException($checkoutProcess);
            }

            $addProccess = new Process(['git', 'add', '.']);
            $addProccess->setWorkingDirectory($repoPath);
            $addProccess->run();

            if (!$addProccess->isSuccessful()) {
                throw new ProcessFailedException($addProccess);
            }

            $commitProcess = new Process(['git', 'commit', '-m', $message]);
            $commitProcess->setWorkingDirectory($repoPath);
            $commitProcess->run();

            if (!$commitProcess->isSuccessful()) {
                throw new ProcessFailedException($commitProcess);
            }

            $pushProcess = new Process(['git', 'push', 'origin', $branch]);
            $pushProcess->setWorkingDirectory($repoPath);
            $pushProcess->run();

            if (!$pushProcess->isSuccessful()) {
                throw new ProcessFailedException($pushProcess);
            }

            return 1;
        } catch (ProcessFailedException $e) {
            return $e->getMessage();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
