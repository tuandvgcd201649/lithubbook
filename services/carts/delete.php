<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../../pages/user/login.html');
    exit;
}

// Kiểm tra nếu không có tham số cart_id được gửi
if (!isset($_POST['cart_id'])) {
    echo "Cart ID is missing";
    exit;
}

$cart_id = $_POST['cart_id'];

// Kết nối đến cơ sở dữ liệu
$db = mysqli_connect('localhost', 'root', '', 'lithubbook');

// Kiểm tra kết nối
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

$user_id = $_SESSION['user_id'];

// Kiểm tra xem giỏ hàng thuộc về người dùng hiện tại hay không
$query = "SELECT * FROM carts WHERE id = $cart_id AND user_id = $user_id";
$result = mysqli_query($db, $query);

if (!$result) {
    echo "Error: " . $query . "<br>" . mysqli_error($db);
    exit;
}

if (mysqli_num_rows($result) == 0) {
    echo "Cart not found or does not belong to the current user";
    exit;
}

// Xóa tất cả các mục trong giỏ hàng từ bảng cart_items
$delete_items_query = "DELETE FROM cart_items WHERE cart_id = $cart_id";

if (!mysqli_query($db, $delete_items_query)) {
    echo "Error deleting cart items: " . mysqli_error($db);
    exit;
}

// Sau đó, xóa giỏ hàng từ bảng carts
$delete_cart_query = "DELETE FROM carts WHERE id = $cart_id";

if (mysqli_query($db, $delete_cart_query)) {
    echo "Cart deleted successfully";
} else {
    echo "Error deleting cart: " . mysqli_error($db);
}

mysqli_close($db);
?>