<?php

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../helpers.php';

require_login();

$title = 'Kelola Visi, Misi, Info & Hero Section';

$success = '';
$error = '';

/* =====================================================
   AMBIL DATA TERBARU
===================================================== */

$stmt = $pdo->query("SELECT * FROM site_info WHERE id = 1");
$data = $stmt->fetch(PDO::FETCH_ASSOC);


/* =====================================================
   PROSES FORM
===================================================== */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    check_csrf();

    $visi = trim($_POST['visi'] ?? '');
    $misi = trim($_POST['misi'] ?? '');
    $info = trim($_POST['info_singkat'] ?? '');

    $hero_title = trim($_POST['hero_title'] ?? '');
    $hero_sub = trim($_POST['hero_subtitle'] ?? '');

    $hero_image = null;
    $hero_video = null;

    $uploadDir = __DIR__ . '/../uploads/site/';


    /* =================================================
       BUAT FOLDER UPLOAD JIKA BELUM ADA
    ================================================= */

    if (!is_dir($uploadDir)) {

        mkdir(
            $uploadDir,
            0777,
            true
        );

    }


    /* =================================================
       HAPUS GAMBAR HERO
    ================================================= */

    if (
        !empty($_POST['hapus_hero_image']) &&
        !empty($data['hero_image'])
    ) {

        $oldImage =
            $uploadDir . $data['hero_image'];

        if (file_exists($oldImage)) {
            @unlink($oldImage);
        }

        $hero_image = '';

    }


    /* =================================================
       HAPUS VIDEO HERO
    ================================================= */

    if (
        !empty($_POST['hapus_hero_video']) &&
        !empty($data['hero_video'])
    ) {

        $oldVideo =
            $uploadDir . $data['hero_video'];

        if (file_exists($oldVideo)) {
            @unlink($oldVideo);
        }

        $hero_video = '';

    }


    /* =================================================
       UPLOAD GAMBAR HERO BARU
    ================================================= */

    if (
        isset($_FILES['hero_image']) &&
        $_FILES['hero_image']['error'] !== UPLOAD_ERR_NO_FILE
    ) {

        if (
            $_FILES['hero_image']['error'] === UPLOAD_ERR_OK
        ) {

            $originalName =
                basename(
                    $_FILES['hero_image']['name']
                );

            $ext =
                strtolower(
                    pathinfo(
                        $originalName,
                        PATHINFO_EXTENSION
                    )
                );

            $allowedImage =
                [
                    'jpg',
                    'jpeg',
                    'png',
                    'gif',
                    'webp'
                ];


            if (in_array($ext, $allowedImage, true)) {

                $filename =
                    time() .
                    '_img_' .
                    bin2hex(random_bytes(4)) .
                    '.' .
                    $ext;

                $targetFile =
                    $uploadDir . $filename;


                if (
                    move_uploaded_file(
                        $_FILES['hero_image']['tmp_name'],
                        $targetFile
                    )
                ) {

                    /*
                     * Hapus gambar lama
                     */

                    if (
                        !empty($data['hero_image']) &&
                        $data['hero_image'] !== $filename
                    ) {

                        $oldImage =
                            $uploadDir .
                            $data['hero_image'];

                        if (file_exists($oldImage)) {
                            @unlink($oldImage);
                        }

                    }


                    $hero_image = $filename;

                }

            }

        }

    }


    /* =================================================
       UPLOAD VIDEO HERO BARU
    ================================================= */

    if (
        isset($_FILES['hero_video']) &&
        $_FILES['hero_video']['error'] !== UPLOAD_ERR_NO_FILE
    ) {

        if (
            $_FILES['hero_video']['error'] === UPLOAD_ERR_OK
        ) {

            $originalName =
                basename(
                    $_FILES['hero_video']['name']
                );

            $ext =
                strtolower(
                    pathinfo(
                        $originalName,
                        PATHINFO_EXTENSION
                    )
                );

            $allowedVideo =
                [
                    'mp4',
                    'webm',
                    'ogg'
                ];


            if (in_array($ext, $allowedVideo, true)) {

                $filename =
                    time() .
                    '_vid_' .
                    bin2hex(random_bytes(4)) .
                    '.' .
                    $ext;

                $targetFile =
                    $uploadDir . $filename;


                if (
                    move_uploaded_file(
                        $_FILES['hero_video']['tmp_name'],
                        $targetFile
                    )
                ) {

                    /*
                     * Hapus video lama
                     */

                    if (
                        !empty($data['hero_video']) &&
                        $data['hero_video'] !== $filename
                    ) {

                        $oldVideo =
                            $uploadDir .
                            $data['hero_video'];

                        if (file_exists($oldVideo)) {
                            @unlink($oldVideo);
                        }

                    }


                    $hero_video = $filename;

                }

            }

        }

    }


    /* =================================================
       UPDATE DATABASE
    ================================================= */

    $fields = [

        'visi' =>
            $visi,

        'misi' =>
            $misi,

        'info_singkat' =>
            $info,

        'hero_title' =>
            $hero_title,

        'hero_subtitle' =>
            $hero_sub

    ];


    /*
     * Hanya update kolom gambar jika:
     * - gambar dihapus, atau
     * - gambar baru diupload
     */

    if ($hero_image !== null) {

        $fields['hero_image'] =
            $hero_image;

    }


    /*
     * Hanya update kolom video jika:
     * - video dihapus, atau
     * - video baru diupload
     */

    if ($hero_video !== null) {

        $fields['hero_video'] =
            $hero_video;

    }


    $setParts = [];

    foreach (
        array_keys($fields)
        as $field
    ) {

        $setParts[] =
            "`$field` = ?";

    }


    $setStr =
        implode(
            ', ',
            $setParts
        );


    $stmt =
        $pdo->prepare(
            "UPDATE site_info
             SET $setStr
             WHERE id = 1"
        );


    $stmt->execute(
        array_values($fields)
    );


    /* =================================================
       AMBIL DATA TERBARU
    ================================================= */

    $stmt =
        $pdo->query(
            "SELECT *
             FROM site_info
             WHERE id = 1"
        );

    $data =
        $stmt->fetch(
            PDO::FETCH_ASSOC
        );


    $success =
        'Data berhasil diperbarui.';

}


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
                Kelola Home
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


        <div class="page-header">

            <div>

                <h1>
                    Kelola Visi, Misi, Info & Hero
                </h1>

                <p>
                    Kelola informasi utama yang ditampilkan
                    pada halaman Home MI Aditirto.
                </p>

            </div>


            <a
                href="../index.php"
                target="_blank"
                class="view-site-btn"
            >
                Lihat Website
            </a>

        </div>


        <!-- ============================================
             SUCCESS MESSAGE
        ============================================= -->

        <?php if ($success): ?>

            <div class="alert-success">

                <span>
                    ✓
                </span>

                <div>
                    <?= e($success) ?>
                </div>

            </div>

        <?php endif; ?>


        <!-- ============================================
             FORM
        ============================================= -->

        <form
            method="post"
            enctype="multipart/form-data"
        >

            <?php csrf_field(); ?>


            <!-- ========================================
                 HERO SECTION
            ========================================= -->

            <section class="form-card">

                <div class="form-card-header">

                   

                    <div>

                        <h2>
                            Hero Section
                        </h2>

                        <p>
                            Konten utama yang tampil di bagian
                            paling atas halaman Home.
                        </p>

                    </div>

                </div>


                <div class="form-body">


                    <div class="form-group">

                        <label for="hero_title">
                            Hero Title
                        </label>

                        <input
                            type="text"
                            id="hero_title"
                            name="hero_title"
                            value="<?= e($data['hero_title'] ?? '') ?>"
                            placeholder="Masukkan judul utama"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label for="hero_subtitle">
                            Hero Subtitle
                        </label>

                        <input
                            type="text"
                            id="hero_subtitle"
                            name="hero_subtitle"
                            value="<?= e($data['hero_subtitle'] ?? '') ?>"
                            placeholder="Masukkan subtitle"
                            required
                        >

                    </div>


                    <!-- GAMBAR -->

                    <div class="form-group">

                        <label for="hero_image">
                            Gambar Hero
                        </label>

                        <input
                            type="file"
                            id="hero_image"
                            name="hero_image"
                            accept="image/*"
                        >

                        <small>
                            Format yang didukung:
                            JPG, JPEG, PNG, GIF, WEBP.
                        </small>


                        <?php if (!empty($data['hero_image'])): ?>

                            <div class="media-preview">

                                <div class="preview-title">
                                    Gambar saat ini
                                </div>

                                <img
                                    src="../uploads/site/<?= e($data['hero_image']) ?>"
                                    alt="Hero Image"
                                >


                                <label class="delete-check">

                                    <input
                                        type="checkbox"
                                        name="hapus_hero_image"
                                    >

                                    Hapus gambar ini

                                </label>

                            </div>

                        <?php endif; ?>

                    </div>


                    <!-- VIDEO -->

                    <div class="form-group">

                        <label for="hero_video">
                            Video Hero
                        </label>

                        <input
                            type="file"
                            id="hero_video"
                            name="hero_video"
                            accept="video/mp4,video/webm,video/ogg"
                        >

                        <small>
                            Format yang didukung:
                            MP4, WEBM, OGG.
                        </small>


                        <?php if (!empty($data['hero_video'])): ?>

                            <div class="media-preview">

                                <div class="preview-title">
                                    Video saat ini
                                </div>

                                <video
                                    controls
                                    preload="metadata"
                                >

                                    <source
                                        src="../uploads/site/<?= e($data['hero_video']) ?>"
                                        type="video/mp4"
                                    >

                                    Browser kamu tidak mendukung
                                    pemutaran video.

                                </video>


                                <label class="delete-check">

                                    <input
                                        type="checkbox"
                                        name="hapus_hero_video"
                                    >

                                    Hapus video ini

                                </label>

                            </div>

                        <?php endif; ?>

                    </div>


                </div>

            </section>


            <!-- ========================================
                 VISI MISI
            ========================================= -->

            <section class="form-card">

                <div class="form-card-header">

                   

                    <div>

                        <h2>
                            Visi & Misi
                        </h2>

                        <p>
                            Informasi visi dan misi MI Aditirto.
                        </p>

                    </div>

                </div>


                <div class="form-body">


                    <div class="form-group">

                        <label for="visi">
                            Visi
                        </label>

                        <textarea
                            id="visi"
                            name="visi"
                            rows="5"
                            placeholder="Masukkan visi sekolah"
                            required
                        ><?= e($data['visi'] ?? '') ?></textarea>

                    </div>


                    <div class="form-group">

                        <label for="misi">
                            Misi
                        </label>

                        <textarea
                            id="misi"
                            name="misi"
                            rows="7"
                            placeholder="Pisahkan setiap poin dengan tanda |"
                            required
                        ><?= e($data['misi'] ?? '') ?></textarea>


                        <small>
                            Pisahkan setiap poin misi dengan tanda
                            <strong>|</strong>
                        </small>

                    </div>


                </div>

            </section>


            <!-- ========================================
                 INFO SINGKAT
            ========================================= -->

            <section class="form-card">

                <div class="form-card-header">

                   

                    <div>

                        <h2>
                            Info Singkat
                        </h2>

                        <p>
                            Informasi singkat mengenai MI Aditirto.
                        </p>

                    </div>

                </div>


                <div class="form-body">


                    <div class="form-group">

                        <label for="info_singkat">
                            Informasi Singkat
                        </label>

                        <textarea
                            id="info_singkat"
                            name="info_singkat"
                            rows="6"
                            placeholder="Masukkan informasi singkat sekolah"
                            required
                        ><?= e($data['info_singkat'] ?? '') ?></textarea>

                    </div>


                </div>

            </section>


            <!-- ========================================
                 ACTION
            ========================================= -->

            <div class="form-actions">

                <a
                    href="dashboard_admin.php"
                    class="btn-secondary"
                >
                    ← Kembali
                </a>


                <button
                    type="submit"
                    class="btn-primary"
                >
                    💾 Simpan Perubahan
                </button>

            </div>


        </form>


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


