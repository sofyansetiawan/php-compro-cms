<?php 
session_start();
$title = "Edit Logo (200 x 63)";
include_once "header.php";
if(isset($_GET['id']) && !empty($_GET['id'])){
  $id = $_GET['id'];
  $seleksi_logo = mysqli_query($koneksi, "SELECT * FROM logo WHERE id_logo='$id' LIMIT 1");
?>

<div class="container margin-b50">
        <?php
          if(mysqli_num_rows($seleksi_logo) == 0){
          echo '<div class="alert alert-danger fade in">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <strong><i class="fa fa-exclamation-triangle"></i> Data Kosong,</strong> Tidak ada data yang tersedia di kolom.
                  <a href="logo.php" class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
                </div>';
          }else{
            $daftar_logo = mysqli_fetch_array($seleksi_logo);
          ?>

          <div class="row">
            <div class="col-md-6 col-md-offset-3">

              <?php echo $status_form; ?>
              
              <nav class="navbar navbar-default navbar-utama nav-admin-data" role="navigation">
                <div class="container-fluid">
                  <!-- Brand and toggle get grouped for better mobile display -->
                  <div class="navbar-header">
                    <a class="navbar-brand" href="#"><i class="fa fa-pencil"></i> Edit Logo (200 x 63)</a>
                  </div>
                  
                  </div><!-- /.container-fluid -->
                </nav>
                
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 col-md-offset-3">
                <div class="well">
                  <form class="form-horizontal" role="form" action="action.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <div class="form-group">
                      <label for="inputNama" class="col-sm-3 control-label">Nama Logo</label>
                      <div class="col-sm-9">
                          <input type="text" class="form-control" id="inputNama" placeholder="misal: Logo Perusahaan Eapp 1" value="<?php echo $daftar_logo['judul_logo']; ?>" name="nama_logo" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputNama" class="col-sm-3 control-label">Logo Saat Ini</label>
                      <div class="col-sm-6">
                        <?php
                        if(!empty($daftar_logo['image_logo'])){  
                            if(file_exists("../upload/image/logo/".$daftar_logo['image_logo'])){
                          ?>
                            <img src="../upload/image/logo/<?php echo $daftar_logo['image_logo']; ?>" alt="<?php echo $daftar_logo['image_logo']; ?>" class="img-responsive" width="200" onError="this.onerror=null;this.src='../images/no_image/no-app2.png';">
                          <?php
                            }
                            else{
                          ?>
                            <h4>Tidak ada logo</h4>
                          <?php
                            }
                          }
                          else{
                          ?>
                          <img src="../images/admin/eapp-logo.png" alt="<?php echo $daftar_logo['judul_logo']; ?>" class="img-responsive" width="200" onError="this.onerror=null;this.src='../images/no_image/no-logo.png';"
>
                          <?php
                        }
                        ?>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputFile" class="col-sm-3 control-label">Upload Baru</label>
                      <div class="col-sm-8">
                          <input type="file" class="form-control" id="inputFile" placeholder="Pilih Gambar Logo" accept="image/*" value="" name="upload_logo">
                          <small class="text-muted">File image harus berekstensi (jpg / png), ukuran 200 x 63 pixel, size maksimal 100 KB</small><br>
                          <small class="text-muted">Lewati jika tidak ingin mengganti image dengan yang baru.</small>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputStatus" class="col-sm-3 control-label">Status Logo</label>
                      <div class="col-sm-6">
                          <div class="form-check">
                            <label>
                              <input type="checkbox" name="dipakai" value="1" <?php if($daftar_logo['used'] == 'ya'){ echo 'checked'; } ?>> <span class="label-text">Dipakai</span>                              
                            </label>
                          </div>
                      </div>
                    </div>
                    
                    <hr class="hr1">
                    <div class="form-group">
                      <div class="col-sm-offset-3 col-sm-9">
                        <button type="submit" class="btn btn-primary bold" name="logo_edit"><i class="fa fa-save"></i> Simpan</button>&nbsp;&nbsp;<a href="logo.php" class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
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

      <?php
      
        include_once "footer.php";
      ?>