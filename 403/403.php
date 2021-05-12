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
    <title>403 | Forbidden | website.com</title>
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
                <p class="lead">website situs belanja online B2B, B2G, & B2C terlengkap, terpercaya, termurah, se Indonesia Raya. Menjual produk asli, bergaransi resmi, hingga cicilan 0% & gratis pengiriman.</p>            
              </div>
            </div>
            <hr class="hr1 margin-b-10" />
          </div>
        </div>

        <div class="ukuran450 tengah margin-b50">
          <div class="login-container">
            <div id="output"></div>
            <div class="form-box">
                <div class="text-center text-danger"><i class="fa fa-5x fa-exclamation-triangle"></i></div>
                <h1 class="text-center text-danger">403 - Forbidden <p> </p><p><small class="text-center text-danger"> Halaman yang anda akses tersembunyi</small></p></h1>
                <p class="text-center">Jika halaman ini muncul, kemungkinan Anda tidak mempunyai izin untuk mengakses halaman ini.</p>
                <p class="text-center"><a class="btn btn-primary" href="../index.php"><i class="fa fa-home"></i> Ke Halaman Depan</a> <a class="btn btn-info" href="mailto:contact@website.com"><i class="fa fa-envelope-o"></i> Contact Support</a></p>
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