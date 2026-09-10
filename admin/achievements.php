<?php

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../helpers.php';

require_login();

$title = 'Admin - Prestasi';

/* =========================
   HAPUS DATA
========================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['_action'] ?? '') === 'delete') {
    try {
        check_csrf();

        $id = (int) ($_POST['id'] ?? 0);

        if ($id > 0) {
            $stmt = $pdo->prepare("DELETE FROM achievements WHERE id = ?");
            $stmt->execute([$id]);
        }

        header('Location: achievements.php');
        exit;

    } catch (Exception $e) {
        die("Gagal menghapus data: " . $e->getMessage());
    }
}

/* =========================
   TAMBAH DATA
========================= */
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['_action'] ?? '') === 'create') {
    try {
        check_csrf();

        $titleIn = trim($_POST['title'] ?? '');
        $descIn  = trim($_POST['description'] ?? '');
        $dateIn  = !empty($_POST['achieved_at'])
            ? $_POST['achieved_at']
            : null;

        if ($titleIn) {

            $stmt = $pdo->prepare("
                INSERT INTO achievements(title, description, achieved_at)
                VALUES (?, ?, ?)
            ");

            $stmt->execute([
                $titleIn,
                $descIn,
                $dateIn
            ]);

            $msg = 'Prestasi berhasil ditambahkan.';

        } else {
            $msg = 'Judul wajib diisi.';
        }

    } catch (Exception $e) {
        die("Gagal menambah data: " . $e->getMessage());
    }
}

/* =========================
   AMBIL DATA PRESTASI
========================= */
$list = $pdo
    ->query("SELECT * FROM achievements ORDER BY achieved_at DESC, id DESC")
    ->fetchAll(PDO::FETCH_ASSOC);


/* =========================
   HEADER ADMIN
========================= */
include __DIR__ . '/../partials/admin_header.php';
include __DIR__ . '/../partials/admin_sidebar.php';
?>

<div class="admin-main">

    <!-- TOPBAR -->
    <header class="admin-topbar">

        <div style="display:flex;align-items:center;gap:12px;">

            <button
                type="button"
                class="sidebar-toggle"
                id="sidebarToggle"
                aria-label="Buka menu"
            >
                
            </button>

            <div class="admin-page-title">
                Kelola Prestasi
            </div>

        </div>

        <div class="admin-user">

            <div class="admin-avatar">
                A
            </div>

            <div class="admin-user-info">
                <strong>Administrator</strong>
                <span>Admin</span>
            </div>

        </div>

    </header>


    <!-- CONTENT -->
    <main class="admin-content">

        <div class="page-header">

            <div>
                <h1> Kelola Prestasi Sekolah</h1>
                <p>
                    Tambahkan dan kelola daftar prestasi yang dimiliki MI Aditirto.
                </p>
            </div>

            <a
                href="../prestasi.php"
                target="_blank"
                class="btn-view"
            >
                 Lihat Prestasi
            </a>

        </div>


        <?php if ($msg): ?>

            <div class="alert-success">
                <span>✓</span>
                <div><?= e($msg) ?></div>
            </div>

        <?php endif; ?>


        <!-- FORM TAMBAH -->
        <section class="content-card">

            <div class="card-header">

                <div>
                    <h2>Tambah Prestasi Baru</h2>
                    <p>Isi informasi prestasi yang ingin ditambahkan.</p>
                </div>

              

            </div>


            <form method="post">

                <?php csrf_field(); ?>

                <input
                    type="hidden"
                    name="_action"
                    value="create"
                >


                <div class="form-grid">

                    <div class="form-group full">

                        <label for="title">
                            Judul Prestasi
                        </label>

                        <input
                            type="text"
                            id="title"
                            name="title"
                            placeholder="Contoh: Juara 1 Lomba Tahfidz Al-Qur'an"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label for="achieved_at">
                            Tanggal
                            <span class="optional">(opsional)</span>
                        </label>

                        <input
                            type="date"
                            id="achieved_at"
                            name="achieved_at"
                        >

                    </div>


                    <div class="form-group full">

                        <label for="description">
                            Deskripsi
                        </label>

                        <textarea
                            id="description"
                            name="description"
                            rows="5"
                            placeholder="Tuliskan deskripsi atau keterangan prestasi..."
                        ></textarea>

                    </div>

                </div>


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
                        ➕ Tambah Prestasi
                    </button>

                </div>

            </form>

        </section>


        <!-- DAFTAR PRESTASI -->
        <section class="content-card">

            <div class="card-header">

                <div>
                    <h2>Daftar Prestasi</h2>
                    <p>
                        <?= count($list) ?> data prestasi tersimpan.
                    </p>
                </div>

                <div class="total-badge">
                    <?= count($list) ?>
                </div>

            </div>


            <?php if (!empty($list)): ?>

                <div class="table-wrapper">

                    <table class="admin-table">

                        <thead>

                            <tr>
                                <th width="60">No</th>
                                <th>Judul Prestasi</th>
                                <th width="150">Tanggal</th>
                                <th>Deskripsi</th>
                                <th width="110">Aksi</th>
                            </tr>

                        </thead>

                        <tbody>

                            <?php foreach ($list as $index => $r): ?>

                                <tr>

                                    <td>
                                        <span class="number-badge">
                                            <?= $index + 1 ?>
                                        </span>
                                    </td>


                                    <td>

                                        <div class="achievement-title">
                                            🏆
                                            <strong>
                                                <?= e($r['title']) ?>
                                            </strong>
                                        </div>

                                    </td>


                                    <td>

                                        <?php if (!empty($r['achieved_at'])): ?>

                                            <span class="date-badge">
                                                
                                                <?= e(
                                                    date(
                                                        'd/m/Y',
                                                        strtotime($r['achieved_at'])
                                                    )
                                                ) ?>
                                            </span>

                                        <?php else: ?>

                                            <span class="no-date">
                                                Tidak ada tanggal
                                            </span>

                                        <?php endif; ?>

                                    </td>


                                    <td>

                                        <?php if (!empty($r['description'])): ?>

                                            <div class="description-text">
                                                <?= nl2br(e($r['description'])) ?>
                                            </div>

                                        <?php else: ?>

                                            <span class="no-description">
                                                Tidak ada deskripsi
                                            </span>

                                        <?php endif; ?>

                                    </td>


                                    <td>

                                        <form
                                            method="post"
                                            onsubmit="return confirm('Yakin ingin menghapus prestasi ini?')"
                                        >

                                            <?php csrf_field(); ?>

                                            <input
                                                type="hidden"
                                                name="_action"
                                                value="delete"
                                            >

                                            <input
                                                type="hidden"
                                                name="id"
                                                value="<?= (int) $r['id'] ?>"
                                            >

                                            <button
                                                type="submit"
                                                class="btn-delete"
                                            >
                                                 Hapus
                                            </button>

                                        </form>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        </tbody>

                    </table>

                </div>

            <?php else: ?>

                <div class="empty-state">

                    <div class="empty-icon">
                        🏆
                    </div>

                    <h3>Belum Ada Prestasi</h3>

                    <p>
                        Belum ada data prestasi yang ditambahkan.
                    </p>

                    <p>
                        Gunakan formulir di atas untuk menambahkan prestasi pertama.
                    </p>

                </div>

            <?php endif; ?>

        </section>

    </main>

</div>


<style>

/* =========================
   PAGE HEADER
========================= */

.page-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    margin-bottom: 25px;
}

