<?php 
session_start();
$title = "Edit Judul Section";
include_once "header.php";

$seleksi_judul_header = mysqli_query($koneksi, "SELECT * FROM judul_header") or die("<script>alert('Query salah')</script>");
$jumlah_judul_header = mysqli_num_rows($seleksi_judul_header);
?>

<div class="container margin-b50">
      <div class="row">
        <div class="col-md-8 col-md-offset-2">

          <?php echo $status_form; ?>
          
          <nav class="navbar navbar-default navbar-utama nav-admin-data" role="navigation">
            <div class="container-fluid">
              <!-- Brand and toggle get grouped for better mobile display -->
              <div class="navbar-header">
                <a class="navbar-brand" href="#"><i class="fa fa-pencil"></i> Edit Judul Header</a>
              </div>
              
              </div><!-- /.container-fluid -->
            </nav>
            
          </div>
        </div>
        <div class="row">
          <div class="col-md-8 col-md-offset-2">
            <div class="well">
              <?php 
                if($jumlah_judul_header == 1){
                  while($daftar_judul_header = mysqli_fetch_array($seleksi_judul_header)){
              ?>

              <form class="form-horizontal" role="form" action="action.php" method="post">
                <div class="form-group">
                  <label for="inputNama" class="col-sm-3 control-label">Judul Header Video</label>
                  <div class="col-sm-9">
                      <input type="text" class="form-control" id="inputNama" placeholder="Isi judul header akan tampilan di website company profile" value="<?php echo $daftar_judul_header['judul_header_video']; ?>" name="judul_heading_video" required>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputNama1" class="col-sm-3 control-label">Judul Header Partner</label>
                  <div class="col-sm-9">
                      <input type="text" class="form-control" id="inputNama1" placeholder="Isi judul header akan tampilan di website company profile" value="<?php echo $daftar_judul_header['judul_header_partner']; ?>" name="judul_heading_partner" required>
                  </div>
                </div>

                 <fieldset class="scheduler-border">
                  <legend class="scheduler-border">Event & News</legend>
                    <div class="form-group">
                      <label for="inputNama2" class="col-sm-3 control-label">Judul Event & News</label>
                      <div class="col-sm-9">
                          <input type="text" class="form-control" id="inputNama2" placeholder="Isi judul header akan tampilan di website company profile" value="<?php echo $daftar_judul_header['judul_header_event']; ?>" name="judul_heading_event" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputNama2" class="col-sm-3 control-label">Judul All News</label>
                      <div class="col-sm-9">
                          <input type="text" class="form-control" id="inputNama2" placeholder="Isi judul header akan tampilan di website company profile" value="<?php echo $daftar_judul_header['judul_header_event_all']; ?>" name="judul_heading_event_all" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputNama2" class="col-sm-3 control-label">Link All News</label>
                      <div class="col-sm-9">
                          <input type="url" class="form-control" id="inputNama2" placeholder="Isi judul header akan tampilan di website company profile" value="<?php echo $daftar_judul_header['judul_header_event_all_link']; ?>" name="judul_heading_event_all_link" required>
                      </div>
                    </div>

                  </fieldset>

                <div class="form-group">
                  <label for="inputNama3" class="col-sm-3 control-label">Judul License & Awards</label>
                  <div class="col-sm-9">
                      <input type="text" class="form-control" id="inputNama3" placeholder="Isi judul header akan tampilan di website company profile" value="<?php echo $daftar_judul_header['judul_header_license']; ?>" name="judul_heading_license" required>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputNama4" class="col-sm-3 control-label">Judul Testimonial</label>
                  <div class="col-sm-9">
                      <input type="text" class="form-control" id="inputNama4" placeholder="Isi judul header akan tampilan di website company profile" value="<?php echo $daftar_judul_header['judul_header_testimoni']; ?>" name="judul_heading_testimonial" required>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputNama5" class="col-sm-3 control-label">Judul Office</label>
                  <div class="col-sm-9">
                      <input type="text" class="form-control" id="inputNama5" placeholder="Isi judul header akan tampilan di website company profile" value="<?php echo $daftar_judul_header['judul_header_office']; ?>" name="judul_heading_office" required>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputNama5" class="col-sm-3 control-label">Judul Warehouse</label>
                  <div class="col-sm-9">
                      <input type="text" class="form-control" id="inputNama5" placeholder="Isi judul header akan tampilan di website company profile" value="<?php echo $daftar_judul_header['judul_header_warehouse']; ?>" name="judul_heading_warehouse" required>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputNama6" class="col-sm-3 control-label">Judul Form Contact</label>
                  <div class="col-sm-9">
                      <textarea id="editor" class="form-control" rows="15" id="InputIsi" name="judul_heading_form" required><?php echo $daftar_judul_header['judul_header_form_contact']; ?></textarea>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputNama7" class="col-sm-3 control-label">Judul Footer</label>
                  <div class="col-sm-9">
                      <input type="text" class="form-control" id="inputNama7" placeholder="Isi judul header akan tampilan di website company profile" value="<?php echo $daftar_judul_header['judul_header_footer']; ?>" name="judul_heading_footer" required>
                  </div>
                </div>
                
                <hr class="hr1">
                <div class="form-group">
                  <div class="col-sm-offset-3 col-sm-9">
                    <button type="submit" class="btn btn-primary bold" name="judul_heading_edit"><i class="fa fa-save"></i> Simpan</button>
                  </div>
                </div>
              </form>

              <?php
                }

              }
                elseif($jumlah_judul_header == 0){
              ?>

              <form class="form-horizontal" role="form" action="action.php" method="post">
                <div class="form-group">
                  <label for="inputNama" class="col-sm-3 control-label">Judul Header Video</label>
                  <div class="col-sm-9">
                      <input type="text" class="form-control" id="inputNama" placeholder="Isi judul header akan tampilan di website company profile" value="" name="judul_heading_video" required>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputNama1" class="col-sm-3 control-label">Judul Header Partner</label>
                  <div class="col-sm-9">
                      <input type="text" class="form-control" id="inputNama1" placeholder="Isi judul header akan tampilan di website company profile" value="" name="judul_heading_partner" required>
                  </div>
                </div>

                <fieldset class="scheduler-border">
                  <legend class="scheduler-border">Event & News</legend>
                    <div class="form-group">
                      <label for="inputNama2" class="col-sm-3 control-label">Judul Event & News</label>
                      <div class="col-sm-9">
                          <input type="text" class="form-control" id="inputNama2" placeholder="Isi judul header akan tampilan di website company profile" value="" name="judul_heading_event" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputNama2" class="col-sm-3 control-label">Judul All News</label>
                      <div class="col-sm-9">
                          <input type="text" class="form-control" id="inputNama2" placeholder="Isi judul header akan tampilan di website company profile" value="" name="judul_heading_event_all" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputNama2" class="col-sm-3 control-label">Link All News</label>
                      <div class="col-sm-9">
                          <input type="url" class="form-control" id="inputNama2" placeholder="Isi judul header akan tampilan di website company profile" value="" name="judul_heading_event_all_link" required>
                      </div>
                    </div>

                  </fieldset>

                <div class="form-group">
                  <label for="inputNama3" class="col-sm-3 control-label">Judul License & Awards</label>
                  <div class="col-sm-9">
                      <input type="text" class="form-control" id="inputNama3" placeholder="Isi judul header akan tampilan di website company profile" value="" name="judul_heading_license" required>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputNama4" class="col-sm-3 control-label">Judul Testimonial</label>
                  <div class="col-sm-9">
                      <input type="text" class="form-control" id="inputNama4" placeholder="Isi judul header akan tampilan di website company profile" value="" name="judul_heading_testimonial" required>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputNama5" class="col-sm-3 control-label">Judul Office</label>
                  <div class="col-sm-9">
                      <input type="text" class="form-control" id="inputNama5" placeholder="Isi judul header akan tampilan di website company profile" value="" name="judul_heading_office" required>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputNama5" class="col-sm-3 control-label">Judul Warehouse</label>
                  <div class="col-sm-9">
                      <input type="text" class="form-control" id="inputNama5" placeholder="Isi judul header akan tampilan di website company profile" value="" name="judul_heading_warehouse" required>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputNama6" class="col-sm-3 control-label">Judul Form Contact</label>
                  <div class="col-sm-9">
                      <textarea id="editor" class="form-control" rows="15" id="InputIsi" name="judul_heading_form" required></textarea>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputNama7" class="col-sm-3 control-label">Judul Footer</label>
                  <div class="col-sm-9">
                      <input type="text" class="form-control" id="inputNama7" placeholder="Isi judul header akan tampilan di website company profile" value="" name="judul_heading_footer" required>
                  </div>
                </div>
                
                <hr class="hr1">
                <div class="form-group">
                  <div class="col-sm-offset-3 col-sm-9">
                    <button type="submit" class="btn btn-primary bold" name="judul_heading_tambah"><i class="fa fa-save"></i> Tambah</button>
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