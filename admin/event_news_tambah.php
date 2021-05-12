<?php 
session_start();
$title = "Tambah Event News";
$ada_jenis = false;
include_once "header.php";

if(isset($_GET['jenis']) && !empty($_GET['jenis'])){
  $jenis = $_GET['jenis'];
  $seleksi_jenis = mysqli_query($koneksi, "SELECT * FROM event_news_kategori WHERE event_news_kategori.id_event_news_kategori = '$jenis' LIMIT 1");
  $daftar_jenis = mysqli_fetch_array($seleksi_jenis);
  $ada_jenis = true;
}
else{
  $ada_jenis = false;
} 
?>

<div class="container margin-b50">
      <div class="row">
        <div class="col-md-8 col-md-offset-2">

         <?php echo $status_form; ?>

          <nav class="navbar navbar-default navbar-utama nav-admin-data" role="navigation">
            <div class="container-fluid">
              <!-- Brand and toggle get grouped for better mobile display -->
              <div class="navbar-header">
                <a class="navbar-brand" href="#"><i class="fa fa-plus-circle"></i> Tambah Event & News&nbsp;
                  <?php
                    if($ada_jenis == true){
                      echo " - ".$daftar_jenis['nama_event_news_kategori'];
                    }
                    else{
                      echo '';
                    }
                  ?>
                </a>
              </div>
              
              </div><!-- /.container-fluid -->
            </nav>
            
          </div>
        </div>
        <div class="row">
          <div class="col-md-8 col-md-offset-2">
            <div class="well">
              <form class="form-horizontal" role="form" action="action.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="inputNama" class="col-sm-2 control-label">Judul</label>
                  <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputNama" placeholder="misal: Produk Asus 2018" name="judul_event_news" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputNama" class="col-sm-2 control-label">Sub Judul</label>
                  <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputNama" placeholder="misal: Info Menarik Nih.." name="sub_judul_event_news" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputFile" class="col-sm-2 control-label">Upload</label>
                  <div class="col-sm-10">
                      <input type="file" class="form-control" id="inputFile" placeholder="Pilih Gambar Event & News" name="upload_event_news" required>
                      <small class="text-muted">File image harus berekstensi (jpg / png), ukuran 410 x 303 pixel, size maksimal 100 KB</small>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputIsi" class="col-sm-2 control-label">Konten</label>
                  <div class="col-sm-10">
                      <textarea id="editor" class="form-control" rows="15" id="InputIsi" name="konten_event_news" required></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputNama" class="col-sm-2 control-label">Author</label>
                  <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputNama" placeholder="misal: Sofyan Setiawan" name="author_event_news" value="" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputNama" class="col-sm-2 control-label">Kategori</label>
                  <div class="col-sm-10">
                  <?php
                    if($ada_jenis == true){
                      echo '<input type="hidden" name="jenis_event_news" value="'.$jenis.'">';
                      echo '<h4><span class="label label-info">'.$daftar_jenis["nama_event_news_kategori"].'</span></h4>';
                    }
                    else{

                      $seleksi_kategori = mysqli_query($koneksi, "SELECT * FROM event_news_kategori");
                      echo '<select class="form-control" name="jenis_event_news">';
                      echo ' <option value="">- Pilih Kategori -</option>';
                      while ($daftar_kategori = mysqli_fetch_array($seleksi_kategori)) {
                    ?>
                        <option value="<?php echo $daftar_kategori['id_event_news_kategori']; ?>"><?php echo $daftar_kategori['nama_event_news_kategori']; ?></option>
                      
                    <?php
                      }
                      echo '</select>';
                    }
                  ?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputStatus" class="col-sm-2 control-label">Urutan</label>
                  <div class="col-sm-10">
                      <select class="form-control" name="urutan_event_news">
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
                  <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary bold" name="event_news_tambah"><i class="fa fa-save"></i> Tambah</button>&nbsp;&nbsp;<a href="event_news.php" class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
                  </div>
                </div>
              </form>
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