<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<style>
	body{
		background: #e9ebee;
	}
	.menu{
		margin-top: 15px;
		margin-left: 30px;
		padding:0px;
	}
	.content{
		background: white;
		margin-top: 0px;
		float: right;
		position:fixed;
        top: 10%;
		left: 22%;
        bottom: 0%;        
        height:auto;
	}	
	.listStudent{
		background: #e9ebee;
	}
	.menustudent{
		padding-right: 0px;
	}
	.menusearch{
		padding: 5px;
	}
	a{
		color: red;
	}
	.titleStudent{
		background-color: #4080ff;
		padding: 4px;
	}
	.row{
		background-color: #C9E4D6;
	}
</style>
<body>

<header>
	<nav class="navbar navbar-default" style="margin-bottom: 0px">
	  <div class="container-fluid">    
		<ul class="nav navbar-nav">
		  <li><a href="#">Home</a></li>
		  <li><a href="#">Admin</a></li>
		  <li><a href="#">Student Management</a></li>
		  <li><a href="#">Lead Management</a></li>
		  <li><a href="#">Report</a></li>
		  <li><a href="#">Logout</a></li>
		  <li><a href="#">Help</a></li>
		</ul>
	  </div>
	</nav>
 </header>
 <section>
	<div class="col-md-2 menu">		
		 <ul class="list-group">
			 <li class="list-group-item active">Student List</li>
			 <li class="list-group-item">Course Learning</li>
			 <li class="list-group-item">Free Learning</li>
			 <li class="list-group-item">Register Absence</li>
			 <li class="list-group-item">Quick Payment</li>
		</ul>
	</div>
	<div class="col-md-9 content">
		<h2 style="color: red; margin-left: 30px">Students</h2>
		<div class="col-md-12">
			<div class="col-md-12 menustudent">
				<button class="col-md-1 btn btn-success" style="float: right"> Add New</button>
			</div>
			<div class="col-md-12 listStudent">
				<div class="col-md-12 menusearch">
					<form class="col-md-5" id="search" style="padding-right: 0px" method="POST">				
						<input class="col-md-10" style="border:0px;padding: 5px;margin-top: 3px" type="text" name="search" placeholder="Tìm kiếm">
						<button type="submit" class="col-md-1 btn btn-default" style="border: 0px;padding: 5px;margin-top: 3px;background-color: #DDDDDD;border-radius: 0px">
							<span class="glyphicon glyphicon-search"></span>
						</button>								
					</form>
					<button type="submit" class="col-md-1 btn btn-default">Show All</button>			
				</div>								
				<div class="col-md-12 namesearch" style="display: inline">					
					 <a href="#">A</a>					  
					 <a href="#">B</a>
					 <a href="#">C</a>
					 <a href="#">D</a>
					 <a href="#">E</a>
					 <a href="#">F</a>
					 <a href="#">H</a>
					 <a href="#">J</a>
					 <a href="#">K</a>
					 <a href="#">L</a>
					 <a href="#">M</a>
					 <a href="#">O</a>
					 <a href="#">P</a>
					 <a href="#">R</a>
					 <a href="#">S</a>
					 <a href="#">T</a>
					 <a href="#">U</a>
					 <a href="#">V</a>
					 <a href="#">W</a>
					 <a href="#">X</a>
					 <a href="#">Y</a>
					 <a href="#">Z</a>
					 <a href="#">All</a>
				</div>				
			</div>						
			<div class="col-md-12 text-left titleStudent">
				<p class="col-md-1">ID</p>
				<p class="col-md-2">Name</p>
				<p class="col-md-2">Birthday</p>
				<p class="col-md-4">Address</p>
				<p class="col-md-3">Email</p>
			</div>
			<div class="col-md-12 text-left contentStudent">
				<div class="row" style="padding: 4px">
					<p class="col-md-1">14000065</p>
					<p class="col-md-2">Hoàng Xuân Bình</p>
					<p class="col-md-2">31/10/1996</p>
					<p class="col-md-4">Nam Tiến-Nam Trực-Nam Định</p>
					<p class="col-md-3">hoangxuanbinh_t59@hus.edu.vn</p>
				</div>
			</div>
		</div>		
	</div>
 </section>
</body>
</html>
