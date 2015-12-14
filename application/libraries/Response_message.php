<?php

class Response_message {

    private $message;
    private $lang;

    public function __construct() {
        $this->message['status_code'] = 500;
        $this->message['message'] = '';
    }
    
    public function set_lang($language){
        $this->lang = $language;
    }
    
    public function get_message() {
        return $this->message;
    }

    /**
     * Get the status code of this response
     */
    public function get_status_code() {
        return $this->message['status_code'];
    }

    public function set_message($statusCode, $message, $option = NULL) {
        //Reset previous messages
//        if($option === NULL){
        foreach ($this->message as $key => $value) {
            unset($this->message[$key]);
        }
//        }

        if (is_array($option)) {
            foreach ($option as $key => $value) {
                $this->message[$key] = $value;
            }
        }

        $this->message['status_code'] = $statusCode;
        $this->message['message'] = $message;
    }
    
    
    public function set_message_with_code($statusCode, $option = NULL) {
        //Reset previous messages
//        if($option === NULL){
        foreach ($this->message as $key => $value) {
            unset($this->message[$key]);
        }
//        }

        if (is_array($option)) {
            foreach ($option as $key => $value) {
                $this->message[$key] = $value;
            }
        }

        $message = $this->lang->line(MESSAGE_CODE_SUFFIX.$statusCode);
        if(!isset($message) || empty($message)){
            $message = 'Unknow Message';
        }
        
        $this->message['status_code'] = $statusCode;
        $this->message['message'] = $message;
    }
}