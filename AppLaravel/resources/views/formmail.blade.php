@if($type == 1)		
	<h2>{{$name}}</h2><h4> Đã bình luận bài viết của bạn</h4>
	<a href="http://localhost/status={{$id_status}}">Nhấp vào đây</a>
@else
	<h2>{{$name}} </h2><h4> Thích bài viết của bạn</h4>
	<a href="http://localhost/status={{$id_status}}">Nhấp vào đây</a>
@endif
