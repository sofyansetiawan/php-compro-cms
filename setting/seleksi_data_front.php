<?php 

$seleksi_logo = mysqli_query($koneksi, "SELECT * FROM logo WHERE used = 'ya' LIMIT 1") or die(mysqli_error());
$daftar_logo = mysqli_fetch_array($seleksi_logo);
$jumlah_logo = mysqli_num_rows($seleksi_logo);
$gambar_logo_dipakai = $daftar_logo['image_logo'];
$judul_logo_dipakai = $daftar_logo['judul_logo'];

//
$seleksi_menu_atas = mysqli_query($koneksi, "SELECT * FROM menu WHERE aktif = 'ya'") or die(mysqli_error());
$jumlah_menu_atas = mysqli_num_rows($seleksi_menu_atas);

//
$seleksi_cover = mysqli_query($koneksi, "SELECT * FROM cover_background WHERE used = 'ya'") or die(mysqli_error());
$jumlah_cover = mysqli_num_rows($seleksi_cover);

//

$seleksi_about_who_we_are = mysqli_query($koneksi, "SELECT * FROM about WHERE category = 'who_we_are' LIMIT 1") or die("<script>alert('Query salah')</script>");
$jumlah_who_we_are = mysqli_num_rows($seleksi_about_who_we_are);
$daftar_who_we_are = mysqli_fetch_array($seleksi_about_who_we_are);

//

$seleksi_about_us = mysqli_query($koneksi, "SELECT * FROM about WHERE category = 'about_us' LIMIT 1") or die("<script>alert('Query salah')</script>");
$jumlah_about_us = mysqli_num_rows($seleksi_about_us);
$daftar_about_us = mysqli_fetch_array($seleksi_about_us);

//

$seleksi_vission = mysqli_query($koneksi, "SELECT * FROM about WHERE category = 'vission' LIMIT 1") or die("<script>alert('Query salah')</script>");
$jumlah_vission = mysqli_num_rows($seleksi_vission);
$daftar_vission = mysqli_fetch_array($seleksi_vission);

//

$seleksi_mission = mysqli_query($koneksi, "SELECT * FROM about WHERE category = 'mission' LIMIT 1") or die("<script>alert('Query salah')</script>");
$jumlah_mission = mysqli_num_rows($seleksi_mission);
$daftar_mission = mysqli_fetch_array($seleksi_mission);

//

$seleksi_teamsupport = mysqli_query($koneksi, "SELECT * FROM about WHERE category = 'teamsupport' LIMIT 1") or die("<script>alert('Query salah')</script>");
$jumlah_teamsupport = mysqli_num_rows($seleksi_teamsupport);
$daftar_teamsupport = mysqli_fetch_array($seleksi_teamsupport);

//

$seleksi_teamconsultant = mysqli_query($koneksi, "SELECT * FROM about WHERE category = 'teamconsultant' LIMIT 1") or die("<script>alert('Query salah')</script>");
  $jumlah_teamconsultant = mysqli_num_rows($seleksi_teamconsultant);
  $daftar_teamconsultant = mysqli_fetch_array($seleksi_teamconsultant);

//

$seleksi_app_teknologi = mysqli_query($koneksi, "SELECT * FROM app WHERE kategori_app = 'app_teknologi' && aktif = 'ya' LIMIT 1") or die("<script>alert('Query salah')</script>");
$jumlah_app_teknologi = mysqli_num_rows($seleksi_app_teknologi);
$daftar_app_teknologi = mysqli_fetch_array($seleksi_app_teknologi);

//

$seleksi_app_ponsel = mysqli_query($koneksi, "SELECT * FROM app WHERE kategori_app = 'app_ponsel' && aktif = 'ya' LIMIT 1") or die("<script>alert('Query salah')</script>");
$jumlah_app_ponsel = mysqli_num_rows($seleksi_app_ponsel);
$daftar_app_ponsel = mysqli_fetch_array($seleksi_app_ponsel);

//

$seleksi_app_travel = mysqli_query($koneksi, "SELECT * FROM app WHERE kategori_app = 'app_travel' && aktif = 'ya' LIMIT 1") or die("<script>alert('Query salah')</script>");
$jumlah_app_travel = mysqli_num_rows($seleksi_app_travel);
$daftar_app_travel = mysqli_fetch_array($seleksi_app_travel);

//

$seleksi_app_perkakas = mysqli_query($koneksi, "SELECT * FROM app WHERE kategori_app = 'app_perkakas' && aktif = 'ya' LIMIT 1") or die("<script>alert('Query salah')</script>");
$jumlah_app_perkakas = mysqli_num_rows($seleksi_app_perkakas);
$daftar_app_perkakas = mysqli_fetch_array($seleksi_app_perkakas);

//

$seleksi_app_office = mysqli_query($koneksi, "SELECT * FROM app WHERE kategori_app = 'app_office' && aktif = 'ya' LIMIT 1") or die("<script>alert('Query salah')</script>");
$jumlah_app_office = mysqli_num_rows($seleksi_app_office);
$daftar_app_office = mysqli_fetch_array($seleksi_app_office);

