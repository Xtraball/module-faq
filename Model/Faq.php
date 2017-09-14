<?php

/**
 * Class Faq_Model_Faq
 */
class Faq_Model_Faq extends Core_Model_Default {

    /**
     * Faq_Model_Faq constructor.
     * @param array $params
     */
    public function __construct($params = array()) {
        parent::__construct($params);
        $this->_db_table = 'Faq_Model_Db_Table_Faq';
        return $this;
    }

    /**
     * @param null $option_value
     * @return array
     */
    public function getEmbedPayload($option_value) {
        $payload = [
            'page_title' => $option_value->getTabbarName()
        ];

        if($option_value->getId()) {
            /**$mailchimp_model = new Mailchimp_Model_Mailchimp();
            $mailchimp = $mailchimp_model->find(array(
                'value_id' => $option_value->getId()
            ));

            $payload['welcome_message'] = $mailchimp->getWelcomeMessage();*/
        }

        return $payload;
    }
}