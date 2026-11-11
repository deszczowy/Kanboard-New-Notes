<div class="page-header">
    <h2><?= $title ?></h2>
</div>
<form method="post" action="<?= $this->url->href('UserNotesAndTodosController', 'create', array('plugin' => 'Notes')) ?>" autocomplete="off">
    <?= $this->form->csrf() ?>

    <div class="note-form-container">
        <div class="note-form-main-column">
            <?= $this->note->renderTitleField($values, $errors) ?>
            <?= $this->note->renderDescriptionField($values, $errors) ?>
            <?= $this->note->renderTagField($this->user->getId()) ?>
        </div>

        <div class="note-form-bottom">
            <?= $this->modal->submitButtons() ?>
        </div>
    </div>
</form>