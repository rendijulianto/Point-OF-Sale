<?php
if ($_GET['module']=='kategori'){
	echo "<h3>Manajemen Kategori Produk.</h3><br/>
          <input type=button value='Tambah Kategori' 
          onclick=\"window.location.href='media.php?module=tambahkategori';\">
          <table class='data' width=100% cellpadding=6>
			<tr>
				<th class='data' width=30px>No</th>
				<th class='data'>Nama Kategori</th>
				<th class='data' align='center' width='80px;'>Action</th>
			</tr>"; 
    $tampil=mysqli_query($koneksi, "SELECT * FROM kategori_produk ORDER BY id_kategori DESC");
    $no=1;
    while ($r=mysqli_fetch_array($tampil)){
	if(($no % 2)==0){
			$warna="#ffffff";
		  }
		  else{
			$warna="#E1E1E1";
		  }
       echo "<tr class='data' bgcolor=$warna><td class='data'>$no</td>
				<td class='data'>$r[nama_kategori]</td>
				<td class='data'><a href=media.php?module=editkategori&id=$r[id_kategori]>Edit</a> | 
	               <a href=media.php?module=hapuskategori&id=$r[id_kategori]>Hapus</a>
				</td>
			</tr>";
      $no++;
    }
    echo "</table>";
	
}elseif($_GET['module']=='tambahkategori'){
echo "<h3>Tambah Kategori Produk.</h3><br/>
          <form method=POST action='media.php?module=aksitambahkategori'>
          <table>
          <tr><td>Nama Kategori</td><td> : <input type=text name='nama_kategori'></td></tr>
          <tr><td colspan=2><input type=submit name=submit value=Simpan>
                            <input type=button value=Batal onclick=self.history.back()></td></tr>
          </table></form>";
		  
}elseif($_GET['module']=='aksitambahkategori'){
	$testing = addslashes($_POST['nama_kategori']);
	mysqli_query($koneksi, "INSERT INTO kategori_produk(nama_kategori) VALUES('$testing')");
	header('location:kategori.html');
	
}elseif($_GET['module']=='editkategori'){
	$edit=mysqli_query($koneksi, "SELECT * FROM kategori_produk WHERE id_kategori='$_GET[id]'");
    $r=mysqli_fetch_array($edit);

    echo "<h3>Edit Kategori Produk.</h3><br/>
          <form method=POST action='media.php?module=aksieditkategori'>
          <input type=hidden name=id value='$r[id_kategori]'>
          <table>
          <tr><td>Nama Kategori</td><td> : <input type=text name='nama_kategori' value='$r[nama_kategori]'></td></tr>
          <tr><td colspan=2><input type=submit value=Update>
                            <input type=button value=Batal onclick=self.history.back()></td></tr>
          </table></form>";
		  
}elseif($_GET['module']=='aksieditkategori'){
	mysqli_query($koneksi, "UPDATE kategori_produk SET nama_kategori = '$_POST[nama_kategori]' WHERE id_kategori = '$_POST[id]'");
  header('location:kategori.html');
  
}elseif($_GET['module']=='hapuskategori'){
	mysqli_query($koneksi, "DELETE FROM kategori_produk WHERE id_kategori='$_GET[id]'");
  header('location:kategori.html');
}

?>