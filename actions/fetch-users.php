<?php
session_start();
if(!isset($_SESSION['user'])) {
   echo json_encode([
      'success' => false,
      'message' => 'Unauthorized access'
   ]);

   exit;
}

require_once __DIR__ . '../class/User.php';
$user = new User();
$users = $user->getAll();

echo json_encode([
    'success' => true,
    'users' => $users,
    'message' => 'Users fetched successfully'
]);