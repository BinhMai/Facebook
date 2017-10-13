<?php

namespace App\Observers;
use Auth;
use App\Status;
use App\Notice;
use App\User;
use App\Like;
use Log;
use App\Jobs\MailQueue;
use App\Mail\NotificationMail;
use Illuminate\Support\Facades\Mail;

class ObserveLike
{    

    public function saved(Like $like)
    {                          
        $user = Auth::user();             
        $status = $like->statusLike;          

        // $checkNotice = Notice::where([['id_ac',$user->id],['id_user',$status->id_user],['id_status',$status->id_status],['type',0]])->get();
        // if($checkNotice == "[]"){
            $nt = new Notice();
            $nt->id_ac = Auth::id();
            $nt->id_user = $status->id_user;
            $nt->id_status = $status->id_status;
            $nt->type = 0;                                    

            $nt->save();  
            $job = (new MailQueue($nt->id_nc))->onQueue('high');              
            return dispatch($job);        
        // }                        
    }

    public function deleting($model)
    {
        echo "deleted";
    }
}