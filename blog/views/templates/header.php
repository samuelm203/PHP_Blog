<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
?>
<header>
    <nav>
        <div class="nav-left">
            <?php if (!empty($_SESSION['user_id'])): ?>
            <a href="blog" class="nav-link">Home</a>
            <a href="friends" class="nav-link">More Blogs</a>
            <a href="write" class="nav-link">Write</a>
            <a href="read" class="nav-link">Read</a>
            <?php else: ?>
            <a href="blog" class="nav-link">Home</a>
            <a href="friends" class="nav-link">More Blogs</a>
            <?php endif; ?>
        </div>
        <div class="nav-right">
            <?php if (!empty($_SESSION['user_id'])): ?>
                <a href="profil" class="nav-link">Profil</a>
                <a href="about" class="nav-link">About me</a>
            <?php else: ?>
                <a href="login" class="nav-link">Login</a>
                <a href="signup" class="nav-link">Sign up</a>
                <a href="about" class="nav-link">About me</a>
            <?php endif; ?>
        </div>
    </nav>
</header>