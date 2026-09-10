<?php

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../helpers.php';

require_login();

$title = 'Dashboard Admin';

include __DIR__ . '/../partials/admin_header.php';
include __DIR__ . '/../partials/admin_sidebar.php';

?>

<div class="admin-main">

    <!-- TOPBAR -->
    <header class="admin-topbar">

        <div class="topbar-left">

            <button
                type="button"
                class="sidebar-toggle"
                id="sidebarToggle"
                aria-label="Buka menu"
            >
                ☰
            </button>

            <div class="admin-page-title">
                Dashboard
            </div>

        </div>

        <div class="admin-user">

            <div class="admin-user-info">
                <strong>Administrator</strong>
                <span>Admin</span>
            </div>

        </div>

    </header>


    <!-- CONTENT -->
    <main class="admin-content">

        <style>

            /* =========================
               DASHBOARD
            ========================= */

            .dashboard-header {
                margin-bottom: 25px;
            }

            .dashboard-header h1 {
                margin: 0 0 8px;
                font-size: 30px;
                line-height: 1.25;
                font-weight: 750;
                color: #172333;
                letter-spacing: -.5px;
            }

            .dashboard-header p {
                margin: 0;
                color: #7a8796;
                font-size: 14px;
            }


            /* =========================
               WELCOME BOX
            ========================= */

            .welcome-box {
                position: relative;
                overflow: hidden;

                background: linear-gradient(
                    135deg,
                    #0d6efd 0%,
                    #1558c0 100%
                );

                border-radius: 18px;

                padding: 28px 32px;

                margin-bottom: 28px;

                color: #fff;

                box-shadow:
                    0 12px 30px rgba(13, 110, 253, .16);
            }

            .welcome-box::after {
                content: "";
                position: absolute;

                width: 180px;
                height: 180px;

                right: -60px;
                top: -80px;

                border-radius: 50%;

                background: rgba(255,255,255,.08);
            }

            .welcome-box::before {
                content: "";
                position: absolute;

                width: 120px;
                height: 120px;

                right: 100px;
                bottom: -80px;

                border-radius: 50%;

                background: rgba(255,255,255,.06);
            }

            .welcome-content {
                position: relative;
                z-index: 2;
            }

            .welcome-label {
                display: inline-block;

                margin-bottom: 9px;

                font-size: 11px;
                font-weight: 700;

                text-transform: uppercase;

                letter-spacing: 1px;

                color: rgba(255,255,255,.75);
            }

            .welcome-box h2 {
                margin: 0 0 7px;

                font-size: 23px;
                font-weight: 700;

                color: #fff;
            }

            .welcome-box p {
                margin: 0;

                max-width: 650px;

                color: rgba(255,255,255,.82);

                font-size: 14px;

                line-height: 1.6;
            }


            /* =========================
               SECTION TITLE
            ========================= */

            .section-heading {
                display: flex;
                align-items: center;
                justify-content: space-between;

                margin-bottom: 16px;
            }

            .section-heading h3 {
                margin: 0;

                font-size: 17px;
                font-weight: 700;

                color: #253342;
            }

            .section-heading span {
                font-size: 12px;
                color: #98a3af;
            }


            /* =========================
               DASHBOARD GRID
            ========================= */

            .dashboard-grid {
                display: grid;

                grid-template-columns:
                    repeat(3, minmax(0, 1fr));

                gap: 18px;
            }


            /* =========================
               DASHBOARD CARD
            ========================= */

            .dashboard-card {
                position: relative;

                display: flex;
                flex-direction: column;

                min-height: 170px;

                padding: 24px 23px 20px;

                background: #fff;

                border: 1px solid #e9edf2;

                border-radius: 16px;

                text-decoration: none;

                color: inherit;

                box-shadow:
                    0 4px 15px rgba(20, 42, 70, .035);

                transition:
                    transform .25s ease,
                    box-shadow .25s ease,
                    border-color .25s ease;
            }

            .dashboard-card::before {
                content: "";

                position: absolute;

                left: 0;
                top: 20px;
                bottom: 20px;

                width: 3px;

                background: #0d6efd;

                border-radius: 0 5px 5px 0;

                opacity: 0;

                transition: opacity .25s ease;
            }

            .dashboard-card:hover {
                transform: translateY(-4px);

                border-color: #d8e5fa;

                box-shadow:
                    0 13px 28px rgba(20, 42, 70, .09);
            }

            .dashboard-card:hover::before {
                opacity: 1;
            }


            /* =========================
               CARD CONTENT
            ========================= */

            .card-number {
                margin-bottom: 18px;

                font-size: 12px;
                font-weight: 700;

                color: #0d6efd;

                letter-spacing: .5px;
            }

            .dashboard-card h4 {
                margin: 0 0 8px;

                font-size: 17px;
                font-weight: 700;

                color: #202f3f;
            }

            .dashboard-card p {
                margin: 0;

                color: #7d8997;

                font-size: 13px;

                line-height: 1.6;
            }

            .card-footer {
                display: flex;

                align-items: center;
                justify-content: space-between;

                margin-top: auto;
                padding-top: 18px;
            }

            .card-link {
                font-size: 12px;
                font-weight: 700;

                color: #0d6efd;
            }

            .card-arrow {
                display: flex;

                align-items: center;
                justify-content: center;

                width: 30px;
                height: 30px;

                border-radius: 8px;

                background: #f1f6ff;

                color: #0d6efd;

                font-size: 17px;

                transition:
                    background .25s ease,
                    transform .25s ease;
            }

            .dashboard-card:hover .card-arrow {
                background: #e4efff;

                transform: translateX(3px);
            }


            /* =========================
               RESPONSIVE
            ========================= */

            @media (max-width: 1100px) {

                .dashboard-grid {
                    grid-template-columns:
                        repeat(2, minmax(0, 1fr));
                }

            }


            @media (max-width: 700px) {

                .dashboard-grid {
                    grid-template-columns: 1fr;
                }

                .welcome-box {
                    padding: 24px 22px;
                }

                .welcome-box h2 {
                    font-size: 21px;
                }

                .dashboard-header h1 {
                    font-size: 25px;
                }

            }


            @media (max-width: 500px) {

                .admin-user-info {
                    display: none;
                }

                .dashboard-card {
                    min-height: 155px;
                }

            }

        </style>


        <!-- HEADER -->
        <div class="dashboard-header">

            <h1>
                Dashboard Admin
            </h1>

            <p>
                Kelola konten dan informasi website MI Aditirto melalui panel administrasi.
            </p>

        </div>


        <!-- WELCOME -->
        <div class="welcome-box">

            <div class="welcome-content">

                <span class="welcome-label">
                    Panel Administrasi
                </span>

                <h2>
                    Selamat datang, Administrator
                </h2>

                <p>
                    Gunakan menu di bawah untuk mengelola informasi,
                    berita, prestasi, struktur guru, dan pesan dari pengunjung
                    website MI Aditirto.
                </p>

            </div>

        </div>


        <!-- SECTION TITLE -->
        <div class="section-heading">

            <h3>
                Menu Pengelolaan
            </h3>

            <span>
                6 menu tersedia
            </span>

        </div>


        <!-- MENU GRID -->
        <div class="dashboard-grid">


            <!-- HOME -->
            <a
                class="dashboard-card"
                href="site_info.php"
            >

                <div class="card-number">
                    01
                </div>

                <h4>
                    Kelola Home
                </h4>

                <p>
                    Edit konten utama halaman depan website.
                </p>

                <div class="card-footer">

                    <span class="card-link">
                        Kelola sekarang
                    </span>

                    <span class="card-arrow">
                        →
                    </span>

                </div>

            </a>


            <!-- PROFIL -->
            <a
                class="dashboard-card"
                href="site_profile.php"
            >

                <div class="card-number">
                    02
                </div>

                <h4>
                    Profil Sekolah
                </h4>

                <p>
                    Kelola alamat, kontak, dan deskripsi sekolah.
                </p>

                <div class="card-footer">

                    <span class="card-link">
                        Kelola sekarang
                    </span>

                    <span class="card-arrow">
                        →
                    </span>

                </div>

            </a>


            <!-- BERITA -->
            <a
                class="dashboard-card"
                href="berita_list.php"
            >

                <div class="card-number">
                    03
                </div>

                <h4>
                    Kelola Berita
                </h4>

                <p>
                    Tambah, edit, dan hapus berita sekolah.
                </p>

                <div class="card-footer">

                    <span class="card-link">
                        Kelola sekarang
                    </span>

                    <span class="card-arrow">
                        →
                    </span>

                </div>

            </a>


            <!-- PRESTASI -->
            <a
                class="dashboard-card"
                href="achievements.php"
            >

                <div class="card-number">
                    04
                </div>

                <h4>
                    Kelola Prestasi
                </h4>

                <p>
                    Kelola data prestasi dan pencapaian sekolah.
                </p>

                <div class="card-footer">

                    <span class="card-link">
                        Kelola sekarang
                    </span>

                    <span class="card-arrow">
                        →
                    </span>

                </div>

            </a>


            <!-- GURU -->
            <a
                class="dashboard-card"
                href="teachers.php"
            >

                <div class="card-number">
                    05
                </div>

                <h4>
                    Struktur Guru
                </h4>

                <p>
                    Kelola data guru dan jabatan sekolah.
                </p>

                <div class="card-footer">

                    <span class="card-link">
                        Kelola sekarang
                    </span>

                    <span class="card-arrow">
                        →
                    </span>

                </div>

            </a>


            <!-- CONTACT -->
            <a
                class="dashboard-card"
                href="contacts.php"
            >

                <div class="card-number">
                    06
                </div>

                <h4>
                    Pesan Kontak
                </h4>

                <p>
                    Lihat pesan yang masuk dari pengunjung.
                </p>

                <div class="card-footer">

                    <span class="card-link">
                        Kelola sekarang
                    </span>

                    <span class="card-arrow">
                        →
                    </span>

                </div>

            </a>


        </div>

    </main>

</div>


<?php

include __DIR__ . '/../partials/admin_footer.php';

?>