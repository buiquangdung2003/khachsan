<?php 

  require('../inc/db_config.php');// Kết nối đến cơ sở dữ liệu
  require('../inc/essentials.php');// Import các hàm cần thiết
  adminLogin();// Đảm bảo quản trị viên đã đăng nhập

  if(isset($_POST['add_room']))
  {
    $features = filteration(json_decode($_POST['features']));// Lấy và lọc dữ liệu đặc tính từ JSON
    $facilities = filteration(json_decode($_POST['facilities']));// Lấy và lọc dữ liệu tiện nghi từ JSON

    $frm_data = filteration($_POST);// Lọc dữ liệu POST
    $flag = 0;// Biến cờ để kiểm tra lỗi

    $q1 = "INSERT INTO `rooms` (`name`, `area`, `price`, `quantity`, `adult`, `children`, `description`) VALUES (?,?,?,?,?,?,?)";
    $values = [$frm_data['name'],$frm_data['area'],$frm_data['price'],$frm_data['quantity'],$frm_data['adult'],$frm_data['children'],$frm_data['desc']];

    if(insert($q1,$values,'siiiiis')){// Thực hiện truy vấn chèn dữ liệu vào bảng 'rooms'
      $flag = 1;// Đánh dấu thành công
    }
    
    $room_id = mysqli_insert_id($con);// Lấy ID của phòng vừa được chèn vào cơ sở dữ liệu
    // Chèn thông tin về các tiện nghi của phòng vào bảng 'room_facilities'
    $q2 = "INSERT INTO `room_facilities`(`room_id`, `facilities_id`) VALUES (?,?)";// Câu truy vấn SQL để chèn dữ liệu tiện nghi phòng
    if($stmt = mysqli_prepare($con,$q2))
    {
      foreach($facilities as $f){
        mysqli_stmt_bind_param($stmt,'ii',$room_id,$f);
        mysqli_stmt_execute($stmt);
      }
      mysqli_stmt_close($stmt);
    }
    else{
      $flag = 0;
      die('truy vấn không thể được chuẩn bị - chèn');
    }

     // Chèn thông tin về các đặc tính của phòng vào bảng 'room_features'
    $q3 = "INSERT INTO `room_features`(`room_id`, `features_id`) VALUES (?,?)";
    if($stmt = mysqli_prepare($con,$q3))
    {
      foreach($features as $f){
        mysqli_stmt_bind_param($stmt,'ii',$room_id,$f);
        mysqli_stmt_execute($stmt);
      }
      mysqli_stmt_close($stmt);
    }
    else{
      $flag = 0;
      die('truy vấn không thể được chuẩn bị - chèn');
    }
    
    if($flag){
      echo 1;// Trả về 1 nếu thêm phòng thành công, 0 nếu thất bại
    }
    else{
      echo 0;
    }


  }


  if(isset($_POST['get_all_rooms']))// Kiểm tra nếu có yêu cầu POST để lấy danh sách tất cả các phòng
  {
    $res = select("SELECT * FROM `rooms` WHERE `removed`=?",[0],'i');// Lấy danh sách tất cả các phòng chưa bị xóa
    $i=1;

    $data = "";

    while($row = mysqli_fetch_assoc($res))
    {
      if($row['status']==1){
        $status = "<button onclick='toggle_status($row[id],0)' class='btn btn-dark btn-sm shadow-none'>Hoạt Động</button>";
      }
      else{
        $status = "<button onclick='toggle_status($row[id],1)' class='btn btn-warning btn-sm shadow-none'>Bảo Trì</button>";
      }


      $data.="
        <tr class='align-middle'>
          <td>$i</td>
          <td>$row[name]</td>
          <td>$row[area] m2</td>
          <td>
            <span class='badge rounded-pill bg-light text-dark'>
              Người Lớn: $row[adult]
            </span><br>
            <span class='badge rounded-pill bg-light text-dark'>
              Trẻ Em: $row[children]
            </span>
          </td>
          <td>$row[price] vnđ</td>
          <td>$row[quantity]</td>
          <td>$status</td>
          <td>
            <button type='button' onclick='edit_details($row[id])' class='btn btn-primary shadow-none btn-sm' data-bs-toggle='modal' data-bs-target='#edit-room'>
              <i class='bi bi-pencil-square'></i> 
            </button>
            <button type='button' onclick=\"room_images($row[id],'$row[name]')\" class='btn btn-info shadow-none btn-sm' data-bs-toggle='modal' data-bs-target='#room-images'>
              <i class='bi bi-images'></i> 
            </button>
            <button type='button' onclick='remove_room($row[id])' class='btn btn-danger shadow-none btn-sm'>
              <i class='bi bi-trash'></i> 
            </button>
          </td>
        </tr>
      ";
      $i++;
    }

    echo $data;// Trả về dữ liệu phòng dưới dạng HTML
  }

  if(isset($_POST['get_room']))// Kiểm tra nếu có yêu cầu POST để lấy thông tin chi tiết về một phòng
  {
    $frm_data = filteration($_POST);

    $res1 = select("SELECT * FROM `rooms` WHERE `id`=?",[$frm_data['get_room']],'i');
    $res2 = select("SELECT * FROM `room_features` WHERE `room_id`=?",[$frm_data['get_room']],'i');
    $res3 = select("SELECT * FROM `room_facilities` WHERE `room_id`=?",[$frm_data['get_room']],'i');

    $roomdata = mysqli_fetch_assoc($res1);
    $features = [];
    $facilities = [];

    if(mysqli_num_rows($res2)>0)
    {
      while($row = mysqli_fetch_assoc($res2)){
        array_push($features,$row['features_id']);
      }
    }

    if(mysqli_num_rows($res3)>0)
    {
      while($row = mysqli_fetch_assoc($res3)){
        array_push($facilities,$row['facilities_id']);
      }
    }

    $data = ["roomdata" => $roomdata, "features" => $features, "facilities" => $facilities];
    
    $data = json_encode($data);

    echo $data;

  }

  if(isset($_POST['edit_room'])) // Kiểm tra nếu có yêu cầu POST để chỉnh sửa thông tin phòng

  {
    $features = filteration(json_decode($_POST['features']));
    $facilities = filteration(json_decode($_POST['facilities']));

    $frm_data = filteration($_POST);
    $flag = 0;
// Tạo truy vấn SQL để cập nhật thông tin phòng
    $q1 = "UPDATE `rooms` SET `name`=?,`area`=?,`price`=?,`quantity`=?,
      `adult`=?,`children`=?,`description`=? WHERE `id`=?";
    $values = [$frm_data['name'],$frm_data['area'],$frm_data['price'],$frm_data['quantity'],$frm_data['adult'],$frm_data['children'],$frm_data['desc'],$frm_data['room_id']];
    
    if(update($q1,$values,'siiiiisi')){
      $flag = 1;
    }
    // Xóa thông tin về các đặc tính và tiện nghi của phòng trước khi cập nhật
    $del_features = delete("DELETE FROM `room_features` WHERE `room_id`=?", [$frm_data['room_id']],'i');
    $del_facilities = delete("DELETE FROM `room_facilities` WHERE `room_id`=?", [$frm_data['room_id']],'i');

    if(!($del_facilities && $del_features)){
      $flag = 0;
    }
    // Chèn thông tin mới về các tiện nghi và đặc tính của phòng
    $q2 = "INSERT INTO `room_facilities`(`room_id`, `facilities_id`) VALUES (?,?)";
    if($stmt = mysqli_prepare($con,$q2))
    {
      foreach($facilities as $f){
        mysqli_stmt_bind_param($stmt,'ii',$frm_data['room_id'],$f);
        mysqli_stmt_execute($stmt);
      }
      $flag = 1;// Trả về 1 nếu chỉnh sửa thành công, 0 nếu thất bại
      mysqli_stmt_close($stmt);
    }
    else{
      $flag = 0;
      die('truy vấn không thể được chuẩn bị - chèn');
    }

    
    $q3 = "INSERT INTO `room_features`(`room_id`, `features_id`) VALUES (?,?)";
    if($stmt = mysqli_prepare($con,$q3))
    {
      foreach($features as $f){
        mysqli_stmt_bind_param($stmt,'ii',$frm_data['room_id'],$f);
        mysqli_stmt_execute($stmt);
      }
      $flag = 1;// Trả về 1 nếu chỉnh sửa thành công, 0 nếu thất bại
      mysqli_stmt_close($stmt);
    }
    else{
      $flag = 0;
      die('truy vấn không thể được chuẩn bị - chèn');
    }
    
    if($flag){
      echo 1;
    }
    else{
      echo 0;
    }

  }

  if(isset($_POST['toggle_status']))// Kiểm tra nếu có yêu cầu POST để chuyển đổi trạng thái phòng (Hoạt Động/Bảo Trì)
  {
    $frm_data = filteration($_POST);
     // Tạo truy vấn SQL để cập nhật trạng thái phòng
    $q = "UPDATE `rooms` SET `status`=? WHERE `id`=?";
    $v = [$frm_data['value'],$frm_data['toggle_status']];

    if(update($q,$v,'ii')){
      echo 1;// Trả về 1 nếu cập nhật thành công, 0 nếu thất bại
    }
    else{
      echo 0;
    }
  }

  if(isset($_POST['add_image']))// Kiểm tra nếu có yêu cầu POST để thêm hình ảnh cho phòng
  {
    $frm_data = filteration($_POST);

    $img_r = uploadImage($_FILES['image'],ROOMS_FOLDER);// Upload hình ảnh và trả về kết quả


    if($img_r == 'inv_img'){
      echo $img_r;// Trả về lỗi nếu hình ảnh không hợp lệ
    }
    else if($img_r == 'inv_size'){// Trả về lỗi nếu kích thước hình ảnh không hợp lệ
      echo $img_r;
    }
    else if($img_r == 'upd_failed'){// Trả về lỗi nếu không thể tải lên hình ảnh
      echo $img_r;
    }
    else{
      $q = "INSERT INTO `room_images`(`room_id`, `image`) VALUES (?,?)";
      $values = [$frm_data['room_id'],$img_r];
      $res = insert($q,$values,'is');
      echo $res;// Trả về kết quả (1 nếu thành công, 0 nếu thất bại)
    }
  }

  if(isset($_POST['get_room_images']))// Kiểm tra nếu có yêu cầu POST để lấy danh sách hình ảnh của phòng
  {
    $frm_data = filteration($_POST);
    $res = select("SELECT * FROM `room_images` WHERE `room_id`=?",[$frm_data['get_room_images']],'i');

    $path = anh_phong;

    while($row = mysqli_fetch_assoc($res))
    {
      if($row['thumb']==1){
        $thumb_btn = "<i class='bi bi-check-lg text-light bg-success px-2 py-1 rounded fs-5'></i>";
      }
      else{
        $thumb_btn = "<button onclick='thumb_image($row[sr_no],$row[room_id])' class='btn btn-secondary shadow-none'>
          <i class='bi bi-check-lg'></i>
        </button>";
      }

      echo<<<data
        <tr class='align-middle'>
          <td><img src='$path$row[image]' class='img-fluid'></td>
          <td>$thumb_btn</td>
          <td>
            <button onclick='rem_image($row[sr_no],$row[room_id])' class='btn btn-danger shadow-none'>
              <i class='bi bi-trash'></i>
            </button>
          </td>
        </tr>
      data;
    }

  }

  if(isset($_POST['rem_image']))// Kiểm tra nếu có yêu cầu POST để xóa một hình ảnh của phòng
  {
    $frm_data = filteration($_POST);

    $values = [$frm_data['image_id'],$frm_data['room_id']];

    $pre_q = "SELECT * FROM `room_images` WHERE `sr_no`=? AND `room_id`=?";
    $res = select($pre_q,$values,'ii');
    $img = mysqli_fetch_assoc($res);

    if(deleteImage($img['image'],ROOMS_FOLDER)){
      $q = "DELETE FROM `room_images` WHERE `sr_no`=? AND `room_id`=?";
      $res = delete($q,$values,'ii');
      echo $res;
    }
    else{
      echo 0;
    }

  }

  if(isset($_POST['thumb_image']))// Kiểm tra nếu có yêu cầu POST để đặt hình ảnh làm hình đại diện
  {
    $frm_data = filteration($_POST);

    $pre_q = "UPDATE `room_images` SET `thumb`=? WHERE `room_id`=?";
    $pre_v = [0,$frm_data['room_id']];
    $pre_res = update($pre_q,$pre_v,'ii');

    $q = "UPDATE `room_images` SET `thumb`=? WHERE `sr_no`=? AND `room_id`=?";
    $v = [1,$frm_data['image_id'],$frm_data['room_id']];
    $res = update($q,$v,'iii');

    echo $res;

  }

  if(isset($_POST['remove_room']))// Kiểm tra nếu có yêu cầu POST để xóa một phòng
  {
    $frm_data = filteration($_POST);

    $res1 = select("SELECT * FROM `room_images` WHERE `room_id`=?",[$frm_data['room_id']],'i');

    while($row = mysqli_fetch_assoc($res1)){
      deleteImage($row['image'],ROOMS_FOLDER);
    }

    $res2 = delete("DELETE FROM `room_images` WHERE `room_id`=?",[$frm_data['room_id']],'i');
    $res3 = delete("DELETE FROM `room_features` WHERE `room_id`=?",[$frm_data['room_id']],'i');
    $res4 = delete("DELETE FROM `room_facilities` WHERE `room_id`=?",[$frm_data['room_id']],'i');
    $res5 = update("UPDATE `rooms` SET `removed`=? WHERE `id`=?",[1,$frm_data['room_id']],'ii');

    if($res2 || $res3 || $res4 || $res5){
      echo 1;
    }
    else{
      echo 0;
    }

  }

?>