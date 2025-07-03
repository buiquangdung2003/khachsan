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
  <title>Admin Panel - Hồ Sơ Đặt Phòng</title>
  <?php require('inc/links.php'); ?>
</head>
<body class="bg-light">

  <?php require('inc/header.php'); ?>

  <div class="container-fluid" id="main-content">
    <div class="row">
      <div class="col-lg-10 ms-auto p-4 overflow-hidden">
        <h3 class="mb-4">Hồ Sơ Đặt Phòng</h3>

        <div class="card border-0 shadow-sm mb-4">
          <div class="card-body">

            <div class="text-end mb-4">
              <input type="text" id="search_input" oninput="get_bookings(this.value)" class="form-control shadow-none w-25 ms-auto" placeholder="Nhập để tìm kiếm...">
            </div>

            <div class="table-responsive">
              <table class="table table-hover border" style="min-width: 1200px;">
                <thead>
                  <tr class="bg-dark text-light">
                    <th scope="col">#</th>
                    <th scope="col">Khách Hàng</th>
                    <th scope="col">Phòng</th>
                    <th scope="col">Chi Tiết Phòng Đặt</th>
                    <th scope="col">Trạng Thái</th>
                    <th scope="col">Hành Động</th>
                  </tr>
                </thead>
                <tbody id="table-data">                 
                </tbody>
              </table>
            </div>

            <nav>
              <ul class="pagination mt-3" id="table-pagination">
              </ul>
            </nav>

          </div>
        </div>

      </div>
    </div>
  </div>



  <?php require('inc/scripts.php'); ?>

  <script src="scripts/booking_records.js"></script>

  <!-- Modal Gia hạn -->
<div class="modal fade" id="extendBookingModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="extend-booking-form">
        <div class="modal-header">
          <h5 class="modal-title">Gia hạn đặt phòng</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="booking_id" id="extend_booking_id">
          <label for="extra_days">Chọn số ngày gia hạn:</label>
          <select class="form-select" name="extra_days" id="extra_days">
            <option value="1">+1 ngày</option>
            <option value="2">+2 ngày</option>
          </select>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Xác nhận</button>
        </div>
      </form>
    </div>
  </div>
</div>

</body>
</html>