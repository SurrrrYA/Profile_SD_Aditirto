<?php

require_once __DIR__ . '/../helpers.php';

if (!isset($title)) {
    $title = 'Profil MI Aditirto';
}

$baseUrl = rtrim(
    str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])),
    '/'
);

if ($baseUrl === '/' || $baseUrl === '\\') {
    $baseUrl = '';
}

$rootUrl = preg_replace('#/admin$#', '', $baseUrl);

$currentPage = basename($_SERVER['SCRIPT_NAME']);

?>

<!doctype html>

<html lang="id">

<head>

    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title><?= e($title) ?></title>

    <link
        rel="stylesheet"
        href="<?= $rootUrl ?>/assets/style.css"
    >

    <style>

        :root {
            --primary: #0d6efd;
            --primary-dark: #0a4fc4;
            --primary-light: #e8f1ff;

            --accent: #ffb703;

            --text-dark: #1c2733;
            --text-muted: #6b7785;
        }


        * {
            box-sizing: border-box;
        }


        body {
            margin: 0;

            font-family:
                'Segoe UI',
                Arial,
                sans-serif;

            color:
                var(--text-dark);

            background:
                #f5f7fa;
        }


        /* =================================================
           TOPBAR
        ================================================= */

        .topbar {
            position: fixed;

            top: 0;
            left: 0;

            width: 100%;

            z-index: 9999;

            background:
                rgba(255,255,255,.88);

            backdrop-filter:
                blur(10px);

            -webkit-backdrop-filter:
                blur(10px);

            border-bottom:
                1px solid rgba(0,0,0,.05);

            padding:
                17px 0;

            transition:
                background .3s ease,
                box-shadow .3s ease,
                padding .3s ease;
        }


        .topbar.scrolled {
            background:
                rgba(255,255,255,.97);

            box-shadow:
                0 5px 20px rgba(13,38,76,.10);

            padding:
                10px 0;
        }


        /* =================================================
           CONTAINER
        ================================================= */

        .topbar .container {
            max-width:
                1200px;

            margin:
                auto;

            padding:
                0 24px;

            display:
                flex;

            align-items:
                center;

            justify-content:
                space-between;

            gap:
                20px;
        }


        /* =================================================
           BRAND
        ================================================= */

        .brand {
            display:
                flex;

            align-items:
                center;

            gap:
                10px;

            color:
                var(--text-dark);

            text-decoration:
                none;

            font-size:
                17px;

            font-weight:
                800;

            white-space:
                nowrap;
        }


        .brand .logo-dot {
            width:
                38px;

            height:
                38px;

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            border-radius:
                11px;

            background:
                linear-gradient(
                    135deg,
                    var(--primary),
                    var(--primary-dark)
                );

            color:
                white;

            font-size:
                13px;

            font-weight:
                800;

            box-shadow:
                0 4px 12px rgba(13,110,253,.25);
        }


        /* =================================================
           DESKTOP NAV
        ================================================= */

        #mainnav {
            display:
                flex;

            align-items:
                center;

            gap:
                4px;
        }


        #mainnav a {
            position:
                relative;

            padding:
                9px 13px;

            border-radius:
                9px;

            color:
                var(--text-muted);

            text-decoration:
                none;

            font-size:
                14px;

            font-weight:
                600;

            transition:
                .2s ease;
        }


        #mainnav a:hover {
            color:
                var(--primary);

            background:
                var(--primary-light);
        }


        #mainnav a.active {
            color:
                var(--primary);

            background:
                var(--primary-light);
        }


        /* =================================================
           NAV RIGHT
        ================================================= */

        .nav-right {
            display:
                flex;

            align-items:
                center;

            gap:
                7px;
        }


        .nav-right a {
            padding:
                9px 14px;

            border-radius:
                9px;

            color:
                var(--text-muted);

            text-decoration:
                none;

            font-size:
                14px;

            font-weight:
                600;

            transition:
                .2s ease;
        }


        .nav-right a:hover {
            color:
                var(--primary);
        }


        .nav-right a.btn-solid {
            background:
                var(--primary);

            color:
                white;

            box-shadow:
                0 4px 10px rgba(13,110,253,.18);
        }


        .nav-right a.btn-solid:hover {
            background:
                var(--primary-dark);

            color:
                white;

            transform:
                translateY(-1px);
        }


        /* =================================================
           MOBILE BUTTON
        ================================================= */

        .nav-toggle {
            display:
                none;

            width:
                40px;

            height:
                40px;

            align-items:
                center;

            justify-content:
                center;

            border:
                none;

            border-radius:
                9px;

            background:
                transparent;

            color:
                var(--text-dark);

            font-size:
                22px;

            cursor:
                pointer;

            transition:
                .2s ease;
        }


        .nav-toggle:hover {
            background:
                var(--primary-light);

            color:
                var(--primary);
        }


        /* =================================================
           MOBILE MENU
        ================================================= */

        .dropdown-menu {
            display:
                none;

            flex-direction:
                column;

            position:
                absolute;

            top:
                100%;

            left:
                0;

            right:
                0;

            padding:
                10px;

            background:
                white;

            border-top:
                1px solid #eef1f5;

            box-shadow:
                0 12px 25px rgba(13,38,76,.12);

            animation:
                slideDown .2s ease both;
        }


        .dropdown-menu a {
            display:
                block;

            padding:
                12px 14px;

            border-radius:
                8px;

            color:
                var(--text-dark);

            text-decoration:
                none;

            font-weight:
                600;
        }


        .dropdown-menu a:hover {
            background:
                var(--primary-light);

            color:
                var(--primary);
        }


        .dropdown-menu .divider {
            height:
                1px;

            margin:
                7px 4px;

            background:
                #eef1f5;
        }


        @keyframes slideDown {

            from {
                opacity:
                    0;

                transform:
                    translateY(-8px);
            }

            to {
                opacity:
                    1;

                transform:
                    translateY(0);
            }

        }


        /* =================================================
           MAIN
        ================================================= */

        main {
            width:
                100%;

            margin-top:
                74px;
        }


        /* =================================================
           RESPONSIVE
        ================================================= */

        @media(max-width: 950px) {

            #mainnav,
            .nav-right {
                display:
                    none;
            }


            .nav-toggle {
                display:
                    inline-flex;
            }

        }


        @media(max-width: 500px) {

            .topbar .container {
                padding:
                    0 16px;
            }


            .brand {
                font-size:
                    15px;
            }


            .brand .logo-dot {
                width:
                    35px;

                height:
                    35px;
            }

        }

    </style>


    <script>

        function toggleMenu() {

            const menu =
                document.getElementById(
                    'dropdownMenu'
                );

            if (!menu) {
                return;
            }

            const isOpen =
                menu.style.display === 'flex';

            menu.style.display =
                isOpen
                    ? 'none'
                    : 'flex';

        }


        window.addEventListener(
            'scroll',
            function () {

                const header =
                    document.querySelector(
                        '.topbar'
                    );

                if (!header) {
                    return;
                }

                if (window.scrollY > 40) {

                    header.classList.add(
                        'scrolled'
                    );

                } else {

                    header.classList.remove(
                        'scrolled'
                    );

                }

            }
        );


        document.addEventListener(
            'click',
            function (e) {

                const menu =
                    document.getElementById(
                        'dropdownMenu'
                    );

                const toggle =
                    document.querySelector(
                        '.nav-toggle'
                    );

                if (
                    menu &&
                    toggle &&
                    menu.style.display === 'flex' &&
                    !menu.contains(e.target) &&
                    !toggle.contains(e.target)
                ) {

                    menu.style.display =
                        'none';

                }

            }
        );

    </script>

