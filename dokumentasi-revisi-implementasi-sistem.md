# Dokumentasi Revisi 4.1.4 Implementasi Sistem

Dokumen ini dibuat sebagai panduan untuk mengerjakan revisi bagian **4.1.4 Implementasi Sistem** pada laporan proyek Sistem Informasi Manajemen Mudain.

## Arahan Revisi

Catatan revisi:

> Untuk source code, untuk yang pakai UML (use case, class, activity), tampilkan source code sesuai class. Jangan di-screenshot atau copy paste begitu saja. Source code harus dirapikan dengan shape/kotak seperti contoh.

Artinya, bagian implementasi sistem tidak cukup hanya menampilkan screenshot halaman atau source code panjang tanpa konteks. Source code yang ditampilkan harus disesuaikan dengan rancangan UML pada Bab III, yaitu:

- Use Case Diagram
- Activity Diagram
- Class Diagram

Source code sebaiknya ditempel sebagai teks di dalam shape/kotak dengan border, seperti contoh revisi dari dosen.

## Format Penulisan

Gunakan format berikut untuk setiap source code:

1. Judul gambar/source code
   
   Contoh: `Gambar 4.xx Source Code Model User`

2. Deskripsi singkat sebelum source code
   
   Contoh:
   
   `Source code berikut merupakan implementasi class User yang digunakan untuk menyimpan data pengguna dan mengatur relasi pengguna dengan role.`

3. Kotak/shape berisi source code
   
   Ambil bagian penting saja. Tidak perlu seluruh file jika terlalu panjang.

4. Penjelasan setelah source code
   
   Jelaskan fungsi class atau method tersebut dalam sistem.

## Contoh Kalimat Pembuka 4.1.4

Implementasi sistem merupakan tahap penerapan rancangan UML ke dalam bentuk source code program. Pada bagian ini, source code yang ditampilkan disesuaikan dengan rancangan use case diagram, activity diagram, dan class diagram yang telah dibuat pada Bab III. Source code yang digunakan berasal dari model, controller, dan middleware pada framework Laravel.

Source code model digunakan untuk merepresentasikan class diagram, sedangkan source code controller dan middleware digunakan untuk menjelaskan proses yang terdapat pada use case dan activity diagram, seperti login, manajemen data, transaksi, produksi, keuangan, laporan, hak akses, dan pengelolaan konten.

## A. Source Code Berdasarkan Class Diagram Domain Utama

Bagian ini berisi source code model utama yang menggambarkan entitas dalam sistem.

| No | File | Bagian yang Dicopy | Deskripsi |
|---|---|---|---|
| 1 | `app/Models/User.php` | `class User`, `$fillable`, `$hidden`, `$casts`, `hasPermission()`, `role()` | File ini digunakan untuk merepresentasikan data pengguna sistem. Class `User` menyimpan data seperti nama, username, email, password, role, telepon, alamat, dan status. Method `hasPermission()` digunakan untuk mengecek apakah pengguna memiliki izin akses tertentu, sedangkan method `role()` menunjukkan relasi user dengan role. |
| 2 | `app/Models/Role.php` | `class Role`, `$fillable`, `$casts` | File ini digunakan untuk mengatur role atau hak akses pengguna. Atribut `permissions` digunakan untuk menyimpan daftar izin akses setiap role. Cast `permissions` menjadi array memudahkan sistem membaca permission pengguna. |
| 3 | `app/Models/Produk.php` | `class Produk`, `$fillable`, `kategori()`, `satuan()`, `supplier()`, `pembelianDetails()`, `penjualanDetails()` | File ini merepresentasikan data produk operasional. Produk memiliki atribut seperti kode barang, nama item, kategori, satuan, supplier, harga beli, harga jual, dan stok. Relasi di dalam file ini menunjukkan bahwa produk berhubungan dengan kategori, satuan, supplier, transaksi pembelian, dan transaksi penjualan. |
| 4 | `app/Models/Kategori.php` | `class Kategori`, atribut utama, relasi jika ada | File ini digunakan untuk menyimpan kategori produk. Kategori membantu mengelompokkan produk agar data barang lebih terstruktur. |
| 5 | `app/Models/Satuan.php` | `class Satuan`, atribut utama, relasi jika ada | File ini digunakan untuk menyimpan satuan produk, seperti pcs, lusin, meter, dan sebagainya. Data satuan digunakan pada produk agar informasi barang lebih jelas. |
| 6 | `app/Models/Supplier.php` | `class Supplier`, atribut utama, relasi jika ada | File ini merepresentasikan data supplier atau pemasok. Supplier digunakan dalam proses pembelian barang dan terhubung dengan data produk maupun transaksi pembelian. |
| 7 | `app/Models/Customer.php` | `class Customer`, atribut utama, relasi jika ada | File ini merepresentasikan data customer atau pelanggan. Data customer digunakan dalam transaksi penjualan untuk mencatat siapa pelanggan yang melakukan pembelian. |
| 8 | `app/Models/Stok.php` | `class Stok`, `$fillable`, `produk()`, `user()` | File ini digunakan untuk mencatat riwayat stok masuk dan stok keluar. Class ini terhubung dengan produk dan user sehingga setiap perubahan stok dapat diketahui barangnya dan siapa pengguna yang melakukan proses tersebut. |
| 9 | `app/Models/Kas.php` | `class Kas`, `$table`, `$guarded`, `user()`, `getDynamicKas()`, `getDynamicLabaRugi()` | File ini merepresentasikan data kas dan keuangan. Method `getDynamicKas()` digunakan untuk menggabungkan data kas dari penjualan, pembelian, cicilan piutang, cicilan hutang, dan kas manual. Method `getDynamicLabaRugi()` digunakan untuk menghitung data laba rugi berdasarkan pemasukan dan pengeluaran. |

