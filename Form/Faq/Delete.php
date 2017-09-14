<?php
/**
 * Class Faq_Form_Faq_Delete
 */
class Faq_Form_Faq_Delete extends Siberian_Form_Abstract {

    public function init() {
        parent::init();

        $this
            ->setAction(__path('/faq/application/deletepost'))
            ->setAttrib('id', 'form-faq-delete')
            ->setConfirmText('You are about to remove this Question ! Are you sure ?');
        ;

        // Bind as a delete form!
        self::addClass('delete', $this);

        $db = Zend_Db_Table::getDefaultAdapter();
        $select = $db->select()
            ->from('faq')
            ->where('faq.faq_id = :value')
        ;

        $faq_id = $this->addSimpleHidden('faq_id', __('FAQ'));
        $faq_id->addValidator('Db_RecordExists', true, $select);
        $faq_id->setMinimalDecorator();

        $value_id = $this->addSimpleHidden('value_id');
        $value_id
            ->setRequired(true)
        ;

        $this->addMiniSubmit();
    }
}