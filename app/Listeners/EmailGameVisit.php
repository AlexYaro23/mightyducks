<?php

namespace App\Listeners;

use App\Events\GameVisitChange;
use App\Models\Game;
use App\Models\Player;
use App\Models\Stat;
use App\Models\TrainingVisit;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Log;
use Mail;

//class EmailGameVisit implements ShouldQueue
class EmailGameVisit
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
    public function handle(GameVisitChange $event)
    {
        $player = Player::find($event->playerId);
        $game = Game::find($event->gameId);
        $users = \App\Models\User::whereNotNull('email')->where('email', '!=', '')->get();
        $visitList = Stat::$visitList;
        if (isset($event->visit) && $event->visit) {
            $status = $visitList[$event->visit];
        } else {
            $status = 'Cancelled';
        }

        $subject = str_limit($player->name, 50) . ' ' . str_limit($game->team, 20) . ' ' . $status;

        Mail::send(
            'emails.game_visit',
            ['player' => $player, 'game' => $game, 'status' => $status],
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
