<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/helpers.php';

$title = 'Prestasi - MI Aditirto';

include __DIR__ . '/partials/header.php';

/*
|--------------------------------------------------------------------------
| DATA PRESTASI SEMENTARA
|--------------------------------------------------------------------------
| Nanti bisa dipindahkan ke database jika tabel prestasi sudah dibuat.
*/

$prestasi = [
    [
        'judul' => 'Juara 1 Lomba Tahfidz Al-Qur’an',
        'kategori' => 'Keagamaan',
        'tingkat' => 'Kecamatan',
        'tahun' => '2025',
        'peraih' => 'Siswa MI Aditirto',
        'deskripsi' => 'Prestasi dalam lomba tahfidz Al-Qur’an tingkat kecamatan.',
        'gambar' => 'prestasi1.jpg'
    ],
    [
        'judul' => 'Juara 2 Lomba Cerdas Cermat',
        'kategori' => 'Akademik',
        'tingkat' => 'Kabupaten',
        'tahun' => '2025',
        'peraih' => 'Tim MI Aditirto',
        'deskripsi' => 'Prestasi siswa dalam kompetisi cerdas cermat tingkat kabupaten.',
        'gambar' => 'prestasi2.jpg'
    ],
    [
        'judul' => 'Juara 1 Lomba Futsal',
        'kategori' => 'Olahraga',
        'tingkat' => 'Kecamatan',
        'tahun' => '2024',
        'peraih' => 'Tim Futsal MI Aditirto',
        'deskripsi' => 'Prestasi olahraga siswa dalam kompetisi futsal antar sekolah.',
        'gambar' => 'prestasi3.jpg'
    ],
    [
        'judul' => 'Juara 3 Lomba Kaligrafi',
        'kategori' => 'Seni',
        'tingkat' => 'Kabupaten',
        'tahun' => '2024',
        'peraih' => 'Siswa MI Aditirto',
        'deskripsi' => 'Prestasi siswa dalam bidang seni kaligrafi tingkat kabupaten.',
        'gambar' => 'prestasi4.jpg'
    ],
    [
        'judul' => 'Juara 2 Olimpiade Matematika',
        'kategori' => 'Akademik',
        'tingkat' => 'Kecamatan',
        'tahun' => '2024',
        'peraih' => 'Siswa MI Aditirto',
        'deskripsi' => 'Prestasi akademik dalam kompetisi matematika tingkat kecamatan.',
        'gambar' => 'prestasi5.jpg'
    ],
    [
        'judul' => 'Juara 1 Lomba Adzan',
        'kategori' => 'Keagamaan',
        'tingkat' => 'Kecamatan',
        'tahun' => '2023',
        'peraih' => 'Siswa MI Aditirto',
        'deskripsi' => 'Prestasi siswa dalam lomba adzan tingkat kecamatan.',
        'gambar' => 'prestasi6.jpg'
    ]
];
?>

<style>
/* =========================================================
   PRESTASI PAGE
========================================================= */

.prestasi-page {
    background: #f7f9fc;
    padding: 70px 20px 90px;
}

.prestasi-container {
    max-width: 1200px;
    margin: 0 auto;
}

/* Header */

.prestasi-heading {
    text-align: center;
    max-width: 750px;
    margin: 0 auto 45px;
}

.prestasi-heading .badge {
    display: inline-block;
    padding: 7px 14px;
    background: #e8f1ff;
    color: #0d6efd;
    border-radius: 999px;
    font-size: 13px;
    font-weight: 700;
    margin-bottom: 12px;
}

.prestasi-heading h1 {
    margin: 0 0 12px;
    font-size: 38px;
    color: #1c2733;
    font-weight: 800;
}

.prestasi-heading p {
    margin: 0;
    color: #6b7785;
    font-size: 16px;
    line-height: 1.7;
}

/* Grid */

.prestasi-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 25px;
}

/* Card */

.prestasi-card {
    background: #fff;
    border-radius: 18px;
    overflow: hidden;
    border: 1px solid #edf0f5;
    box-shadow: 0 8px 25px rgba(13, 38, 76, 0.06);
    transition: transform .25s ease, box-shadow .25s ease;
}

.prestasi-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 15px 35px rgba(13, 38, 76, 0.12);
}

/* Image */

.prestasi-image {
    position: relative;
    height: 220px;
    overflow: hidden;
    background: #e9eef5;
}

