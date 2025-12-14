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
    <title>Cetak Laporan Barang Masuk</title>
</head>

<body>
    <?php
    $tgl_awal = $_POST['tanggal_awal'];
    $tgl_akhir = $_POST['tanggal_akhir'];
    $query = mysqli_query($con,"SELECT x.*,x1.nama_barang,x2.nama_merek,x3.nama_kategori FROM barang_masuk x JOIN barang x1 ON x1.idbarang=x.barang_id JOIN merek x2 ON x2.idmerek=x1.merek_id JOIN kategori x3 ON x3.idkategori=x1.kategori_id WHERE x.tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY x.idbarang_masuk DESC")or die(mysqli_error($con));
    
    // Generate nomor surat
    $nomor_surat = '005/INV-BM-P/DISDUKCAPIL/' . strtoupper(bulan_romawi(date('m'))) . '/' . date('Y');
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
                <td style="border: none;"><strong>Laporan Barang Masuk Periode</strong></td>
            </tr>
        </table>
    </div>
    
    <!-- JUDUL LAPORAN -->
    <div class="judul-laporan">
        LAPORAN BARANG MASUK<br>
        <span style="font-size: 12pt;">PERIODE: <?= strtoupper(date('d-m-Y',strtotime($tgl_awal))); ?> s/d <?= strtoupper(date('d-m-Y',strtotime($tgl_akhir))); ?></span>
    </div>
    
    <div style="page-break-after:always;">
        <table class="data">
            <thead>
                <tr>
                    <th width="30">NO</th>
                    <th width="100">TANGGAL</th>
                    <th>NAMA BARANG</th>
                    <th>MEREK</th>
                    <th>KATEGORI</th>
                    <th>KETERANGAN</th>
                    <th width="60">JUMLAH</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $n=1; 
                $total = 0;
                $count = mysqli_num_rows($query);
                if($count > 0){
                    while($row = mysqli_fetch_array($query)): 
                        $total += $row['jumlah'];
                ?>
                <tr>
                    <td align="center"><?= $n++; ?></td>
                    <td align="center"><?= date('d-m-Y',strtotime($row['tanggal'])); ?></td>
                    <td><?= $row['nama_barang']; ?></td>
                    <td><?= $row['nama_merek']; ?></td>
                    <td><?= $row['nama_kategori']; ?></td>
                    <td><?= $row['keterangan']; ?></td>
                    <td align="center"><?= $row['jumlah']; ?></td>
                </tr>
                <?php 
                    endwhile;
                } else {
                ?>
                <tr>
                    <td colspan="7" align="center" style="padding: 20px; color: #999;">
                        <em>Tidak ada data barang masuk pada periode ini</em>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
            <?php if($count > 0){ ?>
            <tfoot>
                <tr>
                    <th colspan="6" style="text-align: right;">TOTAL BARANG MASUK:</th>
                    <th style="text-align: center;"><?= $total; ?></th>
                </tr>
            </tfoot>
            <?php } ?>
        </table>
        
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