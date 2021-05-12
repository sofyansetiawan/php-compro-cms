<?php 
session_start();
$title = "Edit Video";
include_once "header.php";
if(isset($_GET['id']) && !empty($_GET['id'])){
    $id = $_GET['id'];
    $seleksi_video = mysqli_query($koneksi, "SELECT * FROM video WHERE id_video='$id' LIMIT 1");
?>

<div class="container margin-b50">
        <?php
          if(mysqli_num_rows($seleksi_video) == 0){
          echo '<div class="alert alert-danger fade in">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <strong><i class="fa fa-exclamation-triangle"></i> Data Kosong,</strong> Tidak ada data yang tersedia di kolom.
                  <a href="video.php" class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
                </div>';
          }else{
            $daftar_video = mysqli_fetch_array($seleksi_video);
        ?>

      <div class="row">
        <div class="col-md-6 col-md-offset-3">

          <?php echo $status_form; ?>
          
          <nav class="navbar navbar-default navbar-utama nav-admin-data" role="navigation">
            <div class="container-fluid">
              <!-- Brand and toggle get grouped for better mobile display -->
              <div class="navbar-header">
                <a class="navbar-brand" href="#"><i class="fa fa-pencil"></i> Edit Video</a>
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
                  <label for="inputHome" class="col-sm-3 control-label">Judul Video</label>
                  <div class="col-sm-9">
                      <input type="text" class="form-control" id="inputHome" placeholder="misal: Video Profile Eapp" name="judul_video" value="<?php echo $daftar_video['nama_video']; ?>" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputLinkHome" class="col-sm-3 control-label">Link Video</label>
                  <div class="col-sm-9">
                      <?php echo '<a href="'.$site.'upload/video/'.$daftar_video['file_video'].'" target="_blank">'.$daftar_video['file_video'].' <span class="fa fa-external-link"></span></a>'; ?>
                        <p><small><span class="text-muted"><em>Klik link diatas untuk melihat video</em></span></small></p>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputFile" class="col-sm-3 control-label">Upload Video</label>
                  <div class="col-sm-8">
                      <input type="file" class="form-control" id="inputFile" placeholder="Pilih Video" accept="video/*" name="file_video"/>
                      <small class="text-muted">File video harus berekstensi (mp4), size maksimal 5 MB.<br>Lewati jika tidak ingin mengganti video</small>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputStatusHome" class="col-sm-3 control-label"></label>
                  <div class="col-sm-6">
                      <div class="form-check">
                        <label>
                          <input type="checkbox" name="dipakai" value="1" <?php if($daftar_video['dipakai'] == 'ya'){ echo 'checked'; } ?>> <span class="label-text">Dipakai</span>
                        </label>
                      </div>
                  </div>
                </div>

                <hr class="hr1">

                <div class="form-group">
                  <div class="col-sm-offset-3 col-sm-9">
                    <button type="submit" class="btn btn-primary bold" name="video_edit"><i class="fa fa-save"></i> Simpan</button>&nbsp;&nbsp;<a href="video.php" class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
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