<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
?>
<header>
    <nav>
        <div class="nav-left">
            <?php if (!empty($_SESSION['user_id'])): ?>
            <a href="friends" class="nav-link">More Blogs</a>
            <a href="write" class="nav-link">Write</a>
            <a href="read" class="nav-link">Blog</a>
            <a href="about" class="nav-link">About me</a>
            <?php else: ?>
            <a href="friends" class="nav-link">More Blogs</a>
            <a href="about" class="nav-link">About me</a>
            <?php endif; ?>
        </div>
        <div class="nav-right">
            <?php if (!empty($_SESSION['user_id'])): ?>
                <a href="logout" class="nav-link">Log out</a>
                <a href="blog" class="nav-link">Home</a>
            <?php else: ?>
                <a href="login" class="nav-link">Login</a>
                <a href="signup" class="nav-link">Sign up</a>
            <?php endif; ?>
        </div>
    </nav>
</header>