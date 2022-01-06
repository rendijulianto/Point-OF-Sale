<?php
include "config/koneksi.php";
$term = trim(strip_tags($_GET['term']));
$qstring = "SELECT kode_produk, nama_produk FROM produk WHERE kode_produk LIKE '".$term."%'";
$result = mysqli_query($koneksi, $qstring);
while ($row = mysqli_fetch_array($result)){
		$row['value']=htmlentities(stripslashes($row['kode_produk']));
		$row_set[] = $row;
}
//data hasil query yang dikirim kembali dalam format json
echo json_encode($row_set);
?>