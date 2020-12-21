<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\HtmlString;

class InsuranceEnd2 extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */

    protected $full_name;
    protected $commission_date;
    protected $end_date;

    public function __construct($full_name, $commission_date, $end_date, $salutation)
    {
        //
        $this->name = $full_name;
         $this->start = $commission_date;
         $this->end = $end_date;
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
                    ->subject('INSURANCE_ABOUT_TO_EXPIRE')
                    ->line(new HtmlString('This is to remind you that your insurance commissioned on '.date("d/m/Y",strtotime($this->start)).' is about to expire on '.date("d/m/Y",strtotime($this->end)).'.'))
                    ->line('Please visit our office to renew your contract')
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
