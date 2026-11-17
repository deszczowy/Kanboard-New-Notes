<?php

namespace Kanboard\Plugin\Notebook\Pagination;

use Kanboard\Core\Base;
use Kanboard\Core\Filter\QueryBuilder;
use Kanboard\Plugin\Notebook\Filter\NoteContentFilter;
use Kanboard\Plugin\Notebook\Filter\NotesFilter;
use Kanboard\Plugin\Notebook\Filter\NoteTagFilter;
use Kanboard\Plugin\Notebook\Model\NotesModel;

class UserNotesPagination extends Base
{
    public function getUserNotesPaginator($userId, $searchString = '', $searchTags = '')
    {
        $queryBuilder = new QueryBuilder();
        $queryBuilder->withQuery($this->notesModel->getUserViewQuery($userId));

        $paginator = $this->paginator
            ->setUrl('UserNotesAndTodosController', 'show', array(
                'pagination' => 'notes',
                'userId' => $userId,
                'plugin' => 'Notebook'
            ))
            ->setMax(50)
            ->setOrder(NotesModel::TABLE . '.modified_on')
            ->setDirection('DESC')
            ->setFormatter($this->noteListFormatter);
        if ($searchString != '' || $searchTags != '') {
            $filterValue = ['search' => $searchString, 'tags' => $searchTags];
            $queryBuilder
                ->withFilter((new NotesFilter())
                    ->withValue($filterValue)
                    ->withTagSubQuery($this->noteTagModel->getNoteTagSubQuery())
                    ->withTagNotExistsSubQuery($this->notesModel->getTagNotExistsSubQuery($userId))
                );
        }

        $paginator
            ->setQuery($queryBuilder->getQuery())
            ->calculateOnlyIf($this->request->getStringParam('pagination') === 'notes');

        return $paginator;
    }
}
