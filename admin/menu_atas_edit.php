<?php 
session_start();
$title = "Edit Menu Atas";
include_once "header.php";
if(isset($_GET['id']) && !empty($_GET['id'])){
  $id = $_GET['id'];
  $seleksi_menu = mysqli_query($koneksi, "SELECT * FROM menu WHERE id_menu='$id' LIMIT 1");
?>

<div class="container margin-b50">
  <?php
    if(mysqli_num_rows($seleksi_menu) == 0){
    echo '<div class="alert alert-danger fade in">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <strong><i class="fa fa-exclamation-triangle"></i> Data Kosong,</strong> Tidak ada data yang tersedia di kolom.
            <a href="logo.php" class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
          </div>';
    }else{
      $daftar_menu = mysqli_fetch_array($seleksi_menu);
    ?>

      <div class="row">
        <div class="col-md-6 col-md-offset-3">

         <?php echo $status_form; ?>
          
          <nav class="navbar navbar-default navbar-utama nav-admin-data" role="navigation">
            <div class="container-fluid">
              <!-- Brand and toggle get grouped for better mobile display -->
              <div class="navbar-header">
                <a class="navbar-brand" href="#"><i class="fa fa-pencil"></i> Edit Menu Atas</a>
              </div>
              
              </div><!-- /.container-fluid -->
            </nav>
            
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 col-md-offset-3">
            <div class="well">
              <form class="form-horizontal" role="form" action="action.php" method="post">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <div class="form-group">
                  <label for="inputHome" class="col-sm-3 control-label">Menu</label>
                  <div class="col-sm-9">
                      <input type="text" class="form-control" id="inputHome" placeholder="misal: Home" value="<?php echo $daftar_menu['nama_menu']; ?>" name="menu" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputLinkHome" class="col-sm-3 control-label">Link</label>
                  <div class="col-sm-9">
                      <input type="text" class="form-control" id="inputLinkHome" placeholder="misal: #home" value="<?php echo $daftar_menu['url']; ?>" name="link" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputStatusHome" class="col-sm-3 control-label"></label>
                  <div class="col-sm-6">
                      <div class="form-check">
                        <label>
                          <input type="checkbox" name="menu_aktif" value="1" <?php if($daftar_menu['aktif'] == 'ya'){ echo 'checked'; } ?>> <span class="label-text">Aktif</span>
                        </label>
                      </div>
                  </div>
                </div>

                <hr class="hr1">

                <div class="form-group">
                  <div class="col-sm-offset-3 col-sm-9">
                    <button type="submit" class="btn btn-primary bold" name="menu_atas_edit"><i class="fa fa-save"></i> Simpan</button>
                    <a href="menu_atas.php" class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
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