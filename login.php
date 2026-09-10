<?php
require_once __DIR__.'/config.php';
require_once __DIR__.'/helpers.php';
$title = 'Login - MI Maarif Aditirto';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    check_csrf();
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username && $password) {
        $stmt = $pdo->prepare("SELECT id, password_hash FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $u = $stmt->fetch();

        if ($u && password_verify($password, $u['password_hash'])) {
            $_SESSION['user_id'] = $u['id'];
            $_SESSION['username'] = $username;

            header('Location: ' . dirname($_SERVER['SCRIPT_NAME']) . '/admin/dashboard_admin.php');
            exit;
        } else {
            $error = 'Username atau password salah.';
        }
    } else {
        $error = 'Mohon isi username dan password.';
    }
}

include __DIR__.'/partials/header.php';
?>

<style>
html, body {
    margin: 0;
    padding: 0;
    height: 100%;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #f0f4f8;
}

.login-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: calc(100vh - 60px); /* jika header tinggi 60px */
    width: 100%;
}

.card {
    background: #fff;
    padding: 2.5rem 3rem;
    border-radius: 15px;
    box-shadow: 0 12px 25px rgba(0,0,0,0.15);
    max-width: 400px;
    width: 100%;
}

h2 {
    text-align: center;
    margin-bottom: 2rem;
    color: #1e40af;
    font-size: 1.75rem;
}

.row {
    display: flex;
    flex-direction: column;
    margin-bottom: 1.25rem;
}

label {
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: #334155;
}

input {
    padding: 0.65rem 1rem;
    border-radius: 10px;
    border: 1px solid #cbd5e1;
    font-size: 1rem;
    transition: 0.3s;
    width: 100%;
}

input:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 8px rgba(59,130,246,0.4);
}

button {
    width: 100%;
    padding: 0.75rem;
    background-color: #3b82f6;
    color: #fff;
    font-size: 1rem;
    font-weight: 600;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    transition: 0.3s;
}

button:hover {
    background-color: #2563eb;
}

.error {
    background-color: #fee2e2;
    color: #b91c1c;
    padding: 0.75rem 1rem;
    border-radius: 8px;
    margin-bottom: 1rem;
    text-align: center;
    font-weight: 500;
}

/* Responsive untuk layar kecil */
@media (max-width: 500px) {
    .card {
        padding: 2rem;
        margin: 0 1rem;
    }
}
</style>

<div class="login-container">
    <div class="card">
        <h2>Login Admin</h2>
        <?php if ($error): ?>
            <div class="error"><?= e($error) ?></div>
        <?php endif; ?>
        <form method="post">
            <?php csrf_field(); ?>
            <div class="row">
                <label>Username</label>
                <input name="username" placeholder="Masukkan username" required>
            </div>
            <div class="row">
                <label>Password</label>
                <input name="password" type="password" placeholder="Masukkan password" required>
            </div>
            <button type="submit">Masuk</button>
        </form>
    </div>
</div>

<?php include __DIR__.'/partials/footer.php'; ?>
