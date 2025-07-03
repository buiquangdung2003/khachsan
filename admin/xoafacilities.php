<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
$con = mysqli_connect("localhost", "root", "", "khachsan");

if (!$con) {
    die("Kết nối thất bại");
}

$Id = $_GET['ID1'];

// Kiểm tra xem tiện ích đã được sử dụng trong phòng hay chưa
$query_check_usage = "SELECT COUNT(*) AS count FROM room_facilities WHERE facilities_id = $Id";
$result_check_usage = mysqli_query($con, $query_check_usage);
$row_check_usage = mysqli_fetch_assoc($result_check_usage);
$count = $row_check_usage['count'];

if ($count > 0) {
    // Đặc Tính Phòng đã được sử dụng trong phòng, không thể xóa
    echo "<script>alert('Không thể xóa Tiện Ích Phòng đã được sử dụng.');</script>";
} else {
    // Xóa Đặc Tính Phòng nếu không có phòng sử dụng
    $query_delete = "DELETE FROM facilities WHERE Id = $Id";
    $result_delete = mysqli_query($con, $query_delete);
    echo "<script>alert('Xóa thành công');</script>";
}

// Chuyển hướng sau khi xóa
echo "<script>window.location.href='/khachsan/admin/features_facilities.php';</script>";
?>
</body>
</html>