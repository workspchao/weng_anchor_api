<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Access_token_model
 *
 * @author lichao
 */
class Access_token_model extends Base_Common_Model {
    //put your code here
    
    private $tblName = 'access_token';
    
    public function __construct() {
        parent::__construct();
        
        $this->db = $this->load->database('default', TRUE);
    }

    
    public function createToken($accountId, $accessToken)
    {
        $data = array();
        $data['account_id']   = $accountId;
        $data['access_token'] = $accessToken;
        $data['created_at']   = $this->get_now();

        $token_id = $this->common_add($this->tblName, $data);

        return $token_id;
    }
    
}
