<?php

session_start();
require_once __DIR__ . '../class/User.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
   $user = new User();
   $email = $_POST['email'];
   $password = $_POST['password'];

   $data = $user->login($email, $password);
   if($data) {
      $_SESSION['user'] = $data;
      echo json_encode([
          'success' => true,
          'message' => 'Login successfull',
      ]);
   }else {
      echo json_encode([
          'success' => false,
           'message' => 'Invalid email or password',
      ]);
   }
}