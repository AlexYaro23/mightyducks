<?php

namespace App\Console\Commands;

use App\Models\Game;
use App\Models\Training;
use Carbon\Carbon;
use Illuminate\Console\Command;

class TrainingsReminder extends CommandParent
{
    const PERIOD = 1;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trainings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reminds about training into VK team chart';


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
        $this->startLog();

        $dayOfWeek = Carbon::now()->addDays(self::PERIOD)->dayOfWeek;

        $trainingList = Training::where('day_of_week', $dayOfWeek)->get();

        if ($trainingList->count() < 1) {
            $this->error('No games to remind');
            exit;
        }

        foreach ($trainingList as $training) {

            $msg = config('mls.chat_training_msg');
            $msg = str_replace('%training%', $training->name,  $msg);
            $msg = str_replace('%time%', $training->getTime(), $msg);
            $msg = str_replace('%url%', route('training.visit', ['id' => $training->id]), $msg);

            $result = sendVkMsg($msg);

            $this->comment($result);
        }

        $this->endLog();
    }
}
