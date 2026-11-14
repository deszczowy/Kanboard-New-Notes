<li <?= $this->app->checkMenuSelection('UserNotesAndTodosController', '', 'NewNotes') ?> >
    <a href="<?= '/dashboard/' . $this->user->getId() . '/notes' ?>"><?= t('My Notes') ?></a>
</li>
