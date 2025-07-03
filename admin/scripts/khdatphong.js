function get_bookings(search = '') {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/khdatphong.php", true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  xhr.onload = function () {
    document.getElementById('table-data').innerHTML = this.responseText;
  }

  xhr.send('get_bookings&search=' + search);
}

let assign_room_form = document.getElementById('assign_room_form');

function assign_room(id) {
  assign_room_form.elements['booking_id'].value = id;
}

assign_room_form.addEventListener('submit', function (e) {
  e.preventDefault();

  let data = new FormData();
  data.append('room_no', assign_room_form.elements['room_no'].value);
  data.append('booking_id', assign_room_form.elements['booking_id'].value);
  data.append('assign_room', '');

  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/khdatphong.php", true);

  xhr.onload = function () {
    var myModal = document.getElementById('assign-room');
    var modal = bootstrap.Modal.getInstance(myModal);
    modal.hide();

    if (this.responseText == 1) {
      alert('success', 'Room Number Alloted! Booking Finalized!');
      assign_room_form.reset();
      get_bookings();
    }
    else {
      alert('error', 'Server Down!');
    }
  }

  xhr.send(data);
});

function kh_booking(id) {
  if (confirm("Bạn có chắc chắn, bạn muốn xác nhận đặt phòng này?")) {
    let data = new FormData();

    data.append('booking_id', id);
    // data.append('trans_amt', price * totalDay);
    // data.append('booking_status', 'Đã Xác Nhận Đặt Phòng');
    // data.append('trans_status', 'TXN_SUCCESS');
    // data.append('payment_booking', '');
    data.append('kh_booking', '');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/khdatphong.php", true);

    xhr.onload = function () {
      console.log(this.responseText)
      if (this.responseText == 1) {
        alert('success', 'Xác nhận thành công!');
        get_bookings();
      }
      else {
        alert('error', 'Lỗi!');
        get_bookings();
      }
    }

    xhr.send(data);
  }
}

function huy_booking(id) {
  if (confirm("Bạn có chắc chắn, bạn muốn hủy đặt phòng này?")) {
    let data = new FormData();
    data.append('booking_id', id);
    data.append('huy_booking', '');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/khdatphong.php", true);

    xhr.onload = function () {
      if (this.responseText == 1) {
        alert('success', 'Đặt chỗ đã bị hủy!');
        get_bookings();
      }
      else {
        alert('error', 'Server Down!');
      }
    }

    xhr.send(data);
  }
}

window.onload = function () {
  get_bookings();
}