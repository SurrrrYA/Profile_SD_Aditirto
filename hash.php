<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'] ?? '';
    if ($password !== '') {
        $hash = password_hash($password, PASSWORD_DEFAULT);
    }
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Generate Password Hash</title>
  <style>
    body { font-family: Arial, sans-serif; background: #f7f7fb; color: #222; padding: 20px; }
    form { background: #fff; padding: 20px; border-radius: 8px; max-width: 400px; margin: auto; }
    label { display: block; font-weight: bold; margin-bottom: 5px; }
    input, button { padding: 10px; width: 100%; margin-bottom: 10px; }
    button { background: #1957a4; color: #fff; border: none; cursor: pointer; }
    button:hover { background: #12417d; }
    .result { background: #e2f7e2; border: 1px solid #b4e0b4; padding: 10px; border-radius: 5px; word-break: break-all; }
  </style>
</head>
<body>

<h2>Generate Bcrypt Password Hash</h2>
<form method="post">
  <label for="password">Masukkan Password:</label>
  <input type="text" name="password" id="password" required>
  <button type="submit">Generate</button>
</form>

<?php if (!empty($hash)): ?>
<div class="result">
  <strong>Hash:</strong><br>
  <?= htmlspecialchars($hash, ENT_QUOTES, 'UTF-8'); ?>
</div>
<?php endif; ?>

</body>
</html>
