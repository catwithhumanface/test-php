<div>
    <?php if (isset($_SESSION['is_logged_in'])) : 
        $pageCount =1;
        $iduserStr =  $_SESSION['user_data']['id_user'];
        $iduser = (int)$iduserStr;?>
        <a class="btn btn-success btn-share" href="<?php echo ROOT_URL; ?>blog/add">Add a blog post</a>
    <?php endif; ?>
    <?php
        if(isset($_SESSION['page'])){
            $page = $_SESSION['page'];
        }else{
            $page = 1;
        }
        if (isset($_SESSION['totalCount']) || isset($_SESSION['items_per_page'])) :
            if ($_SESSION['totalCount'] === 0){
                // no posts
            }else{
                $totalCount = $_SESSION['totalCount'];
                $items_per_page =$_SESSION['items_per_page'];
                $pageCount = (int)ceil($totalCount/$items_per_page);
                if($page > $pageCount) {
                    // error to user, set page to 1
                    $page = 1;
                }
            }
        endif;
    ?>
    <?php foreach ($view_model as $item) : ?>
        <div class="well">
            <h3><?php echo $item['title']; ?></h3>
            <small><?php echo $item['create_date']; ?></small>
            <hr>
            <p><?php echo $item['body']; ?></p>
            <br>
            <img id="thumbnail" style="max-width:50%; max-height:50%; margin-bottom:30px;" src="<?php echo $item['imgurl']; ?>"/>
            <br>
            <a class="btn btn-default" href="<?php echo $item['link']; ?>" target="_blank">Go To Website</a>
        <!-- Possible to edit if it's the user's post !-->
        <?php if (isset($_SESSION['is_logged_in'])) : 
            if($iduser==$item['id_user']){?>
            <a class="btn btn-default" href="blog/edit?id_blog=<?php echo $item['id_blog']?>" target="_blank">Edit My Post</a>
         <?php } endif; ?>
        </div>
    <?php endforeach; ?>
    <ul class ="pagination">
        <?php for ($i=1; $i<= $pageCount; $i++) {?>
            <li class="page-item <?= ($page == $i) ? "active" : "" ?>">
                    <a href="blog?id=<?= $i ?>" class="page-link"><?= $i ?></a>
            </li>
        <?php } ?>
    </ul>
        

</div>

<?php
    if(isset($_SESSION['alertMessage'])){
        echo "<script type='text/javascript'>
        alert('" . $_SESSION['alertMessage'] . "');
        </script>";
        //to not make the error message appear again after refresh:
        unset($_SESSION['alertMessage']);
    }
 ?>