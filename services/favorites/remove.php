<?php

session_start(); // start a session

if (!isset($_SESSION['user_id'])) {
  echo ("Not authrozied");
  exit();
}

if (!isset($_GET['book_id'])) {
  echo ("Book ID is required");
  exit();
}

// Connect to the database
$db = mysqli_connect('localhost', 'root', '', 'lithubbook');

// Check connection
if (!$db) {
  die("Connection failed: " . mysqli_connect_error());
}

// Prepare sql statement
$book_id = $_GET['book_id'];
$user_id = $_SESSION['user_id'];

$sql = "DELETE FROM favorites WHERE user_id = '$user_id' AND book_id = '$book_id'";

try {
  if ($db->query($sql) === TRUE) {
    echo "Removed Success";
    header('Location: ../../pages/favorites/all.php');
  } else {
    echo "Someting went wrong";
  }
} catch (\Throwable $th) {
  echo "fatal error";
}