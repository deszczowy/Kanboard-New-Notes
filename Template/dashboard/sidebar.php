<li <?= $this->app->checkMenuSelection('UserNotesAndTodosController', '', 'Notes') ?> >
    <a href="<?= '/dashboard/' . $this->user->getId() . '/notes' ?>"><?= t('My Notes') ?></a>
</li>