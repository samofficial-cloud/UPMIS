<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\HtmlString;

class ContractEnd extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */

    protected $name;
    protected $start;
    protected $end;
    protected $contract_id;
    protected $salutation;

    public function __construct($name, $start, $end, $contract_id, $salutation)
    {
        //
         $this->name = $name;
         $this->start = $start;
         $this->end = $end;
         $this->contract_id = $contract_id;
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
                    ->subject('CONTRACT_ABOUT_TO_EXPIRE')
                    ->line(new HtmlString('This is to remind you that your contract with contract id <b>' .($this->contract_id). ',</b> signed with DPDI UDSM on '.date("d/m/Y",strtotime($this->start)).' is approaching its end on '.date("d/m/Y",strtotime($this->end)).'.'))
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
