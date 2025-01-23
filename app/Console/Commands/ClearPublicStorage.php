<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ClearPublicStorage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'storage:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear all files in storage/app/public';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $disk = Storage::disk('public');
        $folders = $disk->allDirectories();

        foreach ($folders as $folder) {
            $disk->deleteDirectory($folder);
            $this->info("Deleting");
        }

        $this->info("All folders deleted");
        return 0;
    }
}
