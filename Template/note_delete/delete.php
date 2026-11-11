<div class="page-header">
    <h2><?= t('Remove a note') ?></h2>
</div>

<div class="confirm">
    <p class="alert alert-info">
        <?= t('Do you really want to remove this note: "%s"?', $this->text->e($deletingNote['note_title'])) ?>
    </p>

    <?= $this->modal->confirmButtons(
        'UserNotesAndTodosController',
        'delete',
        array('noteId' => $deletingNote['id'], 'redirect' => $redirect, 'plugin' => 'Notes')
    ) ?>
</div>