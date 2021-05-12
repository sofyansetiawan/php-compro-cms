<?php 
if(isset($_SESSION['id_user']) && isset($_SESSION['level'])){

}
else{
	echo "<script>alert('Anda tidak mempunyai akses untuk halaman ini.')</script>";
	echo "<script>window.location.href='index.php';</script>";
}
?>