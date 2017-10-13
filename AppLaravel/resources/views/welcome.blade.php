<!DOCTYPE html>
<html>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<style type="text/css">
	body { 
	    background: url('image/go.jpg') no-repeat center center fixed;
        -moz-background-size: cover;
        -webkit-background-size: cover;
        -o-background-size: cover;
        background-size: cover;;	
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
</body>
</html>