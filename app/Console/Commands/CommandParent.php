<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;

class CommandParent extends Command
{
    public function startLog()
    {
        $msg = 'Script start';
        $this->timedInfo($msg);
    }

    public function endLog()
    {
        $msg = 'Script end';
        $this->timedInfo($msg);
    }

    public function timedInfo($msg)
    {
        $this->info(PHP_EOL . Carbon::now()->format('d-m-Y H:i:s') . ' ' . substr(strrchr(get_class($this), "\\"), 1) . ' ' . $msg);
    }
}