<!-- footer-section-starts-here -->

	<div class="footer">

		<!--<div class="footer-top">

			<div class="wrap">

				<div class="col-md-4 col-xs-6 col-sm-4 footer-grid">

					<h4 class="footer-head">About Us</h4>

					<?php echo $daftar_about_us['konten']; ?>;

				</div>

				<div class="col-md-2 col-xs-6 col-sm-4 footer-grid">

					<h4 class="footer-head">Categories</h4>

					<ul class="cat">
						<?php 
						if($jumlah_event_news_kategori3 > 0){
							while ($daftar_event_news_kategori3 = mysqli_fetch_array($seleksi_event_news_kategori3)) {
							    echo '<li><a href="kategori.php?id='.$daftar_event_news_kategori3['id_event_news_kategori'].'">app '.$daftar_event_news_kategori3['nama_event_news_kategori'].'</a></li>';
							}
						}
						else{
							echo '';
						}

						?>

					</ul>

                    </div>

				<div class="col-md-3 col-xs-6 col-sm-6 footer-grid">

					<h4 class="footer-head">Flickr Feed</h4>

					<ul class="flickr">

						<li><a href="#"><img src="images/gallery/k_buku.png"></a></li>

						<li><a href="#"><img src="images/gallery/k_fashion.png"></a></li>

						<li><a href="#"><img src="images/gallery/k_food.png"></a></li>

						<li><a href="#"><img src="images/gallery/k_home.png"></a></li>

						<li><a href="#"><img src="images/gallery/k_kesehatan.png"></a></li>

						<li><a href="#"><img src="images/gallery/k_office.png"></a></li>

						<li><a href="#"><img src="images/gallery/k_otomotif.png"></a></li>

						<li><a href="#"><img src="images/gallery/k_pendidikan.png"></a></li><li><a href="#"><img src="images/gallery/k_perkakas.png"></a></li><li><a href="#"><img src="images/gallery/k_gadget.png"></a></li>

                        <li><a href="#"><img src="images/gallery/k_security.png"></a></li>

                        <li><a href="#"><img src="images/gallery/k_sport.png"></a></li>

                        <li><a href="#"><img src="images/gallery/k_travel.png"></a></li>

                        <li><a href="#"><img src="images/gallery/k_ukm.png"></a></li>

						<div class="clearfix"></div>

					</ul>

				</div>

				<div class="col-md-3 col-xs-12 footer-grid">

					<h4 class="footer-head">Contact Us</h4>

					<span class="hq"><?php echo $daftar_judul_header['judul_header_office']; ?></span>

					<address>

						<ul class="location">

							<li><span class="glyphicon glyphicon-map-marker"></span></li>

							<li><?php echo $daftar_contact['alamat_gedung']; ?> <?php echo $daftar_contact['alamat_jalan']; ?> <?php echo $daftar_contact['alamat_daerah']; ?></li>

							<div class="clearfix"></div>

						</ul>	

						<ul class="location">

							<li><span class="glyphicon glyphicon-earphone"></span></li>

                            <li><a href="tel:<?php echo $daftar_contact['no_telp']; ?>"><?php echo $daftar_contact['no_telp']; ?></a></li>

							<div class="clearfix"></div>

						</ul>	

						<ul class="location">

							<li><span class="glyphicon glyphicon-envelope"></span></li>

							<li> <a href="mailto:<?php echo $daftar_contact['email']; ?>"><?php echo $daftar_contact['email']; ?></a></li>

							<div class="clearfix"></div>

						</ul>						

					</address>


					<span class="hq"><?php echo $daftar_judul_header['judul_header_warehouse']; ?></span>

					<address>

						<ul class="location">

							<li><span class="glyphicon glyphicon-map-marker"></span></li>

							<li><?php echo $daftar_contact['warehouse_jalan']; ?> <?php echo $daftar_contact['warehouse_wilayah']; ?> <?php echo $daftar_contact['warehouse_daerah']; ?></li>

							<div class="clearfix"></div>

						</ul>						

					</address>

				</div>

				<div class="clearfix"></div>

			</div>

		</div>-->

		<div class="footer-bottom">

			<div class="wrap">

				<div class="copyrights col-md-6">

					<p> &copy; <?php echo $daftar_judul_header['judul_header_footer']; ?>  </p>

				</div>

				<div class="footer-social-icons col-md-6">

					<ul>

                        <li><a href="<?php echo $daftar_social_footer['facebook_url']; ?>"><i class="fab fa-facebook-square" style="color: #3b5998;font-size: 30px;margin-top: 5px;"></i></a></li>

                        <li><a href="<?php echo $daftar_social_footer['twitter_url']; ?>"><i class="fab fa-twitter-square" style="color: #55acee;font-size: 30px;margin-top: 5px;"></i></a></li>

                        <li><a href="<?php echo $daftar_social_footer['instagram_url']; ?>"><i class="fab fa-instagram" style="color: #e95950;font-size: 30px;margin-top: 5px;"></i></a></li>

                        <li><a href="<?php echo $daftar_social_footer['linkedin_url']; ?>"><i class="fab fa-linkedin" style="color: #007bb5;font-size: 30px;margin-top: 5px;"></i></a></li>

                        <li><a href="<?php echo $daftar_social_footer['youtube_url']; ?>"><i class="fab fa-youtube" style="color: #ff0000;font-size: 30px;margin-top: 5px;"></i></a></li>

					</ul>

				</div>

				<div class="clearfix"></div>

			</div>

		</div>

	</div>

	<!-- footer-section-ends-here -->

	<script type="text/javascript">

		$(document).ready(function() {

				/*

				var defaults = {

				wrapID: 'toTop', // fading element id

				wrapHoverID: 'toTopHover', // fading element hover id

				scrollSpeed: 1200,

				easingType: 'linear' 

				};

				*/

		$().UItoTop({ easingType: 'easeOutQuart' });

});

</script>

<a href="#to-top" id="toTop" style="display: block;"> <span id="toTopHover" style="opacity: 0.5;"> </span></a>

<!---->

</body>

</html>