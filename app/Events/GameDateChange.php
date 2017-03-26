<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class GameDateChange extends Event
{
    use SerializesModels;

    public $gameId;
    public $team;
    public $date;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->gameId = $data['game_id'];
        $this->team = $data['team'];
        $this->date = $data['date'];
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
