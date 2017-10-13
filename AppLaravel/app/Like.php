<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $table = 'likes';
    protected $fillable = ['id_status','id_user'];
    public $timestamps = false;
    protected $primaryKey = 'id_status';

    public function UserLike(){
     	return $this->belongsTo('App\User','id_user');
    }

    public function statusLike(){
    	return $this->belongsTo('App\Status','id_status');	
    }   

    protected static function boot()
    {
        Like::observe(new Observers\ObserveLike);
    }
}
