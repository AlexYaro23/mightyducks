<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\Inspire::class,
        Commands\ParseTeam::class,
        Commands\ParseSchedule::class,
        Commands\ParseResult::class,
        Commands\Reminder::class,
        Commands\TrainingsReminder::class,
        Commands\TrainingsReset::class,
        Commands\ParseHistorySchedule::class,
        Commands\FixTeamNames::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $filePath = storage_path('logs/cron.log');
        $schedule->command('parseschedule')->twiceDaily(13, 22)->appendOutputTo($filePath);;
        $schedule->command('parseresult')->daily()->appendOutputTo($filePath);;
        $schedule->command('reminder')->twiceDaily(15, 23)->appendOutputTo($filePath);;
        $schedule->command('trainings')->dailyAt('13:00')->appendOutputTo($filePath);;
        $schedule->command('trainings_reset')->dailyAt('23:30')->appendOutputTo($filePath);;
    }
}
