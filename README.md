# 📦 Sistem Inventaris Barang DISDUKCAPIL Kabupaten Ngawi

Aplikasi web untuk mengelola inventaris barang pada Dinas Kependudukan dan Pencatatan Sipil (DISDUKCAPIL) Kabupaten Ngawi. Sistem ini memudahkan pencatatan, monitoring, dan pelaporan barang masuk dan keluar dengan fitur validasi stok otomatis.

![PHP Version](https://img.shields.io/badge/PHP-7.3.33-blue)
![MySQL](https://img.shields.io/badge/MySQL-10.4.22-orange)
![Bootstrap](https://img.shields.io/badge/Bootstrap-4-purple)
![License](https://img.shields.io/badge/License-MIT-green)

---

## 📋 Daftar Isi

- [Fitur Utama](#-fitur-utama)
- [Teknologi](#-teknologi)
- [Persyaratan Sistem](#-persyaratan-sistem)
- [Instalasi](#-instalasi)
- [Konfigurasi](#-konfigurasi)
- [Penggunaan](#-penggunaan)
- [Struktur Project](#-struktur-project)
- [Database](#-database)
- [Fitur Keamanan](#-fitur-keamanan)
- [Screenshot](#-screenshot)
- [Kontribusi](#-kontribusi)
- [Lisensi](#-lisensi)

---

## ✨ Fitur Utama

### 🔐 Multi-Level Access Control
- **Admin**: Akses penuh (CRUD semua data, cetak laporan)
- **Staff**: Akses terbatas (view data, cetak laporan saja)
- Session timeout otomatis (30 menit)
- Password terenkripsi dengan bcrypt

### 📊 Master Data Management
- **Barang**: Kelola data barang dengan stok awal
- **Kategori**: Klasifikasi barang berdasarkan jenis
- **Merek**: Pengelompokan barang berdasarkan merek
- **Pengguna**: Manajemen user dan role

### 🔄 Transaksi
- **Barang Masuk**: Pencatatan barang yang masuk dengan auto-increment stok
- **Barang Keluar**: Pencatatan barang keluar dengan validasi stok
- **Validasi Real-time**: Sistem mencegah stok minus dengan 3 layer validasi:
  - Frontend validation (JavaScript)
  - Backend validation (PHP)
  - Database trigger (MySQL)

### 📑 Sistem Pelaporan Profesional
- Kop surat resmi DISDUKCAPIL Kabupaten Ngawi
- Format nomor surat otomatis (005/INV-XX/DISDUKCAPIL/ROMAWI/TAHUN)
- TTD section dengan ruang tanda tangan manual
- Timestamp cetak otomatis
- Export ke Excel (.xls)

**Jenis Laporan:**
1. Laporan Stok Barang (real-time)
2. Laporan Barang Masuk (periode & filter)
3. Laporan Barang Keluar (periode & filter)
4. Cetak Barang Masuk Hari Ini
5. Cetak Barang Keluar Hari Ini

### 🎨 User Interface
- Dashboard responsive dengan Bootstrap 4
- Gradient header biru (kondisional per halaman)
- Logo DISDUKCAPIL dengan animasi pulse
- DataTables untuk tabel interaktif
- Select2 untuk dropdown pencarian
- SweetAlert2 untuk notifikasi user-friendly
- Sidebar navigasi dengan icon Font Awesome

### 🔍 Filter & Pencarian
- Filter laporan berdasarkan:
  - Tanggal (range)
  - Bulan & Tahun
  - Kategori
  - Merek
- Pencarian real-time dengan DataTables
- Export hasil filter ke Excel

---

## 🛠 Teknologi

### Backend
- **PHP 7.3.33**: Server-side scripting
- **MySQL 10.4.22 (MariaDB)**: Database relasional
- **MySQLi Extension**: Database connector

### Frontend
- **Bootstrap 4**: CSS framework
- **jQuery 3.x**: JavaScript library
- **DataTables**: Tabel interaktif
- **Select2**: Enhanced select boxes
- **SweetAlert2**: Beautiful alerts
- **Font Awesome 5**: Icon library
- **jQuery Mask**: Input masking
- **jQuery Easing**: Smooth animations

### Template
- **SB Admin 2**: Admin dashboard template

---

## ⚙️ Persyaratan Sistem

- **Web Server**: Apache 2.4+ (XAMPP/WAMP/LAMP)
- **PHP**: 7.3.33 atau lebih tinggi
- **MySQL**: 5.7+ atau MariaDB 10.4+
- **Browser**: Chrome, Firefox, Edge (versi terbaru)
- **RAM**: Minimal 512 MB
- **Storage**: Minimal 100 MB free space

---

## 📥 Instalasi

### 1. Clone Repository
```bash
git clone https://github.com/Pram85/inventaris_kantor.git
cd inventaris_kantor
```

### 2. Setup Web Server (XAMPP)
1. Copy folder project ke `C:\xampp\htdocs\inventaris_kantor`
2. Start Apache dan MySQL dari XAMPP Control Panel

### 3. Import Database
1. Buka phpMyAdmin: `http://localhost/phpmyadmin`
2. Create database baru: `inventaris`
3. Import file: `database/inventaris.sql`
4. Database akan otomatis terisi data sample

### 4. Konfigurasi Database
Edit file `config/conn.php`:
```php
<?php
$con = mysqli_connect('localhost', 'root', '', 'inventaris');
if(!$con){
    die('Koneksi gagal: ' . mysqli_connect_error());
}
?>
```

### 5. Akses Aplikasi
Buka browser dan akses: `http://localhost/inventaris_kantor`

---

## 🔧 Konfigurasi

### Login Credentials
```
Admin:
Username: admin
Password: admin

Staff:
Username: staff  
Password: staff
```

### Database Triggers (Optional)
Untuk keamanan ekstra, aktifkan trigger validasi stok:
```sql
-- Lihat file: database/trigger_validasi_stok.sql
SOURCE database/trigger_validasi_stok.sql;
```

### Session Timeout
Default: 30 menit (1800 detik)
Edit di `config/function.php`:
```php
function session_timeout(){
    if(isset($_SESSION['LAST_ACTIVITY'])&&(time()-$_SESSION['LAST_ACTIVITY']>1800)){
        // 1800 = 30 menit, ubah sesuai kebutuhan
    }
}
```

---

## 📖 Penggunaan

### Login
1. Akses halaman login
2. Masukkan username dan password
3. Sistem akan redirect ke dashboard sesuai role

### Tambah Barang Baru
1. Menu **Master** → **Barang**
2. Klik tombol **Tambah Data**
3. Isi form:
   - Nama Barang
   - Merek (dropdown)
   - Kategori (dropdown)
   - Keterangan
   - **Stok Awal** (khusus barang baru)
4. Simpan

### Transaksi Barang Masuk
1. Menu **Transaksi** → **Barang Masuk**
2. Klik **Tambah Data**
3. Pilih barang, tanggal, jumlah
4. Sistem otomatis menambah stok

### Transaksi Barang Keluar
1. Menu **Transaksi** → **Barang Keluar**
2. Klik **Tambah Data**
3. Pilih barang (stok tersedia ditampilkan)
4. Masukkan jumlah
5. **Validasi otomatis**:
   - Jika jumlah > stok → Error, transaksi ditolak
   - Jika valid → Stok berkurang otomatis

### Generate Laporan
1. Menu **Laporan** → Pilih jenis laporan
2. Tentukan filter (tanggal/bulan/tahun)
3. Pilih kategori/merek (optional)
4. Klik **Tampilkan** atau **Export Excel**
5. Untuk print: Klik **Cetak** (auto print dialog)

---

## 📁 Struktur Project

```
inventaris_kantor/
│
├── assets/                      # Asset statis
│   ├── css/                     # Custom styles
│   │   ├── custom-style.css
│   │   └── sb-admin-2.min.css
│   ├── img/                     # Gambar & logo
│   │   └── dispenduk.png        # Logo DISDUKCAPIL
│   ├── js/                      # JavaScript files
│   │   ├── demo/
│   │   └── sb-admin-2.min.js
│   └── vendor/                  # Libraries pihak ketiga
│       ├── bootstrap/
│       ├── datatables/
│       ├── fontawesome-free/
│       ├── jquery/
│       ├── select2/
│       └── sweet-alert/
│
├── config/                      # Konfigurasi aplikasi
│   ├── conn.php                 # Database connection
│   ├── function.php             # Helper functions
│   ├── header.php               # HTML head & assets
│   ├── footer.php               # Footer & scripts
│   ├── topbar.php               # Top navigation bar
│   ├── sidebar.php              # Left sidebar menu
│   └── page.php                 # Page routing
│
├── database/                    # Database files
│   ├── inventaris.sql           # Database structure & data
│   └── trigger_validasi_stok.sql # Optional triggers
│
├── process/                     # Backend processing
│   ├── barang.php               # CRUD barang
│   ├── barang_masuk.php         # Transaksi masuk
│   ├── barang_keluar.php        # Transaksi keluar
│   ├── kategori.php             # CRUD kategori
│   ├── merek.php                # CRUD merek
│   ├── users.php                # CRUD users
│   ├── lap_stok_barang.php      # Laporan stok
│   ├── lap_barang_masuk.php     # Laporan masuk (filter)
│   ├── lap_barang_keluar.php    # Laporan keluar (filter)
│   ├── cetak_barang_masuk.php   # Cetak masuk (periode)
│   ├── cetak_barang_keluar.php  # Cetak keluar (periode)
│   ├── cetak_barang_masuk_today.php
│   ├── cetak_barang_keluar_today.php
│   ├── view_barang.php          # View detail barang
│   ├── view_user.php            # View detail user
│   └── logout.php               # Logout handler
│
├── views/                       # View files
│   ├── home.php                 # Dashboard
│   ├── master/                  # Master data views
│   │   ├── barang.php
│   │   ├── kategori.php
│   │   ├── merek.php
│   │   └── pengguna.php
│   ├── transaksi/               # Transaction views
│   │   ├── barang_masuk.php
│   │   └── barang_keluar.php
│   └── laporan/                 # Report views
│       ├── lap_barang_masuk.php
│       └── lap_barang_keluar.php
│
├── index.php                    # Main entry point
├── login.php                    # Login page
└── README.md                    # Dokumentasi ini
```

---

## 🗄️ Database

### Tabel Utama

#### 1. **barang**
```sql
- idbarang (PK, INT, AUTO_INCREMENT)
- merek_id (FK, INT)
- kategori_id (FK, INT)
- nama_barang (VARCHAR 128)
- keterangan (VARCHAR 256)
- stok (INT) -- Stok saat ini
```

#### 2. **barang_masuk**
```sql
- idbarang_masuk (PK, INT, AUTO_INCREMENT)
- barang_id (FK, INT)
- tanggal (DATE)
- jumlah (INT)
- keterangan (VARCHAR 256)
```

#### 3. **barang_keluar**
```sql
- idbarang_keluar (PK, INT, AUTO_INCREMENT)
- barang_id (FK, INT)
- tanggal (DATE)
- jumlah (INT)
- keterangan (VARCHAR 256)
```

#### 4. **kategori**
```sql
- idkategori (PK, INT, AUTO_INCREMENT)
- nama_kategori (VARCHAR 50)
- keterangan (VARCHAR 128)
```

#### 5. **merek**
```sql
- idmerek (PK, INT, AUTO_INCREMENT)
- nama_merek (VARCHAR 50)
```

#### 6. **users**
```sql
- id_users (PK, INT, AUTO_INCREMENT)
- username (VARCHAR 50)
- password (VARCHAR 256) -- Bcrypt hashed
- nama (VARCHAR 128)
- level (ENUM: 'admin', 'staff')
```

### Database Triggers

#### Trigger: `kurang_stok`
```sql
-- Otomatis kurangi stok saat barang keluar
AFTER INSERT ON barang_keluar
```

#### Trigger: `tambah_stok`
```sql
-- Otomatis tambah stok saat barang masuk
AFTER INSERT ON barang_masuk
```

#### Trigger: `validate_barang_keluar` (Optional)
```sql
-- Validasi stok sebelum insert barang keluar
BEFORE INSERT ON barang_keluar
```

---

## 🔒 Fitur Keamanan

### 1. Authentication
- Session-based authentication
- Password hashing dengan `password_hash()` (bcrypt)
- Session timeout 30 menit

### 2. Authorization
- Role-based access control (RBAC)
- Function `hakAkses()` untuk proteksi halaman
- Staff tidak bisa akses CRUD

### 3. Input Validation
- **Frontend**: JavaScript validation
- **Backend**: PHP validation & sanitization
- `mysqli_real_escape_string()` untuk prevent SQL injection
- Type casting untuk data numerik

### 4. Stock Validation (3 Layer)
```
Layer 1: JavaScript (Real-time feedback)
   ↓
Layer 2: PHP Backend (Server-side check)
   ↓
Layer 3: Database Trigger (Final safeguard)
```

### 5. Session Security
- Regenerate session ID setelah login
- Unset semua session variable saat logout
- Session timeout otomatis

---

## 🖼️ Screenshot

### Login Page
Interface login dengan form username dan password.

### Dashboard (Beranda)
- Header gradient dengan logo DISDUKCAPIL
- Quick stats: Total Barang, Kategori, Merek
- Welcome message sesuai role user

### Master Barang
- DataTables dengan search, sort, pagination
- Form tambah/edit dengan Select2
- Field stok awal khusus untuk barang baru

### Transaksi Barang Keluar
- Real-time stock validation
- SweetAlert confirmation
- Disabled submit button jika stok tidak cukup

### Laporan Professional
- Kop surat resmi dengan logo
- Header instansi lengkap
- Nomor surat otomatis
- Ruang TTD manual
- Footer dengan timestamp

---

## 🤝 Kontribusi

Kontribusi sangat diterima! Berikut langkah-langkahnya:

1. Fork repository ini
2. Create branch baru: `git checkout -b fitur-baru`
3. Commit changes: `git commit -m 'Tambah fitur baru'`
4. Push ke branch: `git push origin fitur-baru`
5. Submit Pull Request

### Aturan Kontribusi
- Ikuti coding standard PHP (PSR-12)
- Tambahkan komentar untuk kode kompleks
- Test semua perubahan sebelum PR
- Update README jika menambah fitur baru

---

## 📞 Support

Jika menemukan bug atau ada pertanyaan:
- **GitHub Issues**: [Create Issue](https://github.com/Pram85/inventaris_kantor/issues)
- **Email**: disdukcapil@ngawikab.go.id

---

## 📝 Changelog

### Version 2.0 (Current)
- ✅ Multi-level access control (admin/staff)
- ✅ Stock validation system (3-layer)
- ✅ Master barang dengan stok awal
- ✅ Professional report dengan kop surat
- ✅ Conditional header display
- ✅ Filter & export Excel
- ✅ UI/UX improvements

### Version 1.0
- Basic CRUD operations
- Simple reporting
- Single user level

---

## 📜 Lisensi

Aplikasi ini dilisensikan di bawah **MIT License**.

```
MIT License

Copyright (c) 2024 DISDUKCAPIL Kabupaten Ngawi

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
```

---

## 🙏 Credits

- **Developer**: Pram85
- **Organization**: DISDUKCAPIL Kabupaten Ngawi
- **Template**: [SB Admin 2](https://startbootstrap.com/theme/sb-admin-2)
- **Icons**: [Font Awesome](https://fontawesome.com)
- **UI Framework**: [Bootstrap 4](https://getbootstrap.com)

---

## 📌 Notes

- Aplikasi ini dikembangkan khusus untuk DISDUKCAPIL Kabupaten Ngawi
- Untuk production, pastikan ganti password default
- Enable HTTPS untuk keamanan lebih baik
- Backup database secara berkala
- Test semua fitur sebelum deployment

---

<div align="center">

**Dibuat dengan ❤️ untuk DISDUKCAPIL Kabupaten Ngawi**

[⬆ Kembali ke atas](#-sistem-inventaris-barang-disdukcapil-kabupaten-ngawi)

</div>
