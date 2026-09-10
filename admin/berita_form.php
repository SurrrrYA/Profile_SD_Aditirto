<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../helpers.php';
require_login();

$id = $_GET['id'] ?? null;
$judul = $isi = $gambar = $video = "";
$tanggal = date('Y-m-d');

// Ambil data kalau edit
if ($id) {
    $stmt = $pdo->prepare("SELECT * FROM berita WHERE id = ?");
    $stmt->execute([$id]);
    $data = $stmt->fetch();
    if ($data) {
        $judul = $data['judul'];
        $isi = $data['isi'];
        $gambar = $data['gambar'];
        $video = $data['video'];
        $tanggal = $data['tanggal'];
    }
}

// Proses simpan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = trim($_POST['judul']);
    $isi = trim($_POST['isi']);
    $tanggal = !empty($_POST['tanggal']) ? $_POST['tanggal'] : date('Y-m-d');

    // Hapus gambar
    if (!empty($_POST['hapus_gambar']) && $gambar) {
        $path_gambar = __DIR__ . '/../uploads/berita/' . $gambar;
        if (file_exists($path_gambar)) unlink($path_gambar);
        $gambar = "";
    }

    // Upload gambar baru
    if (!empty($_FILES['gambar']['name'])) {
        $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
        $nama_file = time() . "_" . uniqid() . "." . $ext;
        $tujuan = __DIR__ . '/../uploads/berita/' . $nama_file;
        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $tujuan)) {
            $gambar = $nama_file;
        }
    }

    // Hapus video
    if (!empty($_POST['hapus_video']) && $video) {
        if (!preg_match('/^https?:\/\//', $video)) {
            $path_video = __DIR__ . '/../uploads/berita/' . $video;
            if (file_exists($path_video)) unlink($path_video);
        }
        $video = "";
    }

    // Upload video baru
    if (!empty($_FILES['video']['name'])) {
        $ext = pathinfo($_FILES['video']['name'], PATHINFO_EXTENSION);
        $nama_file = time() . "_" . uniqid() . "." . $ext;
        $tujuan = __DIR__ . '/../uploads/berita/' . $nama_file;
        if (move_uploaded_file($_FILES['video']['tmp_name'], $tujuan)) {
            $video = $nama_file;
        }
    } elseif (!empty($_POST['video_link'])) {
        $video = trim($_POST['video_link']);
    }

    try {
        if ($id) {
            $stmt = $pdo->prepare("UPDATE berita SET judul=?, isi=?, gambar=?, video=?, tanggal=? WHERE id=?");
            $stmt->execute([$judul, $isi, $gambar, $video, $tanggal, $id]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO berita (judul, isi, gambar, video, tanggal) VALUES (?,?,?,?,?)");
            $stmt->execute([$judul, $isi, $gambar, $video, $tanggal]);
        }
        header("Location: berita_list.php");
        exit;
    } catch (PDOException $e) {
        echo "<p style='color:red'>Error DB: " . $e->getMessage() . "</p>";
    }
}

$title = $id ? "Edit Berita" : "Tambah Berita";
include __DIR__ . '/../partials/admin_header.php';
?>

<style>
.form-card {
  max-width: 700px;
  margin: 20px auto;
  padding: 25px;
  background: #fff;
  border-radius: 8px;
  box-shadow: 0px 4px 10px rgba(0,0,0,0.1);
}
.form-card h2 {
  margin-bottom: 20px;
  text-align: center;
  color: #333;
}
.form-card label {
  font-weight: bold;
  margin-top: 10px;
  display: block;
  color: #444;
}
.form-card input[type="text"],
.form-card input[type="date"],
.form-card input[type="url"],
.form-card textarea,
.form-card input[type="file"] {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 6px;
  margin-top: 5px;
}
.form-card button {
  background: #007BFF;
  border: none;
  padding: 12px 20px;
  color: white;
  border-radius: 6px;
  cursor: pointer;
  margin-top: 15px;
}
.form-card button:hover {
  background: #0056b3;
}
.preview {
  margin: 10px 0;
}
</style>

<div class="form-card">
  <h2><?= e($title) ?></h2>

  <form method="post" enctype="multipart/form-data">
    <label>Judul</label>
    <input type="text" name="judul" value="<?= e($judul) ?>" required>

    <label>Isi</label>
    <textarea name="isi" rows="5" required><?= e($isi) ?></textarea>

    <label>Tanggal</label>
    <input type="date" name="tanggal" value="<?= e($tanggal) ?>">

    <label>Gambar</label>
    <?php if ($gambar): ?>
      <div class="preview">
        <img src="../uploads/berita/<?= e($gambar) ?>" width="150" style="border:1px solid #ccc;border-radius:5px">
      </div>
      <label><input type="checkbox" name="hapus_gambar" value="1"> Hapus gambar</label>
    <?php endif; ?>
    <input type="file" name="gambar" accept="image/*">

    <label>Video Upload</label>
    <?php if ($video && !preg_match('/^https?:\/\//', $video)): ?>
      <div class="preview">
        <video width="250" controls style="border-radius:5px">
          <source src="../uploads/berita/<?= e($video) ?>" type="video/mp4">
        </video>
      </div>
      <label><input type="checkbox" name="hapus_video" value="1"> Hapus video</label>
    <?php endif; ?>
    <input type="file" name="video" accept="video/*">

    <label>Video Link (YouTube/URL)</label>
    <input type="url" name="video_link" value="<?= e(preg_match('/^https?:\/\//', $video) ? $video : '') ?>">

    <button type="submit">💾 Simpan</button>
  </form>
</div>

<?php include __DIR__ . '/../partials/admin_footer.php'; ?>
