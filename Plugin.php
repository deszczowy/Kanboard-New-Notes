<?php

namespace Kanboard\Plugin\NewNotes;

use Kanboard\Core\Plugin\Base;
use Kanboard\Core\Translator;
use Kanboard\Plugin\NewNotes\Filter\NoteContentFilter;

class Plugin extends Base
{
    public function initialize()
    {
        $this->hook->on('template:layout:js', array('template' => 'plugins/NewNotes/Assets/js/NotesApp.js'));
        $this->template->hook->attach('template:dashboard:sidebar', 'NewNotes:dashboard/sidebar');
        $this->template->hook->attach('template:dashboard:page-header:menu', 'NewNotes:dashboard/menu');
        $this->template->hook->attach('template:user:sidebar:actions', 'NewNotes:user/sidebar');
        $this->route->addRoute('/dashboard/:userId/notes', 'UserNotesAndTodosController', 'show', 'NewNotes');
        $this->route->addRoute('/user/:userId/tags', 'NoteTagController', 'show', 'NewNotes');

        $this->helper->register('note', '\Kanboard\Plugin\NewNotes\Helper\NoteHelper');
    }

    public function onStartup()
    {
        Translator::load($this->languageModel->getCurrentLanguage(), __DIR__.'/Locale');
    }

    public function getPluginName()
    {
        return 'NewNotes';
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
            'Plugin\NewNotes\Model' => array(
                'NotesModel',
                'NoteTagModel',
            ),
            'Plugin\NewNotes\Formatter' => array(
                'NoteListFormatter'
            )
        );
    }
}

