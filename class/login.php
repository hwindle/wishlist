<?php

class User {
  private $session;
  private $conn;
  private $dbTable = 'users';

  public $user_id;
  public $user_name;
  public $email;
  public $password;

  public function __construct($db) {
    $this->conn = $db;
    if (!$this->conn) {
      $e = 'Database connection failed in users constructor.';
    }
  }

  // create one user
  public function register() {
    // check if user id, email already exists in table
    $sql = 'SELECT * FROM ' . $this->dbTable . ' WHERE id = :id OR email = :email LIMIT 1';
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':id', $this->user_id);
    $stmt->bindParam(':email', $this->email);
    if ($stmt->execute()) {
      if ($stmt->fetch(PDO::FETCH_ASSOC)) {
        $e = 'The user id or email already exists in the table.';
      }
    }
    // store the new user data
    $sql_store = 'INSERT INTO ' . $this->dbTable . 
              '(user_name = :user_name, 
                email = :email, 
                password = :password)';
    $other_stmt = $this->conn->prepare($sql_store);
    $this->user_name = preg_match('/[a-zA-Z0-9]{2, 16}/', $this->user_name, '');
    $other_stmt->bindParam(':user_name', $this->user_name);
    $other_stmt->bindParam(':email', $this->email);
    $other_stmt->bindParam(':password', $this->password);
    if ($other_stmt->execute()) {
      return true;
    } 
    return false;
  }

  // login 1 user
  public function login() {
    // see if the username and password are in the database
    $sql = 'SELECT * FROM ' . $this->dbTable . ' WHERE user_name = :user_name AND password = :password LIMIT 1';
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':user_name', $this->user_name);
    $stmt->bindParam(':password', $this->password);
    try {
      $stmt->execute();
    } catch (PDOException $pdoExcept) {
      echo 'Caught exception: ' . $pdoExcept->getMessage();
    }
    // login and start new session if they are
    $user_data = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user_data) {
      session_start();
      $_SESSION['user_id'] = $user_data['user_id']; // from DB - pri key
      $_SESSION['user_name'] = $this->user_name;
      return true;
    } else {
      return false;
    }

  }

  // logout 1 user
  public function logout($user_id) {

  }

}