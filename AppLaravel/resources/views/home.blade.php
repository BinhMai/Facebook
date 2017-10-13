@extends('master')
@section('profile')

	<a href='http://localhost/user={{$user->id}}'>
		<div class="col-md-12" style="background-color: white;float:right;">						
			<img src="{{asset($user->avatar!= '' ? $user->avatar : '/image/black.png')}}" style="padding: 10px" height="50" width="50"/>	
			<span style="font-size:18px; margin-left: 10px;">{{$user->name}}</span>		
		</div>
	</a>

	<a class="list-group-item" href='http://localhost/user={{$user->id}}' style="margin-top: 70px"><span class="glyphicon glyphicon-user"></span> {{ trans('file.Trang Cá Nhân')}}</a>	

		<a class="list-group-item" href='http://localhost/friend' style="margin-top: 20px"><span class="glyphicon glyphicon-search"></span> {{ trans('file.Bạn Bè')}} ({{count($follow)}})</a>	
	
	<div class="col-md-12" style="background: white; margin-top: 20px;padding: 0px">	
		<ul class="list-group" style="margin-bottom: 0px">
			<a class="list-group-item"><span class="glyphicon glyphicon-cog"></span> {{ trans('file.Quản lý nhóm')}}</a>
			<a class="list-group-item"><span class="glyphicon glyphicon-plus-sign"></span> {{ trans('file.Tạo nhóm mới')}}</a>
			<a class="list-group-item"><span class="glyphicon glyphicon-user"></span> {{ trans('file.Tham gia nhóm')}}</a>
		 </ul>
	</div>
@endsection
@section('psStatus')	
	<form class="col-md-12 col-xs-12" id ="postStatus" style="background-color: white;padding:0px" method="POST">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">

		<div class="col-md-12 col-xs-12" style="border-bottom: solid 1px #e9ebee;padding:5px">
			<div class="col-md-3 col-xs-4" style="padding: 5px">
				<input type="file" name="pictures" id="images" style="display: none" />
				<span class="glyphicon glyphicon-camera" style="color: #4267b2"></span> <input type="button" class="file" id="btnAttachment"  onclick="openAttachment()" style="color: #4267b2;border: none ; background-color: white" value="{{ trans('file.Ảnh')}}/Video"/>
			</div>
			<div class="col-md-4 col-xs-5"  style="padding: 5px;">
				<button type="button"style="color: #4267b2;border: none ; background-color: white"><span class="glyphicon glyphicon-facetime-video"></span> Video {{ trans('file.trực tiếp')}}</button>
			</div>
			<div class="col-md-5 col-xs-3" style="padding: 0px">
				<button type="button"style="color: #4267b2; border: none; background-color: white"><span class="glyphicon glyphicon-picture"></span> Album {{ trans('file.Ảnh')}}/Video</button>
			</div>
		</div>		
		<div class="col-md-12 col-xs-12" style="border-bottom: solid 1px #e9ebee">
			<textarea class="col-md-12 col-xs-12" style="margin-top: 10px; margin-bottom: 10px;padding: 10px; border: none;word-wrap: break-word;font-size: 17px;color:black" type="text" name="contentStt" placeholder="{{ trans('file.status')}}"></textarea>
			<p class="col-md-12 error errorContent"></p>
		</div>
		<div class = "col-md-1 col-xs-2" id="images-to-upload">
		</div>
		<div class="col-md-12 col-xs-12">
			<input class="col-md-2 col-xs-2 btn btn-primary" type="submit" style="float:right; padding: 3px; margin: 10px" value="{{ trans('file.Đăng')}}"/>
		</div>
	</form>
	
	<script type="text/javascript">
		function openAttachment(){
			document.getElementById('images').click();
		}
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			//onload file
			var fileCollection = new Array();
			$('#images').on('change',function(e){

				var files = e.target.files;

				$.each(files, function(i, file){

					fileCollection.push(file);

					var reader = new FileReader();
					reader.readAsDataURL(file);
					reader.onload = function(e){
						var template = '<img src="'+e.target.result+'" height="40" width="40">';
						$('#images-to-upload').html(template);
					};
				});
			});
			$.ajaxSetup({
				headers: {
					'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
				}
			});
			jQuery.validator.setDefaults({
				errorPlacement: function(error, element) {
					error.appendTo(element.parent().find('div.myErrors'));
				}
			});
			$("#postStatus").validate({				
				submitHandler: submitFormStatus
			});
			function submitFormStatus(){	
				var form = $('#postStatus')[0];
				var formData = new FormData(form);	    		
				$.ajax({
					type : 'POST',
					url  : 'status',
					data : formData,
					contentType: false,
					processData: false,
					success:  function(data)
					{		   
						console.log(data);		            	     		           						
						if (data.error == true) {
                            $('.error').hide();                            
                            if (data.message.contentStt != undefined) {
                                $('.errorContent').show().text(data.message.contentStt[0]);
                            }
                        } else {
                            window.location = "/";
                        }
					}
				});
				return false;
			}
		});
	</script>