.view-site-btn {

    display: inline-flex;

    align-items: center;

    gap: 7px;

    padding: 10px 15px;

    background: #ffffff;

    border: 1px solid #dfe5ec;

    border-radius: 9px;

    color: #526171;

    text-decoration: none;

    font-size: 13px;

    font-weight: 600;

    white-space: nowrap;

}


.view-site-btn:hover {

    color: #0d6efd;

    border-color: #cbdcff;

    background: #f7faff;

}


/* =====================================================
   ALERT
===================================================== */

.alert-success {

    display: flex;

    align-items: center;

    gap: 10px;

    padding: 13px 16px;

    margin-bottom: 20px;

    background: #ecfdf3;

    border: 1px solid #b7ebcc;

    border-radius: 10px;

    color: #146c43;

    font-size: 14px;

}


.alert-success span {

    font-weight: 800;

    font-size: 17px;

}


/* =====================================================
   FORM CARD
===================================================== */

.form-card {

    background: #ffffff;

    border: 1px solid #e8edf3;

    border-radius: 15px;

    margin-bottom: 20px;

    overflow: hidden;

    box-shadow:
        0 4px 15px rgba(13,38,76,.04);

}


.form-card-header {

    display: flex;

    align-items: center;

    gap: 14px;

    padding: 20px 22px;

    border-bottom: 1px solid #edf0f4;

}


