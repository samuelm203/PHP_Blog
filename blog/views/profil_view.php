<?php
require 'views/templates/header.php';

require_once 'core/database.php';
$userID = $_SESSION['user_id'] ?? 0;

if (empty($userID)) {
    header('Location: login');
    exit;
}

$userName = '';
$userEmail = '';
$userPasswordDisplay = '*****';

try {
    $pdo = connectToLocalDatabase();

    $stmt = $pdo->prepare("SELECT Name, Email FROM user WHERE UserId = :id");
    $stmt->execute([':id' => $userID]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $userName = htmlspecialchars($user['Name']);
        $userEmail = htmlspecialchars($user['Email']);
    } else {
        header('Location: logout');
        exit;
    }

} catch (Exception $e) {
    echo '<div class="error-message">Error connecting to the database.</div>';
}

?>

<div class="profil">
    <div class="profil-titel-banner">Your Profil</div>

    <div class="profil-card-informations" >
        <p class="profil-card-informations-p">Your Username: <?= $userName ?></p>
        <p class="profil-card-informations-p">Your Email: <?= $userEmail ?></p>
        <p class="profil-card-informations-p">Your Password: <?= $userPasswordDisplay ?></p>
    </div>

    <div class="profil-card-options">
        <a href="logout" class="nav-link">Log out</a>

        <a href="" class="nav-link">Change Password</a>

        <a href="" class="nav-link">Change Email</a>

        <a href="" class="nav-link">Change Username</a>

        <a href="" class="nav-link">Delete your Account</a>
    </div>
</div>

<footer>
    <?php require "views/templates/footer.php" ?>
</footer>