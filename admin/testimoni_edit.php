<?php 
session_start();
$title = "Edit Testimoni";
include_once "header.php";
if(isset($_GET['id']) && !empty($_GET['id'])){
    $id = $_GET['id'];
    $seleksi_testimoni = mysqli_query($koneksi, "SELECT * FROM testimoni WHERE id_testimoni='$id' LIMIT 1");
?>

<div class="container margin-b50">
       <?php
          if(mysqli_num_rows($seleksi_testimoni) == 0){
          echo '<div class="alert alert-danger fade in">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <strong><i class="fa fa-exclamation-triangle"></i> Data Kosong,</strong> Tidak ada data yang tersedia di kolom.
                  <a href="testimoni.php" class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
                </div>';
          }else{
            $daftar_testimoni = mysqli_fetch_array($seleksi_testimoni);
        ?>
      <div class="row">
        <div class="col-md-8 col-md-offset-2">

         <?php echo $status_form; ?>

          <nav class="navbar navbar-default navbar-utama nav-admin-data" role="navigation">
            <div class="container-fluid">
              <!-- Brand and toggle get grouped for better mobile display -->
              <div class="navbar-header">
                <a class="navbar-brand" href="#"><i class="fa fa-plus-circle"></i> Tambah Testimoni</a>
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
                  <label for="inputNama" class="col-sm-2 control-label">Nama</label>
                  <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputNama" placeholder="misal: Sofyan Setiawan" name="person_testimoni" value="<?php echo $daftar_testimoni['person_testimoni']; ?>" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputNama" class="col-sm-2 control-label">Foto Saat Ini</label>
                  <div class="col-sm-6">
                    <?php
                       if(!empty($daftar_testimoni['image_testimoni'])){ 
                            if(file_exists("../upload/image/testimoni/".$daftar_testimoni['image_testimoni'])){
                          ?>
                            <img src="../upload/image/testimoni/<?php echo $daftar_testimoni['image_testimoni']; ?>" alt="<?php echo $daftar_testimoni['image_testimoni']; ?>" class="img-responsive" width="80" onError=\"this.onerror=null;this.src='../images/no_image/no-testimoni.png\"'>
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
                             <img src="../images/gallery/user1.png" alt="<?php echo $daftar_testimoni['image_testimoni']; ?>" class="img-responsive" width="80" onError="this.onerror=null;this.src='../images/no_image/no-testimoni.png';">
                          <?php 
                          }
                        ?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputFile" class="col-sm-2 control-label">Upload Foto</label>
                  <div class="col-sm-10">
                      <input type="file" class="form-control" id="inputFile" placeholder="Pilih Foto Testimoni" name="upload_testimoni">
                      <small class="text-muted">File image harus berekstensi (jpg / png), ukuran 80 x 80 pixel, size maksimal 50 KB</small>
                      <small class="text-muted">Lewati jika tidak ingin mengganti image dengan yang baru.</small>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputNama1" class="col-sm-2 control-label">Jabatan</label>
                  <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputNama1" placeholder="misal: Direktur Utama" name="jabatan_testimoni" value="<?php echo $daftar_testimoni['jabatan_testimoni']; ?>" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputNama2" class="col-sm-2 control-label">Facebook</label>
                  <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputNama2" placeholder="misal: http://facebook.com/sofyan" value="<?php echo $daftar_testimoni['facebook_url']; ?>" name="facebook_testimoni">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputNama3" class="col-sm-2 control-label">Twitter</label>
                  <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputNama3" placeholder="misal: http://twitter.com/sofyan" value="<?php echo $daftar_testimoni['twitter_url']; ?>" name="twitter_testimoni">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputNama3" class="col-sm-2 control-label">Instagram</label>
                  <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputNama3" placeholder="misal: http://instagram.com/sofyan" value="<?php echo $daftar_testimoni['instagram_url']; ?>" name="instagram_testimoni">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputIsi" class="col-sm-2 control-label">Konten</label>
                  <div class="col-sm-10">
                      <textarea id="editor" class="form-control" rows="15" id="InputIsi" name="konten_testimoni" required><?php echo $daftar_testimoni['konten_testimoni']; ?></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputStatus" class="col-sm-2 control-label">Urutan</label>
                  <div class="col-sm-10">
                      <select class="form-control" name="urutan_testimoni">
                        <option value="" <?php if($daftar_testimoni['urutan'] == 10){ echo 'selected'; } ?>>- Tidak Urutan -</option>
                        <option value="1" <?php if($daftar_testimoni['urutan'] == 1){ echo 'selected'; } ?>>1</option>
                        <option value="2" <?php if($daftar_testimoni['urutan'] == 2){ echo 'selected'; } ?>>2</option>
                        <option value="3" <?php if($daftar_testimoni['urutan'] == 3){ echo 'selected'; } ?>>3</option>
                        <option value="4" <?php if($daftar_testimoni['urutan'] == 4){ echo 'selected'; } ?>>4</option>
                        <option value="5" <?php if($daftar_testimoni['urutan'] == 5){ echo 'selected'; } ?>>5</option>
                      </select>
                      <small class="text-muted">Lewati jika tidak ingin mengganti urutan. Jika tidak dipilih maka tidak masuk 5 urutan paling awal.</small>
                  </div>
                </div>
                <hr class="hr1">
                <div class="form-group">
                  <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary bold" name="testimoni_edit"><i class="fa fa-save"></i> Simpan</button>&nbsp;&nbsp;<a href="testimoni.php" class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
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