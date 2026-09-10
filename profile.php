<?php

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/helpers.php';

$title = 'Profil - MI Aditirto';

// Ambil data dari site_profile
$stmt = $pdo->query("SELECT * FROM site_profile LIMIT 1");
$info = $stmt->fetch(PDO::FETCH_ASSOC);

include __DIR__ . '/partials/header.php';

?>

<style>

/* =========================================================
   PROFILE PAGE
========================================================= */

.profile-section {
    padding: 70px 20px 90px;
    background: #f7f9fc;
}

.profile-container {
    max-width: 1100px;
    margin: 0 auto;
}


/* =========================================================
   HEADER
========================================================= */

.profile-heading {
    text-align: center;
    max-width: 750px;
    margin: 0 auto 45px;
}

.profile-badge {
    display: inline-block;
    padding: 7px 14px;

    background: #e8f1ff;
    color: #0d6efd;

    border-radius: 999px;

    font-size: 13px;
    font-weight: 700;

    margin-bottom: 12px;
}

.profile-heading h1 {
    margin: 0 0 12px;

    font-size: 38px;
    font-weight: 800;

    color: #1c2733;
}

.profile-heading p {
    margin: 0;

    color: #6b7785;

    font-size: 16px;
    line-height: 1.7;
}


/* =========================================================
   PROFILE CARD
========================================================= */

.profile-card {
    background: #fff;

    border: 1px solid #edf0f5;
    border-radius: 18px;

    padding: 35px;

    box-shadow: 0 8px 25px rgba(13, 38, 76, .06);

    margin-bottom: 30px;
}


/* =========================================================
   DESCRIPTION
========================================================= */

.profile-card h2 {
    margin: 0 0 18px;

    font-size: 24px;
    color: #1c2733;
}

.profile-description {
    color: #5f6b78;

    font-size: 15px;

    line-height: 1.9;

    margin: 0;
}


/* =========================================================
   INFORMATION
========================================================= */

.profile-info {
    display: grid;

    grid-template-columns: repeat(2, 1fr);

    gap: 18px;

    margin-top: 30px;
}

.profile-info-item {
    padding: 20px;

    background: #f8fafc;

    border-radius: 14px;

    border: 1px solid #edf0f5;
}

.profile-info-item strong {
    display: block;

    color: #1c2733;

    font-size: 14px;

    margin-bottom: 6px;
}

.profile-info-item span {
    color: #6b7785;

    font-size: 14px;

    line-height: 1.6;
}


/* =========================================================
   MAP
========================================================= */

.map-wrapper {
    background: #fff;

    border: 1px solid #edf0f5;

    border-radius: 18px;

    overflow: hidden;

    box-shadow: 0 8px 25px rgba(13, 38, 76, .06);
}

.map-header {
    padding: 25px 30px 18px;
}

.map-header h2 {
    margin: 0 0 6px;

    font-size: 23px;

    color: #1c2733;
}

.map-header p {
    margin: 0;

    color: #6b7785;

    font-size: 14px;
}

.map-wrapper iframe {
    width: 100%;

    height: 400px;

    display: block;

    border: 0;
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 700px) {

    .profile-section {
        padding: 50px 15px 70px;
    }

    .profile-heading h1 {
        font-size: 30px;
    }

    .profile-card {
        padding: 25px;
    }

    .profile-info {
        grid-template-columns: 1fr;
    }

    .map-header {
        padding: 22px;
    }

    .map-wrapper iframe {
        height: 330px;
    }

}

</style>


<section class="profile-section">

    <div class="profile-container">


        <!-- =================================================
             HEADER
        ================================================== -->

        <div class="profile-heading">

            <span class="profile-badge">
                PROFIL MADRASAH
            </span>

            <h1>
                Profil MI Aditirto
            </h1>

            <p>
                Mengenal lebih dekat MI Aditirto sebagai lembaga
                pendidikan yang berkomitmen dalam memberikan
                pendidikan kepada peserta didik.
            </p>

        </div>


        <!-- =================================================
             PROFIL
        ================================================== -->

        <div class="profile-card">

            <h2>
                Tentang MI Aditirto
            </h2>

            <p class="profile-description">
                <?= nl2br(e($info['deskripsi'] ?? '-')) ?>
            </p>


            <!-- INFORMASI SEKOLAH -->

            <div class="profile-info">

                <div class="profile-info-item">

                    <strong>
                         Alamat
                    </strong>

                    <span>
                        <?= e($info['alamat'] ?? '-') ?>
                    </span>

                </div>


                <div class="profile-info-item">

                    <strong>
                         Telepon
                    </strong>

                    <span>
                        <?= e($info['telepon'] ?? '-') ?>
                    </span>

                </div>


                <div class="profile-info-item">

                    <strong>
                         Email
                    </strong>

                    <span>
                        <?= e($info['email'] ?? '-') ?>
                    </span>

                </div>


                <div class="profile-info-item">

                    <strong>
                         Nama Sekolah
                    </strong>

                    <span>
                        MI Aditirto
                    </span>

                </div>

            </div>

        </div>


        <!-- =================================================
             MAP
        ================================================== -->

        <div class="map-wrapper">

            <div class="map-header">

                <h2>
                    Lokasi MI Aditirto
                </h2>

                <p>
                    Lihat lokasi MI Aditirto melalui Google Maps.
                </p>

            </div>


            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3952.1899999999996!2d110.000000!3d-7.800000!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x000000000000000!2sSD%20Aditirto!5e0!3m2!1sid!2sid!4v"
                loading="lazy"
                allowfullscreen
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>

        </div>


    </div>

</section>


<?php include __DIR__ . '/partials/footer.php'; ?>