<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class RequestAccepted extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */

    protected $start;
    protected $end;
    protected $dest;
    protected $vehicle;
    protected $name;
    protected $salutation;
    
    public function __construct($start, $end, $dest, $vehicle, $name, $salutation)
    {
        //

        $this->start = $start;
        $this->end = $end;
        $this->dest = $dest;
        $this->vehicle = $vehicle;
        $this->name = $name;
        $this->salutation = $salutation;

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
                    ->greeting('Dear '.($this->name).',')
                    ->subject('VEHICLE_REQUISTION_TO_'.strtoupper($this->dest))
                    ->line('Your vehicle reservation for '.date("d/m/Y",strtotime($this->start)).' - '.date("d/m/Y",strtotime($this->end)). ' to '.($this->dest).' has been accepted.')
                    ->salutation('Regards, <br>'.($this->salutation));
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
