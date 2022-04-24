<?php

namespace App\Mail;


use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BAMail extends Mailable
{
    use Queueable, SerializesModels;

    

    /**
     * The title instance.
     *
     * @var data
     */
    protected $title;
    /**
     * The content instance.
     *
     * @var data
     */
    protected $content;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($title,$content)
    {
        //$this->data = $data;
        $this->title = $title;
         $this->content = $content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return 

        $this->subject($this->title)
            ->view('email.email')->with([
                        'title' => $this->title,
                        'content' => $this->content,
                    ]);
    }
}
