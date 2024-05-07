<?php

function deleteBook($id)
{
  // Database connection
  $host = 'localhost';
  $db = 'lithubbook';
  $user = 'root';
  $pass = '';
  $charset = 'utf8mb4';

  $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
  $opt = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
  ];
  $pdo = new PDO($dsn, $user, $pass, $opt);

  // SQL query
  $sql = "DELETE FROM books WHERE id = :id";

  // Prepare statement
  $stmt = $pdo->prepare($sql);

  // Bind parameters
  $stmt->bindParam(':id', $id, PDO::PARAM_INT);

  // Execute query
  $stmt->execute();
}

session_start();

if (!isset($_SESSION['user_id'])) {
  // Redirect to login page or show an error
  echo 'user not logged in';
  exit();
}

if (isset($_GET['id'])) {
  $id = $_GET['id'];

  if ($id === '') {
    // Redirect to a page or show an error if no ID is provided
    echo 'No ID provided';
    exit();
  }
  // Delete the book with this ID
  // Assuming you have a function deleteBook($id) that deletes the book
  deleteBook($id);
  echo 'Book deleted successfully';
} else {
  echo 'Something went wrong. Please try again later.';
  exit();
}