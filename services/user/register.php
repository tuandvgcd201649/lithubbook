<?php
function connectToDatabase()
{
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
  return new PDO($dsn, $user, $pass, $opt);
}

function register($email, $password)
{
  $pdo = connectToDatabase();

  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

  $stmt = $pdo->prepare('INSERT INTO users (email, password) VALUES (?, ?)');
  $stmt->execute([$email, $hashedPassword]);

  return $pdo->lastInsertId(); // return the ID of the inserted user
}

session_start(); // start the session

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $userId = register($email, $password);

  if ($userId) {
    $_SESSION['user_id'] = $userId;
    header('Location: ../../pages/book/books.php');
  } else {
    echo 'Registration failed';
  }
}
?>