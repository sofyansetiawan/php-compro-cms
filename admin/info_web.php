<?php
session_start();
$title = "Edit Info Web dan Meta";
include_once "header.php";
$seleksi_info = mysqli_query($koneksi, "SELECT * FROM info_web LIMIT 1") or die("<script>alert('Query salah')</script>");
$jumlah_info = mysqli_num_rows($seleksi_info);
?>
<div class="container margin-b50">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      
      <?php echo $status_form; ?>
      
      <nav class="navbar navbar-default navbar-utama nav-admin-data" role="navigation">
        <div class="container-fluid">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header">
            <a class="navbar-brand" href="#"><i class="fa fa-pencil"></i> Edit Info Web & Meta</a>
          </div>
          
          </div><!-- /.container-fluid -->
        </nav>
        
      </div>
    </div>
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="well">
          <?php
          if($jumlah_info == 1){
          while($daftar_info = mysqli_fetch_array($seleksi_info)){
          ?>
          <form class="form-horizontal" role="form" action="action.php" method="post" enctype="multipart/form-data">
            <fieldset class="scheduler-border">
              <legend class="scheduler-border">Info Umum</legend>
              <div class="form-group">
                <label for="inputNama1" class="col-sm-2 control-label">Nama Perusahaan</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="inputNama1" placeholder="misal: PT app Solusi Teknology" value="<?php echo $daftar_info['nama_perusahaan']; ?>" name="nama_perusahaan" required>
                </div>
              </div>
              <div class="form-group">
                <label for="inputNama2" class="col-sm-2 control-label">Title Website</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="inputNama2" placeholder="misal: PT app Solusi Teknology" value="<?php echo $daftar_info['title_website']; ?>" name="title_website" required>
                </div>
              </div>
            </fieldset>
            <fieldset class="scheduler-border">
              <legend class="scheduler-border">Meta</legend>
              <div class="form-group">
                  <label for="inputNama" class="col-sm-2 control-label">Favicon Saat Ini</label>
                  <div class="col-sm-8">
                      <?php 
                        if(!empty($daftar_info['favicon'])){
                      ?>
                        <img src="../upload/image/favicon/<?php echo $daftar_info['favicon']; ?>" alt="<?php echo $daftar_info['favicon']; ?>" class="img-responsive" width="100" onError="this.onerror=null;this.src='../images/no_image/no-favicon.png';">
                      <?php
                        }
                        else{
                      ?>
                        <h4>Tidak ada Favicon</h4>
                      <?php
                        }
                      ?>
                  </div>
              </div>
              <div class="form-group">
                  <label for="inputFile" class="col-sm-2 control-label">Upload Favicon</label>
                  <div class="col-sm-10">
                      <input type="file" class="form-control" id="inputFile" placeholder="Pilih Favicon" name="upload_favicon">
                      <small class="text-muted">File image harus berekstensi (jpg / png), ukuran 667 x 667 pixel, size maksimal 100 KB</small><br>
                      <small class="text-muted">Lewati jika tidak ingin mengganti image dengan yang baru.</small>
                  </div>
                </div>
              <div class="form-group">
                <label for="inputNama5" class="col-sm-2 control-label">Deskripsi</label>
                <div class="col-sm-10">
                  <textarea id="editor2" class="form-control" rows="5" id="InputIsi" name="deskripsi" required><?php echo $daftar_info['deskripsi']; ?></textarea>
                  <small class="text-danger">Deskripsi website akan menjadi bagian dari meta, berisi informasi deskripsi singkat tentang website<br>Maksimal karakter untuk meta deskripsi adalah <strong>150 karakter</strong></small>
                </div>
              </div>
              <div class="form-group">
                <label for="inputNama5" class="col-sm-2 control-label">Keyword</label>
                <div class="col-sm-10">
                  <textarea id="editor2" class="form-control" rows="5" id="InputIsi" name="keyword" required><?php echo $daftar_info['keyword']; ?></textarea>
                  <small class="text-muted">Keyword website akan menjadi bagian dari meta, berisi kata-kata kunci yang berkaitan dengan isi website. Setiap keyword dipisahkan dengan koma ( , )</small>
                </div>
              </div>
              <div class="form-group">
                <label for="inputNama2" class="col-sm-2 control-label">Author</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="inputNama2" placeholder="misal: website" value="<?php echo $daftar_info['author']; ?>" name="author" required>
                </div>
              </div>
            </fieldset>

              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <button type="submit" class="btn btn-primary bold" name="info_web_edit"><i class="fa fa-save"></i> Simpan</button>
                </div>
              </div>
            </form>
          <?php
          }
          }
          elseif($jumlah_info == 0){
          ?>
            <form class="form-horizontal" role="form" action="action.php" method="post" enctype="multipart/form-data">
            <fieldset class="scheduler-border">
              <legend class="scheduler-border">Info Umum</legend>
              <div class="form-group">
                <label for="inputNama1" class="col-sm-2 control-label">Nama Perusahaan</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="inputNama1" placeholder="misal: PT app Solusi Teknology" value="" name="nama_perusahaan" required>
                </div>
              </div>
              <div class="form-group">
                <label for="inputNama2" class="col-sm-2 control-label">Title Website</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="inputNama2" placeholder="misal: PT app Solusi Teknology" value="" name="title_website" required>
                </div>
              </div>
            </fieldset>
            <fieldset class="scheduler-border">
              <legend class="scheduler-border">Meta</legend>
              <div class="form-group">
                  <label for="inputFile" class="col-sm-2 control-label">Upload Favicon</label>
                  <div class="col-sm-10">
                      <input type="file" class="form-control" id="inputFile" placeholder="Pilih Favicon" name="upload_favicon" required>
                      <small class="text-muted">File image harus berekstensi (jpg / png), ukuran 667 x 667 pixel, size maksimal 100 KB</small><br>
                      <small class="text-muted">Lewati jika tidak ingin mengganti image dengan yang baru.</small>
                  </div>
                </div>
              <div class="form-group">
                <label for="inputNama5" class="col-sm-2 control-label">Deskripsi</label>
                <div class="col-sm-10">
                  <textarea id="editor2" class="form-control" rows="5" id="InputIsi" name="deskripsi" required></textarea>
                  <small class="text-muted">Deskripsi website akan menjadi bagian dari meta, berisi informasi deskripsi singkat tentang website</small>
                </div>
              </div>
              <div class="form-group">
                <label for="inputNama5" class="col-sm-2 control-label">Keyword</label>
                <div class="col-sm-10">
                  <textarea id="editor2" class="form-control" rows="5" id="InputIsi" name="keyword" required></textarea>
                  <small class="text-muted">Keyword website akan menjadi bagian dari meta, berisi kata-kata kunci yang berkaitan dengan isi website. Setiap keyword dipisahkan dengan koma ( , )</small>
                </div>
              </div>
              <div class="form-group">
                <label for="inputNama2" class="col-sm-2 control-label">Author</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="inputNama2" placeholder="misal: website" value="" name="author" required>
                </div>
              </div>
            </fieldset>

              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <button type="submit" class="btn btn-primary bold" name="info_web_tambah"><i class="fa fa-save"></i> Tambah</button>
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