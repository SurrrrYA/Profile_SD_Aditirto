<?php

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/helpers.php';

$title = 'Contact - MI Aditirto';

// Ambil data dari site_profile
$stmt = $pdo->query("SELECT * FROM site_profile LIMIT 1");
$info = $stmt->fetch(PDO::FETCH_ASSOC);

include __DIR__ . '/partials/header.php';

?>

<style>
/* =========================================================
   CONTACT PAGE
========================================================= */

.contact-section {
    padding: 60px 20px 80px;
    background: #f7f9fc;
}

.contact-container {
    max-width: 1150px;
    margin: 0 auto;
}


/* =========================================================
   HEADER
========================================================= */

.contact-heading {
    text-align: center;
    max-width: 750px;
    margin: 0 auto 45px;
}

.contact-heading .badge {
    display: inline-block;
    padding: 7px 14px;
    background: #e8f1ff;
    color: #0d6efd;
    border-radius: 999px;
    font-size: 13px;
    font-weight: 700;
    margin-bottom: 12px;
}

.contact-heading h2 {
    margin: 0 0 12px;
    font-size: 38px;
    font-weight: 800;
    color: #1c2733;
}

.contact-heading p {
    margin: 0;
    color: #6b7785;
    font-size: 16px;
    line-height: 1.7;
}


/* =========================================================
   CONTENT
========================================================= */

.contact-grid {
    display: grid;
    grid-template-columns: 1fr 1.2fr;
    gap: 25px;
}


/* =========================================================
   CONTACT CARD
========================================================= */

.contact-info {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.contact-card {
    display: flex;
    align-items: flex-start;
    gap: 16px;

    background: #fff;
    border: 1px solid #edf0f5;
    border-radius: 16px;

    padding: 22px;

    box-shadow: 0 7px 24px rgba(13, 38, 76, .05);

    transition:
        transform .25s ease,
        box-shadow .25s ease;
}

.contact-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 28px rgba(13, 38, 76, .10);
}


/* =========================================================
   ICON
========================================================= */

.contact-icon {
    width: 46px;
    height: 46px;
    min-width: 46px;

    display: flex;
    align-items: center;
    justify-content: center;

    background: #e8f1ff;
    border-radius: 12px;

    font-size: 20px;
}


/* =========================================================
   TEXT
========================================================= */

.contact-card h3 {
    margin: 0 0 6px;

    font-size: 16px;
    color: #1c2733;
}

.contact-card p {
    margin: 0;

    color: #6b7785;
    font-size: 14px;
    line-height: 1.6;

    word-break: break-word;
}

.contact-card a {
    color: #0d6efd;
    text-decoration: none;
}

.contact-card a:hover {
    text-decoration: underline;
}


/* =========================================================
   MAP
========================================================= */

.map-wrapper {
    background: #fff;

    border: 1px solid #edf0f5;
    border-radius: 18px;

    overflow: hidden;

    box-shadow: 0 7px 24px rgba(13, 38, 76, .05);
}

.map-wrapper iframe {
    width: 100%;
    height: 100%;
    min-height: 430px;

    display: block;

    border: 0;
}


/* =========================================================
   CTA
========================================================= */

.contact-cta {
    margin-top: 35px;

    background: linear-gradient(
        135deg,
        #0d6efd,
        #0a4fc4
    );

    color: #fff;

    border-radius: 20px;

    padding: 35px;

    text-align: center;
}

.contact-cta h3 {
    margin: 0 0 10px;

    font-size: 26px;
}

.contact-cta p {
    max-width: 650px;

    margin: 0 auto 22px;

    line-height: 1.7;

    opacity: .9;
}


/* =========================================================
   BUTTON
========================================================= */

.contact-buttons {
    display: flex;
    justify-content: center;
    gap: 12px;
    flex-wrap: wrap;
}

.contact-btn {
    display: inline-block;

    padding: 11px 20px;

    border-radius: 10px;

    text-decoration: none;

    font-weight: 700;
    font-size: 14px;

    transition:
        transform .2s ease,
        background .2s ease;
}

.contact-btn:hover {
    transform: translateY(-2px);
}


/* WhatsApp */

.contact-btn.whatsapp {
    background: #fff;
    color: #0d6efd;
}


/* Email */

