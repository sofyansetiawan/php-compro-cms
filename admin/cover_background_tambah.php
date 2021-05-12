<?php 
session_start();
$title = "Tambah Cover Background (4269 x 2231)";
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
                <a class="navbar-brand" href="#"><i class="fa fa-plus-circle"></i> Tambah Cover Background (4269 x 2231)</a>
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
                  <label for="inputNama" class="col-sm-3 control-label">Nama Cover</label>
                  <div class="col-sm-9">
                      <input type="text" class="form-control" id="inputNama" placeholder="misal: Cover Bg 1" name="nama_cover" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputFile" class="col-sm-3 control-label">Upload Cover</label>
                  <div class="col-sm-8">
                      <input type="file" class="form-control" id="inputFile" placeholder="Pilih Gambar Cover" name="upload_cover" required>
                      <small class="text-muted">File image harus berekstensi (jpg / png) ukuran 4269 x 2231 pixel, size maksimal 500 KB</small>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputStatus" class="col-sm-3 control-label">Status Cover</label>
                  <div class="col-sm-6">
                      <div class="form-check">
                        <label>
                          <input type="checkbox" name="dipakai" value="1" checked> <span class="label-text">Aktif</span>
                        </label>
                      </div>
                  </div>
                </div>
                
                <hr class="hr1">
                <div class="form-group">
                  <div class="col-sm-offset-3 col-sm-9">
                    <button type="submit" class="btn btn-primary bold" name="cover_tambah"><i class="fa fa-save"></i> Tambah</button>&nbsp;&nbsp;
                    <a href="cover_background.php" class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
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