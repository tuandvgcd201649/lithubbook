<?php
session_start(); // start a session

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
  session_destroy(); // Xóa tất cả các session
  header('Location: ../../pages/user/login.php'); // Chuyển hướng về trang đăng nhập
  exit;
}

if (!isset($_SESSION['user_id'])) {
  header('Location: ../user/login.php'); // redirect to login page if $email is not in the session
  exit;
}

// Connect to the database
$db = mysqli_connect('localhost', 'root', '', 'lithubbook');

// Check connection
if (!$db) {
  die("Connection failed: " . mysqli_connect_error());
}

// Select all books
$result = mysqli_query($db, "SELECT * FROM books");
?>
<!-- Todo: display all books with add to cart button -->

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <title>Document</title>
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
        <ul class="navbar-nav mr-auto">
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
  <h1>Books</h1>
  <div class="container">
    <a href="add.php" class="btn btn-primary">Add new Book</a>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Title</th>
          <th scope="col">Author</th>
          <th scope="col">Price</th>
          <th scope="col">Favorite</th>
          <th scope="col">Edit</th>
          <th scope="col">Delete</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
          <tr>
            <th scope="row"><?php echo $row['id']; ?></th>
            <td><?php echo $row['title']; ?></td>
            <td><?php echo $row['author']; ?></td>
            <td><?php echo $row['price']; ?></td>
            <td>
              <a href="../../services/favorites/add.php?book_id=<?php echo $row['id'] ?>" class="btn btn-primary">
                Add to Favorite
              </a>
            </td>
            <td>
              <a href="./edit.php?id=<?php echo $row['id']; ?>" class="btn btn-secondary">
                Edit
              </a>
            </td>
            <td>
              <a href="../../services/book/delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger">
                Delete
              </a>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</body>

</html>