@endsection
@section('content')
	@if(count($statuses) > 0)
		@foreach($statuses as $stt)
			@php				
				$checkLike = App\Status::find($stt->id_status)->getLike()->where('id_user',$user->id)->get();
				$checkFollow = App\User::find($user->id)->follow()->where('follow',$stt->id_user)->get();
				$likes = App\Status::find($stt->id_status)->getLike;	
				$comments = App\Comment::where('id_status',$stt->id_status)->orderBy('created_at','asc')->get();				
			@endphp			
			<div class="col-md-12 col-xs-12 status{{$stt->id_status}}" style="margin-top: 30px; padding: 10px; background-color: white">
				<div class="col-md-12 col-xs-12" style="margin-top: 10px">
					<img class="col-md-1 col-xs-2" src="{{asset($stt->User->avatar!= '' ? $stt->User->avatar : '/image/black.png')}}" style="padding: 0px" height="50" width="50" />
					<div class="col-md-9 col-xs-8">
						<a href='http://localhost/user={{$stt->User->id}}'>
							<span class="col-md-12 col-xs-12" style="color: #4267b2; padding-left:0px;font-size: 20px">{{$stt->User->name}}</span>
						</a>	
						<span class="col-md-12 col-xs-12" style="padding-left: 0px; color:#90949c">							
							@php 											
								$time = strtotime(date('Y-m-d H:i:s'))-strtotime($stt->created_at);					
								if($time < 60)					
									echo "Vừa xong";
								else if($time>60 and $time < 3600)
									echo (integer)($time/60)." phút trước";
								else if($time> 3600 and $time < 86400)
									echo (integer)($time/3600)." giờ trước";
								else
									echo (integer)($time/86400). "ngày trước";
							@endphp
						</span>
					</div>				
					<div class="dropdown col-xs-1" style="float: right">
						<input type="hidden" name="_method" value="DELETE">
						<button class="dropdown-toggle" type="button" style="background-color: white; border: none" data-toggle="dropdown">
							<span class="glyphicon glyphicon-chevron-down"></span>
						</button>
						@if($user->id == $stt->User->id)
							<ul class="dropdown-menu">
								<li>
									<a class="delete" id="delete{{$stt->id_status}}"><span class="glyphicon glyphicon-trash" style="color: red; padding-right: 10px"></span>{{ trans('file.delete')}}</a>
								</li>
								<li>
									<a class="edit" id="edit{{$stt->id_status}}" ><span class="glyphicon glyphicon-edit" style="color: green;padding-right: 10px"></span>{{ trans('file.edit')}}</a>
								</li>			
							</ul>
						@else
							<ul class="dropdown-menu">
								<li>
									<a class="hideStt" id="hideStt{{$stt->id_status}}"><span class="glyphicon glyphicon-minus-sign" style="padding-right: 10px"></span>
										{{ trans('file.hide')}}
									</a>
								</li>
								<li>
									<a class="unfollow" id="unfollow{{$checkFollow[0]['user'].$checkFollow[0]['follow']}}"><span class="glyphicon glyphicon-remove" style="padding-right: 10px"></span> {{ trans('file.unfollow')}}</a>
								</li>			
							</ul>
						@endif						
					 </div>
				</div>
				<div class="col-md-12 col-xs-12">
					<span class="col-md-12 content{{$stt->id_status}}" style="word-wrap: break-word; margin-top: 10px">{{$stt->content}}</span>	
					<form class="col-md-12 col-xs-12 editcontent" id="editcontent{{$stt->id_status}}" method="POST" style="padding: 0px">
						<input type="hidden" name="_method" value="put">

						<textarea class="col-md-12 col-xs-12" style="border: solid 1px blue; margin-top: 10px" id="contentedit{{$stt->id_status}}">{{$stt->content}}</textarea>	
						<button type="button" class="col-md-2 col-xs-2 btn btn-danger cancel" id="cancel{{$stt->id_status}}" style="float: right; margin-top: 10px;width: 70px">Cancel</button>
						<button type="button" class="col-md-2 col-xs-2 btn btn-primary save" id="save{{$stt->id_status}}" style="float: right; margin-top: 10px;width: 70px">Save</button>			
					</form>
				</div>					 
				@if($stt->picture != '')
					<img class="col-md-12 col-xs-12" src="{{asset($stt->picture)}}" style="margin-top: 10px;margin-bottom: 20px" height="300" />
				@endif
				
				<div class="col-md-12 col-xs-12" style="margin-top: 20px;padding-top: 20px; border-top: solid 1px #e9ebee;margin-bottom: 10px">		
					<input type="hidden" name="_method" value="DELETE">
			
					@if(count($checkLike) >0)
						<div class="dropdown ">							
							<a class="dropbtn countlike{{$stt->id_status}} countlike{{$checkLike[0]['id_user'].$checkLike[0]['id_status']}}">{{count($likes) > 0 ? count($likes):''}}</a>
							<div class="dropdown-content">
								@foreach($likes as $lk)
									@if($lk->UserLike->id == $user->id)
										<a href="http://localhost/user={{$lk->UserLike->id}}" class="userlike{{$stt->id_status}} userlike{{$checkLike[0]['id_user'].$checkLike[0]['id_status']}}" style="padding-left: 30px">{{$lk->UserLike->name}}</a>
									@else
										<a href="http://localhost/user={{$lk->UserLike->id}}" style="padding-left: 30px">{{$lk->UserLike->name}}</a>
									@endif
								@endforeach
							</div>
						</div>						
						<span class="glyphicon glyphicon-thumbs-up glyphicon{{$stt->id_status}} glyphicon{{$checkLike[0]['id_user'].$checkLike[0]['id_status']}}" style="font-size: 20px; color: blue"></span>

						<a class="dislike dislike{{$stt->id_status}} dislike{{$checkLike[0]['id_user'].$checkLike[0]['id_status']}}" id="dislike{{$checkLike[0]['id_user'].$checkLike[0]['id_status']}}" style="padding-left: 5px">DisLike</a>			

						<a class="like like{{$checkLike[0]['id_user'].$checkLike[0]['id_status']}}" id="like{{$stt->id_status}}" style="padding-left: 5px; display: none">{{ trans('file.like')}}</a>									
					@else
						<div class="dropdown">							
							<a class="dropbtn countlike{{$stt->id_status}}">{{count($likes) > 0 ? count($likes):''}}</a>
							<div class="dropdown-content">
								<a href="http://localhost/user={{$user->id}}" class="userlike{{$stt->id_status}}" style="display: none">{{$user->name}}</a>
								@foreach($likes as $lk)
									<a href="http://localhost/user={{$lk->UserLike->id}}">{{$lk->UserLike->name}}</a>
								@endforeach																							
							</div>
						</div>								
						<span class="glyphicon glyphicon-thumbs-up glyphicon{{$stt->id_status}}" style="font-size: 20px;"></span>
						<a class="like like{{$stt->id_status}}" id="like{{$stt->id_status}}" style="padding-left: 5px">{{ trans('file.like')}}</a>	
						<a class="dislike dislike{{$stt->id_status}}" id="like{{$stt->id_status}}" style="padding-left: 5px;display: none">DisLike</a>								
					@endif
					<span class="glyphicon glyphicon-comment" style="font-size: 20px;padding-left: 20px"></span>
						<a class="comment" id="comment{{$stt->id_status}}" style="padding-left: 5px">{{ trans('file.comment')}}</a>
					<span class="glyphicon glyphicon-share" style="font-size: 20px; padding-left: 20px;"></span>
						<a href="" style="padding-left: 5px">  {{ trans('file.share')}}</a>	
					<a style="float:right" class="showComment" id="show{{$stt->id_status}}">{{count($comments) >0 ? count($comments)." bình luận" : ""}}</a>
				</div>							

				<div class="col-md-12 statuscomment" style = "padding: 0px" id="statuscomment{{$stt->id_status}}">
					@if(count($comments) < 5)
						@foreach($comments as $coms)
							<div class="col-md-12" style="background-color: #f6f7f9;">
								<img class="col-md-1" src="{{asset($coms->user->avatar!= '' ? $coms->user->avatar : '/image/black.png')}}" style="padding: 10px 5px 0px 0px " height="50" width="40" />
								<div class="col-md-11" style="margin-top: 5px; padding-left: 5px">
									<a href="http://localhost/user={{$coms->user->id}}"><span style="color: #365899; font-size: 18px">{{$coms->user->name}}</span></a>
									<span style="word-wrap: break-word;padding-left:5px">{{$coms->content}}</span>
									<br>
									<a style="color: #365899; font-size: 12px">Thích  </a>
									<a style="color: #365899; font-size: 12px">  Trả lời</a>
									<span style="color: #90949c; font-size: 12px"> 													
										@php 											
											$time = strtotime(date('Y-m-d H:i:s'))-strtotime($coms->updated_at);					if($time < 60)					
												echo "Vừa xong";
											else if($time>60 and $time < 3600)
												echo (integer)($time/60)." phút trước";
											else if($time> 3600 and $time < 86400)
												echo (integer)($time/3600)." giờ trước";
											else
												echo (integer)($time/86400). "ngày trước";
										@endphp
									</span>
								</div>
							</div>
						@endforeach
					@else																			
						@for($i=0;$i<5;$i++)	
							 <div class="col-md-12" style="background-color: #f6f7f9;">							
								<img class="col-md-1" src="{{asset($comments->get($i)->user->avatar != '' ? $comments->get($i)->user->avatar: '/image/black.png')}}" style="padding: 10px 5px 0px 0px " height="50" width="40" />
								<div class="col-md-11" style="margin-top: 5px; padding-left: 5px">
									<a href="http://localhost/user={{$comments->get($i)['id']}}"><span style="color: #365899; font-size: 18px">{{$comments->get($i)->user->name}}</span></a>
									<span style="word-wrap: break-word;padding-left:5px">{{$comments->get($i)['content']}}</span>
									<br>
									<a style="color: #365899; font-size: 12px">Thích  </a>
									<a style="color: #365899; font-size: 12px">  Trả lời</a>
									<span style="color: #90949c; font-size: 12px">
										@php 											
											$time = strtotime(date('Y-m-d H:i:s'))-strtotime($comments->get($i)['updated_at']);					if($time < 60)					
												echo "Vừa xong";
											else if($time>60 and $time < 3600)
												echo (integer)($time/60)." phút trước";
											else if($time> 3600 and $time < 86400)
												echo (integer)($time/3600)." giờ trước";
											else
												echo (integer)($time/86400). "ngày trước";
										@endphp
									</span>
								</div>
							</div> 
						@endfor
						<a class="viewcomment" id="hidecomment{{$stt->id_status}}">Xem thêm bình luận ...</a>
						@for($i=5;$i<count($comments);$i++)	
							<div class="col-md-12 hidecomment hidecomment{{$stt->id_status}}" style="background-color: #f6f7f9;">								
								<img class="col-md-1" src="{{asset($comments->get($i)->user->avatar != '' ? $comments->get($i)->user->avatar : '/image/black.png')}}" style="padding: 10px 5px 0px 0px " height="50" width="40" />
								<div class="col-md-11" style="margin-top: 5px; padding-left: 5px">
									<a href="http://localhost/user={{$comments->get($i)['id']}}"><span style="color: #365899; font-size: 18px">{{$comments->get($i)->user->name}}</span></a>
									<span style="word-wrap: break-word;padding-left:5px">{{$comments->get($i)['content']}}</span>
									<br>
									<a style="color: #365899; font-size: 12px">Thích  </a>
									<a style="color: #365899; font-size: 12px">  Trả lời</a>
									<span style="color: #90949c; font-size: 12px"> 
										@php 											
											$time = strtotime(date('Y-m-d H:i:s'))-strtotime($comments->get($i)['updated_at']);					if($time < 60)					
												echo "Vừa xong";
											else if($time>60 and $time < 3600)
												echo (integer)($time/60)." phút trước";
											else if($time> 3600 and $time < 86400)
												echo (integer)($time/3600)." giờ trước";
											else
												echo (integer)($time/86400). "ngày trước";
										@endphp
									</span>
								</div>
							</div>
						@endfor
					@endif
				</div>

				<!--form bình luận-->
				<form class="col-md-12 commentDialog" method="post" id="dialogcomment{{$stt->id_status}}" onsubmit="return false" style="background-color: #f6f7f9">
					<img class="col-md-1" src="{{asset($user->avatar!= '' ? $user->avatar : '/image/black.png')}}" style="padding: 10px 5px 0px 0px " height="50" width="40" />
					<input class="col-md-11 comment{{$stt->id_status}} entercomment" type="text" placeholder="Viết bình luận ..." name ="comment" style="margin-top: 10px;border-radius: 10px; float: right;padding: 8px">
					<div class="myErrors"></div>
				</form>
			</div>
		@endforeach
	@else
		<div class="col-md-12 btn-warning" style="padding: 5px; margin-top: 10px">Không có bài đăng để hiển thị</div>
	@endif

	<script type="text/javascript">
		$(document).ready(function(){

			$.ajaxSetup({
				headers: {
					'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
				}
			});

			$('.viewcomment').click(function(){
				var id = $(this).attr('id');
				$('.'+id).show();
				$('#'+id).hide();
			});

			$('.comment').click(function(){
				var id = $(this).attr('id');
				var id_status = id.substr(7,id.length-7);
				$('#statuscomment'+id_status).fadeIn(300);
				$('form#dialog'+id).fadeIn(300);

				var ro = {
			            required: "This field is required.",
			        },
			        en = {
			            required: "Nội dung bình luận không được để trống."
			        };

			    var check = '<?php echo App::getLocale();?>'				

				if(check =='en'){			    
			        $.extend($.validator.messages, eval('en'));    
			    }else{
			    	$.extend($.validator.messages, eval('ro'));    
			    }			  

			    $("#dialog"+id).validate({
			        rules: {
			            comment: {
			                required: true
			            }
			        }
			    });								

				$('.entercomment').change(function(){					
					$.ajax({
						type : 'POST',
						url  : 'comment',
						data : {id_status: id_status, comment: $("."+id).val()},
						success:  function(ketqua)
						{								
							$(".comment"+id_status).val("");																	
																
							var html='';
							for (var i=0; i<ketqua.length; i++) {
								var status = ketqua[i];
								var currentDate = new Date();
								var date = new Date(status.created);
								var time = (currentDate.getTime()-date.getTime())/1000;								
														
								var value = "Vừa xong";
								if( time < 60)								
									value = " Vừa xong";					
								else if(time> 60 && time < 3600)
									value = " "+Math.round(time/60)+" phút trước";
								else if(time > 3600 && time < 86400)
									value = " "+Math.round(time/3600)+" giờ trước";
								else
									value = " "+Math.round(time/86400)+" ngày trước";
								if(status.avatar != null)																		
									html+='<div class="col-md-12" style="background-color: #f6f7f9;">'
											+'<img class="col-md-1" src="'+status.avatar+'" style="padding: 10px 5px 0px 0px "height="50" width="40" />'
											+'<div class="col-md-11" style="margin-top: 5px; padding-left: 5px">'
												+'<a href=""><span style="color: #365899; font-size: 18px">'+status.name+'</span></a>'
												+'<span style="word-wrap: break-word;padding-left:5px">'+status.content+'</span>'
												+'<br>'
												+'<a style="color: #365899; font-size: 12px">Thích  </a>'
												+'<a style="color: #365899; font-size: 12px">  Trả lời</a>'
												+'<span style="color: #90949c; font-size: 12px">'
												+value
												+'</span>'
											+'</div>'
										+'</div>';
								else
									html+='<div class="col-md-12" style="background-color: #f6f7f9;">'
											+'<img class="col-md-1" src="/image/black.png" style="padding: 10px 5px 0px 0px "height="50" width="40" />'
											+'<div class="col-md-11" style="margin-top: 5px; padding-left: 5px">'
												+'<a href=""><span style="color: #365899; font-size: 18px">'+status.name+'</span></a>'
												+'<span style="word-wrap: break-word;padding-left:10px">'+status.content+'</span>'
												+'<br>'
												+'<a style="color: #365899; font-size: 12px">Thích  </a>'
												+'<a style="color: #365899; font-size: 12px">  Trả lời</a>'
												+'<span style="color: #90949c; font-size: 12px">'
												+value
												+'</span>'
											+'</div>'
										+'</div>';
							}													
							$("#statuscomment"+id_status).html(html);
							var id_show = $('#show'+id_status).text();
							var number = id_show.substr(0,1);
							number++;
							$('#show'+id_status).text(number.toString()+" bình luận");																							
						}
					});					
				});
			});
			
			//show comment			
			$('.showComment').click(function(){
				var id_name = $(this).attr('id');
				var id = id_name.substr(4,id_name.length-4);

				if($('#statuscomment'+id).css('display') == 'none'){
					$('#statuscomment'+id).fadeIn(300);
				}else{
					$('#statuscomment'+id).fadeOut(300);
					$('form#dialogcomment'+id).fadeOut(300);
				}
			});

			$('.like').click(function(){
				var id_name = $(this).attr('id');
				var id = id_name.substr(4,id_name.length -4);
				var id_user = {{$user->id}};
				$('.glyphicon'+id).css('color','blue');
				
				var count = $(".countlike"+id).text();
				count++;		
				$(".countlike"+id).text(count.toString());
			
				$.ajax({
					url : 'like',
					type: 'post',
					data:{id_status:id},
					success: function(data){						
						$('#like'+id).hide();
						$('.dislike'+id).show();

						$('.dislike'+id).attr("id","dislike"+id_user+id);
						$('.dislike'+id).attr("class","dislike dislike"+id+" dislike"+id_user+id);	
						$('.glyphicon'+id).attr("class","glyphicon glyphicon-thumbs-up glyphicon"+id +" glyphicon"+id_user+id);	
						$('#like'+id).attr("class","like like"+id_user+id);	
						$('.countlike'+id).attr("class","dropbtn countlike"+id+" countlike"+id_user+id);	
						$('.userlike'+id).show();
						$('.userlike'+id).attr("class","userlike"+id+" userlike"+id_user+id);
					}
				});
			});

			$('.dislike').click(function(){
				var id_dislike = $(this).attr('id');
				var id = id_dislike.substr(7,id_dislike.length-7);	
				var id_user = {{$user->id}};				
				$('.glyphicon'+id).css('color','black');					

				var count = $(".countlike"+id).text();			
				count--;				
				if(count!= 0)
					$(".countlike"+id).text(count.toString());
				else
					$(".countlike"+id).text("");				
				$.ajax({
					url : 'like/'+id,
					type: 'Delete',
					data: {id_user: id_user},
					success: function(data){						
						$('.userlike'+id).hide();					
						$('.like'+id).show();
						$('.dislike'+id).hide();
					}
				});
			});

			$('.delete').click(function(){
				var id_name = $(this).attr('id');
				var id = id_name.substr(6,id_name.length-6);

				$.ajax({
					url : 'status/'+id,
					type: 'Delete',
					success: function(){					
						document.location= "http://localhost/home";            						
					}
				});
			});

			$('.edit').click(function(){
				var id_name = $(this).attr('id');
				var id = id_name.substr(4,id_name.length-4);

				$('#editcontent'+id).show();
				$('.content'+id).hide();

				$('.cancel').click(function(){
					$('#editcontent'+id).hide();
					$('.content'+id).show();
				});

				$('.save').click(function(){
					var content = $('#contentedit'+id).val();
						$.ajax({
						url : 'status/'+id,
						type: 'put',
						data: {contentedit: content},			
						success: function(){					
							$('.content'+id).text(content);
							$('.content'+id).show();
							$('#editcontent'+id).hide();
						}
					});
				});
			});

			$('.hideStt').click(function(){
				var id_name = $(this).attr('id');
				var id = id_name.substr(7,id_name.length-7);				
				$('.status'+id).hide();
			});

			$('.unfollow').click(function(){
				var id_name = $(this).attr('id');
				var id_user = {{$user->id}};
				var id = id_name.substr(8,id_name.length-8);				
							
				$.ajax({
					type:'DELETE',
					url :'follow/'+id,	
					data: {id_user: id_user},
					success:function(data){					
						document.location =  "http://localhost/home";            
					}
				});
			});			
		});
	</script>
@endsection