<?php 
session_start();
$title = "Manajemen License & Awards";
include_once "header.php";

$seleksi_license_award = mysqli_query($koneksi, "SELECT * FROM license_award WHERE urutan > 0 ORDER BY urutan ASC") or die("<script>alert('Query salah')</script>");
$jumlah_license_award = mysqli_num_rows($seleksi_license_award);
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
                <a class="navbar-brand">License & Awards (150 x 150 - QR 170 x 170)</a>
              </div>

              <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
                <ul class="nav navbar-nav">
                  <li><a href="license_awards_tambah.php"><i class="fa fa-plus-circle"></i> Tambah License & Awards</a></li>
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
                  <th width="15%">Image</th>
                  <th width="10%">QR Code</th>
                  <th width="25%">Konten</th>
                  <th width="10%">Urutan</th>
                  <th width="15%">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                  if($jumlah_license_award == 0){
                    echo '<tr>
                            <td colspan="7">Tidak ada data</td>
                            <td style="display: none;"></td>
                            <td style="display: none;"></td>
                            <td style="display: none;"></td>
                            <td style="display: none;"></td>
                            <td style="display: none;"></td>
                            <td style="display: none;"></td>
                            <td style="display: none;"></td>
                         </tr>';
                  }
                  elseif ($jumlah_license_award > 0) {
                    $no = 1;
                    while($daftar_license_award = mysqli_fetch_array($seleksi_license_award)){
                      echo "<tr>";
                      echo "<td>".$no."</td>";
                      echo "<td>".$daftar_license_award['judul_license_awards']."</td>";
                      if(empty($daftar_license_award['image_license_awards'])){
                        echo "<td><img src='..".$default_image_license_awards."' alt='License Awards' class='img-responsive' width='200'></td>";
                      }
                      else{
                        echo "<td><img src='../upload/image/license_awards/".$daftar_license_award['image_license_awards']."' alt='".$daftar_license_award['judul_license_awards']."' class='img-responsive' width='200' onError=\"this.onerror=null;this.src='../images/no_image/no-license.png\"'></td>";
                      }
                      if(empty($daftar_license_award['image_qrcode'])){
                        echo "<td><img src='..".$default_image_qrcode."' alt='License Awards' class='img-responsive' width='200' onError=\"this.onerror=null;this.src='../images/no_image/no-license.png\"'></td>";
                      }
                      else{
                        echo "<td><img src='../upload/image/qrcode/".$daftar_license_award['image_qrcode']."' alt='".$daftar_license_award['judul_license_awards']."' class='img-responsive' width='200' onError=\"this.onerror=null;this.src='../images/no_image/no-qrcode.png\"'></td>";
                      }
                      echo '<td>'.$daftar_license_award['konten_license_awards'].'</td>';
                      if(empty($daftar_license_award['urutan']) || $daftar_license_award['urutan'] == 10){
                          echo "<td>-</td>";
                      }
                      else{
                          echo '<td><span class="label label-primary">'.$daftar_license_award['urutan'].'</span></td>';
                      }
                      echo "<td class=ctr'>
                                    <div class='btn-group'>
                                      <a href='license_awards_edit.php?id=".$daftar_license_award['id_license_awards']."' class='btn btn-success'><i class='fa fa-pencil'></i> Edit</a>
                                      <a href='action.php?id_hapus_license_awards=".$daftar_license_award['id_license_awards']."' class='btn btn-danger' onclick='return confirm(\"Apakah Anda Yakin Ingin Menghapus Data Ini?\")'><i class='fa fa-trash-o'></i> Hapus</a>
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