<?php

namespace SimpleW\Controllers; // ✅ Correct namespace

use SimpleW\Core\Controller; // ✅ Import base controller

class HomeController extends Controller {
    public function index() {
        echo "Welcome to SimpleW PHP Framework!";
    }
}
