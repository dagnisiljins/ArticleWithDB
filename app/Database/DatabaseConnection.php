<?php

declare(strict_types=1);

namespace App\Database;

class DatabaseConnection {
    private static $instance = null;
    private $pdo;

    private $host = 'localhost';
    private $db   = 'your_database_name';
    private $user = 'your_username';
    private $pass = 'your_password';
    private $charset = 'utf8mb4';

    private function __construct() {
        $dsn = "mysql:host=$this->host;dbname=$this->db;charset=$this->charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->pdo = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->pdo;
    }

    // Prevent cloning and unserialization (which would create multiple instances)
    private function __clone() { }
    private function __wakeup() { }
}

// Usage
//$db = DatabaseConnection::getInstance()->getConnection();
//$stmt = $db->query('SELECT * FROM table');
//while ($row = $stmt->fetch()) {
//    // Do something with $row
//}