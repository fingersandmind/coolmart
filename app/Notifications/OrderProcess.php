<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderProcess extends Notification implements ShouldQueue
{
    use Queueable;
    protected $name;
    protected $orderId;
    protected $date;
    protected $method;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($name, $orderId, $method)
    {
        $this->date = Carbon::now()->toDayDateTimeString();
        $this->name = $name;
        $this->orderId = $orderId;
        $this->method = $method;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->greeting('Hello '.$this->name.'!')
                    ->line('We received your order #' .$this->orderId. ' on '.$this->date.' and you\'ll be paying for this via '.strtoupper($this->method).'.')
                    ->line('We’re getting your order ready and will let you know once it’s on the way. We wish you enjoy shopping with us and hope to see you again real soon!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
