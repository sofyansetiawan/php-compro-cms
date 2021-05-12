<?php 
session_start();
$title = "Edit License & Awards";
include_once "header.php";
if(isset($_GET['id']) && !empty($_GET['id'])){
    $id = $_GET['id'];
    $seleksi_license = mysqli_query($koneksi, "SELECT * FROM license_award WHERE id_license_awards='$id' LIMIT 1");
?>

<div class="container margin-b50">
        <?php
          if(mysqli_num_rows($seleksi_license) == 0){
          echo '<div class="alert alert-danger fade in">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <strong><i class="fa fa-exclamation-triangle"></i> Data Kosong,</strong> Tidak ada data yang tersedia di kolom.
                  <a href="license_awards.php" class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
                </div>';
          }else{
            $daftar_license = mysqli_fetch_array($seleksi_license);
        ?>
      <div class="row">
        <div class="col-md-8 col-md-offset-2">

          <?php echo $status_form; ?>

          <nav class="navbar navbar-default navbar-utama nav-admin-data" role="navigation">
            <div class="container-fluid">
              <!-- Brand and toggle get grouped for better mobile display -->
              <div class="navbar-header">
                <a class="navbar-brand" href="#"><i class="fa fa-pencil"></i> Edit License & Awards</a>
              </div>
              
              </div><!-- /.container-fluid -->
            </nav>
            
          </div>
        </div>
        <div class="row">
          <div class="col-md-8 col-md-offset-2">
            <div class="well">
              <form class="form-horizontal" role="form" action="action.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <div class="form-group">
                  <label for="inputNama" class="col-sm-2 control-label">Judul</label>
                  <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputNama" placeholder="misal: Awards PT app" name="judul_license_awards" value="<?php echo $daftar_license['judul_license_awards']; ?>" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputNama" class="col-sm-2 control-label">Image Saat Ini</label>
                  <div class="col-sm-6">
                    <?php
                       if(!empty($daftar_license['image_license_awards'])){ 
                            if(file_exists("../upload/image/license_awards/".$daftar_license['image_license_awards'])){
                          ?>
                            <img src="../upload/image/license_awards/<?php echo $daftar_license['image_license_awards']; ?>" alt="<?php echo $daftar_license['image_license_awards']; ?>" class="img-responsive" width="200" onError="this.onerror=null;this.src='../images/no_image/no-license.png';">
                          <?php
                            }
                            else{
                          ?>
                            <h4>Tidak ada cover</h4>
                          <?php
                            }
                          }
                          else{
                          ?>
                             <img src="../images/news/power-pdf.png" alt="<?php echo $daftar_license['judul_license_awards']; ?>" class="img-responsive" width="200" onError="this.onerror=null;this.src='../images/no_image/no-license.png';">
                          <?php 
                          }
                        ?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputNama" class="col-sm-2 control-label">QRCode Saat Ini</label>
                  <div class="col-sm-6">
                    <?php
                       if(!empty($daftar_license['image_qrcode'])){ 
                            if(file_exists("../upload/image/qrcode/".$daftar_license['image_qrcode'])){
                          ?>
                            <img src="../upload/image/qrcode/<?php echo $daftar_license['image_qrcode']; ?>" alt="<?php echo $daftar_license['image_qrcode']; ?>" class="img-responsive" width="200" onError="this.onerror=null;this.src='../images/no_image/no-license.png';">
                          <?php
                            }
                            else{
                          ?>
                            <h4>Tidak ada QR COde</h4>
                          <?php
                            }
                          }
                          else{
                          ?>
                             <img src="../images/QR-EK.png" alt="<?php echo $daftar_license['judul_license_awards']; ?>" class="img-responsive" width="200" onError="this.onerror=null;this.src='../images/no_image/no-license.png';">
                          <?php 
                          }
                        ?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputFile" class="col-sm-2 control-label">Upload Image</label>
                  <div class="col-sm-10">
                      <input type="file" class="form-control" id="inputFile" placeholder="Pilih Gambar License & Awards" name="upload_license_awards">
                      <p><small class="text-muted">File image harus berekstensi (jpg / png), ukuran 150 x 150 pixel, size maksimal 100 KB</small></p>
                      <p><small class="text-muted">Jika Ingin Mengganti salah satu QR Kode atau Image, maka harus diupload keduanya.</small></p>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputFile" class="col-sm-2 control-label">Upload QRCode</label>
                  <div class="col-sm-10">
                      <input type="file" class="form-control" id="inputFile" placeholder="Pilih QR Code" name="upload_qrcode">
                      <p><small class="text-muted">File image harus berekstensi (jpg / png), ukuran 170 x 170 pixel, maksimal 100 KB</small></p>
                      <p><small class="text-muted">Jika Ingin Mengganti salah satu QR Kode atau Image, maka harus diupload keduanya.</small></p>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputIsi" class="col-sm-2 control-label">Konten</label>
                  <div class="col-sm-10">
                      <textarea id="editor" class="form-control" rows="15" id="InputIsi" name="konten_license_awards" required><?php echo $daftar_license['konten_license_awards']; ?></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputStatus" class="col-sm-2 control-label">Urutan</label>
                  <div class="col-sm-10">
                      <select class="form-control" name="urutan_license_awards">
                        <option value="" <?php if($daftar_license['urutan'] == 10){ echo 'selected'; } ?>>- Tidak Urutan -</option>
                        <option value="1" <?php if($daftar_license['urutan'] == 1){ echo 'selected'; } ?>>1</option>
                        <option value="2" <?php if($daftar_license['urutan'] == 2){ echo 'selected'; } ?>>2</option>
                        <option value="3" <?php if($daftar_license['urutan'] == 3){ echo 'selected'; } ?>>3</option>
                        <option value="4" <?php if($daftar_license['urutan'] == 4){ echo 'selected'; } ?>>4</option>
                        <option value="5" <?php if($daftar_license['urutan'] == 5){ echo 'selected'; } ?>>5</option>
                      </select>
                      <small class="text-muted">Lewati jika tidak ingin mengganti urutan. Jika tidak dipilih maka tidak masuk 5 urutan paling awal.</small>
                  </div>
                </div>
                
                <hr class="hr1">
                <div class="form-group">
                  <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary bold" name="license_awards_edit"><i class="fa fa-save"></i> Simpan</button>&nbsp;&nbsp;<a href="license_awards.php" class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>

        <?php
          }
        }
        else{
          echo '<script>alert("Tidak ada data yang terpilih. Pilih pada salah satu baris."); window.history.back()</script>';
        } 
      ?>
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