<?php 
session_start();
$title = "Edit Partner (400 x 72)";
include_once "header.php";
if(isset($_GET['id']) && !empty($_GET['id'])){
    $id = $_GET['id'];
    $seleksi_partner = mysqli_query($koneksi, "SELECT * FROM partner WHERE id_partner='$id' LIMIT 1");
?>

<div class="container margin-b50">
  <?php
          if(mysqli_num_rows($seleksi_partner) == 0){
          echo '<div class="alert alert-danger fade in">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <strong><i class="fa fa-exclamation-triangle"></i> Data Kosong,</strong> Tidak ada data yang tersedia di kolom.
                  <a href="partner.php" class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
                </div>';
          }else{
            $daftar_partner = mysqli_fetch_array($seleksi_partner);
        ?>
      <div class="row">
        <div class="col-md-6 col-md-offset-3">

          <?php echo $status_form; ?>

          <nav class="navbar navbar-default navbar-utama nav-admin-data" role="navigation">
            <div class="container-fluid">
              <!-- Brand and toggle get grouped for better mobile display -->
              <div class="navbar-header">
                <a class="navbar-brand" href="#"><i class="fa fa-pencil"></i> Edit Partner (400 x 72)</a>
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
                  <label for="inputNama" class="col-sm-3 control-label">Nama Partner</label>
                  <div class="col-sm-9">
                      <input type="text" class="form-control" id="inputNama" placeholder="misal: Partner Logistik" name="nama_partner" value="<?php echo $daftar_partner['nama_partner']; ?>" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputNama" class="col-sm-3 control-label">Logo Saat Ini</label>
                  <div class="col-sm-6">
                    <?php
                       if(!empty($daftar_partner['image_partner'])){ 
                            if(file_exists("../upload/image/partner/".$daftar_partner['image_partner'])){
                          ?>
                            <img src="../upload/image/partner/<?php echo $daftar_partner['image_partner']; ?>" alt="<?php echo $daftar_partner['image_partner']; ?>" class="img-responsive" width="200" onError="this.onerror=null;this.src='../images/no_image/no-partner.png';">
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
                             <img src="../images/news/power-pdf.png" alt="<?php echo $daftar_partner['nama_partner']; ?>" class="img-responsive" width="200" onError="this.onerror=null;this.src='../images/no_image/no-partner.png';">
                          <?php 
                          }
                        ?> 
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputFile" class="col-sm-3 control-label">Upload</label>
                  <div class="col-sm-6">
                      <input type="file" class="form-control" id="inputFile" placeholder="Pilih Gambar Partner" name="upload_partner">
                      <small class="text-muted">File image harus berekstensi (jpg / png), ukuran 400 x 72 pixel, size maksimal 100 KB</small>
                      <small class="text-muted">Lewati jika tidak ingin mengganti image dengan yang baru.</small>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputStatus" class="col-sm-3 control-label">Urutan Partner</label>
                  <div class="col-sm-6">
                      <select class="form-control" name="urutan_partner">
                        <option value="" <?php if($daftar_partner['urutan'] == 10){ echo 'selected'; } ?>>- Tidak Urutan -</option>
                        <option value="1" <?php if($daftar_partner['urutan'] == 1){ echo 'selected'; } ?>>1</option>
                        <option value="2" <?php if($daftar_partner['urutan'] == 2){ echo 'selected'; } ?>>2</option>
                        <option value="3" <?php if($daftar_partner['urutan'] == 3){ echo 'selected'; } ?>>3</option>
                        <option value="4" <?php if($daftar_partner['urutan'] == 4){ echo 'selected'; } ?>>4</option>
                        <option value="5" <?php if($daftar_partner['urutan'] == 5){ echo 'selected'; } ?>>5</option>
                      </select>
                      <small class="text-muted">Lewati jika tidak ingin mengganti urutan. Jika tidak dipilih maka tidak masuk 5 urutan paling awal.</small>
                  </div>
                </div>
                
                <hr class="hr1">
                <div class="form-group">
                  <div class="col-sm-offset-3 col-sm-9">
                    <button type="submit" class="btn btn-primary bold" name="partner_edit"><i class="fa fa-save"></i> Simpan</button>&nbsp;&nbsp;<a href="partner.php" class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
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