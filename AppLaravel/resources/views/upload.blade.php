<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<div class="container">
		<h1>Image Uploader</h1>

		<input type="file" name="images[]" id="images" multiple>
		<hr>
		<div id="images-to-upload">

		</div><!-- end #images-to-upload -->

		<hr>
		<a href="#" class="btn btn-sm btn-success">Upload all images</a>
</div><!-- end .container -->
<script type="text/javascript">
	var fileCollection = new Array();
		$('#images').on('change',function(e){

			var files = e.target.files;

			$.each(files, function(i, file){

				fileCollection.push(file);

				var reader = new FileReader();
				reader.readAsDataURL(file);
				reader.onload = function(e){

					var template = '<form action="/upload">'+
						'<img src="'+e.target.result+'"> '+
						'<label>Image Title</label> <input type="text" name="title">'+
						' <button class="btn btn-sm btn-info upload">Upload</button>'+
						' <a href="#" class="btn btn-sm btn-danger remove">Remove</a>'+
					'</form>';

					$('#images-to-upload').append(template);
				};

			});

		});
</script>