<?php

class User {
  private $session;
  private $conn;
  private $dbTable = 'users';

  public $user_id;
  public $user_name;
  public $email;
  public $password;
  public $password_to_check;

  public function __construct($db) {
    $this->conn = $db;
    if (!$this->conn) {
      $e .= '<p class="php-error">Database connection failed in users constructor.</p>';
    }
  }

  // create one user
  public function register() {
    // check if user id, email already exists in table
    $sql = 'SELECT * FROM ' . $this->dbTable . ' WHERE user_id = :id OR email = :email LIMIT 1';
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':id', $this->user_id);
    $stmt->bindParam(':email', $this->email);
    if ($stmt->execute()) {
      if ($stmt->fetch(PDO::FETCH_ASSOC)) {
        $e .= '<p class="php-error">The user id or email already exists in the table.</p>';
        return false;
      }
    }
    // store the new user data
    $sql_store = 'INSERT INTO ' . $this->dbTable . 
              ' VALUES (DEFAULT, :user_name, 
                :email, 
                :password)';
    $other_stmt = $this->conn->prepare($sql_store);
    $this->user_name = preg_replace('/[^a-zA-Z0-9]{2, 16}/', '', $this->user_name);
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
    $sql = 'SELECT * FROM ' . $this->dbTable . ' WHERE user_name = :user_name LIMIT 1';
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':user_name', $this->user_name);
    try {
      $stmt->execute();
    } catch (PDOException $pdoExcept) {
      echo 'Caught exception: ' . $pdoExcept->getMessage();
    }
    // login and start new session if they are
    $user_data = $stmt->fetch(PDO::FETCH_ASSOC);
    $this->password = $user_data['password'];
    // echo 'password hash' . $this->password;
    if ($this->password) {
      if (password_verify($this->password_to_check, $this->password)) {
        $_SESSION['user_id'] = $user_data['user_id']; // from DB - pri key
        $_SESSION['user_name'] = $user_data['user_name'];
        return true;
      } else {
        return false;
      }
    }
  }

  // // logout 1 user
  // public function logout($user_id) {

  // }

}