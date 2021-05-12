<?php
	$status_form = "";

	if(isset($_GET['status_form']) and $_GET['status_form'] == "berhasil" and isset($_GET['jenis_form']) and $_GET['jenis_form'] == "tambah"){
		$status_form = '<div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <strong><i class="fa fa-check-circle"></i> Berhasil,</strong> Data sudah ditambahkan.
          </div>';
	}
	elseif(isset($_GET['status_form']) and $_GET['status_form'] == "gagal" and isset($_GET['jenis_form']) and $_GET['jenis_form'] == "tambah"){
		$status_form = '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <strong><i class="fa fa-exclamation-triangle"></i> Gagal,</strong> Data tidak dapat ditambahkan. Hubungi programmer.
          </div>';
	}
	elseif(isset($_GET['status_form']) and $_GET['status_form'] == "berhasil" and isset($_GET['jenis_form']) and $_GET['jenis_form'] == "edit"){
		$status_form = '<div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <strong><i class="fa fa-check-circle"></i> Berhasil,</strong> Data sudah tersimpan.
          </div>';
	}
	elseif(isset($_GET['status_form']) and $_GET['status_form'] == "gagal" and isset($_GET['jenis_form']) and $_GET['jenis_form'] == "edit"){
		$status_form = '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <strong><i class="fa fa-exclamation-triangle"></i> Gagal,</strong> Data tidak dapat disimpan. Hubungi programmer.
          </div>';
	}
	elseif(isset($_GET['status_form']) and $_GET['status_form'] == "berhasil" and isset($_GET['jenis_form']) and $_GET['jenis_form'] == "hapus"){
		$status_form = '<div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <strong><i class="fa fa-check-circle"></i> Berhasil,</strong> Data sudah dihapus.
          </div>';
	}
	elseif(isset($_GET['status_form']) and $_GET['status_form'] == "gagal" and isset($_GET['jenis_form']) and $_GET['jenis_form'] == "hapus"){
		$status_form = '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <strong><i class="fa fa-exclamation-triangle"></i> Gagal,</strong> Data tidak dapat dihapus. Hubungi programmer.
          </div>';
	}
	elseif(isset($_GET['status_form']) and $_GET['status_form'] == "tidak_lengkap"){
		$status_form = '<div class="alert alert-warning">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <strong><i class="fa fa-exclamation-triangle"></i> Perhatian,</strong> Isi semua data dengan lengkap.
          </div>';
	}
	elseif(isset($_GET['status_form']) and $_GET['status_form'] == "tidak_ada_data"){
		$status_form = '<div class="alert alert-warning">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <strong><i class="fa fa-exclamation-triangle"></i> Data Tidak Ditemukan,</strong> Tidak ada data yang terpilih / data kosong.
          </div>';
	}
	elseif(isset($_GET['status_form']) and $_GET['status_form'] == "gambar_tidak_valid"){
		$status_form = '<div class="alert alert-warning">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <strong><i class="fa fa-exclamation-triangle"></i> Gambar tidak valid,</strong> Periksa lebar tinggi, jenis dan ukuran gambar.
          </div>';
	}
	elseif(isset($_GET['status_form']) and $_GET['status_form'] == "gagal_hapus_gambar"){
		$status_form = '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <strong><i class="fa fa-exclamation-triangle"></i> Gagal Hapus Gambar,</strong> Kemungkinan ada kesalahan gambar tidak dapat dihapus. Hubungi Programmer.
          </div>';
	}
	elseif(isset($_GET['status_form']) and $_GET['status_form'] == "gagal_hapus_video"){
		$status_form = '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <strong><i class="fa fa-exclamation-triangle"></i> Gagal Hapus Video,</strong> Kemungkinan ada kesalahan video tidak dapat dihapus. Hubungi Programmer.
          </div>';
	}
	elseif(isset($_GET['status_form']) and $_GET['status_form'] == "gagal_upload"){
		$status_form = '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <strong><i class="fa fa-exclamation-triangle"></i> Gagal Upload Image/Dokumen,</strong> Kemungkinan tidak bisa dipindahkan / folder tidak tersedia. Hubungi Programmer.
          </div>';
	}
	elseif(isset($_GET['status_form']) and $_GET['status_form'] == "sudah_ada"){
		$status_form = '<div class="alert alert-warning">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <strong><i class="fa fa-exclamation-triangle"></i> Data sudah ada,</strong> Jika keluar pesan ini, ada kesalahan di form. Hubungi Programmer.
          </div>';
	}
	elseif(isset($_GET['status_form']) and $_GET['status_form'] == "password_lama_tidak"){
		$status_form = '<div class="alert alert-warning">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <strong><i class="fa fa-unlock-alt"></i> Tidak Sama,</strong> Password lama tidak sama.
          </div>';
	}
	elseif(isset($_GET['status_form']) and $_GET['status_form'] == "password_lama_baru"){
		$status_form = '<div class="alert alert-warning">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <strong><i class="fa fa-unlock-alt"></i> Tidak Boleh Sama,</strong> Password lama tidak sama dengan Password baru.
          </div>';
	}
	elseif(isset($_GET['status_form']) and $_GET['status_form'] == "password_tidak_sama"){
		$status_form = '<div class="alert alert-warning">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <strong><i class="fa fa-unlock-alt"></i> Tidak Sama,</strong> Password Baru dengan Konfirm Password Baru tidak sama.
          </div>';
	}
	elseif(isset($_GET['status_form']) and $_GET['status_form'] == "bukan_superuser"){
		$status_form = '<div class="alert alert-warning">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <strong><i class="fa fa-unlock-alt"></i> Dilarang,</strong> Aksi ini hanya bisa dilakukan oleh SUPERUSER.
          </div>';
	}
	elseif(isset($_GET['status_form']) and $_GET['status_form'] == "level_harus_sesuai"){
		$status_form = '<div class="alert alert-warning">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <strong><i class="fa fa-warning"></i> Perhatian,</strong> Level harus sesuai dengan input level.
          </div>';
	}
	else{
		$status_form = "";
	}
?>