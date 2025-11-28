<?php
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    require_once 'core/database.php';
    $userID = $_SESSION['user_id'] ?? 0;

    if ($userID) {
    try {
        $pdo = connectToLocalDatabase();

        $stmt = $pdo->prepare("SELECT Name FROM user WHERE UserId = :id");
        $stmt->execute([':id' => $userID]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $userName = htmlspecialchars($user['Name']);
        }

    } catch (Exception $e) {
        echo '<div class="error-message">Error connecting to the database.</div>';
        }
    }


?>

<div class="container">
    <?php if (empty($_SESSION['user_id'])): ?>
        <h2 id="hero-second-titel">To write or read blogs, you need to register or log in</h2>
    <?php else: ?>
        <h2 id="hero-second-titel">Welcome back, <?= $userName ?></h2>
    <?php endif; ?>

    <section class="hero">
        <h1>Welcome</h1>
        <?php if (empty($_SESSION['user_id'])): ?>
            <div class="button-group">
                <a href="friends" class="btn">Other Blogs</a>
                <a href="login" class="btn">Login</a>
                <a href="signup" class="btn">Sign Up</a>
            </div>
        <?php else: ?>
            <div class="button-group">
                <a href="friends" class="btn">Other Blogs</a>
                <a href="write" class="btn">Write</a>
                <a href="read" class="btn">Read</a>
                <a href="logout" class="btn">Logout</a>
            </div>
        <?php endif; ?>
    </section>

    <footer>
        <?php require "views/templates/footer.php" ?>
    </footer>
</div>