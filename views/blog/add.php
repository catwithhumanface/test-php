
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">New blog post</h3>
  </div>
  <div class="panel-body">
  	<form method="post" action="<?php $_SERVER['PHP_SELF']; ?>"enctype="multipart/form-data">
  		<div class="form-group">
  			<label>Title</label>
  			<input type="text" name="title" class="form-control">
  		</div>
  		<div class="form-group">
  			<label>Body</label>
  			<textarea name="body" class="form-control"></textarea>
  		</div>
  		<div class="form-group">
  			<label>Link</label>
  			<input type="url" name="link" class="form-control">
  		</div>
		<div class="form-group">
			<label>Photo</label>
		  <input type="file" name="uploadedFile" id="uploadedFile" class="form-control" onchange="preview()">
		  <img id="thumbnail" style="max-width:50%; max-height:50%; margin-bottom:30px; margin-top:10px;" src="" />
		</div>

  		<input type="submit" name="submit" class="btn btn-primary" value="Submit">
  		<a class="btn btn-danger" href="<?php echo ROOT_URL; ?>blog">Cancel</a>
  	</form>
  </div>
</div>
<!--preview image to be uploaded-->
<script type='text/javascript'>
	function preview() {
		thumbnail.src=URL.createObjectURL(event.target.files[0]);
	}
</script>

<?php
    if(isset($_SESSION['alertMessage'])){
        echo "<script type='text/javascript'>
        alert('" . $_SESSION['alertMessage'] . "');
        </script>";
        //to not make the error message appear again after refresh:
        unset($_SESSION['alertMessage']);
    }
 ?>
 
