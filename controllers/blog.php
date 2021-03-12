<?php

class Blog extends Controller
{
    protected function Index()
    {   
        if(isset($_GET["id"]) && !empty($_GET["id"])){
            $currentPage = (int) $_GET["id"];
        }else{
            $currentPage = 1;
        }
        $viewmodel = new BlogModel();
        $this->ReturnView($viewmodel->Index($currentPage), true);
    }
    
    
    protected function add()
    {
        if (!isset($_SESSION['is_logged_in'])) {
            header('Location: ' . ROOT_URL . 'shares');
        }
        $viewmodel = new BlogModel();
        $this->ReturnView($viewmodel->add(), true);
    }

    protected function edit()
    {
        if (!isset($_SESSION['is_logged_in'])) {
            header('Location: ' . ROOT_URL . 'shares');
        }
        if(isset($_GET["id_blog"]) && !empty($_GET["id_blog"])){
            $id_blog = (int) $_GET["id_blog"];
        }
        $viewmodel = new BlogModel();
        $this->ReturnView($viewmodel->edit($id_blog), true);
    }

    protected function editSubmit()
    {
        if (!isset($_SESSION['is_logged_in'])) {
            header('Location: ' . ROOT_URL . 'shares');
        }
        $viewmodel = new BlogModel();
        $this->ReturnView($viewmodel->editsubmit(), true);
    }
}