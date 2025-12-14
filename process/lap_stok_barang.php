<?php
session_start();
include ('../config/conn.php');
include ('../config/function.php');
?>
<html>

<head>
    <style>
    @media print {
        @page {
            margin: 1cm;
        }
    }
    
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
    }
    
    .kop-surat {
        text-align: center;
        margin-bottom: 20px;
    }
    
    .kop-surat table {
        width: 100%;
        border: none;
    }
    
    .kop-surat td {
        border: none;
        padding: 0;
    }
    
    .logo {
        width: 80px;
        height: auto;
    }
    
    .header-text {
        text-align: center;
        line-height: 1.4;
    }
    
    .header-text h2 {
        margin: 0;
        padding: 0;
        font-size: 18pt;
        font-weight: bold;
    }
    
    .header-text h3 {
        margin: 0;
        padding: 0;
        font-size: 16pt;
        font-weight: bold;
    }
    
    .header-text p {
        margin: 2px 0;
        font-size: 10pt;
    }
    
    .garis-tebal {
        border-top: 3px solid #000;
        border-bottom: 1px solid #000;
        height: 3px;
        margin: 10px 0;
    }
    
    .info-surat {
        margin: 20px 0;
        font-size: 11pt;
    }
    
    .judul-laporan {
        text-align: center;
        margin: 20px 0;
        font-weight: bold;
        font-size: 14pt;
        text-decoration: underline;
    }
    
    table.data {
        border-collapse: collapse;
        border: 1px solid #000;
        font-size: 10pt;
        width: 100%;
        margin: 20px 0;
    }
    
    table.data th,
    table.data td {
        border: 1px solid #000;
        padding: 5px;
    }
    
    table.data th {
        background-color: #f0f0f0;
        font-weight: bold;
    }
    
    .stok-habis {
        background-color: #ffcccc;
        font-weight: bold;
    }
    
    .stok-menipis {
        background-color: #fff4cc;
    }
    
    .ttd-section {
        margin-top: 40px;
        text-align: right;
    }
    
    .ttd-box {
        display: inline-block;
        text-align: center;
        min-width: 200px;
    }
    
    .footer-info {
        margin-top: 50px;
        font-size: 9pt;
        color: #666;
    }
    </style>
    <title>Cetak Laporan Stok Barang</title>
</head>

<body>
    <?php
    $query = mysqli_query($con,"SELECT x.*,x1.nama_merek,x2.nama_kategori FROM barang x JOIN merek x1 ON x1.idmerek=x.merek_id JOIN kategori x2 ON x2.idkategori=x.kategori_id ORDER BY x.idbarang DESC")or die(mysqli_error($con));
    
    // Generate nomor surat
    $nomor_surat = '005/INV-ST/DISDUKCAPIL/' . strtoupper(bulan_romawi(date('m'))) . '/' . date('Y');
    $tanggal_cetak = date('d') . ' ' . bulan_indonesia(date('m')) . ' ' . date('Y');
    ?>
    
    <!-- KOP SURAT -->
    <div class="kop-surat">
        <table>
            <tr>
                <td width="80" style="vertical-align: middle;">
                    <img src="../assets/img/dispenduk.png" class="logo" alt="Logo">
                </td>
                <td style="vertical-align: middle;">
                    <div class="header-text">
                        <h2>PEMERINTAH KABUPATEN NGAWI</h2>
                        <h3>DINAS KEPENDUDUKAN DAN PENCATATAN SIPIL</h3>
                        <p>Jl. Ahmad Yani No. 23 Ngawi 63219</p>
                        <p>Telp. (0351) 748712 | Email: disdukcapil@ngawikab.go.id</p>
                        <p>Website: www.ngawikab.go.id</p>
                    </div>
                </td>
                <td width="80"></td>
            </tr>
        </table>
    </div>
    <div class="garis-tebal"></div>
    
    <!-- INFO SURAT -->
    <div class="info-surat">
        <table style="border: none; width: 100%;">
            <tr>
                <td style="border: none; width: 20%;">Nomor</td>
                <td style="border: none; width: 2%;">:</td>
                <td style="border: none;"><?= $nomor_surat; ?></td>
            </tr>
            <tr>
                <td style="border: none;">Perihal</td>
                <td style="border: none;">:</td>
                <td style="border: none;"><strong>Laporan Stok Barang</strong></td>
            </tr>
        </table>
    </div>
    
    <!-- JUDUL LAPORAN -->
    <div class="judul-laporan">
        LAPORAN STOK BARANG<br>
        <span style="font-size: 12pt;">PER TANGGAL: <?= strtoupper($tanggal_cetak); ?></span>
    </div>
    
    <div style="page-break-after:always;">
        <table class="data">
            <thead>
                <tr>
                    <th width="30">NO</th>
                    <th>NAMA BARANG</th>
                    <th>MEREK</th>
                    <th>KATEGORI</th>
                    <th>KETERANGAN</th>
                    <th width="80">STOK</th>
                    <th width="100">STATUS</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $n=1; 
                $total_stok = 0;
                $stok_habis = 0;
                $stok_menipis = 0;
                while($row = mysqli_fetch_array($query)): 
                    $total_stok += $row['stok'];
                    $class = '';
                    $status = 'Aman';
                    
                    if($row['stok'] == 0){
                        $class = 'stok-habis';
                        $status = 'HABIS';
                        $stok_habis++;
                    } elseif($row['stok'] <= 5){
                        $class = 'stok-menipis';
                        $status = 'Menipis';
                        $stok_menipis++;
                    }
                ?>
                <tr class="<?= $class; ?>">
                    <td align="center"><?= $n++; ?></td>
                    <td><?= $row['nama_barang']; ?></td>
                    <td><?= $row['nama_merek']; ?></td>
                    <td><?= $row['nama_kategori']; ?></td>
                    <td><?= $row['keterangan']; ?></td>
                    <td align="center"><strong><?= $row['stok']; ?></strong></td>
                    <td align="center"><?= $status; ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="5" style="text-align: right;">TOTAL STOK:</th>
                    <th style="text-align: center;"><?= $total_stok; ?></th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
        
        <!-- RINGKASAN STOK -->
        <div style="margin: 20px 0; padding: 10px; background-color: #f5f5f5; border: 1px solid #ddd;">
            <strong>RINGKASAN STATUS STOK:</strong><br>
            <table style="border: none; margin-top: 10px; width: 100%;">
                <tr>
                    <td style="border: none;">🔴 Stok Habis (0)</td>
                    <td style="border: none;">: <strong><?= $stok_habis; ?></strong> item</td>
                    <td style="border: none;">🟡 Stok Menipis (≤5)</td>
                    <td style="border: none;">: <strong><?= $stok_menipis; ?></strong> item</td>
                </tr>
            </table>
        </div>
        
        <!-- TTD SECTION -->
        <div class="ttd-section">
            <div class="ttd-box">
                <p>Ngawi, <?= $tanggal_cetak; ?><br>
                Kepala Dinas Kependudukan<br>
                dan Pencatatan Sipil<br>
                Kabupaten Ngawi</p>
                <div style="height: 80px;"></div>
                <p><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></p>
            </div>
        </div>
        
        <!-- FOOTER INFO -->
        <div class="footer-info">
            <hr>
            <p style="text-align: right; margin: 0;">Waktu Cetak: <strong><?= date('d-m-Y H:i:s'); ?></strong></p>
        </div>
    </div>
</body>

</html>

<script>
window.print();
</script>