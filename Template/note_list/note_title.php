<div class="table-list-title">
    <span class="notes-table-title">
        <?= $this->modal->large('', $this->text->e($note['note_title']), 'UserNotesAndTodosController', 'showNote', array('plugin' => 'NewNotes', 'noteId' => $note['id'])) ?>
        <?= $this->modal->large('edit', '', 'UserNotesAndTodosController', 'showEditModal', array('plugin' => 'NewNotes', 'noteId' => $note['id'])) ?>
        <?= $this->modal->large('trash', '', 'UserNotesAndTodosController', 'showDeleteModal', array('plugin' => 'NewNotes', 'noteId' => $note['id'])) ?>
    </span>
</div>
