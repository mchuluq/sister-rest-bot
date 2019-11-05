CREATE TABLE `t_kalender` (
	`id` INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`nama` VARCHAR(256) NULL DEFAULT NULL,
	`tgl_mulai` DATE NULL DEFAULT NULL,
	`tgl_akhir` DATE NULL DEFAULT NULL,
	`thn_ajar` VARCHAR(9) NOT NULL,
	`id_smt` VARCHAR(5) NOT NULL, 
    `semester` ENUM('ganjil','genap') NOT NULL,
	`keterangan` TEXT NOT NULL
) COLLATE='utf8_unicode_ci' ENGINE=InnoDB;

CREATE TABLE `t_mhs` (
	`mhs_nim` VARCHAR(15) NOT NULL PRIMARY KEY,
	`nama_lengkap` VARCHAR(100) NOT NULL,
	`jenis_kelamin` CHAR(1) NOT NULL,
	`tempat_lahir` VARCHAR(50) NOT NULL,
	`tanggal_lahir` DATE NOT NULL,
	`tahun_angkatan` VARCHAR(4) NOT NULL,
	`prodi` VARCHAR(50) NOT NULL,
	`fakultas` VARCHAR(50) NOT NULL
) COLLATE='utf8_unicode_ci' ENGINE=InnoDB;

CREATE TABLE `t_frs` (
	`frs_id` VARCHAR(36) NOT NULL PRIMARY KEY,
	`mhs_nim` VARCHAR(15) NOT NULL,
	`semester` TINYINT(4) NULL DEFAULT NULL,
	`pembimbing_akademik` VARCHAR(100) NULL DEFAULT NULL,
	`persetujuan` CHAR(1) NULL DEFAULT '0',
	`id_smt` VARCHAR(5) NULL DEFAULT NULL,
	`ips` FLOAT NOT NULL DEFAULT '0',
	`sks_smt` TINYINT(3) NOT NULL DEFAULT '0',
	`ip` FLOAT NOT NULL DEFAULT '0',
	`sks_total` TINYINT(3) NOT NULL DEFAULT '0',
	`status_aktif_mhs` CHAR(1) NOT NULL DEFAULT 'A'
) COLLATE='utf8_unicode_ci' ENGINE=InnoDB;

CREATE TABLE `t_frs_items` (
	`id` INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`frs_id` VARCHAR(100) NULL DEFAULT NULL,
	`kode_kelas` VARCHAR(36) NULL DEFAULT NULL,
	`mhs_nim` VARCHAR(15) NULL DEFAULT NULL,
	`keterangan` TEXT NULL,
	`nilai_huruf` VARCHAR(2) NULL DEFAULT 'E',
	`nilai_angka` FLOAT NULL DEFAULT '0',
	`sksn` FLOAT(9,1) NULL DEFAULT '0.0',
	`nilai_index` FLOAT(9,1) NOT NULL DEFAULT '0.0',
	`jumlah_kehadiran` TINYINT(2) NULL DEFAULT '0'
) COLLATE='utf8_unicode_ci'ENGINE=InnoDB;

CREATE TABLE `t_kelas` (
	`kode_kelas` VARCHAR(36) NOT NULL PRIMARY KEY,
	`mk_kode` VARCHAR(15) NOT NULL,
    `mk_nama` VARCHAR(100) NOT NULL,
    `mk_sks` TINYINT(3) NOT NULL,
	`id_smt` VARCHAR(5) NOT NULL,
	`nama_dosen` VARCHAR(100) NULL DEFAULT NULL,
	`hari` CHAR(1) NULL DEFAULT NULL,
	`jam_mulai` VARCHAR(5) NULL DEFAULT '00:00',
	`jam_selesai` VARCHAR(5) NULL DEFAULT '00:00',
	`ruang` VARCHAR(20) NULL DEFAULT NULL,
	`nm_kelas` VARCHAR(5) NULL DEFAULT NULL,
	`tatap_muka` TINYINT(2) NOT NULL
) COLLATE='utf8_unicode_ci' ENGINE=InnoDB;

CREATE TABLE `api_keys` (
	`id` INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`user_id` INT(11) NOT NULL,
	`key` VARCHAR(40) NOT NULL,
	`level` INT(2) NOT NULL,
	`ignore_limits` TINYINT(1) NOT NULL DEFAULT '0',
	`is_private_key` TINYINT(1)  NOT NULL DEFAULT '0',
	`ip_addresses` TEXT NULL DEFAULT NULL,
	`date_created` INT(11) NOT NULL
) COLLATE='utf8_unicode_ci'ENGINE=InnoDB;


