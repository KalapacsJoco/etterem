<?php

class Database {
    private $pdo;

    protected static $host = 'localhost';
    protected static $dbname = 'etterem';
    protected static $username = 'localuser';
    protected static $password = 'localpass';

    public function __construct() {
        try {
            $dsn = "mysql:host=" . self::$host . ";dbname=" . self::$dbname . ";charset=utf8mb4";
            $this->pdo = new PDO($dsn, self::$username, self::$password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public function getPDO() {
        return $this->pdo;
    }

    public function insert($table, $data) {
        $keys = array_keys($data);
        $fields = implode(',', $keys);
        $placeholders = ':' . implode(',:', $keys);
        $sql = "INSERT INTO $table ($fields) VALUES ($placeholders)";
        $stmt = $this->getPDO()->prepare($sql);
        return $stmt->execute($data);
    }

    public function update($table, $data, $where) {
        $fields = '';
        foreach ($data as $key => $value) {
            $fields .= "$key = :$key, ";
        }
        $fields = rtrim($fields, ', ');
        $sql = "UPDATE $table SET $fields WHERE $where";
        $stmt = $this->getPDO()->prepare($sql);
        return $stmt->execute($data);
    }

    public function delete($table, $where, $params) {
        $sql = "DELETE FROM $table WHERE $where";
        $stmt = $this->getPDO()->prepare($sql);
        return $stmt->execute($params);
    }
}
?>
