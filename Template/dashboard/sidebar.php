<li <?= $this->app->checkMenuSelection('UserNotesAndTodosController', '', 'NewNotes') ?> >
    <a href="<?= $this->url->to('UserNotesAndTodosController', 'show', array('plugin' => 'NewNotes')) ?>"><?= t('Notebook') ?></a>
</li>
