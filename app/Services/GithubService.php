<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;
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

            // 2. Checkout para a branch de destino
            $checkoutProcess = new Process(['git', 'checkout', $branch]);
            $checkoutProcess->setWorkingDirectory($repoPath);
            $checkoutProcess->run();

            if (!$checkoutProcess->isSuccessful()) {

                throw new ProcessFailedException($checkoutProcess);
                $checkoutProcess = new Process(['git', 'checkout', '-b', $branch, "origin/{$branch}"]);
                $checkoutProcess->setWorkingDirectory($repoPath);
                $checkoutProcess->run();

                if (!$checkoutProcess->isSuccessful()) {
                    throw new ProcessFailedException($checkoutProcess);
                }
            }


            $pullProcess = new Process(['git', 'pull', '--rebase', '-X', 'theirs', 'origin', $branch]);
            $pullProcess->setWorkingDirectory($repoPath);
            $pullProcess->run();

            if (!$pullProcess->isSuccessful()) {
                throw new ProcessFailedException($pullProcess);
            }

            $configName = new Process(['git', 'config', 'user.name', '"Vinícius Truan"']);
            $configName->setWorkingDirectory($repoPath);
            $configName->run();

            if (!$configName->isSuccessful()) {
                throw new ProcessFailedException($configName);
            }

            // 2. Configurar o email do usuário
            $configEmail = new Process(['git', 'config', 'user.email', '"contatoruanvinicius@gmail.com"']);
            $configEmail->setWorkingDirectory($repoPath);
            $configEmail->run();

            if (!$configEmail->isSuccessful()) {
                throw new ProcessFailedException($configEmail);
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

            Log::info("Caiou aqui");
            return 1;
        } catch (ProcessFailedException $e) {
            Log::info("Caiou aBqui");
            return $e->getMessage();
        } catch (Exception $e) {
                        Log::info("Caiou aBCqui");

            return $e->getMessage();
        }
    }
}
