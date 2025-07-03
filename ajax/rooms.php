<?php 

  require('../admin/inc/db_config.php');
  require('../admin/inc/essentials.php');
  date_default_timezone_set('Asia/Ho_Chi_Minh');


  session_start();
  
/* ===========================================================
   1)  HÀM KIỂM TRA PHÒNG CÒN TRỐNG
   =========================================================== */
function is_room_available(mysqli $con, int $room_id, string $in, string $out): bool
{
    $sql = "SELECT 1
            FROM booking_order
            WHERE room_id = ?
              AND booking_status IN ('Đã Đặt', 'Đã Xác Nhận Đặt Phòng')   -- các trạng thái còn 'giữ' phòng
              AND NOT (check_out <= ? OR check_in >= ?)
            LIMIT 1";
    $stm = $con->prepare($sql);
    $stm->bind_param("iss", $room_id, $in, $out);
    $stm->execute();
    $stm->store_result();
    return $stm->num_rows === 0;   // TRUE  --> phòng còn
}

/* ===========================================================
   2)  API / AJAX: XỬ LÝ ĐẶT PHÒNG
   Gửi từ JS dưới dạng POST: book_room&room_id=...&checkin=...&checkout=...
   Trả JSON: {status:"success" | "unavailable" | "error"}
   =========================================================== */
