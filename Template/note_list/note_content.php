<div class="accordion-content">
    <article class="markdown">
        <?php
        $content = $note['note_content'] ?? '';
        $noteLen = (int) ($note['note_len'] ?? 0);
        $contentLen = function_exists('mb_strlen')
            ? mb_strlen($content, 'UTF-8')
            : strlen($content);
        if ($contentLen < $noteLen){
            $content = $content . "...";
        }
        ?>
        <?= $this->text->markdown($content) ?>
    </article>
    <?php foreach ($note['tags'] as $tag): ?>
        <span class="table-list-category task-list-tag <?= $tag['color_id'] ? "color-{$tag['color_id']}" : '' ?>">
            <?= $this->text->e($tag['name']) ?>
        </span>
    <?php endforeach ?>
</div>
