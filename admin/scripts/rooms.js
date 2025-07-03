// Lấy tham chiếu đến biểu mẫu "add_room_form" từ tài liệu HTML
let add_room_form = document.getElementById('add_room_form');
// Thêm sự kiện "submit" cho biểu mẫu "add_room_form"    
add_room_form.addEventListener('submit',function(e){
  e.preventDefault();// Ngăn chặn gửi biểu mẫu theo cách thường
  add_room();// Gọi hàm "add_room" để xử lý thêm phòng
});
// Hàm "add_room" thực hiện việc thêm phòng
function add_room()
{
  // Tạo một đối tượng FormData để chứa dữ liệu biểu mẫu.
  let data = new FormData();
  //thêm các thông tin từ biểu mẫu vào đối tượng FormData. 
  data.append('add_room','');
  data.append('name',add_room_form.elements['name'].value);
  data.append('area',add_room_form.elements['area'].value);
  data.append('price',add_room_form.elements['price'].value);
  data.append('quantity',add_room_form.elements['quantity'].value);
  data.append('adult',add_room_form.elements['adult'].value);
  data.append('children',add_room_form.elements['children'].value);
  data.append('desc',add_room_form.elements['desc'].value);
  // Tạo một mảng trống để lưu trữ các đặc tính (features)
  let features = [];
  // Lặp qua các phần tử "features" trong biểu mẫu
  add_room_form.elements['features'].forEach(el =>{
    if(el.checked){
      features.push(el.value);
    }
  });
// Tạo một mảng trống để lưu trữ các tiện nghi (facilities)
  let facilities = [];
  // Lặp qua các phần tử "facilities" trong biểu mẫu
  add_room_form.elements['facilities'].forEach(el =>{
    if(el.checked){
      facilities.push(el.value);
    }
  });
  // thêm mảng features và facilities vào đối tượng FormData sau khi chuyển sang chuỗi JSON
  data.append('features',JSON.stringify(features));
  data.append('facilities',JSON.stringify(facilities));
  // Tạo một đối tượng XMLHttpRequest
  let xhr = new XMLHttpRequest();
  xhr.open("POST","ajax/rooms.php",true);
  // Xử lý sự kiện khi yêu cầu AJAX hoàn thành
  xhr.onload = function(){
    // Tìm tham chiếu đến modal có ID "add-room"
    var myModal = document.getElementById('add-room');
    // Lấy đối tượng modal Bootstrap
    var modal = bootstrap.Modal.getInstance(myModal);
    // Ẩn modal
    modal.hide();
    // Kiểm tra phản hồi từ máy chủ
    if(this.responseText == 1){
      alert('Thành công','Đã thêm phòng mới!');// Hiển thị thông báo thành công
      add_room_form.reset();// Xóa nội dung trong biểu mẫu
      get_all_rooms();// Gọi hàm "get_all_rooms" để cập nhật danh sách phòng
    }
    else{
      alert('Thất bại','Lỗi!'); // Hiển thị thông báo lỗi
    }
  }
   // Gửi yêu cầu AJAX với dữ liệu đã chuẩn bị
  xhr.send(data);
}
// Hàm "get_all_rooms" thực hiện yêu cầu AJAX để lấy danh sách phòng
function get_all_rooms()
{
  // Tạo một đối tượng XMLHttpRequest để thực hiện yêu cầu AJAX
  let xhr = new XMLHttpRequest();
  // Mở yêu cầu với phương thức POST, địa chỉ tệp "rooms.php", và thiết lập yêu cầu bất đồng bộ (true).
  xhr.open("POST","ajax/rooms.php",true);
  // Thiết lập tiêu đề yêu cầu để xác định kiểu dữ liệu gửi đi là form-urlencoded.
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  // Xử lý sự kiện khi yêu cầu AJAX đã hoàn thành.
  xhr.onload = function(){
    // Khi yêu cầu hoàn thành, nội dung phản hồi từ máy chủ sẽ được gán vào phần thân bảng có id="room-data".
    document.getElementById('room-data').innerHTML = this.responseText;
  }
  // Gửi yêu cầu với dữ liệu là chuỗi "get_all_rooms".
  xhr.send('get_all_rooms');
}
//tham chiếu đến biểu mẫu chỉnh sửa phòng dựa trên ID 
let edit_room_form = document.getElementById('edit_room_form');