CREATE TABLE `api_access` (
	`id` INT(11) unsigned NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `key` VARCHAR(40) NOT NULL DEFAULT '',
    `all_access` TINYINT(1) NOT NULL DEFAULT '0',
    `controller` VARCHAR(50) NOT NULL DEFAULT '',
	`date_created` DATETIME DEFAULT NULL,
    `date_modified` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) COLLATE='utf8_unicode_ci'ENGINE=InnoDB;

INSERT INTO `api_keys` (`id`, `user_id`, `key`, `level`, `ignore_limits`, `is_private_key`, `ip_addresses`, `date_created`) VALUES (2, 0, '86b47b2c7e9824b7eda643f2f00ce1c4a11a7d59', 0, 0, 0, NULL, 1569560373);
INSERT INTO `api_keys` (`id`, `user_id`, `key`, `level`, `ignore_limits`, `is_private_key`, `ip_addresses`, `date_created`) VALUES (3, 0, '379c4c55ad48c73fd5f0182e38e46e10ad3db40e', 0, 0, 0, NULL, 1569560556);

INSERT INTO sister_rest_bot.t_mhs (mhs_nim,nama_lengkap,jenis_kelamin,tempat_lahir,tanggal_lahir,tahun_angkatan,prodi,fakultas) 
SELECT mhs_nim,nama_lengkap,jenis_kelamin,tempat_lahir,tanggal_lahir,tahun_angkatan,jurusan,fakultas FROM sister_1801.view_mahasiswa
WHERE sister_1801.view_mahasiswa.tahun_angkatan = '2017';

INSERT INTO sister_rest_bot.t_kalender (nama,tgl_mulai,tgl_akhir,thn_ajar,semester,keterangan) 
SELECT k_nama,k_tanggal_mulai,k_tanggal_akhir,CONCAT(k_thn_ajar_1,'/',k_thn_ajar_2),k_ganjil_genap,k_keterangan FROM sister_1801.tbl_kalender;

INSERT INTO 
sister_rest_bot.t_frs 
(frs_id,mhs_nim,semester,pembimbing_akademik,persetujuan,id_smt,ips,sks_smt,ip,sks_total,status_aktif_mhs) 
SELECT
a.frs_id,a.mhs_nim,a.semester,CONCAT(c.nama_lengkap,', ',c.titel),a.persetujuan,a.id_smt,a.ips,a.sks_smt,a.ip,a.sks_total,a.status_aktif_mhs from 
sister_1801.tbl_frs a 
join sister_1801.tbl_mahasiswa b on a.mhs_nim = b.mhs_nim
join sister_1801.tbl_pegawai c on a.pembimbing_akademik = c.nik
WHERE a.mhs_nim LIKE '2017%' AND a.id_smt = '20181';

INSERT INTO sister_rest_bot.t_kelas
(kode_kelas,mk_kode,mk_nama,mk_sks,nama_dosen,hari,jam_mulai,jam_selesai,ruang,nm_kelas,tatap_muka,id_smt)
SELECT
a.kelas_id,d.mk_kode,d.mk_nama,c.mk_sks,CONCAT(b.nama_lengkap,', ',b.titel),a.hari,a.jam_mulai,a.jam_selesai,a.ruang,a.nm_kelas,a.tatap_muka,'20181'
FROM 
sister_1801.tbl_kelas a
JOIN sister_1801.tbl_pegawai b ON a.kode_dosen = b.nik
JOIN sister_1801.tbl_frs_matakuliah c ON a.fmk_id = c.fmk_id
JOIN sister_1801.tbl_matakuliah d ON c.mk_id = d.mk_id
WHERE c.tahun_ajaran = '2018/2019' AND c.mk_gg = 'ganjil' AND c.id_angkatan LIKE '2017%'


INSERT INTO sister_rest_bot.t_frs_items
(frs_id,kode_kelas,mhs_nim,keterangan,nilai_huruf,nilai_angka,sksn,nilai_index,jumlah_kehadiran)
SELECT
a.frs_id,a.kelas_id,a.mhs_nim,a.keterangan,nilai_huruf,nilai_angka,sksn,nilai_index,jumlah_kehadiran
FROM 
sister_1801.tbl_frs_item a
JOIN sister_1801.tbl_frs_matakuliah c ON a.fmk_id = c.fmk_id
WHERE c.tahun_ajaran = '2018/2019' AND c.mk_gg = 'ganjil' AND c.id_angkatan LIKE '2017%'