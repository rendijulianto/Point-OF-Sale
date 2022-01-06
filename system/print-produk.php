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
echo "  <center><h2>Semua Produk dengan No Faktur : $_GET[kode]</h2></center>
		<table width=100% cellpadding=6>
          <tr style='color:#fff; height:35px;' bgcolor=#000><th>No</th><th>Nama Produk</th><th>Kategori</th><th>Harga</th><th>Stok</th><th>Diskon</th><th>Nama Supplier</th></tr>";


    $tampil = mysqli_query($koneksi, "SELECT * FROM produk left join supplier on produk.id_supplier=supplier.id_supplier 
								left join kategori_produk on produk.id_kategori=kategori_produk.id_kategori where produk.no_faktur='$_GET[kode]' ORDER BY id_produk DESC");
  
    $no = $posisi+1;
    while($r=mysqli_fetch_array($tampil)){
      $tanggal=tgl_indo($r['tgl_masuk']);
      $harga=format_rupiah($r['harga']);
	  if(($no % 2)==0){
			$warna="#ffffff";
		  }
		  else{
			$warna="#E1E1E1";
		  }
      echo "<tr bgcolor=$warna><td>$no</td>
                <td>$r[nama_produk]</td>
				<td>$r[nama_kategori]</td>
                <td>$harga</td>
                <td align=center>$r[stok]</td>
				<td>$r[diskon] %</td>
				<td>$r[nama_supplier]</td>
		            </tr>";
      $no++;
    }
    echo "</table><br/><tr><td><br/><span style='float:right; text-align:center;'> Point of Sale, $tgl_sekarang <br/>
										Karyawan<br/></br></br>
								(.............................................)
								<br/>$_SESSION[namalengkap]</span></td></tr>";
?>