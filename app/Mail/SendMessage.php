<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
class SendMessage extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $user;
    public $subject;
    public $message;
    public $name;
    public $filepaths;

    public function __construct( $user, $name, $subject, $message, $filepaths)
    {
        //
        $this->user=$user;
        $this->name = $name;
        $this->subject = $subject;
        $this->message = $message;
        $this->filepaths = $filepaths;
        $this->message= (new MailMessage)
            ->greeting('Dear '.($this->name).',')
            ->subject(($this->subject))
            ->line(($this->message));
        

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
         $email=$this->markdown('vendor.notifications.email', $this->message->data())->to($this->user->email);


            foreach($this->filepaths as $filePath){
                $email->attach($filePath);
            }
            return $email;
    }
}
