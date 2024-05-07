<!-- Remove an item from cart -->

<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../../pages/user/login.html');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('HTTP/1.0 405 Method Not Allowed');
    exit;
}

if (!isset($_POST['cart_id']) || !isset($_POST['book_id'])) {
    header('HTTP/1.0 400 Bad Request');
    exit;
}

$cart_id = $_POST['cart_id'];
$book_id = $_POST['book_id'];

// Kết nối đến cơ sở dữ liệu
$db = mysqli_connect('localhost', 'root', '', 'lithubbook');

// Kiểm tra kết nối
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

$user_id = $_SESSION['user_id'];

// Xóa mặt hàng từ giỏ hàng
$query = "DELETE FROM cart_items WHERE cart_id = $cart_id AND book_id = $book_id";

if (mysqli_query($db, $query)) {
    echo "Item removed successfully";
} else {
    echo "Error: " . $query . "<br>" . mysqli_error($db);
}

mysqli_close($db);
?>