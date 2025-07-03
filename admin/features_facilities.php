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
              <h5 class="card-title m-0">Đặc Tính Phòng</h5>
                <a class="btn btn-success" href="/khachsan/admin/themfeatures.php">Thêm</a>
            </div>

            <div class="table-responsive-md" style="height: 350px; overflow-y: scroll;">
              <table class="table table-hover border">
                <thead>
                  <tr class="bg-dark text-light">
                    <th scope="col">#</th>
                    <th scope="col">Tên</th>
                    <th scope="col">Hành Động</th>
                  </tr>
                </thead>
                <tbody id="features-data"> 

                <?php 
            $conn = mysqli_connect("localhost", "root", "", "khachsan");
            // cau lenh
            $sql = "SELECT * FROM features";
            // thuc thi cau lenh
            $result = mysqli_query($conn, $sql);
            // duyet qua result va in ra 
            $count=1;
            while ($row = mysqli_fetch_assoc($result)) {
              echo "<tr>";            
              echo "<td>" . $count . "</td>";
              echo "<td>" . $row["name"] . "</td>";
              echo "<td><a class='btn btn-info' href='/khachsan/admin/suafeatures.php/?ID="  . $row['id'] ."'>Sửa</a>
                          <a class='btn btn-danger' href='/khachsan/admin/xoafeatures.php/?ID1=" . $row['id'] . "' onclick=\"return confirm('Bạn có muốn xóa không?')\">Xóa</a></td>";
              echo "</tr>";
              $count++;
          }
            
?>            
                </tbody>
              </table>
            </div>
          </div>
            <div class="card border-0 shadow-sm mb-4">
          <div class="card-body">

            <div class="d-flex align-items-center justify-content-between mb-3">
              <h5 class="card-title m-0">Tiện Nghi & Trang Thiết Bị</h5>
              <a class="btn btn-success" href="/khachsan/admin/themfacilities.php">Thêm</a>
            </div>

            <div class="table-responsive-md" style="height: 350px; overflow-y: scroll;">
              <table class="table table-hover border">
                <thead>
                  <tr class="bg-dark text-light">
                    <th scope="col">#</th>
                    <th scope="col">Tên</th>
                    <th scope="col" width="40%">Mô Tả</th>
                    <th scope="col">Hành Động</th>
                  </tr>
                </thead>
                <tbody id="facilities-data">                 
                </tbody>
                <?php 
                $conn = mysqli_connect("localhost", "root", "", "khachsan");
                $sql = "SELECT * FROM facilities";
                $result = mysqli_query($conn, $sql);
                $count = 1;
                while ($row = mysqli_fetch_array($result))
                {
                  echo "<td>" . $count . "</td>";
                  echo "<td>" .$row['name']."</td>";
                  echo "<td>" .$row['description']."</td>";
                  echo "<td><a class='btn btn-info' href='/khachsan/admin/suafacilities.php/?ID="  . $row['id'] ."'>Sửa</a>
                          <a class='btn btn-danger' href='/khachsan/admin/xoafacilities.php/?ID1=" . $row['id'] . "' onclick=\"return confirm('Bạn có muốn xóa không?')\">Xóa</a></td>";
              echo "</tr>";
              $count++;
                }

                ?>
              </table>
            </div>

          </div>
        </div>
  
</body>
</html>