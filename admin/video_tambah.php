<?php 
session_start();
$title = "Tambah Video";
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
                <a class="navbar-brand" href="#"><i class="fa fa-plus-circle"></i> Tambah Video</a>
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
                  <label for="inputHome" class="col-sm-3 control-label">Judul Video</label>
                  <div class="col-sm-9">
                      <input type="text" class="form-control" id="inputHome" placeholder="misal: Video Profile Eapp" name="judul_video" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputFile" class="col-sm-3 control-label">Upload Video</label>
                  <div class="col-sm-8">
                      <input type="file" class="form-control" id="inputFile" placeholder="Pilih Video" accept="video/*" name="file_video" required />
                      <small class="text-muted">File video harus berekstensi (mp4), size maksimal 5 MB</small>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputStatusHome" class="col-sm-3 control-label"></label>
                  <div class="col-sm-6">
                      <div class="form-check">
                        <label>
                          <input type="checkbox" name="dipakai" value="1" checked> <span class="label-text">Dipakai</span>
                        </label>
                      </div>
                  </div>
                </div>

                <hr class="hr1">

                <div class="form-group">
                  <div class="col-sm-offset-3 col-sm-9">
                    <button type="submit" class="btn btn-primary bold" name="video_tambah"><i class="fa fa-save"></i> Tambah</button>
                    <a href="video.php" class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
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