## B. Source Code Berdasarkan Class Diagram Transaksi dan Keuangan

Bagian ini menampilkan source code model yang berhubungan dengan transaksi penjualan, pembelian, hutang, piutang, dan keuangan.

| No | File | Bagian yang Dicopy | Deskripsi |
|---|---|---|---|
| 1 | `app/Models/Penjualan.php` | `class Penjualan`, `$fillable`, `$appends`, `user()`, `customer()`, `details()`, `riwayat_pembayarans()`, `getAverageProgressAttribute()` | File ini merepresentasikan transaksi penjualan. Class ini menyimpan invoice, user, customer, total harga, pembayaran, status pembayaran, dan data desain. Method `getAverageProgressAttribute()` digunakan untuk menghitung rata-rata progress produksi dari detail penjualan. |
| 2 | `app/Models/PenjualanDetail.php` | `class PenjualanDetail`, `operator()`, `penjualan()`, `produk()`, `servis()` | File ini menyimpan detail item dalam transaksi penjualan. Setiap detail dapat berupa produk atau servis. File ini juga berkaitan dengan progress produksi karena detail penjualan menjadi dasar update produksi. |
| 3 | `app/Models/Pembelian.php` | `class Pembelian`, `$fillable`, `supplier()`, `user()`, `penjualan()`, `details()`, `riwayat_pembayarans()` | File ini merepresentasikan transaksi pembelian kepada supplier. Data yang disimpan meliputi faktur, tanggal faktur, supplier, penjualan terkait, total harga, diskon, pembayaran, sisa hutang, dan status pembayaran. |
| 4 | `app/Models/PembelianDetail.php` | `class PembelianDetail`, atribut dan relasi utama | File ini menyimpan rincian barang dalam transaksi pembelian. Data yang dicatat meliputi produk, harga beli, harga jual, jumlah, dan subtotal. |
| 5 | `app/Models/RiwayatPembayaranPenjualan.php` | class dan atribut utama | File ini digunakan untuk mencatat riwayat pembayaran piutang dari transaksi penjualan. Data ini penting untuk mengetahui cicilan pembayaran customer. |
| 6 | `app/Models/RiwayatPembayaranPembelian.php` | class dan atribut utama | File ini digunakan untuk mencatat riwayat pembayaran hutang kepada supplier. Data ini membantu sistem menghitung sisa hutang pembelian. |

## C. Source Code Berdasarkan Use Case Login dan Hak Akses

Bagian ini berhubungan dengan use case login, logout, role, permission, dan pembatasan akses menu.

| No | File | Bagian yang Dicopy | Deskripsi |
|---|---|---|---|
| 1 | `app/Http/Controllers/Auth/AuthenticatedSessionController.php` | `store()` dan `destroy()` | Method `store()` digunakan untuk memproses login pengguna berdasarkan username/email dan password. Jika data valid, sistem membuat session login. Method `destroy()` digunakan untuk logout dengan menghapus session pengguna. |
| 2 | `app/Http/Middleware/CheckPermission.php` | `handle()` | Middleware ini digunakan untuk mengecek apakah user memiliki permission terhadap menu tertentu. Jika user tidak memiliki izin, sistem akan menolak akses dan menampilkan halaman 403. |
| 3 | `app/Http/Middleware/LogActivity.php` | `handle()` | Middleware ini digunakan untuk mencatat aktivitas pengguna di dalam sistem. Source code ini sesuai dengan activity diagram histori pengguna karena setiap aktivitas penting dapat direkam sebagai histori. |
| 4 | `app/Http/Controllers/Admin/UserController.php` | `role()`, `storeRole()`, `updateRole()`, `pengguna()`, `storePengguna()`, `histori()` | Controller ini digunakan untuk manajemen role, manajemen pengguna, dan histori aktivitas. Source code ini mewakili activity diagram manajemen role, pengguna, dan melihat histori pengguna. |

