<?php 
session_start();

if(isset($_SESSION['id_user']) && isset($_SESSION['level'])){
	unset($_SESSION['id_user']);
	unset($_SESSION['level']);
?>

<script type="text/javascript">
	alert("Anda melakukan logout");
	document.location = "index.php";
</script>

<?php 
}
else{
?>
	<script type="text/javascript">
		alert("Login Dahulu Sebelum Masuk Halaman ini..");
		document.location = "index.php";
	</script>

<?php
}

?>