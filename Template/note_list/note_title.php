<div class="table-list-title">
    <span class="notes-table-title">
            <?= $this->url->link($this->text->e($note['note_title']), 'UserNotesAndTodosController', 'show', array('note_id' => $note['id'])) ?>
            <?= $this->modal->large('edit', '', 'UserNotesAndTodosController', 'showEditModal', array('plugin' => 'Notes', 'noteId' => $note['id'])) ?>
            <?= $this->modal->large('trash', '', 'UserNotesAndTodosController', 'showDeleteModal', array('plugin' => 'Notes', 'noteId' => $note['id'])) ?>
    </span>
</div>