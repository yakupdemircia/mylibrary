<?php

namespace App\Events;

use Illuminate\Support\Facades\Event;

class CalculateCampaignTotalAmount extends Event
{

    public $data;

    public function __construct($data = [])
    {
        $this->data = $data;
    }

    public function broadcastOn()
    {
        return [];
    }
}