.page-header h1 {
    margin: 0 0 7px;
    font-size: 27px;
    color: #1c2733;
}

.page-header p {
    margin: 0;
    color: #7b8794;
    font-size: 14px;
}

.btn-view {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 10px 16px;
    border-radius: 9px;
    background: #e8f1ff;
    color: #0d6efd;
    text-decoration: none;
    font-size: 13px;
    font-weight: 700;
    white-space: nowrap;
}

.btn-view:hover {
    background: #dceaff;
}


/* =========================
   ALERT
========================= */

.alert-success {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #ecfdf3;
    border: 1px solid #c8f0d8;
    color: #198754;
    padding: 13px 16px;
    border-radius: 10px;
    margin-bottom: 20px;
    font-size: 14px;
    font-weight: 600;
}

.alert-success span {
    width: 25px;
    height: 25px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: #198754;
    color: white;
    font-size: 13px;
}


/* =========================
   CONTENT CARD
========================= */

.content-card {
    background: #fff;
    border: 1px solid #edf0f4;
    border-radius: 15px;
    margin-bottom: 22px;
    box-shadow: 0 5px 18px rgba(13, 38, 76, .05);
    overflow: hidden;
}

.card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
    padding: 21px 23px;
    border-bottom: 1px solid #edf0f4;
}

.card-header h2 {
    margin: 0 0 5px;
    color: #253342;
    font-size: 18px;
}

.card-header p {
    margin: 0;
    color: #8a96a3;
    font-size: 13px;
}

.card-icon {
    width: 43px;
    height: 43px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 11px;
    background: #e8f1ff;
    font-size: 20px;
}

.total-badge {
    min-width: 40px;
    height: 40px;
    padding: 0 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    background: #e8f1ff;
    color: #0d6efd;
    font-size: 15px;
    font-weight: 800;
}


/* =========================
   FORM
========================= */

.content-card form {
    padding: 23px;
}

.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 18px 20px;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group.full {
    grid-column: 1 / -1;
}

.form-group label {
    margin-bottom: 7px;
    color: #344252;
    font-size: 13px;
    font-weight: 700;
}

