<?php

$currentPage = basename($_SERVER['SCRIPT_NAME']);

?>

<aside
    class="admin-sidebar"
    id="adminSidebar"
>


    <!-- BRAND -->

    <a
        href="<?= $rootUrl ?? '..' ?>/admin/dashboard_admin.php"
        class="sidebar-brand"
    >

        <div class="sidebar-logo">
            MI
        </div>

        <div class="sidebar-brand-text">

            <strong>
                MI Aditirto
            </strong>

            <span>
                Admin Panel
            </span>

        </div>

    </a>


    <!-- MENU -->

    <div class="sidebar-menu">


        <div class="menu-label">
            Menu Utama
        </div>


        <!-- DASHBOARD -->

        <a
            href="dashboard_admin.php"
            class="<?= $currentPage === 'dashboard_admin.php' ? 'active' : '' ?>"
        >

          

            <span>
                Dashboard
            </span>

        </a>


        <!-- HOME -->

        <a
            href="site_info.php"
            class="<?= $currentPage === 'site_info.php' ? 'active' : '' ?>"
        >

          

            <span>
                Kelola Home
            </span>

        </a>


        <!-- PROFIL -->

        <a
            href="site_profile.php"
            class="<?= $currentPage === 'site_profile.php' ? 'active' : '' ?>"
        >

           

            <span>
                Profil Sekolah
            </span>

        </a>


        <!-- BERITA -->

        <a
            href="berita_list.php"
            class="<?= $currentPage === 'berita_list.php' ? 'active' : '' ?>"
        >

          

            <span>
                Berita
            </span>

        </a>


        <!-- PRESTASI -->

        <a
            href="achievements.php"
            class="<?= $currentPage === 'achievements.php' ? 'active' : '' ?>"
        >

            

            <span>
                Prestasi
            </span>

        </a>


        <!-- GURU -->

        <a
            href="teachers.php"
            class="<?= $currentPage === 'teachers.php' ? 'active' : '' ?>"
        >

           

            <span>
                Struktur Guru
            </span>

        </a>


        <!-- CONTACT -->

        <a
            href="contacts.php"
            class="<?= $currentPage === 'contacts.php' ? 'active' : '' ?>"
        >

         

            <span>
                Pesan Kontak
            </span>

        </a>


    </div>


    <!-- BOTTOM -->

    <div class="sidebar-bottom">


        <a
            href="../index.php"
            target="_blank"
        >

           

            <span>
                Lihat Website
            </span>

        </a>


        <a
            href="../logout.php"
            class="logout"
        >

            

            <span>
                Logout
            </span>

        </a>


    </div>


</aside>


<div
    class="sidebar-overlay"
    id="sidebarOverlay"
></div>