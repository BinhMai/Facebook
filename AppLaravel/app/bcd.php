<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DB;
use Validator;
use Hash;
use Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'users';

    protected $fillable = [
        'id','name','password','address','phonenumber','avatar','remember_token','created_at','updated_at'
    ];

    protected $primaryKey = 'id';

    public function validation($value){        
        $rules = [
         'name'=>'required|empty_with:email', 
         'email'=>'required|email',       
         'pass'=>'required|min:6',
         'repass'=>'required|same:pass'
        ];
        $validator = Validator::make($value, $rules);
        if ($validator->fails()) {
        return response()->json([
                'error' => true,
                'message' => $validator->errors()
            ], 200);
        }else{
            $name = $value['name'];
            $pass = $value['pass'];

            $user = new User();
            $user->name = $name; 
            $user->email = $value['email'];       
            $user->password = Hash::make($pass);            
            $user->save();

            $user = User::find($user->id);
            $user_follow = User::find($user->id);;
            $user->followUsers()->save($user_follow);

            Auth::attempt(['name' => $name, 'password' => $pass]);
            return response()->json(['error' => false,'message' => 'thanh cong'], 200);
        }
    }

    public function validationUpdate($value){
        $rules = [
         'name'=>'unique:users,name,'.Auth::id()                
        // 'name'=>'empty_with:email,name,'.Auth::id()                
        ];
        $messages = [         
         // 'name.empty_with'=>"Tài khoản này đã tồn tại",                                   
        ];

        $validator = Validator::make($value, $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['error' => true,'message' => $validator->errors()], 200);
        }
    }

    public function getStatus(){
        return $this->hasMany('App\Status','id_user','id')->orderBy('id_status','desc');
    }

    public function search($name,$username){
        return User::where([['name','LIKE','%'.$name.'%'],['name',"<>",$username]])->get();
    }

    public function followStatus(){        
        return $this->hasManyThrough('App\Status','App\Follow','user','id_user','id')->orderBy('id_status','desc'); 
    }

    public function followUsers() {
        return $this->belongsToMany('App\User', 'follows', 'user', 'follow');    
    }    

    public function likeStatus() {
        return $this->belongsToMany('App\Status', 'likes', 'id_user', 'id_status');    
    }    

    public function follow(){
        return $this->hasMany('App\Follow','user');
    }

    public function like(){
        return $this->hasMany('App\like','id_user');
    }
    public function getNotice(){
        return $this->hasMany('App\Notice','id_user')->orderBy('created_at','desc');
    }    
}
