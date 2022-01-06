<?php
if ($_GET['module']=='supplier'){
    echo "<h3>Manajemen supplier Produk.</b></h3><br/>
          <input type=button value='Tambah Supplier' 
          onclick=\"window.location.href='media.php?module=tambahsupplier';\">
         
		 <table  class='data'>
          <tr class='data'>
			<th class='data'>No</th>
			<th class='data'>Nama supplier</th>
			<th class='data'>Nama Bank</th>
			<th class='data'>No Rekening</th>
			<th class='data' align='center' width='80px;'>Action</th>
		  </tr>"; 
    $tampil=mysqli_query($koneksi, "SELECT * FROM supplier ORDER BY id_supplier DESC");
    $no=1;
    while ($r=mysqli_fetch_array($tampil)){
	if(($no % 2)==0){
			$warna="#ffffff";
		  }
		  // Apabila sisa baginya ganjil, maka warnanya kuning (#FFFF00). 
		  else{
			$warna="#E1E1E1";
		  }
       echo "<tr class='data'><td class='data'>$no</td>
             <td class='data'>$r[nama_supplier]</td>
			 <td class='data'>$r[bank]</td>
			 <td class='data'>$r[no_rekening]</td>
             <td class='data'><a href=media.php?module=editsupplier&id=$r[id_supplier]>Edit</a> | 
	               <a href=media.php?module=hapussupplier&id=$r[id_supplier]>Hapus</a>
             </td></tr>";
      $no++;
    }
    echo "</table>";
	
}elseif ($_GET['module']=='tambahsupplier'){
	echo "<h3>Tambah supplier Produk.</h3><br/>
          <form method=POST action='media.php?module=aksitambahsupplier'>
          <table>
          <tr><td>Nama supplier</td><td> : <input type=text name='nama_supplier' style='width:350px;'></td></tr>
		  <tr><td>Nama Bank</td><td> : <input type=text name='bank' style='width:350px;'></td></tr>
		  <tr><td>No Rekening</td><td> : <input type=text name='no_rekening' style='width:350px;'></td></tr>
          <tr><td colspan=2><input type=submit name=submit value=Simpan>
                            <input type=button value=Batal onclick=self.history.back()></td></tr>
          </table></form>";
		  
}elseif ($_GET['module']=='aksitambahsupplier'){
  mysqli_query($koneksi, "INSERT INTO supplier(nama_supplier, bank, no_rekening) VALUES('$_POST[nama_supplier]','$_POST[bank]','$_POST[no_rekening]')");
  header('location:supplier.html');
}

elseif ($_GET['module']=='editsupplier'){
    $edit=mysqli_query($koneksi, "SELECT * FROM supplier WHERE id_supplier='$_GET[id]'");
    $r=mysqli_fetch_array($edit);

    echo "<h3>Edit supplier Produk.</h3><br/>
          <form method=POST action='media.php?module=aksieditsupplier'>
          <input type=hidden name=id value='$r[id_supplier]'>
          <table>
          <tr><td>Nama supplier</td><td> : <input type=text name='nama_supplier' value='$r[nama_supplier]' style='width:350px;'></td></tr>
		  <tr><td>Nama Bank</td><td> : <input type=text name='bank' value='$r[bank]' style='width:350px;'></td></tr>
          <tr><td>No Rekening</td><td> : <input type=text name='no_rekening' value='$r[no_rekening]' style='width:350px;'></td></tr>
		  <tr><td colspan=2><input type=submit value=Update>
                            <input type=button value=Batal onclick=self.history.back()></td></tr>
          </table></form>";
		  
}elseif ($_GET['module']=='aksieditsupplier'){
  mysqli_query($koneksi, "UPDATE supplier SET nama_supplier = '$_POST[nama_supplier]',bank = '$_POST[bank]',no_rekening = '$_POST[no_rekening]' WHERE id_supplier = '$_POST[id]'");
  header('location:supplier.html');
  
}elseif ($_GET['module']=='hapussupplier'){
  mysqli_query($koneksi, "DELETE FROM supplier WHERE id_supplier='$_GET[id]'");
  header('location:supplier.html');
}
?>