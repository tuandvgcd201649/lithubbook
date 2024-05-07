<?php
session_start();

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

// Lấy dữ liệu từ form
$title = mysqli_real_escape_string($db, $_POST['title']);
$author = mysqli_real_escape_string($db, $_POST['author']);
$price = mysqli_real_escape_string($db, $_POST['price']);

// Thực hiện truy vấn chèn sách mới vào cơ sở dữ liệu
$query = "INSERT INTO books (title, author, price) VALUES ('$title', '$author', '$price')";

if (!mysqli_query($db, $query)) {
    echo "Error: " . $query . "<br>" . mysqli_error($db);
    exit;
} else {
    echo "New record created successfully";
    header('Location: ../../pages/book/books.php');
}

mysqli_close($db);
?>