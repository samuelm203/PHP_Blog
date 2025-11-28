<?php
require_once __DIR__ . '/../core/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $password = trim($_POST['password'] ?? '');
        $newPassword = trim($_POST['new_password'] ?? '');

        $email = $_SESSION['email'] ?? '';

        if(empty($password) || empty($newPassword)) {
            throw new Exception('Passwords cant be empty.');
        }

        if($password !== $newPassword) {
            $pdo = connectToLocalDatabase();

            $stmt = $pdo->prepare("SELECT Password FROM user WHERE Email = :email");
            $stmt->execute([':Password' => $newPassword]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user || !password_verify($password, $user['Password'])) {
                throw new Exception('Old Password is incorrect.');
            } else {
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $pdo = connectToLocalDatabase();
                $stmt = $pdo->prepare("UPDATE user SET Password = :password WHERE Email = :email");
                $stmt->execute([
                    ':password' => $hashedPassword,
                    ':email' => $email
                ]);                header('Location: profil');
                exit;
            }
        } else {
            throw new Exception('New Password cant be the same as the old one');
        }
    } catch (Exception $e) {
        echo $e->getMessage();
        exit;
    }
}