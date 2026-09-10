<?php

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../helpers.php';

require_login();

$title = 'Admin - Struktur Guru';

$uploadDir = __DIR__ . '/../uploads/teachers/';

/* =========================
   VARIABEL
========================= */

$msg = '';
$editData = null;


/* =========================
   HAPUS DATA GURU
========================= */

if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    ($_POST['_action'] ?? '') === 'delete'
) {
    check_csrf();

    $id = (int) ($_POST['id'] ?? 0);

    if ($id > 0) {

        // Ambil foto lama
        $stmt = $pdo->prepare(
            "SELECT photo FROM teachers WHERE id = ?"
        );
        $stmt->execute([$id]);

        $old = $stmt->fetch(PDO::FETCH_ASSOC);

        // Hapus file foto
        if (
            $old &&
            !empty($old['photo']) &&
            file_exists($uploadDir . $old['photo'])
        ) {
            unlink($uploadDir . $old['photo']);
        }

        // Hapus data
        $stmt = $pdo->prepare(
            "DELETE FROM teachers WHERE id = ?"
        );
        $stmt->execute([$id]);
    }

    header('Location: teachers.php');
    exit;
}


/* =========================
   UPDATE DATA GURU
========================= */

if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    ($_POST['_action'] ?? '') === 'update'
) {
    check_csrf();

    $id       = (int) ($_POST['id'] ?? 0);
    $name     = trim($_POST['name'] ?? '');
    $position = trim($_POST['position'] ?? '');
    $phone    = trim($_POST['phone'] ?? '');

    // Ambil data lama
    $stmt = $pdo->prepare(
        "SELECT * FROM teachers WHERE id = ?"
    );
    $stmt->execute([$id]);

    $old = $stmt->fetch(PDO::FETCH_ASSOC);

    $photoName = $old['photo'] ?? null;

    if ($name && $position) {

        /* =========================
           UPLOAD FOTO BARU
        ========================= */

        if (
            isset($_FILES['photo']) &&
            !empty($_FILES['photo']['name']) &&
            $_FILES['photo']['error'] === UPLOAD_ERR_OK
        ) {

            $ext = strtolower(
                pathinfo(
                    $_FILES['photo']['name'],
                    PATHINFO_EXTENSION
                )
            );

            $allowed = [
                'jpg',
                'jpeg',
                'png',
                'gif'
            ];

            if (in_array($ext, $allowed, true)) {

                $photoName =
                    uniqid('teacher_', true) .
                    '.' .
                    $ext;

                if (
                    move_uploaded_file(
                        $_FILES['photo']['tmp_name'],
                        $uploadDir . $photoName
                    )
                ) {

                    // Hapus foto lama
                    if (
                        $old &&
                        !empty($old['photo']) &&
                        file_exists($uploadDir . $old['photo'])
                    ) {
                        unlink(
                            $uploadDir . $old['photo']
                        );
                    }

                } else {

                    $photoName = $old['photo'] ?? null;
                    $msg = '❌ Foto gagal diupload.';
                }
            }
        }

        /* =========================
           UPDATE DATABASE
        ========================= */

        $stmt = $pdo->prepare("
            UPDATE teachers
            SET name = ?,
                position = ?,
                phone = ?,
                photo = ?
            WHERE id = ?
        ");

        $stmt->execute([
            $name,
            $position,
            $phone,
            $photoName,
            $id
        ]);

        $msg = 'Data guru berhasil diperbarui.';

    } else {

        $msg = 'Nama dan Jabatan wajib diisi.';
    }
}


/* =========================
   AMBIL DATA UNTUK EDIT
========================= */

if (isset($_GET['edit'])) {

    $id = (int) $_GET['edit'];

    if ($id > 0) {

        $stmt = $pdo->prepare(
            "SELECT * FROM teachers WHERE id = ?"
        );

        $stmt->execute([$id]);

        $editData = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}


/* =========================
   TAMBAH DATA GURU
========================= */

if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    ($_POST['_action'] ?? '') === 'create'
) {
    check_csrf();

    $name     = trim($_POST['name'] ?? '');
    $position = trim($_POST['position'] ?? '');
    $phone    = trim($_POST['phone'] ?? '');

    $photoName = null;

    if ($name && $position) {

        /* =========================
           UPLOAD FOTO
        ========================= */

        if (
            isset($_FILES['photo']) &&
            !empty($_FILES['photo']['name']) &&
            $_FILES['photo']['error'] === UPLOAD_ERR_OK
        ) {

            $ext = strtolower(
                pathinfo(
                    $_FILES['photo']['name'],
                    PATHINFO_EXTENSION
                )
            );

            $allowed = [
                'jpg',
                'jpeg',
                'png',
                'gif'
            ];

            if (in_array($ext, $allowed, true)) {

                $photoName =
                    uniqid('teacher_', true) .
                    '.' .
                    $ext;

                if (
                    !move_uploaded_file(
                        $_FILES['photo']['tmp_name'],
                        $uploadDir . $photoName
                    )
                ) {
                    $photoName = null;
                }
            }
        }

        /* =========================
           INSERT DATABASE
        ========================= */

        $stmt = $pdo->prepare("
            INSERT INTO teachers
            (name, position, phone, photo)
            VALUES (?, ?, ?, ?)
        ");

        $stmt->execute([
            $name,
            $position,
            $phone,
            $photoName
        ]);

        $msg = 'Data guru berhasil ditambahkan.';

    } else {

        $msg = 'Nama dan Jabatan wajib diisi.';
    }
}


/* =========================
   AMBIL SEMUA DATA GURU
========================= */

$list = $pdo
    ->query("
        SELECT *
        FROM teachers
        ORDER BY position ASC, name ASC
    ")
    ->fetchAll(PDO::FETCH_ASSOC);


/* =========================
   ADMIN HEADER + SIDEBAR
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
                ☰
            </button>

            <div class="admin-page-title">
                Struktur Guru
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

        <!-- PAGE HEADER -->
        <div class="page-header">

            <div>

                <h1>
                     Kelola Struktur Guru
                </h1>

                <p>
                    Tambahkan, ubah, dan kelola data guru MI Aditirto.
                </p>

            </div>

            <a
                href="../struktur_guru.php"
                target="_blank"
                class="btn-view"
            >
                 Lihat Struktur
            </a>

        </div>


        <!-- MESSAGE -->
        <?php if ($msg): ?>

            <div class="alert-success">

                <span>✓</span>

                <div>
                    <?= e($msg) ?>
                </div>

            </div>

        <?php endif; ?>


        <!-- FORM -->
        <section class="content-card">

            <div class="card-header">

                <div>

                    <h2>
                        <?= $editData
                            ? ' Edit Data Guru'
                            : 'Tambah Guru'
                        ?>
                    </h2>

                    <p>
                        <?= $editData
                            ? 'Perbarui informasi guru yang dipilih.'
                            : 'Isi informasi guru yang ingin ditambahkan.'
                        ?>
                    </p>

                </div>

              

            </div>


            <form
                method="post"
                enctype="multipart/form-data"
            >

                <?php csrf_field(); ?>


                <?php if ($editData): ?>

                    <input
                        type="hidden"
                        name="_action"
                        value="update"
                    >

                    <input
                        type="hidden"
                        name="id"
                        value="<?= (int) $editData['id'] ?>"
                    >

                <?php else: ?>

                    <input
                        type="hidden"
                        name="_action"
                        value="create"
                    >

                <?php endif; ?>


                <div class="form-grid">

                    <!-- NAMA -->
                    <div class="form-group">

                        <label for="name">
                            Nama Guru
                        </label>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="<?= $editData
                                ? e($editData['name'])
                                : ''
                            ?>"
                            placeholder="Contoh: Ahmad Fauzi, S.Pd."
                            required
                        >

                    </div>


                    <!-- JABATAN -->
                    <div class="form-group">

                        <label for="position">
                            Jabatan
                        </label>

                        <input
                            type="text"
                            id="position"
                            name="position"
                            value="<?= $editData
                                ? e($editData['position'])
                                : ''
                            ?>"
                            placeholder="Kepala Madrasah / Guru Kelas"
                            required
                        >

                    </div>


                    <!-- TELEPON -->
                    <div class="form-group">

                        <label for="phone">
                            No. HP
                            <span class="optional">
                                (opsional)
                            </span>
                        </label>

                        <input
                            type="text"
                            id="phone"
                            name="phone"
                            value="<?= $editData
                                ? e($editData['phone'])
                                : ''
                            ?>"
                            placeholder="08xxxxxxxxxx"
                        >

                    </div>


                    <!-- FOTO -->
                    <div class="form-group">

                        <label for="photo">
                            Foto
                            <span class="optional">
                                (opsional)
                            </span>
                        </label>

                        <input
                            type="file"
                            id="photo"
                            name="photo"
                            accept="image/jpeg,image/png,image/gif"
                        >

                        <small class="input-help">
                            JPG, JPEG, PNG, atau GIF.
                        </small>

                    </div>


                    <?php if ($editData && !empty($editData['photo'])): ?>

                        <div class="current-photo">

                            <div class="current-photo-label">
                                Foto saat ini
                            </div>

                            <img
                                src="../uploads/teachers/<?= e($editData['photo']) ?>"
                                alt="<?= e($editData['name']) ?>"
                            >

                            <span>
                                Biarkan pilihan foto kosong jika tidak ingin menggantinya.
                            </span>

                        </div>

                    <?php endif; ?>

                </div>


                <!-- BUTTON -->
                <div class="form-actions">

                    <?php if ($editData): ?>

                        <a
                            href="teachers.php"
                            class="btn-secondary"
                        >
                            ✕ Batal
                        </a>

                        <button
                            type="submit"
                            class="btn-primary"
                        >
                             Simpan Perubahan
                        </button>

                    <?php else: ?>

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
                             Tambah Guru
                        </button>

                    <?php endif; ?>

                </div>

            </form>

        </section>


        <!-- DATA GURU -->
        <section class="content-card">

            <div class="card-header">

                <div>

                    <h2>
                         Data Guru
                    </h2>

                    <p>
                        <?= count($list) ?> data guru tersimpan.
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

                                <th width="80">
                                    Foto
                                </th>

                                <th>
                                    Nama
                                </th>

                                <th>
                                    Jabatan
                                </th>

                                <th>
                                    Kontak
                                </th>

                                <th width="170">
                                    Aksi
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            <?php foreach ($list as $r): ?>

                                <tr>

                                    <!-- FOTO -->
                                    <td>

                                        <?php if (!empty($r['photo'])): ?>

                                            <img
                                                src="../uploads/teachers/<?= e($r['photo']) ?>"
                                                alt="<?= e($r['name']) ?>"
                                                class="teacher-thumb"
                                            >

                                        <?php else: ?>

                                            <div class="teacher-placeholder">
                                                👤
                                            </div>

                                        <?php endif; ?>

                                    </td>


                                    <!-- NAMA -->
                                    <td>

                                        <div class="teacher-name">

                                            <strong>
                                                <?= e($r['name']) ?>
                                            </strong>

                                        </div>

                                    </td>


                                    <!-- JABATAN -->
                                    <td>

                                        <span class="position-badge">
                                            <?= e($r['position']) ?>
                                        </span>

                                    </td>


                                    <!-- PHONE -->
                                    <td>

                                        <?php if (!empty($r['phone'])): ?>

                                            <span class="phone-text">
                                                 <?= e($r['phone']) ?>
                                            </span>

                                        <?php else: ?>

                                            <span class="no-data">
                                                Tidak ada kontak
                                            </span>

                                        <?php endif; ?>

                                    </td>


                                    <!-- ACTION -->
                                    <td>

                                        <div class="action-group">

                                            <a
                                                href="teachers.php?edit=<?= (int) $r['id'] ?>"
                                                class="btn-edit"
                                            >
                                                 Edit
                                            </a>


                                            <form
                                                method="post"
                                                onsubmit="return confirm('Yakin ingin menghapus data guru ini?')"
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

                                        </div>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        </tbody>

                    </table>

                </div>

            <?php else: ?>

                <div class="empty-state">

                    <div class="empty-icon">
                        👩‍🏫
                    </div>

                    <h3>
                        Belum Ada Data Guru
                    </h3>

                    <p>
                        Belum ada data guru yang ditambahkan.
                    </p>

                    <p>
                        Gunakan formulir di atas untuk menambahkan data guru.
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
   CARD
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

.form-group input {
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

.form-group input:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 3px rgba(13, 110, 253, .10);
}

.form-group input[type="file"] {
    padding: 9px;
    background: #f9fafb;
}

.input-help {
    margin-top: 6px;
    color: #9aa5b1;
    font-size: 11px;
}

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
}


/* =========================
   FOTO SAAT EDIT
========================= */

.current-photo {
    grid-column: 1 / -1;
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 14px;
    border: 1px solid #e8edf3;
    border-radius: 10px;
    background: #fafbfd;
}

.current-photo-label {
    color: #687585;
    font-size: 12px;
    font-weight: 700;
}

.current-photo img {
    width: 65px;
    height: 65px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #e8f1ff;
}

.current-photo span {
    color: #8a96a3;
    font-size: 12px;
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
    padding: 14px 16px;
    border-bottom: 1px solid #edf0f4;
    color: #52606d;
    font-size: 13px;
    vertical-align: middle;
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
   TEACHER
========================= */

.teacher-thumb,
.teacher-placeholder {
    width: 50px;
    height: 50px;
    border-radius: 50%;
}

.teacher-thumb {
    display: block;
    object-fit: cover;
    border: 2px solid #e8edf3;
}

.teacher-placeholder {
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f1f4f7;
    font-size: 21px;
}

.teacher-name {
    color: #263442;
}

.teacher-name strong {
    font-size: 13px;
}

.position-badge {
    display: inline-block;
    padding: 6px 9px;
    border-radius: 7px;
    background: #f1f6ff;
    color: #0d6efd;
    font-size: 12px;
    font-weight: 600;
}

.phone-text {
    color: #687585;
    font-size: 12px;
}

.no-data {
    color: #a0aab5;
    font-size: 12px;
    font-style: italic;
}


/* =========================
   ACTION
========================= */

.action-group {
    display: flex;
    align-items: center;
    gap: 6px;
}

.action-group form {
    padding: 0;
    margin: 0;
}

.btn-edit,
.btn-delete {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 7px 9px;
    border-radius: 8px;
    font-family: inherit;
    font-size: 12px;
    font-weight: 700;
    text-decoration: none;
    cursor: pointer;
    white-space: nowrap;
}

.btn-edit {
    border: none;
    background: #fff7df;
    color: #a87500;
}

.btn-edit:hover {
    background: #ffc107;
    color: #212529;
}

.btn-delete {
    border: none;
    background: #fff0f0;
    color: #dc3545;
}

.btn-delete:hover {
    background: #dc3545;
    color: white;
}


/* =========================
   EMPTY
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

    .current-photo {
        grid-column: auto;
        align-items: flex-start;
        flex-wrap: wrap;
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

    .action-group {
        flex-direction: column;
        align-items: stretch;
    }

    .btn-edit,
    .btn-delete {
        width: 100%;
    }

    .admin-table th,
    .admin-table td {
        padding: 12px;
    }

}

</style>


<?php include __DIR__ . '/../partials/admin_footer.php'; ?>