<div class="page-header">
    <h2><?= $editingNote['note_title']?></h2>
</div>
<form method="post" action="<?= $this->url->href('UserNotesAndTodosController', 'save', array('plugin' => 'Notes')) ?>" autocomplete="off">
    <?= $this->form->csrf() ?>

    <div class="note-form-container">
        <div class="note-form-main-column">
            <?= $this->note->renderTitleField($values, $errors, $editingNote['note_title']) ?>
            <?= $this->note->renderDescriptionField($values, $errors, $editingNote['note_content']) ?>
            <?= $this->note->renderTagField($this->user->getId(), $tags) ?>
            <?= $this->note->renderHiddenIdField($editingNote['id']) ?>
        </div>

        <div class="note-form-bottom">

            <?= $this->modal->submitButtons() ?>
        </div>
    </div>
</form>