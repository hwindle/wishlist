<?php

  class Wishlist {
    private $conn;

    private $dbTable = 'wishlist';
    // columns
    public $wishlistId;
    public $item;
    public $category;
    public $shopName;
    public $url;
    public $description;
    public $quantity;
    public $price;
    public $totalPrice;
    public $room;
    public $priority;
    // DB connection in constructor
    public function __construct($db) {
      $this->conn = $db;
    }

    // fetch all rows
    public function getWishlist() {
      $sqlQuery = 'SELECT * FROM ' . $this->dbTable . '';
      $stmt = $this->conn->prepare($sqlQuery);
      $stmt->execute();
      return $stmt; 
    }

    // create one wishlist item
    public function createWishlist() {
      $sqlQuery = 'INSERT INTO' . $this->dbTable . 
            '(item, category, shop_name, url,
               description, quantity, price, room, priority)
                VALUES (
                item = :item, category = :category,
                shop_name = :shop_name, url = :url,
                description = :description, quantity = :quantity,
                price = :price, room = :room, priority = :priority    
            )';
      $stmt = $this->conn->prepare($sqlQuery);
      // clean data
      $this->item = htmlspecialchars(strip_tags($this->item));
      $this->category = htmlspecialchars(strip_tags($this->category));
      $this->shop_name = htmlspecialchars(strip_tags($this->shopName));
      $this->url = htmlspecialchars(strip_tags($this->url));
      $this->description = htmlspecialchars(strip_tags($this->description));
      $this->quantity = (int) $this->quantity;
      $this->price = floatval($this->price);
      $this->room = htmlspecialchars(strip_tags($this->room));
      $this->priority = (int) $this->priority;
      // bind data
      $stmt->bindParam(':item', $this->item);
      $stmt->bindParam(':category', $this->category);
      $stmt->bindParam(':shop_name', $this->shopName);
      $stmt->bindParam(':url', $this->url);
      $stmt->bindParam(':description', $this->description);
      $stmt->bindParam(':quantity', $this->quantity);
      $stmt->bindParam(':price', $this->price);
      $stmt->bindParam(':room', $this->room);
      $stmt->bindParam(':priority', $this->priority);

      if ($stmt->execute()) {
        return true;
      } 
      return false;
    }

    // read one item
    public function getSingleItem() {
      $sqlQuery = 'SELECT * FROM' . $this->dbTable 
              . ' WHERE id = ? LIMIT 1';
      $stmt = $this->conn->prepare($sqlQuery);
      $stmt->bindParam(1, $this->wishlistId);
      try {
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->item = $dataRow['item'];
        $this->category = $dataRow['category'];
        $this->shopName = $dataRow['shop_name'];
        $this->url = $dataRow['url'];
        $this->description = $dataRow['description'];
        $this->quantity = $dataRow['quantity'];
        $this->price = $dataRow['price'];
        $this->totalPrice = $dataRow['total_price'];
        $this->room = $dataRow['room'];
        $this->priority = $dataRow['priority'];
      } catch (PDOException $e) {
        echo 'Fetching one item failed: ' . $e->getMessage();
      }
    }

    // update 1 item
    public function updateItem() {
      $sqlQuery = 'UPDATE ' . $this->dbTable .
          ' SET 
           item = :item, category = :category,
                shop_name = :shop_name, url = :url,
                description = :description, quantity = :quantity,
                price = :price, room = :room, priority = :priority 
           WHERE wishlist_id = :id';

      $stmt = $this->conn->prepare($sqlQuery);
      // clean data
      $this->item = htmlspecialchars(strip_tags($this->item));
      $this->category = htmlspecialchars(strip_tags($this->category));
      $this->shop_name = htmlspecialchars(strip_tags($this->shopName));
      $this->url = htmlspecialchars(strip_tags($this->url));
      $this->description = htmlspecialchars(strip_tags($this->description));
      $this->quantity = (int) $this->quantity;
      $this->price = floatval($this->price);
      $this->room = htmlspecialchars(strip_tags($this->room));
      $this->priority = (int) $this->priority;
      $this->wishlistId = (int) $this->wishlistId;
      // bind data
      $stmt->bindParam(':item', $this->item);
      $stmt->bindParam(':category', $this->category);
      $stmt->bindParam(':shop_name', $this->shopName);
      $stmt->bindParam(':url', $this->url);
      $stmt->bindParam(':description', $this->description);
      $stmt->bindParam(':quantity', $this->quantity);
      $stmt->bindParam(':price', $this->price);
      $stmt->bindParam(':room', $this->room);
      $stmt->bindParam(':priority', $this->priority);
      $stmt->bindParam(':id', $this->wishlistId);

      if ($stmt->execute()) {
        return true;
      } 
      return false;
    }

    // delete 1 item
    function deleteItem() {
      $sqlQuery = 'DELETE FROM ' . $this->dbTable . ' WHERE id = ?';
      $stmt = $this->conn->prepare($sqlQuery);
      $this->wishlistId = (int) $this->wishlistId;
      $stmt->bindParam(1, $this->wishlistId);
      if ($stmt->execute()) {
        return true;
      }
      return false;
    }

  }