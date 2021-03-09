<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Login</h3>
    </div>
    <div class="panel-body">
        <form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control">
            </div>
            <input type="submit" name="submit" class="btn btn-primary" value="Submit">
            <a class="btn btn-danger" href="<?php echo ROOT_URL; ?>shares">Cancel</a>
        </form>
    </div>
</div>