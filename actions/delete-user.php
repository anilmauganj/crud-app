<?php
session_start();
require_once __DIR__ . '../class/User.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
   $id = $_POST['id'];
   $user = new User();
   $deleted = $user->delete($id);
   
   echo json_encode([
      'success' => $deleted,
      'message' => $deleted ? 'User deleted successfully.' : 'Failed to delete user'
   ]);
   
}