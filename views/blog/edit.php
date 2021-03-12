<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">New blog post</h3>
  </div>
  <div class="panel-body">
  	<form method="post" action="editSubmit">
  		<div class="form-group">
		  	<input type="hidden" name="id_blog" value="<?php echo $view_model['id_blog']?>" class="form-control" >
  			<label>Title</label>
  			<input type="text" name="title" value="<?php echo $view_model['title']?>" class="form-control"required>
  		</div>
  		<div class="form-group">
  			<label>Body</label>
  			<textarea name="body" class="form-control" required><?php echo $view_model['body']?></textarea>
  		</div>
  		<div class="form-group">
  			<label>Link</label>
  			<input type="url" name="link" value="<?php echo $view_model['link']?>" class="form-control"required>
  		</div>
  		<input type="submit" name="submit" class="btn btn-primary" value="Submit">
  		<a class="btn btn-danger" href="<?php echo ROOT_URL; ?>shares">Cancel</a>
  	</form>
  </div>
</div>