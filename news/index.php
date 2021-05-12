<?php
include_once "../setting/database.php";
include_once "../setting/seleksi_data_front.php";

$title = "website - Event & News | ".$daftar_info['title_website'];
include_once "header.php";
?>
<!-- content-section-starts-here -->

<link rel="stylesheet" href="css/vertical.news.slider.css">
<script src="js/vertical.news.slider.min.js"></script>

<style type="text/css">
	.news-headlines .highlight{
	    border-right: solid 1px #999;
	    border-left: solid 0px transparent;
	    left: -2px;
    }
	.news-holder{
		float: right;
		margin-top: 20px;
		width: 30%;
		max-width: none;
	}

	.news-preview{
		margin-top: 20px;
		width: 70%;
		min-height: 375px;
		box-shadow: 7px 7px 12px -10px #000;
	}
	.news-headlines{
		width: 100%;
	}
	.news-content p{
		text-align: justify;
	}
	.news-content img{
		max-height: 300px;
		max-width: 400px;
	}
	.news-content a:has(img){
		margin-right: 20px;
	}
	.news-headlines li{
		font-size: 16px;
	}
	.news-head{
		padding: 0 30px;
	}
	.news-content{
		background: transparent;
	}
	li.highlight.nh-anim {
    	box-shadow: 7px 7px 12px -10px #000;
	}
</style>

