<?php

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../helpers.php';

require_login();

$title = 'Kelola Berita';

/* =====================================================
   AMBIL SEMUA BERITA
===================================================== */

$stmt = $pdo->query("
    SELECT *
    FROM berita
    ORDER BY tanggal DESC
");

$berita = $stmt->fetchAll(PDO::FETCH_ASSOC);


/* =====================================================
   ADMIN HEADER
===================================================== */

include __DIR__ . '/../partials/admin_header.php';


/* =====================================================
   ADMIN SIDEBAR
===================================================== */

include __DIR__ . '/../partials/admin_sidebar.php';

?>


<!-- =====================================================
     ADMIN MAIN
===================================================== -->

<div class="admin-main">


    <!-- ================================================
         TOPBAR
    ================================================= -->

    <header class="admin-topbar">

        <div
            style="
                display:flex;
                align-items:center;
                gap:12px;
            "
        >

            <button
                type="button"
                class="sidebar-toggle"
                id="sidebarToggle"
                aria-label="Buka menu"
            >
                ☰
            </button>

            <div class="admin-page-title">
                Kelola Berita
            </div>

        </div>


        <div class="admin-user">

            <div class="admin-avatar">
                A
            </div>

            <div class="admin-user-info">

                <strong>
                    Administrator
                </strong>

                <span>
                    Admin
                </span>

            </div>

        </div>

    </header>


    <!-- ================================================
         CONTENT
    ================================================= -->

    <main class="admin-content">


        <!-- ============================================
             PAGE HEADER
        ============================================= -->

        <div class="page-header">

            <div>

                <h1>
                    Kelola Berita
                </h1>

                <p>
                    Tambahkan, ubah, atau hapus berita
                    yang ditampilkan pada website.
                </p>

            </div>


            <a
                href="berita_form.php"
                class="btn-primary"
            >
                + Tambah Berita
            </a>

        </div>


        <!-- ============================================
             TABLE CARD
        ============================================= -->

        <section class="table-card">


            <div class="table-card-header">

                <div>

                    <h2>
                        Daftar Berita
                    </h2>

                    <p>
                        <?= count($berita) ?> berita tersimpan
                    </p>

                </div>

            </div>


            <div class="table-wrapper">

                <table class="data-table">

                    <thead>

                        <tr>

                            <th width="60">
                                No
                            </th>

                            <th>
                                Judul
                            </th>

                            <th width="120">
                                Tanggal
                            </th>

                            <th width="130">
                                Gambar
                            </th>

                            <th width="150">
                                Video
                            </th>

                            <th width="150">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody>


                        <?php if ($berita): ?>


                            <?php foreach ($berita as $i => $b): ?>

                                <tr>


                                    <!-- NO -->

                                    <td class="text-center">

                                        <?= $i + 1 ?>

                                    </td>


                                    <!-- JUDUL -->

                                    <td>

                                        <div class="news-title">

                                            <?= e($b['judul']) ?>

                                        </div>

                                    </td>


                                    <!-- TANGGAL -->

                                    <td class="text-center">

                                        <span class="date-badge">

                                       
                                            <?= e($b['tanggal']) ?>

                                        </span>

                                    </td>


                                    <!-- GAMBAR -->

                                    <td class="text-center">

                                        <?php

                                        $imagePath =
                                            __DIR__ .
                                            "/../uploads/berita/" .
                                            ($b['gambar'] ?? '');

                                        ?>


                                        <?php if (
                                            !empty($b['gambar']) &&
                                            file_exists($imagePath)
                                        ): ?>


                                            <img
                                                src="../uploads/berita/<?= e($b['gambar']) ?>"
                                                width="90"
                                                class="thumb"
                                                alt="Gambar berita"
                                            >


                                        <?php else: ?>

                                            <span class="empty-media">
                                                -
                                            </span>

                                        <?php endif; ?>

                                    </td>


                                    <!-- VIDEO -->

                                    <td class="text-center">

                                        <?php if (!empty($b['video'])): ?>


                                            <?php if (
                                                preg_match(
                                                    '/^https?:\/\//',
                                                    $b['video']
                                                )
                                            ): ?>


                                                <a
                                                    href="<?= e($b['video']) ?>"
                                                    target="_blank"
                                                    class="media-link"
                                                >
                                                    🔗 Lihat Video
                                                </a>


                                            <?php else: ?>


                                                <?php

                                                $videoPath =
                                                    __DIR__ .
                                                    "/../uploads/berita/" .
                                                    $b['video'];

                                                $ext =
                                                    strtolower(
                                                        pathinfo(
                                                            $b['video'],
                                                            PATHINFO_EXTENSION
                                                        )
                                                    );

                                                ?>


                                                <?php if (
                                                    file_exists($videoPath) &&
                                                    in_array(
                                                        $ext,
                                                        [
                                                            'mp4',
                                                            'webm',
                                                            'ogg'
                                                        ],
                                                        true
                                                    )
                                                ): ?>


                                                    <video
                                                        width="120"
                                                        controls
                                                        preload="metadata"
                                                        class="video-thumb"
                                                    >

                                                        <source
                                                            src="../uploads/berita/<?= e($b['video']) ?>"
                                                            type="video/<?= e($ext) ?>"
                                                        >

                                                        Browser tidak mendukung
                                                        video.

                                                    </video>


                                                <?php else: ?>

                                                    <span class="empty-media">
                                                        -
                                                    </span>

                                                <?php endif; ?>


                                            <?php endif; ?>


                                        <?php else: ?>

                                            <span class="empty-media">
                                                -
                                            </span>

                                        <?php endif; ?>

                                    </td>


                                    <!-- AKSI -->

                                    <td>

                                        <div class="actions">


                                            <a
                                                href="berita_form.php?id=<?= (int)$b['id'] ?>"
                                                class="action-edit"
                                                title="Edit berita"
                                            >
                                                 Edit
                                            </a>


                                            <a
                                                href="berita_delete.php?id=<?= (int)$b['id'] ?>"
                                                class="action-delete"
                                                title="Hapus berita"
                                                onclick="return confirm('Yakin hapus berita ini?')"
                                            >
                                                 Hapus
                                            </a>


                                        </div>

                                    </td>


                                </tr>

                            <?php endforeach; ?>


                        <?php else: ?>


                            <tr>

                                <td
                                    colspan="6"
                                    class="empty-table"
                                >

                                    <div class="empty-icon">
                                        📰
                                    </div>

                                    <strong>
                                        Belum ada berita
                                    </strong>

                                    <span>
                                        Silakan tambahkan berita
                                        pertama.
                                    </span>

                                    <a
                                        href="berita_form.php"
                                        class="empty-add-btn"
                                    >
                                        + Tambah Berita
                                    </a>

                                </td>

                            </tr>


                        <?php endif; ?>


                    </tbody>

                </table>

            </div>


        </section>


    </main>


</div>


<style>

/* =====================================================
   PAGE HEADER
===================================================== */

.page-header {

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 20px;

    margin-bottom: 25px;

}


.page-header h1 {

    margin: 0 0 6px;

    font-size: 25px;

    color: #1c2733;

}


.page-header p {

    margin: 0;

    color: #7b8794;

    font-size: 14px;

}


/* =====================================================
   BUTTON
===================================================== */

.btn-primary {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    padding: 11px 17px;

    border: none;

    border-radius: 9px;

    background: #0d6efd;

    color: #fff;

    text-decoration: none;

    font-size: 13px;

    font-weight: 700;

    white-space: nowrap;

    transition: .2s ease;

}


.btn-primary:hover {

    background: #0a4fc4;

    transform: translateY(-1px);

}


/* =====================================================
   TABLE CARD
===================================================== */

.table-card {

    background: #fff;

    border: 1px solid #e8edf3;

    border-radius: 15px;

    overflow: hidden;

    box-shadow:
        0 4px 15px rgba(13,38,76,.04);

}


.table-card-header {

    display: flex;

    align-items: center;

    justify-content: space-between;

    padding: 20px 22px;

    border-bottom: 1px solid #edf0f4;

}


.table-card-header h2 {

    margin: 0 0 4px;

    font-size: 17px;

    color: #263442;

}


.table-card-header p {

    margin: 0;

    color: #8a96a3;

    font-size: 12px;

}


/* =====================================================
   TABLE WRAPPER
===================================================== */

.table-wrapper {

    width: 100%;

    overflow-x: auto;

}


.data-table {

    width: 100%;

    min-width: 850px;

    border-collapse: collapse;

}


.data-table th {

    padding: 13px 15px;

    background: #f8fafc;

    border-bottom: 1px solid #e8edf3;

    color: #687585;

    font-size: 11px;

    font-weight: 700;

    text-transform: uppercase;

    letter-spacing: .4px;

    text-align: left;

}


.data-table td {

    padding: 14px 15px;

    border-bottom: 1px solid #edf0f4;

    color: #526171;

    font-size: 13px;

    vertical-align: middle;

}


.data-table tbody tr:last-child td {

    border-bottom: none;

}


.data-table tbody tr:hover {

    background: #fbfcfe;

}


.text-center {

    text-align: center !important;

}


/* =====================================================
   NEWS TITLE
===================================================== */

.news-title {

    max-width: 350px;

    color: #263442;

    font-size: 13px;

    font-weight: 700;

    line-height: 1.5;

}


/* =====================================================
   DATE
===================================================== */

.date-badge {

    display: inline-flex;

    align-items: center;

    gap: 4px;

    color: #687585;

    font-size: 12px;

    white-space: nowrap;

}


/* =====================================================
   IMAGE
===================================================== */

.thumb {

    width: 90px;

    height: 60px;

    object-fit: cover;

    border-radius: 8px;

    border: 1px solid #e1e6ec;

    display: block;

    margin: auto;

}


/* =====================================================
   VIDEO
===================================================== */

.video-thumb {

    display: block;

    margin: auto;

    max-width: 120px;

    max-height: 75px;

    border-radius: 7px;

    border: 1px solid #e1e6ec;

    background: #111;

}


.media-link {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    padding: 7px 10px;

    border-radius: 7px;

    background: #e8f1ff;

    color: #0d6efd;

    text-decoration: none;

    font-size: 11px;

    font-weight: 700;

}


.media-link:hover {

    background: #dbe9ff;

}


/* =====================================================
   EMPTY MEDIA
===================================================== */

.empty-media {

    color: #a0aab5;

    font-size: 13px;

}


/* =====================================================
   ACTIONS
===================================================== */

.actions {

    display: flex;

    align-items: center;

    justify-content: center;

    gap: 6px;

}


.actions a {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    padding: 7px 9px;

    border-radius: 7px;

    text-decoration: none;

    font-size: 11px;

    font-weight: 700;

    transition: .2s ease;

}


.action-edit {

    background: #e8f1ff;

    color: #0d6efd;

}


.action-edit:hover {

    background: #d8e7ff;

}


.action-delete {

    background: #fff0f0;

    color: #dc3545;

}


.action-delete:hover {

    background: #ffe0e0;

}


/* =====================================================
   EMPTY TABLE
===================================================== */

.empty-table {

    padding: 55px 20px !important;

    text-align: center !important;

}


.empty-icon {

    margin-bottom: 10px;

    font-size: 35px;

}


.empty-table strong {

    display: block;

    margin-bottom: 5px;

    color: #526171;

    font-size: 14px;

}


.empty-table span {

    display: block;

    margin-bottom: 17px;

    color: #9aa5b1;

    font-size: 12px;

}


.empty-add-btn {

    display: inline-flex;

    padding: 9px 13px;

    border-radius: 8px;

    background: #0d6efd;

    color: #fff;

    text-decoration: none;

    font-size: 12px;

    font-weight: 700;

}


.empty-add-btn:hover {

    background: #0a4fc4;

}


/* =====================================================
   RESPONSIVE
===================================================== */

@media (max-width: 700px) {

    .page-header {

        align-items: flex-start;

        flex-direction: column;

    }


    .page-header .btn-primary {

        width: 100%;

    }

}

</style>


<?php

include __DIR__ . '/../partials/admin_footer.php';

?>