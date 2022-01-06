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

  $filter = $_POST['tahun'].'-'.$_POST['bulan'];
  $bulan = Bulan($_POST['bulan']);
  
if (isset($_POST['submit'])){
	if (strlen($_POST['bulan']) == 1 ){
		$bulann = '0'.$_POST['bulan'];
	}else{
		$bulann = $_POST['bulan'];
	}
	
	if (strlen($_POST['bulanx']) == 1 ){
		$bulannx = '0'.$_POST['bulanx'];
	}else{
		$bulannx = $_POST['bulanx'];
	}
	
	if (strlen($_POST['tanggal']) == 1 ){
		$tanggall = '0'.$_POST['tanggal'];
	}else{
		$tanggall = $_POST['tanggal'];
	}
	if (strlen($_POST['tanggalx']) == 1 ){
		$tanggallx = '0'.$_POST['tanggalx'];
	}else{
		$tanggallx = $_POST['tanggalx'];
	}
	
	$mulai = $_POST['tahun'].'-'.$bulann.'-'.$tanggall;
	$selesai = $_POST['tahunx'].'-'.$bulannx.'-'.$tanggallx;

echo "<center><h2 style='margin-bottom:3px;'>POINT OF SALE (POS)</h2>
    Laporan Daftar belanja pada : ".tgl_indo($mulai)." s/d ".tgl_indo($selesai)."<br>
	Jl.Angkasa Puri 4, Perundam Tunggul Hitam, Padang<br>
	No Telpon. 081267771344. Fax. 0751 461695</center><hr/>
				
		  <table width=100% cellpadding=6>
          <tr style='color:#fff; height:35px;' bgcolor=#000><th>No</th><th>No.order</th><th>Nama Konsumen</th><th>Berat</th><th>Jumlah</th><th>Harga</th><th>Tanggal Order</th><th>Status</th></tr>";
		  
		  if ($_POST['status']=='0'){
			  $tampil=mysqli_query($koneksi, "SELECT a.*, b.nama_costumer FROM orders a LEFT JOIN costumer b ON a.id_costumer=b.id_costumer where a.tgl_order BETWEEN '$mulai' AND '$selesai'");
		  }else{
		  	  $tampil=mysqli_query($koneksi, "SELECT a.*, b.nama_costumer FROM orders a LEFT JOIN costumer b ON a.id_costumer=b.id_costumer where a.tgl_order BETWEEN '$mulai' AND '$selesai' AND a.status='$_POST[status]'");
		  }

		  $no = $no+1;
		  while ($r=mysqli_fetch_array($tampil)){
		  $tanggal=tgl_indo($r['tgl_order']);
		  if ($r['id_costumer']=='0'){ $nama_costumer = "<i style='color:red'>Tidak ada,..</i>"; }else{ $nama_costumer = $r['nama_costumer']; }
	  if ($r['status']=='1'){ $status = "<i style='color:orange'>Eceran</i>"; }else{ $status = "<i style='color:purple'>Grosir</i>"; }
	  $tot = mysqli_fetch_array(mysqli_query($koneksi, "SELECT sum(z.harga_belanja) as total_belanja, sum(z.harga_modal) as total_pokok, (sum(z.harga_belanja)-sum(z.harga_modal)) as untung FROM (SELECT a.*, b.harga, b.harga_grosir, b.harga_pokok, c.status, IF(c.status=1, a.jumlah*b.harga, a.jumlah*b.harga_grosir) as harga_belanja, (a.jumlah*b.harga_pokok) as harga_modal FROM `orders_detail` a JOIN produk b ON a.id_produk=b.id_produk JOIN orders c On a.id_orders=c.id_orders) as z where z.id_orders='$r[id_orders]'"));
		  echo "<tr bgcolor=$warna>
				<td align=center>$no</td>
				<td class='data'><a href='#' title='$r[nama_kasir]'>$r[no_orders]</a></td>
      			<td class='data'>$nama_costumer</td>
				<td class='data'>".format_rupiah($tot['total_belanja'])."</td>
				<td class='data'>".format_rupiah($tot['total_pokok'])."</td>
				<td class='data'>".format_rupiah($tot['untung'])."</td>
				<td class='data'>$tanggal, $r[jam_order]</td>
                <td class='data'>$status</td></tr>";
				$no++;
}
if ($_POST['status']=='0'){
$tot_all = mysqli_fetch_array(mysqli_query($koneksi, "SELECT sum(z.harga_belanja) as total_belanja, sum(z.harga_modal) as total_pokok, (sum(z.harga_belanja)-sum(z.harga_modal)) as untung FROM (SELECT a.*, b.harga, b.harga_grosir, b.harga_pokok, c.status, IF(c.status=1, a.jumlah*b.harga, a.jumlah*b.harga_grosir) as harga_belanja, (a.jumlah*b.harga_pokok) as harga_modal FROM `orders_detail` a JOIN produk b ON a.id_produk=b.id_produk JOIN orders c On a.id_orders=c.id_orders where c.tgl_order BETWEEN '$mulai' AND '$selesai') as z"));
}else{
$tot_all = mysqli_fetch_array(mysqli_query($koneksi, "SELECT sum(z.harga_belanja) as total_belanja, sum(z.harga_modal) as total_pokok, (sum(z.harga_belanja)-sum(z.harga_modal)) as untung FROM (SELECT a.*, b.harga, b.harga_grosir, b.harga_pokok, c.status, IF(c.status=1, a.jumlah*b.harga, a.jumlah*b.harga_grosir) as harga_belanja, (a.jumlah*b.harga_pokok) as harga_modal FROM `orders_detail` a JOIN produk b ON a.id_produk=b.id_produk JOIN orders c On a.id_orders=c.id_orders where c.tgl_order BETWEEN '$mulai' AND '$selesai' AND c.status='$_POST[status]') as z"));
}
    echo "<tr bgcolor='#e3e3e3'>
    		<td colspan='3'><b>Total</b></td>
    		<td>".format_rupiah($tot_all['total_belanja'])."</td>
    		<td>".format_rupiah($tot_all['total_pokok'])."</td>
    		<td>".format_rupiah($tot_all['untung'])."</td>
    		<td colspan='3'></td>
    	  </tr>";

echo "</table><tr><td><br/><span style='float:right; text-align:center;'> Point of Sale, $tgl_sekarang <br/>
										Karyawan<br/></br></br>
								(.............................................)
								<br/>$_SESSION[namalengkap]</span></td></tr>";
}else{
echo "<center><h2 style='margin-bottom:3px;'>POINT OF SALE (POS)</h2>
	Jl.Angkasa Puri 4, Perundam Tunggul Hitam, Padang<br>
	No Telpon. 081267771344. Fax. 0751 461695</center><hr/>
				
		  <table width=100% cellpadding=6>
          <tr style='color:#fff; height:35px;' bgcolor=#000>
          	<th>No</th>
          	<th class='data' width=80px>No Faktur</th>
			<th class='data'>Nama Konsumen</th>
			<th class='data'>Total Belanja</th>
			<th class='data'>Total Modal</th>
			<th class='data'>Keuntungan</th>
			<th class='data' width='110px'>Waktu Penjualan</th>
			<th class='data'>Status</th>
          </tr>";
		  
		  $tampil=mysqli_query($koneksi, "SELECT a.*, b.nama_costumer FROM orders a LEFT JOIN costumer b ON a.id_costumer=b.id_costumer ORDER BY a.id_orders DESC");
		  $no = $no+1;
		  while ($r=mysqli_fetch_array($tampil)){
		  $tanggal=tgl_indoo($r['tgl_order']);
		  if ($r['id_costumer']=='0'){ $nama_costumer = "<i style='color:red'>Tidak ada,..</i>"; }else{ $nama_costumer = $r['nama_costumer']; }
	  if ($r['status']=='1'){ $status = "<i style='color:orange'>Eceran</i>"; }else{ $status = "<i style='color:purple'>Grosir</i>"; }
	  $tot = mysqli_fetch_array(mysqli_query($koneksi, "SELECT sum(z.harga_belanja) as total_belanja, sum(z.harga_modal) as total_pokok, (sum(z.harga_belanja)-sum(z.harga_modal)) as untung FROM (SELECT a.*, b.harga, b.harga_grosir, b.harga_pokok, c.status, IF(c.status=1, a.jumlah*b.harga, a.jumlah*b.harga_grosir) as harga_belanja, (a.jumlah*b.harga_pokok) as harga_modal FROM `orders_detail` a JOIN produk b ON a.id_produk=b.id_produk JOIN orders c On a.id_orders=c.id_orders) as z where z.id_orders='$r[id_orders]'"));
		  echo "<tr bgcolor=$warna>
				<td align=center>$no</td>
				<td class='data'><a href='#' title='$r[nama_kasir]'>$r[no_orders]</a></td>
      			<td class='data'>$nama_costumer</td>
				<td class='data'>".format_rupiah($tot['total_belanja'])."</td>
				<td class='data'>".format_rupiah($tot['total_pokok'])."</td>
				<td class='data'>".format_rupiah($tot['untung'])."</td>
				<td class='data'>$tanggal, $r[jam_order]</td>
                <td class='data'>$status</td></tr>";
				$no++;
}
$tot_all = mysqli_fetch_array(mysqli_query($koneksi, "SELECT sum(z.harga_belanja) as total_belanja, sum(z.harga_modal) as total_pokok, (sum(z.harga_belanja)-sum(z.harga_modal)) as untung FROM (SELECT a.*, b.harga, b.harga_grosir, b.harga_pokok, c.status, IF(c.status=1, a.jumlah*b.harga, a.jumlah*b.harga_grosir) as harga_belanja, (a.jumlah*b.harga_pokok) as harga_modal FROM `orders_detail` a JOIN produk b ON a.id_produk=b.id_produk JOIN orders c On a.id_orders=c.id_orders) as z"));

    echo "<tr bgcolor='#e3e3e3'>
    		<td colspan='3'><b>Total</b></td>
    		<td>".format_rupiah($tot_all['total_belanja'])."</td>
    		<td>".format_rupiah($tot_all['total_pokok'])."</td>
    		<td>".format_rupiah($tot_all['untung'])."</td>
    		<td colspan='3'></td>
    	  </tr>";
echo "</table><tr><td><br/><span style='float:right; text-align:center;'> Point of Sale, $tgl_sekarang <br/>
										Karyawan<br/></br></br>
								(.............................................)
								<br/>$_SESSION[namalengkap]</span></td></tr>";
}
?>