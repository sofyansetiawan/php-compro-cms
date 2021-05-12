<?php
session_start();
$title = "Edit Contact";
include_once "header.php";
$seleksi_contact = mysqli_query($koneksi, "SELECT * FROM contact") or die("<script>alert('Query salah')</script>");
$jumlah_contact = mysqli_num_rows($seleksi_contact);
?>
<div class="container margin-b50">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      
      <?php echo $status_form; ?>
      
      <nav class="navbar navbar-default navbar-utama nav-admin-data" role="navigation">
        <div class="container-fluid">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header">
            <a class="navbar-brand" href="#"><i class="fa fa-pencil"></i> Edit Contact</a>
          </div>
          
          </div><!-- /.container-fluid -->
        </nav>
        
      </div>
    </div>
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="well">
          <?php
          if($jumlah_contact == 1){
          while($daftar_contact = mysqli_fetch_array($seleksi_contact)){
          ?>
          <form class="form-horizontal" role="form" action="action.php" method="post">
            <fieldset class="scheduler-border">
              <legend class="scheduler-border">Office</legend>
              <div class="form-group">
                <label for="inputNama1" class="col-sm-2 control-label">Alamat Gedung</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="inputNama1" placeholder="misal: Graha Mampang " value="<?php echo $daftar_contact['alamat_gedung']; ?>" name="alamat_gedung" required>
                </div>
              </div>
              <div class="form-group">
                <label for="inputNama2" class="col-sm-2 control-label">Alamat Jalan</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="inputNama2" placeholder="misal: Mampang Prapatan Raya no.100" value="<?php echo $daftar_contact['alamat_jalan']; ?>" name="alamat_jalan" required>
                </div>
              </div>
              <div class="form-group">
                <label for="inputNama3" class="col-sm-2 control-label">Alamat Daerah</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="inputNama3" placeholder="misal: Pancoran Jakarta Selatan" value="<?php echo $daftar_contact['alamat_daerah']; ?>" name="alamat_daerah" required>
                </div>
              </div>
              <div class="form-group">
                <label for="inputNama4" class="col-sm-2 control-label">Nomor Telepon</label>
                <div class="col-sm-10">
                  <input type="tel" class="form-control" id="inputNama4" placeholder="misal: (021) 7972660" value="<?php echo $daftar_contact['no_telp']; ?>" name="no_telp" required>
                </div>
              </div>
              <div class="form-group">
                <label for="inputNama5" class="col-sm-2 control-label">Email</label>
                <div class="col-sm-10">
                  <input type="email" class="form-control" id="inputNama5" placeholder="misal: contact@website.com" value="<?php echo $daftar_contact['email']; ?>" name="email" required>
                </div>
              </div>
            </fieldset>
            <fieldset class="scheduler-border">
              <legend class="scheduler-border">Warehouse</legend>
              <div class="form-group">
                <label for="inputNama1" class="col-sm-2 control-label">Alamat Jalan</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="inputNama1" placeholder="misal: Bintara Jaya 1 no.15a" value="<?php echo $daftar_contact['warehouse_jalan']; ?>" name="warehouse_jalan" required>
                </div>
              </div>
              <div class="form-group">
                <label for="inputNama2" class="col-sm-2 control-label">Alamat Wilayah</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="inputNama2" placeholder="misal: Sumber Arta Kalimalang Bekasi" value="<?php echo $daftar_contact['warehouse_wilayah']; ?>" name="warehouse_wilayah" required>
                </div>
              </div>
              <div class="form-group">
                <label for="inputNama3" class="col-sm-2 control-label">Alamat Daerah</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="inputNama3" placeholder="misal: Pancoran Jakarta Selatan" value="<?php echo $daftar_contact['warehouse_daerah']; ?>" name="warehouse_daerah" required>
                </div>
              </div>
            </fieldset>
            <div class="form-group">
              <label for="inputNama5" class="col-sm-2 control-label">Embed Code Google Maps</label>
              <div class="col-sm-10">
                <textarea id="editor1" class="form-control" rows="5" id="InputIsi" name="embed_google_maps" required><?php echo $daftar_contact['embed_google_maps']; ?></textarea>
              </div>
            </div>
            
            <hr class="hr1">
            <div class="form-group">
              <label for="inputNama6" class="col-sm-2 control-label">Email Pengirim Pesan</label>
              <div class="col-sm-10">
                <input type="email" class="form-control" id="inputNama6" placeholder="misal: support@website.com" value="<?php echo $daftar_contact['email_pengirim']; ?>" name="email_pengirim" required>
              </div>
            </div>
            <div class="form-group">
              <label for="inputNama6" class="col-sm-2 control-label">Subyek Pesan</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="inputNama6" placeholder="misal: Contact From website Company Profile" value="<?php echo $daftar_contact['subyek_pesan']; ?>" name="subyek_pesan" required>
              </div>
            </div>
            <div class="form-group">
              <label for="inputNama6" class="col-sm-2 control-label">Email Tujuan Pesan</label>
              <div class="col-sm-10">
                <input type="email" class="form-control" id="inputNama6" placeholder="misal: contact@website.com" value="<?php echo $daftar_contact['email_tujuan']; ?>" name="email_tujuan" required>
              </div>
            </div>
            <hr class="hr1">
            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary bold" name="contact_edit"><i class="fa fa-save"></i> Simpan</button>
              </div>
            </div>
          </form>
          <?php
          }
          }
          elseif($jumlah_contact == 0){
          ?>
          <form class="form-horizontal" role="form" action="action.php" method="post">
            <fieldset class="scheduler-border">
              <legend class="scheduler-border">Office</legend>
              <div class="form-group">
                <label for="inputNama1" class="col-sm-2 control-label">Alamat Gedung</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="inputNama1" placeholder="misal: Graha Mampang " value="" name="alamat_gedung" required>
                </div>
              </div>
              <div class="form-group">
                <label for="inputNama2" class="col-sm-2 control-label">Alamat Jalan</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="inputNama2" placeholder="misal: Mampang Prapatan Raya no.100" value="" name="alamat_jalan" required>
                </div>
              </div>
              <div class="form-group">
                <label for="inputNama3" class="col-sm-2 control-label">Alamat Daerah</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="inputNama3" placeholder="misal: Pancoran Jakarta Selatan" value="" name="alamat_daerah" required>
                </div>
              </div>
              <div class="form-group">
                <label for="inputNama4" class="col-sm-2 control-label">Nomor Telepon</label>
                <div class="col-sm-10">
                  <input type="tel" class="form-control" id="inputNama4" placeholder="misal: (021) 7972660" value="" name="no_telp" required>
                </div>
              </div>
              <div class="form-group">
                <label for="inputNama5" class="col-sm-2 control-label">Email</label>
                <div class="col-sm-10">
                  <input type="email" class="form-control" id="inputNama5" placeholder="misal: contact@website.com" value="" name="email" required>
                </div>
              </div>
            </fieldset>
            <fieldset class="scheduler-border">
              <legend class="scheduler-border">Warehouse</legend>
              <div class="form-group">
                <label for="inputNama1" class="col-sm-2 control-label">Alamat Jalan</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="inputNama1" placeholder="misal: Bintara Jaya 1 no.15a" value="" name="warehouse_jalan" required>
                </div>
              </div>
              <div class="form-group">
                <label for="inputNama2" class="col-sm-2 control-label">Alamat Wilayah</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="inputNama2" placeholder="misal: Sumber Arta Kalimalang Bekasi" value="" name="warehouse_wilayah" required>
                </div>
              </div>
              <div class="form-group">
                <label for="inputNama3" class="col-sm-2 control-label">Alamat Daerah</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="inputNama3" placeholder="misal: Pancoran Jakarta Selatan" value="" name="warehouse_daerah" required>
                </div>
              </div>
            </fieldset>
            <div class="form-group">
              <label for="inputNama5" class="col-sm-2 control-label">Embed Code Google Maps</label>
              <div class="col-sm-10">
                <textarea id="editor1" class="form-control" rows="5" id="InputIsi" name="embed_google_maps" required placeholder='misal : <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d63457.2942234049!2d106.79747261323384!3d-6.253072818838603!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f3d2f6e5e2f9%3A0x18edb1161e319554!2swww.eapp.co.id!5e0!3m2!1sen!2sid!4v1518171877057" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>'></textarea>
                <small class="text-muted">Pilihlah embed map dengan ukuran <strong>Large</strong></small>
              </div>
            </div>
            
            <hr class="hr1">
            <div class="form-group">
              <label for="inputNama6" class="col-sm-2 control-label">Email Pengirim Pesan</label>
              <div class="col-sm-10">
                <input type="email" class="form-control" id="inputNama6" placeholder="misal: support@website.com" value="" name="email_pengirim" required>
              </div>
            </div>
            <div class="form-group">
              <label for="inputNama6" class="col-sm-2 control-label">Subyek Pesan</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="inputNama6" placeholder="misal: Contact From website Company Profile" value="" name="subyek_pesan" required>
              </div>
            </div>
            <div class="form-group">
              <label for="inputNama6" class="col-sm-2 control-label">Email Tujuan Pesan</label>
              <div class="col-sm-10">
                <input type="email" class="form-control" id="inputNama6" placeholder="misal: contact@website.com" value="" name="email_tujuan" required>
              </div>
            </div>
            <hr class="hr1">
            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary bold" name="contact_tambah"><i class="fa fa-save"></i> Tambah</button>
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