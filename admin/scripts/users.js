function get_users()
{
  let xhr = new XMLHttpRequest();
  xhr.open("POST","ajax/users.php",true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  xhr.onload = function(){
    document.getElementById('users-data').innerHTML = this.responseText;
  }

  xhr.send('get_users');
}




function remove_user(user_id)
{
  if(confirm("Bạn có chắc chắn muốn xóa người dùng này không?"))
  {
    let data = new FormData();
    data.append('user_id',user_id);
    data.append('remove_user','');

    let xhr = new XMLHttpRequest();
    xhr.open("POST","ajax/users.php",true);

    xhr.onload = function()
    {
      if(this.responseText == 1){
        alert('success','Đã xóa người dùng!');
        get_users();
      }
      else{
        alert('error','Xóa người dùng không thành công!');
      }
    }
    xhr.send(data);
  }
}

function search_user(username){
  let xhr = new XMLHttpRequest();
  xhr.open("POST","ajax/users.php",true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  xhr.onload = function(){
    document.getElementById('users-data').innerHTML = this.responseText;
  }

  xhr.send('search_user&name='+username);
}

window.onload = function(){
  get_users();
}