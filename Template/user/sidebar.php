<li <?= $this->app->checkMenuSelection('UserNotesAndTodosController', 'showTags') ?> >
    <a href="<?= $this->url->to('NoteTagController', 'show', array('plugin' => 'NewNotes')) ?>"><?= t('Tags Management') ?></a>
</li>
