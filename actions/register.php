<?php

require_once __DIR__ . '../class/User.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
   $user = new User();
   $name = $_POST['name'];
   $email = $_POST['email'];
   $password = $_POST['password'];

   $success = $user->register($name, $email, $password);

   echo json_encode([
      'success' => $success,
      'message' => $success ? 'User registered successfully.': 'Resitration failed.'
   ]);
   
}