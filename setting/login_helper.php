<?php 

if(isset($_SESSION['id_user']) && isset($_SESSION['level'])){
  echo "<script>alert('Anda sudah login.')</script>";
  echo "<script>window.location.href='dashboard.php';</script>";
}
else{

}

if(isset($_POST['submit_login'])){
  
  $username       = isset($_POST['username']) ? $_POST['username'] : '' ;
  $password       = isset($_POST['password']) ? $_POST['password'] : '' ;
  $level          = isset($_POST['level']) ? $_POST['level'] : '' ;
  
  $username_login = trim(strip_tags(htmlentities($username)));
  $password_login = htmlentities(md5($password));
  $level_login    = trim(strip_tags(htmlentities($level)));

  $seleksi = mysqli_query($koneksi, "SELECT id_user, username, password, level FROM user WHERE username = '$username_login' and password = '$password_login' and level = '$level_login' ") or die("Query Salah");

  $data_user = mysqli_fetch_array($seleksi);
  $jumlah_baris = mysqli_num_rows($seleksi);

  
  if (empty($username_login) && empty($password_login) && empty($level_login)) {
      echo "<script>alert('Username, Password dan Level masih kosong.!');</script>";
      echo "<script>window.location.href='login.php';</script>";

  } elseif (empty($username_login)) {
      echo "<script>alert('Username masih kosong.!');</script>";
      echo "<script>window.location.href='login.php';</script>";

  } elseif (empty($password_login)) {
      echo "<script>alert('Password masih kosong.!');</script>";
      echo "<script>window.location.href='login.php';</script>";

  } elseif (empty($level_login)) {
      echo "<script>alert('Level masih kosong.!');</script>";
      echo "<script>window.location.href='login.php';</script>";

  } else {

      if ( $data_user['username'] == $username_login && $data_user['password'] == $password_login && $data_user['level'] == $level_login) {
        if ($jumlah_baris==1) {
          $_SESSION['id_user'] = $data_user['id_user'] ;
          $_SESSION['level'] = $data_user['level'] ;
          header('location: dashboard.php');
        }
        elseif ($jumlah_baris>1) {
          echo "<script>alert('Ada Kesalahan, mungkin ada 2 atau lebih username yang sama.!');</script>";
        }
        else {
          echo "<script>alert('Ada Kesalahan, silakan hubungi programmer.!');</script>";
        }
      }

      else{
          echo "<script>alert('Ada Kesalahan! Silakan Masukkan Username, Password dan Level dengan benar!');</script>";
      }
  }
  
}

?>