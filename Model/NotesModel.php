<?php

namespace Kanboard\Plugin\Notebook\Model;

use Kanboard\Core\Base;


class NotesModel extends Base
{
    const TABLE = "notes";

    public function getUserViewQuery($userId)
    {
        $driver = defined('DB_DRIVER') ? DB_DRIVER : 'sqlite';

        switch ($driver) {
            case 'mysql':
            case 'postgres':
                $lengthExpression = 'CHAR_LENGTH(note_content) AS note_len';
                break;

            case 'sqlite':
            default:
                $lengthExpression = 'LENGTH(note_content) AS note_len';
                break;
        }

        return $this->db
        ->table(self::TABLE)
        ->columns(
            'id',
            'note_owner_type',
            'note_owner_id',
            'note_title',
            $lengthExpression,
            'substr(note_content, 1, 400) AS note_content',
            'created_on',
            'created_by',
            'modified_on',
            'modified_by'
        )
        ->eq('note_owner_type', 'user')
        ->eq('note_owner_id', $userId);
    }

    public function getTagNotExistsSubQuery($userId)
    {
        return $this->getExtendedQuery()
            ->join(NoteTagModel::TABLE, 'note_id', 'id')
            ->columns('id')
            ->eq('note_owner_id', $userId)
            ->isNull('tag_id');
    }

    public function getExtendedQuery()
    {
        return $this->db
            ->table(self::TABLE)
            ->eq('note_owner_type', 'user');
    }

    public function getNoteByIdForUser($noteId, $userId)
    {
        return $this->db
            ->table(self::TABLE)
            ->eq('note_owner_type', 'user')
            ->eq('note_owner_id', $userId)
            ->eq('id', $noteId)
            ->join(NoteTagModel::TABLE, 'note_id', 'id')
            ->findOne();
    }

    public function createNote($note, $userId)
    {
        $newNoteId = $this->db
            ->table(self::TABLE)
            ->persist(
                [
                    'note_owner_id' => $userId,
                    'note_owner_type' => 'user',
                    'note_title' => $note['note_title'],
                    'note_content' => $note['note_content'],
                    'created_on' => time(),
                    'created_by' => $userId,
                    'modified_by' => $userId,
                    'modified_on' => time()
                ]
            );
        $this->noteTagModel->insertTagsForNote($newNoteId, $this->mapTagsArray($note['tags'], $userId));
        return $newNoteId;
    }

    public function saveNote($note, $userId)
    {
        $tags = $this->mapTagsArray($note['tags'], $userId);
        $noteUpdate = $this->db
            ->table(self::TABLE)
            ->eq('id', $note['noteId'])
            ->eq('note_owner_id', $userId)
            ->save(
                [
                    'note_title' => $note['note_title'],
                    'note_content' => $note['note_content'],
                    'modified_by' => $userId,
                    'modified_on' => time()
                ]
            );
        $tagsUpdate = true;
        if (count($tags) > 0) {
            $tagsUpdate = $this->noteTagModel->insertTagsForNote($note['noteId'], $tags);
        }
        return $noteUpdate && $tagsUpdate;
    }

    public function deleteNote($noteId, $userId)
    {
        return $this->db
            ->table(self::TABLE)
            ->eq('note_owner_type', 'user')
            ->eq('note_owner_id', $userId)
            ->eq('id', $noteId)
            ->remove();
    }

    protected function mapTagsArray($tags, $userId)
    {
        if (count($tags) == 0) {
            return array();
        } else {
            $filteredTags = array_filter($tags, function ($value) {
                return $value != '';
            }, ARRAY_FILTER_USE_BOTH);
            $mappedArr = array_map(function ($value) use ($userId) {
                if (is_numeric($value)) {
                    return intval($value);
                }
                return $this->noteTagModel->createTag($userId, $value, '');
            }, $filteredTags);
            return $mappedArr;
        }
    }
}
