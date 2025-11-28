<ul class="post_list">
<?php foreach ($posts as $post): ?>
    <li>
        <div class="post-left">
            <a href="view.php?id=<?= $post['id'] ?>" class="post-title">
                <?= htmlspecialchars($post['title']) ?>
            </a>
            <?php if ($post['file_path']): ?>
                <img src="/img/download.png" alt="첨부파일" class="isFile">
            <?php endif; ?>
        </div>
        <div class="post-info">
            <small><?= $post['author'] ?></small>
            <small>(<?= $post['created_at'] ?>)</small>
        </div>
    </li>
<?php endforeach; ?>
</ul>
