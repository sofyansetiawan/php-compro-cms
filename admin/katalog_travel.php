<?php 
session_start();
$title = "Edit app Travel";
include_once "header.php";

$seleksi_app_travel = mysqli_query($koneksi, "SELECT * FROM app WHERE kategori_app = 'app_travel' LIMIT 1") or die("<script>alert('Query salah')</script>");
$jumlah_app_travel = mysqli_num_rows($seleksi_app_travel);
?>

<div class="container margin-b50">
      <div class="row">
        <div class="col-md-8 col-md-offset-2">

          <?php echo $status_form; ?>
          
          <nav class="navbar navbar-default navbar-utama nav-admin-data" role="navigation">
            <div class="container-fluid">
              <!-- Brand and toggle get grouped for better mobile display -->
              <div class="navbar-header">
                <a class="navbar-brand" href="#"><i class="fa fa-pencil"></i> Edit app Travel</a>
              </div>
              
              </div><!-- /.container-fluid -->
            </nav>
            
          </div>
        </div>
        <div class="row">
          <div class="col-md-8 col-md-offset-2">
            <div class="well">
              <?php 
                if($jumlah_app_travel == 1){
                  while($daftar_app_travel = mysqli_fetch_array($seleksi_app_travel)){
              ?>

              <form class="form-horizontal" role="form" action="action.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="inputNama" class="col-sm-2 control-label">Judul app Travel</label>
                  <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputNama" placeholder="misal: app Travel" value="<?php echo $daftar_app_travel['judul_app']; ?>" name="judul_app_travel" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputNama" class="col-sm-2 control-label">Cover Saat Ini</label>
                  <div class="col-sm-8">
                      <?php 
                        if(!empty($daftar_app_travel['image_app'])){
                      ?>
                        <img src="../upload/image/app/travel/<?php echo $daftar_app_travel['image_app']; ?>" alt="<?php echo $daftar_app_travel['image_app']; ?>" class="img-responsive" width="200" onError="this.onerror=null;this.src='../images/no_image/no-app2.png';">
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
                      <textarea id="editor" class="form-control" rows="15" id="InputIsi" name="konten_app_travel" required><?php echo $daftar_app_travel['konten_app']; ?></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputNama" class="col-sm-2 control-label">Teks URL</label>
                  <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputNama" placeholder="misal: View" value="<?php echo $daftar_app_travel['teks_url']; ?>" name="teks_url_app_travel" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputNama" class="col-sm-2 control-label">Link URL</label>
                  <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputNama" placeholder="misal: http://eapptravel.com" value="<?php echo $daftar_app_travel['url_app']; ?>" name="url_app_travel" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputStatusHome" class="col-sm-2 control-label"></label>
                  <div class="col-sm-8">
                      <div class="form-check">
                        <label>
                          <input type="checkbox" name="app_aktif" value="1" <?php if($daftar_app_travel['aktif'] == 'ya'){ echo 'checked'; } ?>> <span class="label-text">Aktif</span>
                        </label>
                      </div>
                  </div>
                </div>
                <hr class="hr1">
                <div class="form-group">
                  <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary bold" name="app_travel_edit"><i class="fa fa-save"></i> Simpan</button>
                  </div>
                </div>
              </form>

              <?php
                }

              }
                elseif($jumlah_app_travel == 0){
              ?>

              <form class="form-horizontal" role="form" action="action.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="inputNama" class="col-sm-2 control-label">Judul app Travel</label>
                  <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputNama" placeholder="misal: app Travel" value="" name="judul_app_travel" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputFile" class="col-sm-2 control-label">Upload Cover Baru</label>
                  <div class="col-sm-10">
                      <input type="file" class="form-control" id="inputFile" placeholder="Pilih Gambar Cover" name="upload_cover">
                      <small class="text-muted">File image harus berekstensi (jpg / png), ukuran 700 x 700 pixel, size maksimal 80 KB</small>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputIsi" class="col-sm-2 control-label">Konten app</label>
                  <div class="col-sm-10">
                      <textarea id="editor" class="form-control" rows="15" id="InputIsi" name="konten_app_travel"></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputNama" class="col-sm-2 control-label">Teks URL</label>
                  <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputNama" placeholder="misal: View" value="" name="teks_url_app_travel" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputNama" class="col-sm-2 control-label">Link URL</label>
                  <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputNama" placeholder="misal: http://eapptravel.com" value="" name="url_app_travel" required>
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
                    <button type="submit" class="btn btn-primary bold" name="app_travel_tambah"><i class="fa fa-save"></i> Tambah</button>
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