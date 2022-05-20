<?php
  class Database {
    private $host = '127.0.0.1';
    private $databaseName = 'wishlist';
    private $username = 'wishlist';
    private $password = 'T34u589i23*3ere';
    public $conn;

    public function getConnection() {
      $this->conn = null;
      try {
        $this->conn = new PDO("pgsql:host=" . $this->host . ";dbname=" . $this->database_name, $this->username, $this->password);
        $this->conn->exec("set names utf8");
      } catch (PDOException $e) {
        echo 'Database could not be connected' . $e->getMessage();
      }
      return $this->conn;
    }

  }