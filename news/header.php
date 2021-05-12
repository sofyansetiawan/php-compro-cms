<!DOCTYPE html>

<html>

<head>

<title><?php echo $title; ?></title>

<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->

<script src="js/jquery.min.js"></script>

<!-- Custom Theme files -->

<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />

<link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">

<!-- Custom Theme files -->

<meta name="viewport" content="width=device-width, initial-scale=1">

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?php
if($jumlah_info > 0){
echo '<link rel="shortcut icon" href="../upload/image/favicon/'.$daftar_info["favicon"].'">';
}
else{
echo '<link rel="shortcut icon" href="favicon.png">';
}
?>

<meta name="description" content="<?php echo $daftar_info['deskripsi']; ?>">
<meta name="LuckyDev" content="<?php echo $daftar_info['title_website']; ?>">
<meta name="keywords" content="<?php echo $daftar_info['keyword']; ?>">
<meta name="author" content="<?php echo $daftar_info['author']; ?>">

<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>

<!-- for bootstrap working -->

	<script type="text/javascript" src="js/bootstrap.js"></script>

<!-- //for bootstrap working -->

<!-- web-fonts -->

<link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>

<link href='//fonts.googleapis.com/css?family=Varela+Round' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
     
</style>
<script src="js/responsiveslides.min.js"></script>

	<script>

		$(function () {

		  $("#slider").responsiveSlides({

			auto: true,

			nav: true,

			speed: 500,

			namespace: "callbacks",

			pager: true,

		  });

		});

	</script>

	<script type="text/javascript" src="js/move-top.js"></script>

<script type="text/javascript" src="js/easing.js"></script>

<!--/script-->

<script type="text/javascript">

			jQuery(document).ready(function($) {

				$(".scroll").click(function(event){

					event.preventDefault();

					$('html,body').animate({scrollTop:$(this.hash).offset().top},900);

				});

			});

</script>

<script type='text/javascript' src='//platform-api.sharethis.com/js/sharethis.js#property=5aa8a1cca0a3350013d76f9e&product=sticky-share-buttons' async='async'></script>
</head>

<body>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/id_ID/sdk.js#xfbml=1&version=v2.12&appId=197815214149768&autoLogAppEvents=1';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

	<!-- header-section-starts-here -->

	<div class="header">

		<div class="header-top">

			<div class="wrap">

				<div class="top-menu">

					<ul>

						<li><a href="../index.php">app Group</a></li>

					</ul>

				</div>

				<div class="num">

                    <p> Call us : <a href="tel:+62217972660" style="color: #dddddd;text-decoration: none;">(021) 7972660</a></p>

				</div>

				<div class="clear"></div>

			</div>

		</div>

		<div class="header-bottom hap" style="background: #fd4500;height: 97px;">
			
			<div class="logo text-center h-pad">
				<?php
				if($jumlah_logo == 1){
				?>
				<a href="index.php"><img src="../upload/image/logo/<?php echo $gambar_logo_dipakai; ?>" onError="this.onerror=null;this.src='images/no_image/no-logo.png';" alt="<?php echo $judul_logo_dipakai; ?>" class="rtoooo"></a>
				<?php
				}
				else{
				?>
				<a href="index.php"><img src="images/no_image/no_logo.png" alt="Site Logo" class="rtoooo"></a>
				<?php
				}
				?>
			</div>
			<div class="topnav-new" id="mytopnav-new">

			  <?php
					$jum = 0;
					if($jumlah_event_news_kategori > 0){
						while ($daftar_event_news_kategori = mysqli_fetch_array($seleksi_event_news_kategori)) {
							if($jum < 8){
								echo '<a href="kategori.php?id='.$daftar_event_news_kategori['id_event_news_kategori'].'">'.$daftar_event_news_kategori['nama_event_news_kategori'].'</a>';
							}
							else{
								if($jum == 8){
									echo '<div class="dropdown-new"><button class="dropbtn">Kategori Lain <i class="fa fa-caret-down"></i></button><div class="dropdown-new-content">';
								}
								echo '<a href="kategori.php?id='.$daftar_event_news_kategori['id_event_news_kategori'].'">'.$daftar_event_news_kategori['nama_event_news_kategori'].'</a>';
								if($jum == $jumlah_event_news_kategori-1){
									echo '</div>';
								}
							}

							$jum++;
						}
					}
					else{
						echo '';
					}
					?>
					</div>

			  <a href="javascript:void(0);" style="font-size:15px;" class="icon" onclick="myFunction()">&#9776;</a>
			<div class="clear"></div>
 
            <div class="search-box">

				    

						<form action="search.php" method="get">

							<input class="top-search-custom-ex" style="" placeholder="Enter your search term..." type="search" name="cari" id="search">

							<input class="top-button-unfix" style="" type="submit" value="">

<!--							<span class="sb-icon-search"> </span>-->

						</form>

					
				</div>

				<script src="js/classie.js"></script>

				<script src="js/uisearch.js"></script>

				<script>

					new UISearch( document.getElementById( 'sb-search' ) );

				</script>
			</div>

<script>
function myFunction() {
var x = document.getElementById("mytopnav-new");
if (x.className === "topnav-new") {
	x.className += " responsive";
} else {
	x.className = "topnav-new";
}
}
</script>	

</div>


	<!-- header-section-ends-here -->
<div class="clear"></div>
	<div class="wrap">

		<div class="move-text">

			<div class="breaking_news">

				<h2>Breaking News</h2>

			</div>

			<div class="marquee">

				<?php
					if($jumlah_event_news1 > 0){
						while ($daftar_event_news1 = mysqli_fetch_array($seleksi_event_news1)) {
						    echo '<div class="marquee1"><a class="breaking" href="post.php?id='.$daftar_event_news1['id_event_news'].'&kat='.$daftar_event_news1['id_event_news_kategori'].'">'.$daftar_event_news1['judul_event_news'].'</a></div>';
						}
					}
					else{
						echo '<div class="marquee1"><a class="breaking">Sorry no breaking news today..</a></div>';
					}

					?>

				<div class="clearfix"></div>

			</div>

			<div class="clearfix"></div>

			<script type="text/javascript" src="js/jquery.marquee.min.js"></script>

			<script>

			  $('.marquee').marquee({
			  	pauseOnHover: true,
			  	duration: 15000,
			  	gap: 100
			  });

			  //@ sourceURL=pen.js

			</script>

		</div>

	</div>

	<?php

	if(isset($status)){
		echo $status;
	}

	?>
