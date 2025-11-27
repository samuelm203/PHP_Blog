<?php
    require_once __DIR__ . '/../core/database.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {

            $name = htmlspecialchars(trim($_POST['name'] ?? ''));

            $email = htmlspecialchars(trim($_POST['email'] ?? ''));
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new Exception('Invalid email format.');
            }

            if (empty($name) || empty($email)) {
                throw new Exception("Name and Email can't be empty.");
            }

            $password = trim($_POST['password'] ?? '');
            $passwordConfirm = trim($_POST['confirm_password'] ?? '');

            if (empty($password) || empty($passwordConfirm)) {
                throw new Exception('Passwords can\'t be empty.');
            }

            if (!($password === $passwordConfirm)) {
                throw new Exception('Passwords do not match.');
            } else {
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            }

            $pdo = connectToLocalDatabase();

            $stmt = $pdo->prepare("INSERT INTO user (Name, Email, Password) VALUES (:name, :email, :password)");
            $stmt->execute([':name' => $name, ':email' => $email, ':password' => $password]);

        } catch (\Exception $e) {
            echo '<div class="error-message">' . htmlspecialchars($e->getMessage()) . '</div>';
        }
    }