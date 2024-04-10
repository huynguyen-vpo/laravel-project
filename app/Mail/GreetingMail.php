<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\Mailer\Envelope;
use Symfony\Component\Mime\Address;

class GreetingMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    protected $message;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $message)
    {
        //
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
                ->from('quanghuyhihi128@gmail.com')
                ->subject('Hello')
                ->markdown('emails.greeting')
                ->with([
                    'message' => $this->message
                ]);
    }
}
