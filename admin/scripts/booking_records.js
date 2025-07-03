/*************** 1. Hàm tải danh sách đặt phòng ***************/
function get_bookings(search_term = '') {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/booking_records.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onload = function () {
    document.getElementById('table-data').innerHTML = this.responseText;
  };

  xhr.send('get_bookings=true&search=' + encodeURIComponent(search_term));
}

/*************** 2. Gọi hàm khi trang vừa tải ***************/
window.onload = function () {
  get_bookings();
};

/*************** 3. Hàm mở modal Gia hạn ***************/
function extendBooking(booking_id) {
  document.getElementById('extend_booking_id').value = booking_id;
  const modal = new bootstrap.Modal(document.getElementById('extendBookingModal'));
  modal.show();
}

/*************** 4. Gửi request Gia hạn ***************/
document.getElementById('extend-booking-form').addEventListener('submit', function (e) {
  e.preventDefault();

  let booking_id = document.getElementById('extend_booking_id').value;
  let extra_days = document.getElementById('extra_days').value;

  let formData = new FormData();
  formData.append('extend_booking', true);
  formData.append('booking_id', booking_id);
  formData.append('extra_days', extra_days);

  fetch('ajax/booking_records.php', {
    method: 'POST',
    body: formData,
  })
    .then((res) => res.text())
    .then((data) => {
      if (data.trim() === 'success') {
        alert('Gia hạn thành công!');
        bootstrap.Modal.getInstance(document.getElementById('extendBookingModal')).hide();
        get_bookings(document.getElementById('search_input').value); // reload bảng
      } else {
        alert('Gia hạn thất bại!');
      }
    });
});

/*************** 5. Tải file PDF ***************/
function download(id) {
  window.location.href = 'generate_pdf.php?gen_pdf&id=' + id;
}
