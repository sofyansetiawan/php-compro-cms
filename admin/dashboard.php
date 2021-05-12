<?php 
session_start();
$title = "Beranda";
include_once "header.php";
?>


            <div class="container margin-b70">
              <div class="row">
                <div class="col-md-10 col-md-offset-2">
                  <div class="alert alert-success fade in">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <strong>Selamat Datang, <?php echo $_SESSION['level']; ?>!</strong> Maju Bersama, Membangun Masa Depan. Let's Do It.
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-10 col-md-offset-2">
                  <div class="panel panel-primary">
                    <div class="panel-heading">
                      <h3 class="panel-title">Operasi</h3>
                    </div>
                    <div class="panel-body">
                      <?php 
                      if($_SESSION['level'] == 'news'){
                      ?>
                        <button onclick="location.href = 'event_news_tambah.php';" type="button" class="btn btn-success btn-lg"><span class="fa fa-plus-circle"></span> Tambah Event News</button>

                      <?php
                      }
                      elseif($_SESSION['level'] == 'admin' || $_SESSION['level'] == 'marketing'){
                      ?>
                        <button onclick="location.href = 'event_news_tambah.php';" type="button" class="btn btn-success btn-lg"><span class="fa fa-plus-circle"></span> Tambah Event News</button>
                        <button onclick="location.href = 'partner_tambah.php';" type="button" class="btn btn-warning btn-lg"><span class="fa fa-plus-circle"></span> Tambah Partner</button>
                        <button onclick="location.href = 'testimoni_tambah.php';" type="button" class="btn btn-danger btn-lg"><span class="fa fa-plus-circle"></span> Tambah Testimoni</button>
                        <button onclick="location.href = 'cover_tambah.php';" type="button" class="btn btn-info btn-lg"><span class="fa fa-plus-circle"></span> Tambah Cover</button>

                      <?php
                      }
                      elseif($_SESSION['level'] == 'superuser'){
                      ?>
                        <button onclick="location.href = 'event_news_tambah.php';" type="button" class="btn btn-success btn-lg"><span class="fa fa-plus-circle"></span> Tambah Event News</button>
                        <button onclick="location.href = 'partner_tambah.php';" type="button" class="btn btn-warning btn-lg"><span class="fa fa-plus-circle"></span> Tambah Partner</button>
                        <button onclick="location.href = 'testimoni_tambah.php';" type="button" class="btn btn-danger btn-lg"><span class="fa fa-plus-circle"></span> Tambah Testimoni</button>
                        <button onclick="location.href = 'cover_tambah.php';" type="button" class="btn btn-info btn-lg"><span class="fa fa-plus-circle"></span> Tambah Cover</button>
                        <button onclick="location.href = 'profile_tambah.php';" type="button" class="btn btn-primary btn-lg"><span class="fa fa-user"></span> Tambah User</button>
                      <?php
                      }
                      ?>

                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-5 col-md-offset-2">
                  <div class="panel panel-warning">
                    <div class="panel-heading">
                      <h3 class="panel-title">Petunjuk Penggunaan</h3>
                    </div>
                    <div class="panel-body">
                      <ul>
                        <li>Gunakan Menu Di Samping untuk melakukan navigasi</li>
                        <li>Telitilah inputan sebelum disimpan</li>
                        <li>Jika di bagian edit tidak ingin mengganti gambar/foto, maka cukup lewati tanpa input gambar</li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="panel panel-info">
                    <div class="panel-heading">
                      <h3 class="panel-title">Kewajiban</h3>
                    </div>
                    <div class="panel-body">
                      <ul>
                        <li>Jika terdapat kesalahan pada sistem / bugs / alur program salah, dimohon informasikan kesalahan ke programmer (Sofyan Setiawan)</li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php 
            include_once "footer.php";

            ?>