.prestasi-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform .4s ease;
}

.prestasi-card:hover .prestasi-image img {
    transform: scale(1.05);
}

.prestasi-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #0d6efd, #0a4fc4);
    color: #fff;
    font-size: 48px;
    font-weight: 800;
}

/* Badge kategori */

.prestasi-category {
    position: absolute;
    left: 15px;
    top: 15px;
    background: rgba(255,255,255,.95);
    color: #0d6efd;
    padding: 6px 11px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 700;
}

/* Content */

.prestasi-content {
    padding: 22px;
}

.prestasi-content h2 {
    margin: 0 0 12px;
    font-size: 20px;
    line-height: 1.4;
    color: #1c2733;
}

.prestasi-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 14px;
}

.prestasi-meta span {
    font-size: 12px;
    color: #667085;
    background: #f3f5f8;
    padding: 6px 9px;
    border-radius: 7px;
}

.prestasi-peraih {
    font-weight: 700;
    color: #0d6efd;
    font-size: 14px;
    margin-bottom: 10px;
}

.prestasi-content p {
    margin: 0;
    color: #6b7785;
    font-size: 14px;
    line-height: 1.7;
}

/* Statistik */

.prestasi-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 18px;
    margin-bottom: 50px;
}

.prestasi-stat {
    background: #fff;
    padding: 24px;
    border-radius: 16px;
    text-align: center;
    border: 1px solid #edf0f5;
}

.prestasi-stat strong {
    display: block;
    font-size: 30px;
    color: #0d6efd;
    margin-bottom: 5px;
}

.prestasi-stat span {
    color: #6b7785;
    font-size: 14px;
}

/* Responsive */

@media (max-width: 900px) {
    .prestasi-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 600px) {

    .prestasi-page {
        padding: 50px 15px 70px;
    }

    .prestasi-heading h1 {
        font-size: 30px;
    }

    .prestasi-grid {
        grid-template-columns: 1fr;
    }

    .prestasi-stats {
        grid-template-columns: 1fr;
    }

    .prestasi-image {
        height: 210px;
    }
}
</style>

<section class="prestasi-page">

    <div class="prestasi-container">

        <!-- HEADER -->
        <div class="prestasi-heading">

            <span class="badge">
                PRESTASI MADRASAH
            </span>

            <h1>
                Prestasi MI Aditirto
            </h1>

            <p>
                Dokumentasi pencapaian dan prestasi siswa
                MI Aditirto dalam berbagai bidang akademik,
                keagamaan, olahraga, dan seni.
            </p>

        </div>


        <!-- STATISTIK -->
        <div class="prestasi-stats">

            <div class="prestasi-stat">
                <strong><?= count($prestasi) ?></strong>
                <span>Total Prestasi</span>
            </div>

            <div class="prestasi-stat">
                <strong>4</strong>
                <span>Bidang Prestasi</span>
            </div>

            <div class="prestasi-stat">
                <strong>2023–2025</strong>
                <span>Periode Prestasi</span>
            </div>

        </div>


        <!-- LIST PRESTASI -->
        <div class="prestasi-grid">

            <?php foreach ($prestasi as $item): ?>

                <article class="prestasi-card">

                    <div class="prestasi-image">

                        <?php if (!empty($item['gambar'])): ?>

                            <img
                                src="assets/img/<?= e($item['gambar']) ?>"
                                alt="<?= e($item['judul']) ?>"
                                loading="lazy"
                            >

                        <?php else: ?>

                            <div class="prestasi-placeholder">
                                🏆
                            </div>

                        <?php endif; ?>

                        <span class="prestasi-category">
                            <?= e($item['kategori']) ?>
                        </span>

                    </div>


                    <div class="prestasi-content">

                        <h2>
                            <?= e($item['judul']) ?>
                        </h2>

                        <div class="prestasi-meta">

                            <span>
                                🏅 <?= e($item['tingkat']) ?>
                            </span>

                            <span>
                                📅 <?= e($item['tahun']) ?>
                            </span>

                        </div>

                        <div class="prestasi-peraih">
                            <?= e($item['peraih']) ?>
                        </div>

                        <p>
                            <?= e($item['deskripsi']) ?>
                        </p>

                    </div>

                </article>

            <?php endforeach; ?>

        </div>

    </div>

</section>

<?php include __DIR__ . '/partials/footer.php'; ?>