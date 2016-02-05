<?php

namespace App\Console\Commands;

use App\Models\Training;
use App\Repositories\TrainingVisitRepository;
use Carbon\Carbon;
use Illuminate\Console\Command;

class TrainingsReset extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trainings_reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reseting training visits';


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
        $this->info('Script start');

        $daytime = Carbon::now();

        $trainingList = Training::where('day_of_week', $daytime->dayOfWeek)
            ->where('time', '<', $daytime->format('H:i:s'))->get();


        if ($trainingList->count() < 1) {
            $this->error('No games to remind');
            exit;
        }

        foreach ($trainingList as $training) {
            TrainingVisitRepository::setNotVisited($training->id);
        }

        $this->info('Script end');
    }
}
