<?php
  require('inc/essentials.php');
  require('inc/db_config.php');
  adminLogin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>THỐNG KÊ</title>
  <?php require('inc/links.php'); ?>
</head>
<body class="bg-light">

  <?php 
  
    require('inc/header.php'); 
    
    $is_shutdown = mysqli_fetch_assoc(mysqli_query($con,"SELECT `shutdown` FROM `settings`"));

    $current_bookings = mysqli_fetch_assoc(mysqli_query($con,"SELECT 
      COUNT(CASE WHEN booking_status='Đã Thanh Toán' AND arrival=0 THEN 1 END) AS `new_bookings`,
      COUNT(CASE WHEN booking_status='Đã Huỷ' AND refund=0 THEN 1 END) AS `refund_bookings`
      FROM `booking_order`"));

    $unread_queries = mysqli_fetch_assoc(mysqli_query($con,"SELECT COUNT(sr_no) AS `count`
      FROM `user_queries` WHERE `seen`=0"));

    $unread_reviews = mysqli_fetch_assoc(mysqli_query($con,"SELECT COUNT(sr_no) AS `count`
      FROM `rating_review` WHERE `seen`=0"));
    
    $current_users = mysqli_fetch_assoc(mysqli_query($con,"SELECT 
      COUNT(id) AS `total`,
      COUNT(CASE WHEN `status`=1 THEN 1 END) AS `active`,
      COUNT(CASE WHEN `status`=0 THEN 1 END) AS `inactive`,
      COUNT(CASE WHEN `is_verified`=0 THEN 1 END) AS `unverified`
      FROM `user_cred`"));  
  
  ?>
  <?php
      // truy vấn lấy tổng số phòng trong khách sạn
      $query = "SELECT COUNT(*) AS total_rooms FROM rooms";
      $result = mysqli_query($con, $query);
      // kiểm tra kết quả truy vấn
      if ($result) {
          // lấy kết quả dưới dạng mảng kết hợp (associative array)
          $row = mysqli_fetch_assoc($result);
          $total_rooms = $row['total_rooms'];
      }
      // Tong kh dat phong
      $query = "SELECT COUNT(*) AS kh_datphong FROM booking_order  WHERE `booking_status` = 'Đã Đặt'";
      $result1 = mysqli_query($con, $query);
      if ($result1) {
          $row = mysqli_fetch_assoc($result1);
          $kh_datphong = $row['kh_datphong'];
        }
      // Tong doanh thu
      $query = "SELECT SUM(trans_amt) AS tong_doanhthu FROM booking_order";
      $result2 = mysqli_query($con, $query);

      // kiểm tra kết quả truy vấn
      if ($result2) {
          // lấy kết quả dưới dạng mảng kết hợp (associative array)
          $row = mysqli_fetch_assoc($result2);
          // lấy tổng doanh thu
          $tong_doanhthu = $row['tong_doanhthu'];
          // in ra tổng doanh thu
      }
      // $query = "SELECT SUM(total_pay) AS tong_doanhthu FROM booking_details";
      // $result2 = mysqli_query($con, $query);

      // // kiểm tra kết quả truy vấn
      // if ($result2) {
      //     // lấy kết quả dưới dạng mảng kết hợp (associative array)
      //     $row = mysqli_fetch_assoc($result2);
      //     // lấy tổng doanh thu
      //     $tong_doanhthu = $row['tong_doanhthu'];
      //     // in ra tổng doanh thu
      // }

       // truy vấn lấy tổng số đánh giá
       $query = "SELECT COUNT(*) AS total_rating FROM rating_review";
       $result3 = mysqli_query($con, $query);
       // kiểm tra kết quả truy vấn
       if ($result3) {
           // lấy kết quả dưới dạng mảng kết hợp (associative array)
           $row = mysqli_fetch_assoc($result3);
           $total_rating = $row['total_rating'];
       }
       // truy vấn lấy tổng kh
       $query = "SELECT COUNT(*) AS total_khachhang FROM user_cred";
       $result4 = mysqli_query($con, $query);
       // kiểm tra kết quả truy vấn
       if ($result4) {
           // lấy kết quả dưới dạng mảng kết hợp (associative array)
           $row = mysqli_fetch_assoc($result4);
           $total_khachhang = $row['total_khachhang'];
       }
       // truy vấn lấy tổng kh
       $query = "SELECT COUNT(*) AS total_phanhoi FROM user_queries";
       $result5 = mysqli_query($con, $query);
       // kiểm tra kết quả truy vấn
       if ($result5) {
           // lấy kết quả dưới dạng mảng kết hợp (associative array)
           $row = mysqli_fetch_assoc($result5);
           $total_phanhoi = $row['total_phanhoi'];
       }
       // truy vấn lấy tổng phong huy
       $query = "SELECT COUNT(*) AS total_phonghuy FROM booking_order WHERE `booking_status` = 'Đã Huỷ'";
       $result6 = mysqli_query($con, $query);
       // kiểm tra kết quả truy vấn
       if ($result6) {
           // lấy kết quả dưới dạng mảng kết hợp (associative array)
           $row = mysqli_fetch_assoc($result6);
           $total_phonghuy = $row['total_phonghuy'];
       }

             // Tong so phong
      $query = "SELECT SUM(quantity) AS tong_sophong FROM rooms";
      $result7 = mysqli_query($con, $query);
      if ($result7) {
          // lấy kết quả dưới dạng mảng kết hợp (associative array)
          $row = mysqli_fetch_assoc($result7);
          $tong_sophong = $row['tong_sophong'];
      }

      // truy vấn lấy tổng phong da dat
      $query = "SELECT COUNT(*) AS total_bookings FROM booking_order WHERE `booking_status` = 'Đã Xác Nhận Đặt Phòng'";
      $result8 = mysqli_query($con, $query);
      $row = mysqli_fetch_assoc($result8);
      $total_phongdat = $row['total_bookings'];


  ?>
<!-- style="margin-left : 200px" -->
  <div class="container-fluid" id="main-content">
    <div class="row" >
      <div class="col-lg-10 ms-auto p-4 overflow-hidden">
        
        <div class="d-flex align-items-center justify-content-between mb-4">
          <h3>THỐNG KÊ</h3>
          <?php 
            if($is_shutdown['shutdown']){
              echo<<<data
                <h6 class="badge bg-danger py-2 px-3 rounded">Chế độ tắt máy đang hoạt động!</h6>
              data;
            }
          ?>
        </div>

        <div class="row mb-4">
          <div class="col-md-3 mb-4">
            <a href="" class="text-decoration-none">
              <div class="card text-center text-success p-3">
                <h6>Tổng Số Loại Phòng</h6>
                <h1 class="mt-2 mb-0"><?php echo $total_rooms ?></h1>
              </div>
            </a>
          </div>
          <div class="col-md-3 mb-4">
            <a href="" class="text-decoration-none">
              <div class="card text-center text-info p-3">
                <h6>Tổng Số Phòng</h6>
                <h1 class="mt-2 mb-0"><?php echo $tong_sophong ?></h1>
              </div>
            </a>
          </div>
          <div class="col-md-3 mb-4">
            <a href="" class="text-decoration-none">
              <div class="card text-center text-info p-3">
                <h6>Khách Hàng Mới Đặt</h6>
                <h1 class="mt-2 mb-0"><?php echo $kh_datphong ?></h1>
              </div>
            </a>
          </div>
          <div class="col-md-3 mb-4">
            <a href="" class="text-decoration-none">
              <div class="card text-center text-info p-3">
                <h6>Phòng Đang Đặt</h6>
                <h1 class="mt-2 mb-0"><?php echo $total_phongdat ?></h1>
              </div>
            </a>
          </div>



        </div>
        <div class="row mb-3">
        <div class="col-md-3 mb-4">
            <a href="" class="text-decoration-none">
              <div class="card text-center text-info p-3">
                <h6>Phòng Đang Trống</h6>
                <h1 class="mt-2 mb-0"><?php  echo $p_trong = $tong_sophong - $total_phongdat ?></h1>
              </div>
            </a>
          </div>
          <div class="col-md-3 mb-4">
            <a href="" class="text-decoration-none">
              <div class="card text-center text-primary p-3">
                <h6>Xếp hạng và đánh giá</h6>
                <h1 class="mt-2 mb-0"><?php echo $total_rating ?></h1>
              </div>
            </a>
          </div>
          <div class="col-md-3 mb-4">
            <a href="" class="text-decoration-none">
              <div class="card text-center text-info p-3">
                <h6>Khách Hàng Đăng Ký</h6>
                <h1 class="mt-2 mb-0"><?php echo $total_khachhang ?></h1>
              </div>
            </a>
          </div>
          <div class="col-md-3 mb-4">
            <a href="" class="text-decoration-none">
              <div class="card text-center text-warning p-3">
                <h6>Phản Hồi Và Góp Ý</h6>
                <h1 class="mt-2 mb-0"><?php echo $total_phanhoi ?></h1>
              </div>
            </a>
          </div>

          <div class="row mb-4" >
            <div class="col-md-3 mb-4">
              <a href="" class="text-decoration-none">
                <div class="card text-center text-danger p-3">
                  <h6>Phòng Bị Huỷ</h6>
                  <h1 class="mt-2 mb-0"><?php echo $total_phonghuy ?></h1>
                </div>
              </a>
            </div>
            <div class="col-md-3 mb-4">
              <a href="" class="text-decoration-none">
                <div class="card text-center text-success p-3">
                  <h6>Tổng Doanh Thu</h6>
                  <h2 class="mt-2 mb-0"><?php echo $tong_doanhthu ?> vnđ</h2>
                </div>
              </a>
            </div>
          </div>
      </div>
    </div>
  </div>
  

  <?php require('inc/scripts.php'); ?>
  <script src="scripts/dashboard.js"></script>
</body>
</html>