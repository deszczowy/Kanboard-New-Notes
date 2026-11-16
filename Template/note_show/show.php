<div class="page-header">
    <h2><?= $editingNote['note_title']?></h2>
</div>

<div class="note-form-container">
    <div class="note-form-main-column">
        <?= $this->text->e($editingNote['note_content']) ?>
    </div>
</div>
