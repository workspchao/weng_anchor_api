<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of otp
 *
 * @author lichao
 */
class Otp extends Base_Controller {

    
    public function __construct() {
        parent::__construct();
        $this->load->model('otp_model');
    }
    
    

}
