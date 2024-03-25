
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
$ma_phong = $_POST['ma_phong'];
$luong = $_POST['luong'];


$sql = "INSERT INTO nhanvien (Ma_NV, Ten_NV, Phai, Noi_Sinh, Ma_Phong, Luong) 
        VALUES ('$ma_nv', '$ten_nv', '$phai', '$noi_sinh', '$ma_phong', '$luong')";

if ($conn->query($sql) === TRUE) {

    header("Location: index.php");
    exit();
} else {
    echo "Lỗi: " . $sql . "<br>" . $conn->error;
}


$conn->close();
