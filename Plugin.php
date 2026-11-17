<?php

namespace Kanboard\Plugin\Notebook;

use Kanboard\Core\Plugin\Base;
use Kanboard\Core\Translator;
use Kanboard\Plugin\Notebook\Filter\NoteContentFilter;

class Plugin extends Base
{
    public function initialize()
    {
        $this->hook->on('template:layout:js', array('template' => 'plugins/Notebook/Assets/js/NotesApp.js'));
        $this->hook->on('template:layout:css', array('template' => 'plugins/Notebook/Assets/css/notes.css'));
        $this->template->hook->attach('template:dashboard:sidebar', 'Notebook:dashboard/sidebar');
        $this->template->hook->attach('template:dashboard:page-header:menu', 'Notebook:dashboard/menu');
        $this->template->hook->attach('template:user:sidebar:actions', 'Notebook:user/sidebar');
        $this->route->addRoute('/dashboard/:userId/notes', 'UserNotesAndTodosController', 'show', 'Notebook');
        $this->route->addRoute('/user/:userId/tags', 'NoteTagController', 'show', 'Notebook');

        $this->helper->register('note', '\Kanboard\Plugin\Notebook\Helper\NoteHelper');
    }

    public function onStartup()
    {
        Translator::load($this->languageModel->getCurrentLanguage(), __DIR__.'/Locale');
    }

    public function getPluginName()
    {
        return 'Notebook';
    }

    public function getPluginDescription()
    {
        return t('Notebook for your Kanboard.');
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
        return 'https://github.com/deszczowy/kanboard-notebook';
    }

    public function getClasses()
    {
        return array(
            'Plugin\Notebook\Model' => array(
                'NotesModel',
                'NoteTagModel',
            ),
            'Plugin\Notebook\Formatter' => array(
                'NoteListFormatter'
            )
        );
    }
}

