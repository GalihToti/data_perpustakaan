-- Query Sample - Database Perpustakaan
USE perpustakaan;

-- SELECT

-- 1. Semua buku dengan stok lebih dari 3
SELECT * FROM buku WHERE stok > 3 ORDER BY judul;

-- 2. Semua anggota yang beralamat di Sidoarjo
SELECT nama, email FROM anggota WHERE alamat LIKE '%Sidoarjo%';

-- JOIN 

-- 3. Daftar peminjaman lengkap
SELECT p.id_peminjaman, b.judul, a.nama, p.tanggal_pinjam, p.tanggal_kembali, p.status
FROM peminjaman p
JOIN buku b    ON p.id_buku    = b.id_buku
JOIN anggota a ON p.id_anggota = a.id_anggota
ORDER BY p.tanggal_pinjam DESC;

-- 4. Jumlah peminjaman per anggota (termasuk yang belum pernah meminjam)
SELECT a.nama, COUNT(p.id_peminjaman) AS total_pinjam
FROM anggota a
LEFT JOIN peminjaman p ON a.id_anggota = p.id_anggota
GROUP BY a.id_anggota, a.nama
ORDER BY total_pinjam DESC;

-- 5. Buku yang sedang dipinjam
SELECT b.judul, a.nama, p.tanggal_pinjam
FROM peminjaman p
JOIN buku b    ON p.id_buku    = b.id_buku
JOIN anggota a ON p.id_anggota = a.id_anggota
WHERE p.status = 'Dipinjam';

-- UPDATE 

-- 6. Pengembalian buku: ubah status & isi tanggal kembali
UPDATE peminjaman
SET status = 'Dikembalikan', tanggal_kembali = '2026-10-07'
WHERE id_peminjaman = 3;

-- 7. Tambah stok buku
UPDATE buku SET stok = stok + 2 WHERE id_buku = 5;

-- DELETE 

-- 8. Hapus data peminjaman tertentu
DELETE FROM peminjaman WHERE id_peminjaman = 6;

-- 9. Hapus anggota yang belum pernah meminjam
--    (anggota yang punya riwayat peminjaman akan ditolak oleh FK RESTRICT)
DELETE FROM anggota
WHERE id_anggota NOT IN (SELECT DISTINCT id_anggota FROM peminjaman);