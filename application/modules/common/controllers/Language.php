<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Language
 *
 * @author lichao
 */
class Language extends Base_Controller {
    
    public function __construct() {
        parent::__construct();
        
        $this->load->model('language_model');
    }
    
    public function languageList(){
        if($this->language_model->languageList()){
            $this->response($this->response_message->get_message());
        }
        else
        {
            $this->response($this->response_message->get_message(),WA_HEADER_NOT_FOUND);
        }
    }
    
}
