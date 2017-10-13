<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    protected $table = 'follows';
    
    protected $fillable = ['user','follow'];

    protected $primaryKey = 'follow';

    public function follow(){
        return $this->belongTo('App\User','user','id');
    }
}
