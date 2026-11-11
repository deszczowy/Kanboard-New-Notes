<div class="accordion-content">
    <article class="markdown">
        <?= $this->text->markdown($note['note_content']); ?>
    </article>
    <?php foreach ($note['tags'] as $tag): ?>
        <span class="table-list-category task-list-tag <?= $tag['color_id'] ? "color-{$tag['color_id']}" : '' ?>">
            <?= $this->text->e($tag['name']) ?>
        </span>
    <?php endforeach ?>
</div>