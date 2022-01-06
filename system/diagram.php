<?php 
$bulann = date("m");
$tahunn = date("Y");
?>
<script type="text/javascript">
var chart1;
$(document).ready(function() {
      chart1 = new Highcharts.Chart({
         chart: {
            renderTo: 'containerj',
            type: 'column'
         },   
         title: {
				<?php if (isset($_POST['submit'])){ ?>
				text: 'Laporan Jumlah Data Penjualan Bulan <?php echo "$_POST[bulan] - $_POST[tahun]"; ?>'
				<?php }else{ ?>
				text: 'Laporan Jumlah Data Penjualan Bulan <?php echo "$bulann - $tahunn"; ?>'
				<?php } ?>
         },
         xAxis: {
            categories: ['Kode / Nama Produk Yang Terjual']
         },
         yAxis: {
            title: {
				text: 'Jumlah Penjualan'
            }
         },
              series:             
            [
            <?php 
			include "../config/koneksi.php";
			if (isset($_POST['submit'])){
				$sql   = "SELECT * FROM (SELECT a.*, b.tgl_order, b.jam_order, substring(tgl_order,6,2) as bulan, substring(tgl_order,1,4) as tahun, e.kode_produk 
						FROM `orders_detail` a JOIN orders b ON a.id_orders=b.id_orders 
							JOIN produk e ON a.id_produk=e.id_produk) c 
								where c.bulan='$_POST[bulan]' AND tahun='$_POST[tahun]' LIMIT 20";
			}else{
				$sql   = "SELECT * FROM (SELECT a.*, b.tgl_order, b.jam_order, substring(tgl_order,6,2) as bulan, substring(tgl_order,1,4) as tahun, e.kode_produk 
						FROM `orders_detail` a JOIN orders b ON a.id_orders=b.id_orders 
							JOIN produk e ON a.id_produk=e.id_produk) c 
								where c.bulan='$bulann' AND tahun='$tahunn' LIMIT 20";
			}
            $query = mysqli_query($koneksi,  $sql )  or die(mysqli_error());
            while( $ret = mysqli_fetch_array( $query ) ){
            	$jenis=$ret['id_produk'];     
				$kode=$ret['kode_produk'];  
				$sql_jumlah = "SELECT SUM(jumlah) as jumlah FROM orders_detail where id_produk='$jenis'";  
                 $query_jumlah = mysqli_query($koneksi,  $sql_jumlah ) or die(mysqli_error());
                 while( $data = mysqli_fetch_array( $query_jumlah ) ){
					$jumlah = $data['jumlah']; 
                  }             
                  ?>
                  {
                      name: '<?php echo $kode;?>',
                      data: [<?php echo $jumlah; ?>]
                  },
                  <?php } ?>
            ]
      });
   });	
</script>
		<div id='containerj'></div>		
