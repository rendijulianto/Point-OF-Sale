<?php 
  session_start();
  error_reporting(0);
  ?>
<head>
<title>Report - Point Of Sale</title>
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
  $gid =$_GET[id];
  if ($_GET['stat']=='1'){
    $status = 'Eceran';
    $sql2=mysqli_query($koneksi, "SELECT orders_detail.*, produk.harga as harga, produk.kode_produk, produk.nama_produk, produk.id_produk, produk.satuan, produk.part_number  FROM orders_detail, produk 
                          WHERE orders_detail.id_produk=produk.id_produk AND orders_detail.id_orders='$gid'");
  }else{
    $status = 'Grosir';
    $sql2=mysqli_query($koneksi, "SELECT orders_detail.*, produk.harga_grosir as harga, produk.kode_produk, produk.nama_produk, produk.id_produk, produk.satuan, produk.part_number  FROM orders_detail, produk 
                          WHERE orders_detail.id_produk=produk.id_produk AND orders_detail.id_orders='$gid'");
  }  

echo "<center>
  <h2 style='margin-bottom:3px; text-transform:uppercase'>$status - POINT OF SALE (POS)</h2>
    Jl.Angkasa Puri 4, Perundam Tunggul Hitam, Padang<br>
	No Telpon. 081267771344. Fax. 0751 461695</center><hr/>";
				
   $order = mysqli_query($koneksi, "SELECT * FROM orders a JOIN costumer b ON a.id_costumer = b.id_costumer WHERE a.id_orders='$gid'");
  
    $r    = mysqli_fetch_array($order);
  
    $tanggal=tgl_indo($r['tgl_order']);
		if($r) {
      echo "<div class='post_title'><b>Detail Informasi Order.</b></div>
            <form method=POST action=$aksi?module=order&act=update>
            <input type=hidden name=id value=$r[id_orders]>
            <table width=100%>
            <tr><td style='width:200px'>No. Faktur</td>        <td> : $r[no_orders]</td></tr>
            <tr><td style='width:200px'>Nama Costumer</td>        <td> : $r[nama_costumer]</td></tr>
            <tr><td>Tgl. & Jam Order</td> <td> : $tanggal & $r[jam_order]</td></tr>
            </table></form>";
    } else {
      $order = mysqli_query($koneksi, "SELECT * FROM orders a WHERE a.id_orders='$gid'");
  
      $r    = mysqli_fetch_array($order);
      $tanggal=tgl_indo($r['tgl_order']);
      echo "<div class='post_title'><b>Detail Informasi Order.</b></div>
            <form method=POST action=$aksi?module=order&act=update>
            <input type=hidden name=id value=$r[id_orders]>
            <table width=100%>
            <tr><td style='width:200px'>No. Faktur</td>        <td> : $r[no_orders]</td></tr>
            <tr><td>Tgl. & Jam Order</td> <td> : $tanggal & $r[jam_order]</td></tr>
            </table></form>";
    }

  // tampilkan rincian produk yang di order
  
  
  echo "<table width=100% >
        <tr>
          <th  style='height:35px;border: 2px solid;'>No</th>
          <th  style='height:35px;border: 2px solid;'>Kd Brg</th>
          <th  style='height:35px;border: 2px solid;'>Nama Barang</th>
          <th  style='height:35px;border: 2px solid;'>Part Number</th>
          <th  style='height:35px;border: 2px solid;'>Jumlah</th>
          <th  style='height:35px;border: 2px solid;'>Satuan</th>
          <th  style='height:35px;border: 2px solid;'>Harga $status</th>
          <th  style='height:35px;border: 2px solid;'>Sub Total</th>
        </tr>";
  $i=1;
  while($s=mysqli_fetch_array($sql2)){
     // rumus untuk menghitung subtotal dan total	

    $subtotal    = $s['harga'] * $s['jumlah'] ;

    $total       = $total + $subtotal;
    $subtotal_rp = format_rupiah($subtotal);    
    $total_rp    = format_rupiah($total);    
    $harga       = format_rupiah($s['harga']);
    echo "<tr align='center'>
      <td>$i</td>
      <td>$s[kode_produk]</td>
      <td>$s[nama_produk]</td>
      <td>$s[part_number]</td>
      <td>$s[jumlah]</td>
      <td>$s[satuan]</td>
      <td>Rp. $harga</td>
      <td>Rp. $subtotal_rp</td>
    </tr>";
    $i++;
  }   
		
    $by = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM orders where id_orders='$gid'")); 
    $kembali = $by['bayar'] - $total;

echo "<div class='post_title'><b>Detail Order yang harus di bayar.</b></div>
	  <table width=100%>
    <tr><td width=120px>Total</td><td> Rp. <b>$total_rp</b></td></tr>   
    <tr><td>Bayar</td><td> Rp. <b>".format_rupiah($by['bayar'])."</b></td></tr>   
    <tr><td>Kembali</td><td> Rp. <b>".format_rupiah($kembali)."</b></td></tr>   
      </table>
	  
	  <tr>
    <td col><span style='float:left; text-align:center;'>
    <br/>
    <br/>
    <br/>
    <br/>
								(.............................................)
								<br/>Tanda Terima</span></td>
    <td col><br/><span style='float:right; text-align:center;'> Point Of Sale, $tgl_sekarang <br/>
										Kasir<br/></br></br>
								(.............................................)
								<br/>$_SESSION[namalengkap]</span></td></tr>";
if ($_GET['page']=='report'){

}else{
echo "<script>window.alert('Oke !!!');
        window.location=('transaksi-belanja-$_GET[stat].html')</script>";  		
}					
?>