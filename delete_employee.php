<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "ql_nhansu";


$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (isset($_GET['ma_nv']) && !empty($_GET['ma_nv'])) {
    $ma_nv = $_GET['ma_nv'];


    $sql = "DELETE FROM nhanvien WHERE Ma_NV = '$ma_nv'";


    if ($conn->query($sql) === TRUE) {
        echo "Nhân viên đã được xóa thành công.";

        echo "<script>window.location.href = 'index.php';</script>";
    } else {
        echo "Lỗi: " . $conn->error;
    }
} else {
    echo "Mã nhân viên không hợp lệ hoặc không được cung cấp.";
}


$conn->close();
