<?php 
session_start();
$title = "Manajemen Cover video (4200 x 1800)";
include_once "header.php";

$seleksi_cover = mysqli_query($koneksi, "SELECT * FROM cover_video ORDER BY FIELD(used, 'ya') DESC") or die("<script>alert('Query salah')</script>");
$jumlah_cover = mysqli_num_rows($seleksi_cover);
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
                <a class="navbar-brand">Cover video (4200 x 1800)</a>
              </div>

              <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
                <ul class="nav navbar-nav">
                  <li><a href="cover_video_tambah.php"><i class="fa fa-plus-circle"></i> Tambah Cover video</a></li>
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
                        <th width="20%">Nama Cover</th>
                        <th width="25%">URL Cover</th>
                        <th width="25%">Preview</th>
                        <th width="10%">Dipakai</th>
                        <th width="15%">Aksi</th>
                      </tr>
                    </thead>
                    <tbody> 
                    <?php 
                        if($jumlah_cover == 0){
                          echo '<tr>
                                  <td colspan="6">Tidak ada data</td>
                                  <td style="display: none;"></td>
                                  <td style="display: none;"></td>
                                  <td style="display: none;"></td>
                                  <td style="display: none;"></td>
                                  <td style="display: none;"></td>
                               </tr>';
                        }
                        elseif ($jumlah_cover > 0) {
                          $no = 1;
                          while($daftar_cover= mysqli_fetch_array($seleksi_cover)){
                            echo "<tr>";
                            echo "<td>".$no."</td>";
                            echo "<td>".$daftar_cover['judul_cover']."</td>";
                            
                            if(empty($daftar_cover['gambar_cover'])){
                                echo "<td>
                                <input type='url' class='form-control' value='".$site."".$default_image_cover_video."' style='width: 100% !important'>
                                </td>";
                                echo "<td><img src='..".$default_image_cover."' alt='cover' class='img-responsive' width='200' onError='this.onerror=null;this.src=\"../images/no_image/no-cover.png\";'></td>";
                            }
                            else{
                                echo "<td>
                                <input type='url' class='form-control' value='".$site."upload/image/cover_v/".$daftar_cover['gambar_cover']."' style='width: 100% !important'>
                                </td>";
                                echo "<td><img src='../upload/image/cover_v/".$daftar_cover['gambar_cover']."' alt='".$daftar_cover['judul_cover']."' class='img-responsive' width='200' onError='this.onerror=null;this.src=\"../images/no_image/no-cover.png\";'></td>";
                            }
                            echo "<td><div class='form-check'><label class='toggle'>";
                            if($daftar_cover['used'] == "ya"){
                              echo "<span class='label label-primary'>Dipakai</span>";
                            }
                            elseif($daftar_cover['used'] == "tidak"){
                              echo "<span class='label label-default'>Tidak Dipakai</span>";
                            }
                              echo "</label></div></td>";

                              echo "<td class=ctr'>
                                    <div class='btn-group'>
                                      <a href='cover_video_edit.php?id=".$daftar_cover['id_cover']."' class='btn btn-success'><i class='fa fa-pencil'></i> Edit</a>
                                      <a href='action.php?id_hapus_cover_video=".$daftar_cover['id_cover']."' class='btn btn-danger' onclick='return confirm(\"Apakah Anda Yakin Ingin Menghapus Data Ini?\")'><i class='fa fa-trash-o'></i> Hapus</a>
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