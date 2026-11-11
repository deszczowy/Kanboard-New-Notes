<?php

namespace Kanboard\Plugin\Notes\Helper;

use Kanboard\Core\Base;

class NoteHelper extends Base
{
    public function renderTitleField(array $values, array $errors)
    {
        $html = $this->helper->form->label(t('Title'), 'title', ['class="ui-helper-hidden-accessible"']);
        $html .= $this->helper->form->text(
            'note_title',
            $values,
            $errors,
            array(
                'autofocus',
                'required',
                'tabindex="1"',
                'placeholder="' . t('Title') . '"'
            )
        );

        return $html;
    }

    public function renderDescriptionField(array $values, array $errors)
    {
        return $this->helper->form->textEditor('note_content', $values, $errors, array('tabindex' => 2, 'aria-label' => t('Description')));
    }

    public function renderHiddenIdField($hiddenId)
    {
        return '<input type="hidden" name="noteId" value="' . $hiddenId . '">';
    }

    public function renderTagField($user, array $tags = array())
    {
        $options = $this->noteTagModel->getUserTagsViewQuery($user)->findAll();
        $html = $this->helper->form->label(t('Tags'), 'tags[]');
        $html .= '<input type="hidden" name="tags[]" value="">';
        $html .= '<select name="tags[]" id="form-tags" class="tag-autocomplete" multiple tabindex="3">';

        foreach ($options as $tag) {
            $html .= sprintf(
                '<option value="%s" %s>%s</option>',
                $this->helper->text->e($tag['id']),
                in_array($tag, $tags) ? 'selected="selected"' : '',
                $this->helper->text->e($tag['name'])
            );
        }

        $html .= '</select>';

        return $html;
    }
}
