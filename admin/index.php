<?php 
session_start();
include_once "../setting/database.php";
include_once "../setting/login_helper.php";
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Halaman Login website.com</title>
    <link rel="shortcut icon" href="favicon.png">
    <link href="../assets/css/bootstrap.min3.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/font-awesome.min.css">
    <link href="../assets/css/style_admin.css" rel="stylesheet">
  </head>
  <body>
    <div class="container">
      <div class="row">
      <div class="col-md-12">
        <div class="ukuran500 tengah">
          <div class="head-depan tengah">
            <div class="row">
              <div class="col-md-12">
                <center><img class="margin-b10" src="../images/eapp_logo.png" width="200" height="63" alt="Site Logo Eapp" /></center>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 text-center">
                <p class="lead">Selamat Datang Team app, Maju Bersama, Membangun Masa Depan.</p>
                <p class="lead">Let's Do It.</p>            
              </div>
            </div>
            <hr class="hr1 margin-b-10" />
          </div>
        </div>

        <div class="ukuran450 tengah margin-b50">
          <div class="login-container">
            <div id="output"></div>
            <div class="form-box">
              <form action="" method="post">
                <legend><h3 class="text-center">Login Web Company Profile</h3></legend>
                <div class="left-inner-addon2">
                  <i class="fa fa-user"></i>
                  <input name="username" class="input-lg form-control" type="text" placeholder="Username" value="" required="required" autocomplete="off">
                </div>
                <div class="left-inner-addon2">
                  <i class="fa fa-lock"></i>
                  <input name="password" type="password" value="" class="input-lg form-control" placeholder="Password" required="required" autocomplete="off">
                </div>
                <div class="left-inner-addon2">
                  <i class="fa fa-star"></i>
                  <select name="level" class="input-lg form-control" required="required" autocomplete="off">
                    <option value="">- Pilih Level -</option>
                    <option value="superuser">Super User</option>
                    <option value="admin">Admin</option>
                    <option value="marketing">Marketing</option>
                    <option value="news">News</option>
                  </select>
                </div>
                <div class="form-group">
                  <button class="btn btn-info btn-lg btn-block login" type="submit" name="submit_login">Login</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        </div>
      </div>
    </div>
    <script src="../assets/js/jquery.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/bootstrap-hover-dropdown.js"></script>
    <script src="../assets/js/script.js"></script>
  </body>
</html>