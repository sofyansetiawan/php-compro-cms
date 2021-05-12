<?php 
session_start();
$title = "Manajemen Partner (400 x 72)";
include_once "header.php";

$seleksi_partner = mysqli_query($koneksi, "SELECT * FROM partner WHERE urutan > 0 ORDER BY urutan ASC") or die("<script>alert('Query salah')</script>");
$jumlah_partner = mysqli_num_rows($seleksi_partner);
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
                <a class="navbar-brand">Partner</a>
              </div>

              <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
                <ul class="nav navbar-nav">
                  <li><a href="partner_tambah.php"><i class="fa fa-plus-circle"></i> Tambah Partner (400 x 72)</a></li>
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
                  <th width="15%">Nama Partner</th>
                  <th width="35%">Image Partner</th>
                  <th width="10%">Urutan</th>
                  <th width="15%">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                  if($jumlah_partner == 0 && $jumlah_partner2 == 0){
                    echo '<tr>
                            <td colspan="5">Tidak ada data</td>
                            <td style="display: none;"></td>
                            <td style="display: none;"></td>
                            <td style="display: none;"></td>
                            <td style="display: none;"></td>
                         </tr>';
                  }
                  ?>
                  
                  <?php 
                  if ($jumlah_partner > 0) {
                    $no = 1;
                    while($daftar_partner= mysqli_fetch_array($seleksi_partner)){
                      echo "<tr>";
                      echo "<td>".$no."</td>";
                      echo "<td>".$daftar_partner['nama_partner']."</td>";
                      if(empty($daftar_partner['image_partner'])){
                          echo "<td><img src='..".$default_image_partner."' alt='partner' class='img-responsive' width='200' onError=\"this.onerror=null;this.src='../images/no_image/no-partner.png\"'></td>";
                      }
                      else{
                          echo "<td><img src='../upload/image/partner/".$daftar_partner['image_partner']."' alt='".$daftar_partner['nama_partner']."' class='img-responsive' width='200' onError=\"this.onerror=null;this.src='../images/no_image/no-partner.png\"'></td>";
                      }
                      if($daftar_partner['urutan'] == "10"){
                          echo "<td>-</td>";
                      }
                      else{
                          echo '<td><span class="label label-primary">'.$daftar_partner['urutan'].'</span></td>';
                      }
                      echo "<td class=ctr'>
                                    <div class='btn-group'>
                                      <a href='partner_edit.php?id=".$daftar_partner['id_partner']."' class='btn btn-success'><i class='fa fa-pencil'></i> Edit</a>
                                      <a href='action.php?id_hapus_partner=".$daftar_partner['id_partner']."' class='btn btn-danger' onclick='return confirm(\"Apakah Anda Yakin Ingin Menghapus Data Ini?\")'><i class='fa fa-trash-o'></i> Hapus</a>
                                    </div>
                                  </td>";
                          echo "</tr>";
                          $no++;
                      }
                    }
                    else{

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