<?php

require_once __DIR__ . '/../class/User.php';
$user = new User();

if (isset($_POST['id'], $_POST['name'], $_POST['email'], $_POST['mobile'])) {
  $updated = $user->update($_POST['id'], $_POST['name'], $_POST['email'], $_POST['mobile']);

  if ($updated) {
    echo json_encode(['success' => true, 'message' => 'User updated successfully.']);
  } else {
    echo json_encode(['success' => false, 'message' => 'Update failed']);
  }
}