</head>


<body>


<header class="topbar">

    <div class="container">


        <!-- =============================================
             BRAND
        ============================================== -->

        <a
            class="brand"
            href="<?= $rootUrl ?>/index.php"
        >

            <span class="logo-dot">
                MI
            </span>

            <span>
                MI Aditirto
            </span>

        </a>


        <!-- =============================================
             DESKTOP NAV
        ============================================== -->

        <nav id="mainnav">


            <a
                href="<?= $rootUrl ?>/index.php"
                class="<?= $currentPage === 'index.php' ? 'active' : '' ?>"
            >
                Home
            </a>


            <a
                href="<?= $rootUrl ?>/profile.php"
                class="<?= $currentPage === 'profile.php' ? 'active' : '' ?>"
            >
                Profil
            </a>


            <a
                href="<?= $rootUrl ?>/berita.php"
                class="<?= $currentPage === 'berita.php' ? 'active' : '' ?>"
            >
                Berita
            </a>


            <a
                href="<?= $rootUrl ?>/galeri.php"
                class="<?= $currentPage === 'galeri.php' ? 'active' : '' ?>"
            >
                Galeri
            </a>


            <a
                href="<?= $rootUrl ?>/prestasi.php"
                class="<?= $currentPage === 'prestasi.php' ? 'active' : '' ?>"
            >
                Prestasi
            </a>


            <a
                href="<?= $rootUrl ?>/agenda.php"
                class="<?= $currentPage === 'agenda.php' ? 'active' : '' ?>"
            >
                Agenda
            </a>


            <a
                href="<?= $rootUrl ?>/contact.php"
                class="<?= $currentPage === 'contact.php' ? 'active' : '' ?>"
            >
                Contact
            </a>


        </nav>


        <!-- =============================================
             RIGHT
             LOGIN TIDAK DITAMPILKAN DI HALAMAN PUBLIK
        ============================================== -->

        <div class="nav-right">

            <?php if (!empty($_SESSION['user_id'])): ?>


                <a
                    href="<?= $rootUrl ?>/admin/dashboard_admin.php"
                >
                    Admin
                </a>


                <a
                    href="<?= $rootUrl ?>/logout.php"
                >
                    Logout
                </a>


            <?php endif; ?>

        </div>


        <!-- =============================================
             MOBILE BUTTON
        ============================================== -->

        <button
            class="nav-toggle"
            type="button"
            aria-label="Buka menu"
            onclick="toggleMenu()"
        >
            ☰
        </button>


    </div>


    <!-- =============================================
         MOBILE MENU
    ============================================== -->

    <div
        id="dropdownMenu"
        class="dropdown-menu"
    >


        <a
            href="<?= $rootUrl ?>/index.php"
        >
            Home
        </a>


        <a
            href="<?= $rootUrl ?>/profile.php"
        >
            Profil
        </a>


        <a
            href="<?= $rootUrl ?>/berita.php"
        >
            Berita
        </a>


        <a
            href="<?= $rootUrl ?>/galeri.php"
        >
            Galeri
        </a>


        <a
            href="<?= $rootUrl ?>/prestasi.php"
        >
            Prestasi
        </a>


        <a
            href="<?= $rootUrl ?>/agenda.php"
        >
            Agenda
        </a>


        <a
            href="<?= $rootUrl ?>/contact.php"
        >
            Contact
        </a>


        <?php if (!empty($_SESSION['user_id'])): ?>


            <div class="divider"></div>


            <a
                href="<?= $rootUrl ?>/admin/dashboard_admin.php"
            >
                Admin
            </a>


            <a
                href="<?= $rootUrl ?>/logout.php"
            >
                Logout
            </a>


        <?php endif; ?>


    </div>


</header>


<main>