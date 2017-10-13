@extends('home')
@section('psStatus')
	<form class="col-md-12" id ="postStatus" style="background-color: white" method="POST">
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
		<div class="col-md-12" style="border-bottom: solid 1px #e9ebee">
			<textarea class="col-md-12" style="font-size: 17px;margin-top: 10px; margin-bottom: 10px;padding: 10px; border: none;word-wrap: break-word" type="text" name="contentStt" placeholder="{{$user_profile->id == $user->id ? trans('file.status') : trans('file.status2').$user_profile->name}}"></textarea>
			<div class="myErrors"></div>
		</div>
		<div class = "col-md-1" id="images-to-upload">
		</div>
		<div class="col-md-12">
			<input class="col-md-2 btn btn-primary" type="submit" style="float:right; padding: 3px; margin: 10px" value="{{ trans('file.Đăng')}}"/>
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
		        rules: {
		            contentStt: {
		                required: true
		            }
		        },
		        messages:{
		            contentStt:{
		                required:"Bài đăng không được để trống"
		            }
		        },
				     submitHandler: submitFormStatus
		    });
		    function submitFormStatus(){	
		    	var form = $('#postStatus')[0];
				var formData = new FormData(form);
				var id_profile = {{$user_profile->id}};

		        $.ajax({
		            type : 'POST',
		            url  : 'status',
		            data : formData,
		            contentType: false,
    				processData: false,
		            success:  function(data)
		            {		   		            	     		           
		            	document.location = "http://localhost/user="+id_profile;            
		            }
		        });
		        return false;
		    }
		});
	</script>
