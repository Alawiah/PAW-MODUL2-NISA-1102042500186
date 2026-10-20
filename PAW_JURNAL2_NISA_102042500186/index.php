<?php
require 'functions.php';
require 'connect.php';

// TODO 1 (RINGKASAN)
// Hitung jumlah baris di tabel mata_kuliah, materi, dan tugas,
// lalu hitung juga tugas yang statusnya 'Aktif'.
// Simpan hasilnya ke empat variabel di bawah ini (gunakan COUNT, bukan mengambil semua baris).

$stmt = $conn->prepare("
    SELECT
        (SELECT COUNT(*) FROM mata_kuliah) AS jumlah_mata_kuliah,
        (SELECT COUNT(*) FROM materi) AS jumlah_materi,
        (SELECT COUNT(*) FROM tugas) AS jumlah_tugas,
        (SELECT COUNT(*) FROM tugas WHERE status = 'Aktif') AS jumlah_tugas_aktif
");

$stmt->execute();
$ringkasan = $stmt->get_result()->fetch_assoc();
$stmt->close();

$jumlah_mata_kuliah = (int) $ringkasan['jumlah_mata_kuliah'];
$jumlah_materi      = (int) $ringkasan['jumlah_materi'];
$jumlah_tugas       = (int) $ringkasan['jumlah_tugas'];
$jumlah_tugas_aktif = (int) $ringkasan['jumlah_tugas_aktif'];


$pilihan_mk = pilihan_mata_kuliah($conn);

$judul = 'Beranda';
require 'header.php';
?>
<p class="eyebrow">Learning Management System</p>
<h1 class="hero">Kelola perkuliahan dalam satu tempat.</h1>
<p class="muted">Pengelolaan mata kuliah, materi pembelajaran, dan tugas.</p>

<div class="stats">
    <a class="card stat" href="mata_kuliah.php">
        <b><?= (int) $jumlah_mata_kuliah ?></b>
        <span>Mata kuliah</span>
    </a>
    <a class="card stat" href="materi.php">
        <b><?= (int) $jumlah_materi ?></b>
        <span>Materi</span>
    </a>
    <a class="card stat" href="tugas.php">
        <b><?= (int) $jumlah_tugas ?></b>
        <span>Tugas</span>
    </a>
    <a class="card stat" href="tugas.php?status=Aktif">
        <b><?= (int) $jumlah_tugas_aktif ?></b>
        <span>Tugas aktif</span>
    </a>
</div>

<h2>Mata kuliah tersedia</h2>
<?php if (count($pilihan_mk) === 0): ?>
    <p class="empty">Belum ada mata kuliah.</p>
<?php else: ?>
    <div class="card list">
        <?php foreach ($pilihan_mk as $id => $nama): ?>
            <a class="list-item" href="mata_kuliah.php?aksi=detail&id=<?= (int) $id ?>"><?= h($nama) ?></a>
        <?php endforeach ?>
    </div>
<?php endif ?>
<?php require 'footer.php'; ?>
