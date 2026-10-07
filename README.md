# Sistem Perpustakaan (PHP + MySQL)

Aplikasi sederhana yang menampilkan 3 tabel (Buku, Anggota, Peminjaman) dari database MySQL menggunakan PHP `mysqli`.

## Struktur File

```
perpustakaan/
├── services/
│   └── config.php        # Konfigurasi dan koneksi database
├── database/
│   ├── schema.sql        # DDL + DML (data contoh)
│   └── queries.sql       # Contoh query SELECT, JOIN, UPDATE, DELETE
├── index.php             # Halaman utama (menampilkan 3 tabel)
├── style.css             # Styling responsif
└── README.md
```

## Entitas dan Atribut

### 1. `buku` (Master)

| Atribut      | Tipe                    | Keterangan       |
| ------------ | ----------------------- | ---------------- |
| id_buku      | INT, PK, AUTO_INCREMENT | Identitas buku   |
| judul        | VARCHAR(150)            | Judul buku       |
| penulis      | VARCHAR(100)            | Nama penulis     |
| penerbit     | VARCHAR(100)            | Nama penerbit    |
| tahun_terbit | YEAR                    | Tahun terbit     |
| stok         | INT                     | Jumlah eksemplar |

### 2. `anggota` (Master)

| Atribut    | Tipe                    | Keterangan        |
| ---------- | ----------------------- | ----------------- |
| id_anggota | INT, PK, AUTO_INCREMENT | Identitas anggota |
| nama       | VARCHAR(100)            | Nama lengkap      |
| email      | VARCHAR(100), UNIQUE    | Alamat email      |
| no_telepon | VARCHAR(20)             | Nomor telepon     |
| alamat     | VARCHAR(200)            | Alamat tinggal    |

### 3. `peminjaman` (Transaksi)

| Atribut         | Tipe                            | Keterangan           |
| --------------- | ------------------------------- | -------------------- |
| id_peminjaman   | INT, PK, AUTO_INCREMENT         | Identitas transaksi  |
| id_buku         | INT, FK → buku.id_buku          | Buku yang dipinjam   |
| id_anggota      | INT, FK → anggota.id_anggota    | Peminjam             |
| tanggal_pinjam  | DATE                            | Tanggal meminjam     |
| tanggal_kembali | DATE (NULL)                     | Tanggal pengembalian |
| status          | ENUM('Dipinjam','Dikembalikan') | Status peminjaman    |

## Relasi dan Kardinalitas

| Relasi                   | Kardinalitas | Penjelasan                                                                         |
| ------------------------ | ------------ | ---------------------------------------------------------------------------------- |
| `buku` → `peminjaman`    | **1 : N**    | Satu buku dapat dipinjam berkali"; setiap transaksi hanya untuk satu buku.         |
| `anggota` → `peminjaman` | **1 : N**    | Satu anggota dapat lakukan banyak peminjaman; setiap transaksi milik satu anggota. |
| `buku` ↔ `anggota`       | **M : N**    | Diwujudkan lewat tabel `peminjaman` sebagai tabel relasi.                          |

Aturan FK: `ON UPDATE CASCADE`, `ON DELETE RESTRICT` (buku/anggota yang masih punya riwayat peminjaman tidak dapat dihapus).

```
buku (1) ────< (N) peminjaman (N) >──── (1) anggota
```

## Cara Menjalankan

1. Pasang Laragon, jalankan Apache dan MySQL.
2. Import database lewat DBeaver atau GUI yang lain.
3. Letakkan folder proyek di `www` (Laragon).
4. Sesuaikan `services/config.php` bila user/password MySQL berbeda.
5. Buka `http://localhost/perpustakaan/index.php`.

## Query Sample

Lengkapnya ada di `database/queries.sql`. Contoh:

```sql
-- SELECT + JOIN
SELECT b.judul, a.nama, p.tanggal_pinjam, p.status
FROM peminjaman p
JOIN buku b    ON p.id_buku = b.id_buku
JOIN anggota a ON p.id_anggota = a.id_anggota;

-- UPDATE (pengembalian buku)
UPDATE peminjaman SET status='Dikembalikan', tanggal_kembali='2026-10-07'
WHERE id_peminjaman = 3;

-- DELETE
DELETE FROM peminjaman WHERE id_peminjaman = 6;
```

## Fitur Tampilan

- 1 warna brand (teal `#0f766e`) untuk navbar, heading, dan header tabel
- Box model: card dengan padding, border, dan shadow
- Flexbox pada navbar; tabel dibungkus `overflow-x: auto` agar nyaman di mobile
- Media query untuk layar ≤ 768px