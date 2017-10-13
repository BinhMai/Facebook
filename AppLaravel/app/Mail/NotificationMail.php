<?php

namespace App\Mail;

use App\Notice;
use App\User;
use Log;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotificationMail extends Mailable
{
    use Queueable, SerializesModels;

     protected $notice;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Notice $notice)
    {
        $this->notice = $notice;                 
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('formmail')
                    ->with([                                           
                        'id_status' => $this->notice->id_status,                        
                        'name' => User::find($this->notice->id_ac)->name, 
                        'type' => $this->notice->type,                    
                    ]);
    }
}
