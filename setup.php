<?php

echo "Setting up SimpleW PHP Framework...\n";

// Define folders to create
$folders = [
    'app/controllers',
    'app/core',
    'app/models',
    'app/views',
    'config',
    'public',
    'routes'
];

// Create folders
foreach ($folders as $folder) {
    if (!is_dir($folder)) {
        mkdir($folder, 0777, true);
        echo "Created folder: $folder\n";
    }
}

// Create core App.php
$appContent = <<<PHP
<?php

namespace SimpleW;

class App {
    protected \$controller = 'HomeController';
    protected \$method = 'index';
    protected \$params = [];

    public function __construct() {
        \$url = \$this->parseUrl();

        // Load controller
        if (file_exists('../app/controllers/' . \$url[0] . '.php')) {
            \$this->controller = \$url[0];
            unset(\$url[0]);
        }
        
        require_once '../app/controllers/' . \$this->controller . '.php';
        \$this->controller = new \$this->controller;
        
        // Load method
        if (isset(\$url[1]) && method_exists(\$this->controller, \$url[1])) {
            \$this->method = \$url[1];
            unset(\$url[1]);
        }

        \$this->params = \$url ? array_values(\$url) : [];
        
        // Call the controller method
        call_user_func_array([\$this->controller, \$this->method], \$this->params);
    }

    private function parseUrl() {
        if (isset(\$_GET['url'])) {
            return explode('/', filter_var(rtrim(\$_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
        return ['HomeController'];
    }
}

// Autoloader
spl_autoload_register(function (\$class) {
    \$file = '../app/core/' . \$class . '.php';
    if (file_exists(\$file)) {
        require_once \$file;
    }
});

PHP;

file_put_contents('app/core/App.php', $appContent);
echo "Created file: app/core/App.php\n";

// Create index.php
$indexContent = <<<PHP
<?php
require_once '../app/core/App.php';
\$app = new SimpleW\App();
PHP;

file_put_contents('public/index.php', $indexContent);
echo "Created file: public/index.php\n";

// Create HomeController.php
$controllerContent = <<<PHP
<?php

namespace SimpleW\Controllers;

use SimpleW\Core\Controller;

class HomeController extends Controller {
    public function index() {
        \$this->view('home', ['message' => 'Welcome to SimpleW PHP Framework!']);
    }
}
PHP;

file_put_contents('app/controllers/HomeController.php', $controllerContent);
echo "Created file: app/controllers/HomeController.php\n";

// Create Controller.php
$baseControllerContent = <<<PHP
<?php

namespace SimpleW\Core;

class Controller {
    public function view(\$view, \$data = []) {
        extract(\$data);
        require_once "../app/views/\$view.php";
    }
}
PHP;

file_put_contents('app/core/Controller.php', $baseControllerContent);
echo "Created file: app/core/Controller.php\n";

// Create home.php view
$viewContent = <<<HTML
<!DOCTYPE html>
<html>
<head>
    <title>SimpleW</title>
</head>
<body>
    <h1><?= \$message; ?></h1>
</body>
</html>
HTML;

file_put_contents('app/views/home.php', $viewContent);
echo "Created file: app/views/home.php\n";

// Create .htaccess
$htaccessContent = <<<HTACCESS
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.+)$ index.php?url=$1 [QSA,L]
HTACCESS;

file_put_contents('public/.htaccess', $htaccessContent);
echo "Created file: public/.htaccess\n";

// Create composer.json
$composerJsonContent = <<<JSON
{
    "name": "simplew/phpframework",
    "description": "A simple PHP MVC framework.",
    "autoload": {
        "psr-4": {
            "SimpleW\\\\": "app/"
        }
    },
    "require": {}
}
JSON;

file_put_contents('composer.json', $composerJsonContent);
echo "Created file: composer.json\n";

echo "SimpleW PHP Framework setup complete! 🚀\n";
echo "Run 'php -S localhost:8000 -t public' to start the development server.\n";
