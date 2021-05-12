<?php 
session_start();
$title = "Manajemen Logo (ukuran 200 x 63)";
include_once "header.php";

$seleksi_logo = mysqli_query($koneksi, "SELECT * FROM logo ORDER BY FIELD(used, 'ya') DESC") or die("<script>alert('Query salah')</script>");
$jumlah_logo = mysqli_num_rows($seleksi_logo);
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
                <a class="navbar-brand">Logo (200 x 63)</a>
              </div>

              <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
                <ul class="nav navbar-nav">
                  <li><a href="logo_tambah.php"><i class="fa fa-plus-circle"></i> Tambah Logo</a></li>
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
                  <th width="20%">Nama Logo</th>
                  <th width="25%">URL Logo</th>
                  <th width="25%">Preview</th>
                  <th width="10%">Status</th>
                  <th width="15%">Aksi</th>
                </tr>
              </thead>

                <?php 
                  if($jumlah_logo == 0){
                    echo '<tr>
                            <td colspan="6">Tidak ada data</td>
                            <td style="display: none;"></td>
                            <td style="display: none;"></td>
                            <td style="display: none;"></td>
                            <td style="display: none;"></td>
                            <td style="display: none;"></td>
                         </tr>';
                  }
                  elseif ($jumlah_logo > 0) {
                    $no = 1;
                    while($daftar_logo = mysqli_fetch_array($seleksi_logo)){
                      echo "<tr>";
                      echo "<td>".$no."</td>";
                      echo "<td>".$daftar_logo['judul_logo']."</td>";
                      
                      if(empty($daftar_logo['image_logo'])){
                          echo "<td>
                          <input type='url' class='form-control' value='".$site."".$default_image_logo."' style='width: 100% !important'>
                          </td>";
                          echo "<td><img src='..".$default_image_logo."' alt='Logo' class='img-responsive' width='200'></td>";
                      }
                      else{
                          echo "<td>
                          <input type='url' class='form-control' value='".$site."upload/image/logo/".$daftar_logo['image_logo']."' style='width: 100% !important' onError=\"this.onerror=null;this.src='../images/no_image/no-logo.png\"'>
                          </td>";
                          echo "<td><img src='../upload/image/logo/".$daftar_logo['image_logo']."' alt='".$daftar_logo['judul_logo']."' class='img-responsive' width='200' onError=\"this.onerror=null;this.src='../images/no_image/no-logo.png\"'></td>";
                      }
                      echo "<td><div class='form-check'><label class='toggle'>";
                      if($daftar_logo['used'] == "ya"){
                        echo "<span class='label label-primary'>Dipakai</span>";
                      }
                      elseif($daftar_logo['used'] == "tidak"){
                        echo "<span class='label label-default'>Tidak Dipakai</span>";
                      }
                        echo "</label></div></td>";

                        echo "<td class=ctr'>
                              <div class='btn-group'>
                                <a href='logo_edit.php?id=".$daftar_logo['id_logo']."' class='btn btn-success'><i class='fa fa-pencil'></i> Edit</a>
                                <a href='action.php?id_hapus_logo=".$daftar_logo['id_logo']."' class='btn btn-danger' onclick='return confirm(\"Apakah Anda Yakin Ingin Menghapus Data Ini?\")'><i class='fa fa-trash-o'></i> Hapus</a>
                              </div>
                            </td>";
                      echo "</tr>";
                    $no++;
                  }
                }
                ?>
            </table>
          </div>

            </div>
          </div>
        </div>

<?php 
include_once "footer.php";

?>