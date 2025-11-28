<?php
require_once __DIR__ . '/../core/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $password = trim($_POST['old_password'] ?? '');
        $newPassword = trim($_POST['new_password'] ?? '');

        $userID = $_SESSION['user_id'] ?? 0;

        if (empty($userID)) {
            throw new Exception("User not logged in.");
        }

        if(empty($password) || empty($newPassword)) {
            throw new Exception('Passwords cant be empty.');
        }

        if($password !== $newPassword) {
            $pdo = connectToLocalDatabase();

            $stmt = $pdo->prepare("SELECT Password FROM user WHERE UserId = :userID");

            $stmt->execute([':userID' => $userID]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user || !password_verify($password, $user['Password'])) {
                throw new Exception('Old Password is incorrect.');
            } else {
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("UPDATE user SET Password = :password WHERE UserId = :userID");
                $stmt->execute([
                    ':password' => $hashedPassword,
                    ':userID' => $userID
                ]);
                header('Location: profil');
                exit;
            }
        } else {
            throw new Exception('New Password cant be the same as the old one');
        }
    } catch (Exception $e) {
        echo '<div class="error-message">' . htmlspecialchars($e->getMessage()) . '</div>';
    }
}