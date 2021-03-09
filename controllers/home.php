<?php

class Home extends Controller
{
    protected function Index()
    {
        $view_model = new HomeModel();
        $this->ReturnView($view_model->Index(), true);
    }
}