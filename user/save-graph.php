<?php

include("../config/functions.php");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $image = $_FILES['chart_image'];
  $filename = basename($image['name']);
  $uploadDir = '../uploads/graphs/';
  if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
  }
  $uploadPath = $uploadDir . $filename;
  if (move_uploaded_file($image['tmp_name'], $uploadPath)) {
    echo json_encode(['success' => true, 'message' => 'Image uploaded successfully']);
  } else {
    echo json_encode(['success' => false, 'message' => 'Error uploading image']);
  }
    log_activity_message("../log/user_activity_log", "error");
}
else{
    log_activity_message("../log/user_activity_log", "error");
}