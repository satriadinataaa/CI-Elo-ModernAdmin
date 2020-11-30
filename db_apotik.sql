-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 29 Nov 2020 pada 13.05
-- Versi server: 10.4.14-MariaDB
-- Versi PHP: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_apotik`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang_jual`
--

CREATE TABLE `barang_jual` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `id_penjualan` bigint(20) UNSIGNED NOT NULL,
  `id_obat` smallint(5) UNSIGNED NOT NULL,
  `qty` smallint(5) UNSIGNED NOT NULL,
  `harga` int(10) UNSIGNED NOT NULL,
  `diskon` float UNSIGNED NOT NULL DEFAULT 0,
  `online` int(11) NOT NULL DEFAULT 0,
  `satuan` int(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `barang_jual`
--

INSERT INTO `barang_jual` (`id`, `id_penjualan`, `id_obat`, `qty`, `harga`, `diskon`, `online`, `satuan`, `created_at`, `updated_at`) VALUES
(161, 1239, 11, 10, 5600, 0, 0, 0, '2020-11-29 06:21:55', '2020-11-29 06:21:55'),
(162, 1240, 11, 10, 5600, 0, 0, 0, '2020-11-29 06:22:44', '2020-11-29 06:22:44'),
(163, 1240, 11, 5, 1500, 0, 0, 1, '2020-11-29 06:22:44', '2020-11-29 06:22:44');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cabang`
--

CREATE TABLE `cabang` (
  `id_cabang` smallint(5) UNSIGNED NOT NULL,
  `nama_cabang` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `no_hp` varchar(14) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `cabang`
--

INSERT INTO `cabang` (`id_cabang`, `nama_cabang`, `alamat`, `no_hp`, `created_at`, `updated_at`) VALUES
(1, 'Cabang Demang Lebar Daun', 'Jl Demang Lebar Daun no 3', '0711442279', '2020-03-21 23:15:13', '2020-03-21 23:15:13'),
(2, 'Cabang Polygon', 'Perumahan Bukit Sejahtera Blok Ek-25 Palembang', '0711442278', '2020-03-21 23:16:47', '2020-03-21 23:16:47'),
(8, 'Cabang Tes', '12121', '121212', '2020-03-26 01:43:22', '2020-03-26 01:43:22');

-- --------------------------------------------------------

--
-- Struktur dari tabel `obat`
--

CREATE TABLE `obat` (
  `id_obat` smallint(5) UNSIGNED NOT NULL,
  `nama` varchar(100) NOT NULL,
  `no_batch` varchar(100) NOT NULL,
  `expired_date` date NOT NULL,
  `StockBox` int(11) UNSIGNED NOT NULL,
  `qtyPerBox` int(11) NOT NULL,
  `stok` mediumint(8) UNSIGNED NOT NULL,
  `modal` int(11) NOT NULL,
  `harga_satuan` int(10) UNSIGNED NOT NULL,
  `hargaBox` int(11) NOT NULL,
  `LetakObat` text NOT NULL,
  `id_cabang` smallint(5) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `obat`
--

INSERT INTO `obat` (`id_obat`, `nama`, `no_batch`, `expired_date`, `StockBox`, `qtyPerBox`, `stok`, `modal`, `harga_satuan`, `hargaBox`, `LetakObat`, `id_cabang`, `created_at`, `updated_at`) VALUES
(11, 'yawa', '23423423', '2024-09-08', 47, 10, 470, 5000, 300, 5600, 'disamping lemari', 1, '2020-11-29 06:22:44', '2020-11-29 06:22:44');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penjualan`
--

CREATE TABLE `penjualan` (
  `id_penjualan` bigint(20) UNSIGNED NOT NULL,
  `id_cabang` smallint(5) UNSIGNED NOT NULL,
  `id_user` smallint(5) UNSIGNED NOT NULL,
  `total` int(10) UNSIGNED NOT NULL,
  `nama_pembeli` varchar(100) NOT NULL,
  `no_hp` varchar(14) NOT NULL,
  `statusBon` tinyint(1) NOT NULL DEFAULT 0,
  `uangMuka` int(11) NOT NULL DEFAULT 0,
  `statusVerifikasi` int(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `penjualan`
--

INSERT INTO `penjualan` (`id_penjualan`, `id_cabang`, `id_user`, `total`, `nama_pembeli`, `no_hp`, `statusBon`, `uangMuka`, `statusVerifikasi`, `created_at`, `updated_at`) VALUES
(1239, 1, 4, 5600, 'satria1', '829348923829', 0, 0, 0, '2020-11-29 06:21:55', '2020-11-29 06:21:55'),
(1240, 1, 4, 7100, 'satria1', '829348923829', 0, 0, 0, '2020-11-29 06:22:44', '2020-11-29 06:22:44');

-- --------------------------------------------------------

--
-- Struktur dari tabel `role`
--

CREATE TABLE `role` (
  `id_role` smallint(5) NOT NULL,
  `role` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `role`
--

INSERT INTO `role` (`id_role`, `role`) VALUES
(1, 'owner'),
(2, 'pegawai');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_user` smallint(5) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `id_role` smallint(5) NOT NULL,
  `id_cabang` smallint(5) UNSIGNED NOT NULL,
  `no_hp` varchar(14) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `nama`, `id_role`, `id_cabang`, `no_hp`, `created_at`, `updated_at`) VALUES
(1, 'owner', '72122ce96bfec66e2396d2e25225d70a', 'Santoso', 1, 1, '0711442289', '2020-03-21 23:17:47', '2020-08-29 01:09:57'),
(2, 'pegawai1', '0b96cb1d0dfbcc85f6b57041656abc49', 'pegawai1', 2, 1, '07114422792', '2020-03-21 23:22:08', '2020-03-21 23:22:08'),
(3, 'pegawai2', 'fa23517aa1adfaab707494340009a330', 'pegawai2', 2, 2, '07114422793', '2020-03-21 23:22:50', '2020-03-21 23:22:50'),
(4, 'satria', '477054c78baea7a1242f79d898a2ca46', 'Satria', 2, 1, '0711442279', '2020-03-26 03:07:00', '2020-03-26 03:07:00');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `barang_jual`
--
ALTER TABLE `barang_jual`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_obat` (`id_obat`),
  ADD KEY `id_penjualan` (`id_penjualan`);

--
-- Indeks untuk tabel `cabang`
--
ALTER TABLE `cabang`
  ADD PRIMARY KEY (`id_cabang`);

--
-- Indeks untuk tabel `obat`
--
ALTER TABLE `obat`
  ADD PRIMARY KEY (`id_obat`),
  ADD KEY `id_cabang` (`id_cabang`);

--
-- Indeks untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id_penjualan`),
  ADD KEY `id_cabang` (`id_cabang`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id_role`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `id_cabang` (`id_cabang`),
  ADD KEY `id_role` (`id_role`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `barang_jual`
--
ALTER TABLE `barang_jual`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=166;

--
-- AUTO_INCREMENT untuk tabel `cabang`
--
ALTER TABLE `cabang`
  MODIFY `id_cabang` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `obat`
--
ALTER TABLE `obat`
  MODIFY `id_obat` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `id_penjualan` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1242;

--
-- AUTO_INCREMENT untuk tabel `role`
--
ALTER TABLE `role`
  MODIFY `id_role` smallint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_user` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `barang_jual`
--
ALTER TABLE `barang_jual`
  ADD CONSTRAINT `barang_jual_ibfk_3` FOREIGN KEY (`id_obat`) REFERENCES `obat` (`id_obat`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `barang_jual_ibfk_4` FOREIGN KEY (`id_penjualan`) REFERENCES `penjualan` (`id_penjualan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `obat`
--
ALTER TABLE `obat`
  ADD CONSTRAINT `obat_ibfk_1` FOREIGN KEY (`id_cabang`) REFERENCES `cabang` (`id_cabang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  ADD CONSTRAINT `penjualan_ibfk_1` FOREIGN KEY (`id_cabang`) REFERENCES `cabang` (`id_cabang`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `penjualan_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`id_cabang`) REFERENCES `cabang` (`id_cabang`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`id_role`) REFERENCES `role` (`id_role`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
