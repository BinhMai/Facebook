@extends('master')
@section('profile')
	<a href='http://localhost/user={{$user->id}}'>
		<div class="col-md-12" style="background-color: white;float:right;">						
			<img src="{{asset($user->avatar!= '' ? $user->avatar : '/image/black.png')}}" style="padding: 10px" height="50" width="50"/>	
			<span style="font-size:18px; margin-left: 10px;">{{isset($friend) ? $friend->name : $user->name}}</span>		
		</div>
	</a>

	<a class="list-group-item" href='http://localhost/user={{isset($friend) ? $friend->id : $user->id}}' style="margin-top: 70px"><span class="glyphicon glyphicon-user"></span> Trang Cá Nhân</a>	
		@if(!isset($friend))
			<a class="list-group-item" href='http://localhost/friend' style="margin-top: 20px"><span class="glyphicon glyphicon-search"></span> Bạn bè ({{count($follow)}})</a>	
		@endif
	
	<div class="col-md-12" style="background: white; margin-top: 20px;padding: 0px">	
		<ul class="list-group" style="margin-bottom: 0px">
			<a class="list-group-item"><span class="glyphicon glyphicon-cog"></span> Quản lý nhóm </a>
			<a class="list-group-item"><span class="glyphicon glyphicon-plus-sign"></span> Tạo nhóm mới</a>
			<a class="list-group-item"><span class="glyphicon glyphicon-user"></span> Tham gia nhóm </a>
		 </ul>
	</div>
@endsection
@section('search')
	@if(count($search) > 0)
		@foreach($search as $src)
			@php 		
				$us = App\User::find($user->id)->follow()->where('follow',$src->id)->get();
			@endphp
			<form class="col-md-12" method="POST" style="margin-top: 15px; padding: 10px; background-color: white">
				<input type="hidden" name="_method" value="DELETE">
				<img class="col-md-2" src="{{asset($src->avatar!= '' ? $src->avatar : '/image/black.png')}}" style="padding: 10px" height="80" />
				<div class="col-md-10" style="margin-top: 20px">				
					<a href='http://localhost/user={{$src->id}}' style="color: #4267b2; font-size: 25px; border: none" type="text" name="result">{{$src->name}}</a>				

					@if($us != "[]")
						<input class="col-md-3 btn btn-danger unfollow unfollow{{$src->id}} unfollow{{$us[0]['user'].$us[0]['follow']}}" type="submit" id="{{$us[0]['user'].$us[0]['follow']}}" style="margin-top: 50px;float: right" value="UnFollow">
						<input class="col-md-3 btn btn-primary addfollow addfollow{{$us[0]['user'].$us[0]['follow']}}" type="submit" id="{{$src->id}}" style="margin-top: 50px;float: right;display: none;" value="Follow">
					@else
						<input class="col-md-3 btn btn-danger unfollow unfollow{{$src->id}}" type="submit" style="margin-top: 50px;float: right;display: none;" value="UnFollow">
						<input class="col-md-3 btn btn-primary addfollow" type="submit" id="{{$src->id}}" style="margin-top: 50px;float: right" value="Follow">
					@endif
				</div>
			</form>
		@endforeach
	@else
		<form style="margin-top: 30px"><button class="col-md-12 btn btn-warning" type="button">Không có kết quả nào !!!</button></form>
	@endif
	<div id="aaaa"></div>
	
	<script type="text/javascript">
		$(document).ready(function(){
			$('.addfollow').click(function(e){
				e.preventDefault();
				var id_user = {{$user->id}};
				var id_follow = $(this).attr("id");
				$.ajax({
					type:'POST',
					url :'http://localhost/follow ',
					data:{id_user: id_user, id_follow : id_follow},
					success:function(data){											
						$('#'+id_follow).hide();
						$('.unfollow'+id_follow).show();

						$('.unfollow'+id_follow).attr("id",id_user+id_follow);
						$('.unfollow'+id_follow).attr("class","col-md-3 btn btn-danger unfollow unfollow"+id_follow+" unfollow"+id_user+id_follow)
						$('#'+id_follow).attr("class","col-md-3 btn btn-primary addfollow addfollow"+id_user+id_follow);
												
						var html='<form class="col-md-11" style="background-color: white;padding-bottom: 10px; margin-left: 20px"><span class="col-md-12 text-center" style="font-size: 20px; color: red">Bạn Bè</span>';
						for (var i=0; i<data.length; i++) {
						    var user = data[i];	
						    if(user.avatar == null)						    
							    html+='<div class="col-md-12" style="padding: 10px 10px 10px 20px; margin-top: 10px; background-color: #e9ebee">'
										+'<img src="/image/black.png" height="35px" width="35px" />'
										+'<a href="http://localhost/user='+user.id+'">'
											+'<span style="color: black;font-size: 15px; margin-left: 15px">'+user.name
											+'</span>'
										+'</a>'
									+'</div>';
							else
								html+='<div class="col-md-12" style="padding: 10px 10px 10px 20px; margin-top: 10px; background-color: #e9ebee">'
										+'<img src="http://localhost/'+user.avatar+'" height="35px" width="35px" />'
										+'<a href="http://localhost/user='+user.id+'">'
											+'<span style="color: black;font-size: 15px; margin-left: 15px">'+user.name
											+'</span>'
										+'</a>'
									+'</div>';
						}		
						$('.list-friends').html(html);
					}
				});
			});
			$('.unfollow').click(function(e){
				e.preventDefault();
				var id = $(this).attr("id");
				var id_user = {{$user->id}};				
				$.ajax({
					type:'DELETE',
					url :'http://localhost/follow/'+id,	
					data: {id_user: id_user},
					success:function(data){								
						$('.addfollow'+id).show();
						$('.unfollow'+id).hide();		

						var html='<form class="col-md-11" style="background-color: white;padding-bottom: 10px; margin-left: 20px"><span class="col-md-12 text-center" style="font-size: 20px; color: red">Bạn Bè</span>';
						for (var i=0; i<data.length; i++) {
						    var user = data[i];	
						    if(user.avatar == null)						    
							    html+='<div class="col-md-12" style="padding: 10px 10px 10px 20px; margin-top: 10px; background-color: #e9ebee">'
										+'<img src="/image/black.png" height="35px" width="35px" />'
										+'<a href="http://localhost/user='+user.id+'">'
											+'<span style="color: black;font-size: 15px; margin-left: 15px">'+user.name
											+'</span>'
										+'</a>'
									+'</div>';
							else
								html+='<div class="col-md-12" style="padding: 10px 10px 10px 20px; margin-top: 10px; background-color: #e9ebee">'
										+'<img src="http://localhost/'+user.avatar+'" height="35px" width="35px" />'
										+'<a href="http://localhost/user='+user.id+'">'
											+'<span style="color: black;font-size: 15px; margin-left: 15px">'+user.name
											+'</span>'
										+'</a>'
									+'</div>';
						}		
						$('.list-friends').html(html);		
					}
				});
			});
		});
	</script>
@endsection