.contact-btn.email {
    background: rgba(255,255,255,.15);
    color: #fff;

    border: 1px solid rgba(255,255,255,.3);
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 800px) {

    .contact-section {
        padding: 50px 15px 70px;
    }

    .contact-heading h2 {
        font-size: 30px;
    }

    .contact-grid {
        grid-template-columns: 1fr;
    }

    .map-wrapper iframe {
        min-height: 350px;
    }

    .contact-cta {
        padding: 28px 20px;
    }
}


@media (max-width: 500px) {

    .contact-card {
        padding: 18px;
    }

    .contact-icon {
        width: 42px;
        height: 42px;
        min-width: 42px;
    }

    .contact-cta h3 {
        font-size: 22px;
    }

}
</style>


<section class="contact-section">

    <div class="contact-container">


        <!-- =================================================
             HEADER
        ================================================== -->

        <div class="contact-heading">

            <span class="badge">
                HUBUNGI KAMI
            </span>

            <h2>
                Kontak MI Aditirto
            </h2>

            <p>
                Silakan hubungi MI Aditirto untuk mendapatkan
                informasi lebih lanjut mengenai kegiatan,
                penerimaan siswa, maupun informasi madrasah lainnya.
            </p>

        </div>


        <!-- =================================================
             CONTACT + MAP
        ================================================== -->

        <div class="contact-grid">


            <!-- =================================================
                 INFORMASI KONTAK
            ================================================== -->

            <div class="contact-info">


                <!-- ALAMAT -->

                <div class="contact-card">

                    <div class="contact-icon">
                        📍
                    </div>

                    <div>

                        <h3>
                            Alamat
                        </h3>

                        <p>
                            <?= e($info['alamat'] ?? '-') ?>
                        </p>

                    </div>

                </div>


                <!-- TELEPON -->

                <div class="contact-card">

                    <div class="contact-icon">
                        📞
                    </div>

                    <div>

                        <h3>
                            Telepon
                        </h3>

                        <p>

                            <?php if (!empty($info['telepon'])): ?>

                                <a href="tel:<?= e($info['telepon']) ?>">
                                    <?= e($info['telepon']) ?>
                                </a>

                            <?php else: ?>

                                -

                            <?php endif; ?>

                        </p>

                    </div>

                </div>


                <!-- EMAIL -->

                <div class="contact-card">

                    <div class="contact-icon">
                        ✉️
                    </div>

                    <div>

                        <h3>
                            Email
                        </h3>

                        <p>

                            <?php if (!empty($info['email'])): ?>

                                <a href="mailto:<?= e($info['email']) ?>">
                                    <?= e($info['email']) ?>
                                </a>

                            <?php else: ?>

                                -

                            <?php endif; ?>

                        </p>

                    </div>

                </div>


                <!-- JAM OPERASIONAL -->

                <div class="contact-card">

                    <div class="contact-icon">
                        🕐
                    </div>

                    <div>

                        <h3>
                            Jam Operasional
                        </h3>

                        <p>
                            Senin - Jumat, 07:00 - 14:00 WIB
                        </p>

                    </div>

                </div>


            </div>


            <!-- =================================================
                 GOOGLE MAPS
            ================================================== -->

            <div class="map-wrapper">

                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3952.1899999999996!2d110.000000!3d-7.800000!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x000000000000000!2sSD%20Aditirto!5e0!3m2!1sid!2sid!4v"
                    loading="lazy"
                    allowfullscreen
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>

            </div>


        </div>


        <!-- =================================================
             CTA
        ================================================== -->

        <div class="contact-cta">

            <h3>
                Ada yang ingin ditanyakan?
            </h3>

            <p>
                Hubungi MI Aditirto melalui WhatsApp atau email
                untuk mendapatkan informasi lebih lanjut.
            </p>


            <div class="contact-buttons">


                <!-- WHATSAPP -->

                <?php if (!empty($info['telepon'])): ?>

                    <?php
                    $wa = preg_replace('/[^0-9]/', '', $info['telepon']);

                    if (substr($wa, 0, 1) === '0') {
                        $wa = '62' . substr($wa, 1);
                    }
                    ?>

                    <a
                        href="https://wa.me/<?= e($wa) ?>"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="contact-btn whatsapp">

                        💬 Hubungi via WhatsApp

                    </a>

                <?php endif; ?>


                <!-- EMAIL -->

                <?php if (!empty($info['email'])): ?>

                    <a
                        href="mailto:<?= e($info['email']) ?>"
                        class="contact-btn email">

                        ✉️ Kirim Email

                    </a>

                <?php endif; ?>


            </div>

        </div>


    </div>

</section>


<?php include __DIR__ . '/partials/footer.php'; ?>