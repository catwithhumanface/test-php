<?php

class BlogModel extends Model
{
    
    public function Index($currentPage)
    {
        $_SESSION['page'] = $currentPage;
        // 5 posts per page
        $items_per_page = 5;
        $offset = ($currentPage -1) * $items_per_page;

         //get totalCount
        $this->query('SELECT * FROM blog ORDER BY create_date DESC');
        $rows = $this->resultSet();
        $totalCount = sizeof($rows);
        $_SESSION['totalCount'] = $totalCount;
        $_SESSION['items_per_page'] = $items_per_page;

        $this->query('SELECT * FROM blog ORDER BY create_date DESC LIMIT ' . $offset . ',' . $items_per_page );
        $rows = $this->resultSet();
        return $rows;
    }
   
    public function add()
    {
        // Get id_user from Session, user_data
        $iduserStr =  $_SESSION['user_data']['id_user'];
        $iduser = (int)$iduserStr;

        // Sanitize Post
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if ($post['submit']) {
            if ($post['title'] == '' || $post['body'] == '' || $post['link'] == '') {
                Messages::setMsg('Please complete all fields', 'error');
                return;
            }
            if (isset($_FILES['uploadedFile']) && $_FILES['uploadedFile']['error'] === UPLOAD_ERR_OK){
                $dest_path = $this->fileupload($post);
                $this->query('INSERT INTO blog(title, body, link, id_user, imgurl) VALUES(:title, :body, :link, :id_user, :imgurl)');
                $this->bind(':title', $post['title']);
                $this->bind(':body', $post['body']);
                $this->bind(':link', $post['link']);
                $this->bind(':id_user', $iduser );
                $this->bind(':imgurl', $dest_path );
                $this->execute();

                 // Verify
                 if ($this->lastInsertId()) {
                    // Redirect
                    header('Location: ' . ROOT_URL . 'blog');
                }else{
                    $_SESSION['alertMessage'] = 'Upload failed. Please try again';
                    return;
                }

            }else{
                // Insert into table blog when there is no image to upload
                $this->query('INSERT INTO blog(title, body, link, id_user) VALUES(:title, :body, :link, :id_user)');
                $this->bind(':title', $post['title']);
                $this->bind(':body', $post['body']);
                $this->bind(':link', $post['link']);
                $this->bind(':id_user', $iduser );
                $this->execute();

                // Verify
                if ($this->lastInsertId()) {
                    // Redirect
                    header('Location: ' . ROOT_URL . 'blog');
                }else{
                    $_SESSION['alertMessage'] = 'Upload failed. Please try again';
                    return;
                }
            }
        }
    }

    public function fileupload($post){
        // get details of the uploaded file
        $fileTmpPath = $_FILES['uploadedFile']['tmp_name'];
        $fileName = $_FILES['uploadedFile']['name'];
        $fileSize = $_FILES['uploadedFile']['size'];
        $fileType = $_FILES['uploadedFile']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // sanitize file-name
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
       
        // check if file has one of the following extensions, only image file accepted
        $allowedfileExtensions = array('jpg', 'gif', 'png', 'jpeg');

        if (in_array($fileExtension, $allowedfileExtensions)){
          
            // directory in which the uploaded file will be moved
            $uploadFileDir = './uploaded_files/';
            //$uploadFileDir= realpath("/uploaded_files/readme.txt");
            $dest_path = $uploadFileDir . $newFileName;
            if(move_uploaded_file($fileTmpPath, $dest_path)){
                // Return the path of file to put on DB
                return $dest_path;

            }else{
                $_SESSION['alertMessage'] = 'There was some error moving the file to upload directory. Please make sure the upload directory is writable by web server.';
                header('Location: ' . ROOT_URL. 'blog');
                $this->index();
            }
        }else{
            $_SESSION['alertMessage'] = 'Upload failed. Allowed file types: ' . implode(',', $allowedfileExtensions);
            header('Location: ' . ROOT_URL. 'blog');
            $this->index();
        }
  }

    public function edit($id_blog)
    {
        $this->query('SELECT * FROM blog where id_blog='.$id_blog);
        $rows = $this->single();
        return $rows;
    }

    public function editSubmit()
    {
        // Get id_user from Session, user_data
        $iduserStr =  $_SESSION['user_data']['id_user'];
        $iduser = (int)$iduserStr;

        // Sanitize Post
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if ($post['submit']) {
            if ($post['title'] == '' || $post['body'] == '' || $post['link'] == '') {
               header('location:'.$_SERVER['HTTP_REFERER']);
               return;
            }
            // file upload if exists
            if (isset($_FILES['uploadedFile']) && $_FILES['uploadedFile']['error'] === UPLOAD_ERR_OK){
               
                
                // Verify if there was a photo attached before
                // If exists, delete it
                $this->query('SELECT imgurl from blog where id_blog='.$post['id_blog']);
                $rows = $this->single();
                if($rows != NULL){
                    unlink($_SERVER['DOCUMENT_ROOT'] . $rows['imgurl']);
                }

                $dest_path = $this->fileupload($post);
                // Update the blog post
                $this->query('UPDATE blog SET title=:title, body=:body, link=:link, imgurl=:imgurl WHERE id_blog=:id_blog');
                $this->bind(':title', $post['title']);
                $this->bind(':body', $post['body']);
                $this->bind(':link', $post['link']);
                $this->bind(':imgurl', $dest_path );
                $this->bind(':id_blog', $post['id_blog']);
                try{
                    $this->execute();
                    header('Location: ' . ROOT_URL. 'blog');
                }catch(Exception $e){
                    $_SESSION['alertMessage'] = 'Failed to add a post.';
                    header('Location: ' . ROOT_URL. 'blog');
                }
                
            // Update the blog post when there is no image to update
            }else{
                $this->query('UPDATE blog SET title=:title, body=:body, link=:link WHERE id_blog=:id_blog');
                $this->bind(':title', $post['title']);
                $this->bind(':body', $post['body']);
                $this->bind(':link', $post['link']);
                $this->bind(':id_blog', $post['id_blog']);
                try{
                    $this->execute();
                    header('Location: ' . ROOT_URL. 'blog');
                }catch(Exception $e){
                    $_SESSION['alertMessage'] = 'Failed to add a post.';
                    header('Location: ' . ROOT_URL. 'blog');
                }
            }
           
        }   
    }

}