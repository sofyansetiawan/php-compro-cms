<?php
include_once "../setting/database.php";
include_once "../setting/seleksi_data_front.php";
$title = $daftar_info['title_website'];
if(isset($_GET['id']) || isset($_GET['id'])){
	$id_kategori = trim(strip_tags(mysqli_real_escape_string($koneksi, $_GET['id'])));
	$status = "";

	$seleksi_kategori = mysqli_query($koneksi, "SELECT * FROM event_news_kategori WHERE id_event_news_kategori = '$id_kategori'") or die("<script>alert('Query salah')</script>");

	$jumlah_kategori = mysqli_num_rows($seleksi_kategori);

	if($jumlah_kategori == 0){
		$status = '<div class="well text-center text-warning lead"><span class="glyphicon glyphicon-exclamation-sign"></span> Kategori Tidak Ditemukan, <a href="index.php">Ke Home</a></div>';
	}
	else {
		$daftar_kategori = mysqli_fetch_array($seleksi_kategori);
		$title = "Kategori: ".$daftar_kategori['nama_event_news_kategori']." | ".$daftar_info['title_website'];
	}
}
else{
	$status = '<div class="well text-center text-warning lead"><span class="glyphicon glyphicon-exclamation-sign"></span> Pilih Salah Satu Kategori Untuk Mendapatkan Postingan-Postingan Yang Terkait, <a href="index.php">Ke Home</a></div>';
}

include_once "header.php";
?>
<!-- content-section-starts-here -->

<?php 
	if(isset($daftar_kategori['id_event_news_kategori'])){
?>
<div class="main-body">
	<div class="wrap">
		<ol class="breadcrumb">

			  <li><a href="index.php">Home</a></li>

			  <li class="active"><?php echo $daftar_kategori['nama_event_news_kategori']; ?></li>

			</ol>

		<div class="articles">
			<header>
				<h3 class="title-head">
				<?php
				if(isset($daftar_kategori['nama_event_news_kategori'])) {
					echo $daftar_kategori['nama_event_news_kategori'];
				}
				?>
				</h3>
			</header>
			<div class="tech-main">
				<?php
				$seleksi_event_news3 = mysqli_query($koneksi, "
								SELECT event_news.*, event_news_kategori.*
							FROM event_news
							LEFT JOIN event_news_kategori
							ON event_news.id_event_news_kategori = event_news_kategori.id_event_news_kategori
							WHERE event_news_kategori.id_event_news_kategori = '$daftar_kategori[id_event_news_kategori]' && event_news.urutan > 0
				") or die("<script>alert('Query salah')</script>");
				if ($jumlah_event_news3 > 0) {
				while($daftar_event_news3 = mysqli_fetch_array($seleksi_event_news3)){
				?>

				<div class="col-md-6" style="min-height: 250px;">
					<div class="s-grid-small">
						<div class="sc-image">
							<a href="post.php?id=<?php echo $daftar_event_news3['id_event_news']; ?>&kat=<?php echo $id_kategori; ?>"><img src="../upload/image/event_news/<?php echo $daftar_event_news3['image_event_news']; ?>" alt="" onerror="this.onerror=null;this.src='../images/no_image/no-news.png';"></a>
						</div>
						<div class="sc-text">
							<a class="power" href="post.php?id=<?php echo $daftar_event_news3['id_event_news']; ?>&kat=<?php echo $id_kategori; ?>"><?php echo $daftar_event_news3['judul_event_news']; ?><br><small><blockquote><?php echo $daftar_event_news3['sub_judul_event_news']; ?></blockquote></small></a>
							<div class="article-text" style="margin-top: 10px;">
								<?php echo substr(strip_tags($daftar_event_news3['konten_event_news']), 0, 300);
								echo '[...]'; ?>
							</div>
							<p class="date">
								<?php
									$date = date_create($daftar_event_news3['tanggal_event_news']);
									echo date_format($date, "D, M jS, Y");
								?>
							</p>
							<a class="reu" href="post.php?id=<?php echo $daftar_event_news3['id_event_news']; ?>&kat=<?php echo $id_kategori; ?>"><img src="images/more.png" alt=""></a>
							<div class="clearfix"></div>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>

				<?php
				}
				}
				elseif($jumlah_event_news3 == 0){
				?>
				<div class="tech tech1">
					<h1 class="text-center">Tidak ada Berita</h1>
				</div>
				<?php
				}
				?>
				
				<div class="clearfix"></div>
			</div>
		</div>
	</div>

	<?php } ?>
	<!-- content-section-ends-here -->
	<?php
	include_once "footer.php";
	?>