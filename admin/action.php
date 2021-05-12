<?php
session_start();
include_once "../setting/setting.php";

include_once '../setting/database.php';

include_once "../setting/status_session.php";

if($_SESSION['level'] == 'superuser' || $_SESSION['level'] == 'admin' || $_SESSION['level'] == 'marketing'){
    // Tambah video Tambah
    if (isset($_POST['video_tambah']))
    {
        if (isset($_POST['judul_video']) && isset($_FILES['file_video']) && !$_FILES['file_video']['error'])
        {
            $video_status = "";
            if (isset($_POST['dipakai']) && $_POST['dipakai'] == 1)
            {
                $video_status = 'ya';
            }
            else
            {
                $video_status = 'tidak';
            }

            $valid_file = true;
            $max_size = 5000000;
            $judul_video = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['judul_video'])));
            $file_video_file = $_FILES['file_video']['name'];
            $temp_video_file = $_FILES['file_video']['tmp_name'];
            $ukuran_video_file = $_FILES['file_video']['size'];
            $jenis_video = strtolower(pathinfo($file_video_file, PATHINFO_EXTENSION));
            if ($ukuran_video_file > $max_size)
            {
                $valid_file = false;
            }

            if ($jenis_video != "mp4")
            {
                $valid_file = false;
            }

            $videobaru = date('dmYHis') . "_" . strtolower(str_replace(' ', '_', $file_video_file));
            $path = "../upload/video/" . $videobaru;
            if (!empty($judul_video))
            {
                if ($valid_file == true)
                {
                    if (move_uploaded_file($temp_video_file, $path))
                    {
                        if ($video_status == "ya")
                        {
                            $update = mysqli_query($koneksi, "UPDATE video SET dipakai = 'tidak' WHERE video.id_video > 0") or die(mysqli_error());
                            $input = mysqli_query($koneksi, "INSERT INTO video VALUES (NULL, '$judul_video', '$videobaru', '$video_status')") or die(mysqli_error());
                            if ($input == true && $update)
                            {
                                header("location: video_tambah.php?status_form=berhasil&jenis_form=tambah");
                            }
                            else
                            {
                                header("location: video_tambah.php?status_form=gagal&jenis_form=tambah");
                            }

                            $input = null;
                            $update = null;
                        }
                        else
                        {
                            $input = mysqli_query($koneksi, "INSERT INTO video VALUES (NULL, '$judul_video', '$videobaru', '$video_status')") or die(mysqli_error());
                            if ($input == true)
                            {
                                header("location: video_tambah.php?status_form=berhasil&jenis_form=tambah");
                            }
                            else
                            {
                                header("location: video_tambah.php?status_form=gagal&jenis_form=tambah");
                            }

                            $input = null;
                        }
                    }
                    else
                    {
                        header("location: video_tambah.php?status_form=gagal_upload");
                    }
                }
                else
                {
                    header("location: video_tambah.php?status_form=gambar_tidak_valid");
                }
            }
            else
            {
                header("location: video_tambah.php?status_form=tidak_lengkap&b");
            }
        }
        else
        {
            header("location: video_tambah.php?status_form=tidak_lengkap&a");
        }
    }

    if (isset($_POST['video_edit']))
    {
        if (isset($_POST['judul_video']) && isset($_POST['id']) && isset($_FILES['file_video']))
        {
            $video_status = "";
            if (isset($_POST['dipakai']) && $_POST['dipakai'] == 1)
            {
                $video_status = 'ya';
            }
            else
            {
                $video_status = 'tidak';
            }

            $max_size = 5000000;
            $id = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['id'])));
            $judul_video = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['judul_video'])));
            $file_video_file = $_FILES['file_video']['name'];
            $temp_video_file = $_FILES['file_video']['tmp_name'];
            $ukuran_video_file = $_FILES['file_video']['size'];
            if (!empty($file_video_file) && !empty($temp_video_file))
            {
                $valid_file = true;
                $jenis_video = strtolower(pathinfo($file_video_file, PATHINFO_EXTENSION));
                if ($ukuran_video_file > $max_size)
                {
                    $valid_file = false;
                }

                if ($jenis_video != "mp4")
                {
                    $valid_file = false;
                }

                $videobaru = date('dmYHis') . "_" . strtolower(str_replace(' ', '_', $file_video_file));
                $path = "../upload/video/" . $videobaru;
            }

            if (!empty($judul_video))
            {
                if ($video_status == "ya")
                {
                    if (!empty($file_video_file) && !empty($temp_video_file))
                    {
                        if ($valid_file == true)
                        {
                            if (move_uploaded_file($temp_video_file, $path))
                            {
                                $cek_file_video = mysqli_query($koneksi, "SELECT file_video FROM video WHERE id_video = '$id' LIMIT 1") or die(mysqli_error());
                                if (mysqli_num_rows($cek_file_video) == 1)
                                {
                                    while ($daftar_video = mysqli_fetch_array($cek_file_video))
                                    {
                                        $hapus_video = $daftar_video['file_video'];
                                        if (file_exists("../upload/video/" . $hapus_video))
                                        {
                                            unlink("../upload/video/" . $hapus_video);
                                        }
                                        else
                                        {
                                            header("location: video.php?status_form=gagal_hapus_video");
                                        }
                                    }
                                }
                                else
                                {
                                    header("location: video.php?status_form=tidak_ada_data");
                                }
                            }
                            else
                            {
                                header("location: video.php?status_form=gagal_upload");
                            }

                            $update = mysqli_query($koneksi, "UPDATE video SET dipakai = 'tidak' WHERE video.id_video != '$id'") or die(mysqli_error());
                            $update2 = mysqli_query($koneksi, "UPDATE video SET nama_video = '$judul_video', file_video = '$videobaru', dipakai = '$video_status' WHERE video.id_video = '$id' LIMIT 1;") or die(mysqli_error());
                            if ($update == true && $update2 == true)
                            {
                                header("location: video.php?status_form=berhasil&jenis_form=edit&a1");
                            }
                            else
                            {
                                header("location: video.php?status_form=gagal&jenis_form=edit&a1");
                            }
                        }
                        else
                        {
                            header("location: video.php?status_form=gambar_tidak_valid");
                        }
                    }
                    elseif (empty($file_video_file) && empty($temp_video_file))
                    {
                        $update = mysqli_query($koneksi, "UPDATE video SET dipakai = 'tidak' WHERE video.id_video != '$id'") or die(mysqli_error());
                        $update2 = mysqli_query($koneksi, "UPDATE video SET nama_video = '$judul_video', dipakai = 'ya' WHERE video.id_video = '$id' LIMIT 1;") or die(mysqli_error());
                        if ($update == true && $update2 == true)
                        {
                            header("location: video.php?status_form=berhasil&jenis_form=edit&a2");
                        }
                        else
                        {
                            header("location: video.php?status_form=gagal&jenis_form=edit&a2");
                        }
                    }
                }
                else
                {
                    if (!empty($file_video_file) && !empty($temp_video_file))
                    {
                        if ($valid_file == true)
                        {
                            if (move_uploaded_file($temp_video_file, $path))
                            {
                                $cek_file_video = mysqli_query($koneksi, "SELECT file_video FROM video WHERE id_video = '$id' LIMIT 1") or die(mysqli_error());
                                if (mysqli_num_rows($cek_file_video) == 1)
                                {
                                    while ($daftar_video = mysqli_fetch_array($cek_file_video))
                                    {
                                        $hapus_video = $daftar_video['file_video'];
                                        if (file_exists("../upload/video/" . $hapus_video))
                                        {
                                            unlink("../upload/video/" . $hapus_video);
                                        }
                                        else
                                        {
                                            header("location: video.php?status_form=gagal_hapus_video");
                                        }
                                    }
                                }
                                else
                                {
                                    header("location: video.php?status_form=tidak_ada_data");
                                }
                            }
                            else
                            {
                                header("location: video.php?status_form=gagal_upload");
                            }

                            $update2 = mysqli_query($koneksi, "UPDATE video SET nama_video = '$judul_video', file_video = '$videobaru', dipakai = 'tidak' WHERE video.id_video = '$id' LIMIT 1;") or die(mysqli_error());
                            if ($update2 == true)
                            {
                                header("location: video.php?status_form=berhasil&jenis_form=edit&a2");
                            }
                            else
                            {
                                header("location: video.php?status_form=gagal&jenis_form=edit&a2");
                            }
                        }
                        else
                        {
                            header("location: video.php?status_form=gambar_tidak_valid");
                        }
                    }
                    elseif (empty($file_video_file) && empty($temp_video_file))
                    {
                        $update2 = mysqli_query($koneksi, "UPDATE video SET nama_video = '$judul_video', dipakai = 'tidak' WHERE video.id_video = '$id' LIMIT 1;") or die(mysqli_error());
                        if ($update2 == true)
                        {
                            header("location: video.php?status_form=berhasil&jenis_form=edit&b2");
                        }
                        else
                        {
                            header("location: video.php?status_form=gagal&jenis_form=edit&b2");
                        }
                    }
                }
            }
            else
            {
                header("location: video.php?status_form=tidak_lengkap&b");
            }
        }
        else
        {
            header("location: video.php?status_form=tidak_lengkap&a");
        }
    }

    if (isset($_GET['id_hapus_video']))
    {
        if (!empty($_GET['id_hapus_video']))
        {
            $id = trim(strip_tags(mysqli_real_escape_string($koneksi, $_GET['id_hapus_video'])));
            $cek_terpilih = mysqli_query($koneksi, "SELECT id_video FROM video WHERE id_video = '$id' LIMIT 1") or die(mysqli_error());
            if (mysqli_num_rows($cek_terpilih) == 0)
            {
                header("location: video.php?status_form=tidak_ada_data");
            }
            elseif (mysqli_num_rows($cek_terpilih) == 1)
            {
                $cek_file_video = mysqli_query($koneksi, "SELECT file_video FROM video WHERE id_video = '$id' LIMIT 1") or die(mysqli_error());
                if (mysqli_num_rows($cek_file_video) == 1)
                {
                    while ($daftar_video = mysqli_fetch_array($cek_file_video))
                    {
                        $hapus_video = $daftar_video['file_video'];
                        if (file_exists("../upload/video/" . $hapus_video))
                        {
                            unlink("../upload/video/" . $hapus_video);
                        }
                        else
                        {
                            header("location: video.php?status_form=gagal_hapus_gambar");
                        }
                    }
                }

                $hapus = mysqli_query($koneksi, "DELETE FROM video WHERE id_video = '$id' LIMIT 1");
                if ($hapus == true)
                {
                    header("location: video.php?status_form=berhasil&jenis_form=hapus");
                }
                else
                {
                    header("location: video.php?status_form=gagal&jenis_form=hapus");
                }

                $hapus = null;
            }
        }
        else
        {
            header("location: video.php?status_form=tidak_lengkap");
        }
    }

    // Tambah Menu Atas

    if (isset($_POST['menu_atas_tambah']))
    {
        if (isset($_POST['menu']) && isset($_POST['link']))
        {
            $menu = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['menu'])));
            $link = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['link'])));
            $menu_status = "";
            if (isset($_POST['menu_aktif']) && $_POST['menu_aktif'] == 1)
            {
                $menu_status = 'ya';
            }
            else
            {
                $menu_status = 'tidak';
            }

            if (!empty($menu) && !empty($link))
            {
                $input = mysqli_query($koneksi, "INSERT INTO menu VALUES (NULL, '$menu', '$link', '$menu_status')") or die(mysqli_error());
                if ($input == true)
                {
                    header("location: menu_atas_tambah.php?status_form=berhasil&jenis_form=tambah");
                }
                else
                {
                    header("location: menu_atas_tambah.php?status_form=gagal&jenis_form=tambah");
                }

                $input = null;
            }
            else
            {
                header("location: menu_atas_tambah.php?status_form=tidak_lengkap");
            }
        }
    }

    // Edit Menu Atas

    if (isset($_POST['menu_atas_edit']))
    {
        if (isset($_POST['menu']) && isset($_POST['link']) && isset($_POST['id']))
        {
            $id = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['id'])));
            $menu = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['menu'])));
            $link = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['link'])));
            $video_dipakai_status = "";
            if (isset($_POST['menu_aktif']) && $_POST['menu_aktif'] == 1)
            {
                $menu_status = 'ya';
            }
            else
            {
                $menu_status = 'tidak';
            }

            if (!empty($menu) && !empty($link) && !empty($id))
            {
                $update = mysqli_query($koneksi, "UPDATE menu SET nama_menu = '$menu', url = '$link', aktif = '$menu_status' WHERE menu.id_menu = '$id' LIMIT 1;") or die(mysqli_error());
                if ($update == true)
                {
                    header("location: menu_atas.php?status_form=berhasil&jenis_form=edit");
                }
                else
                {
                    header("location: menu_atas.php?status_form=gagal&jenis_form=edit");
                }

                $update = null;
            }
            else
            {
                header("location: menu_atas.php?status_form=tidak_lengkap");
            }
        }
        else
        {
            header("location: menu_atas.php?status_form=tidak_lengkap");
        }
    }

    // Hapus Menu Atas

    if (isset($_GET['id_hapus_menu_atas']))
    {
        if (!empty($_GET['id_hapus_menu_atas']))
        {
            $id = trim(strip_tags(mysqli_real_escape_string($koneksi, $_GET['id_hapus_menu_atas'])));
            $cek_terpilih = mysqli_query($koneksi, "SELECT id_menu FROM menu WHERE id_menu = '$id' LIMIT 1") or die(mysqli_error());
            if (mysqli_num_rows($cek_terpilih) == 0)
            {
                header("location: menu_atas.php?status_form=tidak_ada_data");
            }
            elseif (mysqli_num_rows($cek_terpilih) == 1)
            {
                $hapus = mysqli_query($koneksi, "DELETE FROM menu WHERE id_menu = '$id' LIMIT 1");
                if ($hapus == true)
                {
                    header("location: menu_atas.php?status_form=berhasil&jenis_form=hapus");
                }
                else
                {
                    header("location: menu_atas.php?status_form=gagal&jenis_form=hapus");
                }

                $hapus = null;
            }
        }
        else
        {
            header("location: menu_atas.php?status_form=tidak_lengkap");
        }
    }

    // Tambah Contact

    if (isset($_POST['contact_tambah']))
    {
        if (isset($_POST['alamat_gedung']) && isset($_POST['alamat_jalan']) && isset($_POST['alamat_daerah']) && isset($_POST['no_telp']) && isset($_POST['email']) && isset($_POST['warehouse_jalan']) && isset($_POST['warehouse_wilayah']) && isset($_POST['warehouse_daerah']) && isset($_POST['embed_google_maps']) && isset($_POST['email_pengirim']) && isset($_POST['subyek_pesan']) && isset($_POST['email_tujuan']))
        {
            $alamat_gedung = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['alamat_gedung'])));
            $alamat_jalan = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['alamat_jalan'])));
            $alamat_daerah = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['alamat_daerah'])));
            $no_telp = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['no_telp'])));
            $email = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['email'])));
            $warehouse_jalan = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['warehouse_jalan'])));
            $warehouse_wilayah = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['warehouse_wilayah'])));
            $warehouse_daerah = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['warehouse_daerah'])));
            $embed_google_maps = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['embed_google_maps'])));
            $email_pengirim = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['no_telp'])));
            $subyek_pesan = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['subyek_pesan'])));
            $email_tujuan = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['email_tujuan'])));
            if (!empty($alamat_gedung) && !empty($alamat_jalan) && !empty($alamat_daerah) && !empty($no_telp) && !empty($email) && !empty($warehouse_jalan) && !empty($warehouse_wilayah) && !empty($warehouse_daerah) && !empty($email_pengirim) && !empty($embed_google_maps) && !empty($subyek_pesan) && !empty($email_tujuan))
            {
                $input = mysqli_query($koneksi, "INSERT INTO contact VALUES (NULL, '$alamat_gedung', '$alamat_jalan', '$alamat_daerah', '$warehouse_jalan', '$warehouse_wilayah', '$warehouse_daerah', $no_telp', '$email', '$embed_google_maps', '$email_pengirim', '$subyek_pesan' ,'$email_tujuan')") or die(mysqli_error());
                if ($input == true)
                {
                    header("location: contact_tambah.php?status_form=berhasil&jenis_form=tambah");
                }
                else
                {
                    header("location: contact_tambah.php?status_form=gagal&jenis_form=tambah");
                }

                $input = null;
            }
            else
            {
                header("location: contact_tambah.php?status_form=tidak_lengkap");
            }
        }
    }

    // Edit Contact

    if (isset($_POST['contact_edit']))
    {
        if (isset($_POST['alamat_gedung']) && isset($_POST['alamat_jalan']) && isset($_POST['alamat_daerah']) && isset($_POST['no_telp']) && isset($_POST['email']) && isset($_POST['warehouse_jalan']) && isset($_POST['warehouse_wilayah']) && isset($_POST['warehouse_daerah']) && isset($_POST['embed_google_maps']) && isset($_POST['email_pengirim']) && isset($_POST['subyek_pesan']) && isset($_POST['email_tujuan']))
        {
            $alamat_gedung = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['alamat_gedung'])));
            $alamat_jalan = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['alamat_jalan'])));
            $alamat_daerah = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['alamat_daerah'])));
            $no_telp = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['no_telp'])));
            $email = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['email'])));
            $warehouse_jalan = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['warehouse_jalan'])));
            $warehouse_wilayah = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['warehouse_wilayah'])));
            $warehouse_daerah = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['warehouse_daerah'])));
            $embed_google_maps = trim(mysqli_real_escape_string($koneksi, $_POST['embed_google_maps']));
            $email_pengirim = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['email_pengirim'])));
            $subyek_pesan = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['subyek_pesan'])));
            $email_tujuan = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['email_tujuan'])));
            if (!empty($alamat_gedung) && !empty($alamat_jalan) && !empty($alamat_daerah) && !empty($no_telp) && !empty($email) && !empty($warehouse_jalan) && !empty($warehouse_wilayah) && !empty($warehouse_daerah) && !empty($embed_google_maps) && !empty($email_pengirim) && !empty($subyek_pesan) && !empty($email_tujuan))
            {
                $update = mysqli_query($koneksi, "UPDATE contact SET alamat_gedung = '$alamat_gedung', alamat_jalan = '$alamat_jalan', alamat_daerah = '$alamat_daerah', warehouse_jalan = '$warehouse_jalan', warehouse_wilayah = '$warehouse_wilayah', warehouse_daerah = '$warehouse_daerah', no_telp = '$no_telp', email = '$email', embed_google_maps = '$embed_google_maps', email_pengirim = '$email_pengirim', subyek_pesan = '$subyek_pesan',email_tujuan = '$email_tujuan' WHERE contact.id_contact > 0 LIMIT 1") or die(mysqli_error());
                if ($update == true)
                {
                    header("location: contact.php?status_form=berhasil&jenis_form=edit");
                }
                else
                {
                    header("location: contact.php?status_form=gagal&jenis_form=edit");
                }

                $update = null;
            }
            else
            {
                header("location: contact.php?status_form=tidak_lengkap&a");
            }
        }
        else
        {
            header("location: contact.php?status_form=tidak_lengkap&b");
        }
    }

    // Tambah Social Footer

    if (isset($_POST['social_footer_tambah']))
    {
        if (isset($_POST['facebook_url']) && isset($_POST['twitter_url']) && isset($_POST['instagram_url']) && isset($_POST['linkedin_url']) && isset($_POST['youtube_url']))
        {
            $facebook_url = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['facebook_url'])));
            $twitter_url = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['twitter_url'])));
            $instagram_url = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['instagram_url'])));
            $linkedin_url = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['linkedin_url'])));
            $youtube_url = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['youtube_url'])));
            if (!empty($facebook_url) && !empty($twitter_url) && !empty($instagram_url) && !empty($linkedin_url) && !empty($youtube_url))
            {
                $input = mysqli_query($koneksi, "INSERT INTO social_footer VALUES (NULL, '$facebook_url', '$twitter_url', '$instagram_url', '$linkedin_url', '$youtube_url')") or die(mysqli_error());
                if ($input == true)
                {
                    header("location: social_footer.php?status_form=berhasil&jenis_form=tambah");
                }
                else
                {
                    header("location: social_footer.php?status_form=gagal&jenis_form=tambah");
                }

                $input = null;
            }
            else
            {
                header("location: social_footer.php?status_form=tidak_lengkap");
            }
        }
    }

    // Edit Social Footer

    if (isset($_POST['social_footer_edit']))
    {
        if (isset($_POST['facebook_url']) && isset($_POST['twitter_url']) && isset($_POST['instagram_url']) && isset($_POST['linkedin_url']) && isset($_POST['youtube_url']))
        {
            $facebook_url = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['facebook_url'])));
            $twitter_url = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['twitter_url'])));
            $instagram_url = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['instagram_url'])));
            $linkedin_url = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['linkedin_url'])));
            $youtube_url = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['youtube_url'])));
            if (!empty($facebook_url) && !empty($twitter_url) && !empty($instagram_url) && !empty($linkedin_url) && !empty($youtube_url))
            {
                $update = mysqli_query($koneksi, "UPDATE social_footer SET facebook_url = '$facebook_url', twitter_url = '$twitter_url', instagram_url = '$instagram_url', linkedin_url = '$linkedin_url', youtube_url = '$youtube_url' WHERE social_footer.id_social > 0 LIMIT 1") or die(mysqli_error());
                if ($update == true)
                {
                    header("location: social_footer.php?status_form=berhasil&jenis_form=edit");
                }
                else
                {
                    header("location: social_footer.php?status_form=gagal&jenis_form=edit");
                }

                $update = null;
            }
            else
            {
                header("location: social_footer.php?status_form=tidak_lengkap");
            }
        }
        else
        {
            header("location: social_footer.php?status_form=tidak_lengkap");
        }
    }

    // Tambah Judul Section

    if (isset($_POST['judul_heading_tambah']))
    {
        if (isset($_POST['judul_heading_video']) && isset($_POST['judul_heading_partner']) && isset($_POST['judul_heading_event']) && isset($_POST['judul_heading_event_all']) && isset($_POST['judul_heading_event_all_link']) && isset($_POST['judul_heading_license']) && isset($_POST['judul_heading_testimonial']) && isset($_POST['judul_heading_office']) && isset($_POST['judul_heading_warehouse']) && isset($_POST['judul_heading_form']) && isset($_POST['judul_heading_footer']))
        {
            $judul_heading_video = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['judul_heading_video'])));
            $judul_heading_partner = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['judul_heading_partner'])));
            $judul_heading_event = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['judul_heading_event'])));
            $judul_heading_event_all = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['judul_heading_event_event'])));
            $judul_heading_event_all_link = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['judul_heading_event_all_link'])));
            $judul_heading_license = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['judul_heading_license'])));
            $judul_heading_testimonial = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['judul_heading_testimonial'])));
            $judul_heading_office = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['judul_heading_office'])));
            $judul_heading_warehouse = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['judul_heading_warehouse'])));
            $judul_heading_form = trim(mysqli_real_escape_string($koneksi, $_POST['judul_heading_form']));
            $judul_heading_footer = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['judul_heading_footer'])));
            if (!empty($judul_heading_video) && !empty($judul_heading_partner) && !empty($judul_heading_event) && !empty($judul_heading_event_all) && !empty($judul_heading_event_all_link) && !empty($judul_heading_license) && !empty($judul_heading_testimonial) && !empty($judul_heading_office) && !empty($judul_heading_warehouse) && !empty($judul_heading_form) && !empty($judul_heading_footer))
            {
                $input = mysqli_query($koneksi, "INSERT INTO judul_header VALUES (NULL, '$judul_heading_video', '$judul_heading_partner', '$judul_heading_event', '$judul_heading_event_all', '$judul_heading_event_all_link', '$judul_heading_license', '$judul_heading_testimonial', '$judul_heading_office', '$judul_heading_warehouse', '$judul_heading_form', '$judul_heading_footer')") or die(mysqli_error());
                if ($input == true)
                {
                    header("location: judul_heading.php?status_form=berhasil&jenis_form=tambah");
                }
                else
                {
                    header("location: judul_heading.php?status_form=gagal&jenis_form=tambah");
                }

                $input = null;
            }
            else
            {
                header("location: judul_heading.php?status_form=tidak_lengkap");
            }
        }
        else
        {
            header("location: judul_heading.php?status_form=tidak_lengkap");
        }
    }

    // Edit Judul Section Header

    if (isset($_POST['judul_heading_edit']))
    {
        if (isset($_POST['judul_heading_video']) && isset($_POST['judul_heading_partner']) && isset($_POST['judul_heading_event']) && isset($_POST['judul_heading_event_all']) && isset($_POST['judul_heading_event_all_link']) && isset($_POST['judul_heading_license']) && isset($_POST['judul_heading_testimonial']) && isset($_POST['judul_heading_office']) && isset($_POST['judul_heading_warehouse']) && isset($_POST['judul_heading_form']) && isset($_POST['judul_heading_footer']))
        {
            $judul_heading_video = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['judul_heading_video'])));
            $judul_heading_partner = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['judul_heading_partner'])));
            $judul_heading_event = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['judul_heading_event'])));
            $judul_heading_event_all = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['judul_heading_event_all'])));
            $judul_heading_event_all_link = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['judul_heading_event_all_link'])));
            $judul_heading_license = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['judul_heading_license'])));
            $judul_heading_testimonial = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['judul_heading_testimonial'])));
            $judul_heading_office = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['judul_heading_office'])));
            $judul_heading_warehouse = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['judul_heading_warehouse'])));
            $judul_heading_form = trim(mysqli_real_escape_string($koneksi, $_POST['judul_heading_form']));
            $judul_heading_footer = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['judul_heading_footer'])));
            if (!empty($judul_heading_video) && !empty($judul_heading_partner) && !empty($judul_heading_event) && !empty($judul_heading_event_all) && !empty($judul_heading_event_all_link) && !empty($judul_heading_license) && !empty($judul_heading_testimonial) && !empty($judul_heading_office) && !empty($judul_heading_warehouse) && !empty($judul_heading_form) && !empty($judul_heading_footer))
            {
                $update = mysqli_query($koneksi, "UPDATE judul_header SET judul_header_video = '$judul_heading_video', judul_header_partner = '$judul_heading_partner', judul_header_event = '$judul_heading_event', judul_header_event_all = '$judul_heading_event_all', judul_header_event_all_link = '$judul_heading_event_all_link', judul_header_license = '$judul_heading_license', judul_header_testimoni = '$judul_heading_testimonial', judul_header_office = '$judul_heading_office', judul_header_warehouse = '$judul_heading_warehouse', judul_header_form_contact = '$judul_heading_form', judul_header_footer = '$judul_heading_footer' WHERE judul_header.id_judul_header > 0 LIMIT 1") or die(mysqli_error());
                if ($update == true)
                {
                    header("location: judul_heading.php?status_form=berhasil&jenis_form=edit");
                }
                else
                {
                    header("location: judul_heading.php?status_form=gagal&jenis_form=edit");
                }

                $update = null;
            }
            else
            {
                header("location: judul_heading.php?status_form=tidak_lengkap&a");
            }
        }
        else
        {
            header("location: judul_heading.php?status_form=tidak_lengkap&b");
        }
    }

    // Tambah Logo Tambah

    if (isset($_POST['logo_tambah']))
    {
        if (isset($_POST['nama_logo']) && isset($_FILES['upload_logo']) && !$_FILES['upload_logo']['error'])
        {
            $logo_status = "";
            if (isset($_POST['dipakai']) && $_POST['dipakai'] == 1)
            {
                $logo_status = 'ya';
            }
            else
            {
                $logo_status = 'tidak';
            }

            $valid_file = true;
            $max_size = 100000;
            $glebar = 200;
            $gtinggi = 63;
            $nama_logo = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['nama_logo'])));
            $image_logo_file = $_FILES['upload_logo']['name'];
            $temp_logo_file = $_FILES['upload_logo']['tmp_name'];
            $ukuran_logo_file = $_FILES['upload_logo']['size'];
            $jenis_image = strtolower(pathinfo($image_logo_file, PATHINFO_EXTENSION));
            list($lebar, $tinggi) = getimagesize($temp_logo_file);
            if ($ukuran_logo_file > $max_size)
            {
                $valid_file = false;
            }

            if ($jenis_image != "jpg" && $jenis_image != "jpeg" && $jenis_image != "png" && $jenis_image != "gif")
            {
                $valid_file = false;
            }

            if ($lebar != $glebar && $tinggi != $gtinggi)
            {
                $valid_file = false;
            }

            $fotobaru = date('dmYHis') . "_" . strtolower(str_replace(' ', '_', $image_logo_file));
            $path = "../upload/image/logo/" . $fotobaru;
            if (!empty($nama_logo))
            {
                if ($valid_file == true)
                {
                    if (move_uploaded_file($temp_logo_file, $path))
                    {
                        if ($logo_status == "ya")
                        {
                            $update = mysqli_query($koneksi, "UPDATE logo SET used = 'tidak' WHERE logo.id_logo > 0") or die(mysqli_error());
                            $input = mysqli_query($koneksi, "INSERT INTO logo VALUES (NULL, '$nama_logo', '$fotobaru', '$logo_status')") or die(mysqli_error());
                            if ($input == true && $update)
                            {
                                header("location: logo_tambah.php?status_form=berhasil&jenis_form=tambah");
                            }
                            else
                            {
                                header("location: logo_tambah.php?status_form=gagal&jenis_form=tambah");
                            }

                            $input = null;
                            $update = null;
                        }
                        else
                        {
                            $input = mysqli_query($koneksi, "INSERT INTO logo VALUES (NULL, '$nama_logo', '$fotobaru', '$logo_status')") or die(mysqli_error());
                            if ($input == true)
                            {
                                header("location: logo_tambah.php?status_form=berhasil&jenis_form=tambah");
                            }
                            else
                            {
                                header("location: logo_tambah.php?status_form=gagal&jenis_form=tambah");
                            }

                            $input = null;
                        }
                    }
                    else
                    {
                        header("location: logo_tambah.php?status_form=gagal_upload");
                    }
                }
                else
                {
                    header("location: logo_tambah.php?status_form=gambar_tidak_valid");
                }
            }
            else
            {
                header("location: logo_tambah.php?status_form=tidak_lengkap&b");
            }
        }
        else
        {
            header("location: logo_tambah.php?status_form=tidak_lengkap&a");
        }
    }

    if (isset($_POST['logo_edit']))
    {
        if (isset($_POST['nama_logo']) && isset($_POST['id']) && isset($_FILES['upload_logo']))
        {
            $logo_status = "";
            if (isset($_POST['dipakai']) && $_POST['dipakai'] == 1)
            {
                $logo_status = 'ya';
            }
            else
            {
                $logo_status = 'tidak';
            }

            $max_size = 100000;
            $glebar = 200;
            $gtinggi = 63;
            $id = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['id'])));
            $judul_logo = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['nama_logo'])));
            $image_logo_file = $_FILES['upload_logo']['name'];
            $temp_logo_file = $_FILES['upload_logo']['tmp_name'];
            $ukuran_logo_file = $_FILES['upload_logo']['size'];
            if (!empty($image_logo_file) && !empty($temp_logo_file))
            {
                $valid_file = true;
                $jenis_image = strtolower(pathinfo($image_logo_file, PATHINFO_EXTENSION));
                list($lebar, $tinggi) = getimagesize($temp_logo_file);
                if ($ukuran_logo_file > $max_size)
                {
                    $valid_file = false;
                }

                if ($jenis_image != "jpg" && $jenis_image != "jpeg" && $jenis_image != "png" && $jenis_image != "gif")
                {
                    $valid_file = false;
                }

                if ($lebar != $glebar && $tinggi != $gtinggi)
                {
                    $valid_file = false;
                }

                $fotobaru = date('dmYHis') . "_" . strtolower(str_replace(' ', '_', $image_logo_file));
                $path = "../upload/image/logo/" . $fotobaru;
            }

            if (!empty($judul_logo))
            {
                if ($logo_status == "ya")
                {
                    if (!empty($image_logo_file) && !empty($temp_logo_file))
                    {
                        if ($valid_file == true)
                        {
                            if (move_uploaded_file($temp_logo_file, $path))
                            {
                                $cek_gambar_logo = mysqli_query($koneksi, "SELECT image_logo FROM logo WHERE id_logo = '$id' LIMIT 1") or die(mysqli_error());
                                if (mysqli_num_rows($cek_gambar_logo) == 1)
                                {
                                    while ($daftar_logo = mysqli_fetch_array($cek_gambar_logo))
                                    {
                                        $hapus_image = $daftar_logo['image_logo'];
                                        if (file_exists("../upload/image/logo/" . $hapus_image))
                                        {
                                            unlink("../upload/image/logo/" . $hapus_image);
                                        }
                                        else
                                        {
                                            header("location: logo.php?status_form=gagal_hapus_gambar");
                                        }
                                    }
                                }
                                else
                                {
                                    header("location: logo.php?status_form=tidak_ada_data");
                                }
                            }
                            else
                            {
                                header("location: logo.php?status_form=gagal_upload");
                            }

                            $update = mysqli_query($koneksi, "UPDATE logo SET used = 'tidak' WHERE logo.id_logo != '$id'") or die(mysqli_error());
                            $update2 = mysqli_query($koneksi, "UPDATE logo SET judul_logo = '$judul_logo', image_logo = '$fotobaru', used = '$logo_status' WHERE logo.id_logo = '$id' LIMIT 1;") or die(mysqli_error());
                            if ($update == true && $update2 == true)
                            {
                                header("location: logo.php?status_form=berhasil&jenis_form=edit&a1");
                            }
                            else
                            {
                                header("location: logo.php?status_form=gagal&jenis_form=edit&a1");
                            }
                        }
                        else
                        {
                            header("location: logo.php?status_form=gambar_tidak_valid");
                        }
                    }
                    elseif (empty($image_logo_file) && empty($temp_logo_file))
                    {
                        $update = mysqli_query($koneksi, "UPDATE logo SET used = 'tidak' WHERE logo.id_logo != '$id'") or die(mysqli_error());
                        $update2 = mysqli_query($koneksi, "UPDATE logo SET judul_logo = '$judul_logo', used = 'ya' WHERE logo.id_logo = '$id' LIMIT 1;") or die(mysqli_error());
                        if ($update == true && $update2 == true)
                        {
                            header("location: logo.php?status_form=berhasil&jenis_form=edit&a2");
                        }
                        else
                        {
                            header("location: logo.php?status_form=gagal&jenis_form=edit&a2");
                        }
                    }
                }
                else
                {
                    if (!empty($image_logo_file) && !empty($temp_logo_file))
                    {
                        if ($valid_file == true)
                        {
                            if (move_uploaded_file($temp_logo_file, $path))
                            {
                                $cek_gambar_logo = mysqli_query($koneksi, "SELECT image_logo FROM logo WHERE id_logo = '$id' LIMIT 1") or die(mysqli_error());
                                if (mysqli_num_rows($cek_gambar_logo) == 1)
                                {
                                    while ($daftar_logo = mysqli_fetch_array($cek_gambar_logo))
                                    {
                                        $hapus_image = $daftar_logo['image_logo'];
                                        if (file_exists("../upload/image/logo/" . $hapus_image))
                                        {
                                            unlink("../upload/image/logo/" . $hapus_image);
                                        }
                                        else
                                        {
                                            header("location: logo.php?status_form=gagal_hapus_gambar");
                                        }
                                    }
                                }
                                else
                                {
                                    header("location: logo.php?status_form=tidak_ada_data");
                                }
                            }
                            else
                            {
                                header("location: logo.php?status_form=gagal_upload");
                            }

                            $update2 = mysqli_query($koneksi, "UPDATE logo SET judul_logo = '$judul_logo', image_logo = '$fotobaru', used = 'tidak' WHERE logo.id_logo = '$id' LIMIT 1;") or die(mysqli_error());
                            if ($update2 == true)
                            {
                                header("location: logo.php?status_form=berhasil&jenis_form=edit&a2");
                            }
                            else
                            {
                                header("location: logo.php?status_form=gagal&jenis_form=edit&a2");
                            }
                        }
                        else
                        {
                            header("location: logo.php?status_form=gambar_tidak_valid");
                        }
                    }
                    elseif (empty($image_logo_file) && empty($temp_logo_file))
                    {
                        $update2 = mysqli_query($koneksi, "UPDATE logo SET judul_logo = '$judul_logo', used = 'tidak' WHERE logo.id_logo = '$id' LIMIT 1;") or die(mysqli_error());
                        if ($update2 == true)
                        {
                            header("location: logo.php?status_form=berhasil&jenis_form=edit&b2");
                        }
                        else
                        {
                            header("location: logo.php?status_form=gagal&jenis_form=edit&b2");
                        }
                    }
                }
            }
            else
            {
                header("location: logo.php?status_form=tidak_lengkap&b");
            }
        }
        else
        {
            header("location: logo.php?status_form=tidak_lengkap&a");
        }
    }

    if (isset($_GET['id_hapus_logo']))
    {
        if (!empty($_GET['id_hapus_logo']))
        {
            $id = trim(strip_tags(mysqli_real_escape_string($koneksi, $_GET['id_hapus_logo'])));
            $cek_terpilih = mysqli_query($koneksi, "SELECT id_logo FROM logo WHERE id_logo = '$id' LIMIT 1") or die(mysqli_error());
            if (mysqli_num_rows($cek_terpilih) == 0)
            {
                header("location: logo.php?status_form=tidak_ada_data");
            }
            elseif (mysqli_num_rows($cek_terpilih) == 1)
            {
                $cek_gambar_logo = mysqli_query($koneksi, "SELECT image_logo FROM logo WHERE id_logo = '$id' LIMIT 1") or die(mysqli_error());
                if (mysqli_num_rows($cek_gambar_logo) == 1)
                {
                    while ($daftar_logo = mysqli_fetch_array($cek_gambar_logo))
                    {
                        $hapus_image = $daftar_logo['image_logo'];
                        if (file_exists("../upload/image/logo/" . $hapus_image))
                        {
                            unlink("../upload/image/logo/" . $hapus_image);
                        }
                        else
                        {
                            header("location: logo.php?status_form=gagal_hapus_gambar");
                        }
                    }
                }

                $hapus = mysqli_query($koneksi, "DELETE FROM logo WHERE id_logo = '$id' LIMIT 1");
                if ($hapus == true)
                {
                    header("location: logo.php?status_form=berhasil&jenis_form=hapus");
                }
                else
                {
                    header("location: logo.php?status_form=gagal&jenis_form=hapus");
                }

                $hapus = null;
            }
        }
        else
        {
            header("location: logo.php?status_form=tidak_lengkap");
        }
    }

    // Tambah cover

    if (isset($_POST['cover_tambah']))
    {
        if (isset($_POST['nama_cover']) && isset($_FILES['upload_cover']) && !$_FILES['upload_cover']['error'])
        {
            $cover_status = "";
            if (isset($_POST['dipakai']) && $_POST['dipakai'] == 1)
            {
                $cover_status = 'ya';
            }
            else
            {
                $cover_status = 'tidak';
            }

            $valid_file = true;
            $max_size = 200000;
            $glebar = 4269;
            $gtinggi = 2231;
            $nama_cover = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['nama_cover'])));
            $image_cover_file = $_FILES['upload_cover']['name'];
            $temp_cover_file = $_FILES['upload_cover']['tmp_name'];
            $ukuran_cover_file = $_FILES['upload_cover']['size'];
            $jenis_image = strtolower(pathinfo($image_cover_file, PATHINFO_EXTENSION));
            list($lebar, $tinggi) = getimagesize($temp_cover_file);
            if ($ukuran_cover_file > $max_size)
            {
                $valid_file = false;
            }

            if ($jenis_image != "jpg" && $jenis_image != "jpeg" && $jenis_image != "png" && $jenis_image != "gif")
            {
                $valid_file = false;
            }

            if ($lebar != $glebar && $tinggi != $gtinggi)
            {
                $valid_file = false;
            }

            $fotobaru = date('dmYHis') . "_" . strtolower(str_replace(' ', '_', $image_cover_file));
            $path = "../upload/image/cover/" . $fotobaru;
            if (!empty($nama_cover))
            {
                if ($valid_file == true)
                {
                    if (move_uploaded_file($temp_cover_file, $path))
                    {
                        $input = mysqli_query($koneksi, "INSERT INTO cover_background VALUES (NULL, '$nama_cover', '$fotobaru', '$cover_status')") or die(mysqli_error());
                        if ($input == true)
                        {
                            header("location: cover_background_tambah.php?status_form=berhasil&jenis_form=tambah");
                        }
                        else
                        {
                            header("location: cover_background_tambah.php?status_form=gagal&jenis_form=tambah");
                        }

                        $input = null;
                        $update = null;
                    }
                    else
                    {
                        header("location: cover_background_tambah.php?status_form=gagal_upload");
                    }
                }
                else
                {
                    header("location: cover_background_tambah.php?status_form=gambar_tidak_valid");
                }
            }
            else
            {
                header("location: cover_background_tambah.php?status_form=tidak_lengkap&b");
            }
        }
        else
        {
            header("location: cover_background_tambah.php?status_form=tidak_lengkap&a");
        }
    }

    if (isset($_POST['cover_edit']))
    {
        if (isset($_POST['nama_cover']) && isset($_POST['id']) && isset($_FILES['upload_cover']))
        {
            $cover_status = "";
            if (isset($_POST['dipakai']) && $_POST['dipakai'] == 1)
            {
                $cover_status = 'ya';
            }
            else
            {
                $cover_status = 'tidak';
            }

            $max_size = 200000;
            $glebar = 4269;
            $gtinggi = 2231;
            $id = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['id'])));
            $judul_cover = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['nama_cover'])));
            $image_cover_file = $_FILES['upload_cover']['name'];
            $temp_cover_file = $_FILES['upload_cover']['tmp_name'];
            $ukuran_cover_file = $_FILES['upload_cover']['size'];
            if (!empty($image_cover_file) && !empty($temp_cover_file))
            {
                $valid_file = true;
                $jenis_image = strtolower(pathinfo($image_cover_file, PATHINFO_EXTENSION));
                list($lebar, $tinggi) = getimagesize($temp_cover_file);
                if ($ukuran_cover_file > $max_size)
                {
                    $valid_file = false;
                }

                if ($jenis_image != "jpg" && $jenis_image != "jpeg" && $jenis_image != "png" && $jenis_image != "gif")
                {
                    $valid_file = false;
                }

                if ($lebar != $glebar && $tinggi != $gtinggi)
                {
                    $valid_file = false;
                }

                $fotobaru = date('dmYHis') . "_" . strtolower(str_replace(' ', '_', $image_cover_file));
                $path = "../upload/image/cover/" . $fotobaru;
            }

            if (!empty($judul_cover))
            {
                if (!empty($image_cover_file) && !empty($temp_cover_file))
                {
                    if ($valid_file == true)
                    {
                        if (move_uploaded_file($temp_cover_file, $path))
                        {
                            $cek_gambar_cover = mysqli_query($koneksi, "SELECT gambar_cover FROM cover_background WHERE id_cover = '$id' LIMIT 1") or die(mysqli_error());
                            if (mysqli_num_rows($cek_gambar_cover) == 1)
                            {
                                while ($daftar_cover = mysqli_fetch_array($cek_gambar_cover))
                                {
                                    $hapus_image = $daftar_cover['gambar_cover'];
                                    if (file_exists("../upload/image/cover/" . $hapus_image))
                                    {
                                        unlink("../upload/image/cover/" . $hapus_image);
                                    }
                                    else
                                    {
                                        header("location: cover_background.php?status_form=gagal_hapus_gambar");
                                    }
                                }
                            }
                            else
                            {
                                header("location: cover_background.php?status_form=tidak_ada_data");
                            }
                        }
                        else
                        {
                            header("location: cover_background.php?status_form=gagal_upload");
                        }

                        $update2 = mysqli_query($koneksi, "UPDATE cover_background SET judul_cover = '$judul_cover', gambar_cover = '$fotobaru', used = '$cover_status' WHERE cover_background.id_cover = '$id' LIMIT 1;") or die(mysqli_error());
                        if ($update2 == true)
                        {
                            header("location: cover_background.php?status_form=berhasil&jenis_form=edit&a1");
                        }
                        else
                        {
                            header("location: cover_background.php?status_form=gagal&jenis_form=edit&a1");
                        }
                    }
                    else
                    {
                        header("location: cover_background.php?status_form=gambar_tidak_valid");
                    }
                }
                elseif (empty($image_cover_file) && empty($temp_cover_file))
                {
                    $update2 = mysqli_query($koneksi, "UPDATE cover_background SET judul_cover = '$judul_cover', used = '$cover_status' WHERE cover_background.id_cover = '$id' LIMIT 1;") or die(mysqli_error());
                    if ($update2 == true)
                    {
                        header("location: cover_background.php?status_form=berhasil&jenis_form=edit&a2");
                    }
                    else
                    {
                        header("location: cover_background.php?status_form=gagal&jenis_form=edit&a2");
                    }
                }
            }
            else
            {
                header("location: cover_background.php?status_form=tidak_lengkap&b");
            }
        }
        else
        {
            header("location: cover_background.php?status_form=tidak_lengkap&a");
        }
    }

    if (isset($_GET['id_hapus_cover']))
    {
        if (!empty($_GET['id_hapus_cover']))
        {
            $id = trim(strip_tags(mysqli_real_escape_string($koneksi, $_GET['id_hapus_cover'])));
            $cek_terpilih = mysqli_query($koneksi, "SELECT id_cover FROM cover_background WHERE id_cover = '$id'") or die(mysqli_error());
            if (mysqli_num_rows($cek_terpilih) == 0)
            {
                header("location: cover_background.php?status_form=tidak_ada_data");
            }
            elseif (mysqli_num_rows($cek_terpilih) == 1)
            {
                $cek_gambar_cover = mysqli_query($koneksi, "SELECT gambar_cover FROM cover_background WHERE id_cover = '$id' LIMIT 1") or die(mysqli_error());
                if (mysqli_num_rows($cek_gambar_cover) == 1)
                {
                    while ($daftar_cover = mysqli_fetch_array($cek_gambar_cover))
                    {
                        $hapus_image = $daftar_cover['gambar_cover'];
                        if (file_exists("../upload/image/cover/" . $hapus_image))
                        {
                            unlink("../upload/image/cover/" . $hapus_image);
                        }
                        else
                        {
                            header("location: cover_background.php?status_form=gagal_hapus_gambar");
                        }
                    }
                }

                $hapus = mysqli_query($koneksi, "DELETE FROM cover_background WHERE id_cover = '$id' LIMIT 1");
                if ($hapus == true)
                {
                    header("location: cover_background.php?status_form=berhasil&jenis_form=hapus");
                }
                else
                {
                    header("location: cover_background.php?status_form=gagal&jenis_form=hapus");
                }

                $hapus = null;
            }
        }
        else
        {
            header("location: cover_background.php?status_form=tidak_lengkap");
        }
    }

    // tambah about who we are

    if (isset($_POST['about_who_we_are_tambah']))
    {
        if (isset($_POST['judul_who']) && isset($_POST['konten_who']))
        {
            $judul_who = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['judul_who'])));
            $konten_who = trim(mysqli_real_escape_string($koneksi, $_POST['konten_who']));
            if (!empty($judul_who) && !empty($konten_who))
            {
                $seleksi_about_who_we_are = mysqli_query($koneksi, "SELECT * FROM about WHERE category = 'who_we_are' LIMIT 1") or die("<script>alert('Query salah')</script>");
                $jumlah_who_we_are = mysqli_num_rows($seleksi_about_who_we_are);
                if ($jumlah_who_we_are == 0)
                {
                    $input = mysqli_query($koneksi, "INSERT INTO about VALUES (NULL, 'who_we_are', $judul_who', '$konten_who', NULL)") or die(mysqli_error());
                    if ($input == true)
                    {
                        header("location: about_who_we_are.php?status_form=berhasil&jenis_form=tambah");
                    }
                    else
                    {
                        header("location: about_who_we_are.php?status_form=gagal&jenis_form=tambah");
                    }

                    $input = null;
                }
                else
                {
                    header("location: about_who_we_are.php?status_form=sudah_ada");
                }
            }
            else
            {
                header("location: about_who_we_are.php?status_form=tidak_lengkap");
            }
        }
    }

    // Edit about who we are

    if (isset($_POST['about_who_we_are_edit']))
    {
        if (isset($_POST['judul_who']) && isset($_POST['konten_who']))
        {
            $judul_who = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['judul_who'])));
            $konten_who = trim(mysqli_real_escape_string($koneksi, $_POST['konten_who']));
            if (!empty($judul_who) && !empty($konten_who))
            {
                $seleksi_about_who_we_are = mysqli_query($koneksi, "SELECT * FROM about WHERE category = 'who_we_are' LIMIT 1") or die("<script>alert('Query salah')</script>");
                $jumlah_who_we_are = mysqli_num_rows($seleksi_about_who_we_are);
                if ($jumlah_who_we_are == 1)
                {
                    $update = mysqli_query($koneksi, "UPDATE about SET judul = '$judul_who', konten = '$konten_who' WHERE category = 'who_we_are' LIMIT 1") or die(mysqli_error());
                    if ($update == true)
                    {
                        header("location: about_who_we_are.php?status_form=berhasil&jenis_form=edit");
                    }
                    else
                    {
                        header("location: about_who_we_are.php?status_form=gagal&jenis_form=edit");
                    }

                    $update = null;
                }
                else
                {
                    header("location: about_who_we_are.php?status_form=tidak_ada_data");
                }
            }
            else
            {
                header("location: about_who_we_are.php?status_form=tidak_lengkap");
            }
        }
        else
        {
            header("location: about_who_we_are.php?status_form=tidak_lengkap");
        }
    }

    // tambah about us

    if (isset($_POST['about_us_tambah']))
    {
        if (isset($_POST['judul_us']) && isset($_POST['konten_us']) && isset($_FILES['upload_logo']))
        {
            $judul_us = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['judul_us'])));
            $konten_us = trim(mysqli_real_escape_string($koneksi, $_POST['konten_us']));
            $valid_file = true;
            $max_size = 100000;
            $glebar = 868;
            $gtinggi = 365;
            $image_about_file = $_FILES['upload_logo']['name'];
            $temp_about_file = $_FILES['upload_logo']['tmp_name'];
            $ukuran_about_file = $_FILES['upload_logo']['size'];
            $jenis_image = strtolower(pathinfo($image_about_file, PATHINFO_EXTENSION));
            list($lebar, $tinggi) = getimagesize($temp_about_file);
            if ($ukuran_about_file > $max_size)
            {
                $valid_file = false;
            }

            if ($jenis_image != "jpg" && $jenis_image != "jpeg" && $jenis_image != "png" && $jenis_image != "gif")
            {
                $valid_file = false;
            }

            if ($lebar != $glebar && $tinggi != $gtinggi)
            {
                $valid_file = false;
            }

            $gambar_about_baru = date('dmYHis') . "_" . strtolower(str_replace(' ', '_', $image_about_file));
            $path = "../upload/image/about/us/" . $gambar_about_baru;
            if (!empty($judul_us) && !empty($konten_us))
            {
                $seleksi_about_us = mysqli_query($koneksi, "SELECT * FROM about WHERE category = 'about_us' LIMIT 1") or die("<script>alert('Query salah')</script>");
                $jumlah_about_us = mysqli_num_rows($seleksi_about_us);
                if ($jumlah_about_us == 0)
                {
                    if ($valid_file == true)
                    {
                        $input = mysqli_query($koneksi, "INSERT INTO about VALUES (NULL, 'about_us', '$judul_us', '$konten_us', '$gambar_about_baru')") or die(mysqli_error());
                        if ($input == true)
                        {
                            if (move_uploaded_file($temp_about_file, $path))
                            {
                                header("location: about_about_us.php?status_form=berhasil&jenis_form=tambah");
                            }
                            else
                            {
                                header("location: about_about_us.php?status_form=gagal_upload");
                            }
                        }
                    }
                    else
                    {
                        header("location: about_about_us.php?status_form=gambar_tidak_valid");
                    }

                    $input = null;
                }
            }
            else
            {
                header("location: about_about_us.php?status_form=tidak_ada_data");
            }
        }
        else
        {
            header("location: about_about_us.php?status_form=tidak_lengkap&a");
        }
    }

    if (isset($_POST['about_us_edit']))
    {
        if (isset($_POST['judul_us']) && isset($_POST['konten_us']) && isset($_FILES['upload_logo']))
        {
            $judul_us = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['judul_us'])));
            $konten_us = trim(mysqli_real_escape_string($koneksi, $_POST['konten_us']));
            $max_size = 100000;
            $glebar = 868;
            $gtinggi = 365;
            $image_about_file = $_FILES['upload_logo']['name'];
            $temp_about_file = $_FILES['upload_logo']['tmp_name'];
            $ukuran_about_file = $_FILES['upload_logo']['size'];
            if (!empty($image_about_file) && !empty($temp_about_file))
            {
                $valid_file = true;
                $jenis_image = strtolower(pathinfo($image_about_file, PATHINFO_EXTENSION));
                list($lebar, $tinggi) = getimagesize($temp_about_file);
                if ($ukuran_about_file > $max_size)
                {
                    $valid_file = false;
                }

                if ($jenis_image != "jpg" && $jenis_image != "jpeg" && $jenis_image != "png" && $jenis_image != "gif")
                {
                    $valid_file = false;
                }

                if ($lebar != $glebar && $tinggi != $gtinggi)
                {
                    $valid_file = false;
                }

                $gambar_about_baru = date('dmYHis') . "_" . strtolower(str_replace(' ', '_', $image_about_file));
                $path = "../upload/image/about/us/" . $gambar_about_baru;
            }

            if (!empty($judul_us) && !empty($konten_us))
            {
                if (!empty($image_about_file) && !empty($temp_about_file))
                {
                    if ($valid_file == true)
                    {
                        if (move_uploaded_file($temp_about_file, $path))
                        {
                            $cek_gambar_about = mysqli_query($koneksi, "SELECT image_about FROM about WHERE about.category = 'about_us'") or die(mysqli_error());
                            if (mysqli_num_rows($cek_gambar_about) == 1)
                            {
                                while ($daftar_about = mysqli_fetch_array($cek_gambar_about))
                                {
                                    $hapus_image = $daftar_about['image_about'];
                                    if (file_exists("../upload/image/about/us/" . $hapus_image))
                                    {
                                        unlink("../upload/image/about/us/" . $hapus_image);
                                    }
                                    else
                                    {
                                        header("location: about_about_us.php?status_form=gagal_hapus_gambar");
                                    }
                                }
                            }
                            else
                            {
                                header("location: about_about_us.php?status_form=tidak_ada_data");
                            }
                        }
                        else
                        {
                            header("location: about_about_us.php?status_form=gagal_upload");
                        }

                        $update2 = mysqli_query($koneksi, "UPDATE about SET judul = '$judul_us', konten = '$konten_us', image_about = '$gambar_about_baru' WHERE about.category = 'about_us' LIMIT 1") or die(mysqli_error());
                        if ($update2 == true)
                        {
                            header("location: about_about_us.php?status_form=berhasil&jenis_form=edit&a");
                        }
                        else
                        {
                            header("location: about_about_us.php?status_form=gagal&jenis_form=edit&a");
                        }
                    }
                    else
                    {
                        header("location: about_about_us.php?status_form=gambar_tidak_valid");
                    }
                }
                elseif (empty($image_about_file) && empty($temp_about_file))
                {
                    $update2 = mysqli_query($koneksi, "UPDATE about SET judul = '$judul_us', konten = '$konten_us' WHERE about.category = 'about_us' LIMIT 1") or die(mysqli_error());
                    if ($update2 == true)
                    {
                        header("location: about_about_us.php?status_form=berhasil&jenis_form=edit&b");
                    }
                    else
                    {
                        header("location: about_about_us.php?status_form=gagal&jenis_form=edit&b");
                    }
                }
            }
            else
            {
                header("location: about_about_us.php?status_form=tidak_lengkap&a");
            }
        }
        else
        {
            header("location: about_about_us.php?status_form=tidak_lengkap&b");
        }
    }

    // tambah vission

    if (isset($_POST['about_vission_tambah']))
    {
        if (isset($_POST['judul_vission']) && isset($_POST['konten_vission']) && isset($_FILES['upload_logo']))
        {
            $judul_vission = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['judul_vission'])));
            $konten_vission = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['konten_vission'])));
            $valid_file = true;
            $max_size = 100000;
            $glebar = 45;
            $gtinggi = 62;
            $image_vission_file = $_FILES['upload_logo']['name'];
            $temp_vission_file = $_FILES['upload_logo']['tmp_name'];
            $ukuran_vission_file = $_FILES['upload_logo']['size'];
            $jenis_image = strtolower(pathinfo($image_vission_file, PATHINFO_EXTENSION));
            list($lebar, $tinggi) = getimagesize($temp_vission_file);
            if ($ukuran_vission_file > $max_size)
            {
                $valid_file = false;
            }

            if ($jenis_image != "jpg" && $jenis_image != "jpeg" && $jenis_image != "png" && $jenis_image != "gif")
            {
                $valid_file = false;
            }

            if ($lebar != $glebar && $tinggi != $gtinggi)
            {
                $valid_file = false;
            }

            $gambar_about_baru = date('dmYHis') . "_" . strtolower(str_replace(' ', '_', $image_vission_file));
            $path = "../upload/image/about/vission/" . $gambar_about_baru;
            if (!empty($judul_vission) && !empty($konten_vission))
            {
                $seleksi_about_vission = mysqli_query($koneksi, "SELECT * FROM about WHERE category = 'vission' LIMIT 1") or die("<script>alert('Query salah')</script>");
                $jumlah_about_vission = mysqli_num_rows($seleksi_about_vission);
                if ($jumlah_about_vission == 0)
                {
                    if ($valid_file == true)
                    {
                        $input = mysqli_query($koneksi, "INSERT INTO about VALUES (NULL, 'vission', '$judul_vission', '$konten_vission', '$gambar_about_baru')") or die(mysqli_error());
                        if ($input == true)
                        {
                            if (move_uploaded_file($temp_vission_file, $path))
                            {
                                header("location: about_vission.php?status_form=berhasil&jenis_form=tambah");
                            }
                            else
                            {
                                header("location: about_vission.php?status_form=gagal_upload");
                            }
                        }
                    }
                    else
                    {
                        header("location: about_vission.php?status_form=gambar_tidak_valid");
                    }

                    $input = null;
                }
            }
            else
            {
                header("location: about_vission.php?status_form=tidak_ada_data");
            }
        }
        else
        {
            header("location: about_vission.php?status_form=tidak_lengkap&a");
        }
    }

    if (isset($_POST['about_vission_edit']))
    {
        if (isset($_POST['judul_vission']) && isset($_POST['konten_vission']) && isset($_FILES['upload_logo']))
        {
            $judul_vission = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['judul_vission'])));
            $konten_vission = trim(mysqli_real_escape_string($koneksi, $_POST['konten_vission']));
            $max_size = 100000;
            $glebar = 45;
            $gtinggi = 62;
            $image_vission_file = $_FILES['upload_logo']['name'];
            $temp_vission_file = $_FILES['upload_logo']['tmp_name'];
            $ukuran_vission_file = $_FILES['upload_logo']['size'];
            if (!empty($image_vission_file) && !empty($temp_vission_file))
            {
                $valid_file = true;
                $jenis_image = strtolower(pathinfo($image_vission_file, PATHINFO_EXTENSION));
                list($lebar, $tinggi) = getimagesize($temp_vission_file);
                if ($ukuran_vission_file > $max_size)
                {
                    $valid_file = false;
                }

                if ($jenis_image != "jpg" && $jenis_image != "jpeg" && $jenis_image != "png" && $jenis_image != "gif")
                {
                    $valid_file = false;
                }

                if ($lebar != $glebar && $tinggi != $gtinggi)
                {
                    $valid_file = false;
                }

                $gambar_vission_baru = date('dmYHis') . "_" . strtolower(str_replace(' ', '_', $image_vission_file));
                $path = "../upload/image/about/vission/" . $gambar_vission_baru;
            }

            if (!empty($judul_vission) && !empty($konten_vission))
            {
                if (!empty($image_vission_file) && !empty($temp_vission_file))
                {
                    if ($valid_file == true)
                    {
                        if (move_uploaded_file($temp_vission_file, $path))
                        {
                            $cek_gambar_about = mysqli_query($koneksi, "SELECT image_about FROM about WHERE about.category = 'vission'") or die(mysqli_error());
                            if (mysqli_num_rows($cek_gambar_about) == 1)
                            {
                                while ($daftar_about = mysqli_fetch_array($cek_gambar_about))
                                {
                                    $hapus_image = $daftar_about['image_about'];
                                    if (file_exists("../upload/image/about/vission/" . $hapus_image))
                                    {
                                        unlink("../upload/image/about/vission/" . $hapus_image);
                                    }
                                    else
                                    {
                                        header("location: about_vission.php?status_form=gagal_hapus_gambar");
                                    }
                                }
                            }
                            else
                            {
                                header("location: about_vission.php?status_form=tidak_ada_data");
                            }
                        }
                        else
                        {
                            header("location: about_vission.php?status_form=gagal_upload");
                        }

                        $update2 = mysqli_query($koneksi, "UPDATE about SET judul = '$judul_vission', konten = '$konten_vission', image_about = '$gambar_vission_baru' WHERE about.category = 'vission' LIMIT 1") or die(mysqli_error());
                        if ($update2 == true)
                        {
                            header("location: about_vission.php?status_form=berhasil&jenis_form=edit&a");
                        }
                        else
                        {
                            header("location: about_vission.php?status_form=gagal&jenis_form=edit&a");
                        }
                    }
                    else
                    {
                        header("location: about_vission.php?status_form=gambar_tidak_valid");
                    }
                }
                elseif (empty($image_vission_file) && empty($temp_vission_file))
                {
                    $update2 = mysqli_query($koneksi, "UPDATE about SET judul = '$judul_vission', konten = '$konten_vission' WHERE about.category = 'vission' LIMIT 1") or die(mysqli_error());
                    if ($update2 == true)
                    {
                        header("location: about_vission.php?status_form=berhasil&jenis_form=edit&b");
                    }
                    else
                    {
                        header("location: about_vission.php?status_form=gagal&jenis_form=edit&b");
                    }
                }
            }
            else
            {
                header("location: about_vission.php?status_form=tidak_lengkap&a");
            }
        }
        else
        {
            header("location: about_vission.php?status_form=tidak_lengkap&b");
        }
    }

    // tambah mission

    if (isset($_POST['about_mission_tambah']))
    {
        if (isset($_POST['judul_mission']) && isset($_POST['konten_mission']) && isset($_FILES['upload_logo']))
        {
            $judul_mission = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['judul_mission'])));
            $konten_mission = trim(mysqli_real_escape_string($koneksi, $_POST['konten_mission']));
            $valid_file = true;
            $max_size = 100000;
            $glebar = 63;
            $gtinggi = 61;
            $image_mission_file = $_FILES['upload_logo']['name'];
            $temp_mission_file = $_FILES['upload_logo']['tmp_name'];
            $ukuran_mission_file = $_FILES['upload_logo']['size'];
            $jenis_image = strtolower(pathinfo($image_mission_file, PATHINFO_EXTENSION));
            list($lebar, $tinggi) = getimagesize($temp_mission_file);
            if ($ukuran_mission_file > $max_size)
            {
                $valid_file = false;
            }

            if ($jenis_image != "jpg" && $jenis_image != "jpeg" && $jenis_image != "png" && $jenis_image != "gif")
            {
                $valid_file = false;
            }

            if ($lebar != $glebar && $tinggi != $gtinggi)
            {
                $valid_file = false;
            }

            $gambar_about_baru = date('dmYHis') . "_" . strtolower(str_replace(' ', '_', $image_mission_file));
            $path = "../upload/image/about/mission/" . $gambar_about_baru;
            if (!empty($judul_mission) && !empty($konten_mission))
            {
                $seleksi_about_mission = mysqli_query($koneksi, "SELECT * FROM about WHERE category = 'mission' LIMIT 1") or die("<script>alert('Query salah')</script>");
                $jumlah_about_mission = mysqli_num_rows($seleksi_about_mission);
                if ($jumlah_about_mission == 0)
                {
                    if ($valid_file == true)
                    {
                        $input = mysqli_query($koneksi, "INSERT INTO about VALUES (NULL, 'mission', '$judul_mission', '$konten_mission', '$gambar_about_baru')") or die(mysqli_error());
                        if ($input == true)
                        {
                            if (move_uploaded_file($temp_mission_file, $path))
                            {
                                header("location: about_mission.php?status_form=berhasil&jenis_form=tambah");
                            }
                            else
                            {
                                header("location: about_mission.php?status_form=gagal_upload");
                            }
                        }
                    }
                    else
                    {
                        header("location: about_mission.php?status_form=gambar_tidak_valid");
                    }

                    $input = null;
                }
            }
            else
            {
                header("location: about_mission.php?status_form=tidak_ada_data");
            }
        }
        else
        {
            header("location: about_mission.php?status_form=tidak_lengkap&a");
        }
    }

    if (isset($_POST['about_mission_edit']))
    {
        if (isset($_POST['judul_mission']) && isset($_POST['konten_mission']) && isset($_FILES['upload_logo']))
        {
            $judul_mission = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['judul_mission'])));
            $konten_mission = trim(mysqli_real_escape_string($koneksi, $_POST['konten_mission']));
            $max_size = 100000;
            $glebar = 63;
            $gtinggi = 61;
            $image_mission_file = $_FILES['upload_logo']['name'];
            $temp_mission_file = $_FILES['upload_logo']['tmp_name'];
            $ukuran_mission_file = $_FILES['upload_logo']['size'];
            if (!empty($image_mission_file) && !empty($temp_mission_file))
            {
                $valid_file = true;
                $jenis_image = strtolower(pathinfo($image_mission_file, PATHINFO_EXTENSION));
                list($lebar, $tinggi) = getimagesize($temp_mission_file);
                if ($ukuran_mission_file > $max_size)
                {
                    $valid_file = false;
                }

                if ($jenis_image != "jpg" && $jenis_image != "jpeg" && $jenis_image != "png" && $jenis_image != "gif")
                {
                    $valid_file = false;
                }

                if ($lebar != $glebar && $tinggi != $gtinggi)
                {
                    $valid_file = false;
                }

                $gambar_mission_baru = date('dmYHis') . "_" . strtolower(str_replace(' ', '_', $image_mission_file));
                $path = "../upload/image/about/mission/" . $gambar_mission_baru;
            }

            if (!empty($judul_mission) && !empty($konten_mission))
            {
                if (!empty($image_mission_file) && !empty($temp_mission_file))
                {
                    if ($valid_file == true)
                    {
                        if (move_uploaded_file($temp_mission_file, $path))
                        {
                            $cek_gambar_about = mysqli_query($koneksi, "SELECT image_about FROM about WHERE about.category = 'mission'") or die(mysqli_error());
                            if (mysqli_num_rows($cek_gambar_about) == 1)
                            {
                                while ($daftar_about = mysqli_fetch_array($cek_gambar_about))
                                {
                                    $hapus_image = $daftar_about['image_about'];
                                    if (file_exists("../upload/image/about/mission/" . $hapus_image))
                                    {
                                        unlink("../upload/image/about/mission/" . $hapus_image);
                                    }
                                    else
                                    {
                                        header("location: about_mission.php?status_form=gagal_hapus_gambar");
                                    }
                                }
                            }
                            else
                            {
                                header("location: about_mission.php?status_form=tidak_ada_data");
                            }
                        }
                        else
                        {
                            header("location: about_mission.php?status_form=gagal_upload");
                        }

                        $update2 = mysqli_query($koneksi, "UPDATE about SET judul = '$judul_mission', konten = '$konten_mission', image_about = '$gambar_mission_baru' WHERE about.category = 'mission' LIMIT 1") or die(mysqli_error());
                        if ($update2 == true)
                        {
                            header("location: about_mission.php?status_form=berhasil&jenis_form=edit&a");
                        }
                        else
                        {
                            header("location: about_mission.php?status_form=gagal&jenis_form=edit&a");
                        }
                    }
                    else
                    {
                        header("location: about_mission.php?status_form=gambar_tidak_valid");
                    }
                }
                elseif (empty($image_mission_file) && empty($temp_mission_file))
                {
                    $update2 = mysqli_query($koneksi, "UPDATE about SET judul = '$judul_mission', konten = '$konten_mission' WHERE about.category = 'mission' LIMIT 1") or die(mysqli_error());
                    if ($update2 == true)
                    {
                        header("location: about_mission.php?status_form=berhasil&jenis_form=edit&b");
                    }
                    else
                    {
                        header("location: about_mission.php?status_form=gagal&jenis_form=edit&b");
                    }
                }
            }
            else
            {
                header("location: about_mission.php?status_form=tidak_lengkap&a");
            }
        }
        else
        {
            header("location: about_mission.php?status_form=tidak_lengkap&b");
        }
    }

    // tambah teamsupport

    if (isset($_POST['about_teamsupport_tambah']))
    {
        if (isset($_POST['judul_teamsupport']) && isset($_POST['konten_teamsupport']) && isset($_FILES['upload_logo']))
        {
            $judul_teamsupport = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['judul_teamsupport'])));
            $konten_teamsupport = trim(mysqli_real_escape_string($koneksi, $_POST['konten_teamsupport']));
            $valid_file = true;
            $max_size = 100000;
            $glebar = 71;
            $gtinggi = 61;
            $image_teamsupport_file = $_FILES['upload_logo']['name'];
            $temp_teamsupport_file = $_FILES['upload_logo']['tmp_name'];
            $ukuran_teamsupport_file = $_FILES['upload_logo']['size'];
            $jenis_image = strtolower(pathinfo($image_teamsupport_file, PATHINFO_EXTENSION));
            list($lebar, $tinggi) = getimagesize($temp_teamsupport_file);
            if ($ukuran_teamsupport_file > $max_size)
            {
                $valid_file = false;
            }

            if ($jenis_image != "jpg" && $jenis_image != "jpeg" && $jenis_image != "png" && $jenis_image != "gif")
            {
                $valid_file = false;
            }

            if ($lebar != $glebar && $tinggi != $gtinggi)
            {
                $valid_file = false;
            }

            $gambar_about_baru = date('dmYHis') . "_" . strtolower(str_replace(' ', '_', $image_teamsupport_file));
            $path = "../upload/image/about/teamsupport/" . $gambar_about_baru;
            if (!empty($judul_teamsupport) && !empty($konten_teamsupport))
            {
                $seleksi_about_teamsupport = mysqli_query($koneksi, "SELECT * FROM about WHERE category = 'teamsupport' LIMIT 1") or die("<script>alert('Query salah')</script>");
                $jumlah_about_teamsupport = mysqli_num_rows($seleksi_about_teamsupport);
                if ($jumlah_about_teamsupport == 0)
                {
                    if ($valid_file == true)
                    {
                        $input = mysqli_query($koneksi, "INSERT INTO about VALUES (NULL, 'teamsupport', '$judul_teamsupport', '$konten_teamsupport', '$gambar_about_baru')") or die(mysqli_error());
                        if ($input == true)
                        {
                            if (move_uploaded_file($temp_teamsupport_file, $path))
                            {
                                header("location: about_teamsupport.php?status_form=berhasil&jenis_form=tambah");
                            }
                            else
                            {
                                header("location: about_teamsupport.php?status_form=gagal_upload");
                            }
                        }
                    }
                    else
                    {
                        header("location: about_teamsupport.php?status_form=gambar_tidak_valid");
                    }

                    $input = null;
                }
            }
            else
            {
                header("location: about_teamsupport.php?status_form=tidak_ada_data");
            }
        }
        else
        {
            header("location: about_teamsupport.php?status_form=tidak_lengkap&a");
        }
    }

    if (isset($_POST['about_teamsupport_edit']))
    {
        if (isset($_POST['judul_teamsupport']) && isset($_POST['konten_teamsupport']) && isset($_FILES['upload_logo']))
        {
            $judul_teamsupport = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['judul_teamsupport'])));
            $konten_teamsupport = trim(mysqli_real_escape_string($koneksi, $_POST['konten_teamsupport']));
            $max_size = 100000;
            $glebar = 71;
            $gtinggi = 61;
            $image_teamsupport_file = $_FILES['upload_logo']['name'];
            $temp_teamsupport_file = $_FILES['upload_logo']['tmp_name'];
            $ukuran_teamsupport_file = $_FILES['upload_logo']['size'];
            if (!empty($image_teamsupport_file) && !empty($temp_teamsupport_file))
            {
                $valid_file = true;
                $jenis_image = strtolower(pathinfo($image_teamsupport_file, PATHINFO_EXTENSION));
                list($lebar, $tinggi) = getimagesize($temp_teamsupport_file);
                if ($ukuran_teamsupport_file > $max_size)
                {
                    $valid_file = false;
                }

                if ($jenis_image != "jpg" && $jenis_image != "jpeg" && $jenis_image != "png" && $jenis_image != "gif")
                {
                    $valid_file = false;
                }

                if ($lebar != $glebar && $tinggi != $gtinggi)
                {
                    $valid_file = false;
                }

                $gambar_teamsupport_baru = date('dmYHis') . "_" . strtolower(str_replace(' ', '_', $image_teamsupport_file));
                $path = "../upload/image/about/teamsupport/" . $gambar_teamsupport_baru;
            }

            if (!empty($judul_teamsupport) && !empty($konten_teamsupport))
            {
                if (!empty($image_teamsupport_file) && !empty($temp_teamsupport_file))
                {
                    if ($valid_file == true)
                    {
                        if (move_uploaded_file($temp_teamsupport_file, $path))
                        {
                            $cek_gambar_about = mysqli_query($koneksi, "SELECT image_about FROM about WHERE about.category = 'teamsupport'") or die(mysqli_error());
                            if (mysqli_num_rows($cek_gambar_about) == 1)
                            {
                                while ($daftar_about = mysqli_fetch_array($cek_gambar_about))
                                {
                                    $hapus_image = $daftar_about['image_about'];
                                    if (file_exists("../upload/image/about/teamsupport/" . $hapus_image))
                                    {
                                        unlink("../upload/image/about/teamsupport/" . $hapus_image);
                                    }
                                    else
                                    {
                                        header("location: about_teamsupport.php?status_form=gagal_hapus_gambar");
                                    }
                                }
                            }
                            else
                            {
                                header("location: about_teamsupport.php?status_form=tidak_ada_data");
                            }
                        }
                        else
                        {
                            header("location: about_teamsupport.php?status_form=gagal_upload");
                        }

                        $update2 = mysqli_query($koneksi, "UPDATE about SET judul = '$judul_teamsupport', konten = '$konten_teamsupport', image_about = '$gambar_teamsupport_baru' WHERE about.category = 'teamsupport' LIMIT 1") or die(mysqli_error());
                        if ($update2 == true)
                        {
                            header("location: about_teamsupport.php?status_form=berhasil&jenis_form=edit&a");
                        }
                        else
                        {
                            header("location: about_teamsupport.php?status_form=gagal&jenis_form=edit&a");
                        }
                    }
                    else
                    {
                        header("location: about_teamsupport.php?status_form=gambar_tidak_valid");
                    }
                }
                elseif (empty($image_teamsupport_file) && empty($temp_teamsupport_file))
                {
                    $update2 = mysqli_query($koneksi, "UPDATE about SET judul = '$judul_teamsupport', konten = '$konten_teamsupport' WHERE about.category = 'teamsupport' LIMIT 1") or die(mysqli_error());
                    if ($update2 == true)
                    {
                        header("location: about_teamsupport.php?status_form=berhasil&jenis_form=edit&b");
                    }
                    else
                    {
                        header("location: about_teamsupport.php?status_form=gagal&jenis_form=edit&b");
                    }
                }
            }
            else
            {
                header("location: about_teamsupport.php?status_form=tidak_lengkap&a");
            }
        }
        else
        {
            header("location: about_teamsupport.php?status_form=tidak_lengkap&b");
        }
    }

    // tambah teamconsultant

    if (isset($_POST['about_teamconsultant_tambah']))
    {
        if (isset($_POST['judul_teamconsultant']) && isset($_POST['konten_teamconsultant']) && isset($_FILES['upload_logo']))
        {
            $judul_teamconsultant = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['judul_teamconsultant'])));
            $konten_teamconsultant = trim(mysqli_real_escape_string($koneksi, $_POST['konten_teamconsultant']));
            $valid_file = true;
            $max_size = 100000;
            $glebar = 71;
            $gtinggi = 61;
            $image_teamconsultant_file = $_FILES['upload_logo']['name'];
            $temp_teamconsultant_file = $_FILES['upload_logo']['tmp_name'];
            $ukuran_teamconsultant_file = $_FILES['upload_logo']['size'];
            $jenis_image = strtolower(pathinfo($image_teamconsultant_file, PATHINFO_EXTENSION));
            list($lebar, $tinggi) = getimagesize($temp_teamconsultant_file);
            if ($ukuran_teamconsultant_file > $max_size)
            {
                $valid_file = false;
            }

            if ($jenis_image != "jpg" && $jenis_image != "jpeg" && $jenis_image != "png" && $jenis_image != "gif")
            {
                $valid_file = false;
            }

            if ($lebar != $glebar && $tinggi != $gtinggi)
            {
                $valid_file = false;
            }

            $gambar_about_baru = date('dmYHis') . "_" . strtolower(str_replace(' ', '_', $image_teamconsultant_file));
            $path = "../upload/image/about/teamconsultant/" . $gambar_about_baru;
            if (!empty($judul_teamconsultant) && !empty($konten_teamconsultant))
            {
                $seleksi_about_teamconsultant = mysqli_query($koneksi, "SELECT * FROM about WHERE category = 'teamconsultant' LIMIT 1") or die("<script>alert('Query salah')</script>");
                $jumlah_about_teamconsultant = mysqli_num_rows($seleksi_about_teamconsultant);
                if ($jumlah_about_teamconsultant == 0)
                {
                    if ($valid_file == true)
                    {
                        $input = mysqli_query($koneksi, "INSERT INTO about VALUES (NULL, 'teamconsultant', '$judul_teamconsultant', '$konten_teamconsultant', '$gambar_about_baru')") or die(mysqli_error());
                        if ($input == true)
                        {
                            if (move_uploaded_file($temp_teamconsultant_file, $path))
                            {
                                header("location: about_teamconsultant.php?status_form=berhasil&jenis_form=tambah");
                            }
                            else
                            {
                                header("location: about_teamconsultant.php?status_form=gagal_upload");
                            }
                        }
                    }
                    else
                    {
                        header("location: about_teamconsultant.php?status_form=gambar_tidak_valid");
                    }

                    $input = null;
                }
            }
            else
            {
                header("location: about_teamconsultant.php?status_form=tidak_ada_data");
            }
        }
        else
        {
            header("location: about_teamconsultant.php?status_form=tidak_lengkap&a");
        }
    }

    if (isset($_POST['about_teamconsultant_edit']))
    {
        if (isset($_POST['judul_teamconsultant']) && isset($_POST['konten_teamconsultant']) && isset($_FILES['upload_logo']))
        {
            $judul_teamconsultant = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['judul_teamconsultant'])));
            $konten_teamconsultant = trim(mysqli_real_escape_string($koneksi, $_POST['konten_teamconsultant']));
            $max_size = 100000;
            $glebar = 71;
            $gtinggi = 61;
            $image_teamconsultant_file = $_FILES['upload_logo']['name'];
            $temp_teamconsultant_file = $_FILES['upload_logo']['tmp_name'];
            $ukuran_teamconsultant_file = $_FILES['upload_logo']['size'];
            if (!empty($image_teamconsultant_file) && !empty($temp_teamconsultant_file))
            {
                $valid_file = true;
                $jenis_image = strtolower(pathinfo($image_teamconsultant_file, PATHINFO_EXTENSION));
                list($lebar, $tinggi) = getimagesize($temp_teamconsultant_file);
                if ($ukuran_teamconsultant_file > $max_size)
                {
                    $valid_file = false;
                }

                if ($jenis_image != "jpg" && $jenis_image != "jpeg" && $jenis_image != "png" && $jenis_image != "gif")
                {
                    $valid_file = false;
                }

                if ($lebar != $glebar && $tinggi != $gtinggi)
                {
                    $valid_file = false;
                }

                $gambar_teamconsultant_baru = date('dmYHis') . "_" . strtolower(str_replace(' ', '_', $image_teamconsultant_file));
                $path = "../upload/image/about/teamconsultant/" . $gambar_teamconsultant_baru;
            }

            if (!empty($judul_teamconsultant) && !empty($konten_teamconsultant))
            {
                if (!empty($image_teamconsultant_file) && !empty($temp_teamconsultant_file))
                {
                    if ($valid_file == true)
                    {
                        if (move_uploaded_file($temp_teamconsultant_file, $path))
                        {
                            $cek_gambar_about = mysqli_query($koneksi, "SELECT image_about FROM about WHERE about.category = 'teamconsultant'") or die(mysqli_error());
                            if (mysqli_num_rows($cek_gambar_about) == 1)
                            {
                                while ($daftar_about = mysqli_fetch_array($cek_gambar_about))
                                {
                                    $hapus_image = $daftar_about['image_about'];
                                    if (file_exists("../upload/image/about/teamconsultant/" . $hapus_image))
                                    {
                                        unlink("../upload/image/about/teamconsultant/" . $hapus_image);
                                    }
                                    else
                                    {
                                        header("location: about_teamconsultant.php?status_form=gagal_hapus_gambar");
                                    }
                                }
                            }
                            else
                            {
                                header("location: about_teamconsultant.php?status_form=tidak_ada_data");
                            }
                        }
                        else
                        {
                            header("location: about_teamconsultant.php?status_form=gagal_upload");
                        }

                        $update2 = mysqli_query($koneksi, "UPDATE about SET judul = '$judul_teamconsultant', konten = '$konten_teamconsultant', image_about = '$gambar_teamconsultant_baru' WHERE about.category = 'teamconsultant' LIMIT 1") or die(mysqli_error());
                        if ($update2 == true)
                        {
                            header("location: about_teamconsultant.php?status_form=berhasil&jenis_form=edit&a");
                        }
                        else
                        {
                            header("location: about_teamconsultant.php?status_form=gagal&jenis_form=edit&a");
                        }
                    }
                    else
                    {
                        header("location: about_teamconsultant.php?status_form=gambar_tidak_valid");
                    }
                }
                elseif (empty($image_teamconsultant_file) && empty($temp_teamconsultant_file))
                {
                    $update2 = mysqli_query($koneksi, "UPDATE about SET judul = '$judul_teamconsultant', konten = '$konten_teamconsultant' WHERE about.category = 'teamconsultant' LIMIT 1") or die(mysqli_error());
                    if ($update2 == true)
                    {
                        header("location: about_teamconsultant.php?status_form=berhasil&jenis_form=edit&b");
                    }
                    else
                    {
                        header("location: about_teamconsultant.php?status_form=gagal&jenis_form=edit&b");
                    }
                }
            }
            else
            {
                header("location: about_teamconsultant.php?status_form=tidak_lengkap&a");
            }
        }
        else
        {
            header("location: about_teamconsultant.php?status_form=tidak_lengkap&b");
        }
    }

    // tambah appteknologi

    if (isset($_POST['app_teknologi_tambah']))
    {
        if (isset($_POST['judul_app_teknologi']) && isset($_POST['teks_url_app_teknologi']) && isset($_POST['konten_app_teknologi']) && isset($_POST['url_app_teknologi']) && isset($_FILES['upload_cover']))
        {
            if (isset($_POST['app_aktif']) && $_POST['app_aktif'] == 1)
            {
                $app_status = 'ya';
            }
            else
            {
                $app_status = 'tidak';
            }

            $judul_app_teknologi = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['judul_app_teknologi'])));
            $teks_url_app_teknologi = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['teks_url_app_teknologi'])));
            $url_app_teknologi = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['url_app_teknologi'])));
            $konten_app_teknologi = trim(mysqli_real_escape_string($koneksi, $_POST['konten_app_teknologi']));
            $valid_file = true;
            $max_size = 80000;
            $glebar = 700;
            $gtinggi = 700;
            $image_app_teknologi_file = $_FILES['upload_cover']['name'];
            $temp_app_teknologi_file = $_FILES['upload_cover']['tmp_name'];
            $ukuran_app_teknologi_file = $_FILES['upload_cover']['size'];
            $jenis_image = strtolower(pathinfo($image_app_teknologi_file, PATHINFO_EXTENSION));
            list($lebar, $tinggi) = getimagesize($temp_app_teknologi_file);
            if ($ukuran_app_teknologi_file > $max_size)
            {
                $valid_file = false;
            }

            if ($jenis_image != "jpg" && $jenis_image != "jpeg" && $jenis_image != "png" && $jenis_image != "gif")
            {
                $valid_file = false;
            }

            if ($lebar != $glebar && $tinggi != $gtinggi)
            {
                $valid_file = false;
            }

            $gambar_app_baru = date('dmYHis') . "_" . strtolower(str_replace(' ', '_', $image_app_teknologi_file));
            $path = "../upload/image/app/teknologi/" . $gambar_app_baru;
            if (!empty($judul_app_teknologi) && !empty($konten_app_teknologi) && !empty($teks_url_app_teknologi) && !empty($url_app_teknologi))
            {
                $seleksi_app_teknologi = mysqli_query($koneksi, "SELECT * FROM app WHERE kategori_app = 'app_teknologi' LIMIT 1") or die("<script>alert('Query salah')</script>");
                $jumlah_app_teknologi = mysqli_num_rows($seleksi_app_teknologi);
                if ($jumlah_app_teknologi == 0)
                {
                    if ($valid_file == true)
                    {
                        $input = mysqli_query($koneksi, "INSERT INTO app VALUES (NULL, '$judul_app_teknologi', 'app_teknologi', '$gambar_app_baru', '$konten_app_teknologi', '$teks_url_app_teknologi', '$url_app_teknologi', '$app_status')") or die(mysqli_error());
                        if ($input == true)
                        {
                            if (move_uploaded_file($temp_app_teknologi_file, $path))
                            {
                                header("location: app_teknologi.php?status_form=berhasil&jenis_form=tambah");
                            }
                            else
                            {
                                header("location: app_teknologi.php?status_form=gagal_upload");
                            }
                        }
                    }
                    else
                    {
                        header("location: app_teknologi.php?status_form=gambar_tidak_valid");
                    }

                    $input = null;
                }
            }
            else
            {
                header("location: app_teknologi.php?status_form=tidak_ada_data");
            }
        }
        else
        {
            header("location: app_teknologi.php?status_form=tidak_lengkap&a");
        }
    }

    if (isset($_POST['app_teknologi_edit']))
    {
        if (isset($_POST['judul_app_teknologi']) && isset($_POST['teks_url_app_teknologi']) && isset($_POST['konten_app_teknologi']) && isset($_POST['url_app_teknologi']) && isset($_FILES['upload_cover']))
        {
            if (isset($_POST['app_aktif']) && $_POST['app_aktif'] == 1)
            {
                $app_status = 'ya';
            }
            else
            {
                $app_status = 'tidak';
            }

            $judul_app_teknologi = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['judul_app_teknologi'])));
            $teks_url_app_teknologi = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['teks_url_app_teknologi'])));
            $url_app_teknologi = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['url_app_teknologi'])));
            $konten_app_teknologi = trim(mysqli_real_escape_string($koneksi, $_POST['konten_app_teknologi']));
            $max_size = 80000;
            $glebar = 700;
            $gtinggi = 700;
            $image_app_teknologi_file = $_FILES['upload_cover']['name'];
            $temp_app_teknologi_file = $_FILES['upload_cover']['tmp_name'];
            $ukuran_app_teknologi_file = $_FILES['upload_cover']['size'];
            $valid_file = false;
            if (!empty($image_app_teknologi_file) && !empty($temp_app_teknologi_file))
            {
                $valid_file = true;
                $jenis_image = strtolower(pathinfo($image_app_teknologi_file, PATHINFO_EXTENSION));
                list($lebar, $tinggi) = getimagesize($temp_app_teknologi_file);
                if ($ukuran_app_teknologi_file > $max_size)
                {
                    $valid_file = false;
                }

                if ($jenis_image != "jpg" && $jenis_image != "jpeg" && $jenis_image != "png" && $jenis_image != "gif")
                {
                    $valid_file = false;
                }

                if ($lebar != $glebar && $tinggi != $gtinggi)
                {
                    $valid_file = false;
                }

                $gambar_app_baru = date('dmYHis') . "_" . strtolower(str_replace(' ', '_', $image_app_teknologi_file));
                $path = "../upload/image/app/teknologi/" . $gambar_app_baru;
            }

            if (!empty($judul_app_teknologi) && !empty($konten_app_teknologi) && !empty($teks_url_app_teknologi) && !empty($url_app_teknologi))
            {
                if (!empty($image_app_teknologi_file) && !empty($temp_app_teknologi_file))
                {
                    if ($valid_file == true)
                    {
                        if (move_uploaded_file($temp_app_teknologi_file, $path))
                        {
                            $cek_gambar_app_teknologi = mysqli_query($koneksi, "SELECT image_app FROM app WHERE app.kategori_app = 'app_teknologi'") or die(mysqli_error());
                            if (mysqli_num_rows($cek_gambar_app_teknologi) == 1)
                            {
                                while ($daftar_app_teknologi = mysqli_fetch_array($cek_gambar_app_teknologi))
                                {
                                    $hapus_image = $daftar_app_teknologi['image_app'];
                                    if (file_exists("../upload/image/app/teknologi/" . $hapus_image))
                                    {
                                        unlink("../upload/image/app/teknologi/" . $hapus_image);
                                    }
                                    else
                                    {
                                        header("location: app_teknologi.php?status_form=gagal_hapus_gambar");
                                    }
                                }
                            }
                            else
                            {
                                header("location: app_teknologi.php?status_form=tidak_ada_data");
                            }
                        }
                        else
                        {
                            header("location: app_teknologi.php?status_form=gagal_upload");
                        }

                        $update2 = mysqli_query($koneksi, "UPDATE app SET judul_app = '$judul_app_teknologi', image_app = '$gambar_app_baru', konten_app = '$konten_app_teknologi', teks_url = '$teks_url_app_teknologi', url_app = '$url_app_teknologi', aktif = '$app_status' WHERE app.kategori_app = 'app_teknologi' LIMIT 1") or die(mysqli_error());
                        if ($update2 == true)
                        {
                            header("location: app_teknologi.php?status_form=berhasil&jenis_form=edit&a");
                        }
                        else
                        {
                            header("location: app_teknologi.php?status_form=gagal&jenis_form=edit&a");
                        }
                    }
                    else
                    {
                        header("location: app_teknologi.php?status_form=gambar_tidak_valid");
                    }
                }
                elseif (empty($image_app_teknologi_file) && empty($temp_app_teknologi_file))
                {
                    $update2 = mysqli_query($koneksi, "UPDATE app SET judul_app = '$judul_app_teknologi', konten_app = '$konten_app_teknologi', teks_url = '$teks_url_app_teknologi', url_app = '$url_app_teknologi', aktif = '$app_status' WHERE app.kategori_app = 'app_teknologi' LIMIT 1") or die(mysqli_error());
                    if ($update2 == true)
                    {
                        header("location: app_teknologi.php?status_form=berhasil&jenis_form=edit&b");
                    }
                    else
                    {
                        header("location: app_teknologi.php?status_form=gagal&jenis_form=edit&b");
                    }
                }
            }
        }
        else
        {
            header("location: app_teknologi.php?status_form=tidak_lengkap&b");
        }
    }

    // tambah appponsel

    if (isset($_POST['app_ponsel_tambah']))
    {
        if (isset($_POST['judul_app_ponsel']) && isset($_POST['teks_url_app_ponsel']) && isset($_POST['konten_app_ponsel']) && isset($_POST['url_app_ponsel']) && isset($_FILES['upload_cover']))
        {
            if (isset($_POST['app_aktif']) && $_POST['app_aktif'] == 1)
            {
                $app_status = 'ya';
            }
            else
            {
                $app_status = 'tidak';
            }

            $judul_app_ponsel = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['judul_app_ponsel'])));
            $teks_url_app_ponsel = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['teks_url_app_ponsel'])));
            $url_app_ponsel = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['url_app_ponsel'])));
            $konten_app_ponsel = trim(mysqli_real_escape_string($koneksi, $_POST['konten_app_ponsel']));
            $valid_file = true;
            $max_size = 80000;
            $glebar = 700;
            $gtinggi = 700;
            $image_app_ponsel_file = $_FILES['upload_cover']['name'];
            $temp_app_ponsel_file = $_FILES['upload_cover']['tmp_name'];
            $ukuran_app_ponsel_file = $_FILES['upload_cover']['size'];
            $jenis_image = strtolower(pathinfo($image_app_ponsel_file, PATHINFO_EXTENSION));
            list($lebar, $tinggi) = getimagesize($temp_app_ponsel_file);
            if ($ukuran_app_ponsel_file > $max_size)
            {
                $valid_file = false;
            }

            if ($jenis_image != "jpg" && $jenis_image != "jpeg" && $jenis_image != "png" && $jenis_image != "gif")
            {
                $valid_file = false;
            }

            if ($lebar != $glebar && $tinggi != $gtinggi)
            {
                $valid_file = false;
            }

            $gambar_app_baru = date('dmYHis') . "_" . strtolower(str_replace(' ', '_', $image_app_ponsel_file));
            $path = "../upload/image/app/ponsel/" . $gambar_app_baru;
            if (!empty($judul_app_ponsel) && !empty($konten_app_ponsel) && !empty($teks_url_app_ponsel) && !empty($url_app_ponsel))
            {
                $seleksi_app_ponsel = mysqli_query($koneksi, "SELECT * FROM app WHERE kategori_app = 'app_ponsel' LIMIT 1") or die("<script>alert('Query salah')</script>");
                $jumlah_app_ponsel = mysqli_num_rows($seleksi_app_ponsel);
                if ($jumlah_app_ponsel == 0)
                {
                    if ($valid_file == true)
                    {
                        $input = mysqli_query($koneksi, "INSERT INTO app VALUES (NULL, '$judul_app_ponsel', 'app_ponsel', '$gambar_app_baru', '$konten_app_ponsel', '$teks_url_app_ponsel', '$url_app_ponsel', '$app_status')") or die(mysqli_error());
                        if ($input == true)
                        {
                            if (move_uploaded_file($temp_app_ponsel_file, $path))
                            {
                                header("location: app_ponsel.php?status_form=berhasil&jenis_form=tambah");
                            }
                            else
                            {
                                header("location: app_ponsel.php?status_form=gagal_upload");
                            }
                        }
                    }
                    else
                    {
                        header("location: app_ponsel.php?status_form=gambar_tidak_valid");
                    }

                    $input = null;
                }
            }
            else
            {
                header("location: app_ponsel.php?status_form=tidak_ada_data");
            }
        }
        else
        {
            header("location: app_ponsel.php?status_form=tidak_lengkap&a");
        }
    }

    if (isset($_POST['app_ponsel_edit']))
    {
        if (isset($_POST['judul_app_ponsel']) && isset($_POST['teks_url_app_ponsel']) && isset($_POST['konten_app_ponsel']) && isset($_POST['url_app_ponsel']) && isset($_FILES['upload_cover']))
        {
            if (isset($_POST['app_aktif']) && $_POST['app_aktif'] == 1)
            {
                $app_status = 'ya';
            }
            else
            {
                $app_status = 'tidak';
            }

            $judul_app_ponsel = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['judul_app_ponsel'])));
            $teks_url_app_ponsel = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['teks_url_app_ponsel'])));
            $url_app_ponsel = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['url_app_ponsel'])));
            $konten_app_ponsel = trim(mysqli_real_escape_string($koneksi, $_POST['konten_app_ponsel']));
            $max_size = 80000;
            $glebar = 700;
            $gtinggi = 700;
            $image_app_ponsel_file = $_FILES['upload_cover']['name'];
            $temp_app_ponsel_file = $_FILES['upload_cover']['tmp_name'];
            $ukuran_app_ponsel_file = $_FILES['upload_cover']['size'];
            if (!empty($image_app_ponsel_file) && !empty($temp_app_ponsel_file))
            {
                $valid_file = true;
                $jenis_image = strtolower(pathinfo($image_app_ponsel_file, PATHINFO_EXTENSION));
                list($lebar, $tinggi) = getimagesize($temp_app_ponsel_file);
                if ($ukuran_app_ponsel_file > $max_size)
                {
                    $valid_file = false;
                }

                if ($jenis_image != "jpg" && $jenis_image != "jpeg" && $jenis_image != "png" && $jenis_image != "gif")
                {
                    $valid_file = false;
                }

                if ($lebar != $glebar && $tinggi != $gtinggi)
                {
                    $valid_file = false;
                }

                $gambar_app_baru = date('dmYHis') . "_" . strtolower(str_replace(' ', '_', $image_app_ponsel_file));
                $path = "../upload/image/app/ponsel/" . $gambar_app_baru;
            }

            if (!empty($judul_app_ponsel) && !empty($konten_app_ponsel) && !empty($teks_url_app_ponsel) && !empty($url_app_ponsel))
            {
                if (!empty($image_app_ponsel_file) && !empty($temp_app_ponsel_file))
                {
                    if ($valid_file == true)
                    {
                        if (move_uploaded_file($temp_app_ponsel_file, $path))
                        {
                            $cek_gambar_app_ponsel = mysqli_query($koneksi, "SELECT image_app FROM app WHERE app.kategori_app = 'app_ponsel'") or die(mysqli_error());
                            if (mysqli_num_rows($cek_gambar_app_ponsel) == 1)
                            {
                                while ($daftar_app_ponsel = mysqli_fetch_array($cek_gambar_app_ponsel))
                                {
                                    $hapus_image = $daftar_app_ponsel['image_app'];
                                    if (file_exists("../upload/image/app/ponsel/" . $hapus_image))
                                    {
                                        unlink("../upload/image/app/ponsel/" . $hapus_image);
                                    }
                                    else
                                    {
                                        header("location: app_ponsel.php?status_form=gagal_hapus_gambar");
                                    }
                                }
                            }
                            else
                            {
                                header("location: app_ponsel.php?status_form=tidak_ada_data");
                            }
                        }
                        else
                        {
                            header("location: app_ponsel.php?status_form=gagal_upload");
                        }

                        $update2 = mysqli_query($koneksi, "UPDATE app SET judul_app = '$judul_app_ponsel', image_app = '$gambar_app_baru', konten_app = '$konten_app_ponsel', teks_url = '$teks_url_app_ponsel', url_app = '$url_app_ponsel', aktif = '$app_status' WHERE app.kategori_app = 'app_ponsel' LIMIT 1") or die(mysqli_error());
                        if ($update2 == true)
                        {
                            header("location: app_ponsel.php?status_form=berhasil&jenis_form=edit&a");
                        }
                        else
                        {
                            header("location: app_ponsel.php?status_form=gagal&jenis_form=edit&a");
                        }
                    }
                    else
                    {
                        header("location: app_ponsel.php?status_form=gambar_tidak_valid");
                    }
                }
                elseif (empty($image_app_ponsel_file) && empty($temp_app_ponsel_file))
                {
                    $update2 = mysqli_query($koneksi, "UPDATE app SET judul_app = '$judul_app_ponsel', konten_app = '$konten_app_ponsel', teks_url = '$teks_url_app_ponsel', url_app = '$url_app_ponsel', aktif = '$app_status' WHERE app.kategori_app = 'app_ponsel' LIMIT 1") or die(mysqli_error());
                    if ($update2 == true)
                    {
                        header("location: app_ponsel.php?status_form=berhasil&jenis_form=edit&b");
                    }
                    else
                    {
                        header("location: app_ponsel.php?status_form=gagal&jenis_form=edit&b");
                    }
                }
            }
            else
            {
                header("location: app_ponsel.php?status_form=tidak_lengkap&a");
            }
        }
        else
        {
            header("location: app_ponsel.php?status_form=tidak_lengkap&b");
        }
    }

    // tambah apptravel

    if (isset($_POST['app_travel_tambah']))
    {
        if (isset($_POST['judul_app_travel']) && isset($_POST['teks_url_app_travel']) && isset($_POST['konten_app_travel']) && isset($_POST['url_app_travel']) && isset($_FILES['upload_cover']))
        {
            if (isset($_POST['app_aktif']) && $_POST['app_aktif'] == 1)
            {
                $app_status = 'ya';
            }
            else
            {
                $app_status = 'tidak';
            }

            $judul_app_travel = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['judul_app_travel'])));
            $teks_url_app_travel = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['teks_url_app_travel'])));
            $url_app_travel = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['url_app_travel'])));
            $konten_app_travel = trim(mysqli_real_escape_string($koneksi, $_POST['konten_app_travel']));
            $valid_file = true;
            $max_size = 80000;
            $glebar = 700;
            $gtinggi = 700;
            $image_app_travel_file = $_FILES['upload_cover']['name'];
            $temp_app_travel_file = $_FILES['upload_cover']['tmp_name'];
            $ukuran_app_travel_file = $_FILES['upload_cover']['size'];
            $jenis_image = strtolower(pathinfo($image_app_travel_file, PATHINFO_EXTENSION));
            list($lebar, $tinggi) = getimagesize($temp_app_travel_file);
            if ($ukuran_app_travel_file > $max_size)
            {
                $valid_file = false;
            }

            if ($jenis_image != "jpg" && $jenis_image != "jpeg" && $jenis_image != "png" && $jenis_image != "gif")
            {
                $valid_file = false;
            }

            if ($lebar != $glebar && $tinggi != $gtinggi)
            {
                $valid_file = false;
            }

            $gambar_app_baru = date('dmYHis') . "_" . strtolower(str_replace(' ', '_', $image_app_travel_file));
            $path = "../upload/image/app/travel/" . $gambar_app_baru;
            if (!empty($judul_app_travel) && !empty($konten_app_travel) && !empty($teks_url_app_travel) && !empty($url_app_travel))
            {
                $seleksi_app_travel = mysqli_query($koneksi, "SELECT * FROM app WHERE kategori_app = 'app_travel' LIMIT 1") or die("<script>alert('Query salah')</script>");
                $jumlah_app_travel = mysqli_num_rows($seleksi_app_travel);
                if ($jumlah_app_travel == 0)
                {
                    if ($valid_file == true)
                    {
                        $input = mysqli_query($koneksi, "INSERT INTO app VALUES (NULL, '$judul_app_travel', 'app_travel', '$gambar_app_baru', '$konten_app_travel', '$teks_url_app_travel', '$url_app_travel', '$app_status')") or die(mysqli_error());
                        if ($input == true)
                        {
                            if (move_uploaded_file($temp_app_travel_file, $path))
                            {
                                header("location: app_travel.php?status_form=berhasil&jenis_form=tambah");
                            }
                            else
                            {
                                header("location: app_travel.php?status_form=gagal_upload");
                            }
                        }
                    }
                    else
                    {
                        header("location: app_travel.php?status_form=gambar_tidak_valid");
                    }

                    $input = null;
                }
            }
            else
            {
                header("location: app_travel.php?status_form=tidak_ada_data");
            }
        }
        else
        {
            header("location: app_travel.php?status_form=tidak_lengkap&a");
        }
    }

    if (isset($_POST['app_travel_edit']))
    {
        if (isset($_POST['judul_app_travel']) && isset($_POST['teks_url_app_travel']) && isset($_POST['konten_app_travel']) && isset($_POST['url_app_travel']) && isset($_FILES['upload_cover']))
        {
            if (isset($_POST['app_aktif']) && $_POST['app_aktif'] == 1)
            {
                $app_status = 'ya';
            }
            else
            {
                $app_status = 'tidak';
            }

            $judul_app_travel = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['judul_app_travel'])));
            $teks_url_app_travel = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['teks_url_app_travel'])));
            $url_app_travel = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['url_app_travel'])));
            $konten_app_travel = trim(mysqli_real_escape_string($koneksi, $_POST['konten_app_travel']));
            $max_size = 80000;
            $glebar = 700;
            $gtinggi = 700;
            $image_app_travel_file = $_FILES['upload_cover']['name'];
            $temp_app_travel_file = $_FILES['upload_cover']['tmp_name'];
            $ukuran_app_travel_file = $_FILES['upload_cover']['size'];
            if (!empty($image_app_travel_file) && !empty($temp_app_travel_file))
            {
                $valid_file = true;
                $jenis_image = strtolower(pathinfo($image_app_travel_file, PATHINFO_EXTENSION));
                list($lebar, $tinggi) = getimagesize($temp_app_travel_file);
                if ($ukuran_app_travel_file > $max_size)
                {
                    $valid_file = false;
                }

                if ($jenis_image != "jpg" && $jenis_image != "jpeg" && $jenis_image != "png" && $jenis_image != "gif")
                {
                    $valid_file = false;
                }

                if ($lebar != $glebar && $tinggi != $gtinggi)
                {
                    $valid_file = false;
                }

                $gambar_app_baru = date('dmYHis') . "_" . strtolower(str_replace(' ', '_', $image_app_travel_file));
                $path = "../upload/image/app/travel/" . $gambar_app_baru;
            }

            if (!empty($judul_app_travel) && !empty($konten_app_travel) && !empty($teks_url_app_travel) && !empty($url_app_travel))
            {
                if (!empty($image_app_travel_file) && !empty($temp_app_travel_file))
                {
                    if ($valid_file == true)
                    {
                        if (move_uploaded_file($temp_app_travel_file, $path))
                        {
                            $cek_gambar_app_travel = mysqli_query($koneksi, "SELECT image_app FROM app WHERE app.kategori_app = 'app_travel'") or die(mysqli_error());
                            if (mysqli_num_rows($cek_gambar_app_travel) == 1)
                            {
                                while ($daftar_app_travel = mysqli_fetch_array($cek_gambar_app_travel))
                                {
                                    $hapus_image = $daftar_app_travel['image_app'];
                                    if (file_exists("../upload/image/app/travel/" . $hapus_image))
                                    {
                                        unlink("../upload/image/app/travel/" . $hapus_image);
                                    }
                                    else
                                    {
                                        header("location: app_travel.php?status_form=gagal_hapus_gambar");
                                    }
                                }
                            }
                            else
                            {
                                header("location: app_travel.php?status_form=tidak_ada_data");
                            }
                        }
                        else
                        {
                            header("location: app_travel.php?status_form=gagal_upload");
                        }

                        $update2 = mysqli_query($koneksi, "UPDATE app SET judul_app = '$judul_app_travel', image_app = '$gambar_app_baru', konten_app = '$konten_app_travel', teks_url = '$teks_url_app_travel', url_app = '$url_app_travel', aktif = '$app_status' WHERE app.kategori_app = 'app_travel' LIMIT 1") or die(mysqli_error());
                        if ($update2 == true)
                        {
                            header("location: app_travel.php?status_form=berhasil&jenis_form=edit&a");
                        }
                        else
                        {
                            header("location: app_travel.php?status_form=gagal&jenis_form=edit&a");
                        }
                    }
                    else
                    {
                        header("location: app_travel.php?status_form=gambar_tidak_valid");
                    }
                }
                elseif (empty($image_app_travel_file) && empty($temp_app_travel_file))
                {
                    $update2 = mysqli_query($koneksi, "UPDATE app SET judul_app = '$judul_app_travel', konten_app = '$konten_app_travel', teks_url = '$teks_url_app_travel', url_app = '$url_app_travel', aktif = '$app_status' WHERE app.kategori_app = 'app_travel' LIMIT 1") or die(mysqli_error());
                    if ($update2 == true)
                    {
                        header("location: app_travel.php?status_form=berhasil&jenis_form=edit&b");
                    }
                    else
                    {
                        header("location: app_travel.php?status_form=gagal&jenis_form=edit&b");
                    }
                }
            }
            else
            {
                header("location: app_travel.php?status_form=tidak_lengkap&a");
            }
        }
        else
        {
            header("location: app_travel.php?status_form=tidak_lengkap&b");
        }
    }

    // tambah appperkakas

    if (isset($_POST['app_perkakas_tambah']))
    {
        if (isset($_POST['judul_app_perkakas']) && isset($_POST['teks_url_app_perkakas']) && isset($_POST['konten_app_perkakas']) && isset($_POST['url_app_perkakas']) && isset($_FILES['upload_cover']))
        {
            if (isset($_POST['app_aktif']) && $_POST['app_aktif'] == 1)
            {
                $app_status = 'ya';
            }
            else
            {
                $app_status = 'tidak';
            }

            $judul_app_perkakas = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['judul_app_perkakas'])));
            $teks_url_app_perkakas = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['teks_url_app_perkakas'])));
            $url_app_perkakas = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['url_app_perkakas'])));
            $konten_app_perkakas = trim(mysqli_real_escape_string($koneksi, $_POST['konten_app_perkakas']));
            $valid_file = true;
            $max_size = 80000;
            $glebar = 700;
            $gtinggi = 700;
            $image_app_perkakas_file = $_FILES['upload_cover']['name'];
            $temp_app_perkakas_file = $_FILES['upload_cover']['tmp_name'];
            $ukuran_app_perkakas_file = $_FILES['upload_cover']['size'];
            $jenis_image = strtolower(pathinfo($image_app_perkakas_file, PATHINFO_EXTENSION));
            list($lebar, $tinggi) = getimagesize($temp_app_perkakas_file);
            if ($ukuran_app_perkakas_file > $max_size)
            {
                $valid_file = false;
            }

            if ($jenis_image != "jpg" && $jenis_image != "jpeg" && $jenis_image != "png" && $jenis_image != "gif")
            {
                $valid_file = false;
            }

            if ($lebar != $glebar && $tinggi != $gtinggi)
            {
                $valid_file = false;
            }

            $gambar_app_baru = date('dmYHis') . "_" . strtolower(str_replace(' ', '_', $image_app_perkakas_file));
            $path = "../upload/image/app/perkakas/" . $gambar_app_baru;
            if (!empty($judul_app_perkakas) && !empty($konten_app_perkakas) && !empty($teks_url_app_perkakas) && !empty($url_app_perkakas))
            {
                $seleksi_app_perkakas = mysqli_query($koneksi, "SELECT * FROM app WHERE kategori_app = 'app_perkakas' LIMIT 1") or die("<script>alert('Query salah')</script>");
                $jumlah_app_perkakas = mysqli_num_rows($seleksi_app_perkakas);
                if ($jumlah_app_perkakas == 0)
                {
                    if ($valid_file == true)
                    {
                        $input = mysqli_query($koneksi, "INSERT INTO app VALUES (NULL, '$judul_app_perkakas', 'app_perkakas', '$gambar_app_baru', '$konten_app_perkakas', '$teks_url_app_perkakas', '$url_app_perkakas', '$app_status')") or die(mysqli_error());
                        if ($input == true)
                        {
                            if (move_uploaded_file($temp_app_perkakas_file, $path))
                            {
                                header("location: app_perkakas.php?status_form=berhasil&jenis_form=tambah");
                            }
                            else
                            {
                                header("location: app_perkakas.php?status_form=gagal_upload");
                            }
                        }
                    }
                    else
                    {
                        header("location: app_perkakas.php?status_form=gambar_tidak_valid");
                    }

                    $input = null;
                }
            }
            else
            {
                header("location: app_perkakas.php?status_form=tidak_ada_data");
            }
        }
        else
        {
            header("location: app_perkakas.php?status_form=tidak_lengkap&a");
        }
    }

    if (isset($_POST['app_perkakas_edit']))
    {
        if (isset($_POST['judul_app_perkakas']) && isset($_POST['teks_url_app_perkakas']) && isset($_POST['konten_app_perkakas']) && isset($_POST['url_app_perkakas']) && isset($_FILES['upload_cover']))
        {
            if (isset($_POST['app_aktif']) && $_POST['app_aktif'] == 1)
            {
                $app_status = 'ya';
            }
            else
            {
                $app_status = 'tidak';
            }

            $judul_app_perkakas = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['judul_app_perkakas'])));
            $teks_url_app_perkakas = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['teks_url_app_perkakas'])));
            $url_app_perkakas = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['url_app_perkakas'])));
            $konten_app_perkakas = trim(mysqli_real_escape_string($koneksi, $_POST['konten_app_perkakas']));
            $max_size = 80000;
            $glebar = 700;
            $gtinggi = 700;
            $image_app_perkakas_file = $_FILES['upload_cover']['name'];
            $temp_app_perkakas_file = $_FILES['upload_cover']['tmp_name'];
            $ukuran_app_perkakas_file = $_FILES['upload_cover']['size'];
            if (!empty($image_app_perkakas_file) && !empty($temp_app_perkakas_file))
            {
                $valid_file = true;
                $jenis_image = strtolower(pathinfo($image_app_perkakas_file, PATHINFO_EXTENSION));
                list($lebar, $tinggi) = getimagesize($temp_app_perkakas_file);
                if ($ukuran_app_perkakas_file > $max_size)
                {
                    $valid_file = false;
                }

                if ($jenis_image != "jpg" && $jenis_image != "jpeg" && $jenis_image != "png" && $jenis_image != "gif")
                {
                    $valid_file = false;
                }

                if ($lebar != $glebar && $tinggi != $gtinggi)
                {
                    $valid_file = false;
                }

                $gambar_app_baru = date('dmYHis') . "_" . strtolower(str_replace(' ', '_', $image_app_perkakas_file));
                $path = "../upload/image/app/perkakas/" . $gambar_app_baru;
            }

            if (!empty($judul_app_perkakas) && !empty($konten_app_perkakas) && !empty($teks_url_app_perkakas) && !empty($url_app_perkakas))
            {
                if (!empty($image_app_perkakas_file) && !empty($temp_app_perkakas_file))
                {
                    if ($valid_file == true)
                    {
                        if (move_uploaded_file($temp_app_perkakas_file, $path))
                        {
                            $cek_gambar_app_perkakas = mysqli_query($koneksi, "SELECT image_app FROM app WHERE app.kategori_app = 'app_perkakas'") or die(mysqli_error());
                            if (mysqli_num_rows($cek_gambar_app_perkakas) == 1)
                            {
                                while ($daftar_app_perkakas = mysqli_fetch_array($cek_gambar_app_perkakas))
                                {
                                    $hapus_image = $daftar_app_perkakas['image_app'];
                                    if (file_exists("../upload/image/app/perkakas/" . $hapus_image))
                                    {
                                        unlink("../upload/image/app/perkakas/" . $hapus_image);
                                    }
                                    else
                                    {
                                        header("location: app_perkakas.php?status_form=gagal_hapus_gambar");
                                    }
                                }
                            }
                            else
                            {
                                header("location: app_perkakas.php?status_form=tidak_ada_data");
                            }
                        }
                        else
                        {
                            header("location: app_perkakas.php?status_form=gagal_upload");
                        }

                        $update2 = mysqli_query($koneksi, "UPDATE app SET judul_app = '$judul_app_perkakas', image_app = '$gambar_app_baru', konten_app = '$konten_app_perkakas', teks_url = '$teks_url_app_perkakas', url_app = '$url_app_perkakas', aktif = '$app_status' WHERE app.kategori_app = 'app_perkakas' LIMIT 1") or die(mysqli_error());
                        if ($update2 == true)
                        {
                            header("location: app_perkakas.php?status_form=berhasil&jenis_form=edit&a");
                        }
                        else
                        {
                            header("location: app_perkakas.php?status_form=gagal&jenis_form=edit&a");
                        }
                    }
                    else
                    {
                        header("location: app_perkakas.php?status_form=gambar_tidak_valid");
                    }
                }
                elseif (empty($image_app_perkakas_file) && empty($temp_app_perkakas_file))
                {
                    $update2 = mysqli_query($koneksi, "UPDATE app SET judul_app = '$judul_app_perkakas', konten_app = '$konten_app_perkakas', teks_url = '$teks_url_app_perkakas', url_app = '$url_app_perkakas', aktif = '$app_status' WHERE app.kategori_app = 'app_perkakas' LIMIT 1") or die(mysqli_error());
                    if ($update2 == true)
                    {
                        header("location: app_perkakas.php?status_form=berhasil&jenis_form=edit&b");
                    }
                    else
                    {
                        header("location: app_perkakas.php?status_form=gagal&jenis_form=edit&b");
                    }
                }
            }
            else
            {
                header("location: app_perkakas.php?status_form=tidak_lengkap&a");
            }
        }
        else
        {
            header("location: app_perkakas.php?status_form=tidak_lengkap&b");
        }
    }

    // tambah appoffice

    if (isset($_POST['app_office_tambah']))
    {
        if (isset($_POST['judul_app_office']) && isset($_POST['teks_url_app_office']) && isset($_POST['konten_app_office']) && isset($_POST['url_app_office']) && isset($_FILES['upload_cover']))
        {
            if (isset($_POST['app_aktif']) && $_POST['app_aktif'] == 1)
            {
                $app_status = 'ya';
            }
            else
            {
                $app_status = 'tidak';
            }

            $judul_app_office = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['judul_app_office'])));
            $teks_url_app_office = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['teks_url_app_office'])));
            $url_app_office = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['url_app_office'])));
            $konten_app_office = trim(mysqli_real_escape_string($koneksi, $_POST['konten_app_office']));
            $valid_file = true;
            $max_size = 80000;
            $glebar = 700;
            $gtinggi = 700;
            $image_app_office_file = $_FILES['upload_cover']['name'];
            $temp_app_office_file = $_FILES['upload_cover']['tmp_name'];
            $ukuran_app_office_file = $_FILES['upload_cover']['size'];
            $jenis_image = strtolower(pathinfo($image_app_office_file, PATHINFO_EXTENSION));
            list($lebar, $tinggi) = getimagesize($temp_app_office_file);
            if ($ukuran_app_office_file > $max_size)
            {
                $valid_file = false;
            }

            if ($jenis_image != "jpg" && $jenis_image != "jpeg" && $jenis_image != "png" && $jenis_image != "gif")
            {
                $valid_file = false;
            }

            if ($lebar != $glebar && $tinggi != $gtinggi)
            {
                $valid_file = false;
            }

            $gambar_app_baru = date('dmYHis') . "_" . strtolower(str_replace(' ', '_', $image_app_office_file));
            $path = "../upload/image/app/office/" . $gambar_app_baru;
            if (!empty($judul_app_office) && !empty($konten_app_office) && !empty($teks_url_app_office) && !empty($url_app_office))
            {
                $seleksi_app_office = mysqli_query($koneksi, "SELECT * FROM app WHERE kategori_app = 'app_office' LIMIT 1") or die("<script>alert('Query salah')</script>");
                $jumlah_app_office = mysqli_num_rows($seleksi_app_office);
                if ($jumlah_app_office == 0)
                {
                    if ($valid_file == true)
                    {
                        $input = mysqli_query($koneksi, "INSERT INTO app VALUES (NULL, '$judul_app_office', 'app_office', '$gambar_app_baru', '$konten_app_office', '$teks_url_app_office', '$url_app_office', '$app_status')") or die(mysqli_error());
                        if ($input == true)
                        {
                            if (move_uploaded_file($temp_app_office_file, $path))
                            {
                                header("location: app_office.php?status_form=berhasil&jenis_form=tambah");
                            }
                            else
                            {
                                header("location: app_office.php?status_form=gagal_upload");
                            }
                        }
                    }
                    else
                    {
                        header("location: app_office.php?status_form=gambar_tidak_valid");
                    }

                    $input = null;
                }
            }
            else
            {
                header("location: app_office.php?status_form=tidak_ada_data");
            }
        }
        else
        {
            header("location: app_office.php?status_form=tidak_lengkap&a");
        }
    }

    if (isset($_POST['app_office_edit']))
    {
        if (isset($_POST['judul_app_office']) && isset($_POST['teks_url_app_office']) && isset($_POST['konten_app_office']) && isset($_POST['url_app_office']) && isset($_FILES['upload_cover']))
        {
            if (isset($_POST['app_aktif']) && $_POST['app_aktif'] == 1)
            {
                $app_status = 'ya';
            }
            else
            {
                $app_status = 'tidak';
            }

            $judul_app_office = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['judul_app_office'])));
            $teks_url_app_office = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['teks_url_app_office'])));
            $url_app_office = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['url_app_office'])));
            $konten_app_office = trim(mysqli_real_escape_string($koneksi, $_POST['konten_app_office']));
            $max_size = 80000;
            $glebar = 700;
            $gtinggi = 700;
            $image_app_office_file = $_FILES['upload_cover']['name'];
            $temp_app_office_file = $_FILES['upload_cover']['tmp_name'];
            $ukuran_app_office_file = $_FILES['upload_cover']['size'];
            if (!empty($image_app_office_file) && !empty($temp_app_office_file))
            {
                $valid_file = true;
                $jenis_image = strtolower(pathinfo($image_app_office_file, PATHINFO_EXTENSION));
                list($lebar, $tinggi) = getimagesize($temp_app_office_file);
                if ($ukuran_app_office_file > $max_size)
                {
                    $valid_file = false;
                }

                if ($jenis_image != "jpg" && $jenis_image != "jpeg" && $jenis_image != "png" && $jenis_image != "gif")
                {
                    $valid_file = false;
                }

                if ($lebar != $glebar && $tinggi != $gtinggi)
                {
                    $valid_file = false;
                }

                $gambar_app_baru = date('dmYHis') . "_" . strtolower(str_replace(' ', '_', $image_app_office_file));
                $path = "../upload/image/app/office/" . $gambar_app_baru;
            }

            if (!empty($judul_app_office) && !empty($konten_app_office) && !empty($teks_url_app_office) && !empty($url_app_office))
            {
                if (!empty($image_app_office_file) && !empty($temp_app_office_file))
                {
                    if ($valid_file == true)
                    {
                        if (move_uploaded_file($temp_app_office_file, $path))
                        {
                            $cek_gambar_app_office = mysqli_query($koneksi, "SELECT image_app FROM app WHERE app.kategori_app = 'app_office'") or die(mysqli_error());
                            if (mysqli_num_rows($cek_gambar_app_office) == 1)
                            {
                                while ($daftar_app_office = mysqli_fetch_array($cek_gambar_app_office))
                                {
                                    $hapus_image = $daftar_app_office['image_app'];
                                    if (file_exists("../upload/image/app/office/" . $hapus_image))
                                    {
                                        unlink("../upload/image/app/office/" . $hapus_image);
                                    }
                                    else
                                    {
                                        header("location: app_office.php?status_form=gagal_hapus_gambar");
                                    }
                                }
                            }
                            else
                            {
                                header("location: app_office.php?status_form=tidak_ada_data");
                            }
                        }
                        else
                        {
                            header("location: app_office.php?status_form=gagal_upload");
                        }

                        $update2 = mysqli_query($koneksi, "UPDATE app SET judul_app = '$judul_app_office', image_app = '$gambar_app_baru', konten_app = '$konten_app_office', teks_url = '$teks_url_app_office', url_app = '$url_app_office', aktif = '$app_status' WHERE app.kategori_app = 'app_office' LIMIT 1") or die(mysqli_error());
                        if ($update2 == true)
                        {
                            header("location: app_office.php?status_form=berhasil&jenis_form=edit&a");
                        }
                        else
                        {
                            header("location: app_office.php?status_form=gagal&jenis_form=edit&a");
                        }
                    }
                    else
                    {
                        header("location: app_office.php?status_form=gambar_tidak_valid");
                    }
                }
                elseif (empty($image_app_office_file) && empty($temp_app_office_file))
                {
                    $update2 = mysqli_query($koneksi, "UPDATE app SET judul_app = '$judul_app_office', konten_app = '$konten_app_office', teks_url = '$teks_url_app_office', url_app = '$url_app_office', aktif = '$app_status' WHERE app.kategori_app = 'app_office' LIMIT 1") or die(mysqli_error());
                    if ($update2 == true)
                    {
                        header("location: app_office.php?status_form=berhasil&jenis_form=edit&b");
                    }
                    else
                    {
                        header("location: app_office.php?status_form=gagal&jenis_form=edit&b");
                    }
                }
            }
            else
            {
                header("location: app_office.php?status_form=tidak_lengkap&a");
            }
        }
        else
        {
            header("location: app_office.php?status_form=tidak_lengkap&b");
        }
    }

    // tambah appkesehatan

    if (isset($_POST['app_kesehatan_tambah']))
    {
        if (isset($_POST['judul_app_kesehatan']) && isset($_POST['teks_url_app_kesehatan']) && isset($_POST['konten_app_kesehatan']) && isset($_POST['url_app_kesehatan']) && isset($_FILES['upload_cover']))
        {
            if (isset($_POST['app_aktif']) && $_POST['app_aktif'] == 1)
            {
                $app_status = 'ya';
            }
            else
            {
                $app_status = 'tidak';
            }

            $judul_app_kesehatan = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['judul_app_kesehatan'])));
            $teks_url_app_kesehatan = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['teks_url_app_kesehatan'])));
            $url_app_kesehatan = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['url_app_kesehatan'])));
            $konten_app_kesehatan = trim(mysqli_real_escape_string($koneksi, $_POST['konten_app_kesehatan']));
            $valid_file = true;
            $max_size = 80000;
            $glebar = 494;
            $gtinggi = 494;
            $image_app_kesehatan_file = $_FILES['upload_cover']['name'];
            $temp_app_kesehatan_file = $_FILES['upload_cover']['tmp_name'];
            $ukuran_app_kesehatan_file = $_FILES['upload_cover']['size'];
            $jenis_image = strtolower(pathinfo($image_app_kesehatan_file, PATHINFO_EXTENSION));
            list($lebar, $tinggi) = getimagesize($temp_app_kesehatan_file);
            if ($ukuran_app_kesehatan_file > $max_size)
            {
                $valid_file = false;
            }

            if ($jenis_image != "jpg" && $jenis_image != "jpeg" && $jenis_image != "png" && $jenis_image != "gif")
            {
                $valid_file = false;
            }

            if ($lebar != $glebar && $tinggi != $gtinggi)
            {
                $valid_file = false;
            }

            $gambar_app_baru = date('dmYHis') . "_" . strtolower(str_replace(' ', '_', $image_app_kesehatan_file));
            $path = "../upload/image/app/kesehatan/" . $gambar_app_baru;
            if (!empty($judul_app_kesehatan) && !empty($konten_app_kesehatan) && !empty($teks_url_app_kesehatan) && !empty($url_app_kesehatan))
            {
                $seleksi_app_kesehatan = mysqli_query($koneksi, "SELECT * FROM app WHERE kategori_app = 'app_kesehatan' LIMIT 1") or die("<script>alert('Query salah')</script>");
                $jumlah_app_kesehatan = mysqli_num_rows($seleksi_app_kesehatan);
                if ($jumlah_app_kesehatan == 0)
                {
                    if ($valid_file == true)
                    {
                        $input = mysqli_query($koneksi, "INSERT INTO app VALUES (NULL, '$judul_app_kesehatan', 'app_kesehatan', '$gambar_app_baru', '$konten_app_kesehatan', '$teks_url_app_kesehatan', '$url_app_kesehatan', '$app_status')") or die(mysqli_error());
                        if ($input == true)
                        {
                            if (move_uploaded_file($temp_app_kesehatan_file, $path))
                            {
                                header("location: app_kesehatan.php?status_form=berhasil&jenis_form=tambah");
                            }
                            else
                            {
                                header("location: app_kesehatan.php?status_form=gagal_upload");
                            }
                        }
                    }
                    else
                    {
                        header("location: app_kesehatan.php?status_form=gambar_tidak_valid");
                    }

                    $input = null;
                }
            }
            else
            {
                header("location: app_kesehatan.php?status_form=tidak_ada_data");
            }
        }
        else
        {
            header("location: app_kesehatan.php?status_form=tidak_lengkap&a");
        }
    }

    if (isset($_POST['app_kesehatan_edit']))
    {
        if (isset($_POST['judul_app_kesehatan']) && isset($_POST['teks_url_app_kesehatan']) && isset($_POST['konten_app_kesehatan']) && isset($_POST['url_app_kesehatan']) && isset($_FILES['upload_cover']))
        {
            if (isset($_POST['app_aktif']) && $_POST['app_aktif'] == 1)
            {
                $app_status = 'ya';
            }
            else
            {
                $app_status = 'tidak';
            }

            $judul_app_kesehatan = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['judul_app_kesehatan'])));
            $teks_url_app_kesehatan = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['teks_url_app_kesehatan'])));
            $url_app_kesehatan = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['url_app_kesehatan'])));
            $konten_app_kesehatan = trim(mysqli_real_escape_string($koneksi, $_POST['konten_app_kesehatan']));
            $max_size = 80000;
            $glebar = 494;
            $gtinggi = 494;
            $image_app_kesehatan_file = $_FILES['upload_cover']['name'];
            $temp_app_kesehatan_file = $_FILES['upload_cover']['tmp_name'];
            $ukuran_app_kesehatan_file = $_FILES['upload_cover']['size'];
            if (!empty($image_app_kesehatan_file) && !empty($konten_app_kesehatan) && !empty($temp_app_kesehatan_file))
            {
                $valid_file = true;
                $jenis_image = strtolower(pathinfo($image_app_kesehatan_file, PATHINFO_EXTENSION));
                list($lebar, $tinggi) = getimagesize($temp_app_kesehatan_file);
                if ($ukuran_app_kesehatan_file > $max_size)
                {
                    $valid_file = false;
                }

                if ($jenis_image != "jpg" && $jenis_image != "jpeg" && $jenis_image != "png" && $jenis_image != "gif")
                {
                    $valid_file = false;
                }

                if ($lebar != $glebar && $tinggi != $gtinggi)
                {
                    $valid_file = false;
                }

                $gambar_app_baru = date('dmYHis') . "_" . strtolower(str_replace(' ', '_', $image_app_kesehatan_file));
                $path = "../upload/image/app/kesehatan/" . $gambar_app_baru;
            }

            if (!empty($judul_app_kesehatan) && !empty($teks_url_app_kesehatan) && !empty($url_app_kesehatan))
            {
                if (!empty($image_app_kesehatan_file) && !empty($temp_app_kesehatan_file))
                {
                    if ($valid_file == true)
                    {
                        if (move_uploaded_file($temp_app_kesehatan_file, $path))
                        {
                            $cek_gambar_app_kesehatan = mysqli_query($koneksi, "SELECT image_app FROM app WHERE app.kategori_app = 'app_kesehatan'") or die(mysqli_error());
                            if (mysqli_num_rows($cek_gambar_app_kesehatan) == 1)
                            {
                                while ($daftar_app_kesehatan = mysqli_fetch_array($cek_gambar_app_kesehatan))
                                {
                                    $hapus_image = $daftar_app_kesehatan['image_app'];
                                    if (file_exists("../upload/image/app/kesehatan/" . $hapus_image))
                                    {
                                        unlink("../upload/image/app/kesehatan/" . $hapus_image);
                                    }
                                    else
                                    {
                                        header("location: app_kesehatan.php?status_form=gagal_hapus_gambar");
                                    }
                                }
                            }
                            else
                            {
                                header("location: app_kesehatan.php?status_form=tidak_ada_data");
                            }
                        }
                        else
                        {
                            header("location: app_kesehatan.php?status_form=gagal_upload");
                        }

                        $update2 = mysqli_query($koneksi, "UPDATE app SET judul_app = '$judul_app_kesehatan', konten_app = '$konten_app_kesehatan', image_app = '$gambar_app_baru', teks_url = '$teks_url_app_kesehatan', url_app = '$url_app_kesehatan', aktif = '$app_status' WHERE app.kategori_app = 'app_kesehatan' LIMIT 1") or die(mysqli_error());
                        if ($update2 == true)
                        {
                            header("location: app_kesehatan.php?status_form=berhasil&jenis_form=edit&a");
                        }
                        else
                        {
                            header("location: app_kesehatan.php?status_form=gagal&jenis_form=edit&a");
                        }
                    }
                    else
                    {
                        header("location: app_kesehatan.php?status_form=gambar_tidak_valid");
                    }
                }
                elseif (empty($image_app_kesehatan_file) && empty($temp_app_kesehatan_file))
                {
                    $update2 = mysqli_query($koneksi, "UPDATE app SET judul_app = '$judul_app_kesehatan', konten_app = '$konten_app_kesehatan', teks_url = '$teks_url_app_kesehatan', url_app = '$url_app_kesehatan', aktif = '$app_status' WHERE app.kategori_app = 'app_kesehatan' LIMIT 1") or die(mysqli_error());
                    if ($update2 == true)
                    {
                        header("location: app_kesehatan.php?status_form=berhasil&jenis_form=edit&b");
                    }
                    else
                    {
                        header("location: app_kesehatan.php?status_form=gagal&jenis_form=edit&b");
                    }
                }
            }
            else
            {
                header("location: app_kesehatan.php?status_form=tidak_lengkap&a");
            }
        }
        else
        {
            header("location: app_kesehatan.php?status_form=tidak_lengkap&b");
        }
    }

    // tambah appbuku

    if (isset($_POST['app_buku_tambah']))
    {
        if (isset($_POST['judul_app_buku']) && isset($_POST['teks_url_app_buku']) && isset($_POST['url_app_buku']) && isset($_POST['konten_app_buku']) && isset($_FILES['upload_cover']))
        {
            if (isset($_POST['app_aktif']) && $_POST['app_aktif'] == 1)
            {
                $app_status = 'ya';
            }
            else
            {
                $app_status = 'tidak';
            }

            $judul_app_buku = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['judul_app_buku'])));
            $teks_url_app_buku = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['teks_url_app_buku'])));
            $url_app_buku = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['url_app_buku'])));
            $konten_app_buku = trim(mysqli_real_escape_string($koneksi, $_POST['konten_app_buku']));
            $valid_file = true;
            $max_size = 80000;
            $glebar = 494;
            $gtinggi = 494;
            $image_app_buku_file = $_FILES['upload_cover']['name'];
            $temp_app_buku_file = $_FILES['upload_cover']['tmp_name'];
            $ukuran_app_buku_file = $_FILES['upload_cover']['size'];
            $jenis_image = strtolower(pathinfo($image_app_buku_file, PATHINFO_EXTENSION));
            list($lebar, $tinggi) = getimagesize($temp_app_buku_file);
            if ($ukuran_app_buku_file > $max_size)
            {
                $valid_file = false;
            }

            if ($jenis_image != "jpg" && $jenis_image != "jpeg" && $jenis_image != "png" && $jenis_image != "gif")
            {
                $valid_file = false;
            }

            if ($lebar != $glebar && $tinggi != $gtinggi)
            {
                $valid_file = false;
            }

            $gambar_app_baru = date('dmYHis') . "_" . strtolower(str_replace(' ', '_', $image_app_buku_file));
            $path = "../upload/image/app/buku/" . $gambar_app_baru;
            if (!empty($judul_app_buku) && !empty($konten_app_buku) && !empty($teks_url_app_buku) && !empty($url_app_buku))
            {
                $seleksi_app_buku = mysqli_query($koneksi, "SELECT * FROM app WHERE kategori_app = 'app_buku' LIMIT 1") or die("<script>alert('Query salah')</script>");
                $jumlah_app_buku = mysqli_num_rows($seleksi_app_buku);
                if ($jumlah_app_buku == 0)
                {
                    if ($valid_file == true)
                    {
                        $input = mysqli_query($koneksi, "INSERT INTO app VALUES (NULL, '$judul_app_buku', 'app_buku', '$gambar_app_baru', '$konten_app_buku', '$teks_url_app_buku', '$url_app_buku', '$app_status')") or die(mysqli_error());
                        if ($input == true)
                        {
                            if (move_uploaded_file($temp_app_buku_file, $path))
                            {
                                header("location: app_buku.php?status_form=berhasil&jenis_form=tambah");
                            }
                            else
                            {
                                header("location: app_buku.php?status_form=gagal_upload");
                            }
                        }
                    }
                    else
                    {
                        header("location: app_buku.php?status_form=gambar_tidak_valid");
                    }

                    $input = null;
                }
            }
            else
            {
                header("location: app_buku.php?status_form=tidak_ada_data");
            }
        }
        else
        {
            header("location: app_buku.php?status_form=tidak_lengkap&a");
        }
    }

    if (isset($_POST['app_buku_edit']))
    {
        if (isset($_POST['judul_app_buku']) && isset($_POST['teks_url_app_buku']) && isset($_POST['url_app_buku']) && isset($_POST['konten_app_buku']) && isset($_FILES['upload_cover']))
        {
            if (isset($_POST['app_aktif']) && $_POST['app_aktif'] == 1)
            {
                $app_status = 'ya';
            }
            else
            {
                $app_status = 'tidak';
            }

            $judul_app_buku = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['judul_app_buku'])));
            $teks_url_app_buku = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['teks_url_app_buku'])));
            $url_app_buku = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['url_app_buku'])));
            $konten_app_buku = trim(mysqli_real_escape_string($koneksi, $_POST['konten_app_buku']));
            $max_size = 80000;
            $glebar = 494;
            $gtinggi = 494;
            $image_app_buku_file = $_FILES['upload_cover']['name'];
            $temp_app_buku_file = $_FILES['upload_cover']['tmp_name'];
            $ukuran_app_buku_file = $_FILES['upload_cover']['size'];
            if (!empty($image_app_buku_file) && !empty($temp_app_buku_file))
            {
                $valid_file = true;
                $jenis_image = strtolower(pathinfo($image_app_buku_file, PATHINFO_EXTENSION));
                list($lebar, $tinggi) = getimagesize($temp_app_buku_file);
                if ($ukuran_app_buku_file > $max_size)
                {
                    $valid_file = false;
                }

                if ($jenis_image != "jpg" && $jenis_image != "jpeg" && $jenis_image != "png" && $jenis_image != "gif")
                {
                    $valid_file = false;
                }

                if ($lebar != $glebar && $tinggi != $gtinggi)
                {
                    $valid_file = false;
                }

                $gambar_app_baru = date('dmYHis') . "_" . strtolower(str_replace(' ', '_', $image_app_buku_file));
                $path = "../upload/image/app/buku/" . $gambar_app_baru;
            }

            if (!empty($judul_app_buku) && !empty($konten_app_buku) && !empty($teks_url_app_buku) && !empty($url_app_buku))
            {
                if (!empty($image_app_buku_file) && !empty($temp_app_buku_file))
                {
                    if ($valid_file == true)
                    {
                        if (move_uploaded_file($temp_app_buku_file, $path))
                        {
                            $cek_gambar_app_buku = mysqli_query($koneksi, "SELECT image_app FROM app WHERE app.kategori_app = 'app_buku'") or die(mysqli_error());
                            if (mysqli_num_rows($cek_gambar_app_buku) == 1)
                            {
                                while ($daftar_app_buku = mysqli_fetch_array($cek_gambar_app_buku))
                                {
                                    $hapus_image = $daftar_app_buku['image_app'];
                                    if (file_exists("../upload/image/app/buku/" . $hapus_image))
                                    {
                                        unlink("../upload/image/app/buku/" . $hapus_image);
                                    }
                                    else
                                    {
                                        header("location: app_buku.php?status_form=gagal_hapus_gambar");
                                    }
                                }
                            }
                            else
                            {
                                header("location: app_buku.php?status_form=tidak_ada_data");
                            }
                        }
                        else
                        {
                            header("location: app_buku.php?status_form=gagal_upload");
                        }

                        $update2 = mysqli_query($koneksi, "UPDATE app SET judul_app = '$judul_app_buku', image_app = '$gambar_app_baru', konten_app = '$konten_app_buku', teks_url = '$teks_url_app_buku', url_app = '$url_app_buku', aktif = '$app_status' WHERE app.kategori_app = 'app_buku' LIMIT 1") or die(mysqli_error());
                        if ($update2 == true)
                        {
                            header("location: app_buku.php?status_form=berhasil&jenis_form=edit&a");
                        }
                        else
                        {
                            header("location: app_buku.php?status_form=gagal&jenis_form=edit&a");
                        }
                    }
                    else
                    {
                        header("location: app_buku.php?status_form=gambar_tidak_valid");
                    }
                }
                elseif (empty($image_app_buku_file) && empty($temp_app_buku_file))
                {
                    $update2 = mysqli_query($koneksi, "UPDATE app SET judul_app = '$judul_app_buku', konten_app = '$konten_app_buku', teks_url = '$teks_url_app_buku', url_app = '$url_app_buku', aktif = '$app_status' WHERE app.kategori_app = 'app_buku' LIMIT 1") or die(mysqli_error());
                    if ($update2 == true)
                    {
                        header("location: app_buku.php?status_form=berhasil&jenis_form=edit&b");
                    }
                    else
                    {
                        header("location: app_buku.php?status_form=gagal&jenis_form=edit&b");
                    }
                }
            }
            else
            {
                header("location: app_buku.php?status_form=tidak_lengkap&a");
            }
        }
        else
        {
            header("location: app_buku.php?status_form=tidak_lengkap&b");
        }
    }

    // tambah appukm

    if (isset($_POST['app_ukm_tambah']))
    {
        if (isset($_POST['judul_app_ukm']) && isset($_POST['teks_url_app_ukm']) && isset($_POST['konten_app_ukm']) && isset($_POST['url_app_ukm']) && isset($_FILES['upload_cover']))
        {
            if (isset($_POST['app_aktif']) && $_POST['app_aktif'] == 1)
            {
                $app_status = 'ya';
            }
            else
            {
                $app_status = 'tidak';
            }

            $judul_app_ukm = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['judul_app_ukm'])));
            $teks_url_app_ukm = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['teks_url_app_ukm'])));
            $url_app_ukm = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['url_app_ukm'])));
            $konten_app_ukm = trim(mysqli_real_escape_string($koneksi, $_POST['konten_app_ukm']));
            $valid_file = true;
            $max_size = 80000;
            $glebar = 494;
            $gtinggi = 494;
            $image_app_ukm_file = $_FILES['upload_cover']['name'];
            $temp_app_ukm_file = $_FILES['upload_cover']['tmp_name'];
            $ukuran_app_ukm_file = $_FILES['upload_cover']['size'];
            $jenis_image = strtolower(pathinfo($image_app_ukm_file, PATHINFO_EXTENSION));
            list($lebar, $tinggi) = getimagesize($temp_app_ukm_file);
            if ($ukuran_app_ukm_file > $max_size)
            {
                $valid_file = false;
            }

            if ($jenis_image != "jpg" && $jenis_image != "jpeg" && $jenis_image != "png" && $jenis_image != "gif")
            {
                $valid_file = false;
            }

            if ($lebar != $glebar && $tinggi != $gtinggi)
            {
                $valid_file = false;
            }

            $gambar_app_baru = date('dmYHis') . "_" . strtolower(str_replace(' ', '_', $image_app_ukm_file));
            $path = "../upload/image/app/ukm/" . $gambar_app_baru;
            if (!empty($judul_app_ukm) && !empty($konten_app_ukm) && !empty($teks_url_app_ukm) && !empty($url_app_ukm))
            {
                $seleksi_app_ukm = mysqli_query($koneksi, "SELECT * FROM app WHERE kategori_app = 'app_ukm' LIMIT 1") or die("<script>alert('Query salah')</script>");
                $jumlah_app_ukm = mysqli_num_rows($seleksi_app_ukm);
                if ($jumlah_app_ukm == 0)
                {
                    if ($valid_file == true)
                    {
                        $input = mysqli_query($koneksi, "INSERT INTO app VALUES (NULL, '$judul_app_ukm', 'app_ukm', '$gambar_app_baru', '$konten_app_ukm', '$teks_url_app_ukm', '$url_app_ukm', '$app_status')") or die(mysqli_error());
                        if ($input == true)
                        {
                            if (move_uploaded_file($temp_app_ukm_file, $path))
                            {
                                header("location: app_ukm.php?status_form=berhasil&jenis_form=tambah");
                            }
                            else
                            {
                                header("location: app_ukm.php?status_form=gagal_upload");
                            }
                        }
                    }
                    else
                    {
                        header("location: app_ukm.php?status_form=gambar_tidak_valid");
                    }

                    $input = null;
                }
            }
            else
            {
                header("location: app_ukm.php?status_form=tidak_ada_data");
            }
        }
        else
        {
            header("location: app_ukm.php?status_form=tidak_lengkap&a");
        }
    }

    if (isset($_POST['app_ukm_edit']))
    {
        if (isset($_POST['judul_app_ukm']) && isset($_POST['teks_url_app_ukm']) && isset($_POST['konten_app_ukm']) && isset($_POST['url_app_ukm']) && isset($_FILES['upload_cover']))
        {
            if (isset($_POST['app_aktif']) && $_POST['app_aktif'] == 1)
            {
                $app_status = 'ya';
            }
            else
            {
                $app_status = 'tidak';
            }

            $judul_app_ukm = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['judul_app_ukm'])));
            $teks_url_app_ukm = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['teks_url_app_ukm'])));
            $url_app_ukm = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['url_app_ukm'])));
            $konten_app_ukm = trim(mysqli_real_escape_string($koneksi, $_POST['konten_app_ukm']));
            $max_size = 80000;
            $glebar = 494;
            $gtinggi = 494;
            $image_app_ukm_file = $_FILES['upload_cover']['name'];
            $temp_app_ukm_file = $_FILES['upload_cover']['tmp_name'];
            $ukuran_app_ukm_file = $_FILES['upload_cover']['size'];
            if (!empty($image_app_ukm_file) && !empty($temp_app_ukm_file))
            {
                $valid_file = true;
                $jenis_image = strtolower(pathinfo($image_app_ukm_file, PATHINFO_EXTENSION));
                list($lebar, $tinggi) = getimagesize($temp_app_ukm_file);
                if ($ukuran_app_ukm_file > $max_size)
                {
                    $valid_file = false;
                }

                if ($jenis_image != "jpg" && $jenis_image != "jpeg" && $jenis_image != "png" && $jenis_image != "gif")
                {
                    $valid_file = false;
                }

                if ($lebar != $glebar && $tinggi != $gtinggi)
                {
                    $valid_file = false;
                }

                $gambar_app_baru = date('dmYHis') . "_" . strtolower(str_replace(' ', '_', $image_app_ukm_file));
                $path = "../upload/image/app/ukm/" . $gambar_app_baru;
            }

            if (!empty($judul_app_ukm) && !empty($konten_app_ukm) && !empty($teks_url_app_ukm) && !empty($url_app_ukm))
            {
                if (!empty($image_app_ukm_file) && !empty($temp_app_ukm_file))
                {
                    if ($valid_file == true)
                    {
                        if (move_uploaded_file($temp_app_ukm_file, $path))
                        {
                            $cek_gambar_app_ukm = mysqli_query($koneksi, "SELECT image_app FROM app WHERE app.kategori_app = 'app_ukm'") or die(mysqli_error());
                            if (mysqli_num_rows($cek_gambar_app_ukm) == 1)
                            {
                                while ($daftar_app_ukm = mysqli_fetch_array($cek_gambar_app_ukm))
                                {
                                    $hapus_image = $daftar_app_ukm['image_app'];
                                    if (file_exists("../upload/image/app/ukm/" . $hapus_image))
                                    {
                                        unlink("../upload/image/app/ukm/" . $hapus_image);
                                    }
                                    else
                                    {
                                        header("location: app_ukm.php?status_form=gagal_hapus_gambar");
                                    }
                                }
                            }
                            else
                            {
                                header("location: app_ukm.php?status_form=tidak_ada_data");
                            }
                        }
                        else
                        {
                            header("location: app_ukm.php?status_form=gagal_upload");
                        }

                        $update2 = mysqli_query($koneksi, "UPDATE app SET judul_app = '$judul_app_ukm', image_app = '$gambar_app_baru', konten_app = '$konten_app_ukm', teks_url = '$teks_url_app_ukm', url_app = '$url_app_ukm', aktif = '$app_status' WHERE app.kategori_app = 'app_ukm' LIMIT 1") or die(mysqli_error());
                        if ($update2 == true)
                        {
                            header("location: app_ukm.php?status_form=berhasil&jenis_form=edit&a");
                        }
                        else
                        {
                            header("location: app_ukm.php?status_form=gagal&jenis_form=edit&a");
                        }
                    }
                    else
                    {
                        header("location: app_ukm.php?status_form=gambar_tidak_valid");
                    }
                }
                elseif (empty($image_app_ukm_file) && empty($temp_app_ukm_file))
                {
                    $update2 = mysqli_query($koneksi, "UPDATE app SET judul_app = '$judul_app_ukm', konten_app = '$konten_app_ukm', teks_url = '$teks_url_app_ukm', url_app = '$url_app_ukm', aktif = '$app_status' WHERE app.kategori_app = 'app_ukm' LIMIT 1") or die(mysqli_error());
                    if ($update2 == true)
                    {
                        header("location: app_ukm.php?status_form=berhasil&jenis_form=edit&b");
                    }
                    else
                    {
                        header("location: app_ukm.php?status_form=gagal&jenis_form=edit&b");
                    }
                }
            }
            else
            {
                header("location: app_ukm.php?status_form=tidak_lengkap&a");
            }
        }
        else
        {
            header("location: app_ukm.php?status_form=tidak_lengkap&b");
        }
    }

    // tambah appotomotif

    if (isset($_POST['app_otomotif_tambah']))
    {
        if (isset($_POST['judul_app_otomotif']) && isset($_POST['teks_url_app_otomotif']) && isset($_POST['konten_app_otomotif']) && isset($_POST['url_app_otomotif']) && isset($_FILES['upload_cover']))
        {
            if (isset($_POST['app_aktif']) && $_POST['app_aktif'] == 1)
            {
                $app_status = 'ya';
            }
            else
            {
                $app_status = 'tidak';
            }

            $judul_app_otomotif = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['judul_app_otomotif'])));
            $teks_url_app_otomotif = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['teks_url_app_otomotif'])));
            $url_app_otomotif = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['url_app_otomotif'])));
            $konten_app_otomotif = trim(mysqli_real_escape_string($koneksi, $_POST['konten_app_otomotif']));
            $valid_file = true;
            $max_size = 80000;
            $glebar = 494;
            $gtinggi = 494;
            $image_app_otomotif_file = $_FILES['upload_cover']['name'];
            $temp_app_otomotif_file = $_FILES['upload_cover']['tmp_name'];
            $ukuran_app_otomotif_file = $_FILES['upload_cover']['size'];
            $jenis_image = strtolower(pathinfo($image_app_otomotif_file, PATHINFO_EXTENSION));
            list($lebar, $tinggi) = getimagesize($temp_app_otomotif_file);
            if ($ukuran_app_otomotif_file > $max_size)
            {
                $valid_file = false;
            }

            if ($jenis_image != "jpg" && $jenis_image != "jpeg" && $jenis_image != "png" && $jenis_image != "gif")
            {
                $valid_file = false;
            }

            if ($lebar != $glebar && $tinggi != $gtinggi)
            {
                $valid_file = false;
            }

            $gambar_app_baru = date('dmYHis') . "_" . strtolower(str_replace(' ', '_', $image_app_otomotif_file));
            $path = "../upload/image/app/otomotif/" . $gambar_app_baru;
            if (!empty($judul_app_otomotif) && !empty($konten_app_otomotif) && !empty($teks_url_app_otomotif) && !empty($url_app_otomotif))
            {
                $seleksi_app_otomotif = mysqli_query($koneksi, "SELECT * FROM app WHERE kategori_app = 'app_otomotif' LIMIT 1") or die("<script>alert('Query salah')</script>");
                $jumlah_app_otomotif = mysqli_num_rows($seleksi_app_otomotif);
                if ($jumlah_app_otomotif == 0)
                {
                    if ($valid_file == true)
                    {
                        $input = mysqli_query($koneksi, "INSERT INTO app VALUES (NULL, '$judul_app_otomotif', 'app_otomotif', '$gambar_app_baru', , '$konten_app_otomotif', '$teks_url_app_otomotif', '$url_app_otomotif', '$app_status')") or die(mysqli_error());
                        if ($input == true)
                        {
                            if (move_uploaded_file($temp_app_otomotif_file, $path))
                            {
                                header("location: app_otomotif.php?status_form=berhasil&jenis_form=tambah");
                            }
                            else
                            {
                                header("location: app_otomotif.php?status_form=gagal_upload");
                            }
                        }
                    }
                    else
                    {
                        header("location: app_otomotif.php?status_form=gambar_tidak_valid");
                    }

                    $input = null;
                }
            }
            else
            {
                header("location: app_otomotif.php?status_form=tidak_ada_data");
            }
        }
        else
        {
            header("location: app_otomotif.php?status_form=tidak_lengkap&a");
        }
    }

    if (isset($_POST['app_otomotif_edit']))
    {
        if (isset($_POST['judul_app_otomotif']) && isset($_POST['teks_url_app_otomotif']) && isset($_POST['konten_app_otomotif']) && isset($_POST['url_app_otomotif']) && isset($_FILES['upload_cover']))
        {
            if (isset($_POST['app_aktif']) && $_POST['app_aktif'] == 1)
            {
                $app_status = 'ya';
            }
            else
            {
                $app_status = 'tidak';
            }

            $judul_app_otomotif = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['judul_app_otomotif'])));
            $teks_url_app_otomotif = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['teks_url_app_otomotif'])));
            $url_app_otomotif = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['url_app_otomotif'])));
            $konten_app_otomotif = trim(mysqli_real_escape_string($koneksi, $_POST['konten_app_otomotif']));
            $max_size = 80000;
            $glebar = 494;
            $gtinggi = 700;
            $image_app_otomotif_file = $_FILES['upload_cover']['name'];
            $temp_app_otomotif_file = $_FILES['upload_cover']['tmp_name'];
            $ukuran_app_otomotif_file = $_FILES['upload_cover']['size'];
            if (!empty($image_app_otomotif_file) && !empty($temp_app_otomotif_file))
            {
                $valid_file = true;
                $jenis_image = strtolower(pathinfo($image_app_otomotif_file, PATHINFO_EXTENSION));
                list($lebar, $tinggi) = getimagesize($temp_app_otomotif_file);
                if ($ukuran_app_otomotif_file > $max_size)
                {
                    $valid_file = false;
                }

                if ($jenis_image != "jpg" && $jenis_image != "jpeg" && $jenis_image != "png" && $jenis_image != "gif")
                {
                    $valid_file = false;
                }

                if ($lebar != $glebar && $tinggi != $gtinggi)
                {
                    $valid_file = false;
                }

                $gambar_app_baru = date('dmYHis') . "_" . strtolower(str_replace(' ', '_', $image_app_otomotif_file));
                $path = "../upload/image/app/otomotif/" . $gambar_app_baru;
            }

            if (!empty($judul_app_otomotif) && !empty($konten_app_otomotif) && !empty($teks_url_app_otomotif) && !empty($url_app_otomotif))
            {
                if (!empty($image_app_otomotif_file) && !empty($temp_app_otomotif_file))
                {
                    if ($valid_file == true)
                    {
                        if (move_uploaded_file($temp_app_otomotif_file, $path))
                        {
                            $cek_gambar_app_otomotif = mysqli_query($koneksi, "SELECT image_app FROM app WHERE app.kategori_app = 'app_otomotif'") or die(mysqli_error());
                            if (mysqli_num_rows($cek_gambar_app_otomotif) == 1)
                            {
                                while ($daftar_app_otomotif = mysqli_fetch_array($cek_gambar_app_otomotif))
                                {
                                    $hapus_image = $daftar_app_otomotif['image_app'];
                                    if (file_exists("../upload/image/app/otomotif/" . $hapus_image))
                                    {
                                        unlink("../upload/image/app/otomotif/" . $hapus_image);
                                    }
                                    else
                                    {
                                        header("location: app_otomotif.php?status_form=gagal_hapus_gambar");
                                    }
                                }
                            }
                            else
                            {
                                header("location: app_otomotif.php?status_form=tidak_ada_data");
                            }
                        }
                        else
                        {
                            header("location: app_otomotif.php?status_form=gagal_upload");
                        }

                        $update2 = mysqli_query($koneksi, "UPDATE app SET judul_app = '$judul_app_otomotif', image_app = '$gambar_app_baru', konten_app = '$konten_app_otomotif', teks_url = '$teks_url_app_otomotif', url_app = '$url_app_otomotif', aktif = '$app_status' WHERE app.kategori_app = 'app_otomotif' LIMIT 1") or die(mysqli_error());
                        if ($update2 == true)
                        {
                            header("location: app_otomotif.php?status_form=berhasil&jenis_form=edit&a");
                        }
                        else
                        {
                            header("location: app_otomotif.php?status_form=gagal&jenis_form=edit&a");
                        }
                    }
                    else
                    {
                        header("location: app_otomotif.php?status_form=gambar_tidak_valid");
                    }
                }
                elseif (empty($image_app_otomotif_file) && empty($temp_app_otomotif_file))
                {
                    $update2 = mysqli_query($koneksi, "UPDATE app SET judul_app = '$judul_app_otomotif', konten_app = '$konten_app_otomotif', teks_url = '$teks_url_app_otomotif', url_app = '$url_app_otomotif', aktif = '$app_status' WHERE app.kategori_app = 'app_otomotif' LIMIT 1") or die(mysqli_error());
                    if ($update2 == true)
                    {
                        header("location: app_otomotif.php?status_form=berhasil&jenis_form=edit&b");
                    }
                    else
                    {
                        header("location: app_otomotif.php?status_form=gagal&jenis_form=edit&b");
                    }
                }
            }
            else
            {
                header("location: app_otomotif.php?status_form=tidak_lengkap&a");
            }
        }
        else
        {
            header("location: app_otomotif.php?status_form=tidak_lengkap&b");
        }
    }

    // tambah apphome

    if (isset($_POST['app_home_tambah']))
    {
        if (isset($_POST['judul_app_home']) && isset($_POST['teks_url_app_home']) && isset($_POST['konten_app_home']) && isset($_POST['url_app_home']) && isset($_FILES['upload_cover']))
        {
            if (isset($_POST['app_aktif']) && $_POST['app_aktif'] == 1)
            {
                $app_status = 'ya';
            }
            else
            {
                $app_status = 'tidak';
            }

            $judul_app_home = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['judul_app_home'])));
            $teks_url_app_home = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['teks_url_app_home'])));
            $url_app_home = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['url_app_home'])));
            $konten_app_home = trim(mysqli_real_escape_string($koneksi, $_POST['konten_app_home']));
            $valid_file = true;
            $max_size = 80000;
            $glebar = 494;
            $gtinggi = 494;
            $image_app_home_file = $_FILES['upload_cover']['name'];
            $temp_app_home_file = $_FILES['upload_cover']['tmp_name'];
            $ukuran_app_home_file = $_FILES['upload_cover']['size'];
            $jenis_image = strtolower(pathinfo($image_app_home_file, PATHINFO_EXTENSION));
            list($lebar, $tinggi) = getimagesize($temp_app_home_file);
            if ($ukuran_app_home_file > $max_size)
            {
                $valid_file = false;
            }

            if ($jenis_image != "jpg" && $jenis_image != "jpeg" && $jenis_image != "png" && $jenis_image != "gif")
            {
                $valid_file = false;
            }

            if ($lebar != $glebar && $tinggi != $gtinggi)
            {
                $valid_file = false;
            }

            $gambar_app_baru = date('dmYHis') . "_" . strtolower(str_replace(' ', '_', $image_app_home_file));
            $path = "../upload/image/app/home/" . $gambar_app_baru;
            if (!empty($judul_app_home) && !empty($konten_app_home) && !empty($teks_url_app_home) && !empty($url_app_home))
            {
                $seleksi_app_home = mysqli_query($koneksi, "SELECT * FROM app WHERE kategori_app = 'app_home' LIMIT 1") or die("<script>alert('Query salah')</script>");
                $jumlah_app_home = mysqli_num_rows($seleksi_app_home);
                if ($jumlah_app_home == 0)
                {
                    if ($valid_file == true)
                    {
                        $input = mysqli_query($koneksi, "INSERT INTO app VALUES (NULL, '$judul_app_home', 'app_home', '$gambar_app_baru', , '$konten_app_home', '$teks_url_app_home', '$url_app_home', '$app_status')") or die(mysqli_error());
                        if ($input == true)
                        {
                            if (move_uploaded_file($temp_app_home_file, $path))
                            {
                                header("location: app_home.php?status_form=berhasil&jenis_form=tambah");
                            }
                            else
                            {
                                header("location: app_home.php?status_form=gagal_upload");
                            }
                        }
                    }
                    else
                    {
                        header("location: app_home.php?status_form=gambar_tidak_valid");
                    }

                    $input = null;
                }
            }
            else
            {
                header("location: app_home.php?status_form=tidak_ada_data");
            }
        }
        else
        {
            header("location: app_home.php?status_form=tidak_lengkap&a");
        }
    }

    if (isset($_POST['app_home_edit']))
    {
        if (isset($_POST['judul_app_home']) && isset($_POST['teks_url_app_home']) && isset($_POST['konten_app_home']) && isset($_POST['url_app_home']) && isset($_FILES['upload_cover']))
        {
            if (isset($_POST['app_aktif']) && $_POST['app_aktif'] == 1)
            {
                $app_status = 'ya';
            }
            else
            {
                $app_status = 'tidak';
            }

            $judul_app_home = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['judul_app_home'])));
            $teks_url_app_home = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['teks_url_app_home'])));
            $url_app_home = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['url_app_home'])));
            $konten_app_home = trim(mysqli_real_escape_string($koneksi, $_POST['konten_app_home']));
            $max_size = 80000;
            $glebar = 494;
            $gtinggi = 494;
            $image_app_home_file = $_FILES['upload_cover']['name'];
            $temp_app_home_file = $_FILES['upload_cover']['tmp_name'];
            $ukuran_app_home_file = $_FILES['upload_cover']['size'];
            if (!empty($image_app_home_file) && !empty($temp_app_home_file))
            {
                $valid_file = true;
                $jenis_image = strtolower(pathinfo($image_app_home_file, PATHINFO_EXTENSION));
                list($lebar, $tinggi) = getimagesize($temp_app_home_file);
                if ($ukuran_app_home_file > $max_size)
                {
                    $valid_file = false;
                }

                if ($jenis_image != "jpg" && $jenis_image != "jpeg" && $jenis_image != "png" && $jenis_image != "gif")
                {
                    $valid_file = false;
                }

                if ($lebar != $glebar && $tinggi != $gtinggi)
                {
                    $valid_file = false;
                }

                $gambar_app_baru = date('dmYHis') . "_" . strtolower(str_replace(' ', '_', $image_app_home_file));
                $path = "../upload/image/app/home/" . $gambar_app_baru;
            }

            if (!empty($judul_app_home) && !empty($konten_app_home) && !empty($teks_url_app_home) && !empty($url_app_home))
            {
                if (!empty($image_app_home_file) && !empty($temp_app_home_file))
                {
                    if ($valid_file == true)
                    {
                        if (move_uploaded_file($temp_app_home_file, $path))
                        {
                            $cek_gambar_app_home = mysqli_query($koneksi, "SELECT image_app FROM app WHERE app.kategori_app = 'app_home'") or die(mysqli_error());
                            if (mysqli_num_rows($cek_gambar_app_home) == 1)
                            {
                                while ($daftar_app_home = mysqli_fetch_array($cek_gambar_app_home))
                                {
                                    $hapus_image = $daftar_app_home['image_app'];
                                    if (file_exists("../upload/image/app/home/" . $hapus_image))
                                    {
                                        unlink("../upload/image/app/home/" . $hapus_image);
                                    }
                                    else
                                    {
                                        header("location: app_home.php?status_form=gagal_hapus_gambar");
                                    }
                                }
                            }
                            else
                            {
                                header("location: app_home.php?status_form=tidak_ada_data");
                            }
                        }
                        else
                        {
                            header("location: app_home.php?status_form=gagal_upload");
                        }

                        $update2 = mysqli_query($koneksi, "UPDATE app SET judul_app = '$judul_app_home', image_app = '$gambar_app_baru', konten_app = '$konten_app_home', teks_url = '$teks_url_app_home', url_app = '$url_app_home', aktif = '$app_status' WHERE app.kategori_app = 'app_home' LIMIT 1") or die(mysqli_error());
                        if ($update2 == true)
                        {
                            header("location: app_home.php?status_form=berhasil&jenis_form=edit&a");
                        }
                        else
                        {
                            header("location: app_home.php?status_form=gagal&jenis_form=edit&a");
                        }
                    }
                    else
                    {
                        header("location: app_home.php?status_form=gambar_tidak_valid");
                    }
                }
                elseif (empty($image_app_home_file) && empty($temp_app_home_file))
                {
                    $update2 = mysqli_query($koneksi, "UPDATE app SET judul_app = '$judul_app_home', konten_app = '$konten_app_home', teks_url = '$teks_url_app_home', url_app = '$url_app_home', aktif = '$app_status' WHERE app.kategori_app = 'app_home' LIMIT 1") or die(mysqli_error());
                    if ($update2 == true)
                    {
                        header("location: app_home.php?status_form=berhasil&jenis_form=edit&b");
                    }
                    else
                    {
                        header("location: app_home.php?status_form=gagal&jenis_form=edit&b");
                    }
                }
            }
            else
            {
                header("location: app_home.php?status_form=tidak_lengkap&a");
            }
        }
        else
        {
            header("location: app_home.php?status_form=tidak_lengkap&b");
        }
    }

    // tambah appfashion

    if (isset($_POST['app_fashion_tambah']))
    {
        if (isset($_POST['judul_app_fashion']) && isset($_POST['teks_url_app_fashion']) && isset($_POST['url_app_fashion']) && isset($_POST['konten_app_fashion']) && isset($_FILES['upload_cover']))
        {
            if (isset($_POST['app_aktif']) && $_POST['app_aktif'] == 1)
            {
                $app_status = 'ya';
            }
            else
            {
                $app_status = 'tidak';
            }

            $judul_app_fashion = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['judul_app_fashion'])));
            $teks_url_app_fashion = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['teks_url_app_fashion'])));
            $url_app_fashion = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['url_app_fashion'])));
            $konten_app_fashion = trim(mysqli_real_escape_string($koneksi, $_POST['konten_app_fashion']));
            $valid_file = true;
            $max_size = 80000;
            $glebar = 494;
            $gtinggi = 494;
            $image_app_fashion_file = $_FILES['upload_cover']['name'];
            $temp_app_fashion_file = $_FILES['upload_cover']['tmp_name'];
            $ukuran_app_fashion_file = $_FILES['upload_cover']['size'];
            $jenis_image = strtolower(pathinfo($image_app_fashion_file, PATHINFO_EXTENSION));
            list($lebar, $tinggi) = getimagesize($temp_app_fashion_file);
            if ($ukuran_app_fashion_file > $max_size)
            {
                $valid_file = false;
            }

            if ($jenis_image != "jpg" && $jenis_image != "jpeg" && $jenis_image != "png" && $jenis_image != "gif")
            {
                $valid_file = false;
            }

            if ($lebar != $glebar && $tinggi != $gtinggi)
            {
                $valid_file = false;
            }

            $gambar_app_baru = date('dmYHis') . "_" . strtolower(str_replace(' ', '_', $image_app_fashion_file));
            $path = "../upload/image/app/fashion/" . $gambar_app_baru;
            if (!empty($judul_app_fashion) && !empty($konten_app_fashion) && !empty($teks_url_app_fashion) && !empty($url_app_fashion))
            {
                $seleksi_app_fashion = mysqli_query($koneksi, "SELECT * FROM app WHERE kategori_app = 'app_fashion' LIMIT 1") or die("<script>alert('Query salah')</script>");
                $jumlah_app_fashion = mysqli_num_rows($seleksi_app_fashion);
                if ($jumlah_app_fashion == 0)
                {
                    if ($valid_file == true)
                    {
                        $input = mysqli_query($koneksi, "INSERT INTO app VALUES (NULL, '$judul_app_fashion', 'app_fashion', '$gambar_app_baru', '$konten_app_fashion', '$teks_url_app_fashion', '$url_app_fashion', '$app_status')") or die(mysqli_error());
                        if ($input == true)
                        {
                            if (move_uploaded_file($temp_app_fashion_file, $path))
                            {
                                header("location: app_fashion.php?status_form=berhasil&jenis_form=tambah");
                            }
                            else
                            {
                                header("location: app_fashion.php?status_form=gagal_upload");
                            }
                        }
                    }
                    else
                    {
                        header("location: app_fashion.php?status_form=gambar_tidak_valid");
                    }

                    $input = null;
                }
            }
            else
            {
                header("location: app_fashion.php?status_form=tidak_ada_data");
            }
        }
        else
        {
            header("location: app_fashion.php?status_form=tidak_lengkap&a");
        }
    }

    if (isset($_POST['app_fashion_edit']))
    {
        if (isset($_POST['judul_app_fashion']) && isset($_POST['teks_url_app_fashion']) && isset($_POST['url_app_fashion']) && isset($_POST['konten_app_fashion']) && isset($_FILES['upload_cover']))
        {
            if (isset($_POST['app_aktif']) && $_POST['app_aktif'] == 1)
            {
                $app_status = 'ya';
            }
            else
            {
                $app_status = 'tidak';
            }

            $judul_app_fashion = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['judul_app_fashion'])));
            $teks_url_app_fashion = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['teks_url_app_fashion'])));
            $url_app_fashion = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['url_app_fashion'])));
            $konten_app_fashion = trim(mysqli_real_escape_string($koneksi, $_POST['konten_app_fashion']));
            $max_size = 80000;
            $glebar = 494;
            $gtinggi = 494;
            $image_app_fashion_file = $_FILES['upload_cover']['name'];
            $temp_app_fashion_file = $_FILES['upload_cover']['tmp_name'];
            $ukuran_app_fashion_file = $_FILES['upload_cover']['size'];
            if (!empty($image_app_fashion_file) && !empty($temp_app_fashion_file))
            {
                $valid_file = true;
                $jenis_image = strtolower(pathinfo($image_app_fashion_file, PATHINFO_EXTENSION));
                list($lebar, $tinggi) = getimagesize($temp_app_fashion_file);
                if ($ukuran_app_fashion_file > $max_size)
                {
                    $valid_file = false;
                }

                if ($jenis_image != "jpg" && $jenis_image != "jpeg" && $jenis_image != "png" && $jenis_image != "gif")
                {
                    $valid_file = false;
                }

                if ($lebar != $glebar && $tinggi != $gtinggi)
                {
                    $valid_file = false;
                }

                $gambar_app_baru = date('dmYHis') . "_" . strtolower(str_replace(' ', '_', $image_app_fashion_file));
                $path = "../upload/image/app/fashion/" . $gambar_app_baru;
            }

            if (!empty($judul_app_fashion) && !empty($konten_app_fashion) && !empty($teks_url_app_fashion) && !empty($url_app_fashion))
            {
                if (!empty($image_app_fashion_file) && !empty($temp_app_fashion_file))
                {
                    if ($valid_file == true)
                    {
                        if (move_uploaded_file($temp_app_fashion_file, $path))
                        {
                            $cek_gambar_app_fashion = mysqli_query($koneksi, "SELECT image_app FROM app WHERE app.kategori_app = 'app_fashion'") or die(mysqli_error());
                            if (mysqli_num_rows($cek_gambar_app_fashion) == 1)
                            {
                                while ($daftar_app_fashion = mysqli_fetch_array($cek_gambar_app_fashion))
                                {
                                    $hapus_image = $daftar_app_fashion['image_app'];
                                    if (file_exists("../upload/image/app/fashion/" . $hapus_image))
                                    {
                                        unlink("../upload/image/app/fashion/" . $hapus_image);
                                    }
                                    else
                                    {
                                        header("location: app_fashion.php?status_form=gagal_hapus_gambar");
                                    }
                                }
                            }
                            else
                            {
                                header("location: app_fashion.php?status_form=tidak_ada_data");
                            }
                        }
                        else
                        {
                            header("location: app_fashion.php?status_form=gagal_upload");
                        }

                        $update2 = mysqli_query($koneksi, "UPDATE app SET judul_app = '$judul_app_fashion', image_app = '$gambar_app_baru', konten_app = '$konten_app_fashion', teks_url = '$teks_url_app_fashion', url_app = '$url_app_fashion', aktif = '$app_status' WHERE app.kategori_app = 'app_fashion' LIMIT 1") or die(mysqli_error());
                        if ($update2 == true)
                        {
                            header("location: app_fashion.php?status_form=berhasil&jenis_form=edit&a");
                        }
                        else
                        {
                            header("location: app_fashion.php?status_form=gagal&jenis_form=edit&a");
                        }
                    }
                    else
                    {
                        header("location: app_fashion.php?status_form=gambar_tidak_valid");
                    }
                }
                elseif (empty($image_app_fashion_file) && empty($temp_app_fashion_file))
                {
                    $update2 = mysqli_query($koneksi, "UPDATE app SET judul_app = '$judul_app_fashion', konten_app = '$konten_app_fashion', teks_url = '$teks_url_app_fashion', url_app = '$url_app_fashion', aktif = '$app_status' WHERE app.kategori_app = 'app_fashion' LIMIT 1") or die(mysqli_error());
                    if ($update2 == true)
                    {
                        header("location: app_fashion.php?status_form=berhasil&jenis_form=edit&b");
                    }
                    else
                    {
                        header("location: app_fashion.php?status_form=gagal&jenis_form=edit&b");
                    }
                }
            }
            else
            {
                header("location: app_fashion.php?status_form=tidak_lengkap&a");
            }
        }
        else
        {
            header("location: app_fashion.php?status_form=tidak_lengkap&b");
        }
    }

    // tambah appfood

    if (isset($_POST['app_food_tambah']))
    {
        if (isset($_POST['judul_app_food']) && isset($_POST['teks_url_app_food']) && isset($_POST['url_app_food']) && isset($_POST['konten_app_food']) && isset($_FILES['upload_cover']))
        {
            if (isset($_POST['app_aktif']) && $_POST['app_aktif'] == 1)
            {
                $app_status = 'ya';
            }
            else
            {
                $app_status = 'tidak';
            }

            $judul_app_food = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['judul_app_food'])));
            $teks_url_app_food = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['teks_url_app_food'])));
            $url_app_food = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['url_app_food'])));
            $konten_app_food = trim(mysqli_real_escape_string($koneksi, $_POST['konten_app_food']));
            $valid_file = true;
            $max_size = 80000;
            $glebar = 1029;
            $gtinggi = 515;
            $image_app_food_file = $_FILES['upload_cover']['name'];
            $temp_app_food_file = $_FILES['upload_cover']['tmp_name'];
            $ukuran_app_food_file = $_FILES['upload_cover']['size'];
            $jenis_image = strtolower(pathinfo($image_app_food_file, PATHINFO_EXTENSION));
            list($lebar, $tinggi) = getimagesize($temp_app_food_file);
            if ($ukuran_app_food_file > $max_size)
            {
                $valid_file = false;
            }

            if ($jenis_image != "jpg" && $jenis_image != "jpeg" && $jenis_image != "png" && $jenis_image != "gif")
            {
                $valid_file = false;
            }

            if ($lebar != $glebar && $tinggi != $gtinggi)
            {
                $valid_file = false;
            }

            $gambar_app_baru = date('dmYHis') . "_" . strtolower(str_replace(' ', '_', $image_app_food_file));
            $path = "../upload/image/app/food/" . $gambar_app_baru;
            if (!empty($judul_app_food) && !empty($konten_app_food) && !empty($teks_url_app_food) && !empty($url_app_food))
            {
                $seleksi_app_food = mysqli_query($koneksi, "SELECT * FROM app WHERE kategori_app = 'app_food' LIMIT 1") or die("<script>alert('Query salah')</script>");
                $jumlah_app_food = mysqli_num_rows($seleksi_app_food);
                if ($jumlah_app_food == 0)
                {
                    if ($valid_file == true)
                    {
                        $input = mysqli_query($koneksi, "INSERT INTO app VALUES (NULL, '$judul_app_food', 'app_food', '$gambar_app_baru', '$konten_app_food', '$teks_url_app_food', '$url_app_food', '$app_status')") or die(mysqli_error());
                        if ($input == true)
                        {
                            if (move_uploaded_file($temp_app_food_file, $path))
                            {
                                header("location: app_food.php?status_form=berhasil&jenis_form=tambah");
                            }
                            else
                            {
                                header("location: app_food.php?status_form=gagal_upload");
                            }
                        }
                    }
                    else
                    {
                        header("location: app_food.php?status_form=gambar_tidak_valid");
                    }

                    $input = null;
                }
            }
            else
            {
                header("location: app_food.php?status_form=tidak_ada_data");
            }
        }
        else
        {
            header("location: app_food.php?status_form=tidak_lengkap&a");
        }
    }

    if (isset($_POST['app_food_edit']))
    {
        if (isset($_POST['judul_app_food']) && isset($_POST['teks_url_app_food']) && isset($_POST['url_app_food']) && isset($_POST['konten_app_food']) && isset($_FILES['upload_cover']))
        {
            if (isset($_POST['app_aktif']) && $_POST['app_aktif'] == 1)
            {
                $app_status = 'ya';
            }
            else
            {
                $app_status = 'tidak';
            }

            $judul_app_food = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['judul_app_food'])));
            $teks_url_app_food = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['teks_url_app_food'])));
            $url_app_food = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['url_app_food'])));
            $konten_app_food = trim(mysqli_real_escape_string($koneksi, $_POST['konten_app_food']));
            $max_size = 80000;
            $glebar = 1029;
            $gtinggi = 515;
            $image_app_food_file = $_FILES['upload_cover']['name'];
            $temp_app_food_file = $_FILES['upload_cover']['tmp_name'];
            $ukuran_app_food_file = $_FILES['upload_cover']['size'];
            if (!empty($image_app_food_file) && !empty($temp_app_food_file))
            {
                $valid_file = true;
                $jenis_image = strtolower(pathinfo($image_app_food_file, PATHINFO_EXTENSION));
                list($lebar, $tinggi) = getimagesize($temp_app_food_file);
                if ($ukuran_app_food_file > $max_size)
                {
                    $valid_file = false;
                }

                if ($jenis_image != "jpg" && $jenis_image != "jpeg" && $jenis_image != "png" && $jenis_image != "gif")
                {
                    $valid_file = false;
                }

                if ($lebar != $glebar && $tinggi != $gtinggi)
                {
                    $valid_file = false;
                }

                $gambar_app_baru = date('dmYHis') . "_" . strtolower(str_replace(' ', '_', $image_app_food_file));
                $path = "../upload/image/app/food/" . $gambar_app_baru;
            }

            if (!empty($judul_app_food) && !empty($konten_app_food) && !empty($teks_url_app_food) && !empty($url_app_food))
            {
                if (!empty($image_app_food_file) && !empty($temp_app_food_file))
                {
                    if ($valid_file == true)
                    {
                        if (move_uploaded_file($temp_app_food_file, $path))
                        {
                            $cek_gambar_app_food = mysqli_query($koneksi, "SELECT image_app FROM app WHERE app.kategori_app = 'app_food'") or die(mysqli_error());
                            if (mysqli_num_rows($cek_gambar_app_food) == 1)
                            {
                                while ($daftar_app_food = mysqli_fetch_array($cek_gambar_app_food))
                                {
                                    $hapus_image = $daftar_app_food['image_app'];
                                    if (file_exists("../upload/image/app/food/" . $hapus_image))
                                    {
                                        unlink("../upload/image/app/food/" . $hapus_image);
                                    }
                                    else
                                    {
                                        header("location: app_food.php?status_form=gagal_hapus_gambar");
                                    }
                                }
                            }
                            else
                            {
                                header("location: app_food.php?status_form=tidak_ada_data");
                            }
                        }
                        else
                        {
                            header("location: app_food.php?status_form=gagal_upload");
                        }

                        $update2 = mysqli_query($koneksi, "UPDATE app SET judul_app = '$judul_app_food', image_app = '$gambar_app_baru', konten_app = '$konten_app_food', teks_url = '$teks_url_app_food', url_app = '$url_app_food', aktif = '$app_status' WHERE app.kategori_app = 'app_food' LIMIT 1") or die(mysqli_error());
                        if ($update2 == true)
                        {
                            header("location: app_food.php?status_form=berhasil&jenis_form=edit&a");
                        }
                        else
                        {
                            header("location: app_food.php?status_form=gagal&jenis_form=edit&a");
                        }
                    }
                    else
                    {
                        header("location: app_food.php?status_form=gambar_tidak_valid");
                    }
                }
                elseif (empty($image_app_food_file) && empty($temp_app_food_file))
                {
                    $update2 = mysqli_query($koneksi, "UPDATE app SET judul_app = '$judul_app_food', konten_app = '$konten_app_food', teks_url = '$teks_url_app_food', url_app = '$url_app_food', aktif = '$app_status' WHERE app.kategori_app = 'app_food' LIMIT 1") or die(mysqli_error());
                    if ($update2 == true)
                    {
                        header("location: app_food.php?status_form=berhasil&jenis_form=edit&b");
                    }
                    else
                    {
                        header("location: app_food.php?status_form=gagal&jenis_form=edit&b");
                    }
                }
            }
            else
            {
                header("location: app_food.php?status_form=tidak_lengkap&a");
            }
        }
        else
        {
            header("location: app_food.php?status_form=tidak_lengkap&b");
        }
    }

    // tambah apppendidikan

    if (isset($_POST['app_pendidikan_tambah']))
    {
        if (isset($_POST['judul_app_pendidikan']) && isset($_POST['teks_url_app_pendidikan']) && isset($_POST['konten_app_pendidikan']) && isset($_POST['url_app_pendidikan']) && isset($_FILES['upload_cover']))
        {
            if (isset($_POST['app_aktif']) && $_POST['app_aktif'] == 1)
            {
                $app_status = 'ya';
            }
            else
            {
                $app_status = 'tidak';
            }

            $judul_app_pendidikan = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['judul_app_pendidikan'])));
            $teks_url_app_pendidikan = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['teks_url_app_pendidikan'])));
            $url_app_pendidikan = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['url_app_pendidikan'])));
            $konten_app_pendidikan = trim(mysqli_real_escape_string($koneksi, $_POST['konten_app_pendidikan']));
            $valid_file = true;
            $max_size = 80000;
            $glebar = 494;
            $gtinggi = 494;
            $image_app_pendidikan_file = $_FILES['upload_cover']['name'];
            $temp_app_pendidikan_file = $_FILES['upload_cover']['tmp_name'];
            $ukuran_app_pendidikan_file = $_FILES['upload_cover']['size'];
            $jenis_image = strtolower(pathinfo($image_app_pendidikan_file, PATHINFO_EXTENSION));
            list($lebar, $tinggi) = getimagesize($temp_app_pendidikan_file);
            if ($ukuran_app_pendidikan_file > $max_size)
            {
                $valid_file = false;
            }

            if ($jenis_image != "jpg" && $jenis_image != "jpeg" && $jenis_image != "png" && $jenis_image != "gif")
            {
                $valid_file = false;
            }

            if ($lebar != $glebar && $tinggi != $gtinggi)
            {
                $valid_file = false;
            }

            $gambar_app_baru = date('dmYHis') . "_" . strtolower(str_replace(' ', '_', $image_app_pendidikan_file));
            $path = "../upload/image/app/pendidikan/" . $gambar_app_baru;
            if (!empty($judul_app_pendidikan) && !empty($konten_app_pendidikan) && !empty($teks_url_app_pendidikan) && !empty($url_app_pendidikan))
            {
                $seleksi_app_pendidikan = mysqli_query($koneksi, "SELECT * FROM app WHERE kategori_app = 'app_pendidikan' LIMIT 1") or die("<script>alert('Query salah')</script>");
                $jumlah_app_pendidikan = mysqli_num_rows($seleksi_app_pendidikan);
                if ($jumlah_app_pendidikan == 0)
                {
                    if ($valid_file == true)
                    {
                        $input = mysqli_query($koneksi, "INSERT INTO app VALUES (NULL, '$judul_app_pendidikan', 'app_pendidikan', '$gambar_app_baru', '$konten_app_pendidikan', '$teks_url_app_pendidikan', '$url_app_pendidikan', '$app_status')") or die(mysqli_error());
                        if ($input == true)
                        {
                            if (move_uploaded_file($temp_app_pendidikan_file, $path))
                            {
                                header("location: app_pendidikan.php?status_form=berhasil&jenis_form=tambah");
                            }
                            else
                            {
                                header("location: app_pendidikan.php?status_form=gagal_upload");
                            }
                        }
                    }
                    else
                    {
                        header("location: app_pendidikan.php?status_form=gambar_tidak_valid");
                    }

                    $input = null;
                }
            }
            else
            {
                header("location: app_pendidikan.php?status_form=tidak_ada_data");
            }
        }
        else
        {
            header("location: app_pendidikan.php?status_form=tidak_lengkap&a");
        }
    }

    if (isset($_POST['app_pendidikan_edit']))
    {
        if (isset($_POST['judul_app_pendidikan']) && isset($_POST['teks_url_app_pendidikan']) && isset($_POST['konten_app_pendidikan']) && isset($_POST['url_app_pendidikan']) && isset($_FILES['upload_cover']))
        {
            if (isset($_POST['app_aktif']) && $_POST['app_aktif'] == 1)
            {
                $app_status = 'ya';
            }
            else
            {
                $app_status = 'tidak';
            }

            $judul_app_pendidikan = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['judul_app_pendidikan'])));
            $teks_url_app_pendidikan = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['teks_url_app_pendidikan'])));
            $url_app_pendidikan = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['url_app_pendidikan'])));
            $konten_app_pendidikan = trim(mysqli_real_escape_string($koneksi, $_POST['konten_app_pendidikan']));
            $max_size = 80000;
            $glebar = 494;
            $gtinggi = 494;
            $image_app_pendidikan_file = $_FILES['upload_cover']['name'];
            $temp_app_pendidikan_file = $_FILES['upload_cover']['tmp_name'];
            $ukuran_app_pendidikan_file = $_FILES['upload_cover']['size'];
            if (!empty($image_app_pendidikan_file) && !empty($temp_app_pendidikan_file))
            {
                $valid_file = true;
                $jenis_image = strtolower(pathinfo($image_app_pendidikan_file, PATHINFO_EXTENSION));
                list($lebar, $tinggi) = getimagesize($temp_app_pendidikan_file);
                if ($ukuran_app_pendidikan_file > $max_size)
                {
                    $valid_file = false;
                }

                if ($jenis_image != "jpg" && $jenis_image != "jpeg" && $jenis_image != "png" && $jenis_image != "gif")
                {
                    $valid_file = false;
                }

                if ($lebar != $glebar && $tinggi != $gtinggi)
                {
                    $valid_file = false;
                }

                $gambar_app_baru = date('dmYHis') . "_" . strtolower(str_replace(' ', '_', $image_app_pendidikan_file));
                $path = "../upload/image/app/pendidikan/" . $gambar_app_baru;
            }

            if (!empty($judul_app_pendidikan) && !empty($teks_url_app_pendidikan) && !empty($url_app_pendidikan))
            {
                if (!empty($image_app_pendidikan_file) && !empty($temp_app_pendidikan_file))
                {
                    if ($valid_file == true)
                    {
                        if (move_uploaded_file($temp_app_pendidikan_file, $path))
                        {
                            $cek_gambar_app_pendidikan = mysqli_query($koneksi, "SELECT image_app FROM app WHERE app.kategori_app = 'app_pendidikan'") or die(mysqli_error());
                            if (mysqli_num_rows($cek_gambar_app_pendidikan) == 1)
                            {
                                while ($daftar_app_pendidikan = mysqli_fetch_array($cek_gambar_app_pendidikan))
                                {
                                    $hapus_image = $daftar_app_pendidikan['image_app'];
                                    if (file_exists("../upload/image/app/pendidikan/" . $hapus_image))
                                    {
                                        unlink("../upload/image/app/pendidikan/" . $hapus_image);
                                    }
                                    else
                                    {
                                        header("location: app_pendidikan.php?status_form=gagal_hapus_gambar");
                                    }
                                }
                            }
                            else
                            {
                                header("location: app_pendidikan.php?status_form=tidak_ada_data");
                            }
                        }
                        else
                        {
                            header("location: app_pendidikan.php?status_form=gagal_upload");
                        }

                        $update2 = mysqli_query($koneksi, "UPDATE app SET judul_app = '$judul_app_pendidikan', image_app = '$gambar_app_baru', konten_app = '$konten_app_pendidikan', teks_url = '$teks_url_app_pendidikan', url_app = '$url_app_pendidikan', aktif = '$app_status' WHERE app.kategori_app = 'app_pendidikan' LIMIT 1") or die(mysqli_error());
                        if ($update2 == true)
                        {
                            header("location: app_pendidikan.php?status_form=berhasil&jenis_form=edit&a");
                        }
                        else
                        {
                            header("location: app_pendidikan.php?status_form=gagal&jenis_form=edit&a");
                        }
                    }
                    else
                    {
                        header("location: app_pendidikan.php?status_form=gambar_tidak_valid");
                    }
                }
                elseif (empty($image_app_pendidikan_file) && empty($temp_app_pendidikan_file))
                {
                    $update2 = mysqli_query($koneksi, "UPDATE app SET judul_app = '$judul_app_pendidikan', konten_app = '$konten_app_pendidikan', teks_url = '$teks_url_app_pendidikan', url_app = '$url_app_pendidikan', aktif = '$app_status' WHERE app.kategori_app = 'app_pendidikan' LIMIT 1") or die(mysqli_error());
                    if ($update2 == true)
                    {
                        header("location: app_pendidikan.php?status_form=berhasil&jenis_form=edit&b");
                    }
                    else
                    {
                        header("location: app_pendidikan.php?status_form=gagal&jenis_form=edit&b");
                    }
                }
            }
            else
            {
                header("location: app_pendidikan.php?status_form=tidak_lengkap&a");
            }
        }
        else
        {
            header("location: app_pendidikan.php?status_form=tidak_lengkap&b");
        }
    }

    // tambah appsecurity

    if (isset($_POST['app_security_tambah']))
    {
        if (isset($_POST['judul_app_security']) && isset($_POST['teks_url_app_security']) && isset($_POST['konten_app_security']) && isset($_POST['url_app_security']) && isset($_FILES['upload_cover']))
        {
            if (isset($_POST['app_aktif']) && $_POST['app_aktif'] == 1)
            {
                $app_status = 'ya';
            }
            else
            {
                $app_status = 'tidak';
            }

            $judul_app_security = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['judul_app_security'])));
            $teks_url_app_security = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['teks_url_app_security'])));
            $url_app_security = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['url_app_security'])));
            $konten_app_security = trim(mysqli_real_escape_string($koneksi, $_POST['konten_app_security']));
            $valid_file = true;
            $max_size = 80000;
            $glebar = 1248;
            $gtinggi = 625;
            $image_app_security_file = $_FILES['upload_cover']['name'];
            $temp_app_security_file = $_FILES['upload_cover']['tmp_name'];
            $ukuran_app_security_file = $_FILES['upload_cover']['size'];
            $jenis_image = strtolower(pathinfo($image_app_security_file, PATHINFO_EXTENSION));
            list($lebar, $tinggi) = getimagesize($temp_app_security_file);
            if ($ukuran_app_security_file > $max_size)
            {
                $valid_file = false;
            }

            if ($jenis_image != "jpg" && $jenis_image != "jpeg" && $jenis_image != "png" && $jenis_image != "gif")
            {
                $valid_file = false;
            }

            if ($lebar != $glebar && $tinggi != $gtinggi)
            {
                $valid_file = false;
            }

            $gambar_app_baru = date('dmYHis') . "_" . strtolower(str_replace(' ', '_', $image_app_security_file));
            $path = "../upload/image/app/security/" . $gambar_app_baru;
            if (!empty($judul_app_security) && !empty($konten_app_security) && !empty($teks_url_app_security) && !empty($url_app_security))
            {
                $seleksi_app_security = mysqli_query($koneksi, "SELECT * FROM app WHERE kategori_app = 'app_security' LIMIT 1") or die("<script>alert('Query salah')</script>");
                $jumlah_app_security = mysqli_num_rows($seleksi_app_security);
                if ($jumlah_app_security == 0)
                {
                    if ($valid_file == true)
                    {
                        $input = mysqli_query($koneksi, "INSERT INTO app VALUES (NULL, '$judul_app_security', 'app_security', '$gambar_app_baru', '$konten_app_security', '$teks_url_app_security', '$url_app_security', '$app_status')") or die(mysqli_error());
                        if ($input == true)
                        {
                            if (move_uploaded_file($temp_app_security_file, $path))
                            {
                                header("location: app_security.php?status_form=berhasil&jenis_form=tambah");
                            }
                            else
                            {
                                header("location: app_security.php?status_form=gagal_upload");
                            }
                        }
                    }
                    else
                    {
                        header("location: app_security.php?status_form=gambar_tidak_valid");
                    }

                    $input = null;
                }
            }
            else
            {
                header("location: app_security.php?status_form=tidak_ada_data");
            }
        }
        else
        {
            header("location: app_security.php?status_form=tidak_lengkap&a");
        }
    }

    if (isset($_POST['app_security_edit']))
    {
        if (isset($_POST['judul_app_security']) && isset($_POST['teks_url_app_security']) && isset($_POST['konten_app_security']) && isset($_POST['url_app_security']) && isset($_FILES['upload_cover']))
        {
            if (isset($_POST['app_aktif']) && $_POST['app_aktif'] == 1)
            {
                $app_status = 'ya';
            }
            else
            {
                $app_status = 'tidak';
            }

            $judul_app_security = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['judul_app_security'])));
            $teks_url_app_security = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['teks_url_app_security'])));
            $url_app_security = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['url_app_security'])));
            $konten_app_security = trim(mysqli_real_escape_string($koneksi, $_POST['konten_app_security']));
            $max_size = 80000;
            $glebar = 1248;
            $gtinggi = 625;
            $image_app_security_file = $_FILES['upload_cover']['name'];
            $temp_app_security_file = $_FILES['upload_cover']['tmp_name'];
            $ukuran_app_security_file = $_FILES['upload_cover']['size'];
            if (!empty($image_app_security_file) && !empty($temp_app_security_file))
            {
                $valid_file = true;
                $jenis_image = strtolower(pathinfo($image_app_security_file, PATHINFO_EXTENSION));
                list($lebar, $tinggi) = getimagesize($temp_app_security_file);
                if ($ukuran_app_security_file > $max_size)
                {
                    $valid_file = false;
                }

                if ($jenis_image != "jpg" && $jenis_image != "jpeg" && $jenis_image != "png" && $jenis_image != "gif")
                {
                    $valid_file = false;
                }

                if ($lebar != $glebar && $tinggi != $gtinggi)
                {
                    $valid_file = false;
                }

                $gambar_app_baru = date('dmYHis') . "_" . strtolower(str_replace(' ', '_', $image_app_security_file));
                $path = "../upload/image/app/security/" . $gambar_app_baru;
            }

            if (!empty($judul_app_security) && !empty($konten_app_security) && !empty($teks_url_app_security) && !empty($url_app_security))
            {
                if (!empty($image_app_security_file) && !empty($temp_app_security_file))
                {
                    if ($valid_file == true)
                    {
                        if (move_uploaded_file($temp_app_security_file, $path))
                        {
                            $cek_gambar_app_security = mysqli_query($koneksi, "SELECT image_app FROM app WHERE app.kategori_app = 'app_security'") or die(mysqli_error());
                            if (mysqli_num_rows($cek_gambar_app_security) == 1)
                            {
                                while ($daftar_app_security = mysqli_fetch_array($cek_gambar_app_security))
                                {
                                    $hapus_image = $daftar_app_security['image_app'];
                                    if (file_exists("../upload/image/app/security/" . $hapus_image))
                                    {
                                        unlink("../upload/image/app/security/" . $hapus_image);
                                    }
                                    else
                                    {
                                        header("location: app_security.php?status_form=gagal_hapus_gambar");
                                    }
                                }
                            }
                            else
                            {
                                header("location: app_security.php?status_form=tidak_ada_data");
                            }
                        }
                        else
                        {
                            header("location: app_security.php?status_form=gagal_upload");
                        }

                        $update2 = mysqli_query($koneksi, "UPDATE app SET judul_app = '$judul_app_security', image_app = '$gambar_app_baru', konten_app = '$konten_app_security', teks_url = '$teks_url_app_security', url_app = '$url_app_security', aktif = '$app_status' WHERE app.kategori_app = 'app_security' LIMIT 1") or die(mysqli_error());
                        if ($update2 == true)
                        {
                            header("location: app_security.php?status_form=berhasil&jenis_form=edit&a");
                        }
                        else
                        {
                            header("location: app_security.php?status_form=gagal&jenis_form=edit&a");
                        }
                    }
                    else
                    {
                        header("location: app_security.php?status_form=gambar_tidak_valid");
                    }
                }
                elseif (empty($image_app_security_file) && empty($temp_app_security_file))
                {
                    $update2 = mysqli_query($koneksi, "UPDATE app SET judul_app = '$judul_app_security', konten_app = '$konten_app_security', teks_url = '$teks_url_app_security', url_app = '$url_app_security', aktif = '$app_status' WHERE app.kategori_app = 'app_security' LIMIT 1") or die(mysqli_error());
                    if ($update2 == true)
                    {
                        header("location: app_security.php?status_form=berhasil&jenis_form=edit&b");
                    }
                    else
                    {
                        header("location: app_security.php?status_form=gagal&jenis_form=edit&b");
                    }
                }
            }
            else
            {
                header("location: app_security.php?status_form=tidak_lengkap&a");
            }
        }
        else
        {
            header("location: app_security.php?status_form=tidak_lengkap&b");
        }
    }

    // tambah appsport

    if (isset($_POST['app_sport_tambah']))
    {
        if (isset($_POST['judul_app_sport']) && isset($_POST['teks_url_app_sport']) && isset($_POST['konten_app_sport']) && isset($_POST['url_app_sport']) && isset($_FILES['upload_cover']))
        {
            if (isset($_POST['app_aktif']) && $_POST['app_aktif'] == 1)
            {
                $app_status = 'ya';
            }
            else
            {
                $app_status = 'tidak';
            }

            $judul_app_sport = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['judul_app_sport'])));
            $teks_url_app_sport = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['teks_url_app_sport'])));
            $url_app_sport = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['url_app_sport'])));
            $konten_app_sport = trim(mysqli_real_escape_string($koneksi, $_POST['konten_app_sport']));
            $valid_file = true;
            $max_size = 80000;
            $glebar = 494;
            $gtinggi = 494;
            $image_app_sport_file = $_FILES['upload_cover']['name'];
            $temp_app_sport_file = $_FILES['upload_cover']['tmp_name'];
            $ukuran_app_sport_file = $_FILES['upload_cover']['size'];
            $jenis_image = strtolower(pathinfo($image_app_sport_file, PATHINFO_EXTENSION));
            list($lebar, $tinggi) = getimagesize($temp_app_sport_file);
            if ($ukuran_app_sport_file > $max_size)
            {
                $valid_file = false;
            }

            if ($jenis_image != "jpg" && $jenis_image != "jpeg" && $jenis_image != "png" && $jenis_image != "gif")
            {
                $valid_file = false;
            }

            if ($lebar != $glebar && $tinggi != $gtinggi)
            {
                $valid_file = false;
            }

            $gambar_app_baru = date('dmYHis') . "_" . strtolower(str_replace(' ', '_', $image_app_sport_file));
            $path = "../upload/image/app/sport/" . $gambar_app_baru;
            if (!empty($judul_app_sport) && !empty($konten_app_sport) && !empty($teks_url_app_sport) && !empty($url_app_sport))
            {
                $seleksi_app_sport = mysqli_query($koneksi, "SELECT * FROM app WHERE kategori_app = 'app_sport' LIMIT 1") or die("<script>alert('Query salah')</script>");
                $jumlah_app_sport = mysqli_num_rows($seleksi_app_sport);
                if ($jumlah_app_sport == 0)
                {
                    if ($valid_file == true)
                    {
                        $input = mysqli_query($koneksi, "INSERT INTO app VALUES (NULL, '$judul_app_sport', 'app_sport', '$gambar_app_baru', '$konten_app_sport', '$teks_url_app_sport', '$url_app_sport', '$app_status')") or die(mysqli_error());
                        if ($input == true)
                        {
                            if (move_uploaded_file($temp_app_sport_file, $path))
                            {
                                header("location: app_sport.php?status_form=berhasil&jenis_form=tambah");
                            }
                            else
                            {
                                header("location: app_sport.php?status_form=gagal_upload");
                            }
                        }
                    }
                    else
                    {
                        header("location: app_sport.php?status_form=gambar_tidak_valid");
                    }

                    $input = null;
                }
            }
            else
            {
                header("location: app_sport.php?status_form=tidak_ada_data");
            }
        }
        else
        {
            header("location: app_sport.php?status_form=tidak_lengkap&a");
        }
    }

    if (isset($_POST['app_sport_edit']))
    {
        if (isset($_POST['judul_app_sport']) && isset($_POST['teks_url_app_sport']) && isset($_POST['konten_app_sport']) && isset($_POST['url_app_sport']) && isset($_FILES['upload_cover']))
        {
            if (isset($_POST['app_aktif']) && $_POST['app_aktif'] == 1)
            {
                $app_status = 'ya';
            }
            else
            {
                $app_status = 'tidak';
            }

            $judul_app_sport = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['judul_app_sport'])));
            $teks_url_app_sport = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['teks_url_app_sport'])));
            $url_app_sport = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['url_app_sport'])));
            $konten_app_sport = trim(mysqli_real_escape_string($koneksi, $_POST['konten_app_sport']));
            $max_size = 80000;
            $glebar = 494;
            $gtinggi = 494;
            $image_app_sport_file = $_FILES['upload_cover']['name'];
            $temp_app_sport_file = $_FILES['upload_cover']['tmp_name'];
            $ukuran_app_sport_file = $_FILES['upload_cover']['size'];
            if (!empty($image_app_sport_file) && !empty($temp_app_sport_file))
            {
                $valid_file = true;
                $jenis_image = strtolower(pathinfo($image_app_sport_file, PATHINFO_EXTENSION));
                list($lebar, $tinggi) = getimagesize($temp_app_sport_file);
                if ($ukuran_app_sport_file > $max_size)
                {
                    $valid_file = false;
                }

                if ($jenis_image != "jpg" && $jenis_image != "jpeg" && $jenis_image != "png" && $jenis_image != "gif")
                {
                    $valid_file = false;
                }

                if ($lebar != $glebar && $tinggi != $gtinggi)
                {
                    $valid_file = false;
                }

                $gambar_app_baru = date('dmYHis') . "_" . strtolower(str_replace(' ', '_', $image_app_sport_file));
                $path = "../upload/image/app/sport/" . $gambar_app_baru;
            }

            if (!empty($judul_app_sport) && !empty($konten_app_sport) && !empty($teks_url_app_sport) && !empty($url_app_sport))
            {
                if (!empty($image_app_sport_file) && !empty($temp_app_sport_file))
                {
                    if ($valid_file == true)
                    {
                        if (move_uploaded_file($temp_app_sport_file, $path))
                        {
                            $cek_gambar_app_sport = mysqli_query($koneksi, "SELECT image_app FROM app WHERE app.kategori_app = 'app_sport'") or die(mysqli_error());
                            if (mysqli_num_rows($cek_gambar_app_sport) == 1)
                            {
                                while ($daftar_app_sport = mysqli_fetch_array($cek_gambar_app_sport))
                                {
                                    $hapus_image = $daftar_app_sport['image_app'];
                                    if (file_exists("../upload/image/app/sport/" . $hapus_image))
                                    {
                                        unlink("../upload/image/app/sport/" . $hapus_image);
                                    }
                                    else
                                    {
                                        header("location: app_sport.php?status_form=gagal_hapus_gambar");
                                    }
                                }
                            }
                            else
                            {
                                header("location: app_sport.php?status_form=tidak_ada_data");
                            }
                        }
                        else
                        {
                            header("location: app_sport.php?status_form=gagal_upload");
                        }

                        $update2 = mysqli_query($koneksi, "UPDATE app SET judul_app = '$judul_app_sport', image_app = '$gambar_app_baru', konten_app = '$konten_app_sport', teks_url = '$teks_url_app_sport', url_app = '$url_app_sport', aktif = '$app_status' WHERE app.kategori_app = 'app_sport' LIMIT 1") or die(mysqli_error());
                        if ($update2 == true)
                        {
                            header("location: app_sport.php?status_form=berhasil&jenis_form=edit&a");
                        }
                        else
                        {
                            header("location: app_sport.php?status_form=gagal&jenis_form=edit&a");
                        }
                    }
                    else
                    {
                        header("location: app_sport.php?status_form=gambar_tidak_valid");
                    }
                }
                elseif (empty($image_app_sport_file) && empty($temp_app_sport_file))
                {
                    $update2 = mysqli_query($koneksi, "UPDATE app SET judul_app = '$judul_app_sport', konten_app = '$konten_app_sport', teks_url = '$teks_url_app_sport', url_app = '$url_app_sport', aktif = '$app_status' WHERE app.kategori_app = 'app_sport' LIMIT 1") or die(mysqli_error());
                    if ($update2 == true)
                    {
                        header("location: app_sport.php?status_form=berhasil&jenis_form=edit&b");
                    }
                    else
                    {
                        header("location: app_sport.php?status_form=gagal&jenis_form=edit&b");
                    }
                }
            }
            else
            {
                header("location: app_sport.php?status_form=tidak_lengkap&a");
            }
        }
        else
        {
            header("location: app_sport.php?status_form=tidak_lengkap&b");
        }
    }

    // Tambah partner Tambah

    if (isset($_POST['partner_tambah']))
    {
        if (isset($_POST['nama_partner']) && isset($_FILES['upload_partner']) && !$_FILES['upload_partner']['error'] && isset($_POST['urutan_partner']))
        {
            if (empty($_POST['urutan_partner']) && $_POST['urutan_partner'] != "1" && $_POST['urutan_partner'] != "2" && $_POST['urutan_partner'] != "3" && $_POST['urutan_partner'] != "4" && $_POST['urutan_partner'] != "5")
            {
                $urutan_partner = "10";
            }
            else
            {
                $urutan_partner = $_POST['urutan_partner'];
            }

            $valid_file = true;
            $max_size = 100000;
            $glebar = 400;
            $gtinggi = 72;
            $nama_partner = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['nama_partner'])));
            $image_partner_file = $_FILES['upload_partner']['name'];
            $temp_partner_file = $_FILES['upload_partner']['tmp_name'];
            $ukuran_partner_file = $_FILES['upload_partner']['size'];
            $jenis_image = strtolower(pathinfo($image_partner_file, PATHINFO_EXTENSION));
            list($lebar, $tinggi) = getimagesize($temp_partner_file);
            if ($ukuran_partner_file > $max_size)
            {
                $valid_file = false;
            }

            if ($jenis_image != "jpg" && $jenis_image != "jpeg" && $jenis_image != "png" && $jenis_image != "gif")
            {
                $valid_file = false;
            }

            if ($lebar < $glebar && $tinggi != $gtinggi)
            {
                $valid_file = false;
            }

            $fotobaru = date('dmYHis') . "_" . strtolower(str_replace(' ', '_', $image_partner_file));
            $path = "../upload/image/partner/" . $fotobaru;
            if (!empty($nama_partner))
            {
                if ($valid_file == true)
                {
                    if (move_uploaded_file($temp_partner_file, $path))
                    {
                        $input = mysqli_query($koneksi, "INSERT INTO partner VALUES (NULL, '$nama_partner', '$fotobaru', '$urutan_partner')") or die(mysqli_error());
                        if ($input == true)
                        {
                            header("location: partner_tambah.php?status_form=berhasil&jenis_form=tambah");
                        }
                        else
                        {
                            header("location: partner_tambah.php?status_form=gagal&jenis_form=tambah");
                        }

                        $input = null;
                    }
                    else
                    {
                        header("location: partner_tambah.php?status_form=gagal_upload");
                    }
                }
                else
                {
                    header("location: partner_tambah.php?status_form=gambar_tidak_valid");
                }
            }
            else
            {
                header("location: partner_tambah.php?status_form=tidak_lengkap&b");
            }
        }
        else
        {
            header("location: partner_tambah.php?status_form=tidak_lengkap&a");
        }
    }

    if (isset($_POST['partner_edit']))
    {
        if (isset($_POST['nama_partner']) && isset($_POST['id']) && isset($_FILES['upload_partner']))
        {
            if (empty($_POST['urutan_partner']) && $_POST['urutan_partner'] != "1" && $_POST['urutan_partner'] != "2" && $_POST['urutan_partner'] != "3" && $_POST['urutan_partner'] != "4" && $_POST['urutan_partner'] != "5")
            {
                $urutan_partner = "10";
            }
            else
            {
                $urutan_partner = $_POST['urutan_partner'];
            }

            $max_size = 100000;
            $glebar = 400;
            $gtinggi = 72;
            $id = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['id'])));
            $nama_partner = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['nama_partner'])));
            $image_partner_file = $_FILES['upload_partner']['name'];
            $temp_partner_file = $_FILES['upload_partner']['tmp_name'];
            $ukuran_partner_file = $_FILES['upload_partner']['size'];
            if (!empty($image_partner_file) && !empty($temp_partner_file))
            {
                $valid_file = true;
                $jenis_image = strtolower(pathinfo($image_partner_file, PATHINFO_EXTENSION));
                list($lebar, $tinggi) = getimagesize($temp_partner_file);
                if ($ukuran_partner_file > $max_size)
                {
                    $valid_file = false;
                }

                if ($jenis_image != "jpg" && $jenis_image != "jpeg" && $jenis_image != "png" && $jenis_image != "gif")
                {
                    $valid_file = false;
                }

                if ($lebar != $glebar && $tinggi != $gtinggi)
                {
                    $valid_file = false;
                }

                $fotobaru = date('dmYHis') . "_" . strtolower(str_replace(' ', '_', $image_partner_file));
                $path = "../upload/image/partner/" . $fotobaru;
            }

            if (!empty($nama_partner))
            {
                if (!empty($image_partner_file) && !empty($temp_partner_file))
                {
                    if ($valid_file == true)
                    {
                        if (move_uploaded_file($temp_partner_file, $path))
                        {
                            $cek_gambar_partner = mysqli_query($koneksi, "SELECT image_partner FROM partner WHERE id_partner = '$id' LIMIT 1") or die(mysqli_error());
                            if (mysqli_num_rows($cek_gambar_partner) == 1)
                            {
                                while ($daftar_partner = mysqli_fetch_array($cek_gambar_partner))
                                {
                                    $hapus_image = $daftar_partner['image_partner'];
                                    if (file_exists("../upload/image/partner/" . $hapus_image))
                                    {
                                        unlink("../upload/image/partner/" . $hapus_image);
                                    }
                                    else
                                    {
                                        header("location: partner.php?status_form=gagal_hapus_gambar");
                                    }
                                }
                            }
                            else
                            {
                                header("location: partner.php?status_form=tidak_ada_data");
                            }
                        }
                        else
                        {
                            header("location: partner.php?status_form=gagal_upload");
                        }

                        $update2 = mysqli_query($koneksi, "UPDATE partner SET nama_partner = '$nama_partner', image_partner = '$fotobaru', urutan = $urutan_partner WHERE partner.id_partner = '$id' LIMIT 1;") or die(mysqli_error());
                        if ($update2 == true)
                        {
                            header("location: partner.php?status_form=berhasil&jenis_form=edit&a1");
                        }
                        else
                        {
                            header("location: partner.php?status_form=gagal&jenis_form=edit&a1");
                        }
                    }
                    else
                    {
                        header("location: partner.php?status_form=gambar_tidak_valid");
                    }
                }
                elseif (empty($image_partner_file) && empty($temp_partner_file))
                {
                    $update2 = mysqli_query($koneksi, "UPDATE partner SET nama_partner = '$nama_partner', urutan = $urutan_partner WHERE partner.id_partner = '$id' LIMIT 1;") or die(mysqli_error());
                    if ($update2 == true)
                    {
                        header("location: partner.php?status_form=berhasil&jenis_form=edit&a2");
                    }
                    else
                    {
                        header("location: partner.php?status_form=gagal&jenis_form=edit&a2");
                    }
                }
            }
            else
            {
                header("location: partner.php?status_form=tidak_lengkap&b");
            }
        }
        else
        {
            header("location: partner.php?status_form=tidak_lengkap&a");
        }
    }

    if (isset($_GET['id_hapus_partner']))
    {
        if (!empty($_GET['id_hapus_partner']))
        {
            $id = trim(strip_tags(mysqli_real_escape_string($koneksi, $_GET['id_hapus_partner'])));
            $cek_terpilih = mysqli_query($koneksi, "SELECT id_partner FROM partner WHERE id_partner = '$id'") or die(mysqli_error());
            if (mysqli_num_rows($cek_terpilih) == 0)
            {
                header("location: partner.php?status_form=tidak_ada_data");
            }
            elseif (mysqli_num_rows($cek_terpilih) == 1)
            {
                $cek_gambar_partner = mysqli_query($koneksi, "SELECT image_partner FROM partner WHERE id_partner = '$id' LIMIT 1") or die(mysqli_error());
                if (mysqli_num_rows($cek_gambar_partner) == 1)
                {
                    while ($daftar_partner = mysqli_fetch_array($cek_gambar_partner))
                    {
                        $hapus_image = $daftar_partner['image_partner'];
                        if (file_exists("../upload/image/partner/" . $hapus_image))
                        {
                            unlink("../upload/image/partner/" . $hapus_image);
                        }
                        else
                        {
                            header("location: partner.php?status_form=gagal_hapus_gambar");
                        }
                    }
                }

                $hapus = mysqli_query($koneksi, "DELETE FROM partner WHERE id_partner = '$id' LIMIT 1");
                if ($hapus == true)
                {
                    header("location: partner.php?status_form=berhasil&jenis_form=hapus");
                }
                else
                {
                    header("location: partner.php?status_form=gagal&jenis_form=hapus");
                }

                $hapus = null;
            }
        }
        else
        {
            header("location: partner.php?status_form=tidak_lengkap");
        }
    }

    // Tambah license_awards Tambah

    if (isset($_POST['license_awards_tambah']))
    {
        if (isset($_POST['judul_license_awards']) && isset($_FILES['upload_license_awards']) && isset($_FILES['upload_qrcode']) && isset($_POST['konten_license_awards']) && isset($_POST['urutan_license_awards']))
        {
            if (empty($_POST['urutan_license_awards']) && $_POST['urutan_license_awards'] != "1" && $_POST['urutan_license_awards'] != "2" && $_POST['urutan_license_awards'] != "3" && $_POST['urutan_license_awards'] != "4" && $_POST['urutan_license_awards'] != "5")
            {
                $urutan_license_awards = "10";
            }
            else
            {
                $urutan_license_awards = $_POST['urutan_license_awards'];
            }

            $valid_file = true;
            $max_size = 100000;
            $glebar = 150;
            $gtinggi = 150;
            $glebar2 = 170;
            $gtinggi2 = 170;
            $judul_license_awards = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['judul_license_awards'])));
            $konten_license_awards = trim(mysqli_real_escape_string($koneksi, $_POST['konten_license_awards']));
            $tanggal_license_awards = date('Y-m-d H:i:s');
            $image_license_awards_file = $_FILES['upload_license_awards']['name'];
            $temp_license_awards_file = $_FILES['upload_license_awards']['tmp_name'];
            $ukuran_license_awards_file = $_FILES['upload_license_awards']['size'];
            $image_qrcode_file = $_FILES['upload_qrcode']['name'];
            $temp_qrcode_file = $_FILES['upload_qrcode']['tmp_name'];
            $ukuran_qrcode_file = $_FILES['upload_qrcode']['size'];
            $jenis_image = strtolower(pathinfo($image_license_awards_file, PATHINFO_EXTENSION));
            $jenis_qrcode = strtolower(pathinfo($image_qrcode_file, PATHINFO_EXTENSION));
            list($lebar, $tinggi) = getimagesize($temp_license_awards_file);
            list($lebar2, $tinggi2) = getimagesize($temp_qrcode_file);
            if ($ukuran_license_awards_file > $max_size && $ukuran_qrcode_file > $max_size)
            {
                $valid_file = false;
            }

            if ($jenis_image != "jpg" && $jenis_image != "jpeg" && $jenis_image != "png" && $jenis_image != "gif" && $jenis_qrcode != "jpg" && $jenis_qrcode != "jpeg" && $jenis_qrcode != "png" && $jenis_qrcode != "gif")
            {
                $valid_file = false;
            }

            if ($lebar != $glebar && $tinggi != $gtinggi && $lebar2 != $glebar2 && $tinggi2 != $gtinggi2)
            {
                $valid_file = false;
            }

            $fotobaru = date('dmYHis') . "_" . strtolower(str_replace(' ', '_', $image_license_awards_file));
            $path = "../upload/image/license_awards/" . $fotobaru;
            $fotobaru2 = date('dmYHis') . "_" . strtolower(str_replace(' ', '_', $image_qrcode_file));
            $path2 = "../upload/image/qrcode/" . $fotobaru2;
            if (!empty($judul_license_awards) && !empty($konten_license_awards))
            {
                if ($valid_file == true)
                {
                    if (move_uploaded_file($temp_license_awards_file, $path) && move_uploaded_file($temp_qrcode_file, $path2))
                    {
                        $input = mysqli_query($koneksi, "INSERT INTO license_award VALUES (NULL, '$judul_license_awards', '$fotobaru', '$fotobaru2', '$konten_license_awards', $urutan_license_awards)") or die(mysqli_error());
                        if ($input == true)
                        {
                            header("location: license_awards_tambah.php?status_form=berhasil&jenis_form=tambah");
                        }
                        else
                        {
                            header("location: license_awards_tambah.php?status_form=gagal&jenis_form=tambah");
                        }

                        $input = null;
                    }
                    else
                    {
                        header("location: license_awards_tambah.php?status_form=gagal_upload");
                    }
                }
                else
                {
                    header("location: license_awards_tambah.php?status_form=gambar_tidak_valid");
                }
            }
            else
            {
                header("location: license_awards_tambah.php?status_form=tidak_lengkap&b");
            }
        }
        else
        {
            header("location: license_awards_tambah.php?status_form=tidak_lengkap&a");
        }
    }

    if (isset($_POST['license_awards_edit']))
    {
        if (isset($_POST['judul_license_awards']) && isset($_POST['id']) && isset($_FILES['upload_license_awards']) && isset($_FILES['upload_qrcode']) && isset($_POST['konten_license_awards']) && isset($_POST['urutan_license_awards']))
        {
            if (empty($_POST['urutan_license_awards']) && $_POST['urutan_license_awards'] != "1" && $_POST['urutan_license_awards'] != "2" && $_POST['urutan_license_awards'] != "3" && $_POST['urutan_license_awards'] != "4" && $_POST['urutan_license_awards'] != "5")
            {
                $urutan_license_awards = "10";
            }
            else
            {
                $urutan_license_awards = $_POST['urutan_license_awards'];
            }

            $max_size = 100000;
            $glebar = 150;
            $gtinggi = 150;
            $glebar2 = 170;
            $gtinggi2 = 170;
            $id = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['id'])));
            $judul_license_awards = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['judul_license_awards'])));
            $konten_license_awards = trim(mysqli_real_escape_string($koneksi, $_POST['konten_license_awards']));
            $image_license_awards_file = $_FILES['upload_license_awards']['name'];
            $temp_license_awards_file = $_FILES['upload_license_awards']['tmp_name'];
            $ukuran_license_awards_file = $_FILES['upload_license_awards']['size'];
            $image_qrcode_file = $_FILES['upload_qrcode']['name'];
            $temp_qrcode_file = $_FILES['upload_qrcode']['tmp_name'];
            $ukuran_qrcode_file = $_FILES['upload_qrcode']['size'];
            if (!empty($image_license_awards_file) && !empty($temp_license_awards_file) && !empty($image_qrcode_file) && !empty($temp_qrcode_file))
            {
                $valid_file = true;
                $jenis_image = strtolower(pathinfo($image_license_awards_file, PATHINFO_EXTENSION));
                list($lebar, $tinggi) = getimagesize($temp_license_awards_file);
                $jenis_qrcode = strtolower(pathinfo($image_qrcode_file, PATHINFO_EXTENSION));
                list($lebar2, $tinggi2) = getimagesize($temp_qrcode_file);
                if ($ukuran_license_awards_file > $max_size && $ukuran_qrcode_file > $max_size)
                {
                    $valid_file = false;
                }

                if ($jenis_image != "jpg" && $jenis_image != "jpeg" && $jenis_image != "png" && $jenis_image != "gif" && $jenis_qrcode != "jpg" && $jenis_qrcode != "jpeg" && $jenis_qrcode != "png" && $jenis_qrcode != "gif")
                {
                    $valid_file = false;
                }

                if ($lebar != $glebar && $tinggi != $gtinggi && $lebar2 != $glebar2 && $tinggi2 != $gtinggi2)
                {
                    $valid_file = false;
                }

                $fotobaru = date('dmYHis') . "_" . strtolower(str_replace(' ', '_', $image_license_awards_file));
                $path = "../upload/image/license_awards/" . $fotobaru;
                $fotobaru2 = date('dmYHis') . "_" . strtolower(str_replace(' ', '_', $image_qrcode_file));
                $path2 = "../upload/image/qrcode/" . $fotobaru2;
            }

            if (!empty($judul_license_awards) && !empty($konten_license_awards))
            {
                if (!empty($image_license_awards_file) && !empty($temp_license_awards_file) && !empty($image_qrcode_file) && !empty($temp_qrcode_file))
                {
                    if ($valid_file == true)
                    {
                        if (move_uploaded_file($temp_license_awards_file, $path) && move_uploaded_file($temp_qrcode_file, $path2))
                        {
                            $cek_gambar_license_awards = mysqli_query($koneksi, "SELECT image_license_awards, image_qrcode FROM license_award WHERE id_license_awards = '$id' LIMIT 1") or die(mysqli_error());
                            if (mysqli_num_rows($cek_gambar_license_awards) == 1)
                            {
                                while ($daftar_license_awards = mysqli_fetch_array($cek_gambar_license_awards))
                                {
                                    $hapus_image = $daftar_license_awards['image_license_awards'];
                                    $hapus_image2 = $daftar_license_awards['image_qrcode'];
                                    if (file_exists("../upload/image/license_awards/" . $hapus_image) && file_exists("../upload/image/qrcode/" . $hapus_image2))
                                    {
                                        unlink("../upload/image/license_awards/" . $hapus_image);
                                        unlink("../upload/image/qrcode/" . $hapus_image2);
                                    }
                                    else
                                    {
                                        header("location: license_awards.php?status_form=gagal_hapus_gambar");
                                    }
                                }
                            }
                            else
                            {
                                header("location: license_awards.php?status_form=tidak_ada_data");
                            }
                        }
                        else
                        {
                            header("location: license_awards.php?status_form=gagal_upload");
                        }

                        $update2 = mysqli_query($koneksi, "UPDATE license_award SET judul_license_awards = '$judul_license_awards', image_license_awards = '$fotobaru', image_qrcode = '$fotobaru2', konten_license_awards = '$konten_license_awards', urutan = $urutan_license_awards WHERE id_license_awards = '$id' LIMIT 1;") or die(mysqli_error());
                        if ($update2 == true)
                        {
                            header("location: license_awards.php?status_form=berhasil&jenis_form=edit&a1");
                        }
                        else
                        {
                            header("location: license_awards.php?status_form=gagal&jenis_form=edit&a1");
                        }
                    }
                    else
                    {
                        header("location: license_awards.php?status_form=gambar_tidak_valid");
                    }
                }
                elseif (empty($image_license_awards_file) && empty($temp_license_awards_file) && empty($image_qrcode_file) && empty($temp_qrcode_file))
                {
                    $update2 = mysqli_query($koneksi, "UPDATE license_award SET judul_license_awards = '$judul_license_awards', konten_license_awards = '$konten_license_awards', urutan = $urutan_license_awards WHERE id_license_awards = '$id' LIMIT 1;") or die(mysqli_error());
                    if ($update2 == true)
                    {
                        header("location: license_awards.php?status_form=berhasil&jenis_form=edit&a2");
                    }
                    else
                    {
                        header("location: license_awards.php?status_form=gagal&jenis_form=edit&a2");
                    }
                }
            }
            else
            {
                header("location: license_awards.php?status_form=tidak_lengkap&b");
            }
        }
        else
        {
            header("location: license_awards.php?status_form=tidak_lengkap&a");
        }
    }

    if (isset($_GET['id_hapus_license_awards']))
    {
        if (!empty($_GET['id_hapus_license_awards']))
        {
            $id = trim(strip_tags(mysqli_real_escape_string($koneksi, $_GET['id_hapus_license_awards'])));
            $cek_terpilih = mysqli_query($koneksi, "SELECT id_license_awards FROM license_award WHERE id_license_awards = '$id'") or die(mysqli_error());
            if (mysqli_num_rows($cek_terpilih) == 0)
            {
                header("location: license_awards.php?status_form=tidak_ada_data");
            }
            elseif (mysqli_num_rows($cek_terpilih) == 1)
            {
                $cek_gambar_license_awards = mysqli_query($koneksi, "SELECT image_license_awards, image_qrcode FROM license_award WHERE id_license_awards = '$id' LIMIT 1") or die(mysqli_error());
                if (mysqli_num_rows($cek_gambar_license_awards) == 1)
                {
                    while ($daftar_license_awards = mysqli_fetch_array($cek_gambar_license_awards))
                    {
                        $hapus_image = $daftar_license_awards['image_license_awards'];
                        $hapus_image2 = $daftar_license_awards['image_qrcode'];
                        if (file_exists("../upload/image/license_awards/" . $hapus_image))
                        {
                            unlink("../upload/image/license_awards/" . $hapus_image);
                        }
                        else
                        {
                            header("location: license_awards.php?status_form=gagal_hapus_gambar");
                        }

                        if (file_exists("../upload/image/qrcode/" . $hapus_image2))
                        {
                            unlink("../upload/image/qrcode/" . $hapus_image2);
                        }
                        else
                        {
                            header("location: license_awards.php?status_form=gagal_hapus_gambar");
                        }
                    }
                }
                else
                {
                    header("location: license_awards.php?status_form=tidak_ada_data");
                }

                $hapus = mysqli_query($koneksi, "DELETE FROM license_award WHERE id_license_awards = '$id' LIMIT 1");
                if ($hapus == true)
                {
                    header("location: license_awards.php?status_form=berhasil&jenis_form=hapus");
                }
                else
                {
                    header("location: license_awards.php?status_form=gagal&jenis_form=hapus");
                }

                $hapus = null;
            }
        }
        else
        {
            header("location: license_awards.php?status_form=tidak_lengkap");
        }
    }

    // Tambah testimoni Tambah

    if (isset($_POST['testimoni_tambah']))
    {
        if (isset($_POST['person_testimoni']) && isset($_FILES['upload_testimoni']) && isset($_POST['jabatan_testimoni']) && isset($_POST['facebook_testimoni']) && isset($_POST['twitter_testimoni']) && isset($_POST['instagram_testimoni']) && isset($_POST['konten_testimoni']) && isset($_POST['urutan_testimoni']))
        {
            if (empty($_POST['urutan_testimoni']) && $_POST['urutan_testimoni'] != "1" && $_POST['urutan_testimoni'] != "2" && $_POST['urutan_testimoni'] != "3" && $_POST['urutan_testimoni'] != "4" && $_POST['urutan_testimoni'] != "5")
            {
                $urutan_testimoni = "10";
            }
            else
            {
                $urutan_testimoni = $_POST['urutan_testimoni'];
            }

            $valid_file = true;
            $max_size = 50000;
            $glebar = 80;
            $gtinggi = 80;
            $person_testimoni = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['person_testimoni'])));
            $jabatan_testimoni = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['jabatan_testimoni'])));
            $facebook_testimoni = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['facebook_testimoni'])));
            $twitter_testimoni = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['twitter_testimoni'])));
            $instagram_testimoni = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['instagram_testimoni'])));
            $konten_testimoni = trim(mysqli_real_escape_string($koneksi, $_POST['konten_testimoni']));
            $image_testimoni_file = $_FILES['upload_testimoni']['name'];
            $temp_testimoni_file = $_FILES['upload_testimoni']['tmp_name'];
            $ukuran_testimoni_file = $_FILES['upload_testimoni']['size'];
            $jenis_image = strtolower(pathinfo($image_testimoni_file, PATHINFO_EXTENSION));
            list($lebar, $tinggi) = getimagesize($temp_testimoni_file);
            if ($ukuran_testimoni_file > $max_size)
            {
                $valid_file = false;
            }

            if ($jenis_image != "jpg" && $jenis_image != "jpeg" && $jenis_image != "png" && $jenis_image != "gif")
            {
                $valid_file = false;
            }

            if ($lebar != $glebar && $tinggi != $gtinggi)
            {
                $valid_file = false;
            }

            $fotobaru = date('dmYHis') . "_" . strtolower(str_replace(' ', '_', $image_testimoni_file));
            $path = "../upload/image/testimoni/" . $fotobaru;
            if (!empty($person_testimoni) && !empty($jabatan_testimoni) && !empty($facebook_testimoni) && !empty($twitter_testimoni) && !empty($instagram_testimoni) && !empty($konten_testimoni))
            {
                if ($valid_file == true)
                {
                    if (move_uploaded_file($temp_testimoni_file, $path))
                    {
                        $input = mysqli_query($koneksi, "INSERT INTO testimoni VALUES (NULL, '$fotobaru', '$person_testimoni', '$jabatan_testimoni', '$twitter_testimoni', '$facebook_testimoni', '$instagram_testimoni', '$konten_testimoni', $urutan_testimoni)") or die(mysqli_error());
                        if ($input == true)
                        {
                            header("location: testimoni_tambah.php?status_form=berhasil&jenis_form=tambah");
                        }
                        else
                        {
                            header("location: testimoni_tambah.php?status_form=gagal&jenis_form=tambah");
                        }

                        $input = null;
                    }
                    else
                    {
                        header("location: testimoni_tambah.php?status_form=gagal_upload");
                    }
                }
                else
                {
                    header("location: testimoni_tambah.php?status_form=gambar_tidak_valid");
                }
            }
            else
            {
                header("location: testimoni_tambah.php?status_form=tidak_lengkap&b");
            }
        }
        else
        {
            header("location: testimoni_tambah.php?status_form=tidak_lengkap&a");
        }
    }

    if (isset($_POST['testimoni_edit']))
    {
        if (isset($_POST['person_testimoni']) && isset($_POST['id']) && isset($_FILES['upload_testimoni']) && isset($_POST['jabatan_testimoni']) && isset($_POST['facebook_testimoni']) && isset($_POST['twitter_testimoni']) && isset($_POST['instagram_testimoni']) && isset($_POST['konten_testimoni']) && isset($_POST['urutan_testimoni']))
        {
            if (empty($_POST['urutan_testimoni']) && $_POST['urutan_testimoni'] != "1" && $_POST['urutan_testimoni'] != "2" && $_POST['urutan_testimoni'] != "3" && $_POST['urutan_testimoni'] != "4" && $_POST['urutan_testimoni'] != "5")
            {
                $urutan_testimoni = "10";
            }
            else
            {
                $urutan_testimoni = $_POST['urutan_testimoni'];
            }

            $max_size = 50000;
            $glebar = 80;
            $gtinggi = 80;
            $id = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['id'])));
            $person_testimoni = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['person_testimoni'])));
            $jabatan_testimoni = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['jabatan_testimoni'])));
            $facebook_testimoni = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['facebook_testimoni'])));
            $twitter_testimoni = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['twitter_testimoni'])));
            $instagram_testimoni = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['instagram_testimoni'])));
            $konten_testimoni = trim(mysqli_real_escape_string($koneksi, $_POST['konten_testimoni']));
            $image_testimoni_file = $_FILES['upload_testimoni']['name'];
            $temp_testimoni_file = $_FILES['upload_testimoni']['tmp_name'];
            $ukuran_testimoni_file = $_FILES['upload_testimoni']['size'];
            if (!empty($image_testimoni_file) && !empty($temp_testimoni_file))
            {
                $valid_file = true;
                $jenis_image = strtolower(pathinfo($image_testimoni_file, PATHINFO_EXTENSION));
                list($lebar, $tinggi) = getimagesize($temp_testimoni_file);
                if ($ukuran_testimoni_file > $max_size)
                {
                    $valid_file = false;
                }

                if ($jenis_image != "jpg" && $jenis_image != "jpeg" && $jenis_image != "png" && $jenis_image != "gif")
                {
                    $valid_file = false;
                }

                if ($lebar != $glebar && $tinggi != $gtinggi)
                {
                    $valid_file = false;
                }

                $fotobaru = date('dmYHis') . "_" . strtolower(str_replace(' ', '_', $image_testimoni_file));
                $path = "../upload/image/testimoni/" . $fotobaru;
            }

            if (!empty($_POST['person_testimoni']) && !empty($_POST['jabatan_testimoni']) && !empty($_POST['facebook_testimoni']) && !empty($_POST['twitter_testimoni']) && !empty($_POST['instagram_testimoni']) && !empty($_POST['konten_testimoni']))
            {
                if (!empty($image_testimoni_file) && !empty($temp_testimoni_file))
                {
                    if ($valid_file == true)
                    {
                        if (move_uploaded_file($temp_testimoni_file, $path))
                        {
                            $cek_gambar_testimoni = mysqli_query($koneksi, "SELECT image_testimoni FROM testimoni WHERE id_testimoni = '$id' LIMIT 1") or die(mysqli_error());
                            if (mysqli_num_rows($cek_gambar_testimoni) == 1)
                            {
                                while ($daftar_testimoni = mysqli_fetch_array($cek_gambar_testimoni))
                                {
                                    $hapus_image = $daftar_testimoni['image_testimoni'];
                                    if (file_exists("../upload/image/testimoni/" . $hapus_image))
                                    {
                                        unlink("../upload/image/testimoni/" . $hapus_image);
                                    }
                                    else
                                    {
                                        header("location: testimoni.php?status_form=gagal_hapus_gambar");
                                    }
                                }
                            }
                            else
                            {
                                header("location: testimoni.php?status_form=tidak_ada_data");
                            }
                        }
                        else
                        {
                            header("location: testimoni.php?status_form=gagal_upload");
                        }

                        $update2 = mysqli_query($koneksi, "UPDATE testimoni SET person_testimoni = '$person_testimoni', image_testimoni = '$fotobaru', jabatan_testimoni = '$jabatan_testimoni', twitter_url = '$twitter_testimoni', facebook_url = '$facebook_testimoni', instagram_url = '$instagram_testimoni', konten_testimoni = '$konten_testimoni', urutan = $urutan_testimoni WHERE id_testimoni = '$id' LIMIT 1;") or die(mysqli_error());
                        if ($update2 == true)
                        {
                            header("location: testimoni.php?status_form=berhasil&jenis_form=edit&a1");
                        }
                        else
                        {
                            header("location: testimoni.php?status_form=gagal&jenis_form=edit&a1");
                        }
                    }
                    else
                    {
                        header("location: testimoni.php?status_form=gambar_tidak_valid");
                    }
                }
                elseif (empty($image_testimoni_file) && empty($temp_testimoni_file))
                {
                    $update2 = mysqli_query($koneksi, "UPDATE testimoni SET person_testimoni = '$person_testimoni', jabatan_testimoni = '$jabatan_testimoni', twitter_url = '$twitter_testimoni', facebook_url = '$facebook_testimoni', instagram_url = '$instagram_testimoni', konten_testimoni = '$konten_testimoni', urutan = $urutan_testimoni WHERE id_testimoni = '$id' LIMIT 1;") or die(mysqli_error());
                    if ($update2 == true)
                    {
                        header("location: testimoni.php?status_form=berhasil&jenis_form=edit&a2");
                    }
                    else
                    {
                        header("location: testimoni.php?status_form=gagal&jenis_form=edit&a2");
                    }
                }
            }
            else
            {
                header("location: testimoni.php?status_form=tidak_lengkap&b");
            }
        }
        else
        {
            header("location: testimoni.php?status_form=tidak_lengkap&a");
        }
    }

    if (isset($_GET['id_hapus_testimoni']))
    {
        if (!empty($_GET['id_hapus_testimoni']))
        {
            $id = trim(strip_tags(mysqli_real_escape_string($koneksi, $_GET['id_hapus_testimoni'])));
            $cek_terpilih = mysqli_query($koneksi, "SELECT id_testimoni FROM testimoni WHERE id_testimoni = '$id'") or die(mysqli_error());
            if (mysqli_num_rows($cek_terpilih) == 0)
            {
                header("location: testimoni.php?status_form=tidak_ada_data");
            }
            elseif (mysqli_num_rows($cek_terpilih) == 1)
            {
                $cek_gambar_testimoni = mysqli_query($koneksi, "SELECT image_testimoni FROM testimoni WHERE id_testimoni = '$id' LIMIT 1") or die(mysqli_error());
                if (mysqli_num_rows($cek_gambar_testimoni) == 1)
                {
                    while ($daftar_testimoni = mysqli_fetch_array($cek_gambar_testimoni))
                    {
                        $hapus_image = $daftar_testimoni['image_testimoni'];
                        if (file_exists("../upload/image/testimoni/" . $hapus_image))
                        {
                            unlink("../upload/image/testimoni/" . $hapus_image);
                        }
                        else
                        {
                            header("location: testimoni.php?status_form=gagal_hapus_gambar");
                        }
                    }
                }
                else
                {
                    header("location: testimoni.php?status_form=tidak_ada_data");
                }

                $hapus = mysqli_query($koneksi, "DELETE FROM testimoni WHERE id_testimoni = '$id' LIMIT 1");
                if ($hapus == true)
                {
                    header("location: testimoni.php?status_form=berhasil&jenis_form=hapus");
                }
                else
                {
                    header("location: testimoni.php?status_form=gagal&jenis_form=hapus");
                }

                $hapus = null;
            }
        }
        else
        {
            header("location: testimoni.php?status_form=tidak_lengkap");
        }
    }

    // Tambah info_web

    if (isset($_POST['info_web_tambah']))
    {
        if (isset($_POST['nama_perusahaan']) && isset($_POST['title_website']) && isset($_POST['deskripsi']) && isset($_FILES['upload_favicon']) && isset($_POST['keyword']) && isset($_POST['author']))
        {
            $nama_perusahaan = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['nama_perusahaan'])));
            $title_website = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['title_website'])));
            $deskripsi = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['deskripsi'])));
            $keyword = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['keyword'])));
            $author = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['author'])));
            $valid_file = true;
            $max_size = 100000;
            $glebar = 667;
            $gtinggi = 667;
            $image_favicon_file = $_FILES['upload_favicon']['name'];
            $temp_favicon_file = $_FILES['upload_favicon']['tmp_name'];
            $ukuran_favicon_file = $_FILES['upload_favicon']['size'];
            $jenis_image = strtolower(pathinfo($image_favicon_file, PATHINFO_EXTENSION));
            list($lebar, $tinggi) = getimagesize($temp_favicon_file);
            if ($ukuran_favicon_file > $max_size)
            {
                $valid_file = false;
            }

            if ($jenis_image != "jpg" && $jenis_image != "jpeg" && $jenis_image != "png" && $jenis_image != "gif")
            {
                $valid_file = false;
            }

            if ($lebar != $glebar && $tinggi != $gtinggi)
            {
                $valid_file = false;
            }

            $gambar_favicon_baru = date('dmYHis') . "_" . strtolower(str_replace(' ', '_', $image_favicon_file));
            $path = "../upload/image/favicon/" . $gambar_favicon_baru;
            if (!empty($nama_perusahaan) && !empty($title_website) && !empty($deskripsi) && !empty($keyword) && !empty($author))
            {
                $seleksi_info_web = mysqli_query($koneksi, "SELECT * FROM info_web LIMIT 1") or die("<script>alert('Query salah')</script>");
                $jumlah_info_web = mysqli_num_rows($seleksi_info_web);
                if ($jumlah_info_web == 0)
                {
                    if ($valid_file == true)
                    {
                        $input = mysqli_query($koneksi, "INSERT INTO info_web VALUES (NULL, '$nama_perusahaan', '$title_website', '$gambar_favicon_baru', '$deskripsi', '$keyword', '$author')") or die(mysqli_error());
                        if ($input == true)
                        {
                            if (move_uploaded_file($temp_favicon_file, $path))
                            {
                                header("location: info_web.php?status_form=berhasil&jenis_form=tambah");
                            }
                            else
                            {
                                header("location: info_web.php?status_form=gagal_upload");
                            }
                        }
                        else
                        {
                            header("location: info_web.php?status_form=gagal&jenis_form=tambah");
                        }

                        $input = null;
                    }
                    else
                    {
                        header("location: info_web.php?status_form=gambar_tidak_valid");
                    }
                }
                else
                {
                    header("location: info_web.php?status_form=tidak_ada_data");
                }
            }
            else
            {
                header("location: info_web.php?status_form=tidak_lengkap&a");
            }
        }
        else
        {
            header("location: info_web.php?status_form=tidak_lengkap&b");
        }
    }

    // Edit info_web

    if (isset($_POST['info_web_edit']))
    {
        if (isset($_POST['nama_perusahaan']) && isset($_POST['title_website']) && isset($_POST['deskripsi']) && isset($_FILES['upload_favicon']) && isset($_POST['keyword']) && isset($_POST['author']))
        {
            $nama_perusahaan = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['nama_perusahaan'])));
            $title_website = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['title_website'])));
            $deskripsi = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['deskripsi'])));
            $keyword = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['keyword'])));
            $author = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['author'])));
            $valid_file = true;
            $max_size = 100000;
            $glebar = 667;
            $gtinggi = 667;
            $image_favicon_file = $_FILES['upload_favicon']['name'];
            $temp_favicon_file = $_FILES['upload_favicon']['tmp_name'];
            if (!empty($image_favicon_file) && !empty($temp_favicon_file))
            {
                $ukuran_favicon_file = $_FILES['upload_favicon']['size'];
                $jenis_image = strtolower(pathinfo($image_favicon_file, PATHINFO_EXTENSION));
                list($lebar, $tinggi) = getimagesize($temp_favicon_file);
                if ($ukuran_favicon_file > $max_size)
                {
                    $valid_file = false;
                }

                if ($jenis_image != "jpg" && $jenis_image != "jpeg" && $jenis_image != "png" && $jenis_image != "gif")
                {
                    $valid_file = false;
                }

                if ($lebar != $glebar && $tinggi != $gtinggi)
                {
                    $valid_file = false;
                }

                $gambar_favicon_baru = date('dmYHis') . "_" . strtolower(str_replace(' ', '_', $image_favicon_file));
                $path = "../upload/image/favicon/" . $gambar_favicon_baru;
            }

            if (!empty($nama_perusahaan) && !empty($title_website) && !empty($deskripsi) && !empty($keyword) && !empty($author))
            {
                if (!empty($image_favicon_file) && !empty($temp_favicon_file))
                {
                    if ($valid_file == true)
                    {
                        if (move_uploaded_file($temp_favicon_file, $path))
                        {
                            $cek_favicon = mysqli_query($koneksi, "SELECT favicon FROM info_web LIMIT 1") or die(mysqli_error());
                            if (mysqli_num_rows($cek_favicon) == 1)
                            {
                                while ($daftar_favicon = mysqli_fetch_array($cek_gambar_favicon))
                                {
                                    $hapus_image = $daftar_favicon['favicon'];
                                    if (file_exists("../upload/image/favicon/" . $hapus_image))
                                    {
                                        unlink("../upload/image/favicon/" . $hapus_image);
                                    }
                                    else
                                    {
                                        header("location: favicon.php?status_form=gagal_hapus_gambar");
                                    }
                                }
                            }
                            else
                            {
                                header("location: favicon.php?status_form=tidak_ada_data");
                            }
                        }
                        else
                        {
                            header("location: favicon.php?status_form=gagal_upload");
                        }

                        $update2 = mysqli_query($koneksi, "UPDATE info_web SET nama_perusahaan = '$nama_perusahaan', title_website = '$title_website', favicon ='$gambar_favicon_baru', deskripsi = '$deskripsi', keyword = '$keyword', author = '$author' WHERE info_web.id_info_web > 0 LIMIT 1") or die(mysqli_error());
                        if ($update2 == true)
                        {
                            header("location: info_web.php?status_form=berhasil&jenis_form=edit&a1");
                        }
                        else
                        {
                            header("location: info_web.php?status_form=gagal&jenis_form=edit&a1");
                        }
                    }
                    else
                    {
                        header("location: info_web.php?status_form=gambar_tidak_valid");
                    }
                }
                elseif (empty($image_favicon_file) && empty($temp_favicon_file))
                {
                    $update2 = mysqli_query($koneksi, "UPDATE info_web SET nama_perusahaan = '$nama_perusahaan', title_website = '$title_website', deskripsi = '$deskripsi', keyword = '$keyword', author = '$author' WHERE info_web.id_info_web > 0 LIMIT 1") or die(mysqli_error());
                    if ($update2 == true)
                    {
                        header("location: info_web.php?status_form=berhasil&jenis_form=edit&a2");
                    }
                    else
                    {
                        header("location: info_web.php?status_form=gagal&jenis_form=edit&a2");
                    }
                }
            }
            else
            {
                header("location: info_web.php?status_form=tidak_lengkap&a");
            }
        }
        else
        {
            header("location: info_web.php?status_form=tidak_lengkap&b");
        }
    }

    // Edit profile

    if (isset($_POST['profile_edit']))
    {
        if (isset($_POST['profile_nama']) && isset($_POST['profile_jabatan']) && isset($_FILES['profile_upload']))
        {
            $profile_nama = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['profile_nama'])));
            $profile_jabatan = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['profile_jabatan'])));
            $max_size = 100000;
            $glebar = 150;
            $gtinggi = 150;
            $image_profile_file = $_FILES['profile_upload']['name'];
            $temp_profile_file = $_FILES['profile_upload']['tmp_name'];
            $ukuran_profile_file = $_FILES['profile_upload']['size'];
            $valid_file = false;
            if (!empty($image_profile_file) && !empty($temp_profile_file))
            {
                $valid_file = true;
                $jenis_image = strtolower(pathinfo($image_profile_file, PATHINFO_EXTENSION));
                list($lebar, $tinggi) = getimagesize($temp_profile_file);
                if ($ukuran_profile_file > $max_size)
                {
                    $valid_file = false;
                }

                if ($jenis_image != "jpg" && $jenis_image != "jpeg" && $jenis_image != "png" && $jenis_image != "gif")
                {
                    $valid_file = false;
                }

                if ($lebar != $glebar && $tinggi != $gtinggi)
                {
                    $valid_file = false;
                }

                $gambar_profile_baru = date('dmYHis') . "_" . strtolower(str_replace(' ', '_', $image_profile_file));
                $path = "../upload/image/user/" . $gambar_profile_baru;
            }

            if (!empty($profile_nama) && !empty($profile_jabatan))
            {
                if (!empty($image_profile_file) && !empty($temp_profile_file))
                {
                    if ($valid_file == true)
                    {
                        if (move_uploaded_file($temp_profile_file, $path))
                        {
                            $cek_gambar_profile = mysqli_query($koneksi, "SELECT image_user FROM user WHERE id_user = '" . $_SESSION['id_user'] . "' && level = '" . $_SESSION['level'] . "' LIMIT 1") or die(mysqli_error());
                            if (mysqli_num_rows($cek_gambar_profile) == 1)
                            {
                                while ($daftar_profile = mysqli_fetch_array($cek_gambar_profile))
                                {
                                    $hapus_image = $daftar_profile['image_user'];
                                    if (file_exists("../upload/image/user/" . $hapus_image))
                                    {
                                        unlink("../upload/image/user/" . $hapus_image);
                                    }
                                    else
                                    {
                                        header("location: profile.php?status_form=gagal_hapus_gambar");
                                    }
                                }
                            }
                            else
                            {
                                header("location: profile.php?status_form=tidak_ada_data");
                            }
                        }
                        else
                        {
                            header("location: profile.php?status_form=gagal_upload");
                        }

                        $update2 = mysqli_query($koneksi, "UPDATE user SET nama_user = '$profile_nama', jabatan_user = '$profile_jabatan', image_user = '$gambar_profile_baru' WHERE id_user = '" . $_SESSION['id_user'] . "' && level = '" . $_SESSION['level'] . "' LIMIT 1") or die(mysqli_error());
                        if ($update2 == true)
                        {
                            header("location: profile.php?status_form=berhasil&jenis_form=edit&a");
                        }
                        else
                        {
                            header("location: profile.php?status_form=gagal&jenis_form=edit&a");
                        }
                    }
                    else
                    {
                        header("location: profile.php?status_form=gambar_tidak_valid");
                    }
                }
                elseif (empty($image_profile_file) && empty($temp_profile_file))
                {
                    $update2 = mysqli_query($koneksi, "UPDATE user SET nama_user = '$profile_nama', jabatan_user = '$profile_jabatan' WHERE id_user = '" . $_SESSION['id_user'] . "' && level = '" . $_SESSION['level'] . "' LIMIT 1") or die(mysqli_error());
                    if ($update2 == true)
                    {
                        header("location: profile.php?status_form=berhasil&jenis_form=edit&b");
                    }
                    else
                    {
                        header("location: profile.php?status_form=gagal&jenis_form=edit&b");
                    }
                }
            }
        }
        else
        {
            header("location: profile.php?status_form=tidak_lengkap&b");
        }
    }

    // Edit username & password

    if (isset($_POST['profile_edit_username']))
    {
        if (isset($_POST['username']) && isset($_POST['password_lama']) && isset($_POST['password_baru']) && isset($_POST['konfirm_password_baru']))
        {
            $username = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['username'])));
            $password_lama = md5($_POST['password_lama']);
            $password_baru = md5($_POST['password_baru']);
            $konfirm_password_baru = md5($_POST['konfirm_password_baru']);
            if (!empty($username) && !empty($password_lama) && !empty($password_baru) && !empty($konfirm_password_baru))
            {
                $seleksi_username_password = mysqli_query($koneksi, "SELECT username, password FROM user WHERE id_user = '" . $_SESSION['id_user'] . "' && level = '" . $_SESSION['level'] . "' LIMIT 1") or die("<script>alert('Query salah')</script>");
                $jumlah_username_password = mysqli_num_rows($seleksi_username_password);
                $daftar_username_password = mysqli_fetch_array($seleksi_username_password);
                if (!$jumlah_username_password >= 1)
                {
                    unset($_SESSION['id_user']);
                    unset($_SESSION['level']);
                    header("location: index.php");
                }
                elseif ($password_lama != $daftar_username_password['password'])
                {
                    header("location: profile.php?status_form=password_lama_tidak");
                }
                elseif ($password_lama == $password_baru)
                {
                    header("location: profile.php?status_form=password_lama_baru");
                }
                elseif ($password_baru != $konfirm_password_baru)
                {
                    header("location: profile.php?status_form=password_tidak_sama");
                }
                else
                {
                    $update = mysqli_query($koneksi, "UPDATE user SET username = '$username', password = '$konfirm_password_baru' WHERE id_user = '" . $_SESSION['id_user'] . "' && level = '" . $_SESSION['level'] . "' LIMIT 1") or die(mysqli_error());
                    if ($update == true)
                    {
                        header("location: profile.php?status_form=berhasil&jenis_form=edit");
                    }
                    else
                    {
                        header("location: profile.php?status_form=gagal&jenis_form=edit");
                    }

                    $update = null;
                }
            }
            else
            {
                header("location: profile.php?status_form=tidak_lengkap");
            }
        }
        else
        {
            header("location: profile.php?status_form=tidak_lengkap");
        }
    }

    // tambah cover video

    if (isset($_POST['cover_video_tambah']))
    {
        if (isset($_POST['nama_cover']) && isset($_FILES['upload_cover']) && !$_FILES['upload_cover']['error'])
        {
            $cover_status = "";
            if (isset($_POST['dipakai']) && $_POST['dipakai'] == 1)
            {
                $cover_status = 'ya';
            }
            else
            {
                $cover_status = 'tidak';
            }

            $valid_file = true;
            $max_size = 200000;
            $glebar = 4200;
            $gtinggi = 1800;
            $nama_cover = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['nama_cover'])));
            $image_cover_file = $_FILES['upload_cover']['name'];
            $temp_cover_file = $_FILES['upload_cover']['tmp_name'];
            $ukuran_cover_file = $_FILES['upload_cover']['size'];
            $jenis_image = strtolower(pathinfo($image_cover_file, PATHINFO_EXTENSION));
            list($lebar, $tinggi) = getimagesize($temp_cover_file);
            if ($ukuran_cover_file > $max_size)
            {
                $valid_file = false;
            }

            if ($jenis_image != "jpg" && $jenis_image != "jpeg" && $jenis_image != "png" && $jenis_image != "gif")
            {
                $valid_file = false;
            }

            if ($lebar != $glebar && $tinggi != $gtinggi)
            {
                $valid_file = false;
            }

            $fotobaru = date('dmYHis') . "_" . strtolower(str_replace(' ', '_', $image_cover_file));
            $path = "../upload/image/cover_v/" . $fotobaru;
            if (!empty($nama_cover))
            {
                if ($valid_file == true)
                {
                    if (move_uploaded_file($temp_cover_file, $path))
                    {
                        if ($cover_status == "ya")
                        {
                            $update = mysqli_query($koneksi, "UPDATE cover_video SET used = 'tidak' WHERE cover_video.id_cover > 0") or die(mysqli_error());
                            $input = mysqli_query($koneksi, "INSERT INTO cover_video VALUES (NULL, '$nama_cover', '$fotobaru', '$cover_status')") or die(mysqli_error());
                            if ($input == true)
                            {
                                header("location: cover_video_tambah.php?status_form=berhasil&jenis_form=tambah");
                            }
                            else
                            {
                                header("location: cover_video_tambah.php?status_form=gagal&jenis_form=tambah");
                            }

                            $input = null;
                            $update = null;
                        }
                        else
                        {
                            $input = mysqli_query($koneksi, "INSERT INTO cover_video VALUES (NULL, '$nama_cover', '$fotobaru', '$cover_status')") or die(mysqli_error());
                            if ($input == true)
                            {
                                header("location: cover_video_tambah.php?status_form=berhasil&jenis_form=tambah");
                            }
                            else
                            {
                                header("location: cover_video_tambah.php?status_form=gagal&jenis_form=tambah");
                            }

                            $input = null;
                            $update = null;
                        }
                    }
                    else
                    {
                        header("location: cover_video_tambah.php?status_form=gagal_upload");
                    }
                }
                else
                {
                    header("location: cover_video_tambah.php?status_form=gambar_tidak_valid");
                }
            }
            else
            {
                header("location: cover_video_tambah.php?status_form=tidak_lengkap&b");
            }
        }
        else
        {
            header("location: cover_video_tambah.php?status_form=tidak_lengkap&a");
        }
    }

    if (isset($_POST['cover_video_edit']))
    {
        if (isset($_POST['nama_cover']) && isset($_POST['id']) && isset($_FILES['upload_cover']))
        {
            $cover_status = "";
            if (isset($_POST['dipakai']) && $_POST['dipakai'] == 1)
            {
                $cover_status = 'ya';
            }
            else
            {
                $cover_status = 'tidak';
            }

            $max_size = 200000;
            $glebar = 4200;
            $gtinggi = 1800;
            $id = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['id'])));
            $judul_cover = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['nama_cover'])));
            $image_cover_file = $_FILES['upload_cover']['name'];
            $temp_cover_file = $_FILES['upload_cover']['tmp_name'];
            $ukuran_cover_file = $_FILES['upload_cover']['size'];
            if (!empty($image_cover_file) && !empty($temp_cover_file))
            {
                $valid_file = true;
                $jenis_image = strtolower(pathinfo($image_cover_file, PATHINFO_EXTENSION));
                list($lebar, $tinggi) = getimagesize($temp_cover_file);
                if ($ukuran_cover_file > $max_size)
                {
                    $valid_file = false;
                }

                if ($jenis_image != "jpg" && $jenis_image != "jpeg" && $jenis_image != "png" && $jenis_image != "gif")
                {
                    $valid_file = false;
                }

                if ($lebar != $glebar && $tinggi != $gtinggi)
                {
                    $valid_file = false;
                }

                $fotobaru = date('dmYHis') . "_" . strtolower(str_replace(' ', '_', $image_cover_file));
                $path = "../upload/image/cover_v/" . $fotobaru;
            }

            if (!empty($judul_cover))
            {
                if ($cover_status == "ya")
                {
                    if (!empty($image_cover_file) && !empty($temp_cover_file))
                    {
                        if ($valid_file == true)
                        {
                            if (move_uploaded_file($temp_cover_file, $path))
                            {
                                $cek_gambar_cover = mysqli_query($koneksi, "SELECT gambar_cover FROM cover_background WHERE id_cover = '$id' LIMIT 1") or die(mysqli_error());
                                if (mysqli_num_rows($cek_gambar_cover) == 1)
                                {
                                    while ($daftar_cover = mysqli_fetch_array($cek_gambar_cover))
                                    {
                                        $hapus_image = $daftar_cover['gambar_cover'];
                                        if (file_exists("../upload/image/cover_v/" . $hapus_image))
                                        {
                                            unlink("../upload/image/cover_v/" . $hapus_image);
                                        }
                                        else
                                        {
                                            header("location: cover_video.php?status_form=gagal_hapus_gambar");
                                        }
                                    }
                                }
                                else
                                {
                                    header("location: cover_video.php?status_form=tidak_ada_data");
                                }
                            }
                            else
                            {
                                header("location: cover_video.php?status_form=gagal_upload");
                            }

                            $update2 = mysqli_query($koneksi, "UPDATE cover_video SET judul_cover = '$judul_cover', gambar_cover = '$fotobaru', used = '$cover_status' WHERE cover_video.id_cover = '$id' LIMIT 1;") or die(mysqli_error());
                            if ($update2 == true)
                            {
                                header("location: cover_video.php?status_form=berhasil&jenis_form=edit&a1");
                            }
                            else
                            {
                                header("location: cover_video.php?status_form=gagal&jenis_form=edit&a1");
                            }
                        }
                        else
                        {
                            header("location: cover_video.php?status_form=gambar_tidak_valid");
                        }
                    }
                    elseif (empty($image_cover_file) && empty($temp_cover_file))
                    {
                        $update2 = mysqli_query($koneksi, "UPDATE cover_video SET judul_cover = '$judul_cover', used = '$cover_status' WHERE cover_video.id_cover = '$id' LIMIT 1;") or die(mysqli_error());
                        if ($update2 == true)
                        {
                            header("location: cover_video.php?status_form=berhasil&jenis_form=edit&a2");
                        }
                        else
                        {
                            header("location: cover_video.php?status_form=gagal&jenis_form=edit&a2");
                        }
                    }
                }
                else
                {
                    if (!empty($image_cover_file) && !empty($temp_cover_file))
                    {
                        if ($valid_file == true)
                        {
                            if (move_uploaded_file($temp_cover_file, $path))
                            {
                                $cek_gambar_cover = mysqli_query($koneksi, "SELECT gambar_cover FROM cover_background WHERE id_cover = '$id' LIMIT 1") or die(mysqli_error());
                                if (mysqli_num_rows($cek_gambar_cover) == 1)
                                {
                                    while ($daftar_cover = mysqli_fetch_array($cek_gambar_cover))
                                    {
                                        $hapus_image = $daftar_cover['gambar_cover'];
                                        if (file_exists("../upload/image/cover_v/" . $hapus_image))
                                        {
                                            unlink("../upload/image/cover_v/" . $hapus_image);
                                        }
                                        else
                                        {
                                            header("location: cover_video.php?status_form=gagal_hapus_gambar");
                                        }
                                    }
                                }
                                else
                                {
                                    header("location: cover_video.php?status_form=tidak_ada_data");
                                }
                            }
                            else
                            {
                                header("location: cover_video.php?status_form=gagal_upload");
                            }

                            $update2 = mysqli_query($koneksi, "UPDATE cover_video SET judul_cover = '$judul_cover', gambar_cover = '$fotobaru', used = '$cover_status' WHERE cover_video.id_cover = '$id' LIMIT 1;") or die(mysqli_error());
                            if ($update2 == true)
                            {
                                header("location: cover_video.php?status_form=berhasil&jenis_form=edit&a1");
                            }
                            else
                            {
                                header("location: cover_video.php?status_form=gagal&jenis_form=edit&a1");
                            }
                        }
                        else
                        {
                            header("location: cover_video.php?status_form=gambar_tidak_valid");
                        }
                    }
                    elseif (empty($image_cover_file) && empty($temp_cover_file))
                    {
                        $update2 = mysqli_query($koneksi, "UPDATE cover_video SET judul_cover = '$judul_cover', used = '$cover_status' WHERE cover_video.id_cover = '$id' LIMIT 1;") or die(mysqli_error());
                        if ($update2 == true)
                        {
                            header("location: cover_video.php?status_form=berhasil&jenis_form=edit&a2");
                        }
                        else
                        {
                            header("location: cover_video.php?status_form=gagal&jenis_form=edit&a2");
                        }
                    }
                }
            }
            else
            {
                header("location: cover_video.php?status_form=tidak_lengkap&b");
            }
        }
        else
        {
            header("location: cover_video.php?status_form=tidak_lengkap&a");
        }
    }

    if (isset($_GET['id_hapus_cover_video']))
    {
        if (!empty($_GET['id_hapus_cover_video']))
        {
            $id = trim(strip_tags(mysqli_real_escape_string($koneksi, $_GET['id_hapus_cover_video'])));
            $cek_terpilih = mysqli_query($koneksi, "SELECT id_cover FROM cover_video WHERE id_cover = '$id'") or die(mysqli_error());
            if (mysqli_num_rows($cek_terpilih) == 0)
            {
                header("location: cover_video.php?status_form=tidak_ada_data");
            }
            elseif (mysqli_num_rows($cek_terpilih) == 1)
            {
                $cek_gambar_cover = mysqli_query($koneksi, "SELECT gambar_cover FROM cover_video WHERE id_cover = '$id' LIMIT 1") or die(mysqli_error());
                if (mysqli_num_rows($cek_gambar_cover) == 1)
                {
                    while ($daftar_cover = mysqli_fetch_array($cek_gambar_cover))
                    {
                        $hapus_image = $daftar_cover['gambar_cover'];
                        if (file_exists("../upload/image/cover_v/" . $hapus_image))
                        {
                            unlink("../upload/image/cover_v/" . $hapus_image);
                        }
                        else
                        {
                            header("location: cover_video.php?status_form=gagal_hapus_gambar");
                        }
                    }
                }

                $hapus = mysqli_query($koneksi, "DELETE FROM cover_video WHERE id_cover = '$id' LIMIT 1");
                if ($hapus == true)
                {
                    header("location: cover_video.php?status_form=berhasil&jenis_form=hapus");
                }
                else
                {
                    header("location: cover_video.php?status_form=gagal&jenis_form=hapus");
                }

                $hapus = null;
            }
        }
        else
        {
            header("location: cover_video.php?status_form=tidak_lengkap");
        }
    }
}


