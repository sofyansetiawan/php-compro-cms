<?php
include_once "../setting/database.php";
include_once "../setting/seleksi_data_front.php";
$title = $daftar_info['title_website'];
if(isset($_GET['cari']) || empty($_GET['cari'])){

	$dicari = trim(strip_tags(mysqli_real_escape_string($koneksi, $_GET['cari'])));

	$seleksi_dicari = mysqli_query($koneksi, "
		SELECT event_news.*, event_news_kategori.* FROM event_news
		LEFT OUTER JOIN event_news_kategori 
		ON event_news.id_event_news_kategori = event_news_kategori.id_event_news_kategori
		WHERE event_news.judul_event_news LIKE '%$dicari%' OR event_news.sub_judul_event_news LIKE '%$dicari%' OR event_news.konten_event_news LIKE '%$dicari%' OR event_news.author_event_news LIKE '%$dicari%' OR event_news_kategori.nama_event_news_kategori LIKE '%$dicari%'
		ORDER BY event_news.judul_event_news ASC") or die("<script>alert('Query salah 1')</script>");;

	$jumlah_dicari = mysqli_num_rows($seleksi_dicari);

	if($jumlah_dicari == 0){
		$status = '<div class="well text-center text-warning lead"><span class="glyphicon glyphicon-exclamation-sign"></span> Pencarian Tidak Ditemukan, <a href="index.php">Ke Home</a></div>';
	}
	else {
		$daftar_dicari = mysqli_fetch_array($seleksi_dicari);
		$title = "Pencarian: ".$dicari." | ".$daftar_info['title_website'];
	}
}
else{
	$status = '<div class="well text-center text-warning lead"><span class="glyphicon glyphicon-exclamation-sign"></span> Isilah Form Pencarian Untuk Mendapatkan Konten Postingan-Postingan Yang Terkait, <a href="index.php">Ke Home</a></div>';
}

include_once "header.php";
?>

<?php 
	if(isset($daftar_dicari['id_event_news'])){
?>
<!-- content-section-starts-here -->
<div class="main-body">
	<div class="wrap">

		<div class="articles">
			<header>
				<h3 class="title-head">
				<?php
				$judul_cari = "<span class='glyphicon glyphicon-search'></span> Hasil Pencarian : \"".$dicari."\"";
				echo $judul_cari;
				?>
				</h3>
			</header>
			<div class="tech-main">
				<?php
				while($daftar_dicari = mysqli_fetch_array($seleksi_dicari)){
				?>

				<div class="col-md-6" style="min-height: 250px;">
					<div class="s-grid-small">
						<div class="sc-image">
							<a href="post.php?id=<?php echo $daftar_dicari['id_event_news']; ?>&kat=<?php echo $daftar_dicari['id_event_news_kategori']; ?>"><img src="../upload/image/event_news/<?php echo $daftar_dicari['image_event_news']; ?>" alt="" onerror="this.onerror=null;this.src='../images/no_image/no-news.png';"></a>
						</div>
						<div class="sc-text">
							<a class="power" href="post.php?id=<?php echo $daftar_dicari['id_event_news']; ?>&kat=<?php echo $daftar_dicari['id_event_news_kategori']; ?>"><?php echo $daftar_dicari['judul_event_news']; ?><br><small><blockquote><?php echo $daftar_dicari['sub_judul_event_news']; ?></blockquote></small></a>
							<div class="article-text" style="margin-top: 10px;">
								<?php echo substr(strip_tags($daftar_dicari['konten_event_news']), 0, 300);
								echo '[...]'; ?>
							</div>
							<p class="date">
								<?php
									$date = date_create($daftar_dicari['tanggal_event_news']);
									echo date_format($date, "D, M jS, Y");
								?>
							</p>
							<a class="reu" href="post.php?id=<?php echo $daftar_dicari['id_event_news']; ?>&kat=<?php echo $daftar_dicari['id_event_news_kategori']; ?>"><img src="images/more.png" alt=""></a>
							<div class="clearfix"></div>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
				<?php } ?>
				
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
	<?php } ?>
	<!-- content-section-ends-here -->
	<?php
	include_once "footer.php";
	?>