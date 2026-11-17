<div class="page-header">
    <h2><?= $this->url->link(t('Notebook'), 'UserNotesAndTodosController', 'show', array('plugin' => 'Notebook')) ?>
        (<?= $paginator->getTotal() == 0 ? 0 : $paginator->getTotal() ?>)</h2>
</div>
<div class="filter-box margin-bottom" style="max-width: unset">
    <form method="get" action="<?= $this->url->dir() ?>" id="notes-search-form" class="search">
        <?= $this->form->hidden('controller', array('controller' => 'UserNotesAndTodosController')) ?>
        <?= $this->form->hidden('plugin', array('plugin' => 'Notebook')) ?>
        <?= $this->form->hidden('action', array('action' => 'filterNotes')) ?>
        <?= $this->form->hidden('pagination', array('pagination' => 'notes')) ?>
        <?= $this->form->hidden('searchTags', array('searchTags' => !(isset($values)) ? '' : $values['searchTags'])) ?>

        <div class="input-addon">
            <?= $this->form->text('search', array('search' => !(isset($values)) ? '' : $values['search']), array(), array('placeholder="' . t('Search') . '"', 'aria-label="' . t('Search') . '"'), 'input-addon-field') ?>
            <div class="input-addon-item">
                <?= $this->render('Notebook:dashboard/filters_helper', array('tags' => $tags, 'outerForm' => $this->form, 'hasUntagged' => $hasUntagged)) ?>
            </div>
        </div>
    </form>
</div>
<?php if ($paginator->isEmpty()): ?>
    <p class="alert"><?= t('No notes found.') ?></p>
<?php elseif (!$paginator->isEmpty()): ?>
    <div class="table-list">
        <?= $this->render('Notebook:note_list/header', array(
            'paginator' => $paginator,
        )) ?>

        <?php foreach ($paginator->getCollection() as $note): ?>
            <div class="table-list-row notes-container">
                <?= $this->render('Notebook:note_list/note_title', array(
                    'note' => $note,
                )) ?>

                <?= $this->render('Notebook:note_list/note_content', array(
                    'note' => $note,
                )) ?>
            </div>
        <?php endforeach ?>
    </div>

    <?= $paginator ?>
<?php endif ?>
