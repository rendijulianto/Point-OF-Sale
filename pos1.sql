-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               5.7.24 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table pos_baru.admin
CREATE TABLE IF NOT EXISTS `admin` (
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telp` varchar(12) NOT NULL,
  `level` varchar(10) NOT NULL,
  `blokir` varchar(2) NOT NULL,
  `id_session` varchar(100) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Dumping data for table pos_baru.admin: 1 rows
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` (`username`, `password`, `nama_lengkap`, `email`, `telp`, `level`, `blokir`, `id_session`) VALUES
	('admin', '21232f297a57a5a743894a0e4a801fc3', 'Administrator', 'administrator@gmail.com', '081267771344', 'Admin', 'N', '21232f297a57a5a743894a0e4a801fc3');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;

-- Dumping structure for table pos_baru.costumer
CREATE TABLE IF NOT EXISTS `costumer` (
  `id_costumer` int(5) NOT NULL AUTO_INCREMENT,
  `nama_costumer` varchar(30) NOT NULL,
  `no_telpon` varchar(15) NOT NULL,
  `alamat_lengkap` text NOT NULL,
  PRIMARY KEY (`id_costumer`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

-- Dumping data for table pos_baru.costumer: 19 rows
/*!40000 ALTER TABLE `costumer` DISABLE KEYS */;
INSERT INTO `costumer` (`id_costumer`, `nama_costumer`, `no_telpon`, `alamat_lengkap`) VALUES
	(7, 'Utari', '089610889464', 'Natar, Lampung Selatan'),
	(6, 'Ummi Elviani', '087899113864', 'Branti, Natar'),
	(3, 'Udin Sedunia', '081267771355', 'Ulak Karang, Padang, Sumatera Barat'),
	(4, 'Anike Soumokill', '0894355763', 'Pagar Alam, Bandar Lampung'),
	(5, 'Qurota Anggun', '085768194950', 'Poncowarno,Pringsewu'),
	(8, 'Puput Indrayani', '085841354077', 'Rajabasa Permai, Bandar Lampung'),
	(9, 'Susilowati', '085783333873', 'Banyuwangi,Jawa Tengah'),
	(10, 'Yuli Ariyani', '085768497262', 'Rajabasa Permai, Bandar Lampung'),
	(11, 'Windia Bagus', '085736453858', 'Bandar Jaya'),
	(13, 'Septa Latif', '09878653643', 'Rajabasa Permai, Bandar Lampung'),
	(14, 'Dian Fajar', '08767343483', 'Kampung Baru, Unila'),
	(15, 'Dean Satya P', '08966576385', 'Bandar Lampung'),
	(16, 'Redho Algifaro', '08795436438', 'Rajabasa Permai, Bandar Lampung'),
	(17, 'Siti Fatimah', '085767437922', 'Kali Rejo, Pringsewu'),
	(18, 'Pita Sari', '085356388392', 'Palembang'),
	(19, 'Thiana Indar', '08973536463', 'Desa Mekar, Kota Bumi'),
	(20, 'M. FAHMI HAFIDZ', '089691561660', 'TABEK INDAH, NATAR');
/*!40000 ALTER TABLE `costumer` ENABLE KEYS */;

-- Dumping structure for table pos_baru.faktur
CREATE TABLE IF NOT EXISTS `faktur` (
  `id_faktur` int(5) NOT NULL AUTO_INCREMENT,
  `no_faktur` varchar(30) NOT NULL,
  `tanggal` datetime NOT NULL,
  PRIMARY KEY (`id_faktur`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

-- Dumping data for table pos_baru.faktur: 1 rows
/*!40000 ALTER TABLE `faktur` DISABLE KEYS */;
INSERT INTO `faktur` (`id_faktur`, `no_faktur`, `tanggal`) VALUES
	(14, 'AYO.220103161030', '2022-01-05 11:17:40');
/*!40000 ALTER TABLE `faktur` ENABLE KEYS */;

-- Dumping structure for table pos_baru.kategori_produk
CREATE TABLE IF NOT EXISTS `kategori_produk` (
  `id_kategori` int(5) NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(100) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id_kategori`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Dumping data for table pos_baru.kategori_produk: 7 rows
/*!40000 ALTER TABLE `kategori_produk` DISABLE KEYS */;
INSERT INTO `kategori_produk` (`id_kategori`, `nama_kategori`) VALUES
	(19, 'Penerangan'),
	(18, 'Media'),
	(20, 'Perabot'),
	(21, 'Rumah tangga'),
	(23, 'Bumbu Dapur'),
	(27, 'Kosmetik'),
	(28, 'Kesehatan');
/*!40000 ALTER TABLE `kategori_produk` ENABLE KEYS */;

-- Dumping structure for table pos_baru.orders
CREATE TABLE IF NOT EXISTS `orders` (
  `id_orders` int(5) NOT NULL AUTO_INCREMENT,
  `no_orders` varchar(12) COLLATE latin1_general_ci NOT NULL,
  `id_costumer` int(5) NOT NULL,
  `nama_kasir` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `tgl_order` date NOT NULL,
  `jam_order` time NOT NULL,
  `bayar` int(10) NOT NULL,
  `status` int(2) NOT NULL,
  PRIMARY KEY (`id_orders`)
) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Dumping data for table pos_baru.orders: 1 rows
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` (`id_orders`, `no_orders`, `id_costumer`, `nama_kasir`, `tgl_order`, `jam_order`, `bayar`, `status`) VALUES
	(52, 'S220105-0006', 0, 'Rendi Jul', '2022-01-05', '11:38:34', 0, 1),
	(51, 'S220105-0005', 0, 'Rendi Jul', '2022-01-05', '11:34:57', 500000, 1),
	(50, 'S220105-0004', 0, 'Rendi Jul', '2022-01-05', '11:33:47', 250000, 1),
	(49, 'S220105-0003', 0, 'Rendi Jul', '2022-01-05', '11:33:12', 250000, 1),
	(48, 'S220105-0002', 0, 'Rendi Jul', '2022-01-05', '11:33:00', 240000, 2),
	(47, 'S220105-0001', 0, 'Rendi Jul', '2022-01-05', '11:32:39', 100000000, 2);
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;

-- Dumping structure for table pos_baru.orders_detail
CREATE TABLE IF NOT EXISTS `orders_detail` (
  `id_orders` int(5) NOT NULL,
  `id_produk` int(5) NOT NULL,
  `jumlah` int(5) NOT NULL,
  `harga` int(20) DEFAULT NULL,
  `harga_pokok` int(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Dumping data for table pos_baru.orders_detail: 1 rows
/*!40000 ALTER TABLE `orders_detail` DISABLE KEYS */;
INSERT INTO `orders_detail` (`id_orders`, `id_produk`, `jumlah`, `harga`, `harga_pokok`) VALUES
	(52, 121, 1, 180000, 167000),
	(51, 120, 1, 250000, 214000),
	(51, 121, 1, 180000, 167000),
	(50, 120, 1, 250000, 214000),
	(49, 120, 1, 250000, 214000),
	(48, 120, 1, 240000, 214000),
	(47, 121, 1000, 170000, 167000),
	(0, 121, 1, 170000, 167000),
	(0, 121, 1, 170000, 167000),
	(0, 121, 3, 170000, 167000);
/*!40000 ALTER TABLE `orders_detail` ENABLE KEYS */;

-- Dumping structure for table pos_baru.orders_temp
CREATE TABLE IF NOT EXISTS `orders_temp` (
  `id_orders_temp` int(5) NOT NULL AUTO_INCREMENT,
  `id_produk` int(5) NOT NULL,
  `id_session` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `jumlah` int(5) NOT NULL,
  `tgl_order_temp` date NOT NULL,
  `jam_order_temp` time NOT NULL,
  PRIMARY KEY (`id_orders_temp`)
) ENGINE=MyISAM AUTO_INCREMENT=490 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Dumping data for table pos_baru.orders_temp: 0 rows
/*!40000 ALTER TABLE `orders_temp` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders_temp` ENABLE KEYS */;

-- Dumping structure for table pos_baru.produk
CREATE TABLE IF NOT EXISTS `produk` (
  `id_produk` int(5) NOT NULL AUTO_INCREMENT,
  `kode_produk` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `id_kategori` int(5) NOT NULL,
  `nama_produk` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `deskripsi` text COLLATE latin1_general_ci NOT NULL,
  `harga` int(20) NOT NULL,
  `harga_grosir` int(20) NOT NULL,
  `harga_pokok` int(20) NOT NULL,
  `satuan` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `berat` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `diskon` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `tgl_masuk` date NOT NULL,
  `id_rak` int(5) NOT NULL,
  `baris_rak` int(5) NOT NULL,
  `id_supplier` int(5) NOT NULL,
  `part_number` varchar(30) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id_produk`)
) ENGINE=MyISAM AUTO_INCREMENT=122 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Dumping data for table pos_baru.produk: 3 rows
/*!40000 ALTER TABLE `produk` DISABLE KEYS */;
INSERT INTO `produk` (`id_produk`, `kode_produk`, `id_kategori`, `nama_produk`, `deskripsi`, `harga`, `harga_grosir`, `harga_pokok`, `satuan`, `berat`, `diskon`, `tgl_masuk`, `id_rak`, `baris_rak`, `id_supplier`, `part_number`) VALUES
	(121, '0411255221', 28, 'DJI SAM SOE MAGNUM FILTER 12', '-', 180000, 170000, 167000, 'Bungkus', '0', '0', '2022-01-05', 1, 2, 3, '552525252'),
	(120, '8993988090083', 21, 'DJI SAM SOE KRETEK', '-', 250000, 240000, 214000, 'Bungkus', '0', '0', '2022-01-05', 1, 2, 3, '85852582582');
/*!40000 ALTER TABLE `produk` ENABLE KEYS */;

-- Dumping structure for table pos_baru.produk_pembelian
CREATE TABLE IF NOT EXISTS `produk_pembelian` (
  `id_produk_pembelian` int(5) NOT NULL AUTO_INCREMENT,
  `id_faktur` varchar(20) NOT NULL,
  `id_produk` int(5) NOT NULL,
  `id_supplier` int(5) NOT NULL,
  `jumlah` int(5) NOT NULL,
  `tanggal_masuk` datetime NOT NULL,
  `username` varchar(50) NOT NULL,
  PRIMARY KEY (`id_produk_pembelian`)
) ENGINE=MyISAM AUTO_INCREMENT=60 DEFAULT CHARSET=latin1;

-- Dumping data for table pos_baru.produk_pembelian: 4 rows
/*!40000 ALTER TABLE `produk_pembelian` DISABLE KEYS */;
INSERT INTO `produk_pembelian` (`id_produk_pembelian`, `id_faktur`, `id_produk`, `id_supplier`, `jumlah`, `tanggal_masuk`, `username`) VALUES
	(59, '14', 121, 3, 1000, '2022-01-05 11:34:31', 'admin'),
	(58, '14', 121, 3, 5, '2022-01-05 11:22:20', 'admin'),
	(57, '14', 121, 3, 10, '2022-01-05 11:20:12', 'admin'),
	(56, '14', 120, 3, 12, '2022-01-05 11:19:22', 'admin');
/*!40000 ALTER TABLE `produk_pembelian` ENABLE KEYS */;

-- Dumping structure for table pos_baru.rak
CREATE TABLE IF NOT EXISTS `rak` (
  `id_rak` int(5) NOT NULL AUTO_INCREMENT,
  `nama_rak` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id_rak`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table pos_baru.rak: ~0 rows (approximately)
/*!40000 ALTER TABLE `rak` DISABLE KEYS */;
INSERT INTO `rak` (`id_rak`, `nama_rak`) VALUES
	(1, 'Rak 1');
/*!40000 ALTER TABLE `rak` ENABLE KEYS */;

-- Dumping structure for table pos_baru.return_produk
CREATE TABLE IF NOT EXISTS `return_produk` (
  `id_return` int(5) NOT NULL AUTO_INCREMENT,
  `id_produk` int(5) NOT NULL,
  `id_supplier` int(5) NOT NULL,
  `jumlah` int(5) NOT NULL,
  `waktu_return` datetime NOT NULL,
  PRIMARY KEY (`id_return`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Dumping data for table pos_baru.return_produk: 0 rows
/*!40000 ALTER TABLE `return_produk` DISABLE KEYS */;
/*!40000 ALTER TABLE `return_produk` ENABLE KEYS */;

-- Dumping structure for table pos_baru.statis
CREATE TABLE IF NOT EXISTS `statis` (
  `judul` varchar(255) NOT NULL,
  `halaman` varchar(20) NOT NULL,
  `detail` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table pos_baru.statis: 1 rows
/*!40000 ALTER TABLE `statis` DISABLE KEYS */;
INSERT INTO `statis` (`judul`, `halaman`, `detail`) VALUES
	('Selamat datang di sistem informasi Penjualan', 'home', '<p>System aplikasi point of sale adalah software yang di rancang, untuk mempermudah user / kasir dalam melakukan transaksi penjulan dan pembelian barang, software point of sale sudah bisa menghitung stock barang secara otomatis. software ini bisa digunakan di toko, minimarket dll. Selain itu keunggulan software ini sudah mencakup, pembayaran hutang, pembayaran piutang dan retur pembelian, retur penjualan barang , penjualan jasa dan software ini sudah dilengkapi dengan beberapa laporan-laporan yang bertujuan untuk mempermudah user dalam mengontrol data barang data â€“ data transaksi penjualan dan pembelian maupun retur barang secara baik. </p>\r\n\r\n<p>Adapun laporan point of sale adalah laporan master barang, laporan transaksi penjualan dan pembelian barang, laporan stock, laporan mutasi stock, laporan daftar customer, laporan piutang , laporan rekap umur piutang, laporan rugi laba dll. Software ini sudah dilengkapi dengan user password level sehingga hak akses user dalam mengoperasikan software bisa di control atau dibatasi yang bertujuan untuk menjaga kerahasiaan data yang semuanya sudah teritegrasi yang dikumpulkan dalam satu modul poin of sale.</p>\r\n\r\n<p>Selain itu keunggulan software ini sudah mencakup, pembayaran hutang, pembayaran piutang dan retur pembelian, retur penjualan barang , penjualan jasa dan software ini sudah dilengkapi dengan beberapa laporan-laporan yang bertujuan untuk mempermudah user dalam mengontrol data barang data â€“ data transaksi penjualan dan pembelian maupun retur barang secara baik. </p>');
/*!40000 ALTER TABLE `statis` ENABLE KEYS */;

-- Dumping structure for table pos_baru.supplier
CREATE TABLE IF NOT EXISTS `supplier` (
  `id_supplier` int(5) NOT NULL AUTO_INCREMENT,
  `nama_supplier` varchar(255) NOT NULL,
  `bank` varchar(100) NOT NULL,
  `no_rekening` varchar(255) NOT NULL,
  PRIMARY KEY (`id_supplier`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- Dumping data for table pos_baru.supplier: 3 rows
/*!40000 ALTER TABLE `supplier` DISABLE KEYS */;
INSERT INTO `supplier` (`id_supplier`, `nama_supplier`, `bank`, `no_rekening`) VALUES
	(1, 'Pt Persada Nusantara tbk', 'Bank BCA', '112 56 7879 23'),
	(2, 'Pt Makmur cahaya baru melati', 'Bank Danamon', '3511887071'),
	(3, 'PT Damai Sentosa Sejahtera ', 'Bank Mandiri', '123 1 90897 453');
/*!40000 ALTER TABLE `supplier` ENABLE KEYS */;

-- Dumping structure for table pos_baru.users
CREATE TABLE IF NOT EXISTS `users` (
  `username` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `password` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `nama_lengkap` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `email` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `no_telp` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `level` varchar(20) COLLATE latin1_general_ci NOT NULL DEFAULT 'customer',
  `aktif` enum('Y','N') COLLATE latin1_general_ci NOT NULL DEFAULT 'N',
  `id_session` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `alamat_lengkap` varchar(255) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Dumping data for table pos_baru.users: 1 rows
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`username`, `password`, `nama_lengkap`, `email`, `no_telp`, `level`, `aktif`, `id_session`, `alamat_lengkap`) VALUES
	('rendijulianto', '7afe54be18aab7bd12cfe74ee7739cfe', 'Rendi Jul', 'rendijulianto1707@gmail.com', '082129632854', 'kasir', 'Y', '7afe54be18aab7bd12cfe74ee7739cfe', '-');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
