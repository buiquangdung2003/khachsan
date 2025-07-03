<?php 

  require('inc/essentials.php');
  require('inc/db_config.php');
  require('inc/mpdf/vendor/autoload.php');

  adminLogin();

  if(isset($_GET['gen_pdf']) && isset($_GET['id']))
  {
    $frm_data = filteration($_GET);
    $query = "SELECT bo.*, bd.*,uc.email FROM `booking_order` bo
      INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id
      INNER JOIN `user_cred` uc ON bo.user_id = uc.id
      WHERE ((bo.booking_status='Đã Thanh Toán') 
      OR (bo.booking_status='Đã Huỷ')
      OR (bo.booking_status='Đã Xác Nhận Đặt Phòng')) 
      AND bo.booking_id = '$frm_data[id]'";

    $res = mysqli_query($con,$query);
    $total_rows = mysqli_num_rows($res);

    if($total_rows==0){
      header('location: dashboard.php');
      exit;
    }

    $data = mysqli_fetch_assoc($res);

    $date = date("H:i | d-m-Y",strtotime($data['datentime']));
    $checkin = date("d-m-Y",strtotime($data['check_in']));
    $checkout = date("d-m-Y",strtotime($data['check_out']));

    $table_data = "

    <h2 style='text-align: center'>KHÁCH SẠN VINH HOTEL</h2>
    <h3 style='text-align: center'>HOÁ ĐƠN</h3>
    <table border='1' style='margin: auto'>
      <tr>
        <td>ID Đơn: $data[order_id]</td>
        <td>Ngày Đặt: $date</td>
      </tr>
      <tr>
        <td colspan='2'>Trạng Thái: $data[booking_status]</td>
      </tr>
      <tr>
        <td>Tên: $data[user_name]</td>
        <td>Email: $data[email]</td>
      </tr>
      <tr>
        <td>Số Điện Thoại: $data[phonenum]</td>
        <td>Địa Chỉ: $data[address]</td>
      </tr>
      <tr>
        <td>Tên Phòng: $data[room_name]</td>
        <td>Giá: $data[price] VNĐ</td>
      </tr>
      <tr>
        <td>Ngày Vào: $checkin</td>
        <td>Ngày Ra: $checkout</td>
      </tr>
      <tr>
        <td colspan='2'>Số Tiền Thanh Toán: $data[trans_amt] vnđ</td>
        
      </tr>
    ";

    // if($data['booking_status']=='Đã Huỷ')
    // {
    //   $refund = ($data['refund']) ? "Amount Refunded" : "Not Yet Refunded";

    //   $table_data.="<tr>
    //     <td>Amount Paid: ₹$data[trans_amt]</td>
    //     <td>Refund: $refund</td>
    //   </tr>";
    // }
    // else if($data['booking_status']=='payment failed')
    // {
    //   $table_data.="<tr>
    //     <td>Transaction Amount: ₹$data[trans_amt]</td>
    //     <td>Failure Response: $data[trans_resp_msg]</td>
    //   </tr>";
    // }
    // else
    // {
    //   $table_data.="<tr>
    //     <td>Room Number: $data[room_no]</td>
    //     <td>Amount Paid: ₹$data[trans_amt]</td>
    //   </tr>";
    // }

    $table_data.="</table>";

    $mpdf = new \Mpdf\Mpdf();
    $mpdf->WriteHTML($table_data);
    $mpdf->Output($data['order_id'].'.pdf','D');

  }
  else{
    header('location: dashboard.php');
  }
  
?>