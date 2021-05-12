<?php
  include_once "../setting/setting.php";
  include_once '../setting/database.php';
  include_once "../setting/status_session.php";
  include_once "../setting/konten_helper.php";
  include_once "../setting/form_status.php";

  $seleksi_kategori_event_news = mysqli_query($koneksi, "SELECT * FROM event_news_kategori");
  $jumlah_kategori_event_news = mysqli_num_rows($seleksi_kategori_event_news);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $title; ?> - Admin Web Eapp</title>
    <link rel="shortcut icon" href="favicon.png">
    <link rel="stylesheet" href="../assets/css/font-awesome.min.css">
    <link href="../assets/css/bootstrap.min3.css" rel="stylesheet">
    <link href="../assets/css/datatable-bootstrap.css" rel="stylesheet">
    <link href="../assets/css/style_admin.css" rel="stylesheet">
    <link href="../assets/css/menu_admin.css" rel="stylesheet">
    <link href="../assets/js/select2.css" rel="stylesheet">
  </head>
  <body>

    <?php 
        $seleksi_profile = mysqli_query($koneksi, "SELECT nama_user, jabatan_user, image_user FROM user WHERE id_user = '".$_SESSION['id_user']."' && level = '".$_SESSION['level']."' LIMIT 1") or die("<script>alert('Query salah')</script>");
        $daftar_profile = mysqli_fetch_array($seleksi_profile);
    ?>

    <div id="wrapper" class="toggled">
    <!-- <div class="overlay"></div> -->  
        <!-- Sidebar -->
        <nav class="navbar navbar-fixed-top" id="sidebar-wrapper" role="navigation">
            <ul class="nav sidebar-nav">
                <li class="sidebar-brand">
                    <a class="navbar-brand" href="index.php">
                      <img src="../images/admin/eapp-logo.png" class="img-responsive logo-navbar">
                    </a>
                </li>
                <li>
                  <div class="profile-sidebar">
                    <!-- SIDEBAR USERPIC -->
                    <div class="profile-userpic">
                      <img src="../upload/image/user/<?php echo $daftar_profile['image_user']; ?>" class="img-responsive" alt="" onError="this.onerror=null;this.src='../images/no_image/no-testimoni.png';">
                    </div>
                    <!-- END SIDEBAR USERPIC -->
                    <!-- SIDEBAR USER TITLE -->
                    <div class="profile-usertitle">
                      <div class="profile-usertitle-name">
                        <?php echo $daftar_profile['nama_user']; ?>
                      </div>
                      <div class="profile-usertitle-job">
                        <?php echo $daftar_profile['jabatan_user']; ?>
                      </div>
                    </div>
                    <!-- END SIDEBAR USER TITLE -->
                    <!-- SIDEBAR BUTTONS -->
                    <div class="profile-userbuttons">
                      <button onclick="location.href = 'profile.php';" type="button" class="btn btn-success btn-sm"><span class="fa fa-user"></span> User Setting</button>
                      <button onclick="location.href = 'logout.php';" type="button" class="btn btn-danger btn-sm"><span class="fa fa-sign-out"></span> Logout</button>
                    </div>
                  </div>
                </li>
                <li>
                    <a href="dashboard.php">Beranda</a>
                </li>

                <?php 
                  if ($_SESSION['level'] == "superuser" OR $_SESSION['level'] == "admin" OR $_SESSION['level'] == "marketing"){
                ?>
                  <li>
                      <a href="logo.php">Logo</a>
                  </li>
                  <li>
                      <a href="menu_atas.php">Menu Atas</a>
                  </li>
                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Cover <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                      <li class="dropdown-header">Konten Cover Background dan Video</li>
                       <li>
                          <a href="cover_background.php">Cover Background</a>
                      </li>
                           <li>
                          <a href="cover_video.php">Cover Video</a>
                      </li>
                    </ul>
                  </li>
                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">About <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                      <li class="dropdown-header">Konten Isi Tentang Eapp</li>
                      <li><a href="about_who_we_are.php">Who We Are</a></li>
                      <li><a href="about_about_us.php">About Us</a></li>
                      <li><a href="about_vission.php">Vission</a></li>
                      <li><a href="about_mission.php">Mission</a></li>
                      <li><a href="about_teamsupport.php">Team Support</a></li>
                      <li><a href="about_teamconsultant.php">Team Consultant</a></li>
                    </ul>
                  </li>
                  <li>
                      <a href="video.php">Video</a>
                  </li>
                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">app <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                      <li class="dropdown-header">Daftar app-app di PT app Solusi Teknology</li>
                      <li><a href="app_teknologi.php">app Teknologi</a></li>
                      <li><a href="app_ponsel.php">app Ponsel Aksesoris</a></li>
                      <li><a href="app_travel.php">app Travel Pariwisata</a></li>
                      <li><a href="app_perkakas.php">app Perkakas</a></li>
                      <li><a href="app_office.php">app Office Equipment</a></li>
                      <li><a href="app_kesehatan.php">app Kesehatan </a></li>
                      <li><a href="app_buku.php">app Buku Penulis</a></li>
                      <li><a href="app_ukm.php">app UKM</a></li>
                      <li><a href="app_otomotif.php">app Otomotif</a></li>
                      <li><a href="app_home.php">app Home Decor</a></li>
                      <li><a href="app_fashion.php">app Fashion Lifestyle</a></li>
                      <li><a href="app_food.php">app Food Baverage</a></li>
                      <li><a href="app_pendidikan.php">app Pendidikan</a></li>
                      <li><a href="app_security.php">app Security</a></li>
                      <li><a href="app_sport.php">app Sport</a></li>
                    </ul>
                  </li>
                  <li>
                      <a href="partner.php">Partner</a>
                  </li>
                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Event & News <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                      <li class="dropdown-header">Daftar Event News untuk masing-masing Event News</li>
                      <li><a href="event_news.php"><span class="fa fa-list-ul"></span> ALL EVENT NEWS</a></li>
                      <li><a href="event_news_kategori.php"><span class="fa fa-tags"></span> KATEGORI</a></li>
                      <?php 
                      if($jumlah_kategori_event_news > 0){
                        while ($daftar_kategori_event_news =  mysqli_fetch_array($seleksi_kategori_event_news)) {
                          echo '<li><a href="event_news.php?jenis='.$daftar_kategori_event_news["id_event_news_kategori"].'">Event News '.$daftar_kategori_event_news["nama_event_news_kategori"].'</a></li>';
                        }
                      }
                      ?>
                      <!-- <li><a href="event_news.php?jenis=teknologi">Event News Teknologi</a></li>
                      <li><a href="event_news.php?jenis=ponsel">Event News Ponsel Aksesoris</a></li>
                      <li><a href="event_news.php?jenis=travel">Event News Travel Pariwisata</a></li>
                      <li><a href="event_news.php?jenis=perkakas">Event News Perkakas</a></li>
                      <li><a href="event_news.php?jenis=office">Event News Office Equipment</a></li>
                      <li><a href="event_news.php?jenis=kesehatan">Event News Kesehatan </a></li>
                      <li><a href="event_news.php?jenis=buku">Event News Buku Penulis</a></li>
                      <li><a href="event_news.php?jenis=ukm">Event News UKM</a></li>
                      <li><a href="event_news.php?jenis=otomotif">Event News Otomotif</a></li>
                      <li><a href="event_news.php?jenis=home">Event News Home Decor</a></li>
                      <li><a href="event_news.php?jenis=fashion">Event News Fashion Lifestyle</a></li>
                      <li><a href="event_news.php?jenis=food">Event News Food Baverage</a></li>
                      <li><a href="event_news.php?jenis=pendidikan">Event News Pendidikan</a></li>
                      <li><a href="event_news.php?jenis=security">Event News Security</a></li>
                      <li><a href="event_news.php?jenis=sport">Event News Sport</a></li> -->
                    </ul>
                  </li>
                  <li>
                      <a href="license_awards.php">License & Awards</a>
                  </li>
                  <li>
                      <a href="testimoni.php">Testimoni</a>
                  </li>
                  <li>
                      <a href="contact.php">Contact</a>
                  </li>
                  <li>
                      <a href="social_footer.php">Social Footer</a>
                  </li>
                  <li>
                      <a href="judul_heading.php">Judul Section</a>
                  </li>
                  <li>
                      <a href="info_web.php">Info Website</a>
                  </li>

                <?php
                  }
                  elseif($_SESSION['level'] == "news"){
                ?>
                  <li><a href="event_news.php"><span class="fa fa-list-ul"></span> ALL EVENT NEWS</a></li>
                      <li><a href="event_news_kategori.php"><span class="fa fa-tags"></span> KATEGORI</a></li>
                      <?php 
                      if($jumlah_kategori_event_news > 0){
                        while ($daftar_kategori_event_news =  mysqli_fetch_array($seleksi_kategori_event_news)) {
                          echo '<li><a href="event_news.php?jenis='.$daftar_kategori_event_news["id_event_news_kategori"].'">Event News '.$daftar_kategori_event_news["nama_event_news_kategori"].'</a></li>';
                        }
                      }
                      ?>
                <?php
                  }
                ?>

              <!--  -->

              

                    <!--  -->
            </ul>
        </nav>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <button type="button" class="hamburger is-open" data-toggle="offcanvas">
              <span class="hamb-top"></span>
              <span class="hamb-middle"></span>
              <span class="hamb-bottom"></span>
            </button>
            <nav class="navbar navbar-default navbar-utama" style="border-radius: 0px;" role="navigation">
              <div class="container">
                
                <div class="navbar-header">
                  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  </button>
                  <a class="navbar-brand brand-atas" href="dashboard.php">
                  <strong>Admin Web Company Profile</strong>
                  </a>
                </div>
                
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                  <ul class="nav navbar-nav navbar-right">
                    <li><a><span style="font-size: 20px">PT app Solusi Teknology</span></a></li>
                    </li>
                  </ul>
                </div>
              </div>
            </nav>

            <div class="container">
              <div class="row">
                <div class="col-md-8 col-md-offset-2">
                <div class="tengah">
                  <div class="head-depan tengah">
                    <div class="row">
                      <div class="col-md-12">
                        <h1 class="judul-head">Halaman <?php echo $title; ?></h1>
                        <hr class="hr1" />
                      </div>
                    </div>
                  </div>
                </div>
                </div>
              </div>
            </div>