<?php
require_once __DIR__.'/config.php';
require_once __DIR__.'/helpers.php';
$title = 'About - MI Aditirto';

// Ambil struktur guru
$teachers = $pdo->query("SELECT * FROM teachers ORDER BY position, name")->fetchAll();
// Ambil prestasi terbaru
$ach = $pdo->query("SELECT * FROM achievements ORDER BY achieved_at DESC, id DESC LIMIT 10")->fetchAll();

include __DIR__.'/partials/header.php';
?>
<style>
  .about-section { padding: 20px 0; }
  .section-title { text-align: center; margin-bottom: 25px; }

  /* Grid Guru */
  .teacher-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
  }
  .teacher-card {
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    text-align: center;
    padding: 15px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    transition: transform 0.2s;
  }
  .teacher-card:hover { transform: translateY(-5px); }
  .teacher-photo {
    width: 90px; height: 90px; object-fit: cover;
    border-radius: 50%; margin-bottom: 10px;
    border: 2px solid #007bff;
  }
  .teacher-name { font-weight: bold; margin-bottom: 5px; }
  .teacher-position { font-size: 0.9em; color: #555; margin-bottom: 5px; }
  .teacher-phone { font-size: 0.85em; color: #007bff; }

  /* Prestasi List */
  .achievement-list {
    list-style: none; margin: 0; padding: 0; border-left: 2px solid #ddd;
  }
  .achievement-list li {
    margin: 0 0 15px 20px; padding: 0 0 5px 10px; position: relative;
  }
  .achievement-list li::before {
    content: ""; position: absolute; left: -22px; top: 5px;
    width: 10px; height: 10px; background: #007bff; border-radius: 50%;
  }
</style>

<div class="about-section">
  <h2 class="section-title">Tentang Kami</h2>

  <!-- Struktur Guru -->
  <div class="card">
    <h3 style="margin-bottom:15px;">Struktur Guru</h3>
    <div class="teacher-grid">
      <?php foreach($teachers as $t): ?>
        <div class="teacher-card">
          <?php if($t['photo']): ?>
            <img src="uploads/teachers/<?= e($t['photo']) ?>" class="teacher-photo">
          <?php else: ?>
            <img src="https://via.placeholder.com/90x90?text=Guru" class="teacher-photo">
          <?php endif; ?>
          <div class="teacher-name"><?= e($t['name']); ?></div>
          <div class="teacher-position"><?= e($t['position']); ?></div>
          <div class="teacher-phone"><?= e($t['phone']); ?></div>
        </div>
      <?php endforeach; ?>
      <?php if(empty($teachers)): ?>
        <p>Belum ada data guru.</p>
      <?php endif; ?>
    </div>
  </div>

  <!-- Prestasi -->
  <div class="card">
    <h3 style="margin-bottom:15px;">Prestasi</h3>
    <ul class="achievement-list">
      <?php foreach($ach as $a): ?>
        <li>
          <strong><?= e($a['title']); ?></strong>
          <?php if(!empty($a['achieved_at'])): ?> (<?= e($a['achieved_at']); ?>)<?php endif; ?>
          <br><?= nl2br(e($a['description'])); ?>
        </li>
      <?php endforeach; ?>
      <?php if(empty($ach)): ?>
        <li>Belum ada data.</li>
      <?php endif; ?>
    </ul>
  </div>
</div>

<?php include __DIR__.'/partials/footer.php'; ?>
