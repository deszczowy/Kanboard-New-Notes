<div class="table-list-header">
    <div class="table-list-header-count">
        <?php if ($paginator->getTotal() > 1): ?>
            <?= t('%d notes', $paginator->getTotal()) ?>
        <?php else: ?>
            <?= t('%d note', $paginator->getTotal()) ?>
        <?php endif ?>
    </div>
    <div class="table-list-header-menu">
        <?= $this->render('Notes:note_list/sort_menu', array('paginator' => $paginator)) ?>
    </div>
</div>