@endsection
@section('profile')
	@if($user->id == $user_profile->id)
		<form class="col-md-12" style="background-color: white" id="updateUser" method="POST" enctype="multipart/form-data" >			
			<div class="col-md-12" style="padding: 0px">
				<label class="col-md-6; text-center" style="margin-top: 20px;padding-top: 5px;padding-left: 10px;color: #4267b2;">Thay đổi ảnh đại diện :</label>				
				<input type="file" id="picture" name="image" style="display: none" />				
			</div>			
			<div class = "col-md-1" id="avatar-to-upload">
				<img src="{{asset($user->avatar!= '' ? $user->avatar : '/image/black.png')}}" onclick="openAttach()" height="60" width="60" style="margin-left: 80px;border-radius: 30px" />
			</div>

			<div class="col-md-12" style="padding: 0px; margin-top: 10px">
		    	<label class="col-md-5" style="padding-top: 5px; color: #4267b2;">Tên:</label>		    	
		    	<input class="col-md-7" style="border:none; margin-top: 5px" onkeydown="setTimeout(myFunction, 0, this)" id="name" name="name" value="{{$user_profile->name}}" required>
		    	<p style="color:red; display: none; padding-left: 15px; margin: 0px;font-size: 15px" class="col-md-12 error errorName"></p>  
		   </div>
		   
			<div class="col-md-12" style="padding: 0px;margin-top: 5px">
		   	 	<label class="col-md-5" style="padding-top: 5px; color: #4267b2;float: left">Email:</label>
		    	<input class="col-md-7 text-left" style="margin-top: 5px;border: none" type="text" onkeydown="setTimeout(myFunction, 0, this)" id="email" name="email" value="{{$user_profile->email}}" required/>
		   </div>

		   <div class="col-md-12" style="padding: 0px;margin-top: 5px">
		   	 	<label class="col-md-5" style="padding-top: 5px; color: #4267b2;float: left">Địa chỉ:</label>
		    	<input class="col-md-7 text-left" style="margin-top: 5px;border: none" type="text" onkeydown="setTimeout(myFunction, 0, this)" id="diachi" name="diachi" value="{{$user_profile->address!= '' ? $user_profile->address : 'Not Available'}}" required/>
		   </div>
		   
		   <div class="col-md-12" style="padding: 0px;margin-top: 5px;margin-bottom: 10px">
		    	<label class="col-md-7" style="padding-top: 5px;padding-right: 0px; color: #4267b2;">Số điện thoại:</label>
		   		<input class="col-md-5 text-left" style="padding-top: 5px;padding:0px;border: none" type="text" onkeydown="setTimeout(myFunction, 0, this)" id="sdt" name="sdt" value="{{$user_profile->phonenumber!= '' ? $user_profile->phonenumber : 'Not Available'}}"" required />
		   </div>
			<div class="col-md-12" style="margin-bottom: 30px;margin-top: 10px">			
				<button type="submit" id="btnUpdate" class="col-md-6 btn btn-success update" style="float: right;">Cập Nhật</button>
			</div>
		</form>
	@else
		<form class="col-md-12" style="background-color: white;padding: 20px">
			<div class="col-md-12" style="padding-top: 8px">
				<span class = "glyphicon glyphicon-globe" style="color: blue">
				</span>
				<span style="font-size: 18px">Giới thiệu
				</span>		
			</div>
			<div class="col-md-12" style="padding: 0px;margin-top:20px ">
				<div class="glyphicon glyphicon-tower col-md-2" style="padding-right: 0px">
				</div>
				<div class = "col-md-10" style = "padding-left: 0px">Tên
					<a href="">{{$user_profile->name}}
					</a>
				</div>
			</div>
			<div class = "col-md-12" style="padding: 0px;margin-top:10px ">
				<div class="glyphicon glyphicon-home col-md-2" style="padding-right: 0px">
				</div>	
				<div class ="col-md-10" style = "padding-left: 0px">Đến từ
					<a href = "">{{$user_profile->address!= '' ? $user_profile->address : "No_Available"}}</a> 
				</div>
			</div>
			<div class="col-md-12" style="padding: 0px;margin-top:10px ">
				<div class="glyphicon glyphicon-earphone col-md-2" style="padding-right: 0px">
				</div>
				<div class="col-md-10" style = "padding-left: 0px">Số điện thoại
					<a href="">{{$user_profile->phonenumber!= '' ? $user_profile->phonenumber : "No_Available"}}</a>
				</div>
			</div>
			<div class="col-md-12" style="padding: 0px;margin-top:10px ">
				<div class="glyphicon glyphicon-star col-md-2" style="padding-right: 0px">
				</div>
				<div class="col-md-10" style = "padding-left: 0px">Theo dõi
					<a href="/friend/user={{$user_profile->id}}">{{count($follow_bb)}}</a>
				</div>
			</div>
			<div>
			</div>
		</form>
	@endif
	<script type="text/javascript">	
		function myFunction() {		
			var name = '{{$user_profile->name}}',
				email = '{{$user_profile->email}}',
				diachi = '{{$user_profile->address}}',
				sdt = '{{$user_profile->phonenumber}}';			
			if($('#name').val() == name && $('#email').val() == email && $('#diachi').val() == diachi && $('#sdt').val() == sdt)
		    	document.getElementById("btnUpdate").disabled = true;		    
		    else
		    	document.getElementById("btnUpdate").disabled = false;		    
		}

		function openAttach(){
			document.getElementById('picture').click();
		}
	</script>		
	<script type="text/javascript">
		$(document).ready(function(){			
			document.getElementById("btnUpdate").disabled = true;
			//onload file
			var fileCollection = new Array();
			$('#picture').on('change',function(e){

				var files = e.target.files;

				$.each(files, function(i, file){

					fileCollection.push(file);

					var reader = new FileReader();
					reader.readAsDataURL(file);
					reader.onload = function(e){
						var template = '<img src="'+e.target.result+'" height="60" width="60" onclick="openAttach()" style="margin-left: 80px;border-radius: 30px">';
						$('#avatar-to-upload').html(template);
					};

				});
			});

			$('#updateUser').validate({
				submitHandler: sumbmitformUpdate			
			});
			function sumbmitformUpdate(){
				var form = $('#updateUser')[0];
				var formData = new FormData(form);
				var id = {{$user->id}};				
				// var data = $("#updateUser").serialize();				
				$.ajax({
		            type : 'POST',
		            url  : 'update',
		            data: formData,
		            contentType: false,
    				processData: false,
		            success:  function(data)
		            {
		            	console.log(data);
		            	if (data.error == true) {
                            $('.error').hide();
                            if (data.message.name != undefined) {
                                $('.errorName').show().text(data.message.name[0]);
                            }                                                
                        } else {
                            alert("Cập Nhật Thành Công");  
		             		document.location = "user="+id;
                        }		            			             	
		            }
		        });		    
				return false;
			}
		});
	</script>

@endsection