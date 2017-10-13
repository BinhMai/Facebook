<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    protected $table = 'notices';

    protected $fillable = [
        'id_nc','id_ac','id_user','id_status','type','created','updated'
    ];
    public $timestamps = true;

    protected $primaryKey = 'id_nc';

    public function UserNotice(){
     	return $this->belongsTo('App\User','id_ac');
    }
}
