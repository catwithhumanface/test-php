<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">New blog post</h3>
  </div>
  <div class="panel-body">
  	<form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
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
  		<input type="submit" name="submit" class="btn btn-primary" value="Submit">
  		<a class="btn btn-danger" href="<?php echo ROOT_URL; ?>shares">Cancel</a>
  	</form>
  </div>
</div>