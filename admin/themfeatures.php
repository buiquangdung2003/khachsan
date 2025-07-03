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
            </div>
                <?php
            echo'
            <form method="post" enctype="multipart/form-data">
                <!-- Tên -->
                <div class="form-group">
                    <label for="name">Tên </label>
                    <input class="form-control" id="name" type="text" name="name" value="" >
                </div>
                <br>
                <button type="submit" class="btn btn-primary" name="btnsubmit">Thêm</button>
                <a class="btn btn-warning" href="/khachsan/admin/features_facilities.php" name="" style="float:right; color:blue">Quay lại</a>
                </form>';
                ?>
                <?php
                    try{
                        $con = mysqli_connect("localhost", "root", "", "khachsan");
                        if($_SERVER['REQUEST_METHOD']=="POST" and isset($_POST['btnsubmit'])){
                        if(!$con){
                            die("Kết  nối thất bại");
                        }else{
                            $ten = $_POST['name'];

                            if($ten==""){
                                echo"<script style='text-javascript'>alert('Tên không được để trống')</script>";
                        
                            }else{
                                $sql = "INSERT INTO features (name) VALUES ('$ten')";  
                                $result = mysqli_query($con, $sql);
                            if($result){
                                echo "<script type='text/javascript'>alert('Thêm thành công !!!');
                                window.location.href=\"/khachsan/admin/features_facilities.php\";
                                </script>";
                            }else{
                                echo"Lỗi".$sql."<br>".mysqli_error($con);
                            }
                        }
                        }
                        }
                    }catch(Exception $e){
                        echo "Lỗi: ".$e->getMessage();
                    }
    ?> 
                </tbody>
              </table>
            </div>
  
</body>
</html>
