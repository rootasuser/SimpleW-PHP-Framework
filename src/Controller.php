<?php

namespace SimpleW;

class Controller
{
    protected function view($viewPath, $data = [])
    {
        extract($data);
        require __DIR__."/../../app/views/{$viewPath}.php";
    }
}