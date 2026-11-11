<?php

namespace Kanboard\Plugin\Notes\Controller;

use Kanboard\Controller\BaseController;
use Kanboard\Core\Controller\AccessForbiddenException;

class NoteTagController extends BaseController

{
    public function show()
    {
        $user = $this->getUser();
        $this->response->html($this->helper->layout->user('Notes:tag/index', array(
            'user' => $user,
            'tags' => $this->noteTagModel->getUserTags($user['id']),
            'colors' => $this->colorModel->getList(),
        )));
    }

    public function create(array $values = array(), array $errors = array())
    {
        $this->response->html($this->template->render('Notes:tag/create', array(
            'values' => $values,
            'colors' => $this->colorModel->getList(),
            'errors' => $errors,
        )));
    }

    public function save()
    {
        $userId = $this->getUser()['id'];
        $values = $this->request->getValues();
        if ($this->noteTagModel->createTag($userId, $values['name'], $values['color_id']) > 0) {
            $this->flash->success(t('Tag created successfully.'));
        } else {
            $this->flash->failure(t('Unable to create this tag.'));
        }

        $this->response->redirect($this->helper->url->to('NoteTagController', 'show', array('plugin' => 'Notes')));
    }

    public function edit(array $values = array(), array $errors = array())
    {
        $tag_id = $this->request->getIntegerParam('tag_id');
        $tag = $this->noteTagModel->getTagById($tag_id);

        if (empty($values)) {
            $values = $tag;
        }

        $this->response->html($this->template->render('Notes:tag/edit', array(
            'tag' => $tag,
            'values' => $values,
            'colors' => $this->colorModel->getList(),
            'errors' => $errors,
        )));
    }

    public function update()
    {
        $values = $this->request->getValues();

        if ($this->noteTagModel->updateTag($values['id'], $values['name'], $values['color_id'])) {
            $this->flash->success(t('Tag updated successfully.'));
        } else {
            $this->flash->failure(t('Unable to update this tag.'));
        }

        $this->response->redirect($this->helper->url->to('NoteTagController', 'show', array('plugin' => 'Notes')));
    }

    public function confirm()
    {
        $tag_id = $this->request->getIntegerParam('tag_id');
        $tag = $this->noteTagModel->getTagById($tag_id);

        $this->response->html($this->template->render('Notes:tag/delete', array(
            'tag' => $tag,
        )));
    }

    public function remove()
    {
        $this->checkCSRFParam();
        $tag_id = $this->request->getIntegerParam('tag_id');

        if ($this->noteTagModel->removeTag($tag_id)) {
            $this->flash->success(t('Tag removed successfully.'));
        } else {
            $this->flash->failure(t('Unable to remove this tag.'));
        }

        $this->response->redirect($this->helper->url->to('NoteTagController', 'show', array('plugin' => 'Notes')));
    }
}