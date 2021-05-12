<?php 
  session_start();
  $title = "Edit About Mission";
  include_once "header.php";

  $seleksi_mission = mysqli_query($koneksi, "SELECT * FROM about WHERE category = 'mission' LIMIT 1") or die("<script>alert('Query salah')</script>");
  $jumlah_mission = mysqli_num_rows($seleksi_mission);
?>

<div class="container margin-b50">
      <div class="row">
        <div class="col-md-8 col-md-offset-2">
          <?php echo $status_form; ?>
          
          <nav class="navbar navbar-default navbar-utama nav-admin-data" role="navigation">
            <div class="container-fluid">
              <!-- Brand and toggle get grouped for better mobile display -->
              <div class="navbar-header">
                <a class="navbar-brand" href="#"><i class="fa fa-pencil"></i> Edit About Mission</a>
              </div>
            </div><!-- /.container-fluid -->
          </nav>  
          </div>
        </div>
        <div class="row">
          <div class="col-md-8 col-md-offset-2">
            <div class="well">

              <?php 
                if($jumlah_mission == 1){
                  while($daftar_mission = mysqli_fetch_array($seleksi_mission)){
              ?>

              <form class="form-horizontal" role="form" action="action.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="inputNama" class="col-sm-2 control-label">Judul About Mission</label>
                  <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputNama" placeholder="misal: About Mission" value="<?php echo $daftar_mission['judul']; ?>" name="judul_mission" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputNama" class="col-sm-2 control-label">Logo Saat Ini</label>
                  <div class="col-sm-8">
                      <?php 
                        if(!empty($daftar_mission['image_about'])){
                      ?>
                        <img src="../upload/image/about/mission/<?php echo $daftar_mission['image_about']; ?>" alt="<?php echo $daftar_mission['image_about']; ?>" class="img-responsive" width="200" onError="this.onerror=null;this.src='../images/no_image/no-about-mission.png';">
                      <?php
                        }
                        else{
                      ?>
                        <h4>Tidak ada logo</h4>
                      <?php
                        }
                      ?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputFile" class="col-sm-2 control-label">Upload Logo Baru</label>
                  <div class="col-sm-8">
                      <input type="file" class="form-control" id="inputFile" placeholder="Pilih Gambar Cover" name="upload_logo">
                      <small class="text-muted">File image harus berekstensi (jpg / png), ukuran 63 x 61 pixel, size maksimal 100 KB<br>
                      Kosongi jika tidak ingin mengganti image dengan yang baru.</small>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputIsi" class="col-sm-2 control-label">Konten About Mission</label>
                  <div class="col-sm-10">
                      <textarea id="editor" class="form-control" rows="15" id="InputIsi" name="konten_mission" required><?php echo $daftar_mission['konten']; ?></textarea>
                  </div>
                </div>
                <hr class="hr1">
                <div class="form-group">
                  <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary bold" name="about_mission_edit"><i class="fa fa-save"></i> Simpan</button>
                  </div>
                </div>
              </form>

              <?php
                }

              }
                elseif($jumlah_mission == 0){
              ?>

              <form class="form-horizontal" role="form" action="action.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="inputNama" class="col-sm-2 control-label">Judul About Mission</label>
                  <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputNama" placeholder="misal: About Mission" name="judul_mission" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputFile" class="col-sm-2 control-label">Upload Logo Baru</label>
                  <div class="col-sm-8">
                      <input type="file" class="form-control" id="inputFile" placeholder="Pilih Gambar Cover" name="upload_logo">
                      <small class="text-muted">File image harus berekstensi (jpg / png), ukuran 63 x 61 pixel, size maksimal 100 KB<br>
                      Kosongi jika tidak ingin mengganti image dengan yang baru.</small>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputIsi" class="col-sm-2 control-label">Konten About Mission</label>
                  <div class="col-sm-10">
                      <textarea id="editor" class="form-control" rows="15" id="InputIsi" name="konten_mission" required></textarea>
                  </div>
                </div>
                <hr class="hr1">
                <div class="form-group">
                  <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary bold" name="about_mission_tambah"><i class="fa fa-save"></i> Tambah</button>
                  </div>
                </div>
              </form>

              <?php  
                }
              ?>

            </div>
          </div>
        </div>
      </div>

      <script src="../assets/ckeditor/ckeditor.js"></script>
      <script type="text/javascript">
        CKEDITOR.editorConfig = function (config) {
            config.language = 'es';
            config.uiColor = '#F7B42C';
            config.height = 600;
            config.toolbarCanCollapse = true;

        };
        CKEDITOR.replace('editor');
      </script>

      <?php 
        include_once "footer.php";
      ?>