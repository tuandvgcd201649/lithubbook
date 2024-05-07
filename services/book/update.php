<?php

session_start(); // start a session

if (!isset($_SESSION['user_id'])) {
  header('Location: ../user/login.html'); // redirect to login page if $email is not in the session
  exit;
}

if ($_POST['title'] === '' || $_POST['author'] === '' || $_POST['price'] === '') {
  echo 'Please fill all fields';
  exit;
}

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

$stmt = $pdo->prepare(
  'UPDATE books SET title = :title, author = :author, price = :price WHERE id = :id'
);

$stmt->execute([
  'title' => $_POST['title'],
  'author' => $_POST['author'],
  'price' => $_POST['price'],
  'id' => $_POST['id']
]);

echo 'Book updated successfully';