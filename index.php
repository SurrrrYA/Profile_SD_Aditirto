<?php
require_once __DIR__.'/config.php';

$title = 'Home - MI Aditirto';

include __DIR__.'/partials/header.php';

/* =========================================================
   DATA SITE INFO
   ========================================================= */
$stmt = $pdo->query("SELECT * FROM site_info LIMIT 1");
$info = $stmt->fetch();

$misi_list = !empty($info['misi'])
    ? explode('|', $info['misi'])
    : [];

/* =========================================================
   HERO
   ========================================================= */
$heroVideo = !empty($info['hero_video'])
    ? 'uploads/site/'.e($info['hero_video'])
    : null;

$heroImage = !empty($info['hero_image'])
    ? 'uploads/site/'.e($info['hero_image'])
    : 'assets/sekolah.jpg';

/* =========================================================
   BERITA
   ========================================================= */
$beritaStmt = $pdo->query("
    SELECT *
    FROM berita
    ORDER BY tanggal DESC
");

$beritaList = $beritaStmt->fetchAll();

/* =========================================================
   DATA TAMBAHAN
   Untuk sementara menggunakan data contoh.
   Nanti bisa dipindahkan ke database/admin.
   ========================================================= */

/* Statistik */
$statistik = [
    [
        'angka' => '250+',
        'label' => 'Siswa'
    ],
    [
        'angka' => '20+',
        'label' => 'Guru & Staff'
    ],
    [
        'angka' => '12',
        'label' => 'Ruang Kelas'
    ],
    [
        'angka' => 'A',
        'label' => 'Akreditasi'
    ]
];

/* Prestasi */
$prestasi = [
    [
        'icon' => '🏆',
        'judul' => 'Prestasi Siswa',
        'keterangan' => 'Berbagai prestasi siswa dalam bidang akademik dan non-akademik.',
        'tahun' => '2026'
    ],
    [
        'icon' => '🥇',
        'judul' => 'Juara Perlombaan',
        'keterangan' => 'Siswa berprestasi dalam perlombaan tingkat kecamatan dan kabupaten.',
        'tahun' => '2026'
    ],
    [
        'icon' => '📖',
        'judul' => 'Prestasi Keagamaan',
        'keterangan' => 'Prestasi dalam bidang keagamaan dan kegiatan madrasah.',
        'tahun' => '2026'
    ]
];

/* Galeri */
$galeri = [
    [
        'gambar' => 'assets/sekolah.jpg',
        'judul' => 'Kegiatan Pembelajaran'
    ],
    [
        'gambar' => 'assets/sekolah.jpg',
        'judul' => 'Kegiatan Siswa'
    ],
    [
        'gambar' => 'assets/sekolah.jpg',
        'judul' => 'Kegiatan Keagamaan'
    ],
    [
        'gambar' => 'assets/sekolah.jpg',
        'judul' => 'Kegiatan Sekolah'
    ],
    [
        'gambar' => 'assets/sekolah.jpg',
        'judul' => 'Perlombaan Siswa'
    ],
    [
        'gambar' => 'assets/sekolah.jpg',
        'judul' => 'Lingkungan Madrasah'
    ]
];

/* Agenda */
$agenda = [
    [
        'tanggal' => '12',
        'bulan' => 'SEP',
        'judul' => 'Kegiatan Pembelajaran',
        'keterangan' => 'Kegiatan pembelajaran siswa di madrasah.'
    ],
    [
        'tanggal' => '20',
        'bulan' => 'SEP',
        'judul' => 'Kegiatan Olahraga',
        'keterangan' => 'Kegiatan olahraga dan pengembangan bakat siswa.'
    ],
    [
        'tanggal' => '25',
        'bulan' => 'SEP',
        'judul' => 'Kegiatan Keagamaan',
        'keterangan' => 'Kegiatan keagamaan bersama siswa dan guru.'
    ]
];

/* Fasilitas */
$fasilitas = [
    [
        'icon' => '📚',
        'judul' => 'Perpustakaan',
        'keterangan' => 'Sarana untuk mendukung kegiatan membaca dan belajar siswa.'
    ],
    [
        'icon' => '💻',
        'judul' => 'Laboratorium Komputer',
        'keterangan' => 'Fasilitas komputer untuk mendukung pembelajaran teknologi.'
    ],
    [
        'icon' => '🕌',
        'judul' => 'Sarana Ibadah',
        'keterangan' => 'Sarana untuk mendukung kegiatan keagamaan warga madrasah.'
    ],
    [
        'icon' => '⚽',
        'judul' => 'Lapangan',
        'keterangan' => 'Digunakan untuk olahraga dan kegiatan siswa.'
    ]
];

/* =========================================================
   CSS
   ========================================================= */
?>

<style>

:root {
    --primary: #0d6efd;
    --primary-dark: #084298;
    --primary-light: #eaf3ff;

    --accent: #ffb703;
    --accent-dark: #e09b00;

    --green: #198754;

    --text-dark: #17212b;
    --text-muted: #687585;

    --bg: #ffffff;
    --bg-soft: #f5f7fa;

    --border: #e7ebf0;

    --radius: 18px;

    --shadow-sm:
        0 4px 15px rgba(15, 40, 80, .06);

    --shadow-md:
        0 12px 35px rgba(15, 40, 80, .12);
}


/* =========================================================
   GLOBAL
   ========================================================= */

* {
    box-sizing: border-box;
}

html {
    scroll-behavior: smooth;
}

body {
    margin: 0;
    padding: 0;

    font-family:
        'Segoe UI',
        Arial,
        sans-serif;

    background: var(--bg-soft);
    color: var(--text-dark);

    overflow-x: hidden;
}

a {
    text-decoration: none;
}

img {
    max-width: 100%;
}


/* =========================================================
   HERO
   ========================================================= */

.hero {
    position: relative;

    width: 100%;
    min-height: 92vh;

    display: flex;
    align-items: center;
    justify-content: center;

    text-align: center;

    overflow: hidden;
}

.hero-video {
    position: absolute;

    inset: 0;

    width: 100%;
    height: 100%;

    object-fit: cover;

    z-index: 0;
}

.hero::after {
    content: '';

    position: absolute;

    inset: 0;

    background:
        linear-gradient(
            180deg,
            rgba(5, 20, 40, .45),
            rgba(5, 20, 40, .82)
        );

    z-index: 1;
}

.hero-overlay {
    position: relative;

    z-index: 2;

    max-width: 850px;

    padding: 40px 25px;

    color: white;

    animation:
        fadeUp .9s ease both;
}

.hero-badge {
    display: inline-block;

    padding: 7px 18px;

    margin-bottom: 20px;

    border-radius: 999px;

    background:
        rgba(255,255,255,.15);

    border:
        1px solid rgba(255,255,255,.35);

    backdrop-filter:
        blur(8px);

    font-size: 13px;

    font-weight: 600;

    letter-spacing: 1px;

    text-transform: uppercase;
}

.hero h1 {
    margin: 0 0 18px;

    font-size:
        clamp(32px, 6vw, 58px);

    line-height: 1.15;

    font-weight: 800;
}

.hero p {
    max-width: 680px;

    margin:
        0 auto 30px;

    color:
        rgba(255,255,255,.9);

    font-size:
        clamp(15px, 2vw, 19px);

    line-height: 1.7;
}

.hero-buttons {
    display: flex;

    justify-content: center;

    gap: 12px;

    flex-wrap: wrap;
}

.btn-primary {
    display: inline-flex;

    align-items: center;

    justify-content: center;

    padding: 13px 25px;

    border-radius: 10px;

    background:
        var(--primary);

    color: white;

    font-weight: 700;

    transition:
        .25s ease;
}

.btn-primary:hover {
    background:
        var(--primary-dark);

    transform:
        translateY(-2px);
}

.btn-outline {
    display: inline-flex;

    align-items: center;

    justify-content: center;

    padding: 13px 25px;

    border-radius: 10px;

    border:
        1px solid rgba(255,255,255,.6);

    color: white;

    font-weight: 700;

    background:
        rgba(255,255,255,.08);

    backdrop-filter:
        blur(5px);

    transition:
        .25s ease;
}

.btn-outline:hover {
    background:
        white;

    color:
        var(--primary);
}

.hero-scroll {
    position: absolute;

    z-index: 2;

    bottom: 25px;

    left: 50%;

    transform:
        translateX(-50%);

    color: white;

    font-size: 28px;

    animation:
        bounce 2s infinite;

    opacity: .8;
}

@keyframes fadeUp {

    from {
        opacity: 0;

        transform:
            translateY(25px);
    }

    to {
        opacity: 1;

        transform:
            translateY(0);
    }
}

@keyframes bounce {

    0%,100% {
        transform:
            translate(-50%,0);
    }

    50% {
        transform:
            translate(-50%,10px);
    }
}


/* =========================================================
   SECTION
   ========================================================= */

.section {
    max-width: 1200px;

    margin: auto;

    padding:
        80px 24px;
}

.section-head {
    text-align: center;

    margin-bottom: 45px;
}

.eyebrow {
    display: block;

    color:
        var(--primary);

    font-size: 13px;

    font-weight: 800;

    letter-spacing: 1.7px;

    text-transform: uppercase;
}

.section-head h2 {
    margin:
        8px 0 0;

    font-size:
        clamp(26px, 4vw, 36px);

    color:
        var(--text-dark);
}

.underline {
    width: 60px;

    height: 4px;

    margin:
        16px auto 0;

    border-radius: 5px;

    background:
        var(--accent);
}


/* =========================================================
   STATISTIK
   ========================================================= */

.stats-section {
    position: relative;

    margin-top: -50px;

    z-index: 5;
}

.stats-box {
    display: grid;

    grid-template-columns:
        repeat(4, 1fr);

    background: white;

    border-radius:
        var(--radius);

    box-shadow:
        var(--shadow-md);

    overflow: hidden;
}

.stat-item {
    padding:
        30px 20px;

    text-align: center;

    border-right:
        1px solid var(--border);

    transition:
        .25s ease;
}

.stat-item:last-child {
    border-right: none;
}

.stat-item:hover {
    background:
        var(--primary-light);
}

.stat-number {
    color:
        var(--primary);

    font-size:
        32px;

    font-weight: 800;

    margin-bottom: 5px;
}

.stat-label {
    color:
        var(--text-muted);

    font-size: 14px;

    font-weight: 600;
}


/* =========================================================
   SAMBUTAN
   ========================================================= */

.sambutan {
    display: grid;

    grid-template-columns:
        .75fr 1.25fr;

    gap: 45px;

    align-items: center;
}

.sambutan-photo {
    min-height: 350px;

    border-radius:
        var(--radius);

    overflow: hidden;

    box-shadow:
        var(--shadow-md);
}

.sambutan-photo img {
    width: 100%;

    height: 100%;

    object-fit: cover;
}

.sambutan-content h2 {
    margin:
        0 0 18px;

    font-size:
        clamp(27px, 4vw, 38px);
}

.sambutan-content p {
    color:
        var(--text-muted);

    line-height: 1.8;

    font-size: 16px;
}

.kepala {
    margin-top: 25px;

    padding-left: 16px;

    border-left:
        4px solid var(--accent);
}

.kepala strong {
    display: block;

    color:
        var(--text-dark);

    font-size: 17px;
}

.kepala span {
    color:
        var(--text-muted);

    font-size: 14px;
}


/* =========================================================
   BERITA
   ========================================================= */

.berita-scroll {
    display: flex;

    gap: 22px;

    overflow-x: auto;

    scroll-snap-type:
        x mandatory;

    padding:
        10px 4px 22px;

    scrollbar-width:
        thin;
}

.berita-scroll::-webkit-scrollbar {
    height: 8px;
}

.berita-scroll::-webkit-scrollbar-track {
    background:
        #e9edf2;

    border-radius:
        5px;
}

.berita-scroll::-webkit-scrollbar-thumb {
    background:
        var(--primary);

    border-radius:
        5px;
}

.berita-card {
    flex:
        0 0 290px;

    scroll-snap-align:
        start;

    background:
        white;

    border-radius:
        var(--radius);

    overflow:
        hidden;

    box-shadow:
        var(--shadow-sm);

    display:
        flex;

    flex-direction:
        column;

    transition:
        .25s ease;
}

.berita-card:hover {
    transform:
        translateY(-7px);

    box-shadow:
        var(--shadow-md);
}

.thumb-wrap {
    position: relative;

    height: 175px;

    overflow: hidden;
}

.thumb-wrap img,
.thumb-wrap video,
.thumb-wrap iframe {
    width: 100%;

    height: 175px;

    object-fit: cover;

    border: none;

    display: block;
}

.berita-card:hover img {
    transform:
        scale(1.06);
}

.date-chip {
    position: absolute;

    top: 12px;

    left: 12px;

    padding:
        5px 12px;

    background:
        var(--primary);

    color: white;

    border-radius:
        999px;

    font-size: 12px;

    font-weight: 700;
}

.berita-content {
    padding:
        18px;

    display:
        flex;

    flex-direction:
        column;

    flex: 1;
}

.berita-content h3 {
    margin:
        0 0 9px;

    font-size: 17px;

    line-height: 1.4;
}

.berita-content p {
    flex: 1;

    margin:
        0 0 15px;

    color:
        var(--text-muted);

    font-size: 14px;

    line-height: 1.6;
}

.read-more {
    color:
        var(--primary);

    font-size: 14px;

    font-weight: 700;

    transition:
        .2s ease;
}

.read-more:hover {
    color:
        var(--primary-dark);

    padding-left:
        5px;
}


/* =========================================================
   VISI MISI
   ========================================================= */

.info-grid {
    display: grid;

    grid-template-columns:
        1.1fr .9fr;

    gap: 28px;
}

.card {
    background:
        white;

    padding:
        32px;

    border-radius:
        var(--radius);

    box-shadow:
        var(--shadow-sm);

    transition:
        .25s ease;
}

.card:hover {
    box-shadow:
        var(--shadow-md);
}

.card h3 {
    margin:
        0 0 22px;

    display:
        flex;

    align-items:
        center;

    gap: 10px;

    font-size: 21px;
}

.card h3::before {
    content: '';

    width: 8px;

    height: 22px;

    background:
        var(--primary);

    border-radius:
        4px;
}

.visi h4,
.misi h4 {
    margin:
        0 0 10px;

    color:
        var(--primary);

    font-size: 14px;

    font-weight: 800;

    letter-spacing: .5px;

    text-transform: uppercase;
}

.visi p {
    margin:
        0 0 27px;

    padding:
        15px 18px;

    background:
        var(--primary-light);

    border-left:
        4px solid var(--primary);

    border-radius:
        0 10px 10px 0;

    line-height: 1.7;

    font-style: italic;
}

.misi ul {
    list-style: none;

    padding: 0;

    margin: 0;
}

.misi li {
    position: relative;

    padding:
        10px 0 10px 30px;

    border-bottom:
        1px dashed var(--border);

    line-height: 1.6;
}

.misi li::before {
    content: '✓';

    position: absolute;

    left: 0;

    top: 10px;

    width: 20px;

    height: 20px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 50%;

    background:
        var(--accent);

    color:
        white;

    font-size: 12px;

    font-weight: 800;
}

.info-singkat-body {
    color:
        var(--text-muted);

    line-height:
        1.8;
}


/* =========================================================
   PRESTASI
   ========================================================= */

.prestasi-grid {
    display: grid;

    grid-template-columns:
        repeat(3, 1fr);

    gap: 22px;
}

.prestasi-card {
    position: relative;

    background:
        white;

    padding:
        30px 25px;

    border-radius:
        var(--radius);

    box-shadow:
        var(--shadow-sm);

    transition:
        .25s ease;

    overflow: hidden;
}

.prestasi-card::after {
    content: '';

    position: absolute;

    width: 90px;

    height: 90px;

    right: -35px;

    top: -35px;

    border-radius: 50%;

    background:
        var(--primary-light);
}

.prestasi-card:hover {
    transform:
        translateY(-6px);

    box-shadow:
        var(--shadow-md);
}

.prestasi-icon {
    font-size:
        40px;

    margin-bottom:
        15px;
}

.prestasi-card h3 {
    margin:
        0 0 10px;

    font-size: 19px;
}

.prestasi-card p {
    margin:
        0 0 15px;

    color:
        var(--text-muted);

    line-height:
        1.6;

    font-size: 14px;
}

.tahun {
    display: inline-block;

    padding:
        5px 12px;

    border-radius:
        999px;

    background:
        var(--primary-light);

    color:
        var(--primary);

    font-size: 12px;

    font-weight: 700;
}


/* =========================================================
   GALERI
   ========================================================= */

.gallery-grid {
    display: grid;

    grid-template-columns:
        repeat(3, 1fr);

    gap: 18px;
}

.gallery-item {
    position: relative;

    height: 230px;

    border-radius:
        var(--radius);

    overflow: hidden;

    cursor: pointer;

    box-shadow:
        var(--shadow-sm);
}

.gallery-item img {
    width: 100%;

    height: 100%;

    object-fit: cover;

    transition:
        transform .4s ease;
}

.gallery-overlay {
    position: absolute;

    inset: 0;

    display: flex;

    align-items: flex-end;

    padding: 20px;

    background:
        linear-gradient(
            transparent,
            rgba(0,0,0,.75)
        );

    color: white;

    font-weight: 700;

    opacity: 0;

    transition:
        .3s ease;
}

.gallery-item:hover img {
    transform:
        scale(1.08);
}

.gallery-item:hover .gallery-overlay {
    opacity: 1;
}


/* =========================================================
   AGENDA
   ========================================================= */

.agenda-list {
    display: grid;

    gap: 16px;

    max-width: 850px;

    margin:
        auto;
}

.agenda-item {
    display: flex;

    align-items: center;

    gap: 20px;

    background:
        white;

    padding:
        20px;

    border-radius:
        var(--radius);

    box-shadow:
        var(--shadow-sm);

    transition:
        .25s ease;
}

.agenda-item:hover {
    transform:
        translateX(5px);

    box-shadow:
        var(--shadow-md);
}

.agenda-date {
    flex:
        0 0 65px;

    text-align: center;

    overflow: hidden;

    border-radius:
        12px;

    background:
        var(--primary);

    color: white;
}

.agenda-date strong {
    display: block;

    padding:
        7px;

    background:
        var(--primary-dark);

    font-size:
        12px;
}

.agenda-date span {
    display: block;

    padding:
        8px 5px;

    font-size:
        25px;

    font-weight:
        800;
}

.agenda-content h3 {
    margin:
        0 0 5px;

    font-size:
        17px;
}

.agenda-content p {
    margin: 0;

    color:
        var(--text-muted);

    font-size:
        14px;
}


/* =========================================================
   FASILITAS
   ========================================================= */

.fasilitas-grid {
    display: grid;

    grid-template-columns:
        repeat(4, 1fr);

    gap: 18px;
}

.fasilitas-card {
    padding:
        28px 20px;

    text-align:
        center;

    background:
        white;

    border-radius:
        var(--radius);

    box-shadow:
        var(--shadow-sm);

    transition:
        .25s ease;
}

.fasilitas-card:hover {
    transform:
        translateY(-5px);

    box-shadow:
        var(--shadow-md);
}

.fasilitas-icon {
    font-size:
        38px;

    margin-bottom:
        13px;
}

.fasilitas-card h3 {
    margin:
        0 0 8px;

    font-size:
        17px;
}

.fasilitas-card p {
    margin: 0;

    color:
        var(--text-muted);

    font-size:
        13px;

    line-height:
        1.6;
}


/* =========================================================
   KONTAK
   ========================================================= */

.contact-section {
    background:
        linear-gradient(
            135deg,
            #0d6efd,
            #084298
        );

    color:
        white;
}

.contact-inner {
    max-width:
        1200px;

    margin:
        auto;

    padding:
        75px 24px;

    display: grid;

    grid-template-columns:
        1fr 1fr;

    gap:
        50px;

    align-items:
        center;
}

.contact-content h2 {
    margin:
        0 0 15px;

    font-size:
        clamp(28px, 4vw, 40px);
}

.contact-content p {
    color:
        rgba(255,255,255,.85);

    line-height:
        1.8;
}

.contact-info {
    display:
        grid;

    gap:
        13px;

    margin-top:
        25px;
}

.contact-item {
    display:
        flex;

    align-items:
        flex-start;

    gap:
        12px;

    color:
        white;

    line-height:
        1.6;
}

.contact-icon {
    width:
        38px;

    height:
        38px;

    flex:
        0 0 38px;

    display:
        flex;

    align-items:
        center;

    justify-content:
        center;

    border-radius:
        10px;

    background:
        rgba(255,255,255,.14);
}

.map-box {
    min-height:
        330px;

    border-radius:
        var(--radius);

    overflow:
        hidden;

    background:
        rgba(255,255,255,.1);

    border:
        1px solid rgba(255,255,255,.2);

    display:
        flex;

    align-items:
        center;

    justify-content:
        center;

    text-align:
        center;

    padding:
        30px;
}

.map-placeholder {
    font-size:
        50px;

    margin-bottom:
        15px;
}

.map-box p {
    margin: 0;

    color:
        rgba(255,255,255,.8);
}


/* =========================================================
   CTA
   ========================================================= */

.cta {
    max-width:
        1150px;

    margin:
        0 auto;

    padding:
        55px 30px;

    text-align:
        center;

    background:
        white;

    border-radius:
        var(--radius);

    box-shadow:
        var(--shadow-md);
}

.cta h2 {
    margin:
        0 0 12px;

    font-size:
        clamp(25px, 4vw, 34px);
}

.cta p {
    max-width:
        650px;

    margin:
        0 auto 25px;

    color:
        var(--text-muted);

    line-height:
        1.7;
}


/* =========================================================
   EMPTY STATE
   ========================================================= */

.empty-state {
    width: 100%;

    padding:
        40px;

    text-align:
        center;

    color:
        var(--text-muted);

    background:
        white;

    border-radius:
        var(--radius);
}


/* =========================================================
   RESPONSIVE
   ========================================================= */

@media(max-width: 950px) {

    .stats-box {
        grid-template-columns:
            repeat(2, 1fr);
    }

    .stat-item:nth-child(2) {
        border-right: none;
    }

    .stat-item:nth-child(-n+2) {
        border-bottom:
            1px solid var(--border);
    }

    .sambutan {
        grid-template-columns:
            1fr;
    }

    .sambutan-photo {
        min-height:
            300px;
    }

    .info-grid {
        grid-template-columns:
            1fr;
    }

    .prestasi-grid {
        grid-template-columns:
            repeat(2, 1fr);
    }

    .gallery-grid {
        grid-template-columns:
            repeat(2, 1fr);
    }

    .fasilitas-grid {
        grid-template-columns:
            repeat(2, 1fr);
    }

    .contact-inner {
        grid-template-columns:
            1fr;
    }
}


@media(max-width: 600px) {

    .section {
        padding:
            60px 18px;
    }

    .stats-section {
        margin-top:
            -30px;

        padding-left:
            15px;

        padding-right:
            15px;
    }

    .stats-box {
        grid-template-columns:
            repeat(2, 1fr);
    }

    .stat-item {
        padding:
            23px 10px;
    }

    .stat-number {
        font-size:
            27px;
    }

    .hero {
        min-height:
            85vh;
    }

    .hero h1 {
        font-size:
            32px;
    }

    .hero p {
        font-size:
            15px;
    }

    .prestasi-grid {
        grid-template-columns:
            1fr;
    }

    .gallery-grid {
        grid-template-columns:
            1fr;
    }

    .gallery-item {
        height:
            220px;
    }

    .fasilitas-grid {
        grid-template-columns:
            1fr 1fr;
    }

    .agenda-item {
        gap:
            13px;

        padding:
            15px;
    }

    .agenda-date {
        flex-basis:
            58px;
    }

    .contact-inner {
        padding:
            60px 20px;
    }

}

</style>


<!-- =========================================================
     HERO
     ========================================================= -->

<section class="hero">

    <?php if($heroVideo): ?>

        <video
            autoplay
            muted
            loop
            playsinline
            class="hero-video">

            <source
                src="<?= $heroVideo ?>"
                type="video/mp4">

            Browser Anda tidak mendukung video.

        </video>

    <?php else: ?>

        <img
            src="<?= $heroImage ?>"
            alt="MI Aditirto"
            class="hero-video">

    <?php endif; ?>


    <div class="hero-overlay">

        <span class="hero-badge">
            Madrasah Ibtidaiyah
        </span>


        <h1>
            <?= e(
                $info['hero_title']
                ?? 'Selamat Datang di MI Ma\'arif Aditirto'
            ) ?>
        </h1>


        <p>
            <?= e(
                $info['hero_subtitle']
                ?? 'Sekolah dasar berbasis madrasah yang berkomitmen pada akhlak, ilmu, dan prestasi.'
            ) ?>
        </p>


        <div class="hero-buttons">

            <a
                href="#tentang"
                class="btn-primary">

                Tentang Kami

            </a>


            <a
                href="#berita"
                class="btn-outline">

                Lihat Kegiatan

            </a>

        </div>

    </div>


    <div class="hero-scroll">
        ↓
    </div>

</section>


<!-- =========================================================
     STATISTIK
     ========================================================= -->

<section class="stats-section">

    <div class="section" style="padding-top:0;padding-bottom:0;">

        <div class="stats-box">

            <?php foreach($statistik as $stat): ?>

                <div class="stat-item">

                    <div class="stat-number">
                        <?= e($stat['angka']) ?>
                    </div>

                    <div class="stat-label">
                        <?= e($stat['label']) ?>
                    </div>

                </div>

            <?php endforeach; ?>

        </div>

    </div>

</section>


<!-- =========================================================
     SAMBUTAN / TENTANG
     ========================================================= -->

<section
    class="section"
    id="tentang">

    <div class="sambutan">

        <div class="sambutan-photo">

            <img
                src="<?= $heroImage ?>"
                alt="MI Aditirto">

        </div>


        <div class="sambutan-content">

            <span class="eyebrow">
                Tentang Madrasah
            </span>

            <h2>
                Membangun Generasi Berilmu dan Berakhlak
            </h2>

            <p>
                MI Ma'arif Aditirto merupakan lembaga pendidikan
                dasar yang berkomitmen memberikan pendidikan yang
                seimbang antara ilmu pengetahuan, pembentukan
                karakter, akhlak, serta nilai-nilai keagamaan.
            </p>

            <p>
                Melalui lingkungan belajar yang nyaman dan kegiatan
                yang beragam, madrasah terus berupaya mendukung
                perkembangan potensi setiap peserta didik agar
                menjadi generasi yang berprestasi, mandiri, dan
                berakhlak mulia.
            </p>


            <div class="kepala">

                <strong>
                    Kepala Madrasah
                </strong>

                <span>
                    MI Ma'arif Aditirto
                </span>

            </div>

        </div>

    </div>

</section>


<!-- =========================================================
     BERITA
     ========================================================= -->

<section
    class="section"
    id="berita">

    <div class="section-head">

        <span class="eyebrow">
            Kabar Terbaru
        </span>

        <h2>
            Berita & Kegiatan
        </h2>

        <div class="underline"></div>

    </div>


    <div class="berita-scroll">

        <?php if(!empty($beritaList)): ?>

            <?php foreach($beritaList as $b): ?>

                <div class="berita-card">

                    <div class="thumb-wrap">

                        <?php if(!empty($b['video'])): ?>

                            <?php if(
                                preg_match(
                                    '/^https?:\/\//',
                                    $b['video']
                                )
                            ): ?>

                                <iframe
                                    src="<?= e($b['video']) ?>"
                                    allowfullscreen>
                                </iframe>

                            <?php else: ?>

                                <video controls>

                                    <source
                                        src="uploads/berita/<?= e($b['video']) ?>"
                                        type="video/mp4">

                                    Browser Anda tidak mendukung video.

                                </video>

                            <?php endif; ?>


                        <?php elseif(!empty($b['gambar'])): ?>

                            <img
                                src="uploads/berita/<?= e($b['gambar']) ?>"
                                alt="<?= e($b['judul']) ?>">


                        <?php else: ?>

                            <img
                                src="assets/no-image.jpg"
                                alt="Tidak ada gambar">

                        <?php endif; ?>


                        <span class="date-chip">

                            <?= date(
                                'd M Y',
                                strtotime($b['tanggal'])
                            ) ?>

                        </span>

                    </div>


                    <div class="berita-content">

                        <h3>
                            <?= e($b['judul']) ?>
                        </h3>


                        <p>

                            <?= nl2br(
                                e(
                                    mb_substr(
                                        $b['isi'],
                                        0,
                                        100
                                    )
                                )
                            ) ?>

                            ...

                        </p>


                        <a
                            class="read-more"
                            href="berita_detail.php?id=<?= (int)$b['id'] ?>">

                            Baca selengkapnya →

                        </a>

                    </div>

                </div>

            <?php endforeach; ?>

        <?php else: ?>

            <div class="empty-state">

                Belum ada berita atau kegiatan.

            </div>

        <?php endif; ?>

    </div>

</section>


<!-- =========================================================
     VISI MISI
     ========================================================= -->

<section
    class="section"
    style="padding-top:0;">

    <div class="info-grid">


        <!-- VISI MISI -->

        <div class="card">

            <h3>
                Visi & Misi
            </h3>


            <div class="visi">

                <h4>
                    Visi
                </h4>

                <p>

                    <?= e(
                        $info['visi']
                        ?? 'Menjadi madrasah yang unggul dalam ilmu pengetahuan, berakhlak mulia, dan berprestasi.'
                    ) ?>

                </p>

            </div>


            <div class="misi">

                <h4>
                    Misi
                </h4>

                <ul>

                    <?php if(!empty($misi_list)): ?>

                        <?php foreach($misi_list as $m): ?>

                            <li>
                                <?= e(trim($m)) ?>
                            </li>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <li>
                            Menyelenggarakan pendidikan yang berkualitas.
                        </li>

                        <li>
                            Membentuk peserta didik yang berakhlak mulia.
                        </li>

                        <li>
                            Mengembangkan potensi dan kreativitas siswa.
                        </li>

                    <?php endif; ?>

                </ul>

            </div>

        </div>


        <!-- INFO -->

        <div class="card">

            <h3>
                Info Singkat
            </h3>

            <p class="info-singkat-body">

                <?= e(
                    $info['info_singkat']
                    ?? 'MI Ma\'arif Aditirto berkomitmen memberikan pendidikan yang berkualitas dengan mengedepankan nilai akademik, karakter, dan keagamaan.'
                ) ?>

            </p>


            <div
                style="
                    margin-top:25px;
                    padding:18px;
                    border-radius:12px;
                    background:#eaf3ff;
                ">

                <strong
                    style="
                        color:#0d6efd;
                        display:block;
                        margin-bottom:5px;
                    ">

                    Pendidikan untuk Masa Depan

                </strong>


                <span
                    style="
                        color:#687585;
                        font-size:14px;
                        line-height:1.6;
                    ">

                    Mendukung setiap siswa untuk berkembang
                    sesuai dengan potensi dan kemampuannya.

                </span>

            </div>

        </div>

    </div>

</section>


<!-- =========================================================
     PRESTASI
     ========================================================= -->

<section class="section">

    <div class="section-head">

        <span class="eyebrow">
            Pencapaian
        </span>

        <h2>
            Prestasi & Penghargaan
        </h2>

        <div class="underline"></div>

    </div>


    <div class="prestasi-grid">

        <?php foreach($prestasi as $p): ?>

            <div class="prestasi-card">

                <div class="prestasi-icon">
                    <?= $p['icon'] ?>
                </div>


                <h3>
                    <?= e($p['judul']) ?>
                </h3>


                <p>
                    <?= e($p['keterangan']) ?>
                </p>


                <span class="tahun">
                    <?= e($p['tahun']) ?>
                </span>

            </div>

        <?php endforeach; ?>

    </div>

</section>


<!-- =========================================================
     GALERI
     ========================================================= -->

<section
    class="section"
    style="padding-top:20px;">

    <div class="section-head">

        <span class="eyebrow">
            Dokumentasi
        </span>

        <h2>
            Galeri Kegiatan
        </h2>

        <div class="underline"></div>

    </div>


    <div class="gallery-grid">

        <?php foreach($galeri as $g): ?>

            <div class="gallery-item">

                <img
                    src="<?= e($g['gambar']) ?>"
                    alt="<?= e($g['judul']) ?>">

                <div class="gallery-overlay">

                    <?= e($g['judul']) ?>

                </div>

            </div>

        <?php endforeach; ?>

    </div>

</section>


<!-- =========================================================
     AGENDA
     ========================================================= -->

<section
    class="section"
    style="padding-top:20px;">

    <div class="section-head">

        <span class="eyebrow">
            Kegiatan Mendatang
        </span>

        <h2>
            Agenda Madrasah
        </h2>

        <div class="underline"></div>

    </div>


    <div class="agenda-list">

        <?php foreach($agenda as $a): ?>

            <div class="agenda-item">

                <div class="agenda-date">

                    <strong>
                        <?= e($a['bulan']) ?>
                    </strong>

                    <span>
                        <?= e($a['tanggal']) ?>
                    </span>

                </div>


                <div class="agenda-content">

                    <h3>
                        <?= e($a['judul']) ?>
                    </h3>

                    <p>
                        <?= e($a['keterangan']) ?>
                    </p>

                </div>

            </div>

        <?php endforeach; ?>

    </div>

</section>


<!-- =========================================================
     FASILITAS
     ========================================================= -->

<section
    class="section"
    style="padding-top:20px;">

    <div class="section-head">

        <span class="eyebrow">
            Sarana & Prasarana
        </span>

        <h2>
            Fasilitas Madrasah
        </h2>

        <div class="underline"></div>

    </div>


    <div class="fasilitas-grid">

        <?php foreach($fasilitas as $f): ?>

            <div class="fasilitas-card">

                <div class="fasilitas-icon">
                    <?= $f['icon'] ?>
                </div>


                <h3>
                    <?= e($f['judul']) ?>
                </h3>


                <p>
                    <?= e($f['keterangan']) ?>
                </p>

            </div>

        <?php endforeach; ?>

    </div>

</section>


<!-- =========================================================
     CTA
     ========================================================= -->

<section class="section">

    <div class="cta">

        <span class="eyebrow">
            MI Ma'arif Aditirto
        </span>

        <h2>
            Bersama Membangun Generasi Unggul
        </h2>

        <p>
            Pendidikan bukan hanya tentang memperoleh ilmu,
            tetapi juga membentuk karakter dan mempersiapkan
            generasi untuk masa depan.
        </p>


        <a
            href="#kontak"
            class="btn-primary">

            Hubungi Kami

        </a>

    </div>

</section>


<!-- =========================================================
     KONTAK + LOKASI
     ========================================================= -->

<section
    class="contact-section"
    id="kontak">

    <div class="contact-inner">


        <div class="contact-content">

            <span
                class="eyebrow"
                style="color:#ffcf4a;">

                Hubungi Kami

            </span>


            <h2>
                Mari Berkunjung ke MI Aditirto
            </h2>


            <p>
                Untuk informasi lebih lanjut mengenai madrasah,
                kegiatan, maupun layanan pendidikan, silakan
                menghubungi kami melalui informasi berikut.
            </p>


            <div class="contact-info">


                <div class="contact-item">

                    <div class="contact-icon">
                        📍
                    </div>

                    <div>
                        <strong>
                            Alamat
                        </strong>

                        <br>

                        MI Ma'arif Aditirto
                    </div>

                </div>


                <div class="contact-item">

                    <div class="contact-icon">
                        📞
                    </div>

                    <div>
                        <strong>
                            Telepon
                        </strong>

                        <br>

                        08xxxxxxxxxx
                    </div>

                </div>


                <div class="contact-item">

                    <div class="contact-icon">
                        ✉️
                    </div>

                    <div>
                        <strong>
                            Email
                        </strong>

                        <br>

                        email@sekolah.sch.id
                    </div>

                </div>


            </div>

        </div>


        <!-- MAP -->

        <div class="map-box">

            <div>

                <div class="map-placeholder">
                    📍
                </div>

                <h3>
                    Lokasi MI Aditirto
                </h3>

                <p>
                    Google Maps dapat ditempatkan di bagian ini.
                </p>

            </div>

        </div>

    </div>

</section>


<?php include __DIR__.'/partials/footer.php'; ?>