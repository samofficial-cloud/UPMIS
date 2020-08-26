<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

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

    public function __construct($name, $subject, $message, $file,$extension,$filename,$mime,$path)
    {
        //
        $this->name = $name;
        $this->subject = $subject;
        $this->message = $message;
        $this->file = $file;
        $this->filename = $filename;
        $this->extension=$extension;
        $this->mime=$mime;
        $this->path=$path;
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
$path=public_path().'/'.'uploads'.'/'.($this->filename);
        return (new MailMessage)
                    ->greeting('Dear '.($this->name).',')
                    ->subject(($this->subject))
                    ->line(($this->message))
                    // ->attachData(($this->path), ($this->filename));
                    ->attach($path , [
                        'as' =>($this->filename),
                        'mime' =>($this->mime),
                    ]);
                    
                    
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
