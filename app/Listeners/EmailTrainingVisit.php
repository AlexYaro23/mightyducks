<?php

namespace App\Listeners;

use App\Events\TrainingVisitChange;
use App\Models\Player;
use App\Models\Training;
use App\Models\TrainingVisit;
use App\Models\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;
use Log;

//class EmailTrainingVisit implements ShouldQueue
class EmailTrainingVisit
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  TrainingVisitChange $event
     * @return void
     */
    public function handle(TrainingVisitChange $event)
    {
        $player = Player::find($event->playerId);
        $training = Training::find($event->trainingId);
        $users = \App\Models\User::whereNotNull('email')->where('email', '!=', '')->get();
        $status = $event->visit;
        $visitList = TrainingVisit::getVisitList();

        $subject = trans('email.training.subject') . ' ' . str_limit($player->name, 10) . ' ' . str_limit($training->name, 10) . ' ' . $visitList[$status];

        Mail::send(
            'emails.training_visit',
            ['player' => $player, 'training' => $training, 'status' => $status],
            function ($m) use ($users, $subject) {
                foreach ($users as $user) {
                    if ($user->isAdmin()) {
                        $m->to($user->email);
                    }
                }

                $m->subject($subject);
            }
        );
    }
}
