<div class="dropdown">
    <a href="#" class="dropdown-menu dropdown-menu-link-icon"><strong><?= t('Sort') ?> <i class="fa fa-caret-down"></i></strong></a>
    <ul>
        <li>
            <?= $paginator->order(t('Created On Date'), 'created_on') ?>
        </li>
        <li>
            <?= $paginator->order(t('Last Modified Date'), 'modified_on') ?>
        </li>
        <li>
            <?= $paginator->order(t('Note Title'), 'note_title') ?>
        </li>
    </ul>
</div>