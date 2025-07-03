<?php

require('../inc/db_config.php');
require('../inc/essentials.php');
adminLogin();

if (isset($_POST['get_bookings'])) {
  $frm_data = filteration($_POST);

  $query = "SELECT bo.*, bd.* FROM `booking_order` bo
      INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id
      WHERE (bo.order_id LIKE ? OR bd.phonenum LIKE ? OR bd.user_name LIKE ?) 
      AND (bo.booking_status = ? AND bo.arrival = ?) ORDER BY bo.booking_id ASC";

  $res = select($query, ["%$frm_data[search]%", "%$frm_data[search]%", "%$frm_data[search]%", 'Đã Đặt', 0], 'ssssi');

  $i = 1;
  $table_data = "";

  if (mysqli_num_rows($res) == 0) {
    echo "<b>Không tìm thấy dữ liệu nào!</b>";
    exit;
  }

  while ($data = mysqli_fetch_assoc($res)) {
    $date = date("d-m-Y", strtotime($data['datentime']));
    $checkin = date("d-m-Y", strtotime($data['check_in']));
    $checkout = date("d-m-Y", strtotime($data['check_out']));
    $count_days = date_diff(new DateTime($checkin), new DateTime($checkout))->days; 
    //convert từ string sang time để tính toán
    $table_data .= "
        <tr>
          <td>$i</td>
          <td>
            <span class='badge bg-primary'>
              ID Đặt Phòng: $data[order_id]
            </span>
            <br>
            <b>Tên:</b> $data[user_name]
            <br>
            <b>Điện Thoại:</b> $data[phonenum]
          </td>
          <td>
            <b>Phòng:</b> $data[room_name]
            <br>
            <b>Giá:</b> $data[price] vnđ
            <br>
            <b>Tổng:</b> $data[total_pay] vnđ
          </td>
          <td>
            <b>Ngày Vào:</b> $checkin
            <br>
            <b>Ngày Trả:</b> $checkout
            <br>
            <b>Thời Gian:</b> $count_days ngày
            <br>

            <b>Ngày Đặt:</b> $date
          </td>
          <td>
            <button type='button' onclick='kh_booking($data[booking_id])' class='mb-2 btn btn-outline-primary btn-sm fw-bold shadow-none'>
              <i class='bi bi-check2-square'></i> Xác Nhận Đặt Phòng
            </button>
            <br>
            <button type='button' onclick='huy_booking($data[booking_id])' class='mt-2 btn btn-outline-danger btn-sm fw-bold shadow-none'>
              <i class='bi bi-trash'></i> Huỷ Đặt Phòng
            </button>
          </td>
        </tr>
      ";

    $i++;
  }

  echo $table_data;
}
// <b>Số Tiền Trả:</b> $data[trans_amt] vnđ
// <br>
// <button type='button' onclick='assign_room($data[booking_id])' class='btn text-white btn-sm fw-bold custom-bg shadow-none' data-bs-toggle='modal' data-bs-target='#assign-room'>
// <i class='bi bi-check2-square'></i> Chỉ Định Phòng
// </button>
// if (isset($_POST['payment_booking'])) {
//   $frm_data = filteration($_POST);

//   $query = "UPDATE `booking_order` bo INNER JOIN `booking_details` bd
//       ON bo.booking_id = bd.booking_id INNER JOIN `rooms` r
//       ON bd.room_id = r.room_id
//       SET bo.arrival = ?, bo.booking_status = ?, bo.trans_amt = ?, bo.trans_status=?, r.quantity = r.quantity + 1
//       WHERE bo.booking_id = ?";

//   $values = [1, $frm_data['booking_status'], $frm_data['trans_amt'], $frm_data['trans_status'], $frm_data['booking_id']];

//   $res = update($query, $values, 'isssi');

//   echo $res;


//   // $room_id = $_SESSION['room']['id'];
//   // $query = "SELECT quantity FROM rooms WHERE id = ?";
//   // $result = select($query, [$room_id], 'i');

//   // if ($result && mysqli_num_rows($result) > 0) {
//   //   $room = mysqli_fetch_assoc($result);
//   //   $quantity = $room['quantity'];
//   //   $new_quantity = $quantity - 1;
//   //   $query = "UPDATE rooms SET quantity = ? WHERE id = ?";
//   //   update($query, [$new_quantity, $room_id], 'ii');


//   // }
// }

if (isset($_POST['kh_booking'])) {
  $frm_data = filteration($_POST);

  $query = "UPDATE `booking_order` bo INNER JOIN `booking_details` bd
      ON bo.booking_id = bd.booking_id
      SET bo.booking_status = ?
      WHERE bo.booking_id = ?";

  $values = ['Đã Xác Nhận Đặt Phòng',$frm_data['booking_id']];

  $res = update($query, $values, 'si');
  echo $res;
}


if (isset($_POST['assign_room'])) {
  $frm_data = filteration($_POST);

  $query = "UPDATE `booking_order` bo INNER JOIN `booking_details` bd
      ON bo.booking_id = bd.booking_id
      SET bo.arrival = ?, bo.rate_review = ?, bd.room_no = ? 
      WHERE bo.booking_id = ?";

  $values = [1, 0, $frm_data['room_no'], $frm_data['booking_id']];

  $res = update($query, $values, 'iisi'); 

  echo ($res == 2) ? 1 : 0;
}


if (isset($_POST['huy_booking'])) {
  $frm_data = filteration($_POST);

  $query = "UPDATE `booking_order` bo INNER JOIN `rooms` r
  ON bo.room_id = r.id
  SET `booking_status`=?, `refund`=?
  WHERE `booking_id`=?";
  $values = ['Đã Huỷ', 0, $frm_data['booking_id']];
  $res = update($query, $values, 'sii');

  echo $res;

}

// traphong();
// function traphong(){
//   $frm_data = filteration($_POST);

//   function query($query, $params, $types) {
//     $pdo = new PDO('mysql:host=localhost;dbname=hbwebsite', 'root', '');
//     $stmt = $pdo->prepare($query);
//     $stmt->execute($params);
//     return $stmt->fetchAll(PDO::FETCH_ASSOC);
//   }

//   // Lấy số lượng phòng còn lại từ cơ sở dữ liệu
//   $q_room = "SELECT `room_id` FROM `booking_order` WHERE `booking_id`=?";
//   $result = query($q_room, [$frm_data['booking_id']], 'iiiiiiiii');
//   $room_idd = $result[0]['room_id'];

//   echo $room_id;

// }
