<?php
session_start(); // start a session

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
  session_destroy(); // Xóa tất cả các session
  header('Location: ../../pages/user/login.php'); // Chuyển hướng về trang đăng nhập
  exit;
}

if (!isset($_SESSION['user_id'])) {
  echo ("Not authrozied");
  exit;
}

// use mysqli to connection
$host = 'localhost';
$db = 'lithubbook';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';
// Connect to the database

$db = mysqli_connect($host, $user, $pass, $db);

// Check connection
if (!$db) {
  die("Connection failed: " . mysqli_connect_error());
}

$result = mysqli_query($db, "SELECT * FROM favorites WHERE user_id = " . $_SESSION['user_id']);


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
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
  <table>
    <tr>
      <th>User ID</th>
      <th>Book ID</th>
      <th>Actions</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
      <tr>
        <td><?php echo $row['user_id']; ?></td>
        <td><?php echo $row['book_id']; ?></td>
        <td>
          <a href="../../services/favorites/remove.php?book_id=<?php echo $row['book_id'] ?>" class="btn btn-danger">
            Remove
          </a>
        </td>
      </tr>
    <?php endwhile; ?>
  </table>
</body>

</html>