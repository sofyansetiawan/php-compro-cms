<?php 
session_start();
$title = "Tambah Partner (400 x 72)";
include_once "header.php";
?>

<div class="container margin-b50">
      <div class="row">
        <div class="col-md-6 col-md-offset-3">

         <?php echo $status_form; ?>

          <nav class="navbar navbar-default navbar-utama nav-admin-data" role="navigation">
            <div class="container-fluid">
              <!-- Brand and toggle get grouped for better mobile display -->
              <div class="navbar-header">
                <a class="navbar-brand" href="#"><i class="fa fa-plus-circle"></i> Tambah Partner</a>
              </div>
              
              </div><!-- /.container-fluid -->
            </nav>
            
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 col-md-offset-3">
            <div class="well">
              <form class="form-horizontal" role="form" action="action.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="inputNama" class="col-sm-3 control-label">Nama Partner</label>
                  <div class="col-sm-9">
                      <input type="text" class="form-control" id="inputNama" placeholder="misal: Partner Logistik" name="nama_partner" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputFile" class="col-sm-3 control-label">Upload</label>
                  <div class="col-sm-6">
                      <input type="file" class="form-control" id="inputFile" placeholder="Pilih Gambar Partner" name="upload_partner" required>
                      <small class="text-muted">File image harus berekstensi (jpg / png), ukuran 400 x 72 pixel, size maksimal 100 KB</small>
                      <small class="text-muted">Lewati jika tidak ingin mengganti image dengan yang baru.</small>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputStatus" class="col-sm-3 control-label">Urutan Partner</label>
                  <div class="col-sm-6">
                      <select class="form-control" name="urutan_partner">
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
                  <div class="col-sm-offset-3 col-sm-9">
                    <button type="submit" class="btn btn-primary bold" name="partner_tambah"><i class="fa fa-save"></i> Tambah</button>&nbsp;&nbsp;<a href="partner.php" class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <?php 
        include_once "footer.php";
      ?>