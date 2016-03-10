<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TrainingVisitAdded extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $trainingId;
    public $playerId;
    public $visit;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->trainingId = $data['training_id'];
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
        return ['trainingVisit.' . $this->trainingId];
    }
}
