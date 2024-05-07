<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../../pages/user/login.html');
    exit;
}

$user_id = $_SESSION['user_id'];

// Kết nối đến cơ sở dữ liệu
$db = mysqli_connect('localhost', 'root', '', 'lithubbook');

// Kiểm tra kết nối
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

// Tạo giỏ hàng mới
$query = "INSERT INTO carts (user_id) VALUES ($user_id)";

if (mysqli_query($db, $query)) {
    $new_cart_id = mysqli_insert_id($db); // Lấy ID của giỏ hàng mới
    mysqli_close($db);
    header("Location: ../../pages/carts/add.php?cart_id=$new_cart_id"); // Chuyển hướng đến trang thêm book vào giỏ hàng mới
    exit;
} else {
    echo "Error creating new cart: " . mysqli_error($db);
}

mysqli_close($db);
?>