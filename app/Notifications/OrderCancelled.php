<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCancelled extends Notification implements ShouldQueue
{
    use Queueable;

    protected $name;
    protected $orderId;
    protected $date;
    protected $cartItem;
    protected $itemPrice;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($name, $orderId, $cartItem, $itemPrice)
    {
        $this->name = $name;
        $this->orderId = $orderId;
        $this->date = Carbon::now()->toDayDateTimeString();
        $this->cartItem = $cartItem;
        $this->itemPrice = $itemPrice;
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
        $url = env('FRONTEND_REDIRECT_PAGE').'/dashboard/order/view-order/'.$this->cartItem->transaction->id;
        return (new MailMessage)
        ->greeting('Hello '.$this->name.'!')
        ->line('We received your request to cancel an item from this order #' .$this->orderId. ' on '.$this->date.'. We\'re sorry this order didn\'t work out for you')
        ->line('We hope to see you again soon.')
        ->action('ORDER STATUS', $url)
        ->line('Item(s) :')
        ->line(''.$this->cartItem->item->name.'')
        ->line('₱'. $this->itemPrice)
        ->line('Quantity x '.$this->cartItem->qty);
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
