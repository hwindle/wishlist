<?php
  class Database {
    private $host = 'pg-wishlist';
    private $databaseName = 'wishlist';
    private $username = 'postgres';
    private $password = '<putnode-pw-here-process-env';
    public $conn;

    public function getConnection() {
      $this->conn = null;
      try {
        $this->conn = new PDO("pgsql:host=$this->host;dbname=$this->databaseName;options='--client_encoding=utf8'",$this->username, 
        $this->password);
        // $this->conn->exec("set names utf8");
      } catch (PDOException $e) {
        echo 'Database could not be connected :-(' . $e->getMessage();
      }
      return $this->conn;
    }

  }
