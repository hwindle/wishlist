<?php

  class Wishlist {
    private $conn;

    private $dbTable = 'wishlist';
    // columns
    public $wishlist_id;
    public $user_id;
    public $item;
    public $category;
    public $shopName;
    public $url;
    public $pic;
    public $quantity;
    public $price;
    // public $totalPrice;
    public $room;
    public $priority;
    // DB connection in constructor
    public function __construct($db) {
      $this->conn = $db;
      if (!$this->conn) {
        $e .= '<p class="php-error">Database connection failed in wishlist constructor.</p>';
      }
    }

    // fetch all rows
    public function getWishlist() {
      $sqlQuery = 'SELECT * FROM ' . $this->dbTable . ' ORDER BY room';
      $stmt = $this->conn->prepare($sqlQuery);
      $stmt->execute();
      return $stmt; 
    }

    // create one wishlist item
    public function createWishlist() {
      $sqlQuery = 'INSERT INTO ' . $this->dbTable . 
            ' (user_id, item, category, shop_name, url,
               pic, quantity, price, room, priority)
                VALUES (user_id = :user_id,
                item = :item, category = :category,
                shop_name = :shop_name, url = :url,
                pic = :pic, quantity = :quantity,
                price = :price, room = :room, priority = :priority    
            )';
      $stmt = $this->conn->prepare($sqlQuery);
      // clean data
      $this->user_id = $this->user_id;
      $this->item = htmlspecialchars(strip_tags($this->item));
      $this->category = htmlspecialchars(strip_tags($this->category));
      $this->shopName = htmlspecialchars(strip_tags($this->shopName));
      $this->url = htmlspecialchars(strip_tags($this->url));
      $this->pic = htmlspecialchars(strip_tags($this->pic));
      $this->quantity = (int) $this->quantity;
      $this->price = floatval($this->price);
      $this->room = htmlspecialchars(strip_tags($this->room));
      $this->priority = (int) $this->priority;
      // bind data
      $stmt->bindParam(':user_id', $this->user_id);
      $stmt->bindParam(':item', $this->item);
      $stmt->bindParam(':category', $this->category);
      $stmt->bindParam(':shop_name', $this->shopName);
      $stmt->bindParam(':url', $this->url);
      $stmt->bindParam(':pic', $this->pic);
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
      $sqlQuery = 'SELECT * FROM ' . $this->dbTable 
              . ' WHERE id = ? LIMIT 1';
      $stmt = $this->conn->prepare($sqlQuery);
      $stmt->bindParam(1, $this->wishlist_id);
      try {
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->user_id = $dataRow['user_id'];
        $this->item = $dataRow['item'];
        $this->category = $dataRow['category'];
        $this->shopName = $dataRow['shop_name'];
        $this->url = $dataRow['url'];
        $this->pic = $dataRow['pic'];
        $this->quantity = $dataRow['quantity'];
        $this->price = $dataRow['price'];
        $this->totalPrice = $dataRow['total_price'];
        $this->room = $dataRow['room'];
        $this->priority = $dataRow['priority'];
      } catch (PDOException $err) {
        $e .= '<p class="php-error">Fetching one item failed: ' . $err->getMessage() . '</p>';
      }
    }

    // update 1 item
    public function updateItem() {
      $sqlQuery = 'UPDATE ' . $this->dbTable .
          ' SET user_id = :user_id,
           item = :item, category = :category,
                shop_name = :shop_name, url = :url,
                pic = :pic, quantity = :quantity,
                price = :price, room = :room, priority = :priority 
           WHERE wishlist_id = :id';

      $stmt = $this->conn->prepare($sqlQuery);
      // clean data
      $this->user_id = $_SESSION['user_id'];
      $this->item = htmlspecialchars(strip_tags($this->item));
      $this->category = htmlspecialchars(strip_tags($this->category));
      $this->shop_name = htmlspecialchars(strip_tags($this->shopName));
      $this->url = htmlspecialchars(strip_tags($this->url));
      $this->pic = htmlspecialchars(strip_tags($this->pic));
      $this->quantity = (int) $this->quantity;
      $this->price = floatval($this->price);
      $this->room = htmlspecialchars(strip_tags($this->room));
      $this->priority = (int) $this->priority;
      $this->wishlist_id = (int) $this->wishlist_id;
      // bind data
      $stmt->bindParam(':user_id', $this->user_id);
      $stmt->bindParam(':item', $this->item);
      $stmt->bindParam(':category', $this->category);
      $stmt->bindParam(':shop_name', $this->shopName);
      $stmt->bindParam(':url', $this->url);
      $stmt->bindParam(':pic', $this->pic);
      $stmt->bindParam(':quantity', $this->quantity);
      $stmt->bindParam(':price', $this->price);
      $stmt->bindParam(':room', $this->room);
      $stmt->bindParam(':priority', $this->priority);
      $stmt->bindParam(':id', $this->wishlist_id);

      if ($stmt->execute()) {
        return true;
      } 
      return false;
    }

    // delete 1 item
    function deleteItem($id) {
      $sqlQuery = 'DELETE FROM ' . $this->dbTable . ' WHERE id = ?';
      $stmt = $this->conn->prepare($sqlQuery);
      $this->wishlist_id = (int) $id;
      $stmt->bindParam(1, $this->wishlist_id);
      if ($stmt->execute()) {
        return true;
      }
      return false;
    }

  }