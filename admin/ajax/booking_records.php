<?php 

  require('../inc/db_config.php');
  require('../inc/essentials.php');
  date_default_timezone_set('Asia/Ho_Chi_Minh');

  adminLogin();

  if(isset($_POST['get_bookings']))
  {
    $frm_data = filteration($_POST);

    $query = "SELECT bo.*, bd.* FROM `booking_order` bo
      INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id
      WHERE ((bo.booking_status='Đã Thanh Toán') 
      OR (bo.booking_status='Đã Huỷ')
      OR (bo.booking_status='Đã Xác Nhận Đặt Phòng')) 
      AND (bo.order_id LIKE ? OR bd.phonenum LIKE ? OR bd.user_name LIKE ?) 
      ORDER BY bo.booking_id DESC";

    $res = select($query,["%$frm_data[search]%","%$frm_data[search]%","%$frm_data[search]%"],'sss');

    if (mysqli_num_rows($res) == 0) {
      echo "<b>Không tìm thấy dữ liệu nào!</b>";
      exit;
    }
    $i = 1;
    $table_data = "";
    while($data = mysqli_fetch_assoc($res))
    {   
     
      $date = date("d-m-Y",strtotime($data['datentime']));
      $checkin = date("d-m-Y",strtotime($data['check_in']));
      $checkout = date("d-m-Y",strtotime($data['check_out']));
      if($data['booking_status']=='Đã Thanh Toán'){
        $status_bg = 'bg-success';
      }
      else if($data['booking_status']=='Đã Huỷ'){
        $status_bg = 'bg-danger';
      }
      else{
        $status_bg = 'bg-primary';
      }
      
      $table_data .="
        <tr>
          <td>$i</td>
          <td>
            <span class='badge bg-primary'>
              ID Đơn: $data[order_id]
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
          </td>
          <td>
            <b>Ngày Đặt:</b> $date
            <br>
            <b>Ngày Vào:</b> $checkin
            <br>
            <b>Ngày Trả:</b> $checkout
            <br>
            <b>Thanh Toán:</b> $data[trans_amt] vnđ
          </td>
          <td>
            <span class='badge $status_bg'>$data[booking_status]</span>
          </td>
          <td>
          <button type='button' onclick='download($data[booking_id])' 
            class='btn btn-outline-success btn-sm fw-bold shadow-none'>
            <i class='bi bi-file-earmark-arrow-down-fill'></i>
          </button>
      ";

      // Nút hành động
      if(trim($data['booking_status'])=='Đã Thanh Toán')
      {
        $table_data.="
              <button type='button' onclick='extendBooking($data[booking_id])' class='btn btn-sm btn-primary ms-2'>
              Gia hạn
              </button>";
      }
      // Đóng cột và hàng
      $table_data .= " 
            </td>
              </tr>";
      
      $i++;
    }
    echo $table_data;
    exit;
  }
  if(isset($_POST['extend_booking']))
{
  $frm_data = filteration($_POST);
  $booking_id = $frm_data['booking_id'];
  $extra_days = (int)$frm_data['extra_days'];

  // Lấy ngày check_out hiện tại
  $query = "SELECT check_out FROM booking_order WHERE booking_id = ?";
  $res = select($query, [$booking_id], 'i');

  if(mysqli_num_rows($res) == 1){
    $row = mysqli_fetch_assoc($res);
    $old_checkout = $row['check_out'];

    // Tính ngày mới
    $new_checkout = date("Y-m-d", strtotime($old_checkout . " +$extra_days days"));

    // Cập nhật vào DB
    $update = update("UPDATE booking_order SET check_out = ? WHERE booking_id = ?", [$new_checkout, $booking_id], 'si');

    echo ($update) ? 'success' : 'failed';
  } else {
    echo 'failed';
  }

  exit; 
}
?>

