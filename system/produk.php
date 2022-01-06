<?php
//Detail-produk.html
if ($_GET['module'] == 'produk')
{
    echo "<h3>Semua Produk no Faktur : $_GET[kode]<span style='float:right'><a style='float:right;' target='_BALNK' href='print-produk.php?kode=$_GET[kode]'>Cetak Laporan Produk</a></span></h3><br/>
          <input type=button value='Tambah Master dan Pembelian Produk' onclick=\"window.location.href='media.php?module=tambahproduk&no=$_GET[kode]';\">
          <span style='float:right;'>
			<form action='media.php' method='GET' style='margin-right:22px'>
							  <input type='hidden' name='module' value='editproduk' style='width:200px; margin-bottom:3px;'/>
				<input type='text' name='kdp' autofocus style='width:200px; margin-bottom:3px;' placeholder='Input Kode Produk...'/>
							  <input type='hidden' name='no' value='$_GET[kode]' style='width:200px; margin-bottom:3px;'/>
				<input type='submit' name='cari' value='Tambahkan'>
				<a href='all-produk-faktur-$_GET[kode].html'>All Produk</a>
			</form>
		  </span><br/>
		  
			 <div class='h_line'></div>
		<table id='twitter-table' class='data'>
			<tr class='data'>
				<th class='data'>No </th>
				<th class='data'>Kode Produk</th>
				<th class='data'>Nama Produk</th>
				<th class='data'>Part Number</th>
				<th class='data'>Harga Ecer</th>
				<th class='data'>Harga Grosir</th>
				<th class='data'>Harga Pokok</th>
				<th class='data'>Jumlah</th>
				<th  class='data' align='center' width='70px;'>Action</th>
			</tr>";
    $ifa = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM faktur where no_faktur='$_GET[kode]'"));

    if (isset($_POST['cari']) or isset($_REQUEST['kata']))
    {
        $tampil = mysqli_query($koneksi, "SELECT c.nama_supplier, a.id_produk_pembelian, a.id_faktur, a.id_produk, a.id_supplier, a.jumlah, a.tanggal_masuk, a.username, b.kode_produk, b.nama_produk, b.harga, b.harga_grosir, b.harga_pokok, b.satuan, b.part_number 
					FROM `produk_pembelian`a JOIN produk b ON a.id_produk=b.id_produk JOIN supplier c ON a.id_supplier=c.id_supplier where a.id_faktur='$ifa[id_faktur]' AND b.kode_produk='$_POST[kata]' ORDER BY a.id_produk_pembelian");
    }
    else
    {
		$ifaktur = $ifa['id_faktur'];
        $per_page = 10;
        $page_query = mysqli_query($koneksi, "SELECT COUNT(*) FROM produk_pembelian WHERE id_faktur = '6'");
        $pages = ceil($page_query / $per_page);
	
	
        $page = (isset($_GET['p'])) ? (int)$_GET['p'] : 1;
        $start = ($page - 1) * $per_page;

        $tampil = mysqli_query($koneksi, "SELECT c.nama_supplier, a.id_produk_pembelian, a.id_faktur, a.id_produk, a.id_supplier, a.jumlah, a.tanggal_masuk, a.username, b.kode_produk, b.nama_produk, b.harga, b.harga_grosir, b.harga_pokok, b.satuan, rak.nama_rak, b.baris_rak, b.part_number
					FROM `produk_pembelian` a JOIN produk b ON a.id_produk=b.id_produk JOIN supplier c JOIN rak ON a.id_supplier=c.id_supplier where a.id_faktur = '$ifaktur' ORDER BY a.id_produk_pembelian ASC LIMIT $start, $per_page");

	
	}
	

    $no = $start + 1;
    while ($r = mysqli_fetch_array($tampil))
    {
        $tanggal = tgl_indo($r['tgl_masuk']);
        $harga = format_rupiah($r['harga']);
        $harga_pokok = format_rupiah($r['harga_pokok']);
        $harga_grosir = format_rupiah($r['harga_grosir']);

        $in = mysqli_fetch_array(mysqli_query($koneksi, "SELECT a.id_produk, sum(a.jumlah) as masuk FROM `produk_pembelian` a where a.id_produk='$r[id_produk]'"));
        $out = mysqli_fetch_array(mysqli_query($koneksi, "SELECT a.id_produk, sum(a.jumlah) as keluar FROM `orders_detail` a where a.id_produk='$r[id_produk]'"));
        $stok = $in['masuk'] - $out['keluar'];

        if (($no % 2) == 0)
        {
            $warna = "#ffffff";
        }
        else
        {
            $warna = "#E1E1E1";
        }
        echo "<tr class='data'><td class='data'>$no</td>
				<td class='data'>$r[kode_produk]</td>
                <td class='data'><a href='#' title='Pemasok : $r[nama_supplier]'>$r[nama_produk]</td>
				<td class='data'>$r[part_number]</td>
                <td class='data'>Rp $harga</td>
				<td class='data'>Rp $harga_grosir</td>
				<td class='data'>Rp $harga_pokok</td>
				<td class='data' align=center>$r[jumlah] $r[satuan]</td>
				<td class='data' align='center'>
                    <a href=media.php?module=hapusproduk&id=$r[id_produk]&no=$_GET[kode]&idf=$r[id_faktur]>Hapus</a> <br>
                     <a href='#' onclick='alert(`Rak : ".$r[nama_rak]." | Baris : ".$r['baris_rak']."`)'>Detail</a>
                    </td>
                 
                  
                </tr>";
        $no++;
    }
    echo "</table>";
    echo "<div style='clear:both'></div>Halaman : ";
    if ($pages >= 1 && $page <= $pages)
    {
        for ($x = 1;$x <= $pages;$x++)
        {
            echo ($x == $page) ? '
						<a href="halaman-detail-produk-' . $_GET['kode'] . '-' . $x . '.html">' . $x . '</a> | ' : '
						<a href="halaman-detail-produk-' . $_GET['kode'] . '-' . $x . '.html">' . $x . '</a>';
        }
    }

}
elseif ($_GET['module'] == 'tambahproduk')
{
    echo "<h3>Tambah Master dan Pembelian Produk Baru di Faktur : $_GET[no]</h3><br/>
          <form method=POST action='media.php?module=aksitambahproduk' enctype='multipart/form-data'>
          <table>
		  <tr><td width=100>No Faktur</td>     <td> : <input type=text name='no' value='$_GET[no]' size=10 readonly='on'></td></tr>
		  <tr><td width=100>Kode Produk</td>     <td> : <input type=text name='kode_produk'required size=10></td></tr>
          <tr><td>Nama Produk</td>     <td> : <input type=text name='nama_produk' required size=60></td></tr>
		  <tr><td width=100>Part Number</td>     <td> : <input type=text name='part_number'required size=10></td></tr>
          <tr><td>Rak</td>  <td> : 
          <select name='rak'>
            <option value=0 selected>- Pilih Rak -</option>";
    $tampil = mysqli_query($koneksi, "SELECT * FROM rak ORDER BY nama_rak");
    while ($r = mysqli_fetch_array($tampil))
    {
        echo "<option value=$r[id_rak]>$r[nama_rak]</option>";
    }
    echo "</select></td></tr>
    <tr><td>Baris Rak</td>  <td> : 
    <select name='baris'>
      <option value=0 selected>- Pilih Baris Rak -</option>
      <option value=1>1</option>
      <option value=2>2</option>
      <option value=3>3</option>
      <option value=4>4</option>
      <option value=5>5</option>
      <option value=6>6</option>
      <option value=7>7</option>
      <option value=8>8</option>
      <option value=9>9</option>
      <option value=10>10</option>
    </select>
    </td>
    </tr>
    
          <tr><td>Kategori</td>  <td> : 
          <select name='kategori'>
            <option value=0 selected>- Pilih Kategori -</option>";
    $tampil = mysqli_query($koneksi, "SELECT * FROM kategori_produk ORDER BY nama_kategori");
    while ($r = mysqli_fetch_array($tampil))
    {
        echo "<option value=$r[id_kategori]>$r[nama_kategori]</option>";
    }
    echo "</select></td></tr>
    
		  <tr><td>Supplier </td>  <td> : 
          <select name='id_supplier'>
            <option value=0 selected>- Pilih Supplier -</option>";
    $tampil = mysqli_query($koneksi, "SELECT * FROM supplier ORDER BY nama_supplier");
    while ($r = mysqli_fetch_array($tampil))
    {
        echo "<option value=$r[id_supplier]>$r[nama_supplier]</option>";
    }
    echo "</select></td></tr>
          <tr><td>Harga</td>     <td> : <input type=text name='harga' size=20></td></tr>
		  <tr><td>Harga grosir</td>     <td> : <input type=text name='harga_grosir' size=20></td></tr>
		  <tr><td>Harga Pokok</td>     <td> : <input type=text name='harga_pokok' size=20></td></tr>
		  <tr><td>Satuan</td>     <td> : <input type=text name='satuan' size=20></td></tr>
          <tr><td>Stok</td>     <td> : <input type=text name='stok' size=20></td></tr>
		  <input type=hidden name='berat' size=20 value='0'>
          <tr><td>Deskripsi</td>  <td> : <textarea name='deskripsi' style='width: 470px; height: 60px;'></textarea>
          <tr><td colspan=2><br/><input style='float:right;' type=button value=Batal onclick=self.history.back()>
							<input style='float:right; margin-right:5px;' type=submit value='Simpan dan Tambahkan'></td></tr>
          </table></form>";

}
elseif ($_GET['module'] == 'aksitambahproduk')
{
    $ifa = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM faktur where no_faktur='$_POST[no]'"));
    $hitung = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM produk where kode_produk='$_POST[kode_produk]'"));
    if ($hitung >= 1)
    {
        echo "<script>window.alert('Maaf, Kode Produk Sudah ada di system.');
				window.location=('produk-$_POST[kode_produk].html')</script>";
    }
    else
    {
      
       $produk = mysqli_query($koneksi, "INSERT INTO `produk` (
			`kode_produk`,
			`id_kategori`,
			`nama_produk`,
			`deskripsi`,
			`harga`,
			`harga_grosir`,
			`harga_pokok`,
			`satuan`,
			`berat`,
            `diskon`,
			`tgl_masuk`,
            `id_rak`,
            `baris_rak`,
            `id_supplier`,
            `part_number`
		  )
		  VALUES
			(
				'$_POST[kode_produk]',
 				'$_POST[kategori]',
 				'$_POST[nama_produk]',
 				'$_POST[deskripsi]', 
 				'$_POST[harga]',
 				'$_POST[harga_grosir]',
 				'$_POST[harga_pokok]',
 				'$_POST[satuan]',
 				'$_POST[berat]',
                '0',
 				'$tgl_sekarang',
                '$_POST[rak]',
                '$_POST[baris]',
                '$_POST[id_supplier]',
                '$_POST[part_number]'
			);
		  
		  ");

    
        $idp = mysqli_insert_id($koneksi);
      
        $tglbeli = date("Y-m-d H:i:s");
       $tambah =  mysqli_query($koneksi, "INSERT INTO produk_pembelian(
                                        `id_faktur`,
										`id_produk`,
										`id_supplier`,
										`jumlah`,
										`tanggal_masuk`,
										`username`) 
								VALUES(
                                       '$ifa[id_faktur]',
									   '$idp',
									   '$_POST[id_supplier]',
									   '$_POST[stok]',
									   '$tglbeli',
									   '$_SESSION[namauser]')");
        
        header('location:detail-produk-' . $_POST['no'] . '.html');
    }
}
elseif ($_GET['module'] == 'editproduk')
{

    $edit = mysqli_query($koneksi, "SELECT * FROM produk WHERE kode_produk='$_GET[kdp]'");
    $r = mysqli_fetch_array($edit);
    $temukan = mysqli_num_rows($edit);

    echo "<h3>Edit Data Produk</h3><br/>";

    if ($temukan <= 0)
    {
        echo "<center style='margin-top:10%'>Maaf, Produk Dengan Kode <b>$_GET[kdp]</b> Tidak Ditemukan !!!<br>
    				   Tambahkan Master Produk dan Pembelian untuk Faktur <b>$_GET[no]</b>
    				   <br> <button><a href='media.php?module=tambahproduk&no=$_GET[no]'>Tambah Master dan Pembelian</a></button></center>";
    }
    else
    {

        echo "<form method=POST enctype='multipart/form-data' action=media.php?module=aksieditproduk>
	          <input type=hidden name=id value=$r[id_produk]>
	          <table>
              <tr><td width=100>No Faktur</td>     <td> : <input type=text name='no' value='$_GET[no]' size=10 readonly='on'></td></tr>
			  <tr><td width=100>Kode Produk</td>     <td> : <input type=text name='kode_produk' value='$r[kode_produk]' size=10 readonly='on' style='background:#e3e3e3'></td></tr>
	          <tr><td width=100>Nama Produk</td>     <td> : <input type=text name='judul' size=60 value='$r[nama_produk]' readonly='on' style='background:#e3e3e3'></td></tr>
              <tr><td width=100>Part Number</td>     <td> : <input type=text name='part_number' required value='$r[part_number]' size=10></td></tr>
              <tr><td>Rak</td>  <td> : 
          <select name='rak'>
            <option value=0 selected>- Pilih Rak -</option>";
    $tampilRak = mysqli_query($koneksi, "SELECT * FROM rak ORDER BY nama_rak");
    while ($rak = mysqli_fetch_array($tampilRak))
    {
        $selected = '';
       if($rak['id_rak'] == $r['id_rak']) {
           $selected = "selected";
       }
        echo "<option ".$selected." value=$rak[id_rak]>$rak[nama_rak]</option>";
    }
    echo "</select></td></tr>
    <tr><td>Baris Rak</td>  <td> : 
    <select name='baris'>
      <option value=0>- Pilih Baris Rak -</option>";
     
      for ($i=1; $i <= 10 ; $i++) { 
            $selected = '';
            if($i == $r['baris_rak']) {
                $selected = "selected";
            }
            echo "<option ".$selected." value=".$i." >".$i."</option>";
        }
    echo "</select> </td></tr>
    
          <tr><td>Kategori</td>  <td> : 
          <select name='kategori'>
            <option value=0 selected>- Pilih Kategori -</option>";
    $tampilKat = mysqli_query($koneksi, "SELECT * FROM kategori_produk ORDER BY nama_kategori");
    while ($kat = mysqli_fetch_array($tampilKat))
    {
        $selected = '';
        if($kat['id_kategori'] == $r['id_kategori']) {
            $selected = "selected";
        }
         echo "<option ".$selected." value=$kat[id_kategori]>$kat[nama_kategori]</option>";
       
    }
    echo "</select></td></tr>
    
		  <tr><td>Supplier </td>  <td> : 
          <select name='id_supplier'>
            <option value=0 selected>- Pilih Supplier -</option>";
    $tampilSup = mysqli_query($koneksi, "SELECT * FROM supplier ORDER BY nama_supplier");
    while ($sup = mysqli_fetch_array($tampilSup))
    {
        $selected = '';
        if($sup['id_supplier'] == $r['id_supplier']) {
            $selected = "selected";
        }
        echo "<option ".$selected." value=$sup[id_supplier]>$sup[nama_supplier]</option>";
    }
    echo "</select></td></tr>
          <tr><td>Harga</td>     <td> : <input type=text name='harga' value='$r[harga]' size=20></td></tr>
		  <tr><td>Harga grosir</td>     <td> : <input type=text name='harga_grosir' value='$r[harga_grosir]' size=20></td></tr>
		  <tr><td>Harga Pokok</td>     <td> : <input type=text name='harga_pokok' value='$r[harga_pokok]' size=20></td></tr>
		  <input type=hidden name='berat' size=20 value='0'>
          <tr><td>Deskripsi</td>  <td> : <textarea name='deskripsi'  style='width: 470px; height: 60px;'>$r[deskripsi]</textarea>
       
          <tr><td>Satuan</td>     <td> : <input type=text name='satuan' value='$r[satuan]' size=20 readonly='on' style='background:#e3e3e3'></td></tr>";
		

        
        $in = mysqli_fetch_array(mysqli_query($koneksi, "SELECT a.id_produk, sum(a.jumlah) as masuk FROM `produk_pembelian` a where a.id_produk='$r[id_produk]'"));
        $out = mysqli_fetch_array(mysqli_query($koneksi, "SELECT a.id_produk, sum(a.jumlah) as keluar FROM `orders_detail` a where a.id_produk='$r[id_produk]'"));
        $stok = $in['masuk'] - $out['keluar'];

        echo "</select></td></tr>
			  <tr><td>Stok dan Jumlah</td>     <td> : <input type=text value='$stok' name='stok' size=10 readonly  style='background:#e3e3e3'> + <input type=text name='stokmasuk' size=15 placeholder='Jumlah Masuk'></td></tr>
			  <input type=hidden name='berat' size=20 value='0'>
	          <tr><td colspan=2><br/><input style='float:right;' type=button value=Batal onclick=self.history.back()>
								<input style='float:right;margin-right:5px' type=submit value=Edit></td></tr>
	         </table></form>";
    }

}
elseif ($_GET['module'] == 'aksieditproduk')
{
    $tglbeli = date("Y-m-d H:i:s");
    $ifa = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM faktur where no_faktur='$_POST[no]'"));

    mysqli_query($koneksi, "INSERT INTO produk_pembelian(id_faktur,
										id_produk,
										id_supplier,
										jumlah,
										tanggal_masuk,
										username) 
								VALUES('$ifa[id_faktur]',
									   '$_POST[id]',
									   '$_POST[id_supplier]',
									   '$_POST[stokmasuk]',
									   '$tglbeli',
									   '$_SESSION[namauser]')");
    $id =$_POST[id];
    $newStok = $_POST['stok'] + $_POST['stokmasuk'];
    $produk = mysqli_query($koneksi, "UPDATE produk SET id_kategori = '$_POST[kategori]', nama_produk = '$_POST[judul]', deskripsi = '$_POST[deskripsi]', harga = '$_POST[harga]', harga_grosir = '$_POST[harga_grosir]', harga_pokok = '$_POST[harga_pokok]', satuan = '$_POST[satuan]', id_rak = '$_POST[rak]', baris_rak = '$_POST[baris]', id_supplier = '$_POST[id_supplier]', part_number = '$_POST[part_number]' WHERE id_produk = '$id'");


    header('location:all-produk-faktur-' . $_POST['id'] . '.html');

}
elseif ($_GET['module'] == 'hapusproduk')
{
    mysqli_query($koneksi, "DELETE FROM produk_pembelian WHERE id_produk='$_GET[id]' AND id_faktur='$_GET[idf]'");

    header('location:detail-produk-' . $_GET['no'] . '.html');
}
?>
