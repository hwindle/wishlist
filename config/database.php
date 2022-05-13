<?php
  class Database {
    private $host = '127.0.0.1';
    private $databaseName = 'wishlist';
    private $username = 'wishlist';
    private $password = 'T34u589i23*3ere';
    public $conn;

    public function getConnection() {
      $this->conn = null;
      $connectionString = 'host=' . $this->host . 'port=' . $this->port . 'dbname='
        . $this->dbname . 'user=' . $this->user . 'password=' . $this->password;
      try {
        $this->conn = pg_connect($connectionString);
      } catch (Exception $e) {
        echo 'Database could not be connected' . $e->getMessage();
      }

      return $this->conn;
    }
  }