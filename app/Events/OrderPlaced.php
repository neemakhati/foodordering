<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use App\Models\Order;

class OrderPlaced implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;

    /**
     * Create a new event instance.
     *
     * @param  Order  $order
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
        \Log::info('OrderPlaced event constructed', ['order' => $order]);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return PrivateChannel
     */
    public function broadcastOn()
    {
        dd("test");
        \Log::info('OrderPlaced event broadcasting on channel my-channel.'.$this->order->id);
        return new PrivateChannel('my-channel.'.$this->order->id);
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return [
            'order_id' => $this->order->id,
            'customer_name' => $this->order->customer->name, // Assuming you have a relationship to get customer details
            // Add other relevant order data here
        ];
    }

    /**
     * Get the event name for the broadcast.
     *
     * @return string
     */
    public function broadcastAs()
    {
        \Log::info('OrderPlaced event broadcast as my-event');
        return 'my-event';
    }
}
