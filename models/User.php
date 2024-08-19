<?php

require_once 'Database.php';

class User {
    private $id;
    private $username;
    private $email;
    private $db;

    public function __construct($username, $email, $id = null) {
        $this->username = $username;
        $this->email = $email;
        $this->id = $id;
        $this->db = new Database();
    }

    public function save() {
        if ($this->id) {
            $data = [
                'username' => $this->username,
                'email' => $this->email,
                'id' => $this->id
            ];
            $this->db->update('users', $data, 'id = :id');
        } else {
            $data = [
                'username' => $this->username,
                'email' => $this->email
            ];
            $this->db->insert('users', $data);
        }
    }

    public static function getAllUsers($db) {
        $stmt = $db->getPDO()->query("SELECT * FROM users");
        $usersData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $users = [];
        foreach ($usersData as $userData) {
            $users[] = new self($userData['username'], $userData['email'], $userData['id']);
        }

        return $users;
    }

    public function delete() {
        $this->db->delete('users', 'id = :id', ['id' => $this->id]);
    }

    public function getId() {
        return $this->id;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getEmail() {
        return $this->email;
    }
}
