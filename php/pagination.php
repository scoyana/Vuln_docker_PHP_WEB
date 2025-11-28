<?php if ($total_pages > 1): ?>
<div class="pagination">
    <?php if ($current_page > 1): ?>
        <a href="<?= $base_url ?>&pageNum=<?= $current_page - 1 ?>" class="page-btn">이전</a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <a href="<?= $base_url ?>&pageNum=<?= $i ?>" class="page-btn <?= ($i == $current_page) ? 'current' : '' ?>"><?= $i ?></a>
    <?php endfor; ?>

    <?php if ($current_page < $total_pages): ?>
        <a href="<?= $base_url ?>&pageNum=<?= $current_page + 1 ?>" class="page-btn">다음</a>
    <?php endif; ?>
</div>
<?php endif; ?>
