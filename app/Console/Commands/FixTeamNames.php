<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use File;

class FixTeamNames extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fixicons';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fixing existing teams names using str2url func';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $path = public_path('img/team_logos');
        $files = File::allFiles($path);

        $this->info('Files found: ' . count($files));

        foreach ($files as $file) {
            $currentFilePath = $file->getRealPath();
            $ext = '.' . $file->getExtension();
            $filename = basename($currentFilePath, $ext);
            $fileslug = str2url($filename);
            $newfilepath = $path . '/' . $fileslug . $ext;
            if ($currentFilePath != $newfilepath) {
                copy($currentFilePath, $newfilepath);
                $this->info('File updated: ' . $fileslug);
            }
        }

        $this->info('Finished');
    }
}
