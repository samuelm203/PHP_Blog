<?php
// Ensure session is started for auth-dependent navigation
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
?>
<header>
    <nav>
        <div class="nav-left">
            <a href="friends" class="nav-link">BLJ</a>
            <a href="write" class="nav-link">Write</a>
            <a href="read" class="nav-link">Blog</a>
            <a href="about" class="nav-link">About me</a>
        </div>
        <div class="nav-right">
            <?php if (!empty($_SESSION['user_id'])): ?>
                <a href="logout" class="nav-link">Log out</a>
            <?php else: ?>
                <a href="login" class="nav-link">Login</a>
                <a href="signup" class="nav-link">Sign up</a>
            <?php endif; ?>
        </div>
    </nav>
</header>