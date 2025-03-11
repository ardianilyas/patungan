<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DonationSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $receiver;
    public $sender;
    public $amount;
    /**
     * Create a new event instance.
     */
    public function __construct($message, $receiver, $sender, $amount)
    {
        $this->message = $message;
        $this->receiver = $receiver;
        $this->sender = $sender;
        $this->amount = $amount;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel("donation.{$this->receiver->token}"),
        ];
    }

    public function broadcastWith(): array {
        $formattedAmount = 'Rp. ' . number_format($this->amount, '0', ',', '.');
        return [
            'title' => "<strong>{$this->sender->name}</strong> has been donated <strong>{$formattedAmount}</strong>",
            'message' => $this->message,
        ];
    }
}
