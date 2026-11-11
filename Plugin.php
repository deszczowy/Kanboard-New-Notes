<?php

namespace Kanboard\Plugin\Notes;

use Kanboard\Core\Plugin\Base;
use Kanboard\Core\Translator;
use Kanboard\Plugin\Notes\Filter\NoteContentFilter;

class Plugin extends Base
{
    public function initialize()
    {
        $this->hook->on('template:layout:js', array('template' => 'plugins/Notes/Assets/js/NotesApp.js'));
        $this->template->hook->attach('template:dashboard:sidebar', 'notes:dashboard/sidebar');
        $this->template->hook->attach('template:dashboard:page-header:menu', 'notes:dashboard/menu');
        $this->template->hook->attach('template:user:sidebar:actions', 'notes:user/sidebar');
        $this->route->addRoute('/dashboard/:userId/notes', 'UserNotesAndTodosController', 'show', 'Notes');
        $this->route->addRoute('/user/:userId/tags', 'NoteTagController', 'show', 'Notes');

        $this->helper->register('note', '\Kanboard\Plugin\Notes\Helper\NoteHelper');
    }

    public function onStartup()
    {
        Translator::load($this->languageModel->getCurrentLanguage(), __DIR__.'/Locale');
    }

    public function getPluginName()
    {
        return 'Notes';
    }

    public function getPluginDescription()
    {
        return t('Write notes in Kanboard.');
    }

    public function getPluginAuthor()
    {
        return 'Jonathan Ling';
    }

    public function getPluginVersion()
    {
        return '1.0.0';
    }

    public function getPluginHomepage()
    {
        return 'https://gitlab.com/colonelpopcorn/kanboard-notes-plugin';
    }

    public function getClasses()
    {
        return array(
            'Plugin\Notes\Model' => array(
                'NotesModel',
                'NoteTagModel',
            ),
            'Plugin\Notes\Formatter' => array(
                'NoteListFormatter'
            )
        );
    }
}

