<?php 

	define('DB_SERVER', 'localhost');

	define('DB_USERNAME', 'eapp_admin');

	define('DB_PASSWORD', 'comproapp2018');

	define('DB_DATABASE', 'eapp_compro');



	$koneksi = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

	$database = mysqli_select_db($koneksi, DB_DATABASE);

?>