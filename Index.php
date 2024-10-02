<?php

final class Index
{
    public static function run()
    {
        self::init();
        self::handle();
    }

    private static function init()
    {
        error_reporting(E_ERROR);
        spl_autoload_register(['Index', 'loadClass']);

        // Detect environment (local or production)
        $env = self::detectEnvironment();

        define('PROJECT_ROOT', $_SERVER['DOCUMENT_ROOT'] . '/');

        // Load configuration based on environment
        $config = parse_ini_file(PROJECT_ROOT . 'config.ini', true);
        $envConfig = $config[$env];

        define('PROJECT_URL', 'https://' . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\'));
        define('BASE_PATH', rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\'));
        define('TITLE', 'Project 1 - Franko');
    }

    public static function detectEnvironment()
    {
        // Use server host to determine environment
        if ($_SERVER['HTTP_HOST'] == 'localhost') {
            return 'local';
        } else {
            return 'production';
        }
    }

    private static function handle()
    {
        $url = isset($_GET['url']) ? $_GET['url'] : '';

        // Start with empty controller and action
        $controller = '';
        $action = '';
        $params = [];

        if ($url) {
            // Split the URL by slashes
            $urlParts = explode('/', trim($url, '/'));

            // Get controller and action from the URL, if available
            if (isset($urlParts[0])) {
                $controller = $urlParts[0];
            }
            if (isset($urlParts[1])) {
                $action = $urlParts[1];
            }

            // Any additional parts in the URL are considered parameters
            $params = array_slice($urlParts, 2);
        }

        // If the controller and action are still empty, redirect to the login page
        if (empty($controller) && empty($action)) {
            $controller = 'user';
            $action = 'login';
        }

        // Pass the controller, action, and params to the Router
        $router = new Router();
        $router->dispatch($controller, $action, $params);
    }

    private static function loadClass($class_name)
    {
        $dirs = array(
            'app/',
            'app/router/',
            'app/model/',
            'app/view/',
            'app/controller/',
            'app/db/',
            'app/session/'
        );
        foreach ($dirs as $dir) {
            if (file_exists($dir . $class_name . '.php')) {
                require_once($dir . $class_name . '.php');
                return true;
            }
        }
        return false;
    }
}

Index::run();
