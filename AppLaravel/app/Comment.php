<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Log;
use DB;
use Validator;

class Comment extends Model
{
    protected $table = 'comments';
    protected $fillable = ['id_status','id_user','content','created_at','updated_at'];    
    // protected $primaryKey = 'id_status'; 

    public function user(){
    	return $this->belongsTo('App\User','id_user');
    }
    public function status(){
    	return $this->belongsTo('App\Status','id_status');	
    }
    
    // public function validationComment($value){
    //     $rules = [
    //      'comment'=>'required'         
    //     ];
    //     $validator = Validator::make($value, $rules);
        
    //     if ($validator->fails()) {
    //         return response()->json(['error' => true,'message' => $validator->errors()], 200);
    //     }
    // }

    protected static function boot()
    {
        Comment::observe(new Observers\ObserveComment);
        // static::saved(function ($model) {
        //     $status = $model->status;    
	       //  Log::info("ObserveComment is ".print_r($model,true));
	       //  $user = Auth::user();    
	        
	       //  $notice = new Notice();
	       //  $notice->id_ac = $user->id;
	       //  $notice->id_user = $status->id_user;
	       //  $notice->id_status = $status->id_status;
	       //  $notice->type = 1;        

	       //  Mail::to('hoangbinhnt1996@gmail.com')->send(new NotificationMail($notice));       
	       //  $notice->save(); 
        // });
    }
}
