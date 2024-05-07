<!-- Design the HTML form to add new book  -->
<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
  session_destroy(); // Xóa tất cả các session
  header('Location: ../../pages/user/login.php'); // Chuyển hướng về trang đăng nhập
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Add new Book</title>
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
  <h1>Adding new Book</h1>
  <form action="../../services/book/add.php" method="post">
    <div>
      <label>Title:</label>
      <input type="text" name="title" required />
    </div>
    <div>
      <label>Author:</label>
      <input type="text" name="author" required />
    </div>
    <div>
      <label>Price:</label>
      <input type="number" name="price" required />
    </div>
    <button type="submit">Add new book</button>
  </form>
</body>

</html>