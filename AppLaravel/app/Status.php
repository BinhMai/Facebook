<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Follow;
use Validator;

class Status extends Model
{
    protected $table = 'statuses';

    protected $fillable = [
        'id_status','id_user','content','picture','created_at','updated_at'
    ];

    protected $primaryKey = 'id_status';

    public function validationStatus($value){
        $rules = [
         'contentStt'=>'required'         
        ];
        $validator = Validator::make($value, $rules);
        
        if ($validator->fails()) {
            return response()->json(['error' => true,'message' => $validator->errors()], 200);
        }
    }
    public function User(){
        return $this->belongsTo('App\User','id_user','id');
    }

    public function getLike(){
        return $this->hasMany('App\Like','id_status');
    }    

    public function getComment(){
        return $this->hasMany('App\Comment','id_status')
                    ->join('users','users.id','id_user')  
                    ->select('*', 'comments.created_at as created')                  
                    ->orderby('created','ASC');
    }
}

