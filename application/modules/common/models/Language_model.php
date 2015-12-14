<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Language_model
 *
 * @author lichao
 */
class Language_model extends Base_Common_Model {
    
    const CODE_LANGUAGE_LIST_SUCCEEFULLY    = 1050;
    const CODE_LANGUAGE_LIST_NOT_FOUND      = 1051;
    
    
    function __construct() {
        // Call the Model constructor
        parent::__construct();

        $this->db = $this->load->database('default', TRUE);
        
        $this->load->helper('string');
        $this->load->model('common_flag');
    }
    
    public function languageList(){
        
        $this->db->select('*');
        $this->db->from('wa.`language`');
        
        $query = $this->db->get();
        
        if ($query->num_rows() > 0)
        {
            $results = $query->result();
            $this->response_message->set_message_with_code(self::CODE_LANGUAGE_LIST_SUCCEEFULLY, array(RESULTS => $results));
            return true;
        }
        
        $this->response_message->set_message_with_code(self::CODE_LANGUAGE_LIST_NOT_FOUND);
        return false;
    }
    
}
