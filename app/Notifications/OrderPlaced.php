<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class OrderPlaced extends Notification{
    use Queueable;

    protected $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {
        return ['broadcast', 'database'];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'order_id' => $this->order->id,
            'name' => $this->order->username,
            'created_at' => $this->order->created_at->toDateTimeString(),
        ]);
    }

    public function toArray($notifiable)
    {
        return [
            'order_id' => $this->order->id,
            'name' => $this->order->username,
            'created_at' => $this->order->created_at->toDateTimeString(),
        ];
    }
}
