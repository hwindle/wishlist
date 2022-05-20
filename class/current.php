<?php

  class Current {
    private $conn;

    private $dbTable = 'current_items';
    // columns
    public $id;
    public $item;
    public $description;
    public $status;
    public $place;
    // DB connection in constructor
    public function __construct($db) {
      $this->conn = $db;
    }

    // fetch all rows
    public function getCurrentItems() {
      $sqlQuery = 'SELECT * FROM ' . $this->dbTable . '';
      $stmt = $this->conn->prepare($sqlQuery);
      $stmt->execute();
      return $stmt; 
    }

    // create one current item
    public function createCurrent() {
      $sqlQuery = 'INSERT INTO' . $this->dbTable . 
            '(item, description, status, place)
                VALUES (
                item = :item, 
                description = :description, 
                status = :status,
                place = :place    
            )';
      $stmt = $this->conn->prepare($sqlQuery);
      // clean data
      $this->item = htmlspecialchars(strip_tags($this->item));
      $this->description = htmlspecialchars(strip_tags($this->description));
      $this->status = htmlspecialchars(strip_tags($this->status));
      $this->place = htmlspecialchars(strip_tags($this->place));
      // bind data
      $stmt->bindParam(':item', $this->item);
      $stmt->bindParam(':description', $this->description);
      $stmt->bindParam(':status', $this->status);
      $stmt->bindParam(':place', $this->place);
      if ($stmt->execute()) {
        return true;
      } 
      return false;
    }

    // read one item
    public function getOneItem() {
      $sqlQuery = 'SELECT * FROM' . $this->dbTable 
              . ' WHERE id = ? LIMIT 1';
      $stmt = $this->conn->prepare($sqlQuery);
      $stmt->bindParam(1, $this->id);
      try {
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->item = $dataRow['item'];
        $this->description = $dataRow['description'];
        $this->status = $dataRow['status'];
        $this->place = $dataRow['place'];
      } catch (PDOException $e) {
        echo 'Fetching one item failed: ' . $e->getMessage();
      }
    }

    // update 1 item
    public function updateItem() {
      $sqlQuery = 'UPDATE ' . $this->dbTable .
          ' SET 
            item = :item, 
            description = :description, 
            status = :status,
                place = :place
           WHERE current_id = :id';

      $stmt = $this->conn->prepare($sqlQuery);
      // clean data
      $this->item = htmlspecialchars(strip_tags($this->item));
      $this->description = htmlspecialchars(strip_tags($this->description));
      $this->status = htmlspecialchars(strip_tags($this->status));
      $this->place = htmlspecialchars(strip_tags($this->place));
      $this->id = (int) $this->id;
      // bind data
      $stmt->bindParam(':item', $this->item);
      $stmt->bindParam(':description', $this->description);
      $stmt->bindParam(':status', $this->status);
      $stmt->bindParam(':place', $this->place);
      $stmt->bindParam(':id', $this->id);
      if ($stmt->execute()) {
        return true;
      } 
      return false;
    }

    // delete 1 item
    function deleteItem() {
      $sqlQuery = 'DELETE FROM ' . $this->dbTable . ' WHERE id = ?';
      $stmt = $this->conn->prepare($sqlQuery);
      $this->id = (int) $this->id;
      $stmt->bindParam(1, $this->id);
      if ($stmt->execute()) {
        return true;
      }
      return false;
    }

  }