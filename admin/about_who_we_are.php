<?php 
session_start();
$title = "Edit About Who We Are";
include_once "header.php";

$seleksi_about_who_we_are = mysqli_query($koneksi, "SELECT * FROM about WHERE category = 'who_we_are' LIMIT 1") or die("<script>alert('Query salah')</script>");
$jumlah_who_we_are = mysqli_num_rows($seleksi_about_who_we_are);
?>

<div class="container margin-b50">
      <div class="row">
        <div class="col-md-8 col-md-offset-2">

          <?php echo $status_form; ?>
          
          <nav class="navbar navbar-default navbar-utama nav-admin-data" role="navigation">
            <div class="container-fluid">
              <!-- Brand and toggle get grouped for better mobile display -->
              <div class="navbar-header">
                <a class="navbar-brand" href="#"><i class="fa fa-pencil"></i> Edit About Who We Are</a>
              </div>
              
              </div><!-- /.container-fluid -->
            </nav>
            
          </div>
        </div>
        <div class="row">
          <div class="col-md-8 col-md-offset-2">
            <div class="well">
              <?php 
                if($jumlah_who_we_are == 1){
                  while($daftar_who_we_are = mysqli_fetch_array($seleksi_about_who_we_are)){
              ?>
                
                <form class="form-horizontal" role="form" action="action.php" method="post">
                <div class="form-group">
                  <label for="inputNama" class="col-sm-2 control-label">Judul About Who</label>
                  <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputNama" placeholder="misal: About Who We Are" value="<?php echo $daftar_who_we_are['judul']; ?>" name="judul_who" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputIsi" class="col-sm-2 control-label">Konten About Who</label>
                  <div class="col-sm-10">
                      <textarea id="editor" class="form-control" rows="15" id="InputIsi" name="konten_who" required><?php echo $daftar_who_we_are['konten']; ?></textarea>
                  </div>
                </div>
                <hr class="hr1">
                <div class="form-group">
                  <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary bold" name="about_who_we_are_edit"><i class="fa fa-save"></i> Simpan</button>
                  </div>
                </div>
              </form>


              <?php
                }

              }
                elseif($jumlah_who_we_are == 0){
              ?>

                <form class="form-horizontal" role="form" action="action.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="inputNama" class="col-sm-2 control-label">Judul About Who</label>
                  <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputNama" placeholder="misal: About Who We Are" value="About Who We Are" name="judul_who" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputIsi" class="col-sm-2 control-label">Konten About Who</label>
                  <div class="col-sm-10">
                      <textarea id="editor" class="form-control" rows="15" id="InputIsi" name="konten_who" required>Teks untuk isi about who we are</textarea>
                  </div>
                </div>
                <hr class="hr1">
                <div class="form-group">
                  <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary bold" name="about_who_we_are_tambah"><i class="fa fa-save"></i> Tambah</button>
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

      <<script src="../assets/ckeditor/ckeditor.js"></script>
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