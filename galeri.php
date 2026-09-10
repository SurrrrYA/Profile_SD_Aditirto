<?php

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/helpers.php';

$title = 'Galeri - MI Aditirto';

include __DIR__ . '/partials/header.php';

?>

<style>

/* =========================================================
   GALERI
========================================================= */

.galeri-page {
    background: #f7f9fc;
    min-height: calc(100vh - 74px);
    padding: 70px 20px 90px;
}

.galeri-container {
    max-width: 1200px;
    margin: 0 auto;
}


/* =========================================================
   HEADER
========================================================= */

.galeri-header {
    text-align: center;
    margin-bottom: 45px;
}

.galeri-label {
    display: inline-block;
    padding: 7px 15px;
    border-radius: 30px;
    background: #e8f1ff;
    color: #0d6efd;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: .4px;
    margin-bottom: 12px;
}

.galeri-header h1 {
    margin: 0 0 12px;
    font-size: 38px;
    color: #1c2733;
}

.galeri-header p {
    max-width: 650px;
    margin: auto;
    color: #6b7785;
    line-height: 1.7;
}


/* =========================================================
   GRID
========================================================= */

.galeri-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 22px;
}


/* =========================================================
   ITEM
========================================================= */

.galeri-item {
    position: relative;
    height: 280px;
    overflow: hidden;
    border-radius: 18px;
    background: #e8f1ff;
    cursor: pointer;
    box-shadow: 0 8px 25px rgba(13, 38, 76, 0.08);
}

.galeri-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform .45s ease;
}


/* =========================================================
   OVERLAY
========================================================= */

.galeri-overlay {
    position: absolute;
    inset: 0;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    padding: 22px;
    background: linear-gradient(
        to top,
        rgba(0,0,0,.65),
        rgba(0,0,0,.05) 70%
    );
    opacity: 0;
    transition: opacity .3s ease;
}

.galeri-item:hover img {
    transform: scale(1.08);
}

.galeri-item:hover .galeri-overlay {
    opacity: 1;
}

.galeri-overlay h3 {
    color: #fff;
    margin: 0 0 5px;
    font-size: 18px;
}

.galeri-overlay span {
    color: rgba(255,255,255,.85);
    font-size: 13px;
}


/* =========================================================
   EMPTY
========================================================= */

.galeri-empty {
    background: #fff;
    border-radius: 18px;
    padding: 70px 20px;
    text-align: center;
    color: #6b7785;
}

.galeri-empty-icon {
    font-size: 55px;
    margin-bottom: 15px;
}

.galeri-empty h3 {
    color: #1c2733;
    margin-bottom: 8px;
}


/* =========================================================
   LIGHTBOX
========================================================= */

.lightbox {
    position: fixed;
    inset: 0;
    z-index: 2000;
    background: rgba(0, 0, 0, .88);
    display: none;
    align-items: center;
    justify-content: center;
    padding: 25px;
}

.lightbox.show {
    display: flex;
}

.lightbox img {
    max-width: 90%;
    max-height: 85vh;
    object-fit: contain;
    border-radius: 10px;
    box-shadow: 0 15px 50px rgba(0,0,0,.4);
}

.lightbox-close {
    position: absolute;
    top: 20px;
    right: 25px;
    width: 42px;
    height: 42px;
    border: none;
    border-radius: 50%;
    background: rgba(255,255,255,.15);
    color: #fff;
    font-size: 25px;
    cursor: pointer;
}

.lightbox-close:hover {
    background: rgba(255,255,255,.25);
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 900px) {

    .galeri-grid {
        grid-template-columns: repeat(2, 1fr);
    }

}

@media (max-width: 600px) {

    .galeri-page {
        padding: 50px 15px 70px;
    }

    .galeri-header h1 {
        font-size: 30px;
    }

    .galeri-grid {
        grid-template-columns: 1fr;
        gap: 18px;
    }

    .galeri-item {
        height: 250px;
    }

    .galeri-overlay {
        opacity: 1;
    }

}

</style>


