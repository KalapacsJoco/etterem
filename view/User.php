<?php

class User {
    private $id;
    private $email;
    private $password;
    private $firstName;
    private $lastName;
    private $phone;
    private $street;
    private $houseNumber;
    private $isAdmin;

    public function __construct($id = null, $email, $password, $firstName, $lastName, $phone, $street, $houseNumber, $isAdmin) {
        $this->id = $id;
        $this->email = $email;
        // Ha a jelszó nem hash-elt, akkor hash-eljük
        $this->password = $id ? $password : password_hash($password, PASSWORD_BCRYPT);
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->phone = $phone;
        $this->street = $street;
        $this->houseNumber = $houseNumber;
        $this->isAdmin = $isAdmin;
    }

    public static function findByEmail($email) {
        $database = new Database();
        $db = $database->getPDO();
        $stmt = $db->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new User( $row['id'], $row['email'], $row['password'], $row['first_name'], $row['last_name'], $row['phone'], $row['street'], $row['house_number'], $row['is_admin']);
        }
        return null;
    }

    public function save() {
        $database = new Database();
        $db = $database->getPDO();

        if ($this->id) {
            // Update existing user
            $stmt = $db->prepare("UPDATE users SET email = :email, password = :password, first_name = :first_name, last_name = :last_name, phone = :phone, street = :street, house_number = :house_number, is_admin = :is_admin WHERE id = :id");
            return $stmt->execute([
                'email' => $this->email,
                'password' => $this->password,
                'first_name' => $this->firstName,
                'last_name' => $this->lastName,
                'phone' => $this->phone,
                'street' => $this->street,
                'house_number' => $this->houseNumber,
                'is_admin' => $this->isAdmin,
                'id' => $this->id
            ]);
        } else {
            // Insert new user
            $stmt = $db->prepare("INSERT INTO users (email, password, first_name, last_name, phone, street, house_number, is_admin) VALUES (:email, :password, :first_name, :last_name, :phone, :street, :house_number, :is_admin)");
            return $stmt->execute([
                'email' => $this->email,
                'password' => $this->password,
                'first_name' => $this->firstName,
                'last_name' => $this->lastName,
                'phone' => $this->phone,
                'street' => $this->street,
                'house_number' => $this->houseNumber,
                'is_admin' => $this->isAdmin
            ]);
        }
    }

    public function getId() {
        return $this->id;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getFirstName() {
        return $this->firstName;
    }

    public function getLastName() {
        return $this->lastName;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function getStreet() {
        return $this->street;
    }

    public function getHouseNumber() {
        return $this->houseNumber;
    }

    public function getIsAdmin() {
        return $this->isAdmin;
    }
    public static function findById($id) {
        $database = new Database();
        $db = $database->getPDO();
        $stmt = $db->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($row) {
            return new User($row['id'], $row['email'], $row['password'], $row['first_name'], $row['last_name'], $row['phone'], $row['street'], $row['house_number'], $row['is_admin']);
        }
        return null;
    }

    //setterek

    public function setFirstName($firstName) {
        $this->firstName = $firstName;
    }
    
    public function setLastName($lastName) {
        $this->lastName = $lastName;
    }
    
    public function setPhoneNumber($phone) {
        $this->phone = $phone;
    }
    
    public function setStreet($street) {
        $this->street = $street;
    }
    
    public function setHouseNumber($houseNumber) {
        $this->houseNumber = $houseNumber;
    }
    
    
}
?>
