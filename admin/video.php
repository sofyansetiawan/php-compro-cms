<?php 
session_start();
$title = "Manajemen Video";
include_once "header.php";

$seleksi_video = mysqli_query($koneksi, "SELECT * FROM video ORDER BY FIELD(dipakai, 'ya') DESC") or die("<script>alert('Query salah')</script>");
$jumlah_video = mysqli_num_rows($seleksi_video);
?>

<div class="container margin-b70">
      <div class="row">
        <div class="col-md-10 col-md-offset-1">

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
                <a class="navbar-brand">Video</a>
              </div>

              <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
                <ul class="nav navbar-nav">
                  <li><a href="video_tambah.php"><i class="fa fa-plus-circle"></i> Tambah Video</a></li>
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
                  <th width="30%">Nama Menu</th>
                  <th width="35%">File Video</th>
                  <th width="10%">Status</th>
                  <th width="20%">Aksi</th>
                </tr>
              </thead>
              <tbody>
                 <?php 
                    if($jumlah_video == 0){
                      echo '<tr>
                              <td colspan="5">Tidak ada data</td>
                              <td style="display: none;"></td>
                              <td style="display: none;"></td>
                              <td style="display: none;"></td>
                              <td style="display: none;"></td>
                           </tr>';
                    }     
                    elseif ($jumlah_video > 0) {
                        $no = 1;
                        while($daftar_video = mysqli_fetch_array($seleksi_video)){
                          echo '<tr>';
                          echo '<td>'.$no.'</td>';
                          echo '<td>'.$daftar_video['nama_video'].'</td>';
                          echo '<td><a href="'.$site.'upload/video/'.$daftar_video['file_video'].'" target="_blank">'.$daftar_video['file_video'].' <span class="fa fa-external-link"></span></a><br>
                                <p><small><span class="text-muted"><em>Klik link diatas untuk melihat video</em></span></small></p>
                                </td>';
                          echo '<td>
                                  <div class="form-check">
                                    <label class="toggle">
                                    ';
                          if($daftar_video['dipakai'] == "ya"){
                           echo '<span class="label label-primary">Dipakai</span>';
                          }
                          elseif($daftar_video['dipakai'] == "tidak"){
                            echo '<span class="label label-default">Tidak Dipakai</span>';
                          }
                          echo '</label>
                                  </div>
                                </td>';
                          echo '<td class="ctr">
                                  <div class="btn-group">
                                    <a href="video_edit.php?id='.$daftar_video["id_video"].'" class="btn btn-success"><i class="fa fa-pencil"></i> Edit</a>
                                    <a href="action.php?id_hapus_video='.$daftar_video["id_video"].'" class="btn btn-danger" onclick="return confirm(\'Apakah Anda Yakin Ingin Menghapus Data Ini?\')"><i class="fa fa-trash-o"></i> Hapus</a>
                                  </div>
                                </td>
                              </tr>';
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