<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MessageMail extends Mailable
{
    use Queueable, SerializesModels;

    public $view;

    public $with;

    public function __construct(
        string $view,
        array $with
    ) {
        $this->view = $view;
        $this->with = $with;
    }

    public function build(): Mailable
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
            ->subject(trans($this->view))
            ->markdown($this->view)
            ->with($this->with);
    }
}
