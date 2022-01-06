<?php 

  error_reporting(0);
  include "../config/koneksi.php";
  include "../config/fungsi_indotgl.php";
  include "../config/class_paging.php";
  include "../config/library.php";
  include "../config/fungsi_rupiah.php";
  include "../config/session_member.php";
?>

<html>
<head>
<title>Aplikasi Penjualan</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="robots" content="index, follow">
	<meta name="author" content="phpmu.com">
	<meta http-equiv="imagetoolbar" content="no">
	<meta name="language" content="Indonesia">
	<meta name="revisit-after" content="7">
	<meta name="webcrawlers" content="all">
	<meta name="rating" content="general">
	<meta name="spiders" content="all">
	<link rel="shortcut icon" href="favicon.png" />
		
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="../mos-css/mos-style.css"> <!--pemanggilan file css-->
    <link rel="stylesheet" href="autocomplete/jquery-ui.css" />
    <script src="autocomplete/jquery-1.8.3.js"></script>
    <script src="autocomplete/jquery-ui.js"></script>

    <script>
    $(function() {  
        $( "#kodeproduk" ).autocomplete({
         source: "sourcedata.php",  
           minLength:2, 
        });
    });
    </script>

<script src="js/highcharts.js" type="text/javascript"></script>
<script src="js/format_rp.js" type="text/javascript"></script>
<script type="text/javascript">
		$(document).ready(function(){
			$('#angka1').maskMoney();
			$('#angka2').maskMoney({prefix:'US$'});
			$('#type2').maskMoney({prefix:'', thousands:'.', decimal:',', precision:0});
			$('#result').maskMoney({prefix:'', thousands:'.', decimal:',', precision:0});
			$('#angka4').maskMoney();
		});
</script>
<script>
	function kalkulatorTambah(type1,type2){
	var res = type2.replace(".", "");
	var hasil = eval(res) - eval(type1);
	document.getElementById('result').value = hasil;
		if (isNaN(hasil)) 
			return 0;
		else
			return hasil;
		}
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
</head>

<body>
<div id="header">
	<div class="inHeader">
		<div class="mosAdmin">
		Hallo, <?php echo "$_SESSION[namalengkap]"; ?><br>
		<a target='_BLANK' href="http://phpmu.com/">Help</a> | <a href="../logout.php">Keluar</a>
		</div>
	<div class="clear"></div>
	</div>
</div>

<div id="wrapper">
	<div id="leftBar">
	<ul>
		<li><a href="index.php">Dashboard</a></li>
		<?php 
			if ($_SESSION['leveluser'] == 'Admin'){
				echo "<li><a href='kasir.html'>Kasir</a></li>
				<li><a href='faktur.html'>Barang Masuk</a></li>
				<li><a href='rak.html'>Rak Barang</a></li>
					  <li><a href='kategori.html'>Kategori</a></li>
					  <li><a href='supplier.html'>Suppliers</a></li>
					  <li><a href='semua-customer.html'>Data Customer</a></li>
					  <li><a href='return.html'>Return Produk</a></li>
					  <li><a href='laporan.html'>Laporan</a></li>
					  <li><a href='diagram.html'>Graf. Bulan</a></li>
					  <li><a href='tahun-diagram.html'>Graf. Tahun</a></li>
					  <li><a href='data-kategori-diagram.html'>Graf. Kategori</a></li>
					  ";
			}else{
				echo "<li><a href='semua-produk.html'>Produk</a></li>
					  <li><a href='transaksi-belanja-1.html'>Transaksi Ecer</a></li>
					  <li><a href='transaksi-belanja-2.html'>Transaksi Grosir</a></li>
					  <li><a href='semua-customer.html'>Data Customer</a></li>
					  <li><a href='return.html'>Return Produk</a></li>
					  <li><a href='status-pembelian.html'>Laporan</a></li>";
			}
			
		?>
		<li><a href="../logout.php">Logout</a></li>
	</ul>
	</div>
	<div id="rightContent">
		<?php include "kiri.php"; ?>
	</div>
<div class="clear"></div>
<div id="footer">
	Copyright &copy; <?php echo date('Y') ?> <a href="#">Point of Sale</a> | Design <a href="www.beliscript.com" target="_blank">Beli Script</a><br>
</div>
</div>
<script type="text/javascript">
$(document).ready(function() {
  update();
  $(".quant").change(function() {
    //this: context of the input that was changed
    $.get(
      '/minimarket/media.php?module=keranjangbelanja&stat=1&AddTocart', {
        id: $(this).attr('data-id'),
        returnUrl: '',
        quantity: $(this).val()
      });
    update();
  });

  function update() {
    var sum = 0.0;
    var quantity;
    $('#myTable > tbody  > tr').each(function() {
      quantity = $(this).find('.quant').val();
      var price = parseFloat($(this).find('.price').attr('data-price').replace(',', '.'));
      var amount = (quantity * price);

      sum += amount;
      $(this).find('.amount').text('' + amount);
    });
    $('.total').val(sum);
  }
});
</script>
</body>
</html>