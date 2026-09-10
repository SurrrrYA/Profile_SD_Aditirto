<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/helpers.php';

$title = 'Agenda - MI Aditirto';

include __DIR__ . '/partials/header.php';

/*
|--------------------------------------------------------------------------
| DATA AGENDA SEMENTARA
|--------------------------------------------------------------------------
| Nanti dapat dipindahkan ke database.
*/

$agenda = [
    [
        'tanggal' => '2026-09-15',
        'judul' => 'Rapat Wali Murid',
        'kategori' => 'Pertemuan',
        'waktu' => '08:00 - 10:00 WIB',
        'tempat' => 'Aula MI Aditirto',
        'deskripsi' => 'Pertemuan bersama wali murid untuk membahas kegiatan dan perkembangan pendidikan siswa.'
    ],
    [
        'tanggal' => '2026-09-20',
        'judul' => 'Kegiatan Keagamaan',
        'kategori' => 'Keagamaan',
        'waktu' => '07:30 - 11:00 WIB',
        'tempat' => 'MI Aditirto',
        'deskripsi' => 'Kegiatan keagamaan dan pembinaan karakter siswa.'
    ],
    [
        'tanggal' => '2026-09-25',
        'judul' => 'Lomba Antar Kelas',
        'kategori' => 'Kegiatan Siswa',
        'waktu' => '08:00 - 12:00 WIB',
        'tempat' => 'Halaman MI Aditirto',
        'deskripsi' => 'Kegiatan perlombaan antar kelas untuk meningkatkan kreativitas dan kerja sama siswa.'
    ],
    [
        'tanggal' => '2026-10-02',
        'judul' => 'Peringatan Hari Besar Islam',
        'kategori' => 'Keagamaan',
        'waktu' => '08:00 - selesai',
        'tempat' => 'Aula MI Aditirto',
        'deskripsi' => 'Kegiatan dalam rangka memperingati hari besar Islam bersama seluruh warga madrasah.'
    ],
    [
        'tanggal' => '2026-10-10',
        'judul' => 'Kegiatan Ekstrakurikuler',
        'kategori' => 'Ekstrakurikuler',
        'waktu' => '13:00 - 15:00 WIB',
        'tempat' => 'MI Aditirto',
        'deskripsi' => 'Pelaksanaan kegiatan ekstrakurikuler siswa sesuai jadwal masing-masing.'
    ],
    [
        'tanggal' => '2026-10-17',
        'judul' => 'Kerja Bakti Lingkungan',
        'kategori' => 'Lingkungan',
        'waktu' => '07:00 - 09:00 WIB',
        'tempat' => 'Lingkungan MI Aditirto',
        'deskripsi' => 'Kegiatan menjaga kebersihan dan lingkungan madrasah bersama seluruh warga sekolah.'
    ]
];

/*
|--------------------------------------------------------------------------
| Urutkan berdasarkan tanggal
|--------------------------------------------------------------------------
*/
usort($agenda, function ($a, $b) {
    return strtotime($a['tanggal']) <=> strtotime($b['tanggal']);
});
?>

<style>
/* =========================================================
   AGENDA PAGE
========================================================= */

.agenda-page {
    background: #f7f9fc;
    padding: 70px 20px 90px;
}

.agenda-container {
    max-width: 1100px;
    margin: 0 auto;
}

/* Header */

.agenda-heading {
    text-align: center;
    max-width: 750px;
    margin: 0 auto 50px;
}

.agenda-heading .badge {
    display: inline-block;
    padding: 7px 14px;
    background: #e8f1ff;
    color: #0d6efd;
    border-radius: 999px;
    font-size: 13px;
    font-weight: 700;
    margin-bottom: 12px;
}

.agenda-heading h1 {
    margin: 0 0 12px;
    font-size: 38px;
    color: #1c2733;
    font-weight: 800;
}

.agenda-heading p {
    margin: 0;
    color: #6b7785;
    font-size: 16px;
    line-height: 1.7;
}

/* Timeline */

.agenda-list {
    position: relative;
    display: flex;
    flex-direction: column;
    gap: 22px;
}

.agenda-list::before {
    content: '';
    position: absolute;
    left: 105px;
    top: 20px;
    bottom: 20px;
    width: 2px;
    background: #dce5f2;
}

/* Item */

