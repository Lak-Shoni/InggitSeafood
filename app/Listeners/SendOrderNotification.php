<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Models\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendOrderNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderCreated $event)
    {
        Notification::create([
            'order_code' => $event->order->order_code,
        ]);
    }
}
