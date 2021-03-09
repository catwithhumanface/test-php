<div>
    <?php if (isset($_SESSION['is_logged_in'])) : ?>
        <a class="btn btn-success btn-share" href="<?php echo ROOT_URL; ?>blog/add">Add a blog post</a>
    <?php endif; ?>
    <?php foreach ($view_model as $item) : ?>
        <div class="well">
            <h3><?php echo $item['title']; ?></h3>
            <small><?php echo $item['create_date']; ?></small>
            <hr>
            <p><?php echo $item['body']; ?></p>
            <br>
            <a class="btn btn-default" href="<?php echo $item['link']; ?>" target="_blank">Go To Website</a>
        </div>
    <?php endforeach; ?>
</div>