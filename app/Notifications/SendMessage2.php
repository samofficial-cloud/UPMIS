<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SendMessage2 extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */

    protected $subject;
    protected $message;
    protected $name;
    protected $salutation;

    public function __construct($name, $subject, $message, $salutation)
    {
        //
        $this->name = $name;
        $this->subject = $subject;
        $this->message = $message;
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
                    ->subject(($this->subject))
                    ->line(($this->message))
                    ->salutation('Regards, <br>'.($this->salutation));
                    // ->attachData(($this->path), ($this->filename));
                    
                        # code...
                    
                    
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
