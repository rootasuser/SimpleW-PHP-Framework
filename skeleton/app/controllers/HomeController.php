<?php

class HomeController extends SimpleW\Controller
{
    public function index()
    {
        return $this->view('home/index', ['title' => 'Welcome']);
    }
}