<?php

namespace SimpleW;

class SimpleWFramework {
    public function run() {
        echo "\033[1;34mSetting up SimpleW PHP Framework...\033[0m\n";

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
        $appContent = "<?php\n\nnamespace SimpleW;\n\nclass App {\n    protected \$controller = 'HomeController';\n    protected \$method = 'index';\n    protected \$params = [];\n\n    public function __construct() {\n        \$url = \$this->parseUrl();\n\n        if (file_exists('../app/controllers/' . \$url[0] . '.php')) {\n            \$this->controller = \$url[0];\n            unset(\$url[0]);\n        }\n        \n        require_once '../app/controllers/' . \$this->controller . '.php';\n        \$this->controller = new \$this->controller;\n\n        if (isset(\$url[1]) && method_exists(\$this->controller, \$url[1])) {\n            \$this->method = \$url[1];\n            unset(\$url[1]);\n        }\n\n        \$this->params = \$url ? array_values(\$url) : [];\n        call_user_func_array([\$this->controller, \$this->method], \$this->params);\n    }\n\n    private function parseUrl() {\n        if (isset(\$_GET['url'])) {\n            return explode('/', filter_var(rtrim(\$_GET['url'], '/'), FILTER_SANITIZE_URL));\n        }\n        return ['HomeController'];\n    }\n}\n";
        file_put_contents('app/core/App.php', $appContent);
        echo "Created file: app/core/App.php\n";

        // Create index.php
        $indexContent = "<?php\nrequire_once '../app/core/App.php';\n\$app = new SimpleW\App();\n";
        file_put_contents('public/index.php', $indexContent);
        echo "Created file: public/index.php\n";

        // Create HomeController.php
        $controllerContent = "<?php\n\nnamespace SimpleW\Controllers;\n\nuse SimpleW\Core\Controller;\n\nclass HomeController extends Controller {\n    public function index() {\n        \$this->view('home', ['message' => 'Welcome to SimpleW PHP Framework!']);\n    }\n}\n";
        file_put_contents('app/controllers/HomeController.php', $controllerContent);
        echo "Created file: app/controllers/HomeController.php\n";

        // Create Controller.php
        $baseControllerContent = "<?php\n\nnamespace SimpleW\Core;\n\nclass Controller {\n    public function view(\$view, \$data = []) {\n        extract(\$data);\n        require_once \"../app/views/\$view.php\";\n    }\n}\n";
        file_put_contents('app/core/Controller.php', $baseControllerContent);
        echo "Created file: app/core/Controller.php\n";

        // Create home.php view
        $viewContent = "<!DOCTYPE html>\n<html>\n<head>\n    <title>SimpleW</title>\n</head>\n<body>\n    <h1><?= \$message; ?></h1>\n</body>\n</html>\n";
        file_put_contents('app/views/home.php', $viewContent);
        echo "Created file: app/views/home.php\n";

        // Create .htaccess
        $htaccessContent = "RewriteEngine On\nRewriteCond %{REQUEST_FILENAME} !-f\nRewriteCond %{REQUEST_FILENAME} !-d\nRewriteRule ^(.+)$ index.php?url=\$1 [QSA,L]\n";
        file_put_contents('public/.htaccess', $htaccessContent);
        echo "Created file: public/.htaccess\n";

        // Create composer.json
        $composerJsonContent = "{\n    \"name\": \"simplew/phpframework\",\n    \"description\": \"A simple PHP MVC framework.\",\n    \"autoload\": {\n        \"psr-4\": {\n            \"SimpleW\\\\\": \"app/\"\n        }\n    },\n    \"require\": {}\n}\n";
        file_put_contents('composer.json', $composerJsonContent);
        echo "Created file: composer.json\n";

        echo "\033[1;32mSimpleW PHP Framework setup complete! 🚀\033[0m\n";
        echo "\033[1;33mRun 'php -S localhost:8000 -t public' to start the development server.\033[0m\n";
        echo "\033[1;36mCredits: Windel Navales\033[0m\n";
    }
}


