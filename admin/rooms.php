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
  <title>Admin - Phòng</title>
  <?php require('inc/links.php'); ?>
</head>
<body class="bg-light">

  <?php require('inc/header.php'); ?>

  <div class="container-fluid" id="main-content">
    <div class="row">
      <div class="col-lg-10 ms-auto p-4 overflow-hidden">
        <h3 class="mb-4">PHÒNG</h3>

        <div class="card border-0 shadow-sm mb-4">
          <div class="card-body">

            <div class="text-end mb-4">
              <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#add-room">
                <i class="bi bi-plus-square"></i> Thêm
              </button>
            </div>

            <div class="table-responsive-lg" style="height: 450px; overflow-y: scroll;">
              <table class="table table-hover border text-center">
                <thead>
                  <tr class="bg-dark text-light">
                    <th scope="col">#</th>
                    <th scope="col">Tên Phòng</th>
                    <th scope="col">Diện Tích</th>
                    <th scope="col">Khách Hàng</th>
                    <th scope="col">Giá</th>
                    <th scope="col">Số Lượng</th>
                    <th scope="col">Trạng Thái</th>
                    <th scope="col">Hành Động</th>
                  </tr>
                </thead>
                <tbody id="room-data">                 
                </tbody>
              </table>
            </div>

          </div>
        </div>

      </div>
    </div>
  </div>
  

  <!-- Thêm phòng -->

  <div class="modal fade" id="add-room" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <form id="add_room_form" autocomplete="off">
        <div class="modal-content">
          <div>
            <h5>Thêm Phòng</h5>
          </div>
          <div class="modal-body">
            <div >
              <div>
                <label>Tên</label>
                <input type="text" name="name" class="form-control shadow-none" required>
              </div>
              <div>
                <label>Diện Tích</label>
                <input type="number" min="1" name="area" class="form-control shadow-none" required>
              </div>
              <div>
                <label>Giá</label>
                <input type="number" min="1" name="price" class="form-control shadow-none" required>
              </div>
              <div>
                <label>Số Lượng</label>
                <input type="number" min="1" name="quantity" class="form-control shadow-none" required>
              </div>
              <div >
                <label>Người Lớn</label>
                <input type="number" min="1" name="adult" class="form-control shadow-none" required>
              </div>
              <div >
                <label>Trẻ Em</label>
                <input type="number" min="1" name="children" class="form-control shadow-none" required>
              </div>
              <div >
                <label>Đặc Tính</label>
                <div class="row">
                  <?php 
                    $res = selectAll('features');
                    while($opt = mysqli_fetch_assoc($res)){
                      echo"
                        <div class='col-md-3 mb-1'>
                          <label>
                            <input type='checkbox' name='features' value='$opt[id]' class='form-check-input shadow-none'>
                            $opt[name]
                          </label>
                        </div>
                      ";
                    }
                  ?>
                </div>
              </div>
              <div>
                <label>Tiện Nghi & Trang Thiết Bị</label>
                <div class="row">
                  <?php 
                    $res = selectAll('facilities');
                    while($opt = mysqli_fetch_assoc($res)){
                      echo"
                        <div class='col-md-3 mb-1'>
                          <label>
                            <input type='checkbox' name='facilities' value='$opt[id]' class='form-check-input shadow-none'>
                            $opt[name]
                          </label>
                        </div>
                      ";
                    }
                  ?>
                </div>
              </div>
              <div>
                <label>Mô Tả</label>
                <textarea name="desc" rows="4" class="form-control shadow-none" required></textarea>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">Huỷ</button>
            <button type="submit" class="btn custom-bg text-white shadow-none">Thêm</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- Sửa-->

  <div class="modal fade" id="edit-room" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <form id="edit_room_form" autocomplete="off">
        <div class="modal-content">
          <div>
            <h5>Cập Nhật Phòng</h5>
          </div>
          <div class="modal-body">
            <div>
              <div>
                <label>Tên Phòng</label>
                <input type="text" name="name" class="form-control shadow-none" required>
              </div>
              <div>
                <label>Diện Tích</label>
                <input type="number" min="1" name="area" class="form-control shadow-none" required>
              </div>
              <div>
                <label>Giá</label>
                <input type="number" min="1" name="price" class="form-control shadow-none" required>
              </div>
              <div>
                <label>Số Lượng</label>
                <input type="number" min="1" name="quantity" class="form-control shadow-none" required>
              </div>
              <div>
                <label>Người Lớn</label>
                <input type="number" min="1" name="adult" class="form-control shadow-none" required>
              </div>
              <div>
                <label>Trẻ Em</label>
                <input type="number" min="1" name="children" class="form-control shadow-none" required>
              </div>
              <div>
                <label>Đặc Tính</label>
                <div class="row">
                  <?php 
                    $res = selectAll('features');
                    while($opt = mysqli_fetch_assoc($res)){
                      echo"
                        <div>
                          <label>
                            <input type='checkbox' name='features' value='$opt[id]' class='form-check-input shadow-none'>
                            $opt[name]
                          </label>
                        </div>
                      ";
                    }
                  ?>
                </div>
              </div>
              <div>
                <labe>Tiện Nghi & Trang Thiết Bị</labe>
                <div class="row">
                  <?php 
                    $res = selectAll('facilities');
                    while($opt = mysqli_fetch_assoc($res)){
                      echo"
                        <div>
                          <label>
                            <input type='checkbox' name='facilities' value='$opt[id]' class='form-check-input shadow-none'>
                            $opt[name]
                          </label>
                        </div>
                      ";
                    }
                  ?>
                </div>
              </div>
              <div>
                <label>Mô Tả</label>
                <textarea name="desc" rows="4" class="form-control shadow-none" required></textarea>
              </div>
              <input type="hidden" name="room_id">
            </div>
          </div>
          <div class="modal-footer">
            <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">Huỷ</button>
            <button type="submit" class="btn custom-bg text-white shadow-none">Cập Nhật</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!--Ảnh -->

  <div class="modal fade" id="room-images" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tên Phòng</h5>
          <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div id="image-alert"></div>
          <div class="border-bottom border-3 pb-3 mb-3">
            <form id="add_image_form">
              <label class="form-label fw-bold">Thêm Ảnh</label>
              <input type="file" name="image" accept=".jpg, .png, .webp, .jpeg" class="form-control shadow-none mb-3" required>
              <button class="btn custom-bg text-white shadow-none">Thêm</button>
              <input type="hidden" name="room_id">
            </form>
          </div>
          <div class="table-responsive-lg" style="height: 350px; overflow-y: scroll;">
            <table class="table table-hover border text-center">
              <thead>
                <tr class="bg-dark text-light sticky-top">
                  <th scope="col" width="60%">Ảnh</th>
                  <th scope="col">Trạng Thái</th>
                  <th scope="col">Xoá</th>
                </tr>
              </thead>
              <tbody id="room-image-data">                 
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>


  <?php require('inc/scripts.php'); ?>

  <script src="scripts/rooms.js"></script>

</body>
</html>