<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('HTTP/1.0 405 Method Not Allowed');
    exit;
}

// Kiểm tra xem đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    header('Location: ../../pages/user/login.html');
    exit;
}

// Kết nối đến cơ sở dữ liệu
$db = mysqli_connect('localhost', 'root', '', 'lithubbook');

// Kiểm tra kết nối
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

// Lấy thông tin sản phẩm được gửi từ form
$product_id = $_POST['product_id'];
$quantity = $_POST['quantity'];

// Kiểm tra xem giỏ hàng đã tồn tại cho user_id hay chưa
$user_id = $_SESSION['user_id'];
$query = "SELECT id FROM carts WHERE user_id = $user_id";
$result = mysqli_query($db, $query);

if (mysqli_num_rows($result) == 0) {
    // Nếu giỏ hàng chưa tồn tại, tạo mới
    $query = "INSERT INTO carts (user_id, created_at) VALUES ($user_id, NOW())";
    if (!mysqli_query($db, $query)) {
        echo "Error: " . $query . "<br>" . mysqli_error($db);
        exit;
    }
    // Lấy cart_id mới tạo
    $cart_id = mysqli_insert_id($db);
} else {
    // Nếu giỏ hàng đã tồn tại, lấy cart_id
    $row = mysqli_fetch_assoc($result);
    $cart_id = $row['id'];
}

// Kiểm tra xem sản phẩm đã tồn tại trong giỏ hàng chưa
$query = "SELECT * FROM cart_items WHERE cart_id = $cart_id AND book_id = $product_id";
$result = mysqli_query($db, $query);

if (mysqli_num_rows($result) > 0) {
    // Nếu sản phẩm đã tồn tại, cập nhật số lượng
    $row = mysqli_fetch_assoc($result);
    $new_quantity = $row['quantity'] + $quantity;
    $query = "UPDATE cart_items SET quantity = $new_quantity WHERE cart_id = $cart_id AND book_id = $product_id";
} else {
    // Nếu sản phẩm chưa tồn tại, thêm mới vào giỏ hàng
    $query = "INSERT INTO cart_items (cart_id, book_id, quantity) VALUES ($cart_id, $product_id, $quantity)";
}

if (!mysqli_query($db, $query)) {
    echo "Error: " . $query . "<br>" . mysqli_error($db);
    exit;
}

// Chuyển hướng trở lại trang trước
header('Location: ../../pages/carts/all.php');
?>