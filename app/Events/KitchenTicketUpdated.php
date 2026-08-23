<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class KitchenTicketUpdated implements ShouldBroadcastNow
{
    use Dispatchable, SerializesModels;

    public int $orderId;
    public string $status;

    public function __construct(
        int $orderId,
        string $status
    ) {
        $this->orderId = $orderId;
        $this->status = $status;
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('helabojun.queue'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'kitchen.ticket.updated';
    }

    public function broadcastWith(): array
    {
        return [
            'order_id' => $this->orderId,
            'status' => $this->status,
        ];
    }
}