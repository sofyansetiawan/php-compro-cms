<?php

session_start();

$title = "";

if(isset($_GET['jenis']) && !empty($_GET['jenis'])){
  $jenis_event_news = $_GET['jenis'];
}
else{
  $jenis_event_news = "";
}

$title .= "Manajemen Event & News (410 x 303)";
include_once "header.php";

if(!isset($jenis_event_news) || empty($jenis_event_news)){

   $seleksi_event_news = mysqli_query($koneksi, "
    SELECT event_news.*, event_news_kategori.* 
     FROM event_news 
     LEFT OUTER JOIN event_news_kategori 
     ON event_news.id_event_news_kategori = event_news_kategori.id_event_news_kategori
     WHERE event_news.urutan > 0
     ORDER BY event_news.urutan ASC
      ") or die("<script>alert('Query salah')</script>");

}
else{
  $seleksi_event_news = mysqli_query($koneksi, "
   SELECT event_news.*, event_news_kategori.* 
   FROM event_news 
   LEFT OUTER JOIN event_news_kategori 
   ON event_news.id_event_news_kategori = event_news_kategori.id_event_news_kategori 
   WHERE event_news_kategori.id_event_news_kategori = $jenis_event_news AND event_news.urutan > 0
   ORDER BY event_news.urutan ASC
    ") or die("<script>alert('Query salah')</script>");

   $seleksi_event_news2 = mysqli_query($koneksi, "
   SELECT event_news.*, event_news_kategori.* 
   FROM event_news 
   JOIN event_news_kategori 
   ON event_news.id_event_news_kategori = event_news_kategori.id_event_news_kategori 
   WHERE event_news_kategori.id_event_news_kategori = $jenis_event_news AND event_news.urutan > 0
   ORDER BY event_news.urutan ASC
    ") or die("<script>alert('Query salah')</script>");

   $nama_jenis = mysqli_fetch_array($seleksi_event_news2);
}

$jumlah_event_news = mysqli_num_rows($seleksi_event_news);

?>

<div class="container margin-b70">
      <div class="row">
        <div class="col-md-12">

          <?php echo $status_form; ?>
          
          <nav class="navbar navbar-default navbar-utama nav-admin-data" role="navigation">
            <div class="container-fluid">
              <!-- Brand and toggle get grouped for better mobile display -->
              <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand">Event & News (410 x 303) <span class="text-danger">
                  <?php 
                  if(isset($nama_jenis['nama_event_news_kategori']) && !empty($nama_jenis['nama_event_news_kategori']))
                  {
                    echo " - ".$nama_jenis['nama_event_news_kategori'];
                  }
                  else 
                  {
                    echo " - ALL";
                  }
                  ?>
                    
                  </span></a>
              </div>

              <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
                <ul class="nav navbar-nav">
                  <li><a href="event_news_tambah.php?jenis=<?php echo $jenis_event_news; ?>"><i class="fa fa-plus-circle"></i> Tambah Event & News&nbsp;
                  <?php 
                  if(isset($nama_jenis['nama_event_news_kategori']) && !empty($nama_jenis['nama_event_news_kategori']))
                  {
                    echo " - ".$nama_jenis['nama_event_news_kategori'];
                  }
                  else 
                  {
                    echo " - ALL";
                  }
                  ?>
                </a></li>
                </ul>
                </div>
              <!-- Collect the nav links, forms, and other content for toggling -->
                </div><!-- /.container-fluid -->
              </nav> 
              <div class="table-responsive">
            <table id="table_data" class="table table-bordered table-striped table-admin">
              <thead>
                <tr>
                  <th width="5%">No.</th>
                  <th width="10%">Judul</th>
                  <th width="10%">Sub Judul</th>
                  <th width="10%">Image</th>
                  <th width="10%">Diubah</th>
                  <th width="15%">Konten</th>
                  <th width="10%">Author</th>
                  <th width="5%">Kategori</th>
                  <th width="10%">Urutan</th>
                  <th width="15%">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                  if($jumlah_event_news == 0){
                    echo '<tr>
                            <td colspan="10">Tidak ada data</td>
                            <td style="display: none;"></td>
                            <td style="display: none;"></td>
                            <td style="display: none;"></td>
                            <td style="display: none;"></td>
                            <td style="display: none;"></td>
                            <td style="display: none;"></td>
                            <td style="display: none;"></td>
                            <td style="display: none;"></td>
                            <td style="display: none;"></td>
                         </tr>';
                  }
                  elseif ($jumlah_event_news > 0) {
                    $no = 1;
                    while($daftar_event_news = mysqli_fetch_array($seleksi_event_news)){

                      echo "<tr>";
                      echo "<td>".$no."</td>";
                      echo "<td>".$daftar_event_news['judul_event_news']."</td>";
                      echo "<td>".$daftar_event_news['sub_judul_event_news']."</td>";
                      if(empty($daftar_event_news['image_event_news'])){
                          echo "<td><img src='..".$default_image_event_news."' alt='event_news' class='img-responsive' width='200' onError='this.onerror=null;this.src='../images/no_image/no-news.png';'></td>";
                      }
                      else{
                          echo "<td><img src='../upload/image/event_news/".$daftar_event_news['image_event_news']."' alt='".$daftar_event_news['judul_event_news']."' class='img-responsive' width='200' onError='this.onerror=null;this.src=\"../images/no_image/no-news.png\";'></td>";
                      }
                      echo '<td>'.$daftar_event_news["tanggal_event_news"].'</td>';
                      echo '<td>'.substr($daftar_event_news['konten_event_news'], 0, 100)."[...]".'</td>';
                      echo '<td>'.$daftar_event_news["author_event_news"].'</td>';


                      if(isset($daftar_event_news['slug_event_news_kategori'])){
                        echo '<td><span class="label label-info">'.$daftar_event_news['slug_event_news_kategori'].'</span></td>';
                      }
                      else{
                        echo '<td><span class="label label-default">Tanpa Kategori</span></td>';
                      }

                      
                      if(empty($daftar_event_news['urutan']) || $daftar_event_news['urutan'] == 10){
                          echo "<td>-</td>";
                      }
                      else{
                          echo '<td><span class="label label-primary">'.$daftar_event_news['urutan'].'</span></td>';
                      }

                      echo "<td class=ctr'>
                                    <div class='btn-group'>
                                      <a href='event_news_edit.php?id=".$daftar_event_news['id_event_news']."' class='btn btn-success'><i class='fa fa-pencil'></i> Edit</a>
                                      <a href='action.php?id_hapus_event_news=".$daftar_event_news['id_event_news']."' class='btn btn-danger' onclick='return confirm(\"Apakah Anda Yakin Ingin Menghapus Data Ini?\")'><i class='fa fa-trash-o'></i> Hapus</a>
                                    </div>
                                  </td>";
                          echo "</tr>";
                        $no++;
                      }
                    }
                  ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

<?php 
include_once "footer.php";

?>