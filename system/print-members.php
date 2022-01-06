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
echo "<table width=100% cellpadding='7'>
          <tr style='color:#fff; height:35px;' bgcolor=#000><th>No</th><th>Username</th><th>Nama Lengkap</th><th>No.Telp/HP</th><th>Alamat Lengkap</th><th>Status</th></tr>"; 
    $no=1;
	$tampil = mysqli_query($koneksi, "SELECT * FROM users ORDER BY username");
    while ($r=mysqli_fetch_array($tampil)){
       if ($r['level'] == 'admin'){
	   echo "<tr bgcolor=red style='color:#fff;'>";
	   }else{
	   echo "<tr bgcolor=$warna>";
	   }
			echo " <td>$no</td>
             <td>$r[username]</td>
             <td><a title='$r[email]' href=mailto:$r[email]>$r[nama_lengkap]</a></td>
		         <td>$r[no_telp]</td>
				 <td>$r[alamat_lengkap]</td>
				 <td>$r[aktif]</td>
             </tr>";
      $no++;
    }
    echo "</table><br/><tr><td><br/><span style='float:right; text-align:center;'> Point of Sale, $tgl_sekarang <br/>
										Karyawan<br/></br></br>
								(.............................................)
								<br/>$_SESSION[namalengkap]</span></td></tr>";
?>