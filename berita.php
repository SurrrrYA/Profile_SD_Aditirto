<?php

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/helpers.php';

$title = 'Berita & Kegiatan - MI Aditirto';

$stmt = $pdo->query("
    SELECT id, judul, isi, gambar, video, tanggal
    FROM berita
    ORDER BY tanggal DESC, id DESC
");

$berita = $stmt->fetchAll(PDO::FETCH_ASSOC);

include __DIR__ . '/partials/header.php';

?>

<style>
    .berita-page {
        background: #f7f9fc;
        min-height: calc(100vh - 74px);
        padding: 70px 24px 90px;
    }

    .berita-container {
        max-width: 1200px;
        margin: auto;
    }

    .berita-header {
        text-align: center;
        margin-bottom: 45px;
    }

    .berita-label {
        display: inline-block;
        color: #0d6efd;
        background: #e8f1ff;
        padding: 7px 15px;
        border-radius: 30px;
        font-size: 13px;
        font-weight: 700;
        margin-bottom: 12px;
    }

    .berita-header h1 {
        margin: 0 0 12px;
        font-size: 38px;
        color: #1c2733;
    }

    .berita-header p {
        max-width: 650px;
        margin: auto;
        color: #6b7785;
        line-height: 1.7;
    }

    .berita-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 28px;
    }

    .berita-card {
        background: #fff;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 8px 30px rgba(13, 38, 76, 0.08);
        transition: transform .25s ease, box-shadow .25s ease;
        display: flex;
        flex-direction: column;
    }

    .berita-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 15px 35px rgba(13, 38, 76, 0.13);
    }

    .berita-image {
        width: 100%;
        height: 220px;
        object-fit: cover;
        display: block;
    }

    .berita-image-placeholder {
        width: 100%;
        height: 220px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #e8f1ff;
        color: #0d6efd;
        font-size: 45px;
    }

    .berita-content {
        padding: 22px;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .berita-date {
        color: #0d6efd;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 10px;
    }

    .berita-content h2 {
        font-size: 21px;
        line-height: 1.4;
        margin: 0 0 12px;
        color: #1c2733;
    }

    .berita-excerpt {
        color: #6b7785;
        line-height: 1.7;
        font-size: 14px;
        margin: 0 0 20px;

        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .berita-button {
        margin-top: auto;
        display: inline-block;
        text-decoration: none;
        color: #fff;
        background: #0d6efd;
        padding: 10px 17px;
        border-radius: 9px;
        font-size: 14px;
        font-weight: 600;
        text-align: center;
        transition: background .2s ease;
    }

    .berita-button:hover {
        background: #0a4fc4;
    }

    .berita-empty {
        text-align: center;
        background: #fff;
        padding: 60px 20px;
        border-radius: 18px;
        color: #6b7785;
    }

    @media (max-width: 900px) {
        .berita-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 600px) {
        .berita-page {
            padding: 50px 16px 70px;
        }

        .berita-header h1 {
            font-size: 30px;
        }

        .berita-grid {
            grid-template-columns: 1fr;
        }

        .berita-image,
        .berita-image-placeholder {
            height: 210px;
        }
    }
</style>

<section class="berita-page">

    <div class="berita-container">

        <div class="berita-header">

            <span class="berita-label">
                INFORMASI TERKINI
            </span>

            <h1>
                Berita & Kegiatan
            </h1>

            <p>
                Informasi terbaru mengenai kegiatan, prestasi,
                dan berbagai aktivitas yang berlangsung di MI Aditirto.
            </p>

        </div>


        <?php if (empty($berita)): ?>

            <div class="berita-empty">

                <h3>
                    Belum Ada Berita
                </h3>

                <p>
                    Saat ini belum terdapat berita atau kegiatan
                    yang dipublikasikan.
                </p>

            </div>

        <?php else: ?>

            <div class="berita-grid">

                <?php foreach ($berita as $item): ?>

                    <article class="berita-card">

                        <?php if (!empty($item['gambar'])): ?>

                            <img
                                src="uploads/berita/<?= e($item['gambar']) ?>"
                                alt="<?= e($item['judul']) ?>"
                                class="berita-image"
                            >

                        <?php else: ?>

                            <div class="berita-image-placeholder">
                                📰
                            </div>

                        <?php endif; ?>


                        <div class="berita-content">

                            <div class="berita-date">
                                <?= date('d M Y', strtotime($item['tanggal'])) ?>
                            </div>

                            <h2>
                                <?= e($item['judul']) ?>
                            </h2>

                            <p class="berita-excerpt">
                                <?= e(strip_tags($item['isi'])) ?>
                            </p>

                            <a
                                href="berita_detail.php?id=<?= (int) $item['id'] ?>"
                                class="berita-button"
                            >
                                Baca Selengkapnya →
                            </a>

                        </div>

                    </article>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>

    </div>

</section>

<?php

include __DIR__ . '/partials/footer.php';

?>