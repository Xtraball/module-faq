<?php

class Mailchimp_Mobile_ViewController extends Application_Controller_Mobile_Default {

    /**
     * Only here as a fallback if the embed_payload is not available
     */
    public function findAction() {
        try {
            if($value_id = $this->getRequest()->getParam('value_id')) {
                $option_value = $this->getCurrentOptionValue();
                $mailchimp_model = new Mailchimp_Model_Mailchimp();
                $payload = $mailchimp_model->getEmbedPayload($option_value);
            } else {
                throw new Siberian_Exception('The value_id is required.');
            }
        } catch(Exception $e) {
            $payload = [
                'error' => true,
                'message' => __('Mailchimp::findAction An unknown error occurred, please try again later.'),
                'exceptionMessage' => $e->getMessage()
            ];
        }

        $this->_sendJson($payload);
    }

    /**
     * Subscribe controller
     */
    public function subscribeAction() {
        try {
            $request = $this->getRequest();
            if($value_id = $request->getParam('value_id')) {
                $params = Siberian_Json::decode($this->getRequest()->getRawBody());

                $option_value = $this->getCurrentOptionValue();
                $mailchimp_model = new Mailchimp_Model_Mailchimp();
                $mailchimp = $mailchimp_model->find(
                    $option_value->getId(),
                    'value_id'
                );

                // Check for any existing subscription!
                $mailchimp_subscription_model = new Mailchimp_Model_MailchimpSubscription();
                $existing_subscription = $mailchimp_subscription_model->find([
                    'list_id' => $mailchimp->getListId(),
                    'email' => $params['email']
                ]);

                // Stop now and send error code
                if($existing_subscription->getId()) {
                    $this->_sendJson([
                        'success' => true,
                        'status' => 2
                    ], true);
                }

                $mailchimp_api = new Mailchimp_Model_Api_Mailchimp($mailchimp->getApiKey());

                $updateData = [
                    'email_address' => $params['email'],
                    'status'        => 'pending',
                    'merge_fields'  => [
                        'FNAME'     => $params['firstname'],
                        'LNAME'     => $params['lastname']
                    ]
                ];

                $endpoint = 'lists/' . $mailchimp->getListId() . '/members/' . md5(strtolower($params['email']));
                $response = $mailchimp_api->put($endpoint, $updateData);

                if(isset($response['id']) && !empty($response['id'])) {
                    // Save in DB.
                    $mailchimp_subscription = new Mailchimp_Model_MailchimpSubscription();
                    $mailchimp_subscription
                        ->setListId($mailchimp->getListId())
                        ->setEmail($params['email'])
                        ->setFirstname($params['firstname'])
                        ->setLastname($params['lastname'])
                        ->save();

                    $this->_sendJson([
                        'success' => true,
                        'status' => 1
                    ], true);
                } else {
                    $this->_sendJson([
                        'success' => true,
                        'status' => 0
                    ], true);
                }

            } else {
                throw new Siberian_Exception('The value_id is required.');
            }
        } catch(Exception $e) {
            $payload = [
                'error' => true,
                'message' => __('Mailchimp::subscribeAction An unknown error occurred, please try again later.'),
                'exceptionMessage' => $e->getMessage()
            ];
        }

        $this->_sendJson($payload);
    }
}
