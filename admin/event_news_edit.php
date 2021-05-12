<?php 
  session_start();
  $title = "Edit Event News";
  $ada_jenis = false;

  include_once "header.php";
  if(isset($_GET['id']) && !empty($_GET['id']) && isset($_GET['jenis']) && !empty($_GET['jenis'])){
    $id = $_GET['id'];
    $jenis = $_GET['jenis'];
    $seleksi_event = mysqli_query($koneksi, "
      SELECT event_news.*, event_news_kategori.* 
      FROM event_news 
      LEFT OUTER JOIN event_news_kategori 
      ON event_news.id_event_news_kategori = event_news_kategori.id_event_news_kategori 
      WHERE event_news.id_event_news = '$id' AND event_news_kategori.id_event_news_kategori = '$jenis' AND event_news.urutan > 0
      ORDER BY event_news.urutan ASC LIMIT 1
      ");
      $ada_jenis = true;
    }
    elseif(isset($_GET['id']) && !empty($_GET['id']) && !isset($_GET['jenis']) || empty($_GET['jenis'])){
    $id = $_GET['id'];
    $seleksi_event = mysqli_query($koneksi, "
      SELECT event_news.*, event_news_kategori.* 
      FROM event_news 
      LEFT OUTER JOIN event_news_kategori 
      ON event_news.id_event_news_kategori = event_news_kategori.id_event_news_kategori 
      WHERE event_news.id_event_news = '$id' AND event_news.urutan > 0
      ORDER BY event_news.urutan ASC LIMIT 1
      ");

      $ada_jenis = false;
    }
    else{
      echo '<script>alert("Tidak ada data yang terpilih. Pilih pada salah satu baris."); window.history.back()</script>';
    } 
      ?>

<div class="container margin-b50">
        <?php
          if(mysqli_num_rows($seleksi_event) == 0){
          echo '<div class="alert alert-danger fade in">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <strong><i class="fa fa-exclamation-triangle"></i> Data Kosong,</strong> Tidak ada data yang tersedia di kolom.
                  <a href="event_news.php" class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
                </div>';
          }else{
            $daftar_event = mysqli_fetch_array($seleksi_event);
        ?>

      <div class="row">
        <div class="col-md-8 col-md-offset-2">

          <?php echo $status_form; ?>

          <nav class="navbar navbar-default navbar-utama nav-admin-data" role="navigation">
            <div class="container-fluid">
              <!-- Brand and toggle get grouped for better mobile display -->
              <div class="navbar-header">
                <a class="navbar-brand" href="#"><i class="fa fa-pencil"></i> Edit Event & News&nbsp;
                  <?php
                    if($ada_jenis == true){
                      echo " - ".$daftar_event['nama_event_news_kategori'];
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
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <div class="form-group">
                  <label for="inputNama" class="col-sm-2 control-label">Judul</label>
                  <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputNama" placeholder="misal: Produk Asus 2018" name="judul_event_news" value="<?php echo $daftar_event['judul_event_news']; ?>" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputNama" class="col-sm-2 control-label">Sub Judul</label>
                  <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputNama" placeholder="misal: Info Menarik Nih.." name="sub_judul_event_news" value="<?php echo $daftar_event['sub_judul_event_news']; ?>" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputNama" class="col-sm-2 control-label">Image Saat Ini</label>
                  <div class="col-sm-6">
                    <?php
                       if(!empty($daftar_event['image_event_news'])){ 
                            if(file_exists("../upload/image/event_news/".$daftar_event['image_event_news'])){
                          ?>
                            <img src="../upload/image/event_news/<?php echo $daftar_event['image_event_news']; ?>" alt="<?php echo $daftar_event['image_event_news']; ?>" class="img-responsive" width="200" onError="this.onerror=null;this.src='../images/no_image/no-news.png';">
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
                             <img src="../images/no_image/no-news.png" alt="Nama Gambar" class="img-responsive" width="200">
                          <?php 
                          }
                        ?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputFile" class="col-sm-2 control-label">Upload</label>
                  <div class="col-sm-10">
                      <input type="file" class="form-control" id="inputFile" placeholder="Pilih Gambar Event & News" name="upload_event_news">
                      <small class="text-muted">File image harus berekstensi (jpg / png), ukuran 410 x 303 pixel, size maksimal 100 KB</small><br>
                      <small class="text-muted">Lewati jika tidak ingin mengganti image dengan yang baru.</small>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputIsi" class="col-sm-2 control-label">Konten</label>
                  <div class="col-sm-10">
                      <textarea id="editor" class="form-control" rows="15" id="InputIsi" name="konten_event_news" required><?php echo $daftar_event['konten_event_news']; ?></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputNama" class="col-sm-2 control-label">Author</label>
                  <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputNama" placeholder="misal: Sofyan Setiawan" name="author_event_news" value="<?php echo $daftar_event['author_event_news']; ?>" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputNama" class="col-sm-2 control-label">Kategori</label>
                  <div class="col-sm-10">
                  <?php
                    if($ada_jenis == true){
                      echo '<input type="hidden" name="jenis_event_news" value="'.$jenis.'?>">';
                      echo '<h4><span class="label label-info">'.$daftar_event["nama_event_news_kategori"].'</span></h4>';
                    }
                    else{

                      $seleksi_kategori = mysqli_query($koneksi, "SELECT * FROM event_news_kategori");
                      echo '<select class="form-control" name="jenis_event_news">';
                      echo ' <option value="">- Pilih Kategori -</option>';
                      while ($daftar_kategori = mysqli_fetch_array($seleksi_kategori)) {
                    ?>
                        <option value="<?php echo $daftar_kategori['id_event_news_kategori']; ?>" <?php if($daftar_kategori['slug_event_news_kategori'] == $daftar_event['slug_event_news_kategori']){ echo 'selected'; } ?>><?php echo $daftar_kategori['nama_event_news_kategori']; ?></option>
                      
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
                        <option value="" <?php if($daftar_event['urutan'] == 10){ echo 'selected'; } ?>>- Tidak Urutan -</option>
                        <option value="1" <?php if($daftar_event['urutan'] == 1){ echo 'selected'; } ?>>1</option>
                        <option value="2" <?php if($daftar_event['urutan'] == 2){ echo 'selected'; } ?>>2</option>
                        <option value="3" <?php if($daftar_event['urutan'] == 3){ echo 'selected'; } ?>>3</option>
                        <option value="4" <?php if($daftar_event['urutan'] == 4){ echo 'selected'; } ?>>4</option>
                        <option value="5" <?php if($daftar_event['urutan'] == 5){ echo 'selected'; } ?>>5</option>
                      </select>
                      <small class="text-muted">Lewati jika tidak ingin mengganti urutan. Jika tidak dipilih maka tidak masuk 5 urutan paling awal.</small>
                  </div>
                </div>
                
                <hr class="hr1">
                <div class="form-group">
                  <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary bold" name="event_news_edit"><i class="fa fa-save"></i> Simpan</button>&nbsp;&nbsp;
                    <?php
                    if($ada_jenis == true){
                      echo '<a href="event_news.php?jenis='.$jenis.'" class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Kembali</a>';
                    }
                    else{
                      echo '<a href="event_news.php" class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Kembali</a>';
                    }
                  ?>

                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        <?php
          }
          ?>
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