<?php
// error_reporting(0);
include "config/koneksi.php";
$pass=md5($_POST['password']);
$level=$_POST['level'];
if ($level=='Admin')
{
$login=mysqli_query($koneksi, "SELECT * FROM admin
			WHERE username='$_POST[id_user]' AND password='$pass' AND level='$level'");
$cocok=mysqli_num_rows($login);
$r=mysqli_fetch_array($login);

if ($cocok > 0){
	session_start();
	$_SESSION['namauser']     = $r['username'];
  	$_SESSION['namalengkap']  = $r['nama_lengkap'];
  	$_SESSION['passuser']     = $r['password'];
  	$_SESSION['leveluser']    = $r['level'];

	header('location:system/home');
	}
else {
echo "<script>window.alert('Username atau Password anda salah.');
        window.location=('home')</script>";
}
}

elseif ($level=='kasir')
{
$login=mysqli_query($koneksi, "SELECT * FROM users WHERE username='$_POST[id_user]' AND password='$pass' AND level='$level' AND aktif='Y'");
$cocok=mysqli_num_rows($login);
$r=mysqli_fetch_array($login);

if ($cocok > 0){
	session_start();
	$_SESSION['namauser']     = $r['username'];
	$_SESSION['passuser']     = $r['password'];
  	$_SESSION['namalengkap']  = $r['nama_lengkap'];
	$_SESSION['email']    	= $r['email'];
	$_SESSION['telp']    		= $r['no_telp'];
	$_SESSION['alamat']    	= $r['alamat_lengkap'];
	$_SESSION['kota']   	 	= $r['kota'];
  	$_SESSION['leveluser']    = $r['level'];

	header('location:system/semua-produk.html');
	}
else {
echo "<script>window.alert('Username dan Password anda salah atau account anda belum di aktifkan.');
        window.location=('home')</script>";
}
}

?>
<link href="templates/style.css" rel="stylesheet" type="text/css" /> 