<?php 
  session_start();
  error_reporting(0);
  ?>
<head>
<title>Report - Point of Sale</title>
<style>
.input1 {
	height: 20px;
	font-size: 12px;
	padding-left: 5px;
	margin: 5px 0px 0px 5px;
	width: 97%;
	border: none;
	color: red;
}
table {
	border: 1px solid #cecece;
}
.td {
	border: 1px solid #cecece;
}
#kiri{
width:50%;
float:left;
}

#kanan{
width:50%;
float:right;
padding-top:20px;
margin-bottom:9px;
}
</style>
</head>

<body onload="window.print()">
<?php 
  include "../config/koneksi.php";
  include "../config/fungsi_indotgl.php";
  include "../config/library.php";
  include "../config/fungsi_rupiah.php";

echo "<center><h2 style='margin-bottom:3px;'>POINT OF SALE (POS)</h2>
			  Jl.Angkasa Puri 4, Perundam Tunggul Hitam, Padang<br>
			  No Telpon. 081267771344. Fax. 0751 461695</center><hr/>";
echo "  <center><h2>Semua Data Customer</h2></center>
		<table width=100% cellpadding=6>
          <tr style='color:#fff; height:35px;' bgcolor=#000>
				<th class='data' width='30px'>No</th>
				<th class='data'>Nama Customer</th>
				<th class='data'>No Telpon</th>
				<th class='data'>Alamat Lengkap</th>
				<th class='data'>Total Transaksi</th>
          </tr>";


    $tampil = mysqli_query($koneksi, "SELECT * FROM costumer ORDER BY id_costumer DESC");
  
    $no = $posisi+1;
    while($r=mysqli_fetch_array($tampil)){
      $tanggal=tgl_indo($r['tgl_masuk']);
      $harga=format_rupiah($r['harga']);
	  $harga_grosir=format_rupiah($r['harga_grosir']);
	  if(($no % 2)==0){ $warna="#ffffff"; }else{ $warna="#E1E1E1"; }
	  $cek = mysqli_fetch_array(mysqli_query($koneksi, "SELECT count(*) as total FROM orders where id_costumer='$r[id_costumer]'"));
      echo "<tr bgcolor=$warna class='data'>
				<td class='data' width='30px'>$no</td>
				<td class='data'>$r[nama_costumer]</td>
				<td class='data'>$r[no_telpon]</td>
				<td class='data'>$r[alamat_lengkap]</td>
				<td class='data'>$cek[total] Kali</td>
			</tr>";
      $no++;
    }
    echo "</table><br/><tr><td><br/><span style='float:right; text-align:center;'> Point of Sale, $tgl_sekarang <br/>
										Karyawan<br/></br></br>
								(.............................................)
								<br/>$_SESSION[namalengkap]</span></td></tr>";
?>