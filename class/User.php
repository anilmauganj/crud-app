<?php
require_once __DIR__ . '../config/Database.php';

class User {
   private $conn;
   private $table = 'users';

   public function __construct() {
     $db = new Database();
     $this->conn = $db->connect();
   }

   // Register a new user
   public function register($name, $email, $password) {
      $hash = password_hash($password, PASSWORD_DEFAULT);
      $stmt = $this->conn->prepare("INSERT INTO {$this->table} (name, email, password) VALUES(?, ?, ?)");

      return $stmt->execute([$name, $email, $hash]);
   }

   // Login user.
   public function login($email, $password) {
     $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE email = ?");
     $stmt->execute([$email]);

     $user = $stmt->fetch(PDO::FETCH_ASSOC);

     if($user && password_verify($password, $user['password'])) {
        return $user;
     }

     return false;
   }

   //Fetch All Users
   public function getAll() {
      $stmt = $this->conn->prepare('SELECT id, name, email FROM {$this->table}');

      return $stmt->fetchAll(PDO::FETCH_ASSOC);
   }

   // Delete user by ID
   public function delete($id) {
      $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE id = ?");
      return $stmt->execute([$id]);
   }





   
}