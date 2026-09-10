<?php

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../helpers.php';

require_login();

$title = 'Kelola Profil Sekolah';

$msg = '';

/* =====================================================
   AMBIL DATA AWAL
===================================================== */

$stmt = $pdo->query("SELECT * FROM site_profile LIMIT 1");
$info = $stmt->fetch(PDO::FETCH_ASSOC);


/* =====================================================
   PROSES FORM
===================================================== */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    check_csrf();

    $alamat = trim($_POST['alamat'] ?? '');
    $telepon = trim($_POST['telepon'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $deskripsi = trim($_POST['deskripsi'] ?? '');

    $lat = trim($_POST['latitude'] ?? '');
    $lng = trim($_POST['longitude'] ?? '');


    /* =================================================
       UPDATE DATA
    ================================================= */

    if ($info) {

        $stmt = $pdo->prepare("
            UPDATE site_profile
            SET
                alamat = ?,
                telepon = ?,
                email = ?,
                deskripsi = ?,
                latitude = ?,
                longitude = ?
            WHERE id = ?
        ");

        $stmt->execute([
            $alamat,
            $telepon,
            $email,
            $deskripsi,
            $lat,
            $lng,
            $info['id']
        ]);

    }


    /* =================================================
       AMBIL DATA TERBARU
    ================================================= */

    $stmt = $pdo->query(
        "SELECT * FROM site_profile LIMIT 1"
    );

    $info = $stmt->fetch(PDO::FETCH_ASSOC);

    $msg = 'Profil berhasil diperbarui.';

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
                Profil Sekolah
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
                    Kelola Profil Sekolah
                </h1>

                <p>
                    Kelola informasi utama mengenai
                    MI Aditirto.
                </p>

            </div>


            <a
                href="../profile.php"
                target="_blank"
                class="view-site-btn"
            >
                Lihat Profil
            </a>

        </div>


        <!-- ============================================
             SUCCESS MESSAGE
        ============================================= -->

        <?php if ($msg): ?>

            <div class="alert-success">

                <span>
                    ✓
                </span>

                <div>
                    <?= e($msg) ?>
                </div>

            </div>

        <?php endif; ?>


        <!-- ============================================
             FORM INFORMASI SEKOLAH
        ============================================= -->

        <form method="post">

            <?php csrf_field(); ?>


            <!-- ========================================
                 INFORMASI KONTAK
            ========================================= -->

            <section class="form-card">

                <div class="form-card-header">

                   

                    <div>

                        <h2>
                            Informasi Sekolah
                        </h2>

                        <p>
                            Informasi dasar dan kontak
                            MI Aditirto.
                        </p>

                    </div>

                </div>


                <div class="form-body">


                    <!-- ALAMAT -->

                    <div class="form-group">

                        <label for="alamat">
                            Alamat
                        </label>

                        <textarea
                            id="alamat"
                            name="alamat"
                            rows="3"
                            placeholder="Masukkan alamat sekolah"
                            required
                        ><?= e($info['alamat'] ?? '') ?></textarea>

                    </div>


                    <!-- TELEPON -->

                    <div class="form-group">

                        <label for="telepon">
                            Nomor Telepon
                        </label>

                        <input
                            type="text"
                            id="telepon"
                            name="telepon"
                            value="<?= e($info['telepon'] ?? '') ?>"
                            placeholder="Contoh: 081234567890"
                            required
                        >

                    </div>


                    <!-- EMAIL -->

                    <div class="form-group">

                        <label for="email">
                            Email
                        </label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="<?= e($info['email'] ?? '') ?>"
                            placeholder="Contoh: sekolah@email.com"
                            required
                        >

                    </div>


                    <!-- DESKRIPSI -->

                    <div class="form-group">

                        <label for="deskripsi">
                            Deskripsi Sekolah
                        </label>

                        <textarea
                            id="deskripsi"
                            name="deskripsi"
                            rows="6"
                            placeholder="Masukkan deskripsi sekolah"
                            required
                        ><?= e($info['deskripsi'] ?? '') ?></textarea>

                        <small>
                            Deskripsi ini dapat digunakan pada
                            halaman Profil Sekolah.
                        </small>

                    </div>


                </div>

            </section>


            <!-- ========================================
                 LOKASI SEKOLAH
            ========================================= -->

            <section class="form-card">

                <div class="form-card-header">


                    <div>

                        <h2>
                            Lokasi Sekolah
                        </h2>

                        <p>
                            Koordinat digunakan untuk
                            menampilkan lokasi pada peta.
                        </p>

                    </div>

                </div>


                <div class="form-body">


                    <div class="location-info">

                        <div class="location-info-icon">
                            ℹ️
                        </div>

                        <div>

                            <strong>
                                Koordinat Google Maps
                            </strong>

                            <p>
                                Masukkan latitude dan longitude
                                lokasi sekolah untuk menentukan
                                posisi pada peta.
                            </p>

                        </div>

                    </div>


                    <div class="coordinate-grid">


                        <!-- LATITUDE -->

                        <div class="form-group">

                            <label for="latitude">
                                Latitude
                            </label>

                            <input
                                type="text"
                                id="latitude"
                                name="latitude"
                                value="<?= e($info['latitude'] ?? '') ?>"
                                placeholder="-7.801234"
                            >

                            <small>
                                Contoh: -7.801234
                            </small>

                        </div>


                        <!-- LONGITUDE -->

                        <div class="form-group">

                            <label for="longitude">
                                Longitude
                            </label>

                            <input
                                type="text"
                                id="longitude"
                                name="longitude"
                                value="<?= e($info['longitude'] ?? '') ?>"
                                placeholder="110.123456"
                            >

                            <small>
                                Contoh: 110.123456
                            </small>

                        </div>


                    </div>


                </div>

            </section>


            <!-- ========================================
                 ACTION BUTTON
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

    justify-content: center;

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
   SUCCESS MESSAGE
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
.form-group input[type="email"],
.form-group textarea {

    width: 100%;

    padding: 11px 13px;

    border: 1px solid #dce2e9;

    border-radius: 9px;

    background: #ffffff;

    color: #253342;

    font-family: inherit;

    font-size: 14px;

    outline: none;

    transition:
        border-color .2s ease,
        box-shadow .2s ease;

}


.form-group input:focus,
.form-group textarea:focus {

    border-color: #86b7fe;

    box-shadow:
        0 0 0 3px rgba(13,110,253,.10);

}


.form-group textarea {

    resize: vertical;

    line-height: 1.6;

}


.form-group small {

    display: block;

    margin-top: 6px;

    color: #8a96a3;

    font-size: 11px;

}


/* =====================================================
   LOCATION INFO
===================================================== */

.location-info {

    display: flex;

    align-items: flex-start;

    gap: 12px;

    padding: 14px 16px;

    margin-bottom: 22px;

    background: #f7faff;

    border: 1px solid #dce9ff;

    border-radius: 10px;

}


.location-info-icon {

    font-size: 17px;

    line-height: 1.4;

}


.location-info strong {

    display: block;

    margin-bottom: 3px;

    color: #344454;

    font-size: 13px;

}


.location-info p {

    margin: 0;

    color: #7b8794;

    font-size: 12px;

    line-height: 1.5;

}


/* =====================================================
   COORDINATE GRID
===================================================== */

.coordinate-grid {

    display: grid;

    grid-template-columns: 1fr 1fr;

    gap: 18px;

}


/* =====================================================
   ACTION
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


    .coordinate-grid {

        grid-template-columns: 1fr;

        gap: 0;

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