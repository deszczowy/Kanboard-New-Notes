<?php

namespace Kanboard\Plugin\Notes\Filter;

use Kanboard\Core\Filter\FilterInterface;
use Kanboard\Core\Filter\QueryBuilder;
use Kanboard\Filter\BaseFilter;

class NotesFilter extends BaseFilter implements FilterInterface
{
    private $tagNotExistsSubquery;
    private $tagSubquery;

    public function getAttributes()
    {
        return array('content', 'tags');
    }

    public function withTagSubQuery($subquery): NotesFilter
    {
        $this->tagSubquery = $subquery;
        return $this;
    }

    public function withTagNotExistsSubQuery($subquery): NotesFilter
    {
        $this->tagNotExistsSubquery = $subquery;
        return $this;
    }

    public function apply()
    {
        // Get the final array of tags...
        $hasUntagged = false;
        if ($this->value['tags'] !== '') {
            $finalArr = array_filter(explode(',', $this->value['tags']),
                function ($el) use (&$hasUntagged) {
                    if ($el == 'untagged') {
                        $hasUntagged = true;
                        return false;
                    } else {
                        return true;
                    }
                }, ARRAY_FILTER_USE_BOTH);
        } else {
            $finalArr = array();
        }

        // Apply array of tags in subquery
        if ($hasUntagged && count($finalArr) > 0) {
            $this->query
                ->beginOr();
        }
        if (count($finalArr) > 0) {
            $this->tagSubquery
                ->in('tag_id', $finalArr);
            $this->query->inSubquery('id', $this->tagSubquery);
        }

        if ($hasUntagged) {
            $this->query->inSubquery('id', $this->tagNotExistsSubquery);
        }

        if ($hasUntagged && count($finalArr) > 0) {
            $this->query->closeOr();
        }

        if ($this->value['search'] !== '') {
            $this->query
                ->beginOr()
                ->ilike('note_content', '%' . $this->value['search'] . '%')
                ->ilike('note_title', '%' . $this->value['search'] . '%')
                ->closeOr();
        }
        return $this;
    }
}