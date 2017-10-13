<!DOCTYPE html>
<html>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.js" type="text/javascript"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js" type="text/javascript"></script>
<script src="http://ajax.microsoft.com/ajax/jquery.validate/1.7/jquery.validate.js" type="text/javascript"></script>

<meta name="csrf-token" content="<?= csrf_token() ?>">

<title>HUS</title>

<style type="text/css">
	.container-fluid{
		padding: 0px;
		margin-bottom: 10px;
	}
	body{
		background-color: #e9ebee
	}
	.header_middle{
		position:fixed !important;
		z-index:9999999999;
		top: 0px;
		transition: all 4s ease;
	}
	.header_right{
		position:fixed !important;		
		top: 70px;
		right: 0px;
		transition: all 4s ease;
	}	
	.left-content{
		position:fixed !important;		
		top: 70px;
		left: 0px;
		transition: all 4s ease;
	}		
	.myErrors {
        color: red;
        font-size: 20px;
        font-family: "Times New Roman";
     }
     .error {
        color: red;
        font-size: 20px;
        font-family: "Times New Roman";
     }
    .commentDialog{
		 display: none;
	 }
	 .statuscomment{
	 	 display: none;	
	 }
	 .editcontent{
	 	 display: none;		
	 }
	 .hidecomment{
	 	 display: none;		
	 }

	.dropdown {
	    position: relative;
	    display: inline-block;
	}

	.dropdown-content {
	    display: none;
	    position: absolute;
	    background-color: #f9f9f9;
	    min-width: 160px;
	    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
	    z-index: 1;
	}

	.dropdown-content a {
	    color: black;
	    padding: 12px 16px;
	    text-decoration: none;
	    display: block;
	}

	.dropdown-content a:hover {background-color: #4267b2}

	.dropdown:hover .dropdown-content {
    	display: block;
	}			    
    #noti_Container {
        position:relative;
    }     
        
    /* THE POPULAR RED NOTIFICATIONS COUNTER. */
    #noti_Counter {        
        position:absolute;
        background:#E1141E;
        color:#FFF;
        font-size:12px;
        font-weight:normal;
        padding:1px 3px;
        margin:-9px 0 0 8px;
        border-radius:2px;
        -moz-border-radius:2px; 
        -webkit-border-radius:2px;
        z-index:1;
    }
        
    /* THE NOTIFICAIONS WINDOW. THIS REMAINS HIDDEN WHEN THE PAGE LOADS. */
    #notifications { 
    	display: none;    
        width:430px;
        position:absolute;
        top:30px;
        left:100px;
        background:#FFF;
        border:solid 1px rgba(100, 100, 100, .20);
        -webkit-box-shadow:0 3px 8px rgba(0, 0, 0, .20);
        z-index: 99;
    }
    /* AN ARROW LIKE STRUCTURE JUST OVER THE NOTIFICATIONS WINDOW */
    #notifications:before {         
        content: '';
        display:block;
        width:0;
        height:0;
        color:transparent;
        border:10px solid #CCC;
        border-color:transparent transparent #FFF;
        margin-top:-20px;
        margin-left:10px;
    }
        
    h3 {
        display:block;
        color:#333; 
        background:#FFF;
        font-weight:bold;
        font-size:13px;    
        padding:8px;
        margin:0;
        border-bottom:solid 1px rgba(100, 100, 100, .30);
    }
        
    .seeAll {
        background:#F6F7F8;
        padding:8px;
        font-size:12px;
        font-weight:bold;
        border-top:solid 1px rgba(100, 100, 100, .30);
        text-align:center;
    }
    .seeAll a {
        color:#3b5998;
    }
    .seeAll a:hover {
        background:#F6F7F8;
        color:#3b5998;
        text-decoration:underline;
    }
    @media screen and (max-width: 960px) {
		#left-content{
			display: none;
		}
		#list-friends{
			display: none;	
		}
		#hidediv{
			display: none;		
		}
	}   
	#demo{
		position: absolute;
		bottom: 5px;
		right: 20px;
		color: red;
	} 
