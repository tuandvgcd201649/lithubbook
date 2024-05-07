<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    session_destroy(); // Xóa tất cả các session
    header('Location: ../../pages/user/login.php'); // Chuyển hướng về trang đăng nhập
    exit;
}

if (!isset($_SESSION['user_id'])) {
    header('Location: ../../pages/user/login.php');
    exit;
}

// Kết nối đến cơ sở dữ liệu
$db = mysqli_connect('localhost', 'root', '', 'lithubbook');

// Kiểm tra kết nối
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

$user_id = $_SESSION['user_id'];

// Lấy thông tin giỏ hàng của người dùng
$query = "SELECT carts.id AS cart_id, carts.created_at 
          FROM carts 
          WHERE carts.user_id = $user_id";
$result = mysqli_query($db, $query);

if (!$result) {
    echo "Error: " . $query . "<br>" . mysqli_error($db);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Carts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
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
    <div class="container">
        <div class="row">
            <div class="col">
                <h1>Your Carts</h1>
            </div>
            <div class="col text-end">
                <a href="../../services/carts/new.php" class="btn btn-primary">New Cart</a>
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Cart ID</th>
                    <th scope="col">Created At</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['cart_id']; ?></td>
                        <td><?php echo $row['created_at']; ?></td>
                        <td>

                            <a href="../../pages/carts/add.php" class="btn btn-primary">Add to Cart</a>
                            <a href="details.php?cart_id=<?php echo $row['cart_id']; ?>"
                                class="btn btn-secondary">Details</a>
                        </td>
                        <td>
                            <form action="../../services/carts/delete.php" method="post">
                                <input type="hidden" name="cart_id" value="<?php echo $row['cart_id']; ?>">
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>

</html>