<?php

namespace App\Jobs;

use App\Notice;
use App\Mail\NotificationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class MailQueue implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
        
    protected $id;
    public $timeout = 10;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */

    public function handle()
    {                     
        sleep(5);                                 
        Mail::to('hoangbinhnt1996@gmail.com')
            ->send(new NotificationMail(Notice::find($this->id)));     
    }
}
