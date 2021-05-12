<?php 
session_start();
$title = "Manajemen Testimoni";
include_once "header.php";

$seleksi_testimoni = mysqli_query($koneksi, "SELECT * FROM testimoni WHERE urutan > 0 ORDER BY urutan ASC") or die("<script>alert('Query salah')</script>");
$jumlah_testimoni = mysqli_num_rows($seleksi_testimoni);
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
                <a class="navbar-brand">Testimoni (80 x 80)</a>
              </div>

              <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
                <ul class="nav navbar-nav">
                  <li><a href="testimoni_tambah.php"><i class="fa fa-plus-circle"></i> Tambah Testimoni</a></li>
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
                  <th width="10%">Image</th>
                  <th width="10%">Nama</th>
                  <th width="10%">Jabatan</th>
                  <th width="10%">Social</th>
                  <th width="15%">Konten</th>
                  <th width="10%">Urutan</th>
                  <th width="15%">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                  if($jumlah_testimoni == 0){
                    echo '<tr>
                            <td colspan="8">Tidak ada data</td>
                            <td style="display: none;"></td>
                            <td style="display: none;"></td>
                            <td style="display: none;"></td>
                            <td style="display: none;"></td>
                            <td style="display: none;"></td>
                            <td style="display: none;"></td>
                            <td style="display: none;"></td>
                         </tr>';
                  }
                  elseif ($jumlah_testimoni > 0) {
                    $no = 1;
                    while($daftar_testimoni = mysqli_fetch_array($seleksi_testimoni)){
                      echo "<tr>";
                      echo "<td>".$no."</td>";
                      if(empty($daftar_testimoni['image_testimoni'])){
                        echo "<td><img src='..".$default_image_testimoni."' alt='Testimoni' class='img-responsive' width='80' onError=\"this.onerror=null;this.src='../images/no_image/no-testimoni.png\"'></td>";
                      }
                      else{
                        echo "<td><img src='../upload/image/testimoni/".$daftar_testimoni['image_testimoni']."' alt='".$daftar_testimoni['person_testimoni']."' class='img-responsive' width='80' onError=\"this.onerror=null;this.src='../images/no_image/no-testimoni.png\"'></td>";
                      }
                      echo "<td>".$daftar_testimoni['person_testimoni']."</td>";
                      echo "<td>".$daftar_testimoni['jabatan_testimoni']."</td>";
                      echo '<td>
                            <a href="'.$daftar_testimoni["facebook_url"].'" target="_blank">Facebook <span class="fa fa-external-link"></span</a><br>
                            <a href="'.$daftar_testimoni["twitter_url"].'" target="_blank">Twitter <span class="fa fa-external-link"></span</a><br>
                            <a href="'.$daftar_testimoni["instagram_url"].'" target="_blank">Instagram <span class="fa fa-external-link"></span</a><br>
                          </td>';
                      echo '<td>'.$daftar_testimoni['konten_testimoni'].'</td>';
                      if(empty($daftar_testimoni['urutan']) || $daftar_testimoni['urutan'] == 10){
                          echo "<td>-</td>";
                      }
                      else{
                          echo '<td><span class="label label-primary">'.$daftar_testimoni['urutan'].'</span></td>';
                      }
                      echo "<td class=ctr'>
                                    <div class='btn-group'>
                                      <a href='testimoni_edit.php?id=".$daftar_testimoni['id_testimoni']."' class='btn btn-success'><i class='fa fa-pencil'></i> Edit</a>
                                      <a href='action.php?id_hapus_testimoni=".$daftar_testimoni['id_testimoni']."' class='btn btn-danger' onclick='return confirm(\"Apakah Anda Yakin Ingin Menghapus Data Ini?\")'><i class='fa fa-trash-o'></i> Hapus</a>
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