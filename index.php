<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "ql_nhansu";


$conn = new mysqli($servername, $username, $password, $database);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$records_per_page = 5;


if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $current_page = $_GET['page'];
} else {
    $current_page = 1;
}


$offset = ($current_page - 1) * $records_per_page;


$sql = "SELECT n.Ma_NV, n.Ten_NV, n.Phai, n.Noi_Sinh, p.Ten_Phong, n.Luong 
        FROM nhanvien AS n
        INNER JOIN phongban AS p ON n.Ma_Phong = p.Ma_Phong
        LIMIT $offset, $records_per_page";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách nhân viên</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        button {
            padding: 8px 16px;
            cursor: pointer;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
        }

        button:hover {
            background-color: #45a049;
        }

        form {
            margin-bottom: 20px;
        }

        form label {
            font-weight: bold;
            margin-right: 10px;
        }

        form input[type="text"] {
            padding: 5px;
            width: 200px;
        }

        .edit-form {
            margin-top: 10px;
        }

        .edit-form h3 {
            margin-top: 0;
        }

        .edit-form input[type="submit"] {
            padding: 8px 16px;
            cursor: pointer;
            background-color: #008CBA;
            color: white;
            border: none;
            border-radius: 4px;
        }

        .edit-form input[type="submit"]:hover {
            background-color: #005f7f;
        }

        #add-form {
            display: none;
        }

        .edit-form {
            display: none;
        }
    </style>
</head>

<body>
    <h2>Danh sách nhân viên</h2>
    <button onclick="toggleAddForm()">ADD</button>
    <div id="add-form">
        <h3>Thêm nhân viên mới</h3>
        <form action="add_employee.php" method="POST">
            <label for="ma_nv">Mã Nhân Viên:</label><br>
            <input type="text" id="ma_nv" name="ma_nv"><br>
            <label for="ten_nv">Tên Nhân Viên:</label><br>
            <input type="text" id="ten_nv" name="ten_nv"><br>
            <label for="phai">Giới tính:</label><br>
            <input type="text" id="phai" name="phai"><br>
            <label for="noi_sinh">Nơi Sinh:</label><br>
            <input type="text" id="noi_sinh" name="noi_sinh"><br>
            <label for="ma_phong">Mã Phòng:</label><br>
            <input type="text" id="ma_phong" name="ma_phong"><br>
            <label for="luong">Lương:</label><br>
            <input type="text" id="luong" name="luong"><br><br>
            <input type="submit" value="Submit">
        </form>
    </div>
    <br>
    <table>
        <tr>
            <th>Mã Nhân Viên</th>
            <th>Tên Nhân Viên</th>
            <th>Giới tính</th>
            <th>Nơi Sinh</th>
            <th>Tên Phòng</th>
            <th>Lương</th>
            <th>Update</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["Ma_NV"] . "</td>";
                echo "<td>" . $row["Ten_NV"] . "</td>";
                echo "<td>";
                if ($row["Phai"] == "NAM") {
                    echo "<img src='nam.png' alt='Nam' width='50'>";
                } elseif ($row["Phai"] == "NU") {
                    echo "<img src='nữ.png' alt='Nữ' width='50'>";
                }
                echo "</td>";
                echo "<td>" . $row["Noi_Sinh"] . "</td>";
                echo "<td>" . $row["Ten_Phong"] . "</td>";
                echo "<td>" . $row["Luong"] . "</td>";
                echo "<td>
                <button onclick=\"toggleEditForm('edit-form-" . $row["Ma_NV"] . "')\">Sửa</button>
                <button onclick=\"confirmDelete('" . $row["Ma_NV"] . "')\">Xóa</button>
              </td>";

                echo "</tr>";
        ?>

                <tr>
                    <td colspan="7">
                        <div id="edit-form-<?php echo $row["Ma_NV"]; ?>" class="edit-form">
                            <h3>Sửa thông tin nhân viên</h3>
                            <form action="update_employee.php" method="POST">
                                <input type="hidden" name="ma_nv" value="<?php echo $row["Ma_NV"]; ?>">
                                <label for="ten_nv">Tên Nhân Viên:</label><br>
                                <input type="text" id="ten_nv" name="ten_nv" value="<?php echo $row["Ten_NV"]; ?>"><br>
                                <label for="phai">Giới tính:</label><br>
                                <input type="text" id="phai" name="phai" value="<?php echo $row["Phai"]; ?>"><br>
                                <label for="noi_sinh">Nơi Sinh:</label><br>
                                <input type="text" id="noi_sinh" name="noi_sinh" value="<?php echo $row["Noi_Sinh"]; ?>"><br>

                                <label for="luong">Lương:</label><br>
                                <input type="text" id="luong" name="luong" value="<?php echo $row["Luong"]; ?>"><br><br>
                                <input type="submit" value="Cập nhật">
                            </form>
                        </div>
                    </td>
                </tr>
        <?php
            }
        } else {
            echo "<tr><td colspan='7'>Không có nhân viên nào.</td></tr>";
        }
        ?>
    </table>

    <?php

    $sql = "SELECT COUNT(*) AS total_records FROM nhanvien";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $total_records = $row['total_records'];
    $total_pages = ceil($total_records / $records_per_page);


    echo "<br>";
    for ($i = 1; $i <= $total_pages; $i++) {
        echo "<a href='?page=$i'>$i</a> ";
    }
    ?>
</body>

</html>
<script>
    function toggleAddForm() {
        var form = document.getElementById('add-form');
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    }

    function toggleEditForm(formId) {
        var form = document.getElementById(formId);
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    }

    function confirmDelete(employeeId) {
        if (confirm("Bạn có chắc chắn muốn xóa nhân viên này?")) {

            window.location.href = "delete_employee.php?ma_nv=" + employeeId;
        }
    }
</script>
<?php

$conn->close();
?>