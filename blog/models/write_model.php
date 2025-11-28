<?php

require_once __DIR__ . '/../core/database.php';

$userID = $_SESSION['user_id'] ?? 0;

if (empty($userID)) {
    header('Location: login');
}

$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {

        $title = htmlspecialchars(trim($_POST['title'] ?? ''));
        $content = htmlspecialchars(trim($_POST['content'] ?? ''));

        $image = filter_var(trim($_POST['image'] ?? ''), FILTER_SANITIZE_URL);

        if (empty($image)) {
            $image = null;
        } else if (!(@getimagesize($_POST["image"]))) {
            $image = null;
        }

        $userID = $_SESSION['user_id'] ?? 0;

        if (empty($userID)) {
            throw new Exception("No User logged in");
        }

        if (empty($title) || empty($content)) {
            throw new Exception('Titel and Content cant be empty');
        }

        $pdo = connectToLocalDatabase();

        $stmt = $pdo->prepare("
            INSERT INTO post (Titel, Content, Image, UserID, Timestamp) 
            VALUES (:title, :content, :image, :userID, NOW())
        ");

        $stmt->execute([
            ':title' => $title,
            ':content' => $content,
            ':image' => $image,
            ':userID' => $userID
        ]);

        header('Location: read');
        exit;

    } catch (Exception $e) {
        echo '<div class="error-message">' . htmlspecialchars($e->getMessage()) . '</div>';
    }
}

