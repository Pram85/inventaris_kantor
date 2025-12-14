<?php
session_start();
include ('../config/conn.php');
include ('../config/function.php');

// Validasi level user - hanya admin yang bisa tambah transaksi
if(!isset($_SESSION['level']) || $_SESSION['level'] != 'admin'){
    $_SESSION['error'] = 'Anda tidak memiliki akses untuk melakukan aksi ini!';
    header('Location:../?barang_masuk');
    exit();
}
//proses tambah
if(isset($_POST['tambah'])){
    $barang_id = mysqli_real_escape_string($con, $_POST['barang_id']);
    $jumlah = (int)$_POST['jumlah']; // Cast to integer untuk keamanan
    $keterangan = mysqli_real_escape_string($con, $_POST['keterangan']);
    $tanggal = mysqli_real_escape_string($con, $_POST['tanggal']);

    // VALIDASI: Cek apakah jumlah valid (lebih dari 0)
    if($jumlah <= 0){
        $_SESSION['error'] = 'Jumlah barang harus lebih dari 0!';
        header('Location:../?barang_masuk');
        exit();
    }

    // VALIDASI: Cek apakah barang ada
    $cek_barang = mysqli_query($con, "SELECT idbarang, nama_barang FROM barang WHERE idbarang = '$barang_id'");
    if(mysqli_num_rows($cek_barang) == 0){
        $_SESSION['error'] = 'Barang tidak ditemukan!';
        header('Location:../?barang_masuk');
        exit();
    }
    
    $data_barang = mysqli_fetch_assoc($cek_barang);
    $nama_barang = $data_barang['nama_barang'];

    // Proses insert
    $insert = mysqli_query($con,"INSERT INTO barang_masuk (barang_id, jumlah, keterangan, tanggal) VALUES ('$barang_id','$jumlah','$keterangan','$tanggal')");
    
    if($insert){
        $_SESSION['success'] = "Berhasil menambahkan barang masuk. Barang '$nama_barang' bertambah $jumlah unit.";
    }else{
        $_SESSION['error'] = 'Gagal menambahkan data barang masuk: ' . mysqli_error($con);
    }
    
    header('Location:../?barang_masuk');
    exit();
}

?>