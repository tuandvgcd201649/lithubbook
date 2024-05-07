<!-- Add favorite book to user -->
<!-- Make sure to check the duplicate -->

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

$sql = "INSERT INTO favorites (user_id, book_id) VALUES ('$user_id', '$book_id')";

try {
  if ($db->query($sql) === TRUE) {
    echo "New record created successfully";
  } else {
    echo "Created failed";
  }
} catch (\Throwable $th) {
  echo "fatal error";
}
