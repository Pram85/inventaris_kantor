<?php
session_start();
include ('../config/conn.php');
include ('../config/function.php');

// Validasi level user - hanya admin yang bisa tambah/edit/hapus
if(!isset($_SESSION['level']) || $_SESSION['level'] != 'admin'){
    $_SESSION['error'] = 'Anda tidak memiliki akses untuk melakukan aksi ini!';
    header('Location:../?barang');
    exit();
}

if(isset($_POST['tambah'])){
    $nama_barang = mysqli_real_escape_string($con, $_POST['nama_barang']);
    $merek_id = (int)$_POST['merek_id'];
    $kategori_id = (int)$_POST['kategori_id'];
    $keterangan = mysqli_real_escape_string($con, $_POST['keterangan']);
    $stok = isset($_POST['stok_awal']) ? (int)$_POST['stok_awal'] : 0;
    
    // Validasi stok tidak boleh negatif
    if($stok < 0){
        $_SESSION['error'] = 'Stok awal tidak boleh negatif!';
        header('Location:../?barang');
        exit();
    }

    $insert = mysqli_query($con,"INSERT INTO barang (merek_id, kategori_id, nama_barang, keterangan, stok) VALUES ('$merek_id','$kategori_id','$nama_barang','$keterangan','$stok')") or die (mysqli_error($con));
    if($insert){
        $success = 'Berhasil menambahkan data barang';
    }else{
        $error = 'Gagal menambahkan data barang';
    }
    $_SESSION['success'] = $success;
    $_SESSION['error'] = $error;
    header('Location:../?barang');
}

if(isset($_POST['ubah'])){
    $id = $_POST['idbarang'];
    $merek_id = $_POST['merek_id'];
    $kategori_id = $_POST['kategori_id'];
    $nama_barang = $_POST['nama_barang'];
    $keterangan = $_POST['keterangan'];

    $update = mysqli_query($con,"UPDATE barang SET merek_id='$merek_id', kategori_id='$kategori_id', nama_barang='$nama_barang', keterangan='$keterangan' WHERE idbarang='$id'") or die (mysqli_error($con));
    
    // var_dump($update);die;
    if($update){
        $success = 'Berhasil mengubah data barang';
    }else{
        $error = 'Gagal mengubah data barang';
    }
    $_SESSION['success'] = $success;
    $_SESSION['error'] = $error;
    header('Location:../?barang');
}

if(decrypt($_GET['act'])=='delete' && isset($_GET['id'])!=""){
    // echo $_GET['act'];die;
    $id = decrypt($_GET['id']);
    $delete = mysqli_query($con, "DELETE FROM barang WHERE idbarang='$id'")or die(mysqli_error($con));
    if ($delete) {
        $success = "Data barang berhasil dihapus";
    }else{
        $error = "Data barang gagal dihapus";
    }
    $_SESSION['success'] = $success;
    $_SESSION['error'] = $error;
    header('Location:../?barang');
}
?>