<?php $conn = mysqli_connect('localhost', 'root', '', 'khachsan'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel - Cơ Sở và Tiện Nghi</title>
  <?php require('inc/links.php'); ?>

<body>
<?php require('inc/header.php'); ?>
<div class="container-fluid" id="main-content">
    <div class="row">
      <div class="col-lg-10 ms-auto p-4 overflow-hidden">
        <h3 class="mb-4">Cơ Sở và Tiện Nghi</h3>

        <div class="card border-0 shadow-sm mb-4">
          <div class="card-body">

          <div class="d-flex align-items-center justify-content-between mb-3">
              <h5 class="card-title m-0">Đặc tính phòng</h5>
            </div>
            <?php // Kết nối đến cơ sở dữ liệu
                $con = mysqli_connect("localhost", "root", "", "khachsan");

                // Kiểm tra nếu không thể kết nối
                if (!$con) {
                    die("Kết nối thất bại: " . mysqli_connect_error());
                }

                // Kiểm tra xem có tham số 'ID' trong URL hay không
                if (isset($_GET['ID'])) {
                    $id = $_GET['ID'];

                    // Truy vấn để lấy thông tin features dựa trên ID
                    $sql = "SELECT * FROM features WHERE id = $id";
                    $result = mysqli_query($con, $sql);
                    $kq = mysqli_fetch_assoc($result);        

                } ?>
            <form method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Tên</label>
                    <input class="form-control" id="name" type="text" name="name" value="<?php echo $kq['name'];?>" >
                </div>
                <br>
                <button type="submit" class="btn btn-primary" name="btnsubmit">Update</button>
                <a class="btn btn-warning" href="/khachsan/admin/features_facilities.php" name="" style="float:right; color:blue">Quay lại</a>
                </form>
            </div>
            <?php
// Kết nối đến cơ sở dữ liệu
$con = mysqli_connect("localhost", "root", "", "khachsan");

// Kiểm tra nếu không thể kết nối
if (!$con) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}

// Kiểm tra xem có tham số 'ID' trong URL hay không
if (isset($_GET['ID'])) {
    $id = $_GET['ID'];

    // Truy vấn để lấy thông tin facilities dựa trên ID
    $sql = "SELECT * FROM features WHERE id = $id";
    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $ten = $row['name'];
    } else {
        echo "Không tìm thấy features với ID = $id";
        exit;
    }
}

// Xử lý sự kiện nút cập nhật (sửa) thông tin
if (isset($_POST['btnsubmit'])) {
    $newTen = $_POST['name'];

    // Cập nhật thông tin features trong cơ sở dữ liệu
    $updateSQL = "UPDATE features SET name = '$newTen' WHERE id = $id";
    $updateResult = mysqli_query($con, $updateSQL);

    if ($updateResult) {
        echo "<script type='text/javascript'>alert('Cập nhật thành công'); window.location.href='/khachsan/admin/features_facilities.php';</script>";
    } else {
        echo "Lỗi: " . $updateSQL . "<br>" . mysqli_error($con);
    }
}

// Đóng kết nối cơ sở dữ liệu
mysqli_close($con);
?>

</div>
</div>

</body>
</html>