if($_SESSION['level'] == 'superuser' || $_SESSION['level'] == 'admin' || $_SESSION['level'] == 'marketing' || $_SESSION['level'] == 'news'){
// Tambah event_news Tambah
    if (isset($_POST['event_news_tambah']))
    {
        if (isset($_POST['judul_event_news']) && isset($_POST['sub_judul_event_news']) && isset($_FILES['upload_event_news']) && !$_FILES['upload_event_news']['error'] && isset($_POST['konten_event_news']) && isset($_POST['author_event_news']) && isset($_POST['urutan_event_news']) && isset($_POST['jenis_event_news']))
        {
            if (empty($_POST['urutan_event_news']) && $_POST['urutan_event_news'] != "1" && $_POST['urutan_event_news'] != "2" && $_POST['urutan_event_news'] != "3" && $_POST['urutan_event_news'] != "4" && $_POST['urutan_event_news'] != "5")
            {
                $urutan_event_news = "10";
            }
            else
            {
                $urutan_event_news = $_POST['urutan_event_news'];
            }

            $valid_file = true;
            $max_size = 100000;
            $glebar = 410;
            $gtinggi = 303;
            $judul_event_news = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['judul_event_news'])));
            $sub_judul_event_news = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['sub_judul_event_news'])));
            $konten_event_news = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['konten_event_news'])));
            $author_event_news = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['author_event_news'])));
            $id_event_news_kategori = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['jenis_event_news'])));

            $tanggal_event_news = date('Y-m-d H:i:s');
            $image_event_news_file = $_FILES['upload_event_news']['name'];
            $temp_event_news_file = $_FILES['upload_event_news']['tmp_name'];
            $ukuran_event_news_file = $_FILES['upload_event_news']['size'];
            $jenis_image = strtolower(pathinfo($image_event_news_file, PATHINFO_EXTENSION));
            list($lebar, $tinggi) = getimagesize($temp_event_news_file);
            if ($ukuran_event_news_file > $max_size)
            {
                $valid_file = false;
            }

            if ($jenis_image != "jpg" && $jenis_image != "jpeg" && $jenis_image != "png" && $jenis_image != "gif")
            {
                $valid_file = false;
            }

            if ($lebar != $glebar && $tinggi != $gtinggi)
            {
                $valid_file = false;
            }

            $fotobaru = date('dmYHis') . "_" . strtolower(str_replace(' ', '_', $image_event_news_file));
            $path = "../upload/image/event_news/" . $fotobaru;
            if (!empty($judul_event_news) && !empty($sub_judul_event_news) && !empty($konten_event_news) && !empty($author_event_news) && !empty($id_event_news_kategori))
            {
                if ($valid_file == true)
                {
                    if (move_uploaded_file($temp_event_news_file, $path))
                    {
                        $input = mysqli_query($koneksi, "INSERT INTO event_news VALUES (NULL, '$judul_event_news', '$sub_judul_event_news', '$fotobaru', '$tanggal_event_news', '$konten_event_news', '$author_event_news', '$id_event_news_kategori', '$urutan_event_news')") or die(mysqli_error());
                        if ($input == true)
                        {
                            header("location: event_news_tambah.php?status_form=berhasil&jenis_form=tambah");
                        }
                        else
                        {
                            header("location: event_news_tambah.php?status_form=gagal&jenis_form=tambah");
                        }

                        $input = null;
                    }
                    else
                    {
                        header("location: event_news_tambah.php?status_form=gagal_upload");
                    }
                }
                else
                {
                    header("location: event_news_tambah.php?status_form=gambar_tidak_valid");
                }
            }
            else
            {
                header("location: event_news_tambah.php?status_form=tidak_lengkap&b");
            }
        }
        else
        {
            header("location: event_news_tambah.php?status_form=tidak_lengkap&a");
        }
    }

    if (isset($_POST['event_news_edit']))
    {
        if (isset($_POST['judul_event_news']) && isset($_POST['sub_judul_event_news']) && isset($_POST['id']) && isset($_FILES['upload_event_news']) && isset($_POST['konten_event_news']) && isset($_POST['author_event_news']) && isset($_POST['urutan_event_news']) && isset($_POST['jenis_event_news']))
        {
            if (empty($_POST['urutan_event_news']) && $_POST['urutan_event_news'] != "1" && $_POST['urutan_event_news'] != "2" && $_POST['urutan_event_news'] != "3" && $_POST['urutan_event_news'] != "4" && $_POST['urutan_event_news'] != "5")
            {
                $urutan_event_news = "10";
            }
            else
            {
                $urutan_event_news = $_POST['urutan_event_news'];
            }

            $max_size = 100000;
            $glebar = 410;
            $gtinggi = 303;
            $id = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['id'])));
            $judul_event_news = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['judul_event_news'])));
            $sub_judul_event_news = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['sub_judul_event_news'])));
            $konten_event_news = trim(mysqli_real_escape_string($koneksi, $_POST['konten_event_news']));
            $author_event_news = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['author_event_news'])));
            $id_event_news_kategori = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['jenis_event_news'])));

            $tanggal_event_news = date('Y-m-d H:i:s');
            $image_event_news_file = $_FILES['upload_event_news']['name'];
            $temp_event_news_file = $_FILES['upload_event_news']['tmp_name'];
            $ukuran_event_news_file = $_FILES['upload_event_news']['size'];
            if (!empty($image_event_news_file) && !empty($temp_event_news_file))
            {
                $valid_file = true;
                $jenis_image = strtolower(pathinfo($image_event_news_file, PATHINFO_EXTENSION));
                list($lebar, $tinggi) = getimagesize($temp_event_news_file);
                if ($ukuran_event_news_file > $max_size)
                {
                    $valid_file = false;
                }

                if ($jenis_image != "jpg" && $jenis_image != "jpeg" && $jenis_image != "png" && $jenis_image != "gif")
                {
                    $valid_file = false;
                }

                if ($lebar != $glebar && $tinggi != $gtinggi)
                {
                    $valid_file = false;
                }

                $fotobaru = date('dmYHis') . "_" . strtolower(str_replace(' ', '_', $image_event_news_file));
                $path = "../upload/image/event_news/" . $fotobaru;
            }

            if (!empty($judul_event_news) && !empty($sub_judul_event_news) && !empty($konten_event_news))
            {
                if (!empty($image_event_news_file) && !empty($temp_event_news_file))
                {
                    if ($valid_file == true)
                    {
                        if (move_uploaded_file($temp_event_news_file, $path))
                        {
                            $cek_gambar_event_news = mysqli_query($koneksi, "SELECT image_event_news FROM event_news WHERE id_event_news = '$id' LIMIT 1") or die(mysqli_error());
                            if (mysqli_num_rows($cek_gambar_event_news) == 1)
                            {
                                while ($daftar_event_news = mysqli_fetch_array($cek_gambar_event_news))
                                {
                                    $hapus_image = $daftar_event_news['image_event_news'];
                                    if (file_exists("../upload/image/event_news/" . $hapus_image))
                                    {
                                        unlink("../upload/image/event_news/" . $hapus_image);
                                    }
                                    else
                                    {
                                        header("location: event_news.php?status_form=gagal_hapus_gambar");
                                    }
                                }
                            }
                            else
                            {
                                header("location: event_news.php?status_form=tidak_ada_data");
                            }
                        }
                        else
                        {
                            header("location: event_news.php?status_form=gagal_upload");
                        }

                        $update2 = mysqli_query($koneksi, "UPDATE event_news SET judul_event_news = '$judul_event_news', sub_judul_event_news = '$sub_judul_event_news', image_event_news = '$fotobaru', tanggal_event_news = '$tanggal_event_news', konten_event_news = '$konten_event_news', author_event_news = '$author_event_news', id_event_news_kategori = '$id_event_news_kategori', urutan = $urutan_event_news WHERE event_news.id_event_news = '$id' LIMIT 1;") or die(mysqli_error());
                        if ($update2 == true)
                        {
                            header("location: event_news.php?status_form=berhasil&jenis_form=edit&a1");
                        }
                        else
                        {
                            header("location: event_news.php?status_form=gagal&jenis_form=edit&a1");
                        }
                    }
                    else
                    {
                        header("location: event_news.php?status_form=gambar_tidak_valid");
                    }
                }
                elseif (empty($image_event_news_file) && empty($temp_event_news_file))
                {
                    $update2 = mysqli_query($koneksi, "UPDATE event_news SET judul_event_news = '$judul_event_news', sub_judul_event_news = '$sub_judul_event_news', tanggal_event_news = '$tanggal_event_news', konten_event_news = '$konten_event_news', author_event_news = '$author_event_news', id_event_news_kategori = '$id_event_news_kategori', urutan = $urutan_event_news WHERE event_news.id_event_news = '$id' LIMIT 1;") or die(mysqli_error());
                    if ($update2 == true)
                    {
                        header("location: event_news.php?status_form=berhasil&jenis_form=edit&a2");
                    }
                    else
                    {
                        header("location: event_news.php?status_form=gagal&jenis_form=edit&a2");
                    }
                }
            }
            else
            {
                header("location: event_news.php?status_form=tidak_lengkap&b");
            }
        }
        else
        {
            header("location: event_news.php?status_form=tidak_lengkap&a");
        }
    }

    if (isset($_GET['id_hapus_event_news']))
    {
        if (!empty($_GET['id_hapus_event_news']))
        {
            $id = trim(strip_tags(mysqli_real_escape_string($koneksi, $_GET['id_hapus_event_news'])));
            $cek_terpilih = mysqli_query($koneksi, "SELECT id_event_news FROM event_news WHERE id_event_news = '$id'") or die(mysqli_error());
            if (mysqli_num_rows($cek_terpilih) == 0)
            {
                header("location: event_news.php?status_form=tidak_ada_data");
            }
            elseif (mysqli_num_rows($cek_terpilih) == 1)
            {
                $cek_gambar_event_news = mysqli_query($koneksi, "SELECT image_event_news FROM event_news WHERE id_event_news = '$id' LIMIT 1") or die(mysqli_error());
                if (mysqli_num_rows($cek_gambar_event_news) == 1)
                {
                    while ($daftar_event_news = mysqli_fetch_array($cek_gambar_event_news))
                    {
                        $hapus_image = $daftar_event_news['image_event_news'];
                        if (file_exists("../upload/image/event_news/" . $hapus_image))
                        {
                            unlink("../upload/image/event_news/" . $hapus_image);
                        }
                        else
                        {
                            header("location: event_news.php?status_form=gagal_hapus_gambar");
                        }
                    }
                }

                $hapus = mysqli_query($koneksi, "DELETE FROM event_news WHERE id_event_news = '$id' LIMIT 1");
                if ($hapus == true)
                {
                    header("location: event_news.php?status_form=berhasil&jenis_form=hapus");
                }
                else
                {
                    header("location: event_news.php?status_form=gagal&jenis_form=hapus");
                }

                $hapus = null;
            }
        }
        else
        {
            header("location: event_news.php?status_form=tidak_lengkap");
        }
    }

    // Tambah Kategori Event News

    if (isset($_POST['event_news_kategori_tambah']))
    {
        if (isset($_POST['nama_event_news_kategori']) && isset($_POST['slug_event_news_kategori']))
        {
            $nama_event_news_kategori = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['nama_event_news_kategori'])));
            $slug_event_news_kategori = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['slug_event_news_kategori'])));

            if (!empty($nama_event_news_kategori) && !empty($slug_event_news_kategori))
            {
                $input = mysqli_query($koneksi, "INSERT INTO event_news_kategori VALUES (NULL, '$nama_event_news_kategori', '$slug_event_news_kategori')") or die(mysqli_error());
                if ($input == true)
                {
                    header("location: event_news_kategori_tambah.php?status_form=berhasil&jenis_form=tambah");
                }
                else
                {
                    header("location: event_news_kategori_tambah.php?status_form=gagal&jenis_form=tambah");
                }

                $input = null;
            }
            else
            {
                header("location: event_news_kategori_tambah.php?status_form=tidak_lengkap");
            }
        }
    }

    // Edit Kategori Event News

    if (isset($_POST['event_news_kategori_edit']))
    {
        if (isset($_POST['nama_event_news_kategori']) && isset($_POST['slug_event_news_kategori']) && isset($_POST['id']))
        {
            $id = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['id'])));
            $nama_event_news_kategori = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['nama_event_news_kategori'])));
            $slug_event_news_kategori = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['slug_event_news_kategori'])));

            if (!empty($nama_event_news_kategori) && !empty($slug_event_news_kategori) && !empty($id))
            {
                $update = mysqli_query($koneksi, "UPDATE event_news_kategori SET nama_event_news_kategori = '$nama_event_news_kategori', slug_event_news_kategori = '$slug_event_news_kategori' WHERE event_news_kategori.id_event_news_kategori = '$id' LIMIT 1;") or die(mysqli_error());
                if ($update == true)
                {
                    header("location: event_news_kategori.php?status_form=berhasil&jenis_form=edit");
                }
                else
                {
                    header("location: event_news_kategori.php?status_form=gagal&jenis_form=edit");
                }

                $update = null;
            }
            else
            {
                header("location: event_news_kategori.php?status_form=tidak_lengkap");
            }
        }
        else
        {
            header("location: event_news_kategori.php?status_form=tidak_lengkap");
        }
    }

}