.optional {
    color: #9aa5b1;
    font-weight: 400;
}

.form-group input,
.form-group textarea {
    width: 100%;
    padding: 11px 13px;
    border: 1px solid #dfe5eb;
    border-radius: 9px;
    background: #fff;
    color: #263442;
    font-family: inherit;
    font-size: 14px;
    outline: none;
    transition: border-color .2s ease, box-shadow .2s ease;
}

.form-group input:focus,
.form-group textarea:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 3px rgba(13, 110, 253, .10);
}

.form-group textarea {
    resize: vertical;
    min-height: 120px;
}

.form-group input::placeholder,
.form-group textarea::placeholder {
    color: #adb5bd;
}


/* =========================
   FORM BUTTON
========================= */

.form-actions {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 10px;
    margin-top: 22px;
    padding-top: 18px;
    border-top: 1px solid #edf0f4;
}

.btn-primary,
.btn-secondary {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 10px 17px;
    border-radius: 9px;
    font-family: inherit;
    font-size: 13px;
    font-weight: 700;
    text-decoration: none;
    cursor: pointer;
}

.btn-primary {
    border: none;
    background: #0d6efd;
    color: white;
}

.btn-primary:hover {
    background: #0b5ed7;
}

.btn-secondary {
    border: 1px solid #dfe5eb;
    background: white;
    color: #687585;
}

.btn-secondary:hover {
    background: #f7f9fb;
    color: #253342;
}


/* =========================
   TABLE
========================= */

.table-wrapper {
    width: 100%;
    overflow-x: auto;
}

.admin-table {
    width: 100%;
    border-collapse: collapse;
}

.admin-table th {
    padding: 13px 16px;
    background: #f8fafc;
    border-bottom: 1px solid #e7ebef;
    color: #687585;
    font-size: 12px;
    font-weight: 700;
    text-align: left;
    white-space: nowrap;
}

.admin-table td {
    padding: 15px 16px;
    border-bottom: 1px solid #edf0f4;
    color: #52606d;
    font-size: 13px;
    vertical-align: top;
}

.admin-table tbody tr {
    transition: background .2s ease;
}

.admin-table tbody tr:hover {
    background: #fafcff;
}

.admin-table tbody tr:last-child td {
    border-bottom: none;
}


/* =========================
   TABLE CONTENT
========================= */

.number-badge {
    width: 30px;
    height: 30px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    background: #f1f4f7;
    color: #687585;
    font-size: 12px;
    font-weight: 700;
}

.achievement-title {
    display: flex;
    align-items: flex-start;
    gap: 8px;
    color: #263442;
    line-height: 1.5;
}

.achievement-title strong {
    font-size: 13px;
}

.date-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 6px 9px;
    border-radius: 7px;
    background: #f1f6ff;
    color: #0d6efd;
    font-size: 12px;
    font-weight: 600;
    white-space: nowrap;
}

.no-date {
    color: #a0aab5;
    font-size: 12px;
    font-style: italic;
}

.description-text {
    max-width: 400px;
    color: #687585;
    line-height: 1.6;
}

.no-description {
    color: #a0aab5;
    font-size: 12px;
    font-style: italic;
}

.btn-delete {
    border: none;
    padding: 8px 11px;
    border-radius: 8px;
    background: #fff0f0;
    color: #dc3545;
    font-family: inherit;
    font-size: 12px;
    font-weight: 700;
    cursor: pointer;
    white-space: nowrap;
}

.btn-delete:hover {
    background: #dc3545;
    color: white;
}


/* =========================
   EMPTY STATE
========================= */

.empty-state {
    padding: 55px 20px;
    text-align: center;
}

.empty-icon {
    width: 65px;
    height: 65px;
    margin: 0 auto 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 16px;
    background: #f1f4f7;
    font-size: 28px;
}

.empty-state h3 {
    margin: 0 0 7px;
    color: #344252;
    font-size: 17px;
}

.empty-state p {
    margin: 4px 0;
    color: #8a96a3;
    font-size: 13px;
}


/* =========================
   RESPONSIVE
========================= */

@media (max-width: 900px) {

    .page-header {
        align-items: flex-start;
        flex-direction: column;
    }

    .form-grid {
        grid-template-columns: 1fr;
    }

    .form-group.full {
        grid-column: auto;
    }

}

@media (max-width: 600px) {

    .page-header h1 {
        font-size: 23px;
    }

    .card-header {
        padding: 18px;
    }

    .content-card form {
        padding: 18px;
    }

    .form-actions {
        flex-direction: column-reverse;
        align-items: stretch;
    }

    .btn-primary,
    .btn-secondary {
        width: 100%;
    }

    .admin-table th,
    .admin-table td {
        padding: 12px;
    }

    .description-text {
        min-width: 220px;
    }

}

</style>


<?php include __DIR__ . '/../partials/admin_footer.php'; ?>