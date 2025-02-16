<?php

namespace SimpleW\Controllers;

use SimpleW\Core\Controller;

class HomeController extends Controller {
    public function index() {
        $this->view('home', ['message' => 'Welcome to SimpleW PHP Framework!']);
    }
}