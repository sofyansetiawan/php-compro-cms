<?php
session_start();
$title = "Edit User & Password";
include_once "header.php";
?>
<div class="container margin-b50">
  <div class="row">
    <div class="col-md-12">
      <?php echo $status_form; ?>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <nav class="navbar navbar-default navbar-utama nav-admin-data" role="navigation">
        <div class="container-fluid">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header">
            <a class="navbar-brand" href="#"><i class="fa fa-pencil"></i> Edit Data Profile</a>
          </div>
          
          </div><!-- /.container-fluid -->
        </nav>
        <div class="well">
          <?php
          $seleksi_profile = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '".$_SESSION['id_user']."' && level = '".$_SESSION['level']."' LIMIT 1") or die("<script>alert('Query salah')</script>");
          $jumlah_profile = mysqli_num_rows($seleksi_profile);

          if($jumlah_profile == 1){
          while($daftar_profile = mysqli_fetch_array($seleksi_profile)){
          ?>
          <form class="form-horizontal" role="form" action="action.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
              <label for="inputNama" class="col-sm-3 control-label">Nama Lengkap</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="inputNama" placeholder="misal: Sofyan Setiawan" value="<?php echo $daftar_profile['nama_user']; ?>" name="profile_nama" required>
              </div>
            </div>
            <div class="form-group">
              <label for="inputNama" class="col-sm-3 control-label">Foto Saat Ini</label>
              <div class="col-sm-9">
                <?php
                if(!empty($daftar_profile['image_user'])){
                ?>
                <img src="../upload/image/user/<?php echo $daftar_profile['image_user']; ?>" alt="<?php echo $daftar_profile['image_user']; ?>" class="img-responsive" width="200" onError="this.onerror=null;this.src='../images/no_image/no-testimoni.png';">
                <?php
                }
                else{
                ?>
                <h4>Tidak ada Foto</h4>
                <?php
                }
                ?>
              </div>
            </div>
            <div class="form-group">
              <label for="inputFile" class="col-sm-3 control-label">Upload Foto Baru</label>
              <div class="col-sm-9">
                <input type="file" class="form-control" id="inputFile" placeholder="Pilih Gambar Cover" name="profile_upload">
                <small class="text-muted">File image harus berekstensi (jpg / png), ukuran 150 x 150 pixel, size maksimal 100 KB</small><br>
                <small class="text-muted">Lewati jika tidak ingin mengganti image dengan yang baru.</small>
              </div>
            </div>
            <div class="form-group">
              <label for="inputFile" class="col-sm-3 control-label">Jabatan</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="inputNama3" placeholder="misal: Marketing 1" value="<?php echo $daftar_profile['jabatan_user']; ?>" name="profile_jabatan" required>
              </div>
            </div>
            <div class="form-group">
              <label for="inputFile" class="col-sm-3 control-label">Level</label>
              <div class="col-sm-9">
                <h4><span class="label label-primary"><?php echo $daftar_profile['level']; ?></span></h4>
              </div>
            </div>
            <hr class="hr1">
            <div class="form-group">
              <div class="col-sm-offset-3 col-sm-9">
                <button type="submit" class="btn btn-primary bold" name="profile_edit"><i class="fa fa-save"></i> Simpan</button>
              </div>
            </div>
          </form>
          <?php
          }
          }
          ?>
        </div>
      </div>
      <!-- batas data user -->
      <div class="col-md-6">
        <nav class="navbar navbar-default navbar-utama nav-admin-data" role="navigation">
          <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
              <a class="navbar-brand" href="#"><i class="fa fa-unlock-alt"></i> Edit Username Password</a>
            </div>
            
            </div><!-- /.container-fluid -->
          </nav>
          <div class="well">
            <?php
            $seleksi_profile = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '".$_SESSION['id_user']."' && level = '".$_SESSION['level']."' LIMIT 1") or die("<script>alert('Query salah')</script>");
            $jumlah_profile = mysqli_num_rows($seleksi_profile);
            if($jumlah_profile == 1){
            while($daftar_profile = mysqli_fetch_array($seleksi_profile)){
            ?>
            <form class="form-horizontal" role="form" action="action.php" method="post">
              <div class="form-group">
                <label for="inputFile2" class="col-sm-3 control-label">Username</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="inputFile2" placeholder="misal: usename1" value="<?php echo $daftar_profile['username']; ?>" name="username" required>
                </div>
              </div>
              <div class="form-group">
                <label for="inputFile3" class="col-sm-3 control-label">Password Lama</label>
                <div class="col-sm-9">
                  <input type="password" class="form-control" id="inputFile3" placeholder="misal: username12345" value="" name="password_lama" required autocomplete="off">
                </div>
              </div>
              <div class="form-group">
                <label for="inputFile3" class="col-sm-3 control-label">Password Baru</label>
                <div class="col-sm-9">
                  <input type="password" class="form-control" id="inputFile3" placeholder="misal: username12345" value="" name="password_baru" required autocomplete="off">
                </div>
              </div>
              <div class="form-group">
                <label for="inputFile3" class="col-sm-3 control-label">Konfirm Password Baru</label>
                <div class="col-sm-9">
                  <input type="password" class="form-control" id="inputFile3" placeholder="misal: username12345" value="" name="konfirm_password_baru" required autocomplete="off">
                </div>
              </div>
              <hr class="hr1">
              <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                  <button type="submit" class="btn btn-primary bold" name="profile_edit_username"><i class="fa fa-save"></i> Simpan</button>
                </div>
              </div>
            </form>
            <?php
            }
            }
            ?>
          </div>
        </div>
      </div>
      <!-- INI BATAS PROFILE DAN PASSWORD -->
      <!-- INI BATAS PROFILE DAN PASSWORD -->
      <!-- INI BATAS PROFILE DAN PASSWORD -->
      <!-- INI BATAS PROFILE DAN PASSWORD -->
      <!-- INI BATAS PROFILE DAN PASSWORD -->
      <!-- INI BATAS PROFILE DAN PASSWORD -->
      <?php 
        if($_SESSION['level'] == "superuser"){
      ?>
      <hr class="hr1">

      <div class="row">
        <div class="col-md-6">
          <nav class="navbar navbar-default navbar-utama nav-admin-data" role="navigation">
            <div class="container-fluid">
              <!-- Brand and toggle get grouped for better mobile display -->
              <div class="navbar-header">
                <a class="navbar-brand" href="#"><i class="fa fa-plus-circle"></i> Tambah Data User</a>
              </div>
              
              </div><!-- /.container-fluid -->
            </nav>
            <div class="well">
              <form class="form-horizontal" role="form" action="action.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="inputNama" class="col-sm-3 control-label">Nama Lengkap</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="inputNama" placeholder="misal: Sofyan Setiawan" value="" name="profile_nama" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputFile" class="col-sm-3 control-label">Upload Foto Baru</label>
                  <div class="col-sm-9">
                    <input type="file" class="form-control" id="inputFile" placeholder="Pilih Gambar Cover" name="profile_upload" required>
                    <small class="text-muted">File image harus berekstensi (jpg / png), ukuran 150 x 150 pixel, size maksimal 100 KB</small><br>
                    <small class="text-muted">Lewati jika tidak ingin mengganti image dengan yang baru.</small>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputFile" class="col-sm-3 control-label">Jabatan</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="inputNama3" placeholder="misal: Marketing 1" value="" name="profile_jabatan" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputStatus" class="col-sm-3 control-label">Level</label>
                  <div class="col-sm-9">
                      <select class="form-control" name="profile_level" required>
                        <option value="">- Pilih Level -</option>
                        <option value="admin">Admin</option>
                        <option value="marketing">Marketing</option>
                        <option value="news">News</option>
                      </select>
                  </div>
                </div>

                <hr class="hr1">

                <div class="form-group">
                    <label for="inputFile2" class="col-sm-3 control-label">Username</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="inputFile2" placeholder="misal: usename1" value="" name="profile_username" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputFile3" class="col-sm-3 control-label">Password</label>
                    <div class="col-sm-9">
                      <input type="password" class="form-control" id="inputFile3" placeholder="misal: username12345" value="" name="profile_password" required autocomplete="off">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputFile3" class="col-sm-3 control-label">Konfirmasi Password</label>
                    <div class="col-sm-9">
                      <input type="password" class="form-control" id="inputFile3" placeholder="misal: username12345" value="" name="profile_konfirmasi_password" required autocomplete="off">
                    </div>
                  </div>

                <hr class="hr1">
                <div class="form-group">
                  <div class="col-sm-offset-3 col-sm-9">
                    <button type="submit" class="btn btn-primary bold" name="profile_tambah"><i class="fa fa-plus-circle"></i> Tambah</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <!-- batas data user -->
          <div class="col-md-6">
            <nav class="navbar navbar-default navbar-utama nav-admin-data" role="navigation">
              <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                  <a class="navbar-brand" href="#"><i class="fa fa-table"></i> Tabel Semua User</a>
                </div>
                  
                </div><!-- /.container-fluid -->
              </nav>
              <div class="well">
                <?php
                  $seleksi_semua_user = mysqli_query($koneksi, "SELECT id_user, nama_user, image_user, jabatan_user, level, username FROM user ORDER BY FIELD(level, 'superuser') ASC") or die("<script>alert('Query salah')</script>");
                  $jumlah_semua_user = mysqli_num_rows($seleksi_semua_user);
                ?>

                <div class="table-responsive">
                  <table id="table_data" class="table table-bordered table-striped table-admin">
                    <thead>
                      <tr>
                        <th width="30%">Nama</th>
                        <th width="35%">Foto</th>
                        <th width="10%">Jabatan</th>
                        <th width="20%">Level</th>
                        <th width="20%">Username</th>
                        <th width="5%">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                <?php 
                  if($jumlah_semua_user == 0){
                    echo '<tr>
                            <td colspan="6">Tidak ada data</td>
                            <td style="display: none;"></td>
                            <td style="display: none;"></td>
                            <td style="display: none;"></td>
                            <td style="display: none;"></td>
                            <td style="display: none;"></td>
                         </tr>';
                  }
                  elseif ($jumlah_semua_user > 0) {
                    $no = 1;
                    while($daftar_semua_user = mysqli_fetch_array($seleksi_semua_user)){

                      echo "<tr>";
                      echo "<td>".$daftar_semua_user['nama_user']."</td>";
                      if(empty($daftar_semua_user['image_user'])){
                          echo "<td><img src='..".$default_image_user."' alt='foto_user' class='img-responsive' width='70' onError='this.onerror=null;this.src='../images/no_image/no-testimoni.png';'></td>";
                      }
                      else{
                          echo "<td><img src='../upload/image/user/".$daftar_semua_user['image_user']."' alt='".$daftar_semua_user['nama_user']."' class='img-responsive' width='70' onError='this.onerror=null;this.src=\"../images/no_image/no-testimonis.png\";'></td>";
                      }
                      echo '<td>'.$daftar_semua_user["jabatan_user"].'</td>';
                      echo '<td><span class="label label-info">'.$daftar_semua_user["level"].'</span></td>';
                      echo '<td><span class="label label-primary">'.$daftar_semua_user["username"].'</span></td>';
                      if($_SESSION['id_user'] != $daftar_semua_user["id_user"]){
                        echo '<td class="ctr">
                                <button type="button" class="btn btn-success"><i class="fa fa-pencil" data-toggle="modal" data-target="#editModal'.$daftar_semua_user["id_user"].'"></i></button>

                                <a href="action.php?id_hapus_profile='.$daftar_semua_user["id_user"].'" class="btn btn-danger" onclick="return confirm(\'Apakah Anda Yakin Ingin Menghapus Data Ini?\')"><i class="fa fa-trash-o"></i></a>
                                  </td>';
                      }
                      else{
                        echo '<td></td>';
                      }
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
          }
          ?>
        </div>

        <?php
        $seleksi_semua_user = mysqli_query($koneksi, "SELECT id_user, nama_user, image_user, jabatan_user, level, username FROM user") or die("<script>alert('Query salah')</script>");

        $jumlah_semua_user = mysqli_num_rows($seleksi_semua_user);

        if ($jumlah_semua_user > 0) {
            while($daftar_semua_user = mysqli_fetch_array($seleksi_semua_user)){
        ?>
        <!-- Modal -->
        <div class="modal fade" id="editModal<?php echo $daftar_semua_user["id_user"]; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content" style="background: #fafafa;">
              <div class="modal-header" style="background: #e1e1e1;border-bottom: 2px solid #ccc;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Edit User (<?php echo $daftar_semua_user["nama_user"]; ?>)</h4>
              </div>
              <div class="modal-body">
                <form class="form-horizontal" role="form" action="action.php" method="post" enctype="multipart/form-data">
                  <div class="form-group">
                    <label for="inputNama" class="col-sm-3 control-label">Nama Lengkap</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="inputNama" placeholder="misal: Sofyan Setiawan" value="<?php echo $daftar_semua_user['nama_user']; ?>" name="profile_nama" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputNama" class="col-sm-3 control-label">Foto Saat Ini</label>
                    <div class="col-sm-9">
                      <?php
                      if(!empty($daftar_semua_user['image_user'])){
                      ?>
                      <img src="../upload/image/user/<?php echo $daftar_semua_user['image_user']; ?>" alt="<?php echo $daftar_semua_user['image_user']; ?>" class="img-responsive" width="200" onError="this.onerror=null;this.src='../images/no_image/no-testimoni.png';">
                      <?php
                      }
                      else{
                      ?>
                      <h4>Tidak ada Foto</h4>
                      <?php
                      }
                      ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputFile" class="col-sm-3 control-label">Upload Foto Baru</label>
                    <div class="col-sm-9">
                      <input type="file" class="form-control" id="inputFile" placeholder="Pilih Gambar Cover" name="profile_upload">
                      <small class="text-muted">File image harus berekstensi (jpg / png), ukuran 150 x 150 pixel, size maksimal 100 KB</small><br>
                      <small class="text-muted">Lewati jika tidak ingin mengganti image dengan yang baru.</small>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputFile" class="col-sm-3 control-label">Jabatan</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="inputNama3" placeholder="misal: Marketing 1" value="<?php echo $daftar_semua_user['jabatan_user']; ?>" name="profile_jabatan" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputFile" class="col-sm-3 control-label">Level</label>
                    <div class="col-sm-9">
                      <h5><span class="label label-primary"><?php echo $daftar_semua_user['level']; ?></span></h5>
                    </div>
                  </div>
                
              </div>
              <div class="modal-footer" style="background: #e1e1e1;border-top: 2px solid #ccc;">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
               <button type="submit" class="btn btn-primary bold" name="profile_edit"><i class="fa fa-save"></i> Simpan</button>
                </form>
              </div>
            </div>
          </div>
        </div>
        <?php
          }
        }
        ?>
        
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