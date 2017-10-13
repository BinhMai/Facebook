<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Status;
use App\Comment;
use App\Like;
use App\Notice;
use Auth;
use DateTime;
use File;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Status::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {        
        $status = new Status();
        $data = $status->validationStatus($request->all());                    
        if ($data != null) {
            return $data;
        }else{
            $id = Auth::id();
            $status->id_user = $id;
            $status->content = $request->contentStt;
            $status->created_at = new DateTime();
            
            if($request->file('pictures') != ''){            
                $file = $request->file('pictures')->getClientOriginalName();
                $status->picture = 'image/'.$file;
                 if ( ! File::copy($request->file('pictures'),'image/'.$file))
                  {
                      die("Couldn't copy file");
                  }
            }

            $status->save();            
        }        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $status = Status::find($id);
        $status->content = $request->contentedit;
        $status->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = Comment::where('id_status',$id)->delete();        
        $like = Like::where('id_status',$id)->delete();
        $notice = Notice::where('id_status',$id)->delete();
        $status = Status::find($id)->delete();
    }
}
