<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Mail\SendMessage as Mailable;


class SendMessage extends Notification
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
    protected $file;
    protected $filename;
    protected $extension;
    protected $mime;
    protected $filepaths;

    public function __construct($name, $subject, $message,$filepaths)
    {
        //
        $this->name = $name;
        $this->subject = $subject;
        $this->message = $message;
        $this->filepaths = $filepaths;
        
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
    public function toMail($notifiable){
        return (new Mailable($notifiable, $this->name, $this->subject, $this->message, $this->filepaths));
                                  
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
