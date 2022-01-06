<?php
session_start();
if($_SESSION['namauser'] == '' ){
	echo "<script>window.alert('Untuk mengakses, Anda harus Login Sebagai Agen');
        window.location=('../login.html')</script>";
}
?>