//

$seleksi_app_kesehatan = mysqli_query($koneksi, "SELECT * FROM app WHERE kategori_app = 'app_kesehatan' && aktif = 'ya' LIMIT 1") or die("<script>alert('Query salah')</script>");
$jumlah_app_kesehatan = mysqli_num_rows($seleksi_app_kesehatan);
$daftar_app_kesehatan = mysqli_fetch_array($seleksi_app_kesehatan);

//

$seleksi_app_buku = mysqli_query($koneksi, "SELECT * FROM app WHERE kategori_app = 'app_buku' && aktif = 'ya' LIMIT 1") or die("<script>alert('Query salah')</script>");
$jumlah_app_buku = mysqli_num_rows($seleksi_app_buku);
$daftar_app_buku = mysqli_fetch_array($seleksi_app_buku);

//

$seleksi_app_ukm = mysqli_query($koneksi, "SELECT * FROM app WHERE kategori_app = 'app_ukm' && aktif = 'ya' LIMIT 1") or die("<script>alert('Query salah')</script>");
$jumlah_app_ukm = mysqli_num_rows($seleksi_app_ukm);
$daftar_app_ukm = mysqli_fetch_array($seleksi_app_ukm);

//

$seleksi_app_otomotif = mysqli_query($koneksi, "SELECT * FROM app WHERE kategori_app = 'app_otomotif' && aktif = 'ya' LIMIT 1") or die("<script>alert('Query salah')</script>");
$jumlah_app_otomotif = mysqli_num_rows($seleksi_app_otomotif);
$daftar_app_otomotif = mysqli_fetch_array($seleksi_app_otomotif);

//

$seleksi_app_home = mysqli_query($koneksi, "SELECT * FROM app WHERE kategori_app = 'app_home' && aktif = 'ya' LIMIT 1") or die("<script>alert('Query salah')</script>");
$jumlah_app_home = mysqli_num_rows($seleksi_app_home);
$daftar_app_home = mysqli_fetch_array($seleksi_app_home);

//

$seleksi_app_fashion = mysqli_query($koneksi, "SELECT * FROM app WHERE kategori_app = 'app_fashion' && aktif = 'ya' LIMIT 1") or die("<script>alert('Query salah')</script>");
$jumlah_app_fashion = mysqli_num_rows($seleksi_app_fashion);
$daftar_app_fashion = mysqli_fetch_array($seleksi_app_fashion);

//

$seleksi_app_food = mysqli_query($koneksi, "SELECT * FROM app WHERE kategori_app = 'app_food' && aktif = 'ya' LIMIT 1") or die("<script>alert('Query salah')</script>");
$jumlah_app_food = mysqli_num_rows($seleksi_app_food);
$daftar_app_food = mysqli_fetch_array($seleksi_app_food);

//

$seleksi_app_pendidikan = mysqli_query($koneksi, "SELECT * FROM app WHERE kategori_app = 'app_pendidikan' && aktif = 'ya' LIMIT 1") or die("<script>alert('Query salah')</script>");
$jumlah_app_pendidikan = mysqli_num_rows($seleksi_app_pendidikan);
$daftar_app_pendidikan = mysqli_fetch_array($seleksi_app_pendidikan);

//

$seleksi_app_security = mysqli_query($koneksi, "SELECT * FROM app WHERE kategori_app = 'app_security' && aktif = 'ya' LIMIT 1") or die("<script>alert('Query salah')</script>");
$jumlah_app_security = mysqli_num_rows($seleksi_app_security);
$daftar_app_security = mysqli_fetch_array($seleksi_app_security);

//

$seleksi_app_sport = mysqli_query($koneksi, "SELECT * FROM app WHERE kategori_app = 'app_sport' && aktif = 'ya' LIMIT 1") or die("<script>alert('Query salah')</script>");
$jumlah_app_sport = mysqli_num_rows($seleksi_app_sport);
$daftar_app_sport = mysqli_fetch_array($seleksi_app_sport);

//

$seleksi_video = mysqli_query($koneksi, "SELECT * FROM video WHERE dipakai = 'ya' LIMIT 1") or die("<script>alert('Query salah')</script>");
$jumlah_video = mysqli_num_rows($seleksi_video);
$daftar_video = mysqli_fetch_array($seleksi_video);

//

$seleksi_judul_header = mysqli_query($koneksi, "SELECT * FROM judul_header LIMIT 1") or die("<script>alert('Query salah')</script>");
$jumlah_judul_header = mysqli_num_rows($seleksi_judul_header);
$daftar_judul_header = mysqli_fetch_array($seleksi_judul_header);

//

$seleksi_partner = mysqli_query($koneksi, "SELECT * FROM partner WHERE urutan > 0 ORDER BY urutan ASC") or die("<script>alert('Query salah')</script>");
$jumlah_partner = mysqli_num_rows($seleksi_partner);

//

