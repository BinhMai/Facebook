<!DOCTYPE html>
<html>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.js" type="text/javascript"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js" type="text/javascript"></script>
<script src="http://ajax.microsoft.com/ajax/jquery.validate/1.7/jquery.validate.js" type="text/javascript"></script>

<meta name="csrf-token" content="<?= csrf_token() ?>">
<style type="text/css">
    body { 
        background: url('image/go.jpg') no-repeat center center fixed;
        -moz-background-size: cover;
        -webkit-background-size: cover;
        -o-background-size: cover;
        background-size: cover;;    
    }
    .formSignup {
        margin-top: 10em;
        border: 1px solid #ccc;
        background-color: #f3f3f3;
    }
</style>

<body>
  <div class="col-md-12 col-xs-12 col-sm-12" style="margin-top: 50px;">
        <div class="col-md-11">
            <a href="#" class="col-md-1 btn btn-primary" style="float: right; padding: 10px"> ShowUsers</a>
            <a href="{{asset('signup')}}" class="col-md-1 btn btn-danger" style="float: right; padding: 10px;margin-right: 10px;" >Đăng Ký</a>            
            <a href="{{asset('login')}}" class="col-md-1 btn btn-success" style="float: right; margin-right: 10px;padding: 10px" >Đăng Nhập</a>            
        </div>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-2"></div>
    <div class="col-md-6 col-sm-6 col-xs-8 formSignup">
        <div class="col-md-12 col-xs-12" style="margin-top: 20px">
            <h2 class="modal-title text-center">Đăng Ký Tài Khoản</h2>
        </div>
         <div class="col-md-12 col-xs-12">            
            <form id="signup" method="POST" role="form">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                
                <div class="col-md-12 col-xs-12">                    
                    <input class="col-md-12 col-xs-12" style="margin-top: 20px;padding: 20px" type="text" name="name"  placeholder="Username">           
                    <p style="color:red; display: none;" class="col-md-12 error errorName"></p>         
                </div>
                <div class="col-md-12">                    
                    <input class="col-md-12 col-xs-12" style="margin-top: 20px;padding: 20px" type="text" name="email" placeholder="Email">         
                    <p style="color:red; display: none;" class="col-md-12 error errorEmail"></p>       
                </div>
                <div class="col-md-12">                    
                    <input class="col-md-12 col-xs-12" style="margin-top: 20px;padding: 20px" type="password" name="pass" placeholder="Password">         
                    <p style="color:red; display: none;" class="col-md-12 error errorPass"></p>       
                </div>
                <div class="col-md-12">                    
                    <input class="col-md-12 col-xs-12" style="margin-top: 20px;padding: 20px" type="password" name="repass" placeholder="Recofirm Password">
                    <p style="color:red; display: none;" class="col-md-12 error errorRePass"></p>
                </div>
                <div class="col-md-12">
                    <input type="submit" class="col-md-12 col-xs-12 btn btn-danger" id="dang-ky" style="margin-top: 20px;margin-bottom: 40px;padding: 20px" value="Đăng Ký" >                    
                </div>
            </form>       
        </div>
    </div>
    <script type="text/javascript" >
        $(document).ready(function() {  
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#dang-ky').click(function(e) {
                e.preventDefault();
                var data = $("#signup").serialize();
                $.ajax({
                    url : 'signup',
                    type : 'POST',
                    data: data,
                    success: function (data) {
                        console.log(data);
                        if (data.error == true) {
                            $('.error').hide();
                            if (data.message.name != undefined) {
                                $('.errorName').show().text(data.message.name[0]);
                            }                    
                            if (data.message.email != undefined) {
                                $('.errorEmail').show().text(data.message.email[0]);
                            }                    
                            if (data.message.repass != undefined) {
                                $('.errorRePass').show().text(data.message.repass[0]);
                            }
                            if (data.message.pass != undefined) {
                                $('.errorPass').show().text(data.message.pass[0]);
                            }
                        }else {
                            window.location = "/";
                        }
                    }
                });
            })
        });
    </script>
</body>
</html>