<?php

class Database
{
    private static $instance = null;
    private $pdo;

    private function __construct()
    {
        $env = Index::detectEnvironment();

        // Use the configuration based on the environment (from config.ini)
        if ($env === 'local') {
            $config = parse_ini_file(PROJECT_ROOT . 'Project1Working/app/config/config.ini', true);
        } else {
            $configPath = dirname(__DIR__, 2) . '/app/config/config.ini';
            $config = parse_ini_file($configPath, true);
        }
        $dbConfig = $config[$env];

        $dsn = "mysql:host=" . $dbConfig['db_host'] . ";dbname=" . $dbConfig['db_name'];
        $username = $dbConfig['db_user'];
        $password = $dbConfig['db_pass'];

        try {
            $this->pdo = new PDO($dsn, $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Database connection failed: ' . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection()
    {
        return $this->pdo;
    }
}
