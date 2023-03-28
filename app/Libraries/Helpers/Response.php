<?php

namespace App\Libraries\Helpers;

class Response {

    public $response = [
        'success' => true,
        'data'    => [],
        'message' => '',
    ];

    public function isSuccess() {

        return $this->response['success'];
    }

    public function getData() {

        return $this->response['data'];
    }

    public function getMessage() {

        return $this->response['message'];
    }

    /**
     *set data method.
     *
     */
    public function setData($data) {

        $this->response['data'] = $data;
    }

    /**
     *set message method.
     *
     */
    public function setMessage($message) {

        $this->response['message'] = $message;
    }

    /**
     * set error.
     *
     */
    public function setError($error, $errorData = []) {

        $this->response['success'] = false;

        $this->setMessage($error);

        if(!empty($errorData)) {

            $this->setData($errorData);
        }
    }
}
