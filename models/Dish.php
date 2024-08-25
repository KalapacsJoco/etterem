<?php
include_once 'Database.php';

class Dish {
    public $id;
    public $name;
    public $description;
    public $price;
    public $qty;

    public function __construct($name, $description, $price, $id = null, $qty = null) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->qty = $qty;
    }

    public function save() {
        $database = new Database();
        $db = $database->getPDO();

        if ($this->id) {
            $stmt = $db->prepare("
                UPDATE dishes 
                SET name = :name, description = :description, price = :price 
                WHERE id = :id
            ");
            return $stmt->execute([
                'name' => $this->name,
                'description' => $this->description,
                'price' => $this->price,
                'id' => $this->id
            ]);
        } else {
            $stmt = $db->prepare("
                INSERT INTO dishes (name, description, price) 
                VALUES (:name, :description, :price)
            ");
            $success = $stmt->execute([
                'name' => $this->name,
                'description' => $this->description,
                'price' => $this->price
            ]);

            if ($success) {
                // Beállítjuk az ID-t az utoljára beszúrt rekordhoz
                $this->id = $db->lastInsertId();
            }

            return $success;
        }
    }

    public static function findAll() {
        $database = new Database();
        $db = $database->getPDO();
        $stmt = $db->query("SELECT * FROM dishes");
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $dishes = [];
        foreach ($results as $row) {
            $dishes[] = new Dish($row['name'], $row['description'], $row['price'], $row['id']);
        }

        return $dishes;
    }

    public static function findById($id) {
        $database = new Database();
        $db = $database->getPDO();
        $stmt = $db->prepare("SELECT * FROM dishes WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Dish($row['name'], $row['description'], $row['price'], $row['id']);
        }
        return null;
    }
    public static function findByName($name) {
        $database = new Database();
        $db = $database->getPDO();
        $stmt = $db->prepare("SELECT * FROM dishes WHERE name = :name LIMIT 1");
        $stmt->execute(['name' => $name]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Dish($row['name'], $row['description'], $row['price'], $row['id']);
        }
        return null;
    }

    public function getName() {
        return $this->name;
    }
    public function getDescription() {
        return $this->description;
    }
    
    public function getPrice() {
        return $this->price;
    }
    
    public function getQty() {
        return $this->qty;
    }

    public function getId() {
        return $this->id;
    }

    // setterek
    

    public function setQty($qty) {
        $this->qty = $qty;
    }
}
?>