</style>
<body>
	<div class="container-fluid" id="home">
		<div class="col-md-12 col-xs-12" id="header" name="header" style="background-color: #4267b2; padding: 10px;">
			<div class="col-md-1 col-xs-1" style="padding-right: 0px">
				<a href="{{asset('/')}}"><img src="/image/fb.png" style="float: right;" height="35" width="35" /></a>
			</div>
			<form class="col-md-5 col-xs-8" id="search" style="padding-right: 0px" method="POST" action="{{'http://localhost/search'}}">				
				<input class="col-md-10 col-xs-10" style="border:0px;padding: 5px;margin-top: 3px" type="text" name="search" placeholder="{{ trans('file.Tìm kiếm')}}">
				<button type="submit" class="col-md-1 col-xs-2 btn btn-default" style="border: 0px;padding: 5px;margin-top: 3px;background-color: #DDDDDD;border-radius: 0px">
					<span class="glyphicon glyphicon-search"></span>
				</button>			
			</form>
			<div class="col-md-1 col-xs-3" style="padding-top: 6px;padding-right: 0px">
				<a href='http://localhost/user={{$user->id}}'>					
					<img src="{{asset($user->avatar!= '' ? $user->avatar : '/image/black.png')}}" height="30" width="30"/>
					<span style="color: white;font-size: 15px">{{$user->name}}</span>					
				</a>
			</div>
			<div class="col-md-3 col-xs-10" style="padding:10px 0px 0px 0px ">
				<a href="{{asset('/')}}">
					<span class="col-md-4 col-xs-4" style="color: white;font-family: arial;font-size: 15px;padding:0px">
						<span class = "glyphicon glyphicon-home"></span>
						<span style="color: white; font-size: 14px">{{ trans('file.Trang chủ')}}</span>
					</span>
				</a>		
				<!-- {{count($user->unreadNotifications)}} -->
				<div id="noti_Container">						
					<div id="noti_Count">
						@if(count($nt) > 0)						
							<span id="noti_Counter">
								{{count($nt)}}
							</span>			            				            
			        	@endif	     	
			        </div>	                   
				      		           

		            <div id="notifications">
		                <h3>Notifications</h3>
		                <div id="contentNotice">
		                @foreach($notice as $nt)                	
		                	<a href='http://localhost/status={{$nt->id_status}}'>
			                	<div style="height:60px;background: #edf2fa">	                	
				                	<img class="col-md-2" style="padding:5px" src="{{asset($nt->UserNotice->avatar!= '' ? $nt->UserNotice->avatar : '/image/black.png')}}" height="60" width="60"/>
				                	@if($nt->type == 0)
				                		<div class="col-md-10" style="padding-top: 3px;color: black">
					                		<span style="font-family: VnArabia;">{{$nt->UserNotice->name}}</span>
					                		<span> thích một bài viết của bạn</span>
					                		<br>
					                		<span style="color: #4267b2">
					                			@php 											
													$time = strtotime(date('Y-m-d H:i:s'))-strtotime($nt->created_at);					
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
				                	@else
				                		<div class="col-md-10" style="padding-top: 3px;color: black">
					                		<span style="font-family: VnArabia">{{$nt->UserNotice->name}}</span>
					                		<span> bình luận trong một bài viết của bạn</span>
					                		<br>
					                		<span style="color: #4267b2">
					                			@php 											
													$time = strtotime(date('Y-m-d H:i:s'))-strtotime($nt->created_at);					
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
				                	@endif	                	
				                	<hr style="margin: 3px">  
			                	</div>
			                </a>	                
			            @endforeach                             
		                <div class="seeAll"><a href="#">See All</a></div>
		            </div>	
		            </div>                	            
		        </div>
		        <div id="noti_Button">
		            	<input type="hidden" name="_method" value="put">
		            	<span class="col-md-4 col-xs-4" style="color: white; padding: 0px;font-family: arial;font-size: 15px">
							<span class = "glyphicon glyphicon-globe"></span>
							<span style="color: white; font-size: 14px">{{ trans('file.Thông báo')}}</span>
						</span>
		            </div>    
				<a href="">
					<span class="col-md-4 col-xs-4" style="color: white; padding: 0px;font-family: arial;font-size: 15px">
						<span class = "glyphicon glyphicon-envelope"></span>
						<span style="color: white; font-size: 14px">{{ trans('file.Tin nhắn')}}</span>
					</span>
				</a>
			</div>			
			<div class="col-md-2 col-xs-2" style="padding: 10px 0px 10px 0px">
				<a href="{{asset('logout')}}">
			  		<span class = "col-md-6" style="color: white;padding:0px;font-family: arial;font-size: 15px"> {{ trans('file.Đăng xuất')}} </span>			
			 	</a>	
			 	<form class="col-md-6" id="multilanguage" >
			 		<select name="locale" id="select">
						<option value="en"  {{ App::getLocale() == 'en' ? ' selected' : '' }}>Tiếng Việt</option>
						<option value="ro"  {{ App::getLocale() == 'ro' ? ' selected' : '' }}>English</option>
					</select>								 		 
			 	</form>				 					
		 	</div>		 	
		</div>
		<p id="demo"></p>			
	</div>

	<div class="container-fluid">
		<div class="col-md-3" style="display: none" id="hidediv"></div>
		<div class="col-md-3" style="padding:0px 15px 0px 35px" id="left-content">
			@yield('profile')
		</div>
		<div class="col-md-6 col-xs-12 content" style="padding: 0px">
			@yield('psStatus')
			@yield('content')
			@yield('search')
		</div>
		<div class="col-md-3 list-friends" id="list-friends" style="padding:0px 15px 0px 15px">
			@if(count($follow)>0)
				<div class="col-md-12" style="background-color: white;padding: 20px">
					<span class="col-md-12 text-center" style="font-size: 25px; color: red;">{{ trans('file.Bạn Bè')}}</span>
					@foreach($follow as $fll)	
						<div class="col-md-12" style="padding: 10px 10px 10px 10px; margin-top: 10px; background-color: #e9ebee">
							<img src="{{asset($fll->avatar!= '' ? $fll->avatar : '/image/black.png')}}" height="35px" width="35px" />
							<a href='http://localhost/user={{$fll->id}}'>
								<span style="color: black;font-size: 15px; margin-left: 10px">{{$fll->name}}</span>
							</a>
						</div>
					@endforeach
				</div>				
			@else
				<form class="col-md-12" style="background-color: white;padding-bottom: 10px; margin-left: 20px">
					<span class="col-md-12 text-center" style="font-size: 20px; color: red">Bạn bè trống</span>
				</form>
			@endif		
			</div>
			
			@if(isset($statuses))
				<div class="col-md-6" style="margin-top: 10px;margin-left: 550px">
					{{$statuses->links()}}
				</div>		
			@endif				

	<script type="text/javascript">		
		$(window).scroll(function() {
			
			if ($(this).scrollTop() > 60){  
				$('#header').addClass("header_middle");				
				$('#list-friends').addClass("header_right");
				$('#left-content').addClass("left-content");
				$('#hidediv').show();											
			}
			else{
				$('#header').removeClass("header_middle");				
				$('#list-friends').removeClass("header_right");								
				$('#left-content').removeClass("left-content");
				$('#hidediv').hide();											
			}
		});		
		$(document).ready(function() { 
			$("#search").validate({
		        rules: {
		            search: {
		                required: true
		            }
		        },
		        messages:{
		        	search:{
		        		required: ""
		        	}
		        }
		    });
		});
	</script>	
	<script>
	    $(document).ready(function () { 
			$('#select').on('change',function(){				
				var formData = $("#multilanguage").serialize();	    	
				$.ajax({
					type : 'POST',
					url  : 'language',
					data : formData,	
					success: function(data){
						document.location="/home";
					}
				});
	    	}); 	        
	        $('#noti_Counter')
	            .css({ opacity: 0 })            
	            .css({ top: '-10px' })
	            .animate({ top: '-2px', opacity: 1 }, 500);

	        $('#noti_Button').click(function () {	            	        	
	            $('#notifications').fadeToggle('fast', 'linear', function () {
	                if ($('#notifications').is(':hidden')) {
	                    $('#noti_Button').css('background-color', '#2E467C');	                    
	                }
	                else $('#noti_Button').css('background-color', '#FFF');        
	            });	    	                   

	            $('#noti_Counter').fadeOut('slow');               
	            var id = {{$user->id}};            

	            $.ajax({
					url : 'http://localhost/notice/'+id,
					type: 'put'
				});

	            return false;
	        });
	        
	        $(document).click(function () {
	            $('#notifications').hide();
	            if ($('#noti_Counter').is(':hidden')) {	                
	                $('#noti_Button').css('background-color', '#2E467C');
	            }
	        });        

	        //lock  	
			var myVar = setInterval(function(){ myTimer() }, 1000);

			function myTimer() {
			    var d = new Date();
			    var t = d.toLocaleTimeString();
			    document.getElementById("demo").innerHTML = t;
			}		

			var myVar1 = setInterval(function(){ myTimer1() }, 1000);

			function myTimer1() {
				$.get('/home', function(data) {
			        $("#noti_Count").html($(data).find('#noti_Count'));
			        $("#contentNotice").html($(data).find('#contentNotice'));
			    });				
				// $('#noti_Count').load('/home #noti_Counter').fadeIn("slow");					    
				// $('#contentNotice').load('/home #contentNotice').fadeIn("slow");			
			}    	
	    });
	</script>
</body>
</html>