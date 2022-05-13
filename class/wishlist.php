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
      $stmt = pg_query_params($this->conn, $sqlQuery, []);
      return $stmt; 
    }

  }