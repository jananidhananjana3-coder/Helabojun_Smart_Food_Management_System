<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FoodInventoryUpdated implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public int $foodId;
    public int $counterId;
    public int $quantity;

    public function __construct(
        int $foodId,
        int $counterId,
        int $quantity
    ) {
        $this->foodId = $foodId;
        $this->counterId = $counterId;
        $this->quantity = $quantity;
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('helabojun.inventory'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'food.inventory.updated';
    }
}