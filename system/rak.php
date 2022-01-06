<?php
if ($_GET['module']=='rak'){
	echo "<h3>Manajemen Rak Produk.</h3><br/>
          <input type=button value='Tambah Rak' 
          onclick=\"window.location.href='media.php?module=tambahrak';\">
          <table class='data' width=100% cellpadding=6>
			<tr>
				<th class='data' width=30px>No</th>
				<th class='data'>Nama Rak</th>
				<th class='data' align='center' width='80px;'>Action</th>
			</tr>"; 
    $tampil=mysqli_query($koneksi, "SELECT * FROM rak ORDER BY id_rak DESC");
    $no=1;
    while ($r=mysqli_fetch_array($tampil)){
	if(($no % 2)==0){
			$warna="#ffffff";
		  }
		  else{
			$warna="#E1E1E1";
		  }
       echo "<tr class='data' bgcolor=$warna><td class='data'>$no</td>
				<td class='data'>$r[nama_rak]</td>
				<td class='data'><a href=media.php?module=editrak&id=$r[id_rak]>Edit</a> | 
	               <a href=media.php?module=hapusrak&id=$r[id_rak]>Hapus</a>
				</td>
			</tr>";
      $no++;
    }
    echo "</table>";
	
}elseif($_GET['module']=='tambahrak'){
echo "<h3>Tambah Rak Produk.</h3><br/>
          <form method=POST action='media.php?module=aksitambahrak'>
          <table>
          <tr><td>Nama Rak</td><td> : <input type=text name='nama_rak'></td></tr>
          <tr><td colspan=2><input type=submit name=submit value=Simpan>
                            <input type=button value=Batal onclick=self.history.back()></td></tr>
          </table></form>";
		  
}elseif($_GET['module']=='aksitambahrak'){
	$testing = addslashes($_POST['nama_rak']);
	mysqli_query($koneksi, "INSERT INTO rak(nama_rak) VALUES('$testing')");
	header('location:rak.html');
	
}elseif($_GET['module']=='editrak'){
	$edit=mysqli_query($koneksi, "SELECT * FROM rak WHERE id_rak='$_GET[id]'");
    $r=mysqli_fetch_array($edit);

    echo "<h3>Edit Rak Produk.</h3><br/>
          <form method=POST action='media.php?module=aksieditrak'>
          <input type=hidden name=id value='$r[id_rak]'>
          <table>
          <tr><td>Nama Rak</td><td> : <input type=text name='nama_rak' value='$r[nama_rak]'></td></tr>
          <tr><td colspan=2><input type=submit value=Update>
                            <input type=button value=Batal onclick=self.history.back()></td></tr>
          </table></form>";
		  
}elseif($_GET['module']=='aksieditrak'){
	mysqli_query($koneksi, "UPDATE rak SET nama_rak = '$_POST[nama_rak]' WHERE id_rak = '$_POST[id]'");
  header('location:rak.html');
  
}elseif($_GET['module']=='hapusrak'){
	mysqli_query($koneksi, "DELETE FROM rak WHERE id_rak='$_GET[id]'");
  header('location:rak.html');
}

?>