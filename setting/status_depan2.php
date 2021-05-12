<?php 
if(isset($_SESSION['id_user']) && isset($_SESSION['level'])){
	echo "<script>alert('Anda sudah login.')</script>";
	echo "<script>window.location.href='admin/dashboard.php';</script>";
}
else{

}
?>