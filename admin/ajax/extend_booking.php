<?php
require('../inc/db_config.php');
require('../inc/essentials.php');
adminLogin();

if(isset($_POST['extend_booking']))
{
  $frm_data = filteration($_POST);
  $booking_id = $frm_data['booking_id'];
  $extra_days = (int)$frm_data['extra_days'];

  // Lấy ngày hiện tại checkout
  $query = "SELECT check_out FROM booking_order WHERE booking_id = ?";
  $res = select($query, [$booking_id], 'i');

  if(mysqli_num_rows($res) == 1){
    $row = mysqli_fetch_assoc($res);
    $old_checkout = $row['check_out'];

    // Cộng thêm ngày
    $new_checkout = date("Y-m-d", strtotime($old_checkout . " +$extra_days days"));

    // Cập nhật vào database
    $update = update("UPDATE booking_order SET check_out = ? WHERE booking_id = ?", [$new_checkout, $booking_id], 'si');

    echo ($update) ? 'success' : 'failed';
  }
}
?>
