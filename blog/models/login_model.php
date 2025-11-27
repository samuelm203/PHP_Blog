<?php
    require_once __DIR__ . '/../core/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $email = htmlspecialchars(trim($_POST['email'] ?? ''));
        $password = trim($_POST['password'] ?? '');

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Invalid email format.');
        }

        if (empty($email) || empty($password)) {
            throw new Exception("Email and Password can't be empty.");
        }

        $pdo = connectToLocalDatabase();

        $stmt = $pdo->prepare("SELECT UserId, Password FROM user WHERE Email = :email");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user || !password_verify($password, $user['Password'])) {
            throw new Exception('Invalid email or password.');
        }

        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        $_SESSION['user_id'] = $user['UserId'];

        header('Location: write ');
        exit();
    } catch (Exception $e) {
        echo '<div class="error-message">' . htmlspecialchars($e->getMessage()) . '</div>';
    }
}