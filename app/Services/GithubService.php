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
