<?php
session_start();
include ('../config/conn.php');
include ('../config/function.php');

// Validasi level user - hanya admin yang bisa tambah/hapus
if(!isset($_SESSION['level']) || $_SESSION['level'] != 'admin'){
    $_SESSION['error'] = 'Anda tidak memiliki akses untuk melakukan aksi ini!';
    header('Location:../?kategori');
    exit();
}
//proses tambah
if(isset($_POST['tambah'])){
    $nama_kategori = $_POST['nama_kategori'];
    $keterangan = $_POST['keterangan'];

    
    $insert = mysqli_query($con,"INSERT INTO kategori (nama_kategori, keterangan) VALUES ('$nama_kategori','$keterangan')") or die (mysqli_error($con));
    if($insert){
        $success = 'Berhasil menambahkan data kategori';
    }else{
        $error = 'Gagal menambahkan data kategori';
    }
    $_SESSION['success'] = $success;
    $_SESSION['error'] = $error;
    header('Location:../?kategori');
}
//proses hapus
if(decrypt($_GET['act'])=='delete' && isset($_GET['id'])!=""){
    $id = decrypt($_GET['id']);
    $query = mysqli_query($con, "DELETE FROM kategori WHERE idkategori='$id'")or die(mysqli_error($con));
    if($query){
        $success = 'Berhasil menghapus data kategori';
    }else{
        $error = 'Gagal menghapus data kategori';
    }
    $_SESSION['success'] = $success;
    $_SESSION['error'] = $error;
    header('Location:../?kategori');
}

?>