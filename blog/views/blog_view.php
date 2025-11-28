<?php
require 'views/templates/header.php';
require __DIR__ . '/../models/blog_model.php';

if (!isset($posts) || !is_array($posts)) {
    $posts = [];
}

?>

<div class="read">
    <div class="read-titel-banner">Read all the Blog Entrys</div>

    <?php foreach ($posts as $post) : ?>
        <div class="post-card">
            <h2 class="post-card-title"><?= htmlspecialchars($post["Titel"]) ?></h2>

            <div class="img-p-container">
                <p class="post-card-text"><?= htmlspecialchars($post["Content"]) ?></p>
                <?php
                if (empty($post["Image"])) {
                    echo "";
                } else if (!(@getimagesize($post["Image"]))) {
                    echo "";
                } else {
                    echo '<img src="' . htmlspecialchars($post["Image"]) . '" class="post-card-img" alt="User input Image">';
                }
                ?>
            </div>

            <p>Written by
                <span class="post-card-creator"><?= htmlspecialchars($post["Autor"]) ?></span>
                on
                <span class="post-card-date"><?= htmlspecialchars($post["Timestamp"]) ?></span>
            </p>

<!--            <div class="comments-section">-->
<!--                <h3>Write a Comment</h3>-->
<!--                <ul class="comments-list"></ul>-->
<!--                <form class="comment-form">-->
<!--                    <div>-->
<!--                        <label class="visually-hidden">Comment</label>-->
<!--                        <input type="text" name="comment" placeholder="" required>-->
<!--                    </div>-->
<!--                    <div>-->
<!--                        <button type="submit" class="btn primary">Add comment</button>-->
<!--                    </div>-->
<!--                </form>-->
<!--            </div>-->
        </div>
    <?php endforeach; ?>

</div>

<footer>
    <?php require "views/templates/footer.php" ?>
</footer>


