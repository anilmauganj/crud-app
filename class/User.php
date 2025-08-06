<?php
require_once __DIR__ . '/../config/Database.php';

class User {
   private $conn;
   private $table = 'users';

   public function __construct() {
     $db = new Database();
     $this->conn = $db->connect();
   }

   // Register a new user
   public function register($name, $mobile, $email, $password) {
      $hash = password_hash($password, PASSWORD_DEFAULT);
      $stmt = $this->conn->prepare("INSERT INTO {$this->table} (name,mobile, email, password) VALUES(?, ?, ?, ?)");

      return $stmt->execute([$name, $mobile, $email, $hash]);
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
     $stmt = $this->conn->prepare("SELECT id, name, email, mobile FROM {$this->table}");
     $stmt->execute();
     $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
     foreach ($users as &$user) {
        $id = $user['id'];

        $user['actions'] = '
            <button class="edit-btn bg-blue-500 text-white px-2 py-1 rounded" data-id="'.$id.'">Edit</button>
            <button class="delete-btn bg-red-500 text-white px-2 py-1 rounded ml-2" data-id="'.$id.'">Delete</button>
        ';
    }

    return $users;
   }

   // Delete user by ID
   public function delete($id) {
      $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE id = ?");
      return $stmt->execute([$id]);
   }

   public function getById($id) {
   $stmt = $this->conn->prepare("SELECT id, name, email, mobile FROM {$this->table} WHERE id = ?");
   $stmt->execute([$id]);
   return $stmt->fetch(PDO::FETCH_ASSOC);
   }

   public function update($id, $name, $email, $mobile) {
      $stmt = $this->conn->prepare("UPDATE {$this->table} SET name = ?, email = ?, mobile = ? WHERE id = ?");
      return $stmt->execute([$name, $email, $mobile, $id]);
   }





   
}