## D. Source Code Berdasarkan Activity Diagram Master Data

Bagian ini berisi controller untuk proses tambah, ubah, hapus, import, dan export data master.

| No | File | Bagian yang Dicopy | Deskripsi |
|---|---|---|---|
| 1 | `app/Http/Controllers/Admin/ProductController.php` | `index()`, `store()`, `update()`, `destroy()`, `importExcel()` | Controller ini digunakan untuk mengelola data produk. Method `store()` menyimpan produk baru, `update()` mengubah data produk, `destroy()` menghapus produk, dan `importExcel()` mengimpor data produk dari file Excel. |
| 2 | `app/Http/Controllers/Admin/KategoriController.php` | `index()`, `store()`, `update()`, `destroy()` | Controller ini digunakan untuk mengelola kategori produk. Source code ini sesuai dengan activity diagram manajemen kategori produk. |
| 3 | `app/Http/Controllers/Admin/SatuanController.php` | `index()`, `store()`, `update()`, `destroy()` | Controller ini digunakan untuk mengelola satuan produk. Source code ini sesuai dengan activity diagram manajemen satuan produk. |
| 4 | `app/Http/Controllers/Admin/SupplierController.php` | `index()`, `store()`, `update()`, `destroy()`, `exportPdf()`, `importExcel()` | Controller ini digunakan untuk manajemen supplier. Selain CRUD, controller ini juga memiliki proses import Excel dan export PDF. |
| 5 | `app/Http/Controllers/Admin/CustomerController.php` | `index()`, `store()`, `update()`, `destroy()`, `exportPdf()`, `importExcel()` | Controller ini digunakan untuk manajemen customer. Data customer digunakan dalam proses transaksi penjualan. |
| 6 | `app/Http/Controllers/Admin/ServisController.php` | `index()`, `store()`, `update()`, `destroy()` | Controller ini digunakan untuk mengelola data servis atau layanan yang dapat dimasukkan dalam transaksi penjualan. |
| 7 | `app/Http/Controllers/Admin/StafController.php` | `index()`, `store()`, `update()`, `destroy()` | Controller ini digunakan untuk mengelola data staf yang berkaitan dengan layanan atau proses operasional. |
| 8 | `app/Http/Controllers/Admin/StokController.php` | `index()`, `store()`, `destroy()` | Controller ini digunakan untuk mengelola arus stok masuk dan keluar. Source code ini sesuai dengan activity diagram melihat arus stok. |

## E. Source Code Berdasarkan Activity Diagram Transaksi

Bagian ini wajib karena transaksi adalah inti sistem.

| No | File | Bagian yang Dicopy | Deskripsi |
|---|---|---|---|
| 1 | `app/Http/Controllers/Admin/PenjualanController.php` | `entry()`, `store()`, `daftar()`, `updatePembayaran()`, `cetakInvoice()`, `destroy()` | Controller ini digunakan untuk mengelola transaksi penjualan. Method `entry()` menampilkan halaman entry dan generate invoice. Method `store()` menyimpan transaksi penjualan, detail penjualan, mengurangi stok, dan mencatat stok keluar. Method `updatePembayaran()` memproses pembayaran cicilan piutang. Method `cetakInvoice()` menghasilkan invoice PDF. |
| 2 | `app/Http/Controllers/Admin/PembelianController.php` | `entry()`, `store()`, `daftar()`, `updatePembayaran()`, `destroy()` | Controller ini digunakan untuk mengelola transaksi pembelian. Method `entry()` menampilkan data kebutuhan pembelian berdasarkan stok minus. Method `store()` menyimpan pembelian, membuat faktur, menambah stok, dan mencatat stok masuk. Method `updatePembayaran()` memperbarui pembayaran hutang kepada supplier. |
| 3 | `app/Http/Controllers/Admin/HutangController.php` | `index()`, `bayarCicilan()`, `updateMaster()` | Controller ini digunakan untuk menampilkan daftar hutang dan memproses pembayaran cicilan hutang kepada supplier. |
| 4 | `app/Http/Controllers/Admin/PiutangController.php` | `index()`, `bayarCicilan()`, `updateMaster()` | Controller ini digunakan untuk menampilkan daftar piutang customer dan memproses pembayaran cicilan piutang. |

