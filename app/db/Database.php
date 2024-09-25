<?php

class Database
{
    private static $instance = null;
    private $pdo;

    private function __construct()
    {
        // Hardcode the database connection details
        $dsn = "mysql:host=localhost;dbname=ff1574";
        $username = "root";
        $password = "";

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
