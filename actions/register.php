<?php

require_once __DIR__ . '/../class/User.php';
   header('Content-Type: application/json');

if($_SERVER['REQUEST_METHOD'] === 'POST') {
   $user = new User();
   $name = $_POST['name'];
   $mobile = $_POST['mobile'];
   $email = $_POST['email'];
   $password = $_POST['password'];

   $success = $user->register($name, $mobile, $email, $password);

   echo json_encode([
      'success' => $success,
      'message' => $success ? 'User registered successfully.': 'Resitration failed.'
   ]);
   
}