<?php

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/helpers.php';

$title = 'Detail Berita - MI Aditirto';

// Ambil ID berita
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// Validasi ID
if ($id <= 0) {
    header('Location: berita.php');
    exit;
}

// Ambil data berita
$stmt = $pdo->prepare("
    SELECT id, judul, isi, gambar, video, tanggal
    FROM berita
    WHERE id = ?
    LIMIT 1
");

$stmt->execute([$id]);

$berita = $stmt->fetch(PDO::FETCH_ASSOC);

// Jika berita tidak ditemukan
if (!$berita) {

    include __DIR__ . '/partials/header.php';
    ?>

    <div class="berita-not-found">

        <div class="not-found-icon">
            📰
        </div>

        <h2>Berita Tidak Ditemukan</h2>

        <p>
            Berita yang kamu cari tidak tersedia atau mungkin sudah dihapus.
        </p>

        <a href="berita.php" class="back-button">
            ← Kembali ke Berita
        </a>

    </div>

    <?php
    include __DIR__ . '/partials/footer.php';
    exit;
}

// Format tanggal
$tanggal = date('d M Y', strtotime($berita['tanggal']));

include __DIR__ . '/partials/header.php';

?>

<style>

/* =========================================================
   DETAIL BERITA
========================================================= */

.detail-page {
    background: #f7f9fc;
    min-height: calc(100vh - 74px);
    padding: 45px 20px 80px;
}

.detail-wrapper {
    max-width: 950px;
    margin: 0 auto;
}


/* =========================================================
   BREADCRUMB
========================================================= */

.detail-breadcrumb {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 25px;
    font-size: 14px;
    color: #7a8794;
}

.detail-breadcrumb a {
    color: #0d6efd;
    text-decoration: none;
    font-weight: 600;
}

.detail-breadcrumb a:hover {
    text-decoration: underline;
}

.detail-breadcrumb .separator {
    color: #b4bdc8;
}


/* =========================================================
   ARTICLE
========================================================= */

.detail-card {
    background: #ffffff;
    border-radius: 22px;
    overflow: hidden;
    box-shadow: 0 12px 40px rgba(13, 38, 76, 0.08);
}


/* =========================================================
   HEADER ARTIKEL
========================================================= */

.detail-header {
    padding: 38px 45px 25px;
}

.detail-label {
    display: inline-flex;
    align-items: center;
    padding: 7px 14px;
    border-radius: 30px;
    background: #e8f1ff;
    color: #0d6efd;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: .4px;
    margin-bottom: 16px;
}

.detail-title {
    font-size: 40px;
    line-height: 1.25;
    color: #17212b;
    margin: 0 0 16px;
    font-weight: 750;
}

.detail-meta {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #7a8794;
    font-size: 14px;
}

.detail-meta-icon {
    font-size: 15px;
}


/* =========================================================
   GAMBAR UTAMA
========================================================= */

.detail-cover {
    width: 100%;
    max-height: 520px;
    object-fit: cover;
    display: block;
}

.detail-cover-placeholder {
    width: 100%;
    height: 380px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(
        135deg,
        #e8f1ff,
        #f4f7fb
    );
    color: #0d6efd;
    font-size: 65px;
}


/* =========================================================
   ISI BERITA
========================================================= */

.detail-body {
    padding: 35px 45px 45px;
}

.detail-content {
    color: #414b55;
    font-size: 17px;
    line-height: 1.9;
    word-wrap: break-word;
}

.detail-content p {
    margin: 0 0 20px;
}


/* =========================================================
   VIDEO
========================================================= */

.detail-video-wrapper {
    margin: 35px 0 10px;
}

.detail-video-title {
    font-size: 18px;
    color: #1c2733;
    font-weight: 700;
    margin-bottom: 15px;
}

.detail-video {
    width: 100%;
    aspect-ratio: 16 / 9;
    border: none;
    border-radius: 15px;
    background: #000;
    display: block;
}

.detail-video-file {
    width: 100%;
    border-radius: 15px;
    background: #000;
    display: block;
}


/* =========================================================
   FOOTER ARTIKEL
========================================================= */

.detail-footer {
    margin-top: 35px;
    padding-top: 25px;
    border-top: 1px solid #edf0f4;
}

.back-button {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 11px 18px;
    background: #0d6efd;
    color: #ffffff;
    text-decoration: none;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    transition: .25s ease;
}

.back-button:hover {
    background: #0a4fc4;
    transform: translateX(-3px);
}


/* =========================================================
   NOT FOUND
========================================================= */

.berita-not-found {
    max-width: 700px;
    margin: 100px auto;
    padding: 60px 25px;
    text-align: center;
}

.not-found-icon {
    font-size: 60px;
    margin-bottom: 20px;
}

.berita-not-found h2 {
    color: #1c2733;
    margin-bottom: 10px;
}

.berita-not-found p {
    color: #7a8794;
    margin-bottom: 25px;
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 768px) {

    .detail-page {
        padding: 30px 15px 60px;
    }

    .detail-header {
        padding: 28px 25px 22px;
    }

    .detail-title {
        font-size: 30px;
    }

    .detail-body {
        padding: 28px 25px 35px;
    }

    .detail-content {
        font-size: 16px;
        line-height: 1.8;
    }

    .detail-cover {
        max-height: 400px;
    }

    .detail-cover-placeholder {
        height: 280px;
    }

}

@media (max-width: 480px) {

    .detail-breadcrumb {
        font-size: 13px;
    }

    .detail-header {
        padding: 25px 20px 20px;
    }

    .detail-title {
        font-size: 25px;
    }

    .detail-body {
        padding: 25px 20px 30px;
    }

    .detail-meta {
        font-size: 13px;
    }

    .detail-cover {
        max-height: 300px;
    }

    .detail-cover-placeholder {
        height: 220px;
    }

}

</style>


<section class="detail-page">

    <div class="detail-wrapper">


        <!-- BREADCRUMB -->

        <div class="detail-breadcrumb">

            <a href="index.php">
                Home
            </a>

            <span class="separator">
                /
            </span>

            <a href="berita.php">
                Berita
            </a>

            <span class="separator">
                /
            </span>

            <span>
                Detail
            </span>

        </div>


        <!-- ARTIKEL -->

        <article class="detail-card">


            <!-- HEADER ARTIKEL -->

            <header class="detail-header">

                <span class="detail-label">
                    BERITA & KEGIATAN
                </span>

                <h1 class="detail-title">
                    <?= e($berita['judul']) ?>
                </h1>

                <div class="detail-meta">

                  
                    </span>

                    <span>
                        Dipublikasikan pada <?= e($tanggal) ?>
                    </span>

                </div>

            </header>


            <!-- GAMBAR UTAMA -->

            <?php if (!empty($berita['gambar'])): ?>

                <img
                    src="uploads/berita/<?= e($berita['gambar']) ?>"
                    alt="<?= e($berita['judul']) ?>"
                    class="detail-cover"
                >

            <?php else: ?>

                <div class="detail-cover-placeholder">
                    📰
                </div>

            <?php endif; ?>


            <!-- ISI -->

            <div class="detail-body">

                <div class="detail-content">

                    <?= nl2br(e($berita['isi'])) ?>

                </div>


                <!-- VIDEO -->

                <?php if (!empty($berita['video'])): ?>

                    <div class="detail-video-wrapper">

                        <div class="detail-video-title">
                            Dokumentasi Video
                        </div>


                        <?php

                        $video = trim($berita['video']);

                        /*
                         * Jika video merupakan link YouTube
                         */
                        if (
                            preg_match(
                                '/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&\?\/]+)/',
                                $video,
                                $matches
                            )
                        ):

                            $youtubeId = $matches[1];

                        ?>

                            <iframe
                                class="detail-video"
                                src="https://www.youtube.com/embed/<?= e($youtubeId) ?>"
                                title="<?= e($berita['judul']) ?>"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                            </iframe>


                        <?php elseif (preg_match('/^https?:\/\//', $video)): ?>

                            <!-- Link video lainnya -->

                            <iframe
                                class="detail-video"
                                src="<?= e($video) ?>"
                                title="<?= e($berita['judul']) ?>"
                                allowfullscreen>
                            </iframe>


                        <?php else: ?>

                            <!-- Video hasil upload -->

                            <video
                                class="detail-video-file"
                                controls
                                preload="metadata"
                            >

                                <source
                                    src="uploads/berita/<?= e($video) ?>"
                                    type="video/mp4"
                                >

                                Browser Anda tidak mendukung pemutar video.

                            </video>

                        <?php endif; ?>

                    </div>

                <?php endif; ?>


                <!-- FOOTER ARTIKEL -->

                <div class="detail-footer">

                    <a
                        href="berita.php"
                        class="back-button"
                    >
                        ← Kembali ke Berita
                    </a>

                </div>

            </div>

        </article>

    </div>

</section>


<?php

include __DIR__ . '/partials/footer.php';

?>