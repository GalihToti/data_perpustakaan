<?php
require_once 'services/config.php';

$buku = $conn->query("SELECT * FROM buku  ORDER BY id_buku");
$anggota = $conn->query("SELECT * FROM anggota  ORDER BY id_anggota");
$peminjaman = $conn->query("
SELECT p.id_peminjaman, b.judul, a.nama, p.tanggal_pinjam, p.tanggal_kembali, p.status
FROM peminjaman p
JOIN buku b ON p.id_buku = b.id_buku
JOIN anggota a ON p.id_anggota = a.id_anggota
ORDER BY p.id_peminjaman
");

function e(string $s)
{
    return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <nav class="navbar">
        <div class="container nav-inner">
            <span class="logo">📚 Perpustakaan</span>
            <ul class="nav-links">
                <li><a href="#buku">Buku</a></li>
                <li><a href="#anggota">Anggota</a></li>
                <li><a href="#peminjaman">Peminjaman</a></li>
            </ul>
        </div>
    </nav>

    <main class="container">
        <h1>Data Perpustakaan</h1>

        <section class="card" id="buku">
            <h2>Daftar Buku</h2>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Judul</th>
                            <th>Penulis</th>
                            <th>Penerbit</th>
                            <th>Tahun</th>
                            <th>Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $buku->fetch_assoc()): ?>
                            <tr>
                                <td><?= e($row['id_buku']) ?></td>
                                <td><?= e($row['judul']) ?></td>
                                <td><?= e($row['penulis']) ?></td>
                                <td><?= e($row['penerbit']) ?></td>
                                <td><?= e($row['tahun_terbit']) ?></td>
                                <td><?= e($row['stok']) ?></td>
                            </tr>
                        <?php endwhile ?>
                    </tbody>
                </table>
            </div>
        </section>

        <section class="card" id="anggota">
            <h2>Daftar Anggota</h2>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>No. Telepon</th>
                            <th>Alamat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $anggota->fetch_assoc()): ?>
                            <tr>
                                <td><?= e($row['id_anggota']) ?></td>
                                <td><?= e($row['nama']) ?></td>
                                <td><?= e($row['email']) ?></td>
                                <td><?= e($row['no_telepon']) ?></td>
                                <td><?= e($row['alamat']) ?></td>
                            </tr>
                        <?php endwhile ?>
                    </tbody>
                </table>
            </div>
        </section>

        <section class="card" id="peminjaman">
            <h2>Riwayat Peminjaman</h2>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Judul Buku</th>
                            <th>Peminjam</th>
                            <th>Tgl Pinjam</th>
                            <th>Tgl Kembali</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $peminjaman->fetch_assoc()): ?>
                            <tr>
                                <td><?= e($row['id_peminjaman']) ?></td>
                                <td><?= e($row['judul']) ?></td>
                                <td><?= e($row['nama']) ?></td>
                                <td><?= e($row['tanggal_pinjam']) ?></td>
                                <td><?= e($row['tanggal_kembali'] ? e($row['tanggal_kembali']) : '-') ?></td>
                                <td>
                                    <span class="badge <?= $row['status'] === 'Dipinjam' ? 'badge-out' : 'badge-in' ?>">
                                        <?= e($row['status']) ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endwhile ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <footer class="footer">
        <p>&copy; <?= date('Y') ?> Perpustakaan</p>
    </footer>
</body>
</html>
<?php $conn->close(); ?>