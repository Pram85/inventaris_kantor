<?php
session_start();
include ('../config/conn.php');
include ('../config/function.php');

// Validasi level user - hanya admin yang bisa tambah transaksi
if(!isset($_SESSION['level']) || $_SESSION['level'] != 'admin'){
    $_SESSION['error'] = 'Anda tidak memiliki akses untuk melakukan aksi ini!';
    header('Location:../?barang_keluar');
    exit();
}
//proses tambah
if(isset($_POST['tambah'])){
    $barang_id = mysqli_real_escape_string($con, $_POST['barang_id']);
    $jumlah = (int)$_POST['jumlah']; // Cast to integer untuk keamanan
    $keterangan = mysqli_real_escape_string($con, $_POST['keterangan']);
    $tanggal = mysqli_real_escape_string($con, $_POST['tanggal']);

    // VALIDASI 1: Cek apakah jumlah valid (lebih dari 0)
    if($jumlah <= 0){
        $_SESSION['error'] = 'Jumlah barang harus lebih dari 0!';
        header('Location:../?barang_keluar');
        exit();
    }

    // VALIDASI 2: Cek stok barang saat ini
    $cek_stok = mysqli_query($con, "SELECT idbarang, nama_barang, stok FROM barang WHERE idbarang = '$barang_id'");
    
    if(mysqli_num_rows($cek_stok) == 0){
        $_SESSION['error'] = 'Barang tidak ditemukan!';
        header('Location:../?barang_keluar');
        exit();
    }
    
    $data_barang = mysqli_fetch_assoc($cek_stok);
    $stok_tersedia = (int)$data_barang['stok'];
    $nama_barang = $data_barang['nama_barang'];

    // VALIDASI 3: Cek apakah stok mencukupi
    if($jumlah > $stok_tersedia){
        $_SESSION['error'] = "Stok tidak mencukupi! Barang '$nama_barang' hanya tersedia $stok_tersedia unit, Anda mencoba mengeluarkan $jumlah unit.";
        header('Location:../?barang_keluar');
        exit();
    }

    // VALIDASI 4: Cek apakah stok akan menjadi minus setelah transaksi
    $sisa_stok = $stok_tersedia - $jumlah;
    if($sisa_stok < 0){
        $_SESSION['error'] = "Transaksi ditolak! Stok akan menjadi minus ($sisa_stok). Stok tersedia: $stok_tersedia";
        header('Location:../?barang_keluar');
        exit();
    }

    // Jika semua validasi lolos, proses insert
    $insert = mysqli_query($con,"INSERT INTO barang_keluar (barang_id, jumlah, keterangan, tanggal) VALUES ('$barang_id','$jumlah','$keterangan','$tanggal')");
    
    if($insert){
        // Log untuk audit trail (opsional)
        $sisa_stok_setelah = $stok_tersedia - $jumlah;
        $_SESSION['success'] = "Berhasil menambahkan barang keluar. Stok '$nama_barang' berkurang dari $stok_tersedia menjadi $sisa_stok_setelah unit.";
    }else{
        $_SESSION['error'] = 'Gagal menambahkan data barang keluar: ' . mysqli_error($con);
    }
    
    header('Location:../?barang_keluar');
    exit();
}

?>