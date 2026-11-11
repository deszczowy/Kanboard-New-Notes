<?php

namespace Kanboard\Plugin\Notes\Model;

use Kanboard\Core\Base;

class NoteTagModel extends Base
{
    const TABLE = "note_has_user_tags";
    const TAG_TABLE = "notes_user_tags";

    public function getTagsForNote($noteId)
    {
        return $this->db
            ->table(self::TABLE)
            ->join(self::TAG_TABLE, 'id', 'tag_id')
            ->columns(self::TAG_TABLE . '.name', self::TAG_TABLE . '.id')
            ->eq('note_id', $noteId)
            ->findAll();
    }

    public function getTagsForNoteIds($noteIds)
    {
        if (empty($noteIds)) {
            return array();
        }

        $tags = $this->db->table(self::TAG_TABLE)
            ->columns(self::TAG_TABLE . '.id', self::TAG_TABLE . '.name', self::TAG_TABLE . '.color_id', self::TABLE . '.note_id')
            ->in(self::TABLE . '.note_id', $noteIds)
            ->join(self::TABLE, 'tag_id', 'id')
            ->asc(self::TAG_TABLE . '.name')
            ->findAll();

        return array_column_index($tags, 'note_id');
    }

    public function insertTagsForNote($noteId, $tags)
    {
        $this->clearTagsForNote($noteId);
        return $this->addTagsToNote($noteId, $tags);
    }

    protected function clearTagsForNote($noteId)
    {
        $this->db
            ->table(self::TABLE)
            ->eq('note_id', $noteId)
            ->remove();
    }

    protected function addTagsToNote($noteId, $tags)
    {
        foreach ($tags as $tag) {
            $this->db
                ->table(self::TABLE)
                ->persist([
                    'note_id' => $noteId,
                    'tag_id' => $tag
                ]);
        }
        return true;
    }

    public function getUserTagsViewQuery($userId)
    {
        return $this->db
            ->table(self::TAG_TABLE)
            ->eq('user_id', $userId)
            ->desc('name')
            ->columns('id', 'name');
    }

    public function getUserTags($userId)
    {
        return $this->getUserTagsViewQuery($userId)
            ->columns('id', 'name', 'color_id')
            ->findAll();
    }

    public function getTagById($tagId)
    {
        return $this->db
            ->table(self::TAG_TABLE)
            ->eq('id', $tagId)
            ->findOne();
    }

    public function createTag($userId, $tagName, $colorId)
    {
        return $this->db->table(self::TAG_TABLE)->persist(array(
            'user_id' => $userId,
            'name' => $tagName,
            'color_id' => $colorId,
        ));
    }

    public function updateTag($tagId, $tagName, $colorId)
    {
        return $this->db
            ->table(self::TAG_TABLE)
            ->eq('id', $tagId)
            ->save(
                [
                    'name' => $tagName,
                    'color_id' => $colorId
                ]
            );
    }

    public function removeTag($tagId)
    {
        return $this->db
            ->table(self::TAG_TABLE)
            ->eq('id', $tagId)
            ->remove();
    }

    public function getNoteTagSubQuery()
    {
        return $this->db
            ->table(NoteTagModel::TABLE)
            ->columns('note_id');
    }

}