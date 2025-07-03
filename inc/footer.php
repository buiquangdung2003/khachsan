<div class="container-fluid bg-white mt-5">
  <div class="row">
    <div class="col-lg-4 p-4">
      <h3 class="h-font fw-bold fs-3 mb-2"><?php echo $settings_r['site_title'] ?></h3>
      <p>
        <?php echo $settings_r['site_about'] ?>
      </p>
    </div>
    <div class="col-lg-4 p-4">
      
    </div>
    <div class="col-lg-4 p-4">
        <h5 class="mb-3">Theo dõi ngay</h5>
        <?php 
          if($contact_r['tw']!=''){
            echo<<<data
              <a href="$contact_r[tw]" class="d-inline-block text-dark text-decoration-none mb-2">
                <i class="bi bi-twitter me-1"></i> Twitter
              </a><br>
            data;
          }
        ?>
        <a href="<?php echo $contact_r['fb'] ?>" class="d-inline-block text-dark text-decoration-none mb-2">
          <i class=""></i> Facebook
        </a><br>
        <a href="<?php echo $contact_r['insta'] ?>" class="d-inline-block text-dark text-decoration-none">
          <i class=""></i> Instagram
        </a><br>
    </div>
  </div>
</div>

<h6 class="text-center bg-dark text-white p-3 m-0">Đông Á 1 Hotel - Thái Nguyên</h6>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<script>

  function alert(type,msg,position='body')
  {
    let bs_class = (type == 'success') ? 'alert-success' : 'alert-danger';
    let element = document.createElement('div');
    element.innerHTML = `
      <div class="alert ${bs_class} alert-dismissible fade show" role="alert">
        <strong class="me-3">${msg}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    `;

    if(position=='body'){
      document.body.append(element);
      element.classList.add('custom-alert');
    }
    else{
      document.getElementById(position).appendChild(element);
    }
    setTimeout(remAlert, 3000);
  }

  function remAlert(){
    document.getElementsByClassName('alert')[0].remove();
  }

  function setActive()
  {
    let navbar = document.getElementById('nav-bar');
    let a_tags = navbar.getElementsByTagName('a');

    for(i=0; i<a_tags.length; i++)
    {
      let file = a_tags[i].href.split('/').pop();
      let file_name = file.split('.')[0];

      if(document.location.href.indexOf(file_name) >= 0){
        a_tags[i].classList.add('active');
      }

    }
  }

  let register_form = document.getElementById('register-form');

  register_form.addEventListener('submit', (e)=>{
    e.preventDefault();

    let data = new FormData();

    data.append('name',register_form.elements['name'].value);
    data.append('email',register_form.elements['email'].value);
    data.append('phonenum',register_form.elements['phonenum'].value);
    data.append('address',register_form.elements['address'].value);
    data.append('pincode',register_form.elements['pincode'].value);
    data.append('dob',register_form.elements['dob'].value);
    data.append('pass',register_form.elements['pass'].value);
    data.append('cpass',register_form.elements['cpass'].value);
    data.append('profile',register_form.elements['profile'].files[0]);
    data.append('register','');

    var myModal = document.getElementById('registerModal');
    var modal = bootstrap.Modal.getInstance(myModal);
    modal.hide();

    let xhr = new XMLHttpRequest();
    xhr.open("POST","ajax/login_register.php",true);

    xhr.onload = function(){
      if(this.responseText == 'pass_mismatch'){
        alert('error',"Mật khẩu không khớp!");
      }
      else if(this.responseText == 'email_already'){
        alert('error',"Email đã được đăng ký!");
      }
      else if(this.responseText == 'phone_already'){
        alert('error',"Số điện thoại đã được đăng ký!");
      }
      else if(this.responseText == 'inv_img'){
        alert('error',"Chỉ cho phép hình ảnh JPG, WEBP & PNG!");
      }
      else if(this.responseText == 'upd_failed'){
        alert('error',"Tải lên hình ảnh không thành công!");
      }
      else if(this.responseText == 'mail_failed'){
        alert('error',"Không thể gửi email xác nhận! Máy chủ ngừng hoạt động!");
      }
      else if(this.responseText == 'ins_failed'){
        alert('error',"Đăng ký không thành công! Máy chủ ngừng hoạt động!");
      }
      else{
        alert('success',"Đăng ký thành công. Liên kết xác nhận được gửi đến email!");
        register_form.reset();
      }
    }

    xhr.send(data);
  });

  let login_form = document.getElementById('login-form');

  login_form.addEventListener('submit', (e)=>{
    e.preventDefault();

    let data = new FormData();

    data.append('email_mob',login_form.elements['email_mob'].value);
    data.append('pass',login_form.elements['pass'].value);
    data.append('login','');

    var myModal = document.getElementById('loginModal');
    var modal = bootstrap.Modal.getInstance(myModal);
    modal.hide();

    let xhr = new XMLHttpRequest();
    xhr.open("POST","ajax/login_register.php",true);

    xhr.onload = function(){
      if(this.responseText == 'inv_email_mob'){
        alert('error',"Email hoặc số di động không hợp lệ!");
      }
      else if(this.responseText == 'not_verified'){
        alert('error',"Email chưa được xác minh!");
      }
      else if(this.responseText == 'inactive'){
        alert('error',"Toàn khoản bị khoá! Vui lòng liên hệ Quản trị viên.");
      }
      else if(this.responseText == 'invalid_pass'){
        alert('error',"Mật khẩu không đúng!");
      }
      else{
        //khởi tạo biến "fileurl" để lưu đường dẫn hiện tại của trang. Đường dẫn này được chia thành nhiều phần bằng dấu "/".
        // Hàm "split()" được sử dụng để chia đường dẫn thành các phần dựa trên dấu "/". Sau đó, ".pop()" được sử dụng để lấy ra phần tử cuối cùng của mảng,
        //nghĩa là tên file của trang hiện tại. Sau đó, ".split('?')" được sử dụng để tách đường dẫn và các tham số của URL. ".shift()" được sử dụng để lấy phần tử đầu tiên của mảng
        let fileurl = window.location.href.split('/').pop().split('?').shift();
        if(fileurl == 'room_details.php'){
          window.location = window.location.href;
        }
        else{
          window.location = window.location.pathname;
        }
      }
    }

    xhr.send(data);
  });

  let forgot_form = document.getElementById('forgot-form');

  forgot_form.addEventListener('submit', (e)=>{
    e.preventDefault();

    let data = new FormData();

    data.append('email',forgot_form.elements['email'].value);
    data.append('forgot_pass','');

    var myModal = document.getElementById('forgotModal');
    var modal = bootstrap.Modal.getInstance(myModal);
    modal.hide();

    let xhr = new XMLHttpRequest();
    xhr.open("POST","ajax/login_register.php",true);

    xhr.onload = function(){
      if(this.responseText == 'inv_email'){
        alert('error',"Email không hợp lệ !");
      }
      else if(this.responseText == 'not_verified'){
        alert('error',"Email chưa được xác minh! Vui lòng liên hệ Quản trị viên");
      }
      else if(this.responseText == 'inactive'){
        alert('error',"Toàn khoản bị đình chỉ! Vui lòng liên hệ Quản trị viên.");
      }
      else if(this.responseText == 'mail_failed'){
        alert('error',"Không thể gửi email. Máy chủ ngừng hoạt động!");
      }
      else if(this.responseText == 'upd_failed'){
        alert('error',"Khôi phục tài khoản không thành công. Máy chủ ngừng hoạt động!");
      }
      else{
        alert('success',"Đặt lại liên kết được gửi đến email!");
        forgot_form.reset();
      }
    }

    xhr.send(data);
  });

  function checkLoginToBook(status,room_id){
    if(status){
      window.location.href='confirm_booking.php?id='+room_id;
    }
    else{
      alert('error','Vui lòng đăng nhập để đặt phòng!');
    }
  }

  setActive();

</script>