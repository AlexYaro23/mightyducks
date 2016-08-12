<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class GameVisitChange extends Event
{
    use SerializesModels;

    public $gameId;
    public $playerId;
    public $visit;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->gameId = $data['game_id'];
        $this->playerId = $data['player_id'];
        $this->visit = $data['visit'];
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