$seleksi_event_news = mysqli_query($koneksi, "
	SELECT event_news.*, event_news_kategori.* 
     FROM event_news 
     LEFT OUTER JOIN event_news_kategori 
     ON event_news.id_event_news_kategori = event_news_kategori.id_event_news_kategori
     WHERE event_news.urutan > 0
     ORDER BY event_news.urutan ASC LIMIT 4
	") or die("<script>alert('Query salah')</script>");
$jumlah_event_news = mysqli_num_rows($seleksi_event_news);

//

$seleksi_event_news1 = mysqli_query($koneksi, "
	SELECT event_news.*, event_news_kategori.* 
     FROM event_news 
     LEFT OUTER JOIN event_news_kategori 
     ON event_news.id_event_news_kategori = event_news_kategori.id_event_news_kategori
     WHERE event_news.urutan > 0
     ORDER BY event_news.urutan ASC LIMIT 4
	") or die("<script>alert('Query salah')</script>");
$jumlah_event_news1 = mysqli_num_rows($seleksi_event_news1);

//

$seleksi_event_news2 = mysqli_query($koneksi, "
	SELECT *
     FROM event_news 
     LEFT OUTER JOIN event_news_kategori 
     ON event_news.id_event_news_kategori = event_news_kategori.id_event_news_kategori
     WHERE event_news.urutan > 0
     ORDER BY event_news.urutan ASC LIMIT 4
	") or die("<script>alert('Query salah')</script>");
$jumlah_event_news2 = mysqli_num_rows($seleksi_event_news2);

$seleksi_event_news21 = mysqli_query($koneksi, "
     SELECT *
     FROM event_news 
     LEFT OUTER JOIN event_news_kategori 
     ON event_news.id_event_news_kategori = event_news_kategori.id_event_news_kategori
     WHERE event_news.urutan > 0
     ORDER BY event_news.urutan ASC LIMIT 5
     ") or die("<script>alert('Query salah')</script>");
$jumlah_event_news21 = mysqli_num_rows($seleksi_event_news2);

//

$seleksi_event_news3 = mysqli_query($koneksi, "
	SELECT *
     FROM event_news 
     LEFT OUTER JOIN event_news_kategori 
     ON event_news.id_event_news_kategori = event_news_kategori.id_event_news_kategori
     ORDER BY event_news.id_event_news DESC LIMIT 4
	") or die("<script>alert('Query salah')</script>");
$jumlah_event_news3 = mysqli_num_rows($seleksi_event_news3);

//

$seleksi_license_award = mysqli_query($koneksi, "SELECT * FROM license_award WHERE urutan > 0 ORDER BY urutan ASC") or die("<script>alert('Query salah')</script>");
$jumlah_license_award = mysqli_num_rows($seleksi_license_award);

//

$seleksi_testimoni = mysqli_query($koneksi, "SELECT * FROM testimoni WHERE urutan > 0 ORDER BY urutan ASC") or die("<script>alert('Query salah')</script>");
$jumlah_testimoni = mysqli_num_rows($seleksi_testimoni);

//

$seleksi_contact = mysqli_query($koneksi, "SELECT * FROM contact LIMIT 1") or die("<script>alert('Query salah')</script>");
$jumlah_contact = mysqli_num_rows($seleksi_contact);
$daftar_contact = mysqli_fetch_array($seleksi_contact);

//

$seleksi_social_footer = mysqli_query($koneksi, "SELECT * FROM social_footer LIMIT 1") or die("<script>alert('Query salah')</script>");
$jumlah_social_footer = mysqli_num_rows($seleksi_social_footer);
$daftar_social_footer = mysqli_fetch_array($seleksi_social_footer);

//

$seleksi_info = mysqli_query($koneksi, "SELECT * FROM info_web LIMIT 1") or die("<script>alert('Query salah')</script>");
$jumlah_info = mysqli_num_rows($seleksi_info);
$daftar_info = mysqli_fetch_array($seleksi_info);

//

$seleksi_cover_video = mysqli_query($koneksi, "SELECT * FROM cover_video WHERE used = 'ya' LIMIT 1") or die(mysqli_error());
$jumlah_cover_video = mysqli_num_rows($seleksi_cover_video);
$daftar_cover_video = mysqli_fetch_array($seleksi_cover_video);
$cover_video_dipakai = $daftar_cover_video['gambar_cover'];
$judul_cover_video_dipakai = $daftar_cover_video['judul_cover'];

//

$seleksi_event_news_kategori = mysqli_query($koneksi, "SELECT * FROM event_news_kategori") or die("<script>alert('Query salah')</script>");
$jumlah_event_news_kategori = mysqli_num_rows($seleksi_event_news_kategori);

//

$seleksi_event_news_kategori2 = mysqli_query($koneksi, "SELECT * FROM event_news_kategori") or die("<script>alert('Query salah')</script>");
$jumlah_event_news_kategori2 = mysqli_num_rows($seleksi_event_news_kategori2);

//

$seleksi_event_news_kategori3 = mysqli_query($koneksi, "SELECT * FROM event_news_kategori") or die("<script>alert('Query salah')</script>");
$jumlah_event_news_kategori3 = mysqli_num_rows($seleksi_event_news_kategori3);

?>