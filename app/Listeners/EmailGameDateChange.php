<?php

namespace App\Listeners;

use App\Events\GameDateChange;
use App\Events\GameVisitChange;
use Mail;

class EmailGameDateChange
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
     * @param  GameVisitChange  $event
     * @return void
     */
    public function handle(GameDateChange $event)
    {
        $users = \App\Models\User::whereNotNull('email')->where('email', '!=', '')->get();

        $subject = str_limit($event->team, 20) . ' ' . $event->date;

        Mail::send(
            'emails.game_date',
            ['gameId' => $event->gameId, 'team' => $event->team, 'date' => $event->date],
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
