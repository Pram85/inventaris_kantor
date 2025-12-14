-- ============================================
-- SCRIPT SQL: UPDATE TRIGGER VALIDASI STOK
-- ============================================
-- File ini berisi trigger tambahan untuk keamanan ekstra
-- Eksekusi file ini jika ingin validasi di level database

-- 1. Drop trigger lama jika ada (opsional, jika ingin update)
-- DROP TRIGGER IF EXISTS `kurang_stok`;
-- DROP TRIGGER IF EXISTS `tambah_stok`;

-- 2. Buat trigger dengan validasi stok untuk BARANG KELUAR
DELIMITER $$
DROP TRIGGER IF EXISTS `validate_barang_keluar`$$
CREATE TRIGGER `validate_barang_keluar` BEFORE INSERT ON `barang_keluar` 
FOR EACH ROW 
BEGIN
    DECLARE stok_sekarang INT;
    
    -- Ambil stok saat ini
    SELECT stok INTO stok_sekarang FROM barang WHERE idbarang = NEW.barang_id;
    
    -- Validasi: Cek apakah stok mencukupi
    IF NEW.jumlah > stok_sekarang THEN
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'Error: Stok tidak mencukupi! Transaksi ditolak.';
    END IF;
    
    -- Validasi: Cek apakah jumlah valid
    IF NEW.jumlah <= 0 THEN
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'Error: Jumlah barang harus lebih dari 0!';
    END IF;
END$$
DELIMITER ;

-- 3. Trigger untuk update stok setelah barang keluar (tetap sama)
DELIMITER $$
DROP TRIGGER IF EXISTS `kurang_stok`$$
CREATE TRIGGER `kurang_stok` AFTER INSERT ON `barang_keluar` 
FOR EACH ROW 
BEGIN
    UPDATE barang SET stok = stok - NEW.jumlah WHERE idbarang = NEW.barang_id;
END$$
DELIMITER ;

-- 4. Trigger validasi untuk BARANG MASUK
DELIMITER $$
DROP TRIGGER IF EXISTS `validate_barang_masuk`$$
CREATE TRIGGER `validate_barang_masuk` BEFORE INSERT ON `barang_masuk` 
FOR EACH ROW 
BEGIN
    -- Validasi: Cek apakah jumlah valid
    IF NEW.jumlah <= 0 THEN
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'Error: Jumlah barang harus lebih dari 0!';
    END IF;
END$$
DELIMITER ;

-- 5. Trigger untuk update stok setelah barang masuk (tetap sama)
DELIMITER $$
DROP TRIGGER IF EXISTS `tambah_stok`$$
CREATE TRIGGER `tambah_stok` AFTER INSERT ON `barang_masuk` 
FOR EACH ROW 
BEGIN
    UPDATE barang SET stok = stok + NEW.jumlah WHERE idbarang = NEW.barang_id;
END$$
DELIMITER ;

-- ============================================
-- CATATAN PENTING:
-- ============================================
-- Trigger BEFORE dieksekusi sebelum data masuk ke database
-- Jika validasi gagal, transaksi akan di-ROLLBACK otomatis
-- Ini adalah "DOUBLE PROTECTION" - validasi PHP + validasi Database
-- 
-- Dengan trigger ini, bahkan jika ada bypass di PHP,
-- database akan tetap menolak transaksi yang invalid
-- ============================================
