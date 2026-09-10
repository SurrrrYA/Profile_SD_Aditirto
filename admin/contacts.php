<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../helpers.php';
require_login();

$title = 'Pesan Kontak';

// ---- Aksi admin ----
if (isset($_GET['action'], $_GET['id'])) {
    $id = (int) $_GET['id'];
    if ($_GET['action'] === 'delete') {
        $stmt = $pdo->prepare("DELETE FROM contacts WHERE id = ?");
        $stmt->execute([$id]);
    } elseif ($_GET['action'] === 'toggle') {
        $stmt = $pdo->prepare("UPDATE contacts SET is_read = 1 - is_read WHERE id = ?");
        $stmt->execute([$id]);
    }
    header("Location: contacts.php");
    exit;
}

// ---- Ambil data ----
$stmt = $pdo->query("SELECT * FROM contacts ORDER BY id DESC");
$contacts = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title><?= e($title) ?></title>
  <style>
    body {font-family: Arial, sans-serif; background: #f8f9fa; margin: 0;}
    header {background: #0d6efd; padding: 15px; color: white; text-align: center; font-size: 20px;}
    .container {max-width: 1000px; margin: 20px auto; background: white; padding: 20px 30px; border-radius: 8px; box-shadow: 0 3px 8px rgba(0,0,0,0.1);}
    h2 {margin-top: 0; color: #0d6efd; border-bottom: 2px solid #0d6efd; padding-bottom: 5px;}
    table {width: 100%; border-collapse: collapse; margin-top: 15px;}
    th, td {padding: 10px; border: 1px solid #dee2e6; text-align: left; vertical-align: top;}
    th {background: #e9ecef;}
    .back-btn {display: inline-block; margin-bottom: 15px; text-decoration: none; background: #6c757d; color: white; padding: 8px 12px; border-radius: 5px; font-size: 13px;}
    .back-btn:hover {background: #5a6268;}
    .btn {padding: 5px 8px; font-size: 12px; border-radius: 4px; text-decoration: none; margin-right: 5px;}
    .btn-read {background: #198754; color: white;}
    .btn-unread {background: #ffc107; color: black;}
    .btn-delete {background: #dc3545; color: white;}
    .btn:hover {opacity: 0.9;}
  </style>
</head>
<body>

<header><?= e($title) ?></header>
<div class="container">
  <a href="dashboard_admin.php" class="back-btn">⬅ Kembali ke Dashboard</a>
  <h2>Daftar Pesan Kontak</h2>

  <?php if (count($contacts) === 0): ?>
    <p>Belum ada pesan masuk.</p>
  <?php else: ?>
    <table>
      <tr>
        <th>Nama</th>
        <th>Email</th>
        <th>Pesan</th>
        <th>Tanggal</th>
        <th>Status</th>
        <th>Aksi</th>
      </tr>
      <?php foreach ($contacts as $c): ?>
      <tr>
        <td><?= e($c['name']) ?></td>
        <td><?= e($c['email']) ?></td>
        <td><?= nl2br(e($c['message'])) ?></td>
        <td><?= e($c['created_at'] ?? '') ?></td>
        <td>
          <?= $c['is_read'] ? '<span style="color:green;">Sudah Dibaca</span>' : '<span style="color:red;">Belum Dibaca</span>' ?>
        </td>
        <td>
          <a class="btn <?= $c['is_read'] ? 'btn-unread' : 'btn-read' ?>" href="?action=toggle&id=<?= $c['id'] ?>">
            <?= $c['is_read'] ? 'Tandai Belum Dibaca' : 'Tandai Dibaca' ?>
          </a>
          <a class="btn btn-delete" href="?action=delete&id=<?= $c['id'] ?>" onclick="return confirm('Hapus pesan ini?')">Hapus</a>
        </td>
      </tr>
      <?php endforeach; ?>
    </table>
  <?php endif; ?>
</div>

</body>
</html>