function edit_details(id)
{
  let xhr = new XMLHttpRequest();
  xhr.open("POST","ajax/rooms.php",true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  xhr.onload = function(){
    //giải mã (parse) dữ liệu JSON nhận được từ máy chủ thành một đối tượng JavaScript data
    let data = JSON.parse(this.responseText);
    // điền thông tin từ đối tượng data vào các trường nhập liệu
    edit_room_form.elements['name'].value = data.roomdata.name;
    edit_room_form.elements['area'].value = data.roomdata.area;
    edit_room_form.elements['price'].value = data.roomdata.price;
    edit_room_form.elements['quantity'].value = data.roomdata.quantity;
    edit_room_form.elements['adult'].value = data.roomdata.adult;
    edit_room_form.elements['children'].value = data.roomdata.children;
    edit_room_form.elements['desc'].value = data.roomdata.description;
    edit_room_form.elements['room_id'].value = data.roomdata.id;

    edit_room_form.elements['features'].forEach(el =>{
      if(data.features.includes(Number(el.value))){
        el.checked = true;
      }
    });

    edit_room_form.elements['facilities'].forEach(el =>{
      if(data.facilities.includes(Number(el.value))){
        el.checked = true;
      }
    });
  }

  xhr.send('get_room='+id);
}
// Thêm sự kiện "submit" cho biểu mẫu chỉnh sửa phòng
edit_room_form.addEventListener('submit',function(e){
  e.preventDefault();
  submit_edit_room();
});
// Hàm "submit_edit_room" thực hiện việc gửi yêu cầu sửa đổi thông tin phòng
function submit_edit_room()
{
  // Tạo một đối tượng FormData để lưu trữ dữ liệu biểu mẫu
  let data = new FormData();
  data.append('edit_room','');
  data.append('room_id',edit_room_form.elements['room_id'].value);
  data.append('name',edit_room_form.elements['name'].value);
  data.append('area',edit_room_form.elements['area'].value);
  data.append('price',edit_room_form.elements['price'].value);
  data.append('quantity',edit_room_form.elements['quantity'].value);
  data.append('adult',edit_room_form.elements['adult'].value);
  data.append('children',edit_room_form.elements['children'].value);
  data.append('desc',edit_room_form.elements['desc'].value);

  let features = [];
  edit_room_form.elements['features'].forEach(el =>{
    if(el.checked){
      features.push(el.value);
    }
  });

  let facilities = [];
  edit_room_form.elements['facilities'].forEach(el =>{
    if(el.checked){
      facilities.push(el.value);
    }
  });

  data.append('features',JSON.stringify(features));
  data.append('facilities',JSON.stringify(facilities));
// Tạo một đối tượng XMLHttpRequest
  let xhr = new XMLHttpRequest();
  xhr.open("POST","ajax/rooms.php",true);
 // Xử lý sự kiện khi yêu cầu AJAX hoàn thành
  xhr.onload = function(){
    // Tìm tham chiếu đến modal có ID "edit-room"
    var myModal = document.getElementById('edit-room');
     // Lấy đối tượng modal Bootstrap
    var modal = bootstrap.Modal.getInstance(myModal);
    modal.hide(); // Ẩn modal
  // Kiểm tra phản hồi từ máy chủ
    if(this.responseText == 1){
      alert('Thành công','Đã chỉnh sửa dữ liệu phòng!');
      edit_room_form.reset();
      get_all_rooms();// Gọi hàm "get_all_rooms" để cập nhật danh sách phòng
    }
    else{
      alert('Thất bại','Lỗi!');
    }
  }

  xhr.send(data);
}
// Hàm "toggle_status" thực hiện việc bật/tắt trạng thái của phòng dựa trên ID
function toggle_status(id,val)
{
  let xhr = new XMLHttpRequest();
  xhr.open("POST","ajax/rooms.php",true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  xhr.onload = function(){
    if(this.responseText==1){
      alert('Thành công','Đã bật trạng thái!');
      get_all_rooms();
    }
    else{
      alert('Thất bại','Lỗi!');
    }
  }

  xhr.send('toggle_status='+id+'&value='+val);
}
// Tham chiếu đến biểu mẫu thêm ảnh vào phòng
let add_image_form = document.getElementById('add_image_form');
// Gắn sự kiện "submit" vào biểu mẫu thêm ảnh
add_image_form.addEventListener('submit',function(e){
  e.preventDefault();
  add_image();// Gọi hàm "add_image" để xử lý thêm ảnh
});
// Hàm "add_image" thực hiện việc thêm ảnh vào phòng
function add_image()
{ // Tạo một đối tượng FormData để lưu trữ dữ liệu biểu mẫu
  let data = new FormData();
  data.append('image',add_image_form.elements['image'].files[0]);
  data.append('room_id',add_image_form.elements['room_id'].value);
  data.append('add_image','');

  let xhr = new XMLHttpRequest();
  xhr.open("POST","ajax/rooms.php",true);

  xhr.onload = function()
  {
    if(this.responseText == 'inv_img'){
      alert('Thất bại','Chỉ cho phép hình ảnh JPG, WEBP hoặc PNG!','image-alert');
    }
    else if(this.responseText == 'inv_size'){
      alert('Thất bại','Hình ảnh nên ít hơn 2 MB!','image-alert');
    }
    else if(this.responseText == 'upd_failed'){
      alert('Thất bại','Tải lên hình ảnh không thành công. Máy chủ ngừng hoạt động!','image-alert');
    }
    else{
      alert('Thành công','Hình ảnh mới được thêm vào!','image-alert');
      room_images(add_image_form.elements['room_id'].value,document.querySelector("#room-images .modal-title").innerText)
      add_image_form.reset();
    }
  }
  xhr.send(data);
}
// Hàm "room_images" hiển thị danh sách ảnh của một phòng cụ thể
function room_images(id,rname)
{
  document.querySelector("#room-images .modal-title").innerText = rname;
  add_image_form.elements['room_id'].value = id;
  add_image_form.elements['image'].value = '';

  let xhr = new XMLHttpRequest();
  xhr.open("POST","ajax/rooms.php",true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  xhr.onload = function(){
    document.getElementById('room-image-data').innerHTML = this.responseText;
  }

  xhr.send('get_room_images='+id);
}
// Hàm "rem_image" thực hiện việc xoá ảnh của phòng
function rem_image(img_id,room_id)
{// Tạo một đối tượng FormData để lưu trữ dữ liệu
  let data = new FormData();
  data.append('image_id',img_id);
  data.append('room_id',room_id);
  data.append('rem_image','');
 // Tạo một đối tượng XMLHttpRequest
  let xhr = new XMLHttpRequest();
  xhr.open("POST","ajax/rooms.php",true);

  xhr.onload = function()
  {
    if(this.responseText == 1){
      alert('Thành công','Ảnh đã xóa!','image-alert');
      room_images(room_id,document.querySelector("#room-images .modal-title").innerText);
    }
    else{
      alert('Thất bại','Lỗi xóa ảnh!','image-alert');
    }
  }
  xhr.send(data);  
}
// Hàm "thumb_image" thực hiện việc thay đổi ảnh thumbnail của phòng
function thumb_image(img_id,room_id)
{
  let data = new FormData();
  data.append('image_id',img_id);
  data.append('room_id',room_id);
  data.append('thumb_image','');

  let xhr = new XMLHttpRequest();
  xhr.open("POST","ajax/rooms.php",true);

  xhr.onload = function()
  {
    if(this.responseText == 1){
      alert('Thành công','Hình thu nhỏ của hình ảnh đã thay đổi!','image-alert');
      room_images(room_id,document.querySelector("#room-images .modal-title").innerText);
    }
    else{
      alert('Thất bại','Cập nhật hình thu nhỏ không thành công!','image-alert');
    }
  }
  xhr.send(data);  
}
// Hàm "remove_room" thực hiện việc xoá một phòng
function remove_room(room_id)
{
  if(confirm("Bạn có chắc chắn muốn xóa phòng này không?"))
   // Xác nhận xóa phòng với hộp thoại confirm

    // Tạo một đối tượng FormData để lưu trữ dữ liệu
  {
    let data = new FormData();
    data.append('room_id',room_id);
    data.append('remove_room','');

    let xhr = new XMLHttpRequest();
    xhr.open("POST","ajax/rooms.php",true);

    xhr.onload = function()
    {
      if(this.responseText == 1){
        alert('Thành công','Đã xóa phòng!');
        get_all_rooms();
      }
      else{
        alert('Thất bại','Xóa phòng không thành công!');
      }
    }
    xhr.send(data);
  }

}

window.onload = function(){
  get_all_rooms();
}
