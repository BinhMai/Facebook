<?php

namespace App\Observers;
use Auth;
use App\Notice;
use App\Jobs\MailQueue;
use Log;
use Carbon\Carbon;
class ObserveComment
{    

    public function saved($model)
    {
        $status = $model->status;            
        $user = Auth::user();    
        
        $notice = new Notice();
        $notice->id_ac = Auth::id();
        $notice->id_user = $status->id_user;
        $notice->id_status = $status->id_status;
        $notice->type = 1;        

        $notice->save();      
        $job = (new MailQueue($notice->id_nc))->onQueue('low');              
        return dispatch($job);        
    }

    public function deleting($model)
    {
        echo "deleted";
    }
}