## F. Source Code Berdasarkan Activity Diagram Produksi

| No | File | Bagian yang Dicopy | Deskripsi |
|---|---|---|---|
| 1 | `app/Http/Controllers/Admin/ProduksiController.php` | `updateProduksi()`, `simpanUpdate()`, `resetUpdate()` | Source code ini digunakan untuk proses update progress produksi. Method `simpanUpdate()` menyimpan tahap produksi, progress, dan catatan produksi. |
| 2 | `app/Http/Controllers/Admin/ProduksiController.php` | `updateDesain()`, `simpanDesain()`, `hapusDesain()` | Source code ini digunakan untuk proses pengelolaan desain pesanan. Method `simpanDesain()` menyimpan data desain dan file desain, sedangkan `hapusDesain()` menghapus desain yang sudah diunggah. |

## G. Source Code Berdasarkan Activity Diagram Keuangan dan Laporan

| No | File | Bagian yang Dicopy | Deskripsi |
|---|---|---|---|
| 1 | `app/Http/Controllers/Admin/KeuanganController.php` | `kas()`, `storeKas()` | Method `kas()` digunakan untuk menampilkan data kas dan menghitung saldo dari pemasukan serta pengeluaran. Method `storeKas()` digunakan untuk mencatat mutasi kas manual. |
| 2 | `app/Http/Controllers/Admin/KeuanganController.php` | `labaRugi()` | Method ini digunakan untuk menghitung laporan laba rugi berdasarkan total pemasukan dan total pengeluaran. |
| 3 | `app/Http/Controllers/Admin/KeuanganController.php` | `pengeluaranLainnya()`, `storePengeluaranLainnya()` | Method ini digunakan untuk mencatat pengeluaran tambahan di luar transaksi utama. Data disimpan sebagai kas keluar. |
| 4 | `app/Http/Controllers/Admin/LaporanController.php` | `exportBarang()`, `exportPenjualan()`, `exportPembelian()` | Source code ini digunakan untuk membuat laporan barang, laporan penjualan, dan laporan pembelian. Data diambil berdasarkan filter dan diekspor menjadi CSV/PDF. |
| 5 | `app/Http/Controllers/Admin/LaporanController.php` | `exportKas()`, `exportLabaKotor()`, `exportLabaBersih()` | Source code ini digunakan untuk membuat laporan keuangan, meliputi kas, laba kotor, dan laba bersih. |
| 6 | `app/Http/Controllers/Admin/LaporanController.php` | `exportStok()`, `exportHutang()`, `exportPiutang()` | Source code ini digunakan untuk membuat laporan stok, hutang, dan piutang berdasarkan filter tanggal serta pihak terkait. |
| 7 | `app/Http/Controllers/Admin/GrafikController.php` | `index()` | Controller ini digunakan untuk menampilkan grafik bisnis. Source code ini sesuai dengan activity diagram melihat chart/grafik bisnis. |
| 8 | `app/Http/Controllers/Admin/DashboardController.php` | `index()`, `chartData()` | Controller ini digunakan untuk menampilkan dashboard dan data chart bisnis. Method `chartData()` menghasilkan data grafik berdasarkan periode tertentu. |

## H. Source Code Berdasarkan Activity Diagram Backup Data

| No | File | Bagian yang Dicopy | Deskripsi |
|---|---|---|---|
| 1 | `app/Http/Controllers/Admin/ToolsController.php` | `backupData()`, `processBackup()` | Controller ini digunakan untuk fitur backup data. Method `backupData()` menampilkan halaman backup, sedangkan `processBackup()` memproses backup database dan menghasilkan file cadangan. |

## I. Source Code Berdasarkan Class Diagram CMS Landing Page

Bagian ini wajib ditambahkan karena di laporan terdapat class diagram CMS Landing Page dan activity diagram manajemen konten.

