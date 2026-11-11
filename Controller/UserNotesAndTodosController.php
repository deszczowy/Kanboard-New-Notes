<?php

namespace Kanboard\Plugin\Notes\Controller;

use Kanboard\Controller\BaseController;
use Kanboard\Plugin\Notes\Pagination\UserNotesPagination;

class UserNotesAndTodosController extends BaseController
{
    public function show()
    {
        $userNotesPagination = UserNotesPagination::getInstance($this->container);
        $user = $this->getUser();
        $tags = $this->noteTagModel->getUserTags($user['id']);

        $this->response->html($this->helper->layout->dashboard('Notes:dashboard/show', array(
            'title' => t('Notes for %s', $this->helper->user->getFullname($user)),
            'user' => $user,
            'paginator' => $userNotesPagination->getUserNotesPaginator($user['id']),
            'tags' => $tags,
            'hasUntagged' => false
        )));
    }

    public function showCreateModal(array $values = array(), array $errors = array())
    {
        $this->response->html($this->template->render('Notes:note_creation/create', array(
            'values' => $values,
            'errors' => $errors,
            'title' => t('New Note'),
            'redirect' => $this->request->getStringParam('redirect'),
        )));
    }

    public function showEditModal(array $values = array(), array $errors = array())
    {
        $noteId = $this->request->getIntegerParam('noteId');
        $userId = $this->getUser()['id'];
        $editingNote = $this->notesModel->getNoteByIdForUser($noteId, $userId);
        $tagsArr = $this->noteTagModel->getTagsForNote($noteId);
        if (empty($values)) {
            $values = $editingNote;
        }
        $this->response->html($this->helper->layout->app('Notes:note_edit/edit', array(
            'values' => $values,
            'errors' => $errors,
            'editingNote' => $editingNote,
            'tags' => $tagsArr,
        )));
    }

    public function showDeleteModal(array $values = array(), array $errors = array())
    {
        $noteId = $this->request->getIntegerParam('noteId');
        $userId = $this->getUser()['id'];
        $deletingNote = $this->notesModel->getNoteByIdForUser($noteId, $userId);
        $this->response->html($this->template->render('Notes:note_delete/delete', array(
            'deletingNote' => $deletingNote,
            'redirect' => $this->request->getStringParam('redirect'),
        )));
    }

    public function create()
    {
        $values = $this->request->getValues();
        $userId = $this->getUser()['id'];
        if ($this->notesModel->createNote($values, $userId)) {
            $this->flash->success(t('Note created successfully.'));
        } else {
            $this->flash->failure(t('Unable to create a new note.'));
        }

        $redirect = $this->request->getStringParam('redirect') === '';
        $this->response->redirect($this->helper->url->to('UserNotesAndTodosController', 'show', array('plugin' => 'Notes'), $redirect));
    }

    public function save()
    {
        $values = $this->request->getValues();
        $userId = $this->getUser()['id'];
        if ($this->notesModel->saveNote($values, $userId)) {
            $this->flash->success(t('Note created successfully.'));
        } else {
            $this->flash->failure(t('Unable to create a new note.'));
        }

        $redirect = $this->request->getStringParam('redirect') === '';
        $this->response->redirect($this->helper->url->to('UserNotesAndTodosController', 'show', array('plugin' => 'Notes'), $redirect));
    }

    /**
     * Remove a note
     */
    public function delete()
    {
        $noteId = $this->request->getIntegerParam('noteId');
        $userId = $this->getUser()['id'];
        $this->checkCSRFParam();

        if ($this->notesModel->deleteNote($noteId, $userId)) {
            $this->flash->success(t('Note deleted successfully.'));
        } else {
            $this->flash->failure(t('Unable to delete this note.'));
        }

        $redirect = $this->request->getStringParam('redirect') === '';
        $this->response->redirect($this->helper->url->to('UserNotesAndTodosController', 'show', array('plugin' => 'Notes'), $redirect));
    }

    public function filterNotes()
    {
        $search = urldecode($this->request->getStringParam('search'));
        $searchTagsStr = urldecode($this->request->getStringParam('searchTags'));
        $hasUntagged = strpos($searchTagsStr, 'untagged') !== false;
        $searchTags = $this->formatSearchTagsStr($searchTagsStr);

        $user = $this->getUser();
        $paginatorInstance = UserNotesPagination::getInstance($this->container);

        $paginator = $paginatorInstance->getUserNotesPaginator($user['id'], $search, $searchTags);
        $tags = array_map(function ($tag) use ($searchTags) {
            if (in_array($tag['id'], explode(',',$searchTags))) {
                $tag['isChecked'] = true;
            }
            return $tag;
        }, $this->noteTagModel->getUserTags($user['id']));

        $this->response->html($this->helper->layout->dashboard('Notes:dashboard/show', array(
            'values' => array(
                'search' => $search,
                'searchTags' => $searchTags,
                'controller' => 'UserNotesAndTodosController',
                'action' => 'filterNotes',
                'pagination' => 'notes',
            ),
            'paginator' => $paginator,
            'user' => $user,
            'title' => t('Notes for %s', $this->helper->user->getFullname($user)),
            'tags' => $tags,
            'hasUntagged' => $hasUntagged
        )));
    }

    private function formatSearchTagsStr(string $searchTagsStr)
    {
        return implode(
            ',',
            array_unique(
                explode(',', $searchTagsStr)
            )
        );

    }
}