<section class="galeri-page">

    <div class="galeri-container">


        <!-- HEADER -->

        <div class="galeri-header">

            <span class="galeri-label">
                DOKUMENTASI
            </span>

            <h1>
                Galeri MI Aditirto
            </h1>

            <p>
                Dokumentasi berbagai kegiatan, aktivitas,
                dan momen kebersamaan di MI Aditirto.
            </p>

        </div>


        <!-- GALERI -->

        <div class="galeri-grid">


            <!-- FOTO 1 -->

            <div
                class="galeri-item"
                onclick="openLightbox(
                    'assets/img/galeri1.jpg',
                    'Kegiatan MI Aditirto'
                )"
            >

                <img
                    src="assets/img/galeri1.jpg"
                    alt="Kegiatan MI Aditirto"
                >

                <div class="galeri-overlay">

                    <h3>
                        Kegiatan MI Aditirto
                    </h3>

                    <span>
                        Dokumentasi kegiatan
                    </span>

                </div>

            </div>


            <!-- FOTO 2 -->

            <div
                class="galeri-item"
                onclick="openLightbox(
                    'assets/img/galeri2.jpg',
                    'Kegiatan Siswa'
                )"
            >

                <img
                    src="assets/img/galeri2.jpg"
                    alt="Kegiatan Siswa"
                >

                <div class="galeri-overlay">

                    <h3>
                        Kegiatan Siswa
                    </h3>

                    <span>
                        Aktivitas siswa
                    </span>

                </div>

            </div>


            <!-- FOTO 3 -->

            <div
                class="galeri-item"
                onclick="openLightbox(
                    'assets/img/galeri3.jpg',
                    'Kegiatan Sekolah'
                )"
            >

                <img
                    src="assets/img/galeri3.jpg"
                    alt="Kegiatan Sekolah"
                >

                <div class="galeri-overlay">

                    <h3>
                        Kegiatan Sekolah
                    </h3>

                    <span>
                        Dokumentasi sekolah
                    </span>

                </div>

            </div>


            <!-- FOTO 4 -->

            <div
                class="galeri-item"
                onclick="openLightbox(
                    'assets/img/galeri4.jpg',
                    'Aktivitas Siswa'
                )"
            >

                <img
                    src="assets/img/galeri4.jpg"
                    alt="Aktivitas Siswa"
                >

                <div class="galeri-overlay">

                    <h3>
                        Aktivitas Siswa
                    </h3>

                    <span>
                        Dokumentasi kegiatan
                    </span>

                </div>

            </div>


            <!-- FOTO 5 -->

            <div
                class="galeri-item"
                onclick="openLightbox(
                    'assets/img/galeri5.jpg',
                    'Kegiatan Madrasah'
                )"
            >

                <img
                    src="assets/img/galeri5.jpg"
                    alt="Kegiatan Madrasah"
                >

                <div class="galeri-overlay">

                    <h3>
                        Kegiatan Madrasah
                    </h3>

                    <span>
                        Dokumentasi kegiatan
                    </span>

                </div>

            </div>


            <!-- FOTO 6 -->

            <div
                class="galeri-item"
                onclick="openLightbox(
                    'assets/img/galeri6.jpg',
                    'Momen Kebersamaan'
                )"
            >

                <img
                    src="assets/img/galeri6.jpg"
                    alt="Momen Kebersamaan"
                >

                <div class="galeri-overlay">

                    <h3>
                        Momen Kebersamaan
                    </h3>

                    <span>
                        MI Aditirto
                    </span>

                </div>

            </div>


        </div>

    </div>

</section>


<!-- LIGHTBOX -->

<div
    id="lightbox"
    class="lightbox"
    onclick="closeLightbox()"
>

    <button
        class="lightbox-close"
        onclick="closeLightbox()"
        type="button"
    >
        ×
    </button>

    <img
        id="lightboxImage"
        src=""
        alt=""
        onclick="event.stopPropagation()"
    >

</div>


<script>

function openLightbox(image, title) {

    const lightbox = document.getElementById('lightbox');
    const imageElement = document.getElementById('lightboxImage');

    imageElement.src = image;
    imageElement.alt = title;

    lightbox.classList.add('show');

    document.body.style.overflow = 'hidden';
}


function closeLightbox() {

    const lightbox = document.getElementById('lightbox');

    lightbox.classList.remove('show');

    document.body.style.overflow = '';

}


document.addEventListener('keydown', function(event) {

    if (event.key === 'Escape') {
        closeLightbox();
    }

});

</script>


<?php

include __DIR__ . '/partials/footer.php';

?>