.agenda-item {
    position: relative;
    display: grid;
    grid-template-columns: 140px 1fr;
    gap: 30px;
    align-items: start;
}

/* Date */

.agenda-date {
    position: relative;
    z-index: 2;
    background: #0d6efd;
    color: #fff;
    width: 85px;
    min-height: 85px;
    border-radius: 16px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    box-shadow: 0 8px 20px rgba(13, 110, 253, .18);
}

.agenda-date .day {
    font-size: 28px;
    line-height: 1;
    font-weight: 800;
}

.agenda-date .month {
    font-size: 12px;
    text-transform: uppercase;
    font-weight: 700;
    margin-top: 5px;
}

.agenda-date .year {
    font-size: 11px;
    opacity: .85;
    margin-top: 2px;
}

/* Card */

.agenda-card {
    background: #fff;
    border: 1px solid #edf0f5;
    border-radius: 18px;
    padding: 25px;
    box-shadow: 0 7px 24px rgba(13, 38, 76, .06);
    transition: transform .25s ease, box-shadow .25s ease;
}

.agenda-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 13px 30px rgba(13, 38, 76, .11);
}

.agenda-category {
    display: inline-block;
    background: #e8f1ff;
    color: #0d6efd;
    padding: 6px 11px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 700;
    margin-bottom: 10px;
}

.agenda-card h2 {
    margin: 0 0 14px;
    font-size: 21px;
    color: #1c2733;
}

.agenda-info {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    margin-bottom: 14px;
}

.agenda-info span {
    color: #667085;
    font-size: 13px;
}

.agenda-card p {
    margin: 0;
    color: #6b7785;
    line-height: 1.7;
    font-size: 14px;
}

/* Empty */

.agenda-empty {
    text-align: center;
    padding: 60px 20px;
    background: #fff;
    border-radius: 18px;
    color: #6b7785;
}

/* Responsive */

@media (max-width: 700px) {

    .agenda-page {
        padding: 50px 15px 70px;
    }

    .agenda-heading h1 {
        font-size: 30px;
    }

    .agenda-list::before {
        display: none;
    }

    .agenda-item {
        grid-template-columns: 1fr;
        gap: 12px;
    }

    .agenda-date {
        width: 75px;
        min-height: 75px;
    }

    .agenda-date .day {
        font-size: 24px;
    }

    .agenda-card {
        padding: 20px;
    }

    .agenda-card h2 {
        font-size: 19px;
    }

}
</style>


<section class="agenda-page">

    <div class="agenda-container">

        <!-- HEADER -->
        <div class="agenda-heading">

            <span class="badge">
                AGENDA MADRASAH
            </span>

            <h1>
                Agenda & Kegiatan
            </h1>

            <p>
                Informasi jadwal kegiatan dan agenda yang
                dilaksanakan di MI Aditirto.
            </p>

        </div>


        <!-- AGENDA -->
        <?php if (!empty($agenda)): ?>

            <div class="agenda-list">

                <?php foreach ($agenda as $item): ?>

                    <?php
                    $timestamp = strtotime($item['tanggal']);

                    $hari = date('d', $timestamp);
                    $bulan = date('M', $timestamp);
                    $tahun = date('Y', $timestamp);
                    ?>

                    <article class="agenda-item">

                        <!-- TANGGAL -->
                        <div class="agenda-date">

                            <span class="day">
                                <?= e($hari) ?>
                            </span>

                            <span class="month">
                                <?= e($bulan) ?>
                            </span>

                            <span class="year">
                                <?= e($tahun) ?>
                            </span>

                        </div>


                        <!-- DETAIL -->
                        <div class="agenda-card">

                            <span class="agenda-category">
                                <?= e($item['kategori']) ?>
                            </span>

                            <h2>
                                <?= e($item['judul']) ?>
                            </h2>

                            <div class="agenda-info">

                                <span>
                                    🕐 <?= e($item['waktu']) ?>
                                </span>

                                <span>
                                    📍 <?= e($item['tempat']) ?>
                                </span>

                            </div>

                            <p>
                                <?= e($item['deskripsi']) ?>
                            </p>

                        </div>

                    </article>

                <?php endforeach; ?>

            </div>

        <?php else: ?>

            <div class="agenda-empty">
                Belum ada agenda kegiatan.
            </div>

        <?php endif; ?>

    </div>

</section>


<?php include __DIR__ . '/partials/footer.php'; ?>