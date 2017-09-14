<?php

class Faq_ApplicationController extends Application_Controller_Default {

    /**
     * @var array
     */
    public $cache_triggers = array(
        'editpost' => array(
            'tags' => array(
                'homepage_app_#APP_ID#',
            ),
        ),
        'deletepost' => array(
            'tags' => array(
                'homepage_app_#APP_ID#',
            ),
        )
    );

    /**
     *
     */
    public function loadformAction() {
        $faq_id = $this->getRequest()->getParam('faq_id');

        $faq = new Faq_Model_Faq();
        $faq->find($faq_id);
        if($faq->getId()) {
            $form = new Faq_Form_Faq();

            $formData = $faq->getData();

            $form->populate($formData);
            $form->setValueId($this->getCurrentOptionValue()->getId());
            $form->removeNav('faq-nav');
            $form->addNav('faq-edit-nav', 'Save', false);
            $form->setFaqId($faq->getId());

            $payload = [
                'success' => true,
                'form' => $form->render(),
                'message' => __('Success.')
            ];
        } else {
            $payload = [
                'error' => true,
                'message' => __('The question you are trying to edit doesn\'t exists.'),
            ];
        }

        $this->_sendJson($payload);
    }

    /**
     * Save options
     */
    public function editpostAction() {
        $values = $this->getRequest()->getPost();

        $form = new Faq_Form_Faq();
        if($form->isValid($values)) {

            $this->getCurrentOptionValue();

            $faq = new Faq_Model_Faq();
            $faq->find($form->getValue('faq_id'));
            $faq
                ->setData($form->getValues())
                ->save();

            // Update touch date, then never expires (until next touch)!
            $this->getCurrentOptionValue()
                ->touch()
                ->expires(-1);

            $payload = [
                'success' => true,
                'message' => __('Success.'),
            ];
        } else {
            // Do whatever you need when form is not valid!
            $payload = [
                'error' => true,
                'message' => $form->getTextErrors(),
                'errors' => $form->getTextErrors(true)
            ];
        }

        $this->_sendJson($payload);
    }

    /**
     * Delete place
     */
    public function deletepostAction() {
        $values = $this->getRequest()->getPost();

        $form = new Faq_Form_Faq_Delete();
        if ($form->isValid($values)) {

            $faq = new Faq_Model_Faq();
            $faq->find($form->getValue('faq_id'));
            $faq->delete();

            // Update touch date, then never expires (until next touch)!
            $this->getCurrentOptionValue()
                ->touch()
                ->expires(-1);

            $payload = [
                'success' => true,
                'success_message' => __('Question successfully deleted.'),
                'message_loader' => 0,
                'message_button' => 0,
                'message_timeout' => 2
            ];
        } else {
            $payload = [
                'error' => true,
                'message' => $form->getTextErrors(),
                'errors' => $form->getTextErrors(true),
            ];
        }

        $this->_sendJson($payload);
    }
}
