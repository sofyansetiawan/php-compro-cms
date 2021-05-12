<?php 
session_start();
$title = "Edit app Office";
include_once "header.php";

$seleksi_app_office = mysqli_query($koneksi, "SELECT * FROM app WHERE kategori_app = 'app_office' LIMIT 1") or die("<script>alert('Query salah')</script>");
$jumlah_app_office = mysqli_num_rows($seleksi_app_office);
?>

<div class="container margin-b50">
      <div class="row">
        <div class="col-md-8 col-md-offset-2">

         <?php echo $status_form; ?>
          
          <nav class="navbar navbar-default navbar-utama nav-admin-data" role="navigation">
            <div class="container-fluid">
              <!-- Brand and toggle get grouped for better mobile display -->
              <div class="navbar-header">
                <a class="navbar-brand" href="#"><i class="fa fa-pencil"></i> Edit app Office</a>
              </div>
              
              </div><!-- /.container-fluid -->
            </nav>
            
          </div>
        </div>
        <div class="row">
          <div class="col-md-8 col-md-offset-2">
            <div class="well">
              <?php 
                if($jumlah_app_office == 1){
                  while($daftar_app_office = mysqli_fetch_array($seleksi_app_office)){
              ?>

              <form class="form-horizontal" role="form" action="action.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="inputNama" class="col-sm-2 control-label">Judul app Office</label>
                  <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputNama" placeholder="misal: app Office" value="<?php echo $daftar_app_office['judul_app']; ?>" name="judul_app_office" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputNama" class="col-sm-2 control-label">Cover Saat Ini</label>
                  <div class="col-sm-8">
                      <?php 
                        if(!empty($daftar_app_office['image_app'])){
                      ?>
                        <img src="../upload/image/app/office/<?php echo $daftar_app_office['image_app']; ?>" alt="<?php echo $daftar_app_office['image_app']; ?>" class="img-responsive" width="200" onError="this.onerror=null;this.src='../images/no_image/no-app2.png';">
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
                  <label for="inputFile" class="col-sm-2 control-label">Upload Cover Baru</label>
                  <div class="col-sm-10">
                      <input type="file" class="form-control" id="inputFile" placeholder="Pilih Gambar Cover" name="upload_cover">
                      <small class="text-muted">File image harus berekstensi (jpg / png), ukuran 700 x 700 pixel, size maksimal 80 KB</small><br>
                      <small class="text-muted">Lewati jika tidak ingin mengganti image dengan yang baru.</small>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputIsi" class="col-sm-2 control-label">Konten app</label>
                  <div class="col-sm-10">
                      <textarea id="editor" class="form-control" rows="15" id="InputIsi" name="konten_app_office" required><?php echo $daftar_app_office['konten_app']; ?></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputNama" class="col-sm-2 control-label">Teks URL</label>
                  <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputNama" placeholder="misal: View" value="<?php echo $daftar_app_office['teks_url']; ?>" name="teks_url_app_office" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputNama" class="col-sm-2 control-label">Link URL</label>
                  <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputNama" placeholder="misal: http://eappoffice.com" value="<?php echo $daftar_app_office['url_app']; ?>" name="url_app_office" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputStatusHome" class="col-sm-2 control-label"></label>
                  <div class="col-sm-8">
                      <div class="form-check">
                        <label>
                          <input type="checkbox" name="app_aktif" value="1" <?php if($daftar_app_office['aktif'] == 'ya'){ echo 'checked'; } ?>> <span class="label-text">Aktif</span>
                        </label>
                      </div>
                  </div>
                </div>
                <hr class="hr1">
                <div class="form-group">
                  <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary bold" name="app_office_edit"><i class="fa fa-save"></i> Simpan</button>
                  </div>
                </div>
              </form>

              <?php
                }

              }
                elseif($jumlah_app_office == 0){
              ?>

              <form class="form-horizontal" role="form" action="action.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="inputNama" class="col-sm-2 control-label">Judul app Office</label>
                  <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputNama" placeholder="misal: app Office" value="" name="judul_app_office" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputFile" class="col-sm-2 control-label">Upload Cover Baru</label>
                  <div class="col-sm-10">
                      <input type="file" class="form-control" id="inputFile" placeholder="Pilih Gambar Cover" name="upload_cover">
                      <small class="text-muted">File image harus berekstensi (jpg / png) 700 x 700 pixel, size maksimal 80 KB</small>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputIsi" class="col-sm-2 control-label">Konten app</label>
                  <div class="col-sm-10">
                      <textarea id="editor" class="form-control" rows="15" id="InputIsi" name="konten_app_office"></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputNama" class="col-sm-2 control-label">Teks URL</label>
                  <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputNama" placeholder="misal: View" value="" name="teks_url_app_office" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputNama" class="col-sm-2 control-label">Link URL</label>
                  <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputNama" placeholder="misal: http://eappoffice.com" value="" name="url_app_office" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputStatusHome" class="col-sm-2 control-label"></label>
                  <div class="col-sm-8">
                      <div class="form-check">
                        <label>
                          <input type="checkbox" name="app_aktif" value="1" checked> <span class="label-text">Aktif</span>
                        </label>
                      </div>
                  </div>
                </div>
                <hr class="hr1">
                <div class="form-group">
                  <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary bold" name="app_office_tambah"><i class="fa fa-save"></i> Tambah</button>
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