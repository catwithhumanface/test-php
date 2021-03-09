<?php

class Blog extends Controller
{
    protected function Index()
    {
        $viewmodel = new BlogModel();
        $this->ReturnView($viewmodel->Index(), true);
    }

    protected function add()
    {
        if (!isset($_SESSION['is_logged_in'])) {
            header('Location: ' . ROOT_URL . 'shares');
        }
        $viewmodel = new BlogModel();
        $this->ReturnView($viewmodel->add(), true);
    }
}