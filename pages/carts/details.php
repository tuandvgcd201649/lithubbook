<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    session_destroy(); // Xóa tất cả các session
    header('Location: ../../pages/user/login.html'); // Chuyển hướng về trang đăng nhập
    exit;
}

if (!isset($_SESSION['user_id'])) {
    header('Location: ../../pages/user/login.php');
    exit;
}

// Kiểm tra xem có tham số cart_id được truyền qua không
if (!isset($_GET['cart_id'])) {
    echo "Cart ID is missing";
    exit;
}

$cart_id = $_GET['cart_id'];

// Kết nối đến cơ sở dữ liệu
$db = mysqli_connect('localhost', 'root', '', 'lithubbook');

// Kiểm tra kết nối
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

$user_id = $_SESSION['user_id'];

// Lấy thông tin giỏ hàng của người dùng
$query = "SELECT cart_items.book_id, cart_items.quantity, books.title, books.author, books.price 
          FROM cart_items 
          LEFT JOIN books ON cart_items.book_id = books.id
          WHERE cart_items.cart_id = $cart_id";
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
    <title>Cart Details</title>
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
        <h1>Cart Details</h1>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Book ID</th>
                    <th scope="col">Title</th>
                    <th scope="col">Author</th>
                    <th scope="col">Price</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Subtotal</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total_price = 0;
                while ($row = mysqli_fetch_assoc($result)) {
                    $subtotal = $row['price'] * $row['quantity'];
                    $total_price += $subtotal;
                    ?>
                    <tr>
                        <th scope="row"><?php echo $row['book_id']; ?></th>
                        <td><?php echo $row['title']; ?></td>
                        <td><?php echo $row['author']; ?></td>
                        <td>$<?php echo number_format($row['price'], 2); ?></td>
                        <td><?php echo $row['quantity']; ?></td>
                        <td>$<?php echo number_format($subtotal, 2); ?></td>
                        <td>
                            <form action="../../services/carts/remove-item.php" method="post">
                                <input type="hidden" name="cart_id" value="<?php echo $cart_id; ?>">
                                <input type="hidden" name="book_id" value="<?php echo $row['book_id']; ?>">
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="row">
            <div class="col-md-6">
                <h4>Total Price: $<?php echo number_format($total_price, 2); ?></h4>
            </div>
        </div>
    </div>
</body>

</html>