if($_SESSION['level'] == 'superuser'){
// Tambah Profile Tambah
    if (isset($_POST['profile_tambah']))
    {
        if (isset($_POST['profile_nama']) && isset($_FILES['profile_upload']) && isset($_POST['profile_jabatan']) && isset($_POST['profile_level']) && isset($_POST['profile_username']) && isset($_POST['profile_password']) && isset($_POST['profile_konfirmasi_password']))
        {
            $profile_nama = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['profile_nama'])));
            $profile_jabatan = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['profile_jabatan'])));
            $profile_level_op = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['profile_level'])));
            $profile_username = trim(strip_tags(mysqli_real_escape_string($koneksi, $_POST['profile_username'])));
            $profile_password = md5($_POST['profile_password']);
            $profile_konfirmasi_password = md5($_POST['profile_konfirmasi_password']);
            $profile_level = "";

            if ($profile_level_op == "admin")
            {
                $profile_level = "admin";
            }
            elseif ($profile_level_op == "marketing")
            {
                $profile_level = "marketing";
            }
            elseif ($profile_level_op == "news")
            {
                $profile_level = "news";
            }

            if ($profile_password != $profile_konfirmasi_password)
            {
                header("location: profile.php?status_form=password_tidak_sama");
            }

            $valid_file = true;
            $max_size = 100000;
            $glebar = 150;
            $gtinggi = 150;
            $image_profile_file = $_FILES['profile_upload']['name'];
            $temp_profile_file = $_FILES['profile_upload']['tmp_name'];
            $ukuran_profile_file = $_FILES['profile_upload']['size'];
            $jenis_image = strtolower(pathinfo($image_profile_file, PATHINFO_EXTENSION));
            list($lebar, $tinggi) = getimagesize($temp_profile_file);
            if ($ukuran_profile_file > $max_size)
            {
                $valid_file = false;
            }

            if ($jenis_image != "jpg" && $jenis_image != "jpeg" && $jenis_image != "png" && $jenis_image != "gif")
            {
                $valid_file = false;
            }

            if ($lebar != $glebar && $tinggi != $gtinggi)
            {
                $valid_file = false;
            }

            $gambar_profile_baru = date('dmYHis') . "_" . strtolower(str_replace(' ', '_', $image_profile_file));
            $path = "../upload/image/user/" . $gambar_profile_baru;
            if (!empty($profile_nama) && !empty($profile_jabatan) && !empty($profile_level) && !empty($profile_username) && !empty($profile_password) && !empty($profile_konfirmasi_password) && !empty($image_profile_file) && !empty($temp_profile_file))
            {
                $seleksi_profile = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '" . $_SESSION['id_user'] . "' && level = '" . $_SESSION['level'] . "' LIMIT 1") or die("<script>alert('Query salah')</script>");
                $jumlah_profile = mysqli_num_rows($seleksi_profile);
                if ($valid_file == true)
                {
                    $input = mysqli_query($koneksi, "INSERT INTO user VALUES (NULL, '$profile_username', '$profile_password', '$profile_nama', '$profile_jabatan', '$gambar_profile_baru', '$profile_level')") or die(mysqli_error());
                    if ($input == true)
                    {
                        if (move_uploaded_file($temp_profile_file, $path))
                        {
                            header("location: profile.php?status_form=berhasil&jenis_form=tambah");
                        }
                        else
                        {
                            header("location: profile.php?status_form=gagal_upload");
                        }
                    }
                }
                else
                {
                    header("location: profile.php?status_form=gambar_tidak_valid");
                }

                $input = null;
            }
            else
            {
                header("location: profile.php?status_form=tidak_lengkap&b");
            }
        }
        else
        {
            header("location: profile.php?status_form=tidak_lengkap&a");
        }
    }