<div class="main-body">
	<div class="wrap">
		<div class="col-md-12">
			<div class="articles articles1">
				<header>
					<h3 class="title-head">Headline</h3>
				</header>

				<div class="news-head">
					<div class="news-holder">
						<ul class="news-headlines">
							<?php
								$i = 0; 
								while ($daftar_event_news2 = mysqli_fetch_array($seleksi_event_news2) ) {
									if($i <= 0){
								?>
							      <li class="selected"><?php echo $daftar_event_news2['judul_event_news']; ?></li>
								<?php
									}
									else{
								?>
									<li><?php echo $daftar_event_news2['judul_event_news']; ?></li>
								<?php
									}
									$i++;
								}
							?>
						<!-- li.highlight gets inserted here -->
						</ul>
					</div>


					<div class="news-preview">
						<?php
								$i = 0; 
								while ($daftar_event_news21 = mysqli_fetch_array($seleksi_event_news21) ) {
									if($i <= 0){
								?>
							      <div class="news-content top-content row">
							      	<div class="col-md-5">
						        		<a class="title" href="post.php?id=<?php echo $daftar_event_news21['id_event_news']; ?>&kat=<?php echo $daftar_event_news21['id_event_news_kategori']; ?>"><img src="../upload/image/event_news/<?php echo $daftar_event_news21['image_event_news']; ?>" onError="this.onerror=null;this.src='../images/no_image/no-news.png';" alt="" /></a>
						        	</div>
						        	<div class="col-md-7">
							        	<p>
							        		<a class="title" href="post.php?id=<?php echo $daftar_event_news21['id_event_news']; ?>&kat=<?php echo $daftar_event_news21['id_event_news_kategori']; ?>">
							        			<?php echo $daftar_event_news21['judul_event_news']; ?>
							        		</a>
							        	</p>
							        	<p>
							        		<?php echo substr(strip_tags($daftar_event_news21['konten_event_news']), 0, 480); ?>[...]<br>
							        		<a href="post.php?id=<?php echo $daftar_event_news21['id_event_news']; ?>&kat=<?php echo $daftar_event_news21['id_event_news_kategori']; ?>"><span class="label label-warning">Selengkapnya »</span></a>
							        	</p>
						        	</div>
						      	</div>
								<?php
									}
									else{
								?>
									<div class="news-content row">
										<div class="col-md-6">
							        		<a class="title" href="post.php?id=<?php echo $daftar_event_news21['id_event_news']; ?>&kat=<?php echo $daftar_event_news21['id_event_news_kategori']; ?>"><img src="../upload/image/event_news/<?php echo $daftar_event_news21['image_event_news']; ?>" onError="this.onerror=null;this.src='../images/no_image/no-news.png';" alt="" /></a>
							        	</div>
							        	<div class="col-md-6">
								        	<p>
								        		<a class="title" href="post.php?id=<?php echo $daftar_event_news21['id_event_news']; ?>&kat=<?php echo $daftar_event_news21['id_event_news_kategori']; ?>">
								        			<?php echo $daftar_event_news21['judul_event_news']; ?>
								        		</a>
								        	</p>
								        	<p>
								        		<?php echo substr(strip_tags($daftar_event_news21['konten_event_news']), 0, 480); ?>[...]<br>
							        		<a href="post.php?id=<?php echo $daftar_event_news21['id_event_news']; ?>&kat=<?php echo $daftar_event_news21['id_event_news_kategori']; ?>"><span class="label label-warning">Selengkapnya »</span></a>
								        	</p>
							        	</div>
							      	</div>
								<?php
									}
									$i++;
								}
							?>
					</div>
					<div style="clear:both"></div>
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="articles">
			<header>
				<h3 class="title-head">Event & News Up To Date</h3>
			</header>
			<div class="tech-main">

				<?php
                 if ($jumlah_event_news3 > 0) {
                    while($daftar_event_news3 = mysqli_fetch_array($seleksi_event_news3)){
                ?>
				<div class="tech tech1">
					<a href="post.php?id=<?php echo $daftar_event_news3['id_event_news']; ?>&kat=<?php echo $daftar_event_news3['id_event_news_kategori']; ?>"><img src="../upload/image/event_news/<?php echo $daftar_event_news3['image_event_news']; ?>" onError="this.onerror=null;this.src='../images/no_image/no-news.png';" alt="" /></a>
					<a href="post.php?id=<?php echo $daftar_event_news3['id_event_news']; ?>&kat=<?php echo $daftar_event_news3['id_event_news_kategori']; ?>" class="power"><?php echo $daftar_event_news3['judul_event_news']; ?></a>
				</div>
				<?php
				}
				} 
				else{
                ?>
                <div class="tech">
                	<h1 class="text-center">Tidak ada Berita</h1>
                </div>
                <?php
                }
                ?>
				
				<div class="clearfix"></div>
			</div>
		</div>
		<div class="sports-top">
			<div class="row">

				<?php 
					if($jumlah_event_news_kategori > 0){

						while ($daftar_event_news_kategori2 = mysqli_fetch_array($seleksi_event_news_kategori2)) {

							echo '<div class="col-md-4" style="min-height:450px;margin: 0 0px -3% 0%;">
						<div class="cricket">
							<header>
								<h3 class="title-head">'.$daftar_event_news_kategori2["nama_event_news_kategori"].'</h3>
							</header>';

							$seleksi_event_news4 = mysqli_query($koneksi, "
								SELECT event_news.*, event_news_kategori.* 
							     FROM event_news 
							     LEFT JOIN event_news_kategori 
							     ON event_news.id_event_news_kategori = event_news_kategori.id_event_news_kategori
							     WHERE event_news_kategori.id_event_news_kategori = '$daftar_event_news_kategori2[id_event_news_kategori]' && event_news.urutan > 0 LIMIT 2
								") or die("<script>alert('Query salah')</script>");

							$jumlah_event_news4 = mysqli_num_rows($seleksi_event_news4);

							if($jumlah_event_news4 > 0){
								while ($daftar_event_news4 = mysqli_fetch_array($seleksi_event_news4)) {
									if(isset($daftar_event_news4['id_event_news_kategori'])){
								    echo '<div class="s-grid-small">
											<div class="sc-image">
												<a href="post.php?id='.$daftar_event_news4["id_event_news"].'&kat='.$daftar_event_news4['id_event_news_kategori'].'"><img src="../upload/image/event_news/'.$daftar_event_news4['image_event_news'].'" alt=""  onError="this.onerror=null;this.src=\'../images/no_image/no-news.png\';"></a>
											</div>
											<div class="sc-text">';

									$date = date_create($daftar_event_news4['tanggal_event_news']); 

									echo '
												<a class="power" href="post.php?id='.$daftar_event_news4["id_event_news"].'&kat='.$daftar_event_news4['id_event_news_kategori'].'">'.$daftar_event_news4['judul_event_news'].'</a>
												<p class="date">'.date_format($date, "D, M jS, Y").'</p>
												<a class="reu" href="post.php?id='.$daftar_event_news4["id_event_news"].'"><img src="images/more.png" alt=""></a>
												<div class="clearfix"></div>
											</div>
											<div class="clearfix"></div>
										</div>';
									}
								}
							}
							else{
								 echo '<div class="s-grid-small">';
								echo '<h4 class="text-muted"><em>Tidak Ada Post</em></h4>';
								echo "</div>";
							}

							echo '</div></div>';

						}
					}

					?>

				
			</div>
		</div>
	</div>
	<!-- content-section-ends-here -->
	<?php
	include_once "footer.php";
	?>
