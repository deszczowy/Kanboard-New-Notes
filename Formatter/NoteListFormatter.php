<?php

namespace Kanboard\Plugin\Notes\Formatter;

use Kanboard\Core\Filter\FormatterInterface;
use Kanboard\Formatter\BaseFormatter;

class NoteListFormatter extends BaseFormatter implements FormatterInterface
{
    public function format()
    {
        $notes = $this->query->findAll();
        $noteIds = array_column($notes, 'id');
        $tags = $this->noteTagModel->getTagsForNoteIds($noteIds);
        array_merge_relation($notes, $tags, 'tags', 'id');
        return $notes;
    }
}
