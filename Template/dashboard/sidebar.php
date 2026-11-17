<li <?= $this->app->checkMenuSelection('UserNotesAndTodosController', '', 'Notebook') ?> >
    <a href="<?= $this->url->to('UserNotesAndTodosController', 'show', array('plugin' => 'Notebook')) ?>"><?= t('Notebook') ?></a>
</li>
