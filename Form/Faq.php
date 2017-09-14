<?php
/**
 * Class Faq_Form_Faq
 */
class Faq_Form_Faq extends Siberian_Form_Abstract {

    public function init() {
        parent::init();

        $this
            ->setAction(__path("/faq/application/editpost"))
            ->setAttrib("id", "form-options")
        ;

        // Bind as a onchange form!
        self::addClass('create', $this);

        $question = $this->addSimpleText('question', __('Question'));
        $question
            ->setRequired(true);

        $answer = $this->addSimpleTextarea('answer', __('Anwser'));
        $answer
            ->setNewDesignLarge()
            ->setRichtext()
            ->setRequired(true);

        $state = $this->addSimpleSelect('state', __('State'), [
            'pending' => __('Pending'),
            'published' => __('Published'),
        ]);
        $state
            ->setRequired(true);

        $value_id = $this->addSimpleHidden("value_id");
        $value_id
            ->setRequired(true)
        ;

        $this->addNav('faq-nav', __('Save'), false);
    }
}