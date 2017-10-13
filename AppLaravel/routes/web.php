<?php

use App\User;
use App\Status;
use App\Follow;
use App\Comment;
use App\Like;
use App\Notifications\CreateNotification;

Route::get('/',function(){		
	if(Auth::check()){		
		return Redirect::to('/home');
	}else{
		return view('welcome');
	}	
	// return App::getLocale();		
});

Route::get('/home',['as'=>'Myhome',function(){
	if(!Auth::check()){
		return Redirect::to('/')->with('error', 'Xin vui lòng đăng nhập!');
	}

	$id = Auth::id();
	$user = Auth::user();			
	$follow = User::find($id)->followUsers()->where('id',"<>",$id)->get();
	$status = Auth::user()->followStatus()->paginate(5);
	$notice = Auth::user()->getNotice;	
	$nt = Auth::user()->getNotice()->where('seen',0)->get();
	return view('home',['user'=>$user,'statuses'=>$status,'follow'=>$follow,'notice'=>$notice,'nt'=>$nt]);			
}]);	

Route::post('/home','UserController@checkUser');

Route::get('/login',function(){
	return view('User\Login');
});
Route::get('/signup',function(){
	return view('User\SignUp');
});
Route::get('/user={id}',function($id){
	$user = Auth::user();
	$id_user = Auth::id();
	$user_profile = User::find($id);
	$status = User::find($id)->getStatus()->paginate(5);
	$follow = User::find($id_user)->followUsers()->where('id',"<>",$id_user)->get();
	$follow_bb = User::find($id)->followUsers()->where('id',"<>",$id)->get();
	$notice = Auth::user()->getNotice;	
	$nt = Auth::user()->getNotice()->where('seen','=',0)->get();
	return view('profile',['user'=>$user,'user_profile'=>$user_profile,'statuses'=>$status,'follow'=>$follow,'notice'=>$notice,'follow_bb'=>$follow_bb,'nt'=>$nt]);
});

Route::get('/status={id}',function($id){
	$user = Auth::user();
	$id_user = Auth::id();	
	$status = Status::where('id_status',$id)->paginate(5);
	$follow = User::find($id_user)->followUsers()->where('id',"<>",$id_user)->get();
	$notice = Auth::user()->getNotice;	
	$nt = Auth::user()->getNotice()->where('seen','=',0)->get();
	return view('home',['user'=>$user,'statuses'=>$status,'follow'=>$follow,'notice'=>$notice,'nt'=>$nt]);			
});
Route::get('/friend/user={id}',function($id){
	$id_user = Auth::id();	
    $acc = Auth::user();    
    $friend = User::find($id);
    $search = User::find($id)->followUsers()->where([['id',"<>",$id],['id',"<>",$id_user]])->get();;    
    $follow = User::find($id_user)->followUsers()->where('id',"<>",$id_user)->get();
    $notice = Auth::user()->getNotice;  
    $nt = Auth::user()->getNotice()->where('seen','=',0)->get();  
    return view('search',['user'=>$acc,'friend'=>$friend,'search'=>$search,'follow'=>$follow,'notice'=>$notice,'nt'=>$nt]);
});

Route::get('/friend','UserController@friends');
Route::post('/update','UserController@update');

Route::post('/signup','UserController@Signup');
Route::post('/search','UserController@Search');

Route::resource('/status','StatusController');
Route::resource('/follow','FollowController');
Route::resource('/like','LikeController');
Route::resource('/comment','CommentController');
Route::resource('/notice','NoticeController');

Route::get('/test',function(){	
	$user = Auth::user();	

	$user->notify(new CreateNotification);
});
Route::get('/logout',function(){
	Auth::logout();
	return Redirect::to('/');
});

Route::get('register', 'UserController@showRegisterForm');
Route::post('register', 'UserController@storeUser');

Route::post('/language',array(
	'Middleware'=>'LanguageSwitcher',
	'uses'=>'LanguageController@index'
));