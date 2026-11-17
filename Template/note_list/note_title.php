<div class="table-list-title">
    <span class="notes-table-title">

        <a href="<?= $this->url->to('UserNotesAndTodosController', 'showNote', array('plugin' => 'Notebook', 'noteId' => $note['id'])) ?>"><?= $this->text->e($note['note_title']) ?></a>
        <?= $this->modal->large('edit', '', 'UserNotesAndTodosController', 'showEditModal', array('plugin' => 'Notebook', 'noteId' => $note['id'])) ?>
        <?= $this->modal->large('trash', '', 'UserNotesAndTodosController', 'showDeleteModal', array('plugin' => 'Notebook', 'noteId' => $note['id'])) ?>

    </span>
</div>
