<!DOCTYPE html>
<html>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.js" type="text/javascript"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js" type="text/javascript"></script>
<script src="http://ajax.microsoft.com/ajax/jquery.validate/1.7/jquery.validate.js" type="text/javascript"></script>

<meta name="csrf-token" content="<?= csrf_token() ?>">

<style> 
     .myErrors {
        color: red;
        font-size: 20px;
        font-family: "Times New Roman";
     }
     label{
         margin-left: 50px;
     }
     body { 
        background: url('image/go.jpg') no-repeat center center fixed;
        -moz-background-size: cover;
        -webkit-background-size: cover;
        -o-background-size: cover;
        background-size: cover;;    
    }
     .formlogin {
        position:fixed;
        top: 45%;
        left: 45%;
        width:600px;
        height:auto;
        margin-top: -9em; /*set to a negative number 1/2 of your height*/
        margin-left: -15em; /*set to a negative number 1/2 of your width*/
        border: 1px solid #ccc;
        background-color: #f3f3f3;
    }
</style> 

<body>
    <div class="col-md-12" style="margin-top: 50px;">
        <div class="col-md-11">
            <a href="#" class="col-md-1 btn btn-primary" style="float: right; padding: 10px"> ShowUsers</a>
            <a href="{{asset('signup')}}" class="col-md-1 btn btn-danger" style="float: right; padding: 10px;margin-right: 10px;" >Đăng Ký</a>            
            <a href="{{asset('login')}}" class="col-md-1 btn btn-success" style="float: right; margin-right: 10px;padding: 10px" >Đăng Nhập</a>            
        </div>
    </div>    
	<div class="col-md-5 col-sm-4 formlogin" >
	    <div class="col-md-12 col-sm-12" style="margin-top: 20px">
	        <h2 class="modal-title text-center">Đăng Nhập Hệ Thống</h2>
	    </div>
	     <div class="col-md-12 col-sm-12">            
            <form id="login" method="post"">
            	<input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div id="errorLogin"></div>
                <div class="col-md-12 col-sm-12">
                    <input class="col-md-12 col-sm-12 username" style="margin-top: 20px;padding: 20px" type="text" name="acclogin" placeholder="Email or Username" >
                    <div class="myErrors"></div>
                </div>
                <div class="col-md-12 col-sm-12">
                    <input class="col-md-12 col-sm-12 username" style="margin-top: 20px;padding: 20px" type="text" name="acclogin" placeholder="Email or Username" >
                    <div class="myErrors"></div>
                </div>
                <div class="col-md-12">
                    <input class="col-md-12 col-sm-12 password" style="margin-top: 20px;padding: 20px" type="password" name="passlogin" placeholder="Password">
                    <div class="myErrors"></div>
                </div>
                <div class="col-md-12">
                    <input type="submit" class="col-md-12 col-sm-12 btn btn-success" style="margin-top: 20px;margin-bottom: 40px;padding: 20px" value="Đăng Nhập" name="login">
                </div>
            </form>       
	    </div>
    </div>
</body>
<script type="text/javascript" >
$(document).ready(function() {      
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
     $("#login").validate({
        rules: {
            acclogin: {
                required: true
            },
            passlogin:{
                required: true,
            }
        },
        messages:{
            acclogin:{
                required:"Vui lòng nhập tài khoản"
            },
            passlogin:{
                required: "Vui lòng nhập mật khẩu"
            }
        },
        submitHandler: submitFormLogin
    });
    function submitFormLogin(){
        $.ajax({
            type : 'POST',
            url  : 'home',
            data : {name: $('.username').val(),password:$('.password').val()},
            success:  function(data)
            {
                if(data == "failed"){
                    $("#errorLogin").fadeIn(1000, function(){
                        $("#errorLogin").html('<div class="alert alert-danger text-left" style="margin: 10px 50px 0px 50px"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; Tên tài khoản hoặc mật khẩu không chính xác !</div>');
                    });
                }else{
                    window.location="/home";
                }
            }
        });
        return false;
    }
});
</script>
</html>