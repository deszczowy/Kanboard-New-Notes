<li <?= $this->app->checkMenuSelection('UserNotesAndTodosController', 'showTags') ?> >
    <a href="<?= '/user/' . $this->user->getId() . '/tags' ?>"><?=t('Tags Management')?></a>
</li>