// hapus user

    if (isset($_GET['id_hapus_profile']))
    {
        if (!empty($_GET['id_hapus_profile']))
        {
            $id = trim(strip_tags(mysqli_real_escape_string($koneksi, $_GET['id_hapus_profile'])));
            $cek_terpilih = mysqli_query($koneksi, "SELECT id_user FROM user WHERE id_user = '$id'") or die(mysqli_error());
            if (mysqli_num_rows($cek_terpilih) == 0)
            {
                header("location: profile.php?status_form=tidak_ada_data");
            }
            elseif (mysqli_num_rows($cek_terpilih) == 1)
            {
                $cek_gambar_profile = mysqli_query($koneksi, "SELECT image_user FROM user WHERE id_user = '$id' LIMIT 1") or die(mysqli_error());
                if (mysqli_num_rows($cek_gambar_profile) == 1)
                {
                    while ($daftar_profile = mysqli_fetch_array($cek_gambar_profile))
                    {
                        $hapus_image = $daftar_cover['image_user'];
                        if (file_exists("../upload/image/user/" . $hapus_image))
                        {
                            unlink("../upload/image/user/" . $hapus_image);
                        }
                        else
                        {
                            header("location: profile.php?status_form=gagal_hapus_gambar");
                        }
                    }
                }

                $hapus = mysqli_query($koneksi, "DELETE FROM user WHERE id_user = '$id' LIMIT 1");
                if ($hapus == true)
                {
                    header("location: profile.php?status_form=berhasil&jenis_form=hapus");
                }
                else
                {
                    header("location: profile.php?status_form=gagal&jenis_form=hapus");
                }

                $hapus = null;
            }
        }
        else
        {
            header("location: profile.php?status_form=tidak_lengkap");
        }
    }

        // Hapus kategori Event news

    if (isset($_GET['id_hapus_event_news_kategori']))
    {
        if (!empty($_GET['id_hapus_event_news_kategori']))
        {
            $id = trim(strip_tags(mysqli_real_escape_string($koneksi, $_GET['id_hapus_event_news_kategori'])));
            $cek_terpilih = mysqli_query($koneksi, "SELECT id_event_news_kategori FROM event_news_kategori WHERE id_event_news_kategori = '$id' LIMIT 1") or die(mysqli_error());
            if (mysqli_num_rows($cek_terpilih) == 0)
            {
                header("location: event_news_kategori.php?status_form=tidak_ada_data");
            }
            elseif (mysqli_num_rows($cek_terpilih) == 1)
            {
                $hapus = mysqli_query($koneksi, "DELETE FROM event_news_kategori WHERE id_event_news_kategori = '$id' LIMIT 1");
                $update = mysqli_query($koneksi, "UPDATE event_news SET id_event_news_kategori = '0' WHERE id_event_news_kategori = '$id'");
                if ($hapus == true && $update == true)
                {
                    header("location: event_news_kategori.php?status_form=berhasil&jenis_form=hapus");
                }
                else
                {
                    header("location: event_news_kategori.php?status_form=gagal&jenis_form=hapus");
                }

                $hapus = null;
            }
        }
        else
        {
            header("location: event_news_kategori.php?status_form=tidak_lengkap");
        }
    }
}
?>