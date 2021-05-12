<?php 
session_start();
$title = "Edit Social Footer";
include_once "header.php";

$seleksi_social_footer = mysqli_query($koneksi, "SELECT * FROM social_footer") or die("<script>alert('Query salah')</script>");
$jumlah_social_footer = mysqli_num_rows($seleksi_social_footer);
?>

<div class="container margin-b50">
      <div class="row">
        <div class="col-md-8 col-md-offset-2">
          <?php echo $status_form; ?>
          
          <nav class="navbar navbar-default navbar-utama nav-admin-data" role="navigation">
            <div class="container-fluid">
              <!-- Brand and toggle get grouped for better mobile display -->
              <div class="navbar-header">
                <a class="navbar-brand" href="#"><i class="fa fa-pencil"></i> Edit Social Footer</a>
              </div>
              
              </div><!-- /.container-fluid -->
            </nav>
            
          </div>
        </div>
        <div class="row">
          <div class="col-md-8 col-md-offset-2">
            <div class="well">

              <?php 
                if($jumlah_social_footer == 1){
                  while($daftar_social_footer = mysqli_fetch_array($seleksi_social_footer)){
              ?>

              <form class="form-horizontal" role="form" action="action.php" method="post">
                <div class="form-group">
                  <label for="inputNama" class="col-sm-2 control-label">Facebook URL</label>
                  <div class="col-sm-10">
                      <input type="url" class="form-control" id="inputNama" placeholder="misal: http://facebook.com/eapp" value="<?php echo $daftar_social_footer['facebook_url']; ?>" name="facebook_url" required>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputNama1" class="col-sm-2 control-label">Twitter URL</label>
                  <div class="col-sm-10">
                      <input type="url" class="form-control" id="inputNama1" placeholder="misal: http://twitter.com/eapp " value="<?php echo $daftar_social_footer['twitter_url']; ?>" name="twitter_url" required>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputNama2" class="col-sm-2 control-label">Instagram URL</label>
                  <div class="col-sm-10">
                      <input type="url" class="form-control" id="inputNama2" placeholder="misal: http://instagram.com/eapp" value="<?php echo $daftar_social_footer['instagram_url']; ?>" name="instagram_url" required>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputNama3" class="col-sm-2 control-label">Linkedin URL</label>
                  <div class="col-sm-10">
                      <input type="url" class="form-control" id="inputNama3" placeholder="misal: http://linkedin.com/ekaltalog" value="<?php echo $daftar_social_footer['linkedin_url']; ?>" name="linkedin_url" required>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputNama4" class="col-sm-2 control-label">Youtube URL</label>
                  <div class="col-sm-10">
                      <input type="url" class="form-control" id="inputNama4" placeholder="misal: http://youtube.com/c/eapp" value="<?php echo $daftar_social_footer['youtube_url']; ?>" name="youtube_url" required>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary bold" name="social_footer_edit"><i class="fa fa-save"></i> Simpan</button>
                  </div>
                </div>
              </form>

              <?php
                }

              }
                elseif($jumlah_social_footer == 0){
              ?>

              <form class="form-horizontal" role="form" action="action.php" method="post">
                <div class="form-group">
                  <label for="inputNama" class="col-sm-2 control-label">Facebook URL</label>
                  <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputNama" placeholder="misal: http://facebook.com/eapp" value="" name="facebook_url" required>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputNama1" class="col-sm-2 control-label">Twitter URL</label>
                  <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputNama1" placeholder="misal: http://twitter.com/eapp " value="" name="twitter_url" required>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputNama2" class="col-sm-2 control-label">Instagram URL</label>
                  <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputNama2" placeholder="misal: http://instagram.com/eapp" value="" name="instagram_url" required>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputNama3" class="col-sm-2 control-label">Linkedin URL</label>
                  <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputNama3" placeholder="misal: http://linkedin.com/ekaltalog" value="" name="linkedin_url" required>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputNama4" class="col-sm-2 control-label">Youtube URL</label>
                  <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputNama4" placeholder="misal: http://youtube.com/c/eapp" value="" name="youtube_url" required>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary bold" name="social_footer_tambah"><i class="fa fa-save"></i> Tambah</button>
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