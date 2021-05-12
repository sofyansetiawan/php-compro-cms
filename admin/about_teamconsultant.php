<?php 
  session_start();
  $title = "Edit About Team Consultant";
  include_once "header.php";

  $seleksi_teamconsultant = mysqli_query($koneksi, "SELECT * FROM about WHERE category = 'teamconsultant' LIMIT 1") or die("<script>alert('Query salah')</script>");
  $jumlah_teamconsultant = mysqli_num_rows($seleksi_teamconsultant);
?>

<div class="container margin-b50">
      <div class="row">
        <div class="col-md-8 col-md-offset-2">

          <?php echo $status_form; ?>
          
          <nav class="navbar navbar-default navbar-utama nav-admin-data" role="navigation">
            <div class="container-fluid">
              <!-- Brand and toggle get grouped for better mobile display -->
              <div class="navbar-header">
                <a class="navbar-brand" href="#"><i class="fa fa-pencil"></i> Edit About Team Consultant</a>
              </div>
            </div><!-- /.container-fluid -->
          </nav>  
          </div>
        </div>
        <div class="row">
          <div class="col-md-8 col-md-offset-2">
            <div class="well">

              <?php 
                if($jumlah_teamconsultant == 1){
                  while($daftar_teamconsultant = mysqli_fetch_array($seleksi_teamconsultant)){
              ?>

              <form class="form-horizontal" role="form" action="action.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="inputNama" class="col-sm-2 control-label">Judul About Team Consultant</label>
                  <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputNama" placeholder="misal: About Team Consultant" value="<?php echo $daftar_teamconsultant['judul']; ?>" name="judul_teamconsultant" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputNama" class="col-sm-2 control-label">Logo Saat Ini</label>
                  <div class="col-sm-8">
                      <?php 
                        if(!empty($daftar_teamconsultant['image_about'])){
                      ?>
                        <img src="../upload/image/about/teamconsultant/<?php echo $daftar_teamconsultant['image_about']; ?>" alt="<?php echo $daftar_teamconsultant['image_about']; ?>" class="img-responsive" width="200" onError="this.onerror=null;this.src='../images/no_image/no-about-team.png';">
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
                      <small class="text-muted">File image harus berekstensi (jpg / png), ukuran 71 x 60 pixel, size maksimal 100 KB<br>
                      Kosongi jika tidak ingin mengganti image dengan yang baru.</small>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputIsi" class="col-sm-2 control-label">Konten About Team Consultant</label>
                  <div class="col-sm-10">
                      <textarea id="editor" class="form-control" rows="15" id="InputIsi" name="konten_teamconsultant" required><?php echo $daftar_teamconsultant['konten']; ?></textarea>
                  </div>
                </div>
                <hr class="hr1">
                <div class="form-group">
                  <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary bold" name="about_teamconsultant_edit"><i class="fa fa-save"></i> Simpan</button>
                  </div>
                </div>
              </form>

              <?php
                }

              }
                elseif($jumlah_teamconsultant == 0){
              ?>

              <form class="form-horizontal" role="form" action="action.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="inputNama" class="col-sm-2 control-label">Judul About Team Consultant</label>
                  <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputNama" placeholder="misal: About Team Consultant" name="judul_teamconsultant" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputFile" class="col-sm-2 control-label">Upload Logo Baru</label>
                  <div class="col-sm-8">
                      <input type="file" class="form-control" id="inputFile" placeholder="Pilih Gambar Cover" name="upload_logo">
                      <small class="text-muted">File image harus berekstensi (jpg / png), ukuran 71 x 60 pixel, size maksimal 100 KB<br>
                      Kosongi jika tidak ingin mengganti image dengan yang baru.</small>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputIsi" class="col-sm-2 control-label">Konten About Team Consultant</label>
                  <div class="col-sm-10">
                      <textarea id="editor" class="form-control" rows="15" id="InputIsi" name="konten_teamconsultant" required></textarea>
                  </div>
                </div>
                <hr class="hr1">
                <div class="form-group">
                  <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary bold" name="about_teamconsultant_tambah"><i class="fa fa-save"></i> Tambah</button>
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