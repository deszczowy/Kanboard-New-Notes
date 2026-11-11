<div class="dropdown">
    <a href="#" class="dropdown-menu dropdown-menu-link-icon" title="<?= t('Default filters') ?>"
       aria-label="<?= t('Default filters') ?>"><i class="fa fa-filter fa-fw"></i><i class="fa fa-caret-down"></i></a>
    <ul>
        <?php if (count($tags) != 0): ?>
            <?php foreach ($tags as $tag): ?>
                <li class="table-list-category <?= $tag['color_id'] ? "color-{$tag['color_id']}" : "" ?>">
                    <a href="#" class="notes-filter-helper">
                        <input type="checkbox"
                               name="<?= $tag['name'] ?>" <?= isset($tag['isChecked']) ? 'checked' : '' ?>
                               id="<?= $tag['id'] ?>" form="non-existent-form">

                        <label style="display: inline" for="<?= $tag['id'] ?>"><?= $tag['name'] ?></label>
                    </a>
                </li>
            <?php endforeach; ?>
        <?php endif ?>
        <li>
            <a href="#" class="notes-filter-helper">
                <input type="checkbox" name="$untagged"
                       id="untagged" <?= $hasUntagged ? 'checked' : '' ?>>
                <label style="display: inline" for="untagged"><?= t('Untagged') ?></label>
            </a>
        </li>
        <li>
            <a href="<?= '/dashboard/' . $this->user->getId() . '/notes' ?>"><span><?= t('Remove filters') ?></span></a>
        </li>
    </ul>
</div>