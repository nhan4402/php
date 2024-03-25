<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "ql_nhansu";


$conn = new mysqli($servername, $username, $password, $database);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$ma_nv = $_POST['ma_nv'];
$ten_nv = $_POST['ten_nv'];
$phai = $_POST['phai'];
$noi_sinh = $_POST['noi_sinh'];

$luong = $_POST['luong'];

$sql = "UPDATE nhanvien 
        SET Ten_NV = '$ten_nv', Phai = '$phai', Noi_Sinh = '$noi_sinh', Luong = '$luong' 
        WHERE Ma_NV = '$ma_nv'";

if ($conn->query($sql) === TRUE) {
    echo "Cập nhật thông tin nhân viên thành công.";


    echo "<script>setTimeout(function(){ window.location.href = 'index.php'; }, 1000);</script>";
} else {
    echo "Lỗi: " . $sql . "<br>" . $conn->error;
}
$stmt->close();
$conn->close();
