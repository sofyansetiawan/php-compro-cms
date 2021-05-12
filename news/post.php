<?php
include_once "../setting/database.php";
include_once "../setting/seleksi_data_front.php";
$title = $daftar_info['title_website'];
if((isset($_GET['id']) || !empty($_GET['id'])) && (isset($_GET['kat']) || !empty($_GET['kat']))){
	$id_event_news = trim(strip_tags(mysqli_real_escape_string($koneksi, $_GET['id'])));
	$id_kategori = trim(strip_tags(mysqli_real_escape_string($koneksi, $_GET['kat'])));

	$status = "";

	$seleksi_news = mysqli_query($koneksi, "
		SELECT event_news.*, event_news_kategori.* FROM event_news
		LEFT JOIN event_news_kategori
		ON event_news.id_event_news_kategori = event_news_kategori.id_event_news_kategori
		WHERE event_news.id_event_news= '$id_event_news' && event_news.id_event_news_kategori = '$id_kategori' LIMIT 1
		") or die("<script>alert('Query salah 1')</script>");

	$jumlah_news = mysqli_num_rows($seleksi_news);

	if($jumlah_news == 0){
		$status = '<div class="well text-center text-warning lead"><span class="glyphicon glyphicon-exclamation-sign"></span> Postingan Tidak Ditemukan, <a href="index.php">Ke Home</a></div>';
	}
	else {
		$daftar_news = mysqli_fetch_array($seleksi_news);
		$title = $daftar_news['judul_event_news']." | ".$daftar_info['title_website'];
	}
}
else{
	$status = '<div class="well text-center text-warning lead"><span class="glyphicon glyphicon-exclamation-sign"></span> Pilih Salah Satu Postingan Untuk Mendapatkan Konten Event dan News, <a href="index.php">Ke Home</a></div>';
}

include_once "header.php";
?>
<!-- content-section-starts-here -->

<?php 
	if(isset($daftar_news['id_event_news'])){
?>
	<div class="main-body">

		<div class="wrap">

		<ol class="breadcrumb">

			  <li><a href="index.php">Home</a></li>

			  <li><a href="kategori.php?id=<?php echo $daftar_news['id_event_news_kategori']; ?>"><?php echo $daftar_news['nama_event_news_kategori']; ?></a></li>

			  <li class="active"><?php echo $daftar_news['judul_event_news']; ?></li>

			</ol>

			<div class="single-page">

			<div class="col-md-2 share_grid">

				<script type="text/javascript" src="//platform-api.sharethis.com/js/sharethis.js#property=5aa8a1cca0a3350013d76f9e&product=sticky-share-buttons"></script>

			</div>	

			<div class="col-md-8 content-left single-post">

				<div class="blog-posts">

			<h3 class="post"><?php echo $daftar_news['judul_event_news']; ?></h3>
			<h5 class="post"><blockquote><?php echo $daftar_news['sub_judul_event_news']; ?></blockquote></h5>

				<div class="last-article">

					<p class="artext"><img <img src="../upload/image/event_news/<?php echo $daftar_news['image_event_news']; ?>" alt="" onerror="this.onerror=null;this.src='../images/no_image/no-news.png';"></p>

					<p class="artext"><?php echo $daftar_news['konten_event_news']; ?></p>

					<div class="clearfix"></div>

					<!--related-posts-->

				<div class="row related-posts">

					<h4>Postingan Terkait</h4>

					<?php 

						$seleksi_news_lain = mysqli_query($koneksi, "
							SELECT event_news.*, event_news_kategori.* FROM event_news
							LEFT JOIN event_news_kategori
							ON event_news.id_event_news_kategori = event_news_kategori.id_event_news_kategori
							WHERE event_news.id_event_news != '$id_event_news' && event_news.id_event_news_kategori = '$id_kategori' LIMIT 4
							") or die("<script>alert('Query salah 2')</script>");
						$jumlah_news_lain = mysqli_num_rows($seleksi_news_lain);

						if($jumlah_news_lain > 0){
							while ($daftar_news_lain = mysqli_fetch_array($seleksi_news_lain)) {
						?>


						<div class="col-xs-6 col-md-3 related-grids">

							<a href="post.php?id=<?php echo $daftar_news_lain['id_event_news']; ?>&kat=<?php echo $daftar_news_lain['id_event_news_kategori']; ?>" class="thumbnail">

								<img src="../upload/image/event_news/<?php echo $daftar_news_lain['image_event_news']; ?>" alt=""  onerror="this.onerror=null;this.src='../images/no_image/no-news.png';" />

							</a>

							<h5><a href="post.php?id=<?php echo $daftar_news_lain['id_event_news']; ?>&kat=<?php echo $daftar_news_lain['id_event_news_kategori']; ?>"><?php echo $daftar_news_lain['judul_event_news']; ?></a></h5>

						</div>

						<?php    
							}
						}
						else{
						?>

						<div class="col-xs-6 col-md-3 related-grids">

							<h5 class="text-muted">Tidak Ada Postingan terkait..</h5>

						</div>

						<?php

						}

					?>


				</div>

				<!--//related-posts-->


				<div class="clearfix"></div>

			</div>

		</div>
				<div class="fb-comments" data-href="http://website.com/news" data-width="100%" data-numposts="5"></div>


				</div>

			

			<div class="clearfix"></div>

		</div>

		</div>

	</div>
	<?php 
		}
	?>
	<!-- content-section-ends-here -->
	<?php
	include_once "footer.php";
	?>