<?php 
session_start();
$title = "Edit Cover Background (4269 x 2231)";
include_once "header.php";
if(isset($_GET['id']) && !empty($_GET['id'])){
  $id = $_GET['id'];
  $seleksi_cover = mysqli_query($koneksi, "SELECT * FROM cover_background WHERE id_cover='$id' LIMIT 1");
?>

<div class="container margin-b50">

        <?php
          if(mysqli_num_rows($seleksi_cover) == 0){
          echo '<div class="alert alert-danger fade in">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <strong><i class="fa fa-exclamation-triangle"></i> Data Kosong,</strong> Tidak ada data yang tersedia di kolom.
                  <a href="cover.php" class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
                </div>';
          }else{
            $daftar_cover = mysqli_fetch_array($seleksi_cover);
        ?>
      <div class="row">
        <div class="col-md-6 col-md-offset-3">

          <?php echo $status_form; ?>
          
          <nav class="navbar navbar-default navbar-utama nav-admin-data" role="navigation">
            <div class="container-fluid">
              <!-- Brand and toggle get grouped for better mobile display -->
              <div class="navbar-header">
                <a class="navbar-brand" href="#"><i class="fa fa-pencil"></i> Edit Cover Background (4269 x 2231)</a>
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
                  <label for="inputNama" class="col-sm-3 control-label">Nama Cover</label>
                  <div class="col-sm-9">
                      <input type="text" class="form-control" id="inputNama" placeholder="misal: Cover Perusahaan Eapp 1" value="<?php echo $daftar_cover['judul_cover']; ?>" name="nama_cover" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputNama" class="col-sm-3 control-label">Cover Saat Ini</label>
                  <div class="col-sm-6">
                       <?php
                       if(!empty($daftar_cover['gambar_cover'])){ 
                            if(file_exists("../upload/image/cover/".$daftar_cover['gambar_cover'])){
                          ?>
                            <img src="../upload/image/cover/<?php echo $daftar_cover['gambar_cover']; ?>" alt="<?php echo $daftar_cover['gambar_cover']; ?>" class="img-responsive" width="200" onError="this.onerror=null;this.src='../images/no_image/no-cover.png';">
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
                            <img src="../images/no_image/no-cover.png" alt="<?php echo $daftar_cover['judul_cover']; ?>" class="img-responsive" width="200">
                          <?php 
                          }
                        ?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputFile" class="col-sm-3 control-label">Upload Baru</label>
                  <div class="col-sm-8">
                      <input type="file" class="form-control" id="inputFile" placeholder="Pilih Gambar Cover" value="" accept="image/*" name="upload_cover" />
                      <small class="text-muted">File image harus berekstensi (jpg / png) ukuran 4269 x 2231 pixel, size maksimal 200 KB</small>
                      <small class="text-muted">Lewati jika tidak ingin mengganti image dengan yang baru.</small>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputStatus" class="col-sm-3 control-label">Status Cover</label>
                  <div class="col-sm-6">
                      <div class="form-check">
                        <label>
                          <input type="checkbox" name="dipakai" value="1" <?php if($daftar_cover['used'] == 'ya'){ echo 'checked'; } ?>> <span class="label-text">Aktif</span>
                        </label>
                      </div>
                  </div>
                </div>
                
                <hr class="hr1">
                <div class="form-group">
                  <div class="col-sm-offset-3 col-sm-9">
                    <button type="submit" class="btn btn-primary bold" name="cover_edit"><i class="fa fa-save"></i> Simpan</button>&nbsp;&nbsp;
                    <a href="cover_background.php" class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
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