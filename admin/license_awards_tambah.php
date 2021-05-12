<?php 
session_start();
$title = "Tambah License & Awards";
include_once "header.php";
?>

<div class="container margin-b50">
      <div class="row">
        <div class="col-md-8 col-md-offset-2">

          <?php echo $status_form; ?>

          <nav class="navbar navbar-default navbar-utama nav-admin-data" role="navigation">
            <div class="container-fluid">
              <!-- Brand and toggle get grouped for better mobile display -->
              <div class="navbar-header">
                <a class="navbar-brand" href="#"><i class="fa fa-plus-circle"></i> Tambah License & Awards</a>
              </div>
              
              </div><!-- /.container-fluid -->
            </nav>
            
          </div>
        </div>
        <div class="row">
          <div class="col-md-8 col-md-offset-2">
            <div class="well">
              <form class="form-horizontal" role="form" action="action.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="inputNama" class="col-sm-2 control-label">Judul</label>
                  <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputNama" placeholder="misal: Awards PT app" name="judul_license_awards" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputFile" class="col-sm-2 control-label">Upload Image</label>
                  <div class="col-sm-10">
                      <input type="file" class="form-control" id="inputFile" placeholder="Pilih Gambar License & awards" name="upload_license_awards" required>
                      <small class="text-muted">File image harus berekstensi (jpg / png), ukuran 150 x 150 pixel, size maksimal 100 KB</small>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputFile" class="col-sm-2 control-label">Upload QR Code</label>
                  <div class="col-sm-10">
                      <input type="file" class="form-control" id="inputFile" placeholder="Pilih Gambar License & awards" name="upload_qrcode" required>
                      <small class="text-muted">File image harus berekstensi (jpg / png), ukuran 170 x 170 pixel, size maksimal 100 KB</small>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputIsi" class="col-sm-2 control-label">Konten</label>
                  <div class="col-sm-10">
                      <textarea id="editor" class="form-control" rows="15" id="InputIsi" name="konten_license_awards" required></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputStatus" class="col-sm-2 control-label">Urutan</label>
                  <div class="col-sm-10">
                      <select class="form-control" name="urutan_license_awards">
                        <option value="">- Tidak Urutan -</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                      </select>
                      <small class="text-muted">Lewati jika tidak ingin mengganti urutan. Jika tidak dipilih maka tidak masuk 5 urutan paling awal.</small>
                  </div>
                </div>
                
                <hr class="hr1">
                <div class="form-group">
                  <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary bold" name="license_awards_tambah"><i class="fa fa-save"></i> Tambah</button>&nbsp;&nbsp;<a href="license_awards.php" class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
                  </div>
                </div>
              </form>
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