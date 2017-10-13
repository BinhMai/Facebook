<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Notifications\Notifiable;
use App\User;
use Validator;
use Auth;
use DateTime;
use App\Notice;
use App\Status;
use File;
use Illuminate\Support\MessageBag;

class UserController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function checkUser(Request $request){
        $name = $request->name;
        $password = $request->password;

        if (Auth::attempt(['name' => $name, 'password' => $password])) {
            echo "true";
        }else
            echo "faile";
    }

    public function Signup(Request $req){
        $user = new User();
        return $user->validation($req->all());                    
    }

    public function Search(Request $req){
        $id = Auth::id();
        $acc = User::find($id);
        $user = new User();
        $search = $user->search($req->search,$acc->name);
        $follow = User::find($id)->followUsers()->where('id',"<>",$id)->get();
        $notice = Auth::user()->getNotice;
        $nt = Auth::user()->getNotice()->where('seen','=',0)->get();
        return view('search',['user'=>$acc,'search'=>$search,'follow'=>$follow,'notice'=>$notice,'nt'=>$nt]);
    }

    public function update(Request $req){        
        $user = Auth::user();    
        $user->name = $req->name;    
        $user->email = $req->email; 
        $user->address = $req->diachi;        
        $user->phonenumber = $req->sdt;
        if($req->file('image') != ''){            
            $file = $req->file('image')->getClientOriginalName();
            $user->avatar = 'image/'.$file;
            if ( ! File::copy($req->file('image'),'image/'.$file))
            {
                die("Couldn't copy file");
            }
        }        

        if($user->isDirty('name') || $user->isDirty('email')){
            $data = $user->validationUpdate($req->all());                    
            if ($data != null) {
                return $data;
            }else{                        
                $user->save();
                return response($user,201);                
            }
        }else{
            return "not change";
        }                    
    }    

    public function friends(Request $req){       
        $id = Auth::id();
        $acc = User::find($id);
        $user = new User();        
        $search = User::find($id)->followUsers()->where('id',"<>",$id)->get();        
        $follow = User::find($id)->followUsers()->where('id',"<>",$id)->get();        
        $notice = Auth::user()->getNotice; 
        $nt = Auth::user()->getNotice()->where('seen','=',0)->get();       
        return view('search',['user'=>$acc,'search'=>$search,'follow'=>$follow,'notice'=>$notice,'nt'=>$nt]);    
    }

    public function test(){
        // $date = date("2017-08-18 18:42:28");
        // $curentTime = date('Y-m-d H:i:s');                
        // // echo $days = (strtotime($curentTime)-strtotime($date))/60;
        // echo strtotime($date);
        $user = User::find(1);

        foreach ($user->notifications as $notification) {
            echo $notification->type;
        }
    }

    public function showRegisterForm(){
        return view('fontend.register');
    }

    public function storeUser(Request $request){
        //dd($request->all());

        $messages = [
            'required' => 'Trường :attribute bắt buộc nhập.',
            'email'    => 'Trường :attribute phải có định dạng email'
        ];
        $validator = Validator::make($request->all(), [
            'name'     => 'required|max:255',
            'email'    => 'required|email',
            'password' => 'required|numeric|min:6|confirmed',
            'website'  => 'sometimes|required|url'

        ], $messages);

        if ($validator->fails()) {
            return redirect('register')
                    ->withErrors($validator)
                    ->withInput();
        } else {
            // Lưu thông tin vào database, phần này sẽ giới thiệu ở bài về database

            return redirect('register')
                    ->with('message', 'Đăng ký thành công.');
        }
    }
}
