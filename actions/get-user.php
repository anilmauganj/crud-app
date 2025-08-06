<?php
require_once __DIR__ . '/../class/User.php';
$user = new User();

if (isset($_POST['id'])) {
   $data = $user->getById($_POST['id']);
   if ($data) {
    echo json_encode(['success' => true, 'user' => $data]);
  } else {
    echo json_encode(['success' => false, 'message' => 'User not found']);
  }
}