<?php

namespace App\Notifications;

use App\Models\Order;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class TransporterCanistersFromTransporterConfirmedByDepotNotification extends Notification
{
    use Queueable;

    public Order $order;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'orderId' => $this->order->id,
            'title' => "Order #{$this->order->id} update",
            'message' => "Empty canisters confirmed by depot",
            'type' => 'info',
            'time' => $this->order->transporter_depot_ok_at
        ];
    }


    /**
     * Get the broadcastable representation of the notification.
     *
     * @param mixed $notifiable
     * @return BroadcastMessage
     */
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'orderId' => $this->order->id,
            'title' => "Order #{$this->order->id} update",
            'message' => "Empty canisters confirmed by depot",
            'type' => 'info',
            'time' => $this->order->transporter_depot_ok_at
        ]);
    }

    public function broadcastType()
    {
        return 'info';
    }


}
