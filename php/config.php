<?php
class Config {
    private static $instance = null;
    private $pdo;

    private function __construct() {
        $host = 'localhost';
        $db = 'leads_management';
        $user = 'root';
        $pass = '';
        $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            $this->pdo = new PDO($dsn, $user, $pass, $options);
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    public static function getInstance() {
        if (self::$instance === null) self::$instance = new self();
        return self::$instance->pdo;
    }
}
