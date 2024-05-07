<?php
session_start(); // start a session

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
  session_destroy(); // Xóa tất cả các session
  header('Location: ../../pages/user/login.html'); // Chuyển hướng về trang đăng nhập
  exit;
}

if (!isset($_SESSION['user_id'])) {
  header('Location: ../user/login.html'); // redirect to login page if $email is not in the session
  exit;
}

if (!isset($_GET['id'])) {
  echo 'something went wrong';
  exit;
}

$id = $_GET['id'];

// pdo instance

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

// Assuming you have a PDO instance $pdo
$stmt = $pdo->prepare('SELECT * FROM books WHERE id = :id');
$stmt->execute(['id' => $id]);
$book = $stmt->fetch();

if (!$book) {
  echo 'Book not found';
  exit;
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Edit Book</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">LITHUBBOOK</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="../../pages/book/books.php">Books</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../pages/carts/all.php">Carts</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../pages/favorites/all.php">Favorites</a>
          </li>
        </ul>
        <ul class="navbar-nav">
          <?php if (isset($_SESSION['user_id'])): ?>
            <li class="nav-item">
              <form class="form-inline" action="" method="post">
                <button type="submit" class="btn btn-link nav-link" name="logout">Logout</button>
              </form>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <form method="post" action="../../services/book/update.php">
    <input type="hidden" name="id" value="<?= htmlspecialchars($book['id']) ?>">


    <label>Title: </label>
    <input type="text" name="title" value="<?= htmlspecialchars($book['title']) ?>"><br>

    <label>Author </label>
    <input type="text" name="author" value="<?= htmlspecialchars($book['author']) ?>"><br>

    <label>Price:</label>
    <input type="number" name="price" value="<?= htmlspecialchars($book['price']) ?>"><br>
    <input type="submit" value="Update">
  </form>
</body>

</html>