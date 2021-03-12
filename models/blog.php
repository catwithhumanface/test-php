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
        // Sanitize Post
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if ($post['submit']) {
            if ($post['title'] == '' || $post['body'] == '' || $post['link'] == '') {
                Messages::setMsg('Please complete all fields', 'error');
                return;
            }
            // Get id_user from Session, user_data
            $iduserStr =  $_SESSION['user_data']['id_user'];
            $iduser = (int)$iduserStr;
            // Insert into MySQL
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
            }



            




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
        // Sanitize Post
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if ($post['submit']) {
            if ($post['title'] == '' || $post['body'] == '' || $post['link'] == '') {
               header('location:'.$_SERVER['HTTP_REFERER']);
               return;
            }
            // Get id_user from Session, user_data
            $iduserStr =  $_SESSION['user_data']['id_user'];
            $iduser = (int)$iduserStr;
            // Insert into MySQL
            //
            $this->query('UPDATE blog SET title=:title, body=:body, link=:link, id_user=:id_user WHERE id_blog=:id_blog');
            $this->bind(':title', $post['title']);
            $this->bind(':body', $post['body']);
            $this->bind(':link', $post['link']);
            $this->bind(':id_blog', $post['id_blog']);
            $this->bind(':id_user', $iduser );
            try{
                $this->execute();
                header('Location: ' . ROOT_URL . 'blog');
            }catch(Exception $e){
                header('location:'.$_SERVER['HTTP_REFERER']);
            }
           
        }
    }


}