.section-icon {

    width: 45px;

    height: 45px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 12px;

    background: #e8f1ff;

    font-size: 21px;

}


.form-card-header h2 {

    margin: 0 0 3px;

    font-size: 17px;

    color: #263442;

}


.form-card-header p {

    margin: 0;

    color: #8a96a3;

    font-size: 12px;

}


/* =====================================================
   FORM BODY
===================================================== */

.form-body {

    padding: 22px;

}


.form-group {

    margin-bottom: 22px;

}


.form-group:last-child {

    margin-bottom: 0;

}


.form-group label {

    display: block;

    margin-bottom: 7px;

    color: #344454;

    font-size: 13px;

    font-weight: 700;

}


.form-group input[type="text"],
.form-group textarea,
.form-group input[type="file"] {

    width: 100%;

    font-family: inherit;

    font-size: 14px;

}


.form-group input[type="text"],
.form-group textarea {

    padding: 11px 13px;

    border: 1px solid #dce2e9;

    border-radius: 9px;

    background: #ffffff;

    color: #253342;

    outline: none;

    transition:
        border-color .2s ease,
        box-shadow .2s ease;

}


.form-group input[type="text"]:focus,
.form-group textarea:focus {

    border-color: #86b7fe;

    box-shadow:
        0 0 0 3px rgba(13,110,253,.10);

}


