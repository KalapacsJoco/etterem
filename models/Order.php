<?php
include_once 'Database.php';

class Order {
    private $id;
    private $userId;
    private $dish;
    private $qty;
    private $total;
    private $deliveryType;
    private $deliveryTime;
    private $createdAt;

    public function __construct($userId, $dish, $qty, $deliveryType, $createdAt = null, $id = null) {
        $this->id = $id;
        $this->userId = $userId;
    
        // Debug kimenet
        error_log("Dish ID vagy Objektum: " . print_r($dish, true));
    
        // Ellenőrizd, hogy $dish egy int-e, és ha igen, töltsd be a megfelelő Dish objektumot
        if ($dish) {
            $this->dish = Dish::findById($dish);
        } else {
            $this->dish = $dish;
        }
    
        if ($this->dish instanceof Dish) {
            $this->qty = $qty;
            $this->total = (int)$this->dish->getPrice() * $qty;
        } else {
            throw new Exception("Hibás dish típus: nem sikerült betölteni a Dish objektumot.");
        }
    
        $this->deliveryType = $deliveryType;
        $this->createdAt = $createdAt;
    
        // deliveryTime beállítása
        $currentTime = new DateTime();
        if ($this->deliveryType) {
            // Házhoz szállítás (aktuális idő + 1 óra)
            $currentTime->modify('+1 hour');
        } else {
            // Vendég érte megy (aktuális idő + 30 perc)
            $currentTime->modify('+30 minutes');
        }
        $this->deliveryTime = $currentTime->format('Y-m-d H:i:s');
    }
    
    

    // rendelések mentése vagy módosítása
    public function save() {
        $database = new Database();
        $db = $database->getPDO();
        if ($this->id) {
            // ha létezik az id, akkor módosítjuk
            $stm = $db->prepare("UPDATE orders SET user_id = :userId, total = :total, delivery_type = :deliveryType, delivery_time = :deliveryTime WHERE id = :id");
            return $stm->execute([
                'userId' => $this->userId,
                'total' => $this->total,
                'deliveryType' => $this->deliveryType ? 'delivery' : 'pickup',
                'deliveryTime' => $this->deliveryTime,
                'id' => $this->id
            ]);
        } else {
            // ha nem létezik az id, akkor létrehozzuk a rendelést
            $stm = $db->prepare("INSERT INTO orders (user_id, total, delivery_type, delivery_time) VALUES (:userId, :total, :deliveryType, :deliveryTime)");
            return $stm->execute([
                'userId' => $this->userId,
                'total' => $this->total,
                'deliveryType' => $this->deliveryType ? 'delivery' : 'pickup',
                'deliveryTime' => $this->deliveryTime
            ]);
        }
    }
    

    // Keresés ID alapján, majd asszociatív tömbbe való kiírás a $row változóba
    public static function findById($id) {
        $database = new Database();
        $db = $database->getPDO();
        $stmt = $db->prepare("SELECT * FROM orders WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new self($row['user_id'], $row['dish_id'], $row['qty'], $row['total'], $row['delivery_type'] === 'delivery', $row['id'], $row['created_at']);
        }
        return null;
    }

    // Rendelések keresése user ID alapján
    public static function findByUserId($userId) {
        $database = new Database();
        $db = $database->getPDO();
        $stmt = $db->prepare("SELECT * FROM orders WHERE user_id = :userId");
        $stmt->execute(['userId' => $userId]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        $orders = [];
        foreach ($rows as $row) {
            $orders[] = new self($row['user_id'], $row['dish_id'], $row['qty'], $row['total'], $row['delivery_type'] === 'delivery', $row['id'], $row['created_at']);
        }
        return $orders;
    }

    // feltoltes az ordet_items tablaba

    public function saveOrderItems($items) {
        $database = new Database();
        $db = $database->getPDO();
    
        $stmt = $db->prepare("
            INSERT INTO order_items (order_id, dish_id, quantity, price)
            VALUES (:order_id, :dish_id, :quantity, :price)
        ");
    
        foreach ($items as $item) {
            if ($item instanceof Dish) {  // Biztosítsuk, hogy $item egy Dish objektum
                $stmt->execute([
                    'order_id' => $this->id,
                    'dish_id' => $item->id,  // Itt használd a $item->id változót
                    'quantity' => (int)$item->getQty(),
                    'price' => (int)$item->getPrice(),
                ]);
            }
        }
    }
    


    // Getter metódusok
    public function getId() {
        return $this->id;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function getDish() {
        return $this->dish;
    }

    public function getQty() {
        return $this->qty;
    }

    public function getTotal() {
        return $this->total;
    }

    public function getDeliveryType() {
        return $this->deliveryType;
    }

    public function getDeliveryTime() {
        return $this->deliveryTime;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }
}
?>
