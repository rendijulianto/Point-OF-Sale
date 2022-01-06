<?php
if ($_GET['module']=='return'){
	    echo "<h3>Semua Data Return Produk <span style='float:right'><a style='float:right;' target='_BALNK' href='print-return.php'>Cetak Laporan Return</a></span></h3><br/>
          <span style='float:right;'>
			<form action='media.php' method='GET' style='margin-right:22px'>
							  <input type='hidden' name='module' value='returnproduk' style='width:200px; margin-bottom:3px;'/>
				Kode Produk : <input type='text' name='kdp' autofocus style='width:200px; margin-bottom:3px;' placeholder='Input Kode Produk...'/>
				<input type='submit' name='cari' value='cari'>
			</form>
		  </span><br/>
		  
			 <div class='h_line'></div>
		<table id='twitter-table' class='data'>
			<tr class='data'>
				<th class='data'>No</th>
				<th class='data'>Kode Produk</th>
				<th class='data'>Nama Produk</th>
				<th class='data'>Nama Supplier</th>
				<th class='data'>Harga Pokok</th>
				<th class='data'>Jumlah</th>
				<th  class='data' align='center' width='70px;'>Action</th>
			</tr>";

		$per_page = 10;
		$page_query = mysqli_query($koneksi, "SELECT COUNT(*) FROM produk_pembelian where id_faktur='$ifa[id_faktur]'");
		$pages = ceil($page_query / $per_page);
		$page = (isset($_GET['p'])) ? (int)$_GET['p'] : 1;
		$start = ($page - 1) * $per_page;
		
		$tampil = mysqli_query($koneksi, "SELECT c.nama_supplier, a.id_return, a.id_produk, a.id_supplier, a.jumlah, b.kode_produk, b.nama_produk, b.harga, b.harga_grosir, b.harga_pokok, b.satuan  
					FROM `return_produk`a JOIN produk b ON a.id_produk=b.id_produk JOIN supplier c JOIN rak ON a.id_supplier=c.id_supplier ORDER BY a.id_return DESC LIMIT $start, $per_page");

	$no = $start+1;
    while($r=mysqli_fetch_array($tampil)){
      $tanggal=tgl_indo($r['tgl_masuk']);
      $harga=format_rupiah($r['harga']);
	  $harga_pokok=format_rupiah($r['harga_pokok']);
	  $harga_grosir=format_rupiah($r['harga_grosir']);

	  $in = mysqli_fetch_array(mysqli_query($koneksi, "SELECT a.id_produk, sum(a.jumlah) as masuk FROM `produk_pembelian` a where a.id_produk='$r[id_produk]'"));
      $out = mysqli_fetch_array(mysqli_query($koneksi, "SELECT a.id_produk, sum(a.jumlah) as keluar FROM `orders_detail` a where a.id_produk='$r[id_produk]'"));
      $stok = $in['masuk']-$out['keluar'];

	  if(($no % 2)==0){
			$warna="#ffffff";
		  }
		  else{
			$warna="#E1E1E1";
		  }
      echo "<tr class='data'><td class='data'>$no</td>
				<td class='data'>$r[kode_produk]</td>
                <td class='data'>$r[nama_produk]</td>
                <td class='data'>$r[nama_supplier]</td>
				<td class='data'>Rp $harga_pokok</td>
				<td class='data' align=center>$r[jumlah] $r[satuan]</td>
				<td class='data' align='center'>
				<a href=media.php?module=hapusreturn&id=$r[id_return]>Batalkan</a><br>
				<a href='#' onclick='alert(`Rak : ".$r[nama_rak]." | Baris : ".$r['baris_rak']."`)'>Detail</a>
				</td>
				
		        </tr>";
      $no++;
    }
    echo "</table>";
			echo "<div style='clear:both'></div>Halaman : ";
			if($pages >= 1 && $page <= $pages){
				for($x=1; $x<=$pages; $x++){
					echo ($x == $page) ? '
						<a href="halaman-detail-produk-'.$_GET['kode'].'-'.$x.'.html">'.$x.'</a> | ' : '
						<a href="halaman-detail-produk-'.$_GET['kode'].'-'.$x.'.html">'.$x.'</a>';
				}
			}
	
}elseif ($_GET['module']=='returnproduk'){
    $edit = mysqli_query($koneksi, "SELECT * FROM produk WHERE kode_produk='$_GET[kdp]'");
    $r    = mysqli_fetch_array($edit);
    $temukan    = mysqli_num_rows($edit);

	    echo "<h3>Tambah Data Return Produk</h3><br/>";

    if ($temukan <= 0){
    	echo "<center style='margin-top:10%'>Maaf, Produk Dengan Kode <b>$_GET[kdp]</b> Tidak Ditemukan !!!<br></center>";
    }else{

	    echo "<form method=POST enctype='multipart/form-data' action=media.php?module=aksireturnproduk>
	          <input type=hidden name=id value=$r[id_produk]>
	          <table>
			  <tr><td width=100>Kode Produk</td>     <td> : <input type=text name='kode_produk' value='$r[kode_produk]' size=10 readonly='on' style='background:#e3e3e3'></td></tr>
	          <tr><td width=100>Nama Produk</td>     <td> : <input type=text name='judul' size=60 value='$r[nama_produk]' readonly='on' style='background:#e3e3e3'></td></tr>
	          <tr><td>Satuan</td>     <td> : <input type=text name='satuan' value='$r[satuan]' size=20 readonly='on' style='background:#e3e3e3'></td></tr>
			  <tr><td>Supplier</td>  <td> : <select style='background:#fff' name='id_supplier'>";
	 
	          $tampil=mysqli_query($koneksi, "SELECT * FROM supplier ORDER BY nama_supplier");
	          if ($r['id_supplier']==0){
	            echo "<option value=0 selected>- Pilih Supplier -</option>";
	          }   

	          while($w=mysqli_fetch_array($tampil)){
	            if ($r['id_supplier']==$w['id_supplier']){
	              echo "<option value=$w[id_supplier] selected>$w[nama_supplier]</option>";
	            }
	            else{
	              echo "<option value=$w[id_supplier]>$w[nama_supplier]</option>";
	            }
	          }
	    $in = mysqli_fetch_array(mysqli_query($koneksi, "SELECT a.id_produk, sum(a.jumlah) as masuk FROM `produk_pembelian` a where a.id_produk='$r[id_produk]'"));
	    $out = mysqli_fetch_array(mysqli_query($koneksi, "SELECT a.id_produk, sum(a.jumlah) as keluar FROM `orders_detail` a where a.id_produk='$r[id_produk]'"));
	    $stok = $in['masuk']-$out['keluar'];

	    echo "</select></td></tr>
			  <tr><td>Stok dan Jumlah</td>     <td> : <input type=text value='$stok' size=10 disabled  style='background:#e3e3e3'> + <input type=text name='stokmasuk' size=15 placeholder='Jumlah Return'></td></tr>
			  <input type=hidden name='berat' size=20 value='0'>
	          <tr><td colspan=2><br/><input style='float:right;' type=button value=Batal onclick=self.history.back()>
								<input style='float:right;margin-right:5px' type=submit value=Simpan></td></tr>
	         </table></form>";
    }
		 
}elseif ($_GET['module']=='aksireturnproduk'){
	$tglreturn = date("Y-m-d H:i:s");
	mysqli_query($koneksi, "INSERT INTO return_produk(id_produk,
										id_supplier,
										jumlah,
										waktu_return) 
								VALUES('$_POST[id]',
									   '$_POST[id_supplier]',
									   '$_POST[stokmasuk]',
									   '$tglreturn')");
  header('location:return.html');
  
}elseif ($_GET['module']=='hapusreturn'){
  mysqli_query($koneksi, "DELETE FROM return_produk WHERE id_return='$_GET[id]'");
  header('location:return.html');
}
?>