.form-group textarea {

    resize: vertical;

    line-height: 1.6;

}


.form-group input[type="file"] {

    padding: 9px;

    border: 1px dashed #cbd5e1;

    border-radius: 9px;

    background: #f8fafc;

}


.form-group small {

    display: block;

    margin-top: 6px;

    color: #8a96a3;

    font-size: 11px;

}


/* =====================================================
   MEDIA PREVIEW
===================================================== */

.media-preview {

    margin-top: 15px;

    padding: 15px;

    background: #f8fafc;

    border: 1px solid #edf0f4;

    border-radius: 10px;

}


.preview-title {

    margin-bottom: 10px;

    color: #526171;

    font-size: 12px;

    font-weight: 700;

}


.media-preview img,
.media-preview video {

    display: block;

    width: 100%;

    max-width: 550px;

    max-height: 350px;

    object-fit: contain;

    border-radius: 8px;

    background: #eef2f7;

}


.delete-check {

    display: flex !important;

    align-items: center;

    gap: 7px;

    margin-top: 12px !important;

    color: #dc3545 !important;

    font-weight: 600 !important;

    cursor: pointer;

}


.delete-check input {

    width: 15px;

    height: 15px;

    accent-color: #dc3545;

}


/* =====================================================
   FORM ACTIONS
===================================================== */

.form-actions {

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 12px;

    margin-top: 5px;

    margin-bottom: 10px;

}


.btn-primary,
.btn-secondary {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    padding: 11px 18px;

    border-radius: 9px;

    font-family: inherit;

    font-size: 13px;

    font-weight: 700;

    text-decoration: none;

    cursor: pointer;

    transition: .2s ease;

}


.btn-primary {

    border: none;

    background: #0d6efd;

    color: #ffffff;

}


.btn-primary:hover {

    background: #0a4fc4;

    transform: translateY(-1px);

}


.btn-secondary {

    border: 1px solid #dce2e9;

    background: #ffffff;

    color: #526171;

}


.btn-secondary:hover {

    background: #f5f7fa;

    color: #263442;

}


/* =====================================================
   RESPONSIVE
===================================================== */

@media (max-width: 700px) {

    .page-header {

        align-items: flex-start;

        flex-direction: column;

    }


    .view-site-btn {

        width: 100%;

    }


    .form-card-header {

        padding: 17px;

    }


    .form-body {

        padding: 17px;

    }


    .form-actions {

        flex-direction: column-reverse;

        align-items: stretch;

    }


    .btn-primary,
    .btn-secondary {

        width: 100%;

    }

}

</style>


<?php

include __DIR__ . '/../partials/admin_footer.php';

?>