| No | File | Bagian yang Dicopy | Deskripsi |
|---|---|---|---|
| 1 | `app/Models/KontenProduk.php` | `class KontenProduk` | Model ini digunakan untuk menyimpan konten produk yang ditampilkan pada landing page. Data ini berbeda dengan produk operasional yang digunakan untuk transaksi. |
| 2 | `app/Models/Mitra.php` | `class Mitra` | Model ini digunakan untuk menyimpan data mitra yang ditampilkan pada halaman customer. |
| 3 | `app/Models/Portofolio.php` | `class Portofolio` | Model ini digunakan untuk menyimpan data portofolio atau hasil pekerjaan yang ditampilkan pada landing page. |
| 4 | `app/Models/Testimoni.php` | `class Testimoni` | Model ini digunakan untuk menyimpan testimoni pelanggan yang akan ditampilkan pada halaman website. |
| 5 | `app/Http/Controllers/Admin/KontenController.php` | `mitra()`, `storeMitra()`, `produk()`, `storeProduk()`, `portofolio()`, `storePortofolio()`, `testimoni()`, `storeTestimoni()` | Controller ini digunakan admin untuk mengelola konten landing page, seperti mitra, produk, portofolio, dan testimoni. |
| 6 | `app/Http/Controllers/Customer/LandingPageController.php` | `index()` | Controller ini digunakan untuk menampilkan konten landing page kepada pengunjung website. Data yang ditampilkan berasal dari model konten yang dikelola oleh admin. |
| 7 | `app/Http/Controllers/Customer/ProdukController.php` | `index()` | Controller ini digunakan untuk menampilkan halaman produk pada sisi customer. |
| 8 | `app/Http/Controllers/Customer/TentangController.php` | `index()` | Controller ini digunakan untuk menampilkan halaman tentang perusahaan pada sisi customer. |
| 9 | `app/Http/Controllers/Customer/KontakController.php` | `index()` | Controller ini digunakan untuk menampilkan halaman kontak pada sisi customer. |

## Prioritas Jika Halaman Terbatas

Jika tidak memungkinkan memasukkan semua source code, gunakan prioritas berikut:

1. `app/Models/User.php`
2. `app/Models/Role.php`
3. `app/Models/Produk.php`
4. `app/Models/Penjualan.php`
5. `app/Models/PenjualanDetail.php`
6. `app/Models/Pembelian.php`
7. `app/Models/PembelianDetail.php`
8. `app/Models/Stok.php`
9. `app/Models/Kas.php`
10. `app/Http/Controllers/Admin/PenjualanController.php`, bagian `store()`
11. `app/Http/Controllers/Admin/PembelianController.php`, bagian `store()`
12. `app/Http/Controllers/Admin/KeuanganController.php`, bagian `kas()` dan `labaRugi()`
13. `app/Http/Controllers/Admin/LaporanController.php`, bagian `exportPenjualan()` atau `exportKas()`
14. `app/Http/Controllers/Admin/ProduksiController.php`, bagian `simpanUpdate()` dan `simpanDesain()`
15. `app/Http/Controllers/Admin/UserController.php`, bagian `storeRole()` dan `storePengguna()`
16. `app/Http/Controllers/Admin/KontenController.php`, bagian pengelolaan konten
17. `app/Http/Controllers/Customer/LandingPageController.php`, bagian `index()`
18. `app/Http/Middleware/CheckPermission.php`, bagian `handle()`

## Catatan Penting

Pada Bab III laporan terdapat penjelasan class diagram arsitektur MVC yang menyebutkan adanya service seperti `TransaksiService`, `StokService`, dan `KeuanganService`. Namun, pada repo saat ini tidak ditemukan file service tersebut.

Jadi, pada bagian implementasi sistem jangan menampilkan source code service yang tidak ada. Gunakan source code aktual dari controller dan model karena logika bisnis sistem saat ini berada pada controller dan model Laravel.

Gunakan source code asli dari repo, tetapi boleh dipotong agar tidak terlalu panjang. Bagian yang ditampilkan harus tetap mewakili class atau proses yang dijelaskan pada UML.

## Checklist Pengerjaan

- [ ] Buat subbab `4.1.4 Implementasi Sistem`.
- [ ] Tambahkan kalimat pembuka implementasi sistem.
- [ ] Tampilkan source code model untuk mewakili class diagram.
- [ ] Tampilkan source code controller untuk mewakili activity diagram.
- [ ] Tampilkan source code middleware untuk mewakili login, permission, dan histori.
- [ ] Rapikan source code dalam shape/kotak, bukan screenshot.
- [ ] Tambahkan deskripsi singkat sebelum atau sesudah setiap source code.
- [ ] Pastikan nomor gambar mengikuti urutan laporan.
- [ ] Jangan menampilkan file service yang tidak ada di repo.