if (isset($_POST['book_room'])) {

    $data      = filteration($_POST);           // chống XSS
    $room_id   = (int)$data['room_id'] ?? 0;
    $check_in  = $data['checkin']  ?? '';
    $check_out = $data['checkout'] ?? '';
    $uid       = $_SESSION['uid']   ?? 0;       // tuỳ bạn lấy id user thế nào

    /* --- VALIDATE --- */
    if (!$room_id || !$check_in || !$check_out || $check_in >= $check_out) {
        echo json_encode(['status' => 'error']);
        exit;
    }

    $con->begin_transaction();                  // khóa mềm chống race‑condition

    /* --- KIỂM TRA TRÙNG LỊCH --- */
    if (!is_room_available($con, $room_id, $check_in, $check_out)) {
        $con->rollback();
        echo json_encode(['status' => 'unavailable']);
        exit;
    }

    /* --- CHÈN ĐƠN ĐẶT PHÒNG --- */
    $sql  = "INSERT INTO booking_order
             (user_id, room_id, check_in, check_out, booking_status)
             VALUES (?,?,?,?, 'Đã Đặt')";
    $stm  = $con->prepare($sql);
    $stm->bind_param("iiss", $uid, $room_id, $check_in, $check_out);

    if ($stm->execute()) {
        $con->commit();
        echo json_encode(['status' => 'success']);
    } else {
        $con->rollback();
        echo json_encode(['status' => 'error']);
    }
    exit;                                       // kết thúc request POST
}
/* ====== GIỮ NGUYÊN PHÍA DƯỚI  ====== */


  if(isset($_GET['fetch_rooms']))
  {
    // check availability data decode
    $chk_avail = json_decode($_GET['chk_avail'],true);
    
    // checkin and checkout filter validations
    if($chk_avail['checkin']!='' && $chk_avail['checkout']!='')
    {
      $today_date = new DateTime(date("Y-m-d"));
      $checkin_date = new DateTime($chk_avail['checkin']);
      $checkout_date = new DateTime($chk_avail['checkout']);
  
      if($checkin_date == $checkout_date){
        echo"<h3 class='text-center text-danger'>Ngày đã nhập không hợp lệ!</h3>";
        exit;
      }
      else if($checkout_date < $checkin_date){
        echo"<h3 class='text-center text-danger'>Ngày đã nhập không hợp lệ!</h3>";
        exit;
      }
      else if($checkin_date < $today_date){
        echo"<h3 class='text-center text-danger'>Ngày đã nhập không hợp lệ!</h3>";
        exit;
      }
    }

    // guests data decode
    $guests = json_decode($_GET['guests'],true);
    $adults = ($guests['adults']!='') ? $guests['adults'] : 0;
    $children = ($guests['children']!='') ? $guests['children'] : 0;

    // facilities data decode
    $facility_list = json_decode($_GET['facility_list'],true);

    // count no. of rooms and ouput variable to store room cards
    $count_rooms = 0;
    $output = "";


    // fetching settings table to check website is shutdown or not
    $settings_q = "SELECT * FROM `settings` WHERE `sr_no`=1";
    $settings_r = mysqli_fetch_assoc(mysqli_query($con,$settings_q));


    // truy vấn thẻ phòng với bộ lọc khách
    $room_res = select("SELECT * FROM `rooms` WHERE `adult`>=? AND `children`>=? AND `status`=? AND `removed`=?",[$adults,$children,1,0],'iiii');

    while($phong_data = mysqli_fetch_assoc($room_res))
    {
      // check availability filter
      if($chk_avail['checkin']!='' && $chk_avail['checkout']!='')
      {
        // $tb_query = "SELECT COUNT(*) AS `total_bookings` FROM `booking_order`
        //   WHERE booking_status=? AND room_id=?
        //   AND check_out > ? AND check_in < ?";

        // $values = ['Đã Thanh Toán',$room_data['id'],$chk_avail['checkin'],$chk_avail['checkout']];
        // $tb_fetch = mysqli_fetch_assoc(select($tb_query,$values,'siss'));

        // if(($room_data['quantity']-$tb_fetch['total_bookings'])==0){
        //   continue;
        // }
        $tb_query = "SELECT COUNT(*) AS `total_bookings` FROM `booking_order`
        WHERE booking_status IN ('Đã Đặt', 'Đã Xác Nhận Đặt Phòng')
        AND room_id=?
        AND NOT (check_out < ? OR check_in > ?)";

        $values = [$phong_data['id'],$chk_avail['checkin'],$chk_avail['checkout']];
        $tb_fetch = mysqli_fetch_assoc(select($tb_query,$values,'iss'));

        if(($phong_data['quantity']-$tb_fetch['total_bookings'])==0){
          continue;
        }

        // $tb_query = "SELECT COUNT(*) AS `total_bookings` FROM `booking_order`
        // WHERE booking_status IN ('Đã Đặt', 'Đã Xác Nhận Đặt Phòng')
        // AND room_id=?
        // AND NOT (check_out < ? OR check_in > ?)";

        // $values = [$_SESSION['room']['id'],$frm_data['check_in'],$frm_data['check_out']];
        // $tb_fetch = mysqli_fetch_assoc(select($tb_query,$values,'iss'));
        
        // $rq_result = select("SELECT `quantity` FROM `rooms` WHERE `id`=?",[$_SESSION['room']['id']],'i');
        // $rq_fetch = mysqli_fetch_assoc($rq_result);
        // $count_rooms = $rq_fetch['quantity']-$tb_fetch['total_bookings'];
        // if(($rq_fetch['quantity']-$tb_fetch['total_bookings'])==0){
        //   $status = 'unavailable';
        //   $result = json_encode(['status'=>$status]);
        //   echo $result;
        //   exit;
        // }
      }

      // get facilities of room with filters
      $fac_count=0;

      $fac_q = mysqli_query($con,"SELECT f.name, f.id FROM `facilities` f 
        INNER JOIN `room_facilities` rfac ON f.id = rfac.facilities_id 
        WHERE rfac.room_id = '$phong_data[id]'");

      $facilities_data = "";
      while($fac_row = mysqli_fetch_assoc($fac_q))
      {
        if( in_array($fac_row['id'],$facility_list['facilities']) ){
          $fac_count++;
        }

        $facilities_data .="<span class='badge rounded-pill bg-light text-dark text-wrap me-1 mb-1'>
          $fac_row[name]
        </span>";
      }

      if(count($facility_list['facilities'])!=$fac_count){
        continue;
      }


      // get features of room

      $fea_q = mysqli_query($con,"SELECT f.name FROM `features` f 
        INNER JOIN `room_features` rfea ON f.id = rfea.features_id 
        WHERE rfea.room_id = '$phong_data[id]'");

      $features_data = "";
      while($fea_row = mysqli_fetch_assoc($fea_q)){
        $features_data .="<span class='badge rounded-pill bg-light text-dark text-wrap me-1 mb-1'>
          $fea_row[name]
        </span>";
      }


      // get thumbnail of image

      $room_thumb = anh_phong."thumbnail.jpg";
      $thumb_q = mysqli_query($con,"SELECT * FROM `room_images` 
        WHERE `room_id`='$phong_data[id]' 
        AND `thumb`='1'");

      if(mysqli_num_rows($thumb_q)>0){
        $thumb_res = mysqli_fetch_assoc($thumb_q);
        $room_thumb = anh_phong.$thumb_res['image'];
      }

      $book_btn = "";

      if(!$settings_r['shutdown']){
        $login=0;
        if(isset($_SESSION['login']) && $_SESSION['login']==true){
          $login=1;
        }

        $book_btn = "<button onclick='checkLoginToBook($login,$phong_data[id])' class='btn btn-sm w-100 text-white custom-bg shadow-none mb-2'>Đặt Ngay</button>";
      }

      // print room card

      $output.="
        <div class='card mb-4 border-0 shadow'>
          <div class='row g-0 p-3 align-items-center'>
            <div class='col-md-5 mb-lg-0 mb-md-0 mb-3'>
              <img src='$room_thumb' class='img-fluid rounded'>
            </div>
            <div class='col-md-5 px-lg-3 px-md-3 px-0'>
              <h5 class='mb-3'>$phong_data[name]</h5>
              <div class='features mb-3'>
                <h6 class='mb-1'>Cơ Sở</h6>
                $features_data
              </div>
              <div class='facilities mb-3'>
                <h6 class='mb-1'>Tiện Nghi</h6>
                $facilities_data
              </div>
              <div class='guests'>
                <h6 class='mb-1'>Khách Hàng</h6>
                <span class='badge rounded-pill bg-light text-dark text-wrap'>
                  $phong_data[adult] Người Lớn
                </span>
                <span class='badge rounded-pill bg-light text-dark text-wrap'>
                  $phong_data[children] Trẻ Em
                </span>
              </div>
            </div>
            <div class='col-md-2 mt-lg-0 mt-md-0 mt-4 text-center'>
              <h6 class='mb-4'>$phong_data[price] vnđ mỗi đêm</h6>
              $book_btn
              <a href='room_details.php?id=$phong_data[id]' class='btn btn-sm w-100 btn-outline-dark shadow-none'>Chi Tiết</a>
            </div>
          </div>
        </div>
      ";

      $count_rooms++;
    }

    if($count_rooms>0){
      echo $output;
    }
    else{
      echo"<h3 class='text-center text-danger'>Không có phòng nào !!!</h3>";
    }

  }


?>